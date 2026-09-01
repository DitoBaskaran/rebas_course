<div class="container-fluid py-4" style="padding-top: 0px !important; max-width: 1100px;">
    <div class="mb-4">
        <h4 class="fw-extrabold mb-1" style="color: #0D1830; letter-spacing: -0.02em;"><?php echo t('Learning Path Saya', 'My Learning Paths'); ?></h4>
        <p style="color: #78716c; font-size: 0.85rem; margin-bottom: 0;"><?php echo t('Learning path yang sedang kamu ikuti.', 'Learning paths you are currently following.'); ?></p>
    </div>

    <?php if (empty($learning_paths)): ?>
        <div class="text-center py-5">
            <div style="font-size: 2.5rem; color: #d4d4d4; margin-bottom: 0.75rem;"><i class="fas fa-route"></i></div>
            <h6 class="fw-bold" style="color: #0D1830;"><?php echo t('Belum Ada Learning Path', 'No Learning Paths Yet'); ?></h6>
            <p style="color: #78716c; font-size: 0.85rem; margin-bottom: 1rem;"><?php echo t('Kamu belum mengikuti learning path apapun.', 'You have not joined any learning paths.'); ?></p>
            <a href="<?php echo base_url('learning_paths'); ?>" class="btn rounded-pill px-4 py-2 fw-semibold" style="background: #009688; color: #fff; font-size: 0.85rem;"><?php echo t('Lihat Learning Paths', 'Browse Learning Paths'); ?></a>
        </div>
    <?php else: ?>
        <div class="d-flex flex-column gap-3">
            <?php foreach ($learning_paths as $lp): ?>
                <div class="lp-mob-card d-flex align-items-center gap-3 p-3">
                    <div class="d-flex align-items-center justify-content-center rounded-2 flex-shrink-0" style="width:52px;height:52px;background:<?php echo $lp->color ?? '#009688'; ?>;color:#fff;">
                        <i class="fas fa-road fa-lg"></i>
                    </div>
                    <div class="flex-fill min-w-0">
                        <h6 class="fw-bold text-truncate mb-1" style="color: #0D1830; font-size: 0.88rem;"><?php echo htmlspecialchars($lp->title); ?></h6>
                        <div class="d-flex align-items-center gap-2">
                            <div class="rounded-pill overflow-hidden flex-fill" style="height: 6px; background: #E6EBEF;">
                                <div style="height: 100%; width: <?php echo $lp->progress_pct ?? 0; ?>%; background: linear-gradient(90deg,#009688,#00796B);"></div>
                            </div>
                            <span class="small fw-bold flex-shrink-0" style="color: #009688;"><?php echo $lp->progress_pct ?? 0; ?>%</span>
                        </div>
                    </div>
                    <a href="<?php echo base_url('learning_paths/detail/' . $lp->slug); ?>" class="btn btn-sm fw-bold rounded-pill px-3 flex-shrink-0" style="background:#E0F2F1; color:#009688; font-size:0.72rem;"><?php echo t('Lihat', 'View'); ?></a>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>
