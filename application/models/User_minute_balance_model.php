<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_minute_balance_model extends CI_Model {

    public function get_balance($user_id) {
        $row = $this->db->get_where('user_minute_balances', array('user_id' => $user_id))->row();
        if (!$row) {
            $this->db->insert('user_minute_balances', array(
                'user_id' => $user_id,
                'balance_seconds' => 0,
                'total_purchased_seconds' => 0,
                'total_used_seconds' => 0,
            ));
            $row = $this->db->get_where('user_minute_balances', array('user_id' => $user_id))->row();
        }
        return $row;
    }

    public function add_seconds($user_id, $seconds) {
        $balance = $this->get_balance($user_id);
        if ($balance) {
            $this->db->where('user_id', $user_id)
                ->set('balance_seconds', 'balance_seconds + ' . (int)$seconds, FALSE)
                ->set('total_purchased_seconds', 'total_purchased_seconds + ' . (int)$seconds, FALSE)
                ->update('user_minute_balances');
        } else {
            $this->db->insert('user_minute_balances', array(
                'user_id' => $user_id,
                'balance_seconds' => $seconds,
                'total_purchased_seconds' => $seconds,
                'total_used_seconds' => 0,
            ));
        }
    }

    public function deduct_seconds($user_id, $seconds) {
        $balance = $this->get_balance($user_id);
        if (!$balance || $balance->balance_seconds < $seconds) {
            return false;
        }
        $this->db->where('user_id', $user_id)
            ->set('balance_seconds', 'balance_seconds - ' . (int)$seconds, FALSE)
            ->set('total_used_seconds', 'total_used_seconds + ' . (int)$seconds, FALSE)
            ->update('user_minute_balances');
        return true;
    }

    public function create_session($user_id, $course_id, $lesson_id) {
        $token = bin2hex(random_bytes(16));
        $this->db->insert('minute_sessions', array(
            'user_id' => $user_id,
            'course_id' => $course_id,
            'lesson_id' => $lesson_id,
            'session_token' => $token,
            'started_at' => date('Y-m-d H:i:s'),
            'last_heartbeat' => date('Y-m-d H:i:s'),
            'seconds_consumed' => 0,
            'status' => 'active',
        ));
        $session_id = $this->db->insert_id();
        return array('id' => $session_id, 'token' => $token);
    }

    public function heartbeat_session($session_id, $session_token) {
        $session = $this->db->get_where('minute_sessions', array(
            'id' => $session_id,
            'session_token' => $session_token,
            'status' => 'active'
        ))->row();
        if (!$session) return null;

        $now = time();
        $last_hb = strtotime($session->last_heartbeat);
        $diff = $now - $last_hb;

        if ($diff < 1) return array('consumed' => 0, 'remaining' => null);
        if ($diff > 120) $diff = 0;

        $balance = $this->get_balance($session->user_id);
        if ($balance->balance_seconds < $diff) {
            $diff = $balance->balance_seconds;
        }

        if ($diff > 0) {
            $ok = $this->deduct_seconds($session->user_id, $diff);
            if (!$ok) {
                $this->db->where('id', $session_id)
                    ->update('minute_sessions', array('status' => 'ended', 'ended_at' => date('Y-m-d H:i:s')));
                return array('consumed' => 0, 'remaining' => 0, 'ended' => true);
            }

            $this->db->where('id', $session_id)
                ->set('seconds_consumed', 'seconds_consumed + ' . (int)$diff, FALSE)
                ->set('last_heartbeat', date('Y-m-d H:i:s'))
                ->update('minute_sessions');

            $this->log_consumption($session->user_id, $session->course_id, $session->lesson_id, $diff,
                $balance->balance_seconds, $balance->balance_seconds - $diff, $session_token);
        }

        $new_balance = $this->get_balance($session->user_id);
        return array('consumed' => $diff, 'remaining' => $new_balance->balance_seconds);
    }

    public function end_session($session_id, $session_token) {
        $session = $this->db->get_where('minute_sessions', array(
            'id' => $session_id,
            'session_token' => $session_token,
            'status' => 'active'
        ))->row();
        if (!$session) return false;

        $now = time();
        $last_hb = strtotime($session->last_heartbeat);
        $diff = $now - $last_hb;

        if ($diff > 1 && $diff <= 120) {
            $balance = $this->get_balance($session->user_id);
            if ($balance->balance_seconds < $diff) {
                $diff = $balance->balance_seconds;
            }
            if ($diff > 0) {
                $this->deduct_seconds($session->user_id, $diff);
                $this->db->where('id', $session_id)
                    ->set('seconds_consumed', 'seconds_consumed + ' . (int)$diff, FALSE)
                    ->update('minute_sessions');
                $new_balance = $this->get_balance($session->user_id);
                $this->log_consumption($session->user_id, $session->course_id, $session->lesson_id, $diff,
                    $balance->balance_seconds, $new_balance->balance_seconds, $session_token);
            }
        }

        $this->db->where('id', $session_id)
            ->update('minute_sessions', array('status' => 'ended', 'ended_at' => date('Y-m-d H:i:s')));
        return true;
    }

    public function close_stale_sessions($timeout_seconds = 60) {
        $cutoff = date('Y-m-d H:i:s', time() - $timeout_seconds);
        $stale = $this->db->get_where('minute_sessions', array('status' => 'active'))
            ->where('last_heartbeat <', $cutoff)->result();

        foreach ($stale as $s) {
            $this->end_session($s->id, $s->session_token);
        }
        return count($stale);
    }

    public function get_consumption_logs($user_id, $limit = 50) {
        $this->db->select('minute_consumption_logs.*, courses.title as course_title, lessons.title as lesson_title');
        $this->db->from('minute_consumption_logs');
        $this->db->join('courses', 'courses.id = minute_consumption_logs.course_id', 'left');
        $this->db->join('lessons', 'lessons.id = minute_consumption_logs.lesson_id', 'left');
        $this->db->where('minute_consumption_logs.user_id', $user_id);
        $this->db->order_by('minute_consumption_logs.created_at', 'DESC');
        $this->db->limit($limit);
        return $this->db->get()->result();
    }

    private function log_consumption($user_id, $course_id, $lesson_id, $seconds, $balance_before, $balance_after, $session_id) {
        $this->db->insert('minute_consumption_logs', array(
            'user_id' => $user_id,
            'course_id' => $course_id,
            'lesson_id' => $lesson_id,
            'seconds_consumed' => $seconds,
            'balance_before' => $balance_before,
            'balance_after' => $balance_after,
            'session_id' => $session_id,
            'created_at' => date('Y-m-d H:i:s'),
        ));
    }
}
