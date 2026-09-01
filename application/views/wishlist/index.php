<div class="container-fluid py-4" style="padding-top: 0px !important; max-width: 1200px;">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h4 class="fw-extrabold mb-1" style="color: #0D1830; letter-spacing: -0.02em; font-size: 1.3rem;">
                <?php echo t('Wishlist Saya', 'My Wishlist'); ?>
            </h4>
            <p style="color: #78716c; font-size: 0.82rem; margin-bottom: 0;">
                <?php echo t('Kelas & mentor yang kamu simpan.', 'Courses & mentors you saved.'); ?>
            </p>
        </div>
        <a href="<?php echo base_url('courses'); ?>" class="btn px-3 py-2 fw-semibold rounded-pill" style="background: #009688; color: #fff; font-size: 0.8rem;">
            <i class="fas fa-search me-1"></i> <?php echo t('Jelajahi', 'Browse'); ?>
        </a>
    </div>

    <?php $total_all = count($wishlists) + count($favorite_mentors); ?>
    <?php if ($total_all === 0): ?>
    <!-- Empty State -->
    <div class="border rounded-3 p-5 text-center" style="border-color: #e7e5e4; border-radius: 12px;">
        <div style="font-size: 2rem; color: #d6d3d1; margin-bottom: 0.75rem;">
            <i class="fas fa-heart"></i>
        </div>
        <h5 class="fw-bold" style="color: #0D1830; margin-bottom: 0.375rem;">
            <?php echo t('Belum Ada Wishlist', 'No Wishlist Yet'); ?>
        </h5>
        <p style="color: #78716c; font-size: 0.85rem; max-width: 380px; margin: 0 auto 1rem;">
            <?php echo t('Simpan kelas favorit atau mentor impianmu dengan klik ikon hati. Semua tersimpan rapi di sini.', 'Save your favorite courses or dream mentors by tapping the heart icon. Everything is stored neatly here.'); ?>
        </p>
        <div class="d-flex justify-content-center gap-2 flex-wrap">
            <a href="<?php echo base_url('courses'); ?>" class="btn px-4 py-2 fw-bold rounded-pill" style="background: #009688; color: #fff; font-size: 0.85rem;">
                <i class="fas fa-book-open me-1"></i> <?php echo t('Jelajahi Kelas', 'Browse Courses'); ?>
            </a>
            <a href="<?php echo base_url('mentoring'); ?>" class="btn px-4 py-2 fw-bold rounded-pill" style="border: 1px solid #009688; color: #009688; font-size: 0.85rem;">
                <i class="fas fa-user-tie me-1"></i> <?php echo t('Cari Mentor', 'Find Mentors'); ?>
            </a>
        </div>
    </div>

    <?php else: ?>
    <!-- Tabs: Kelas / Mentor -->
    <div class="d-flex gap-2 mb-3 border-bottom" style="border-color: #f0eeeb !important;">
        <button type="button" class="js-wl-tab btn px-3 py-2 fw-bold rounded-0 active" data-tab="courses" style="font-size: 0.85rem; border: none; border-bottom: 2px solid #009688; color: #009688; background: none;">
            <i class="fas fa-book-open me-1" style="font-size: 0.7rem;"></i> <?php echo t('Kelas', 'Courses'); ?>
            <span class="badge rounded-pill ms-1" style="background: #E0F2F1; color: #009688; font-size: 0.62rem;"><?php echo count($wishlists); ?></span>
        </button>
        <button type="button" class="js-wl-tab btn px-3 py-2 fw-bold rounded-0" data-tab="mentors" style="font-size: 0.85rem; border: none; border-bottom: 2px solid transparent; color: #78716c; background: none;">
            <i class="fas fa-user-tie me-1" style="font-size: 0.7rem;"></i> <?php echo t('Mentor', 'Mentors'); ?>
            <span class="badge rounded-pill ms-1" style="background: #E6EBEF; color: #57534e; font-size: 0.62rem;"><?php echo count($favorite_mentors); ?></span>
        </button>
    </div>

    <!-- ===== TAB KELAS ===== -->
    <div class="js-wl-panel" data-panel="courses">
        <?php if (empty($wishlists)): ?>
            <div class="text-center py-5">
                <div style="font-size: 2rem; color: #d6d3d1; margin-bottom: 0.5rem;"><i class="far fa-heart"></i></div>
                <p style="color: #78716c; font-size: 0.85rem;"><?php echo t('Belum ada kelas disimpan.', 'No saved courses yet.'); ?></p>
                <a href="<?php echo base_url('courses'); ?>" class="btn btn-sm fw-semibold rounded-pill px-3" style="background: #009688; color: #fff; font-size: 0.78rem;"><?php echo t('Jelajahi Kelas', 'Browse Courses'); ?></a>
            </div>
        <?php else: ?>
        <div class="row g-3">
            <?php foreach ($wishlists as $c): ?>
            <div class="col-md-6 col-lg-4">
                <div class="border rounded-3 h-100 d-flex flex-column" style="border-color: #e7e5e4; border-radius: 12px; transition: all 0.15s; position: relative; background: #fff;">
                    <div class="position-relative overflow-hidden" style="aspect-ratio: 16/9; border-radius: 12px 12px 0 0;">
                        <img src="<?php echo base_url('uploads/courses/' . $c->thumbnail); ?>" onerror="this.src='https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=400&auto=format&fit=crop&q=60';" alt="" class="w-100 h-100" style="object-fit: cover;">
                        <button onclick="toggleWishlist('<?php echo $c->slug; ?>', this)" class="btn d-flex align-items-center justify-content-center position-absolute" style="top: 8px; right: 8px; width: 30px; height: 30px; border-radius: 50%; background: rgba(255,255,255,0.9); border: none; color: #009688; padding: 0; cursor: pointer;">
                            <i class="fas fa-heart" style="font-size: 0.75rem;"></i>
                        </button>
                        <span class="position-absolute px-2 py-1 rounded-pill fw-semibold" style="bottom: 8px; left: 8px; background: #0D1830; color: #fff; font-size: 0.6rem;">
                            <?php echo content_type_label($c->content_type); ?>
                        </span>
                    </div>
                    <div class="card-body p-3 d-flex flex-column" style="flex: 1;">
                        <div class="d-flex align-items-center gap-2 mb-1" style="color: #78716c; font-size: 0.7rem;">
                            <?php if ($c->category_name): ?>
                                <span><i class="fas fa-folder me-1" style="font-size: 0.55rem;"></i><?php echo htmlspecialchars($c->category_name); ?></span>
                                <span style="color: #e7e5e4;">·</span>
                            <?php endif; ?>
                            <span><i class="fas fa-signal me-1" style="font-size: 0.55rem;"></i><?php echo skill_level_label($c->skill_level); ?></span>
                        </div>
                        <h6 class="fw-bold mb-2 lh-sm" style="color: #0D1830; font-size: 0.85rem; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                            <?php echo htmlspecialchars(t($c->title, $c->title_en ?: $c->title)); ?>
                        </h6>
                        <div class="mt-auto pt-2 d-flex align-items-center justify-content-between" style="border-top: 1px solid #f0eeeb;">
                            <span class="fw-bold" style="color: #009688; font-size: 0.8rem;">
                                <?php echo $c->price > 0 ? 'Rp ' . number_format($c->price, 0, ',', '.') : '<span style="color: #009688;">' . t('Gratis', 'Free') . '</span>'; ?>
                            </span>
                            <a href="<?php echo base_url('courses/detail/' . $c->slug); ?>" class="btn btn-sm fw-bold rounded-pill px-3" style="background: #009688; color: #fff; font-size: 0.72rem;">
                                <i class="fas fa-eye me-1" style="font-size: 0.6rem;"></i> <?php echo t('Detail', 'Detail'); ?>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </div>

    <!-- ===== TAB MENTOR ===== -->
    <div class="js-wl-panel" data-panel="mentors" style="display:none;">
        <?php if (empty($favorite_mentors)): ?>
            <div class="text-center py-5">
                <div style="font-size: 2rem; color: #d6d3d1; margin-bottom: 0.5rem;"><i class="far fa-heart"></i></div>
                <p style="color: #78716c; font-size: 0.85rem;"><?php echo t('Belum ada mentor disimpan.', 'No saved mentors yet.'); ?></p>
                <a href="<?php echo base_url('mentoring'); ?>" class="btn btn-sm fw-semibold rounded-pill px-3" style="background: #009688; color: #fff; font-size: 0.78rem;"><?php echo t('Cari Mentor', 'Find Mentors'); ?></a>
            </div>
        <?php else: ?>
        <div class="row g-3">
            <?php foreach ($favorite_mentors as $m): ?>
            <div class="col-md-6 col-lg-4">
                <div class="border rounded-3 h-100 d-flex flex-column" style="border-color: #e7e5e4; border-radius: 12px; transition: all 0.15s; position: relative; background: #fff;">
                    <div class="position-relative overflow-hidden" style="aspect-ratio: 16/9; border-radius: 12px 12px 0 0; background: linear-gradient(135deg, #0D1830 0%, #009688 100%); display: flex; align-items: center; justify-content: center;">
                        <?php if (!empty($m->avatar) && file_exists(FCPATH . 'uploads/mentors/' . $m->avatar)): ?>
                            <img src="<?php echo base_url('uploads/mentors/' . $m->avatar); ?>" alt="" class="w-100 h-100" style="object-fit: cover; opacity: 0.85;">
                        <?php else: ?>
                            <span style="font-size: 4rem; color: rgba(255,255,255,0.35); font-weight: 800;"><?php echo strtoupper(substr($m->name, 0, 1)); ?></span>
                        <?php endif; ?>
                        <button onclick="toggleMentorFav('<?php echo encode_id($m->mentor_id); ?>', this)" class="btn d-flex align-items-center justify-content-center position-absolute" style="top: 8px; right: 8px; width: 30px; height: 30px; border-radius: 50%; background: rgba(255,255,255,0.9); border: none; color: #009688; padding: 0; cursor: pointer;">
                            <i class="fas fa-heart" style="font-size: 0.75rem;"></i>
                        </button>
                        <span class="position-absolute px-2 py-1 rounded-pill fw-semibold" style="bottom: 8px; left: 8px; background: rgba(13,24,48,0.75); color: #fff; font-size: 0.6rem;">
                            <i class="fas fa-star me-1" style="color: #FBBF24;"></i><?php echo $m->avg_rating; ?> (<?php echo $m->total_reviews; ?>)
                        </span>
                    </div>
                    <div class="card-body p-3 d-flex flex-column" style="flex: 1;">
                        <div class="d-flex align-items-center gap-2 mb-1">
                            <span class="d-flex align-items-center justify-content-center rounded-circle fw-bold flex-shrink-0" style="width: 34px; height: 34px; background: linear-gradient(135deg,#009688,#00796B); color: #fff; font-size: 0.78rem;">
                                <?php echo strtoupper(substr($m->name, 0, 1)); ?>
                            </span>
                            <div class="min-w-0">
                                <div class="fw-bold text-truncate" style="color: #0D1830; font-size: 0.85rem;"><?php echo htmlspecialchars($m->name); ?></div>
                                <div class="text-truncate" style="color: #78716c; font-size: 0.72rem;"><?php echo htmlspecialchars(t($m->title, $m->title_en)); ?></div>
                            </div>
                        </div>
                        <div class="mt-auto pt-2 d-flex align-items-center justify-content-between" style="border-top: 1px solid #f0eeeb;">
                            <span class="small" style="color: #78716c; font-size: 0.7rem;"><i class="fas fa-video me-1"></i><?php echo strtoupper(str_replace(',', ', ', $m->meeting_platforms)); ?></span>
                            <a href="<?php echo base_url('mentoring/detail/' . encode_id($m->mentor_id)); ?>" class="btn btn-sm fw-bold rounded-pill px-3" style="background: #009688; color: #fff; font-size: 0.72rem;">
                                <i class="fas fa-eye me-1" style="font-size: 0.6rem;"></i> <?php echo t('Detail', 'Detail'); ?>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </div>
    <?php endif; ?>
