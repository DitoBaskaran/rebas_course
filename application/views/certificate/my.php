<div class="certificate-page">
    <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-2 gap-md-3 mb-4 mb-md-5">
        <div>
            <h1 class="fw-extrabold text-dark mb-1 page-title" style="letter-spacing:-0.03em;"><?php echo t('Sertifikat Saya', 'My Certificates'); ?></h1>
            <p class="text-secondary mb-0 small"><?php echo t('Sertifikat yang telah Anda peroleh.', 'Certificates you have earned.'); ?></p>
        </div>
    </div>
    <?php $certificates = isset($certificates) ? $certificates : array(); ?>
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

<style>
.certificate-page .page-title { font-size: 1.5rem; }
@media (min-width: 576px) {
    .certificate-page .page-title { font-size: 1.75rem; }
}
@media (min-width: 768px) {
    .certificate-page .page-title { font-size: 2.25rem; }
}
@media (min-width: 992px) {
    .certificate-page .page-title { font-size: 2.5rem; }
}
</style>
