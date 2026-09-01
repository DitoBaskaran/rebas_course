<div class="container py-4 my-2" style="max-width: 900px;">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-7">

            <!-- ============ MOBILE APP-STYLE ============ -->
            <div class="dashboard-mobile-only">
                <div class="text-center mb-4">
                    <a href="javascript:history.back()" class="d-inline-flex align-items-center justify-content-center rounded-circle mb-3" style="width: 36px; height: 36px; background: #E6EBEF; color: #0D1830; text-decoration: none;">
                        <i class="fas fa-arrow-left"></i>
                    </a>
                </div>
                <div class="bg-white rounded-4 border p-4 text-center" style="border-color: #f0eeeb !important; box-shadow: 0 4px 16px rgba(0,0,0,0.06);">
                    <div class="d-inline-flex align-items-center justify-content-center rounded-circle mb-3" style="width: 72px; height: 72px; background: linear-gradient(135deg,#009688,#34d399); color: #fff;">
                        <i class="fas fa-award" style="font-size: 1.6rem;"></i>
                    </div>
                    <h5 class="fw-extrabold text-dark mb-1" style="letter-spacing: -0.02em;"><?php echo t('Sertifikat Kelulusan', 'Certificate of Completion'); ?></h5>
                    <p class="text-muted mb-3" style="font-size: 0.82rem;">
                        <?php echo t('Dikeluarkan untuk', 'Issued to'); ?> <strong class="text-dark"><?php echo htmlspecialchars($cert->user_name ?? $cert->name); ?></strong>
                    </p>
                    <div class="bg-light rounded-3 p-3 mb-3 text-start" style="background: #E6EBEF !important;">
                        <div class="mb-2">
                            <small class="text-secondary d-block" style="font-size: 0.68rem;"><?php echo t('Kursus', 'Course'); ?></small>
                            <strong class="text-dark" style="font-size: 0.85rem;"><?php echo htmlspecialchars(current_lang() === 'en' && !empty($cert->title_en) ? $cert->title_en : $cert->title); ?></strong>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <div>
                                <small class="text-secondary d-block" style="font-size: 0.68rem;"><?php echo t('Kode', 'Code'); ?></small>
                                <strong class="text-dark" style="font-size: 0.8rem;"><?php echo htmlspecialchars($cert->certificate_code); ?></strong>
                            </div>
                            <div class="text-end">
                                <small class="text-secondary d-block" style="font-size: 0.68rem;"><?php echo t('Tanggal', 'Date'); ?></small>
                                <strong class="text-dark" style="font-size: 0.8rem;"><?php echo date('d M Y', strtotime($cert->issued_at)); ?></strong>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex flex-column gap-2">
                        <a href="<?php echo base_url('certificate/download/' . encode_id($cert->id)); ?>" class="btn btn-dark rounded-pill py-2 fw-bold w-100">
                            <i class="fas fa-download me-2"></i> <?php echo t('Unduh PDF', 'Download PDF'); ?>
                        </a>
                        <a href="<?php echo base_url('certificate/verify/' . $cert->certificate_code); ?>" class="btn btn-outline-dark rounded-pill py-2 fw-semibold w-100" target="_blank">
                            <i class="fas fa-external-link-alt me-2"></i> <?php echo t('Verifikasi', 'Verify'); ?>
                        </a>
                    </div>
                </div>
            </div>

            <!-- ============ DESKTOP ============ -->
            <div class="dashboard-desktop-only">
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-body p-5 text-center">
                        <div class="d-inline-flex align-items-center justify-content-center rounded-circle mb-4" style="width: 80px; height: 80px; background: #E0F2F1;">
                            <i class="fas fa-award fa-lg" style="color: #d97706; font-size: 2rem;"></i>
                        </div>
                        <h3 class="fw-extrabold text-dark mb-2" style="letter-spacing: -0.03em;"><?php echo t('Sertifikat Kelulusan', 'Certificate of Completion'); ?></h3>
                        <p class="text-secondary mb-4"><?php echo t('Dikeluarkan untuk', 'Issued to'); ?> <strong><?php echo htmlspecialchars($cert->user_name ?? $cert->name); ?></strong></p>
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
                                    <a href="<?php echo base_url('certificate/verify/' . $cert->certificate_code); ?>" class="text-primary text-decoration-none fw-semibold" target="_blank"><?php echo base_url('certificate/verify/' . $cert->certificate_code); ?></a>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-center gap-3 flex-wrap">
                            <a href="<?php echo base_url('certificate/download/' . encode_id($cert->id)); ?>" class="btn btn-dark rounded-pill px-4 py-2 fw-semibold"><i class="fas fa-download me-2"></i> <?php echo t('Unduh PDF', 'Download PDF'); ?></a>
                            <a href="<?php echo base_url('certificate/verify/' . $cert->certificate_code); ?>" class="btn btn-outline-dark rounded-pill px-4 py-2 fw-semibold" target="_blank"><i class="fas fa-external-link-alt me-2"></i> <?php echo t('Verifikasi', 'Verify'); ?></a>
                            <a href="<?php echo base_url('certificate/my'); ?>" class="btn btn-outline-secondary rounded-pill px-4 py-2 fw-semibold"><i class="fas fa-arrow-left me-2"></i> <?php echo t('Kembali', 'Back'); ?></a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
