<div class="certificate-page container-fluid px-0">

    <!-- ============ HEADER (hero) ============ -->
    <div class="bento-card mb-4 overflow-hidden" style="background:linear-gradient(120deg,#0D1830 0%,#d97706 160%);border:none;color:#fff;">
        <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3 position-relative" style="z-index:1;">
            <div>
                <span class="d-inline-flex align-items-center gap-1" style="background:rgba(255,255,255,0.14);border:1px solid rgba(255,255,255,0.2);color:#FBBF24;font-size:0.66rem;font-weight:800;letter-spacing:0.12em;text-transform:uppercase;padding:0.3rem 0.7rem;border-radius:100px;">
                    <i data-lucide="award" style="width:12px;height:12px;"></i> <?php echo t('Pencapaian', 'Achievements'); ?>
                </span>
                <h1 class="fw-extrabold text-white mb-1 mt-2 lh-sm" style="letter-spacing:-0.03em;font-size:1.6rem;">
                    <?php echo t('Sertifikat Saya', 'My Certificates'); ?>
                </h1>
                <p class="mb-0" style="color:rgba(255,255,255,0.72);font-size:0.82rem;">
                    <?php echo t('Pencapaian belajarmu.', 'Your learning achievements.'); ?>
                    <span class="fw-semibold text-white">(<?php echo count($certificates ?? array()); ?>)</span>
                </p>
            </div>
            <?php if (!empty($certificates)): ?>
            <a href="<?php echo base_url('certificate/my'); ?>" class="btn fw-semibold rounded-pill d-inline-flex align-items-center gap-2 border-0 flex-shrink-0" style="background:#FBBF24;color:#0D1830;font-size:0.78rem;padding:0.55rem 1.1rem;box-shadow:0 4px 14px rgba(251,191,36,0.3);">
                <i data-lucide="download" style="width:14px;height:14px;"></i> <?php echo t('Unduh', 'Download'); ?>
            </a>
            <?php endif; ?>
        </div>
    </div>

    <?php $certificates = isset($certificates) ? $certificates : array(); ?>
    <?php if (empty($certificates)): ?>
        <div class="bento-card p-5 text-center">
            <div class="mx-auto d-inline-flex align-items-center justify-content-center rounded-circle mb-3" style="width:72px;height:72px;background:#fffbeb;color:#d97706;">
                <i data-lucide="award" style="width:30px;height:30px;"></i>
            </div>
            <h5 class="fw-extrabold text-dark mb-1"><?php echo t('Belum ada sertifikat.', 'No certificates yet.'); ?></h5>
            <p class="text-secondary small mb-4"><?php echo t('Selesaikan kursus untuk mendapatkan sertifikat.', 'Complete courses to earn certificates.'); ?></p>
            <a href="<?php echo base_url('courses'); ?>" class="btn btn-primary rounded-pill px-4 fw-semibold d-inline-flex align-items-center gap-2">
                <i data-lucide="book-open" style="width:15px;height:15px;"></i> <?php echo t('Selesaikan Kelas', 'Complete a Course'); ?>
            </a>
        </div>
    <?php else: ?>
        <!-- ============ CERTIFICATE CARDS ============ -->
        <div class="bento-grid bento-grid-3" style="align-items:stretch;">
            <?php foreach ($certificates as $cert): ?>
                <div class="bento-card p-0 cert-card" style="display:flex;flex-direction:column;overflow:hidden;">
                    <!-- Ribbon header -->
                    <div class="d-flex align-items-center gap-3 px-4 py-3" style="background:linear-gradient(120deg,#0D1830 0%,#b45309 140%);">
                        <span class="d-inline-flex align-items-center justify-content-center rounded-circle flex-shrink-0" style="width:42px;height:42px;background:rgba(255,255,255,0.14);border:1px solid rgba(255,255,255,0.25);">
                            <i class="fas fa-award" style="color:#FBBF24;font-size:1.1rem;"></i>
                        </span>
                        <div class="flex-fill" style="min-width:0;">
                            <div class="fw-bold text-white text-truncate" style="font-size:0.88rem;" title="<?php echo htmlspecialchars($cert->title ?: $cert->course_title); ?>"><?php echo htmlspecialchars($cert->title ?: $cert->course_title); ?></div>
                            <div style="color:rgba(255,255,255,0.6);font-size:0.68rem;">
                                <i data-lucide="calendar" style="width:10px;height:10px;" class="me-1"></i><?php echo t('Diterbitkan', 'Issued'); ?> <?php echo date('d M Y', strtotime($cert->issued_at)); ?>
                            </div>
                        </div>
                    </div>
                    <!-- Body -->
                    <div class="p-4 text-center d-flex flex-column" style="flex:1;">
                        <div class="mx-auto d-inline-flex align-items-center justify-content-center rounded-circle mb-3" style="width:64px;height:64px;background:linear-gradient(135deg,#009688,#34d399);color:#fff;box-shadow:0 6px 16px rgba(0,150,136,0.25);">
                            <i class="fas fa-certificate" style="font-size:1.4rem;"></i>
                        </div>
                        <div class="fw-bold text-dark mb-1" style="font-size:0.95rem;"><?php echo htmlspecialchars($cert->title ?: $cert->course_title); ?></div>
                        <div class="text-muted mb-3 d-inline-flex align-items-center justify-content-center gap-1 mx-auto" style="font-size:0.7rem;">
                            <span class="px-2 py-0 rounded-pill fw-semibold" style="background:#E6EBEF;color:#57534e;font-size:0.6rem;"><?php echo htmlspecialchars(substr($cert->certificate_code, 0, 12)); ?>…</span>
                        </div>
                        <div class="d-flex gap-2 justify-content-center mt-auto">
                            <a href="<?php echo base_url('certificate/download/' . encode_id($cert->id)); ?>" class="btn btn-sm fw-bold rounded-pill px-3 d-inline-flex align-items-center gap-1" style="background:#0D1830;color:#fff;font-size:0.72rem;">
                                <i class="fas fa-download" style="font-size:0.62rem;"></i> <?php echo t('Unduh PDF', 'Download PDF'); ?>
                            </a>
                            <a href="<?php echo base_url('certificate/verify/' . $cert->certificate_code); ?>" class="btn btn-sm fw-semibold rounded-pill px-3 d-inline-flex align-items-center gap-1" style="border:1px solid var(--gray-300,#d4d4d4);color:#57534e;font-size:0.72rem;">
                                <i class="fas fa-external-link-alt" style="font-size:0.6rem;"></i> <?php echo t('Verifikasi', 'Verify'); ?>
                            </a>
                        </div>
                    </div>
                    <!-- Share footer -->
                    <?php
                        $share_url = base_url('certificate/verify/' . $cert->certificate_code);
                        $share_text = t('Saya telah menyelesaikan ', 'I completed ') . $cert->title . ' di BISATUNTAS!';
                    ?>
                    <div class="d-flex align-items-center justify-content-center gap-2 px-3 py-2" style="border-top:1px solid var(--card-border,#eef0f3);">
                        <span class="small text-muted" style="font-size:0.68rem;"><?php echo t('Bagikan:', 'Share:'); ?></span>
                        <a href="https://www.facebook.com/sharer.php?u=<?php echo urlencode($share_url); ?>" target="_blank" rel="noopener" class="cert-share-btn" aria-label="Facebook"><i class="fab fa-facebook-f" style="font-size:0.75rem;"></i></a>
                        <a href="https://www.linkedin.com/sharing/share-offsite/?url=<?php echo urlencode($share_url); ?>" target="_blank" rel="noopener" class="cert-share-btn" aria-label="LinkedIn"><i class="fab fa-linkedin-in" style="font-size:0.75rem;"></i></a>
                        <a href="https://wa.me/?text=<?php echo urlencode($share_text . ' ' . $share_url); ?>" target="_blank" rel="noopener" class="cert-share-btn" aria-label="WhatsApp"><i class="fab fa-whatsapp" style="font-size:0.8rem;"></i></a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>
