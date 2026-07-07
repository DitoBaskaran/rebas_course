<section class="hero-section bg-gradient-light border-bottom">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8 text-center animate-fade-in-up">
                <h1 class="display-5 fw-bold text-dark mb-3"><?php echo t('Temukan Materi Belajar', 'Discover Learning Content'); ?></h1>
                <p class="text-secondary mb-0 mx-auto" style="font-size: 1.05rem; max-width: 600px;"><?php echo t('Pilih dari ribuan konten belajar terstruktur yang siap membantumu menguasai skill baru.', 'Choose from thousands of structured learning content ready to help you master new skills.'); ?></p>
            </div>
        </div>
    </div>
</section>

<div class="container py-5">
    <div class="row g-4">
        <!-- Filters Sidebar -->
        <div class="col-lg-3 animate-fade-in-up">
            <div class="filter-card border-0 shadow-sm rounded-3 p-4 sticky-top" style="top: 100px;">
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <h6 class="fw-bold text-dark mb-0"><i class="fas fa-sliders-h me-2 text-secondary"></i><?php echo t('Filter', 'Filters'); ?></h6>
                    <a href="<?php echo base_url('courses'); ?>" class="text-secondary small text-decoration-none fw-medium hover-text-primary"><?php echo t('Reset', 'Reset'); ?></a>
                </div>
                <form action="<?php echo base_url('courses'); ?>" method="GET">
                    <div class="mb-4">
                        <label class="form-label text-dark fw-medium small"><?php echo t('Cari', 'Search'); ?></label>
                        <input type="text" name="search" class="form-control form-control-sm" value="<?php echo htmlspecialchars($search_query ?? ''); ?>" placeholder="<?php echo t('Kata kunci...', 'Keyword...'); ?>">
                    </div>
                    <div class="mb-4">
                        <label class="form-label text-dark fw-medium small"><?php echo t('Tipe Konten', 'Content Type'); ?></label>
                        <select name="type" class="form-select form-select-sm">
                            <option value=""><?php echo t('Semua', 'All'); ?></option>
                            <?php foreach ($content_types as $ct): ?>
                                <option value="<?php echo $ct; ?>" <?php echo $selected_type === $ct ? 'selected' : ''; ?>><?php echo content_type_label($ct); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label class="form-label text-dark fw-medium small"><?php echo t('Level Skill', 'Skill Level'); ?></label>
                        <select name="skill_level" class="form-select form-select-sm">
                            <option value=""><?php echo t('Semua', 'All'); ?></option>
                            <option value="beginner" <?php echo $selected_level === 'beginner' ? 'selected' : ''; ?>><?php echo t('Pemula', 'Beginner'); ?></option>
                            <option value="intermediate" <?php echo $selected_level === 'intermediate' ? 'selected' : ''; ?>><?php echo t('Menengah', 'Intermediate'); ?></option>
                            <option value="advanced" <?php echo $selected_level === 'advanced' ? 'selected' : ''; ?>><?php echo t('Mahir', 'Advanced'); ?></option>
                            <option value="all_levels" <?php echo $selected_level === 'all_levels' ? 'selected' : ''; ?>><?php echo t('Semua Level', 'All Levels'); ?></option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label class="form-label text-dark fw-medium small"><?php echo t('Kategori', 'Category'); ?></label>
                        <select name="category_id" class="form-select form-select-sm">
                            <option value=""><?php echo t('Semua', 'All'); ?></option>
                            <?php foreach ($categories as $cat): ?>
                                <option value="<?php echo $cat->id; ?>" <?php echo $selected_category == $cat->id ? 'selected' : ''; ?>><?php echo htmlspecialchars($cat->name); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary w-100 py-2 fw-semibold"><?php echo t('Terapkan Filter', 'Apply Filters'); ?></button>
                </form>
            </div>
        </div>

        <!-- Results -->
        <div class="col-lg-9 animate-fade-in-up stagger-1">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 class="fw-bold text-dark mb-0">
                    <span class="text-primary fw-bold"><?php echo count($courses); ?></span> <?php echo t('konten ditemukan', 'contents found'); ?>
                </h5>
            </div>

            <div class="row row-cols-1 row-cols-md-2 g-4">
                <?php if (empty($courses)): ?>
                    <div class="col-12">
                        <div class="text-center py-5">
                            <div class="icon-64 bg-light rounded-circle mx-auto mb-4 d-flex align-items-center justify-content-center">
                                <i class="fas fa-search fs-3 text-secondary"></i>
                            </div>
                            <h5 class="fw-bold text-dark"><?php echo t('Tidak Ada Hasil', 'No Results Found'); ?></h5>
                            <p class="text-secondary small mb-0"><?php echo t('Tidak ada konten yang cocok dengan filter Anda. Coba kata kunci lain.', 'No content matches your filters. Try different keywords.'); ?></p>
                        </div>
                    </div>
                <?php else: ?>
                    <?php foreach ($courses as $i => $course): ?>
                        <div class="col animate-fade-in-up stagger-<?php echo min($i + 1, 8); ?>">
                            <a href="<?php echo base_url('courses/detail/' . $course->id); ?>" class="text-decoration-none">
                                <div class="card course-card h-100 border-0 shadow-sm rounded-3 overflow-hidden">
                                    <div class="position-relative overflow-hidden" style="aspect-ratio: 16/9;">
                                        <img src="<?php echo base_url('uploads/courses/' . $course->thumbnail); ?>" onerror="this.src='https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=500&auto=format&fit=crop&q=60';" alt="" class="w-100 h-100 object-fit-cover">
                                        <div class="position-absolute top-0 start-0 m-3 d-flex gap-2 flex-wrap">
                                            <span class="badge bg-dark text-white rounded-pill px-3 py-1 fw-medium"><?php echo content_type_label($course->content_type); ?></span>
                                        </div>
                                    </div>
                                    <div class="card-body p-4 d-flex flex-column">
                                        <div class="d-flex align-items-center justify-content-between gap-2 mb-2">
                                            <span class="text-secondary small fw-medium"><i class="fas fa-folder-open me-1"></i><?php echo htmlspecialchars($course->category_name ?? ''); ?></span>
                                            <span class="text-secondary small fw-medium"><i class="fas fa-user me-1"></i><?php echo htmlspecialchars($course->teacher_name); ?></span>
                                        </div>
                                        <h6 class="fw-bold text-dark mb-2 lh-sm"><?php echo htmlspecialchars($course->title); ?></h6>
                                        <p class="text-secondary small mb-3 flex-grow-1 text-truncate-2"><?php echo htmlspecialchars($course->description); ?></p>
                                        
                                        <div class="d-flex gap-2 mb-3">
                                            <span class="badge bg-light text-secondary border rounded-pill px-3 py-1 small fw-medium"><?php echo skill_level_label($course->skill_level); ?></span>
                                        </div>
                                        
                                        <div class="mt-auto pt-3 border-top d-flex align-items-center justify-content-between">
                                            <span class="fs-5 fw-bold text-dark"><?php echo $course->price > 0 ? 'Rp ' . number_format($course->price, 0, ',', '.') : '<span class="text-success">' . t('Gratis', 'Free') . '</span>'; ?></span>
                                            <span class="btn btn-sm btn-outline-dark px-3 fw-semibold"><?php echo t('Detail', 'Detail'); ?></span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
