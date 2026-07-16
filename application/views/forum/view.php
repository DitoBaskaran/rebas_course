<div>
    <div class="mb-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb small mb-0">
                <li class="breadcrumb-item"><a href="<?php echo base_url('courses/detail/' . $course->slug); ?>" class="text-decoration-none"><?php echo htmlspecialchars($course->title); ?></a></li>
                <li class="breadcrumb-item"><a href="<?php echo base_url('forum/index/' . $course->slug); ?>" class="text-decoration-none"><?php echo t('Diskusi', 'Discussion'); ?></a></li>
                <li class="breadcrumb-item active fw-medium text-dark"><?php echo htmlspecialchars($discussion->title); ?></li>
            </ol>
        </nav>
    </div>

    <div class="card-modern p-4 mb-4 animate-scale-in">
        <div class="d-flex gap-3">
            <img src="<?php echo base_url('uploads/avatars/' . ($discussion->avatar ?: 'default_avatar.png')); ?>" onerror="this.src='https://ui-avatars.com/api/?name=<?php echo urlencode($discussion->user_name); ?>&background=0d6efd&color=fff&size=44';" alt="" class="rounded-circle flex-shrink-0" style="width: 44px; height: 44px; object-fit: cover;">
            <div class="flex-fill">
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <div>
                        <h5 class="fw-bold text-dark mb-0"><?php echo $discussion->is_pinned ? '<i class="fas fa-thumbtack text-warning me-1"></i>' : ''; ?><?php echo htmlspecialchars($discussion->title); ?></h5>
                        <small class="text-secondary"><?php echo htmlspecialchars($discussion->user_name); ?> &middot; <?php echo time_elapsed($discussion->created_at); ?></small>
                    </div>
                </div>
                <p class="text-dark small mb-0"><?php echo nl2br(htmlspecialchars($discussion->content)); ?></p>
            </div>
        </div>
    </div>

    <h6 class="fw-bold text-dark mb-3"><?php echo count($replies); ?> <?php echo t('Balasan', 'Replies'); ?></h6>

    <div class="d-flex flex-column gap-3 mb-4">
        <?php foreach ($replies as $reply): ?>
            <div class="card-flat p-4 d-flex gap-3 <?php echo $reply->is_best_answer ? 'border-success border-start border-4' : ''; ?>" id="reply-<?php echo $reply->id; ?>">
                <img src="<?php echo base_url('uploads/avatars/' . ($reply->avatar ?: 'default_avatar.png')); ?>" onerror="this.src='https://ui-avatars.com/api/?name=<?php echo urlencode($reply->user_name); ?>&background=6366f1&color=fff&size=36';" alt="" class="rounded-circle flex-shrink-0" style="width: 36px; height: 36px; object-fit: cover;">
                <div class="flex-fill">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <span class="fw-bold text-dark small"><?php echo htmlspecialchars($reply->user_name); ?></span>
                            <span class="text-muted small ms-2"><?php echo time_elapsed($reply->created_at); ?></span>
                        </div>
                        <?php if ($reply->is_best_answer): ?>
                            <span class="badge bg-success badge-modern"><i class="fas fa-check me-1"></i> <?php echo t('Jawaban Terbaik', 'Best Answer'); ?></span>
                        <?php endif; ?>
                    </div>
                    <p class="small text-dark mb-2 mt-2"><?php echo nl2br(htmlspecialchars($reply->content)); ?></p>
                    <?php if ($discussion->user_id == $this->session->userdata('user_id') && !$reply->is_best_answer && !$has_best_answer): ?>
                        <a href="<?php echo base_url('forum/mark_best/' . encode_id($reply->id)); ?>" class="text-success small text-decoration-none"><?php echo t('Tandai sebagai jawaban terbaik', 'Mark as best answer'); ?></a>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <div class="card-flat p-4">
        <h6 class="fw-bold text-dark mb-3"><?php echo t('Tulis Balasan', 'Write a Reply'); ?></h6>
        <?php echo form_open('forum/reply/' . encode_id($discussion->id)); ?>
            <textarea name="content" rows="3" class="form-control mb-3" placeholder="<?php echo t('Tulis balasan...', 'Write your reply...'); ?>" required></textarea>
            <button type="submit" class="btn btn-primary btn-sm px-4 rounded-pill"><?php echo t('Kirim', 'Send'); ?></button>
        <?php echo form_close(); ?>
    </div>
</div>
