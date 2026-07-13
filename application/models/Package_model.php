<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Package_model extends CI_Model {

    public function get_packages($active_only = true) {
        if ($active_only) {
            $this->db->where('is_active', 1);
        }
        $this->db->order_by('sort_order', 'ASC');
        return $this->db->get('packages')->result();
    }

    public function get_package_by_id($id) {
        return $this->db->get_where('packages', array('id' => $id))->row();
    }

    public function get_package_by_slug($slug) {
        return $this->db->get_where('packages', array('slug' => $slug))->row();
    }

    public function create_package($data) {
        $this->db->insert('packages', $data);
        return $this->db->insert_id();
    }

    public function update_package($id, $data) {
        return $this->db->where('id', $id)->update('packages', $data);
    }

    public function delete_package($id) {
        return $this->db->where('id', $id)->delete('packages');
    }

    public function get_package_items($package_id) {
        return $this->db->get_where('package_items', array('package_id' => $package_id))->result();
    }

    public function set_package_items($package_id, $items) {
        $this->db->where('package_id', $package_id)->delete('package_items');
        if (!empty($items)) {
            foreach ($items as $item) {
                $this->db->insert('package_items', array(
                    'package_id' => $package_id,
                    'item_type' => $item['item_type'],
                    'item_id' => $item['item_id']
                ));
            }
        }
    }

    public function calculate_6mo_price($package_id) {
        $pkg = $this->get_package_by_id($package_id);
        if (!$pkg || $pkg->discount_6mo <= 0) return null;
        $full_price = $pkg->price * 6;
        $discounted = $full_price * (1 - ($pkg->discount_6mo / 100));
        return array(
            'full_price' => (int)$full_price,
            'discounted' => (int)$discounted,
            'discount_pct' => $pkg->discount_6mo,
            'savings' => (int)($full_price - $discounted),
        );
    }

    public function has_access_to_course($package_id, $course_id) {
        $course = $this->db->get_where('courses', array('id' => $course_id))->row();
        if (!$course) return false;

        $pkg = $this->get_package_by_id($package_id);
        if (!$pkg) return false;

        if ($pkg->access_scope === 'all') {
            return true;
        }

        $items = $this->get_package_items($package_id);
        foreach ($items as $item) {
            if ($item->item_type === 'course' && $item->item_id == $course_id) {
                return true;
            }
            if ($item->item_type === 'category') {
                if ($course->category_id == $item->item_id) {
                    return true;
                }
                $children = $this->db->get_where('categories', array('parent_id' => $item->item_id))->result();
                foreach ($children as $child) {
                    if ($course->category_id == $child->id) {
                        return true;
                    }
                }
            }
        }
        return false;
    }
}
