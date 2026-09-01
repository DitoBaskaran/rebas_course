<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$auth_title = t('Gabung Gratis 🚀', 'Join Free 🚀');
$auth_subtitle = t('Mulai petualangan belajarmu sekarang', 'Start your learning adventure now');
$auth_icon = 'fa-graduation-cap';
$auth_visual_title = t('Petualanganmu Dimulai di Sini.', 'Your Adventure Starts Here.');
$auth_visual_sub = t('Ribuan siswa sudah menemukan jalannya. Giliranmu sekarang!', 'Thousands of students already found their path. Now it\'s your turn!');
$auth_form_action = 'auth/register';
$auth_submit_text = t('Buat Akun', 'Create Account');
$auth_google_text = t('Daftar dengan Google', 'Sign up with Google');
$auth_footer_text = t('Sudah punya akun?', 'Already have an account?');
$auth_footer_link = t('Masuk', 'Sign In');
$auth_footer_url = base_url('auth/login');

// Field form register
ob_start();
?>
<div class="au2-field">
    <label for="name"><?php echo t('Nama Lengkap', 'Full Name'); ?></label>
    <div class="au2-input-wrap">
        <i class="fas fa-user"></i>
        <input type="text" name="name" id="name" value="<?php echo set_value('name'); ?>" required placeholder="<?php echo t('Nama lengkap', 'Full name'); ?>" autocomplete="name">
    </div>
</div>
<div class="au2-field">
    <label for="email"><?php echo t('Email', 'Email'); ?></label>
    <div class="au2-input-wrap">
        <i class="fas fa-envelope"></i>
        <input type="email" name="email" id="email" value="<?php echo set_value('email'); ?>" required placeholder="nama@email.com" autocomplete="email">
    </div>
</div>
<div class="au2-field">
    <label for="phone"><?php echo t('No. WhatsApp', 'WhatsApp Number'); ?></label>
    <div class="au2-input-wrap">
        <i class="fab fa-whatsapp"></i>
        <input type="tel" name="phone" id="phone" value="<?php echo set_value('phone'); ?>" required placeholder="081234567890" autocomplete="tel">
    </div>
</div>
<div class="au2-field">
    <label for="password"><?php echo t('Kata Sandi', 'Password'); ?></label>
    <div class="au2-input-wrap">
        <i class="fas fa-lock"></i>
        <input type="password" name="password" id="password" required placeholder="<?php echo t('Min. 6 karakter', 'Min. 6 characters'); ?>" autocomplete="new-password">
        <button type="button" class="au2-eye" onclick="auTogglePass(this)" tabindex="-1"><i class="fas fa-eye"></i></button>
    </div>
</div>
<div class="au2-field">
    <label for="confirm_password"><?php echo t('Konfirmasi Kata Sandi', 'Confirm Password'); ?></label>
    <div class="au2-input-wrap">
        <i class="fas fa-lock"></i>
        <input type="password" name="confirm_password" id="confirm_password" required placeholder="••••••••" autocomplete="new-password">
    </div>
</div>
<?php
$auth_form_fields = ob_get_clean();

include '_auth_layout.php';
?>

<script>
function auTogglePass(btn) {
    var inp = btn.parentElement.querySelector('input');
    var ic = btn.querySelector('i');
    if (inp.type === 'password') { inp.type = 'text'; ic.className = 'fas fa-eye-slash'; }
    else { inp.type = 'password'; ic.className = 'fas fa-eye'; }
}
</script>
