<?php $site_settings = settings(); ?>


<!-- Hero Section -->
<?php if (!isset($site_settings['hero_enabled']) || $site_settings['hero_enabled'] === '1'): ?>
<section class="hero-section bg-white text-dark position-relative overflow-hidden py-5">
    <div class="container position-relative hero-pb-padding py-5" style="z-index: 1;">
        <div class="row align-items-center g-5 flex-column-reverse flex-lg-row">
            <div class="col-lg-6 text-center text-lg-start animate-fade-in-up">
                <span class="hero-badge d-inline-flex align-items-center gap-2 bg-light text-dark rounded-pill px-3 py-1 mb-4 shadow-sm border">
                    <span class="icon-18 bg-dark text-white rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 24px; height: 24px;">
                        <i class="fas fa-rocket fa-xs"></i>
                    </span>
                    <span class="fw-medium"><?php echo t(setting('hero_badge', 'Platform Belajar Skill #1'), setting('hero_badge_en', '#1 Skill Learning Platform')); ?></span>
                </span>
                <h1 class="display-4 fw-extrabold text-dark mb-4 hero-title lh-sm" style="letter-spacing: -0.04em;">
                    <?php echo t(setting('hero_title', 'Bangun Masa Depanmu<br>Dengan <span class="text-primary">Skill Terbaik</span>'), setting('hero_title_en', 'Build Your Future<br>With <span class="text-primary">The Best Skills</span>')); ?>
                </h1>
                <p class="lead text-secondary mb-5" style="max-width: 540px; margin-left: auto; margin-right: auto; font-size: 1.1rem; line-height: 1.7;">
                    <?php echo t(setting('hero_subtitle', 'Akses ribuan konten belajar terstruktur: programming, desain, bisnis, soft skill, musik, dan banyak lagi. Dari pemula hingga mahir.'), setting('hero_subtitle_en', 'Access thousands of structured learning content: programming, design, business, soft skills, music, and more. From beginner to advanced.')); ?>
                </p>
                <div class="d-flex flex-wrap gap-3 justify-content-center justify-content-lg-start">
                    <a href="<?php echo base_url(setting('hero_cta_link', 'courses')); ?>" class="btn btn-dark btn-lg px-5 shadow-sm rounded-pill d-flex align-items-center gap-2 fw-semibold">
                        <?php echo t(setting('hero_cta_text', 'Mulai Belajar'), setting('hero_cta_text_en', 'Start Learning')); ?>
                    </a>
                    <a href="<?php echo base_url(setting('hero_secondary_cta_link', 'learning_paths')); ?>" class="btn btn-outline-dark btn-lg px-5 rounded-pill d-flex align-items-center gap-2 fw-semibold border-2">
                        <?php echo t(setting('hero_secondary_cta_text', 'Lihat Alur Belajar'), setting('hero_secondary_cta_text_en', 'View Learning Paths')); ?>
                    </a>
                </div>
                
                <div class="row mt-5 pt-3 g-4 text-start justify-content-center justify-content-lg-start border-top border-light pt-4">
                    <div class="col-4 col-sm-auto">
                        <div class="fw-bold fs-4 text-dark mb-1"><?php echo $total_courses_count; ?>+</div>
                        <div class="text-secondary small fw-medium">Konten Belajar</div>
                    </div>
                    <div class="col-4 col-sm-auto border-start border-light ps-4">
                        <div class="fw-bold fs-4 text-dark mb-1"><?php echo $total_teachers_count; ?>+</div>
                        <div class="text-secondary small fw-medium">Pengajar Ahli</div>
                    </div>
                    <div class="col-4 col-sm-auto border-start border-light ps-4">
                        <div class="fw-bold fs-4 text-dark mb-1"><?php echo $total_students_count; ?>+</div>
                        <div class="text-secondary small fw-medium">Siswa Aktif</div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 d-flex justify-content-center animate-fade-in-up stagger-2 mb-5 mb-lg-0">
                <div class="position-relative w-100" style="max-width: 550px;">
                   <!-- Placeholder for Hero Image -->
                    <div class="rounded-4 overflow-hidden shadow-2xl position-relative" style="aspect-ratio: 4/3; background: #f8f9fa;">
                         <img src="https://images.unsplash.com/photo-1522202176988-66273c2fd55f?auto=format&fit=crop&w=800&q=80" alt="Students learning" class="w-100 h-100 object-fit-cover" style="opacity: 0.9;">
                         <div class="position-absolute inset-0 bg-dark opacity-10"></div>
                         
                         <!-- Floating Elements mimicking the reference -->
                         <div class="position-absolute bg-white rounded-3 p-3 shadow-lg d-flex align-items-center gap-3 animate-fade-in-up stagger-3" style="bottom: -20px; left: -20px; z-index: 2;">
                            <div class="icon-40 bg-success-subtle text-success rounded-circle">
                                <i class="fas fa-certificate"></i>
                            </div>
                            <div>
                                <div class="fw-bold text-dark fs-7">Sertifikat Resmi</div>
                                <div class="text-secondary small">Diakui Industri</div>
                            </div>
                         </div>
                         
                         <div class="position-absolute bg-white rounded-3 p-3 shadow-lg d-flex align-items-center gap-3 animate-fade-in-up stagger-4" style="top: 40px; right: -30px; z-index: 2;">
                             <div class="icon-40 bg-primary-subtle text-primary rounded-circle">
                                <i class="fas fa-chalkboard-teacher"></i>
                            </div>
                            <div>
                                <div class="fw-bold text-dark fs-7">Belajar Interaktif</div>
                                <div class="text-secondary small">Mentoring Langsung</div>
                            </div>
                         </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- Partner / Client Logos Section -->
