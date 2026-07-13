<div class="container-fluid px-0">
    <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between mb-5 gap-3">
        <div>
            <span class="text-primary fw-semibold small text-uppercase tracking-wide d-block mb-1">Mentoring</span>
            <h1 class="display-6 fw-extrabold text-dark mb-1 lh-sm" style="letter-spacing: -0.03em;"><?php echo t('Jadwal Mentoring', 'Mentoring Schedule'); ?></h1>
            <p class="text-secondary mb-0"><?php echo t('Semua sesi mentoring dari siswa.', 'All student mentoring sessions.'); ?></p>
        </div>
    </div>

    <div class="bento-card p-4 p-xl-5">
        <?php if (empty($sessions)): ?>
            <div class="empty-state">
                <i data-lucide="calendar-check" style="width:48px;height:48px;color:var(--gray-300);"></i>
                <h5><?php echo t('Belum ada sesi mentoring.', 'No mentoring sessions yet.'); ?></h5>
            </div>
        <?php else: ?>
            <div class="d-flex flex-column gap-3">
                <?php foreach ($sessions as $s): ?>
                    <div class="d-flex flex-column flex-md-row align-items-md-center gap-3 p-4 rounded-3 border" style="background:var(--card-bg);border-color:var(--card-border)!important;">
                        <div class="d-flex align-items-center gap-3 flex-fill min-w-0">
                            <div class="d-flex align-items-center justify-content-center rounded-circle fw-bold flex-shrink-0" style="width:40px;height:40px;background:var(--primary-light);color:var(--primary);font-size:0.875rem;">
                                <?php echo strtoupper(substr($s->student_name, 0, 1)); ?>
                            </div>
                            <div class="min-w-0">
                                <div class="fw-semibold text-dark small"><?php echo htmlspecialchars($s->student_name); ?></div>
                                <div class="small text-muted">
                                    <?php echo t('Mentor', 'Mentor'); ?>: <?php echo htmlspecialchars($s->mentor_name); ?>
                                    <?php if ($s->course_title): ?>
                                        &middot; <?php echo htmlspecialchars($s->course_title); ?>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex align-items-center gap-3 flex-shrink-0">
                            <div class="small text-muted text-end">
                                <div class="fw-semibold text-dark"><?php echo date('d M Y', strtotime($s->scheduled_at)); ?></div>
                                <div><?php echo date('H:i', strtotime($s->scheduled_at)); ?> WIB &middot; <?php echo $s->duration; ?> min</div>
                            </div>
                            <?php if ($s->status === 'scheduled'): ?>
                                <span class="badge bg-primary rounded-pill px-3 py-2 fw-medium"><?php echo t('Terjadwal', 'Scheduled'); ?></span>
                            <?php elseif ($s->status === 'completed'): ?>
                                <span class="badge bg-success rounded-pill px-3 py-2 fw-medium"><?php echo t('Selesai', 'Completed'); ?></span>
                            <?php elseif ($s->status === 'cancelled'): ?>
                                <span class="badge bg-danger rounded-pill px-3 py-2 fw-medium"><?php echo t('Dibatalkan', 'Cancelled'); ?></span>
                            <?php endif; ?>
                        </div>
                        <?php if ($s->meeting_link && $s->status === 'scheduled'): ?>
                            <a href="<?php echo $s->meeting_link; ?>" target="_blank" class="btn btn-outline-dark btn-sm rounded-pill px-3 flex-shrink-0">
                                <i data-lucide="video" style="width:14px;height:14px;"></i> <?php echo t('Gabung', 'Join'); ?>
                            </a>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>
