<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Wishlist extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata('logged_in')) {
            redirect('auth/login');
        }
        $this->load->model('Course_model');
    }

    public function toggle($course_id) {
        $user_id = $this->session->userdata('user_id');
        $existing = $this->db->where('user_id', $user_id)->where('course_id', $course_id)->get('wishlists')->row();
        if ($existing) {
            $this->db->where('id', $existing->id)->delete('wishlists');
            echo json_encode(array('status' => 'removed'));
        } else {
            $this->db->insert('wishlists', array('user_id' => $user_id, 'course_id' => $course_id, 'created_at' => date('Y-m-d H:i:s')));
            echo json_encode(array('status' => 'added'));
        }
    }

    public function index() {
        $user_id = $this->session->userdata('user_id');
        $data['wishlists'] = $this->db
            ->select('courses.*, categories.name as category_name')
            ->from('wishlists')
            ->join('courses', 'courses.id = wishlists.course_id')
            ->join('categories', 'categories.id = courses.category_id', 'left')
            ->where('wishlists.user_id', $user_id)
            ->order_by('wishlists.created_at', 'DESC')
            ->get()->result();
        $data['title'] = t('Wishlist - REBAS COURSE', 'Wishlist - REBAS COURSE');
        $this->load->view('templates/header', $data);
        $this->load->view('wishlist/index', $data);
        $this->load->view('templates/footer');
    }
}
