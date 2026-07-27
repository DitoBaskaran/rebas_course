<?php $site_settings = settings(); ?>



<?php if (!isset($site_settings['hero_enabled']) || $site_settings['hero_enabled'] === '1'): ?>
<section class="fe-hero">
    <div class="container fe-hero-inner">
        <div class="text-center">
            <span class="fe-badge"><?php echo t(setting('hero_badge', 'Platform Belajar Skill #1'), setting('hero_badge_en', '#1 Skill Learning Platform')); ?></span>

            <h1 class="fe-hero-title">
                <?php echo t(setting('hero_title', 'Kembangkan Skill<br>dan <span>Karirmu</span>'), setting('hero_title_en', 'Develop Your<br>Skills & <span>Career</span>')); ?>
            </h1>

            <p class="fe-hero-sub">
                <?php echo t(setting('hero_subtitle', 'Akses ribuan konten belajar terstruktur, mentoring langsung dengan ahli, dan sertifikat yang diakui industri.'), setting('hero_subtitle_en', 'Access thousands of structured learning content, direct mentoring with experts, and industry-recognized certificates.')); ?>
            </p>

            <div class="fe-hero-cta">
                <a href="<?php echo base_url(setting('hero_cta_link', 'courses')); ?>" class="fe-btn fe-btn-primary">
                    <i class="fas fa-book-open" style="font-size:0.75rem;"></i>
                    <?php echo t(setting('hero_cta_text', 'Mulai Belajar'), setting('hero_cta_text_en', 'Start Learning')); ?>
                </a>
                <a href="<?php echo base_url(setting('hero_secondary_cta_link', 'learning_paths')); ?>" class="fe-btn fe-btn-outline">
                    <?php echo t(setting('hero_secondary_cta_text', 'Lihat Alur Belajar'), setting('hero_secondary_cta_text_en', 'View Learning Paths')); ?>
                    <i class="fas fa-arrow-right ms-1" style="font-size:0.65rem;"></i>
                </a>
            </div>

            <div class="fe-hero-stats">
                <span><strong><?php echo $total_courses_count; ?>+</strong> <?php echo t('Konten Belajar', 'Learning Content'); ?></span>
                <span class="fe-hero-stat-dot"></span>
                <span><strong><?php echo $total_teachers_count; ?>+</strong> <?php echo t('Pengajar Ahli', 'Expert Teachers'); ?></span>
                <span class="fe-hero-stat-dot"></span>
                <span><strong><?php echo $total_students_count; ?>+</strong> <?php echo t('Siswa Aktif', 'Active Students'); ?></span>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>

<section class="fe-section fe-section-alt">
    <div class="container">
        <p class="fe-partner-text"><?php echo t('Dipercaya oleh', 'Trusted by'); ?> <strong><?php echo $total_students_count; ?>+</strong> <?php echo t('siswa di Indonesia', 'students across Indonesia'); ?></p>
        <div class="fe-partner-logos">
            <span><i class="fab fa-google"></i> Google</span>
            <span><i class="fab fa-microsoft"></i> Microsoft</span>
            <span><i class="fab fa-github"></i> GitHub</span>
            <span class="d-none d-md-flex"><i class="fab fa-aws"></i> AWS</span>
        </div>
    </div>
</section>

<?php if ((!isset($site_settings['home_show_categories']) || $site_settings['home_show_categories'] === '1') && !empty($categories)): ?>
<section class="fe-section fe-section-alt">
    <div class="container">
        <div class="fe-section-header">
            <div>
                <h2 class="fe-section-title"><?php echo t('Temukan Bidang yang Kamu Minati', 'Find Your Field of Interest'); ?></h2>
                <p class="fe-section-desc"><?php echo t('Pilih kategori dan mulai perjalanan belajarmu', 'Choose a category and start your learning journey'); ?></p>
            </div>
        </div>

        <div class="fe-pills">
            <?php foreach ($categories as $cat): ?>
                <a href="<?php echo base_url('courses?category_id=' . $cat->id); ?>" class="fe-pill">
                    <i class="fas fa-<?php echo $cat->icon ?: 'folder-open'; ?>"></i>
                    <?php echo htmlspecialchars($cat->name); ?>
                </a>
            <?php endforeach; ?>
            <a href="<?php echo base_url('courses'); ?>" class="fe-pill fe-pill-all"><?php echo t('Semua', 'All'); ?> <i class="fas fa-arrow-right"></i></a>
        </div>
    </div>
