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
        $this->load->library('pakasir');
    }

    public function confirm($tx_id) {
        $tx = $this->Transaction_model->get_transaction_by_id($tx_id);
        if (!$tx || $tx->user_id != $this->session->userdata('user_id')) show_404();

        if ($tx->status === 'approved') {
            $this->session->set_flashdata('success', t('Transaksi ini sudah disetujui.', 'Transaction already approved.'));
            redirect('dashboard');
        }

        $item = NULL;
        if (in_array($tx->item_type, ['course', 'workshop', 'bootcamp', 'ebook', 'project'])) {
            $item = $this->Course_model->get_course_by_id($tx->item_id);
        } else if ($tx->item_type === 'seminar') {
            $item = $this->Seminar_model->get_seminar_by_id($tx->item_id);
        } else if ($tx->item_type === 'package') {
            $this->load->model('Package_model');
            $item = $this->Package_model->get_package_by_id($tx->item_id);
        } else if ($tx->item_type === 'package_6mo') {
            $this->load->model('Package_model');
            $item = $this->Package_model->get_package_by_id($tx->item_id);
        } else if ($tx->item_type === 'minute_bundle') {
            $this->load->model('Minute_bundle_model');
            $item = $this->Minute_bundle_model->get_bundle_by_id($tx->item_id);
        }

        $data['title'] = t('Konfirmasi Pembayaran', 'Payment Confirmation');
        $data['transaction'] = $tx;
        $data['item'] = $item;

        $this->load->view('templates/header', $data);
        $this->load->view('checkout/confirm', $data);
        $this->load->view('templates/footer');
    }

    public function midtrans_snap($tx_id) {
        $tx = $this->Transaction_model->get_transaction_by_id($tx_id);
        if (!$tx || $tx->user_id != $this->session->userdata('user_id')) show_404();

        $server_key = setting('midtrans_server_key', '');
        $is_production = setting('midtrans_is_production', '0') === '1';

        if (!$server_key) {
            $this->session->set_flashdata('error', t('Pembayaran online belum dikonfigurasi.', 'Online payment not configured.'));
            redirect('checkout/confirm/' . $tx_id);
        }

        $this->load->helper('midtrans');

        $item_name = '';
        if ($tx->item_type === 'course') {
            $item = $this->Course_model->get_course_by_id($tx->item_id);
            $item_name = $item ? $item->title : 'Course';
        } elseif ($tx->item_type === 'seminar') {
            $item = $this->Seminar_model->get_seminar_by_id($tx->item_id);
            $item_name = $item ? $item->title : 'Seminar';
        } elseif ($tx->item_type === 'package' || $tx->item_type === 'package_6mo') {
            $this->load->model('Package_model');
            $item = $this->Package_model->get_package_by_id($tx->item_id);
            $item_name = $item ? $item->name : 'Package';
        } elseif ($tx->item_type === 'minute_bundle') {
            $this->load->model('Minute_bundle_model');
            $item = $this->Minute_bundle_model->get_bundle_by_id($tx->item_id);
            $item_name = $item ? $item->name : 'Minute Bundle';
        }

        $data['snap_token'] = get_midtrans_token($tx_id, $tx->amount, $item_name, array(
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

        preg_match('/CRS-(\d+)-/', $notification['order_id'], $matches);
        $tx_id = isset($matches[1]) ? (int)$matches[1] : 0;

        if (!$tx_id) {
            http_response_code(400);
            echo json_encode(array('status' => 'error'));
            return;
        }

        $tx = $this->Transaction_model->get_transaction_by_id($tx_id);
        if (!$tx) {
            http_response_code(404);
            echo json_encode(array('status' => 'not_found'));
            return;
        }

        $transaction_status = $notification['transaction_status'] ?? '';

        if (in_array($transaction_status, ['capture', 'settlement'])) {
            $this->db->where('id', $tx_id)->update('transactions', array(
                'status' => 'approved',
                'payment_channel' => $notification['payment_type'] ?? '',
                'gateway_tx_id' => $notification['transaction_id'] ?? '',
            ));

            if ($tx->item_type === 'course') {
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
            } elseif ($tx->item_type === 'minute_bundle') {
                $this->load->model('Minute_bundle_model');
                $this->load->model('User_minute_balance_model');
                $bundle = $this->Minute_bundle_model->get_bundle_by_id($tx->item_id);
                if ($bundle) {
                    $this->User_minute_balance_model->add_seconds($tx->user_id, $bundle->minutes * 60);
                }
            }

            // Send email notification
            $this->load->helper('mail');
            $user = $this->db->where('id', $tx->user_id)->get('users')->row();
            if ($user) {
                send_email($user->email, 
                    t('Pembayaran Diterima', 'Payment Received'),
                    email_template(
                        t('Pembayaran Berhasil!', 'Payment Successful!'),
                        t('Pembayaran Anda untuk transaksi #' . $tx_id . ' telah diterima. Anda sekarang terdaftar!', 'Your payment for transaction #' . $tx_id . ' has been received. You are now enrolled!'),
                        t('Lihat Dashboard', 'View Dashboard'),
                        base_url('dashboard')
                    )
                );
            }
        } elseif (in_array($transaction_status, ['deny', 'cancel', 'expire'])) {
            $this->db->where('id', $tx_id)->update('transactions', array(
                'status' => 'rejected',
                'payment_channel' => $notification['payment_type'] ?? '',
                'gateway_tx_id' => $notification['transaction_id'] ?? '',
            ));
        }

        http_response_code(200);
        echo json_encode(array('status' => 'ok'));
    }

    public function submit_proof($tx_id) {
        $tx = $this->Transaction_model->get_transaction_by_id($tx_id);
        if (!$tx || $tx->user_id != $this->session->userdata('user_id')) show_404();

        $upload_path = './uploads/proofs';
        if (!is_dir($upload_path)) mkdir($upload_path, 0777, TRUE);

        $config = array(
            'upload_path' => $upload_path,
            'allowed_types' => 'gif|jpg|jpeg|png',
            'max_size' => 2048,
            'file_name' => 'proof_' . $tx_id . '_' . time()
        );
        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('payment_proof')) {
            $this->session->set_flashdata('error', t('Gagal upload bukti bayar.', 'Failed to upload proof.') . ' ' . $this->upload->display_errors('', ''));
            redirect('checkout/confirm/' . $tx_id);
        } else {
            $file_name = $this->upload->data('file_name');
            $this->db->where('id', $tx_id)->update('transactions', array(
                'payment_proof' => $file_name,
                'status' => 'pending'
            ));

            // Notify admin
            $this->load->helper('mail');
            $admin_email = setting('general_admin_email', '');
            if ($admin_email) {
                send_email($admin_email,
                    t('Bukti Pembayaran Baru', 'New Payment Proof'),
                    email_template(
                        t('Bukti Pembayaran #', 'Payment Proof #') . $tx_id,
                        t('Ada bukti pembayaran baru yang menunggu verifikasi.', 'A new payment proof is awaiting verification.'),
                        t('Verifikasi Sekarang', 'Verify Now'),
                        base_url('admin/dashboard')
                    )
                );
            }

            $this->session->set_flashdata('success', t('Bukti berhasil diunggah. Kami akan verifikasi segera!', 'Proof uploaded. We will verify shortly!'));
            redirect('dashboard');
        }
    }

    public function pakasir_pay($tx_id) {
        $tx = $this->Transaction_model->get_transaction_by_id($tx_id);
        if (!$tx || $tx->user_id != $this->session->userdata('user_id')) show_404();

        if ($tx->status === 'approved') {
            $this->session->set_flashdata('success', t('Transaksi ini sudah disetujui.', 'Transaction already approved.'));
            redirect('dashboard');
        }

        if (!$this->pakasir->is_configured()) {
            $this->session->set_flashdata('error', t('Pembayaran online belum dikonfigurasi.', 'Online payment not configured.'));
            redirect('checkout/confirm/' . $tx_id);
        }

        $method = $this->input->get('method') ?: 'qris';
        $order_id = 'CRS-' . $tx_id . '-' . time();

        $result = $this->pakasir->create_transaction($method, $order_id, $tx->amount);

        if (isset($result['error'])) {
            $this->session->set_flashdata('error', t('Gagal memproses pembayaran: ', 'Payment failed: ') . $result['error']);
            redirect('checkout/confirm/' . $tx_id);
        }

        if (!isset($result['payment'])) {
            $this->session->set_flashdata('error', t('Gagal mendapatkan data pembayaran.', 'Failed to get payment data.'));
            redirect('checkout/confirm/' . $tx_id);
        }

        $payment = $result['payment'];

        $this->db->where('id', $tx_id)->update('transactions', array(
            'gateway_tx_id' => $order_id,
            'payment_channel' => $method,
        ));

        $data['title'] = t('Pembayaran Online', 'Online Payment');
        $data['tx'] = $tx;
        $data['payment'] = $payment;
        $data['order_id'] = $order_id;
        $data['method'] = $method;

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

        preg_match('/CRS-(\d+)-/', $notification['order_id'], $matches);
        $tx_id = isset($matches[1]) ? (int)$matches[1] : 0;

        if (!$tx_id) {
            http_response_code(400);
            echo json_encode(array('status' => 'error'));
            return;
        }

        $tx = $this->Transaction_model->get_transaction_by_id($tx_id);
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

    public function pakasir_check($tx_id) {
        $tx = $this->Transaction_model->get_transaction_by_id($tx_id);
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

        if ($tx->item_type === 'course') {
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
        } elseif ($tx->item_type === 'minute_bundle') {
            $this->load->model('Minute_bundle_model');
            $this->load->model('User_minute_balance_model');
            $bundle = $this->Minute_bundle_model->get_bundle_by_id($tx->item_id);
            if ($bundle) {
                $seconds = $bundle->minutes * 60;
                $this->User_minute_balance_model->add_seconds($tx->user_id, $seconds);
            }
        }

        $this->load->helper('mail');
        $user = $this->db->where('id', $tx->user_id)->get('users')->row();
        if ($user) {
            send_email($user->email,
                t('Pembayaran Diterima', 'Payment Received'),
                email_template(
                    t('Pembayaran Berhasil!', 'Payment Successful!'),
                    t('Pembayaran Anda untuk transaksi #' . $tx->id . ' telah diterima.', 'Your payment for transaction #' . $tx->id . ' has been received.'),
                    t('Lihat Dashboard', 'View Dashboard'),
                    base_url('dashboard')
                )
            );
        }
    }
}
