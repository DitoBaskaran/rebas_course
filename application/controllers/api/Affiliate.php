<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'libraries/Api_Controller.php';

class Api_Affiliate extends Api_Controller {
    
    /**
     * GET /api/affiliate/stats
     */
    public function stats() {
        $this->require_auth();
        
        $affiliate = $this->db->get_where('affiliates', ['user_id' => $this->user_id])->row();
        
        if (!$affiliate) {
            // Create affiliate profile if not exists
            $code = substr(md5($this->user_id . time()), 0, 8);
            $this->db->insert('affiliates', [
                'user_id' => $this->user_id,
                'referral_code' => strtoupper($code),
                'total_commission' => 0,
                'paid_commission' => 0,
                'created_at' => date('Y-m-d H:i:s')
            ]);
            
            $affiliate = $this->db->get_where('affiliates', ['user_id' => $this->user_id])->row();
        }
        
        // Count clicks
        $clicks = $this->db->where('affiliate_id', $affiliate->id)->count_all_results('affiliate_clicks');
        
        // Count conversions
        $conversions = $this->db->where('affiliate_id', $affiliate->id)
            ->where('status', 'approved')
            ->count_all_results('affiliate_conversions');
        
        $this->response([
            'referral_code' => $affiliate->referral_code,
            'referral_link' => base_url('ref/' . $affiliate->referral_code),
            'total_clicks' => (int)$clicks,
            'total_conversions' => (int)$conversions,
            'total_commission' => (int)$affiliate->total_commission,
            'paid_commission' => (int)$affiliate->paid_commission,
            'pending_commission' => (int)($affiliate->total_commission - $affiliate->paid_commission)
        ]);
    }
}
