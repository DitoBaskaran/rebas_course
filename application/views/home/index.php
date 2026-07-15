<?php $site_settings = settings(); ?>

<!-- Hero Section — Dealls-style -->
<?php if (!isset($site_settings['hero_enabled']) || $site_settings['hero_enabled'] === '1'): ?>
<section class="bg-white text-dark position-relative overflow-hidden" style="padding-top: 2rem; padding-bottom: 0;">
    <!-- Yellow accent bar top -->
    <div class="w-100" style="height: 4px; background: linear-gradient(90deg, #eab308 0%, #f59e0b 50%, #fbbf24 100%);"></div>

    <div class="container" style="padding-top: 3rem; padding-bottom: 3rem;">
        <div class="text-center mb-4">
            <span class="d-inline-flex align-items-center gap-2 bg-dark text-white rounded-pill px-4 py-2 fw-semibold mb-4" style="font-size: 0.85rem;">
                <i class="fas fa-rocket fa-xs"></i>
                <?php echo t(setting('hero_badge', 'Platform Belajar Skill #1'), setting('hero_badge_en', '#1 Skill Learning Platform')); ?>
            </span>
        </div>

        <h1 class="display-3 fw-extrabold text-dark text-center mb-4 lh-sm" style="letter-spacing: -0.04em; font-size: 3.2rem;">
            <?php echo t(setting('hero_title', 'Cari Lowongan Kerja &<br>Kembangkan Skill <span class="text-primary" style="color: #eab308 !important;">Karirmu</span>'), setting('hero_title_en', 'Find Jobs &<br>Develop Your <span style="color: #eab308 !important;">Career Skills</span>')); ?>
        </h1>

        <p class="text-center mb-4 mx-auto" style="max-width: 600px; font-size: 1.05rem; line-height: 1.7; color: #525252;">
            <?php echo t(setting('hero_subtitle', 'Akses ribuan konten belajar terstruktur, mentoring langsung dengan ahli, dan sertifikat yang diakui industri. Semua dalam satu platform.'), setting('hero_subtitle_en', 'Access thousands of structured learning content, direct mentoring with experts, and industry-recognized certificates. All in one platform.')); ?>
        </p>

        <!-- Search/Filter Bar — Dealls-style -->
        <div class="d-flex justify-content-center mb-4">
            <div class="bg-white rounded-pill border d-inline-flex align-items-center px-2 py-1" style="border: 2px solid #e5e5e5; max-width: 500px; width: 100%;">
                <a href="<?php echo base_url(setting('hero_cta_link', 'courses')); ?>" class="btn rounded-pill px-4 py-2 fw-semibold" style="background: #eab308; color: #111827; font-size: 0.875rem;">
                    <i class="fas fa-book-open me-1"></i> <?php echo t(setting('hero_cta_text', 'Mulai Belajar'), setting('hero_cta_text_en', 'Start Learning')); ?>
                </a>
                <span class="text-secondary mx-2">|</span>
                <a href="<?php echo base_url(setting('hero_secondary_cta_link', 'learning_paths')); ?>" class="text-dark fw-semibold text-decoration-none" style="font-size: 0.875rem;">
                    <?php echo t(setting('hero_secondary_cta_text', 'Lihat Alur Belajar'), setting('hero_secondary_cta_text_en', 'View Learning Paths')); ?> <i class="fas fa-arrow-right ms-1"></i>
                </a>
            </div>
        </div>

        <!-- Stats — Dealls-style -->
        <div class="d-flex justify-content-center gap-4 flex-wrap text-center mb-4">
            <div class="d-flex align-items-center gap-2">
                <span class="fw-bold text-dark" style="font-size: 1.25rem;"><?php echo $total_courses_count; ?>+</span>
                <span class="text-secondary small fw-medium"><?php echo t('Konten Belajar', 'Learning Content'); ?></span>
            </div>
            <span class="text-secondary">•</span>
            <div class="d-flex align-items-center gap-2">
                <span class="fw-bold text-dark" style="font-size: 1.25rem;"><?php echo $total_teachers_count; ?>+</span>
                <span class="text-secondary small fw-medium"><?php echo t('Pengajar Ahli', 'Expert Teachers'); ?></span>
            </div>
            <span class="text-secondary">•</span>
            <div class="d-flex align-items-center gap-2">
                <span class="fw-bold text-dark" style="font-size: 1.25rem;"><?php echo $total_students_count; ?>+</span>
                <span class="text-secondary small fw-medium"><?php echo t('Siswa Aktif', 'Active Students'); ?></span>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- Partner Logos — Dealls-style -->
