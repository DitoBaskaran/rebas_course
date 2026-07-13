<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Coupon_model extends CI_Model {

    public function get_coupon_by_code($code) {
        return $this->db->get_where('coupons', array('code' => strtoupper($code)))->row();
    }

    public function get_coupon_by_id($id) {
        return $this->db->get_where('coupons', array('id' => $id))->row();
    }

    public function validate_coupon($code, $amount) {
        $coupon = $this->get_coupon_by_code($code);
        if (!$coupon) {
            return array('valid' => false, 'message' => t('Kupon tidak ditemukan.', 'Coupon not found.'));
        }
        if (!$coupon->is_active) {
            return array('valid' => false, 'message' => t('Kupon sudah tidak aktif.', 'Coupon is inactive.'));
        }
        if ($coupon->max_uses !== null && $coupon->used_count >= $coupon->max_uses) {
            return array('valid' => false, 'message' => t('Kupon sudah habis masa pemakaian.', 'Coupon usage limit reached.'));
        }
        if ($coupon->expired_at && strtotime($coupon->expired_at) < time()) {
            return array('valid' => false, 'message' => t('Kupon sudah kedaluwarsa.', 'Coupon has expired.'));
        }
        if ($coupon->min_purchase > 0 && $amount < $coupon->min_purchase) {
            return array('valid' => false, 'message' => t('Minimal pembelian Rp ', 'Minimum purchase Rp ') . number_format($coupon->min_purchase, 0, ',', '.'));
        }
        return array('valid' => true, 'coupon' => $coupon);
    }

    public function calculate_discount($coupon, $amount) {
        if ($coupon->discount_type === 'percent') {
            $discount = ($amount * $coupon->discount_value) / 100;
            return array(
                'discount' => (int)$discount,
                'total' => (int)($amount - $discount),
                'label' => $coupon->discount_value . '%'
            );
        } else {
            $discount = min($coupon->discount_value, $amount);
            return array(
                'discount' => (int)$discount,
                'total' => (int)($amount - $discount),
                'label' => 'Rp ' . number_format($coupon->discount_value, 0, ',', '.')
            );
        }
    }

    public function increment_usage($coupon_id) {
        $this->db->where('id', $coupon_id)
            ->set('used_count', 'used_count + 1', FALSE)
            ->update('coupons');
    }

    public function get_all() {
        return $this->db->order_by('created_at', 'DESC')->get('coupons')->result();
    }

    public function create($data) {
        $this->db->insert('coupons', $data);
        return $this->db->insert_id();
    }

    public function update($id, $data) {
        return $this->db->where('id', $id)->update('coupons', $data);
    }

    public function delete($id) {
        return $this->db->where('id', $id)->delete('coupons');
    }
}
