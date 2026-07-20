<?php
// Shared auth page variables
$page_title = t('Gabung Gratis', 'Join Free');
$page_subtitle = t('Mulai petualangan belajarmu bersama ribuan siswa lainnya', 'Start your learning adventure with thousands of students');
$submit_text = t('Buat Akun', 'Create Account');
$form_action = 'auth/register';
$google_btn_text = t('Daftar dengan Google', 'Sign up with Google');
$footer_text = t('Sudah punya akun?', 'Already have an account?');
$footer_link_text = t('Masuk', 'Sign In');
$footer_link_url = base_url('auth/login');
?>

<div class="auth-wrap">
    <div class="auth-blob auth-blob--coral"></div>
    <div class="auth-blob auth-blob--rose"></div>
    <div class="auth-blob auth-blob--teal"></div>

    <div class="auth-box">
        <div class="auth-card">
            <div class="auth-logo">
                <span class="auth-logo__icon">B</span>
                <span class="auth-logo__text">BISATUNTAS</span>
            </div>

            <div class="auth-head">
                <h1 class="auth-head__title"><?php echo $page_title; ?></h1>
                <p class="auth-head__sub"><?php echo $page_subtitle; ?></p>
            </div>

            <?php if (validation_errors()): ?>
                <div class="auth-alert">
                    <i class="fas fa-exclamation-circle"></i>
                    <span><?php echo validation_errors('', ''); ?></span>
                </div>
            <?php endif; ?>

            <?php echo form_open($form_action); ?>
                <div class="auth-field">
                    <label for="name"><?php echo t('Nama Lengkap', 'Full Name'); ?></label>
                    <div class="auth-field__input">
                        <i class="fas fa-user"></i>
                        <input type="text" name="name" id="name" value="<?php echo set_value('name'); ?>" required placeholder="<?php echo t('Nama kamu', 'Your name'); ?>">
                    </div>
                </div>
                <div class="auth-field">
                    <label for="email">Email</label>
                    <div class="auth-field__input">
                        <i class="fas fa-envelope"></i>
                        <input type="email" name="email" id="email" value="<?php echo set_value('email'); ?>" required placeholder="nama@email.com">
                    </div>
                </div>
                <div class="auth-field">
                    <label for="password"><?php echo t('Kata Sandi', 'Password'); ?></label>
                    <div class="auth-field__input">
                        <i class="fas fa-lock"></i>
                        <input type="password" name="password" id="password" required placeholder="<?php echo t('Minimal 6 karakter', 'Min 6 characters'); ?>">
                        <button type="button" class="auth-eye" onclick="authTogglePass(this)" tabindex="-1"><i class="fas fa-eye"></i></button>
                    </div>
                </div>
                <div class="auth-field">
                    <label for="confirm_password"><?php echo t('Ulangi Kata Sandi', 'Confirm Password'); ?></label>
                    <div class="auth-field__input">
                        <i class="fas fa-lock"></i>
                        <input type="password" name="confirm_password" id="confirm_password" required placeholder="<?php echo t('Ulangi sandi', 'Repeat password'); ?>">
                        <button type="button" class="auth-eye" onclick="authTogglePass(this)" tabindex="-1"><i class="fas fa-eye"></i></button>
                    </div>
                </div>

                <div style="position:absolute;left:-9999px;" aria-hidden="true">
                    <input type="text" name="website_url" tabindex="-1" autocomplete="off">
                </div>

                <button type="submit" class="auth-btn">
                    <?php echo $submit_text; ?> <i class="fas fa-arrow-right"></i>
                </button>
            <?php echo form_close(); ?>

            <?php if (!empty($google_login_url)): ?>
                <div class="auth-divider"><span><?php echo t('atau', 'or'); ?></span></div>
                <a href="<?php echo $google_login_url; ?>" class="auth-btn-google">
                    <svg width="16" height="16" viewBox="0 0 24 24"><path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92a5.06 5.06 0 01-2.2 3.32v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.1z" fill="#4285F4"/><path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/><path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/><path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/></svg>
                    <?php echo $google_btn_text; ?>
                </a>
            <?php endif; ?>

            <div class="auth-footer">
                <p><?php echo $footer_text; ?> <a href="<?php echo $footer_link_url; ?>"><?php echo $footer_link_text; ?></a></p>
            </div>
        </div>
    </div>
</div>

<script>
function authTogglePass(btn) {
    var inp = btn.parentElement.querySelector('input');
    var ic = btn.querySelector('i');
    if (inp.type === 'password') { inp.type = 'text'; ic.className = 'fas fa-eye-slash'; }
    else { inp.type = 'password'; ic.className = 'fas fa-eye'; }
}
</script>

<style>
/* ===== Auth Page ===== */
.auth-wrap {
    min-height: calc(100vh - 72px);
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
    padding: 1.5rem;
}

