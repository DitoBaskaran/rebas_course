<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'libraries/Api_Controller.php';

class Api_Reputations extends Api_Controller {
    
    /**
     * GET /api/users/:id/reputation
     * Get user reputation/rating
     */
    public function user_reputation($user_id) {
        $this->load->model('User_model');
        $user = $this->User_model->get_user_by_id($user_id);
        
        if (!$user) {
            $this->response_error('User not found', 404);
        }
        
        // Get ratings received
        $ratings = $this->db
            ->select('AVG(rating) as avg_rating, COUNT(*) as total_ratings')
            ->where('user_id', $user_id)
            ->get('mentor_user_ratings')
            ->row();
        
        // Get rating distribution
        $distribution = $this->db
            ->select('rating, COUNT(*) as count')
            ->where('user_id', $user_id)
            ->group_by('rating')
            ->get('mentor_user_ratings')
            ->result();
        
        $dist_array = [];
        foreach ($distribution as $row) {
            $dist_array[(int)$row->rating] = (int)$row->count;
        }
        
        $this->response([
            'user_id' => $user_id,
            'name' => $user->name,
            'avatar' => $user->avatar,
            'average_rating' => $ratings->avg_rating ? round($ratings->avg_rating, 2) : 0,
            'total_ratings' => (int)$ratings->total_ratings,
            'rating_distribution' => $dist_array
        ]);
    }
    
    /**
     * GET /api/users/:id/reviews
     * Get reviews/ratings received by user
     */
    public function user_reviews($user_id) {
        $this->load->model('User_model');
        $user = $this->User_model->get_user_by_id($user_id);
        
        if (!$user) {
            $this->response_error('User not found', 404);
        }
        
        $pagination = $this->get_pagination();
        
        $this->db->select('mentor_user_ratings.*, users.name as reviewer_name, users.avatar as reviewer_avatar');
        $this->db->from('mentor_user_ratings');
        $this->db->join('users', 'users.id = mentor_user_ratings.mentor_id');
        $this->db->where('mentor_user_ratings.user_id', $user_id);
        $this->db->order_by('mentor_user_ratings.created_at', 'DESC');
        $this->db->limit($pagination['per_page'], $pagination['offset']);
        $ratings = $this->db->get()->result();
        
        $total = $this->db->where('user_id', $user_id)->count_all_results('mentor_user_ratings');
        
        $formatted = array_map(function($rating) {
            return [
                'id' => $rating->id,
                'reviewer' => [
                    'id' => $rating->mentor_id,
                    'name' => $rating->reviewer_name,
                    'avatar' => $rating->reviewer_avatar
                ],
                'rating' => (int)$rating->rating,
                'comment' => $rating->comment,
                'created_at' => $rating->created_at
            ];
        }, $ratings);
        
        $this->response_paginated($formatted, $total, $pagination);
    }
}
