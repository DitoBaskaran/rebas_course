<div>
    <div class="row justify-content-center">
        <div class="col-lg-7">
            <div class="text-center mb-5 animate-fade-in-up">
                <h1 class="display-5 fw-extrabold text-dark mb-2 lh-sm" style="letter-spacing: -0.03em;"><?php echo t('Verifikasi Sertifikat', 'Certificate Verification'); ?></h1>
                <p class="text-secondary lead mb-0" style="font-size: 1.1rem;"><?php echo t('Verifikasi keaslian sertifikat BISATUNTAS.', 'Verify the authenticity of BISATUNTAS certificates.'); ?></p>
            </div>

            <?php if ($error): ?>
                <div class="card border-0 shadow-sm rounded-4 p-5 text-center animate-scale-in">
                    <div class="icon-72 bg-danger-subtle text-danger rounded-circle mx-auto mb-4 d-flex align-items-center justify-content-center" style="width: 72px; height: 72px;">
                        <i class="fas fa-exclamation-triangle fa-2x"></i>
                    </div>
                    <h5 class="fw-bold text-dark mb-2"><?php echo t('Sertifikat Tidak Ditemukan', 'Certificate Not Found'); ?></h5>
                    <p class="text-secondary"><?php echo t('Kode sertifikat tidak valid.', 'Invalid certificate code.'); ?></p>
                </div>
            <?php else: ?>
                <div class="card border-0 shadow-lg rounded-4 p-5 text-center animate-scale-in" style="border: 3px solid #f59e0b;">
                    <div class="icon-72 bg-warning-subtle text-warning rounded-circle mx-auto mb-4 d-flex align-items-center justify-content-center" style="width: 72px; height: 72px;">
                        <i class="fas fa-award fa-2x"></i>
                    </div>
                    <h4 class="fw-extrabold text-dark mb-1" style="letter-spacing: -0.03em;"><?php echo t('Sertifikat Valid', 'Valid Certificate'); ?></h4>
                    <p class="text-success fw-semibold mb-4"><i class="fas fa-check-circle me-1"></i> <?php echo t('Telah terverifikasi', 'Verified'); ?></p>

                    <div class="bg-light rounded-4 p-4 mb-4">
                        <p class="small text-secondary mb-1"><?php echo t('Diberikan kepada', 'Awarded to'); ?></p>
                        <h4 class="fw-extrabold text-dark mb-0"><?php echo htmlspecialchars($cert->user_name); ?></h4>
                    </div>
                    <div class="bg-light rounded-4 p-4 mb-4">
                        <p class="small text-secondary mb-1"><?php echo t('Atas penyelesaian', 'For completing'); ?></p>
                        <h5 class="fw-bold text-dark mb-0"><?php echo htmlspecialchars($cert->title); ?></h5>
                    </div>

                    <div class="d-flex justify-content-center gap-5 pt-3 border-top border-light">
                        <div class="text-center">
                            <p class="small text-secondary mb-1 fw-medium"><?php echo t('Kode Sertifikat', 'Certificate Code'); ?></p>
                            <span class="fw-bold text-dark font-monospace"><?php echo $cert->certificate_code; ?></span>
                        </div>
                        <div class="text-center">
                            <p class="small text-secondary mb-1 fw-medium"><?php echo t('Tanggal Terbit', 'Issued Date'); ?></p>
                            <span class="fw-bold text-dark"><?php echo date('d M Y', strtotime($cert->issued_at)); ?></span>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <div class="text-center mt-4 pt-3">
                <p class="text-secondary small">
                    <?php echo t('Cari sertifikat lain? ', 'Search another certificate? '); ?>
                    <a href="#" onclick="const c=prompt('<?php echo t('Masukkan kode sertifikat:', 'Enter certificate code:'); ?>');if(c)window.location='<?php echo base_url('certificate/verify/'); ?>'+c;return false;" class="text-primary fw-semibold text-decoration-none border-bottom border-primary pb-1"><?php echo t('Cari', 'Search'); ?></a>
                </p>
            </div>
        </div>
    </div>
