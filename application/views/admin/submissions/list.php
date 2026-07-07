<div class="container-fluid px-0">
    <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between mb-5 gap-3">
        <div>
            <span class="text-primary fw-semibold small text-uppercase tracking-wide d-block mb-1">Penilaian</span>
            <h1 class="display-6 fw-extrabold text-dark mb-1 lh-sm" style="letter-spacing: -0.03em;"><?php echo t('Tugas Siswa', 'Student Submissions'); ?></h1>
            <p class="text-secondary mb-0"><?php echo t('Nilai tugas yang dikumpulkan siswa.', 'Grade student assignment submissions.'); ?></p>
        </div>
    </div>

    <div class="bento-card p-4 p-xl-5">
        <?php if (empty($submissions)): ?>
            <div class="empty-state">
                <i data-lucide="code" style="width:48px;height:48px;color:var(--gray-300);"></i>
                <h5><?php echo t('Belum ada submission.', 'No submissions yet.'); ?></h5>
            </div>
        <?php else: ?>
            <div class="d-flex flex-column gap-3">
                <?php foreach ($submissions as $s): ?>
                    <div class="d-flex flex-column flex-md-row align-items-md-center gap-3 p-4 rounded-3 border" style="background:var(--card-bg);border-color:var(--card-border)!important;">
                        <div class="d-flex align-items-center gap-3 flex-fill min-w-0">
                            <div class="d-flex align-items-center justify-content-center rounded-circle fw-bold flex-shrink-0" style="width:40px;height:40px;background:var(--primary-light);color:var(--primary);font-size:0.875rem;">
                                <?php echo strtoupper(substr($s->user_name, 0, 1)); ?>
                            </div>
                            <div class="min-w-0">
                                <div class="fw-semibold text-dark small"><?php echo htmlspecialchars($s->user_name); ?></div>
                                <div class="small text-muted">
                                    <?php echo htmlspecialchars($s->course_title); ?> &middot; <?php echo htmlspecialchars($s->assignment_title); ?>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex align-items-center gap-2 flex-shrink-0">
                            <?php if ($s->status === 'graded'): ?>
                                <span class="badge bg-success rounded-pill px-3 py-2 fw-medium"><?php echo t('Dinilai', 'Graded'); ?></span>
                                <span class="fw-bold text-dark small"><?php echo $s->grade; ?>/100</span>
                            <?php elseif ($s->status === 'returned'): ?>
                                <span class="badge bg-warning text-dark rounded-pill px-3 py-2 fw-medium"><?php echo t('Dikembalikan', 'Returned'); ?></span>
                            <?php else: ?>
                                <span class="badge bg-primary rounded-pill px-3 py-2 fw-medium"><?php echo t('Dikumpulkan', 'Submitted'); ?></span>
                            <?php endif; ?>
                        </div>
                        <div class="d-flex gap-1 flex-shrink-0">
                            <?php if ($s->file_url): ?>
                                <a href="<?php echo base_url('uploads/assignments/' . $s->file_url); ?>" class="btn btn-outline-dark btn-sm rounded-pill px-2" target="_blank" title="<?php echo t('Download File', 'Download File'); ?>">
                                    <i data-lucide="download" style="width:14px;height:14px;"></i>
                                </a>
                            <?php endif; ?>
                            <?php if ($s->status === 'submitted' || $s->status === 'returned'): ?>
                                <a href="#" onclick="document.getElementById('gradeForm<?php echo $s->id; ?>').classList.toggle('d-none');return false;" class="btn btn-dark btn-sm rounded-pill px-3 fw-semibold d-flex align-items-center gap-1">
                                    <i data-lucide="check-circle" style="width:14px;height:14px;"></i> <?php echo t('Nilai', 'Grade'); ?>
                                </a>
                                <form id="gradeForm<?php echo $s->id; ?>" action="<?php echo base_url('admin/grade_submission/' . $s->id); ?>" method="POST" class="d-none">
                                    <div class="d-flex gap-2">
                                        <input type="number" name="grade" class="form-control form-control-sm rounded-pill" placeholder="0-100" min="0" max="100" required style="width:80px;">
                                        <input type="text" name="feedback" class="form-control form-control-sm rounded-pill" placeholder="<?php echo t('Feedback', 'Feedback'); ?>" style="width:140px;">
                                        <button type="submit" class="btn btn-success btn-sm rounded-pill px-3"><i class="fas fa-check"></i></button>
                                        <a href="<?php echo base_url('admin/return_submission/' . $s->id); ?>" class="btn btn-warning btn-sm rounded-pill px-3" onclick="return confirm('<?php echo t('Kembalikan untuk revisi?', 'Return for revision?'); ?>')">
                                            <i class="fas fa-undo"></i>
                                        </a>
                                    </div>
                                </form>
                            <?php else: ?>
                                <span class="text-success small fw-semibold d-flex align-items-center gap-1">
                                    <i data-lucide="check-circle" style="width:14px;height:14px;"></i> <?php echo t('Dinilai', 'Graded'); ?>
                                </span>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>