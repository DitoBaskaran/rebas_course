<?php
$og_title = $course->title . ' — ' . setting('general_site_name', 'REBAS COURSE');
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
    "name": "<?php echo setting('general_site_name', 'REBAS COURSE'); ?>",
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
<div class="container py-5 my-4">
    <div class="row g-5">
        <!-- Main Content -->
        <div class="col-lg-8 animate-fade-in-up">
            <!-- Breadcrumb -->
            <nav aria-label="breadcrumb" class="mb-4 small">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo base_url('courses'); ?>" class="text-primary text-decoration-none fw-medium"><?php echo t('Konten', 'Content'); ?></a></li>
                    <li class="breadcrumb-item active fw-medium text-dark" aria-current="page"><?php echo htmlspecialchars(substr(t($course->title, $course->title_en ?: $course->title), 0, 40)); ?>...</li>
                </ol>
            </nav>

            <!-- Header -->
            <div class="mb-4">
                <div class="d-flex flex-wrap gap-2 mb-3">
                    <span class="badge bg-dark text-white rounded-pill px-3 py-2 fw-medium"><?php echo content_type_label($course->content_type); ?></span>
                    <span class="badge bg-primary-subtle text-primary rounded-pill px-3 py-2 fw-medium"><?php echo skill_level_label($course->skill_level); ?></span>
                    <?php if ($course->price > 0): ?>
                        <span class="badge bg-warning-subtle text-warning rounded-pill px-3 py-2 fw-medium">Rp <?php echo number_format($course->price, 0, ',', '.'); ?></span>
                    <?php else: ?>
                        <span class="badge bg-success-subtle text-success rounded-pill px-3 py-2 fw-medium"><?php echo t('Gratis', 'Free'); ?></span>
                    <?php endif; ?>
                </div>
                <h1 class="fw-extrabold text-dark mb-3 lh-sm" style="letter-spacing: -0.03em; font-size: 1.75rem;"><?php echo htmlspecialchars(t($course->title, $course->title_en ?: $course->title)); ?></h1>
                <div class="d-flex flex-wrap align-items-center gap-3 text-secondary small">
                    <span class="d-flex align-items-center gap-1"><i class="fas fa-chalkboard-teacher text-primary"></i> <?php echo htmlspecialchars($course->teacher_name); ?></span>
                    <?php if ($course->category_name): ?>
                        <span class="d-flex align-items-center gap-1"><i class="fas fa-folder text-info"></i> <?php echo htmlspecialchars($course->category_name); ?></span>
                    <?php endif; ?>
                    <span class="d-flex align-items-center gap-1"><i class="fas fa-users text-success"></i> <?php echo $enrolled_count; ?> <?php echo t('siswa', 'students'); ?></span>
                    <?php if ($course->duration_total > 0): ?>
                        <span class="d-flex align-items-center gap-1"><i class="far fa-clock text-warning"></i> <?php echo $course->duration_total; ?> <?php echo t('menit', 'min'); ?></span>
                    <?php endif; ?>
                    <span class="d-flex align-items-center gap-1"><i class="fas fa-star text-warning"></i> <?php echo $avg_rating; ?> (<?php echo $review_count; ?>)</span>
                </div>
                <?php if (!empty($tags)): ?>
                    <div class="d-flex flex-wrap gap-2 mt-3">
                        <?php foreach ($tags as $tag): ?>
                            <span class="badge bg-light text-secondary rounded-pill px-3 py-2 fw-medium border">#<?php echo htmlspecialchars($tag->name); ?></span>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Thumbnail -->
            <div class="rounded-4 overflow-hidden mb-4 shadow-sm">
                <img src="<?php echo base_url('uploads/courses/' . $course->thumbnail); ?>" onerror="this.src='https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=800&auto=format&fit=crop&q=60';" alt="<?php echo htmlspecialchars($course->title); ?>" class="w-100 object-fit-cover" style="height: 400px;">
            </div>

            <!-- Tabs -->
            <ul class="nav nav-tabs border-0 tabs-modern mb-4 gap-1" id="courseTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active fw-semibold rounded-pill" id="materi-tab" data-bs-toggle="tab" data-bs-target="#materi" type="button" role="tab"><?php echo t('Materi', 'Curriculum'); ?></button>
                </li>
                <?php if (!empty($quizzes)): ?>
                    <li class="nav-item"><button class="nav-link fw-semibold rounded-pill" id="quiz-tab" data-bs-toggle="tab" data-bs-target="#quiz" type="button" role="tab"><?php echo t('Quiz', 'Quiz'); ?> (<?php echo count($quizzes); ?>)</button></li>
                <?php endif; ?>
                <?php if (!empty($assignments)): ?>
                    <li class="nav-item"><button class="nav-link fw-semibold rounded-pill" id="project-tab" data-bs-toggle="tab" data-bs-target="#project" type="button" role="tab"><?php echo t('Proyek', 'Projects'); ?> (<?php echo count($assignments); ?>)</button></li>
                <?php endif; ?>
                <li class="nav-item"><button class="nav-link fw-semibold rounded-pill" id="review-tab" data-bs-toggle="tab" data-bs-target="#review" type="button" role="tab"><?php echo t('Ulasan', 'Reviews'); ?> (<?php echo $review_count; ?>)</button></li>
                <li class="nav-item"><button class="nav-link fw-semibold rounded-pill" id="forum-tab" data-bs-toggle="tab" data-bs-target="#forum" type="button" role="tab"><?php echo t('Diskusi', 'Discussion'); ?> (<?php echo count($discussions); ?>)</button></li>
            </ul>

            <div class="tab-content">
                <div class="tab-pane fade show active" id="materi" role="tabpanel">
                    <div class="card border-0 shadow-sm rounded-4 p-4 p-xl-5 mb-4">
                        <h6 class="fw-bold text-dark mb-3"><?php echo t('Tentang Konten Ini', 'About This Content'); ?></h6>
                        <p class="text-secondary small mb-0 lh-base"><?php echo nl2br(htmlspecialchars(t($course->description, $course->description_en ?: $course->description))); ?></p>
                    </div>
                    <?php if (!empty($lessons)): ?>
                        <h6 class="fw-bold text-dark mb-3"><?php echo t('Kurikulum', 'Curriculum'); ?> (<?php echo count($lessons); ?> <?php echo t('materi', 'lessons'); ?>)</h6>
                        <div class="d-flex flex-column gap-2">
                            <?php foreach ($lessons as $i => $lesson): ?>
                                <div class="d-flex align-items-center gap-3 p-3 rounded-3 bg-light border-0">
                                    <div class="d-flex align-items-center justify-content-center bg-white text-secondary rounded-circle fw-bold flex-shrink-0 shadow-sm" style="width: 36px; height: 36px;">
                                        <?php echo $lesson->lesson_type === 'video' ? '<i class="fas fa-play-circle text-primary"></i>' : ($lesson->lesson_type === 'text' ? '<i class="fas fa-file-alt text-info"></i>' : '<i class="fas fa-pencil-alt text-warning"></i>'); ?>
                                    </div>
                                    <div class="flex-fill min-w-0">
                                        <p class="fw-semibold text-dark small mb-0 text-truncate"><?php echo htmlspecialchars(t($lesson->title, $lesson->title_en ?: $lesson->title)); ?></p>
                                        <small class="text-secondary"><?php echo $lesson->duration > 0 ? $lesson->duration . ' ' . t('menit', 'min') : ''; ?></small>
                                    </div>
                                    <?php if ($is_enrolled): ?>
                                        <a href="<?php echo base_url('courses/learn/' . $course->slug . '/' . $lesson->id); ?>" class="btn btn-dark btn-sm rounded-pill px-3 flex-shrink-0 fw-semibold"><?php echo t('Mulai', 'Start'); ?></a>
                                    <?php endif; ?>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- QUIZ TAB -->
                <?php if (!empty($quizzes)): ?>
                    <div class="tab-pane fade" id="quiz" role="tabpanel">
                        <div class="d-flex flex-column gap-3">
                            <?php foreach ($quizzes as $qz): ?>
                                <?php $qcount = $quiz_question_counts[$qz->id] ?? 0; ?>
                                <div class="card border-0 shadow-sm rounded-4 p-4 d-flex justify-content-between align-items-center flex-column flex-md-row gap-3">
                                    <div>
                                        <h6 class="fw-bold text-dark mb-1"><?php echo htmlspecialchars($qz->title); ?></h6>
                                        <p class="text-secondary small mb-0"><?php echo $qcount; ?> <?php echo t('soal', 'questions'); ?> | <?php echo t('Min lulus: ', 'Passing: '); ?><?php echo $qz->passing_score; ?>%</p>
                                    </div>
                                    <div>
                                        <?php if ($is_enrolled): ?>
                                            <a href="<?php echo base_url('quiz/start/' . $qz->id); ?>" class="btn btn-dark rounded-pill px-3 fw-semibold"><?php echo t('Kerjakan', 'Take Quiz'); ?></a>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- PROJECT TAB -->
                <?php if (!empty($assignments)): ?>
                    <div class="tab-pane fade" id="project" role="tabpanel">
                        <div class="d-flex flex-column gap-3">
                            <?php foreach ($assignments as $a): ?>
                                <div class="card border-0 shadow-sm rounded-4 p-4 d-flex justify-content-between align-items-center flex-column flex-md-row gap-3">
                                    <div class="flex-fill me-3">
                                        <h6 class="fw-bold text-dark mb-1"><?php echo htmlspecialchars($a->title); ?></h6>
                                        <p class="text-secondary small mb-0 text-truncate-2"><?php echo htmlspecialchars($a->description); ?></p>
                                    </div>
                                    <a href="<?php echo base_url('assignment/view/' . $a->id); ?>" class="btn btn-outline-dark rounded-pill px-3 fw-semibold flex-shrink-0"><?php echo t('Lihat', 'View'); ?></a>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- REVIEW TAB -->
                <div class="tab-pane fade" id="review" role="tabpanel">
                    <div class="row g-4 mb-4">
                        <div class="col-md-4 text-center">
                            <div class="card border-0 shadow-sm rounded-4 p-4">
                                <h1 class="fw-black text-dark mb-0" style="font-size: 3rem;"><?php echo $avg_rating; ?></h1>
                                <div class="text-warning mb-1">
                                    <?php for ($s = 1; $s <= 5; $s++): ?>
                                        <i class="fas fa-star <?php echo $s <= round($avg_rating) ? '' : 'text-muted'; ?>" style="font-size: 0.875rem;"></i>
                                    <?php endfor; ?>
                                </div>
                                <small class="text-secondary"><?php echo $review_count; ?> <?php echo t('ulasan', 'reviews'); ?></small>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="card border-0 shadow-sm rounded-4 p-4">
                                <?php foreach (array_reverse(range(5, 1)) as $star): ?>
                                    <div class="d-flex align-items-center gap-2 small mb-2">
                                        <span class="text-secondary" style="min-width: 32px;"><?php echo $star; ?> <i class="fas fa-star ms-1" style="font-size: 0.5rem;"></i></span>
                                        <div class="progress-modern flex-fill"><div class="progress-bar" style="width: <?php echo $review_count > 0 ? ($rating_counts[$star] / $review_count) * 100 : 0; ?>%;"></div></div>
                                        <span class="text-secondary" style="min-width: 24px; text-align: right;"><?php echo $rating_counts[$star]; ?></span>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex flex-column gap-3">
                        <?php foreach ($reviews as $r): ?>
                            <div class="card border-0 shadow-sm rounded-4 p-4 d-flex gap-3">
                                <img src="<?php echo base_url('uploads/avatars/' . ($r->avatar ?: 'default_avatar.png')); ?>" onerror="this.src='https://ui-avatars.com/api/?name=<?php echo urlencode($r->user_name); ?>&background=4361ee&color=fff&size=40';" alt="" class="rounded-circle flex-shrink-0" style="width: 40px; height: 40px; object-fit: cover;">
                                <div class="flex-fill min-w-0">
                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                        <span class="fw-bold text-dark small"><?php echo htmlspecialchars($r->user_name); ?></span>
                                        <div class="text-warning small">
                                            <?php for ($s = 1; $s <= 5; $s++): ?>
                                                <i class="fas fa-star<?php echo $s <= $r->rating ? '' : '-o text-muted'; ?>"></i>
                                            <?php endfor; ?>
                                        </div>
                                    </div>
                                    <?php if ($r->review): ?>
                                        <p class="small text-secondary mt-1 mb-0"><?php echo nl2br(htmlspecialchars($r->review)); ?></p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <?php if ($is_enrolled): ?>
                        <div class="card border-0 shadow-sm rounded-4 p-4 p-xl-5 mt-4">
                            <h6 class="fw-bold text-dark mb-3"><?php echo t('Tulis Ulasan', 'Write a Review'); ?></h6>
                            <?php echo form_open('courses/review/' . $course->slug, array('class' => 'd-flex flex-column gap-3')); ?>
                                <div>
                                    <label class="form-label"><?php echo t('Rating', 'Rating'); ?></label>
                                    <div class="d-flex gap-2">
                                        <?php for ($s = 5; $s >= 1; $s--): ?>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="rating" id="star<?php echo $s; ?>" value="<?php echo $s; ?>" <?php echo $user_review && $user_review->rating == $s ? 'checked' : ($s === 5 && !$user_review ? 'checked' : ''); ?>>
                                                <label class="form-check-label text-warning small" for="star<?php echo $s; ?>"><i class="fas fa-star"></i> <?php echo $s; ?></label>
                                            </div>
                                        <?php endfor; ?>
                                    </div>
                                </div>
                                <div>
                                    <textarea name="review" rows="3" class="form-control" placeholder="<?php echo t('Tulis ulasan...', 'Write your review...'); ?>"><?php echo $user_review ? htmlspecialchars($user_review->review) : ''; ?></textarea>
                                </div>
                                <div>
                                    <button type="submit" class="btn btn-dark rounded-pill px-4 py-2 fw-semibold"><?php echo t('Kirim Ulasan', 'Submit Review'); ?></button>
                                </div>
                            <?php echo form_close(); ?>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- FORUM TAB -->
                <div class="tab-pane fade" id="forum" role="tabpanel">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h6 class="fw-bold text-dark mb-0"><?php echo t('Forum Diskusi', 'Discussion Forum'); ?></h6>
                        <?php if ($is_enrolled): ?>
                            <a href="<?php echo base_url('forum/create/' . $course->slug); ?>" class="btn btn-dark btn-sm rounded-pill px-3 fw-semibold"><?php echo t('Diskusi Baru', 'New Discussion'); ?></a>
                        <?php endif; ?>
                    </div>
                    <div class="d-flex flex-column gap-2">
                        <?php foreach (array_slice($discussions, 0, 5) as $d): ?>
                            <a href="<?php echo base_url('forum/view/' . $d->id); ?>" class="text-decoration-none p-3 rounded-3 bg-light d-flex justify-content-between align-items-center border-0" style="transition: all 0.2s;">
                                <div class="min-w-0 flex-grow-1 me-3">
                                    <p class="fw-semibold text-dark small mb-0 text-truncate"><?php echo $d->is_pinned ? '<i class="fas fa-thumbtack text-warning me-1"></i>' : ''; ?><?php echo htmlspecialchars($d->title); ?></p>
                                    <small class="text-secondary"><?php echo htmlspecialchars($d->user_name); ?> · <?php echo time_elapsed($d->created_at); ?></small>
                                </div>
                                <span class="badge bg-light text-secondary rounded-pill px-3 py-2 fw-medium flex-shrink-0 border"><?php echo $d->reply_count; ?> <?php echo t('balasan', 'replies'); ?></span>
                            </a>
                        <?php endforeach; ?>
                        <?php if (count($discussions) > 5): ?>
                            <a href="<?php echo base_url('forum/index/' . $course->slug); ?>" class="text-center text-primary small fw-semibold text-decoration-none border-bottom border-primary pb-1"><?php echo t('Lihat semua diskusi', 'View all discussions'); ?></a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4 animate-fade-in-up stagger-1">
            <div class="card border-0 shadow-sm rounded-4 p-4 p-xl-5 sticky-top" style="top: 100px;">
                <?php if ($is_enrolled): ?>
                    <a href="<?php echo base_url('courses/learn/' . $course->slug); ?>" class="btn btn-success w-100 mb-3 rounded-pill py-3 fw-semibold shadow-sm d-flex align-items-center justify-content-center gap-2">
                        <i class="fas fa-play-circle"></i> <?php echo t('Mulai Belajar', 'Start Learning'); ?>
                    </a>
                    <a href="<?php echo base_url('forum/index/' . $course->slug); ?>" class="btn btn-outline-dark w-100 rounded-pill py-2 fw-semibold"><?php echo t('Forum Diskusi', 'Discussion Forum'); ?></a>
                <?php else: ?>
                    <a href="<?php echo base_url('courses/buy/' . $course->slug); ?>" class="btn btn-dark w-100 mb-3 rounded-pill py-3 fw-semibold shadow-sm d-flex align-items-center justify-content-center gap-2">
                        <?php if ($course->price <= 0): ?>
                            <i class="fas fa-graduation-cap"></i> <?php echo t('Daftar Gratis', 'Enroll Free'); ?>
                        <?php else: ?>
                            <i class="fas fa-shopping-cart"></i> Beli Rp <?php echo number_format($course->price, 0, ',', '.'); ?>
                        <?php endif; ?>
                    </a>
                <?php endif; ?>

                <div class="d-flex flex-column gap-3 small border-top border-light pt-4 mt-3">
                    <div class="d-flex justify-content-between">
                        <span class="text-secondary"><?php echo t('Tipe', 'Type'); ?></span>
                        <span class="fw-bold text-dark"><?php echo content_type_label($course->content_type); ?></span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="text-secondary"><?php echo t('Level', 'Level'); ?></span>
                        <span class="fw-bold text-dark"><?php echo skill_level_label($course->skill_level); ?></span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="text-secondary"><?php echo t('Bahasa', 'Language'); ?></span>
                        <span class="fw-bold text-dark"><?php echo strtoupper($course->language); ?></span>
                    </div>
                    <?php if ($course->duration_total > 0): ?>
                        <div class="d-flex justify-content-between">
                            <span class="text-secondary"><?php echo t('Durasi', 'Duration'); ?></span>
                            <span class="fw-bold text-dark"><?php echo $course->duration_total; ?> <?php echo t('menit', 'min'); ?></span>
                        </div>
                    <?php endif; ?>
                    <div class="d-flex justify-content-between">
                        <span class="text-secondary"><?php echo t('Siswa', 'Students'); ?></span>
                        <span class="fw-bold text-dark"><?php echo $enrolled_count; ?></span>
                    </div>
                </div>

                <hr class="my-4">
                <div class="d-flex align-items-center gap-3">
                    <img src="<?php echo base_url('uploads/avatars/' . ($course->teacher_avatar ?: 'default_avatar.png')); ?>" onerror="this.src='https://ui-avatars.com/api/?name=<?php echo urlencode($course->teacher_name); ?>&background=4361ee&color=fff&size=48';" alt="" class="rounded-circle flex-shrink-0 object-fit-cover" style="width: 48px; height: 48px;">
                    <div class="min-w-0">
                        <p class="fw-bold text-dark small mb-0"><?php echo htmlspecialchars($course->teacher_name); ?></p>
                        <small class="text-secondary"><?php echo t('Pengajar', 'Instructor'); ?></small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
