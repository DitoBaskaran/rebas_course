<div class="container" style="max-width: 960px; padding-top: 1.25rem; padding-bottom: 4rem;">

    <?php $is_logged = $this->session->userdata('logged_in'); ?>

    <!-- ===== HERO CARD PROFIL ===== -->
    <div class="mn-detail-hero mb-4" style="background: linear-gradient(150deg,#0D1830 0%,#0D1830 55%,#00796B 100%); border-radius: 22px; overflow: hidden; color: #fff; position: relative;">
        <div style="position:absolute; top:-60px; right:-40px; width:220px; height:220px; border-radius:50%; background:rgba(251,191,36,0.13);"></div>
        <div style="position:absolute; bottom:-80px; left:25%; width:200px; height:200px; border-radius:50%; background:rgba(0,150,136,0.3);"></div>

        <!-- Cover top row: favorite -->
        <div class="d-flex justify-content-end p-3 position-relative">
            <a href="<?php echo base_url('mentoring/toggle-favorite/' . encode_id($mentor->id)); ?>" class="btn d-flex align-items-center justify-content-center flex-shrink-0" style="width: 38px; height: 38px; border-radius: 50%; background: rgba(255,255,255,0.12); border: 1px solid rgba(255,255,255,0.2); color: <?php echo $is_favorited ? '#FBBF24' : 'rgba(255,255,255,0.7)'; ?>; padding: 0; backdrop-filter: blur(6px);" title="<?php echo t('Favorit', 'Favorite'); ?>">
                <i class="<?php echo $is_favorited ? 'fas' : 'far'; ?> fa-heart"></i>
            </a>
        </div>

        <div class="px-4 pb-4 position-relative" style="margin-top: -12px;">
            <div class="d-flex flex-column flex-sm-row align-items-center gap-4">
                <?php if (!empty($mentor->avatar) && file_exists(FCPATH . 'uploads/mentors/' . $mentor->avatar)): ?>
                <img src="<?php echo base_url('uploads/mentors/' . $mentor->avatar); ?>" alt="" class="flex-shrink-0" style="width: 96px; height: 96px; border-radius: 50%; object-fit: cover; border: 4px solid rgba(255,255,255,0.25); box-shadow: 0 8px 24px rgba(0,0,0,0.3); background: #E0F2F1;">
                <?php else: ?>
                <span class="flex-shrink-0 d-flex align-items-center justify-content-center" style="width: 96px; height: 96px; border-radius: 50%; background: linear-gradient(135deg,#009688,#00796B); border: 4px solid rgba(255,255,255,0.25); box-shadow: 0 8px 24px rgba(0,0,0,0.3); font-size: 2rem; font-weight: 800; color: #fff;">
                    <?php echo strtoupper(substr($mentor->name, 0, 1)); ?>
                </span>
                <?php endif; ?>
                <div class="text-center text-sm-start flex-fill">
                    <div class="d-flex align-items-center justify-content-center justify-content-sm-start gap-2">
                        <h4 class="fw-extrabold mb-0" style="font-size: 1.45rem; letter-spacing: -0.02em; color: #fff;"><?php echo htmlspecialchars($mentor->name); ?></h4>
                        <i class="fas fa-check-circle" style="color: #FBBF24; font-size: 1rem;" title="<?php echo t('Terverifikasi', 'Verified'); ?>"></i>
                    </div>
                    <p class="fw-medium mb-2" style="color: rgba(230,235,239,0.85); font-size: 0.9rem;"><?php echo htmlspecialchars(t($mentor->title, $mentor->title_en)); ?></p>
                    <div class="d-flex flex-wrap gap-2 justify-content-center justify-content-sm-start mb-2">
                        <?php foreach ($categories as $cat): ?>
                        <span class="px-2 py-1 rounded-pill" style="background: rgba(255,255,255,0.12); border: 1px solid rgba(255,255,255,0.18); color: #E6EBEF; font-size: 0.68rem; font-weight: 600;"><?php echo htmlspecialchars(t($cat->name, $cat->name_en)); ?></span>
                        <?php endforeach; ?>
                    </div>
                    <div class="d-flex flex-wrap align-items-center gap-3 justify-content-center justify-content-sm-start" style="font-size: 0.82rem;">
                        <span class="d-flex align-items-center gap-1">
                            <i class="fas fa-star" style="color: #FBBF24; font-size: 0.75rem;"></i>
                            <strong style="color: #fff;"><?php echo $mentor->avg_rating; ?></strong>
                            <span style="color: rgba(230,235,239,0.6);">(<?php echo $mentor->total_reviews; ?>)</span>
                        </span>
                        <span class="d-none d-sm-inline" style="color: rgba(255,255,255,0.25);">|</span>
                        <span style="color: rgba(230,235,239,0.8);"><i class="fas fa-clock me-1" style="font-size: 0.65rem;"></i><?php echo $mentor->total_sessions; ?> <?php echo t('sesi', 'sessions'); ?></span>
                        <span style="color: rgba(230,235,239,0.8);"><i class="fas fa-video me-1" style="font-size: 0.65rem;"></i><?php echo strtoupper(str_replace(',', ', ', $mentor->meeting_platforms)); ?></span>
                    </div>
                </div>
                <?php if ((float)$mentor->price_per_session > 0): ?>
                <div class="text-center flex-shrink-0 mn-detail-price">
                    <div style="font-size: 0.65rem; color: rgba(230,235,239,0.6); text-transform: uppercase; letter-spacing: 0.05em;"><?php echo t('Harga / Sesi', 'Price / Session'); ?></div>
                    <div class="fw-extrabold" style="color: #FBBF24; font-size: 1.5rem; line-height: 1.2;">Rp <?php echo number_format($mentor->price_per_session, 0, ',', '.'); ?></div>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- ===== DURASI ===== -->
    <div class="d-flex gap-2 mb-4 flex-wrap align-items-center">
        <span class="fw-bold" style="color: #0D1830; font-size: 0.8rem; margin-right: 0.25rem;"><?php echo t('Durasi:', 'Duration:'); ?></span>
        <?php foreach (explode(',', $mentor->durations_available) as $d): ?>
            <span class="px-3 py-2 rounded-pill fw-semibold" style="border: 1.5px solid #009688; color: #009688; font-size: 0.78rem; background: #E0F2F1;"><?php echo trim($d); ?> <?php echo t('mnt', 'min'); ?></span>
        <?php endforeach; ?>
    </div>

    <!-- ===== ABOUT ===== -->
    <div class="border rounded-4 p-4 mb-4" style="border-color: #E6EBEF; border-radius: 16px; background: #fff; box-shadow: 0 1px 3px rgba(13,24,48,0.04);">
        <h6 class="fw-bold mb-2 d-flex align-items-center gap-2" style="color: #0D1830; font-size: 0.9rem;">
            <span class="d-inline-flex align-items-center justify-content-center" style="width: 26px; height: 26px; border-radius: 8px; background: #E0F2F1; color: #009688; font-size: 0.7rem;"><i class="fas fa-user-graduate"></i></span>
            <?php echo t('Tentang Mentor', 'About Mentor'); ?>
        </h6>
        <p class="mb-0" style="color: #57534E; font-size: 0.85rem; line-height: 1.75;"><?php echo nl2br(htmlspecialchars(t($mentor->bio, $mentor->bio_en))); ?></p>
    </div>

    <!-- ===== JADWAL ===== -->
    <div class="border rounded-4 p-4 mb-4" style="border-color: #E6EBEF; border-radius: 16px; background: #fff; box-shadow: 0 1px 3px rgba(13,24,48,0.04);">
        <h6 class="fw-bold mb-3 d-flex align-items-center gap-2" style="color: #0D1830; font-size: 0.9rem;">
            <span class="d-inline-flex align-items-center justify-content-center" style="width: 26px; height: 26px; border-radius: 8px; background: #E0F2F1; color: #009688; font-size: 0.7rem;"><i class="fas fa-calendar-alt"></i></span>
            <?php echo t('Jadwal Tersedia', 'Available Schedule'); ?>
        </h6>

        <?php
            $day_names_short = array(t('Min', 'Sun'), t('Sen', 'Mon'), t('Sel', 'Tue'), t('Rab', 'Wed'), t('Kam', 'Thu'), t('Jum', 'Fri'), t('Sab', 'Sat'));
            $avail_days = array();
            foreach ($week_slots as $d_idx => $slots) { if (!empty($slots)) $avail_days[] = $d_idx; }
            $first_avail = !empty($avail_days) ? $avail_days[0] : null;
        ?>

        <?php if (empty($avail_days)): ?>
            <div class="text-center py-4" style="color: #a8a29e; font-size: 0.85rem;">
                <i class="far fa-calendar-times d-block mb-2" style="font-size: 1.6rem; color: #d4d4d4;"></i>
                <?php echo t('Mentor belum mengatur jadwal.', 'Mentor has not set a schedule.'); ?>
            </div>
        <?php else: ?>
            <!-- Day tabs (hanya hari yang punya slot) -->
            <div class="d-flex gap-2 overflow-auto pb-1 mb-3" id="detailDayTabs" style="scrollbar-width: none; -ms-overflow-style: none;">
                <?php foreach ($avail_days as $d_idx): ?>
                    <button type="button" class="mn-day-tab flex-shrink-0 <?php echo $d_idx === $first_avail ? 'active' : ''; ?>" data-day="<?php echo $d_idx; ?>">
                        <?php echo $day_names_short[$d_idx]; ?>
                        <span class="mn-day-tab-count"><?php echo count($week_slots[$d_idx]); ?></span>
                    </button>
                <?php endforeach; ?>
            </div>

            <!-- Slot panels: satu hari per tampilan -->
            <?php foreach ($avail_days as $d_idx): ?>
                <div class="mn-day-panel" data-day-panel="<?php echo $d_idx; ?>" style="<?php echo $d_idx === $first_avail ? '' : 'display:none;'; ?>">
                    <div class="row g-2">
                        <?php foreach ($week_slots[$d_idx] as $slot): ?>
                            <div class="col-6 col-sm-4 col-md-3">
                                <div class="mn-slot-view text-center">
                                    <i class="far fa-clock me-1" style="font-size: 0.62rem;"></i>
                                    <?php echo substr($slot->start_time, 0, 5); ?>-<?php echo substr($slot->end_time, 0, 5); ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <!-- ===== BOOK CTA ===== -->
    <a href="<?php echo base_url('mentoring/book/' . encode_id($mentor->id)); ?>" class="btn py-3 fw-bold rounded-pill w-100 mb-4 mn-detail-book <?php echo $is_logged ? 'mn-detail-book-panel' : 'mn-detail-book-guest'; ?>" style="background: linear-gradient(135deg,#009688,#00796B); color: #fff; font-size: 0.95rem; box-shadow: 0 8px 20px rgba(0,150,136,0.3);">
        <i class="fas fa-calendar-check me-2"></i> <?php echo t('Booking Sesi Sekarang', 'Book Session Now'); ?>
    </a>

    <!-- ===== REVIEWS ===== -->
    <div class="border rounded-4 p-4" style="border-color: #E6EBEF; border-radius: 16px; background: #fff; box-shadow: 0 1px 3px rgba(13,24,48,0.04);">
        <h6 class="fw-bold mb-3 d-flex align-items-center gap-2" style="color: #0D1830; font-size: 0.9rem;">
            <span class="d-inline-flex align-items-center justify-content-center" style="width: 26px; height: 26px; border-radius: 8px; background: #E0F2F1; color: #009688; font-size: 0.7rem;"><i class="fas fa-comments"></i></span>
            <?php echo t('Ulasan', 'Reviews'); ?>
            <span class="badge rounded-pill" style="background: #E0F2F1; color: #009688; font-size: 0.68rem; font-weight: 700;"><?php echo count($reviews); ?></span>
        </h6>
        <?php if (empty($reviews)): ?>
            <p style="color: #a8a29e; font-size: 0.85rem; text-align: center; padding: 1.5rem 0;">
                <i class="far fa-comment-dots d-block mb-2" style="font-size: 1.5rem; color: #d4d4d4;"></i>
                <?php echo t('Belum ada ulasan.', 'No reviews yet.'); ?>
            </p>
        <?php else: ?>
            <?php foreach ($reviews as $review): ?>
                <div class="d-flex gap-3 pb-3 mb-3" style="border-bottom: 1px solid #f0eeeb;">
                    <span class="d-flex align-items-center justify-content-center flex-shrink-0" style="width: 38px; height: 38px; border-radius: 50%; background: linear-gradient(135deg,#009688,#00796B); color: #fff; font-size: 0.85rem; font-weight: 700;"><?php echo strtoupper(substr($review->user_name, 0, 1)); ?></span>
                    <div class="flex-fill">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <span class="fw-semibold" style="color: #0D1830; font-size: 0.8rem;"><?php echo htmlspecialchars($review->user_name); ?></span>
                            <div class="d-flex gap-1">
                                <?php for ($i = 1; $i <= 5; $i++): ?>
                                    <i class="fas fa-star" style="color: <?php echo $i <= $review->rating ? '#FBBF24' : '#d4d4d4'; ?>; font-size: 0.55rem;"></i>
                                <?php endfor; ?>
                            </div>
                        </div>
                        <?php if ($review->review_text): ?>
                            <p class="mb-0" style="color: #57534E; font-size: 0.78rem; line-height: 1.6;"><?php echo htmlspecialchars($review->review_text); ?></p>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <!-- Spacer utk tombol booking sticky di mobile -->
    <div class="mn-detail-book-spacer"></div>
