<div>
    <div class="d-flex align-items-center justify-content-between mb-5">
        <div>
            <h1 class="display-6 fw-extrabold text-dark mb-1" style="letter-spacing:-0.03em;"><?php echo t('Sertifikat Saya', 'My Certificates'); ?></h1>
            <p class="text-secondary mb-0"><?php echo t('Sertifikat yang telah Anda peroleh.', 'Certificates you have earned.'); ?></p>
        </div>
    </div>
    <?php $certificates = isset($certificates) ? $certificates : array(); ?>
    <?php if (empty($certificates)): ?>
        <div class="bento-card text-center py-5">
            <i data-lucide="award" style="width:48px;height:48px;color:var(--gray-300);margin-bottom:1rem;"></i>
            <h5><?php echo t('Belum ada sertifikat.', 'No certificates yet.'); ?></h5>
            <p class="text-muted small"><?php echo t('Selesaikan kursus untuk mendapatkan sertifikat.', 'Complete courses to earn certificates.'); ?></p>
        </div>
    <?php else: ?>
        <div class="row g-4">
            <?php foreach ($certificates as $cert): ?>
                <div class="col-md-6">
                    <div class="bento-card">
                        <div class="d-flex align-items-start gap-3">
                            <div class="d-flex align-items-center justify-content-center bg-warning-subtle text-warning rounded-2 flex-shrink-0" style="width:48px;height:48px;">
                                <i data-lucide="award" style="width:24px;height:24px;"></i>
                            </div>
                            <div class="flex-fill min-w-0">
                                <h5 class="fw-bold text-dark mb-1"><?php echo htmlspecialchars($cert->title ?: $cert->course_title); ?></h5>
                                <p class="small text-muted mb-2"><?php echo t('Diterbitkan:', 'Issued:'); ?> <?php echo date('d M Y', strtotime($cert->issued_at)); ?></p>
                                <div class="d-flex gap-2 flex-wrap">
                                    <a href="<?php echo base_url('certificate/download/' . encode_id($cert->id)); ?>" class="btn btn-sm btn-dark rounded-pill px-3">
                                        <i data-lucide="download" style="width:14px;height:14px;"></i> <?php echo t('Unduh PDF', 'Download PDF'); ?>
                                    </a>
                                    <a href="<?php echo base_url('certificate/verify/' . $cert->certificate_code); ?>" class="btn btn-sm btn-outline-dark rounded-pill px-3">
                                        <i data-lucide="external-link" style="width:14px;height:14px;"></i> <?php echo t('Verifikasi', 'Verify'); ?>
                                    </a>
                                    <?php
                                    $share_url = base_url('certificate/verify/' . $cert->certificate_code);
                                    $share_text = t('Saya telah menyelesaikan ', 'I completed ') . $cert->title . ' di BISATUNTAS!';
                                    $share_image = '';
                                    ?>
                                    <div class="d-flex align-items-center gap-1 ms-2">
                                        <span class="small text-muted"><?php echo t('Bagikan:', 'Share:'); ?></span>
                                        <a href="https://www.facebook.com/sharer.php?u=<?php echo urlencode($share_url); ?>" target="_blank" class="btn btn-sm btn-outline-secondary rounded-circle" style="width:30px;height:30px;"><i data-lucide="facebook" style="width:12px;height:12px;"></i></a>
                                        <a href="https://www.linkedin.com/sharing/share-offsite/?url=<?php echo urlencode($share_url); ?>" target="_blank" class="btn btn-sm btn-outline-secondary rounded-circle" style="width:30px;height:30px;"><i data-lucide="linkedin" style="width:12px;height:12px;"></i></a>
                                        <a href="https://wa.me/?text=<?php echo urlencode($share_text . ' ' . $share_url); ?>" target="_blank" class="btn btn-sm btn-outline-secondary rounded-circle" style="width:30px;height:30px;"><i data-lucide="message-circle" style="width:12px;height:12px;"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
