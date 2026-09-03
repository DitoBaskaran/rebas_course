<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('User_model');
        $this->load->helper('oauth');
        $this->load->helper('cookie');
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
            $data['google_login_url'] = google_login_url();
            $data['is_auth_page'] = true;
            $data['title'] = t('Login - BISATUNTAS', 'Login - BISATUNTAS');
            $this->load->view('templates/header', $data);
            $this->load->view('auth/login', $data);
            $this->load->view('templates/footer');
        } else {
            $user = $this->User_model->login($this->input->post('email'), $this->input->post('password'));

            if ($user) {
                // Reject banned accounts (konsisten dengan Google & API login)
                if ($user->status === 'banned') {
                    $this->session->set_flashdata('error', t('Akun tidak aktif.', 'Account is not active.'));
                    redirect('auth/login');
                }

                $session_data = array(
                    'user_id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'role' => $user->role,
                    'is_teacher' => $user->is_teacher,
                    'is_mentor' => $user->is_mentor,
                    'logged_in' => TRUE
                );
                $this->session->set_userdata($session_data);

                // Set language preference
                if (!empty($user->language)) {
                    $this->session->set_userdata('site_lang', $user->language);
                }

                $this->session->set_flashdata('success', t('Selamat datang kembali, ', 'Welcome back, ') . $user->name);

                if ($user->role === 'admin') {
                    redirect('admin/dashboard');
                } elseif ($user->is_teacher) {
                    redirect('teacher/dashboard');
                } elseif ($user->is_mentor) {
                    redirect('mentor');
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

        $this->load->helper('wa_notification');

        // ===== Langkah 2: verifikasi OTP (user sudah isi form langkah 1) =====
        $otp_phone = $this->session->userdata('reg_otp_phone');
        $otp_code  = $this->input->post('otp_code');
        if ($otp_phone && $otp_code) {
            $verify = wa_verify_register_otp($otp_phone, $otp_code);
            if ($verify['ok']) {
                $pending = $this->session->userdata('reg_otp_data');
                if (!$pending || empty($pending['email'])) {
                    $this->session->unset_userdata(array('reg_otp_phone', 'reg_otp_data'));
                    $this->session->set_flashdata('error', t('Sesi pendaftaran kedaluwarsa. Silakan daftar ulang.', 'Registration session expired. Please register again.'));
                    redirect('auth/register');
                }

                $new_user_data = array(
                    'name' => $pending['name'], 'email' => $pending['email'],
                    'password' => $pending['password'], 'phone' => $pending['phone'],
                    'role' => 'student', 'language' => current_lang(),
                );
                if (!$this->User_model->register($new_user_data)) {
                    $this->session->set_flashdata('error', t('Gagal mendaftarkan akun.', 'Registration failed.'));
                    redirect('auth/register');
                }
                $user_id = $this->db->insert_id();

                if ($this->session->userdata('utm_source') || $this->session->userdata('utm_medium')) {
                    $this->db->insert('user_sources', array(
                        'user_id' => $user_id,
                        'source' => $this->session->userdata('utm_source') ?: '',
                        'medium' => $this->session->userdata('utm_medium') ?: '',
                        'campaign' => $this->session->userdata('utm_campaign') ?: '',
                        'referrer' => $this->input->server('HTTP_REFERER') ?: '',
                        'landing_page' => $this->session->userdata('landing_page') ?: '',
                        'created_at' => date('Y-m-d H:i:s'),
                    ));
                }
                $referred_by = $this->session->userdata('referred_by') ?: get_cookie('referred_by');
                if ($referred_by) {
                    $this->db->insert('affiliate_conversions', array(
                        'affiliate_id' => $referred_by, 'referred_user_id' => $user_id,
                        'transaction_id' => null, 'commission' => 0, 'status' => 'pending',
                    ));
                }

                $this->load->helper('notification');
                $new_user = $this->User_model->get_user_by_id($user_id);
                notify_welcome($new_user);

                $this->session->set_userdata(array(
                    'user_id' => $user_id, 'name' => $new_user->name, 'email' => $new_user->email,
                    'role' => 'student', 'is_teacher' => 0, 'is_mentor' => 0, 'logged_in' => TRUE,
                ));
                $this->session->unset_userdata(array('reg_otp_phone', 'reg_otp_data'));
                $this->session->set_flashdata('success', t('Akun berhasil dibuat! Selamat datang.', 'Account created! Welcome.'));
                redirect('dashboard');
            } else {
                $msg = array(
                    'otp_wrong'        => t('Kode OTP salah.', 'Invalid OTP code.'),
                    'otp_invalid'      => t('Kode OTP tidak valid atau sudah kedaluwarsa.', 'OTP code is invalid or expired.'),
                    'otp_max_attempts' => t('Terlalu banyak percobaan. Kirim ulang OTP.', 'Too many attempts. Request a new OTP.'),
                );
                $this->session->set_flashdata('error', isset($msg[$verify['error']]) ? $msg[$verify['error']] : t('Verifikasi OTP gagal.', 'OTP verification failed.'));
                redirect('auth/verify-otp');
            }
        }

        // ===== Langkah 1: isi data pendaftaran =====
        $this->form_validation->set_rules('name', t('Nama', 'Name'), 'required|trim');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[users.email]');
        $this->form_validation->set_rules('phone', t('No. WhatsApp', 'Phone Number'), 'required|regex_match[/^[0-9+\-\s]+$/]');
        $this->form_validation->set_rules('password', t('Password', 'Password'), 'required|min_length[6]');
        $this->form_validation->set_rules('confirm_password', t('Konfirmasi Password', 'Confirm Password'), 'required|matches[password]');

        if ($this->form_validation->run() === FALSE) {
            $data['google_login_url'] = google_login_url();
            $data['wa_otp_enabled'] = wa_enabled();
            $data['is_auth_page'] = true;
            $data['title'] = t('Daftar Akun - BISATUNTAS', 'Register - BISATUNTAS');
            $this->load->view('templates/header', $data);
            $this->load->view('auth/register', $data);
            $this->load->view('templates/footer');
        } else {
            $name  = $this->input->post('name');
            $email = $this->input->post('email');
            $phone = $this->input->post('phone');
            $pass  = $this->input->post('password');

            if (wa_enabled()) {
                // Simpan data form di session, kirim OTP, lalu minta verifikasi
                $this->session->set_userdata('reg_otp_phone', $phone);
                $this->session->set_userdata('reg_otp_data', array(
                    'name' => $name, 'email' => $email, 'phone' => $phone, 'password' => $pass,
                ));
                $res = wa_send_register_otp($name, $email, $phone);
                if ($res['ok']) {
                    $this->session->set_flashdata('success', t('Kode OTP dikirim ke WhatsApp Anda.', 'OTP code sent to your WhatsApp.'));
                    redirect('auth/verify-otp');
                }
                $this->session->unset_userdata(array('reg_otp_phone', 'reg_otp_data'));
                $this->session->set_flashdata('error', t('Gagal mengirim OTP WhatsApp. Coba lagi atau hubungi admin.', 'Failed to send WhatsApp OTP. Try again or contact admin.'));
                redirect('auth/register');
            }

            // Fallback tanpa WA: langsung buat akun (perilaku lama)
            $data = array(
                'name' => $name,
                'email' => $email,
                'password' => $pass,
                'phone' => $phone,
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

                // Send welcome email
                $this->load->helper('notification');
                $new_user = $this->User_model->get_user_by_id($user_id);
                notify_welcome($new_user);

                $this->session->set_flashdata('success', t('Akun berhasil dibuat! Silakan login.', 'Account created! Please login.'));
                redirect('auth/login');
            } else {
                $this->session->set_flashdata('error', t('Gagal mendaftarkan akun.', 'Registration failed.'));
                redirect('auth/register');
            }
        }
    }

    // ===== VERIFIKASI OTP WHATSAPP (pendaftaran) =====
    public function verify_otp() {
        if ($this->session->userdata('logged_in')) {
            redirect('dashboard');
        }
        $phone = $this->session->userdata('reg_otp_phone');
        if (!$phone) {
            redirect('auth/register');
        }

        // Kirim ulang OTP
        if ($this->input->post('resend') === '1') {
            $pending = $this->session->userdata('reg_otp_data');
            $res = wa_send_register_otp($pending['name'] ?? '', $pending['email'] ?? '', $phone);
            if ($res['ok']) {
                $this->session->set_flashdata('success', t('Kode OTP baru telah dikirim.', 'A new OTP code has been sent.'));
            } else {
                $this->session->set_flashdata('error', t('Gagal mengirim ulang OTP. Coba lagi.', 'Failed to resend OTP. Try again.'));
            }
            redirect('auth/verify-otp');
        }

        $data['title'] = t('Verifikasi OTP - BISATUNTAS', 'Verify OTP - BISATUNTAS');
        $data['phone'] = $phone;
        $data['is_auth_page'] = true;
        $this->load->view('templates/header', $data);
        $this->load->view('auth/verify_otp', $data);
        $this->load->view('templates/footer');
    }

    // ===== GOOGLE OAUTH =====
    public function google() {
        $this->load->helper('oauth');
        $url = google_login_url();
        if (empty($url)) {
            $this->session->set_flashdata('error', t('Google Login tidak tersedia.', 'Google Login is not available.'));
            redirect('auth/login');
        }
        redirect($url);
    }

    public function google_callback() {
        $this->load->helper('oauth');

        $error = $this->input->get('error');
        if ($error) {
            $this->session->set_flashdata('error', t('Login Google dibatalkan.', 'Google Login cancelled.'));
            redirect('auth/login');
        }

        $code = $this->input->get('code');
        if (!$code) {
            $this->session->set_flashdata('error', t('Kode otorisasi tidak valid.', 'Invalid authorization code.'));
            redirect('auth/login');
        }

        $access_token = google_exchange_code($code);
        if (!$access_token) {
            $this->session->set_flashdata('error', t('Gagal mendapatkan token akses.', 'Failed to get access token.'));
            redirect('auth/login');
        }

        $google_user = google_get_user_info($access_token);
        if (!$google_user || empty($google_user['email'])) {
            $this->session->set_flashdata('error', t('Gagal mendapatkan data pengguna.', 'Failed to get user data.'));
            redirect('auth/login');
        }

        // Find existing user by email or google_id
        $user = $this->db->where('google_id', $google_user['google_id'])->or_where('email', $google_user['email'])->get('users')->row();

        if ($user) {
            // Update google_id if not linked yet
            if (empty($user->google_id) && !empty($google_user['google_id'])) {
                $this->db->where('id', $user->id)->update('users', array('google_id' => $google_user['google_id']));
            }
        } else {
            // Register new user via Google
            $random_pass = bin2hex(random_bytes(16));
            $insert_data = array(
                'name'       => $google_user['name'],
                'email'      => $google_user['email'],
                'password'   => password_hash($random_pass, PASSWORD_BCRYPT),
                'google_id'  => $google_user['google_id'],
                'role'       => 'student',
                'language'   => current_lang(),
            );
            $this->db->insert('users', $insert_data);
            $user = $this->db->where('email', $google_user['email'])->get('users')->row();

            // Send welcome notification
            $this->load->helper('notification');
            notify_welcome($user);
        }

        if (!$user || $user->status === 'banned') {
            $this->session->set_flashdata('error', t('Akun tidak aktif.', 'Account is not active.'));
            redirect('auth/login');
        }

        // Log in
        $session_data = array(
            'user_id' => $user->id,
            'name'    => $user->name,
            'email'   => $user->email,
            'role'    => $user->role,
            'is_teacher' => $user->is_teacher,
            'is_mentor' => $user->is_mentor,
            'logged_in' => TRUE,
        );
        $this->session->set_userdata($session_data);
        if (!empty($user->language)) {
            $this->session->set_userdata('site_lang', $user->language);
        }

        $this->session->set_flashdata('success', t('Selamat datang, ', 'Welcome, ') . $user->name);
        if ($user->role === 'admin') {
            redirect('admin/dashboard');
        } elseif ($user->is_teacher) {
            redirect('teacher/dashboard');
        } elseif ($user->is_mentor) {
            redirect('mentor');
        } else {
            redirect('dashboard');
        }
    }

    // ===== PASSWORD RESET =====
    public function forgot_password() {
        if ($this->session->userdata('logged_in')) redirect('dashboard');

        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');

        if ($this->form_validation->run() === FALSE) {
            $data['title'] = t('Lupa Password - BISATUNTAS', 'Forgot Password - BISATUNTAS');
            $data['is_auth_page'] = true;
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
                send_email($email, 'Reset Password - ' . setting('general_site_name', 'BISATUNTAS'),
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
            $data['title'] = t('Reset Password - BISATUNTAS', 'Reset Password - BISATUNTAS');
            $data['token'] = $token;
            $data['is_auth_page'] = true;
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
