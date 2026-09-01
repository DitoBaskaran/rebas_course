<?php $_mob_crs_panel = $this->session->userdata('logged_in'); ?>

<?php if ($_mob_crs_panel): ?>
<!-- ============ PANEL STUDENT (desktop + mobile app-style) ============ -->
<div class="container-fluid py-4" style="padding-top: 0px !important; max-width: 1100px;">

    <!-- Mobile App-Style -->
    <div class="dashboard-mobile-only">
        <!-- Header -->
        <div class="d-flex align-items-center justify-content-between mb-3">
            <div>
                <h5 class="fw-extrabold mb-0" style="color: #1c1917; font-size: 1.15rem; letter-spacing: -0.02em;">
                    <?php echo t('Tambah Kelas', 'Add Course'); ?>
                </h5>
                <small style="color: #78716c; font-size: 0.72rem;"><?php echo t('Jelajahi dan daftar kelas baru', 'Explore and enroll in new courses'); ?></small>
            </div>
            <a href="<?php echo base_url('courses/mine'); ?>" class="btn px-3 py-2 fw-semibold rounded-pill" style="background:#ecfdf5; color:#059669; font-size:0.72rem;">
                <i class="fas fa-book-open me-1" style="font-size:0.65rem;"></i> <?php echo t('Kelas Saya', 'My Courses'); ?>
            </a>
        </div>

        <!-- Search -->
        <form action="<?php echo base_url('courses'); ?>" method="GET" class="d-flex gap-2 mb-3">
            <div class="flex-fill position-relative">
                <i class="fas fa-search position-absolute" style="left: 14px; top: 50%; transform: translateY(-50%); color: #a3a3a3; font-size: 0.8rem;"></i>
                <input type="text" name="search" class="form-control" value="<?php echo htmlspecialchars($search_query ?? ''); ?>" placeholder="<?php echo t('Cari kelas...', 'Search courses...'); ?>" style="padding-left: 36px; border-radius: 100px; border-color: #e7e5e4; font-size: 0.82rem; height: 42px; background: #fff;">
            </div>
            <button type="submit" class="btn px-3 fw-semibold flex-shrink-0" style="background: #059669; color: #fff; border-radius: 100px; font-size: 0.82rem; height: 42px;">
                <i class="fas fa-search"></i>
            </button>
        </form>

        <!-- Category chips (horizontal scroll) -->
        <div class="d-flex gap-2 overflow-auto pb-1 mb-2" style="scrollbar-width: none; -ms-overflow-style: none;">
            <a href="<?php echo base_url('courses'); ?>" class="px-3 py-2 rounded-pill fw-semibold text-decoration-none flex-shrink-0" style="font-size: 0.72rem; background: <?php echo !$selected_category && !$selected_type && !$selected_level ? '#059669' : '#f5f5f4'; ?>; color: <?php echo !$selected_category && !$selected_type && !$selected_level ? '#fff' : '#57534e'; ?>;">
                <?php echo t('Semua', 'All'); ?>
            </a>
            <?php foreach ($categories as $cat): ?>
                <a href="<?php echo base_url('courses?category_id=' . $cat->id); ?>" class="px-3 py-2 rounded-pill fw-semibold text-decoration-none flex-shrink-0" style="font-size: 0.72rem; background: <?php echo $selected_category == $cat->id ? '#059669' : '#f5f5f4'; ?>; color: <?php echo $selected_category == $cat->id ? '#fff' : '#57534e'; ?>;">
                    <?php echo htmlspecialchars($cat->name); ?>
                </a>
            <?php endforeach; ?>
        </div>

        <!-- Course cards (app-style list) -->
        <?php if (empty($courses)): ?>
            <div class="mob-empty">
                <i class="fas fa-search"></i>
                <p><?php echo t('Tidak ada kelas ditemukan.', 'No courses found.'); ?></p>
            </div>
        <?php else: ?>
            <div class="d-flex flex-column gap-3">
                <?php foreach ($courses as $i => $course): ?>
                    <?php
                    $crs_grads = array(
                        'linear-gradient(135deg,#059669,#10b981)',
                        'linear-gradient(135deg,#2563eb,#38bdf8)',
                        'linear-gradient(135deg,#c026d3,#f472b6)',
                        'linear-gradient(135deg,#ea580c,#fbbf24)',
                        'linear-gradient(135deg,#0d9488,#2dd4bf)',
                        'linear-gradient(135deg,#7c3aed,#a78bfa)'
                    );
                    $gi = $i % 6;
                    $crs_thumb_ok = !empty($course->thumbnail)
                        && file_exists(FCPATH . 'uploads/courses/' . $course->thumbnail)
                        && $course->thumbnail !== 'default_course.png';
                    ?>
                    <a href="<?php echo base_url('courses/detail/' . $course->slug); ?>" class="mob-course-card text-decoration-none w-100" style="width:auto;">
                        <div class="d-flex align-items-center gap-3">
                            <div class="mob-course-thumb" style="background: <?php echo $crs_grads[$gi]; ?>; width: 80px; height: 60px; margin-bottom: 0; flex-shrink: 0; border-radius: 12px; font-size: 1.2rem;">
                                <?php if ($crs_thumb_ok): ?>
                                    <img src="<?php echo base_url('uploads/courses/' . $course->thumbnail); ?>" alt="">
                                <?php else: ?>
                                    <?php echo strtoupper(substr(trim($course->title), 0, 1)); ?>
                                <?php endif; ?>
                            </div>
                            <div class="min-w-0 flex-fill">
                                <div class="fw-bold text-truncate" style="color: #1c1917; font-size: 0.85rem;"><?php echo htmlspecialchars($course->title); ?></div>
                                <div class="d-flex align-items-center gap-1 mt-1">
                                    <span class="px-2 py-0 rounded-pill fw-semibold" style="background: #f5f5f4; color: #57534e; font-size: 0.6rem;"><?php echo content_type_label($course->content_type); ?></span>
                                    <?php if ($course->price > 0): ?>
                                        <span class="px-2 py-0 rounded-pill fw-bold" style="background: #ecfdf5; color: #059669; font-size: 0.6rem;">Rp <?php echo number_format($course->price, 0, ',', '.'); ?></span>
                                    <?php else: ?>
                                        <span class="px-2 py-0 rounded-pill fw-semibold" style="background: #dcfce7; color: #16a34a; font-size: 0.6rem;"><?php echo t('Gratis', 'Free'); ?></span>
                                    <?php endif; ?>
                                </div>
                                <div style="color: #a8a29e; font-size: 0.65rem; margin-top: 2px;"><i class="fas fa-user me-1"></i><?php echo htmlspecialchars($course->teacher_name); ?></div>
                            </div>
                            <span class="mob-chev"><i class="fas fa-chevron-right"></i></span>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>

    <!-- Desktop Panel Version -->
    <div class="dashboard-desktop-only">
        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
            <div>
                <h4 class="fw-extrabold mb-1" style="color: #1c1917; letter-spacing: -0.02em;">
                    <?php echo t('Tambah Kelas', 'Add Course'); ?>
                </h4>
                <p style="color: #78716c; font-size: 0.85rem; margin-bottom: 0;">
                    <?php echo t('Jelajahi dan daftar kelas baru.', 'Explore and enroll in new courses.'); ?>
                </p>
            </div>
            <a href="<?php echo base_url('courses/mine'); ?>" class="btn px-3 py-2 fw-semibold rounded-pill" style="background:#ecfdf5; color:#059669; font-size:0.8rem;">
                <i class="fas fa-book-open me-1"></i> <?php echo t('Kelas Saya', 'My Courses'); ?>
            </a>
        </div>

        <!-- Search -->
        <form action="<?php echo base_url('courses'); ?>" method="GET" class="d-flex gap-2 mb-3">
            <div class="flex-fill position-relative">
                <i class="fas fa-search position-absolute" style="left: 14px; top: 50%; transform: translateY(-50%); color: #a3a3a3; font-size: 0.8rem;"></i>
                <input type="text" name="search" class="form-control" value="<?php echo htmlspecialchars($search_query ?? ''); ?>" placeholder="<?php echo t('Cari kelas, materi, atau mentor...', 'Search classes, content, or mentors...'); ?>" style="padding-left: 36px; border-radius: 100px; border-color: #e7e5e4; font-size: 0.85rem; height: 42px; background: #fff;">
            </div>
            <button type="submit" class="btn px-4 fw-semibold flex-shrink-0" style="background: #059669; color: #fff; border-radius: 100px; font-size: 0.85rem; height: 42px;">
                <i class="fas fa-search"></i>
            </button>
        </form>

        <!-- Category chips -->
        <div class="d-flex gap-2 overflow-auto pb-1 mb-3" style="scrollbar-width: none; -ms-overflow-style: none;">
            <a href="<?php echo base_url('courses'); ?>" class="px-3 py-2 rounded-pill fw-semibold text-decoration-none flex-shrink-0" style="font-size: 0.75rem; background: <?php echo !$selected_category && !$selected_type && !$selected_level ? '#059669' : '#f5f5f4'; ?>; color: <?php echo !$selected_category && !$selected_type && !$selected_level ? '#fff' : '#57534e'; ?>;">
                <?php echo t('Semua', 'All'); ?>
            </a>
            <?php foreach ($categories as $cat): ?>
                <a href="<?php echo base_url('courses?category_id=' . $cat->id); ?>" class="px-3 py-2 rounded-pill fw-semibold text-decoration-none flex-shrink-0" style="font-size: 0.75rem; background: <?php echo $selected_category == $cat->id ? '#059669' : '#f5f5f4'; ?>; color: <?php echo $selected_category == $cat->id ? '#fff' : '#57534e'; ?>;">
                    <?php echo htmlspecialchars($cat->name); ?>
                </a>
            <?php endforeach; ?>
        </div>

        <!-- Course grid -->
        <?php if (empty($courses)): ?>
            <div class="text-center py-5">
                <div style="font-size: 2.5rem; color: #d4d4d4; margin-bottom: 0.75rem;"><i class="fas fa-search"></i></div>
                <h5 class="fw-bold" style="color: #1c1917;"><?php echo t('Tidak Ada Hasil', 'No Results Found'); ?></h5>
                <p style="color: #78716c; font-size: 0.85rem;"><?php echo t('Coba ubah filter atau kata kunci pencarian Anda.', 'Try changing your filters or search keywords.'); ?></p>
            </div>
        <?php else: ?>
            <div class="row g-3">
                <?php foreach ($courses as $i => $course): ?>
                    <?php
                    $crs_grads2 = array(
                        'linear-gradient(135deg,#059669,#10b981)',
                        'linear-gradient(135deg,#2563eb,#38bdf8)',
                        'linear-gradient(135deg,#c026d3,#f472b6)',
                        'linear-gradient(135deg,#ea580c,#fbbf24)',
                        'linear-gradient(135deg,#0d9488,#2dd4bf)',
                        'linear-gradient(135deg,#7c3aed,#a78bfa)'
                    );
                    $gi2 = $i % 6;
                    $crs_thumb_ok2 = !empty($course->thumbnail)
                        && file_exists(FCPATH . 'uploads/courses/' . $course->thumbnail)
                        && $course->thumbnail !== 'default_course.png';
                    ?>
                    <div class="col-md-6 col-lg-4">
                        <a href="<?php echo base_url('courses/detail/' . $course->slug); ?>" class="text-decoration-none">
                            <div class="border rounded-3 h-100" style="border-color: #e7e5e4; border-radius: 14px; background: #fff; overflow: hidden; transition: all 0.15s;">
                                <div class="position-relative overflow-hidden" style="height: 140px; background: <?php echo $crs_grads2[$gi2]; ?>;">
                                    <?php if ($crs_thumb_ok2): ?>
                                        <img src="<?php echo base_url('uploads/courses/' . $course->thumbnail); ?>" alt="" class="w-100 h-100" style="object-fit: cover;">
                                    <?php else: ?>
                                        <div class="w-100 h-100 d-flex align-items-center justify-content-center" style="color: #fff; font-size: 2.4rem; font-weight: 800;">
                                            <?php echo strtoupper(substr(trim($course->title), 0, 1)); ?>
                                        </div>
                                    <?php endif; ?>
                                    <div class="position-absolute top-0 start-0 m-2 d-flex gap-1 flex-wrap">
                                        <span class="px-2 py-1 rounded-pill fw-semibold" style="background: rgba(17,24,39,0.85); color: #fff; font-size: 0.6rem;"><?php echo content_type_label($course->content_type); ?></span>
                                    </div>
                                </div>
                                <div class="p-3">
                                    <div class="d-flex align-items-center justify-content-between gap-2 mb-1">
                                        <span style="color: #a8a29e; font-size: 0.68rem; font-weight: 500;">
                                            <i class="fas fa-folder-open me-1" style="font-size: 0.55rem;"></i><?php echo htmlspecialchars($course->category_name ?? ''); ?>
                                        </span>
                                        <?php if ($course->price > 0): ?>
                                            <span class="px-2 py-1 rounded-pill fw-bold" style="background: #ecfdf5; color: #059669; font-size: 0.62rem;">Rp <?php echo number_format($course->price, 0, ',', '.'); ?></span>
                                        <?php else: ?>
                                            <span class="px-2 py-1 rounded-pill fw-semibold" style="background: #dcfce7; color: #16a34a; font-size: 0.62rem;"><?php echo t('Gratis', 'Free'); ?></span>
                                        <?php endif; ?>
                                    </div>
                                    <h6 class="fw-bold mb-1 lh-sm" style="color: #1c1917; font-size: 0.85rem; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                                        <?php echo htmlspecialchars($course->title); ?>
                                    </h6>
                                    <p class="mb-2" style="color: #78716c; font-size: 0.75rem; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; line-height: 1.5;">
                                        <?php echo htmlspecialchars($course->description); ?>
                                    </p>
                                    <div class="d-flex align-items-center justify-content-between pt-2" style="border-top: 1px solid #f0eeeb;">
                                        <span style="color: #a8a29e; font-size: 0.68rem; font-weight: 500;">
                                            <i class="fas fa-user me-1" style="font-size: 0.55rem;"></i><?php echo htmlspecialchars($course->teacher_name); ?>
                                        </span>
                                        <span class="px-2 py-1 rounded-pill" style="background: #f5f5f4; color: #57534e; font-size: 0.62rem; font-weight: 600;">
                                            <?php echo skill_level_label($course->skill_level); ?>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php else: ?>