/* Background */
.auth-wrap::before {
    content: '';
    position: fixed;
    inset: 0;
    background: linear-gradient(135deg, #ffedd5 0%, #fef2f2 30%, #fdf2f8 60%, #f0fdf4 100%);
    z-index: -2;
}
.auth-blob {
    position: fixed;
    border-radius: 50%;
    z-index: -1;
}
.auth-blob--coral { top: -15%; right: -10%; width: 500px; height: 500px; background: radial-gradient(circle, rgba(249,115,22,0.12), transparent 70%); }
.auth-blob--rose  { bottom: -20%; left: -10%; width: 450px; height: 450px; background: radial-gradient(circle, rgba(244,63,94,0.1), transparent 70%); }
.auth-blob--teal  { top: 40%; left: 60%; width: 250px; height: 250px; background: radial-gradient(circle, rgba(20,184,166,0.08), transparent 70%); }

/* Card */
.auth-box { width: 100%; max-width: 440px; margin: 0 auto; position: relative; z-index: 1; }
.auth-card {
    background: #fff;
    border-radius: 28px;
    padding: 2.75rem 2.5rem;
    box-shadow: 0 2px 4px rgba(0,0,0,0.02), 0 8px 24px -4px rgba(249,115,22,0.08), 0 12px 48px rgba(0,0,0,0.04);
    position: relative;
    overflow: hidden;
}
.auth-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(90deg, #f97316, #fb923c, #f43f5e, #eab308);
}

/* Logo */
.auth-logo { display: flex; align-items: center; justify-content: center; gap: 0.75rem; margin-bottom: 1.75rem; }
.auth-logo__icon {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 44px;
    height: 44px;
    background: linear-gradient(135deg, #f97316, #f43f5e);
    border-radius: 14px;
    color: #fff;
    font-weight: 900;
    font-size: 1.1rem;
    box-shadow: 0 4px 12px rgba(249,115,22,0.3);
}
.auth-logo__text { font-size: 1.15rem; font-weight: 800; color: #1c1917; letter-spacing: -0.03em; }

/* Heading */
.auth-head { text-align: center; margin-bottom: 1.75rem; }
.auth-head__title { font-size: 1.65rem; font-weight: 800; letter-spacing: -0.03em; color: #1c1917; line-height: 1.2; margin-bottom: 0.3rem; }
.auth-head__sub { font-size: 0.85rem; color: #78716c; line-height: 1.5; margin: 0; }

/* Alert */
.auth-alert {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.75rem 1rem;
    margin-bottom: 1.25rem;
    background: #fff1f2;
    border-radius: 12px;
    border: 1px solid #fecdd3;
    font-size: 0.8rem;
    color: #be123c;
}

/* Fields */
.auth-field { margin-bottom: 1rem; }
.auth-field label { display: block; font-size: 0.78rem; font-weight: 600; color: #44403c; margin-bottom: 0.35rem; letter-spacing: 0.01em; }
.auth-field__input { position: relative; }
.auth-field__input input {
    width: 100%;
    padding: 0.85rem 1rem 0.85rem 2.7rem;
    border: 1.5px solid #e7e5e4;
    border-radius: 14px;
    font-size: 0.88rem;
    color: #1c1917;
    background: #fafaf9;
    transition: all 0.2s;
    outline: none;
    font-family: inherit;
}
.auth-field__input input:focus { border-color: #f97316; background: #fff; box-shadow: 0 0 0 4px rgba(249,115,22,0.1); }
.auth-field__input input::placeholder { color: #a8a29e; }
.auth-field__input > i { position: absolute; left: 0.9rem; top: 50%; transform: translateY(-50%); color: #a8a29e; font-size: 0.82rem; pointer-events: none; transition: color 0.2s; }
.auth-field__input input:focus ~ i { color: #f97316; }

/* Eye toggle */
.auth-eye {
    position: absolute;
    right: 0.85rem;
    top: 50%;
    transform: translateY(-50%);
    color: #a8a29e;
    cursor: pointer;
    font-size: 0.82rem;
    background: none;
    border: none;
    padding: 0;
    line-height: 1;
    z-index: 1;
    transition: color 0.2s;
}
.auth-eye:hover { color: #78716c; }

/* Buttons */
.auth-btn {
    width: 100%;
    padding: 0.9rem;
    background: linear-gradient(135deg, #f97316, #f43f5e);
    color: #fff;
    border: none;
    border-radius: 14px;
    font-weight: 700;
    font-size: 0.9rem;
    cursor: pointer;
    transition: all 0.25s;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    font-family: inherit;
    box-shadow: 0 4px 14px rgba(249,115,22,0.35);
}
.auth-btn:hover { transform: translateY(-2px); box-shadow: 0 8px 25px rgba(249,115,22,0.4); }
.auth-btn:active { transform: translateY(0); }

.auth-btn-google {
    width: 100%;
    padding: 0.8rem;
    background: #fff;
    color: #44403c;
    border: 1.5px solid #e7e5e4;
    border-radius: 14px;
    font-weight: 600;
    font-size: 0.84rem;
    cursor: pointer;
    transition: all 0.2s;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.6rem;
    text-decoration: none;
    font-family: inherit;
}
.auth-btn-google:hover { border-color: #f97316; background: #fff7ed; transform: translateY(-1px); }

/* Divider */
.auth-divider { display: flex; align-items: center; gap: 1rem; margin: 1.25rem 0; }
.auth-divider::before, .auth-divider::after { content: ''; flex: 1; height: 1px; background: #f0eeeb; }
.auth-divider span { font-size: 0.75rem; color: #a8a29e; font-weight: 500; }

/* Footer */
.auth-footer { text-align: center; margin-top: 1.5rem; padding-top: 1.25rem; border-top: 1px solid #f0eeeb; }
.auth-footer p { font-size: 0.82rem; color: #78716c; margin: 0; }
.auth-footer a { color: #f97316; font-weight: 700; text-decoration: none; border-bottom: 2px solid rgba(249,115,22,0.3); padding-bottom: 1px; transition: border-color 0.2s; }
.auth-footer a:hover { border-bottom-color: #f97316; }
</style>
