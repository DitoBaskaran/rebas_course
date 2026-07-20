<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Checkout extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata('logged_in')) {
            $this->session->set_flashdata('error', t('Silakan login terlebih dahulu.', 'Please login first.'));
            redirect('auth/login');
        }
        $this->load->model('Transaction_model');
        $this->load->model('Course_model');
        $this->load->model('Seminar_model');
        $this->load->model('Coupon_model');
        $this->load->model('Package_model');
        $this->load->model('Mentoring_package_model');
        $this->load->library('pakasir');
    }

    public function confirm($uuid) {
        // Cart-based flow (no transaction in DB yet)
        if (strpos($uuid, 'cart_') === 0) {
            $this->_confirm_cart($uuid);
            return;
        }

        // UUID-based flow (old — transaction already in DB)
        $tx = $this->Transaction_model->get_by_uuid($uuid);
        if (!$tx || $tx->user_id != $this->session->userdata('user_id')) show_404();

        if ($tx->status === 'approved') {
            $this->session->set_flashdata('success', t('Transaksi ini sudah disetujui.', 'Transaction already approved.'));
            redirect('dashboard');
        }

        $item = NULL;
        $item_name = '';
        if (in_array($tx->item_type, ['course', 'workshop', 'bootcamp', 'ebook', 'project', 'video', 'podcast', 'template'])) {
            $item = $this->Course_model->get_course_by_id($tx->item_id);
            $item_name = $item ? $item->title : ucfirst($tx->item_type);
        } else if ($tx->item_type === 'seminar') {
            $item = $this->Seminar_model->get_seminar_by_id($tx->item_id);
            $item_name = $item ? $item->title : 'Seminar';
        } else if ($tx->item_type === 'package' || $tx->item_type === 'package_6mo') {
            $item = $this->Package_model->get_package_by_id($tx->item_id);
            $item_name = $item ? $item->name : 'Package';
        } else if ($tx->item_type === 'mentoring_package') {
            $item = $this->Mentoring_package_model->get_by_id($tx->item_id);
            $item_name = $item ? t($item->name, $item->name_en) : 'Mentoring Package';
        }

        $data['title'] = t('Konfirmasi Pembayaran', 'Payment Confirmation');
        $data['transaction'] = $tx;
        $data['item'] = $item;
        $data['item_name'] = $item_name;
        $data['applied_coupon'] = null;
        $data['tx_ref'] = $tx->uuid;
        $data['pay_method'] = 'pay';
        $data['coupon_method'] = 'coupon';

        if ($tx->coupon_id) {
            $data['applied_coupon'] = $this->Coupon_model->get_coupon_by_id($tx->coupon_id);
        }

        $this->load->view('templates/header', $data);
        $this->load->view('checkout/confirm', $data);
        $this->load->view('templates/footer');
    }

    public function initiate($item_type, $item_id, $extra = null) {
        $user_id = $this->session->userdata('user_id');
        $item = null;
        $amount = 0;
        $item_name = '';
        $notes = null;
        $real_item_type = $item_type;

        if ($item_type === 'package') {
            $package = is_numeric($item_id)
                ? $this->Package_model->get_package_by_id($item_id)
                : $this->Package_model->get_package_by_slug($item_id);
            if (!$package || !$package->is_active) show_404();

            $months = (int)$extra ?: 1;
            if (!in_array($months, [1, 6])) $months = 1;

            $this->load->model('User_subscription_model');
            $active = $this->User_subscription_model->get_active_subscriptions($user_id);
            foreach ($active as $sub) {
                if ($sub->package_id == $package->id) {
                    $this->session->set_flashdata('info', t('Anda sudah berlangganan paket ini.', 'You already subscribed to this package.'));
                    redirect('subscription/my');
                }
            }

            if ($months === 6) {
                $six = $this->Package_model->calculate_6mo_price($package->id);
                $amount = $six ? $six['discounted'] : $package->price * 6;
                $real_item_type = 'package_6mo';
                $duration_days = $package->duration_days * 6;
            } else {
                $amount = $package->price;
                $real_item_type = 'package';
                $duration_days = $package->duration_days;
            }
            $item_name = $package->name;
            $notes = json_encode(array('duration_days' => $duration_days));
        } elseif ($item_type === 'mentoring_package') {
            $this->load->model('Mentoring_package_model');
            $item = $this->Mentoring_package_model->get_by_id($item_id);
            if (!$item || !$item->is_active) show_404();
            $amount = $item->price;
            $item_name = t($item->name, $item->name_en);
        } elseif ($item_type === 'seminar') {
            $item = $this->Seminar_model->get_seminar_by_id($item_id);
            if (!$item) show_404();
            $amount = $item->price;
            $item_name = $item->title;
        } elseif (in_array($item_type, ['course', 'workshop', 'bootcamp', 'ebook', 'project', 'video', 'podcast', 'template'])) {
            $item = $this->Course_model->get_course_by_id($item_id);
            if (!$item) show_404();
            $amount = $item->price;
            $item_name = $item->title;
        } else {
            show_404();
        }

        // Store pending purchase in session (no DB transaction yet)
        $token = 'cart_' . substr(md5(uniqid(mt_rand(), true)), 0, 8);
        $this->session->set_userdata('pending_cart_' . $token, array(
            'item_type' => $real_item_type,
            'item_id' => (int)$item_id,
            'amount' => (float)$amount,
            'original_amount' => (float)$amount,
            'discount_amount' => 0,
            'coupon_id' => null,
            'item_name' => $item_name,
            'notes' => $notes,
            'created_at' => time(),
        ));
        $this->session->set_userdata('pending_cart_tokens', array_merge(
            (array)$this->session->userdata('pending_cart_tokens'),
            array($token)
        ));

        redirect('checkout/confirm/' . $token);
    }

    private function _confirm_cart($token) {
        $cart = $this->_get_cart($token);
        if (!$cart) show_404();

        $data['title'] = t('Konfirmasi Pembayaran', 'Payment Confirmation');
        $data['tx_ref'] = $token;
        $data['pay_method'] = 'pay_cart';
        $data['coupon_method'] = 'coupon_cart';
        $data['transaction'] = (object)array(
            'uuid' => $token,
            'amount' => $cart['amount'],
            'discount_amount' => $cart['discount_amount'],
            'original_amount' => $cart['original_amount'],
            'coupon_id' => $cart['coupon_id'],
        );
        $data['item_name'] = $cart['item_name'];
        $data['item'] = null;
        $data['applied_coupon'] = $cart['coupon_id']
            ? $this->Coupon_model->get_coupon_by_id($cart['coupon_id'])
            : null;

        $this->load->view('templates/header', $data);
        $this->load->view('checkout/confirm', $data);
        $this->load->view('templates/footer');
    }

    private function _get_cart($token) {
        if (strpos($token, 'cart_') !== 0) return null;
        $cart = $this->session->userdata('pending_cart_' . $token);
        if (!$cart) return null;
        // Auto-expire carts older than 2 hours
        if (isset($cart['created_at']) && (time() - $cart['created_at']) > 7200) {
            $this->session->unset_userdata('pending_cart_' . $token);
            return null;
        }
        return $cart;
    }

    private function _clear_cart($token) {
        $this->session->unset_userdata('pending_cart_' . $token);
        $tokens = (array)$this->session->userdata('pending_cart_tokens');
        $tokens = array_diff($tokens, array($token));
        $this->session->set_userdata('pending_cart_tokens', $tokens);
    }

    public function apply_coupon_cart($token) {
        $cart = $this->_get_cart($token);
        if (!$cart) {
            echo json_encode(array('status' => 'error', 'message' => t('Sesi habis.', 'Session expired.')));
            return;
        }

        $code = $this->input->post('code');
        if (!$code) {
            echo json_encode(array('status' => 'error', 'message' => t('Masukkan kode kupon.', 'Enter coupon code.')));
            return;
        }

        $validation = $this->Coupon_model->validate_coupon($code, $cart['original_amount']);
        if (!$validation['valid']) {
            echo json_encode(array('status' => 'error', 'message' => $validation['message']));
            return;
        }

        $calc = $this->Coupon_model->calculate_discount($validation['coupon'], $cart['original_amount']);

        $cart['coupon_id'] = $validation['coupon']->id;
        $cart['amount'] = $calc['total'];
        $cart['discount_amount'] = $calc['discount'];
        $this->session->set_userdata('pending_cart_' . $token, $cart);

        echo json_encode(array(
            'status' => 'ok',
            'discount' => $calc['discount'],
            'total' => $calc['total'],
            'label' => $calc['label'],
            'message' => t('Kupon berhasil diterapkan!', 'Coupon applied!')
        ));
    }

    public function remove_coupon_cart($token) {
        $cart = $this->_get_cart($token);
        if (!$cart) {
            echo json_encode(array('status' => 'error'));
            return;
        }

        $cart['coupon_id'] = null;
        $cart['amount'] = $cart['original_amount'];
        $cart['discount_amount'] = 0;
        $this->session->set_userdata('pending_cart_' . $token, $cart);

        echo json_encode(array('status' => 'ok', 'amount' => $cart['original_amount']));
    }

    public function pay_cart($token) {
        $cart = $this->_get_cart($token);
        if (!$cart) show_404();

        $user_id = $this->session->userdata('user_id');

        // Create the transaction NOW (only when user clicks pay)
        $tx_data = array(
            'user_id' => $user_id,
            'item_type' => $cart['item_type'],
            'item_id' => $cart['item_id'],
            'amount' => $cart['amount'],
            'original_amount' => $cart['original_amount'],
            'discount_amount' => $cart['discount_amount'],
            'coupon_id' => $cart['coupon_id'],
            'notes' => $cart['notes'],
            'status' => 'pending',
        );
        $tx_id = $this->Transaction_model->create_transaction($tx_data);
        $tx = $this->Transaction_model->get_transaction_by_id($tx_id);

        // Clear the cart
        $this->_clear_cart($token);

        // Redirect to the UUID-based pay flow
        redirect('checkout/pay/' . $tx->uuid . ($this->input->get('method') ? '?method=' . $this->input->get('method') : ''));
    }

    public function apply_coupon($uuid) {
        $tx = $this->Transaction_model->get_by_uuid($uuid);
        if (!$tx || $tx->user_id != $this->session->userdata('user_id')) {
            echo json_encode(array('status' => 'error', 'message' => t('Transaksi tidak valid.', 'Invalid transaction.')));
            return;
        }
        if ($tx->status !== 'pending') {
            echo json_encode(array('status' => 'error', 'message' => t('Transaksi sudah diproses.', 'Already processed.')));
            return;
        }

        $code = $this->input->post('code');
        if (!$code) {
            echo json_encode(array('status' => 'error', 'message' => t('Masukkan kode kupon.', 'Enter coupon code.')));
            return;
        }

        $amount = $tx->original_amount > 0 ? $tx->original_amount : $tx->amount;
        $validation = $this->Coupon_model->validate_coupon($code, $amount);

        if (!$validation['valid']) {
            echo json_encode(array('status' => 'error', 'message' => $validation['message']));
            return;
        }

        $coupon = $validation['coupon'];
        $calc = $this->Coupon_model->calculate_discount($coupon, $amount);

        $this->db->where('id', $tx->id)->update('transactions', array(
            'coupon_id' => $coupon->id,
            'original_amount' => $amount,
            'discount_amount' => $calc['discount'],
            'amount' => $calc['total'],
        ));

        echo json_encode(array(
            'status' => 'ok',
            'discount' => $calc['discount'],
            'total' => $calc['total'],
            'label' => $calc['label'],
            'message' => t('Kupon berhasil diterapkan!', 'Coupon applied!')
        ));
    }

    public function remove_coupon($uuid) {
        $tx = $this->Transaction_model->get_by_uuid($uuid);
        if (!$tx || $tx->user_id != $this->session->userdata('user_id')) {
            echo json_encode(array('status' => 'error'));
            return;
        }

        $original = $tx->original_amount > 0 ? $tx->original_amount : $tx->amount;
        $this->db->where('id', $tx->id)->update('transactions', array(
            'coupon_id' => null,
            'original_amount' => 0,
            'discount_amount' => 0,
            'amount' => $original,
        ));

        echo json_encode(array('status' => 'ok', 'amount' => $original));
    }

    public function midtrans_snap($uuid) {
        $tx = $this->Transaction_model->get_by_uuid($uuid);
        if (!$tx || $tx->user_id != $this->session->userdata('user_id')) show_404();

        $server_key = setting('midtrans_server_key', '');
        $is_production = setting('midtrans_is_production', '0') === '1';

        if (!$server_key) {
            $this->session->set_flashdata('error', t('Pembayaran online belum dikonfigurasi.', 'Online payment not configured.'));
            redirect('checkout/confirm/' . $uuid);
        }

        $this->load->helper('midtrans');

        $item_name = '';
        if (in_array($tx->item_type, ['course', 'workshop', 'bootcamp', 'ebook', 'project', 'video', 'podcast', 'template'])) {
            $item = $this->Seminar_model->get_seminar_by_id($tx->item_id);
            $item_name = $item ? $item->title : 'Seminar';
        } elseif ($tx->item_type === 'package' || $tx->item_type === 'package_6mo') {
            $this->load->model('Package_model');
            $item = $this->Package_model->get_package_by_id($tx->item_id);
            $item_name = $item ? $item->name : 'Package';
        } elseif ($tx->item_type === 'mentoring_package') {
            $this->load->model('Mentoring_package_model');
            $item = $this->Mentoring_package_model->get_by_id($tx->item_id);
            $item_name = $item ? t($item->name, $item->name_en) : 'Mentoring Package';
        }

        $data['snap_token'] = get_midtrans_token($uuid, $tx->amount, $item_name, array(
            'first_name' => $this->session->userdata('name'),
            'email' => $this->session->userdata('email'),
        ), $server_key, $is_production);

        $data['client_key'] = setting('midtrans_client_key', '');
        $data['tx'] = $tx;

        $this->load->view('templates/header', array('title' => t('Pembayaran Online', 'Online Payment')));
        $this->load->view('checkout/midtrans', $data);
        $this->load->view('templates/footer');
    }

    public function midtrans_callback() {
        $notification = json_decode(file_get_contents('php://input'), true);

        if (!$notification || !isset($notification['order_id'])) {
            http_response_code(400);
            echo json_encode(array('status' => 'error'));
            return;
        }

        $uuid = $notification['order_id'];
        $tx = $this->Transaction_model->get_by_uuid($uuid);
        if (!$tx) {
            http_response_code(404);
            echo json_encode(array('status' => 'not_found'));
            return;
        }

        $transaction_status = $notification['transaction_status'] ?? '';

        if (in_array($transaction_status, ['capture', 'settlement'])) {
            $this->db->where('id', $tx->id)->update('transactions', array(
                'status' => 'approved',
                'payment_channel' => $notification['payment_type'] ?? '',
                'gateway_tx_id' => $notification['transaction_id'] ?? '',
            ));

            if ($tx->coupon_id) {
                $this->Coupon_model->increment_usage($tx->coupon_id);
            }

            if (in_array($tx->item_type, ['course', 'workshop', 'bootcamp', 'ebook', 'project', 'video', 'podcast', 'template'])) {
                $this->Course_model->enroll_user($tx->user_id, $tx->item_id);
            } elseif ($tx->item_type === 'seminar') {
                $this->Seminar_model->register_user($tx->user_id, $tx->item_id);
            } elseif ($tx->item_type === 'package') {
                $this->load->model('Package_model');
                $this->load->model('User_subscription_model');
                $pkg = $this->Package_model->get_package_by_id($tx->item_id);
                if ($pkg) {
                    $this->User_subscription_model->activate_subscription($tx->user_id, $pkg->id, $pkg->duration_days, $tx->id);
                }
            } elseif ($tx->item_type === 'package_6mo') {
                $this->load->model('Package_model');
                $this->load->model('User_subscription_model');
                $pkg = $this->Package_model->get_package_by_id($tx->item_id);
                if ($pkg) {
                    $duration_days = $pkg->duration_days * 6;
                    if (!empty($tx->notes)) {
                        $note = json_decode($tx->notes, true);
                        if (isset($note['duration_days'])) $duration_days = (int)$note['duration_days'];
                    }
                    $this->User_subscription_model->activate_subscription($tx->user_id, $pkg->id, $duration_days, $tx->id);
                }
            } elseif ($tx->item_type === 'mentoring_package') {
                $this->load->model('Mentoring_package_model');
                $this->load->model('User_mentoring_balance_model');
                $package = $this->Mentoring_package_model->get_by_id($tx->item_id);
                if ($package) {
                    $this->User_mentoring_balance_model->create(array(
                        'user_id' => $tx->user_id,
                        'package_id' => $package->id,
                        'total_sessions' => $package->session_count,
                        'remaining_sessions' => $package->session_count,
                        'session_duration' => $package->session_duration,
                        'expired_at' => date('Y-m-d', strtotime('+1 year')),
                    ));
                }
            }

            $this->load->helper('mail');
            $user = $this->db->where('id', $tx->user_id)->get('users')->row();
            if ($user) {
                send_email($user->email, 
                    t('Pembayaran Diterima', 'Payment Received'),
                    email_template(
                        t('Pembayaran Berhasil!', 'Payment Successful!'),
                        t('Pembayaran Anda telah diterima. Anda sekarang terdaftar!', 'Your payment has been received. You are now enrolled!'),
                        t('Lihat Dashboard', 'View Dashboard'),
                        base_url('dashboard')
                    )
                );
            }
        } elseif (in_array($transaction_status, ['deny', 'cancel', 'expire'])) {
            $this->db->where('id', $tx->id)->update('transactions', array(
                'status' => 'rejected',
                'payment_channel' => $notification['payment_type'] ?? '',
                'gateway_tx_id' => $notification['transaction_id'] ?? '',
            ));
        }

        http_response_code(200);
        echo json_encode(array('status' => 'ok'));
    }

    public function pay($uuid) {
        $tx = $this->Transaction_model->get_by_uuid($uuid);
        if (!$tx || $tx->user_id != $this->session->userdata('user_id')) show_404();

        if ($tx->status === 'approved') {
            $this->session->set_flashdata('success', t('Transaksi ini sudah disetujui.', 'Transaction already approved.'));
            redirect('dashboard');
        }

        if (!$this->pakasir->is_configured()) {
            $this->session->set_flashdata('error', t('Pembayaran online belum dikonfigurasi.', 'Online payment not configured.'));
            redirect('checkout/confirm/' . $uuid);
        }

        $allowed_methods = array('qris','bri_va','bni_va','cimb_niaga_va','maybank_va','permata_va','atm_bersama_va','sampoerna_va','bnc_va','artha_graha_va');
        $method = $this->input->get('method');
        if (!$method || !in_array($method, $allowed_methods)) $method = 'qris';
        $setting_key = 'payment_method_' . $method;
        if (function_exists('setting') && setting($setting_key, '1') !== '1') {
            $this->session->set_flashdata('error', t('Metode pembayaran tidak tersedia.', 'Payment method not available.'));
            redirect('checkout/confirm/' . $uuid);
        }
        $order_id = $uuid;

        $result = $this->pakasir->create_transaction($method, $order_id, $tx->amount);

        if (isset($result['error'])) {
            $this->session->set_flashdata('error', t('Gagal memproses pembayaran: ', 'Payment failed: ') . $result['error']);
            redirect('checkout/confirm/' . $uuid);
        }

        if (!isset($result['payment'])) {
            $this->session->set_flashdata('error', t('Gagal mendapatkan data pembayaran.', 'Failed to get payment data.'));
            redirect('checkout/confirm/' . $uuid);
        }

        $payment = $result['payment'];

        $this->db->where('id', $tx->id)->update('transactions', array(
            'gateway_tx_id' => $order_id,
            'payment_channel' => $method,
        ));

        $method_labels = array(
            'qris' => 'QRIS',
            'bri_va' => 'BRI Virtual Account',
            'bni_va' => 'BNI Virtual Account',
            'cimb_niaga_va' => 'CIMB Niaga Virtual Account',
            'maybank_va' => 'Maybank Virtual Account',
            'permata_va' => 'Permata Virtual Account',
            'atm_bersama_va' => 'ATM Bersama Virtual Account',
            'sampoerna_va' => 'Sampoerna Virtual Account',
            'bnc_va' => 'BNC Virtual Account',
            'artha_graha_va' => 'Artha Graha Virtual Account',
        );

        $item = NULL;
        if (in_array($tx->item_type, ['course', 'workshop', 'bootcamp', 'ebook', 'project', 'video', 'podcast', 'template'])) {
            $item = $this->Course_model->get_course_by_id($tx->item_id);
        } elseif ($tx->item_type === 'seminar') {
            $item = $this->Seminar_model->get_seminar_by_id($tx->item_id);
        } elseif ($tx->item_type === 'package' || $tx->item_type === 'package_6mo') {
            $this->load->model('Package_model');
            $item = $this->Package_model->get_package_by_id($tx->item_id);
        } elseif ($tx->item_type === 'mentoring_package') {
            $this->load->model('Mentoring_package_model');
            $item = $this->Mentoring_package_model->get_by_id($tx->item_id);
        }

        $data['title'] = t('Pembayaran', 'Payment');
        $data['tx'] = $tx;
        $data['item'] = $item;
        $data['payment'] = $payment;
        $data['order_id'] = $order_id;
        $data['method'] = $method;
        $data['method_label'] = $method_labels[$method] ?? $method;

        $this->load->view('templates/header', $data);
        $this->load->view('checkout/pakasir', $data);
        $this->load->view('templates/footer');
    }

    public function pakasir_webhook() {
        $notification = json_decode(file_get_contents('php://input'), true);

        if (!$notification || !isset($notification['order_id'])) {
            http_response_code(400);
            echo json_encode(array('status' => 'error'));
            return;
        }

        $uuid = $notification['order_id'];
        $tx = $this->Transaction_model->get_by_uuid($uuid);

        if (!$tx) {
            http_response_code(404);
            echo json_encode(array('status' => 'not_found'));
            return;
        }

        if ($tx->status === 'approved') {
            http_response_code(200);
            echo json_encode(array('status' => 'already_approved'));
            return;
        }

        $status = $notification['status'] ?? '';

        if ($status === 'completed') {
            $this->_approve_transaction($tx, $notification);
        }

        http_response_code(200);
        echo json_encode(array('status' => 'ok'));
    }

    public function pakasir_check($uuid) {
        $tx = $this->Transaction_model->get_by_uuid($uuid);
        if (!$tx || $tx->user_id != $this->session->userdata('user_id')) {
            echo json_encode(array('status' => 'error', 'message' => 'Invalid transaction'));
            return;
        }

        if ($tx->status === 'approved') {
            echo json_encode(array('status' => 'completed', 'message' => 'Payment received'));
            return;
        }

        if (empty($tx->gateway_tx_id)) {
            echo json_encode(array('status' => 'pending', 'message' => 'Waiting for payment'));
            return;
        }

        $result = $this->pakasir->get_transaction_detail($tx->gateway_tx_id, $tx->amount);

        if (isset($result['transaction']) && $result['transaction']['status'] === 'completed') {
            $this->_approve_transaction($tx, $result['transaction']);
            echo json_encode(array('status' => 'completed', 'message' => 'Payment received'));
        } else {
            echo json_encode(array('status' => 'pending', 'message' => 'Waiting for payment'));
        }
    }

    private function _approve_transaction($tx, $notification = array()) {
        $this->db->where('id', $tx->id)->update('transactions', array(
            'status' => 'approved',
            'payment_channel' => $notification['payment_method'] ?? '',
            'gateway_tx_id' => $notification['order_id'] ?? $tx->gateway_tx_id,
        ));

        // Increment coupon usage if coupon was applied
        if ($tx->coupon_id) {
            $this->Coupon_model->increment_usage($tx->coupon_id);
        }

        if (in_array($tx->item_type, ['course', 'workshop', 'bootcamp', 'ebook', 'project', 'video', 'podcast', 'template'])) {
            $this->Course_model->enroll_user($tx->user_id, $tx->item_id);
        } elseif ($tx->item_type === 'seminar') {
            $this->Seminar_model->register_user($tx->user_id, $tx->item_id);
        } elseif ($tx->item_type === 'package') {
            $this->load->model('Package_model');
            $this->load->model('User_subscription_model');
            $package = $this->Package_model->get_package_by_id($tx->item_id);
            if ($package) {
                $this->User_subscription_model->activate_subscription($tx->user_id, $package->id, $package->duration_days, $tx->id);
            }
        } elseif ($tx->item_type === 'package_6mo') {
            $this->load->model('Package_model');
            $this->load->model('User_subscription_model');
            $package = $this->Package_model->get_package_by_id($tx->item_id);
            if ($package) {
                $duration_days = $package->duration_days * 6;
                if (!empty($tx->notes)) {
                    $note = json_decode($tx->notes, true);
                    if (isset($note['duration_days'])) $duration_days = (int)$note['duration_days'];
                }
                $this->User_subscription_model->activate_subscription($tx->user_id, $package->id, $duration_days, $tx->id);
            }
        }

        $this->load->helper('mail');
        $user = $this->db->where('id', $tx->user_id)->get('users')->row();
        if ($user) {
            send_email($user->email,
                t('Pembayaran Diterima', 'Payment Received'),
                email_template(
                    t('Pembayaran Berhasil!', 'Payment Successful!'),
                    t('Pembayaran Anda telah diterima.', 'Your payment has been received.'),
                    t('Lihat Dashboard', 'View Dashboard'),
                    base_url('dashboard')
                )
            );
        }
    }
}
