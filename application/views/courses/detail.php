<?php
$_is_panel = $this->session->userdata('logged_in');
$title_local = t($course->title, $course->title_en ?: $course->title);
$desc_local = t($course->description, $course->description_en ?: $course->description);
?>

<?php if ($_is_panel): ?>
<!-- ============ PANEL STUDENT (Mobile App-Style Modern) ============ -->
<div class="container-fluid p-0" style="max-width: 1000px; margin: 0 auto; background: var(--content-bg);">
    
    <!-- Mobile-Only Hero & Header -->
    <div class="dashboard-mobile-only">
        <!-- Sticky Top Back Button -->
        <div class="position-fixed top-0 start-0 w-100 d-flex align-items-center justify-content-between px-3" style="z-index: 1060; height: 56px; background: linear-gradient(to bottom, rgba(0,0,0,0.4), transparent); pointer-events: none;">
            <a href="javascript:history.back()" class="d-flex align-items-center justify-content-center rounded-circle" style="width: 36px; height: 36px; background: rgba(255,255,255,0.2); backdrop-filter: blur(10px); color: #fff; text-decoration: none; pointer-events: auto;">
                <i class="fas fa-arrow-left"></i>
            </a>
            <div class="d-flex gap-2" style="pointer-events: auto;">
                <a href="<?php echo base_url('wishlist/toggle/' . encode_id($course->id)); ?>" class="d-flex align-items-center justify-content-center rounded-circle" style="width: 36px; height: 36px; background: rgba(255,255,255,0.2); backdrop-filter: blur(10px); color: #fff; text-decoration: none;">
                    <i class="far fa-heart"></i>
                </a>
            </div>
        </div>

        <!-- Hero Section -->
        <div class="position-relative overflow-hidden" style="height: 240px; background: #0D1830;">
            <img src="<?php echo base_url('uploads/courses/' . $course->thumbnail); ?>" alt="" class="w-100 h-100 object-fit-cover" style="opacity: 0.7;">
            <div class="position-absolute bottom-0 start-0 w-100 p-3" style="background: linear-gradient(to top, rgba(0,0,0,0.9) 0%, transparent 100%);">
                <div class="d-flex gap-2 mb-2">
                    <span class="px-2 py-1 rounded-pill fw-bold" style="background: var(--primary); color: #fff; font-size: 0.6rem;"><?php echo content_type_label($course->content_type); ?></span>
                    <span class="px-2 py-1 rounded-pill fw-semibold" style="background: rgba(255,255,255,0.2); backdrop-filter: blur(4px); color: #fff; font-size: 0.6rem;"><?php echo skill_level_label($course->skill_level); ?></span>
                </div>
                <h4 class="fw-extrabold text-white mb-1" style="font-size: 1.25rem; line-height: 1.3; letter-spacing: -0.01em;">
                    <?php echo htmlspecialchars($title_local); ?>
                </h4>
                <div class="d-flex align-items-center gap-3 text-white-50" style="font-size: 0.72rem;">
                    <span><i class="fas fa-star text-warning me-1"></i><?php echo $avg_rating; ?> (<?php echo $review_count; ?>)</span>
                    <span>·</span>
                    <span><i class="fas fa-users me-1"></i><?php echo $enrolled_count; ?> <?php echo t('siswa', 'students'); ?></span>
                </div>
            </div>
        </div>

        <!-- Sticky Bottom CTA (Mobile) -->
        <div class="position-fixed bottom-0 start-0 w-100 p-3 pb-4 d-flex align-items-center gap-3" style="z-index: 1051; background: rgba(255,255,255,0.92); backdrop-filter: blur(15px); border-top: 1px solid #f0eeeb; box-shadow: 0 -4px 20px rgba(0,0,0,0.05); padding-bottom: calc(1rem + env(safe-area-inset-bottom)) !important;">
            <div class="flex-grow-1">
                <div class="text-muted" style="font-size: 0.65rem; font-weight: 600;"><?php echo t('Harga', 'Price'); ?></div>
                <div class="fw-extrabold" style="font-size: 1.15rem; color: #0D1830;">
                    <?php if ($course->price > 0): ?>
                        Rp <?php echo number_format($course->price, 0, ',', '.'); ?>
                    <?php else: ?>
                        <?php echo t('Gratis', 'Free'); ?>
                    <?php endif; ?>
                </div>
            </div>
            <?php if ($is_enrolled): ?>
                <a href="<?php echo base_url('courses/learn/' . $course->slug); ?>" class="btn px-4 py-2 fw-bold rounded-pill h-100 d-flex align-items-center justify-content-center" style="background: var(--primary); color: #fff; font-size: 0.85rem; min-height: 48px;">
                    <i class="fas fa-play me-2"></i> <?php echo t('Mulai Belajar', 'Start Learning'); ?>
                </a>
            <?php else: ?>
                <a href="<?php echo base_url('courses/buy/' . $course->slug); ?>" class="btn px-4 py-2 fw-bold rounded-pill h-100 d-flex align-items-center justify-content-center" style="background: var(--primary); color: #fff; font-size: 0.85rem; min-height: 48px;">
                    <?php echo ($course->price <= 0) ? t('Daftar Gratis', 'Enroll Free') : t('Beli Sekarang', 'Buy Now'); ?>
                </a>
            <?php endif; ?>
        </div>
    </div>

    <!-- Desktop Panel Version Header -->
    <div class="dashboard-desktop-only px-4 pt-4">
        <div class="row g-4 mb-4">
            <div class="col-md-5">
                <div class="rounded-4 overflow-hidden shadow-sm" style="aspect-ratio: 16/9; background: #0D1830;">
                    <img src="<?php echo base_url('uploads/courses/' . $course->thumbnail); ?>" alt="" class="w-100 h-100 object-fit-cover">
                </div>
            </div>
            <div class="col-md-7 d-flex flex-column justify-content-center">
                <div class="d-flex gap-2 mb-3">
                    <span class="px-2 py-1 rounded-pill fw-bold" style="background: #f0fdf4; color: #166534; font-size: 0.65rem;"><?php echo content_type_label($course->content_type); ?></span>
                    <span class="px-2 py-1 rounded-pill fw-semibold" style="background: #E6EBEF; color: #57534e; font-size: 0.65rem;"><?php echo skill_level_label($course->skill_level); ?></span>
                </div>
                <h2 class="fw-extrabold mb-3" style="color: #0D1830; letter-spacing: -0.02em;"><?php echo htmlspecialchars($title_local); ?></h2>
                <div class="d-flex align-items-center gap-4 mb-4" style="color: #78716c; font-size: 0.85rem;">
                    <span><i class="fas fa-star text-warning me-1"></i><strong><?php echo $avg_rating; ?></strong> (<?php echo $review_count; ?> <?php echo t('ulasan', 'reviews'); ?>)</span>
                    <span><i class="fas fa-users me-1"></i><?php echo $enrolled_count; ?> <?php echo t('siswa', 'students'); ?></span>
                    <span><i class="far fa-clock me-1"></i><?php echo $course->duration_total ? $course->duration_total . 'm' : '-'; ?></span>
                </div>
                <div class="d-flex align-items-center gap-3">
                    <?php if ($is_enrolled): ?>
                        <a href="<?php echo base_url('courses/learn/' . $course->slug); ?>" class="btn btn-primary px-5 py-2 fw-bold rounded-pill">
                            <i class="fas fa-play me-2"></i> <?php echo t('Mulai Belajar', 'Start Learning'); ?>
                        </a>
                    <?php else: ?>
                        <div class="h3 fw-extrabold mb-0 me-3" style="color: #0D1830;">
                            <?php if ($course->price > 0): ?>
                                Rp <?php echo number_format($course->price, 0, ',', '.'); ?>
                            <?php else: ?>
                                <?php echo t('Gratis', 'Free'); ?>
                            <?php endif; ?>
                        </div>
                        <a href="<?php echo base_url('courses/buy/' . $course->slug); ?>" class="btn btn-primary px-5 py-2 fw-bold rounded-pill">
                            <?php echo ($course->price <= 0) ? t('Daftar Gratis', 'Enroll Free') : t('Beli Sekarang', 'Buy Now'); ?>
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Common Panel Body (Tabs + Content) -->
    <div class="px-3 px-md-4 pb-5" style="margin-bottom: 80px;">
        <ul class="nav nav-pills d-flex gap-2 overflow-auto py-2 mb-4 no-scrollbar" style="flex-wrap: nowrap;" id="courseTabs" role="tablist">
            <li class="nav-item">
                <button class="nav-link active rounded-pill px-4 fw-bold" id="materi-tab" data-bs-toggle="tab" data-bs-target="#materi" type="button" role="tab" style="font-size: 0.8rem;"><?php echo t('Materi', 'Curriculum'); ?></button>
            </li>
            <li class="nav-item">
                <button class="nav-link rounded-pill px-4 fw-bold" id="info-tab" data-bs-toggle="tab" data-bs-target="#info" type="button" role="tab" style="font-size: 0.8rem;"><?php echo t('Info', 'Info'); ?></button>
            </li>
            <li class="nav-item">
                <button class="nav-link rounded-pill px-4 fw-bold" id="review-tab" data-bs-toggle="tab" data-bs-target="#review" type="button" role="tab" style="font-size: 0.8rem;"><?php echo t('Ulasan', 'Reviews'); ?> (<?php echo $review_count; ?>)</button>
            </li>
            <li class="nav-item">
                <button class="nav-link rounded-pill px-4 fw-bold" id="forum-tab" data-bs-toggle="tab" data-bs-target="#forum" type="button" role="tab" style="font-size: 0.8rem;"><?php echo t('Forum', 'Forum'); ?></button>
            </li>
        </ul>

        <div class="tab-content">
            <!-- CURRICULUM -->
            <div class="tab-pane fade show active" id="materi" role="tabpanel">
                <?php if (empty($lessons)): ?>
                    <div class="mob-empty"><i class="fas fa-book-open"></i><p><?php echo t('Belum ada materi.', 'No lessons yet.'); ?></p></div>
                <?php else: ?>
                    <div class="d-flex flex-column gap-2">
                        <?php foreach ($lessons as $i => $lesson): ?>
                            <div class="d-flex align-items-center gap-3 p-3 rounded-4 border bg-white" style="border-color: #f0eeeb !important;">
                                <div class="d-flex align-items-center justify-content-center rounded-3 flex-shrink-0" style="width: 38px; height: 38px; background: #E6EBEF; color: #64748b;">
                                    <i class="fas <?php echo $lesson->lesson_type === 'video' ? 'fa-play' : 'fa-file-alt'; ?>" style="font-size: 0.85rem;"></i>
                                </div>
                                <div class="flex-fill min-w-0">
                                    <div class="fw-bold text-dark text-truncate" style="font-size: 0.85rem;"><?php echo $i+1; ?>. <?php echo htmlspecialchars(t($lesson->title, $lesson->title_en)); ?></div>
                                    <small class="text-muted" style="font-size: 0.72rem;"><?php echo $lesson->lesson_type; ?> <?php echo $lesson->duration > 0 ? '· ' . $lesson->duration . 'm' : ''; ?></small>
                                </div>
                                <?php if ($is_enrolled): ?>
                                    <a href="<?php echo base_url('courses/learn/' . $course->slug . '/' . encode_id($lesson->id)); ?>" class="btn btn-sm rounded-pill px-3 py-1" style="background: #f1f5f9; color: var(--primary); font-size: 0.72rem; font-weight: 700; border: none;">
                                        <?php echo t('Buka', 'Open'); ?>
                                    </a>
                                <?php elseif ($lesson->is_free): ?>
                                    <span class="badge bg-success-subtle text-success rounded-pill fw-bold" style="font-size: 0.65rem;"><?php echo t('Gratis', 'Free'); ?></span>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                        
                        <!-- Quizzes -->
                        <?php foreach ($quizzes as $qz): ?>
                            <div class="d-flex align-items-center gap-3 p-3 rounded-4 border bg-white" style="border-color: #f0eeeb !important; border-left: 4px solid #a855f7 !important;">
                                <div class="d-flex align-items-center justify-content-center rounded-3 flex-shrink-0" style="width: 38px; height: 38px; background: #faf5ff; color: #a855f7;">
                                    <i class="fas fa-question-circle"></i>
                                </div>
                                <div class="flex-fill min-w-0">
                                    <div class="fw-bold text-dark text-truncate" style="font-size: 0.85rem;">Quiz: <?php echo htmlspecialchars($qz->title); ?></div>
                                    <small class="text-muted" style="font-size: 0.72rem;"><?php echo $quiz_question_counts[$qz->id] ?? 0; ?> <?php echo t('soal', 'questions'); ?></small>
                                </div>
                                <?php if ($is_enrolled): ?>
                                    <a href="<?php echo base_url('quiz/start/' . encode_id($qz->id)); ?>" class="btn btn-sm rounded-pill px-3 py-1" style="background: #faf5ff; color: #a855f7; font-size: 0.72rem; font-weight: 700; border: none;"><?php echo t('Kerjakan', 'Start'); ?></a>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>

            <!-- INFO -->
            <div class="tab-pane fade" id="info" role="tabpanel">
                <div class="bg-white rounded-4 border p-4 mb-4" style="border-color: #f0eeeb !important;">
                    <h6 class="fw-bold text-dark mb-3" style="font-size: 0.95rem;"><?php echo t('Deskripsi', 'Description'); ?></h6>
                    <div style="color: #57534e; font-size: 0.85rem; line-height: 1.6;">
                        <?php echo nl2br(htmlspecialchars($desc_local)); ?>
                    </div>
                </div>
                <div class="bg-white rounded-4 border p-3 d-flex align-items-center gap-3" style="border-color: #f0eeeb !important;">
                    <img src="https://ui-avatars.com/api/?name=<?php echo urlencode($course->teacher_name); ?>&background=f59e0b&color=fff&size=48" alt="" class="rounded-circle" style="width: 48px; height: 48px;">
                    <div class="flex-fill">
                        <div class="fw-bold text-dark" style="font-size: 0.85rem;"><?php echo htmlspecialchars($course->teacher_name); ?></div>
                        <small class="text-muted" style="font-size: 0.72rem;"><?php echo t('Instruktur Kursus', 'Course Instructor'); ?></small>
                    </div>
                </div>
            </div>

            <!-- REVIEWS -->
            <div class="tab-pane fade" id="review" role="tabpanel">
                <div class="row g-3 mb-4">
                    <div class="col-4">
                        <div class="bg-white rounded-4 border p-3 text-center" style="border-color: #f0eeeb !important;">
                            <div class="fw-extrabold text-dark h2 mb-0"><?php echo $avg_rating; ?></div>
                            <div class="text-warning mb-1" style="font-size: 0.7rem;"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i></div>
                            <small class="text-muted" style="font-size: 0.65rem;"><?php echo $review_count; ?> <?php echo t('ulasan', 'reviews'); ?></small>
                        </div>
                    </div>
                    <div class="col-8">
                        <div class="bg-white rounded-4 border p-3 h-100 d-flex flex-column justify-content-center" style="border-color: #f0eeeb !important;">
                            <?php foreach (range(5, 1) as $s): ?>
                                <div class="d-flex align-items-center gap-2 mb-1" style="font-size: 0.7rem;">
                                    <span style="min-width: 10px;"><?php echo $s; ?></span>
                                    <div class="flex-fill rounded-pill bg-light overflow-hidden" style="height: 4px;">
                                        <div class="h-100 bg-warning" style="width: <?php echo $review_count > 0 ? ($rating_counts[$s] / $review_count) * 100 : 0; ?>%;"></div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
                
                <?php if ($is_enrolled): ?>
                    <button class="btn btn-outline-dark w-100 rounded-pill fw-bold mb-4 py-2" data-bs-toggle="collapse" data-bs-target="#formReview" style="font-size: 0.8rem; border-color: #f0eeeb;">
                        <i class="fas fa-edit me-1"></i> <?php echo t('Tulis Ulasan Saya', 'Write My Review'); ?>
                    </button>
                    <div class="collapse mb-4" id="formReview">
                        <?php echo form_open('courses/review/' . $course->slug, ['class' => 'bg-light p-3 rounded-4']); ?>
                            <div class="mb-3">
                                <label class="small fw-bold mb-2"><?php echo t('Rating', 'Rating'); ?></label>
                                <div class="d-flex gap-2">
                                    <?php for($i=1;$i<=5;$i++): ?>
                                        <label class="cursor-pointer"><input type="radio" name="rating" value="<?php echo $i; ?>" class="d-none" <?php echo ($user_review && $user_review->rating == $i) ? 'checked' : ($i==5?'checked':''); ?>><i class="fas fa-star fa-lg text-secondary"></i></label>
                                    <?php endfor; ?>
                                </div>
                            </div>
                            <textarea name="review" class="form-control mb-3" rows="3" style="border-radius: 12px; font-size: 0.85rem;" placeholder="Apa pendapatmu tentang kelas ini?"><?php echo $user_review ? htmlspecialchars($user_review->review) : ''; ?></textarea>
                            <button type="submit" class="btn btn-dark w-100 rounded-pill fw-bold py-2"><?php echo t('Kirim', 'Submit'); ?></button>
                        <?php echo form_close(); ?>
                    </div>
                <?php endif; ?>

                <div class="d-flex flex-column gap-3">
                    <?php foreach ($reviews as $r): ?>
                        <div class="bg-white p-3 rounded-4 border" style="border-color: #f0eeeb !important;">
                            <div class="d-flex align-items-center gap-2 mb-2">
                                <img src="https://ui-avatars.com/api/?name=<?php echo urlencode($r->user_name); ?>&background=f5f5f5&size=24" class="rounded-circle">
                                <div class="fw-bold" style="font-size: 0.8rem;"><?php echo htmlspecialchars($r->user_name); ?></div>
                                <div class="ms-auto text-warning" style="font-size: 0.65rem;">
                                    <?php for($i=1;$i<=5;$i++): ?><i class="fas fa-star <?php echo $i<=$r->rating ? '' : 'text-secondary opacity-25'; ?>"></i><?php endfor; ?>
                                </div>
                            </div>
                            <p class="text-muted mb-0" style="font-size: 0.8rem; line-height: 1.5;"><?php echo htmlspecialchars($r->review); ?></p>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- FORUM -->
            <div class="tab-pane fade" id="forum" role="tabpanel">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <h6 class="fw-bold text-dark mb-0" style="font-size: 0.95rem;">Diskusi</h6>
                    <?php if ($is_enrolled): ?>
                        <a href="<?php echo base_url('forum/create/' . $course->slug); ?>" class="btn btn-sm btn-dark rounded-pill px-3"><?php echo t('Tanya', 'Ask'); ?></a>
                    <?php endif; ?>
                </div>
                <div class="d-flex flex-column gap-2">
                    <?php foreach (array_slice($discussions, 0, 5) as $d): ?>
                        <a href="<?php echo base_url('forum/view/' . encode_id($d->id)); ?>" class="bg-white p-3 rounded-4 border text-decoration-none d-flex justify-content-between align-items-center" style="border-color: #f0eeeb !important;">
                            <div class="min-w-0">
                                <div class="fw-bold text-dark text-truncate" style="font-size: 0.85rem;"><?php echo htmlspecialchars($d->title); ?></div>
                                <small class="text-muted" style="font-size: 0.72rem;"><?php echo htmlspecialchars($d->user_name); ?> · <?php echo time_elapsed($d->created_at); ?></small>
                            </div>
                            <span class="badge bg-light text-dark rounded-pill border" style="font-size: 0.65rem;"><?php echo $d->reply_count; ?></span>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .no-scrollbar::-webkit-scrollbar { display: none; }
    .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    .nav-pills .nav-link { color: #78716c; background: #E6EBEF; border: none; }
    .nav-pills .nav-link.active { background: #0D1830 !important; color: #fff !important; }
    #formReview i.fa-star:hover, #formReview input:checked + i.fa-star { color: #FBBF24 !important; }
</style>

<?php else: ?>
<!-- ============ HALAMAN PUBLIK (Guest Landing) ============ -->
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "Course",
  "name": "<?php echo addslashes($course->title); ?>",
  "description": "<?php echo addslashes(strip_tags($course->description)); ?>",
  "provider": {"@type": "Organization", "name": "<?php echo setting('general_site_name', 'BISATUNTAS'); ?>", "sameAs": "<?php echo base_url(); ?>"}
  <?php if ($avg_rating): ?>
  ,"aggregateRating": {"@type": "AggregateRating", "ratingValue": "<?php echo $avg_rating; ?>", "reviewCount": "<?php echo $review_count; ?>"}
  <?php endif; ?>
  ,"offers": {"@type": "Offer", "price": "<?php echo $course->price; ?>", "priceCurrency": "IDR", "availability": "https://schema.org/InStock"}
}
</script>

<!-- UI Landing Tetap Menggunakan Struktur Container Default -->
<div style="background: #f5f5f5; border-bottom: 1px solid #e5e5e5;">
    <div class="container" style="padding-top: 1.5rem; padding-bottom: 2.5rem; max-width: 960px;">
        <div class="rounded-4 overflow-hidden shadow-sm" style="aspect-ratio: 16/9; background: #0D1830;">
            <img src="<?php echo base_url('uploads/courses/' . $course->thumbnail); ?>" class="w-100 h-100 object-fit-cover">
        </div>
    </div>
</div>

<div class="container" style="max-width: 960px; padding-top: 2rem; padding-bottom: 5rem;">
    <div class="row g-5">
        <div class="col-lg-8">
            <h1 class="fw-extrabold mb-4 h2"><?php echo htmlspecialchars($title_local); ?></h1>
            <div class="d-flex align-items-center gap-4 mb-4 text-muted small">
                <span><i class="fas fa-star text-warning me-1"></i><?php echo $avg_rating; ?> (<?php echo $review_count; ?> ulasan)</span>
                <span><i class="fas fa-users me-1"></i><?php echo $enrolled_count; ?> siswa</span>
            </div>
            
            <h5 class="fw-bold mb-3"><?php echo t('Tentang Konten', 'About'); ?></h5>
            <p class="text-muted mb-5"><?php echo nl2br(htmlspecialchars($desc_local)); ?></p>

            <h5 class="fw-bold mb-3"><?php echo t('Materi', 'Curriculum'); ?></h5>
            <div class="list-group list-group-flush border rounded-4 overflow-hidden mb-5">
                <?php foreach($lessons as $i => $l): ?>
                    <div class="list-group-item p-3 d-flex align-items-center gap-3">
                        <i class="fas <?php echo $l->lesson_type=='video'?'fa-play-circle':'fa-file-alt'; ?> text-muted"></i>
                        <span class="small fw-semibold"><?php echo $i+1; ?>. <?php echo htmlspecialchars(t($l->title, $l->title_en)); ?></span>
                        <?php if($l->is_free): ?><span class="ms-auto badge bg-success-subtle text-success rounded-pill fw-bold" style="font-size:0.6rem;">GRATIS</span><?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card border-0 shadow-lg rounded-4 p-4 position-sticky" style="top: 100px;">
                <div class="h2 fw-extrabold mb-3">
                    <?php echo $course->price > 0 ? 'Rp '.number_format($course->price, 0, ',', '.') : 'Gratis'; ?>
                </div>
                <a href="<?php echo base_url('courses/buy/'.$course->slug); ?>" class="btn btn-primary w-100 py-3 rounded-pill fw-bold mb-3">
                    <?php echo $course->price > 0 ? 'Beli Sekarang' : 'Daftar Sekarang'; ?>
                </a>
                <ul class="list-unstyled small text-muted d-flex flex-column gap-2 mb-0">
                    <li><i class="fas fa-check-circle text-primary me-2"></i> Akses selamanya</li>
                    <li><i class="fas fa-check-circle text-primary me-2"></i> Sertifikat kelulusan</li>
                    <li><i class="fas fa-check-circle text-primary me-2"></i> Forum diskusi aktif</li>
                </ul>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>
