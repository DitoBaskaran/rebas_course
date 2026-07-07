<div class="container-fluid px-0">
    <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between mb-5 gap-3">
        <div>
            <div class="d-flex align-items-center gap-2 mb-1">
                <a href="<?php echo base_url('admin/courses'); ?>" class="btn btn-outline-dark btn-sm rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                    <i data-lucide="arrow-left" style="width:14px;height:14px;"></i>
                </a>
                <h1 class="display-6 fw-extrabold text-dark mb-0 lh-sm" style="letter-spacing: -0.03em; font-size: 1.5rem;"><?php echo htmlspecialchars($course->title); ?></h1>
            </div>
            <p class="text-secondary mb-0 ms-5 ps-3"><?php echo t('Materi pembelajaran', 'Learning materials'); ?></p>
        </div>
        <a href="<?php echo base_url('admin/create_lesson/' . $course->id); ?>" class="btn btn-dark btn-sm px-3 rounded-pill shadow-sm d-flex align-items-center gap-1">
            <i data-lucide="plus" style="width:16px;height:16px;"></i> <?php echo t('Tambah Materi', 'Add Lesson'); ?>
        </a>
    </div>

    <div class="bento-card p-4 p-xl-5">
        <?php $lessons = isset($lessons) ? $lessons : array(); ?>
        <?php if (empty($lessons)): ?>
            <div class="empty-state">
                <i data-lucide="file-text" style="width:48px;height:48px;color:var(--gray-300);"></i>
                <h5><?php echo t('Belum ada materi.', 'No lessons yet.'); ?></h5>
                <p><?php echo t('Tambahkan materi pertama untuk kursus ini.', 'Add the first lesson for this course.'); ?></p>
            </div>
        <?php else: ?>
            <div class="d-flex flex-column gap-2">
                <?php foreach ($lessons as $i => $lesson): ?>
                    <div class="d-flex align-items-center gap-3 p-3 rounded-3 border" style="background: var(--card-bg); border-color: var(--card-border) !important;">
                        <div class="d-flex align-items-center justify-content-center rounded-circle fw-bold flex-shrink-0" style="width:36px;height:36px;background:var(--gray-100);color:var(--gray-600);font-size:0.8125rem;">
                            <?php echo $i + 1; ?>
                        </div>
                        <div class="flex-fill min-w-0">
                            <div class="fw-bold text-dark small"><?php echo htmlspecialchars($lesson->title); ?></div>
                            <div class="d-flex align-items-center gap-2 mt-1">
                                <span class="badge bg-light text-dark border rounded-pill px-3 py-1 fw-medium small">
                                    <?php if ($lesson->lesson_type === 'video'): ?>
                                        <i data-lucide="play-circle" style="width:12px;height:12px;color:var(--primary);" class="me-1"></i>
                                    <?php elseif ($lesson->lesson_type === 'text'): ?>
                                        <i data-lucide="file-text" style="width:12px;height:12px;color:var(--info);" class="me-1"></i>
                                    <?php else: ?>
                                        <i data-lucide="pencil" style="width:12px;height:12px;color:var(--warning);" class="me-1"></i>
                                    <?php endif; ?>
                                    <?php echo ucfirst($lesson->lesson_type); ?>
                                </span>
                                <?php if ($lesson->duration > 0): ?>
                                    <span class="small text-muted"><?php echo $lesson->duration . ' ' . t('menit', 'min'); ?></span>
                                <?php endif; ?>
                                <?php if ($lesson->is_free): ?>
                                    <span class="badge bg-success badge-modern small"><?php echo t('Gratis', 'Free'); ?></span>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="d-flex gap-1 flex-shrink-0">
                            <a href="<?php echo base_url('admin/edit_lesson/' . $lesson->id); ?>" class="btn btn-warning btn-sm px-2 rounded-pill" title="<?php echo t('Edit', 'Edit'); ?>">
                                <i data-lucide="edit" style="width:14px;height:14px;"></i>
                            </a>
                            <a href="<?php echo base_url('admin/delete_lesson/' . $lesson->id . '/' . $course->id); ?>" class="btn btn-outline-danger btn-sm px-2 rounded-pill" data-confirm="<?php echo t('Hapus materi ini?', 'Delete this lesson?'); ?>">
                                <i data-lucide="trash-2" style="width:14px;height:14px;"></i>
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>