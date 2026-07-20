<?php
$og_title = $course->title . ' — ' . setting('general_site_name', 'BISATUNTAS');
$og_description = strip_tags(substr($course->description, 0, 160));
$og_image = $course->thumbnail ? base_url('uploads/courses/' . $course->thumbnail) : '';
?>
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "Course",
  "name": "<?php echo addslashes($course->title); ?>",
  "description": "<?php echo addslashes(strip_tags($course->description)); ?>",
  "provider": {
    "@type": "Organization",
    "name": "<?php echo setting('general_site_name', 'BISATUNTAS'); ?>",
    "sameAs": "<?php echo base_url(); ?>"
  }
  <?php if (isset($avg_rating) && $avg_rating): ?>
  ,"aggregateRating": {
    "@type": "AggregateRating",
    "ratingValue": "<?php echo $avg_rating; ?>",
    "reviewCount": "<?php echo $total_reviews; ?>"
  }
  <?php endif; ?>
  ,"offers": {
    "@type": "Offer",
    "price": "<?php echo $course->price; ?>",
    "priceCurrency": "IDR",
    "availability": "https://schema.org/InStock"
  }
}
</script>

<!-- Thumbnail -->
<div style="background: #f5f5f5; border-bottom: 1px solid #e5e5e5;">
    <div class="container" style="padding-top: 1.5rem; padding-bottom: 2rem; max-width: 960px;">
        <div class="position-relative overflow-hidden" style="border-radius: 12px; aspect-ratio: 16/9;">
            <img src="<?php echo base_url('uploads/courses/' . $course->thumbnail); ?>" onerror="this.src='https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=960&auto=format&fit=crop&q=60';" alt="<?php echo htmlspecialchars($course->title); ?>" class="w-100 h-100 object-fit-cover">
        </div>
    </div>
</div>

