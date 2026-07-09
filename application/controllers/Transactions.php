<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Transactions extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata('logged_in')) {
            $this->session->set_flashdata('error', t('Silakan login terlebih dahulu.', 'Please login first.'));
            redirect('auth/login');
        }
        $this->load->model('Transaction_model');
        $this->load->model('Course_model');
        $this->load->model('Seminar_model');
        $this->load->model('Mentoring_model');
    }

    public function history() {
        $data['title'] = t('Riwayat Transaksi', 'Transaction History');
        $data['active_page'] = 'transactions';
        $this->load->view('templates/student_header', $data);
        $this->load->view('transactions/history', $data);
        $this->load->view('templates/student_footer');
    }

    public function history_data() {
        $user_id = $this->session->userdata('user_id');
        $draw = $this->input->get('draw');
        $start = $this->input->get('start');
        $length = $this->input->get('length');
        $search = $this->input->get('search')['value'] ?? '';
        $order_col = $this->input->get('order')[0]['column'] ?? '4';
        $order_dir = $this->input->get('order')[0]['dir'] ?? 'DESC';

        $order_columns = ['created_at' => 'transactions.created_at', 'item_type' => 'transactions.item_type', 'amount' => 'transactions.amount', 'status' => 'transactions.status'];
        $order_key = array_values($order_columns)[$order_col] ?? 'transactions.created_at';

        $total = $this->db->where('user_id', $user_id)->count_all_results('transactions');

        $this->db->select('transactions.*, courses.title as course_title');
        $this->db->from('transactions');
        $this->db->join('courses', 'courses.id = transactions.item_id', 'left');
        $this->db->where('transactions.user_id', $user_id);
        if ($search) {
            $this->db->group_start();
            $this->db->like('transactions.item_type', $search);
            $this->db->or_like('transactions.uuid', $search);
            $this->db->or_like('courses.title', $search);
            $this->db->group_end();
        }
        $filtered = $this->db->count_all_results();

        $this->db->select('transactions.*, courses.title as course_title');
        $this->db->from('transactions');
        $this->db->join('courses', 'courses.id = transactions.item_id', 'left');
        $this->db->where('transactions.user_id', $user_id);
        if ($search) {
            $this->db->group_start();
            $this->db->like('transactions.item_type', $search);
            $this->db->or_like('transactions.uuid', $search);
            $this->db->or_like('courses.title', $search);
            $this->db->group_end();
        }
        $this->db->order_by($order_key, $order_dir);
        $this->db->limit($length, $start);
        $rows = $this->db->get()->result();

        $data_arr = array();
        foreach ($rows as $tx) {
            $status_badge = '';
            if ($tx->status === 'approved') {
                $status_badge = '<span class="badge bg-success rounded-pill px-3 py-1 fw-medium">' . t('Berhasil', 'Success') . '</span>';
            } elseif ($tx->status === 'pending') {
                $status_badge = '<span class="badge bg-warning text-dark rounded-pill px-3 py-1 fw-medium">' . t('Menunggu', 'Pending') . '</span>';
            } else {
                $status_badge = '<span class="badge bg-danger rounded-pill px-3 py-1 fw-medium">' . t('Ditolak', 'Rejected') . '</span>';
            }

            $item_name = $tx->course_title ?? '-';
            $action = '<a href="' . base_url('transactions/detail/' . $tx->uuid) . '" class="btn btn-outline-dark btn-sm rounded-pill px-3 fw-semibold">' . t('Detail', 'Detail') . '</a>';

            $data_arr[] = array(
                date('d M Y H:i', strtotime($tx->created_at)),
                '<span class="badge bg-secondary bg-opacity-10 text-secondary rounded-pill px-2 py-1 fw-medium text-uppercase" style="font-size:0.7rem;">' . $tx->item_type . '</span>',
                $item_name,
                'Rp ' . number_format($tx->amount, 0, ',', '.'),
                $tx->created_at,
                $status_badge,
                $action,
            );
        }

        echo json_encode(array(
            'draw' => (int)$draw,
            'recordsTotal' => $total,
            'recordsFiltered' => $filtered,
            'data' => $data_arr,
        ));
    }

    public function detail($uuid) {
        $tx = $this->Transaction_model->get_by_uuid($uuid);
        if (!$tx || $tx->user_id != $this->session->userdata('user_id')) show_404();

        $item = NULL;
        if (in_array($tx->item_type, ['course', 'workshop', 'bootcamp', 'ebook', 'project'])) {
            $item = $this->Course_model->get_course_by_id($tx->item_id);
        } elseif ($tx->item_type === 'seminar') {
            $item = $this->Seminar_model->get_seminar_by_id($tx->item_id);
        } elseif ($tx->item_type === 'mentoring') {
            $item = $this->Mentoring_model->get_session_by_id($tx->item_id);
        }

        $data['title'] = t('Detail Transaksi', 'Transaction Detail');
        $data['active_page'] = 'transactions';
        $data['transaction'] = $tx;
        $data['item'] = $item;
        $this->load->view('templates/student_header', $data);
        $this->load->view('transactions/detail', $data);
        $this->load->view('templates/student_footer');
    }
}
