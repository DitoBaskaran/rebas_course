<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Search extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Course_model');
        $this->load->model('Tag_model');
    }

    public function index() {
        $q = $this->input->get('q');
        $content_type = $this->input->get('type');
        $skill_level = $this->input->get('level');
        $category_id = $this->input->get('category');
        $tag_id = $this->input->get('tag');
        $lang = $this->input->get('lang');

        $filters = array();
        if ($q) $filters['search'] = $q;
        if ($content_type) $filters['content_type'] = $content_type;
        if ($skill_level) $filters['skill_level'] = $skill_level;
        if ($category_id) $filters['category_id'] = $category_id;
        if ($lang) $filters['language'] = $lang;

        $results = $this->Course_model->get_courses($filters);

        // Filter by tag if specified
        if ($tag_id) {
            $filtered = array();
            foreach ($results as $r) {
                $tags = $this->Course_model->get_content_tags($r->id);
                $tag_ids = array_map(function($t) { return $t->id; }, $tags);
                if (in_array($tag_id, $tag_ids)) {
                    $filtered[] = $r;
                }
            }
            $results = $filtered;
        }

        $data['title'] = t('Pencarian', 'Search');
        $data['results'] = $results;
        $data['q'] = $q;
        $data['categories'] = $this->Course_model->get_root_categories();
        $data['tags'] = $this->Tag_model->get_popular(15);
        $data['content_types'] = array('course','workshop','bootcamp','ebook','project','article','video','podcast','template');
        $data['skill_levels'] = array('beginner','intermediate','advanced','all_levels');

        $this->load->view('templates/header', $data);
        $this->load->view('search/index', $data);
        $this->load->view('templates/footer');
    }
}