<section class="py-4 border-top border-bottom border-light bg-white overflow-hidden">
    <div class="container-fluid px-0">
        <div class="text-center mb-4">
            <p class="text-secondary small fw-semibold text-uppercase tracking-wide mb-0">Telah digunakan dan dipercaya oleh ribuan siswa & perusahaan</p>
        </div>
        <div class="d-flex align-items-center gap-5 justify-content-center opacity-50 flex-wrap px-3 pb-2" style="filter: grayscale(100%);">
            <!-- Placeholder for client logos, using icons for now -->
            <div class="d-flex align-items-center gap-2"><i class="fab fa-aws fs-3"></i><span class="fw-bold">AWS Educate</span></div>
            <div class="d-flex align-items-center gap-2"><i class="fab fa-google fs-3"></i><span class="fw-bold">Google For Education</span></div>
            <div class="d-flex align-items-center gap-2"><i class="fab fa-microsoft fs-3"></i><span class="fw-bold">Microsoft Learn</span></div>
            <div class="d-flex align-items-center gap-2 d-none d-md-flex"><i class="fab fa-github fs-3"></i><span class="fw-bold">GitHub Student</span></div>
        </div>
    </div>
</section>

<!-- Stats Strip -->
<?php if (!isset($site_settings['home_show_stats']) || $site_settings['home_show_stats'] === '1'): ?>
<div class="bg-white stats-strip border-bottom border-light">
    <div class="container py-5">
        <div class="row g-4 text-center justify-content-center">
            <div class="col-6 col-md-3">
                <div class="d-flex flex-column align-items-center justify-content-center gap-3">
                    <div class="icon-56 bg-primary-subtle text-primary rounded-circle flex-shrink-0">
                        <i class="fas fa-book-open fs-4"></i>
                    </div>
                    <div class="text-center">
                        <span class="display-6 fw-extrabold text-dark d-block mb-1" style="letter-spacing: -0.03em;"><?php echo $total_courses_count; ?>+</span>
                        <span class="text-secondary fw-medium"><?php echo t('Konten Belajar', 'Content'); ?></span>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="d-flex flex-column align-items-center justify-content-center gap-3">
                    <div class="icon-56 bg-success-subtle text-success rounded-circle flex-shrink-0">
                        <i class="fas fa-chalkboard-teacher fs-4"></i>
                    </div>
                    <div class="text-center">
                        <span class="display-6 fw-extrabold text-dark d-block mb-1" style="letter-spacing: -0.03em;"><?php echo $total_teachers_count; ?>+</span>
                        <span class="text-secondary fw-medium"><?php echo t('Mentor & Pengajar', 'Teachers'); ?></span>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="d-flex flex-column align-items-center justify-content-center gap-3">
                    <div class="icon-56 bg-info-subtle text-info rounded-circle flex-shrink-0">
                        <i class="fas fa-users fs-4"></i>
                    </div>
                    <div class="text-center">
                        <span class="display-6 fw-extrabold text-dark d-block mb-1" style="letter-spacing: -0.03em;"><?php echo $total_students_count; ?>+</span>
                        <span class="text-secondary fw-medium"><?php echo t('Siswa Aktif', 'Students'); ?></span>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="d-flex flex-column align-items-center justify-content-center gap-3">
                    <div class="icon-56 bg-warning-subtle text-warning rounded-circle flex-shrink-0">
                        <i class="fas fa-award fs-4"></i>
                    </div>
                    <div class="text-center">
                        <span class="display-6 fw-extrabold text-dark d-block mb-1" style="letter-spacing: -0.03em;"><?php echo $total_certificates; ?>+</span>
                        <span class="text-secondary fw-medium"><?php echo t('Sertifikat Resmi', 'Off. Certificate'); ?></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