</div>

<style>
/* Sticky booking bar di mobile */
@media (max-width: 767.98px) {
    .mn-detail-hero { border-radius: 18px; }
    .mn-detail-price { margin-top: 0.5rem; }
    .mn-detail-book { position: fixed; left: 16px; right: 16px; width: auto !important; z-index: 100; box-shadow: 0 8px 24px rgba(0,150,136,0.4); }
    .mn-detail-book-panel { bottom: 76px; } /* di atas bottom nav panel student */
    .mn-detail-book-guest { bottom: 16px; } /* guest tidak ada bottom nav */
    .mn-detail-book-spacer { display: block; height: 70px; }
}
@media (min-width: 768px) {
    .mn-detail-book-spacer { display: none; }
}

/* Day tabs (dipakai juga di book.php, definisi ulang lokal agar halaman detail berdiri sendiri) */
.mn-day-tab {
    border: 1.5px solid #E6EBEF;
    background: #fff;
    color: #57534E;
    border-radius: 100px;
    padding: 0.5rem 1rem;
    font-size: 0.78rem;
    font-weight: 700;
    display: flex;
    align-items: center;
    gap: 0.4rem;
    transition: all 0.15s;
}
.mn-day-tab-count {
    background: #E6EBEF;
    color: #57534E;
    font-size: 0.62rem;
    font-weight: 700;
    padding: 0.05rem 0.4rem;
    border-radius: 100px;
}
.mn-day-tab.active { background: #0D1830; border-color: #0D1830; color: #fff; }
.mn-day-tab.active .mn-day-tab-count { background: #FBBF24; color: #0D1830; }

/* Slot read-only (halaman detail, bukan form) */
.mn-slot-view {
    border: 1.5px solid #E6EBEF;
    background: #E6EBEF;
    color: #0D1830;
    font-size: 0.76rem;
    font-weight: 600;
    padding: 0.6rem 0.5rem;
    border-radius: 10px;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var tabs = document.querySelectorAll('#detailDayTabs .mn-day-tab');
    tabs.forEach(function(tab) {
        tab.addEventListener('click', function() {
            var day = tab.getAttribute('data-day');
            tabs.forEach(function(t) { t.classList.remove('active'); });
            tab.classList.add('active');
            document.querySelectorAll('.mn-day-panel').forEach(function(panel) {
                panel.style.display = panel.getAttribute('data-day-panel') === day ? '' : 'none';
            });
        });
    });
});
</script>
