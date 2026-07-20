<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'libraries/Api_Controller.php';

class Api_Subscriptions extends Api_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('Package_model');
        $this->load->model('User_subscription_model');
    }
    
    /**
     * GET /api/packages
     */
    public function packages() {
        $packages = $this->Package_model->get_all_packages();
        
        $formatted = array_map(function($pkg) {
            return [
                'id' => $pkg->id,
                'name' => $pkg->name,
                'description' => $pkg->description,
                'price' => (float)$pkg->price,
                'duration_days' => (int)$pkg->duration_days,
                'features' => $pkg->features ? json_decode($pkg->features, true) : [],
                'is_active' => (bool)$pkg->is_active
            ];
        }, $packages);
        
        $this->response($formatted);
    }
    
    /**
     * GET /api/subscriptions
     */
    public function index() {
        $this->require_auth();
        
        $subscriptions = $this->User_subscription_model->get_user_subscriptions($this->user_id);
        
        $formatted = array_map(function($sub) {
            return [
                'id' => $sub->id,
                'package' => [
                    'id' => $sub->package_id,
                    'name' => $sub->package_name
                ],
                'status' => $sub->status,
                'started_at' => $sub->started_at,
                'expires_at' => $sub->expires_at,
                'is_active' => $sub->status === 'active' && strtotime($sub->expires_at) > time()
            ];
        }, $subscriptions);
        
        $this->response($formatted);
    }
    
    /**
     * GET /api/subscriptions/active
     */
    public function active() {
        $this->require_auth();
        
        $active = $this->User_subscription_model->get_active_subscription($this->user_id);
        
        if (!$active) {
            $this->response(['has_active' => false, 'subscription' => null]);
        }
        
        $this->response([
            'has_active' => true,
            'subscription' => [
                'id' => $active->id,
                'package' => [
                    'id' => $active->package_id,
                    'name' => $active->package_name
                ],
                'started_at' => $active->started_at,
                'expires_at' => $active->expires_at
            ]
        ]);
    }
    
    /**
     * POST /api/subscriptions/buy/:package_id
     */
    public function buy($package_id) {
        $this->require_auth();
        
        $package = $this->Package_model->get_package_by_id($package_id);
        
        if (!$package) {
            $this->response_error('Package not found', 404);
        }
        
        if (!$package->is_active) {
            $this->response_error('Package is not available', 400);
        }
        
        // Create subscription
        $sub_data = [
            'user_id' => $this->user_id,
            'package_id' => $package_id,
            'status' => 'active',
            'started_at' => date('Y-m-d H:i:s'),
            'expires_at' => date('Y-m-d H:i:s', strtotime('+' . $package->duration_days . ' days')),
            'created_at' => date('Y-m-d H:i:s')
        ];
        
        $sub_id = $this->User_subscription_model->create_subscription($sub_data);
        
        if ($sub_id) {
            $this->response(['subscription_id' => $sub_id], 201, 'Subscription activated');
        }
        
        $this->response_error('Subscription failed', 500);
    }
}