<!-- Layanan (Kategori Skill Replacement) -->
<?php if ((!isset($site_settings['home_show_categories']) || $site_settings['home_show_categories'] === '1') && !empty($categories)): ?>
<section class="container py-5 mt-4">
    <div class="row mb-5">
        <div class="col-lg-6">
            <h2 class="display-6 fw-extrabold text-dark mb-3 lh-sm" style="letter-spacing: -0.03em;">Dari strategi belajar sampai karir impian,<br>semuanya saling terhubung.</h2>
        </div>
        <div class="col-lg-6">
            <p class="text-secondary lead mb-0" style="font-size: 1.1rem; line-height: 1.7;">REBAS COURSE menggabungkan materi belajar interaktif, proyek nyata, bimbingan mentor, dan komunitas untuk memastikan perjalanan belajarmu lebih terarah dan relevan dengan kebutuhan industri.</p>
        </div>
    </div>
    
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
        <!-- Service 1 (Dynamic Categories if available, falling back to static if none) -->
        <?php if(isset($categories) && count($categories) >= 5): ?>
            <?php foreach (array_slice($categories, 0, 5) as $i => $cat): 
                $colors = ['primary', 'success', 'warning', 'info', 'danger'];
                $color = $colors[$i % count($colors)];
            ?>
            <div class="col">
                <a href="<?php echo base_url('courses?category_id=' . $cat->id); ?>" class="card h-100 border-0 shadow-sm text-decoration-none hover-zoom" style="border-radius: 1rem; transition: all 0.3s ease;">
                    <div class="card-body p-4 p-xl-5 d-flex flex-column">
                        <div class="icon-56 bg-<?php echo $color; ?>-subtle text-<?php echo $color; ?> rounded-3 mb-4 d-flex align-items-center justify-content-center">
                            <i class="fas fa-<?php echo $cat->icon ?: 'folder-open'; ?> fs-4"></i>
                        </div>
                        <h4 class="fw-bold text-dark mb-3"><?php echo htmlspecialchars($cat->name); ?></h4>
                        <p class="text-secondary mb-0 flex-grow-1">Pelajari lebih dalam tentang <?php echo strtolower(htmlspecialchars($cat->name)); ?> dari dasar hingga tingkat lanjut.</p>
                        <div class="mt-4 pt-3 border-top border-light d-flex align-items-center text-<?php echo $color; ?> fw-semibold small">
                            Mulai Belajar <i class="fas fa-arrow-right ms-2"></i>
                        </div>
                    </div>
                </a>
            </div>
            <?php endforeach; ?>
        <?php else: ?>
            <!-- Fallback Static Categories mapping to Learning platform context -->
            <div class="col">
                <a href="<?php echo base_url('courses'); ?>" class="card h-100 border-0 shadow-sm text-decoration-none hover-zoom" style="border-radius: 1rem; transition: all 0.3s ease;">
                    <div class="card-body p-4 p-xl-5 d-flex flex-column">
                        <div class="icon-56 bg-primary-subtle text-primary rounded-3 mb-4 d-flex align-items-center justify-content-center">
                            <i class="fas fa-code fs-4"></i>
                        </div>
                        <h4 class="fw-bold text-dark mb-3">Programming</h4>
                        <p class="text-secondary mb-0 flex-grow-1">Pelajari bahasa pemrograman modern, dari Web, Mobile, hingga AI & Data Science.</p>
                        <div class="mt-4 pt-3 border-top border-light d-flex align-items-center text-primary fw-semibold small">
                            Mulai Belajar <i class="fas fa-arrow-right ms-2"></i>
                        </div>
                    </div>
                </a>
            </div>
            
            <div class="col">
                <a href="<?php echo base_url('courses'); ?>" class="card h-100 border-0 shadow-sm text-decoration-none hover-zoom" style="border-radius: 1rem; transition: all 0.3s ease;">
                    <div class="card-body p-4 p-xl-5 d-flex flex-column">
                        <div class="icon-56 bg-success-subtle text-success rounded-3 mb-4 d-flex align-items-center justify-content-center">
                            <i class="fas fa-paint-brush fs-4"></i>
                        </div>
                        <h4 class="fw-bold text-dark mb-3">Desain UI/UX</h4>
                        <p class="text-secondary mb-0 flex-grow-1">Kuasai seni merancang antarmuka pengguna dan pengalaman yang luar biasa.</p>
                        <div class="mt-4 pt-3 border-top border-light d-flex align-items-center text-success fw-semibold small">
                            Mulai Belajar <i class="fas fa-arrow-right ms-2"></i>
                        </div>
                    </div>
                </a>
            </div>
            
            <div class="col">
                <a href="<?php echo base_url('courses'); ?>" class="card h-100 border-0 shadow-sm text-decoration-none hover-zoom" style="border-radius: 1rem; transition: all 0.3s ease;">
                    <div class="card-body p-4 p-xl-5 d-flex flex-column">
                        <div class="icon-56 bg-warning-subtle text-warning rounded-3 mb-4 d-flex align-items-center justify-content-center">
                            <i class="fas fa-bullhorn fs-4"></i>
                        </div>
                        <h4 class="fw-bold text-dark mb-3">Digital Marketing</h4>
                        <p class="text-secondary mb-0 flex-grow-1">Strategi pemasaran digital, SEO, Social Media, hingga periklanan online.</p>
                        <div class="mt-4 pt-3 border-top border-light d-flex align-items-center text-warning fw-semibold small">
                            Mulai Belajar <i class="fas fa-arrow-right ms-2"></i>
                        </div>
                    </div>
                </a>
            </div>
            
            <div class="col">
                <a href="<?php echo base_url('courses'); ?>" class="card h-100 border-0 shadow-sm text-decoration-none hover-zoom" style="border-radius: 1rem; transition: all 0.3s ease;">
                    <div class="card-body p-4 p-xl-5 d-flex flex-column">
                        <div class="icon-56 bg-info-subtle text-info rounded-3 mb-4 d-flex align-items-center justify-content-center">
                            <i class="fas fa-briefcase fs-4"></i>
                        </div>
                        <h4 class="fw-bold text-dark mb-3">Business & Management</h4>
                        <p class="text-secondary mb-0 flex-grow-1">Tingkatkan skill kepemimpinan, manajemen proyek, dan pengembangan karir.</p>
                        <div class="mt-4 pt-3 border-top border-light d-flex align-items-center text-info fw-semibold small">
                            Mulai Belajar <i class="fas fa-arrow-right ms-2"></i>
                        </div>
                    </div>
                </a>
            </div>
            
            <div class="col">
                <a href="<?php echo base_url('courses'); ?>" class="card h-100 border-0 shadow-sm text-decoration-none hover-zoom" style="border-radius: 1rem; transition: all 0.3s ease;">
                    <div class="card-body p-4 p-xl-5 d-flex flex-column">
                        <div class="icon-56 bg-danger-subtle text-danger rounded-3 mb-4 d-flex align-items-center justify-content-center">
                            <i class="fas fa-language fs-4"></i>
                        </div>
                        <h4 class="fw-bold text-dark mb-3">Bahasa Asing</h4>
                        <p class="text-secondary mb-0 flex-grow-1">Persiapkan dirimu untuk go-international dengan menguasai bahasa asing.</p>
                        <div class="mt-4 pt-3 border-top border-light d-flex align-items-center text-danger fw-semibold small">
                            Mulai Belajar <i class="fas fa-arrow-right ms-2"></i>
                        </div>
                    </div>
                </a>
            </div>
        <?php endif; ?>
        
        <!-- View All Categories Box -->
        <div class="col">
            <a href="<?php echo base_url('courses'); ?>" class="card h-100 border-0 shadow-sm text-decoration-none hover-zoom bg-dark text-white" style="border-radius: 1rem; transition: all 0.3s ease;">
                <div class="card-body p-4 p-xl-5 d-flex flex-column justify-content-center align-items-center text-center">
                    <h4 class="fw-bold mb-3">Lihat Semua Kategori</h4>
                    <p class="text-white-50 mb-4 flex-grow-1">Jelajahi berbagai bidang ilmu lain yang kami sediakan.</p>
                    <div class="icon-56 bg-white text-dark rounded-circle d-flex align-items-center justify-content-center">
                        <i class="fas fa-arrow-right fs-4"></i>
                    </div>
                </div>
            </a>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- Why REBAS COURSE Section -->
