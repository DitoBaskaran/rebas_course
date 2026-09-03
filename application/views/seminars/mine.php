<div class="container-fluid px-0">

    <!-- ============ HEADER (hero) ============ -->
    <?php
        $up_n = 0;
        foreach ($registered_seminars as $sem) { if (strtotime($sem->date_time) > time()) $up_n++; }
    ?>
    <div class="bento-card mb-4 overflow-hidden" style="background:linear-gradient(120deg,#0D1830 0%,#00796B 140%);border:none;color:#fff;">
        <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3 position-relative" style="z-index:1;">
            <div>
                <span class="d-inline-flex align-items-center gap-1" style="background:rgba(255,255,255,0.14);border:1px solid rgba(255,255,255,0.2);color:#FBBF24;font-size:0.66rem;font-weight:800;letter-spacing:0.12em;text-transform:uppercase;padding:0.3rem 0.7rem;border-radius:100px;">
                    <i data-lucide="calendar" style="width:12px;height:12px;"></i> <?php echo t('Seminar', 'Seminars'); ?>
                </span>
                <h1 class="fw-extrabold text-white mb-1 mt-2 lh-sm" style="letter-spacing:-0.03em;font-size:1.5rem;">
                    <?php echo t('Seminar Saya', 'My Seminars'); ?>
                </h1>
                <p class="mb-0" style="color:rgba(255,255,255,0.72);font-size:0.8rem;">
                    <?php echo t('Seminar yang sudah kamu daftar.', 'Seminars you have registered for.'); ?>
                    <span class="fw-semibold text-white">(<?php echo count($registered_seminars); ?> · <?php echo $up_n; ?> <?php echo t('mendatang', 'upcoming'); ?>)</span>
                </p>
            </div>
            <a href="<?php echo base_url('seminars'); ?>" class="btn fw-semibold rounded-pill d-inline-flex align-items-center gap-2 border-0 flex-shrink-0" style="background:#FBBF24;color:#0D1830;font-size:0.78rem;padding:0.55rem 1.1rem;box-shadow:0 4px 14px rgba(251,191,36,0.3);">
                <i data-lucide="search" style="width:14px;height:14px;"></i> <?php echo t('Cari Seminar', 'Browse Seminars'); ?>
            </a>
        </div>
    </div>

    <?php if (empty($registered_seminars)): ?>
        <div class="bento-card p-5 text-center">
            <div class="mx-auto d-inline-flex align-items-center justify-content-center rounded-circle mb-3" style="width:72px;height:72px;background:#E0F2F1;color:#009688;">
                <i data-lucide="calendar" style="width:30px;height:30px;"></i>
            </div>
            <h5 class="fw-extrabold text-dark mb-1"><?php echo t('Belum Ada Seminar', 'No Seminars Yet'); ?></h5>
            <p class="text-secondary small mb-4"><?php echo t('Kamu belum mendaftar seminar apapun.', 'You have not registered for any seminars.'); ?></p>
            <a href="<?php echo base_url('seminars'); ?>" class="btn btn-primary rounded-pill px-4 fw-semibold"><?php echo t('Cari Seminar', 'Browse Seminars'); ?></a>
        </div>
    <?php else: ?>
        <!-- ============ SEMINAR LIST ============ -->
        <div class="d-flex flex-column" style="gap:10px;">
            <?php foreach ($registered_seminars as $sem): ?>
                <?php
                    $upcoming = strtotime($sem->date_time) > time();
                    $is_live_soon = $upcoming && strtotime($sem->date_time) < time() + 3600;
                ?>
                <div class="sem-mine-card">
                    <!-- Date block -->
                    <div class="d-flex flex-column align-items-center justify-content-center rounded-3 flex-shrink-0 fw-bold <?php echo $upcoming ? 'sem-date-up' : 'sem-date-past'; ?>" style="width:56px;height:60px;">
                        <span style="font-size:0.6rem;text-transform:uppercase;opacity:0.75;"><?php echo date('M', strtotime($sem->date_time)); ?></span>
                        <span style="font-size:1.2rem;line-height:1.15;"><?php echo date('d', strtotime($sem->date_time)); ?></span>
                    </div>
                    <div class="flex-fill" style="min-width:0;">
                        <div class="fw-bold text-dark" style="font-size:0.88rem;line-height:1.35;"><?php echo htmlspecialchars(t($sem->title, $sem->title_en ?: $sem->title)); ?></div>
                        <div class="d-flex align-items-center gap-1 mt-1 flex-wrap" style="color:#78716c;font-size:0.72rem;">
                            <i data-lucide="clock" style="width:11px;height:11px;"></i>
                            <span><?php echo date('d M Y · H:i', strtotime($sem->date_time)); ?> WIB</span>
                            <?php if ($upcoming): ?>
                                <span class="px-2 py-0 rounded-pill fw-bold" style="background:#E0F2F1;color:#009688;font-size:0.6rem;"><?php echo t('Mendatang', 'Upcoming'); ?></span>
                            <?php else: ?>
                                <span class="px-2 py-0 rounded-pill fw-bold" style="background:#f1f5f9;color:#64748b;font-size:0.6rem;"><?php echo t('Selesai', 'Ended'); ?></span>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php if (!empty($sem->location_link) && $upcoming): ?>
                    <a href="<?php echo $sem->location_link; ?>" target="_blank" class="btn btn-sm fw-semibold rounded-pill d-inline-flex align-items-center gap-1 flex-shrink-0" style="background:#25D366;color:#fff;font-size:0.7rem;padding:0.4rem 0.9rem;">
                        <i class="fas fa-video" style="font-size:0.6rem;"></i> <?php echo t('Gabung', 'Join'); ?>
                    </a>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>
