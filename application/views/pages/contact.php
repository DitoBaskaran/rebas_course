<div class="container py-5 my-4">
    <div class="text-center mb-5">
        <span class="badge bg-primary-subtle text-primary badge-modern mb-3">Kontak</span>
        <h1 class="display-5 fw-extrabold text-dark mb-3" style="letter-spacing:-0.03em;"><?php echo t('Hubungi Kami', 'Contact Us'); ?></h1>
        <p class="text-secondary mx-auto" style="max-width:500px;"><?php echo t('Punya pertanyaan? Kami siap membantu.', 'Have questions? We are here to help.'); ?></p>
    </div>
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="bento-card p-4 p-lg-5">
                <?php echo form_open('contact/send', array('class' => 'd-flex flex-column gap-4')); ?>
                    <div class="row g-4">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold"><?php echo t('Nama', 'Name'); ?></label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Email</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>
                    </div>
                    <div>
                        <label class="form-label fw-semibold"><?php echo t('Pesan', 'Message'); ?></label>
                        <textarea name="message" rows="5" class="form-control" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-dark rounded-pill px-5 py-2 fw-semibold align-self-start">
                        <i data-lucide="send" style="width:16px;height:16px;" class="me-1"></i> <?php echo t('Kirim Pesan', 'Send Message'); ?>
                    </button>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
</div>
