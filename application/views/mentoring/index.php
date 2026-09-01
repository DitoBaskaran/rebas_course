<?php $_mob_mentor_panel = $this->session->userdata('logged_in'); ?>

<?php if ($_mob_mentor_panel): ?>
<!-- ============ PANEL STUDENT (desktop + mobile app-style) ============ -->
<div class="container-fluid py-4" style="padding-top: 0px !important; max-width: 1100px;">

    <!-- Mobile App-Style -->
    <div class="dashboard-mobile-only">
        <!-- Header -->
        <div class="d-flex align-items-center justify-content-between mb-3">
            <div>
                <h5 class="fw-extrabold mb-0" style="color: #0D1830; font-size: 1.15rem; letter-spacing: -0.02em;">
                    <?php echo t('Mentoring', 'Mentoring'); ?>
                </h5>
                <small style="color: #78716c; font-size: 0.72rem;"><?php echo t('Sesi 1-on-1 dengan mentor ahli', '1-on-1 sessions with expert mentors'); ?></small>
            </div>
            <a href="<?php echo base_url('mentoring/my_sessions'); ?>" class="btn px-3 py-2 fw-semibold rounded-pill" style="background:#E0F2F1; color:#009688; font-size:0.72rem;">
                <i class="fas fa-calendar-check me-1" style="font-size:0.65rem;"></i> <?php echo t('Sesi Saya', 'My Sessions'); ?>
            </a>
        </div>

        <!-- Search -->
        <form method="get" class="d-flex gap-2 mb-3">
            <?php if ($selected_category): ?>
                <input type="hidden" name="category" value="<?php echo $selected_category; ?>">
            <?php endif; ?>
            <div class="flex-fill position-relative">
                <i class="fas fa-search position-absolute" style="left: 14px; top: 50%; transform: translateY(-50%); color: #a3a3a3; font-size: 0.8rem;"></i>
                <input type="text" name="search" class="form-control" value="<?php echo htmlspecialchars($search_query ?? ''); ?>" placeholder="<?php echo t('Cari mentor...', 'Search mentors...'); ?>" style="padding-left: 36px; border-radius: 100px; border-color: #e7e5e4; font-size: 0.82rem; height: 42px; background: #fff;">
            </div>
            <button type="submit" class="btn px-3 fw-semibold flex-shrink-0" style="background: #009688; color: #fff; border-radius: 100px; font-size: 0.82rem; height: 42px;">
                <i class="fas fa-search"></i>
            </button>
        </form>

        <!-- Category chips (horizontal scroll) -->
        <div class="d-flex gap-2 overflow-auto pb-1 mb-2" style="scrollbar-width: none; -ms-overflow-style: none;">
            <a href="<?php echo base_url('mentoring'); ?>" class="px-3 py-2 rounded-pill fw-semibold text-decoration-none flex-shrink-0" style="font-size: 0.72rem; background: <?php echo !$selected_category ? '#009688' : '#E6EBEF'; ?>; color: <?php echo !$selected_category ? '#fff' : '#57534e'; ?>;">
                <?php echo t('Semua', 'All'); ?>
            </a>
            <?php foreach ($categories as $cat): ?>
                <a href="<?php echo base_url('mentoring?category=' . $cat->id); ?>" class="px-3 py-2 rounded-pill fw-semibold text-decoration-none flex-shrink-0" style="font-size: 0.72rem; background: <?php echo $selected_category == $cat->id ? '#009688' : '#E6EBEF'; ?>; color: <?php echo $selected_category == $cat->id ? '#fff' : '#57534e'; ?>;">
                    <?php echo htmlspecialchars(t($cat->name, $cat->name_en)); ?>
                </a>
            <?php endforeach; ?>
            <a href="<?php echo base_url('mentoring/packages'); ?>" class="px-3 py-2 rounded-pill fw-semibold text-decoration-none flex-shrink-0" style="font-size: 0.72rem; background: #FEF3C7; color: #92400E;">
                <i class="fas fa-shopping-bag" style="font-size: 0.6rem;"></i> <?php echo t('Paket', 'Packages'); ?>
            </a>
        </div>

        <!-- Mentor cards (vertical list, app-style) -->
        <?php if (empty($mentors)): ?>
            <div class="mob-empty">
                <i class="fas fa-user-tie"></i>
                <p><?php echo t('Tidak ada mentor ditemukan.', 'No mentors found.'); ?></p>
            </div>
        <?php else: ?>
            <div class="d-flex flex-column gap-3">
                <?php foreach ($mentors as $mentor): ?>
                    <a href="<?php echo base_url('mentoring/detail/' . encode_id($mentor->id)); ?>" class="mob-course-card text-decoration-none w-100" style="width:auto;">
                        <div class="d-flex align-items-center gap-3 mb-2">
                            <?php if (!empty($mentor->avatar) && file_exists(FCPATH . 'uploads/mentors/' . $mentor->avatar)): ?>
                            <img src="<?php echo base_url('uploads/mentors/' . $mentor->avatar); ?>" alt="" class="flex-shrink-0" style="width: 46px; height: 46px; border-radius: 50%; object-fit: cover; background: #E0F2F1;">
                            <?php else: ?>
                            <span class="mob-avatar flex-shrink-0" style="background: linear-gradient(135deg,#009688,#00796B); color:#fff; font-size: 1rem; width: 46px; height: 46px; border-radius: 50%; display:inline-flex; align-items:center; justify-content:center;">
                                <?php echo strtoupper(substr($mentor->name, 0, 1)); ?>
                            </span>
                            <?php endif; ?>
                            <div class="min-w-0 flex-fill">
                                <div class="fw-bold text-truncate" style="color: #0D1830; font-size: 0.85rem;"><?php echo htmlspecialchars($mentor->name); ?></div>
                                <div class="text-truncate" style="color: #78716c; font-size: 0.72rem;"><?php echo htmlspecialchars(t($mentor->title, $mentor->title_en)); ?></div>
                                <div class="d-flex align-items-center gap-1 mt-1">
                                    <i class="fas fa-star" style="color: #FBBF24; font-size: 0.6rem;"></i>
                                    <span class="fw-bold" style="color: #0D1830; font-size: 0.72rem;"><?php echo $mentor->avg_rating; ?></span>
                                    <span style="color: #a8a29e; font-size: 0.65rem;">(<?php echo $mentor->total_reviews; ?>)</span>
                                    <?php if ((float)$mentor->price_per_session > 0): ?>
                                    <span class="ms-auto fw-bold" style="color: #009688; font-size: 0.72rem;">Rp <?php echo number_format($mentor->price_per_session, 0, ',', '.'); ?></span>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <span class="mob-chev"><i class="fas fa-chevron-right"></i></span>
                        </div>
                        <?php if (!empty($mentor->bio)): ?>
                            <p class="mb-2" style="color: #78716c; font-size: 0.72rem; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; line-height: 1.4;">
                                <?php echo htmlspecialchars(t($mentor->bio, $mentor->bio_en)); ?>
                            </p>
                        <?php endif; ?>
                        <div class="d-flex align-items-center justify-content-between pt-2" style="border-top: 1px solid #f0eeeb;">
                            <div class="d-flex gap-3" style="color: #a8a29e; font-size: 0.65rem;">
                                <span><i class="fas fa-clock me-1"></i><?php echo $mentor->total_sessions; ?> <?php echo t('sesi', 'sessions'); ?></span>
                                <span><i class="fas fa-video me-1"></i><?php echo strtoupper(substr($mentor->meeting_platforms, 0, 10)); ?></span>
                            </div>
                            <span style="color: #009688; font-size: 0.72rem; font-weight: 600;"><?php echo t('Lihat', 'View'); ?> <i class="fas fa-chevron-right" style="font-size: 0.5rem;"></i></span>
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
                <h4 class="fw-extrabold mb-1" style="color: #0D1830; letter-spacing: -0.02em;">
                    <?php echo t('Mentoring', 'Mentoring'); ?>
                </h4>
                <p style="color: #78716c; font-size: 0.85rem; margin-bottom: 0;">
                    <?php echo t('Temukan mentor dan jadwalkan sesi 1-on-1.', 'Find mentors and schedule 1-on-1 sessions.'); ?>
                </p>
            </div>
            <a href="<?php echo base_url('mentoring/my_sessions'); ?>" class="btn px-3 py-2 fw-semibold rounded-pill" style="background:#E0F2F1; color:#009688; font-size:0.8rem;">
                <i class="fas fa-calendar-check me-1"></i> <?php echo t('Sesi Saya', 'My Sessions'); ?>
            </a>
        </div>

        <!-- Search -->
        <form method="get" class="d-flex gap-2 mb-3">
            <?php if ($selected_category): ?>
                <input type="hidden" name="category" value="<?php echo $selected_category; ?>">
            <?php endif; ?>
            <div class="flex-fill position-relative">
                <i class="fas fa-search position-absolute" style="left: 14px; top: 50%; transform: translateY(-50%); color: #a3a3a3; font-size: 0.8rem;"></i>
                <input type="text" name="search" class="form-control" value="<?php echo htmlspecialchars($search_query ?? ''); ?>" placeholder="<?php echo t('Cari mentor berdasarkan nama atau keahlian...', 'Search mentors by name or expertise...'); ?>" style="padding-left: 36px; border-radius: 100px; border-color: #e7e5e4; font-size: 0.85rem; height: 42px; background: #fff;">
            </div>
            <button type="submit" class="btn px-4 fw-semibold flex-shrink-0" style="background: #009688; color: #fff; border-radius: 100px; font-size: 0.85rem; height: 42px;">
                <i class="fas fa-search"></i>
            </button>
        </form>

        <!-- Category chips -->
        <div class="d-flex gap-2 overflow-auto pb-1 mb-3" style="scrollbar-width: none; -ms-overflow-style: none;">
            <a href="<?php echo base_url('mentoring'); ?>" class="px-3 py-2 rounded-pill fw-semibold text-decoration-none flex-shrink-0" style="font-size: 0.75rem; background: <?php echo !$selected_category ? '#009688' : '#E6EBEF'; ?>; color: <?php echo !$selected_category ? '#fff' : '#57534e'; ?>;">
                <?php echo t('Semua', 'All'); ?>
            </a>
            <?php foreach ($categories as $cat): ?>
                <a href="<?php echo base_url('mentoring?category=' . $cat->id); ?>" class="px-3 py-2 rounded-pill fw-semibold text-decoration-none flex-shrink-0" style="font-size: 0.75rem; background: <?php echo $selected_category == $cat->id ? '#009688' : '#E6EBEF'; ?>; color: <?php echo $selected_category == $cat->id ? '#fff' : '#57534e'; ?>;">
                    <?php echo htmlspecialchars(t($cat->name, $cat->name_en)); ?>
                </a>
            <?php endforeach; ?>
            <a href="<?php echo base_url('mentoring/packages'); ?>" class="px-3 py-2 rounded-pill fw-semibold text-decoration-none flex-shrink-0" style="font-size: 0.75rem; background: #FEF3C7; color: #92400E;">
                <i class="fas fa-shopping-bag" style="font-size: 0.6rem;"></i> <?php echo t('Paket', 'Packages'); ?>
            </a>
        </div>

        <!-- Mentor grid -->
        <?php if (empty($mentors)): ?>
            <div class="text-center py-5">
                <div style="font-size: 2.5rem; color: #d4d4d4; margin-bottom: 0.75rem;"><i class="fas fa-user-tie"></i></div>
                <h5 class="fw-bold" style="color: #0D1830;"><?php echo t('Tidak Ada Mentor', 'No Mentors Found'); ?></h5>
                <p style="color: #78716c; font-size: 0.85rem;"><?php echo t('Coba ubah filter pencarian Anda.', 'Try changing your search filters.'); ?></p>
            </div>
        <?php else: ?>
            <div class="row g-3">
                <?php foreach ($mentors as $mentor): ?>
                    <div class="col-md-6 col-lg-4">
                        <a href="<?php echo base_url('mentoring/detail/' . encode_id($mentor->id)); ?>" class="text-decoration-none">
                            <div class="border rounded-3 h-100 p-3 mentor-card-hover" style="border-color: #e7e5e4; border-radius: 14px; background: #fff; transition: all 0.15s; box-shadow: 0 1px 3px rgba(0,0,0,0.03);">
                                <div class="d-flex align-items-center gap-3 mb-3">
                                    <?php if (!empty($mentor->avatar) && file_exists(FCPATH . 'uploads/mentors/' . $mentor->avatar)): ?>
                                    <img src="<?php echo base_url('uploads/mentors/' . $mentor->avatar); ?>" alt="" class="flex-shrink-0" style="width: 48px; height: 48px; border-radius: 50%; object-fit: cover; background: #E0F2F1;">
                                    <?php else: ?>
                                    <span class="flex-shrink-0" style="background: linear-gradient(135deg,#009688,#00796B); color:#fff; font-size: 1rem; width: 48px; height: 48px; border-radius: 50%; display:inline-flex; align-items:center; justify-content:center; font-weight: 700;">
                                        <?php echo strtoupper(substr($mentor->name, 0, 1)); ?>
                                    </span>
                                    <?php endif; ?>
                                    <div class="min-w-0 flex-fill">
                                        <h6 class="fw-bold mb-0 text-truncate" style="color: #0D1830; font-size: 0.9rem;"><?php echo htmlspecialchars($mentor->name); ?></h6>
                                        <small class="fw-medium text-truncate d-block" style="color: #78716c; font-size: 0.78rem;"><?php echo htmlspecialchars(t($mentor->title, $mentor->title_en)); ?></small>
                                        <div class="d-flex align-items-center gap-1 mt-1">
                                            <i class="fas fa-star" style="color: #FBBF24; font-size: 0.6rem;"></i>
                                            <span class="fw-bold" style="color: #0D1830; font-size: 0.78rem;"><?php echo $mentor->avg_rating; ?></span>
                                            <span style="color: #a8a29e; font-size: 0.7rem;">(<?php echo $mentor->total_reviews; ?>)</span>
                                        </div>
                                    </div>
                                </div>
                                <p class="mb-3" style="color: #78716c; font-size: 0.78rem; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; line-height: 1.5;">
                                    <?php echo htmlspecialchars(t($mentor->bio, $mentor->bio_en)); ?>
                                </p>
                                <div class="d-flex flex-wrap gap-1 mb-3">
                                    <?php
                                    $m_cats = $this->db->select('mentor_categories.*')
                                        ->from('mentor_category_pivot')
                                        ->join('mentor_categories', 'mentor_categories.id = mentor_category_pivot.category_id')
                                        ->where('mentor_category_pivot.mentor_id', $mentor->id)
                                        ->get()->result();
                                    ?>
                                    <?php foreach (array_slice($m_cats, 0, 3) as $mc): ?>
                                        <span class="px-2 py-1 rounded-pill" style="background: #E6EBEF; color: #57534E; font-size: 0.65rem; font-weight: 600;">
                                            <?php echo htmlspecialchars(t($mc->name, $mc->name_en)); ?>
                                        </span>
                                    <?php endforeach; ?>
                                </div>
                                <div class="d-flex align-items-center justify-content-between pt-2" style="border-top: 1px solid #f0eeeb;">
                                    <div class="d-flex flex-column gap-1">
                                        <?php if ((float)$mentor->price_per_session > 0): ?>
                                        <span class="fw-bold" style="color: #009688; font-size: 0.85rem;">Rp <?php echo number_format($mentor->price_per_session, 0, ',', '.'); ?> <small style="color:#a8a29e; font-weight:500; font-size:0.65rem;">/ <?php echo t('sesi', 'session'); ?></small></span>
                                        <?php endif; ?>
                                        <div class="d-flex gap-3" style="color: #a8a29e; font-size: 0.7rem;">
                                            <span><i class="fas fa-clock me-1"></i><?php echo $mentor->total_sessions; ?> <?php echo t('sesi', 'sessions'); ?></span>
                                            <span><i class="fas fa-video me-1"></i><?php echo strtoupper(substr($mentor->meeting_platforms, 0, 10)); ?></span>
                                        </div>
                                    </div>
                                    <span class="btn btn-sm fw-bold rounded-pill px-3 flex-shrink-0" style="background: #009688; color: #fff; font-size: 0.72rem;"><?php echo t('Lihat', 'View'); ?></span>
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
<!-- Hero -->
<section class="mentoring-hero" style="background: linear-gradient(160deg,#0D1830 0%,#0D1830 35%,#00796B 75%,#009688 100%); color:#fff; position:relative; overflow:hidden;">
    <div style="position:absolute; top:-80px; right:-60px; width:280px; height:280px; border-radius:50%; background:rgba(251,191,36,0.12);"></div>
    <div style="position:absolute; bottom:-100px; left:-40px; width:320px; height:320px; border-radius:50%; background:rgba(0,150,136,0.25);"></div>
    <div class="container position-relative" style="padding-top: 3.5rem; padding-bottom: 3rem; max-width: 1000px;">
        <div class="text-center mb-4">
            <span class="px-3 py-1 rounded-pill fw-semibold mb-3 d-inline-block" style="background: rgba(251,191,36,0.18); color: #FBBF24; border: 1px solid rgba(251,191,36,0.35); font-size: 0.72rem; letter-spacing: 0.04em;">
                <i class="fas fa-users me-1"></i> 1-ON-1 MENTORING
            </span>
            <h1 class="fw-extrabold mb-2" style="font-size: 2rem; letter-spacing: -0.03em; color: #fff; text-shadow: 0 2px 20px rgba(0,0,0,0.2);">
                <?php echo t('Dapatkan Mentoring Karirmu', 'Get Career Mentoring'); ?>
                <br><span style="color: #FBBF24;"><?php echo t('Bersama Mentor Ahli', 'With Expert Mentors'); ?></span>
            </h1>
            <p class="mb-3 mx-auto" style="color: rgba(230,235,239,0.85); font-size: 0.95rem; max-width: 540px;">
                <?php echo t('Pilih mentor, jadwalkan sesi 1-on-1, dan mulai perjalanan karirmu.', 'Choose a mentor, schedule a 1-on-1 session, and start your career journey.'); ?>
            </p>
            <div class="d-flex justify-content-center gap-4 mb-3" style="font-size: 0.85rem;">
                <div><strong style="color: #FBBF24; font-size: 1.1rem;">16+</strong> <span style="color: rgba(230,235,239,0.75);"><?php echo t('Bidang', 'Fields'); ?></span></div>
                <div class="mx-2" style="width:1px; background: rgba(255,255,255,0.2);"></div>
                <div><strong style="color: #FBBF24; font-size: 1.1rem;"><?php echo count($mentors); ?>+</strong> <span style="color: rgba(230,235,239,0.75);"><?php echo t('Mentor', 'Mentors'); ?></span></div>
                <div class="mx-2" style="width:1px; background: rgba(255,255,255,0.2);"></div>
                <div><strong style="color: #FBBF24; font-size: 1.1rem;">200+</strong> <span style="color: rgba(230,235,239,0.75);"><?php echo t('Industri', 'Industries'); ?></span></div>
            </div>
        </div>

        <!-- 3 Steps -->
        <div class="d-flex justify-content-center gap-3 flex-wrap mb-1">
            <div class="d-flex align-items-center gap-2 px-3 py-2 rounded-3" style="background: rgba(255,255,255,0.08); border: 1px solid rgba(255,255,255,0.12); backdrop-filter: blur(8px);">
                <div class="fw-bold d-inline-flex align-items-center justify-content-center" style="width: 24px; height: 24px; border-radius: 50%; background: #FBBF24; color: #0D1830; font-size: 0.7rem;">1</div>
                <span style="color: rgba(255,255,255,0.9); font-size: 0.78rem; font-weight: 500;"><?php echo t('Jelajahi Mentor', 'Explore Mentors'); ?></span>
            </div>
            <div class="d-flex align-items-center gap-2 px-3 py-2 rounded-3" style="background: rgba(255,255,255,0.08); border: 1px solid rgba(255,255,255,0.12); backdrop-filter: blur(8px);">
                <div class="fw-bold d-inline-flex align-items-center justify-content-center" style="width: 24px; height: 24px; border-radius: 50%; background: #FBBF24; color: #0D1830; font-size: 0.7rem;">2</div>
                <span style="color: rgba(255,255,255,0.9); font-size: 0.78rem; font-weight: 500;"><?php echo t('Pilih Jadwal', 'Choose Schedule'); ?></span>
            </div>
            <div class="d-flex align-items-center gap-2 px-3 py-2 rounded-3" style="background: rgba(255,255,255,0.08); border: 1px solid rgba(255,255,255,0.12); backdrop-filter: blur(8px);">
                <div class="fw-bold d-inline-flex align-items-center justify-content-center" style="width: 24px; height: 24px; border-radius: 50%; background: #FBBF24; color: #0D1830; font-size: 0.7rem;">3</div>
                <span style="color: rgba(255,255,255,0.9); font-size: 0.78rem; font-weight: 500;"><?php echo t('Mentoring 1-on-1', '1-on-1 Mentoring'); ?></span>
            </div>
        </div>
    </div>