<section class="py-4 border-top border-bottom bg-white" style="border-color: #f0f0f0;">
    <div class="container-fluid px-0">
        <p class="text-center small fw-medium mb-3" style="color: #a3a3a3; letter-spacing: 0.02em;">
            <?php echo t('Telah digunakan dan dipercaya oleh', 'Trusted and used by'); ?> <strong class="text-dark"><?php echo $total_students_count; ?>+</strong> <?php echo t('siswa di seluruh Indonesia', 'students across Indonesia'); ?>
        </p>
        <div class="d-flex align-items-center gap-5 justify-content-center flex-wrap px-3 pb-2" style="opacity: 0.35; filter: grayscale(100%);">
            <div class="d-flex align-items-center gap-2"><i class="fab fa-google fs-4"></i><span class="fw-bold">Google</span></div>
            <div class="d-flex align-items-center gap-2"><i class="fab fa-microsoft fs-4"></i><span class="fw-bold">Microsoft</span></div>
            <div class="d-flex align-items-center gap-2"><i class="fab fa-github fs-4"></i><span class="fw-bold">GitHub</span></div>
            <div class="d-flex align-items-center gap-2 d-none d-md-flex"><i class="fab fa-aws fs-4"></i><span class="fw-bold">AWS</span></div>
        </div>
    </div>
</section>

<!-- Kategori / Layanan — Dealls-style horizontal pills -->
<?php if ((!isset($site_settings['home_show_categories']) || $site_settings['home_show_categories'] === '1') && !empty($categories)): ?>
<section class="bg-white py-5" style="border-bottom: 1px solid #f0f0f0;">
    <div class="container">
        <div class="text-center mb-4">
            <h2 class="fw-extrabold text-dark mb-2" style="font-size: 1.5rem; letter-spacing: -0.02em;">
                <?php echo t('Temukan Bidang yang Kamu Minati', 'Find Your Field of Interest'); ?>
            </h2>
            <p class="text-secondary mb-0" style="font-size: 0.95rem;">
                <?php echo t('Pilih kategori dan mulai perjalanan belajarmu', 'Choose a category and start your learning journey'); ?>
            </p>
        </div>

        <!-- Horizontal scroll pills — Dealls style -->
        <div class="d-flex gap-2 flex-nowrap overflow-auto pb-2 mb-4" style="scrollbar-width: none; -ms-overflow-style: none;">
            <?php foreach ($categories as $i => $cat): ?>
                <a href="<?php echo base_url('courses?category_id=' . $cat->id); ?>" class="btn btn-outline-dark rounded-pill px-4 py-2 fw-semibold flex-shrink-0 d-flex align-items-center gap-2" style="font-size: 0.825rem; border-color: #e5e5e5; white-space: nowrap;">
                    <i class="fas fa-<?php echo $cat->icon ?: 'folder-open'; ?>"></i>
                    <?php echo htmlspecialchars($cat->name); ?>
                </a>
            <?php endforeach; ?>
            <a href="<?php echo base_url('courses'); ?>" class="btn btn-dark rounded-pill px-4 py-2 fw-semibold flex-shrink-0 d-flex align-items-center gap-2" style="font-size: 0.825rem;">
                <i class="fas fa-arrow-right"></i>
                <?php echo t('Semua', 'All'); ?>
            </a>
        </div>

        <!-- Category Cards — Dealls style -->
        <div class="row row-cols-2 row-cols-md-3 row-cols-lg-6 g-3">
            <?php foreach (array_slice($categories, 0, 6) as $cat): ?>
                <div class="col">
                    <a href="<?php echo base_url('courses?category_id=' . $cat->id); ?>" class="card h-100 border text-decoration-none text-dark" style="border-color: #e5e5e5; border-radius: 12px; transition: all 0.15s ease;">
                        <div class="card-body p-3 text-center d-flex flex-column align-items-center gap-2">
                            <div class="rounded-3 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; background: #f5f5f5;">
                                <i class="fas fa-<?php echo $cat->icon ?: 'folder-open'; ?>" style="font-size: 1rem; color: #525252;"></i>
                            </div>
                            <span class="fw-semibold small" style="font-size: 0.8rem;"><?php echo htmlspecialchars($cat->name); ?></span>
                        </div>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- Unggulan / Featured — Dealls-style cards -->
