<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$auth_kicker = t('Amankan Akun', 'Secure Account');
$auth_title = t('Buat Kata Sandi Baru 🛡️', 'Create a New Password 🛡️');
$auth_subtitle = t('Pastikan kata sandi baru Anda kuat dan mudah diingat.', 'Make sure your new password is strong and memorable.');
$auth_icon = 'fa-lock';
$auth_visual_title = t('Amankan Akunmu Kembali.', 'Secure Your Account Again.');
$auth_visual_sub = t('Gunakan kombinasi huruf, angka, dan simbol agar akunmu tetap aman.', 'Use a combination of letters, numbers, and symbols to keep your account safe.');
$auth_form_action = 'auth/reset_password/' . $token;
$auth_submit_text = t('Simpan Kata Sandi Baru', 'Save New Password');
$auth_submit_loading = t('Menyimpan…', 'Saving…');
$auth_google_text = '';
$auth_footer_text = t('Ingat kata sandi?', 'Remember your password?');
$auth_footer_link = t('Kembali ke Login', 'Back to Login');
$auth_footer_url = base_url('auth/login');

// Field form reset password
ob_start();
$err_pass  = form_error('password', '', '');
$err_cpass = form_error('confirm_password', '', '');
?>
<div class="bta-field">
    <label for="password"><?php echo t('Kata Sandi Baru', 'New Password'); ?></label>
    <div class="bta-input-wrap has-eye">
        <i class="fas fa-lock"></i>
        <input type="password" name="password" id="password" class="bta-input<?php echo $err_pass ? ' bta-invalid' : ''; ?>" placeholder="<?php echo t('Min. 6 karakter', 'Min. 6 characters'); ?>" autocomplete="new-password" minlength="6" required autofocus>
        <button type="button" class="bta-eye" tabindex="-1" aria-label="<?php echo t('Tampilkan kata sandi', 'Show password'); ?>"><i class="fas fa-eye"></i></button>
    </div>
    <?php if ($err_pass): ?>
        <div class="bta-err"><i class="fas fa-circle-exclamation"></i><?php echo $err_pass; ?></div>
    <?php endif; ?>
</div>
<div class="bta-field">
    <label for="confirm_password"><?php echo t('Konfirmasi Kata Sandi', 'Confirm Password'); ?></label>
    <div class="bta-input-wrap has-eye">
        <i class="fas fa-lock"></i>
        <input type="password" name="confirm_password" id="confirm_password" class="bta-input<?php echo $err_cpass ? ' bta-invalid' : ''; ?>" placeholder="••••••••" autocomplete="new-password" required>
        <button type="button" class="bta-eye" tabindex="-1" aria-label="<?php echo t('Tampilkan kata sandi', 'Show password'); ?>"><i class="fas fa-eye"></i></button>
    </div>
    <?php if ($err_cpass): ?>
        <div class="bta-err"><i class="fas fa-circle-exclamation"></i><?php echo $err_cpass; ?></div>
    <?php endif; ?>
</div>
<?php
$auth_form_fields = ob_get_clean();

include '_auth_layout.php';
?>
