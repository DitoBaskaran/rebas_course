<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sitemap extends CI_Controller {

    public function index() {
        $this->load->model('Course_model');
        $this->load->model('Seminar_model');
        $this->load->model('Setting_model');

        $data['courses'] = $this->Course_model->get_courses(array('status' => 'published'));
        $data['seminars'] = $this->Seminar_model->get_upcoming();
        $data['categories'] = $this->Course_model->get_categories();

        $this->output->set_content_type('application/xml');
        $this->load->view('sitemap', $data);
    }
}
