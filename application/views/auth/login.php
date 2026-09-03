<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$auth_kicker = t('Selamat Datang Kembali', 'Welcome Back');
$auth_title = t('Masuk ke Akunmu 👋', 'Sign in to your account 👋');
$auth_subtitle = t('Lanjutkan perjalanan belajarmu bersama BISATUNTAS', 'Continue your learning journey with BISATUNTAS');
$auth_icon = 'fa-rocket';
$auth_visual_title = t('Belajar Tuntas, Sukses Pasti.', 'Learn Completely, Succeed Surely.');
$auth_visual_sub = t('Akses kelas, seminar, dan sesi mentoring dari mana saja — kapan saja.', 'Access classes, seminars, and mentoring sessions anywhere — anytime.');
$auth_form_action = 'auth/login';
$auth_submit_text = t('Masuk', 'Sign In');
$auth_submit_loading = t('Memeriksa akun…', 'Checking account…');
$auth_google_text = t('Lanjutkan dengan Google', 'Continue with Google');
$auth_footer_text = t('Belum punya akun?', "Don't have an account?");
$auth_footer_link = t('Daftar Gratis', 'Register Free');
$auth_footer_url = base_url('auth/register');

// Field form login (dengan error per-field dari form_validation)
ob_start();
$err_email = form_error('email', '', '');
$err_pass  = form_error('password', '', '');
?>
<div class="bta-field">
    <label for="email"><?php echo t('Email', 'Email'); ?></label>
    <div class="bta-input-wrap">
        <i class="fas fa-envelope"></i>
        <input type="email" name="email" id="email" value="<?php echo set_value('email'); ?>" class="bta-input<?php echo $err_email ? ' bta-invalid' : ''; ?>" placeholder="nama@email.com" autocomplete="email" required>
    </div>
    <?php if ($err_email): ?>
        <div class="bta-err"><i class="fas fa-circle-exclamation"></i><?php echo $err_email; ?></div>
    <?php endif; ?>
</div>
<div class="bta-field">
    <label for="password"><?php echo t('Kata Sandi', 'Password'); ?></label>
    <div class="bta-input-wrap has-eye">
        <i class="fas fa-lock"></i>
        <input type="password" name="password" id="password" class="bta-input<?php echo $err_pass ? ' bta-invalid' : ''; ?>" placeholder="••••••••" autocomplete="current-password" required>
        <button type="button" class="bta-eye" tabindex="-1" aria-label="<?php echo t('Tampilkan kata sandi', 'Show password'); ?>"><i class="fas fa-eye"></i></button>
    </div>
    <?php if ($err_pass): ?>
        <div class="bta-err"><i class="fas fa-circle-exclamation"></i><?php echo $err_pass; ?></div>
    <?php endif; ?>
</div>
<div class="bta-extra">
    <label class="bta-rem"><input type="checkbox" name="remember" id="remember"> <?php echo t('Ingat saya', 'Remember me'); ?></label>
    <a href="<?php echo base_url('auth/forgot_password'); ?>" class="bta-forgot"><?php echo t('Lupa kata sandi?', 'Forgot password?'); ?></a>
</div>
<?php
$auth_form_fields = ob_get_clean();

include '_auth_layout.php';
?>
