<div class="app-page">
    <!-- Header -->
    <div class="app-page-head">
        <div>
            <h4 class="app-page-title"><i class="fas fa-code"></i> <?php echo t('Tugas Siswa', 'Student Submissions'); ?></h4>
            <p class="app-page-sub"><?php echo t('Nilai tugas yang dikumpulkan siswa.', 'Grade student assignment submissions.'); ?></p>
        </div>
    </div>

    <?php if (empty($submissions)): ?>
        <div class="app-card">
            <div class="app-empty">
                <i class="fas fa-code"></i>
                <h6><?php echo t('Belum ada submission.', 'No submissions yet.'); ?></h6>
                <p><?php echo t('Submissions akan tampil di sini.', 'Submissions will appear here.'); ?></p>
            </div>
        </div>
    <?php else: ?>
        <div class="app-list" style="gap:0.7rem;">
            <?php foreach ($submissions as $s): ?>
                <div class="app-card app-card-pad">
                    <div class="d-flex align-items-center gap-3">
                        <div class="app-avatar" style="width:38px;height:38px;font-size:0.8rem;"><?php echo strtoupper(substr($s->user_name, 0, 1)); ?></div>
                        <div class="flex-fill min-w-0">
                            <div class="app-row-title"><?php echo htmlspecialchars($s->user_name); ?></div>
                            <div class="app-row-sub"><?php echo htmlspecialchars($s->course_title); ?> · <?php echo htmlspecialchars($s->assignment_title); ?></div>
                        </div>
                        <?php if ($s->status === 'graded'): ?><span class="app-chip app-chip-green"><?php echo t('Dinilai', 'Graded'); ?></span><span class="td-title" style="font-size:0.8rem;"><?php echo $s->grade; ?>/100</span>
                        <?php elseif ($s->status === 'returned'): ?><span class="app-chip app-chip-amber"><?php echo t('Dikembalikan', 'Returned'); ?></span>
                        <?php else: ?><span class="app-chip app-chip-green"><?php echo t('Dikumpulkan', 'Submitted'); ?></span><?php endif; ?>
                    </div>
                    <div class="d-flex gap-2 flex-wrap mt-3" style="border-top:1px solid var(--gray-100,#f5f5f5);padding-top:0.7rem;">
                        <?php if ($s->file_url): ?><a href="<?php echo base_url('uploads/assignments/' . $s->file_url); ?>" class="app-btn app-btn-sm" target="_blank"><i class="fas fa-download"></i> <?php echo t('File', 'File'); ?></a><?php endif; ?>
                        <?php if ($s->status === 'submitted' || $s->status === 'returned'): ?>
                            <button class="app-btn app-btn-sm app-btn-primary" onclick="document.getElementById('gradeForm<?php echo $s->id; ?>').classList.toggle('d-none');return false;"><i class="fas fa-check-circle"></i> <?php echo t('Nilai', 'Grade'); ?></button>
                            <?php echo form_open('admin/grade_submission/' . $s->id, array('id' => 'gradeForm' . $s->id, 'class' => 'd-none w-100')); ?>
                                <div class="d-flex gap-2 flex-wrap mt-2">
                                    <input type="number" name="grade" class="form-control" placeholder="0-100" min="0" max="100" required style="width:80px;height:36px;border-radius:10px;font-size:0.78rem;border-color:#e7e5e4;">
                                    <input type="text" name="feedback" class="form-control" placeholder="<?php echo t('Feedback', 'Feedback'); ?>" style="flex:1;min-width:140px;height:36px;border-radius:10px;font-size:0.78rem;border-color:#e7e5e4;">
                                    <button type="submit" class="app-btn app-btn-sm app-btn-success"><i class="fas fa-check"></i></button>
                                    <a href="<?php echo base_url('admin/return_submission/' . $s->id); ?>" class="app-btn app-btn-sm app-btn-primary" onclick="return confirm('<?php echo t('Kembalikan untuk revisi?', 'Return for revision?'); ?>')"><i class="fas fa-undo"></i></a>
                                </div>
                            </form>
                        <?php else: ?><span class="fw-semibold d-flex align-items-center gap-1" style="color:#009688;font-size:0.72rem;"><i class="fas fa-check-circle"></i> <?php echo t('Dinilai', 'Graded'); ?></span><?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>
