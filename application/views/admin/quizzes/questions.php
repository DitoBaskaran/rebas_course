<div class="app-page">
    <!-- Header with back -->
    <div class="app-page-head">
        <div class="d-flex align-items-center gap-2">
            <a href="<?php echo base_url('quiz/admin_quizzes/' . $course->id); ?>" class="app-btn app-btn-icon" title="<?php echo t('Kembali', 'Back'); ?>"><i class="fas fa-arrow-left"></i></a>
            <div>
                <h4 class="app-page-title mb-0"><?php echo t('Soal Quiz', 'Quiz Questions'); ?>: <?php echo htmlspecialchars($quiz->title); ?></h4>
                <p class="app-page-sub"><?php echo t('Kelas: ', 'Course: '); ?><?php echo htmlspecialchars($course->title); ?></p>
            </div>
        </div>
        <div class="app-page-actions">
            <a href="<?php echo base_url('quiz/admin_create_question/' . $quiz->id); ?>" class="app-btn app-btn-primary"><i class="fas fa-plus"></i> <?php echo t('Tambah Soal', 'Add Question'); ?></a>
        </div>
    </div>

    <div class="app-card">
        <div class="app-table-wrap">
            <table class="app-table">
                <thead>
                    <tr><th>#</th><th><?php echo t('Soal', 'Question'); ?></th><th><?php echo t('Tipe', 'Type'); ?></th><th><?php echo t('Poin', 'Points'); ?></th><th class="td-actions"><?php echo t('Aksi', 'Action'); ?></th></tr>
                </thead>
                <tbody>
                    <?php if (empty($questions)): ?>
                        <tr><td colspan="5" class="text-center py-5" style="color:#a8a29e;"><?php echo t('Belum ada soal.', 'No questions yet.'); ?></td></tr>
                    <?php else: ?>
                        <?php foreach ($questions as $i => $q): ?>
                            <tr>
                                <td class="td-title"><?php echo $i + 1; ?></td>
                                <td style="font-size:0.78rem;"><?php echo htmlspecialchars(mb_substr($q->question, 0, 80)) . (mb_strlen($q->question) > 80 ? '...' : ''); ?></td>
                                <td><span class="app-chip app-chip-gray"><?php echo $q->type; ?></span></td>
                                <td class="td-title"><?php echo $q->points; ?></td>
                                <td class="td-actions">
                                    <a href="<?php echo base_url('quiz/admin_delete_question/' . $q->id); ?>" class="app-action app-action-red" data-confirm="<?php echo t('Hapus soal?', 'Delete question?'); ?>" title="<?php echo t('Hapus', 'Delete'); ?>"><i class="fas fa-trash-alt"></i></a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