<section class="bg-dark text-white py-5 my-5">
    <div class="container py-4">
        <div class="row mb-5">
            <div class="col-lg-6">
                <span class="text-warning fw-semibold small text-uppercase tracking-wide d-block mb-2">Kenapa REBAS COURSE</span>
                <h2 class="display-6 fw-extrabold mb-4 lh-sm" style="letter-spacing: -0.03em;">Platform belajar online yang benar-benar peduli hasilmu</h2>
            </div>
            <div class="col-lg-6">
                <p class="text-white-75 lead mb-0" style="font-size: 1.1rem; line-height: 1.7;">Belajar bukan sekadar menonton video. Ia harus terstruktur, membangun portofolio, dan didukung oleh ahli yang siap menjawab kebingunganmu. Itulah alasan kami hadir.</p>
            </div>
        </div>
        
        <div class="row g-4 mt-2">
            <div class="col-md-6 col-lg-3">
                <div class="p-4 rounded-4" style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1);">
                    <div class="text-warning mb-3"><i class="fas fa-sitemap fs-3"></i></div>
                    <h5 class="fw-bold mb-2">Kurikulum Terstruktur</h5>
                    <p class="text-white-50 small mb-0">Alur belajar (Learning Paths) yang jelas dari level pemula hingga mahir, tanpa perlu bingung mulai dari mana.</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="p-4 rounded-4" style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1);">
                    <div class="text-warning mb-3"><i class="fas fa-user-tie fs-3"></i></div>
                    <h5 class="fw-bold mb-2">Mentor Praktisi</h5>
                    <p class="text-white-50 small mb-0">Belajar langsung dari mereka yang terjun di industri. Dapatkan bimbingan dan review tugas langsung dari ahlinya.</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="p-4 rounded-4" style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1);">
                    <div class="text-warning mb-3"><i class="fas fa-project-diagram fs-3"></i></div>
                    <h5 class="fw-bold mb-2">Project-Based</h5>
                    <p class="text-white-50 small mb-0">Bukan sekadar teori. Praktikkan langsung ilmu yang dipelajari dan bangun portofolio menonjol untuk dilirik HRD.</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="p-4 rounded-4" style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1);">
                    <div class="text-warning mb-3"><i class="fas fa-users fs-3"></i></div>
                    <h5 class="fw-bold mb-2">Komunitas Aktif</h5>
                    <p class="text-white-50 small mb-0">Bergabung dengan forum dan grup belajar. Diskusikan masalah, bagikan insight, dan perluas networkingmu.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Unggulan / Featured (Product Ecosystem Replacement) -->
<?php if ((!isset($site_settings['home_show_featured']) || $site_settings['home_show_featured'] === '1') && !empty($featured_courses)): ?>
<section class="bg-light py-5">
    <div class="container py-4">
        <div class="row mb-5 align-items-end">
            <div class="col-lg-6">
                <span class="text-primary fw-semibold small text-uppercase tracking-wide d-block mb-2">Konten Pilihan</span>
                <h2 class="display-6 fw-extrabold text-dark mb-0 lh-sm" style="letter-spacing: -0.03em;">Mulai perjalanan belajarmu dari sini</h2>
            </div>
            <div class="col-lg-6 text-lg-end mt-4 mt-lg-0">
                <p class="text-secondary lead mb-0" style="font-size: 1.1rem; line-height: 1.7; max-width: 500px; margin-left: auto;">Kelas dan materi terbaik yang telah dikurasi oleh tim ahli kami untuk memastikan kamu mendapatkan pemahaman yang kuat.</p>
            </div>
        </div>
        
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4">
            <?php foreach ($featured_courses as $course): ?>
                <div class="col animate-fade-in-up">
                    <div class="card h-100 border-0 shadow-sm rounded-4 bg-white overflow-hidden hover-zoom d-flex flex-column" style="transition: all 0.3s ease;">
                        <div class="position-relative overflow-hidden" style="aspect-ratio: 16/9;">
                            <img src="<?php echo base_url('uploads/courses/' . $course->thumbnail); ?>" onerror="this.src='https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=400&auto=format&fit=crop&q=60';" alt="" class="w-100 h-100 object-fit-cover">
                            <div class="position-absolute top-0 start-0 m-3">
                                <span class="badge bg-dark text-white rounded-pill px-3 py-2 shadow-sm fw-medium"><?php echo content_type_label($course->content_type); ?></span>
                            </div>
                        </div>
                        <div class="card-body p-4 d-flex flex-column flex-grow-1">
                            <div class="d-flex align-items-center gap-2 mb-3">
                                <span class="text-primary small fw-semibold"><i class="fas fa-folder-open me-1"></i><?php echo htmlspecialchars($course->category_name ?? ''); ?></span>
                                <span class="text-secondary opacity-50">•</span>
                                <span class="text-secondary small fw-medium"><i class="fas fa-user me-1"></i><?php echo htmlspecialchars($course->teacher_name); ?></span>
                            </div>
                            <h5 class="fw-bold text-dark mb-3 lh-sm" style="font-size: 1.1rem;"><?php echo htmlspecialchars($course->title); ?></h5>
                            
                            <div class="mb-4">
                                <span class="badge bg-light text-dark border px-2 py-1 rounded-pill small fw-medium"><?php echo skill_level_label($course->skill_level); ?></span>
                            </div>
                            
                            <div class="mt-auto pt-3 border-top border-light d-flex align-items-center justify-content-between">
                                <span class="fs-5 fw-bold text-dark"><?php echo $course->price > 0 ? 'Rp ' . number_format($course->price, 0, ',', '.') : '<span class="text-success">Gratis</span>'; ?></span>
                                <a href="<?php echo base_url('courses/detail/' . $course->slug); ?>" class="btn btn-outline-dark btn-sm rounded-pill px-3 fw-semibold transition-all hover-bg-dark">Detail <i class="fas fa-arrow-right ms-1"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- Konten Terbaru -->
