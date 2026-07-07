<div class="container py-5 my-4">
    <div class="row justify-content-center">
        <div class="col-md-5 col-lg-4">
            <div class="animate-scale-in">
                <div class="text-center mb-5">
                    <div class="d-inline-flex align-items-center justify-content-center bg-dark text-white rounded-3 mb-4 shadow-lg" style="width: 64px; height: 64px;">
                        <i class="fas fa-graduation-cap fa-lg"></i>
                    </div>
                    <h3 class="fw-extrabold text-dark mb-2" style="letter-spacing: -0.03em;"><?php echo t('Selamat Datang Kembali', 'Welcome Back'); ?></h3>
                    <p class="text-secondary small mb-0"><?php echo t('Silakan masuk ke akun Anda untuk melanjutkan belajar', 'Sign in to your account to continue learning'); ?></p>
                </div>

                <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5">
                    <?php if (validation_errors()): ?>
                        <div class="alert alert-danger border-0 rounded-3 py-2 px-3 small d-flex align-items-center gap-2">
                            <i class="fas fa-exclamation-circle text-danger"></i>
                            <span><?php echo validation_errors('', ''); ?></span>
                        </div>
                    <?php endif; ?>

                    <?php echo form_open('auth/login', array('class' => 'd-flex flex-column gap-4')); ?>
                        <div>
                            <label for="email" class="form-label"><?php echo t('Email', 'Email'); ?></label>
                            <input type="email" name="email" id="email" class="form-control rounded-pill" value="<?php echo set_value('email'); ?>" required placeholder="nama@email.com">
                        </div>
                        <div>
                            <label for="password" class="form-label"><?php echo t('Password', 'Password'); ?></label>
                            <input type="password" name="password" id="password" class="form-control rounded-pill" required placeholder="••••••••">
                        </div>
                        <button type="submit" class="btn btn-dark w-100 mt-2 py-3 rounded-pill fw-semibold">
                            <i class="fas fa-sign-in-alt me-2"></i> <?php echo t('Masuk', 'Sign In'); ?>
                        </button>
                        <div style="position:absolute;left:-9999px;" aria-hidden="true">
                            <input type="text" name="website_url" tabindex="-1" autocomplete="off">
                        </div>
                    <?php echo form_close(); ?>

                    <div class="text-center mt-4 pt-4 border-top">
                        <p class="text-secondary small mb-0">
                            <?php echo t('Belum punya akun?', "Don't have an account?"); ?>
                            <a href="<?php echo base_url('auth/register'); ?>" class="text-primary text-decoration-none fw-bold border-bottom border-primary pb-1"><?php echo t('Daftar Sekarang', 'Register Now'); ?></a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
