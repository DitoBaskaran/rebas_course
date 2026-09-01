<?php $site_settings = settings(); ?>
<?php $cat_colors = array('#009688', '#FBBF24', '#0D1830', '#ec4899', '#0ea5e9', '#8b5cf6', '#f43f5e', '#009688'); ?>

<!-- ================= HERO ================= -->
<?php if (!isset($site_settings['hero_enabled']) || $site_settings['hero_enabled'] === '1'): ?>
<section class="lp-hero">
    <div class="lp-hero-glow lp-hero-glow-1"></div>
    <div class="lp-hero-glow lp-hero-glow-2"></div>
    <div class="container lp-hero-inner">
        <div class="lp-hero-left">
            <span class="lp-badge">
                <i class="fas fa-bolt"></i>
                <?php echo t(setting('hero_badge', 'Platform Belajar Skill #1'), setting('hero_badge_en', '#1 Skill Learning Platform')); ?>
            </span>

            <h1 class="lp-hero-title">
                <?php echo t(setting('hero_title', 'Kembangkan Skill<br>dan <span>Karirmu</span>'), setting('hero_title_en', 'Develop Your<br>Skills & <span>Career</span>')); ?>
            </h1>

            <p class="lp-hero-sub">
                <?php echo t(setting('hero_subtitle', 'Akses ribuan konten belajar terstruktur, mentoring langsung dengan ahli, dan sertifikat yang diakui industri.'), setting('hero_subtitle_en', 'Access thousands of structured learning content, direct mentoring with experts, and industry-recognized certificates.')); ?>
            </p>

            <div class="lp-hero-cta">
                <a href="<?php echo base_url(setting('hero_cta_link', 'courses')); ?>" class="lp-btn lp-btn-primary">
                    <i class="fas fa-book-open"></i>
                    <?php echo t(setting('hero_cta_text', 'Mulai Belajar'), setting('hero_cta_text_en', 'Start Learning')); ?>
                </a>
                <a href="<?php echo base_url(setting('hero_secondary_cta_link', 'learning_paths')); ?>" class="lp-btn lp-btn-ghost">
                    <?php echo t(setting('hero_secondary_cta_text', 'Lihat Alur Belajar'), setting('hero_secondary_cta_text_en', 'View Learning Paths')); ?>
                    <i class="fas fa-arrow-right"></i>
                </a>
            </div>

            <div class="lp-hero-stats">
                <div class="lp-stat">
                    <strong><?php echo $total_courses_count; ?>+</strong>
                    <span><?php echo t('Konten Belajar', 'Learning Content'); ?></span>
                </div>
                <div class="lp-stat-divider"></div>
                <div class="lp-stat">
                    <strong><?php echo $total_teachers_count; ?>+</strong>
                    <span><?php echo t('Pengajar Ahli', 'Expert Teachers'); ?></span>
                </div>
                <div class="lp-stat-divider"></div>
                <div class="lp-stat">
                    <strong><?php echo $total_students_count; ?>+</strong>
                    <span><?php echo t('Siswa Aktif', 'Active Students'); ?></span>
                </div>
            </div>
        </div>

        <!-- Visual kanan: ilustrasi playful -->
        <div class="lp-hero-right">
            <div class="lp-hero-visual">
                <div class="lp-float lp-float-1"><i class="fas fa-rocket"></i></div>
                <div class="lp-float lp-float-2"><i class="fas fa-lightbulb"></i></div>
                <div class="lp-float lp-float-3"><i class="fas fa-graduation-cap"></i></div>
                <div class="lp-float lp-float-4"><i class="fas fa-trophy"></i></div>

                <div class="lp-hero-card">
                    <div class="lp-hero-card-top">
                        <div class="lp-hero-emoji"><i class="fas fa-laptop-code"></i></div>
                        <div>
                            <strong><?php echo t('Belajar Seru', 'Learn Fun'); ?></strong>
                            <span><?php echo t('Kelas interaktif & live', 'Interactive & live classes'); ?></span>
                        </div>
                    </div>
                    <div class="lp-hero-progress">
                        <div class="lp-hp-head"><span>Progress Kamu</span><span>80%</span></div>
                        <div class="lp-hp-bar"><div style="width:80%"></div></div>
                    </div>
                    <div class="lp-hero-card-tags">
                        <span><i class="fas fa-check-circle"></i> Video</span>
                        <span><i class="fas fa-check-circle"></i> Kuis</span>
                        <span><i class="fas fa-check-circle"></i> Sertifikat</span>
                    </div>
                </div>

                <div class="lp-bubble lp-bubble-1">
                    <i class="fas fa-certificate"></i>
                    <div><strong>+120</strong><span>Sertifikat</span></div>
                </div>
                <div class="lp-bubble lp-bubble-2">
                    <i class="fas fa-user-tie"></i>
                    <div><strong><?php echo $total_teachers_count; ?>+</strong><span>Mentor Ahli</span></div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- ================= TRUSTED BY ================= -->