</section>
<?php endif; ?>

<?php if ((!isset($site_settings['home_show_featured']) || $site_settings['home_show_featured'] === '1') && !empty($featured_courses)): ?>
<section class="fe-section fe-section-accent">
    <div class="container">
        <div class="fe-section-header">
            <div>
                <h2 class="fe-section-title"><?php echo t('Konten Pilihan', 'Featured Content'); ?></h2>
                <p class="fe-section-desc"><?php echo t('Rekomendasi materi belajar terbaik untukmu', 'Recommended learning content for you'); ?></p>
            </div>
            <a href="<?php echo base_url('courses'); ?>" class="fe-link-all"><?php echo t('Lihat Semua', 'View All'); ?> <i class="fas fa-chevron-right"></i></a>
        </div>

        <div class="row g-3">
            <?php foreach ($featured_courses as $course): ?>
                <div class="col-md-6 col-lg-3">
                    <a href="<?php echo base_url('courses/detail/' . $course->slug); ?>" class="fe-card">
                        <div class="fe-card-img">
                            <img src="<?php echo base_url('uploads/courses/' . $course->thumbnail); ?>" onerror="this.src='https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=400&auto=format&fit=crop&q=60';" alt="">
                            <span class="fe-card-badge"><?php echo content_type_label($course->content_type); ?></span>
                            <?php if ($course->price > 0): ?>
                            <span class="fe-card-price">Rp <?php echo number_format($course->price, 0, ',', '.'); ?></span>
                            <?php endif; ?>
                        </div>
                        <div class="fe-card-body">
                            <div class="fe-card-meta">
                                <span><i class="fas fa-folder-open"></i><?php echo htmlspecialchars($course->category_name ?? ''); ?></span>
                                <span><i class="fas fa-user"></i><?php echo htmlspecialchars($course->teacher_name); ?></span>
                            </div>
                            <h6 class="fe-card-title"><?php echo htmlspecialchars($course->title); ?></h6>
                            <div class="fe-card-footer">
                                <?php echo $course->price > 0 ? 'Rp ' . number_format($course->price, 0, ',', '.') : '<span class="fe-free">' . t('Gratis', 'Free') . '</span>'; ?>
                            </div>
                        </div>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<section class="fe-section fe-section-alt">
    <div class="container">
        <div class="text-center" style="margin-bottom:2rem;">
            <h2 class="fe-section-title" style="margin-bottom:0.5rem;"><?php echo t('Kenapa BISATUNTAS', 'Why BISATUNTAS'); ?>?</h2>
            <p class="fe-section-desc" style="max-width:500px;margin:0 auto;"><?php echo t('Platform belajar yang peduli hasil karirmu', 'A learning platform that cares about your career results'); ?></p>
        </div>

        <div class="row g-3">
            <div class="col-md-4"><div class="fe-why-card"><div class="fe-why-icon"><i class="fas fa-sitemap"></i></div><h6><?php echo t('Kurikulum Terstruktur', 'Structured Curriculum'); ?></h6><p><?php echo t('Alur belajar yang jelas dari pemula hingga mahir.', 'Clear learning paths from beginner to advanced.'); ?></p></div></div>
            <div class="col-md-4"><div class="fe-why-card"><div class="fe-why-icon"><i class="fas fa-user-tie"></i></div><h6><?php echo t('Mentor Praktisi', 'Practitioner Mentors'); ?></h6><p><?php echo t('Belajar langsung dari praktisi industri berpengalaman.', 'Learn directly from experienced industry practitioners.'); ?></p></div></div>
            <div class="col-md-4"><div class="fe-why-card"><div class="fe-why-icon"><i class="fas fa-project-diagram"></i></div><h6><?php echo t('Project-Based', 'Project-Based'); ?></h6><p><?php echo t('Praktik langsung dan bangun portofolio untuk karir.', 'Practice directly and build a portfolio for your career.'); ?></p></div></div>
            <div class="col-md-4"><div class="fe-why-card"><div class="fe-why-icon"><i class="fas fa-certificate"></i></div><h6><?php echo t('Sertifikat Resmi', 'Official Certificate'); ?></h6><p><?php echo t('Dapatkan sertifikat yang diakui industri.', 'Get an industry-recognized certificate.'); ?></p></div></div>
            <div class="col-md-4"><div class="fe-why-card"><div class="fe-why-icon"><i class="fas fa-users"></i></div><h6><?php echo t('Komunitas Aktif', 'Active Community'); ?></h6><p><?php echo t('Diskusi dan networking dengan sesama pembelajar.', 'Discuss and network with fellow learners.'); ?></p></div></div>
            <div class="col-md-4"><div class="fe-why-card"><div class="fe-why-icon"><i class="fas fa-clock"></i></div><h6><?php echo t('Belajar Fleksibel', 'Flexible Learning'); ?></h6><p><?php echo t('Akses kapan saja, di mana saja, sesuai kecepatanmu.', 'Access anytime, anywhere, at your own pace.'); ?></p></div></div>
        </div>
    </div>