<?php if ((!isset($site_settings['home_show_recent']) || $site_settings['home_show_recent'] === '1') && !empty($recent_courses)): ?>
<section class="py-5 bg-white">
    <div class="container py-4">
        <div class="d-flex flex-column flex-md-row align-items-md-end justify-content-between mb-5 gap-4">
            <div class="mb-0">
                <span class="text-primary fw-semibold small text-uppercase tracking-wide d-block mb-2">Terbaru</span>
                <h2 class="display-6 fw-extrabold text-dark mb-2 lh-sm" style="letter-spacing: -0.03em;">Materi fresh untuk skill terbarumu</h2>
                <p class="text-secondary lead mb-0" style="font-size: 1.1rem; max-width: 500px;">Kami terus menambahkan konten baru agar kamu selalu relevan dengan perkembangan industri.</p>
            </div>
            <a href="<?php echo base_url('courses'); ?>" class="btn btn-outline-dark rounded-pill px-4 py-2 fw-semibold d-inline-flex align-items-center gap-2 flex-shrink-0">
                Lihat Semua Materi <i class="fas fa-arrow-right"></i>
            </a>
        </div>
        
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            <?php $recent_limit = (int)(setting('home_recent_count', 6)); ?>
            <?php foreach(array_slice($recent_courses, 0, $recent_limit) as $i => $course): ?>
                <div class="col animate-fade-in-up stagger-<?php echo min($i + 1, 8); ?>">
                    <div class="card h-100 border border-light shadow-sm rounded-4 bg-white overflow-hidden hover-zoom d-flex flex-column" style="transition: all 0.3s ease;">
                        <div class="position-relative overflow-hidden" style="aspect-ratio: 16/10;">
                            <img src="<?php echo base_url('uploads/courses/' . $course->thumbnail); ?>" onerror="this.src='https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=500&auto=format&fit=crop&q=60';" alt="" class="w-100 h-100 object-fit-cover">
                            <div class="position-absolute top-0 start-0 m-3">
                                <span class="badge bg-white text-dark rounded-pill px-3 py-2 shadow-sm fw-medium border"><?php echo content_type_label($course->content_type); ?></span>
                            </div>
                        </div>
                        <div class="card-body p-4 d-flex flex-column flex-grow-1">
                            <div class="d-flex align-items-center justify-content-between mb-3">
                                <span class="text-primary small fw-semibold bg-primary-subtle px-2 py-1 rounded-pill"><i class="fas fa-folder-open me-1"></i><?php echo htmlspecialchars($course->category_name ?? ''); ?></span>
                                <span class="text-secondary small fw-medium"><i class="fas fa-user-circle me-1"></i><?php echo htmlspecialchars($course->teacher_name); ?></span>
                            </div>
                            
                            <h5 class="fw-bold text-dark mb-2 lh-sm flex-grow-0" style="font-size: 1.15rem;"><?php echo htmlspecialchars($course->title); ?></h5>
                            <p class="text-secondary small mb-4 flex-grow-1" style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;"><?php echo htmlspecialchars($course->description); ?></p>
                            
                            <div class="d-flex gap-2 mb-4 flex-wrap">
                                <span class="badge bg-light text-secondary border px-2 py-1 rounded-pill small fw-medium"><i class="fas fa-layer-group me-1"></i><?php echo skill_level_label($course->skill_level); ?></span>
                            </div>
                            
                            <div class="mt-auto pt-3 border-top border-light d-flex align-items-center justify-content-between">
                                <span class="fs-5 fw-bold text-dark"><?php echo $course->price > 0 ? 'Rp ' . number_format($course->price, 0, ',', '.') : '<span class="text-success">Gratis</span>'; ?></span>
                                <a href="<?php echo base_url('courses/detail/' . $course->slug); ?>" class="btn btn-dark btn-sm rounded-pill px-3 fw-semibold transition-all">Pelajari <i class="fas fa-arrow-right ms-1"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="text-center mt-5 d-md-none">
            <a href="<?php echo base_url('courses'); ?>" class="btn btn-dark rounded-pill px-4 py-2 fw-semibold w-100">Lihat Semua Materi</a>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- Testimoni -->
