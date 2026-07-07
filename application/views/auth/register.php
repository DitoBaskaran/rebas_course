<div class="container py-5 my-4">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="animate-scale-in">
                <div class="text-center mb-5">
                    <div class="d-inline-flex align-items-center justify-content-center bg-dark text-white rounded-3 mb-4 shadow-lg" style="width: 64px; height: 64px;">
                        <i class="fas fa-user-plus fa-lg"></i>
                    </div>
                    <h3 class="fw-extrabold text-dark mb-2" style="letter-spacing: -0.03em;"><?php echo t('Buat Akun Baru', 'Create Account'); ?></h3>
                    <p class="text-secondary small mb-0"><?php echo t('Mulai perjalanan belajarmu sekarang bersama ribuan siswa lainnya', 'Start your learning journey now with thousands of other students'); ?></p>
                </div>

                <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5">
                    <?php if (validation_errors()): ?>
                        <div class="alert alert-danger border-0 rounded-3 py-2 px-3 small d-flex align-items-center gap-2">
                            <i class="fas fa-exclamation-circle text-danger"></i>
                            <span><?php echo validation_errors('', ''); ?></span>
                        </div>
                    <?php endif; ?>

                    <?php echo form_open('auth/register', array('class' => 'd-flex flex-column gap-4')); ?>
                        <div class="row g-4">
                            <div class="col-md-12">
                                <label for="name" class="form-label"><?php echo t('Nama Lengkap', 'Full Name'); ?></label>
                                <input type="text" name="name" id="name" class="form-control rounded-pill" value="<?php echo set_value('name'); ?>" required placeholder="<?php echo t('Masukkan nama lengkap', 'Enter your full name'); ?>">
                            </div>
                            <div class="col-md-12">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" name="email" id="email" class="form-control rounded-pill" value="<?php echo set_value('email'); ?>" required placeholder="nama@email.com">
                            </div>
                            <div class="col-md-12">
                                <label for="password" class="form-label"><?php echo t('Password', 'Password'); ?></label>
                                <input type="password" name="password" id="password" class="form-control rounded-pill" required placeholder="<?php echo t('Minimal 6 karakter', 'Min 6 characters'); ?>">
                            </div>
                            <div class="col-md-12">
                                <label for="confirm_password" class="form-label"><?php echo t('Konfirmasi Password', 'Confirm Password'); ?></label>
                                <input type="password" name="confirm_password" id="confirm_password" class="form-control rounded-pill" required placeholder="<?php echo t('Ulangi password', 'Repeat password'); ?>">
                            </div>
                            <div class="col-md-12">
                                <label class="form-label"><?php echo t('Daftar Sebagai', 'Register As'); ?></label>
                                <div class="d-flex align-items-center gap-2 py-2 px-3 bg-light rounded-pill border">
                                    <i data-lucide="user" style="width:16px;height:16px;color:var(--gray-400);"></i>
                                    <span class="text-dark fw-semibold small"><?php echo t('Siswa', 'Student'); ?></span>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-dark w-100 mt-2 py-3 rounded-pill fw-semibold">
                            <i class="fas fa-user-plus me-2"></i> <?php echo t('Daftar Akun', 'Create Account'); ?>
                        </button>
                        <div style="position:absolute;left:-9999px;" aria-hidden="true">
                            <input type="text" name="website_url" tabindex="-1" autocomplete="off">
                        </div>
                    <?php echo form_close(); ?>

                    <div class="text-center mt-4 pt-4 border-top">
                        <p class="text-secondary small mb-0">
                            <?php echo t('Sudah punya akun?', 'Already have an account?'); ?>
                            <a href="<?php echo base_url('auth/login'); ?>" class="text-primary text-decoration-none fw-bold border-bottom border-primary pb-1"><?php echo t('Masuk', 'Sign In'); ?></a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