<?php if ((!isset($site_settings['home_show_featured']) || $site_settings['home_show_featured'] === '1') && !empty($featured_courses)): ?>
<section class="bg-white py-5" style="border-bottom: 1px solid #f0f0f0;">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h3 class="fw-extrabold text-dark mb-1" style="font-size: 1.25rem; letter-spacing: -0.01em;">
                    <?php echo t('Konten Pilihan', 'Featured Content'); ?>
                </h3>
                <p class="text-secondary small mb-0" style="font-size: 0.85rem;"><?php echo t('Rekomendasi materi belajar terbaik untukmu', 'Recommended learning content for you'); ?></p>
            </div>
            <a href="<?php echo base_url('courses'); ?>" class="text-dark fw-semibold text-decoration-none small d-flex align-items-center gap-1">
                <?php echo t('Lihat Semua', 'View All'); ?> <i class="fas fa-chevron-right" style="font-size: 0.7rem;"></i>
            </a>
        </div>

        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-3">
            <?php foreach ($featured_courses as $course): ?>
                <div class="col">
                    <a href="<?php echo base_url('courses/detail/' . $course->slug); ?>" class="card h-100 border text-decoration-none text-dark" style="border-color: #e5e5e5; border-radius: 12px; transition: all 0.15s ease;">
                        <div class="position-relative overflow-hidden" style="aspect-ratio: 16/9; border-radius: 12px 12px 0 0;">
                            <img src="<?php echo base_url('uploads/courses/' . $course->thumbnail); ?>" onerror="this.src='https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=400&auto=format&fit=crop&q=60';" alt="" class="w-100 h-100 object-fit-cover">
                            <div class="position-absolute top-0 start-0 m-2">
                                <span class="badge rounded-pill px-2 py-1 fw-semibold small" style="background: #111827; color: #fff; font-size: 0.65rem;">
                                    <?php echo content_type_label($course->content_type); ?>
                                </span>
                            </div>
                            <?php if ($course->price > 0): ?>
                            <div class="position-absolute top-0 end-0 m-2">
                                <span class="badge rounded-pill px-2 py-1 fw-bold" style="background: #eab308; color: #111827; font-size: 0.7rem;">
                                    Rp <?php echo number_format($course->price, 0, ',', '.'); ?>
                                </span>
                            </div>
                            <?php endif; ?>
                        </div>
                        <div class="card-body p-3 d-flex flex-column">
                            <div class="d-flex align-items-center gap-2 mb-2">
                                <span class="small fw-medium" style="color: #737373; font-size: 0.75rem;">
                                    <i class="fas fa-folder-open me-1"></i><?php echo htmlspecialchars($course->category_name ?? ''); ?>
                                </span>
                                <span style="color: #e5e5e5;">•</span>
                                <span class="small fw-medium" style="color: #737373; font-size: 0.75rem;">
                                    <i class="fas fa-user me-1"></i><?php echo htmlspecialchars($course->teacher_name); ?>
                                </span>
                            </div>
                            <h6 class="fw-bold mb-2 lh-sm" style="font-size: 0.875rem; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                                <?php echo htmlspecialchars($course->title); ?>
                            </h6>
                            <div class="mt-auto pt-2 border-top" style="border-color: #f0f0f0 !important;">
                                <span class="fw-bold small" style="color: #111827; font-size: 0.85rem;">
                                    <?php echo $course->price > 0 ? 'Rp ' . number_format($course->price, 0, ',', '.') : '<span style="color: #22c55e;">Gratis</span>'; ?>
                                </span>
                            </div>
                        </div>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- Kenapa BISATUNTAS — Dealls-style -->
