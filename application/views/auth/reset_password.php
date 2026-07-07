<div class="container py-5 my-4">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="text-center mb-5">
                <h3 class="fw-extrabold text-dark mb-2"><?php echo t('Reset Password', 'Reset Password'); ?></h3>
                <p class="text-secondary small mb-0"><?php echo t('Masukkan password baru Anda.', 'Enter your new password.'); ?></p>
            </div>
            <div class="bento-card p-4 p-md-5">
                <?php echo form_open('auth/reset_password/' . $token, array('class' => 'd-flex flex-column gap-4')); ?>
                    <div>
                        <label class="form-label fw-semibold"><?php echo t('Password Baru', 'New Password'); ?></label>
                        <input type="password" name="password" class="form-control" required minlength="6">
                    </div>
                    <div>
                        <label class="form-label fw-semibold"><?php echo t('Konfirmasi Password', 'Confirm Password'); ?></label>
                        <input type="password" name="confirm_password" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-dark w-100 py-3 rounded-pill fw-semibold">
                        <i data-lucide="lock" style="width:16px;height:16px;" class="me-2"></i> <?php echo t('Reset Password', 'Reset Password'); ?>
                    </button>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
</div>
