<div class="container-fluid px-0">

    <!-- ============ HEADER (hero) ============ -->
    <?php $total_all = count($wishlists) + count($favorite_mentors); ?>
    <div class="bento-card mb-4 overflow-hidden" style="background:linear-gradient(120deg,#0D1830 0%,#be185d 140%);border:none;color:#fff;">
        <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3 position-relative" style="z-index:1;">
            <div>
                <span class="d-inline-flex align-items-center gap-1" style="background:rgba(255,255,255,0.14);border:1px solid rgba(255,255,255,0.2);color:#FBBF24;font-size:0.66rem;font-weight:800;letter-spacing:0.12em;text-transform:uppercase;padding:0.3rem 0.7rem;border-radius:100px;">
                    <i data-lucide="heart" style="width:12px;height:12px;"></i> <?php echo t('Favorit', 'Favorites'); ?>
                </span>
                <h1 class="fw-extrabold text-white mb-1 mt-2 lh-sm" style="letter-spacing:-0.03em;font-size:1.5rem;">
                    <?php echo t('Wishlist Saya', 'My Wishlist'); ?>
                </h1>
                <p class="mb-0" style="color:rgba(255,255,255,0.72);font-size:0.8rem;">
                    <?php echo t('Kelas & mentor yang kamu simpan.', 'Courses & mentors you saved.'); ?>
                    <span class="fw-semibold text-white">(<?php echo $total_all; ?>)</span>
                </p>
            </div>
            <a href="<?php echo base_url('courses'); ?>" class="btn fw-semibold rounded-pill d-inline-flex align-items-center gap-2 border-0 flex-shrink-0" style="background:#FBBF24;color:#0D1830;font-size:0.78rem;padding:0.55rem 1.1rem;box-shadow:0 4px 14px rgba(251,191,36,0.3);">
                <i data-lucide="search" style="width:14px;height:14px;"></i> <?php echo t('Jelajahi', 'Browse'); ?>
            </a>
        </div>
    </div>

    <?php if ($total_all === 0): ?>
    <!-- Empty State -->
    <div class="bento-card p-5 text-center">
        <div class="mx-auto d-inline-flex align-items-center justify-content-center rounded-circle mb-3" style="width:72px;height:72px;background:#fdf2f8;color:#be185d;">
            <i data-lucide="heart" style="width:30px;height:30px;"></i>
        </div>
        <h5 class="fw-extrabold text-dark mb-1"><?php echo t('Belum Ada Wishlist', 'No Wishlist Yet'); ?></h5>
        <p class="text-secondary small mb-4" style="max-width:26rem;margin-left:auto;margin-right:auto;"><?php echo t('Simpan kelas favorit atau mentor impianmu dengan klik ikon hati. Semua tersimpan rapi di sini.', 'Save your favorite courses or dream mentors by tapping the heart icon. Everything is stored neatly here.'); ?></p>
        <div class="d-flex justify-content-center gap-2 flex-wrap">
            <a href="<?php echo base_url('courses'); ?>" class="btn btn-primary rounded-pill px-4 fw-semibold d-inline-flex align-items-center gap-2">
                <i data-lucide="book-open" style="width:15px;height:15px;"></i> <?php echo t('Jelajahi Kelas', 'Browse Courses'); ?>
            </a>
            <a href="<?php echo base_url('mentoring'); ?>" class="btn rounded-pill px-4 fw-semibold d-inline-flex align-items-center gap-2" style="border:1px solid var(--primary);color:var(--primary);">
                <i data-lucide="user" style="width:15px;height:15px;"></i> <?php echo t('Cari Mentor', 'Find Mentors'); ?>
            </a>
        </div>
    </div>

    <?php else: ?>
    <!-- Tabs: Kelas / Mentor -->
    <div class="d-flex gap-1 mb-3">
        <button type="button" class="js-wl-tab wl-tab wl-tab-active" data-tab="courses">
            <i data-lucide="book-open" style="width:14px;height:14px;"></i> <?php echo t('Kelas', 'Courses'); ?>
            <span class="wl-tab-badge"><?php echo count($wishlists); ?></span>
        </button>
        <button type="button" class="js-wl-tab wl-tab" data-tab="mentors">
            <i data-lucide="user" style="width:14px;height:14px;"></i> <?php echo t('Mentor', 'Mentors'); ?>
            <span class="wl-tab-badge"><?php echo count($favorite_mentors); ?></span>
        </button>
    </div>

    <!-- ===== TAB KELAS ===== -->
    <div class="js-wl-panel" data-panel="courses">
        <?php if (empty($wishlists)): ?>
            <div class="bento-card p-5 text-center">
                <p class="text-secondary small mb-3"><?php echo t('Belum ada kelas disimpan.', 'No saved courses yet.'); ?></p>
                <a href="<?php echo base_url('courses'); ?>" class="btn btn-primary rounded-pill px-3 fw-semibold btn-sm"><?php echo t('Jelajahi Kelas', 'Browse Courses'); ?></a>
            </div>
        <?php else: ?>
        <div class="bento-grid bento-grid-3">
            <?php foreach ($wishlists as $c): ?>
            <div class="bento-card p-0 wl-course-card">
                <div class="position-relative overflow-hidden" style="aspect-ratio:16/9;border-radius:20px 20px 0 0;">
                    <img src="<?php echo base_url('uploads/courses/' . $c->thumbnail); ?>" onerror="this.style.display='none';this.parentNode.style.background='linear-gradient(135deg,#0D1830,#009688)';" alt="" class="w-100 h-100" style="object-fit:cover;">
                    <button onclick="toggleWishlist('<?php echo $c->slug; ?>', this)" class="btn d-flex align-items-center justify-content-center position-absolute wl-heart-btn" style="top:8px;right:8px;">
                        <i class="fas fa-heart"></i>
                    </button>
                    <span class="position-absolute px-2 py-1 rounded-pill fw-semibold" style="bottom:8px;left:8px;background:rgba(13,24,48,0.75);color:#fff;font-size:0.62rem;"><?php echo content_type_label($c->content_type); ?></span>
                </div>
                <div class="p-3 d-flex flex-column">
                    <div class="d-flex align-items-center gap-2 mb-1" style="color:#78716c;font-size:0.68rem;">
                        <?php if ($c->category_name): ?><span><i class="fas fa-folder me-1" style="font-size:0.5rem;"></i><?php echo htmlspecialchars($c->category_name); ?></span><span style="opacity:0.5;">·</span><?php endif; ?>
                        <span><i class="fas fa-signal me-1" style="font-size:0.5rem;"></i><?php echo skill_level_label($c->skill_level); ?></span>
                    </div>
                    <div class="fw-bold text-dark mb-2 lh-sm" style="font-size:0.85rem;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;"><?php echo htmlspecialchars(t($c->title, $c->title_en ?: $c->title)); ?></div>
                    <div class="mt-auto pt-2 d-flex align-items-center justify-content-between" style="border-top:1px solid var(--card-border,#eef0f3);">
                        <span class="fw-bold" style="color:<?php echo $c->price > 0 ? '#0D1830' : '#009688'; ?>;font-size:0.82rem;"><?php echo $c->price > 0 ? 'Rp ' . number_format($c->price, 0, ',', '.') : t('Gratis', 'Free'); ?></span>
                        <a href="<?php echo base_url('courses/detail/' . $c->slug); ?>" class="btn btn-sm fw-bold rounded-pill px-3" style="background:#0D1830;color:#fff;font-size:0.7rem;"><?php echo t('Detail', 'Detail'); ?></a>
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
            <div class="bento-card p-5 text-center">
                <p class="text-secondary small mb-3"><?php echo t('Belum ada mentor disimpan.', 'No saved mentors yet.'); ?></p>
                <a href="<?php echo base_url('mentoring'); ?>" class="btn btn-primary rounded-pill px-3 fw-semibold btn-sm"><?php echo t('Cari Mentor', 'Find Mentors'); ?></a>
            </div>
        <?php else: ?>
        <div class="bento-grid bento-grid-3">
            <?php foreach ($favorite_mentors as $m): ?>
            <div class="bento-card p-0 wl-course-card">
                <div class="position-relative overflow-hidden d-flex align-items-center justify-content-center" style="aspect-ratio:16/9;border-radius:20px 20px 0 0;background:linear-gradient(135deg,#0D1830 0%,#009688 100%);">
                    <?php if (!empty($m->avatar) && file_exists(FCPATH . 'uploads/mentors/' . $m->avatar)): ?>
                        <img src="<?php echo base_url('uploads/mentors/' . $m->avatar); ?>" alt="" class="w-100 h-100" style="object-fit:cover;opacity:0.85;">
                    <?php else: ?>
                        <span style="font-size:4rem;color:rgba(255,255,255,0.35);font-weight:800;"><?php echo strtoupper(substr($m->name, 0, 1)); ?></span>
                    <?php endif; ?>
                    <button onclick="toggleMentorFav('<?php echo encode_id($m->mentor_id); ?>', this)" class="btn d-flex align-items-center justify-content-center position-absolute wl-heart-btn" style="top:8px;right:8px;">
                        <i class="fas fa-heart"></i>
                    </button>
                    <span class="position-absolute px-2 py-1 rounded-pill fw-semibold" style="bottom:8px;left:8px;background:rgba(13,24,48,0.75);color:#fff;font-size:0.62rem;"><i class="fas fa-star me-1" style="color:#FBBF24;"></i><?php echo $m->avg_rating; ?> (<?php echo $m->total_reviews; ?>)</span>
                </div>
                <div class="p-3 d-flex flex-column">
                    <div class="d-flex align-items-center gap-2 mb-2">
                        <span class="d-inline-flex align-items-center justify-content-center rounded-circle fw-bold flex-shrink-0" style="width:32px;height:32px;background:linear-gradient(135deg,#009688,#00796B);color:#fff;font-size:0.72rem;"><?php echo strtoupper(substr($m->name, 0, 1)); ?></span>
                        <div class="min-w-0">
                            <div class="fw-bold text-truncate" style="color:#0D1830;font-size:0.82rem;"><?php echo htmlspecialchars($m->name); ?></div>
                            <div class="text-truncate" style="color:#78716c;font-size:0.68rem;"><?php echo htmlspecialchars(t($m->title, $m->title_en)); ?></div>
                        </div>
                    </div>
                    <div class="mt-auto pt-2 d-flex align-items-center justify-content-between" style="border-top:1px solid var(--card-border,#eef0f3);">
                        <span class="small" style="color:#78716c;font-size:0.68rem;"><i class="fas fa-video me-1"></i><?php echo strtoupper(str_replace(',', ', ', $m->meeting_platforms)); ?></span>
                        <a href="<?php echo base_url('mentoring/detail/' . encode_id($m->mentor_id)); ?>" class="btn btn-sm fw-bold rounded-pill px-3" style="background:#0D1830;color:#fff;font-size:0.7rem;"><?php echo t('Detail', 'Detail'); ?></a>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </div>
    <?php endif; ?>
