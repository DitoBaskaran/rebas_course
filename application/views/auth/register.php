<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$auth_kicker = t('Akun Baru', 'New Account');
$auth_title = t('Buat Akun Gratis 🚀', 'Create a Free Account 🚀');
$auth_subtitle = t('Satu akun untuk semua kelas, seminar & mentoring', 'One account for all courses, seminars & mentoring');
$auth_icon = 'fa-graduation-cap';
$auth_visual_title = t('Petualangan Belajarmu Dimulai di Sini.', 'Your Learning Adventure Starts Here.');
$auth_visual_sub = t('Bergabunglah dengan ribuan pelajar yang menyelesaikan masalahnya secara tuntas.', 'Join thousands of learners who solve their problems completely.');
$auth_form_action = 'auth/register';
$auth_submit_text = t('Daftar Sekarang', 'Sign Up Now');
$auth_submit_loading = t('Membuat akun…', 'Creating account…');
$auth_google_text = t('Daftar dengan Google', 'Sign up with Google');
$auth_footer_text = t('Sudah punya akun?', 'Already have an account?');
$auth_footer_link = t('Masuk', 'Sign In');
$auth_footer_url = base_url('auth/login');

// Field form register (dengan error per-field)
ob_start();
$err_name  = form_error('name', '', '');
$err_email = form_error('email', '', '');
$err_phone = form_error('phone', '', '');
$err_pass  = form_error('password', '', '');
$err_cpass = form_error('confirm_password', '', '');
?>
<div class="bta-field">
    <label for="name"><?php echo t('Nama Lengkap', 'Full Name'); ?></label>
    <div class="bta-input-wrap">
        <i class="fas fa-user"></i>
        <input type="text" name="name" id="name" value="<?php echo set_value('name'); ?>" class="bta-input<?php echo $err_name ? ' bta-invalid' : ''; ?>" placeholder="<?php echo t('Nama lengkap', 'Full name'); ?>" autocomplete="name" required>
    </div>
    <?php if ($err_name): ?>
        <div class="bta-err"><i class="fas fa-circle-exclamation"></i><?php echo $err_name; ?></div>
    <?php endif; ?>
</div>
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
    <label for="phone"><?php echo t('No. WhatsApp', 'WhatsApp Number'); ?></label>
    <div class="bta-input-wrap">
        <i class="fab fa-whatsapp"></i>
        <input type="tel" name="phone" id="phone" value="<?php echo set_value('phone'); ?>" class="bta-input<?php echo $err_phone ? ' bta-invalid' : ''; ?>" placeholder="081234567890" autocomplete="tel" required>
    </div>
    <?php if ($err_phone): ?>
        <div class="bta-err"><i class="fas fa-circle-exclamation"></i><?php echo $err_phone; ?></div>
    <?php endif; ?>
</div>
<div class="bta-field">
    <label for="password"><?php echo t('Kata Sandi', 'Password'); ?></label>
    <div class="bta-input-wrap has-eye">
        <i class="fas fa-lock"></i>
        <input type="password" name="password" id="password" class="bta-input<?php echo $err_pass ? ' bta-invalid' : ''; ?>" placeholder="<?php echo t('Min. 6 karakter', 'Min. 6 characters'); ?>" autocomplete="new-password" minlength="6" required>
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
