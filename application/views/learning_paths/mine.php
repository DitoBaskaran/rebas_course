<div class="container-fluid px-0">

    <!-- ============ HEADER (hero) ============ -->
    <?php
        $total_pct = 0;
        foreach ($learning_paths as $lp) { $total_pct += (int)($lp->progress_pct ?? 0); }
        $avg_pct = count($learning_paths) > 0 ? round($total_pct / count($learning_paths)) : 0;
    ?>
    <div class="bento-card mb-4 overflow-hidden" style="background:linear-gradient(120deg,#0D1830 0%,#4361ee 150%);border:none;color:#fff;">
        <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3 position-relative" style="z-index:1;">
            <div>
                <span class="d-inline-flex align-items-center gap-1" style="background:rgba(255,255,255,0.14);border:1px solid rgba(255,255,255,0.2);color:#FBBF24;font-size:0.66rem;font-weight:800;letter-spacing:0.12em;text-transform:uppercase;padding:0.3rem 0.7rem;border-radius:100px;">
                    <i data-lucide="route" style="width:12px;height:12px;"></i> <?php echo t('Jalur Belajar', 'Learning Paths'); ?>
                </span>
                <h1 class="fw-extrabold text-white mb-1 mt-2 lh-sm" style="letter-spacing:-0.03em;font-size:1.5rem;">
                    <?php echo t('Learning Path Saya', 'My Learning Paths'); ?>
                </h1>
                <p class="mb-0" style="color:rgba(255,255,255,0.72);font-size:0.8rem;">
                    <?php echo t('Learning path yang sedang kamu ikuti.', 'Learning paths you are currently following.'); ?>
                    <span class="fw-semibold text-white">(<?php echo count($learning_paths); ?> · <?php echo $avg_pct; ?>% <?php echo t('rata-rata', 'avg'); ?>)</span>
                </p>
            </div>
            <a href="<?php echo base_url('learning_paths'); ?>" class="btn fw-semibold rounded-pill d-inline-flex align-items-center gap-2 border-0 flex-shrink-0" style="background:#FBBF24;color:#0D1830;font-size:0.78rem;padding:0.55rem 1.1rem;box-shadow:0 4px 14px rgba(251,191,36,0.3);">
                <i data-lucide="compass" style="width:14px;height:14px;"></i> <?php echo t('Lihat Learning Paths', 'Browse Learning Paths'); ?>
            </a>
        </div>
    </div>

    <?php if (empty($learning_paths)): ?>
        <div class="bento-card p-5 text-center">
            <div class="mx-auto d-inline-flex align-items-center justify-content-center rounded-circle mb-3" style="width:72px;height:72px;background:#eff6ff;color:#4361ee;">
                <i data-lucide="route" style="width:30px;height:30px;"></i>
            </div>
            <h5 class="fw-extrabold text-dark mb-1"><?php echo t('Belum Ada Learning Path', 'No Learning Paths Yet'); ?></h5>
            <p class="text-secondary small mb-4"><?php echo t('Kamu belum mengikuti learning path apapun.', 'You have not joined any learning paths.'); ?></p>
            <a href="<?php echo base_url('learning_paths'); ?>" class="btn btn-primary rounded-pill px-4 fw-semibold"><?php echo t('Lihat Learning Paths', 'Browse Learning Paths'); ?></a>
        </div>
    <?php else: ?>
        <!-- ============ PATH LIST ============ -->
        <div class="d-flex flex-column" style="gap:10px;">
            <?php foreach ($learning_paths as $lp): ?>
                <?php $pct = (int)($lp->progress_pct ?? 0); $color = $lp->color ?? '#4361ee'; ?>
                <div class="lp-mine-card">
                    <span class="d-inline-flex align-items-center justify-content-center rounded-3 flex-shrink-0" style="width:48px;height:48px;background:<?php echo $color; ?>;color:#fff;">
                        <i data-lucide="route" style="width:22px;height:22px;"></i>
                    </span>
                    <div class="flex-fill" style="min-width:0;">
                        <div class="fw-bold text-dark text-truncate" style="font-size:0.88rem;"><?php echo htmlspecialchars($lp->title); ?></div>
                        <div class="text-secondary text-truncate" style="font-size:0.72rem;"><?php echo htmlspecialchars($lp->description ?? ''); ?></div>
                        <div class="d-flex align-items-center gap-2 mt-2">
                            <div class="flex-fill rounded-pill overflow-hidden" style="height:6px;background:var(--gray-200,#e7e5e4);">
                                <div class="h-100 rounded-pill" style="width:<?php echo $pct; ?>%;background:<?php echo $color; ?>;"></div>
                            </div>
                            <span class="fw-extrabold flex-shrink-0" style="color:<?php echo $color; ?>;font-size:0.75rem;min-width:34px;text-align:right;"><?php echo $pct; ?>%</span>
                        </div>
                    </div>
                    <a href="<?php echo base_url('learning_paths/detail/' . $lp->slug); ?>" class="btn btn-sm fw-semibold rounded-pill flex-shrink-0" style="background:#0D1830;color:#fff;font-size:0.72rem;padding:0.4rem 0.9rem;">
                        <?php echo t('Lihat', 'View'); ?> <i class="fas fa-arrow-right" style="font-size:0.55rem;"></i>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>
