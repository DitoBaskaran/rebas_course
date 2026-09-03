<div class="container-fluid py-4" style="padding-top: 0px !important; max-width: 900px; padding-bottom: 6.5rem !important;">

    <!-- ===== BACK + META ===== -->
    <div class="d-flex align-items-center gap-3 mb-4">
        <a href="<?php echo base_url('forum/index/' . $course->slug); ?>" class="text-decoration-none d-flex align-items-center justify-content-center flex-shrink-0 rounded-circle border" style="width:38px; height:38px; border-color:#e7e5e4 !important; background:#fff; color:#0D1830; box-shadow:0 1px 3px rgba(0,0,0,0.04);">
            <i class="fas fa-arrow-left" style="font-size:0.8rem;"></i>
        </a>
        <div class="flex-fill min-w-0" style="min-width:0;">
            <div class="fw-semibold text-truncate" style="font-size:0.68rem; color:#009688; text-transform:uppercase; letter-spacing:0.04em;"><?php echo htmlspecialchars(t($course->title, $course->title_en ?? $course->title)); ?></div>
            <h5 class="fw-extrabold mb-0" style="color:#0D1830; letter-spacing:-0.02em; font-size:1.05rem; line-height:1.35; display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; overflow:hidden;"><?php echo $discussion->is_pinned ? '<i class="fas fa-thumbtack" style="color:#FBBF24; font-size:0.75rem;"></i> ' : ''; ?><?php echo htmlspecialchars($discussion->title); ?></h5>
            <div class="d-flex align-items-center gap-2 mt-0" style="color:#a8a29e; font-size:0.7rem; white-space:nowrap;">
                <span class="d-inline-flex align-items-center gap-1"><i class="far fa-comment"></i> <?php echo count($replies); ?> <?php echo t('balasan', 'replies'); ?></span>
                <span class="opacity-50">·</span>
                <span><i class="far fa-clock"></i> <?php echo time_elapsed($discussion->created_at); ?></span>
            </div>
        </div>
    </div>

    <!-- ===== POSTINGAN PERTANYAAN ===== -->
    <div class="bg-white rounded-4 border p-4 mb-4" style="border-color:#f0eeeb !important; box-shadow:0 1px 4px rgba(0,0,0,0.03);">
        <div class="d-flex gap-3">
            <img src="<?php echo base_url('uploads/avatars/' . ($discussion->avatar ?: 'default_avatar.png')); ?>" onerror="this.src='https://ui-avatars.com/api/?name=<?php echo urlencode($discussion->user_name); ?>&background=0D1830&color=fff&size=64';" alt="" class="rounded-circle flex-shrink-0" style="width:44px; height:44px; object-fit:cover;">
            <div class="flex-fill min-w-0">
                <div class="d-flex align-items-center justify-content-between flex-wrap gap-1 mb-1">
                    <div class="d-flex align-items-center gap-2 min-w-0">
                        <span class="fw-bold text-dark text-truncate" style="font-size:0.82rem;"><?php echo htmlspecialchars($discussion->user_name); ?></span>
                        <span style="color:#a8a29e; font-size:0.68rem;"><?php echo time_elapsed($discussion->created_at); ?></span>
                    </div>
                </div>
                <p class="text-dark mb-0" style="font-size:0.85rem; line-height:1.6; white-space:pre-line;"><?php echo htmlspecialchars($discussion->content); ?></p>
            </div>
        </div>
    </div>

    <!-- ===== DAFTAR BALASAN ===== -->
    <div class="d-flex align-items-center justify-content-between mb-3">
        <h6 class="fw-bold mb-0" style="color:#0D1830; font-size:0.9rem;"><?php echo count($replies); ?> <?php echo t('Balasan', 'Replies'); ?></h6>
        <?php if ($has_best_answer): ?><span class="app-chip app-chip-green"><i class="fas fa-check-circle"></i> <?php echo t('Terjawab', 'Answered'); ?></span><?php endif; ?>
    </div>

    <div class="d-flex flex-column gap-3 mb-4">
        <?php if (empty($replies)): ?>
            <div class="mob-empty" style="background:#fff; border:1px solid #f0eeeb; border-radius:16px; padding:2.2rem 1rem;">
                <i class="fas fa-comment-slash"></i>
                <p><?php echo t('Belum ada balasan. Jadilah yang pertama menjawab!', 'No replies yet. Be the first to answer!'); ?></p>
            </div>
        <?php endif; ?>
        <?php foreach ($replies as $reply): ?>
            <div class="bg-white rounded-4 border p-4 <?php echo $reply->is_best_answer ? 'forum-best' : ''; ?>" style="<?php echo $reply->is_best_answer ? 'border-color:#009688 !important;' : 'border-color:#f0eeeb !important;'; ?> box-shadow:0 1px 4px rgba(0,0,0,0.03);" id="reply-<?php echo $reply->id; ?>">
                <?php if ($reply->is_best_answer): ?>
                <div class="d-flex align-items-center gap-2 mb-2" style="background:#E0F2F1; border-radius:8px; padding:0.35rem 0.65rem; width:fit-content;">
                    <i class="fas fa-check-circle" style="color:#009688; font-size:0.75rem;"></i>
                    <span class="fw-bold" style="color:#00796B; font-size:0.68rem;"><?php echo t('Jawaban Terbaik', 'Best Answer'); ?></span>
                </div>
                <?php endif; ?>
                <div class="d-flex gap-3">
                    <img src="<?php echo base_url('uploads/avatars/' . ($reply->avatar ?: 'default_avatar.png')); ?>" onerror="this.src='https://ui-avatars.com/api/?name=<?php echo urlencode($reply->user_name); ?>&background=009688&color=fff&size=64';" alt="" class="rounded-circle flex-shrink-0" style="width:38px; height:38px; object-fit:cover;">
                    <div class="flex-fill min-w-0">
                        <div class="d-flex align-items-center justify-content-between flex-wrap gap-1 mb-1">
                            <div class="d-flex align-items-center gap-2 min-w-0">
                                <span class="fw-bold text-dark text-truncate" style="font-size:0.8rem;"><?php echo htmlspecialchars($reply->user_name); ?></span>
                                <?php if ($reply->user_id === $discussion->user_id): ?><span class="rounded-pill px-2 py-0 fw-semibold" style="background:#E0F2F1; color:#009688; font-size:0.58rem;"><?php echo t('Penanya', 'Author'); ?></span><?php endif; ?>
                                <span style="color:#a8a29e; font-size:0.68rem;"><?php echo time_elapsed($reply->created_at); ?></span>
                            </div>
                            <?php if ($discussion->user_id == $this->session->userdata('user_id') && !$reply->is_best_answer && !$has_best_answer): ?>
                                <a href="<?php echo base_url('forum/mark_best/' . encode_id($reply->id)); ?>" class="text-decoration-none fw-semibold d-inline-flex align-items-center gap-1" style="color:#009688; font-size:0.7rem;"><i class="fas fa-check-circle"></i> <?php echo t('Jadikan jawaban terbaik', 'Mark as best'); ?></a>
                            <?php endif; ?>
                        </div>
                        <p class="text-dark mb-0" style="font-size:0.83rem; line-height:1.6; white-space:pre-line;"><?php echo nl2br(htmlspecialchars($reply->content)); ?></p>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- ===== FORM BALAS ===== -->
    <div class="bg-white rounded-4 border p-4" style="border-color:#f0eeeb !important; box-shadow:0 1px 4px rgba(0,0,0,0.03);">
        <h6 class="fw-bold mb-3" style="color:#0D1830; font-size:0.85rem;"><i class="far fa-paper-plane me-1" style="color:#009688;"></i> <?php echo t('Tulis Balasan', 'Write a Reply'); ?></h6>
        <?php echo form_open('forum/reply/' . encode_id($discussion->id), array('class' => 'd-flex flex-column gap-3')); ?>
            <textarea name="content" rows="3" class="form-control" placeholder="<?php echo t('Tulis balasan dengan sopan dan bermanfaat...', 'Write a polite and helpful reply...'); ?>" required style="border-color:#e7e5e4; border-radius:10px; font-size:0.85rem; resize:vertical;"></textarea>
            <div class="d-flex justify-content-end">
                <button type="submit" class="btn fw-bold rounded-pill px-4 py-2" style="background:#009688; color:#fff; font-size:0.8rem;"><i class="fas fa-paper-plane me-1" style="font-size:0.7rem;"></i> <?php echo t('Kirim Balasan', 'Send Reply'); ?></button>
            </div>
        <?php echo form_close(); ?>
    </div>
</div>
