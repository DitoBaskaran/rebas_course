<div class="app-page">
    <!-- Header with back -->
    <div class="app-page-head">
        <div class="d-flex align-items-center gap-2">
            <a href="<?php echo base_url('admin/courses'); ?>" class="app-btn app-btn-icon" title="<?php echo t('Kembali', 'Back'); ?>"><i class="fas fa-arrow-left"></i></a>
            <div>
                <h4 class="app-page-title mb-0"><?php echo htmlspecialchars($course->title); ?></h4>
                <p class="app-page-sub"><?php echo t('Materi pembelajaran', 'Learning materials'); ?></p>
            </div>
        </div>
        <div class="app-page-actions">
            <a href="<?php echo base_url('admin/create_lesson/' . $course->id); ?>" class="app-btn app-btn-primary"><i class="fas fa-plus"></i> <?php echo t('Tambah Materi', 'Add Lesson'); ?></a>
        </div>
    </div>

    <?php $lessons = isset($lessons) ? $lessons : array(); ?>
    <?php if (empty($lessons)): ?>
        <div class="app-card">
            <div class="app-empty">
                <i class="fas fa-file-text"></i>
                <h6><?php echo t('Belum ada materi.', 'No lessons yet.'); ?></h6>
                <p><?php echo t('Tambahkan materi pertama untuk kursus ini.', 'Add the first lesson for this course.'); ?></p>
            </div>
        </div>
    <?php else: ?>
        <div class="app-list" style="gap:0.6rem;">
            <?php foreach ($lessons as $i => $lesson): ?>
                <div class="app-card app-card-pad">
                    <div class="d-flex align-items-center gap-3">
                        <div class="app-avatar" style="width:34px;height:34px;font-size:0.78rem;background:var(--gray-100,#f5f5f5);color:var(--gray-600,#57534e);"><?php echo $i + 1; ?></div>
                        <div class="flex-fill min-w-0">
                            <div class="app-row-title"><?php echo htmlspecialchars($lesson->title); ?></div>
                            <div class="app-row-meta d-flex align-items-center gap-2 mt-1">
                                <span class="app-chip app-chip-gray">
                                    <?php if ($lesson->lesson_type === 'video'): ?><i class="fas fa-play-circle" style="color:var(--primary);"></i>
                                    <?php elseif ($lesson->lesson_type === 'text'): ?><i class="fas fa-file-text" style="color:var(--info);"></i>
                                    <?php else: ?><i class="fas fa-pencil" style="color:var(--warning);"></i><?php endif; ?>
                                    <?php echo ucfirst($lesson->lesson_type); ?>
                                </span>
                                <?php if ($lesson->duration > 0): ?><span style="color:var(--gray-400,#a3a3a3);font-size:0.68rem;"><?php echo $lesson->duration . ' ' . t('menit', 'min'); ?></span><?php endif; ?>
                                <?php if ($lesson->is_free): ?><span class="app-chip app-chip-green"><?php echo t('Gratis', 'Free'); ?></span><?php endif; ?>
                            </div>
                        </div>
                        <div class="app-actions">
                            <a href="<?php echo base_url('admin/edit_lesson/' . $lesson->id); ?>" class="app-action app-action-dark" title="<?php echo t('Edit', 'Edit'); ?>"><i class="fas fa-edit"></i></a>
                            <a href="<?php echo base_url('admin/delete_lesson/' . $lesson->id . '/' . $course->id); ?>" class="app-action app-action-red" data-confirm="<?php echo t('Hapus materi ini?', 'Delete this lesson?'); ?>" title="<?php echo t('Hapus', 'Delete'); ?>"><i class="fas fa-trash-alt"></i></a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>
