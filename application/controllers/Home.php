<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Course_model');
        $this->load->model('Seminar_model');
        $this->load->model('Tag_model');
        $this->load->model('Setting_model');
        $this->load->model('User_model');
        $this->load->model('Package_model');
    }

    public function index() {
        $site_name = setting('general_site_name', 'BISATUNTAS');
        $data['title'] = t($site_name . ' - Platform Belajar & Seminar Online', $site_name . ' - Online Learning & Seminar Platform');
        $data['is_homepage'] = true;
        $featured_count = (int)(setting('home_featured_count', 4));
        $recent_count = (int)(setting('home_recent_count', 6));
        $data['featured_courses'] = $this->Course_model->get_featured_courses($featured_count ?: 4);
        $data['recent_courses'] = $this->Course_model->get_courses(array('limit' => $recent_count ?: 6));
        $data['upcoming_seminars'] = $this->Seminar_model->get_seminars();
        $data['categories'] = $this->Course_model->get_root_categories();
        $data['popular_tags'] = $this->Tag_model->get_popular(10);
        $data['packages'] = $this->Package_model->get_packages(true);
        $data['total_courses_count'] = $this->db->count_all('courses');
        $data['total_teachers_count'] = $this->db->where('is_teacher', 1)->count_all_results('users');
        $data['total_students_count'] = $this->db->where('role', 'student')->count_all_results('users');

        $this->db->select('COUNT(*) as count');
        $this->db->from('certificates');
        $data['total_certificates'] = $this->db->get()->row()->count;

        $this->load->view('templates/header', $data);
        $this->load->view('home/index', $data);
        $this->load->view('templates/footer');
    }

    public function set_language($lang) {
        if (in_array($lang, array('id', 'en'))) {
            $this->session->set_userdata('site_lang', $lang);
        }
        redirect($this->input->server('HTTP_REFERER') ?: 'home');
    }

    public function capture_utm() {
        $utm_json = $this->input->post('utm_data');
        if ($utm_json) {
            $utm = json_decode($utm_json, true);
            if (is_array($utm)) {
                foreach ($utm as $key => $val) {
                    $this->session->set_userdata('utm_' . $key, $val);
                }
            }
        }
    }
}
