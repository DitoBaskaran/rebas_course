<div class="container" style="max-width: 960px; padding-top: 1.5rem; padding-bottom: 3rem;">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4" style="font-size: 0.8rem;">
        <ol class="breadcrumb" style="background: none; padding: 0;">
            <li class="breadcrumb-item"><a href="<?php echo base_url('mentoring'); ?>" style="color: #525252; text-decoration: none; font-weight: 500;"><?php echo t('Mentoring', 'Mentoring'); ?></a></li>
            <li class="breadcrumb-item active" style="color: #737373; font-weight: 500;"><?php echo htmlspecialchars($mentor->name); ?></li>
        </ol>
    </nav>

    <!-- Mentor Header -->
    <div class="d-flex align-items-start gap-4 mb-4 flex-column flex-md-row">
        <img src="https://ui-avatars.com/api/?name=<?php echo urlencode($mentor->name); ?>&background=f59e0b&color=fff&size=80&font-size=0.35" alt="" style="width: 80px; height: 80px; border-radius: 50%; flex-shrink: 0;">
        <div class="flex-fill">
            <div class="d-flex align-items-start justify-content-between gap-2">
                <div>
                    <h4 class="fw-extrabold mb-1" style="color: #111827; font-size: 1.35rem; letter-spacing: -0.02em;">
                        <?php echo htmlspecialchars($mentor->name); ?>
                    </h4>
                    <p class="fw-medium mb-2" style="color: #737373; font-size: 0.9rem;"><?php echo htmlspecialchars(t($mentor->title, $mentor->title_en)); ?></p>
                </div>
                <a href="<?php echo base_url('mentoring/toggle-favorite/' . encode_id($mentor->id)); ?>" class="btn d-flex align-items-center justify-content-center flex-shrink-0" style="width: 36px; height: 36px; border-radius: 8px; border: 1px solid #e5e5e5; background: #fff; color: <?php echo $is_favorited ? '#eab308' : '#d4d4d4'; ?>; padding: 0;">
                    <i class="fas fa-heart"></i>
                </a>
            </div>
            <div class="d-flex flex-wrap gap-2 mb-2">
                <?php foreach ($categories as $cat): ?>
                    <span class="px-2 py-1 rounded-pill" style="background: #f5f5f5; color: #525252; font-size: 0.7rem; font-weight: 600;"><?php echo htmlspecialchars(t($cat->name, $cat->name_en)); ?></span>
                <?php endforeach; ?>
            </div>
            <div class="d-flex flex-wrap align-items-center gap-3" style="color: #737373; font-size: 0.82rem;">
                <span class="d-flex align-items-center gap-1">
                    <i class="fas fa-star" style="color: #eab308; font-size: 0.7rem;"></i>
                    <strong style="color: #111827;"><?php echo $mentor->avg_rating; ?></strong> (<?php echo $mentor->total_reviews; ?>)
                </span>
                <span>·</span>
                <span><i class="fas fa-clock me-1" style="font-size: 0.65rem;"></i><?php echo $mentor->total_sessions; ?> <?php echo t('sesi', 'sessions'); ?></span>
                <span>·</span>
                <span><i class="fas fa-video me-1" style="font-size: 0.65rem;"></i><?php echo strtoupper(str_replace(',', ', ', $mentor->meeting_platforms)); ?></span>
            </div>
        </div>
    </div>

    <!-- Durations -->
    <div class="d-flex gap-2 mb-4 flex-wrap">
        <?php foreach (explode(',', $mentor->durations_available) as $d): ?>
            <span class="px-3 py-2 rounded-pill fw-semibold" style="border: 1px solid #e5e5e5; color: #525252; font-size: 0.78rem; background: #fff;"><?php echo trim($d); ?> <?php echo t('mnt', 'min'); ?></span>
        <?php endforeach; ?>
    </div>

    <!-- Bio -->
    <div class="border rounded-3 p-4 mb-4" style="border-color: #e5e5e5; border-radius: 12px;">
        <h6 class="fw-bold mb-2" style="color: #111827; font-size: 0.9rem;"><?php echo t('Tentang Mentor', 'About Mentor'); ?></h6>
        <p class="mb-0" style="color: #525252; font-size: 0.85rem; line-height: 1.7;"><?php echo nl2br(htmlspecialchars(t($mentor->bio, $mentor->bio_en))); ?></p>
    </div>

    <!-- Schedule -->
    <div class="border rounded-3 p-4 mb-4" style="border-color: #e5e5e5; border-radius: 12px;">
        <h6 class="fw-bold mb-3" style="color: #111827; font-size: 0.9rem;"><?php echo t('Jadwal Tersedia', 'Available Schedule'); ?></h6>
        <?php $day_names = array(t('Min', 'Sun'), t('Sen', 'Mon'), t('Sel', 'Tue'), t('Rab', 'Wed'), t('Kam', 'Thu'), t('Jum', 'Fri'), t('Sab', 'Sat')); ?>
        <div class="row g-2">
            <?php foreach ($week_slots as $day_idx => $slots): ?>
                <div class="col text-center mb-2">
                    <div class="fw-bold mb-2" style="color: #525252; font-size: 0.7rem;"><?php echo $day_names[$day_idx]; ?></div>
                    <?php if (empty($slots)): ?>
                        <div style="color: #d4d4d4; font-size: 0.7rem;">-</div>
                    <?php else: ?>
                        <?php foreach ($slots as $slot): ?>
                            <div class="rounded-3 p-1 mb-1" style="background: #f5f5f5; font-size: 0.68rem; color: #525252;">
                                <?php echo substr($slot->start_time, 0, 5); ?>-<?php echo substr($slot->end_time, 0, 5); ?>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Book Button -->
    <a href="<?php echo base_url('mentoring/book/' . encode_id($mentor->id)); ?>" class="btn py-3 fw-bold rounded-pill w-100 mb-4" style="background: #eab308; color: #111827; font-size: 0.9rem;">
        <i class="fas fa-calendar-check me-2"></i> <?php echo t('Booking Sesi', 'Book Session'); ?>
    </a>

    <!-- Reviews -->
    <div class="border rounded-3 p-4" style="border-color: #e5e5e5; border-radius: 12px;">
        <h6 class="fw-bold mb-3" style="color: #111827; font-size: 0.9rem;">
            <?php echo t('Ulasan', 'Reviews'); ?> <span style="color: #737373; font-weight: 400;">(<?php echo count($reviews); ?>)</span>
        </h6>
        <?php if (empty($reviews)): ?>
            <p style="color: #737373; font-size: 0.85rem;"><?php echo t('Belum ada ulasan.', 'No reviews yet.'); ?></p>
        <?php else: ?>
            <?php foreach ($reviews as $review): ?>
                <div class="d-flex gap-3 pb-3 mb-3" style="border-bottom: 1px solid #f0f0f0;">
                    <img src="https://ui-avatars.com/api/?name=<?php echo urlencode($review->user_name); ?>&background=f5f5f5&color=525252&size=36" alt="" style="width: 36px; height: 36px; border-radius: 50%; flex-shrink: 0;">
                    <div class="flex-fill">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <span class="fw-semibold" style="color: #111827; font-size: 0.8rem;"><?php echo htmlspecialchars($review->user_name); ?></span>
                            <div class="d-flex gap-1">
                                <?php for ($i = 1; $i <= 5; $i++): ?>
                                    <i class="fas fa-star" style="color: <?php echo $i <= $review->rating ? '#eab308' : '#d4d4d4'; ?>; font-size: 0.55rem;"></i>
                                <?php endfor; ?>
                            </div>
                        </div>
                        <?php if ($review->review_text): ?>
                            <p class="mb-0" style="color: #737373; font-size: 0.78rem;"><?php echo htmlspecialchars($review->review_text); ?></p>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>
