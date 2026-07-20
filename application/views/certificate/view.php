<div class="container py-5 my-4">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-7">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-5 text-center">
                    <!-- Award Icon -->
                    <div class="d-inline-flex align-items-center justify-content-center rounded-circle mb-4" style="width: 80px; height: 80px; background: #fef3c7;">
                        <i class="fas fa-award fa-lg" style="color: #d97706; font-size: 2rem;"></i>
                    </div>

                    <h3 class="fw-extrabold text-dark mb-2" style="letter-spacing: -0.03em;">
                        <?php echo t('Sertifikat Kelulusan', 'Certificate of Completion'); ?>
                    </h3>

                    <p class="text-secondary mb-4">
                        <?php echo t('Dikeluarkan untuk', 'Issued to'); ?> <strong><?php echo htmlspecialchars($cert->user_name ?? $cert->name); ?></strong>
                    </p>

                    <!-- Certificate Details -->
                    <div class="bg-light rounded-3 p-4 mb-4 text-start">
                        <div class="row g-3">
                            <div class="col-sm-6">
                                <small class="text-secondary d-block mb-1"><?php echo t('Kursus', 'Course'); ?></small>
                                <strong class="text-dark"><?php echo htmlspecialchars(current_lang() === 'en' && !empty($cert->title_en) ? $cert->title_en : $cert->title); ?></strong>
                            </div>
                            <div class="col-sm-6">
                                <small class="text-secondary d-block mb-1"><?php echo t('Kode Sertifikat', 'Certificate Code'); ?></small>
                                <strong class="text-dark"><?php echo htmlspecialchars($cert->certificate_code); ?></strong>
                            </div>
                            <div class="col-sm-6">
                                <small class="text-secondary d-block mb-1"><?php echo t('Tanggal Terbit', 'Issued Date'); ?></small>
                                <strong class="text-dark"><?php echo date('d F Y', strtotime($cert->issued_at)); ?></strong>
                            </div>
                            <div class="col-sm-6">
                                <small class="text-secondary d-block mb-1"><?php echo t('Tautan Verifikasi', 'Verification Link'); ?></small>
                                <a href="<?php echo base_url('certificate/verify/' . $cert->certificate_code); ?>" class="text-primary text-decoration-none fw-semibold" target="_blank">
                                    <?php echo base_url('certificate/verify/' . $cert->certificate_code); ?>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="d-flex justify-content-center gap-3 flex-wrap">
                        <a href="<?php echo base_url('certificate/download/' . encode_id($cert->id)); ?>" class="btn btn-dark rounded-pill px-4 py-2 fw-semibold">
                            <i class="fas fa-download me-2"></i> <?php echo t('Unduh PDF', 'Download PDF'); ?>
                        </a>
                        <a href="<?php echo base_url('certificate/verify/' . $cert->certificate_code); ?>" class="btn btn-outline-dark rounded-pill px-4 py-2 fw-semibold" target="_blank">
                            <i class="fas fa-external-link-alt me-2"></i> <?php echo t('Verifikasi', 'Verify'); ?>
                        </a>
                        <a href="<?php echo base_url('certificate/my'); ?>" class="btn btn-outline-secondary rounded-pill px-4 py-2 fw-semibold">
                            <i class="fas fa-arrow-left me-2"></i> <?php echo t('Kembali', 'Back'); ?>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
