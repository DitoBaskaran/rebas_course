<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'libraries/Api_Controller.php';

class Api_Transactions extends Api_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('Transaction_model');
        $this->load->model('Course_model');
        $this->load->model('Coupon_model');
        $this->load->model('Course_enrollment_model');
    }
    
    /**
     * POST /api/transactions
     * Create new transaction
     */
    public function create() {
        $this->require_auth();
        
        $input = $this->get_json_input();
        
        $item_type = $input['item_type'] ?? '';
        $item_id = $input['item_id'] ?? 0;
        
        if (empty($item_type) || empty($item_id)) {
            $this->response_error('item_type and item_id are required');
        }
        
        $valid_types = ['course', 'seminar', 'workshop', 'bootcamp', 'ebook', 'project', 'mentoring_package'];
        if (!in_array($item_type, $valid_types)) {
            $this->response_error('Invalid item type');
        }
        
        // Get item price
        $price = 0;
        $title = '';
        
        if (in_array($item_type, ['course', 'workshop', 'bootcamp', 'ebook', 'project'])) {
            $item = $this->Course_model->get_course_by_id($item_id);
            if (!$item) {
                $this->response_error('Course not found', 404);
            }
            $price = $item->price;
            $title = $item->title;
            
            // Check if already enrolled
            $enrolled = $this->Course_enrollment_model->get_enrollment($this->user_id, $item_id);
            if ($enrolled) {
                $this->response_error('Already enrolled in this course', 400);
            }
        }
        
        if ($price <= 0) {
            $this->response_error('Item is free. Use enroll endpoint instead', 400);
        }
        
        // Apply coupon if provided
        $coupon_code = $input['coupon_code'] ?? '';
        $discount = 0;
        $coupon_id = null;
        
        if (!empty($coupon_code)) {
            $coupon = $this->Coupon_model->get_coupon_by_code($coupon_code);
            if ($coupon && $this->Coupon_model->validate_coupon($coupon, $price)) {
                if ($coupon->type === 'percentage') {
                    $discount = $price * ($coupon->value / 100);
                } else {
                    $discount = min($coupon->value, $price);
                }
                $coupon_id = $coupon->id;
                
                // Increment usage
                $this->Coupon_model->increment_usage($coupon->id);
            }
        }
        
        $final_amount = max(0, $price - $discount);
        
        $this->load->helper('uuid');
        
        // Create transaction
        $tx_data = [
            'uuid' => generate_uuid(),
            'user_id' => $this->user_id,
            'item_type' => $item_type,
            'item_id' => $item_id,
            'item_title' => $title,
            'original_amount' => $price,
            'discount_amount' => $discount,
            'amount' => $final_amount,
            'coupon_id' => $coupon_id,
            'coupon_code' => $coupon_code ?: null,
            'status' => 'pending',
            'payment_method' => 'manual',
            'created_at' => date('Y-m-d H:i:s')
        ];
        
        $tx_id = $this->Transaction_model->create_transaction($tx_data);
        
        if ($tx_id) {
            $this->response([
                'transaction' => [
                    'id' => $tx_id,
                    'uuid' => $tx_data['uuid'],
                    'item_type' => $item_type,
                    'item_title' => $title,
                    'original_amount' => $price,
                    'discount_amount' => $discount,
                    'final_amount' => $final_amount,
                    'status' => 'pending'
                ]
            ], 201, 'Transaction created');
        }
        
        $this->response_error('Failed to create transaction', 500);
    }
    
    /**
     * GET /api/transactions
     */
    public function index() {
        $this->require_auth();
        
        $transactions = $this->Transaction_model->get_user_transactions($this->user_id);
        
        $formatted = array_map(function($tx) {
            return format_transaction_for_api($tx);
        }, $transactions);
        
        $this->response($formatted);
    }
    
    /**
     * GET /api/transactions/:uuid
     */
    public function show($uuid) {
        $this->require_auth();
        
        $tx = $this->Transaction_model->get_by_uuid($uuid);
        
        if (!$tx || $tx->user_id != $this->user_id) {
            $this->request->response_error('Transaction not found', 404);
        }
        
        $this->response(format_transaction_for_api($tx));
    }
    
    /**
     * POST /api/transactions/:uuid/pay
     * Upload payment proof
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
        
        // Handle file upload
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
            'status' => 'pending',
            'payment_method' => 'manual'
        ]);
        
        $this->response(null, 200, 'Payment proof uploaded. Waiting for approval.');
    }
    
    /**
     * POST /api/transactions/validate-coupon
     */
    public function validate_coupon() {
        $input = $this->get_json_input();
        
        $code = $input['code'] ?? '';
        $item_type = $input['item_type'] ?? '';
        $item_id = $input['item_id'] ?? 0;
        
        if (empty($code)) {
            $this->response_error('Coupon code is required');
        }
        
        $coupon = $this->Coupon_model->get_coupon_by_code($code);
        
        if (!$coupon) {
            $this->response_error('Invalid coupon code', 404);
        }
        
        // Get item price for validation
        $price = 0;
        if (in_array($item_type, ['course', 'workshop', 'bootcamp', 'ebook', 'project'])) {
            $item = $this->Course_model->get_course_by_id($item_id);
            $price = $item ? $item->price : 0;
        }
        
        if (!$this->Coupon_model->validate_coupon($coupon, $price)) {
            $this->response_error('Coupon is expired or invalid');
        }
        
        $discount = 0;
        if ($coupon->type === 'percentage') {
            $discount = $price * ($coupon->value / 100);
        } else {
            $discount = min($coupon->value, $price);
        }
        
        $this->response([
            'code' => $coupon->code,
            'type' => $coupon->type,
            'value' => (int)$coupon->value,
            'discount' => round($discount, 2),
            'final_amount' => round(max(0, $price - $discount), 2)
        ]);
    }
}
