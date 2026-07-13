<div>
    <div class="mb-4">
        <h2 class="fw-extrabold text-dark mb-1" style="letter-spacing: -0.03em;"><?php echo t('Kelas Saya', 'My Courses'); ?></h2>
        <p class="text-secondary mb-0"><?php echo t('Semua kelas yang sudah kamu daftar.', 'All courses you have enrolled in.'); ?></p>
    </div>

    <?php if (empty($enrolled_courses)): ?>
    <div class="text-center py-5">
        <div class="icon-48 bg-light rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center">
            <i class="fas fa-book-open text-secondary"></i>
        </div>
        <h6 class="fw-bold text-dark"><?php echo t('Belum Ada Kelas', 'No Courses Yet'); ?></h6>
        <p class="text-secondary small mb-3"><?php echo t('Kamu belum terdaftar di kelas apapun.', 'You are not enrolled in any courses yet.'); ?></p>
        <a href="<?php echo base_url('courses'); ?>" class="btn btn-dark rounded-pill px-4 py-2 fw-semibold"><?php echo t('Jelajahi Konten', 'Explore Content'); ?></a>
    </div>
    <?php else: ?>
    <div class="d-flex flex-column gap-3">
        <?php foreach ($enrolled_courses as $course): ?>
        <div class="d-flex align-items-center gap-3 p-4 rounded-3 bg-white border">
            <img src="<?php echo base_url('uploads/courses/' . $course->thumbnail); ?>" onerror="this.src='https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=100&auto=format&fit=crop&q=60';" alt="" class="rounded-2 object-fit-cover flex-shrink-0" style="width: 80px; height: 56px;">
            <div class="flex-fill min-w-0">
                <h6 class="fw-bold text-dark mb-1 small"><?php echo htmlspecialchars(t($course->title, $course->title_en ?: $course->title)); ?></h6>
                <div class="text-secondary small"><?php echo ucfirst($course->content_type); ?></div>
                <div class="d-flex align-items-center gap-2 mt-2">
                    <div class="progress-modern flex-fill" style="height: 6px;"><div class="progress-bar" style="width: <?php echo $course->progress_pct ?? 0; ?>%;"></div></div>
                    <span class="small fw-bold text-primary flex-shrink-0"><?php echo $course->progress_pct ?? 0; ?>%</span>
                </div>
            </div>
            <a href="<?php echo base_url('courses/learn/' . $course->slug); ?>" class="btn btn-dark btn-sm rounded-pill px-3 flex-shrink-0 fw-semibold"><?php echo t('Belajar', 'Learn'); ?></a>
        </div>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>
</div>
