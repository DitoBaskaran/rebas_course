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
    array('#E0F2F1', '#009688'),
    array('#eff6ff', '#2563eb'),
    array('#fdf4ff', '#c026d3'),
    array('#fff7ed', '#ea580c'),
    array('#E0F2F1', '#0d9488'),
    array('#f5f3ff', '#7c3aed'),
);

$ct_icons = array('course'=>'fa-book-open','seminar'=>'fa-video','learning_path'=>'fa-route','mentoring'=>'fa-users','subscription'=>'fa-crown','workshop'=>'fa-tools','bootcamp'=>'fa-fire','ebook'=>'fa-book','project'=>'fa-diagram-project','article'=>'fa-newspaper','video'=>'fa-play','podcast'=>'fa-podcast','template'=>'fa-pen-ruler');

$lvl_meta = array(
    'beginner' => array('Pemula', 'Beginner', 'fa-seedling', '#dcfce7', '#16a34a'),
    'intermediate' => array('Menengah', 'Intermediate', 'fa-fire', '#fef9c3', '#ca8a04'),
    'advanced' => array('Mahir', 'Advanced', 'fa-bolt', '#fce4ec', '#e11d48'),
);

$grads = array(
    'linear-gradient(135deg,#009688,#009688)',
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
    background: linear-gradient(135deg, #009688 0%, #0d9488 55%, #0ea5e9 130%);
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
    font-size: 0.88rem; background: transparent; color: #0D1830; min-width: 0;
}
.crs-searchbar button {
    background: #009688; color: #fff; border: none;
    border-radius: 100px; font-size: 0.8rem; font-weight: 700;
    padding: 0.55rem 1.15rem; white-space: nowrap; cursor: pointer;
    transition: all 0.2s;
}
.crs-searchbar button:hover { background: #00796B; }

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
    background: #E6EBEF; color: #57534e;
    text-decoration: none;
    border: 1.5px solid transparent;
    transition: all 0.2s;
    white-space: nowrap;
}
.crs-chip:hover { border-color: #d6d3d1; background: #E6EBEF; }
.crs-chip.active { background: #009688 !important; color: #fff !important; border-color: #009688 !important; }
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
    background: #E6EBEF;
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
    color: #0D1830; font-size: 0.68rem; font-weight: 800;
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
    font-size: 0.85rem; font-weight: 700; color: #0D1830;
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
    background: linear-gradient(135deg,#009688,#009688);
    color: #fff; font-size: 0.55rem; font-weight: 700;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
}
.crs-card-teacher span { white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
.crs-card-level {
    font-size: 0.6rem; font-weight: 700; color: #57534e;
    background: #E6EBEF; padding: 0.2rem 0.55rem; border-radius: 100px;
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
    background: #E6EBEF;
    display: flex; align-items: center; justify-content: center;
    color: #fff; font-size: 1.2rem; font-weight: 800;
    position: relative;
}
.crs-mob-thumb img { width: 100%; height: 100%; object-fit: cover; }
.crs-mob-body { flex: 1; min-width: 0; }
.crs-mob-title {
    font-size: 0.82rem; font-weight: 700; color: #0D1830;
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
    font-size: 0.7rem; font-weight: 800; color: #009688;
    margin-top: 0.2rem;
}
.crs-mob-price.free { color: #16a34a; }
.crs-mob-chev { color: #d6d3d1; font-size: 0.7rem; flex-shrink: 0; }

/* Panel header compact */
.crs-panel-head { display: flex; align-items: center; justify-content: space-between; gap: 0.75rem; margin-bottom: 1rem; }
.crs-panel-head h4 { font-size: 1.2rem; font-weight: 800; color: #0D1830; letter-spacing: -0.02em; margin: 0; }
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
            <a href="<?php echo base_url('courses/mine'); ?>" class="btn px-3 py-2 fw-semibold rounded-pill" style="background:#E0F2F1;color:#009688;font-size:0.72rem;">
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

        <!-- ===== AI REKOMENDASI KURSUS (MOBILE) ===== -->
        <style>
            #aiGoalMobile::placeholder { color: rgba(255,255,255,0.55) !important; opacity: 1; }
            #aiGoalMobile:-ms-input-placeholder { color: rgba(255,255,255,0.55) !important; }
            #aiGoalMobile::-ms-input-placeholder { color: rgba(255,255,255,0.55) !important; }
        </style>
        <div class="rounded-4 p-3 mb-3" style="border:1px solid #e7e5e4; border-radius:16px; background:linear-gradient(135deg,#0D1830 0%,#1e3a5f 55%,#0ea5e9 130%); position:relative; overflow:hidden;">
            <div style="position:absolute; top:-40px; right:-30px; width:140px; height:140px; border-radius:50%; background:rgba(251,191,36,0.12);"></div>
            <div class="d-flex align-items-center gap-2 mb-2 position-relative">
                <div class="d-flex align-items-center justify-content-center flex-shrink-0 rounded-3" style="width:38px; height:38px; background:rgba(255,255,255,0.12); border:1px solid rgba(255,255,255,0.18);">
                    <i class="fas fa-robot" style="color:#FBBF24; font-size:0.95rem;"></i>
                </div>
                <div>
                    <h6 class="fw-bold mb-0" style="color:#fff; font-size:0.85rem;"><?php echo t('AI Rekomendasi Kursus', 'AI Course Recommendation'); ?></h6>
                    <small style="color:rgba(230,235,239,0.75); font-size:0.68rem;"><?php echo t('Ceritakan tujuan belajarmu, AI pilihkan kursusnya', 'Tell us your learning goal, AI picks the course'); ?></small>
                </div>
            </div>
            <div class="position-relative">
                <textarea id="aiGoalMobile" class="form-control mb-2" rows="2" maxlength="200" placeholder="<?php echo t('Contoh: mau belajar bikin website dari nol...', 'e.g. want to learn web development from scratch...'); ?>" style="border-radius:10px; border-color:rgba(255,255,255,0.2); background:rgba(255,255,255,0.08); color:#fff; font-size:0.8rem; resize:vertical;"></textarea>
                <div class="d-flex align-items-center justify-content-between gap-2">
                    <small style="color:rgba(230,235,239,0.6); font-size:0.65rem;"><span id="aiGoalMobileCount">0</span>/200</small>
                    <button type="button" class="btn fw-bold rounded-pill px-3 flex-shrink-0 js-ai-course-mobile" style="background:#FBBF24; color:#0D1830; font-size:0.75rem; padding:0.4rem 0.9rem;">
                        <i class="fas fa-magic me-1" style="font-size:0.65rem;"></i> <?php echo t('Cari Kursus', 'Find Course'); ?>
                    </button>
                </div>
            </div>
            <div class="js-ai-course-result-mobile mt-3 position-relative" style="display:none;"></div>
            <div class="js-ai-course-loading-mobile text-center py-3 position-relative" style="display:none;">
                <div class="spinner-border spinner-border-sm me-2" style="color:#FBBF24;" role="status"></div>
                <span style="color:rgba(230,235,239,0.85); font-size:0.78rem;"><?php echo t('AI sedang mencari kursus yang tepat...', 'AI is finding the right course...'); ?></span>
            </div>
        </div>

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
            <a href="<?php echo base_url('courses/mine'); ?>" class="btn px-3 py-2 fw-semibold rounded-pill" style="background:#E0F2F1;color:#009688;font-size:0.8rem;">
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

        <!-- ===== AI REKOMENDASI KURSUS ===== -->
        <style>
            #aiGoal::placeholder { color: rgba(255,255,255,0.55) !important; opacity: 1; }
            #aiGoal:-ms-input-placeholder { color: rgba(255,255,255,0.55) !important; }
            #aiGoal::-ms-input-placeholder { color: rgba(255,255,255,0.55) !important; }
        </style>
        <div class="crs-ai-card rounded-4 p-3 mb-4" style="border:1px solid #e7e5e4; border-radius:16px; background:linear-gradient(135deg,#0D1830 0%,#1e3a5f 55%,#0ea5e9 130%); position:relative; overflow:hidden;">
            <div style="position:absolute; top:-40px; right:-30px; width:160px; height:160px; border-radius:50%; background:rgba(251,191,36,0.12);"></div>
            <div class="d-flex align-items-center gap-3 mb-2 position-relative">
                <div class="d-flex align-items-center justify-content-center flex-shrink-0 rounded-3" style="width:44px; height:44px; background:rgba(255,255,255,0.12); border:1px solid rgba(255,255,255,0.18);">
                    <i class="fas fa-robot" style="color:#FBBF24; font-size:1.1rem;"></i>
                </div>
                <div>
                    <h6 class="fw-bold mb-0" style="color:#fff; font-size:0.92rem;"><?php echo t('AI Rekomendasi Kursus', 'AI Course Recommendation'); ?></h6>
                    <small style="color:rgba(230,235,239,0.75); font-size:0.72rem;"><?php echo t('Ceritakan tujuan belajarmu, AI rekomendasikan kursus yang tepat', 'Tell us your learning goal, AI recommends the right course'); ?></small>
                </div>
            </div>
            <div class="position-relative">
                <textarea id="aiGoal" class="form-control mb-2" rows="2" maxlength="200" placeholder="<?php echo t('Contoh: Saya ingin belajar bikin website dari nol, target 3 bulan bisa kerja...', 'e.g. I want to learn web development from scratch, target to get a job in 3 months...'); ?>" style="border-radius:10px; border-color:rgba(255,255,255,0.2); background:rgba(255,255,255,0.08); color:#fff; font-size:0.82rem; resize:vertical;"></textarea>
                <div class="d-flex align-items-center justify-content-between gap-2">
                    <small style="color:rgba(230,235,239,0.6); font-size:0.68rem;"><span id="aiGoalCount">0</span>/200 <?php echo t('karakter', 'characters'); ?></small>
                    <button type="button" id="aiCourseBtn" class="btn fw-bold rounded-pill px-3 flex-shrink-0" style="background:#FBBF24; color:#0D1830; font-size:0.78rem; padding:0.45rem 1rem;">
                        <i class="fas fa-magic me-1" style="font-size:0.7rem;"></i> <?php echo t('Cari Kursus', 'Find Course'); ?>
                    </button>
                </div>
            </div>
            <div id="aiCourseResult" class="mt-3 position-relative" style="display:none;"></div>
            <div id="aiCourseLoading" class="text-center py-3 position-relative" style="display:none;">
                <div class="spinner-border spinner-border-sm me-2" style="color:#FBBF24;" role="status"></div>
                <span style="color:rgba(230,235,239,0.85); font-size:0.8rem;"><?php echo t('AI sedang menganalisis & mencari kursus yang tepat...', 'AI is analyzing & finding the right course...'); ?></span>
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
            <?php echo t('Menampilkan', 'Showing'); ?> <strong style="color:#0D1830;"><?php echo count($courses); ?></strong> <?php echo t('kelas', 'courses'); ?>
        </div>

        <!-- Grid -->
        <?php if (empty($courses)): ?>
            <div class="text-center py-5">
                <div style="font-size: 2.5rem; color: #d4d4d4; margin-bottom: 0.75rem;"><i class="fas fa-search"></i></div>
                <h5 class="fw-bold" style="color: #0D1830;"><?php echo t('Tidak Ada Hasil', 'No Results Found'); ?></h5>
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
                    $lv = $lvl_meta[$course->skill_level] ?? array('', '', 'fa-seedling', '#E6EBEF', '#57534e');
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
                $lv = $lvl_meta[$course->skill_level] ?? array('', '', 'fa-seedling', '#E6EBEF', '#57534e');
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

<script>
document.addEventListener('DOMContentLoaded', function () {
    var btn = document.getElementById('aiCourseBtn');
    var ta = document.getElementById('aiGoal');
    var result = document.getElementById('aiCourseResult');
    var loading = document.getElementById('aiCourseLoading');
    var count = document.getElementById('aiGoalCount');
    if (!btn || !ta || !result || !loading) return;

    function esc(s) {
        var d = document.createElement('div');
        d.textContent = s == null ? '' : s;
        return d.innerHTML;
    }

    if (ta && count) {
        ta.addEventListener('input', function () { count.textContent = ta.value.length; });
    }

    btn.addEventListener('click', function () {
        var goal = ta.value.trim();
        if (goal === '') {
            ta.focus();
            ta.style.borderColor = '#ff6b6b';
            setTimeout(function () { ta.style.borderColor = ''; }, 1500);
            return;
        }
        if (goal.length > 200) {
            ta.value = ta.value.substring(0, 200);
            if (count) count.textContent = 200;
        }
        btn.disabled = true;
        result.style.display = 'none';
        loading.style.display = '';
        var fd = new FormData();
        fd.append('goal', goal);

        fetch('<?php echo base_url('courses/ai-recommend'); ?>', {
            method: 'POST',
            body: fd,
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(function (r) { return r.json(); })
        .then(function (d) {
            loading.style.display = 'none';
            btn.disabled = false;
            if (d.status !== 'ok') {
                result.innerHTML = '<div class="alert alert-danger py-2 mb-0" style="font-size:0.8rem; border-radius:10px;">' + esc(d.message || 'Terjadi kesalahan.') + '</div>';
                result.style.display = '';
                return;
            }
            var html = '';
            if (d.reason) {
                html += '<div class="p-3 rounded-3 mb-2" style="background:rgba(255,255,255,0.1); border:1px solid rgba(255,255,255,0.15); color:#E6EBEF; font-size:0.8rem; line-height:1.6;">'
                    + '<i class="fas fa-quote-left me-1" style="color:#FBBF24;"></i> ' + esc(d.reason) + '</div>';
            }
            if (!d.courses || d.courses.length === 0) {
                html += '<div class="p-3 rounded-3" style="background:rgba(255,255,255,0.08); border:1px solid rgba(255,255,255,0.2); color:#E6EBEF; font-size:0.82rem; line-height:1.7;">'
                    + '<div class="d-flex align-items-center gap-2 mb-2">'
                    + '<span class="d-flex align-items-center justify-content-center rounded-circle flex-shrink-0" style="width:30px;height:30px;background:rgba(251,191,36,0.2);color:#FBBF24;font-size:0.8rem;"><i class="fas fa-robot"></i></span>'
                    + '<span class="fw-bold" style="color:#fff;font-size:0.8rem;"><?php echo t('Asisten BISATUNTAS', 'BISATUNTAS Assistant'); ?></span>'
                    + '</div>'
                    + '<p class="mb-0">' + esc(d.reason || '<?php echo t('Ceritakan lebih detail tujuan belajarmu agar AI bisa merekomendasikan kursus yang tepat.', 'Tell us more details so AI can recommend the right course.'); ?>') + '</p>'
                    + '</div>';
            } else {
                html += '<div class="d-flex flex-column gap-2">';
                d.courses.forEach(function (c) {
                    html += '<div class="d-flex align-items-center gap-2 p-2 rounded-3" style="background:rgba(255,255,255,0.08); border:1px solid rgba(255,255,255,0.14);">'
                        + '<a href="<?php echo base_url('courses/detail/'); ?>' + esc(c.slug) + '" class="d-flex align-items-center gap-2 text-decoration-none flex-fill min-w-0">'
                        + '<span class="d-flex align-items-center justify-content-center rounded-circle flex-shrink-0 fw-bold" style="width:36px;height:36px;background:linear-gradient(135deg,#0ea5e9,#009688);color:#fff;font-size:0.78rem;">' + esc((c.title || '?').charAt(0).toUpperCase()) + '</span>'
                        + '<span class="flex-fill min-w-0">'
                        + '<span class="d-block fw-bold text-truncate" style="color:#fff;font-size:0.8rem;">' + esc(c.title) + '</span>'
                        + '<span class="d-block text-truncate" style="color:rgba(230,235,239,0.7);font-size:0.7rem;">' + esc(c.content_type || '') + (c.price > 0 ? ' · Rp ' + Number(c.price).toLocaleString('id-ID') : ' · ' + '<?php echo t('Gratis', 'Free'); ?>') + '</span>'
                        + '</span>'
                        + '</a>'
                        + '<a href="<?php echo base_url('courses/buy/'); ?>' + esc(c.slug) + '" class="btn btn-sm fw-bold rounded-pill px-3 flex-shrink-0 text-decoration-none" style="background:#FBBF24; color:#0D1830; font-size:0.68rem; white-space:nowrap;">'
                        + '<i class="fas fa-shopping-cart me-1" style="font-size:0.6rem;"></i> <?php echo t('Beli', 'Buy'); ?>'
                        + '</a>'
                        + '</div>';
                });
                html += '</div>';
            }
            result.innerHTML = html;
            result.style.display = '';
        })
        .catch(function () {
            loading.style.display = 'none';
            btn.disabled = false;
            result.innerHTML = '<div class="alert alert-danger py-2 mb-0" style="font-size:0.8rem;"><?php echo t('Gagal terhubung ke AI. Coba lagi.', 'Failed to connect to AI. Try again.'); ?></div>';
            result.style.display = '';
        });
    });

    ta.addEventListener('keydown', function (e) {
        if (e.key === 'Enter' && (e.ctrlKey || e.metaKey)) { btn.click(); }
    });

    // ===== AI Course (MOBILE variant) =====
    var btnM = document.querySelector('.js-ai-course-mobile');
    var taM = document.getElementById('aiGoalMobile');
    var resultM = document.querySelector('.js-ai-course-result-mobile');
    var loadingM = document.querySelector('.js-ai-course-loading-mobile');
    var countM = document.getElementById('aiGoalMobileCount');
    if (btnM && taM && resultM && loadingM) {
        if (countM) taM.addEventListener('input', function () { countM.textContent = taM.value.length; });
        btnM.addEventListener('click', function () {
            var goal = taM.value.trim();
            if (goal === '') {
                taM.focus();
                taM.style.borderColor = '#ff6b6b';
                setTimeout(function () { taM.style.borderColor = ''; }, 1500);
                return;
            }
            if (goal.length > 200) {
                taM.value = taM.value.substring(0, 200);
                if (countM) countM.textContent = 200;
            }
            btnM.disabled = true;
            resultM.style.display = 'none';
            loadingM.style.display = '';
            var fd = new FormData();
            fd.append('goal', goal);
            fetch('<?php echo base_url('courses/ai-recommend'); ?>', {
                method: 'POST', body: fd, headers: { 'X-Requested-With': 'XMLHttpRequest' }
            })
            .then(function (r) { return r.json(); })
            .then(function (d) {
                loadingM.style.display = 'none';
                btnM.disabled = false;
                if (d.status !== 'ok') {
                    resultM.innerHTML = '<div class="alert alert-danger py-2 mb-0" style="font-size:0.78rem; border-radius:10px;">' + esc(d.message || 'Terjadi kesalahan.') + '</div>';
                    resultM.style.display = '';
                    return;
                }
                var html = '';
                if (d.reason) {
                    html += '<div class="p-3 rounded-3 mb-2" style="background:rgba(255,255,255,0.1); border:1px solid rgba(255,255,255,0.15); color:#E6EBEF; font-size:0.78rem; line-height:1.6;">'
                        + '<i class="fas fa-quote-left me-1" style="color:#FBBF24;"></i> ' + esc(d.reason) + '</div>';
                }
                if (!d.courses || d.courses.length === 0) {
                    html += '<div class="p-3 rounded-3" style="background:rgba(255,255,255,0.08); border:1px solid rgba(255,255,255,0.2); color:#E6EBEF; font-size:0.8rem; line-height:1.7;">'
                        + '<div class="d-flex align-items-center gap-2 mb-2">'
                        + '<span class="d-flex align-items-center justify-content-center rounded-circle flex-shrink-0" style="width:28px;height:28px;background:rgba(251,191,36,0.2);color:#FBBF24;font-size:0.75rem;"><i class="fas fa-robot"></i></span>'
                        + '<span class="fw-bold" style="color:#fff;font-size:0.78rem;"><?php echo t('Asisten BISATUNTAS', 'BISATUNTAS Assistant'); ?></span>'
                        + '</div>'
                        + '<p class="mb-0">' + esc(d.reason || '') + '</p>'
                        + '</div>';
                } else {
                    html += '<div class="d-flex flex-column gap-2">';
                    d.courses.forEach(function (c) {
                        html += '<div class="d-flex align-items-center gap-2 p-2 rounded-3" style="background:rgba(255,255,255,0.08); border:1px solid rgba(255,255,255,0.14);">'
                            + '<a href="<?php echo base_url('courses/detail/'); ?>' + esc(c.slug) + '" class="d-flex align-items-center gap-2 text-decoration-none flex-fill min-w-0">'
                            + '<span class="d-flex align-items-center justify-content-center rounded-circle flex-shrink-0 fw-bold" style="width:34px;height:34px;background:linear-gradient(135deg,#0ea5e9,#009688);color:#fff;font-size:0.75rem;">' + esc((c.title || '?').charAt(0).toUpperCase()) + '</span>'
                            + '<span class="flex-fill min-w-0">'
                            + '<span class="d-block fw-bold text-truncate" style="color:#fff;font-size:0.78rem;">' + esc(c.title) + '</span>'
                            + '<span class="d-block text-truncate" style="color:rgba(230,235,239,0.7);font-size:0.68rem;">' + esc(c.content_type || '') + (c.price > 0 ? ' · Rp ' + Number(c.price).toLocaleString('id-ID') : ' · ' + '<?php echo t('Gratis', 'Free'); ?>') + '</span>'
                            + '</span>'
                            + '</a>'
                            + '<a href="<?php echo base_url('courses/buy/'); ?>' + esc(c.slug) + '" class="btn btn-sm fw-bold rounded-pill px-3 flex-shrink-0 text-decoration-none" style="background:#FBBF24; color:#0D1830; font-size:0.66rem; white-space:nowrap;">'
                            + '<i class="fas fa-shopping-cart me-1" style="font-size:0.58rem;"></i> <?php echo t('Beli', 'Buy'); ?>'
                            + '</a>'
                            + '</div>';
                    });
                    html += '</div>';
                }
                resultM.innerHTML = html;
                resultM.style.display = '';
            })
            .catch(function () {
                loadingM.style.display = 'none';
                btnM.disabled = false;
                resultM.innerHTML = '<div class="alert alert-danger py-2 mb-0" style="font-size:0.78rem;"><?php echo t('Gagal terhubung ke AI. Coba lagi.', 'Failed to connect to AI. Try again.'); ?></div>';
                resultM.style.display = '';
            });
        });
    }
});
</script>