</div>

<script>
// Tab switching
document.addEventListener('DOMContentLoaded', function () {
    var tabs = document.querySelectorAll('.js-wl-tab');
    tabs.forEach(function (tab) {
        tab.addEventListener('click', function () {
            var target = tab.getAttribute('data-tab');
            tabs.forEach(function (t) {
                var isActive = t === tab;
                t.classList.toggle('active', isActive);
                if (isActive) {
                    t.style.color = '#009688';
                    t.style.borderBottom = '2px solid #009688';
                } else {
                    t.style.color = '#78716c';
                    t.style.borderBottom = '2px solid transparent';
                }
            });
            document.querySelectorAll('.js-wl-panel').forEach(function (panel) {
                panel.style.display = panel.getAttribute('data-panel') === target ? '' : 'none';
            });
        });
    });
});

// Toggle wishlist kelas (AJAX, tanpa reload)
function toggleWishlist(id, btn) {
    fetch('<?php echo base_url('wishlist/toggle/'); ?>' + id)
        .then(function (r) { return r.json(); })
        .then(function (d) {
            if (d.status === 'removed') {
                var card = btn.closest('.col-md-6');
                if (card) card.remove();
            }
        })
        .catch(function () {});
}

// Toggle favorit mentor (AJAX)
function toggleMentorFav(encodedId, btn) {
    fetch('<?php echo base_url('mentoring/toggle-favorite/'); ?>' + encodedId, {
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
    })
        .then(function (r) { return r.json(); })
        .then(function (d) {
            if (d.status === 'removed') {
                var card = btn.closest('.col-md-6');
                if (card) card.remove();
            }
        })
        .catch(function () {});
}
</script>
