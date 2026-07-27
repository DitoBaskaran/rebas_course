<div class="container-fluid py-4" style="padding-top: 0px !important; max-width: 1200px;">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h4 class="fw-extrabold mb-1" style="color: #1c1917; letter-spacing: -0.02em; font-size: 1.3rem;">
                <?php echo t('Kelas Saya', 'My Courses'); ?>
            </h4>
            <p style="color: #78716c; font-size: 0.82rem; margin-bottom: 0;">
                <?php echo t('Semua kelas yang sudah kamu daftar.', 'All courses you have enrolled in.'); ?>
            </p>
        </div>
        <a href="<?php echo base_url('courses'); ?>" class="btn px-3 py-2 fw-semibold rounded-pill" style="background: #059669; color: #fff; font-size: 0.8rem;">
            <i class="fas fa-plus me-1"></i> <?php echo t('Tambah Kelas', 'Add Course'); ?>
        </a>
    </div>

    <?php if (empty($enrolled_courses)): ?>
    <!-- Empty State -->
    <div class="border rounded-3 p-5 text-center" style="border-color: #e7e5e4; border-radius: 12px;">
        <div style="font-size: 2rem; color: #d6d3d1; margin-bottom: 0.75rem;">
            <i class="fas fa-book-open"></i>
        </div>
        <h5 class="fw-bold" style="color: #1c1917; margin-bottom: 0.375rem;">
            <?php echo t('Belum Ada Kelas', 'No Courses Yet'); ?>
        </h5>
        <p style="color: #78716c; font-size: 0.85rem; max-width: 350px; margin: 0 auto 1rem;">
            <?php echo t('Kamu belum terdaftar di kelas apapun. Mulai eksplorasi dan temukan materi yang menarik.', 'You are not enrolled in any courses yet. Explore and find interesting content.'); ?>
        </p>
        <a href="<?php echo base_url('courses'); ?>" class="btn px-4 py-2 fw-bold rounded-pill" style="background: #059669; color: #fff; font-size: 0.85rem;">
            <i class="fas fa-search me-1"></i> <?php echo t('Jelajahi Konten', 'Explore Content'); ?>
        </a>
    </div>

    <?php else: ?>
    <!-- Filter Tabs -->
    <div class="d-flex gap-2 mb-3 overflow-auto pb-1" style="scrollbar-width: none; -ms-overflow-style: none;">
        <a href="#all" class="px-3 py-2 rounded-pill fw-semibold text-decoration-none" style="background: #059669; color: #fff; font-size: 0.78rem; white-space: nowrap;">
            <?php echo t('Semua', 'All'); ?> (<?php echo count($enrolled_courses); ?>)
        </a>
        <?php
        $types = array_count_values(array_map(fn($c) => content_type_label($c->content_type), $enrolled_courses));
        foreach ($types as $type => $count): ?>
            <a href="#<?php echo strtolower($type); ?>" class="px-3 py-2 rounded-pill fw-semibold text-decoration-none" style="background: #f5f5f4; color: #57534e; font-size: 0.78rem; white-space: nowrap;">
                <?php echo $type; ?> (<?php echo $count; ?>)
            </a>
        <?php endforeach; ?>
    </div>

    <!-- Course List -->
    <div class="d-flex flex-column gap-3">
        <?php foreach ($enrolled_courses as $course): ?>
            <div class="border rounded-3 d-flex align-items-center gap-3 p-3 flex-column flex-md-row" style="border-color: #e7e5e4; border-radius: 12px; transition: all 0.15s; background: #fff;">
                <!-- Thumbnail -->
                <div class="flex-shrink-0" style="width: 100%; max-width: 140px; border-radius: 8px; overflow: hidden;">
                    <img src="<?php echo base_url('uploads/courses/' . $course->thumbnail); ?>" onerror="this.src='https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=140&auto=format&fit=crop&q=60';" alt="" class="w-100 object-fit-cover" style="height: 80px; display: block;">
                </div>

                <!-- Info -->
                <div class="flex-fill min-w-0">
                    <div class="d-flex align-items-center gap-2 mb-1 flex-wrap">
                        <span class="px-2 py-1 rounded-pill fw-semibold" style="background: #f5f5f4; color: #57534e; font-size: 0.65rem;">
                            <?php echo content_type_label($course->content_type); ?>
                        </span>
                        <span class="px-2 py-1 rounded-pill fw-semibold" style="background: #faf5ff; color: #7c3aed; font-size: 0.65rem;">
                            <?php echo skill_level_label($course->skill_level); ?>
                        </span>
                        <?php if (($course->progress_pct ?? 0) >= 100): ?>
                            <span class="px-2 py-1 rounded-pill fw-semibold" style="background: #f0fdfa; color: #10b981; font-size: 0.65rem;">
                                <i class="fas fa-check" style="font-size: 0.5rem;"></i> <?php echo t('Selesai', 'Done'); ?>
                            </span>
                        <?php endif; ?>
                    </div>
                    <h6 class="fw-bold mb-1 text-truncate" style="color: #1c1917; font-size: 0.88rem;">
                        <?php echo htmlspecialchars(t($course->title, $course->title_en ?: $course->title)); ?>
                    </h6>
                    <div class="d-flex align-items-center gap-3 mb-2" style="font-size: 0.72rem; color: #78716c;">
                        <span><i class="fas fa-chalkboard-teacher me-1" style="font-size: 0.6rem;"></i><?php echo htmlspecialchars($course->teacher_name); ?></span>
                        <?php if ($course->category_name): ?>
                            <span><i class="fas fa-folder me-1" style="font-size: 0.6rem;"></i><?php echo htmlspecialchars($course->category_name); ?></span>
                        <?php endif; ?>
                    </div>
                    <!-- Progress -->
                    <div class="d-flex align-items-center gap-2">
                        <div class="flex-fill rounded-pill overflow-hidden" style="height: 5px; background: #e7e5e4; max-width: 200px;">
                            <div class="h-100 rounded-pill" style="width: <?php echo $course->progress_pct ?? 0; ?>%; background: #059669;"></div>
                        </div>
                        <span class="fw-bold" style="color: #1c1917; font-size: 0.72rem; min-width: 32px; text-align: right;">
                            <?php echo $course->progress_pct ?? 0; ?>%
                        </span>
                    </div>
                </div>

                <!-- Action -->
                <div class="d-flex gap-2 flex-shrink-0">
                    <a href="<?php echo base_url('courses/detail/' . $course->slug); ?>" class="btn btn-sm fw-semibold rounded-pill px-3" style="border: 1px solid #e7e5e4; color: #57534e; font-size: 0.75rem;">
                        <?php echo t('Detail', 'Detail'); ?>
                    </a>
                    <a href="<?php echo base_url('courses/learn/' . $course->slug); ?>" class="btn btn-sm fw-bold rounded-pill px-4" style="background: #059669; color: #fff; font-size: 0.75rem;">
                        <i class="fas fa-play me-1" style="font-size: 0.65rem;"></i> <?php echo t('Mulai', 'Start'); ?>
                    </a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>
</div>