<section class="bg-white py-5" style="border-bottom: 1px solid #f0f0f0;">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-extrabold text-dark mb-2" style="font-size: 1.5rem; letter-spacing: -0.02em;">
                <?php echo t('Kenapa BISATUNTAS', 'Why BISATUNTAS'); ?>?
            </h2>
            <p class="text-secondary mb-0" style="font-size: 0.95rem; max-width: 600px; margin: 0 auto;">
                <?php echo t('Platform belajar yang peduli hasil karirmu', 'A learning platform that cares about your career results'); ?>
            </p>
        </div>

        <div class="row g-3">
            <div class="col-md-4">
                <div class="border rounded-3 p-4 h-100" style="border-color: #e5e5e5; border-radius: 12px;">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <div class="rounded-3 d-flex align-items-center justify-content-center" style="width: 44px; height: 44px; background: #fef3c7;">
                            <i class="fas fa-sitemap" style="color: #d97706;"></i>
                        </div>
                        <h6 class="fw-bold text-dark mb-0"><?php echo t('Kurikulum Terstruktur', 'Structured Curriculum'); ?></h6>
                    </div>
                    <p class="small mb-0" style="color: #525252; line-height: 1.6;">
                        <?php echo t('Alur belajar (Learning Paths) yang jelas dari pemula hingga mahir.', 'Clear learning paths from beginner to advanced.'); ?>
                    </p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="border rounded-3 p-4 h-100" style="border-color: #e5e5e5; border-radius: 12px;">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <div class="rounded-3 d-flex align-items-center justify-content-center" style="width: 44px; height: 44px; background: #ecfdf5;">
                            <i class="fas fa-user-tie" style="color: #059669;"></i>
                        </div>
                        <h6 class="fw-bold text-dark mb-0"><?php echo t('Mentor Praktisi', 'Practitioner Mentors'); ?></h6>
                    </div>
                    <p class="small mb-0" style="color: #525252; line-height: 1.6;">
                        <?php echo t('Belajar langsung dari mereka yang terjun di industri. Bimbingan langsung dari ahlinya.', 'Learn directly from industry practitioners. Direct guidance from experts.'); ?>
                    </p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="border rounded-3 p-4 h-100" style="border-color: #e5e5e5; border-radius: 12px;">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <div class="rounded-3 d-flex align-items-center justify-content-center" style="width: 44px; height: 44px; background: #eff6ff;">
                            <i class="fas fa-project-diagram" style="color: #2563eb;"></i>
                        </div>
                        <h6 class="fw-bold text-dark mb-0"><?php echo t('Project-Based', 'Project-Based'); ?></h6>
                    </div>
                    <p class="small mb-0" style="color: #525252; line-height: 1.6;">
                        <?php echo t('Bukan sekadar teori. Praktik langsung dan bangun portofolio untuk dilirik HRD.', 'Not just theory. Practice directly and build a portfolio for HR to see.'); ?>
                    </p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="border rounded-3 p-4 h-100" style="border-color: #e5e5e5; border-radius: 12px;">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <div class="rounded-3 d-flex align-items-center justify-content-center" style="width: 44px; height: 44px; background: #fdf2f8;">
                            <i class="fas fa-certificate" style="color: #db2777;"></i>
                        </div>
                        <h6 class="fw-bold text-dark mb-0"><?php echo t('Sertifikat Resmi', 'Official Certificate'); ?></h6>
                    </div>
                    <p class="small mb-0" style="color: #525252; line-height: 1.6;">
                        <?php echo t('Dapatkan sertifikat kelulusan yang diakui industri untuk boost karirmu.', 'Get an industry-recognized certificate to boost your career.'); ?>
                    </p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="border rounded-3 p-4 h-100" style="border-color: #e5e5e5; border-radius: 12px;">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <div class="rounded-3 d-flex align-items-center justify-content-center" style="width: 44px; height: 44px; background: #f5f5f5;">
                            <i class="fas fa-users" style="color: #525252;"></i>
                        </div>
                        <h6 class="fw-bold text-dark mb-0"><?php echo t('Komunitas Aktif', 'Active Community'); ?></h6>
                    </div>
                    <p class="small mb-0" style="color: #525252; line-height: 1.6;">
                        <?php echo t('Diskusikan masalah, bagikan insight, dan perluas networkingmu dengan komunitas.', 'Discuss problems, share insights, and expand your network.'); ?>
                    </p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="border rounded-3 p-4 h-100" style="border-color: #e5e5e5; border-radius: 12px;">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <div class="rounded-3 d-flex align-items-center justify-content-center" style="width: 44px; height: 44px; background: #fff7ed;">
                            <i class="fas fa-clock" style="color: #ea580c;"></i>
                        </div>
                        <h6 class="fw-bold text-dark mb-0"><?php echo t('Belajar Fleksibel', 'Flexible Learning'); ?></h6>
                    </div>
                    <p class="small mb-0" style="color: #525252; line-height: 1.6;">
                        <?php echo t('Akses materi kapan saja dan di mana saja. Belajar sesuai kecepatanmu sendiri.', 'Access content anytime, anywhere. Learn at your own pace.'); ?>
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Alur Belajar — Dealls-style -->
<section class="bg-white py-5" style="border-bottom: 1px solid #f0f0f0;">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-extrabold text-dark mb-2" style="font-size: 1.5rem; letter-spacing: -0.02em;">
                <?php echo t('3 Langkah Sederhana', '3 Simple Steps'); ?>
            </h2>
            <p class="text-secondary mb-0" style="font-size: 0.95rem;">
                <?php echo t('Mulai perjalanan belajarmu dalam hitungan menit', 'Start your learning journey in minutes'); ?>
            </p>
        </div>

        <div class="row g-4 justify-content-center">
            <div class="col-md-4">
                <div class="text-center px-3">
                    <div class="d-inline-flex align-items-center justify-content-center fw-bold mb-3" style="width: 48px; height: 48px; border-radius: 12px; background: #111827; color: #fff; font-size: 1.125rem;">1</div>
                    <h5 class="fw-bold text-dark mb-2"><?php echo t('Jelajahi Konten', 'Explore Content'); ?></h5>
                    <p class="small mb-0" style="color: #737373; line-height: 1.6;">
                        <?php echo t('Temukan kelas, materi, dan mentor sesuai minatmu.', 'Find classes, materials, and mentors based on your interests.'); ?>
                    </p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="text-center px-3">
                    <div class="d-inline-flex align-items-center justify-content-center fw-bold mb-3" style="width: 48px; height: 48px; border-radius: 12px; background: #eab308; color: #111827; font-size: 1.125rem;">2</div>
                    <h5 class="fw-bold text-dark mb-2"><?php echo t('Pilih Jadwal', 'Choose Schedule'); ?></h5>
                    <p class="small mb-0" style="color: #737373; line-height: 1.6;">
                        <?php echo t('Daftar dan pilih waktu belajar yang fleksibel sesuai kebutuhanmu.', 'Register and choose flexible study times that fit your needs.'); ?>
                    </p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="text-center px-3">
                    <div class="d-inline-flex align-items-center justify-content-center fw-bold mb-3" style="width: 48px; height: 48px; border-radius: 12px; background: #22c55e; color: #fff; font-size: 1.125rem;">3</div>
                    <h5 class="fw-bold text-dark mb-2"><?php echo t('Dapatkan Sertifikat', 'Get Certified'); ?></h5>
                    <p class="small mb-0" style="color: #737373; line-height: 1.6;">
                        <?php echo t('Selesaikan materi, kumpulkan tugas, dan dapatkan sertifikat resmi.', 'Complete materials, submit assignments, and get official certificates.'); ?>
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Konten Terbaru — Dealls-style -->
<?php if ((!isset($site_settings['home_show_recent']) || $site_settings['home_show_recent'] === '1') && !empty($recent_courses)): ?>
<section class="bg-white py-5" style="border-bottom: 1px solid #f0f0f0;">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h3 class="fw-extrabold text-dark mb-1" style="font-size: 1.25rem; letter-spacing: -0.01em;">
                    <?php echo t('Konten Terbaru', 'Latest Content'); ?>
                </h3>
                <p class="text-secondary small mb-0" style="font-size: 0.85rem;"><?php echo t('Materi terbaru untuk skill terbarumu', 'Latest content for your newest skills'); ?></p>
            </div>
            <a href="<?php echo base_url('courses'); ?>" class="text-dark fw-semibold text-decoration-none small d-flex align-items-center gap-1">
                <?php echo t('Lihat Semua', 'View All'); ?> <i class="fas fa-chevron-right" style="font-size: 0.7rem;"></i>
            </a>
        </div>

        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-3">
            <?php foreach(array_slice($recent_courses, 0, 6) as $course): ?>
                <div class="col">
                    <a href="<?php echo base_url('courses/detail/' . $course->slug); ?>" class="card h-100 border text-decoration-none text-dark" style="border-color: #e5e5e5; border-radius: 12px; transition: all 0.15s ease;">
                        <div class="position-relative overflow-hidden" style="aspect-ratio: 16/9; border-radius: 12px 12px 0 0;">
                            <img src="<?php echo base_url('uploads/courses/' . $course->thumbnail); ?>" onerror="this.src='https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=500&auto=format&fit=crop&q=60';" alt="" class="w-100 h-100 object-fit-cover">
                            <div class="position-absolute top-0 start-0 m-2">
                                <span class="badge rounded-pill px-2 py-1 fw-semibold small" style="background: #fff; color: #111827; border: 1px solid #e5e5e5; font-size: 0.65rem;">
                                    <?php echo content_type_label($course->content_type); ?>
                                </span>
                            </div>
                        </div>
                        <div class="card-body p-3 d-flex flex-column">
                            <div class="d-flex align-items-center gap-2 mb-2">
                                <span class="small fw-medium" style="color: #737373; font-size: 0.75rem;">
                                    <i class="fas fa-folder-open me-1"></i><?php echo htmlspecialchars($course->category_name ?? ''); ?>
                                </span>
                                <span style="color: #e5e5e5;">•</span>
                                <span class="small fw-medium" style="color: #737373; font-size: 0.75rem;">
                                    <i class="fas fa-user me-1"></i><?php echo htmlspecialchars($course->teacher_name); ?>
                                </span>
                            </div>
                            <h6 class="fw-bold mb-2 lh-sm" style="font-size: 0.875rem; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                                <?php echo htmlspecialchars($course->title); ?>
                            </h6>
                            <p class="small mb-3 flex-grow-1" style="color: #737373; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; line-height: 1.5; font-size: 0.8rem;">
                                <?php echo htmlspecialchars($course->description); ?>
                            </p>
                            <div class="d-flex gap-2 mb-3 flex-wrap">
                                <span class="small fw-medium px-2 py-1 rounded-pill" style="background: #f5f5f5; color: #525252; font-size: 0.7rem;">
                                    <i class="fas fa-layer-group me-1"></i><?php echo skill_level_label($course->skill_level); ?>
                                </span>
                            </div>
                            <div class="mt-auto pt-2 border-top d-flex align-items-center justify-content-between" style="border-color: #f0f0f0 !important;">
                                <span class="fw-bold small" style="color: #111827; font-size: 0.85rem;">
                                    <?php echo $course->price > 0 ? 'Rp ' . number_format($course->price, 0, ',', '.') : '<span style="color: #22c55e;">Gratis</span>'; ?>
                                </span>
                                <span class="fw-semibold small" style="color: #eab308; font-size: 0.8rem;">
                                    <?php echo t('Pelajari', 'Learn'); ?> <i class="fas fa-chevron-right" style="font-size: 0.6rem;"></i>
                                </span>
                            </div>
                        </div>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- Testimoni — Dealls-style -->
