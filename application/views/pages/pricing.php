<div class="container py-5 my-4">
    <div class="text-center mb-5">
        <span class="badge bg-primary-subtle text-primary badge-modern mb-3">Harga</span>
        <h1 class="display-5 fw-extrabold text-dark mb-3" style="letter-spacing:-0.03em;"><?php echo t('Pilih Paket Belajarmu', 'Choose Your Learning Plan'); ?></h1>
        <p class="text-secondary mx-auto" style="max-width:500px;"><?php echo t('Mulai perjalanan belajarmu dengan paket yang sesuai.', 'Start your learning journey with a plan that fits you.'); ?></p>
    </div>
    <div class="row g-4 justify-content-center">
        <div class="col-md-4">
            <div class="bento-card text-center p-4 p-lg-5">
                <div class="text-secondary small fw-bold text-uppercase tracking-wide mb-3"><?php echo t('Basic', 'Basic'); ?></div>
                <div class="display-4 fw-extrabold text-dark mb-1"><?php echo t('Gratis', 'Free'); ?></div>
                <p class="text-muted small mb-4"><?php echo t('Untuk memulai', 'To get started'); ?></p>
                <ul class="list-unstyled text-start mb-4 small">
                    <li class="py-1"><i data-lucide="check" style="width:16px;height:16px;color:var(--success);" class="me-2"></i>5 kursus gratis</li>
                    <li class="py-1"><i data-lucide="check" style="width:16px;height:16px;color:var(--success);" class="me-2"></i>Akses forum</li>
                    <li class="py-1"><i data-lucide="check" style="width:16px;height:16px;color:var(--success);" class="me-2"></i>Sertifikat terbatas</li>
                    <li class="py-1 text-muted"><i data-lucide="x" style="width:16px;height:16px;" class="me-2"></i>Mentoring</li>
                </ul>
                <a href="<?php echo base_url('auth/register'); ?>" class="btn btn-outline-dark rounded-pill w-100 py-2 fw-semibold"><?php echo t('Daftar Gratis', 'Register Free'); ?></a>
            </div>
        </div>
        <div class="col-md-4">
            <div class="bento-card text-center p-4 p-lg-5 border-primary">
                <span class="badge bg-primary mb-3"><?php echo t('Terpopuler', 'Most Popular'); ?></span>
                <div class="text-secondary small fw-bold text-uppercase tracking-wide mb-3"><?php echo t('Pro', 'Pro'); ?></div>
                <div class="display-4 fw-extrabold text-primary mb-1">Rp 99k</div>
                <p class="text-muted small mb-4"><?php echo t('/bulan', '/month'); ?></p>
                <ul class="list-unstyled text-start mb-4 small">
                    <li class="py-1"><i data-lucide="check" style="width:16px;height:16px;color:var(--success);" class="me-2"></i>Semua kursus</li>
                    <li class="py-1"><i data-lucide="check" style="width:16px;height:16px;color:var(--success);" class="me-2"></i>Sertifikat unlimited</li>
                    <li class="py-1"><i data-lucide="check" style="width:16px;height:16px;color:var(--success);" class="me-2"></i>1x mentoring/bulan</li>
                    <li class="py-1"><i data-lucide="check" style="width:16px;height:16px;color:var(--success);" class="me-2"></i>Akses premium content</li>
                </ul>
                <a href="<?php echo base_url('auth/register'); ?>" class="btn btn-primary rounded-pill w-100 py-2 fw-semibold"><?php echo t('Langganan Sekarang', 'Subscribe Now'); ?></a>
            </div>
        </div>
        <div class="col-md-4">
            <div class="bento-card text-center p-4 p-lg-5">
                <div class="text-secondary small fw-bold text-uppercase tracking-wide mb-3"><?php echo t('Mentor', 'Mentor'); ?></div>
                <div class="display-4 fw-extrabold text-dark mb-1">Rp 350k</div>
                <p class="text-muted small mb-4"><?php echo t('/bulan', '/month'); ?></p>
                <ul class="list-unstyled text-start mb-4 small">
                    <li class="py-1"><i data-lucide="check" style="width:16px;height:16px;color:var(--success);" class="me-2"></i>Semua fitur Pro</li>
                    <li class="py-1"><i data-lucide="check" style="width:16px;height:16px;color:var(--success);" class="me-2"></i>Unlimited mentoring</li>
                    <li class="py-1"><i data-lucide="check" style="width:16px;height:16px;color:var(--success);" class="me-2"></i>Group mentoring</li>
                    <li class="py-1"><i data-lucide="check" style="width:16px;height:16px;color:var(--success);" class="me-2"></i>Prioritas support</li>
                </ul>
                <a href="<?php echo base_url('auth/register'); ?>" class="btn btn-dark rounded-pill w-100 py-2 fw-semibold"><?php echo t('Hubungi Kami', 'Contact Us'); ?></a>
            </div>
        </div>
    </div>
</div>