<!-- Content -->
<div class="container" style="max-width: 960px; padding-top: 1.5rem; padding-bottom: 3rem;">

    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-3 small" style="color: #a3a3a3;">
        <ol class="breadcrumb" style="background: none; padding: 0; font-size: 0.8rem;">
            <li class="breadcrumb-item"><a href="<?php echo base_url('courses'); ?>" style="color: #525252; text-decoration: none; font-weight: 500;"><?php echo t('Kelas', 'Courses'); ?></a></li>
            <li class="breadcrumb-item active" style="color: #737373; font-weight: 500;"><?php echo htmlspecialchars(substr(t($course->title, $course->title_en ?: $course->title), 0, 50)); ?>...</li>
        </ol>
    </nav>

    <!-- Header Info -->
    <div class="mb-4">
        <!-- Tags row -->
        <div class="d-flex flex-wrap gap-2 mb-3">
            <span class="fw-semibold px-2 py-1 rounded-pill" style="background: #111827; color: #fff; font-size: 0.7rem;"><?php echo content_type_label($course->content_type); ?></span>
            <span class="fw-semibold px-2 py-1 rounded-pill" style="background: #f5f5f5; color: #525252; font-size: 0.7rem;"><?php echo skill_level_label($course->skill_level); ?></span>
            <?php if ($course->price > 0): ?>
                <span class="fw-semibold px-2 py-1 rounded-pill" style="background: #fef3c7; color: #92400e; font-size: 0.7rem;">Rp <?php echo number_format($course->price, 0, ',', '.'); ?></span>
            <?php else: ?>
                <span class="fw-semibold px-2 py-1 rounded-pill" style="background: #ecfdf5; color: #065f46; font-size: 0.7rem;"><?php echo t('Gratis', 'Free'); ?></span>
            <?php endif; ?>
        </div>

        <h1 class="fw-extrabold text-dark mb-3 lh-sm" style="font-size: 1.6rem; letter-spacing: -0.02em;">
            <?php echo htmlspecialchars(t($course->title, $course->title_en ?: $course->title)); ?>
        </h1>

        <!-- Meta info -->
        <div class="d-flex flex-wrap align-items-center gap-3 mb-3" style="color: #737373; font-size: 0.8rem;">
            <span class="d-flex align-items-center gap-1">
                <img src="https://ui-avatars.com/api/?name=<?php echo urlencode($course->teacher_name); ?>&background=f59e0b&color=fff&size=20" alt="" style="width: 20px; height: 20px; border-radius: 50%;">
                <?php echo htmlspecialchars($course->teacher_name); ?>
            </span>
            <span class="d-flex align-items-center gap-1">
                <i class="fas fa-folder" style="font-size: 0.65rem;"></i>
                <?php echo htmlspecialchars($course->category_name); ?>
            </span>
            <span class="d-flex align-items-center gap-1">
                <i class="fas fa-users" style="font-size: 0.65rem;"></i>
                <?php echo $enrolled_count; ?> <?php echo t('siswa', 'students'); ?>
            </span>
            <span class="d-flex align-items-center gap-1">
                <i class="fas fa-star" style="color: #eab308; font-size: 0.65rem;"></i>
                <?php echo $avg_rating; ?> (<?php echo $review_count; ?>)
            </span>
            <?php if ($course->duration_total > 0): ?>
            <span class="d-flex align-items-center gap-1">
                <i class="far fa-clock" style="font-size: 0.65rem;"></i>
                <?php echo $course->duration_total; ?> <?php echo t('menit', 'min'); ?>
            </span>
            <?php endif; ?>
        </div>

        <!-- Tags -->
        <?php if (!empty($tags)): ?>
            <div class="d-flex flex-wrap gap-2 mb-3">
                <?php foreach ($tags as $tag): ?>
                    <span class="px-2 py-1 rounded-pill" style="background: #f5f5f5; color: #525252; font-size: 0.7rem; font-weight: 500;">#<?php echo htmlspecialchars($tag->name); ?></span>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>

    <!-- Tabs -->
    <ul class="nav d-flex gap-1 mb-4 border-bottom" style="border-color: #e5e5e5 !important; padding-bottom: 0;" id="courseTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link fw-semibold rounded-top" id="materi-tab" data-bs-toggle="tab" data-bs-target="#materi" type="button" role="tab" style="font-size: 0.825rem; color: #737373; background: #f5f5f5; border: none; border-bottom: 2px solid transparent; padding: 0.5rem 1rem;"><?php echo t('Materi', 'Curriculum'); ?></button>
        </li>
        <?php if (!empty($quizzes)): ?>
            <li class="nav-item"><button class="nav-link fw-semibold rounded-top" id="quiz-tab" data-bs-toggle="tab" data-bs-target="#quiz" type="button" role="tab" style="font-size: 0.825rem; color: #737373; background: transparent; border: none; border-bottom: 2px solid transparent; padding: 0.5rem 1rem;"><?php echo t('Quiz', 'Quiz'); ?> (<?php echo count($quizzes); ?>)</button></li>
        <?php endif; ?>
        <?php if (!empty($assignments)): ?>
            <li class="nav-item"><button class="nav-link fw-semibold rounded-top" id="project-tab" data-bs-toggle="tab" data-bs-target="#project" type="button" role="tab" style="font-size: 0.825rem; color: #737373; background: transparent; border: none; border-bottom: 2px solid transparent; padding: 0.5rem 1rem;"><?php echo t('Proyek', 'Projects'); ?> (<?php echo count($assignments); ?>)</button></li>
        <?php endif; ?>
        <li class="nav-item"><button class="nav-link fw-semibold rounded-top" id="review-tab" data-bs-toggle="tab" data-bs-target="#review" type="button" role="tab" style="font-size: 0.825rem; color: #737373; background: transparent; border: none; border-bottom: 2px solid transparent; padding: 0.5rem 1rem;"><?php echo t('Ulasan', 'Reviews'); ?> (<?php echo $review_count; ?>)</button></li>
        <li class="nav-item"><button class="nav-link fw-semibold rounded-top" id="forum-tab" data-bs-toggle="tab" data-bs-target="#forum" type="button" role="tab" style="font-size: 0.825rem; color: #737373; background: transparent; border: none; border-bottom: 2px solid transparent; padding: 0.5rem 1rem;"><?php echo t('Diskusi', 'Discussion'); ?> (<?php echo count($discussions); ?>)</button></li>
    </ul>

    <!-- Tab Content -->
    <div class="tab-content" style="min-height: 300px;">

        <!-- MATERI TAB -->
        <div class="tab-pane fade show active" id="materi" role="tabpanel">
            <!-- About -->
            <div class="border rounded-3 p-4 mb-4" style="border-color: #e5e5e5; border-radius: 12px;">
                <h6 class="fw-bold text-dark mb-2" style="font-size: 0.9rem;"><?php echo t('Tentang Konten Ini', 'About This Content'); ?></h6>
                <p class="small mb-0" style="color: #525252; line-height: 1.7; font-size: 0.85rem;"><?php echo nl2br(htmlspecialchars(t($course->description, $course->description_en ?: $course->description))); ?></p>
            </div>

            <!-- Curriculum -->
            <?php if (!empty($lessons)): ?>
                <h6 class="fw-bold text-dark mb-3" style="font-size: 0.9rem;"><?php echo t('Kurikulum', 'Curriculum'); ?> (<?php echo count($lessons); ?> <?php echo t('materi', 'lessons'); ?>)</h6>
                <div class="d-flex flex-column gap-2">
                    <?php foreach ($lessons as $i => $lesson): ?>
                        <div class="d-flex align-items-center gap-3 p-3 rounded-3" style="background: #fafafa; border: 1px solid #f0f0f0;">
                            <div class="d-flex align-items-center justify-content-center rounded-circle flex-shrink-0" style="width: 32px; height: 32px; background: #f5f5f5;">
                                <?php if ($lesson->lesson_type === 'video'): ?>
                                    <i class="fas fa-play" style="font-size: 0.65rem; color: #525252;"></i>
                                <?php elseif ($lesson->lesson_type === 'text'): ?>
                                    <i class="fas fa-file-alt" style="font-size: 0.65rem; color: #525252;"></i>
                                <?php else: ?>
                                    <i class="fas fa-pencil-alt" style="font-size: 0.65rem; color: #525252;"></i>
                                <?php endif; ?>
                            </div>
                            <div class="flex-fill min-w-0">
                                <p class="small mb-0 text-truncate" style="font-weight: 600; color: #111827; font-size: 0.825rem;">
                                    <?php echo $i + 1 ?>. <?php echo htmlspecialchars(t($lesson->title, $lesson->title_en ?: $lesson->title)); ?>
                                </p>
                                <?php if ($lesson->duration > 0): ?>
                                    <small style="color: #a3a3a3; font-size: 0.72rem;"><?php echo $lesson->duration; ?> <?php echo t('menit', 'min'); ?></small>
                                <?php endif; ?>
                            </div>
                            <?php if ($is_enrolled): ?>
                                <a href="<?php echo base_url('courses/learn/' . $course->slug . '/' . encode_id($lesson->id)); ?>" class="fw-semibold flex-shrink-0" style="color: #eab308; text-decoration: none; font-size: 0.8rem;">
                                    <?php echo t('Mulai', 'Start'); ?> <i class="fas fa-chevron-right" style="font-size: 0.6rem;"></i>
                                </a>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>

        <!-- QUIZ TAB -->
        <?php if (!empty($quizzes)): ?>
            <div class="tab-pane fade" id="quiz" role="tabpanel">
                <div class="d-flex flex-column gap-2">
                    <?php foreach ($quizzes as $qz): ?>
                        <?php $qcount = $quiz_question_counts[$qz->id] ?? 0; ?>
                        <div class="d-flex justify-content-between align-items-center p-3 rounded-3" style="border: 1px solid #e5e5e5; border-radius: 12px;">
                            <div>
                                <h6 class="fw-bold mb-1" style="font-size: 0.85rem; color: #111827;"><?php echo htmlspecialchars($qz->title); ?></h6>
                                <small style="color: #737373; font-size: 0.75rem;"><?php echo $qcount; ?> <?php echo t('soal', 'questions'); ?> · <?php echo t('Min lulus: ', 'Passing: '); ?><?php echo $qz->passing_score; ?>%</small>
                            </div>
                            <?php if ($is_enrolled): ?>
                                <a href="<?php echo base_url('quiz/start/' . encode_id($qz->id)); ?>" class="fw-semibold" style="color: #111827; text-decoration: none; font-size: 0.8rem;">
                                    <?php echo t('Kerjakan', 'Take Quiz'); ?> <i class="fas fa-chevron-right" style="font-size: 0.6rem;"></i>
                                </a>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>

        <!-- PROJECT TAB -->
        <?php if (!empty($assignments)): ?>
            <div class="tab-pane fade" id="project" role="tabpanel">
                <div class="d-flex flex-column gap-2">
                    <?php foreach ($assignments as $a): ?>
                        <div class="d-flex justify-content-between align-items-center p-3 rounded-3" style="border: 1px solid #e5e5e5; border-radius: 12px;">
                            <div class="min-w-0 me-3">
                                <h6 class="fw-bold mb-1" style="font-size: 0.85rem; color: #111827;"><?php echo htmlspecialchars($a->title); ?></h6>
                                <small style="color: #737373; font-size: 0.75rem;"><?php echo htmlspecialchars(substr($a->description, 0, 80)); ?>...</small>
                            </div>
                            <a href="<?php echo base_url('assignment/view/' . encode_id($a->id)); ?>" class="fw-semibold flex-shrink-0" style="color: #111827; text-decoration: none; font-size: 0.8rem;">
                                <?php echo t('Lihat', 'View'); ?> <i class="fas fa-chevron-right" style="font-size: 0.6rem;"></i>
                            </a>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>

        <!-- REVIEW TAB -->
        <div class="tab-pane fade" id="review" role="tabpanel">
            <!-- Rating Summary -->
            <div class="row g-3 mb-4">
                <div class="col-md-4">
                    <div class="border rounded-3 p-4 text-center" style="border-color: #e5e5e5; border-radius: 12px;">
                        <div class="fw-bold mb-1" style="font-size: 2.5rem; color: #111827; line-height: 1;"><?php echo $avg_rating; ?></div>
                        <div class="d-flex justify-content-center gap-1 mb-1">
                            <?php for ($s = 1; $s <= 5; $s++): ?>
                                <i class="fas fa-star" style="color: <?php echo $s <= round($avg_rating) ? '#eab308' : '#d4d4d4'; ?>; font-size: 0.8rem;"></i>
                            <?php endfor; ?>
                        </div>
                        <small style="color: #a3a3a3; font-size: 0.75rem;"><?php echo $review_count; ?> <?php echo t('ulasan', 'reviews'); ?></small>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="border rounded-3 p-4" style="border-color: #e5e5e5; border-radius: 12px;">
                        <?php foreach (array_reverse(range(5, 1)) as $star): ?>
                            <div class="d-flex align-items-center gap-2 mb-2" style="font-size: 0.8rem;">
                                <span class="fw-medium" style="color: #525252; min-width: 16px;"><?php echo $star; ?></span>
                                <i class="fas fa-star" style="color: #eab308; font-size: 0.6rem;"></i>
                                <div class="flex-fill rounded-pill overflow-hidden" style="height: 6px; background: #f5f5f5;">
                                    <div class="h-100 rounded-pill" style="width: <?php echo $review_count > 0 ? ($rating_counts[$star] / $review_count) * 100 : 0; ?>%; background: #eab308;"></div>
                                </div>
                                <span style="color: #a3a3a3; min-width: 20px; text-align: right; font-size: 0.75rem;"><?php echo $rating_counts[$star]; ?></span>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

            <!-- Review List -->
            <div class="d-flex flex-column gap-3">
                <?php foreach ($reviews as $r): ?>
                    <div class="d-flex gap-3 p-3 rounded-3" style="border: 1px solid #f0f0f0;">
                        <img src="https://ui-avatars.com/api/?name=<?php echo urlencode($r->user_name); ?>&background=f5f5f5&color=525252&size=36" alt="" style="width: 36px; height: 36px; border-radius: 50%; flex-shrink: 0;">
                        <div class="flex-fill min-w-0">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <span class="fw-semibold" style="color: #111827; font-size: 0.825rem;"><?php echo htmlspecialchars($r->user_name); ?></span>
                                <div class="d-flex gap-1">
                                    <?php for ($s = 1; $s <= 5; $s++): ?>
                                        <i class="fas fa-star" style="color: <?php echo $s <= $r->rating ? '#eab308' : '#d4d4d4'; ?>; font-size: 0.6rem;"></i>
                                    <?php endfor; ?>
                                </div>
                            </div>
                            <?php if ($r->review): ?>
                                <p class="small mb-0" style="color: #737373; line-height: 1.5; font-size: 0.8rem;"><?php echo nl2br(htmlspecialchars($r->review)); ?></p>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- Write Review Form -->
            <?php if ($is_enrolled): ?>
                <div class="border rounded-3 p-4 mt-4" style="border-color: #e5e5e5; border-radius: 12px;">
                    <h6 class="fw-bold mb-3" style="font-size: 0.9rem; color: #111827;"><?php echo t('Tulis Ulasan', 'Write a Review'); ?></h6>
                    <?php echo form_open('courses/review/' . $course->slug, array('class' => 'd-flex flex-column gap-3')); ?>
                        <div>
                            <label class="small fw-semibold mb-1" style="color: #525252; font-size: 0.8rem;"><?php echo t('Rating', 'Rating'); ?></label>
                            <div class="d-flex gap-1">
                                <?php for ($s = 5; $s >= 1; $s--): ?>
                                    <label class="d-inline-flex align-items-center cursor-pointer" style="width: 28px; height: 28px;">
                                        <input class="d-none" type="radio" name="rating" value="<?php echo $s; ?>" <?php echo $user_review && $user_review->rating == $s ? 'checked' : ($s === 5 && !$user_review ? 'checked' : ''); ?>>
                                        <i class="fas fa-star" style="color: #d4d4d4; font-size: 0.9rem; cursor: pointer;"></i>
                                    </label>
                                <?php endfor; ?>
                            </div>
                        </div>
                        <div>
                            <textarea name="review" rows="3" class="form-control" style="border-radius: 8px; border-color: #e5e5e5; font-size: 0.85rem;" placeholder="<?php echo t('Tulis ulasan...', 'Write your review...'); ?>"><?php echo $user_review ? htmlspecialchars($user_review->review) : ''; ?></textarea>
                        </div>
                        <div>
                            <button type="submit" class="btn px-4 py-2 fw-bold rounded-pill" style="background: #111827; color: #fff; font-size: 0.85rem;"><?php echo t('Kirim Ulasan', 'Submit Review'); ?></button>
                        </div>
                    <?php echo form_close(); ?>
                </div>
            <?php endif; ?>
        </div>

        <!-- FORUM TAB -->
        <div class="tab-pane fade" id="forum" role="tabpanel">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="fw-bold mb-0" style="font-size: 0.9rem; color: #111827;"><?php echo t('Forum Diskusi', 'Discussion Forum'); ?></h6>
                <?php if ($is_enrolled): ?>
                    <a href="<?php echo base_url('forum/create/' . $course->slug); ?>" class="btn btn-sm fw-semibold rounded-pill px-3" style="background: #111827; color: #fff; font-size: 0.8rem;"><?php echo t('Diskusi Baru', 'New Discussion'); ?></a>
                <?php endif; ?>
            </div>
            <div class="d-flex flex-column gap-2">
                <?php foreach (array_slice($discussions, 0, 5) as $d): ?>
                    <a href="<?php echo base_url('forum/view/' . encode_id($d->id)); ?>" class="text-decoration-none p-3 rounded-3 d-flex justify-content-between align-items-center" style="border: 1px solid #f0f0f0; transition: all 0.15s;">
                        <div class="min-w-0 flex-grow-1 me-3">
                            <p class="small mb-0 text-truncate" style="font-weight: 600; color: #111827; font-size: 0.825rem;">
                                <?php echo $d->is_pinned ? '<i class="fas fa-thumbtack me-1" style="color: #eab308; font-size: 0.65rem;"></i>' : ''; ?>
                                <?php echo htmlspecialchars($d->title); ?>
                            </p>
                            <small style="color: #a3a3a3; font-size: 0.72rem;"><?php echo htmlspecialchars($d->user_name); ?> · <?php echo time_elapsed($d->created_at); ?></small>
                        </div>
                        <span class="px-2 py-1 rounded-pill flex-shrink-0" style="background: #f5f5f5; color: #525252; font-size: 0.7rem; font-weight: 600;">
                            <?php echo $d->reply_count; ?> <?php echo t('balasan', 'replies'); ?>
                        </span>
                    </a>
                <?php endforeach; ?>
                <?php if (count($discussions) > 5): ?>
                    <a href="<?php echo base_url('forum/index/' . $course->slug); ?>" class="text-center small fw-semibold text-decoration-none pt-2" style="color: #eab308; font-size: 0.8rem;">
                        <?php echo t('Lihat semua diskusi', 'View all discussions'); ?> <i class="fas fa-chevron-right" style="font-size: 0.6rem;"></i>
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Sticky Sidebar (Mobile bottom bar) -->
<div class="d-block d-lg-block" style="position: static; z-index: 1040; background: #fff; border-top: 1px solid #e5e5e5; box-shadow: 0 -2px 8px rgba(0,0,0,0.04);" id="ctaBar">
    <div class="container d-flex justify-content-between align-items-center py-2 py-lg-3" style="max-width: 960px;">
        <div class="d-flex align-items-center gap-4">
            <div>
                <div class="fw-bold" style="color: #111827; font-size: 1.1rem;">
                    <?php if ($course->price > 0): ?>
                        Rp <?php echo number_format($course->price, 0, ',', '.'); ?>
                    <?php else: ?>
                        <?php echo t('Gratis', 'Free'); ?>
                    <?php endif; ?>
                </div>
            </div>
            <div class="d-none d-lg-flex align-items-center gap-3" style="color: #737373; font-size: 0.8rem;">
                <span class="d-flex align-items-center gap-1"><i class="fas fa-star" style="color: #eab308; font-size: 0.7rem;"></i> <?php echo $avg_rating; ?></span>
                <span>·</span>
                <span class="d-flex align-items-center gap-1"><i class="fas fa-users" style="font-size: 0.7rem;"></i> <?php echo $enrolled_count; ?> siswa</span>
                <span>·</span>
                <span class="d-flex align-items-center gap-1"><i class="far fa-clock" style="font-size: 0.7rem;"></i> <?php echo $course->duration_total; ?>m</span>
            </div>
        </div>
        <?php if ($is_enrolled): ?>
            <a href="<?php echo base_url('courses/learn/' . $course->slug); ?>" class="btn px-4 fw-bold rounded-pill" style="background: #eab308; color: #111827; font-size: 0.85rem;">
                <i class="fas fa-play me-1"></i> <?php echo t('Mulai Belajar', 'Start Learning'); ?>
            </a>
        <?php else: ?>
            <a href="<?php echo base_url('courses/buy/' . $course->slug); ?>" class="btn px-4 fw-bold rounded-pill" style="background: #eab308; color: #111827; font-size: 0.85rem;">
                <?php if ($course->price <= 0): ?>
                    <i class="fas fa-graduation-cap me-1"></i> <?php echo t('Daftar Gratis', 'Enroll Free'); ?>
                <?php else: ?>
                    <i class="fas fa-shopping-cart me-1"></i> Beli Sekarang
                <?php endif; ?>
            </a>
        <?php endif; ?>
    </div>
