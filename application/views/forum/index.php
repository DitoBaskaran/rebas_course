<div class="container py-5 my-4">
    <div class="d-flex justify-content-between align-items-center mb-5 animate-fade-in-up">
        <div>
            <nav aria-label="breadcrumb" class="mb-2">
                <ol class="breadcrumb small mb-0">
                    <li class="breadcrumb-item"><a href="<?php echo base_url('courses/detail/' . $course->slug); ?>" class="text-primary text-decoration-none fw-medium"><?php echo htmlspecialchars($course->title); ?></a></li>
                    <li class="breadcrumb-item active fw-medium text-dark"><?php echo t('Diskusi', 'Discussion'); ?></li>
                </ol>
            </nav>
            <h3 class="fw-extrabold text-dark mb-0" style="letter-spacing: -0.03em;"><?php echo t('Forum Diskusi', 'Discussion Forum'); ?></h3>
        </div>
        <a href="<?php echo base_url('forum/create/' . $course->id); ?>" class="btn btn-dark btn-sm rounded-pill px-4 py-2 fw-semibold shadow-sm">
            <i class="fas fa-plus me-1"></i> <?php echo t('Diskusi Baru', 'New Discussion'); ?>
        </a>
    </div>

    <div class="d-flex flex-column gap-3 animate-fade-in-up stagger-1">
        <?php if (empty($discussions)): ?>
            <div class="text-center py-5">
                <div class="icon-64 bg-light rounded-circle mx-auto mb-4 d-flex align-items-center justify-content-center">
                    <i class="far fa-comment-dots fs-3 text-secondary"></i>
                </div>
                <h5 class="fw-bold text-dark"><?php echo t('Belum Ada Diskusi', 'No Discussions Yet'); ?></h5>
                <p class="text-secondary small mb-0"><?php echo t('Belum ada diskusi. Jadilah yang pertama!', 'No discussions yet. Be the first!'); ?></p>
            </div>
        <?php else: ?>
            <?php foreach ($discussions as $d): ?>
                <a href="<?php echo base_url('forum/view/' . $d->id); ?>" class="text-decoration-none card border-0 shadow-sm rounded-4 p-4 d-flex gap-3 align-items-start hover-zoom" style="transition: all 0.2s;">
                    <img src="<?php echo base_url('uploads/avatars/' . ($d->avatar ?: 'default_avatar.png')); ?>" onerror="this.src='https://ui-avatars.com/api/?name=<?php echo urlencode($d->user_name); ?>&background=4361ee&color=fff&size=40';" alt="" class="rounded-circle flex-shrink-0" style="width: 40px; height: 40px; object-fit: cover;">
                    <div class="flex-fill min-w-0">
                        <div class="d-flex justify-content-between align-items-start gap-3">
                            <h6 class="fw-bold text-dark mb-1 text-truncate"><?php echo $d->is_pinned ? '<i class="fas fa-thumbtack text-warning me-1"></i>' : ''; ?><?php echo htmlspecialchars($d->title); ?></h6>
                            <span class="badge bg-light text-secondary rounded-pill px-3 py-2 fw-medium flex-shrink-0 border"><?php echo $d->reply_count; ?> <?php echo t('balasan', 'replies'); ?></span>
                        </div>
                        <p class="text-secondary small mb-0"><?php echo htmlspecialchars($d->user_name); ?> <span class="opacity-50 mx-1">·</span> <?php echo time_elapsed($d->created_at); ?></p>
                    </div>
                </a>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>