<section class="lp-trusted">
    <div class="container">
        <p class="lp-trusted-text"><?php echo t('Dipercaya oleh', 'Trusted by'); ?> <strong><?php echo $total_students_count; ?>+</strong> <?php echo t('siswa di Indonesia', 'students across Indonesia'); ?></p>
        <div class="lp-trusted-logos">
            <span><i class="fab fa-google"></i> Google</span>
            <span><i class="fab fa-microsoft"></i> Microsoft</span>
            <span><i class="fab fa-github"></i> GitHub</span>
            <span class="d-none d-md-flex"><i class="fab fa-aws"></i> AWS</span>
            <span class="d-none d-md-flex"><i class="fab fa-figma"></i> Figma</span>
        </div>
    </div>
</section>

<!-- ================= KATEGORI ================= -->
<?php if ((!isset($site_settings['home_show_categories']) || $site_settings['home_show_categories'] === '1') && !empty($categories)): ?>
<section class="lp-section">
    <div class="container">
        <div class="lp-section-head">
            <div>
                <span class="lp-kicker"><?php echo t('Eksplorasi', 'Explore'); ?></span>
                <h2 class="lp-section-title"><?php echo t('Temukan Bidang yang Kamu Minati', 'Find Your Field of Interest'); ?></h2>
                <p class="lp-section-desc"><?php echo t('Pilih kategori dan mulai perjalanan belajarmu', 'Choose a category and start your learning journey'); ?></p>
            </div>
        </div>

        <div class="lp-cat-grid">
            <?php $ci = 0; foreach ($categories as $cat): $c = $cat_colors[$ci % count($cat_colors)]; $ci++; ?>
                <a href="<?php echo base_url('courses?category_id=' . $cat->id); ?>" class="lp-cat-card" style="--cat:<?php echo $c; ?>">
                    <div class="lp-cat-icon"><i class="fas fa-<?php echo $cat->icon ?: 'folder-open'; ?>"></i></div>
                    <div class="lp-cat-info">
                        <strong><?php echo htmlspecialchars($cat->name); ?></strong>
                        <span><?php echo t('Lihat konten', 'View content'); ?> <i class="fas fa-arrow-right"></i></span>
                    </div>
                </a>
            <?php endforeach; ?>
            <a href="<?php echo base_url('courses'); ?>" class="lp-cat-card lp-cat-all">
                <div class="lp-cat-icon"><i class="fas fa-th-large"></i></div>
                <div class="lp-cat-info">
                    <strong><?php echo t('Semua Konten', 'All Content'); ?></strong>
                    <span><?php echo t('Jelajahi semua', 'Browse all'); ?> <i class="fas fa-arrow-right"></i></span>
                </div>
            </a>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- ================= FEATURED ================= -->
<?php if ((!isset($site_settings['home_show_featured']) || $site_settings['home_show_featured'] === '1') && !empty($featured_courses)): ?>
<section class="lp-section lp-section-tint">
    <div class="container">
        <div class="lp-section-head">
            <div>
                <span class="lp-kicker"><?php echo t('Rekomendasi', 'Recommended'); ?></span>
                <h2 class="lp-section-title"><?php echo t('Konten Pilihan', 'Featured Content'); ?></h2>
                <p class="lp-section-desc"><?php echo t('Rekomendasi materi belajar terbaik untukmu', 'Recommended learning content for you'); ?></p>
            </div>
            <a href="<?php echo base_url('courses'); ?>" class="lp-link-all"><?php echo t('Lihat Semua', 'View All'); ?> <i class="fas fa-arrow-right"></i></a>
        </div>

        <div class="row g-3">
            <?php foreach ($featured_courses as $course): ?>
                <div class="col-md-6 col-lg-3">
                    <a href="<?php echo base_url('courses/detail/' . $course->slug); ?>" class="lp-card">
                        <div class="lp-card-img">
                            <img src="<?php echo base_url('uploads/courses/' . $course->thumbnail); ?>" onerror="this.src='https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=400&auto=format&fit=crop&q=60';" alt="">
                            <span class="lp-card-badge"><?php echo content_type_label($course->content_type); ?></span>
                            <?php if ($course->price > 0): ?>
                                <span class="lp-card-price">Rp <?php echo number_format($course->price, 0, ',', '.'); ?></span>
                            <?php endif; ?>
                        </div>
                        <div class="lp-card-body">
                            <div class="lp-card-meta">
                                <span><i class="fas fa-folder-open"></i><?php echo htmlspecialchars($course->category_name ?? ''); ?></span>
                                <span><i class="fas fa-user"></i><?php echo htmlspecialchars($course->teacher_name); ?></span>
                            </div>
                            <h6 class="lp-card-title"><?php echo htmlspecialchars($course->title); ?></h6>
                            <div class="lp-card-foot">
                                <?php echo $course->price > 0 ? '<span class="lp-price">Rp ' . number_format($course->price, 0, ',', '.') . '</span>' : '<span class="lp-free">' . t('Gratis', 'Free') . '</span>'; ?>
                                <span class="lp-learn"><i class="fas fa-arrow-right"></i></span>
                            </div>
                        </div>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- ================= WHY ================= -->
