<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('User_model');
    }

    public function login() {
        if ($this->session->userdata('logged_in')) {
            redirect('dashboard');
        }

        // Honeypot check (anti-spam)
        if ($this->input->post('website_url') !== null && $this->input->post('website_url') !== '') {
            $this->session->set_flashdata('error', 'Invalid request.');
            redirect('auth/login');
        }

        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'required');

        if ($this->form_validation->run() === FALSE) {
            $this->load->view('templates/header', array('title' => t('Login - REBAS COURSE', 'Login - REBAS COURSE')));
            $this->load->view('auth/login');
            $this->load->view('templates/footer');
        } else {
            $user = $this->User_model->login($this->input->post('email'), $this->input->post('password'));

            if ($user) {
                $session_data = array(
                    'user_id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'role' => $user->role,
                    'logged_in' => TRUE
                );
                $this->session->set_userdata($session_data);

                // Set language preference
                if (!empty($user->language)) {
                    $this->session->set_userdata('site_lang', $user->language);
                }

                $this->session->set_flashdata('success', t('Selamat datang kembali, ', 'Welcome back, ') . $user->name);

                if (in_array($user->role, ['admin', 'teacher'])) {
                    redirect('admin/dashboard');
                } else {
                    redirect('dashboard');
                }
            } else {
                $this->session->set_flashdata('error', t('Email atau password salah.', 'Invalid email or password.'));
                redirect('auth/login');
            }
        }
    }

    public function register() {
        if ($this->session->userdata('logged_in')) {
            redirect('dashboard');
        }

        // Honeypot check (anti-spam)
        if ($this->input->post('website_url') !== null && $this->input->post('website_url') !== '') {
            $this->session->set_flashdata('error', 'Invalid request.');
            redirect('auth/register');
        }

        $this->form_validation->set_rules('name', t('Nama', 'Name'), 'required|trim');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[users.email]');
        $this->form_validation->set_rules('password', t('Password', 'Password'), 'required|min_length[6]');
        $this->form_validation->set_rules('confirm_password', t('Konfirmasi Password', 'Confirm Password'), 'required|matches[password]');

        if ($this->form_validation->run() === FALSE) {
            $this->load->view('templates/header', array('title' => t('Daftar Akun - REBAS COURSE', 'Register - REBAS COURSE')));
            $this->load->view('auth/register');
            $this->load->view('templates/footer');
        } else {
            $data = array(
                'name' => $this->input->post('name'),
                'email' => $this->input->post('email'),
                'password' => $this->input->post('password'),
                'role' => 'student',
                'language' => current_lang()
            );

            if ($this->User_model->register($data)) {
                $user_id = $this->db->insert_id();

                // Save UTM source if exists
                if ($this->session->userdata('utm_source') || $this->session->userdata('utm_medium')) {
                    $this->db->insert('user_sources', array(
                        'user_id'      => $user_id,
                        'source'       => $this->session->userdata('utm_source') ?: '',
                        'medium'       => $this->session->userdata('utm_medium') ?: '',
                        'campaign'     => $this->session->userdata('utm_campaign') ?: '',
                        'referrer'     => $this->input->server('HTTP_REFERER') ?: '',
                        'landing_page' => $this->session->userdata('landing_page') ?: '',
                        'created_at'   => date('Y-m-d H:i:s'),
                    ));
                }

                // Track referral conversion
                $referred_by = $this->session->userdata('referred_by') ?: get_cookie('referred_by');
                if ($referred_by) {
                    $this->db->insert('affiliate_conversions', array(
                        'affiliate_id' => $referred_by,
                        'referred_user_id' => $user_id,
                        'transaction_id' => null,
                        'commission' => 0,
                        'status' => 'pending',
                    ));
                }

                $this->session->set_flashdata('success', t('Akun berhasil dibuat! Silakan login.', 'Account created! Please login.'));
                redirect('auth/login');
            } else {
                $this->session->set_flashdata('error', t('Gagal mendaftarkan akun.', 'Registration failed.'));
                redirect('auth/register');
            }
        }
    }

    // ===== PASSWORD RESET =====
    public function forgot_password() {
        if ($this->session->userdata('logged_in')) redirect('dashboard');

        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');

        if ($this->form_validation->run() === FALSE) {
            $data['title'] = t('Lupa Password - REBAS COURSE', 'Forgot Password - REBAS COURSE');
            $this->load->view('templates/header', $data);
            $this->load->view('auth/forgot_password');
            $this->load->view('templates/footer');
        } else {
            $email = $this->input->post('email');
            $user = $this->User_model->login($email, '');
            if ($user) {
                $token = bin2hex(random_bytes(32));
                $this->db->insert('password_resets', array(
                    'email' => $email,
                    'token' => $token,
                    'expired_at' => date('Y-m-d H:i:s', strtotime('+1 hour')),
                ));

                $this->load->helper('mail');
                $reset_link = base_url('auth/reset_password/' . $token);
                $body = 'Klik tombol di bawah untuk mereset password Anda. Link ini berlaku 1 jam.<br><br>Click the button below to reset your password. This link expires in 1 hour.';
                send_email($email, 'Reset Password - ' . setting('general_site_name', 'REBAS COURSE'),
                    email_template('Reset Password', $body, 'Reset Password', $reset_link));
            }

            $this->session->set_flashdata('success', t('Jika email terdaftar, tautan reset telah dikirim.', 'If email is registered, a reset link has been sent.'));
            redirect('auth/login');
        }
    }

    public function reset_password($token) {
        $reset = $this->db->where('token', $token)->where('expired_at >=', date('Y-m-d H:i:s'))->where('used_at IS NULL')->get('password_resets')->row();
        if (!$reset) show_404();

        $this->form_validation->set_rules('password', t('Password', 'Password'), 'required|min_length[6]');
        $this->form_validation->set_rules('confirm_password', t('Konfirmasi Password', 'Confirm Password'), 'required|matches[password]');

        if ($this->form_validation->run() === FALSE) {
            $data['title'] = t('Reset Password - REBAS COURSE', 'Reset Password - REBAS COURSE');
            $data['token'] = $token;
            $this->load->view('templates/header', $data);
            $this->load->view('auth/reset_password', $data);
            $this->load->view('templates/footer');
        } else {
            $this->db->where('email', $reset->email)->update('users', array(
                'password' => password_hash($this->input->post('password'), PASSWORD_BCRYPT),
            ));
            $this->db->where('id', $reset->id)->update('password_resets', array('used_at' => date('Y-m-d H:i:s')));
            $this->session->set_flashdata('success', t('Password berhasil direset. Silakan login.', 'Password reset successfully. Please login.'));
            redirect('auth/login');
        }
    }

    public function logout() {
        $this->session->sess_destroy();
        redirect('home');
    }
}
