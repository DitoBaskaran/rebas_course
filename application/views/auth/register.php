<?php
$page_title = t('Gabung Gratis', 'Join Free');
$page_subtitle = t('Mulai petualangan belajarmu bersama ribuan siswa lainnya', 'Start your learning adventure with thousands of students');
$submit_text = t('Buat Akun', 'Create Account');
$form_action = 'auth/register';
$google_btn_text = t('Daftar dengan Google', 'Sign up with Google');
$footer_text = t('Sudah punya akun?', 'Already have an account?');
$footer_link_text = t('Masuk', 'Sign In');
$footer_link_url = base_url('auth/login');
?>

<div class="au-wrap">
    <div class="au-box">
        <div class="au-card">
            <div class="au-logo">
                <span class="au-logo-dot"></span>
            </div>

            <h1 class="au-title"><?php echo $page_title; ?></h1>
            <p class="au-sub"><?php echo $page_subtitle; ?></p>

            <?php if (validation_errors()): ?>
                <div class="au-alert">
                    <i class="fas fa-exclamation-circle"></i>
                    <span><?php echo validation_errors('', ''); ?></span>
                </div>
            <?php endif; ?>

            <?php echo form_open($form_action); ?>
                <div class="au-field">
                    <label for="name"><?php echo t('Nama Lengkap', 'Full Name'); ?></label>
                    <div class="au-input-wrap">
                        <i class="fas fa-user"></i>
                        <input type="text" name="name" id="name" value="<?php echo set_value('name'); ?>" required placeholder="<?php echo t('Nama lengkap', 'Full name'); ?>">
                    </div>
                </div>
                <div class="au-field">
                    <label for="email"><?php echo t('Email', 'Email'); ?></label>
                    <div class="au-input-wrap">
                        <i class="fas fa-envelope"></i>
                        <input type="email" name="email" id="email" value="<?php echo set_value('email'); ?>" required placeholder="nama@email.com">
                    </div>
                </div>
                <div class="au-field">
                    <label for="password"><?php echo t('Kata Sandi', 'Password'); ?></label>
                    <div class="au-input-wrap">
                        <i class="fas fa-lock"></i>
                        <input type="password" name="password" id="password" required placeholder="••••••••">
                        <button type="button" class="au-eye" onclick="auTogglePass(this)" tabindex="-1"><i class="fas fa-eye"></i></button>
                    </div>
                </div>
                <div class="au-field">
                    <label for="confirm_password"><?php echo t('Konfirmasi Kata Sandi', 'Confirm Password'); ?></label>
                    <div class="au-input-wrap">
                        <i class="fas fa-lock"></i>
                        <input type="password" name="confirm_password" id="confirm_password" required placeholder="••••••••">
                    </div>
                </div>

                <div style="position:absolute;left:-9999px;" aria-hidden="true">
                    <input type="text" name="website_url" tabindex="-1" autocomplete="off">
                </div>

                <button type="submit" class="au-btn">
                    <?php echo $submit_text; ?> <i class="fas fa-arrow-right"></i>
                </button>
            <?php echo form_close(); ?>

            <?php if (!empty($google_login_url)): ?>
                <div class="au-divider"><span><?php echo t('atau', 'or'); ?></span></div>
                <a href="<?php echo $google_login_url; ?>" class="au-btn-google">
                    <svg width="16" height="16" viewBox="0 0 24 24"><path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92a5.06 5.06 0 01-2.2 3.32v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.1z" fill="#4285F4"/><path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/><path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/><path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/></svg>
                    <?php echo $google_btn_text; ?>
                </a>
            <?php endif; ?>

            <div class="au-footer">
                <p><?php echo $footer_text; ?> <a href="<?php echo $footer_link_url; ?>"><?php echo $footer_link_text; ?></a></p>
            </div>
        </div>
    </div>
</div>