</section>

<!-- Category Tabs -->
<div style="border-bottom: 1px solid #E6EBEF; background: #fff;">
    <div class="container d-flex gap-2 overflow-auto py-3" style="max-width: 1000px; scrollbar-width: none; -ms-overflow-style: none;">
        <a href="<?php echo base_url('mentoring'); ?>" class="px-3 py-2 rounded-pill fw-semibold text-decoration-none flex-shrink-0" style="font-size: 0.78rem; background: <?php echo !$selected_category ? '#009688' : '#E6EBEF'; ?>; color: <?php echo !$selected_category ? '#fff' : '#525252'; ?>;">
            <?php echo t('Semua', 'All'); ?>
        </a>
        <?php foreach ($categories as $cat): ?>
            <a href="<?php echo base_url('mentoring?category=' . $cat->id); ?>" class="px-3 py-2 rounded-pill fw-semibold text-decoration-none flex-shrink-0" style="font-size: 0.78rem; background: <?php echo $selected_category == $cat->id ? '#009688' : '#E6EBEF'; ?>; color: <?php echo $selected_category == $cat->id ? '#fff' : '#525252'; ?>;">
                <?php echo htmlspecialchars(t($cat->name, $cat->name_en)); ?>
            </a>
        <?php endforeach; ?>
        <a href="<?php echo base_url('mentoring/packages'); ?>" class="px-3 py-2 rounded-pill fw-semibold text-decoration-none flex-shrink-0" style="font-size: 0.78rem; background: #FEF3C7; color: #92400E;">
            <i class="fas fa-shopping-bag" style="font-size: 0.65rem;"></i> <?php echo t('Paket', 'Packages'); ?>
        </a>
    </div>
