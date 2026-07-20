<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'libraries/Api_Controller.php';

class Api_Checkout extends Api_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('Transaction_model');
        $this->load->model('Course_model');
        $this->load->model('Coupon_model');
        $this->load->model('Package_model');
        $this->load->model('Course_enrollment_model');
        $this->load->model('User_subscription_model');
        $this->load->model('Mentoring_package_model');
        $this->load->model('Setting_model');
        $this->load->helper('uuid');
    }
    
    /**
     * POST /api/checkout
     * Create checkout / transaction
     */
    public function create() {
        $this->require_auth();
        
        $input = $this->get_json_input();
        
        $item_type = $input['item_type'] ?? '';
        $item_id = $input['item_id'] ?? 0;
        
        if (empty($item_type) || empty($item_id)) {
            $this->response_error('item_type and item_id are required');
        }
        
        $valid_types = ['course', 'workshop', 'bootcamp', 'ebook', 'project', 'package', 'package_6mo', 'mentoring_package', 'seminar'];
        if (!in_array($item_type, $valid_types)) {
            $this->response_error('Invalid item type');
        }
        
        $amount = 0;
        $item_name = '';
        $duration_days = 0;
        $real_item_type = $item_type;
        
        if (in_array($item_type, ['course', 'workshop', 'bootcamp', 'ebook', 'project'])) {
            $item = $this->Course_model->get_course_by_id($item_id);
            if (!$item) $this->response_error('Course not found', 404);
            $amount = $item->price;
            $item_name = $item->title;
            
            $enrolled = $this->Course_enrollment_model->get_enrollment($this->user_id, $item_id);
            if ($enrolled) $this->response_error('Already enrolled', 400);
        } elseif (in_array($item_type, ['package', 'package_6mo'])) {
            $package = $this->Package_model->get_package_by_id($item_id);
            if (!$package || !$package->is_active) $this->response_error('Package not found', 404);
            
            if ($item_type === 'package_6mo') {
                $six = $this->Package_model->calculate_6mo_price($package->id);
                $amount = $six ? $six['discounted'] : $package->price * 6;
                $duration_days = $package->duration_days * 6;
            } else {
                $amount = $package->price;
                $duration_days = $package->duration_days;
            }
            $item_name = $package->name;
        } elseif ($item_type === 'mentoring_package') {
            $pkg = $this->Mentoring_package_model->get_by_id($item_id);
            if (!$pkg || !$pkg->is_active) $this->response_error('Mentoring package not found', 404);
            $amount = $pkg->price;
            $item_name = $pkg->name;
        } elseif ($item_type === 'seminar') {
            $this->load->model('Seminar_model');
            $seminar = $this->Seminar_model->get_seminar_by_id($item_id);
            if (!$seminar) $this->response_error('Seminar not found', 404);
            $amount = $seminar->price;
            $item_name = $seminar->title;
        }
        
        if ($amount <= 0) {
            $this->response_error('Item is free. Use direct enroll/register endpoint instead', 400);
        }
        
        // Apply coupon
        $coupon_code = $input['coupon_code'] ?? '';
        $discount = 0;
        $coupon_id = null;
        
        if (!empty($coupon_code)) {
            $coupon = $this->Coupon_model->get_coupon_by_code($coupon_code);
            if ($coupon) {
                $validation = $this->Coupon_model->validate_coupon($coupon_code, $amount);
                if ($validation['valid']) {
                    $calc = $this->Coupon_model->calculate_discount($validation['coupon'], $amount);
                    $discount = $calc['discount'];
                    $coupon_id = $coupon->id;
                }
            }
        }
        
        $final_amount = max(0, $amount - $discount);
        
        $tx_data = [
            'uuid' => generate_uuid(),
            'user_id' => $this->user_id,
            'item_type' => $real_item_type,
            'item_id' => $item_id,
            'item_name' => $item_name,
            'original_amount' => $amount,
            'discount_amount' => $discount,
            'amount' => $final_amount,
            'coupon_id' => $coupon_id,
            'coupon_code' => $coupon_code ?: null,
            'status' => 'pending',
            'payment_method' => 'manual',
            'notes' => $duration_days > 0 ? json_encode(['duration_days' => $duration_days]) : null,
            'created_at' => date('Y-m-d H:i:s')
        ];
        
        $tx_id = $this->Transaction_model->create_transaction($tx_data);
        
        if ($tx_id) {
            $this->response([
                'transaction' => [
                    'id' => $tx_id,
                    'uuid' => $tx_data['uuid'],
                    'item_type' => $real_item_type,
                    'item_name' => $item_name,
                    'original_amount' => $amount,
                    'discount_amount' => $discount,
                    'final_amount' => $final_amount,
                    'status' => 'pending'
                ]
            ], 201, 'Checkout created');
        }
        
        $this->response_error('Checkout failed', 500);
    }
    
    /**
     * GET /api/checkout/:uuid
     * Get checkout detail
     */
    public function show($uuid) {
        $this->require_auth();
        
        $tx = $this->Transaction_model->get_by_uuid($uuid);
        
        if (!$tx || $tx->user_id != $this->user_id) {
            $this->response_error('Transaction not found', 404);
        }
        
        $this->response(format_transaction_for_api($tx));
    }
    
    /**
     * POST /api/checkout/:uuid/midtrans
     * Get Midtrans payment token
     */
    public function midtrans($uuid) {
        $this->require_auth();
        
        $tx = $this->Transaction_model->get_by_uuid($uuid);
        
        if (!$tx || $tx->user_id != $this->user_id) {
            $this->response_error('Transaction not found', 404);
        }
        
        if ($tx->status !== 'pending') {
            $this->response_error('Transaction already processed', 400);
        }
        
        $server_key = setting('midtrans_server_key', '');
        $is_production = setting('midtrans_is_production', '0') === '1';
        
        if (!$server_key) {
            $this->response_error('Online payment not configured', 500);
        }
        
        $this->load->helper('midtrans');
        
        $customer = [
            'first_name' => $this->current_user->name,
            'email' => $this->current_user->email
        ];
        
        $token = get_midtrans_token($tx->id, $tx->amount, $tx->item_name, $customer, $server_key, $is_production);
        
        if (!$token) {
            $this->response_error('Failed to generate payment token', 500);
        }
        
        // Update payment method
        $this->Transaction_model->update_transaction($tx->id, [
            'payment_method' => 'midtrans'
        ]);
        
        $this->response(['payment_token' => $token]);
    }
    
    /**
     * POST /api/checkout/:uuid/pay
     * Upload manual payment proof
     */
    public function pay($uuid) {
        $this->require_auth();
        
        $tx = $this->Transaction_model->get_by_uuid($uuid);
        
        if (!$tx || $tx->user_id != $this->user_id) {
            $this->response_error('Transaction not found', 404);
        }
        
        if ($tx->status !== 'pending') {
            $this->response_error('Transaction already processed', 400);
        }
        
        if (empty($_FILES['payment_proof'])) {
            $this->response_error('Payment proof file is required');
        }
        
        $this->load->helper('upload');
        $upload_result = upload_file('payment_proof', 'payments');
        
        if (!$upload_result['success']) {
            $this->response_error('Upload failed: ' . $upload_result['error']);
        }
        
        $this->Transaction_model->update_transaction($tx->id, [
            'payment_proof' => $upload_result['path'],
            'payment_method' => 'manual'
        ]);
        
        $this->response(null, 200, 'Payment proof uploaded. Waiting for admin approval.');
    }
    
    /**
     * POST /api/checkout/apply-coupon
     * Validate coupon for checkout
     */
    public function apply_coupon() {
        $input = $this->get_json_input();
        
        $code = $input['code'] ?? '';
        $item_type = $input['item_type'] ?? '';
        $item_id = $input['item_id'] ?? 0;
        
        if (empty($code)) {
            $this->response_error('Coupon code is required');
        }
        
        // Get item price
        $price = 0;
        if (in_array($item_type, ['course', 'workshop', 'bootcamp', 'ebook', 'project'])) {
            $item = $this->Course_model->get_course_by_id($item_id);
            $price = $item ? $item->price : 0;
        } elseif (in_array($item_type, ['package', 'package_6mo'])) {
            $package = $this->Package_model->get_package_by_id($item_id);
            $price = $package ? $package->price : 0;
            if ($item_type === 'package_6mo') {
                $six = $this->Package_model->calculate_6mo_price($package->id);
                $price = $six ? $six['discounted'] : $price * 6;
            }
        } elseif ($item_type === 'mentoring_package') {
            $pkg = $this->Mentoring_package_model->get_by_id($item_id);
            $price = $pkg ? $pkg->price : 0;
        }
        
        $validation = $this->Coupon_model->validate_coupon($code, $price);
        
        if (!$validation['valid']) {
            $this->response_error($validation['message'], 400);
        }
        
        $calc = $this->Coupon_model->calculate_discount($validation['coupon'], $price);
        
        $this->response([
            'code' => $validation['coupon']->code,
            'discount' => $calc['discount'],
            'total' => $calc['total'],
            'label' => $calc['label']
        ]);
    }
    
    /**
     * POST /api/checkout/midtrans/notification
     * Midtrans webhook (no auth required)
     */
    public function midtrans_notification() {
        $payload = $this->get_json_input();
        
        if (empty($payload)) {
            $this->response_error('Invalid payload', 400);
        }
        
        $server_key = setting('midtrans_server_key', '');
        
        // Verify signature
        $signature_key = $payload['signature_key'] ?? '';
        $order_id = $payload['order_id'] ?? '';
        $status_code = $payload['status_code'] ?? '';
        
        $expected = hash('sha512', $order_id . $status_code . $payload['gross_amount'] . $server_key, true);
        
        // Extract transaction ID from order_id (CRS-{id}-{timestamp})
        $parts = explode('-', $order_id);
        if (count($parts) < 2) {
            $this->response_error('Invalid order ID', 400);
        }
        $tx_id = (int)$parts[1];
        
        $tx = $this->Transaction_model->get_by_id($tx_id);
        if (!$tx) {
            $this->response_error('Transaction not found', 404);
        }
        
        $transaction_status = $payload['transaction_status'] ?? '';
        $fraud_status = $payload['fraud_status'] ?? '';
        
        // Determine final status
        $is_success = false;
        if ($transaction_status === 'capture') {
            $is_success = ($fraud_status === 'accept');
        } elseif ($transaction_status === 'settlement') {
            $is_success = true;
        }
        
        if ($is_success) {
            $this->Transaction_model->update_transaction($tx->id, [
                'status' => 'completed',
                'payment_method' => 'midtrans',
                'updated_at' => date('Y-m-d H:i:s')
            ]);
            
            // Fulfill order
            $this->_fulfill_order($tx);
        } elseif ($transaction_status === 'deny' || $transaction_status === 'expire' || $transaction_status === 'cancel') {
            $this->Transaction_model->update_transaction($tx->id, [
                'status' => 'failed',
                'updated_at' => date('Y-m-d H:i:s')
            ]);
        }
        
        $this->response(null, 200, 'Notification processed');
    }
    
    /**
     * POST /api/checkout/pakasir/webhook
     * Pakasir payment webhook (no auth required)
     */
    public function pakasir_webhook() {
        $payload = $this->get_json_input();
        
        if (empty($payload)) {
            $this->response_error('Invalid payload', 400);
        }
        
        $order_id = $payload['order_id'] ?? '';
        $status = $payload['status'] ?? '';
        
        // Find transaction
        $tx = $this->Transaction_model->get_by_uuid($order_id);
        if (!$tx) {
            $this->response_error('Transaction not found', 404);
        }
        
        if ($status === 'paid' || $status === 'success') {
            $this->Transaction_model->update_transaction($tx->id, [
                'status' => 'completed',
                'payment_method' => 'pakasir',
                'updated_at' => date('Y-m-d H:i:s')
            ]);
            
            $this->_fulfill_order($tx);
        } elseif ($status === 'failed' || $status === 'expired') {
            $this->Transaction_model->update_transaction($tx->id, [
                'status' => 'failed',
                'updated_at' => date('Y-m-d H:i:s')
            ]);
        }
        
        $this->response(null, 200, 'Webhook processed');
    }
    
    /**
     * Fulfill order after successful payment
     */
    private function _fulfill_order($tx) {
        if (in_array($tx->item_type, ['course', 'workshop', 'bootcamp', 'ebook', 'project'])) {
            $existing = $this->Course_enrollment_model->get_enrollment($tx->user_id, $tx->item_id);
            if (!$existing) {
                $this->Course_enrollment_model->create_enrollment([
                    'user_id' => $tx->user_id,
                    'course_id' => $tx->item_id,
                    'enrolled_at' => date('Y-m-d H:i:s')
                ]);
            }
        } elseif (in_array($tx->item_type, ['package', 'package_6mo'])) {
            $notes = json_decode($tx->notes, true);
            $duration_days = $notes['duration_days'] ?? 30;
            
            $this->User_subscription_model->create_subscription([
                'user_id' => $tx->user_id,
                'package_id' => $tx->item_id,
                'status' => 'active',
                'started_at' => date('Y-m-d H:i:s'),
                'expires_at' => date('Y-m-d H:i:s', strtotime('+' . $duration_days . ' days')),
                'created_at' => date('Y-m-d H:i:s')
            ]);
        } elseif ($tx->item_type === 'mentoring_package') {
            $this->load->model('User_mentoring_balance_model');
            $pkg = $this->Mentoring_package_model->get_by_id($tx->item_id);
            if ($pkg) {
                $this->User_mentoring_balance_model->add_balance($this->user_id, $tx->item_id, $pkg->total_sessions);
            }
        } elseif ($tx->item_type === 'seminar') {
            $this->load->model('Seminar_model');
            $registered = $this->Seminar_model->check_registration($tx->user_id, $tx->item_id);
            if (!$registered) {
                $this->Seminar_model->register_user($tx->user_id, $tx->item_id);
            }
        }
    }
}
