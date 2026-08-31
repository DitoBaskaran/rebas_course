<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$auth_title = t('Halo lagi! 👋', 'Welcome back! 👋');
$auth_subtitle = t('Masuk dan lanjutkan perjalanan belajarmu', 'Sign in and continue your learning journey');
$auth_icon = 'fa-rocket';
$auth_visual_title = t('Lanjutkan Belajarmu.', 'Continue Your Learning.');
$auth_visual_sub = t('Setiap materi baru membawamu selangkah lebih dekat ke tujuan.', 'Every new lesson brings you one step closer to your goal.');
$auth_form_action = 'auth/login';
$auth_submit_text = t('Masuk', 'Sign In');
$auth_google_text = t('Lanjutkan dengan Google', 'Continue with Google');
$auth_footer_text = t('Belum punya akun?', "Don't have an account?");
$auth_footer_link = t('Daftar Gratis', 'Register Free');
$auth_footer_url = base_url('auth/register');

// Field form login
ob_start();
?>
<div class="au2-field">
    <label for="email"><?php echo t('Email', 'Email'); ?></label>
    <div class="au2-input-wrap">
        <i class="fas fa-envelope"></i>
        <input type="email" name="email" id="email" value="<?php echo set_value('email'); ?>" required placeholder="nama@email.com" autocomplete="email">
    </div>
</div>
<div class="au2-field">
    <label for="password"><?php echo t('Kata Sandi', 'Password'); ?></label>
    <div class="au2-input-wrap">
        <i class="fas fa-lock"></i>
        <input type="password" name="password" id="password" required placeholder="••••••••" autocomplete="current-password">
        <button type="button" class="au2-eye" onclick="auTogglePass(this)" tabindex="-1"><i class="fas fa-eye"></i></button>
    </div>
</div>
<div class="au2-extra">
    <label><input type="checkbox" name="remember" id="remember"> <?php echo t('Ingat saya', 'Remember me'); ?></label>
    <a href="<?php echo base_url('auth/forgot_password'); ?>" class="au2-forgot"><?php echo t('Lupa kata sandi?', 'Forgot password?'); ?></a>
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
