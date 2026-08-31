<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Base Controller — pusat kontrol akses bersama.
 *
 * Controller yang butuh sesi login mewarisi kelas ini. Gunanya: user yang
 * di-ban SETELAH login tidak bisa terus memakai sesi lamanya. Cek dilakukan
 * sekali per request terhadap status terkini di DB.
 */
class MY_Controller extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->_enforce_account_status();
    }

    /**
     * Hentikan sesi kalau akun sudah tidak aktif (banned/dihapus).
     */
    protected function _enforce_account_status() {
        if (!$this->session->userdata('logged_in')) {
            return;
        }

        $user_id = (int)$this->session->userdata('user_id');
        $user = null;
        if ($user_id > 0) {
            $this->load->model('User_model');
            $user = $this->User_model->get_user_by_id($user_id);
        }

        if ($user && $user->status === 'active') {
            return;
        }

        // Buang identitas sesi, lalu tulis flash SETELAH sesi bersih supaya
        // pesannya ikut terbawa ke halaman login.
        $this->session->unset_userdata(array(
            'user_id', 'name', 'email', 'role', 'is_teacher', 'is_mentor', 'logged_in'
        ));
        $this->session->set_flashdata('error', t('Akun tidak aktif.', 'Account is not active.'));
        redirect('auth/login');
    }
}
