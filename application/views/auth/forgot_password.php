<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$auth_kicker = t('Bantuan Akun', 'Account Help');
$auth_title = t('Lupa Kata Sandi? 🔑', 'Forgot Your Password? 🔑');
$auth_subtitle = t('Tenang, kami bantu pulihkan. Masukkan email terdaftar Anda.', 'No worries, we\'ll help you recover. Enter your registered email.');
$auth_icon = 'fa-key';
$auth_visual_title = t('Akses Kembali Akunmu.', 'Regain Your Access.');
$auth_visual_sub = t('Tautan reset akan dikirim ke email Anda dan berlaku selama 1 jam.', 'A reset link will be sent to your email and is valid for 1 hour.');
$auth_form_action = 'auth/forgot_password';
$auth_submit_text = t('Kirim Tautan Reset', 'Send Reset Link');
$auth_submit_loading = t('Mengirim tautan…', 'Sending link…');
$auth_google_text = '';
$auth_footer_text = t('Ingat kata sandi?', 'Remember your password?');
$auth_footer_link = t('Kembali ke Login', 'Back to Login');
$auth_footer_url = base_url('auth/login');

// Field form lupa password
ob_start();
$err_email = form_error('email', '', '');
?>
<div class="bta-field">
    <label for="email"><?php echo t('Email Terdaftar', 'Registered Email'); ?></label>
    <div class="bta-input-wrap">
        <i class="fas fa-envelope"></i>
        <input type="email" name="email" id="email" value="<?php echo set_value('email'); ?>" class="bta-input<?php echo $err_email ? ' bta-invalid' : ''; ?>" placeholder="nama@email.com" autocomplete="email" required autofocus>
    </div>
    <?php if ($err_email): ?>
        <div class="bta-err"><i class="fas fa-circle-exclamation"></i><?php echo $err_email; ?></div>
    <?php endif; ?>
</div>
<?php
$auth_form_fields = ob_get_clean();

include '_auth_layout.php';
?>