<section class="bg-white py-5" style="border-bottom: 1px solid #f0f0f0;">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-extrabold text-dark mb-2" style="font-size: 1.5rem; letter-spacing: -0.02em;">
                <?php echo t('Apa Kata Mereka', 'What They Say'); ?>
            </h2>
            <p class="text-secondary mb-0" style="font-size: 0.95rem;">
                <?php echo t('Review dari siswa yang sudah bergabung', 'Reviews from students who have joined'); ?>
            </p>
        </div>

        <div class="row g-3 justify-content-center">
            <div class="col-md-4">
                <div class="border rounded-3 p-4 h-100" style="border-color: #e5e5e5; border-radius: 12px;">
                    <div class="d-flex gap-1 mb-3">
                        <?php for ($i = 0; $i < 5; $i++): ?>
                            <i class="fas fa-star" style="color: #eab308; font-size: 0.8rem;"></i>
                        <?php endfor; ?>
                    </div>
                    <p class="small text-dark mb-3" style="line-height: 1.6; font-size: 0.85rem;">
                        "Materinya sangat terstruktur dan mudah dipahami. Dari yang awalnya tidak bisa coding, sekarang sudah bisa membuat website sendiri. Thanks BISATUNTAS!"
                    </p>
                    <div class="d-flex align-items-center gap-3">
                        <div class="rounded-circle d-flex align-items-center justify-content-center fw-bold" style="width: 40px; height: 40px; background: #f5f5f5; color: #525252; font-size: 0.75rem;">RK</div>
                        <div>
                            <h6 class="fw-bold mb-0 small">Rina Kusuma</h6>
                            <p class="small mb-0" style="color: #a3a3a3; font-size: 0.75rem;">Siswa Web Development</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="border rounded-3 p-4 h-100" style="border-color: #e5e5e5; border-radius: 12px;">
                    <div class="d-flex gap-1 mb-3">
                        <?php for ($i = 0; $i < 5; $i++): ?>
                            <i class="fas fa-star" style="color: #eab308; font-size: 0.8rem;"></i>
                        <?php endfor; ?>
                    </div>
                    <p class="small text-dark mb-3" style="line-height: 1.6; font-size: 0.85rem;">
                        "Sesi mentoring benar-benar membantu memahami konsep yang sulit. Mentor sangat sabar dan memberikan feedback yang detail untuk setiap tugas."
                    </p>
                    <div class="d-flex align-items-center gap-3">
                        <div class="rounded-circle d-flex align-items-center justify-content-center fw-bold" style="width: 40px; height: 40px; background: #f5f5f5; color: #525252; font-size: 0.75rem;">DP</div>
                        <div>
                            <h6 class="fw-bold mb-0 small">Dimas Pratama</h6>
                            <p class="small mb-0" style="color: #a3a3a3; font-size: 0.75rem;">Siswa Program Mentorship</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="border rounded-3 p-4 h-100" style="border-color: #e5e5e5; border-radius: 12px;">
                    <div class="d-flex gap-1 mb-3">
                        <?php for ($i = 0; $i < 5; $i++): ?>
                            <i class="fas fa-star" style="color: #eab308; font-size: 0.8rem;"></i>
                        <?php endfor; ?>
                    </div>
                    <p class="small text-dark mb-3" style="line-height: 1.6; font-size: 0.85rem;">
                        "Sertifikat dari BISATUNTAS membantu saya mendapat promosi di kantor. Materi yang diajarkan sangat relevan dengan kebutuhan industri saat ini."
                    </p>
                    <div class="d-flex align-items-center gap-3">
                        <div class="rounded-circle d-flex align-items-center justify-content-center fw-bold" style="width: 40px; height: 40px; background: #f5f5f5; color: #525252; font-size: 0.75rem;">SI</div>
                        <div>
                            <h6 class="fw-bold mb-0 small">Sari Indah</h6>
                            <p class="small mb-0" style="color: #a3a3a3; font-size: 0.75rem;">Siswa Digital Marketing</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA — Dealls-style -->