<section class="lp-section">
    <div class="container">
        <div class="text-center" style="margin-bottom:2.5rem;">
            <span class="lp-kicker"><?php echo t('Keunggulan', 'Why Us'); ?></span>
            <h2 class="lp-section-title"><?php echo t('Kenapa BISATUNTAS', 'Why BISATUNTAS'); ?>?</h2>
            <p class="lp-section-desc" style="max-width:500px;margin:0 auto;"><?php echo t('Platform belajar yang peduli hasil karirmu', 'A learning platform that cares about your career results'); ?></p>
        </div>

        <div class="row g-3">
            <div class="col-md-6 col-lg-4"><div class="lp-why"><div class="lp-why-icon" style="--wi:#009688;background:rgba(5,150,105,0.1);color:#009688;"><i class="fas fa-sitemap"></i></div><h6><?php echo t('Kurikulum Terstruktur', 'Structured Curriculum'); ?></h6><p><?php echo t('Alur belajar yang jelas dari pemula hingga mahir.', 'Clear learning paths from beginner to advanced.'); ?></p></div></div>
            <div class="col-md-6 col-lg-4"><div class="lp-why"><div class="lp-why-icon" style="--wi:#0D1830;background:rgba(99,102,241,0.1);color:#0D1830;"><i class="fas fa-user-tie"></i></div><h6><?php echo t('Mentor Praktisi', 'Practitioner Mentors'); ?></h6><p><?php echo t('Belajar langsung dari praktisi industri berpengalaman.', 'Learn directly from experienced industry practitioners.'); ?></p></div></div>
            <div class="col-md-6 col-lg-4"><div class="lp-why"><div class="lp-why-icon" style="--wi:#FBBF24;background:rgba(245,158,11,0.1);color:#FBBF24;"><i class="fas fa-project-diagram"></i></div><h6><?php echo t('Project-Based', 'Project-Based'); ?></h6><p><?php echo t('Praktik langsung dan bangun portofolio untuk karir.', 'Practice directly and build a portfolio for your career.'); ?></p></div></div>
            <div class="col-md-6 col-lg-4"><div class="lp-why"><div class="lp-why-icon" style="--wi:#ec4899;background:rgba(236,72,153,0.1);color:#ec4899;"><i class="fas fa-certificate"></i></div><h6><?php echo t('Sertifikat Resmi', 'Official Certificate'); ?></h6><p><?php echo t('Dapatkan sertifikat yang diakui industri.', 'Get an industry-recognized certificate.'); ?></p></div></div>
            <div class="col-md-6 col-lg-4"><div class="lp-why"><div class="lp-why-icon" style="--wi:#0ea5e9;background:rgba(14,165,233,0.1);color:#0ea5e9;"><i class="fas fa-users"></i></div><h6><?php echo t('Komunitas Aktif', 'Active Community'); ?></h6><p><?php echo t('Diskusi dan networking dengan sesama pembelajar.', 'Discuss and network with fellow learners.'); ?></p></div></div>
            <div class="col-md-6 col-lg-4"><div class="lp-why"><div class="lp-why-icon" style="--wi:#8b5cf6;background:rgba(139,92,246,0.1);color:#8b5cf6;"><i class="fas fa-clock"></i></div><h6><?php echo t('Belajar Fleksibel', 'Flexible Learning'); ?></h6><p><?php echo t('Akses kapan saja, di mana saja, sesuai kecepatanmu.', 'Access anytime, anywhere, at your own pace.'); ?></p></div></div>
        </div>
    </div>
</section>