<section class="py-5">
    <div class="container py-4">
        <div class="row mb-5 align-items-end">
            <div class="col-lg-6">
                <span class="text-primary fw-semibold small text-uppercase tracking-wide d-block mb-2">Testimoni Siswa</span>
                <h2 class="display-6 fw-extrabold text-dark mb-0 lh-sm" style="letter-spacing: -0.03em;">Apa kata mereka tentang REBAS COURSE</h2>
            </div>
            <div class="col-lg-6 text-lg-end mt-4 mt-lg-0">
                 <p class="text-secondary lead mb-0" style="font-size: 1.1rem; line-height: 1.7; max-width: 500px; margin-left: auto;">Bergabung bersama ribuan siswa yang sudah merasakan manfaat belajar di REBAS COURSE dalam mengembangkan karir mereka.</p>
            </div>
        </div>
        
        <div class="row g-4">
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 border-0 shadow-sm rounded-4 bg-white p-4 p-xl-5" style="transition: all 0.3s ease;">
                    <div class="text-warning mb-4">
                        <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                    </div>
                    <p class="text-dark fw-medium mb-4 flex-grow-1" style="font-size: 1.05rem; line-height: 1.6;">"Materinya sangat terstruktur dan mudah dipahami. Dari yang awalnya tidak bisa coding, sekarang saya sudah bisa membuat website sendiri. Thanks REBAS!"</p>
                    <div class="d-flex align-items-center gap-3">
                        <img src="https://ui-avatars.com/api/?name=Rina+Kusuma&background=4361ee&color=fff" alt="Rina Kusuma" class="rounded-circle object-fit-cover" width="48" height="48">
                        <div>
                            <h6 class="fw-bold mb-0">Rina Kusuma</h6>
                            <p class="text-secondary small mb-0">Siswa Web Development</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 border-0 shadow-sm rounded-4 bg-white p-4 p-xl-5" style="transition: all 0.3s ease;">
                    <div class="text-warning mb-4">
                        <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                    </div>
                    <p class="text-dark fw-medium mb-4 flex-grow-1" style="font-size: 1.05rem; line-height: 1.6;">"Sesi mentoring benar-benar membantu saya memahami konsep yang sulit. Mentor sangat sabar dan memberikan feedback yang detail untuk setiap tugas."</p>
                    <div class="d-flex align-items-center gap-3">
                        <img src="https://ui-avatars.com/api/?name=Dimas+Pratama&background=f59e0b&color=fff" alt="Dimas Pratama" class="rounded-circle object-fit-cover" width="48" height="48">
                        <div>
                            <h6 class="fw-bold mb-0">Dimas Pratama</h6>
                            <p class="text-secondary small mb-0">Siswa Program Mentorship</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 border-0 shadow-sm rounded-4 bg-white p-4 p-xl-5" style="transition: all 0.3s ease;">
                     <div class="text-warning mb-4">
                        <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                    </div>
                    <p class="text-dark fw-medium mb-4 flex-grow-1" style="font-size: 1.05rem; line-height: 1.6;">"Sertifikat dari REBAS COURSE membantu saya mendapat promosi di kantor. Materi yang diajarkan sangat relevan dengan kebutuhan industri saat ini."</p>
                    <div class="d-flex align-items-center gap-3">
                        <img src="https://ui-avatars.com/api/?name=Sari+Indah&background=10b981&color=fff" alt="Sari Indah" class="rounded-circle object-fit-cover" width="48" height="48">
                        <div>
                            <h6 class="fw-bold mb-0">Sari Indah</h6>
                            <p class="text-secondary small mb-0">Siswa Digital Marketing</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row mt-5 text-center g-4 justify-content-center border-top border-light pt-5">
            <div class="col-6 col-md-3">
                <span class="display-5 fw-extrabold text-dark mb-1 d-block"><?php echo $total_courses_count; ?>+</span>
                <div class="text-secondary fw-medium">Total Konten</div>
            </div>
            <div class="col-6 col-md-3">
                <span class="display-5 fw-extrabold text-dark mb-1 d-block"><?php echo $total_students_count; ?>+</span>
                <div class="text-secondary fw-medium">Siswa Bergabung</div>
            </div>
            <div class="col-6 col-md-3">
                <span class="display-5 fw-extrabold text-dark mb-1 d-block"><?php echo $total_teachers_count; ?>+</span>
                <div class="text-secondary fw-medium">Pengajar Ahli</div>
            </div>
            <div class="col-6 col-md-3">
                <span class="display-5 fw-extrabold text-dark mb-1 d-block">4.9</span>
                <div class="text-secondary fw-medium">Rating Rata-rata</div>
            </div>
        </div>
    </div>
</section>

<!-- Learning Journey -->
<section class="bg-light py-5">
    <div class="container py-4">
        <div class="row align-items-center mb-5">
            <div class="col-lg-6">
                <span class="text-primary fw-semibold small text-uppercase tracking-wide d-block mb-2">Alur Belajar</span>
                <h2 class="display-6 fw-extrabold text-dark mb-4 lh-sm" style="letter-spacing: -0.03em;">Perjalanan belajar yang jelas dari awal hingga mahir</h2>
                <p class="text-secondary lead mb-4" style="font-size: 1.1rem; line-height: 1.7;">Kami merancang setiap jalur belajar dengan struktur yang rapi sehingga kamu tidak perlu bingung harus mulai dari mana. Cukup ikuti langkah-langkahnya.</p>
                <div class="d-flex flex-column gap-3">
                    <div class="d-flex align-items-start gap-3">
                        <div class="icon-32 bg-primary-subtle text-primary rounded-circle d-flex align-items-center justify-content-center flex-shrink-0 mt-1"><i class="fas fa-check"></i></div>
                        <div>
                            <h6 class="fw-bold mb-1">Progress terlacak</h6>
                            <p class="text-secondary small mb-0">Lihat sejauh mana perjalanan belajarmu kapan saja melalui dashboard.</p>
                        </div>
                    </div>
                    <div class="d-flex align-items-start gap-3">
                        <div class="icon-32 bg-primary-subtle text-primary rounded-circle d-flex align-items-center justify-content-center flex-shrink-0 mt-1"><i class="fas fa-check"></i></div>
                        <div>
                            <h6 class="fw-bold mb-1">Materi terstruktur</h6>
                            <p class="text-secondary small mb-0">Setiap kelas dirancang bertahap dari dasar hingga studi kasus nyata.</p>
                        </div>
                    </div>
                    <div class="d-flex align-items-start gap-3">
                        <div class="icon-32 bg-primary-subtle text-primary rounded-circle d-flex align-items-center justify-content-center flex-shrink-0 mt-1"><i class="fas fa-check"></i></div>
                        <div>
                            <h6 class="fw-bold mb-1">Evaluasi & Sertifikat</h6>
                            <p class="text-secondary small mb-0">Uji pemahamanmu lewat quiz dan proyek, lalu dapatkan sertifikat kelulusan.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-5 offset-lg-1 mt-5 mt-lg-0">
                <div class="position-relative">
                    <div class="position-absolute top-0 bottom-0 start-0 border-start border-2 border-primary ms-3" style="z-index: 0;"></div>
                    
                    <div class="d-flex gap-3 position-relative z-index-1 mb-4">
                        <div class="icon-32 bg-primary text-white rounded-circle d-flex align-items-center justify-content-center flex-shrink-0 fw-bold border border-4 border-light shadow-sm" style="margin-left: 2px;">1</div>
                        <div class="pt-1">
                            <h6 class="fw-bold mb-1">Pilih Kelas & Daftar</h6>
                            <p class="text-secondary small mb-0">Tentukan skill yang ingin kamu kuasai dan daftar dalam hitungan detik.</p>
                        </div>
                    </div>
                    
                    <div class="d-flex gap-3 position-relative z-index-1 mb-4">
                        <div class="icon-32 bg-white text-primary border border-2 border-primary rounded-circle d-flex align-items-center justify-content-center flex-shrink-0 fw-bold shadow-sm" style="margin-left: 2px;">2</div>
                        <div class="pt-1">
                            <h6 class="fw-bold mb-1">Pelajari Materi</h6>
                            <p class="text-secondary small mb-0">Ikuti video, baca materi, dan praktikkan langsung dengan studi kasus nyata.</p>
                        </div>
                    </div>
                    
                    <div class="d-flex gap-3 position-relative z-index-1 mb-4">
                        <div class="icon-32 bg-white text-primary border border-2 border-primary rounded-circle d-flex align-items-center justify-content-center flex-shrink-0 fw-bold shadow-sm" style="margin-left: 2px;">3</div>
                        <div class="pt-1">
                            <h6 class="fw-bold mb-1">Kerjakan Tugas & Quiz</h6>
                            <p class="text-secondary small mb-0">Uji pemahaman dengan soal-soal interaktif dan tugas berbasis proyek nyata.</p>
                        </div>
                    </div>
                    
                    <div class="d-flex gap-3 position-relative z-index-1 mb-4">
                        <div class="icon-32 bg-white text-primary border border-2 border-primary rounded-circle d-flex align-items-center justify-content-center flex-shrink-0 fw-bold shadow-sm" style="margin-left: 2px;">4</div>
                        <div class="pt-1">
                            <h6 class="fw-bold mb-1">Dapatkan Sertifikat</h6>
                            <p class="text-secondary small mb-0">Raih sertifikat resmi yang diakui industri untuk boost karirmu.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Pricing / Harga -->
