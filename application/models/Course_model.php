<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Course_model extends CI_Model {

    // --- Category Management ---
    public function get_categories($parent_id = null) {
        if ($parent_id !== null) {
            $this->db->where('parent_id', $parent_id);
        }
        $this->db->order_by('sort_order', 'ASC');
        return $this->db->get('categories')->result();
    }

    public function get_category_by_slug($slug) {
        return $this->db->get_where('categories', array('slug' => $slug))->row();
    }

    public function get_category_by_id($id) {
        return $this->db->get_where('categories', array('id' => $id))->row();
    }

    public function get_root_categories() {
        $this->db->where('parent_id IS NULL');
        $this->db->order_by('sort_order', 'ASC');
        return $this->db->get('categories')->result();
    }

    public function create_category($data) {
        return $this->db->insert('categories', $data);
    }

    public function update_category($id, $data) {
        return $this->db->where('id', $id)->update('categories', $data);
    }

    public function delete_category($id) {
        $this->db->where('parent_id', $id)->update('categories', array('parent_id' => null));
        return $this->db->where('id', $id)->delete('categories');
    }

    public function get_all_categories_tree() {
        $all = $this->db->order_by('sort_order', 'ASC')->get('categories')->result();
        $tree = array();
        $map = array();
        foreach ($all as $c) {
            $map[$c->id] = $c;
            $c->children = array();
        }
        foreach ($all as $c) {
            if ($c->parent_id && isset($map[$c->parent_id])) {
                $map[$c->parent_id]->children[] = $c;
            } else {
                $tree[] = $c;
            }
        }
        return $tree;
    }

    // --- Course Management ---
    public function get_courses($filters = array()) {
        $this->db->select('courses.*, categories.name as category_name, users.name as teacher_name');
        $this->db->from('courses');
        $this->db->join('categories', 'categories.id = courses.category_id', 'left');
        $this->db->join('users', 'users.id = courses.teacher_id');

        if (!empty($filters['skill_level'])) {
            $this->db->where('courses.skill_level', $filters['skill_level']);
        }
        if (!empty($filters['category_id'])) {
            $this->db->where('courses.category_id', $filters['category_id']);
        }
        if (!empty($filters['content_type'])) {
            $this->db->where('courses.content_type', $filters['content_type']);
        }
        if (!empty($filters['language'])) {
            $this->db->where('courses.language', $filters['language']);
        }
        if (!empty($filters['teacher_id'])) {
            $this->db->where('courses.teacher_id', $filters['teacher_id']);
        }
        if (isset($filters['featured'])) {
            $this->db->where('courses.featured', $filters['featured']);
        }
        if (!empty($filters['search'])) {
            $this->db->group_start();
            $this->db->like('courses.title', $filters['search']);
            $this->db->or_like('courses.description', $filters['search']);
            $this->db->group_end();
        }

        if (!isset($filters['status'])) {
            $this->db->where('courses.status', 'published');
        } elseif ($filters['status'] !== 'all') {
            $this->db->where('courses.status', $filters['status']);
        }
        $this->db->order_by('courses.created_at', 'DESC');
        return $this->db->get()->result();
    }

    public function count_all($filters = array()) {
        if (!empty($filters['skill_level'])) $this->db->where('skill_level', $filters['skill_level']);
        if (!empty($filters['category_id'])) $this->db->where('category_id', $filters['category_id']);
        if (!empty($filters['content_type'])) $this->db->where('content_type', $filters['content_type']);
        if (!empty($filters['status'])) $this->db->where('status', $filters['status']);
        return $this->db->count_all_results('courses');
    }

    public function get_course_by_id($id) {
        $this->db->select('courses.*, categories.name as category_name, categories.name_en as category_name_en, users.name as teacher_name, users.avatar as teacher_avatar');
        $this->db->from('courses');
        $this->db->join('categories', 'categories.id = courses.category_id', 'left');
        $this->db->join('users', 'users.id = courses.teacher_id');
        $this->db->where('courses.id', $id);
        return $this->db->get()->row();
    }

    public function get_course_by_slug($slug) {
        $this->db->select('courses.*, categories.name as category_name, categories.name_en as category_name_en, users.name as teacher_name, users.avatar as teacher_avatar');
        $this->db->from('courses');
        $this->db->join('categories', 'categories.id = courses.category_id', 'left');
        $this->db->join('users', 'users.id = courses.teacher_id');
        $this->db->where('courses.slug', $slug);
        return $this->db->get()->row();
    }

    public function create_course($data) {
        $this->db->insert('courses', $data);
        return $this->db->insert_id();
    }

    public function update_course($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('courses', $data);
    }

    public function delete_course($id) {
        $this->db->where('id', $id);
        return $this->db->delete('courses');
    }

    public function get_featured_courses($limit = 6) {
        $this->db->select('courses.*, categories.name as category_name, users.name as teacher_name');
        $this->db->from('courses');
        $this->db->join('categories', 'categories.id = courses.category_id', 'left');
        $this->db->join('users', 'users.id = courses.teacher_id');
        $this->db->where('courses.featured', 1);
        $this->db->where('courses.status', 'published');
        $this->db->limit($limit);
        $this->db->order_by('courses.created_at', 'DESC');
        return $this->db->get()->result();
    }

    // --- Tags ---
    public function get_tags() {
        return $this->db->get('tags')->result();
    }

    public function get_content_tags($content_id) {
        $this->db->select('tags.*');
        $this->db->from('content_tags');
        $this->db->join('tags', 'tags.id = content_tags.tag_id');
        $this->db->where('content_tags.content_id', $content_id);
        return $this->db->get()->result();
    }

    public function set_content_tags($content_id, $tag_ids) {
        $this->db->where('content_id', $content_id)->delete('content_tags');
        if (!empty($tag_ids)) {
            foreach ($tag_ids as $tag_id) {
                $this->db->insert('content_tags', array('content_id' => $content_id, 'tag_id' => $tag_id));
            }
        }
    }

    // --- Lesson Management ---
    public function get_lessons_by_course($course_id) {
        $this->db->where('course_id', $course_id);
        $this->db->order_by('sort_order', 'ASC');
        return $this->db->get('lessons')->result();
    }

    public function get_lesson_by_id($id) {
        return $this->db->get_where('lessons', array('id' => $id))->row();
    }

    public function create_lesson($data) {
        return $this->db->insert('lessons', $data);
    }

    public function update_lesson($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('lessons', $data);
    }

    public function delete_lesson($id) {
        $this->db->where('id', $id);
        return $this->db->delete('lessons');
    }

    // --- Enrollment and Progress Management ---
    public function check_enrollment($user_id, $course_id) {
        $query = $this->db->get_where('enrollments', array('user_id' => $user_id, 'course_id' => $course_id));
        return $query->num_rows() > 0;
    }

    public function get_enrollment_date($user_id, $course_id) {
        $row = $this->db->get_where('enrollments', array('user_id' => $user_id, 'course_id' => $course_id))->row();
        return $row ? $row->enrolled_at : null;
    }

    public function enroll_user($user_id, $course_id) {
        $data = array(
            'user_id' => $user_id,
            'course_id' => $course_id
        );
        $inserted = $this->db->insert('enrollments', $data);

        if ($inserted) {
            $ci =& get_instance();
            $ci->load->helper('notification');
            $user = $ci->User_model->get_user_by_id($user_id);
            $course = $this->get_course_by_id($course_id);
            if ($user && $course) {
                notify_enrollment($user, $course);
            }
        }

        return $inserted;
    }

    public function get_user_enrolled_courses($user_id) {
        $this->db->select('courses.*, categories.name as category_name, users.name as teacher_name');
        $this->db->from('enrollments');
        $this->db->join('courses', 'courses.id = enrollments.course_id');
        $this->db->join('categories', 'categories.id = courses.category_id', 'left');
        $this->db->join('users', 'users.id = courses.teacher_id');
        $this->db->where('enrollments.user_id', $user_id);
        return $this->db->get()->result();
    }

    public function get_enrolled_students($course_id) {
        $this->db->select('users.id, users.name, users.email, users.avatar, enrollments.enrolled_at');
        $this->db->from('enrollments');
        $this->db->join('users', 'users.id = enrollments.user_id');
        $this->db->where('enrollments.course_id', $course_id);
        return $this->db->get()->result();
    }

    public function mark_lesson_completed($user_id, $lesson_id) {
        $data = array(
            'user_id' => $user_id,
            'lesson_id' => $lesson_id,
            'status' => 'completed'
        );
        $exists = $this->db->get_where('progress', array('user_id' => $user_id, 'lesson_id' => $lesson_id))->num_rows() > 0;
        if ($exists) {
            return TRUE;
        }
        return $this->db->insert('progress', $data);
    }

    public function get_completed_lessons($user_id, $course_id) {
        $this->db->select('progress.lesson_id');
        $this->db->from('progress');
        $this->db->join('lessons', 'lessons.id = progress.lesson_id');
        $this->db->where('progress.user_id', $user_id);
        $this->db->where('lessons.course_id', $course_id);
        $this->db->where('progress.status', 'completed');
        $result = $this->db->get()->result_array();
        return array_column($result, 'lesson_id');
    }

    public function get_course_progress_percentage($user_id, $course_id) {
        $total_lessons = $this->db->where('course_id', $course_id)->from('lessons')->count_all_results();
        if ($total_lessons == 0) return 100;

        $completed = $this->db->join('lessons', 'lessons.id = progress.lesson_id')
                              ->where('progress.user_id', $user_id)
                              ->where('lessons.course_id', $course_id)
                              ->where('progress.status', 'completed')
                              ->from('progress')
                              ->count_all_results();

        return round(($completed / $total_lessons) * 100);
    }
}
