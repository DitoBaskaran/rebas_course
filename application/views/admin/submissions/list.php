<div class="container-fluid py-4" style="max-width: 1400px;">
    <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between mb-4 gap-3">
        <div>
            <div style="color: #f97316; font-weight: 700; font-size: 0.7rem; text-transform: uppercase; letter-spacing: 0.08em; margin-bottom: 0.15rem;"><?php echo t('Penilaian', 'Assessment'); ?></div>
            <h4 class="fw-extrabold mb-0" style="color: #1c1917; letter-spacing: -0.02em; font-size: 1.4rem;"><?php echo t('Tugas Siswa', 'Student Submissions'); ?></h4>
            <p style="color: #78716c; font-size: 0.82rem; margin-bottom: 0;"><?php echo t('Nilai tugas yang dikumpulkan siswa.', 'Grade student assignment submissions.'); ?></p>
        </div>
    </div>

    <div class="border rounded-3" style="border-color: #e7e5e4; border-radius: 12px;">
        <?php if (empty($submissions)): ?>
            <div class="p-5 text-center"><div style="font-size: 2rem; color: #d6d3d1; margin-bottom: 0.5rem;"><i class="fas fa-code"></i></div><h6 class="fw-bold" style="color: #1c1917;"><?php echo t('Belum ada submission.', 'No submissions yet.'); ?></h6></div>
        <?php else: ?>
            <div class="d-flex flex-column gap-2 p-3">
                <?php foreach ($submissions as $s): ?>
                    <div class="d-flex flex-column flex-md-row align-items-md-center gap-3 p-3 rounded-3" style="background: #fafaf9; border: 1px solid #f0eeeb;">
                        <div class="d-flex align-items-center gap-3 flex-fill min-w-0">
                            <div class="d-flex align-items-center justify-content-center rounded-circle fw-bold flex-shrink-0" style="width: 38px; height: 38px; background: #fff7ed; color: #f97316; font-size: 0.8rem;"><?php echo strtoupper(substr($s->user_name, 0, 1)); ?></div>
                            <div class="min-w-0">
                                <div class="fw-semibold" style="color: #1c1917; font-size: 0.8rem;"><?php echo htmlspecialchars($s->user_name); ?></div>
                                <div style="color: #78716c; font-size: 0.72rem;"><?php echo htmlspecialchars($s->course_title); ?> · <?php echo htmlspecialchars($s->assignment_title); ?></div>
                            </div>
                        </div>
                        <div class="d-flex align-items-center gap-2 flex-shrink-0">
                            <?php if ($s->status === 'graded'): ?><span class="px-2 py-1 rounded-pill fw-semibold" style="background: #f0fdfa; color: #14b8a6; font-size: 0.6rem;"><?php echo t('Dinilai', 'Graded'); ?></span><span class="fw-bold" style="color: #1c1917; font-size: 0.78rem;"><?php echo $s->grade; ?>/100</span>
                            <?php elseif ($s->status === 'returned'): ?><span class="px-2 py-1 rounded-pill fw-semibold" style="background: #fff7ed; color: #f97316; font-size: 0.6rem;"><?php echo t('Dikembalikan', 'Returned'); ?></span>
                            <?php else: ?><span class="px-2 py-1 rounded-pill fw-semibold" style="background: #f0fdfa; color: #14b8a6; font-size: 0.6rem;"><?php echo t('Dikumpulkan', 'Submitted'); ?></span><?php endif; ?>
                        </div>
                        <div class="d-flex gap-1 flex-shrink-0">
                            <?php if ($s->file_url): ?><a href="<?php echo base_url('uploads/assignments/' . $s->file_url); ?>" class="btn btn-sm rounded-pill px-2 d-inline-flex align-items-center" style="border: 1px solid #e7e5e4; color: #57534e; font-size: 0.68rem;" target="_blank"><i class="fas fa-download" style="font-size: 0.65rem;"></i></a><?php endif; ?>
                            <?php if ($s->status === 'submitted' || $s->status === 'returned'): ?>
                                <a href="#" onclick="document.getElementById('gradeForm<?php echo $s->id; ?>').classList.toggle('d-none');return false;" class="btn btn-sm rounded-pill px-2 fw-semibold d-inline-flex align-items-center gap-1" style="background: #f97316; color: #fff; font-size: 0.68rem;"><i class="fas fa-check-circle" style="font-size: 0.65rem;"></i> <?php echo t('Nilai', 'Grade'); ?></a>
                                <form id="gradeForm<?php echo $s->id; ?>" action="<?php echo base_url('admin/grade_submission/' . $s->id); ?>" method="POST" class="d-none">
                                    <div class="d-flex gap-2">
                                        <input type="number" name="grade" class="form-control rounded-pill" placeholder="0-100" min="0" max="100" required style="width: 72px; height: 34px; font-size: 0.78rem; border-color: #e7e5e4;">
                                        <input type="text" name="feedback" class="form-control rounded-pill" placeholder="<?php echo t('Feedback', 'Feedback'); ?>" style="width: 120px; height: 34px; font-size: 0.78rem; border-color: #e7e5e4;">
                                        <button type="submit" class="btn btn-sm rounded-pill px-2" style="background: #14b8a6; color: #fff; font-size: 0.68rem;"><i class="fas fa-check"></i></button>
                                        <a href="<?php echo base_url('admin/return_submission/' . $s->id); ?>" class="btn btn-sm rounded-pill px-2" style="background: #f97316; color: #fff; font-size: 0.68rem;" onclick="return confirm('<?php echo t('Kembalikan untuk revisi?', 'Return for revision?'); ?>')"><i class="fas fa-undo"></i></a>
                                    </div>
                                </form>
                            <?php else: ?><span class="fw-semibold d-flex align-items-center gap-1" style="color: #14b8a6; font-size: 0.72rem;"><i class="fas fa-check-circle"></i> <?php echo t('Dinilai', 'Graded'); ?></span><?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>
