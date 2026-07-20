<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'libraries/Api_Controller.php';

class Api_Tags extends Api_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('Tag_model');
    }
    
    /**
     * GET /api/tags
     * List all tags
     */
    public function index() {
        $tags = $this->Tag_model->get_all_tags();
        
        $formatted = array_map(function($tag) {
            return [
                'id' => $tag->id,
                'name' => $tag->name,
                'slug' => $tag->slug
            ];
        }, $tags);
        
        $this->response($formatted);
    }
    
    /**
     * GET /api/tags/:id
     * Get tag detail
     */
    public function show($id) {
        $tag = $this->Tag_model->get_tag_by_id($id);
        
        if (!$tag) {
            $this->response_error('Tag not found', 404);
        }
        
        $data = [
            'id' => $tag->id,
            'name' => $tag->name,
            'slug' => $tag->slug
        ];
        
        $this->response($data);
    }
}
