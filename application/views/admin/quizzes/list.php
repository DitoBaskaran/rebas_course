<div class="container-fluid px-0">
    <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between mb-5 gap-3">
        <div>
            <div class="d-flex align-items-center gap-2 mb-1">
                <a href="<?php echo base_url('admin/courses'); ?>" class="btn btn-outline-dark btn-sm rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                    <i data-lucide="arrow-left" style="width:14px;height:14px;"></i>
                </a>
                <h1 class="display-6 fw-extrabold text-dark mb-0 lh-sm" style="letter-spacing: -0.03em; font-size: 1.5rem;"><?php echo t('Quiz', 'Quiz'); ?>: <?php echo htmlspecialchars($course->title); ?></h1>
            </div>
            <p class="text-secondary mb-0 ms-5 ps-3"><?php echo t('Kelola soal-soal quiz', 'Manage quiz questions'); ?></p>
        </div>
        <a href="<?php echo base_url('quiz/admin_create_quiz/' . $course->id); ?>" class="btn btn-dark btn-sm px-3 rounded-pill shadow-sm d-flex align-items-center gap-1">
            <i data-lucide="plus" style="width:16px;height:16px;"></i> <?php echo t('Buat Quiz', 'Create Quiz'); ?>
        </a>
    </div>

    <div class="bento-card p-4 p-xl-5">
        <div class="table-responsive">
            <table class="table-modern">
                <thead>
                    <tr><th><?php echo t('Judul', 'Title'); ?></th><th><?php echo t('Nilai Lulus', 'Passing'); ?></th><th><?php echo t('Waktu', 'Time'); ?></th><th><?php echo t('Percobaan', 'Attempts'); ?></th><th><?php echo t('Soal', 'Questions'); ?></th><th class="text-center col-w-120"><?php echo t('Aksi', 'Actions'); ?></th></tr>
                </thead>
                <tbody>
                    <?php if (empty($quizzes)): ?>
                        <tr><td colspan="6" class="text-center text-muted py-5"><?php echo t('Belum ada quiz.', 'No quizzes.'); ?></td></tr>
                    <?php else: ?>
                        <?php foreach ($quizzes as $qz): ?>
                            <?php $qcount = $question_counts[$qz->id] ?? 0; ?>
                            <tr>
                                <td class="fw-bold text-dark"><?php echo htmlspecialchars($qz->title); ?></td>
                                <td><span class="badge bg-<?php echo $qz->passing_score >= 70 ? 'success' : 'warning'; ?>-subtle text-<?php echo $qz->passing_score >= 70 ? 'success' : 'warning'; ?> rounded-pill px-3 py-2 fw-medium"><?php echo $qz->passing_score; ?>%</span></td>
                                <td><?php echo $qz->time_limit > 0 ? $qz->time_limit . ' ' . t('menit', 'min') : '-'; ?></td>
                                <td><?php echo $qz->max_attempts; ?>x</td>
                                <td><a href="<?php echo base_url('quiz/admin_questions/' . $qz->id); ?>" class="text-primary fw-bold text-decoration-none border-bottom border-primary pb-1"><?php echo $qcount; ?> <?php echo t('soal', 'questions'); ?></a></td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-1">
                                        <a href="<?php echo base_url('quiz/admin_questions/' . $qz->id); ?>" class="btn btn-outline-dark btn-sm px-2 rounded-pill" title="<?php echo t('Soal', 'Questions'); ?>">
                                            <i data-lucide="list" style="width:14px;height:14px;"></i>
                                        </a>
                                        <a href="<?php echo base_url('quiz/admin_delete_quiz/' . $qz->id); ?>" class="btn btn-outline-danger btn-sm px-2 rounded-pill" data-confirm="<?php echo t('Hapus quiz?', 'Delete quiz?'); ?>">
                                            <i data-lucide="trash-2" style="width:14px;height:14px;"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>