<section class="bg-light py-5">
    <div class="container py-4">
        <div class="text-center mb-5">
            <span class="text-primary fw-semibold small text-uppercase tracking-wide d-block mb-2">Pilihan Berlangganan</span>
            <h2 class="display-6 fw-extrabold text-dark mb-3 lh-sm" style="letter-spacing: -0.03em;">Investasi pada dirimu sendiri</h2>
            <p class="text-secondary lead mb-0" style="font-size: 1.1rem; max-width: 600px; margin: 0 auto;">Pilih paket belajar yang sesuai dengan kebutuhan dan targetmu. Fleksibel, tanpa biaya tersembunyi.</p>
        </div>
        
        <div class="row g-4 justify-content-center">
            <!-- Pricing 1 -->
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 border-0 shadow-sm rounded-4 bg-white hover-zoom" style="transition: all 0.3s ease;">
                    <div class="card-body p-4 p-xl-5 d-flex flex-column">
                        <h4 class="fw-bold text-dark mb-2">Basic</h4>
                        <p class="text-secondary small mb-4 pb-3 border-bottom border-light">Cocok untuk pemula yang ingin coba-coba</p>
                        
                        <div class="mb-4">
                            <span class="text-secondary small d-block mb-1">Mulai dari</span>
                            <div class="d-flex align-items-baseline gap-1">
                                <span class="fs-5 fw-bold text-dark">Rp</span>
                                <span class="display-6 fw-bold text-dark">0</span>
                                <span class="text-secondary">/bulan</span>
                            </div>
                        </div>
                        
                        <ul class="list-unstyled mb-4 flex-grow-1">
                            <li class="d-flex align-items-start gap-2 mb-3">
                                <i class="fas fa-check text-success mt-1"></i>
                                <span class="text-secondary small">Akses ke 10+ materi dasar (Gratis)</span>
                            </li>
                            <li class="d-flex align-items-start gap-2 mb-3">
                                <i class="fas fa-check text-success mt-1"></i>
                                <span class="text-secondary small">Bergabung dengan forum komunitas</span>
                            </li>
                            <li class="d-flex align-items-start gap-2 mb-3 text-muted">
                                <i class="fas fa-times mt-1"></i>
                                <span class="small text-decoration-line-through">Sertifikat kelulusan</span>
                            </li>
                            <li class="d-flex align-items-start gap-2 mb-3 text-muted">
                                <i class="fas fa-times mt-1"></i>
                                <span class="small text-decoration-line-through">Sesi live mentoring mingguan</span>
                            </li>
                        </ul>
                        
                        <a href="<?php echo base_url('auth/register'); ?>" class="btn btn-outline-primary w-100 py-2 fw-semibold rounded-pill mt-auto">Daftar Gratis</a>
                    </div>
                </div>
            </div>
            
            <!-- Pricing 2 (Popular) -->
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 border-2 border-primary shadow-lg rounded-4 bg-white position-relative hover-zoom" style="transition: all 0.3s ease; transform: scale(1.02); z-index: 1;">
                    <div class="position-absolute top-0 start-50 translate-middle">
                        <span class="badge bg-primary text-white rounded-pill px-3 py-2 fw-semibold shadow-sm text-uppercase tracking-wide">Paling Populer</span>
                    </div>
                    <div class="card-body p-4 p-xl-5 d-flex flex-column mt-2">
                        <h4 class="fw-bold text-dark mb-2">Pro Learner</h4>
                        <p class="text-secondary small mb-4 pb-3 border-bottom border-light">Untuk kamu yang serius ingin berkarir</p>
                        
                        <div class="mb-4">
                            <span class="text-secondary small d-block mb-1">Mulai dari</span>
                            <div class="d-flex align-items-baseline gap-1">
                                <span class="fs-5 fw-bold text-dark">Rp</span>
                                <span class="display-6 fw-bold text-dark">99rb</span>
                                <span class="text-secondary">/bulan</span>
                            </div>
                        </div>
                        
                        <ul class="list-unstyled mb-4 flex-grow-1">
                            <li class="d-flex align-items-start gap-2 mb-3">
                                <i class="fas fa-check text-success mt-1"></i>
                                <span class="text-secondary small">Akses ke semua materi pembelajaran</span>
                            </li>
                            <li class="d-flex align-items-start gap-2 mb-3">
                                <i class="fas fa-check text-success mt-1"></i>
                                <span class="text-secondary small">Akses ke Learning Paths & Ujian</span>
                            </li>
                            <li class="d-flex align-items-start gap-2 mb-3">
                                <i class="fas fa-check text-success mt-1"></i>
                                <span class="text-secondary small">Sertifikat kelulusan yang diakui</span>
                            </li>
                            <li class="d-flex align-items-start gap-2 mb-3">
                                <i class="fas fa-check text-success mt-1"></i>
                                <span class="text-secondary small">Diskon 50% untuk Seminar/Webinar</span>
                            </li>
                        </ul>
                        
                        <a href="<?php echo base_url('subscription'); ?>" class="btn btn-primary w-100 py-2 fw-semibold rounded-pill mt-auto shadow-sm">Mulai Berlangganan</a>
                    </div>
                </div>
            </div>
            
            <!-- Pricing 3 -->
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 border-0 shadow-sm rounded-4 bg-white hover-zoom" style="transition: all 0.3s ease;">
                    <div class="card-body p-4 p-xl-5 d-flex flex-column">
                        <h4 class="fw-bold text-dark mb-2">Mentorship</h4>
                        <p class="text-secondary small mb-4 pb-3 border-bottom border-light">Fokus intensif dengan bimbingan ahli</p>
                        
                        <div class="mb-4">
                            <span class="text-secondary small d-block mb-1">Mulai dari</span>
                            <div class="d-flex align-items-baseline gap-1">
                                <span class="fs-5 fw-bold text-dark">Rp</span>
                                <span class="display-6 fw-bold text-dark">350rb</span>
                                <span class="text-secondary">/bulan</span>
                            </div>
                        </div>
                        
                        <ul class="list-unstyled mb-4 flex-grow-1">
                            <li class="d-flex align-items-start gap-2 mb-3">
                                <i class="fas fa-check text-success mt-1"></i>
                                <span class="text-secondary small">Semua fitur di paket Pro Learner</span>
                            </li>
                            <li class="d-flex align-items-start gap-2 mb-3">
                                <i class="fas fa-check text-success mt-1"></i>
                                <span class="text-secondary small">Sesi 1-on-1 dengan praktisi (4x/bulan)</span>
                            </li>
                            <li class="d-flex align-items-start gap-2 mb-3">
                                <i class="fas fa-check text-success mt-1"></i>
                                <span class="text-secondary small">Review CV & Portofolio eksklusif</span>
                            </li>
                            <li class="d-flex align-items-start gap-2 mb-3">
                                <i class="fas fa-check text-success mt-1"></i>
                                <span class="text-secondary small">Grup diskusi prioritas via Telegram</span>
                            </li>
                        </ul>
                        
                        <a href="<?php echo base_url('subscription'); ?>" class="btn btn-outline-primary w-100 py-2 fw-semibold rounded-pill mt-auto">Pilih Mentorship</a>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="text-center mt-5">
            <p class="text-secondary">Butuh paket khusus untuk tim atau perusahaan? <a href="<?php echo base_url('contact'); ?>" class="text-primary fw-semibold text-decoration-none border-bottom border-primary pb-1">Hubungi kami untuk penawaran diskon group.</a></p>
        </div>
    </div>
