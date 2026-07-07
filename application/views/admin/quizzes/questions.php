<div class="container-fluid px-0">
    <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between mb-5 gap-3">
        <div>
            <div class="d-flex align-items-center gap-2 mb-1">
                <a href="<?php echo base_url('quiz/admin_quizzes/' . $course->id); ?>" class="btn btn-outline-dark btn-sm rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                    <i data-lucide="arrow-left" style="width:14px;height:14px;"></i>
                </a>
                <h1 class="display-6 fw-extrabold text-dark mb-0 lh-sm" style="letter-spacing: -0.03em; font-size: 1.5rem;"><?php echo t('Soal Quiz', 'Quiz Questions'); ?>: <?php echo htmlspecialchars($quiz->title); ?></h1>
            </div>
            <p class="text-secondary mb-0 ms-5 ps-3"><?php echo t('Kelas: ', 'Course: '); ?><?php echo htmlspecialchars($course->title); ?></p>
        </div>
        <a href="<?php echo base_url('quiz/admin_create_question/' . $quiz->id); ?>" class="btn btn-primary btn-sm px-3 rounded-pill shadow-sm d-flex align-items-center gap-1">
            <i data-lucide="plus" style="width:16px;height:16px;"></i> <?php echo t('Tambah Soal', 'Add Question'); ?>
        </a>
    </div>

    <div class="bento-card p-4 p-xl-5">
        <div class="table-responsive">
            <table class="table-modern">
                <thead>
                    <tr><th>#</th><th><?php echo t('Soal', 'Question'); ?></th><th><?php echo t('Tipe', 'Type'); ?></th><th><?php echo t('Poin', 'Points'); ?></th><th class="text-center col-w-80"><?php echo t('Aksi', 'Action'); ?></th></tr>
                </thead>
                <tbody>
                    <?php if (empty($questions)): ?>
                        <tr><td colspan="5" class="text-center text-muted py-5"><?php echo t('Belum ada soal.', 'No questions yet.'); ?></td></tr>
                    <?php else: ?>
                        <?php foreach ($questions as $i => $q): ?>
                            <tr>
                                <td class="fw-bold"><?php echo $i + 1; ?></td>
                                <td class="small"><?php echo htmlspecialchars(mb_substr($q->question, 0, 80)) . (mb_strlen($q->question) > 80 ? '...' : ''); ?></td>
                                <td><span class="badge bg-light text-dark badge-modern"><?php echo $q->type; ?></span></td>
                                <td class="fw-bold"><?php echo $q->points; ?></td>
                                <td class="text-center">
                                    <a href="<?php echo base_url('quiz/admin_delete_question/' . $q->id); ?>" class="btn btn-outline-danger btn-sm px-2 rounded-pill" data-confirm="<?php echo t('Hapus soal?', 'Delete question?'); ?>">
                                        <i data-lucide="trash-2" style="width:14px;height:14px;"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>