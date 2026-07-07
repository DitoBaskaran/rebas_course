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
        $this->db->select('learning_path_contents.*, courses.title, courses.title_en, courses.content_type, courses.thumbnail, courses.skill_level, courses.duration_total,
            categories.name as category_name');
        $this->db->from('learning_path_contents');
        $this->db->join('courses', 'courses.id = learning_path_contents.course_id');
        $this->db->join('categories', 'categories.id = courses.category_id', 'left');
        $this->db->where('learning_path_contents.path_id', $path_id);
        $this->db->order_by('learning_path_contents.sort_order', 'ASC');
        return $this->db->get()->result();
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
        $total = count($contents);
        if ($total == 0) return;
        $completed = 0;
        foreach ($contents as $c) {
            if ($this->db->get_where('enrollments', array('user_id' => $user_id, 'course_id' => $c->course_id))->num_rows() > 0) {
                $completed++;
            }
        }
        $pct = round(($completed / $total) * 100);
        $data = array('progress_pct' => $pct);
        if ($pct >= 100) {
            $data['completed_at'] = date('Y-m-d H:i:s');
        }
        $this->db->where('user_id', $user_id)->where('path_id', $path_id)->update('path_enrollments', $data);
    }
}
