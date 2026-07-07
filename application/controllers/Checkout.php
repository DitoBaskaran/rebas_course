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
}