</div>

<style>
.wl-tab {
  display: inline-flex; align-items: center; gap: 0.45rem;
  padding: 0.5rem 1rem;
  border-radius: 100px;
  border: none;
  font-size: 0.8rem; font-weight: 700;
  color: #78716c;
  background: var(--gray-100, #f1f5f9);
  transition: all 0.2s;
}
.wl-tab-active { background: #0D1830; color: #fff; }
.wl-tab-badge { padding: 0.1rem 0.5rem; border-radius: 100px; font-size: 0.62rem; background: rgba(0,0,0,0.08); }
.wl-tab-active .wl-tab-badge { background: rgba(255,255,255,0.2); }
.wl-heart-btn {
  width: 30px; height: 30px;
  border-radius: 50%;
  background: rgba(255,255,255,0.92);
  border: none; color: #e11d48; padding: 0;
  box-shadow: 0 2px 6px rgba(0,0,0,0.15);
}
.wl-heart-btn i { font-size: 0.7rem; }
</style>

<script>
// Tab switching
document.addEventListener('DOMContentLoaded', function () {
    var tabs = document.querySelectorAll('.js-wl-tab');
    tabs.forEach(function (tab) {
        tab.addEventListener('click', function () {
            var target = tab.getAttribute('data-tab');
            tabs.forEach(function (t) {
                t.classList.toggle('wl-tab-active', t === tab);
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
                var card = btn.closest('.wl-course-card');
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
                var card = btn.closest('.wl-course-card');
                if (card) card.remove();
            }
        })
        .catch(function () {});
}
</script>