</section>

<section class="fe-section">
    <div class="container">
        <div class="text-center" style="margin-bottom:2rem;">
            <h2 class="fe-section-title" style="margin-bottom:0.5rem;"><?php echo t('3 Langkah Sederhana', '3 Simple Steps'); ?></h2>
            <p class="fe-section-desc"><?php echo t('Mulai perjalanan belajarmu dalam hitungan menit', 'Start your learning journey in minutes'); ?></p>
        </div>

        <div class="fe-steps">
            <div class="fe-step"><div class="fe-step-num">1</div><h5><?php echo t('Jelajahi Konten', 'Explore Content'); ?></h5><p><?php echo t('Temukan kelas, materi, dan mentor sesuai minatmu.', 'Find classes, materials, and mentors based on your interests.'); ?></p></div>
            <div class="fe-step"><div class="fe-step-num">2</div><h5><?php echo t('Pilih Jadwal', 'Choose Schedule'); ?></h5><p><?php echo t('Daftar dan pilih waktu belajar yang fleksibel.', 'Register and choose flexible study times.'); ?></p></div>
            <div class="fe-step"><div class="fe-step-num">3</div><h5><?php echo t('Dapatkan Sertifikat', 'Get Certified'); ?></h5><p><?php echo t('Selesaikan materi dan dapatkan sertifikat resmi.', 'Complete materials and get official certificates.'); ?></p></div>
        </div>
    </div>
</section>