</section>

<!-- CTA Section -->
<?php if (!isset($site_settings['home_show_cta']) || $site_settings['home_show_cta'] === '1'): ?>
<section class="container py-5 my-4">
    <div class="position-relative overflow-hidden rounded-4 bg-primary text-white shadow-lg">
        <div class="position-absolute top-0 end-0 w-50 h-100 opacity-25 d-none d-md-block">
            <div style="background: radial-gradient(circle at center, rgba(255,255,255,0.4) 0%, transparent 70%); width: 500px; height: 500px; border-radius: 50%; position: absolute; top: -150px; right: -150px;"></div>
        </div>
        <div class="position-relative p-5 text-center text-lg-start">
            <div class="row align-items-center justify-content-center justify-content-lg-between g-4">
                <div class="col-lg-8">
                    <h2 class="display-6 fw-extrabold text-white mb-3 lh-sm" style="letter-spacing: -0.03em;"><?php echo t(setting('home_cta_title', 'Siap Menguasai Skill Baru?'), setting('home_cta_title_en', 'Ready to Master a New Skill?')); ?></h2>
                    <p class="lead mb-0 text-white-75" style="font-size: 1.1rem; max-width: 600px;"><?php echo t(setting('home_cta_subtitle', 'Daftar gratis sekarang dan mulai perjalanan belajarmu bersama ribuan siswa lainnya.'), setting('home_cta_subtitle_en', 'Register for free and start your learning journey with thousands of other students.')); ?></p>
                </div>
                <div class="col-lg-4 text-center text-lg-end d-flex flex-column gap-3 align-items-center align-items-lg-end">
                    <a href="<?php echo base_url(setting('home_cta_button_link', 'auth/register')); ?>" class="btn btn-light text-primary btn-lg px-4 py-3 fw-bold rounded-pill shadow-sm d-inline-flex align-items-center gap-3 w-100 justify-content-center" style="max-width: 300px;">
                        <i class="fas fa-user-plus fs-5"></i>
                        <div class="text-start lh-sm">
                            <div class="fs-6"><?php echo t(setting('home_cta_button_text', 'Daftar Gratis Sekarang'), setting('home_cta_button_text_en', 'Register Free Now')); ?></div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>