<!-- ================= STEPS ================= -->
<section class="lp-section lp-dark">
    <div class="container">
        <div class="text-center" style="margin-bottom:2.5rem;">
            <span class="lp-kicker lp-kicker-light"><?php echo t('Cara Kerja', 'How It Works'); ?></span>
            <h2 class="lp-section-title" style="color:#fff;"><?php echo t('3 Langkah Sederhana', '3 Simple Steps'); ?></h2>
            <p class="lp-section-desc" style="color:rgba(255,255,255,0.6);"><?php echo t('Mulai perjalanan belajarmu dalam hitungan menit', 'Start your learning journey in minutes'); ?></p>
        </div>

        <div class="lp-steps">
            <div class="lp-step">
                <div class="lp-step-num">1</div>
                <div class="lp-step-icon"><i class="fas fa-compass"></i></div>
                <h5><?php echo t('Jelajahi Konten', 'Explore Content'); ?></h5>
                <p><?php echo t('Temukan kelas, materi, dan mentor sesuai minatmu.', 'Find classes, materials, and mentors based on your interests.'); ?></p>
            </div>
            <div class="lp-step">
                <div class="lp-step-num">2</div>
                <div class="lp-step-icon"><i class="fas fa-calendar-check"></i></div>
                <h5><?php echo t('Pilih Jadwal', 'Choose Schedule'); ?></h5>
                <p><?php echo t('Daftar dan pilih waktu belajar yang fleksibel.', 'Register and choose flexible study times.'); ?></p>
            </div>
            <div class="lp-step">
                <div class="lp-step-num">3</div>
                <div class="lp-step-icon"><i class="fas fa-award"></i></div>
                <h5><?php echo t('Dapatkan Sertifikat', 'Get Certified'); ?></h5>
                <p><?php echo t('Selesaikan materi dan dapatkan sertifikat resmi.', 'Complete materials and get official certificates.'); ?></p>
            </div>
        </div>
    </div>
</section>

<!-- ================= RECENT ================= -->
<?php if ((!isset($site_settings['home_show_recent']) || $site_settings['home_show_recent'] === '1') && !empty($recent_courses)): ?>
<section class="lp-section">
    <div class="container">
        <div class="lp-section-head">
            <div>
                <span class="lp-kicker"><?php echo t('Baru Rilis', 'New Releases'); ?></span>
                <h2 class="lp-section-title"><?php echo t('Konten Terbaru', 'Latest Content'); ?></h2>
                <p class="lp-section-desc"><?php echo t('Materi terbaru untuk skill terbarumu', 'Latest content for your newest skills'); ?></p>
            </div>
            <a href="<?php echo base_url('courses'); ?>" class="lp-link-all"><?php echo t('Lihat Semua', 'View All'); ?> <i class="fas fa-arrow-right"></i></a>
        </div>

        <div class="row g-3">
            <?php foreach (array_slice($recent_courses, 0, 3) as $course): ?>
                <div class="col-md-4">
                    <a href="<?php echo base_url('courses/detail/' . $course->slug); ?>" class="lp-card lp-card-h">
                        <div class="lp-card-img" style="width:150px;flex-shrink:0;aspect-ratio:auto;">
                            <img src="<?php echo base_url('uploads/courses/' . $course->thumbnail); ?>" onerror="this.src='https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=500&auto=format&fit=crop&q=60';" alt="">
                            <span class="lp-card-badge"><?php echo content_type_label($course->content_type); ?></span>
                        </div>
                        <div class="lp-card-body">
                            <div class="lp-card-meta"><span><?php echo htmlspecialchars($course->category_name ?? ''); ?></span></div>
                            <h6 class="lp-card-title"><?php echo htmlspecialchars($course->title); ?></h6>
                            <div class="lp-card-foot">
                                <?php echo $course->price > 0 ? '<span class="lp-price">Rp ' . number_format($course->price, 0, ',', '.') . '</span>' : '<span class="lp-free">' . t('Gratis', 'Free') . '</span>'; ?>
                                <span class="lp-learn"><?php echo t('Pelajari', 'Learn'); ?> <i class="fas fa-arrow-right"></i></span>
                            </div>
                        </div>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- ================= TESTIMONIALS ================= -->
<section class="lp-section lp-section-tint">
    <div class="container">
        <div class="text-center" style="margin-bottom:2.5rem;">
            <span class="lp-kicker"><?php echo t('Testimoni', 'Testimonials'); ?></span>
            <h2 class="lp-section-title"><?php echo t('Apa Kata Mereka', 'What They Say'); ?></h2>
            <p class="lp-section-desc"><?php echo t('Review dari siswa yang sudah bergabung', 'Reviews from students who have joined'); ?></p>
        </div>

        <div class="row g-3 justify-content-center">
            <div class="col-md-4">
                <div class="lp-testi">
                    <div class="lp-stars"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i></div>
                    <p>"Materinya sangat terstruktur dan mudah dipahami. Dari yang awalnya tidak bisa coding, sekarang sudah bisa membuat website sendiri."</p>
                    <div class="lp-testi-by"><span class="lp-avatar" style="background:#009688;">RK</span><div><strong>Rina Kusuma</strong><small><?php echo t('Siswa Web Development', 'Web Development Student'); ?></small></div></div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="lp-testi">
                    <div class="lp-stars"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i></div>
                    <p>"Sesi mentoring benar-benar membantu memahami konsep yang sulit. Mentor sangat sabar dan memberikan feedback yang detail."</p>
                    <div class="lp-testi-by"><span class="lp-avatar" style="background:#0D1830;">DP</span><div><strong>Dimas Pratama</strong><small><?php echo t('Siswa Program Mentorship', 'Mentorship Program Student'); ?></small></div></div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="lp-testi">
                    <div class="lp-stars"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i></div>
                    <p>"Sertifikat dari BISATUNTAS membantu saya mendapat promosi di kantor. Materi yang diajarkan sangat relevan dengan kebutuhan industri saat ini."</p>
                    <div class="lp-testi-by"><span class="lp-avatar" style="background:#FBBF24;">SI</span><div><strong>Sari Indah</strong><small><?php echo t('Siswa Digital Marketing', 'Digital Marketing Student'); ?></small></div></div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ================= CTA ================= -->
