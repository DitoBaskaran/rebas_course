<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Forum extends MY_Controller {

    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata('logged_in')) {
            $this->session->set_flashdata('error', t('Silakan login terlebih dahulu.', 'Please login first.'));
            redirect('auth/login');
        }
        $this->load->model('Discussion_model');
        $this->load->model('Course_model');
    }

    public function index($course_slug = null) {
        if (!$course_slug) {
            $courses = $this->Course_model->get_user_enrolled_courses($this->session->userdata('user_id'));
            if (!empty($courses)) redirect('forum/index/' . $courses[0]->slug);
            $data['title'] = t('Forum Diskusi', 'Discussion Forum');
            $data['active_page'] = 'forum';
            $this->load->view('templates/student_header', $data);
            $this->load->view('forum/empty', $data);
            $this->load->view('templates/student_footer');
            return;
        }
        $course = $this->Course_model->get_course_by_slug($course_slug);
        if (!$course) show_404();
        $data['title'] = t('Diskusi: ', 'Discussion: ') . $course->title;
        $data['active_page'] = 'forum';
        $data['course'] = $course;
        $data['discussions'] = $this->Discussion_model->get_discussions($course->id);
        $this->load->view('templates/student_header', $data);
        $this->load->view('forum/index', $data);
        $this->load->view('templates/student_footer');
    }

    public function view($encoded_id) {
        $id = decode_id($encoded_id);
        if (!$id) show_404();
        $discussion = $this->Discussion_model->get_discussion_by_id($id);
        if (!$discussion) show_404();
        $course = $this->Course_model->get_course_by_id($discussion->course_id);
        $replies = $this->Discussion_model->get_replies($id);
        $data['title'] = $discussion->title;
        $data['active_page'] = 'forum';
        $data['discussion'] = $discussion;
        $data['course'] = $course;
        $data['replies'] = $replies;
        $data['has_best_answer'] = !empty(array_filter($replies, function($r) { return $r->is_best_answer; }));
        $data['encoded_discussion_id'] = $encoded_id;
        $this->load->view('templates/student_header', $data);
        $this->load->view('forum/view', $data);
        $this->load->view('templates/student_footer');
    }

    public function create($course_slug) {
        $this->load->helper('gamification');
        $course = $this->Course_model->get_course_by_slug($course_slug);
        if (!$course) show_404();
        $this->form_validation->set_rules('title', t('Judul', 'Title'), 'required|trim');
        $this->form_validation->set_rules('content', t('Konten', 'Content'), 'required');
        if ($this->form_validation->run() === FALSE) {
            $data['title'] = t('Buat Diskusi Baru', 'New Discussion');
            $data['active_page'] = 'forum';
            $data['course'] = $course;
            $this->load->view('templates/student_header', $data);
            $this->load->view('forum/create', $data);
            $this->load->view('templates/student_footer');
        } else {
            $discussion_id = $this->Discussion_model->create_discussion(array(
                'course_id' => $course->id, 'user_id' => $this->session->userdata('user_id'),
                'title' => $this->input->post('title'), 'content' => $this->input->post('content')
            ));
            award_points($this->session->userdata('user_id'), 3, 'forum_post', $discussion_id);
            $this->session->set_flashdata('success', t('Diskusi berhasil dibuat.', 'Discussion created.'));
            redirect('forum/index/' . $course->slug);
        }
    }

    public function reply($encoded_id) {
        $discussion_id = decode_id($encoded_id);
        if (!$discussion_id) show_404();
        $discussion = $this->Discussion_model->get_discussion_by_id($discussion_id);
        if (!$discussion) show_404();
        $this->form_validation->set_rules('content', t('Balasan', 'Reply'), 'required');
        if ($this->form_validation->run()) {
            $this->Discussion_model->create_reply(array(
                'discussion_id' => $discussion_id, 'user_id' => $this->session->userdata('user_id'),
                'content' => $this->input->post('content')
            ));
        }
        redirect('forum/view/' . $encoded_id);
    }

    public function mark_best($encoded_reply_id) {
        $reply_id = decode_id($encoded_reply_id);
        if (!$reply_id) show_404();
        $reply = $this->db->get_where('discussion_replies', array('id' => $reply_id))->row();
        if (!$reply) show_404();
        $discussion = $this->Discussion_model->get_discussion_by_id($reply->discussion_id);
        if (!$discussion) show_404();
        $user_id = $this->session->userdata('user_id');
        if ($discussion->user_id != $user_id) {
            $this->session->set_flashdata('error', t('Hanya pembuat diskusi yang bisa memilih jawaban terbaik.', 'Only the discussion author can mark best answer.'));
            redirect('forum/view/' . encode_id($reply->discussion_id));
        }
        $this->Discussion_model->mark_best_answer($reply_id, $reply->discussion_id);
        redirect('forum/view/' . encode_id($reply->discussion_id));
    }
}
