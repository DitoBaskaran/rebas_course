<div class="certificate-page container-fluid py-4" style="padding-top: 0px !important; max-width: 1200px;">

    <!-- ============ MOBILE APP-STYLE ============ -->
    <div class="dashboard-mobile-only">
        <div class="mb-3">
            <h5 class="fw-extrabold mb-0" style="color: #0D1830; font-size: 1.15rem; letter-spacing: -0.02em;">
                <?php echo t('Sertifikat Saya', 'My Certificates'); ?>
            </h5>
            <small style="color: #78716c; font-size: 0.72rem;"><?php echo t('Pencapaian belajarmu', 'Your learning achievements'); ?></small>
        </div>

        <?php $certificates = isset($certificates) ? $certificates : array(); ?>
        <?php if (empty($certificates)): ?>
            <div class="mob-empty">
                <i class="fas fa-award"></i>
                <p><?php echo t('Belum ada sertifikat.', 'No certificates yet.'); ?></p>
                <a href="<?php echo base_url('courses'); ?>"><?php echo t('Selesaikan Kelas', 'Complete a Course'); ?> →</a>
            </div>
        <?php else: ?>
            <div class="d-flex flex-column gap-3">
                <?php foreach ($certificates as $cert): ?>
                    <div class="bg-white rounded-4 border p-4 text-center" style="border-color: #f0eeeb !important; box-shadow: 0 2px 8px rgba(0,0,0,0.04);">
                        <div class="d-inline-flex align-items-center justify-content-center rounded-circle mb-3" style="width: 64px; height: 64px; background: linear-gradient(135deg,#009688,#34d399); color: #fff;">
                            <i class="fas fa-award" style="font-size: 1.5rem;"></i>
                        </div>
                        <h6 class="fw-bold text-dark mb-1" style="font-size: 0.95rem;"><?php echo htmlspecialchars($cert->title ?: $cert->course_title); ?></h6>
                        <p class="text-muted mb-3" style="font-size: 0.72rem;">
                            <i class="far fa-calendar-alt me-1"></i><?php echo t('Diterbitkan', 'Issued'); ?> <?php echo date('d M Y', strtotime($cert->issued_at)); ?>
                        </p>
                        <div class="d-flex gap-2 justify-content-center">
                            <a href="<?php echo base_url('certificate/download/' . encode_id($cert->id)); ?>" class="btn btn-sm fw-bold rounded-pill px-3 py-2" style="background: #0D1830; color: #fff; font-size: 0.72rem;">
                                <i class="fas fa-download me-1"></i> <?php echo t('Unduh PDF', 'Download PDF'); ?>
                            </a>
                            <a href="<?php echo base_url('certificate/verify/' . $cert->certificate_code); ?>" class="btn btn-sm fw-semibold rounded-pill px-3 py-2" style="border: 1px solid #e7e5e4; color: #57534e; font-size: 0.72rem;">
                                <i class="fas fa-external-link-alt me-1"></i> <?php echo t('Verifikasi', 'Verify'); ?>
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>

    <!-- ============ DESKTOP ============ -->
    <div class="dashboard-desktop-only">
        <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-2 gap-md-3 mb-4 mb-md-5">
            <div>
                <h1 class="fw-extrabold text-dark mb-1 page-title" style="letter-spacing:-0.03em;"><?php echo t('Sertifikat Saya', 'My Certificates'); ?></h1>
                <p class="text-secondary mb-0 small"><?php echo t('Sertifikat yang telah Anda peroleh.', 'Certificates you have earned.'); ?></p>
            </div>
        </div>
        <?php if (empty($certificates)): ?>
            <div class="bento-card text-center py-5">
                <i data-lucide="award" style="width:48px;height:48px;color:var(--gray-300);margin-bottom:1rem;"></i>
                <h5 class="mb-2"><?php echo t('Belum ada sertifikat.', 'No certificates yet.'); ?></h5>
                <p class="text-muted small mb-0"><?php echo t('Selesaikan kursus untuk mendapatkan sertifikat.', 'Complete courses to earn certificates.'); ?></p>
            </div>
        <?php else: ?>
            <div class="row g-3 g-lg-4">
                <?php foreach ($certificates as $cert): ?>
                    <div class="col-12 col-md-6 col-lg-6 col-xxl-4 d-flex">
                        <div class="bento-card w-100 d-flex flex-column">
                            <div class="d-flex align-items-start gap-3 mb-3">
                                <div class="d-flex align-items-center justify-content-center bg-warning-subtle text-warning rounded-3 flex-shrink-0" style="width:48px;height:48px;">
                                    <i data-lucide="award" style="width:24px;height:24px;"></i>
                                </div>
                                <div class="flex-fill min-w-0">
                                    <h5 class="fw-bold text-dark mb-1 text-truncate" title="<?php echo htmlspecialchars($cert->title ?: $cert->course_title); ?>"><?php echo htmlspecialchars($cert->title ?: $cert->course_title); ?></h5>
                                    <p class="small text-muted mb-0"><?php echo t('Diterbitkan:', 'Issued:'); ?> <?php echo date('d M Y', strtotime($cert->issued_at)); ?></p>
                                </div>
                            </div>
                            <div class="d-flex flex-column flex-sm-row flex-wrap gap-2 mt-auto">
                                <a href="<?php echo base_url('certificate/download/' . encode_id($cert->id)); ?>" class="btn btn-sm btn-dark rounded-pill px-3 d-inline-flex align-items-center justify-content-center gap-1 flex-grow-1 flex-sm-grow-0">
                                    <i data-lucide="download" style="width:14px;height:14px;"></i>
                                    <span><?php echo t('Unduh PDF', 'Download PDF'); ?></span>
                                </a>
                                <a href="<?php echo base_url('certificate/verify/' . $cert->certificate_code); ?>" class="btn btn-sm btn-outline-dark rounded-pill px-3 d-inline-flex align-items-center justify-content-center gap-1 flex-grow-1 flex-sm-grow-0">
                                    <i data-lucide="external-link" style="width:14px;height:14px;"></i>
                                    <span><?php echo t('Verifikasi', 'Verify'); ?></span>
                                </a>
                            </div>
                            <?php
                            $share_url = base_url('certificate/verify/' . $cert->certificate_code);
                            $share_text = t('Saya telah menyelesaikan ', 'I completed ') . $cert->title . ' di BISATUNTAS!';
                            ?>
                            <div class="d-flex align-items-center flex-wrap gap-2 mt-3 pt-3 border-top">
                                <span class="small text-muted"><?php echo t('Bagikan:', 'Share:'); ?></span>
                                <div class="d-flex align-items-center gap-1">
                                    <a href="https://www.facebook.com/sharer.php?u=<?php echo urlencode($share_url); ?>" target="_blank" rel="noopener" class="btn btn-sm btn-outline-secondary rounded-circle d-inline-flex align-items-center justify-content-center p-0" style="width:32px;height:32px;" aria-label="Facebook"><i data-lucide="facebook" style="width:14px;height:14px;"></i></a>
                                    <a href="https://www.linkedin.com/sharing/share-offsite/?url=<?php echo urlencode($share_url); ?>" target="_blank" rel="noopener" class="btn btn-sm btn-outline-secondary rounded-circle d-inline-flex align-items-center justify-content-center p-0" style="width:32px;height:32px;" aria-label="LinkedIn"><i data-lucide="linkedin" style="width:14px;height:14px;"></i></a>
                                    <a href="https://wa.me/?text=<?php echo urlencode($share_text . ' ' . $share_url); ?>" target="_blank" rel="noopener" class="btn btn-sm btn-outline-secondary rounded-circle d-inline-flex align-items-center justify-content-center p-0" style="width:32px;height:32px;" aria-label="WhatsApp"><i data-lucide="message-circle" style="width:14px;height:14px;"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<style>
.certificate-page .page-title { font-size: 1.5rem; }
@media (min-width: 576px) { .certificate-page .page-title { font-size: 1.75rem; } }
@media (min-width: 768px) { .certificate-page .page-title { font-size: 2.25rem; } }
@media (min-width: 992px) { .certificate-page .page-title { font-size: 2.5rem; } }
</style>