<?php if (!isset($site_settings['home_show_cta']) || $site_settings['home_show_cta'] === '1'): ?>
<section class="bg-white py-5" style="border-bottom: 1px solid #f0f0f0;">
    <div class="container">
        <div class="text-center p-5 rounded-3" style="background: #111827;">
            <h2 class="fw-extrabold text-white mb-3" style="font-size: 1.75rem; letter-spacing: -0.02em;">
                <?php echo t(setting('home_cta_title', 'Siap Menguasai Skill Baru?'), setting('home_cta_title_en', 'Ready to Master a New Skill?')); ?>
            </h2>
            <p class="mb-4 mx-auto" style="color: #a3a3a3; font-size: 0.95rem; max-width: 500px;">
                <?php echo t(setting('home_cta_subtitle', 'Daftar gratis sekarang dan mulai perjalanan belajarmu bersama ribuan siswa lainnya.'), setting('home_cta_subtitle_en', 'Register for free and start your learning journey with thousands of other students.')); ?>
            </p>
            <a href="<?php echo base_url(setting('home_cta_button_link', 'auth/register')); ?>" class="btn px-5 py-3 fw-bold rounded-pill d-inline-flex align-items-center gap-2" style="background: #eab308; color: #111827; font-size: 1rem;">
                <i class="fas fa-user-plus"></i>
                <?php echo t(setting('home_cta_button_text', 'Daftar Gratis Sekarang'), setting('home_cta_button_text_en', 'Register Free Now')); ?>
            </a>
        </div>
    </div>
</section>
<?php endif; ?>
