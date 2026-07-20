<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'libraries/Api_Controller.php';

class Api_Wishlist extends Api_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('Wishlist_model');
    }
    
    /**
     * GET /api/wishlist
     */
    public function index() {
        $this->require_auth();
        
        $items = $this->Wishlist_model->get_user_wishlist($this->user_id);
        
        $formatted = array_map(function($item) {
            return [
                'id' => $item->id,
                'course' => [
                    'id' => $item->course_id,
                    'title' => $item->course_title,
                    'slug' => $item->course_slug,
                    'thumbnail' => $item->course_thumbnail,
                    'price' => (float)$item->course_price
                ],
                'created_at' => $item->created_at
            ];
        }, $items);
        
        $this->response($formatted);
    }
    
    /**
     * POST /api/wishlist/:course_id
     */
    public function toggle($course_id) {
        $this->require_auth();
        
        $existing = $this->Wishlist_model->get_item($this->user_id, $course_id);
        
        if ($existing) {
            $this->Wishlist_model->remove_item($existing->id);
            $this->response(null, 200, 'Removed from wishlist');
        } else {
            $this->Wishlist_model->add_item($this->user_id, $course_id);
            $this->response(null, 201, 'Added to wishlist');
        }
    }
    
    /**
     * GET /api/wishlist/check/:course_id
     */
    public function check($course_id) {
        $this->require_auth();
        
        $is_wishlisted = $this->Wishlist_model->check_item($this->user_id, $course_id);
        
        $this->response(['is_wishlisted' => $is_wishlisted]);
    }
}
