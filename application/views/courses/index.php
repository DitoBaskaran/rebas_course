<!-- Header -->
<div style="border-bottom: 1px solid #e5e5e5;">
    <div class="container" style="padding-top: 2rem; padding-bottom: 1.5rem; max-width: 960px;">
        <div class="text-center mb-3">
            <h1 class="fw-extrabold mb-2" style="font-size: 1.4rem; letter-spacing: -0.02em; color: #111827;">
                <?php echo t('Temukan Materi Belajar', 'Discover Learning Content'); ?>
            </h1>
            <p class="mb-0 mx-auto" style="color: #737373; font-size: 0.9rem; max-width: 500px;">
                <?php echo t('Pilih dari ribuan konten belajar terstruktur untuk menguasai skill baru', 'Choose from thousands of structured content to master new skills'); ?>
            </p>
        </div>

        <!-- Search + Filter Row -->
        <form action="<?php echo base_url('courses'); ?>" method="GET" class="d-flex flex-column flex-md-row gap-2" style="max-width: 600px; margin: 0 auto;">
            <div class="flex-fill position-relative">
                <i class="fas fa-search position-absolute" style="left: 14px; top: 50%; transform: translateY(-50%); color: #a3a3a3; font-size: 0.8rem; z-index: 1;"></i>
                <input type="text" name="search" class="form-control" value="<?php echo htmlspecialchars($search_query ?? ''); ?>" placeholder="<?php echo t('Cari kelas, materi, atau mentor...', 'Search classes, content, or mentors...'); ?>" style="padding-left: 36px; border-radius: 100px; border-color: #e5e5e5; font-size: 0.85rem; height: 44px;">
            </div>
            <button type="submit" class="btn px-4 fw-semibold" style="background: #111827; color: #fff; border-radius: 100px; font-size: 0.85rem; height: 44px; white-space: nowrap;">
                <i class="fas fa-search me-1"></i> <?php echo t('Cari', 'Search'); ?>
            </button>
            <a href="<?php echo base_url('courses'); ?>" class="btn px-3 fw-semibold" style="background: #f5f5f5; color: #525252; border-radius: 100px; font-size: 0.85rem; height: 44px; white-space: nowrap;">
                <i class="fas fa-times"></i>
            </a>
        </form>

        <!-- Horizontal Filter Pills -->
        <div class="d-flex flex-wrap gap-2 justify-content-center mt-3">
            <div class="d-flex gap-1 flex-wrap justify-content-center">
                <a href="<?php echo base_url('courses'); ?>" class="px-3 py-2 rounded-pill fw-semibold text-decoration-none" style="font-size: 0.78rem; background: <?php echo !$selected_type && !$selected_level && !$selected_category ? '#111827' : '#f5f5f5'; ?>; color: <?php echo !$selected_type && !$selected_level && !$selected_category ? '#fff' : '#525252'; ?>;"><?php echo t('Semua', 'All'); ?></a>
                <?php foreach ($content_types as $ct): ?>
                    <a href="<?php echo base_url('courses?type=' . $ct . ($selected_level ? '&skill_level=' . $selected_level : '') . ($selected_category ? '&category_id=' . $selected_category : '')); ?>" class="px-3 py-2 rounded-pill fw-semibold text-decoration-none" style="font-size: 0.78rem; background: <?php echo $selected_type === $ct ? '#111827' : '#f5f5f5'; ?>; color: <?php echo $selected_type === $ct ? '#fff' : '#525252'; ?>;"><?php echo content_type_label($ct); ?></a>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="d-flex flex-wrap gap-2 justify-content-center mt-2">
            <a href="<?php echo base_url('courses?skill_level=beginner' . ($selected_type ? '&type=' . $selected_type : '') . ($selected_category ? '&category_id=' . $selected_category : '')); ?>" class="px-3 py-1 rounded-pill fw-semibold text-decoration-none" style="font-size: 0.72rem; background: <?php echo $selected_level === 'beginner' ? '#111827' : '#f5f5f5'; ?>; color: <?php echo $selected_level === 'beginner' ? '#fff' : '#525252'; ?>;"><?php echo t('Pemula', 'Beginner'); ?></a>
            <a href="<?php echo base_url('courses?skill_level=intermediate' . ($selected_type ? '&type=' . $selected_type : '') . ($selected_category ? '&category_id=' . $selected_category : '')); ?>" class="px-3 py-1 rounded-pill fw-semibold text-decoration-none" style="font-size: 0.72rem; background: <?php echo $selected_level === 'intermediate' ? '#111827' : '#f5f5f5'; ?>; color: <?php echo $selected_level === 'intermediate' ? '#fff' : '#525252'; ?>;"><?php echo t('Menengah', 'Intermediate'); ?></a>
            <a href="<?php echo base_url('courses?skill_level=advanced' . ($selected_type ? '&type=' . $selected_type : '') . ($selected_category ? '&category_id=' . $selected_category : '')); ?>" class="px-3 py-1 rounded-pill fw-semibold text-decoration-none" style="font-size: 0.72rem; background: <?php echo $selected_level === 'advanced' ? '#111827' : '#f5f5f5'; ?>; color: <?php echo $selected_level === 'advanced' ? '#fff' : '#525252'; ?>;"><?php echo t('Mahir', 'Advanced'); ?></a>
            <span style="color: #d4d4d4; font-size: 0.7rem;">|</span>
            <?php foreach ($categories as $cat): ?>
                <a href="<?php echo base_url('courses?category_id=' . $cat->id . ($selected_type ? '&type=' . $selected_type : '') . ($selected_level ? '&skill_level=' . $selected_level : '')); ?>" class="px-3 py-1 rounded-pill fw-semibold text-decoration-none" style="font-size: 0.72rem; background: <?php echo $selected_category == $cat->id ? '#111827' : '#f5f5f5'; ?>; color: <?php echo $selected_category == $cat->id ? '#fff' : '#525252'; ?>;"><?php echo htmlspecialchars($cat->name); ?></a>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<!-- Results -->
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
                        <div class="card h-100" style="border: 1px solid #e5e5e5; border-radius: 12px; transition: all 0.15s;">
                            <div class="position-relative overflow-hidden" style="aspect-ratio: 16/9; border-radius: 12px 12px 0 0;">
                                <img src="<?php echo base_url('uploads/courses/' . $course->thumbnail); ?>" onerror="this.src='https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=500&auto=format&fit=crop&q=60';" alt="" class="w-100 h-100" style="object-fit: cover;">
                                <div class="position-absolute top-0 start-0 m-2 d-flex gap-1 flex-wrap">
                                    <span class="px-2 py-1 rounded-pill fw-semibold" style="background: #111827; color: #fff; font-size: 0.65rem;"><?php echo content_type_label($course->content_type); ?></span>
                                    <?php if ($course->price > 0): ?>
                                        <span class="px-2 py-1 rounded-pill fw-bold" style="background: #eab308; color: #111827; font-size: 0.65rem;">Rp <?php echo number_format($course->price, 0, ',', '.'); ?></span>
                                    <?php else: ?>
                                        <span class="px-2 py-1 rounded-pill fw-semibold" style="background: #22c55e; color: #fff; font-size: 0.65rem;"><?php echo t('Gratis', 'Free'); ?></span>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="card-body p-3 d-flex flex-column">
                                <div class="d-flex align-items-center justify-content-between gap-2 mb-1">
                                    <span style="color: #a3a3a3; font-size: 0.7rem; font-weight: 500;">
                                        <i class="fas fa-folder-open me-1" style="font-size: 0.6rem;"></i><?php echo htmlspecialchars($course->category_name ?? ''); ?>
                                    </span>
                                    <span style="color: #a3a3a3; font-size: 0.7rem; font-weight: 500;">
                                        <i class="fas fa-user me-1" style="font-size: 0.6rem;"></i><?php echo htmlspecialchars($course->teacher_name); ?>
                                    </span>
                                </div>
                                <h6 class="fw-bold mb-1 lh-sm" style="color: #111827; font-size: 0.875rem; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                                    <?php echo htmlspecialchars($course->title); ?>
                                </h6>
                                <p class="mb-2 flex-grow-1" style="color: #737373; font-size: 0.78rem; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; line-height: 1.5;">
                                    <?php echo htmlspecialchars($course->description); ?>
                                </p>
                                <div class="d-flex align-items-center justify-content-between pt-2" style="border-top: 1px solid #f0f0f0;">
                                    <span class="fw-semibold" style="color: #eab308; font-size: 0.8rem;">
                                        <?php echo t('Lihat Detail', 'View Detail'); ?> <i class="fas fa-chevron-right" style="font-size: 0.55rem;"></i>
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