<script>
function auTogglePass(btn) {
    var inp = btn.parentElement.querySelector('input');
    var ic = btn.querySelector('i');
    if (inp.type === 'password') { inp.type = 'text'; ic.className = 'fas fa-eye-slash'; }
    else { inp.type = 'password'; ic.className = 'fas fa-eye'; }
}
</script>

<style>
.au-wrap { min-height:calc(100vh - 56px); display:flex; align-items:center; justify-content:center; padding:1.5rem; background:#fafafa; }
.au-box { width:100%; max-width:400px; }
.au-card { background:#fff; border-radius:12px; padding:2.25rem 2rem; border:1px solid #e5e5e5; }
.au-logo { text-align:center; margin-bottom:1.25rem; }
.au-logo-dot { display:inline-block; width:10px; height:10px; border-radius:50%; background:#059669; }
.au-title { font-size:1.35rem; font-weight:800; letter-spacing:-0.03em; color:#171717; text-align:center; margin:0 0 0.15rem; }
.au-sub { font-size:0.82rem; color:#737373; text-align:center; margin:0 0 1.5rem; }
.au-alert { display:flex; align-items:center; gap:0.5rem; padding:0.65rem 0.85rem; margin-bottom:1rem; background:#fef2f2; border-radius:8px; border:1px solid #fecaca; font-size:0.78rem; color:#dc2626; }
.au-field { margin-bottom:0.85rem; }
.au-field label { display:block; font-size:0.75rem; font-weight:600; color:#525252; margin-bottom:0.3rem; }
.au-input-wrap { position:relative; }
.au-input-wrap input { width:100%; padding:0.7rem 1rem 0.7rem 2.5rem; border:1.5px solid #e5e5e5; border-radius:8px; font-size:0.85rem; color:#171717; background:#fff; transition:all 0.15s; outline:none; font-family:inherit; }
.au-input-wrap input:focus { border-color:#059669; box-shadow:0 0 0 3px rgba(5, 150, 105,0.1); }
.au-input-wrap input::placeholder { color:#a3a3a3; }
.au-input-wrap > i { position:absolute; left:0.85rem; top:50%; transform:translateY(-50%); color:#a3a3a3; font-size:0.78rem; pointer-events:none; }
.au-input-wrap input:focus ~ i { color:#059669; }
.au-eye { position:absolute; right:0.85rem; top:50%; transform:translateY(-50%); color:#a3a3a3; cursor:pointer; font-size:0.78rem; background:none; border:none; padding:0; line-height:1; z-index:1; }
.au-eye:hover { color:#737373; }
.au-btn { width:100%; padding:0.75rem; background:#059669; color:#fff; border:none; border-radius:8px; font-weight:700; font-size:0.85rem; cursor:pointer; transition:all 0.15s; display:flex; align-items:center; justify-content:center; gap:0.5rem; font-family:inherit; }
.au-btn:hover { background:#047857; }
.au-btn:active { transform:translateY(0); }
.au-btn-google { width:100%; padding:0.65rem; background:#fff; color:#525252; border:1.5px solid #e5e5e5; border-radius:8px; font-weight:600; font-size:0.82rem; cursor:pointer; transition:all 0.15s; display:flex; align-items:center; justify-content:center; gap:0.6rem; text-decoration:none; font-family:inherit; }
.au-btn-google:hover { border-color:#d4d4d4; background:#fafafa; }
.au-divider { display:flex; align-items:center; gap:1rem; margin:1rem 0; }
.au-divider::before, .au-divider::after { content:''; flex:1; height:1px; background:#f0f0f0; }
.au-divider span { font-size:0.72rem; color:#a3a3a3; font-weight:500; }
.au-footer { text-align:center; margin-top:1.25rem; padding-top:1rem; border-top:1px solid #f0f0f0; }
.au-footer p { font-size:0.8rem; color:#737373; margin:0; }
.au-footer a { color:#059669; font-weight:700; text-decoration:none; }
.au-footer a:hover { text-decoration:underline; }
</style>