<!-- ============ HALAMAN PUBLIK (guest) ============ -->
<style>
.crs-header { border-bottom: 1px solid #e5e5e5; }
.crs-header-inner { padding-top: 2rem; padding-bottom: 1.5rem; max-width: 960px; }
.crs-search-wrap { background: #f8fafc; border-radius: 20px; padding: 0.5rem 0.75rem 0.75rem; max-width: 640px; margin: 1.5rem auto 0; border: 1px solid #f0f0f0; }
.crs-search-form { display: flex; flex-direction: column; gap: 0.5rem; }
@media (min-width: 768px) { .crs-search-form { flex-direction: row; gap: 0.5rem; } }
.crs-search-input-wrap { position: relative; flex: 1; }
.crs-search-icon { position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: #94a3b8; font-size: 0.85rem; z-index: 1; pointer-events: none; transition: color 0.2s; }
.crs-search-input-wrap:focus-within .crs-search-icon { color: #059669; }
.crs-input { width: 100%; padding: 0.75rem 1rem 0.75rem 46px; border-radius: 14px; border: 2px solid #e5e5e5; font-size: 0.85rem; height: 48px; background: #fff; transition: all 0.2s; outline: none; }
.crs-input:focus { border-color: #059669; box-shadow: 0 0 0 3px rgba(234,179,8,0.1); }
.crs-input::placeholder { color: #cbd5e1; }
.crs-btn-search { background: #059669; color: #111827; border: none; border-radius: 14px; font-size: 0.85rem; height: 48px; padding: 0 1.5rem; font-weight: 700; white-space: nowrap; transition: all 0.2s; cursor: pointer; display: flex; align-items: center; gap: 0.5rem; justify-content: center; }
.crs-btn-search:hover { transform: translateY(-1px); box-shadow: 0 4px 12px rgba(234,179,8,0.3); }
.crs-btn-search:active { transform: translateY(0); }
.crs-scroll { display: flex; gap: 0.75rem; overflow-x: auto; padding-bottom: 0.5rem; scrollbar-width: none; -ms-overflow-style: none; }
.crs-scroll::-webkit-scrollbar { display: none; }
.crs-scroll + .crs-scroll { margin-top: 0.75rem; }
.crs-card { width: 85px; padding: 0.7rem 0.25rem 0.6rem; border-radius: 14px; text-decoration: none; display: flex; flex-direction: column; align-items: center; gap: 0.4rem; font-weight: 600; flex-shrink: 0; transition: all 0.25s cubic-bezier(.4,0,.2,1); border: 2px solid transparent; background: #f9fafb; }
.crs-card:hover { transform: translateY(-4px) scale(1.02); box-shadow: 0 8px 20px rgba(0,0,0,0.08); }
.crs-card:active { transform: translateY(-2px) scale(0.98); }
.crs-card-icon-wrap { width: 40px; height: 40px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.1rem; transition: all 0.25s cubic-bezier(.4,0,.2,1); }
.crs-card:hover .crs-card-icon-wrap { transform: scale(1.1) rotate(-4deg); }
.crs-card-label { font-size: 0.65rem; font-weight: 700; letter-spacing: 0.01em; text-align: center; line-height: 1.2; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 100%; }
.crs-section-title { font-size: 0.7rem; font-weight: 700; color: #a3a3a3; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.5rem; }
.crs-filters { margin-top: 1rem; }
</style>

<div class="crs-header">
    <div class="container crs-header-inner">
        <div class="text-center mb-3">
            <h1 class="fw-extrabold mb-2" style="font-size: 1.4rem; letter-spacing: -0.02em; color: #111827;">
                <?php echo t('Temukan Materi Belajar', 'Discover Learning Content'); ?>
            </h1>
            <p class="mb-0 mx-auto" style="color: #737373; font-size: 0.9rem; max-width: 500px;">
                <?php echo t('Pilih dari ribuan konten belajar terstruktur untuk menguasai skill baru', 'Choose from thousands of structured content to master new skills'); ?>
            </p>
        </div>

        <div class="crs-search-wrap">
            <form action="<?php echo base_url('courses'); ?>" method="GET" class="crs-search-form">
                <div class="crs-search-input-wrap">
                    <i class="fas fa-search crs-search-icon"></i>
                    <input type="text" name="search" class="crs-input" value="<?php echo htmlspecialchars($search_query ?? ''); ?>" placeholder="<?php echo t('Cari kelas, materi, atau mentor...', 'Search classes, content, or mentors...'); ?>">
                </div>
                <button type="submit" class="crs-btn-search">
                    <i class="fas fa-search"></i> <?php echo t('Cari', 'Search'); ?>
                </button>
            </form>
        </div>

        <?php
            $is_all = !$selected_type && !$selected_level && !$selected_category;
            $query_type = $selected_type ? 'type=' . $selected_type : '';
            $query_level = $selected_level ? 'skill_level=' . $selected_level : '';
            $query_cat = $selected_category ? 'category_id=' . $selected_category : '';
            $query_parts = array_filter(array($query_type, $query_level, $query_cat));
            $query_all = $query_parts ? '?' . implode('&', $query_parts) : '';
            $cat_colors = array(
                array('#f0fdfa','#d97706'),
                array('#dbeafe','#2563eb'),
                array('#fce7f3','#db2777'),
                array('#dcfce7','#16a34a'),
                array('#ede9fe','#7c3aed'),
            );
        ?>

        <div class="crs-filters">
            <div class="crs-section-title"><?php echo t('Tipe Konten', 'Content Type'); ?></div>
            <div class="crs-scroll">
                <a href="<?php echo base_url('courses'); ?>" class="crs-card" style="<?php echo $is_all ? 'background:#111827;' : ''; ?>">
                    <div class="crs-card-icon-wrap" style="background: <?php echo $is_all ? 'rgba(255,255,255,0.15)' : '#e5e7eb'; ?>;"><i class="fas fa-th-large" style="color: <?php echo $is_all ? '#fff' : '#6b7280'; ?>;"></i></div>
                    <span class="crs-card-label" style="color: <?php echo $is_all ? '#fff' : '#374151'; ?>;"><?php echo t('Semua', 'All'); ?></span>
                </a>
                <?php $ct_icons = array('course'=>'fa-book-open','seminar'=>'fa-video','learning_path'=>'fa-route','mentoring'=>'fa-users','subscription'=>'fa-crown'); $ci = 0; foreach ($content_types as $ct): $cc = $cat_colors[$ci % 5]; $act = ($selected_type == $ct); ?>
                <a href="<?php echo base_url('courses?type=' . $ct . ($query_level ? '&' . $query_level : '') . ($query_cat ? '&' . $query_cat : '')); ?>" class="crs-card" style="<?php echo $act ? 'background:' . $cc[0] : ''; ?>">
                    <div class="crs-card-icon-wrap" style="background: <?php echo $act ? $cc[0] : '#f3f4f6'; ?>;"><i class="fas <?php echo $ct_icons[$ct] ?? 'fa-folder-open'; ?>" style="color: <?php echo $act ? $cc[1] : '#6b7280'; ?>;"></i></div>
                    <span class="crs-card-label" style="color: <?php echo $act ? '#111827' : '#374151'; ?>;"><?php echo content_type_label($ct); ?></span>
                </a>
                <?php $ci++; endforeach; ?>
            </div>

            <div class="crs-section-title mt-3"><?php echo t('Level Skill', 'Skill Level'); ?></div>
            <?php $lvl_cards = array('beginner'=>array('Pemula','Beginner','fa-seedling','#dcfce7','#16a34a'),'intermediate'=>array('Menengah','Intermediate','fa-fire','#fef9c3','#ca8a04'),'advanced'=>array('Mahir','Advanced','fa-bolt','#fce4ec','#e11d48')); ?>
            <div class="crs-scroll">
                <?php foreach ($lvl_cards as $lk => $lv): $is_lvl = ($selected_level === $lk); ?>
                <a href="<?php echo base_url('courses' . ($query_all ? $query_all . '&' : '?') . 'skill_level=' . $lk); ?>" class="crs-card" style="<?php echo $is_lvl ? 'background:' . $lv[3] : ''; ?>">
                    <div class="crs-card-icon-wrap" style="background: <?php echo $is_lvl ? $lv[3] : '#f3f4f6'; ?>;"><i class="fas <?php echo $lv[2]; ?>" style="color: <?php echo $is_lvl ? $lv[4] : '#6b7280'; ?>;"></i></div>
                    <span class="crs-card-label" style="color: <?php echo $is_lvl ? '#111827' : '#374151'; ?>;"><?php echo t($lv[0], $lv[1]); ?></span>
                </a>
                <?php endforeach; ?>
            </div>

            <div class="crs-section-title mt-3"><?php echo t('Kategori', 'Category'); ?></div>
            <div class="crs-scroll">
                <a href="<?php echo base_url('courses'); ?>" class="crs-card" style="<?php echo !$selected_category ? 'background:#111827;' : ''; ?>">
                    <div class="crs-card-icon-wrap" style="background: <?php echo !$selected_category ? 'rgba(255,255,255,0.15)' : '#e5e7eb'; ?>;"><i class="fas fa-th-large" style="color: <?php echo !$selected_category ? '#fff' : '#6b7280'; ?>;"></i></div>
                    <span class="crs-card-label" style="color: <?php echo !$selected_category ? '#fff' : '#374151'; ?>;"><?php echo t('Semua', 'All'); ?></span>
                </a>
                <?php $ci = 0; foreach ($categories as $cat): $cc = $cat_colors[$ci % 5]; $act = ($selected_category == $cat->id); ?>
                <a href="<?php echo base_url('courses?category_id=' . $cat->id . ($query_type ? '&' . $query_type : '') . ($query_level ? '&' . $query_level : '')); ?>" class="crs-card" style="<?php echo $act ? 'background:' . $cc[0] : ''; ?>">
                    <div class="crs-card-icon-wrap" style="background: <?php echo $act ? $cc[0] : '#f3f4f6'; ?>;"><i class="fas fa-<?php echo htmlspecialchars($cat->icon ?: 'folder-open'); ?>" style="color: <?php echo $act ? $cc[1] : '#6b7280'; ?>;"></i></div>
                    <span class="crs-card-label" style="color: <?php echo $act ? '#111827' : '#374151'; ?>;"><?php echo htmlspecialchars($cat->name); ?></span>
                </a>
                <?php $ci++; endforeach; ?>
            </div>
        </div>
    </div>
</div>

<div class="container" style="max-width: 960px; padding-top: 1.5rem; padding-bottom: 3rem;">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <span style="color: #737373; font-size: 0.85rem; font-weight: 500;">
            <?php echo t('Menampilkan', 'Showing'); ?> <strong style="color: #111827;"><?php echo count($courses); ?></strong> <?php echo t('hasil', 'results'); ?>
        </span>
    </div>

    <?php if (empty($courses)): ?>
        <div class="text-center py-5">
            <div style="font-size: 2.5rem; color: #d4d4d4; margin-bottom: 0.75rem;">
                <i class="fas fa-search"></i>
            </div>
            <h5 class="fw-bold" style="color: #111827;"><?php echo t('Tidak Ada Hasil', 'No Results Found'); ?></h5>
            <p style="color: #737373; font-size: 0.85rem;"><?php echo t('Coba ubah filter atau kata kunci pencarian Anda.', 'Try changing your filters or search keywords.'); ?></p>
        </div>
    <?php else: ?>
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-3">
            <?php foreach ($courses as $i => $course): ?>
                <div class="col">
                    <a href="<?php echo base_url('courses/detail/' . $course->slug); ?>" class="text-decoration-none h-100 d-block">
                        <div class="card h-100 crs-card-v" style="border: 1px solid #e5e5e5; border-radius: 14px; transition: all 0.2s; overflow: hidden; background: #fff;">
                            <!-- Thumbnail atas -->
                            <div class="position-relative overflow-hidden crs-card-thumb">
                                <img src="<?php echo base_url('uploads/courses/' . $course->thumbnail); ?>" onerror="this.parentNode.style.background='linear-gradient(135deg,#059669,#10b981)';this.style.display='none';this.parentNode.innerHTML='<span class=crs-card-thumb-init>'+'<?php echo strtoupper(substr(trim($course->title),0,1)); ?>'+'</span>';" alt="" class="w-100 h-100" style="object-fit: cover;">
                                <div class="position-absolute top-0 start-0 m-2 d-flex gap-1 flex-wrap">
                                    <span class="px-2 py-1 rounded-pill fw-semibold" style="background: rgba(17,24,39,0.85); color: #fff; font-size: 0.62rem;"><?php echo content_type_label($course->content_type); ?></span>
                                </div>
                            </div>
                            <!-- Info bawah -->
                            <div class="card-body p-3 d-flex flex-column">
                                <div class="d-flex align-items-center justify-content-between gap-2 mb-1">
                                    <span style="color: #a3a3a3; font-size: 0.68rem; font-weight: 500; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                        <i class="fas fa-folder-open me-1" style="font-size: 0.55rem;"></i><?php echo htmlspecialchars($course->category_name ?? ''); ?>
                                    </span>
                                    <?php if ($course->price > 0): ?>
                                        <span class="px-2 py-1 rounded-pill fw-bold flex-shrink-0" style="background: #059669; color: #fff; font-size: 0.62rem;">Rp <?php echo number_format($course->price, 0, ',', '.'); ?></span>
                                    <?php else: ?>
                                        <span class="px-2 py-1 rounded-pill fw-semibold flex-shrink-0" style="background: #22c55e; color: #fff; font-size: 0.62rem;"><?php echo t('Gratis', 'Free'); ?></span>
                                    <?php endif; ?>
                                </div>
                                <h6 class="fw-bold mb-1 lh-sm crs-card-title" style="color: #111827; font-size: 0.875rem; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                                    <?php echo htmlspecialchars($course->title); ?>
                                </h6>
                                <p class="mb-2 crs-card-desc" style="color: #737373; font-size: 0.76rem; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; line-height: 1.5;">
                                    <?php echo htmlspecialchars($course->description); ?>
                                </p>
                                <div class="d-flex align-items-center justify-content-between pt-2 mt-auto" style="border-top: 1px solid #f0f0f0;">
                                    <span style="color: #a3a3a3; font-size: 0.68rem; font-weight: 500; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 60%;">
                                        <i class="fas fa-user me-1" style="font-size: 0.55rem;"></i><?php echo htmlspecialchars($course->teacher_name); ?>
                                    </span>
                                    <span class="px-2 py-1 rounded-pill flex-shrink-0" style="background: #f5f5f5; color: #525252; font-size: 0.62rem; font-weight: 600;">
                                        <?php echo skill_level_label($course->skill_level); ?>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<style>
.crs-card-v { box-shadow: 0 1px 4px rgba(0,0,0,0.04); }
.crs-card-v:hover { transform: translateY(-3px); box-shadow: 0 8px 24px rgba(0,0,0,0.10); border-color: #d6d3d1; }
.crs-card-thumb {
    aspect-ratio: 16/9;
    min-height: 0;
    background: #f5f5f5;
}
.crs-card-thumb img { display: block; }
.crs-card-thumb-init {
    position: absolute; inset: 0;
    display: flex; align-items: center; justify-content: center;
    font-size: 2.2rem; font-weight: 800; color: #fff;
}
.crs-card-title { min-height: 2.5em; }
.crs-card-desc { min-height: 2.4em; }
@media (max-width: 767px) {
    .crs-card-thumb { aspect-ratio: 16/9; }
}
</style>
<?php endif; ?>