<?php if ((!isset($site_settings['home_show_recent']) || $site_settings['home_show_recent'] === '1') && !empty($recent_courses)): ?>
<section class="fe-section fe-section-alt">
    <div class="container">
        <div class="fe-section-header">
            <div>
                <h2 class="fe-section-title"><?php echo t('Konten Terbaru', 'Latest Content'); ?></h2>
                <p class="fe-section-desc"><?php echo t('Materi terbaru untuk skill terbarumu', 'Latest content for your newest skills'); ?></p>
            </div>
            <a href="<?php echo base_url('courses'); ?>" class="fe-link-all"><?php echo t('Lihat Semua', 'View All'); ?> <i class="fas fa-chevron-right"></i></a>
        </div>

        <div class="row g-3">
            <?php foreach(array_slice($recent_courses, 0, 6) as $course): ?>
                <div class="col-md-4">
                    <a href="<?php echo base_url('courses/detail/' . $course->slug); ?>" class="fe-card fe-card-h">
                        <div class="fe-card-img" style="width:140px;flex-shrink:0;">
                            <img src="<?php echo base_url('uploads/courses/' . $course->thumbnail); ?>" onerror="this.src='https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=500&auto=format&fit=crop&q=60';" alt="">
                            <span class="fe-card-badge" style="font-size:0.6rem;"><?php echo content_type_label($course->content_type); ?></span>
                        </div>
                        <div class="fe-card-body">
                            <div class="fe-card-meta">
                                <span><?php echo htmlspecialchars($course->category_name ?? ''); ?></span>
                            </div>
                            <h6 class="fe-card-title" style="font-size:0.8rem;"><?php echo htmlspecialchars($course->title); ?></h6>
                            <div class="fe-card-footer">
                                <span><?php echo $course->price > 0 ? 'Rp ' . number_format($course->price, 0, ',', '.') : '<span class="fe-free">' . t('Gratis', 'Free') . '</span>'; ?></span>
                                <span class="fe-learn"><?php echo t('Pelajari', 'Learn'); ?> <i class="fas fa-chevron-right" style="font-size:0.55rem;"></i></span>
                            </div>
                        </div>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<section class="fe-section fe-section-alt">
    <div class="container">
        <div class="text-center" style="margin-bottom:2rem;">
            <h2 class="fe-section-title" style="margin-bottom:0.5rem;"><?php echo t('Apa Kata Mereka', 'What They Say'); ?></h2>
            <p class="fe-section-desc"><?php echo t('Review dari siswa yang sudah bergabung', 'Reviews from students who have joined'); ?></p>
        </div>

        <div class="row g-3 justify-content-center">
            <div class="col-md-4">
                <div class="fe-testi-card">
                    <div class="fe-stars"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i></div>
                    <p>"Materinya sangat terstruktur dan mudah dipahami. Dari yang awalnya tidak bisa coding, sekarang sudah bisa membuat website sendiri."</p>
                    <div class="fe-testi-by"><span class="fe-testi-avatar">RK</span><div><strong>Rina Kusuma</strong><small><?php echo t('Siswa Web Development', 'Web Development Student'); ?></small></div></div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="fe-testi-card">
                    <div class="fe-stars"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i></div>
                    <p>"Sesi mentoring benar-benar membantu memahami konsep yang sulit. Mentor sangat sabar dan memberikan feedback yang detail."</p>
                    <div class="fe-testi-by"><span class="fe-testi-avatar">DP</span><div><strong>Dimas Pratama</strong><small><?php echo t('Siswa Program Mentorship', 'Mentorship Program Student'); ?></small></div></div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="fe-testi-card">
                    <div class="fe-stars"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i></div>
                    <p>"Sertifikat dari BISATUNTAS membantu saya mendapat promosi di kantor. Materi yang diajarkan sangat relevan dengan kebutuhan industri saat ini."</p>
                    <div class="fe-testi-by"><span class="fe-testi-avatar">SI</span><div><strong>Sari Indah</strong><small><?php echo t('Siswa Digital Marketing', 'Digital Marketing Student'); ?></small></div></div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php if (!isset($site_settings['home_show_cta']) || $site_settings['home_show_cta'] === '1'): ?>
<section class="fe-section fe-section-alt">
    <div class="container">
        <div class="fe-cta">
            <div class="fe-cta-content">
                <h2><?php echo t(setting('home_cta_title', 'Siap Menguasai Skill Baru?'), setting('home_cta_title_en', 'Ready to Master a New Skill?')); ?></h2>
                <p><?php echo t(setting('home_cta_subtitle', 'Daftar gratis sekarang dan mulai perjalanan belajarmu bersama ribuan siswa lainnya.'), setting('home_cta_subtitle_en', 'Register for free and start your learning journey with thousands of other students.')); ?></p>
                <a href="<?php echo base_url(setting('home_cta_button_link', 'auth/register')); ?>" class="fe-btn fe-btn-primary fe-btn-lg">
                    <i class="fas fa-user-plus"></i>
                    <?php echo t(setting('home_cta_button_text', 'Daftar Gratis Sekarang'), setting('home_cta_button_text_en', 'Register Free Now')); ?>
                </a>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>

