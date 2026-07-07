<div class="container my-5 py-3">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="d-flex align-items-center gap-4 mb-5 animate-fade-in-up">
                <div class="d-flex align-items-center justify-content-center text-white rounded-3 flex-shrink-0" style="width: 64px; height: 64px; background: <?php echo $path->color ?? '#4361ee'; ?>;">
                    <i class="fas fa-<?php echo $path->icon ?: 'road'; ?> fa-lg"></i>
                </div>
                <div class="flex-fill">
                    <h2 class="fw-extrabold text-dark mb-1"><?php echo htmlspecialchars($path->title); ?></h2>
                    <p class="text-secondary mb-0"><?php echo htmlspecialchars($path->description); ?></p>
                </div>
            </div>

            <?php if ($enrollment): ?>
                <div class="card-flat p-4 mb-4">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="fw-bold text-dark"><?php echo t('Progress Anda', 'Your Progress'); ?></span>
                        <span class="fw-extrabold text-primary"><?php echo $enrollment->progress_pct; ?>%</span>
                    </div>
                    <div class="progress-modern">
                        <div class="progress-bar" style="width: <?php echo $enrollment->progress_pct; ?>%;"></div>
                    </div>
                    <?php if ($enrollment->completed_at): ?>
                        <p class="text-success small mt-2"><i class="fas fa-check-circle me-1"></i> <?php echo t('Selesai!', 'Completed!'); ?></p>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

            <div class="d-flex flex-column gap-0 position-relative">
                <?php foreach ($contents as $i => $content): ?>
                    <div class="d-flex gap-4">
                        <div class="d-flex flex-column align-items-center" style="width: 40px;">
                            <div class="d-flex align-items-center justify-content-center rounded-circle fw-bold text-white <?php echo (isset($content->is_enrolled) && $content->is_enrolled) ? 'bg-success' : 'bg-secondary'; ?>" style="width: 36px; height: 36px; font-size: 0.85rem; z-index: 1;">
                                <?php echo (isset($content->is_enrolled) && $content->is_enrolled) ? '<i class="fas fa-check"></i>' : ($i + 1); ?>
                            </div>
                            <?php if ($i < count($contents) - 1): ?>
                                <div class="flex-fill" style="width: 2px; background: #e2e8f0; min-height: 30px;"></div>
                            <?php endif; ?>
                        </div>
                        <div class="flex-fill pb-4">
                            <div class="card-flat p-3 d-flex justify-content-between align-items-center gap-3 shadow-hover-soft">
                                <div class="min-w-0">
                                    <h6 class="fw-bold text-dark mb-1 small text-truncate"><?php echo htmlspecialchars($content->title); ?></h6>
                                    <div class="d-flex gap-2">
                                        <span class="badge bg-light text-secondary badge-modern" style="font-size: 0.65rem;"><?php echo content_type_label($content->content_type); ?></span>
                                        <span class="badge bg-primary-subtle text-primary badge-modern" style="font-size: 0.65rem;"><?php echo skill_level_label($content->skill_level); ?></span>
                                    </div>
                                </div>
                                <a href="<?php echo base_url('courses/detail/' . $content->slug); ?>" class="btn btn-sm <?php echo (isset($content->is_enrolled) && $content->is_enrolled) ? 'btn-success' : 'btn-outline-primary'; ?> flex-shrink-0">
                                    <?php echo (isset($content->is_enrolled) && $content->is_enrolled) ? t('Mulai', 'Start') : t('Lihat', 'View'); ?>
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="text-center mt-4">
                <?php if (!$enrollment): ?>
                    <a href="<?php echo base_url('learning_paths/enroll/' . $path->id); ?>" class="btn btn-primary px-5 py-2.5">
                        <i class="fas fa-play me-2"></i> <?php echo t('Mulai Learning Path Ini', 'Start This Learning Path'); ?>
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
