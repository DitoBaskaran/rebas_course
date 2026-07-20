<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'libraries/Api_Controller.php';

class Api_Gamification extends Api_Controller {
    
    /**
     * GET /api/users/me/points
     */
    public function points() {
        $this->require_auth();
        
        $points = $this->db->get_where('user_points', ['user_id' => $this->user_id])->row();
        
        $this->response([
            'total_points' => $points ? (int)$points->points : 0,
            'current_level' => $points ? (int)$points->level : 1,
            'points_to_next_level' => $this->calculate_points_to_next_level($points ? $points->level : 1)
        ]);
    }
    
    /**
     * GET /api/badges
     */
    public function badges() {
        $badges = $this->db->get('badges')->result();
        
        $formatted = array_map(function($badge) {
            return [
                'id' => $badge->id,
                'name' => $badge->name,
                'description' => $badge->description,
                'icon' => $badge->icon,
                'criteria' => $badge->criteria,
                'criteria_value' => (int)$badge->criteria_value
            ];
        }, $badges);
        
        $this->response($formatted);
    }
    
    /**
     * GET /api/users/me/badges
     */
    public function user_badges() {
        $this->require_auth();
        
        $badges = $this->db
            ->select('badges.*, user_badges.earned_at')
            ->from('user_badges')
            ->join('badges', 'badges.id = user_badges.badge_id')
            ->where('user_badges.user_id', $this->user_id)
            ->order_by('user_badges.earned_at', 'DESC')
            ->get()
            ->result();
        
        $formatted = array_map(function($badge) {
            return [
                'id' => $badge->id,
                'name' => $badge->name,
                'description' => $badge->description,
                'icon' => $badge->icon,
                'earned_at' => $badge->earned_at
            ];
        }, $badges);
        
        $this->response($formatted);
    }
    
    /**
     * GET /api/users/me/point-history
     */
    public function point_history() {
        $this->require_auth();
        
        $pagination = $this->get_pagination();
        
        $this->db->where('user_id', $this->user_id);
        $this->db->order_by('created_at', 'DESC');
        $this->db->limit($pagination['per_page'], $pagination['offset']);
        $transactions = $this->db->get('point_transactions')->result();
        
        $total = $this->db->where('user_id', $this->user_id)->count_all_results('point_transactions');
        
        $formatted = array_map(function($tx) {
            return [
                'id' => $tx->id,
                'points' => (int)$tx->points,
                'source' => $tx->source,
                'reference_id' => $tx->reference_id,
                'created_at' => $tx->created_at
            ];
        }, $transactions);
        
        $this->response_paginated($formatted, $total, $pagination);
    }
    
    private function calculate_points_to_next_level($current_level) {
        // Level N requires N^2 * 100 points
        $next_level = $current_level + 1;
        return ($next_level * $next_level * 100) - ($current_level * $current_level * 100);
    }
}
