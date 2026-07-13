<div>
    <div class="mb-4">
        <h2 class="fw-extrabold text-dark mb-1" style="letter-spacing: -0.03em;"><?php echo t('Learning Path Saya', 'My Learning Paths'); ?></h2>
        <p class="text-secondary mb-0"><?php echo t('Learning path yang sedang kamu ikuti.', 'Learning paths you are currently following.'); ?></p>
    </div>

    <?php if (empty($learning_paths)): ?>
    <div class="text-center py-5">
        <div class="icon-48 bg-light rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center">
            <i class="fas fa-route text-secondary"></i>
        </div>
        <h6 class="fw-bold text-dark"><?php echo t('Belum Ada Learning Path', 'No Learning Paths Yet'); ?></h6>
        <p class="text-secondary small mb-3"><?php echo t('Kamu belum mengikuti learning path apapun.', 'You have not joined any learning paths.'); ?></p>
        <a href="<?php echo base_url('learning_paths'); ?>" class="btn btn-dark rounded-pill px-4 py-2 fw-semibold"><?php echo t('Lihat Learning Paths', 'Browse Learning Paths'); ?></a>
    </div>
    <?php else: ?>
    <div class="d-flex flex-column gap-3">
        <?php foreach ($learning_paths as $lp): ?>
        <div class="d-flex align-items-center gap-3 p-4 rounded-3 bg-white border">
            <div class="d-flex align-items-center justify-content-center rounded-2 flex-shrink-0" style="width:56px;height:56px;background:<?php echo $lp->color ?? '#4361ee'; ?>15;color:<?php echo $lp->color ?? '#4361ee'; ?>;">
                <i class="fas fa-road fa-lg"></i>
            </div>
            <div class="flex-fill min-w-0">
                <h6 class="fw-bold text-dark mb-1 small"><?php echo htmlspecialchars($lp->title); ?></h6>
                <div class="d-flex align-items-center gap-2 mt-2">
                    <div class="progress-modern flex-fill" style="height: 6px;"><div class="progress-bar" style="width: <?php echo $lp->progress_pct ?? 0; ?>%;"></div></div>
                    <span class="small fw-bold text-primary flex-shrink-0"><?php echo $lp->progress_pct ?? 0; ?>%</span>
                </div>
            </div>
            <a href="<?php echo base_url('learning_paths/detail/' . $lp->slug); ?>" class="btn btn-outline-dark btn-sm rounded-pill px-3 fw-semibold"><?php echo t('Lihat', 'View'); ?></a>
        </div>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>
</div>
