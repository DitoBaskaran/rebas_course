<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$_is_panel = $this->session->userdata('logged_in');

$is_all = !$selected_type && !$selected_level && !$selected_category;
$query_type = $selected_type ? 'type=' . $selected_type : '';
$query_level = $selected_level ? 'skill_level=' . $selected_level : '';
$query_cat = $selected_category ? 'category_id=' . $selected_category : '';
$query_parts = array_filter(array($query_type, $query_level, $query_cat));
$query_all = $query_parts ? '?' . implode('&', $query_parts) : '';

$cat_colors = array(
    array('#ecfdf5', '#059669'),
    array('#eff6ff', '#2563eb'),
    array('#fdf4ff', '#c026d3'),
    array('#fff7ed', '#ea580c'),
    array('#f0fdfa', '#0d9488'),
    array('#f5f3ff', '#7c3aed'),
);

$ct_icons = array('course'=>'fa-book-open','seminar'=>'fa-video','learning_path'=>'fa-route','mentoring'=>'fa-users','subscription'=>'fa-crown','workshop'=>'fa-tools','bootcamp'=>'fa-fire','ebook'=>'fa-book','project'=>'fa-diagram-project','article'=>'fa-newspaper','video'=>'fa-play','podcast'=>'fa-podcast','template'=>'fa-pen-ruler');

$lvl_meta = array(
    'beginner' => array('Pemula', 'Beginner', 'fa-seedling', '#dcfce7', '#16a34a'),
    'intermediate' => array('Menengah', 'Intermediate', 'fa-fire', '#fef9c3', '#ca8a04'),
    'advanced' => array('Mahir', 'Advanced', 'fa-bolt', '#fce4ec', '#e11d48'),
);