<style>
.fe-hero { border-bottom:1px solid #eee; background:linear-gradient(170deg, #fff 0%, #f0fdf4 100%); position:relative; overflow:hidden; padding-top:0.5rem; }
.fe-hero::before { content:''; position:absolute; top:-30%; right:-20%; width:600px; height:600px; background:radial-gradient(circle, rgba(5, 150, 105,0.08) 0%, transparent 70%); pointer-events:none; z-index:0; border-radius:50%; }
.fe-hero-inner { padding:3.5rem 1rem 3rem; position:relative; z-index:1; }
.fe-badge { display:inline-flex;align-items:center;gap:6px;background:#f0fdfa;color:#059669;border-radius:99px;padding:0.3rem 0.7rem;font-size:0.72rem;font-weight:600;margin-bottom:1.25rem; }
.fe-hero-title { font-size:2.4rem;font-weight:800;letter-spacing:-0.03em;line-height:1.15;color:#171717;margin-bottom:1rem; }
.fe-hero-title span { color:#059669; }
.fe-hero-sub { font-size:0.9rem;color:#737373;max-width:560px;margin:0 auto 1.5rem;line-height:1.6; }
.fe-hero-cta { display:flex;align-items:center;justify-content:center;gap:0.75rem;margin-bottom:2rem;flex-wrap:wrap; }
.fe-hero-stats { display:flex;align-items:center;justify-content:center;gap:0.5rem;flex-wrap:wrap;font-size:0.8rem;color:#737373; }
.fe-hero-stats strong { font-weight:700;color:#171717; }
.fe-hero-stat-dot { width:4px;height:4px;border-radius:50%;background:#d4d4d4; }
.fe-section { padding:3rem 0; border-bottom:1px solid #eee; background:#fff; position:relative; }
.fe-section-accent { background:#f0fdfa; border-bottom:1px solid #a7f3d0; }
.fe-section > .container { position:relative; z-index:1; }
.fe-section-alt { background:#f0f0f0; }
.fe-section-header { display:flex;align-items:center;justify-content:space-between;margin-bottom:1.25rem;flex-wrap:wrap;gap:0.75rem; }
.fe-section-title { font-size:1.35rem;font-weight:800;letter-spacing:-0.02em;color:#171717;margin:0; }
.fe-section-desc { font-size:0.82rem;color:#737373;margin:0.2rem 0 0; }
.fe-link-all { font-size:0.8rem;font-weight:600;color:#059669;text-decoration:none;display:inline-flex;align-items:center;gap:4px;white-space:nowrap; }
.fe-link-all:hover { text-decoration:underline; }
.fe-partner-text { text-align:center;font-size:0.78rem;color:#a3a3a3;margin-bottom:1rem; }
.fe-partner-text strong { color:#525252; }
.fe-partner-logos { display:flex;align-items:center;justify-content:center;gap:2.5rem;flex-wrap:wrap;opacity:0.5;filter:grayscale(100%); }
.fe-partner-logos span { display:flex;align-items:center;gap:6px;font-size:0.85rem;font-weight:700;color:#525252; }
.fe-partner-logos i { font-size:1.1rem; }
.fe-pills { display:flex;gap:0.5rem;flex-wrap:wrap; }
.fe-pill { display:inline-flex;align-items:center;gap:5px;padding:0.35rem 0.7rem;border-radius:99px;font-size:0.78rem;font-weight:500;color:#525252;background:#f5f5f5;border:1px solid #e5e5e5;text-decoration:none;transition:all 0.15s; }
.fe-pill:hover { background:#fff;border-color:#d4d4d4;color:#171717; }
.fe-pill-all { background:#171717;border-color:#171717;color:#fff; }
.fe-pill-all:hover { background:#333;color:#fff;border-color:#333; }
.fe-card { display:flex;flex-direction:column;height:100%;border:1px solid #eee;border-radius:12px;overflow:hidden;text-decoration:none;color:inherit;transition:transform 0.2s ease, box-shadow 0.2s ease;background:#fff;box-shadow:0 1px 3px rgba(0,0,0,0.05); }
.fe-card:hover { transform:translateY(-3px);box-shadow:0 12px 28px rgba(0,0,0,0.1); }
.fe-card-h { flex-direction:row; }
.fe-card-img { position:relative;aspect-ratio:16/9;overflow:hidden;background:#fafafa; }
.fe-card-img img { width:100%;height:100%;object-fit:cover; }
.fe-card-body { padding:0.75rem;display:flex;flex-direction:column;flex:1;min-width:0; }
.fe-card-meta { display:flex;align-items:center;gap:8px;font-size:0.68rem;color:#a3a3a3;margin-bottom:0.35rem; }
.fe-card-meta i { font-size:0.6rem;margin-right:2px; }
.fe-card-title { font-size:0.82rem;font-weight:700;color:#171717;margin:0 0 0.5rem;line-height:1.35;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden; }
.fe-card-footer { display:flex;align-items:center;justify-content:space-between;font-size:0.8rem;font-weight:700;color:#171717;margin-top:auto;gap:0.5rem; }
.fe-card-footer .fe-free { color:#059669;font-weight:600; }
.fe-card-badge { position:absolute;top:6px;left:6px;background:#fff;color:#171717;font-size:0.6rem;font-weight:600;padding:0.15rem 0.45rem;border-radius:4px;border:1px solid #e5e5e5; }
.fe-card-price { position:absolute;top:6px;right:6px;background:#059669;color:#fff;font-size:0.6rem;font-weight:700;padding:0.15rem 0.45rem;border-radius:4px; }
.fe-learn { font-size:0.75rem;font-weight:600;color:#059669;display:inline-flex;align-items:center;gap:4px; }
.fe-why-card { padding:1.5rem;border:1px solid #eee;border-radius:12px;height:100%;background:#fff;box-shadow:0 1px 3px rgba(0,0,0,0.04);transition:transform 0.2s ease, box-shadow 0.2s ease; }
.fe-why-card:hover { transform:translateY(-2px);box-shadow:0 8px 20px rgba(0,0,0,0.08); }
.fe-why-card h6 { font-size:0.85rem;font-weight:700;color:#171717;margin:0 0 0.35rem; }
.fe-why-card p { font-size:0.78rem;color:#737373;margin:0;line-height:1.5; }
.fe-why-icon { width:36px;height:36px;display:inline-flex;align-items:center;justify-content:center;border-radius:8px;background:#f0f0f0;color:#525252;font-size:0.85rem;margin-bottom:0.75rem; }
.fe-steps { display:grid;grid-template-columns:repeat(3,1fr);gap:1.5rem;max-width:720px;margin:0 auto; }
@media (max-width:768px) { .fe-steps { grid-template-columns:1fr; } }
.fe-step { text-align:center;padding:1.5rem 1rem; }
.fe-step-num { width:40px;height:40px;display:inline-flex;align-items:center;justify-content:center;border-radius:10px;background:#059669;color:#fff;font-weight:800;font-size:1rem;margin-bottom:1rem; }
.fe-step h5 { font-size:0.9rem;font-weight:700;color:#171717;margin:0 0 0.35rem; }
.fe-step p { font-size:0.78rem;color:#737373;margin:0;line-height:1.5; }
.fe-testi-card { border:1px solid #eee;border-radius:12px;padding:1.5rem;height:100%;background:#fff;box-shadow:0 1px 3px rgba(0,0,0,0.04);transition:transform 0.2s ease, box-shadow 0.2s ease; }
.fe-testi-card:hover { transform:translateY(-2px);box-shadow:0 8px 20px rgba(0,0,0,0.08); }
.fe-testi-card p { font-size:0.8rem;color:#525252;line-height:1.55;margin:0 0 1rem;font-style:italic; }
.fe-stars { display:flex;gap:2px;margin-bottom:0.75rem; }
.fe-stars i { font-size:0.75rem;color:#d4d4d4; }
.fe-testi-by { display:flex;align-items:center;gap:10px; }
.fe-testi-avatar { width:34px;height:34px;border-radius:50%;background:#f5f5f5;color:#737373;font-size:0.65rem;font-weight:700;display:inline-flex;align-items:center;justify-content:center;flex-shrink:0; }
.fe-testi-by strong { display:block;font-size:0.78rem;color:#171717; }
.fe-testi-by small { font-size:0.68rem;color:#a3a3a3; }
.fe-cta { padding:3rem 2.5rem;border-radius:16px;background:#f5f5f5;text-align:center;border:1px solid #e5e5e5;box-shadow:0 2px 8px rgba(0,0,0,0.04); }
.fe-cta-content { max-width:520px;margin:0 auto; }
.fe-cta h2 { font-size:1.35rem;font-weight:800;color:#171717;margin:0 0 0.5rem;letter-spacing:-0.02em; }
.fe-cta p { font-size:0.85rem;color:#737373;margin:0 0 1.25rem;line-height:1.5; }
.fe-btn { display:inline-flex;align-items:center;gap:6px;padding:0.45rem 1rem;border-radius:8px;font-size:0.85rem;font-weight:600;text-decoration:none;transition:all 0.15s;cursor:pointer; }
.fe-btn-primary { background:#059669;color:#fff;border:none; }
.fe-btn-primary:hover { background:#047857;color:#fff; }
.fe-btn-outline { border:1px solid #e5e5e5;color:#525252;background:#fff; }
.fe-btn-outline:hover { border-color:#d4d4d4;color:#171717; }
.fe-btn-lg { padding:0.65rem 1.5rem;font-size:0.9rem; }
</style>
