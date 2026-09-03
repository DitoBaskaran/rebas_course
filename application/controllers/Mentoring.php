<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mentoring extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Mentor_model');
        $this->load->model('Mentoring_package_model');
        $this->load->model('Mentor_availability_model');
        $this->load->model('Mentoring_bookings_model');
        $this->load->model('User_mentoring_balance_model');
    }

    /**
     * Render view dengan template yang sesuai:
     * - sudah login → template student (panel: sidebar + bottom nav)
     * - belum login → template publik
     */
    private function _render($view, $data) {
        if ($this->session->userdata('logged_in')) {
            $this->load->view('templates/student_header', $data);
            $this->load->view($view, $data);
            $this->load->view('templates/student_footer');
        } else {
            $this->load->view('templates/header', $data);
            $this->load->view($view, $data);
            $this->load->view('templates/footer');
        }
    }

    public function index() {
        $data['title'] = t('Mentoring', 'Mentoring');
        $data['active_page'] = 'mentoring';
        $category_id = $this->input->get('category');
        $search = $this->input->get('search');
        $data['mentors'] = $this->Mentor_model->get_all($category_id, $search);
        $data['categories'] = $this->db->order_by('sort_order', 'ASC')->get('mentor_categories')->result();
        $data['selected_category'] = $category_id;
        $data['search_query'] = $search;
        $logged_in = $this->session->userdata('logged_in');
        if ($logged_in) {
            // Di dalam panel student: pakai template student (sidebar + bottom nav)
            $this->_render('mentoring/index', $data);
        } else {
            $this->load->view('templates/header', $data);
            $this->load->view('mentoring/index', $data);
            $this->load->view('templates/footer');
        }
    }

    public function packages() {
        $data['title'] = t('Paket Mentoring', 'Mentoring Packages');
        $data['active_page'] = 'mentoring';
        $data['packages'] = $this->Mentoring_package_model->get_all(true);
        $this->_render('mentoring/packages', $data);
    }

    public function detail($encoded_id) {
        $id = decode_id($encoded_id);
        if (!$id) show_404();
        $mentor = $this->Mentor_model->get_by_id($id);
        if (!$mentor) show_404();
        $data['title'] = $mentor->name . ' - Mentoring';
        $data['active_page'] = 'mentoring';
        $data['mentor'] = $mentor;
        $data['categories'] = $this->Mentor_model->get_categories($id);
        $data['week_slots'] = $this->Mentor_availability_model->get_week_slots($id);
        $data['reviews'] = $this->db->select('mentor_reviews.*, users.name as user_name, users.avatar as user_avatar')
            ->from('mentor_reviews')
            ->join('users', 'users.id = mentor_reviews.user_id')
            ->where('mentor_reviews.mentor_id', $id)
            ->order_by('mentor_reviews.created_at', 'DESC')
            ->limit(20)
            ->get()->result();
        $user_id = $this->session->userdata('user_id');
        $data['is_favorited'] = $user_id ? $this->Mentor_model->is_favorited($user_id, $id) : false;
        $this->_render('mentoring/detail', $data);
    }

    public function book($encoded_mentor_id) {
        $this->_require_perm('mentoring', 'create');
        if (!$this->session->userdata('logged_in')) {
            $this->session->set_flashdata('error', t('Silakan login.', 'Please login.'));
            redirect('auth/login');
        }
        $mentor_id = decode_id($encoded_mentor_id);
        if (!$mentor_id) show_404();
        $mentor = $this->Mentor_model->get_by_id($mentor_id);
        if (!$mentor) show_404();
        $user_id = $this->session->userdata('user_id');
        $data['title'] = t('Booking Sesi', 'Book Session');
        $data['active_page'] = 'mentoring';
        $data['encoded_mentor_id'] = $encoded_mentor_id;
        $data['mentor'] = $mentor;
        $data['packages'] = $this->Mentoring_package_model->get_all(true);
        $data['balances'] = $this->User_mentoring_balance_model->get_by_user($user_id);
        $data['week_slots'] = $this->Mentor_availability_model->get_week_slots($mentor_id);
        $this->_render('mentoring/book', $data);
    }

    public function confirm_booking() {
        $this->_require_perm('mentoring', 'create');
        if (!$this->session->userdata('logged_in')) { redirect('auth/login'); }
        $user_id = $this->session->userdata('user_id');
        $mentor_id = decode_id($this->input->post('mentor_id'));
        $availability_id = $this->input->post('availability_id');
        $balance_id = $this->input->post('balance_id');
        $notes = $this->input->post('notes') ?: '';

        if (!$mentor_id) show_404();
        $slot = $this->Mentor_availability_model->get_by_id($availability_id);
        if (!$slot || $slot->is_booked) {
            $this->session->set_flashdata('error', t('Slot tidak tersedia.', 'Slot not available.'));
            redirect('mentoring/book/' . $this->input->post('mentor_id'));
        }
        $balance = $this->User_mentoring_balance_model->get_by_id($balance_id);
        if (!$balance || $balance->user_id != $user_id || $balance->remaining_sessions <= 0) {
            $this->session->set_flashdata('error', t('Saldo sesi tidak cukup.', 'Insufficient session balance.'));
            redirect('mentoring/book/' . $this->input->post('mentor_id'));
        }
        $mentor = $this->Mentor_model->get_by_id($mentor_id);
        $day_names = array('Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday');
        $scheduled_at = ($slot->date_override) ? $slot->date_override : date('Y-m-d', strtotime('next ' . $day_names[$slot->day_of_week]));
        $scheduled_at .= ' ' . $slot->start_time;
        $booking_id = $this->Mentoring_bookings_model->create(array(
            'user_id' => $user_id, 'mentor_id' => $mentor_id, 'balance_id' => $balance_id,
            'availability_id' => $availability_id, 'scheduled_at' => $scheduled_at,
            'duration' => $balance->session_duration, 'status' => 'pending', 'notes' => $notes,
        ));
        $this->Mentor_availability_model->mark_booked($availability_id, $booking_id);
        $this->User_mentoring_balance_model->deduct_session($balance_id);

        // Notifikasi WhatsApp ke mentor: ada booking baru
        $this->load->helper('wa_notification');
        $new_session = $this->Mentoring_bookings_model->get_by_id($booking_id);
        wa_notify_mentor_new_booking($new_session);

        $this->session->set_flashdata('success', t('Sesi berhasil dibooking! Menunggu konfirmasi mentor.', 'Session booked! Awaiting mentor confirmation.'));
        redirect('mentoring/my-sessions');
    }

    public function my_sessions() {
        $this->_require_perm('mentoring', 'read');
        if (!$this->session->userdata('logged_in')) { redirect('auth/login'); }
        $user_id = $this->session->userdata('user_id');
        $data['title'] = t('Sesi Mentoring Saya', 'My Mentoring Sessions');
        $data['active_page'] = 'mentoring';
        $data['sessions'] = $this->Mentoring_bookings_model->get_by_user($user_id);
        $data['balances'] = $this->User_mentoring_balance_model->get_by_user($user_id);
        $this->_render('mentoring/my_sessions', $data);
    }

    public function cancel($encoded_session_id) {
        $this->_require_perm('mentoring', 'update');
        if (!$this->session->userdata('logged_in')) { redirect('auth/login'); }
        $session_id = decode_id($encoded_session_id);
        if (!$session_id) show_404();
        $user_id = $this->session->userdata('user_id');
        $session = $this->Mentoring_bookings_model->get_by_id($session_id);
        if (!$session || $session->user_id != $user_id) show_404();
        if (!in_array($session->status, array('pending', 'confirmed'))) {
            $this->session->set_flashdata('error', t('Tidak bisa membatalkan sesi ini.', 'Cannot cancel this session.'));
            redirect('mentoring/my-sessions');
        }
        $this->Mentoring_bookings_model->update($session_id, array('status' => 'cancelled', 'cancelled_by' => 'user', 'cancelled_at' => date('Y-m-d H:i:s')));
        if ($session->availability_id) $this->Mentor_availability_model->mark_available($session->availability_id);
        if ($session->balance_id) $this->User_mentoring_balance_model->restore_session($session->balance_id);
        $this->session->set_flashdata('success', t('Sesi dibatalkan. Sesi dikembalikan ke kuota Anda.', 'Session cancelled. Returned to your quota.'));
        redirect('mentoring/my-sessions');
    }

    public function toggle_favorite($encoded_mentor_id) {
        if (!$this->session->userdata('logged_in')) { redirect('auth/login'); }
        $mentor_id = decode_id($encoded_mentor_id);
        if (!$mentor_id) show_404();
        $user_id = $this->session->userdata('user_id');
        $was_favorited = $this->Mentor_model->is_favorited($user_id, $mentor_id);
        $this->Mentor_model->toggle_favorite($user_id, $mentor_id);
        $now_favorited = !$was_favorited;
        // AJAX (dari halaman wishlist) → balas JSON
        if ($this->input->is_ajax_request()) {
            echo json_encode(array('status' => $now_favorited ? 'added' : 'removed'));
            return;
        }
        $this->session->set_flashdata('success', t('Diperbarui.', 'Updated.'));
        redirect('mentoring/detail/' . $encoded_mentor_id);
    }

    public function buy_package($encoded_package_id) {
        if (!$this->session->userdata('logged_in')) {
            $this->session->set_flashdata('error', t('Silakan login.', 'Please login.'));
            redirect('auth/login');
        }
        $package_id = decode_id($encoded_package_id);
        if (!$package_id) show_404();
        redirect('checkout/initiate/mentoring_package/' . $package_id);
    }

    public function approve_booking($encoded_session_id) {
        if (!$this->session->userdata('logged_in')) { redirect('auth/login'); }
        $session_id = decode_id($encoded_session_id);
        if (!$session_id) show_404();
        $user_id = $this->session->userdata('user_id');
        $session = $this->Mentoring_bookings_model->get_by_id($session_id);
        // Cek kepemilikan: hanya pemilik sesi (student) yang bisa mengonfirmasi sesinya sendiri
        if (!$session || $session->user_id != $user_id) show_404();
        if ($session->status !== 'pending') {
            $this->session->set_flashdata('error', t('Sesi ini sudah tidak bisa dikonfirmasi.', 'This session can no longer be confirmed.'));
            redirect('mentoring/my-sessions');
        }
        $this->Mentoring_bookings_model->update($session_id, array('status' => 'confirmed', 'user_confirmed_at' => date('Y-m-d H:i:s')));
        $this->session->set_flashdata('success', t('Sesi dikonfirmasi.', 'Session confirmed.'));
        redirect('mentoring/my-sessions');
    }

    public function review($encoded_session_id) {
        if (!$this->session->userdata('logged_in')) { redirect('auth/login'); }
        $session_id = decode_id($encoded_session_id);
        if (!$session_id) show_404();
        $user_id = $this->session->userdata('user_id');
        $session = $this->Mentoring_bookings_model->get_by_id($session_id);
        if (!$session || $session->user_id != $user_id || $session->status != 'completed') show_404();
        $this->form_validation->set_rules('rating', t('Rating', 'Rating'), 'required|numeric|greater_than[0]|less_than[6]');
        if ($this->form_validation->run()) {
            $this->db->insert('mentor_reviews', array(
                'session_id' => $session_id, 'user_id' => $user_id, 'mentor_id' => $session->mentor_id,
                'rating' => $this->input->post('rating'), 'review_text' => $this->input->post('review_text'),
            ));
            $this->load->model('Mentor_model');
            $this->Mentor_model->update_rating($session->mentor_id);
            $this->session->set_flashdata('success', t('Review berhasil dikirim.', 'Review submitted.'));
        }
        redirect('mentoring/my-sessions');
    }

    public function get_slots_json($encoded_mentor_id) {
        $mentor_id = decode_id($encoded_mentor_id);
        if (!$mentor_id) { echo json_encode(array()); return; }
        $date = $this->input->get('date');
        $slots = $this->Mentor_availability_model->get_available_slots($mentor_id, $date);
        $result = array();
        foreach ($slots as $s) {
            $result[] = array(
                'id' => encode_id($s->id),
                'day_of_week' => $s->day_of_week, 'date_override' => $s->date_override,
                'start_time' => $s->start_time, 'end_time' => $s->end_time,
            );
        }
        echo json_encode($result);
    }

    // ===== KONSULTASI AI → REKOMENDASI MENTOR =====
    public function ai_recommend() {
        if (!$this->session->userdata('logged_in')) {
            echo json_encode(array('status' => 'error', 'message' => 'Silakan login.'));
            return;
        }
        $problem = trim($this->input->post('problem'));
        if ($problem === '') {
            echo json_encode(array('status' => 'error', 'message' => 'Silakan ceritakan masalahmu terlebih dahulu.'));
            return;
        }
        // Izinkan input pendek/sapaan — AI yang menanggapinya dengan baik (minta detail)
        if (mb_strlen($problem) > 200) {
            $problem = mb_substr($problem, 0, 200);
        }

        $this->load->library('Ai_mentor');
        $user_name = $this->session->userdata('name') ?: '';
        $res = $this->ai_mentor->recommend($problem, $user_name);

        if (!$res['ok']) {
            echo json_encode(array(
                'status' => 'error',
                'message' => $res['error'] === 'no_mentors' ? 'Belum ada mentor terdaftar.' : 'Layanan AI sedang sibuk, coba lagi. (' . $res['error'] . ')',
            ));
            return;
        }

        // Ambil detail mentor hasil rekomendasi
        $mentors = array();
        if (!empty($res['mentor_ids'])) {
            $this->load->model('Mentor_model');
            foreach ($res['mentor_ids'] as $mid) {
                $m = $this->Mentor_model->get_by_id($mid);
                if ($m) {
                    $mentors[] = array(
                        'id' => $mid,
                        'encoded_id' => encode_id($mid),
                        'name' => $m->name,
                        'title' => $m->title,
                        'avatar' => $m->avatar,
                        'avg_rating' => $m->avg_rating,
                        'total_reviews' => $m->total_reviews,
                        'bio' => $m->bio,
                        'price_per_session' => (float) $m->price_per_session,
                    );
                }
            }
        }

        echo json_encode(array(
            'status' => 'ok',
            'reason' => $res['explanation'],
            'mentors' => $mentors,
        ));
    }
}
