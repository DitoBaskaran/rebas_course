<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Learning_path_model extends CI_Model {

    public function get_all() {
        $this->db->select('learning_paths.*, categories.name as category_name, categories.icon as category_icon,
            (SELECT COUNT(*) FROM learning_path_contents WHERE path_id = learning_paths.id) as content_count');
        $this->db->from('learning_paths');
        $this->db->join('categories', 'categories.id = learning_paths.category_id', 'left');
        $this->db->order_by('learning_paths.created_at', 'DESC');
        return $this->db->get()->result();
    }

    public function get_by_id($id) {
        $this->db->select('learning_paths.*, categories.name as category_name');
        $this->db->from('learning_paths');
        $this->db->join('categories', 'categories.id = learning_paths.category_id', 'left');
        $this->db->where('learning_paths.id', $id);
        return $this->db->get()->row();
    }

    public function get_by_slug($slug) {
        $this->db->select('learning_paths.*, categories.name as category_name, categories.icon as category_icon');
        $this->db->from('learning_paths');
        $this->db->join('categories', 'categories.id = learning_paths.category_id', 'left');
        $this->db->where('learning_paths.slug', $slug);
        return $this->db->get()->row();
    }

    public function create($data) {
        $this->db->insert('learning_paths', $data);
        return $this->db->insert_id();
    }

    public function update($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('learning_paths', $data);
    }

    public function delete($id) {
        $this->db->where('id', $id)->delete('learning_paths');
    }

    public function get_contents($path_id) {
        $this->db->select('learning_path_contents.*, courses.title, courses.title_en, courses.content_type, courses.thumbnail, courses.skill_level, courses.duration_total, courses.slug,
            categories.name as category_name');
        $this->db->from('learning_path_contents');
        $this->db->join('courses', 'courses.id = learning_path_contents.course_id');
        $this->db->join('categories', 'categories.id = courses.category_id', 'left');
        $this->db->where('learning_path_contents.path_id', $path_id);
        $this->db->order_by('learning_path_contents.sort_order', 'ASC');
        $q = $this->db->get();
        return ($q !== FALSE) ? $q->result() : array();
    }

    public function add_content($data) {
        return $this->db->insert('learning_path_contents', $data);
    }

    public function remove_content($id) {
        $this->db->where('id', $id)->delete('learning_path_contents');
    }

    public function enroll_user($user_id, $path_id) {
        $data = array('user_id' => $user_id, 'path_id' => $path_id);
        $exists = $this->db->get_where('path_enrollments', $data)->num_rows() > 0;
        if ($exists) return true;
        return $this->db->insert('path_enrollments', $data);
    }

    public function get_user_enrollment($user_id, $path_id) {
        return $this->db->get_where('path_enrollments', array('user_id' => $user_id, 'path_id' => $path_id))->row();
    }

    public function get_user_paths($user_id) {
        $this->db->select('learning_paths.*, path_enrollments.progress_pct, path_enrollments.started_at, path_enrollments.completed_at,
            categories.name as category_name');
        $this->db->from('path_enrollments');
        $this->db->join('learning_paths', 'learning_paths.id = path_enrollments.path_id');
        $this->db->join('categories', 'categories.id = learning_paths.category_id', 'left');
        $this->db->where('path_enrollments.user_id', $user_id);
        return $this->db->get()->result();
    }

    public function update_progress($user_id, $path_id) {
        $contents = $this->get_contents($path_id);
        if (!$contents || !is_array($contents)) return;
        $total = count($contents);
        if ($total == 0) {
            // If no contents, progress is 100% by default, and completed_at should be set if not already.
            $enrollment = $this->get_user_enrollment($user_id, $path_id);
            if ($enrollment && $enrollment->progress_pct < 100) {
                $this->db->where('user_id', $user_id)->where('path_id', $path_id)
                         ->update('path_enrollments', ['progress_pct' => 100, 'completed_at' => date('Y-m-d H:i:s')]);
            }
            return 100;
        }
        $completed = 0;
        $CI =& get_instance();
        $CI->load->model('Course_model');
        foreach ($contents as $c) {
            if (!isset($c->course_id)) continue;
            $pct = $CI->Course_model->get_course_progress_percentage($user_id, $c->course_id);
            if ($pct >= 100) {
                $completed++;
            }
        }
        $pct = round(($completed / $total) * 100);

        $data = array('progress_pct' => $pct);
        
        // Check existing enrollment to handle started_at and completed_at
        $existing_enrollment = $this->get_user_enrollment($user_id, $path_id);

        if (!$existing_enrollment->started_at) {
            $data['started_at'] = date('Y-m-d H:i:s');
        }

        if ($pct >= 100) {
            if (!$existing_enrollment->completed_at) { // Only set if not already set
                $data['completed_at'] = date('Y-m-d H:i:s');
            }
        } else {
            $data['completed_at'] = NULL; // Reset if progress drops below 100
        }

        $this->db->where('user_id', $user_id)->where('path_id', $path_id)->update('path_enrollments', $data);
        return $pct;
    }
}
