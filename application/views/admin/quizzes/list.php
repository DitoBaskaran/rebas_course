<div class="app-page">
    <!-- Header with back -->
    <div class="app-page-head">
        <div class="d-flex align-items-center gap-2">
            <a href="<?php echo base_url('admin/courses'); ?>" class="app-btn app-btn-icon" title="<?php echo t('Kembali', 'Back'); ?>"><i class="fas fa-arrow-left"></i></a>
            <div>
                <h4 class="app-page-title mb-0"><?php echo t('Quiz', 'Quiz'); ?>: <?php echo htmlspecialchars($course->title); ?></h4>
                <p class="app-page-sub"><?php echo t('Kelola soal-soal quiz', 'Manage quiz questions'); ?></p>
            </div>
        </div>
        <div class="app-page-actions">
            <a href="<?php echo base_url('quiz/admin_create_quiz/' . $course->id); ?>" class="app-btn app-btn-primary"><i class="fas fa-plus"></i> <?php echo t('Buat Quiz', 'Create Quiz'); ?></a>
        </div>
    </div>

    <!-- Mobile: kartu eksplisit -->
    <?php if (!empty($quizzes)): ?>
    <div class="app-row-list app-list">
        <?php foreach ($quizzes as $qz): ?>
            <?php $qcount = $question_counts[$qz->id] ?? 0; ?>
            <div class="app-row app-row-card">
                <div class="app-row-head">
                    <div class="app-avatar" style="width:38px;height:38px;font-size:0.8rem;background:#E0F2F1;color:#009688;"><i class="fas fa-pencil-alt"></i></div>
                    <div class="app-row-main">
                        <div class="app-row-title"><?php echo htmlspecialchars($qz->title); ?></div>
                        <div class="app-row-sub"><?php echo $qz->time_limit > 0 ? $qz->time_limit . ' ' . t('menit', 'min') : '-'; ?> · <?php echo $qz->max_attempts; ?>x</div>
                    </div>
                    <span class="app-chip <?php echo $qz->passing_score >= 70 ? 'app-chip-green' : 'app-chip-amber'; ?>"><?php echo $qz->passing_score; ?>%</span>
                </div>
                <div class="app-row-meta">
                    <span><b><?php echo t('Soal', 'Questions'); ?>:</b> <?php echo $qcount; ?></span>
                </div>
                <div class="app-actions">
                    <a href="<?php echo base_url('quiz/admin_questions/' . $qz->id); ?>" class="app-action app-action-gray" title="<?php echo t('Soal', 'Questions'); ?>"><i class="fas fa-list"></i></a>
                    <a href="<?php echo base_url('quiz/admin_delete_quiz/' . $qz->id); ?>" class="app-action app-action-red" data-confirm="<?php echo t('Hapus quiz?', 'Delete quiz?'); ?>" title="<?php echo t('Hapus', 'Delete'); ?>"><i class="fas fa-trash-alt"></i></a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>

    <!-- Desktop: tabel -->
    <div class="app-card app-table-desktop">
        <div class="app-table-wrap">
            <table class="app-table">
                <thead>
                    <tr><th><?php echo t('Judul', 'Title'); ?></th><th><?php echo t('Nilai Lulus', 'Passing'); ?></th><th><?php echo t('Waktu', 'Time'); ?></th><th><?php echo t('Percobaan', 'Attempts'); ?></th><th><?php echo t('Soal', 'Questions'); ?></th><th class="td-actions"><?php echo t('Aksi', 'Actions'); ?></th></tr>
                </thead>
                <tbody>
                    <?php if (empty($quizzes)): ?>
                        <tr><td colspan="6" class="text-center py-5" style="color:#a8a29e;"><?php echo t('Belum ada quiz.', 'No quizzes.'); ?></td></tr>
                    <?php else: ?>
                        <?php foreach ($quizzes as $qz): ?>
                            <?php $qcount = $question_counts[$qz->id] ?? 0; ?>
                            <tr>
                                <td class="td-title"><?php echo htmlspecialchars($qz->title); ?></td>
                                <td><span class="app-chip <?php echo $qz->passing_score >= 70 ? 'app-chip-green' : 'app-chip-amber'; ?>"><?php echo $qz->passing_score; ?>%</span></td>
                                <td style="font-size:0.78rem;"><?php echo $qz->time_limit > 0 ? $qz->time_limit . ' ' . t('menit', 'min') : '-'; ?></td>
                                <td style="font-size:0.78rem;"><?php echo $qz->max_attempts; ?>x</td>
                                <td><a href="<?php echo base_url('quiz/admin_questions/' . $qz->id); ?>" style="color:var(--primary);font-weight:700;text-decoration:none;"><?php echo $qcount; ?> <?php echo t('soal', 'questions'); ?></a></td>
                                <td class="td-actions">
                                    <a href="<?php echo base_url('quiz/admin_questions/' . $qz->id); ?>" class="app-action app-action-gray" title="<?php echo t('Soal', 'Questions'); ?>"><i class="fas fa-list"></i></a>
                                    <a href="<?php echo base_url('quiz/admin_delete_quiz/' . $qz->id); ?>" class="app-action app-action-red" data-confirm="<?php echo t('Hapus quiz?', 'Delete quiz?'); ?>" title="<?php echo t('Hapus', 'Delete'); ?>"><i class="fas fa-trash-alt"></i></a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
