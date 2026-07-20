<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'libraries/Api_Controller.php';

class Api_Categories extends Api_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('Category_model');
    }
    
    /**
     * GET /api/categories
     * List all categories
     */
    public function index() {
        $categories = $this->Category_model->get_all_categories();
        
        $formatted = array_map(function($cat) {
            return [
                'id' => $cat->id,
                'name' => $cat->name,
                'slug' => $cat->slug,
                'description' => $cat->description,
                'icon' => $cat->icon,
                'parent_id' => $cat->parent_id,
                'total_courses' => (int)$cat->total_courses
            ];
        }, $categories);
        
        $this->response($formatted);
    }
    
    /**
     * GET /api/categories/tree
     * Get categories as tree structure
     */
    public function tree() {
        $categories = $this->Category_model->get_all_categories();
        
        // Build tree
        $tree = $this->build_tree($categories);
        
        $this->response($tree);
    }
    
    /**
     * GET /api/categories/:id
     * Get category detail
     */
    public function show($id) {
        $category = $this->Category_model->get_category_by_id($id);
        
        if (!$category) {
            $this->response_error('Category not found', 404);
        }
        
        $data = [
            'id' => $category->id,
            'name' => $category->name,
            'slug' => $category->slug,
            'description' => $category->description,
            'icon' => $category->icon,
            'parent_id' => $category->parent_id,
            'total_courses' => (int)$category->total_courses
        ];
        
        $this->response($data);
    }
    
    private function build_tree($categories, $parent_id = null) {
        $tree = [];
        
        foreach ($categories as $cat) {
            if ($cat->parent_id == $parent_id) {
                $children = $this->build_tree($categories, $cat->id);
                $node = [
                    'id' => $cat->id,
                    'name' => $cat->name,
                    'slug' => $cat->slug,
                    'description' => $cat->description,
                    'icon' => $cat->icon,
                    'total_courses' => (int)$cat->total_courses,
                    'children' => $children
                ];
                $tree[] = $node;
            }
        }
        
        return $tree;
    }
}
