<style>
.crs-header { border-bottom: 1px solid #e5e5e5; }
.crs-header-inner { padding-top: 2rem; padding-bottom: 1.5rem; max-width: 960px; }
.crs-search-wrap { background: #f8fafc; border-radius: 20px; padding: 0.5rem 0.75rem 0.75rem; max-width: 640px; margin: 1.5rem auto 0; border: 1px solid #f0f0f0; }
.crs-search-form { display: flex; flex-direction: column; gap: 0.5rem; }
@media (min-width: 768px) { .crs-search-form { flex-direction: row; gap: 0.5rem; } }
.crs-search-input-wrap { position: relative; flex: 1; }
.crs-search-icon { position: absolute; left: 16px; top: 50%; transform: translateY(-50%); color: #94a3b8; font-size: 0.9rem; z-index: 1; pointer-events: none; transition: color 0.2s; }
.crs-search-input-wrap:focus-within .crs-search-icon { color: #eab308; }
.crs-input { width: 100%; padding: 0.75rem 1rem 0.75rem 42px; border-radius: 14px; border: 2px solid #e5e5e5; font-size: 0.85rem; height: 48px; background: #fff; transition: all 0.2s; outline: none; }
.crs-input:focus { border-color: #eab308; box-shadow: 0 0 0 3px rgba(234,179,8,0.1); }
.crs-input::placeholder { color: #cbd5e1; }
.crs-btn-search { background: linear-gradient(135deg, #eab308 0%, #f59e0b 100%); color: #111827; border: none; border-radius: 14px; font-size: 0.85rem; height: 48px; padding: 0 1.5rem; font-weight: 700; white-space: nowrap; transition: all 0.2s; cursor: pointer; display: flex; align-items: center; gap: 0.5rem; justify-content: center; }
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
                array('#fef3c7','#d97706'),
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
        <div class="row row-cols-1 row-cols-md-2 g-3">
            <?php foreach ($courses as $i => $course): ?>
                <div class="col">
                    <a href="<?php echo base_url('courses/detail/' . $course->slug); ?>" class="text-decoration-none">
                        <div class="card h-100" style="border: 1px solid #e5e5e5; border-radius: 12px; transition: all 0.15s; display: flex; flex-direction: row; overflow: hidden;">
                            <!-- Thumbnail kiri -->
                            <div class="position-relative overflow-hidden" style="width: 140px; min-height: 140px; flex-shrink: 0;">
                                <img src="<?php echo base_url('uploads/courses/' . $course->thumbnail); ?>" onerror="this.src='https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=500&auto=format&fit=crop&q=60';" alt="" class="w-100 h-100" style="object-fit: cover;">
                                <div class="position-absolute top-0 start-0 m-2 d-flex gap-1 flex-wrap">
                                    <span class="px-2 py-1 rounded-pill fw-semibold" style="background: #111827; color: #fff; font-size: 0.65rem;"><?php echo content_type_label($course->content_type); ?></span>
                                </div>
                            </div>
                            <!-- Info kanan -->
                            <div class="card-body p-3 d-flex flex-column flex-grow-1">
                                <div class="d-flex align-items-center justify-content-between gap-2 mb-1">
                                    <span style="color: #a3a3a3; font-size: 0.7rem; font-weight: 500;">
                                        <i class="fas fa-folder-open me-1" style="font-size: 0.6rem;"></i><?php echo htmlspecialchars($course->category_name ?? ''); ?>
                                    </span>
                                    <?php if ($course->price > 0): ?>
                                        <span class="px-2 py-1 rounded-pill fw-bold" style="background: #eab308; color: #111827; font-size: 0.65rem;">Rp <?php echo number_format($course->price, 0, ',', '.'); ?></span>
                                    <?php else: ?>
                                        <span class="px-2 py-1 rounded-pill fw-semibold" style="background: #22c55e; color: #fff; font-size: 0.65rem;"><?php echo t('Gratis', 'Free'); ?></span>
                                    <?php endif; ?>
                                </div>
                                <h6 class="fw-bold mb-1 lh-sm" style="color: #111827; font-size: 0.875rem; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                                    <?php echo htmlspecialchars($course->title); ?>
                                </h6>
                                <p class="mb-2 flex-grow-1" style="color: #737373; font-size: 0.78rem; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; line-height: 1.5;">
                                    <?php echo htmlspecialchars($course->description); ?>
                                </p>
                                <div class="d-flex align-items-center justify-content-between pt-2" style="border-top: 1px solid #f0f0f0;">
                                    <span style="color: #a3a3a3; font-size: 0.7rem; font-weight: 500;">
                                        <i class="fas fa-user me-1" style="font-size: 0.6rem;"></i><?php echo htmlspecialchars($course->teacher_name); ?>
                                    </span>
                                    <span class="px-2 py-1 rounded-pill" style="background: #f5f5f5; color: #525252; font-size: 0.65rem; font-weight: 600;">
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