$grads = array(
    'linear-gradient(135deg,#059669,#10b981)',
    'linear-gradient(135deg,#2563eb,#38bdf8)',
    'linear-gradient(135deg,#c026d3,#f472b6)',
    'linear-gradient(135deg,#ea580c,#fbbf24)',
    'linear-gradient(135deg,#0d9488,#2dd4bf)',
    'linear-gradient(135deg,#7c3aed,#a78bfa)'
);
?>
<style>
/* ===== COURSES PAGE REDESIGN ===== */
.crs-hero {
    background: linear-gradient(135deg, #059669 0%, #0d9488 55%, #0ea5e9 130%);
    border-radius: 20px;
    padding: 2.2rem 1.5rem;
    position: relative;
    overflow: hidden;
    color: #fff;
    margin-bottom: 1.5rem;
}
.crs-hero::before {
    content: '';
    position: absolute;
    right: -60px; top: -80px;
    width: 240px; height: 240px;
    border-radius: 50%;
    background: rgba(255,255,255,0.10);
}
.crs-hero::after {
    content: '';
    position: absolute;
    right: 80px; bottom: -70px;
    width: 160px; height: 160px;
    border-radius: 50%;
    background: rgba(255,255,255,0.07);
}
.crs-hero > * { position: relative; z-index: 1; }
.crs-hero-title { font-size: 1.5rem; font-weight: 800; letter-spacing: -0.02em; margin-bottom: 0.35rem; }
.crs-hero-sub { font-size: 0.85rem; opacity: 0.9; max-width: 460px; margin-bottom: 1.1rem; }
.crs-hero-stats { display: flex; gap: 1.25rem; flex-wrap: wrap; }
.crs-hero-stat b { font-size: 1.1rem; font-weight: 800; display: block; line-height: 1.2; }
.crs-hero-stat span { font-size: 0.68rem; opacity: 0.85; }

.crs-searchbar {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    background: #fff;
    border: 2px solid rgba(255,255,255,0.85);
    border-radius: 100px;
    padding: 0.35rem 0.35rem 0.35rem 1.1rem;
    box-shadow: 0 8px 24px -8px rgba(0,0,0,0.25);
    max-width: 560px;
}
.crs-searchbar i { color: #a3a3a3; font-size: 0.85rem; flex-shrink: 0; }
.crs-searchbar input {
    border: none; outline: none; flex: 1;
    font-size: 0.88rem; background: transparent; color: #1c1917; min-width: 0;
}
.crs-searchbar button {
    background: #059669; color: #fff; border: none;
    border-radius: 100px; font-size: 0.8rem; font-weight: 700;
    padding: 0.55rem 1.15rem; white-space: nowrap; cursor: pointer;
    transition: all 0.2s;
}
.crs-searchbar button:hover { background: #047857; }

.crs-chips {
    display: flex; gap: 0.5rem;
    overflow-x: auto; padding-bottom: 0.4rem;
    scrollbar-width: none; -ms-overflow-style: none;
}
.crs-chips::-webkit-scrollbar { display: none; }
.crs-chip {
    flex-shrink: 0;
    padding: 0.45rem 1rem;
    border-radius: 100px;
    font-size: 0.75rem; font-weight: 600;
    background: #f5f5f4; color: #57534e;
    text-decoration: none;
    border: 1.5px solid transparent;
    transition: all 0.2s;
    white-space: nowrap;
}
.crs-chip:hover { border-color: #d6d3d1; background: #fafaf9; }
.crs-chip.active { background: #059669 !important; color: #fff !important; border-color: #059669 !important; }
.crs-chip.ic { display: inline-flex; align-items: center; gap: 0.35rem; }
.crs-chip.ic i { font-size: 0.7rem; }

/* ---- Course Card Premium ---- */
.crs-grid { display: grid; gap: 1rem; }
.crs-grid-lg {
    grid-template-columns: repeat(auto-fill, minmax(230px, 1fr));
}
.crs-card {
    background: #fff;
    border: 1px solid #e7e5e4;
    border-radius: 16px;
    overflow: hidden;
    display: flex;
    flex-direction: column;
    text-decoration: none;
    transition: transform 0.2s ease, box-shadow 0.2s ease, border-color 0.2s ease;
    box-shadow: 0 1px 3px rgba(0,0,0,0.03);
}
.crs-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 28px -8px rgba(0,0,0,0.12);
    border-color: #d6d3d1;
}
.crs-card-thumb {
    position: relative;
    aspect-ratio: 16/9;
    overflow: hidden;
    background: #f5f5f4;
    display: flex; align-items: center; justify-content: center;
    color: #fff; font-size: 2rem; font-weight: 800;
}
.crs-card-thumb img {
    width: 100%; height: 100%;
    object-fit: cover;
    transition: transform 0.35s ease;
}
.crs-card:hover .crs-card-thumb img { transform: scale(1.05); }
.crs-card-badge {
    position: absolute; top: 10px; left: 10px;
    background: rgba(17,24,39,0.85);
    color: #fff; font-size: 0.6rem; font-weight: 700;
    padding: 0.22rem 0.6rem; border-radius: 100px;
    backdrop-filter: blur(4px);
    z-index: 2;
}
.crs-card-price {
    position: absolute; bottom: 10px; right: 10px;
    background: rgba(255,255,255,0.92);
    color: #1c1917; font-size: 0.68rem; font-weight: 800;
    padding: 0.22rem 0.6rem; border-radius: 100px;
    backdrop-filter: blur(4px);
    z-index: 2;
    box-shadow: 0 1px 6px rgba(0,0,0,0.15);
}
.crs-card-price.free { background: #dcfce7; color: #15803d; }
.crs-card-body {
    padding: 0.85rem 0.9rem 0.75rem;
    display: flex; flex-direction: column; flex: 1; min-width: 0;
}
.crs-card-cat {
    font-size: 0.64rem; font-weight: 600; color: #a8a29e;
    text-transform: uppercase; letter-spacing: 0.04em;
    margin-bottom: 0.25rem;
    white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
}
.crs-card-title {
    font-size: 0.85rem; font-weight: 700; color: #1c1917;
    line-height: 1.35;
    display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;
    overflow: hidden;
    margin-bottom: 0.5rem;
    min-height: 2.3em;
}
.crs-card-meta {
    margin-top: auto;
    padding-top: 0.55rem;
    border-top: 1px solid #f0eeeb;
    display: flex; align-items: center; justify-content: space-between; gap: 0.4rem;
}
.crs-card-teacher {
    display: flex; align-items: center; gap: 0.35rem;
    font-size: 0.66rem; color: #78716c;
    min-width: 0;
}
.crs-card-teacher .t-av {
    width: 18px; height: 18px; border-radius: 50%;
    background: linear-gradient(135deg,#059669,#10b981);
    color: #fff; font-size: 0.55rem; font-weight: 700;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
}
.crs-card-teacher span { white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
.crs-card-level {
    font-size: 0.6rem; font-weight: 700; color: #57534e;
    background: #f5f5f4; padding: 0.2rem 0.55rem; border-radius: 100px;
    flex-shrink: 0;
}

/* Mobile list card (horizontal, compact) */
.crs-mob-card {
    display: flex; align-items: center; gap: 0.75rem;
    background: #fff;
    border: 1px solid #f0eeeb;
    border-radius: 16px;
    padding: 0.7rem;
    text-decoration: none;
    transition: transform 0.15s ease, box-shadow 0.2s ease;
    box-shadow: 0 1px 3px rgba(0,0,0,0.03);
}
.crs-mob-card:active { transform: scale(0.98); }
.crs-mob-thumb {
    width: 92px; height: 64px; border-radius: 12px;
    flex-shrink: 0; overflow: hidden;
    background: #f5f5f4;
    display: flex; align-items: center; justify-content: center;
    color: #fff; font-size: 1.2rem; font-weight: 800;
    position: relative;
}
.crs-mob-thumb img { width: 100%; height: 100%; object-fit: cover; }
.crs-mob-body { flex: 1; min-width: 0; }
.crs-mob-title {
    font-size: 0.82rem; font-weight: 700; color: #1c1917;
    white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
    margin-bottom: 0.15rem;
}
.crs-mob-sub {
    font-size: 0.65rem; color: #a8a29e;
    display: flex; align-items: center; gap: 0.4rem;
    white-space: nowrap; overflow: hidden;
}
.crs-mob-sub .dot { width: 3px; height: 3px; border-radius: 50%; background: #d6d3d1; flex-shrink: 0; }
.crs-mob-price {
    font-size: 0.7rem; font-weight: 800; color: #059669;
    margin-top: 0.2rem;
}
.crs-mob-price.free { color: #16a34a; }
.crs-mob-chev { color: #d6d3d1; font-size: 0.7rem; flex-shrink: 0; }

/* Panel header compact */
.crs-panel-head { display: flex; align-items: center; justify-content: space-between; gap: 0.75rem; margin-bottom: 1rem; }
.crs-panel-head h4 { font-size: 1.2rem; font-weight: 800; color: #1c1917; letter-spacing: -0.02em; margin: 0; }
.crs-panel-head small { color: #78716c; font-size: 0.72rem; }

/* Section title untuk filter grup */
.crs-sec-label {
    font-size: 0.65rem; font-weight: 700; color: #a8a29e;
    text-transform: uppercase; letter-spacing: 0.07em;
    margin-bottom: 0.4rem;
}
@media (min-width: 992px) {
    .crs-hero { padding: 3rem 2.5rem; }
    .crs-hero-title { font-size: 2rem; }
    .crs-hero-sub { font-size: 0.95rem; }
}
</style>

<?php if ($_is_panel): ?>
<!-- ============ PANEL STUDENT ============ -->
<div class="container-fluid py-4" style="padding-top: 0 !important; max-width: 1200px;">

    <!-- ===== MOBILE (app-style) ===== -->
    <div class="dashboard-mobile-only">
        <div class="crs-panel-head">
            <div>
                <h4><?php echo t('Jelajahi Kelas', 'Explore Courses'); ?></h4>
                <small><?php echo count($courses); ?> <?php echo t('kelas tersedia', 'courses available'); ?></small>
            </div>
            <a href="<?php echo base_url('courses/mine'); ?>" class="btn px-3 py-2 fw-semibold rounded-pill" style="background:#ecfdf5;color:#059669;font-size:0.72rem;">
                <i class="fas fa-book-open me-1" style="font-size:0.65rem;"></i> <?php echo t('Kelas Saya', 'My Courses'); ?>
            </a>
        </div>

        <!-- Search -->
        <form action="<?php echo base_url('courses'); ?>" method="GET" class="mb-3">
            <div class="crs-searchbar">
                <i class="fas fa-search"></i>
                <input type="text" name="search" value="<?php echo htmlspecialchars($search_query ?? ''); ?>" placeholder="<?php echo t('Cari kelas...', 'Search courses...'); ?>">
                <button type="submit"><?php echo t('Cari', 'Search'); ?></button>
            </div>
        </form>

        <!-- Category chips -->
        <div class="crs-chips mb-3">
            <a href="<?php echo base_url('courses'); ?>" class="crs-chip ic <?php echo $is_all ? 'active' : ''; ?>">
                <i class="fas fa-th-large"></i> <?php echo t('Semua', 'All'); ?>
            </a>
            <?php $ci = 0; foreach ($categories as $cat): $act = ($selected_category == $cat->id); ?>
                <a href="<?php echo base_url('courses?category_id=' . $cat->id); ?>" class="crs-chip <?php echo $act ? 'active' : ''; ?>">
                    <?php echo htmlspecialchars($cat->name); ?>
                </a>
            <?php $ci++; endforeach; ?>
        </div>

        <!-- Course list (horizontal compact) -->
        <?php if (empty($courses)): ?>
            <div class="mob-empty">
                <i class="fas fa-search"></i>
                <p><?php echo t('Tidak ada kelas ditemukan.', 'No courses found.'); ?></p>
                <a href="<?php echo base_url('courses'); ?>"><?php echo t('Reset Filter', 'Reset Filters'); ?></a>
            </div>
        <?php else: ?>
            <div class="d-flex flex-column gap-2">
                <?php foreach ($courses as $i => $course): ?>
                    <?php
                    $gi = $i % 6;
                    $thumb_ok = !empty($course->thumbnail)
                        && file_exists(FCPATH . 'uploads/courses/' . $course->thumbnail)
                        && $course->thumbnail !== 'default_course.png';
                    $price_html = $course->price > 0
                        ? 'Rp ' . number_format($course->price, 0, ',', '.')
                        : t('Gratis', 'Free');
                    $price_cls = $course->price > 0 ? '' : 'free';
                    ?>
                    <a href="<?php echo base_url('courses/detail/' . $course->slug); ?>" class="crs-mob-card">
                        <div class="crs-mob-thumb" style="background: <?php echo $grads[$gi]; ?>;">
                            <?php if ($thumb_ok): ?>
                                <img src="<?php echo base_url('uploads/courses/' . $course->thumbnail); ?>" alt="">
                            <?php else: ?>
                                <?php echo strtoupper(substr(trim($course->title), 0, 1)); ?>
                            <?php endif; ?>
                        </div>
                        <div class="crs-mob-body">
                            <div class="crs-mob-title"><?php echo htmlspecialchars($course->title); ?></div>
                            <div class="crs-mob-sub">
                                <span><?php echo htmlspecialchars($course->teacher_name); ?></span>
                                <span class="dot"></span>
                                <span><?php echo content_type_label($course->content_type); ?></span>
                            </div>
                            <div class="crs-mob-price <?php echo $price_cls; ?>"><?php echo $price_html; ?></div>
                        </div>
                        <span class="crs-mob-chev"><i class="fas fa-chevron-right"></i></span>
                    </a>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>

    <!-- ===== DESKTOP (panel) ===== -->
    <div class="dashboard-desktop-only">
        <div class="crs-panel-head mb-4">
            <div>
                <h4><?php echo t('Jelajahi Kelas', 'Explore Courses'); ?></h4>
                <small><?php echo t('Temukan kelas baru untuk mengembangkan skillmu', 'Discover new courses to grow your skills'); ?></small>
            </div>
            <a href="<?php echo base_url('courses/mine'); ?>" class="btn px-3 py-2 fw-semibold rounded-pill" style="background:#ecfdf5;color:#059669;font-size:0.8rem;">
                <i class="fas fa-book-open me-1"></i> <?php echo t('Kelas Saya', 'My Courses'); ?>
            </a>
        </div>

        <!-- Hero compact -->
        <div class="crs-hero mb-4">
            <div class="crs-hero-title"><?php echo t('Belajar Tanpa Batas', 'Learn Without Limits'); ?></div>
            <div class="crs-hero-sub"><?php echo t('Pilih dari ribuan konten belajar terstruktur dan kuasai skill baru hari ini.', 'Choose from thousands of structured courses and master new skills today.'); ?></div>
            <form action="<?php echo base_url('courses'); ?>" method="GET" class="crs-searchbar mb-3">
                <i class="fas fa-search"></i>
                <input type="text" name="search" value="<?php echo htmlspecialchars($search_query ?? ''); ?>" placeholder="<?php echo t('Cari kelas, materi, atau topik...', 'Search courses, content, or topics...'); ?>">
                <button type="submit"><?php echo t('Cari', 'Search'); ?></button>
            </form>
            <div class="crs-hero-stats">
                <div class="crs-hero-stat"><b><?php echo count($courses); ?>+</b><span><?php echo t('Kelas', 'Courses'); ?></span></div>
                <div class="crs-hero-stat"><b><?php echo count($categories); ?>+</b><span><?php echo t('Kategori', 'Categories'); ?></span></div>
                <div class="crs-hero-stat"><b>24/7</b><span><?php echo t('Akses', 'Access'); ?></span></div>
            </div>
        </div>

        <!-- Filters -->
        <div class="mb-4">
            <div class="crs-sec-label"><?php echo t('Kategori', 'Categories'); ?></div>
            <div class="crs-chips mb-3">
                <a href="<?php echo base_url('courses'); ?>" class="crs-chip ic <?php echo $is_all ? 'active' : ''; ?>">
                    <i class="fas fa-th-large"></i> <?php echo t('Semua', 'All'); ?>
                </a>
                <?php $ci = 0; foreach ($categories as $cat): $act = ($selected_category == $cat->id); ?>
                    <a href="<?php echo base_url('courses?category_id=' . $cat->id); ?>" class="crs-chip <?php echo $act ? 'active' : ''; ?>">
                        <i class="fas fa-<?php echo htmlspecialchars($cat->icon ?: 'folder-open'); ?>" style="font-size:0.65rem;"></i>
                        <?php echo htmlspecialchars($cat->name); ?>
                    </a>
                <?php $ci++; endforeach; ?>
            </div>

            <div class="crs-sec-label"><?php echo t('Level Skill', 'Skill Level'); ?></div>
            <div class="crs-chips">
                <a href="<?php echo base_url('courses' . ($query_all ? $query_all . '&' : '?') . 'skill_level='); ?>" class="crs-chip <?php echo !$selected_level ? 'active' : ''; ?>">
                    <?php echo t('Semua Level', 'All Levels'); ?>
                </a>
                <?php foreach ($lvl_meta as $lk => $lv): ?>
                    <a href="<?php echo base_url('courses' . ($query_all ? $query_all . '&' : '?') . 'skill_level=' . $lk); ?>" class="crs-chip <?php echo $selected_level === $lk ? 'active' : ''; ?>">
                        <i class="fas <?php echo $lv[2]; ?>" style="font-size:0.65rem;"></i>
                        <?php echo t($lv[0], $lv[1]); ?>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Result count -->
        <div class="mb-3" style="font-size:0.78rem;color:#78716c;font-weight:500;">
            <?php echo t('Menampilkan', 'Showing'); ?> <strong style="color:#1c1917;"><?php echo count($courses); ?></strong> <?php echo t('kelas', 'courses'); ?>
        </div>

        <!-- Grid -->
        <?php if (empty($courses)): ?>
            <div class="text-center py-5">
                <div style="font-size: 2.5rem; color: #d4d4d4; margin-bottom: 0.75rem;"><i class="fas fa-search"></i></div>
                <h5 class="fw-bold" style="color: #1c1917;"><?php echo t('Tidak Ada Hasil', 'No Results Found'); ?></h5>
                <p style="color: #78716c; font-size: 0.85rem;"><?php echo t('Coba ubah filter atau kata kunci pencarian Anda.', 'Try changing your filters or search keywords.'); ?></p>
            </div>
        <?php else: ?>
            <div class="crs-grid crs-grid-lg">
                <?php foreach ($courses as $i => $course): ?>
                    <?php
                    $gi = $i % 6;
                    $thumb_ok = !empty($course->thumbnail)
                        && file_exists(FCPATH . 'uploads/courses/' . $course->thumbnail)
                        && $course->thumbnail !== 'default_course.png';
                    $lv = $lvl_meta[$course->skill_level] ?? array('', '', 'fa-seedling', '#f5f5f4', '#57534e');
                    ?>
                    <a href="<?php echo base_url('courses/detail/' . $course->slug); ?>" class="crs-card">
                        <div class="crs-card-thumb" style="background: <?php echo $grads[$gi]; ?>;">
                            <?php if ($thumb_ok): ?>
                                <img src="<?php echo base_url('uploads/courses/' . $course->thumbnail); ?>" alt="" loading="lazy">
                            <?php else: ?>
                                <?php echo strtoupper(substr(trim($course->title), 0, 1)); ?>
                            <?php endif; ?>
                            <span class="crs-card-badge"><?php echo content_type_label($course->content_type); ?></span>
                            <span class="crs-card-price <?php echo $course->price <= 0 ? 'free' : ''; ?>">
                                <?php echo $course->price > 0 ? 'Rp ' . number_format($course->price, 0, ',', '.') : t('Gratis', 'Free'); ?>
                            </span>
                        </div>
                        <div class="crs-card-body">
                            <div class="crs-card-cat"><?php echo htmlspecialchars($course->category_name ?? ''); ?></div>
                            <div class="crs-card-title"><?php echo htmlspecialchars($course->title); ?></div>
                            <div class="crs-card-meta">
                                <span class="crs-card-teacher">
                                    <span class="t-av"><?php echo strtoupper(substr(trim($course->teacher_name), 0, 1)); ?></span>
                                    <span><?php echo htmlspecialchars($course->teacher_name); ?></span>
                                </span>
                                <span class="crs-card-level">
                                    <i class="fas <?php echo $lv[2]; ?>" style="font-size:0.55rem;margin-right:0.2rem;"></i><?php echo t($lv[0], $lv[1]); ?>
                                </span>
                            </div>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php else: ?>
<!-- ============ HALAMAN PUBLIK (guest) ============ -->
<div class="container" style="max-width: 1200px; padding-top: 2rem; padding-bottom: 4rem;">

    <!-- Hero -->
    <div class="crs-hero">
        <div class="crs-hero-title"><?php echo t('Temukan Materi Belajar', 'Discover Learning Content'); ?></div>
        <div class="crs-hero-sub"><?php echo t('Pilih dari ribuan konten belajar terstruktur untuk menguasai skill baru, mulai dari pemula hingga mahir.', 'Choose from thousands of structured courses to master new skills, from beginner to advanced.'); ?></div>
        <form action="<?php echo base_url('courses'); ?>" method="GET" class="crs-searchbar mb-3">
            <i class="fas fa-search"></i>
            <input type="text" name="search" value="<?php echo htmlspecialchars($search_query ?? ''); ?>" placeholder="<?php echo t('Cari kelas, materi, atau topik...', 'Search courses, content, or topics...'); ?>">
            <button type="submit"><?php echo t('Cari', 'Search'); ?></button>
        </form>
        <div class="crs-hero-stats">
            <div class="crs-hero-stat"><b><?php echo count($courses); ?>+</b><span><?php echo t('Kelas', 'Courses'); ?></span></div>
            <div class="crs-hero-stat"><b><?php echo count($categories); ?>+</b><span><?php echo t('Kategori', 'Categories'); ?></span></div>
            <div class="crs-hero-stat"><b>16+</b><span><?php echo t('Bidang', 'Fields'); ?></span></div>
        </div>
    </div>

    <!-- Filter: Tipe Konten -->
    <div class="crs-sec-label mb-2"><?php echo t('Tipe Konten', 'Content Type'); ?></div>
    <div class="crs-chips mb-3">
        <a href="<?php echo base_url('courses'); ?>" class="crs-chip ic <?php echo $is_all ? 'active' : ''; ?>">
            <i class="fas fa-th-large"></i> <?php echo t('Semua', 'All'); ?>
        </a>
        <?php $ci = 0; foreach ($content_types as $ct): $act = ($selected_type == $ct); $cc = $cat_colors[$ci % 6]; ?>
            <a href="<?php echo base_url('courses?type=' . $ct . ($query_level ? '&' . $query_level : '') . ($query_cat ? '&' . $query_cat : '')); ?>" class="crs-chip <?php echo $act ? 'active' : ''; ?>">
                <i class="fas <?php echo $ct_icons[$ct] ?? 'fa-folder-open'; ?>"></i>
                <?php echo content_type_label($ct); ?>
            </a>
        <?php $ci++; endforeach; ?>
    </div>

    <!-- Filter: Level -->
    <div class="crs-sec-label mb-2"><?php echo t('Level Skill', 'Skill Level'); ?></div>
    <div class="crs-chips mb-3">
        <a href="<?php echo base_url('courses' . ($query_all ? $query_all . '&' : '?') . 'skill_level='); ?>" class="crs-chip <?php echo !$selected_level ? 'active' : ''; ?>">
            <?php echo t('Semua Level', 'All Levels'); ?>
        </a>
        <?php foreach ($lvl_meta as $lk => $lv): ?>
            <a href="<?php echo base_url('courses' . ($query_all ? $query_all . '&' : '?') . 'skill_level=' . $lk); ?>" class="crs-chip <?php echo $selected_level === $lk ? 'active' : ''; ?>">
                <i class="fas <?php echo $lv[2]; ?>"></i>
                <?php echo t($lv[0], $lv[1]); ?>
            </a>
        <?php endforeach; ?>
    </div>

    <!-- Filter: Kategori -->
    <div class="crs-sec-label mb-2"><?php echo t('Kategori', 'Categories'); ?></div>
    <div class="crs-chips mb-4">
        <a href="<?php echo base_url('courses'); ?>" class="crs-chip ic <?php echo !$selected_category ? 'active' : ''; ?>">
            <i class="fas fa-th-large"></i> <?php echo t('Semua', 'All'); ?>
        </a>
        <?php $ci = 0; foreach ($categories as $cat): $act = ($selected_category == $cat->id); ?>
            <a href="<?php echo base_url('courses?category_id=' . $cat->id . ($query_type ? '&' . $query_type : '') . ($query_level ? '&' . $query_level : '')); ?>" class="crs-chip <?php echo $act ? 'active' : ''; ?>">
                <i class="fas fa-<?php echo htmlspecialchars($cat->icon ?: 'folder-open'); ?>"></i>
                <?php echo htmlspecialchars($cat->name); ?>
            </a>
        <?php $ci++; endforeach; ?>
    </div>

    <!-- Result count -->
    <div class="mb-3" style="font-size:0.8rem;color:#78716c;font-weight:500;">
        <?php echo t('Menampilkan', 'Showing'); ?> <strong style="color:#111827;"><?php echo count($courses); ?></strong> <?php echo t('hasil', 'results'); ?>
    </div>

    <?php if (empty($courses)): ?>
        <div class="text-center py-5">
            <div style="font-size: 2.5rem; color: #d4d4d4; margin-bottom: 0.75rem;"><i class="fas fa-search"></i></div>
            <h5 class="fw-bold" style="color: #111827;"><?php echo t('Tidak Ada Hasil', 'No Results Found'); ?></h5>
            <p style="color: #737373; font-size: 0.85rem;"><?php echo t('Coba ubah filter atau kata kunci pencarian Anda.', 'Try changing your filters or search keywords.'); ?></p>
        </div>
    <?php else: ?>
        <!-- Mobile: horizontal compact list -->
        <div class="d-flex flex-column gap-2 d-md-none">
            <?php foreach ($courses as $i => $course): ?>
                <?php
                $gi = $i % 6;
                $thumb_ok = !empty($course->thumbnail)
                    && file_exists(FCPATH . 'uploads/courses/' . $course->thumbnail)
                    && $course->thumbnail !== 'default_course.png';
                ?>
                <a href="<?php echo base_url('courses/detail/' . $course->slug); ?>" class="crs-mob-card">
                    <div class="crs-mob-thumb" style="background: <?php echo $grads[$gi]; ?>;">
                        <?php if ($thumb_ok): ?>
                            <img src="<?php echo base_url('uploads/courses/' . $course->thumbnail); ?>" alt="">
                        <?php else: ?>
                            <?php echo strtoupper(substr(trim($course->title), 0, 1)); ?>
                        <?php endif; ?>
                    </div>
                    <div class="crs-mob-body">
                        <div class="crs-mob-title"><?php echo htmlspecialchars($course->title); ?></div>
                        <div class="crs-mob-sub">
                            <span><?php echo htmlspecialchars($course->teacher_name); ?></span>
                            <span class="dot"></span>
                            <span><?php echo content_type_label($course->content_type); ?></span>
                        </div>
                        <div class="crs-mob-price <?php echo $course->price <= 0 ? 'free' : ''; ?>">
                            <?php echo $course->price > 0 ? 'Rp ' . number_format($course->price, 0, ',', '.') : t('Gratis', 'Free'); ?>
                        </div>
                    </div>
                    <span class="crs-mob-chev"><i class="fas fa-chevron-right"></i></span>
                </a>
            <?php endforeach; ?>
        </div>

        <!-- Desktop/Tablet: premium grid -->
        <div class="crs-grid crs-grid-lg d-none d-md-grid">
            <?php foreach ($courses as $i => $course): ?>
                <?php
                $gi = $i % 6;
                $thumb_ok = !empty($course->thumbnail)
                    && file_exists(FCPATH . 'uploads/courses/' . $course->thumbnail)
                    && $course->thumbnail !== 'default_course.png';
                $lv = $lvl_meta[$course->skill_level] ?? array('', '', 'fa-seedling', '#f5f5f4', '#57534e');
                ?>
                <a href="<?php echo base_url('courses/detail/' . $course->slug); ?>" class="crs-card">
                    <div class="crs-card-thumb" style="background: <?php echo $grads[$gi]; ?>;">
                        <?php if ($thumb_ok): ?>
                            <img src="<?php echo base_url('uploads/courses/' . $course->thumbnail); ?>" alt="" loading="lazy">
                        <?php else: ?>
                            <?php echo strtoupper(substr(trim($course->title), 0, 1)); ?>
                        <?php endif; ?>
                        <span class="crs-card-badge"><?php echo content_type_label($course->content_type); ?></span>
                        <span class="crs-card-price <?php echo $course->price <= 0 ? 'free' : ''; ?>">
                            <?php echo $course->price > 0 ? 'Rp ' . number_format($course->price, 0, ',', '.') : t('Gratis', 'Free'); ?>
                        </span>
                    </div>
                    <div class="crs-card-body">
                        <div class="crs-card-cat"><?php echo htmlspecialchars($course->category_name ?? ''); ?></div>
                        <div class="crs-card-title"><?php echo htmlspecialchars($course->title); ?></div>
                        <div class="crs-card-meta">
                            <span class="crs-card-teacher">
                                <span class="t-av"><?php echo strtoupper(substr(trim($course->teacher_name), 0, 1)); ?></span>
                                <span><?php echo htmlspecialchars($course->teacher_name); ?></span>
                            </span>
                            <span class="crs-card-level">
                                <i class="fas <?php echo $lv[2]; ?>" style="font-size:0.55rem;margin-right:0.2rem;"></i><?php echo t($lv[0], $lv[1]); ?>
                            </span>
                        </div>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>
<?php endif; ?>