</div>

<!-- Search -->
<div style="background: #E6EBEF; border-bottom: 1px solid #d6dde4;">
    <div class="container py-3" style="max-width: 1000px;">
        <form method="get" class="d-flex gap-2">
            <?php if ($selected_category): ?>
                <input type="hidden" name="category" value="<?php echo $selected_category; ?>">
            <?php endif; ?>
            <div class="flex-fill position-relative">
                <i class="fas fa-search position-absolute" style="left: 14px; top: 50%; transform: translateY(-50%); color: #a3a3a3; font-size: 0.8rem;"></i>
                <input type="text" name="search" class="form-control" value="<?php echo htmlspecialchars($search_query ?? ''); ?>" placeholder="<?php echo t('Cari mentor berdasarkan nama atau keahlian...', 'Search mentors by name or expertise...'); ?>" style="padding-left: 36px; border-radius: 100px; border-color: #d6dde4; font-size: 0.85rem; height: 42px; background: #fff;">
            </div>
            <button type="submit" class="btn px-4 fw-semibold flex-shrink-0" style="background: #0D1830; color: #fff; border-radius: 100px; font-size: 0.85rem; height: 42px;">
                <i class="fas fa-search"></i>
            </button>
        </form>
    </div>
</div>

<!-- Mentor Grid -->
<div class="container" style="max-width: 1000px; padding-top: 1.5rem; padding-bottom: 3rem;">
    <div class="mb-3 d-flex align-items-center justify-content-between" style="color: #737373; font-size: 0.85rem; font-weight: 500;">
        <span><?php echo t('Menampilkan', 'Showing'); ?> <strong style="color: #0D1830;"><?php echo count($mentors); ?></strong> <?php echo t('mentor', 'mentors'); ?></span>
        <span class="d-none d-sm-inline" style="color:#a8a29e;"><i class="fas fa-user-tie me-1"></i><?php echo t('Mentor terverifikasi', 'Verified mentors'); ?></span>
    </div>

    <?php if (empty($mentors)): ?>
        <div class="text-center py-5">
            <div style="font-size: 2.5rem; color: #d4d4d4; margin-bottom: 0.75rem;"><i class="fas fa-search"></i></div>
            <h5 class="fw-bold" style="color: #0D1830;"><?php echo t('Tidak Ada Mentor', 'No Mentors Found'); ?></h5>
            <p style="color: #737373; font-size: 0.85rem;"><?php echo t('Coba ubah filter pencarian Anda.', 'Try changing your search filters.'); ?></p>
        </div>
    <?php else: ?>
        <div class="row g-3">
            <?php foreach ($mentors as $mentor): ?>
                <div class="col-md-6 col-lg-4">
                    <a href="<?php echo base_url('mentoring/detail/' . encode_id($mentor->id)); ?>" class="text-decoration-none">
                        <div class="card h-100 mentor-card-hover" style="border: 1px solid #E6EBEF; border-radius: 14px; transition: all 0.18s; box-shadow: 0 1px 3px rgba(13,24,48,0.04);">
                            <div class="card-body p-3">
                                <!-- Mentor Header -->
                                <div class="d-flex align-items-center gap-3 mb-3">
                                    <?php if (!empty($mentor->avatar) && file_exists(FCPATH . 'uploads/mentors/' . $mentor->avatar)): ?>
                                    <img src="<?php echo base_url('uploads/mentors/' . $mentor->avatar); ?>" alt="" style="width: 48px; height: 48px; border-radius: 50%; object-fit: cover; background: #E0F2F1; flex-shrink: 0;">
                                    <?php else: ?>
                                    <span style="background: linear-gradient(135deg,#009688,#00796B); color:#fff; font-size: 1rem; width: 48px; height: 48px; border-radius: 50%; display:inline-flex; align-items:center; justify-content:center; font-weight:700; flex-shrink:0;">
                                        <?php echo strtoupper(substr($mentor->name, 0, 1)); ?>
                                    </span>
                                    <?php endif; ?>
                                    <div class="min-w-0 flex-fill">
                                        <h6 class="fw-bold mb-0 text-truncate" style="color: #0D1830; font-size: 0.9rem;"><?php echo htmlspecialchars($mentor->name); ?></h6>
                                        <small class="fw-medium text-truncate d-block" style="color: #737373; font-size: 0.78rem;"><?php echo htmlspecialchars(t($mentor->title, $mentor->title_en)); ?></small>
                                        <div class="d-flex align-items-center gap-1 mt-1">
                                            <i class="fas fa-star" style="color: #FBBF24; font-size: 0.6rem;"></i>
                                            <span class="fw-bold" style="color: #0D1830; font-size: 0.78rem;"><?php echo $mentor->avg_rating; ?></span>
                                            <span style="color: #a3a3a3; font-size: 0.7rem;">(<?php echo $mentor->total_reviews; ?>)</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Bio -->
                                <p class="mb-3" style="color: #737373; font-size: 0.78rem; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; line-height: 1.5;">
                                    <?php echo htmlspecialchars(t($mentor->bio, $mentor->bio_en)); ?>
                                </p>

                                <!-- Tags -->
                                <div class="d-flex flex-wrap gap-1 mb-3">
                                    <?php
                                    $m_cats = $this->db->select('mentor_categories.*')
                                        ->from('mentor_category_pivot')
                                        ->join('mentor_categories', 'mentor_categories.id = mentor_category_pivot.category_id')
                                        ->where('mentor_category_pivot.mentor_id', $mentor->id)
                                        ->get()->result();
                                    ?>
                                    <?php foreach (array_slice($m_cats, 0, 3) as $mc): ?>
                                        <span class="px-2 py-1 rounded-pill" style="background: #E6EBEF; color: #57534E; font-size: 0.65rem; font-weight: 600;">
                                            <?php echo htmlspecialchars(t($mc->name, $mc->name_en)); ?>
                                        </span>
                                    <?php endforeach; ?>
                                </div>

                                <!-- Stats + Price -->
                                <div class="d-flex align-items-center justify-content-between pt-2" style="border-top: 1px solid #E6EBEF;">
                                    <div class="d-flex flex-column gap-1">
                                        <?php if ((float)$mentor->price_per_session > 0): ?>
                                        <span class="fw-bold" style="color: #009688; font-size: 0.9rem;">Rp <?php echo number_format($mentor->price_per_session, 0, ',', '.'); ?> <small style="color:#a8a29e; font-weight:500; font-size:0.65rem;">/ <?php echo t('sesi', 'session'); ?></small></span>
                                        <?php endif; ?>
                                        <div class="d-flex gap-3" style="color: #a8a29e; font-size: 0.7rem;">
                                            <span><i class="fas fa-clock me-1"></i><?php echo $mentor->total_sessions; ?> <?php echo t('sesi', 'sessions'); ?></span>
                                            <span><i class="fas fa-video me-1"></i><?php echo strtoupper(substr($mentor->meeting_platforms, 0, 10)); ?></span>
                                        </div>
                                    </div>
                                    <span class="btn btn-sm fw-bold rounded-pill px-3 flex-shrink-0" style="background: #009688; color: #fff; font-size: 0.72rem;">
                                        <?php echo t('Lihat', 'View'); ?>
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
<?php endif; ?>
