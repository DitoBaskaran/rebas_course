<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Heartbeat API for real-time minute consumption tracking.
 * Called via AJAX from the lesson player page.
 */
class Heartbeat extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('User_minute_balance_model');
        $this->load->helper('time');
    }

    private function _json($data, $code = 200) {
        $this->output
            ->set_status_header($code)
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }

    /**
     * POST start: begin a consumption session for a lesson.
     * Expects: course_id, lesson_id
     */
    public function start() {
        if (!$this->session->userdata('logged_in')) {
            $this->_json(array('status' => 'error', 'message' => 'Not logged in'), 401);
            return;
        }

        $user_id = $this->session->userdata('user_id');
        $course_id = (int)$this->input->post('course_id');
        $lesson_id = (int)$this->input->post('lesson_id');

        if (!$lesson_id) {
            $this->_json(array('status' => 'error', 'message' => 'Missing lesson_id'), 400);
            return;
        }

        $session = $this->User_minute_balance_model->create_session($user_id, $course_id, $lesson_id);
        $balance = $this->User_minute_balance_model->get_balance($user_id);

        $this->_json(array(
            'status' => 'ok',
            'session_id' => $session['id'],
            'session_token' => $session['token'],
            'remaining_seconds' => (int)$balance->balance_seconds
        ));
    }

    /**
     * POST tick: heartbeat signal to keep session alive and consume time.
     * Expects: session_id, session_token
     */
    public function tick() {
        if (!$this->session->userdata('logged_in')) {
            $this->_json(array('status' => 'error', 'message' => 'Not logged in'), 401);
            return;
        }

        $session_id = (int)$this->input->post('session_id');
        $session_token = $this->input->post('session_token');

        if (!$session_id || !$session_token) {
            $this->_json(array('status' => 'error', 'message' => 'Missing session data'), 400);
            return;
        }

        $result = $this->User_minute_balance_model->heartbeat_session($session_id, $session_token);

        if ($result === null) {
            $this->_json(array('status' => 'error', 'message' => 'Invalid or inactive session'), 404);
            return;
        }

        if (isset($result['ended']) && $result['ended']) {
            $this->_json(array(
                'status' => 'ended',
                'message' => t('Waktu Anda habis.', 'Your time has run out.'),
                'remaining_seconds' => 0
            ));
            return;
        }

        $this->_json(array(
            'status' => 'ok',
            'consumed' => (int)($result['consumed'] ?? 0),
            'remaining_seconds' => (int)($result['remaining'] ?? 0)
        ));
    }

    /**
     * POST end: finalize the session.
     * Expects: session_id, session_token
     */
    public function end() {
        if (!$this->session->userdata('logged_in')) {
            $this->_json(array('status' => 'error', 'message' => 'Not logged in'), 401);
            return;
        }

        $session_id = (int)$this->input->post('session_id');
        $session_token = $this->input->post('session_token');

        $ok = $this->User_minute_balance_model->end_session($session_id, $session_token);

        $this->_json(array('status' => $ok ? 'ok' : 'error'));
    }

    /**
     * GET cleanup: close stale sessions (call via cron job).
     * Can be called without authentication for cron purposes.
     */
    public function cleanup() {
        $stale_count = $this->User_minute_balance_model->close_stale_sessions(60);
        $this->_json(array('status' => 'ok', 'closed_sessions' => $stale_count));
    }

    /**
     * GET balance: get remaining balance for the current user.
     */
    public function balance() {
        if (!$this->session->userdata('logged_in')) {
            $this->_json(array('status' => 'error', 'message' => 'Not logged in'), 401);
            return;
        }

        $balance = $this->User_minute_balance_model->get_balance($this->session->userdata('user_id'));
        $this->_json(array(
            'status' => 'ok',
            'remaining_seconds' => (int)($balance->balance_seconds ?? 0)
        ));
    }
}