<?php if (!isset($site_settings['home_show_cta']) || $site_settings['home_show_cta'] === '1'): ?>
<section class="lp-section">
    <div class="container">
        <div class="lp-cta">
            <div class="lp-cta-glow"></div>
            <div class="lp-cta-content">
                <h2><?php echo t(setting('home_cta_title', 'Siap Menguasai Skill Baru?'), setting('home_cta_title_en', 'Ready to Master a New Skill?')); ?></h2>
                <p><?php echo t(setting('home_cta_subtitle', 'Daftar gratis sekarang dan mulai perjalanan belajarmu bersama ribuan siswa lainnya.'), setting('home_cta_subtitle_en', 'Register for free and start your learning journey with thousands of other students.')); ?></p>
                <a href="<?php echo base_url(setting('home_cta_button_link', 'auth/register')); ?>" class="lp-btn lp-btn-amber lp-btn-lg">
                    <i class="fas fa-user-plus"></i>
                    <?php echo t(setting('home_cta_button_text', 'Daftar Gratis Sekarang'), setting('home_cta_button_text_en', 'Register Free Now')); ?>
                </a>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>

<style>
/* ===== Landing redesign (lp-) ===== */
.lp-hero{position:relative;overflow:hidden;background:linear-gradient(160deg,#0D1830 0%,#00796B 40%,#009688 100%);padding:4.5rem 0 4rem;color:#fff;}
.lp-hero-glow{position:absolute;border-radius:50%;pointer-events:none;}
.lp-hero-glow-1{width:560px;height:560px;background:radial-gradient(circle,rgba(255,255,255,0.10) 0%,transparent 65%);top:-180px;right:-120px;}
.lp-hero-glow-2{width:420px;height:420px;background:radial-gradient(circle,rgba(251,191,36,0.12) 0%,transparent 65%);bottom:-160px;left:-100px;}
.lp-hero-inner{position:relative;z-index:2;display:grid;grid-template-columns:1.1fr 0.9fr;gap:3rem;align-items:center;}
.lp-badge{display:inline-flex;align-items:center;gap:7px;background:rgba(255,255,255,0.12);backdrop-filter:blur(8px);border:1px solid rgba(255,255,255,0.2);color:#fff;border-radius:99px;padding:0.4rem 0.9rem;font-size:0.75rem;font-weight:600;margin-bottom:1.4rem;}
.lp-badge i{color:#fbbf24;font-size:0.7rem;}
.lp-hero-title{font-size:2.7rem;font-weight:800;letter-spacing:-0.04em;line-height:1.12;color:#fff;margin:0 0 1rem;}
.lp-hero-title span{color:#fbbf24;}
.lp-hero-sub{font-size:0.95rem;color:rgba(255,255,255,0.75);max-width:520px;margin:0 0 1.8rem;line-height:1.65;}
.lp-hero-cta{display:flex;align-items:center;gap:0.8rem;margin-bottom:2.2rem;flex-wrap:wrap;}
.lp-btn{display:inline-flex;align-items:center;gap:8px;padding:0.6rem 1.3rem;border-radius:12px;font-size:0.88rem;font-weight:700;text-decoration:none;transition:all 0.2s;cursor:pointer;border:none;font-family:inherit;}
.lp-btn i{font-size:0.8rem;}
.lp-btn-primary{background:#fff;color:#00796B;box-shadow:0 8px 24px rgba(0,0,0,0.2);}
.lp-btn-primary:hover{transform:translateY(-2px);box-shadow:0 12px 30px rgba(0,0,0,0.25);color:#00796B;}
.lp-btn-ghost{background:rgba(255,255,255,0.1);color:#fff;border:1.5px solid rgba(255,255,255,0.3);}
.lp-btn-ghost:hover{background:rgba(255,255,255,0.18);color:#fff;}
.lp-btn-amber{background:linear-gradient(135deg,#fbbf24,#FBBF24);color:#0D1830;box-shadow:0 10px 28px rgba(251,191,36,0.4);}
.lp-btn-amber:hover{transform:translateY(-2px);box-shadow:0 14px 34px rgba(251,191,36,0.5);color:#0D1830;}
.lp-btn-lg{padding:0.85rem 2rem;font-size:0.95rem;border-radius:14px;}
.lp-hero-stats{display:flex;align-items:center;gap:1.5rem;flex-wrap:wrap;}
.lp-stat strong{display:block;font-size:1.5rem;font-weight:800;color:#fff;line-height:1.1;}
.lp-stat span{font-size:0.75rem;color:rgba(255,255,255,0.65);}
.lp-stat-divider{width:1px;height:34px;background:rgba(255,255,255,0.2);}
/* visual kanan */
.lp-hero-visual{position:relative;display:flex;align-items:center;justify-content:center;min-height:400px;}
.lp-hero-card{width:100%;max-width:360px;background:rgba(255,255,255,0.12);backdrop-filter:blur(14px);border:1px solid rgba(255,255,255,0.22);border-radius:24px;padding:1.6rem;box-shadow:0 30px 70px rgba(0,0,0,0.3);transform:rotate(-3deg);transition:transform 0.4s cubic-bezier(0.34,1.56,0.64,1);}
.lp-hero-card:hover{transform:rotate(0deg) scale(1.02);}
.lp-hero-card-top{display:flex;align-items:center;gap:0.9rem;margin-bottom:1.2rem;}
.lp-hero-emoji{width:52px;height:52px;border-radius:16px;background:linear-gradient(135deg,#fbbf24,#FBBF24);display:flex;align-items:center;justify-content:center;font-size:1.3rem;color:#0D1830;box-shadow:0 8px 20px rgba(251,191,36,0.4);}
.lp-hero-card-top strong{display:block;font-size:0.95rem;color:#fff;font-weight:700;}
.lp-hero-card-top span{font-size:0.72rem;color:rgba(255,255,255,0.65);}
.lp-hero-progress{margin-bottom:1.2rem;}
.lp-hp-head{display:flex;justify-content:space-between;font-size:0.7rem;color:rgba(255,255,255,0.7);margin-bottom:0.4rem;}
.lp-hp-bar{height:8px;border-radius:99px;background:rgba(255,255,255,0.15);overflow:hidden;}
.lp-hp-bar div{height:100%;border-radius:99px;background:linear-gradient(90deg,#fbbf24,#FBBF24);}
.lp-hero-card-tags{display:flex;gap:0.5rem;flex-wrap:wrap;}
.lp-hero-card-tags span{display:inline-flex;align-items:center;gap:5px;background:rgba(255,255,255,0.1);border:1px solid rgba(255,255,255,0.18);color:#fff;font-size:0.68rem;font-weight:600;padding:0.25rem 0.6rem;border-radius:99px;}
.lp-hero-card-tags i{color:#fbbf24;font-size:0.6rem;}
.lp-bubble{position:absolute;background:rgba(255,255,255,0.14);backdrop-filter:blur(10px);border:1px solid rgba(255,255,255,0.22);border-radius:16px;padding:0.7rem 0.95rem;display:flex;align-items:center;gap:0.6rem;box-shadow:0 14px 34px rgba(0,0,0,0.22);animation:lpFloat 6s ease-in-out infinite;}
.lp-bubble i{font-size:1.1rem;color:#fbbf24;}
.lp-bubble strong{display:block;font-size:0.8rem;color:#fff;font-weight:700;line-height:1.2;}
.lp-bubble span{display:block;font-size:0.62rem;color:rgba(255,255,255,0.7);}
.lp-bubble-1{top:8%;left:-10px;animation-delay:0.6s;}
.lp-bubble-2{bottom:10%;right:-14px;animation-delay:1.4s;}
.lp-float{position:absolute;color:rgba(255,255,255,0.4);font-size:1.2rem;animation:lpFloat 5s ease-in-out infinite;pointer-events:none;}
.lp-float-1{top:4%;right:8%;animation-delay:0s;}
.lp-float-2{top:18%;left:2%;animation-delay:1.1s;color:#fbbf24;}
.lp-float-3{bottom:16%;left:6%;animation-delay:0.5s;}
.lp-float-4{bottom:4%;right:16%;animation-delay:1.8s;color:#fbbf24;}
@keyframes lpFloat{0%,100%{transform:translateY(0) rotate(0);}50%{transform:translateY(-13px) rotate(7deg);}}
/* trusted */
.lp-trusted{padding:2rem 0;background:#fff;border-bottom:1px solid #f0f0f0;}
.lp-trusted-text{text-align:center;font-size:0.78rem;color:#a3a3a3;margin-bottom:1rem;}
.lp-trusted-text strong{color:#525252;}
.lp-trusted-logos{display:flex;align-items:center;justify-content:center;gap:2.5rem;flex-wrap:wrap;opacity:0.45;filter:grayscale(100%);}
.lp-trusted-logos span{display:flex;align-items:center;gap:6px;font-size:0.85rem;font-weight:700;color:#525252;}
.lp-trusted-logos i{font-size:1.1rem;}
/* section umum */
.lp-section{padding:3.5rem 0;background:#fff;}
.lp-section-tint{background:#E0F2F1;}
.lp-section-head{display:flex;align-items:flex-end;justify-content:space-between;margin-bottom:1.6rem;flex-wrap:wrap;gap:0.75rem;}
.lp-kicker{display:inline-block;font-size:0.68rem;font-weight:700;text-transform:uppercase;letter-spacing:0.1em;color:#009688;margin-bottom:0.35rem;}
.lp-kicker-light{color:#fbbf24;}
.lp-section-title{font-size:1.55rem;font-weight:800;letter-spacing:-0.03em;color:#0D1830;margin:0;}
.lp-section-desc{font-size:0.85rem;color:#737373;margin:0.25rem 0 0;}
.lp-link-all{font-size:0.82rem;font-weight:700;color:#009688;text-decoration:none;display:inline-flex;align-items:center;gap:6px;white-space:nowrap;}
.lp-link-all:hover{color:#00796B;text-decoration:underline;}
/* kategori */
.lp-cat-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:0.9rem;}
.lp-cat-card{display:flex;align-items:center;gap:0.85rem;padding:1rem 1.1rem;border-radius:14px;border:1.5px solid #eef2f1;background:#fff;text-decoration:none;transition:all 0.2s;}
.lp-cat-card:hover{transform:translateY(-3px);box-shadow:0 12px 26px rgba(0,0,0,0.08);border-color:var(--cat);}
.lp-cat-icon{width:42px;height:42px;border-radius:12px;background:color-mix(in srgb,var(--cat) 12%,white);color:var(--cat);display:flex;align-items:center;justify-content:center;font-size:1rem;flex-shrink:0;transition:all 0.2s;}
.lp-cat-card:hover .lp-cat-icon{background:var(--cat);color:#fff;}
.lp-cat-info strong{display:block;font-size:0.82rem;font-weight:700;color:#0D1830;margin-bottom:0.1rem;}
.lp-cat-info span{font-size:0.68rem;color:#9ca3af;}
.lp-cat-info span i{font-size:0.55rem;transition:transform 0.2s;}
.lp-cat-card:hover .lp-cat-info span i{transform:translateX(3px);}
.lp-cat-all{background:#0D1830;border-color:#0D1830;}
.lp-cat-all .lp-cat-icon{background:rgba(255,255,255,0.1);color:#fff;}
.lp-cat-all .lp-cat-info strong{color:#fff;}
.lp-cat-all .lp-cat-info span{color:rgba(255,255,255,0.6);}
/* kartu konten */
.lp-card{display:flex;flex-direction:column;height:100%;border:1px solid #eef2f1;border-radius:16px;overflow:hidden;text-decoration:none;color:inherit;transition:transform 0.22s ease,box-shadow 0.22s ease;background:#fff;box-shadow:0 2px 6px rgba(0,0,0,0.04);}
.lp-card:hover{transform:translateY(-4px);box-shadow:0 16px 34px rgba(0,0,0,0.1);}
.lp-card-h{flex-direction:row;}
.lp-card-img{position:relative;aspect-ratio:16/9;overflow:hidden;background:#fafafa;}
.lp-card-img img{width:100%;height:100%;object-fit:cover;transition:transform 0.35s;}
.lp-card:hover .lp-card-img img{transform:scale(1.05);}
.lp-card-body{padding:0.85rem;display:flex;flex-direction:column;flex:1;min-width:0;}
.lp-card-meta{display:flex;align-items:center;gap:10px;font-size:0.66rem;color:#9ca3af;margin-bottom:0.4rem;}
.lp-card-meta i{font-size:0.55rem;margin-right:2px;color:#009688;}
.lp-card-title{font-size:0.84rem;font-weight:700;color:#0D1830;margin:0 0 0.5rem;line-height:1.35;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;}
.lp-card-foot{display:flex;align-items:center;justify-content:space-between;font-size:0.82rem;font-weight:700;color:#0D1830;margin-top:auto;}
.lp-price{color:#0D1830;}
.lp-free{color:#009688;font-weight:600;}
.lp-learn{width:28px;height:28px;border-radius:8px;background:#f0fdf4;color:#009688;display:inline-flex;align-items:center;justify-content:center;font-size:0.65rem;transition:all 0.2s;}
.lp-card:hover .lp-learn{background:#009688;color:#fff;}
.lp-card-badge{position:absolute;top:8px;left:8px;background:rgba(255,255,255,0.92);backdrop-filter:blur(4px);color:#0D1830;font-size:0.6rem;font-weight:700;padding:0.2rem 0.5rem;border-radius:6px;}
.lp-card-price{position:absolute;top:8px;right:8px;background:rgba(5,150,105,0.92);backdrop-filter:blur(4px);color:#fff;font-size:0.62rem;font-weight:700;padding:0.2rem 0.5rem;border-radius:6px;}
/* why */
.lp-why{padding:1.5rem;border:1px solid #eef2f1;border-radius:16px;height:100%;background:#fff;box-shadow:0 2px 6px rgba(0,0,0,0.03);transition:transform 0.2s ease,box-shadow 0.2s ease;}
.lp-why:hover{transform:translateY(-3px);box-shadow:0 14px 30px rgba(0,0,0,0.08);}
.lp-why-icon{width:42px;height:42px;border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:0.95rem;margin-bottom:0.9rem;}
.lp-why h6{font-size:0.88rem;font-weight:700;color:#0D1830;margin:0 0 0.35rem;}
.lp-why p{font-size:0.78rem;color:#737373;margin:0;line-height:1.55;}
/* steps dark */
.lp-dark{background:linear-gradient(160deg,#0D1830 0%,#00796B 60%,#00796B 100%);position:relative;overflow:hidden;}
.lp-dark::before{content:'';position:absolute;width:400px;height:400px;border-radius:50%;background:radial-gradient(circle,rgba(251,191,36,0.08),transparent 70%);top:-120px;right:-100px;}
.lp-steps{display:grid;grid-template-columns:repeat(3,1fr);gap:1.5rem;max-width:820px;margin:0 auto;position:relative;z-index:1;}
.lp-step{text-align:center;padding:1.8rem 1.2rem;position:relative;}
.lp-step:not(:last-child)::after{content:'';position:absolute;top:52px;right:-14px;width:28px;height:2px;background:linear-gradient(90deg,rgba(251,191,36,0.5),transparent);}
.lp-step-num{position:absolute;top:0;left:50%;transform:translateX(-50%);width:30px;height:30px;border-radius:50%;background:#fbbf24;color:#0D1830;font-weight:800;font-size:0.8rem;display:flex;align-items:center;justify-content:center;box-shadow:0 0 0 6px rgba(251,191,36,0.15);}
.lp-step-icon{width:60px;height:60px;border-radius:18px;background:rgba(255,255,255,0.1);border:1px solid rgba(255,255,255,0.2);display:flex;align-items:center;justify-content:center;font-size:1.3rem;color:#fbbf24;margin:1.4rem auto 1rem;}
.lp-step h5{font-size:0.95rem;font-weight:700;color:#fff;margin:0 0 0.4rem;}
.lp-step p{font-size:0.78rem;color:rgba(255,255,255,0.6);margin:0;line-height:1.55;}
/* testimoni */
.lp-testi{border:1px solid #eef2f1;border-radius:18px;padding:1.6rem;height:100%;background:#fff;box-shadow:0 2px 6px rgba(0,0,0,0.04);transition:transform 0.2s ease,box-shadow 0.2s ease;}
.lp-testi:hover{transform:translateY(-3px);box-shadow:0 16px 34px rgba(0,0,0,0.08);}
.lp-testi p{font-size:0.82rem;color:#525252;line-height:1.6;margin:0 0 1.1rem;font-style:italic;}
.lp-stars{display:flex;gap:3px;margin-bottom:0.8rem;}
.lp-stars i{font-size:0.75rem;color:#FBBF24;}
.lp-testi-by{display:flex;align-items:center;gap:10px;}
.lp-avatar{width:38px;height:38px;border-radius:50%;color:#fff;font-size:0.68rem;font-weight:700;display:inline-flex;align-items:center;justify-content:center;flex-shrink:0;}
.lp-testi-by strong{display:block;font-size:0.8rem;color:#0D1830;}
.lp-testi-by small{font-size:0.68rem;color:#9ca3af;}
/* CTA */
.lp-cta{position:relative;overflow:hidden;padding:3.2rem 2.5rem;border-radius:22px;background:linear-gradient(135deg,#0D1830 0%,#00796B 50%,#009688 100%);text-align:center;box-shadow:0 24px 60px rgba(5,150,105,0.25);}
.lp-cta-glow{position:absolute;width:380px;height:380px;border-radius:50%;background:radial-gradient(circle,rgba(251,191,36,0.15),transparent 65%);top:-140px;right:-100px;}
.lp-cta-content{position:relative;z-index:1;max-width:540px;margin:0 auto;}
.lp-cta h2{font-size:1.6rem;font-weight:800;letter-spacing:-0.03em;color:#fff;margin:0 0 0.6rem;}
.lp-cta p{font-size:0.88rem;color:rgba(255,255,255,0.75);margin:0 0 1.5rem;line-height:1.6;}
/* responsive */
@media (max-width:992px){
  .lp-hero-inner{grid-template-columns:1fr;gap:2.5rem;}
  .lp-hero-visual{min-height:340px;}
  .lp-cat-grid{grid-template-columns:repeat(2,1fr);}
  .lp-steps{grid-template-columns:1fr;max-width:480px;}
  .lp-step:not(:last-child)::after{display:none;}
}
@media (max-width:768px){
  .lp-hero{padding:3rem 0;}
  .lp-hero-title{font-size:2rem;}
  .lp-cat-grid{grid-template-columns:1fr;}
  .lp-hero-stats{gap:1rem;}
}
</style>