</div>

<!-- Course Info Section (below tabs, above footer) -->
<div class="container border-top" style="max-width: 960px; border-color: #e5e5e5 !important; padding-top: 2rem; padding-bottom: 3rem;">
    <div class="row g-4">
        <div class="col-md-8">
            <h6 class="fw-bold mb-3" style="font-size: 0.9rem; color: #111827;"><?php echo t('Detail Konten', 'Content Details'); ?></h6>
            <div class="row g-3">
                <div class="col-6 col-md-3">
                    <div class="text-center p-3 rounded-3" style="background: #f5f5f5;">
                        <div class="fw-bold mb-1" style="color: #111827; font-size: 1.1rem;"><?php echo $lessons ? count($lessons) : 0; ?></div>
                        <div style="color: #737373; font-size: 0.75rem;"><?php echo t('Materi', 'Lessons'); ?></div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="text-center p-3 rounded-3" style="background: #f5f5f5;">
                        <div class="fw-bold mb-1" style="color: #111827; font-size: 1.1rem;"><?php echo $quizzes ? count($quizzes) : 0; ?></div>
                        <div style="color: #737373; font-size: 0.75rem;"><?php echo t('Quiz', 'Quizzes'); ?></div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="text-center p-3 rounded-3" style="background: #f5f5f5;">
                        <div class="fw-bold mb-1" style="color: #111827; font-size: 1.1rem;"><?php echo $assignments ? count($assignments) : 0; ?></div>
                        <div style="color: #737373; font-size: 0.75rem;"><?php echo t('Proyek', 'Projects'); ?></div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="text-center p-3 rounded-3" style="background: #f5f5f5;">
                        <div class="fw-bold mb-1" style="color: #111827; font-size: 1.1rem;"><?php echo $course->duration_total ? $course->duration_total . 'm' : '-'; ?></div>
                        <div style="color: #737373; font-size: 0.75rem;"><?php echo t('Durasi', 'Duration'); ?></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <h6 class="fw-bold mb-3" style="font-size: 0.9rem; color: #111827;"><?php echo t('Pengajar', 'Instructor'); ?></h6>
            <div class="d-flex align-items-center gap-3 p-3 rounded-3" style="border: 1px solid #e5e5e5; border-radius: 12px;">
                <img src="https://ui-avatars.com/api/?name=<?php echo urlencode($course->teacher_name); ?>&background=f59e0b&color=fff&size=44" alt="" style="width: 44px; height: 44px; border-radius: 50%; flex-shrink: 0;">
                <div>
                    <div class="fw-bold" style="color: #111827; font-size: 0.85rem;"><?php echo htmlspecialchars($course->teacher_name); ?></div>
                    <small style="color: #a3a3a3; font-size: 0.75rem;"><?php echo t('Instruktur', 'Instructor'); ?></small>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
@media (min-width: 992px) { /* Adjust for desktop */
    #ctaBar { position: fixed; bottom: 0; left: 0; right: 0; }
}</style>
