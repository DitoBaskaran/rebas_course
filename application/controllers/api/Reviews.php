<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'libraries/Api_Controller.php';

class Api_Reviews extends Api_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('Review_model');
        $this->load->model('Course_enrollment_model');
    }
    
    /**
     * GET /api/courses/:id/reviews
     */
    public function index($course_id) {
        $reviews = $this->Review_model->get_reviews($course_id);
        
        $formatted = array_map(function($review) {
            return [
                'id' => $review->id,
                'user_id' => $review->user_id,
                'user_name' => $review->user_name,
                'user_avatar' => $review->avatar,
                'rating' => (int)$review->rating,
                'comment' => $review->comment,
                'created_at' => $review->created_at
            ];
        }, $reviews);
        
        $this->response($formatted);
    }
    
    /**
     * POST /api/courses/:id/reviews
     */
    public function create($course_id) {
        $this->require_auth();
        
        $enrollment = $this->Course_enrollment_model->get_enrollment($this->user_id, $course_id);
        if (!$enrollment) {
            $this->response_error('Must be enrolled to review', 403);
        }
        
        $input = $this->get_json_input();
        $rating = (int)($input['rating'] ?? 0);
        $comment = $input['comment'] ?? '';
        
        if ($rating < 1 || $rating > 5) {
            $this->response_error('Rating must be between 1 and 5', 422);
        }
        
        $existing = $this->Review_model->get_user_review($this->user_id, $course_id);
        
        if ($existing) {
            $this->Review_model->update_review($existing->id, [
                'rating' => $rating,
                'comment' => $comment,
                'updated_at' => date('Y-m-d H:i:s')
            ]);
            $this->response(null, 200, 'Review updated');
        }
        
        $review_id = $this->Review_model->create_review([
            'user_id' => $this->user_id,
            'course_id' => $course_id,
            'rating' => $rating,
            'comment' => $comment,
            'created_at' => date('Y-m-d H:i:s')
        ]);
        
        if ($review_id) {
            $this->response(['review_id' => $review_id], 201, 'Review created');
        }
        
        $this->response_error('Failed to create review', 500);
    }
    
    /**
     * GET /api/courses/:id/rating-summary
     */
    public function summary($course_id) {
        $avg = $this->Review_model->get_average_rating($course_id);
        $total = $this->Review_model->get_review_count($course_id);
        $distribution = $this->Review_model->get_rating_distribution($course_id);
        
        $this->response([
            'average' => $avg,
            'total' => $total,
            'distribution' => $distribution
        ]);
    }
}
