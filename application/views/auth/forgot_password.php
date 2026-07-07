<div class="container py-5 my-4">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="text-center mb-5">
                <h3 class="fw-extrabold text-dark mb-2"><?php echo t('Lupa Password', 'Forgot Password'); ?></h3>
                <p class="text-secondary small mb-0"><?php echo t('Masukkan email Anda, kami akan mengirim tautan reset.', 'Enter your email, we will send a reset link.'); ?></p>
            </div>
            <div class="bento-card p-4 p-md-5">
                <?php echo form_open('auth/forgot_password', array('class' => 'd-flex flex-column gap-4')); ?>
                    <div>
                        <label class="form-label fw-semibold">Email</label>
                        <input type="email" name="email" class="form-control" required placeholder="nama@email.com">
                    </div>
                    <button type="submit" class="btn btn-dark w-100 py-3 rounded-pill fw-semibold">
                        <i data-lucide="send" style="width:16px;height:16px;" class="me-2"></i> <?php echo t('Kirim Tautan Reset', 'Send Reset Link'); ?>
                    </button>
                <?php echo form_close(); ?>
                <div class="text-center mt-4">
                    <a href="<?php echo base_url('auth/login'); ?>" class="text-primary text-decoration-none fw-semibold small"><?php echo t('Kembali ke Login', 'Back to Login'); ?></a>
                </div>
            </div>
        </div>
    </div>
</div>
