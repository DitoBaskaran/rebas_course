<?php $_mob_mentor_panel = $this->session->userdata('logged_in'); ?>

<?php if ($_mob_mentor_panel): ?>
<!-- ============ PANEL STUDENT (desktop + mobile app-style) ============ -->
<div class="container-fluid py-4" style="padding-top: 0px !important; max-width: 1100px;">

    <!-- Mobile App-Style -->
    <div class="dashboard-mobile-only">
        <!-- Header -->
        <div class="d-flex align-items-center justify-content-between mb-3">
            <div>
                <h5 class="fw-extrabold mb-0" style="color: #1c1917; font-size: 1.15rem; letter-spacing: -0.02em;">
                    <?php echo t('Mentoring', 'Mentoring'); ?>
                </h5>
                <small style="color: #78716c; font-size: 0.72rem;"><?php echo t('Sesi 1-on-1 dengan mentor ahli', '1-on-1 sessions with expert mentors'); ?></small>
            </div>
            <a href="<?php echo base_url('mentoring/my_sessions'); ?>" class="btn px-3 py-2 fw-semibold rounded-pill" style="background:#ecfdf5; color:#059669; font-size:0.72rem;">
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
            <button type="submit" class="btn px-3 fw-semibold flex-shrink-0" style="background: #059669; color: #fff; border-radius: 100px; font-size: 0.82rem; height: 42px;">
                <i class="fas fa-search"></i>
            </button>
        </form>

        <!-- Category chips (horizontal scroll) -->
        <div class="d-flex gap-2 overflow-auto pb-1 mb-2" style="scrollbar-width: none; -ms-overflow-style: none;">
            <a href="<?php echo base_url('mentoring'); ?>" class="px-3 py-2 rounded-pill fw-semibold text-decoration-none flex-shrink-0" style="font-size: 0.72rem; background: <?php echo !$selected_category ? '#059669' : '#f5f5f4'; ?>; color: <?php echo !$selected_category ? '#fff' : '#57534e'; ?>;">
                <?php echo t('Semua', 'All'); ?>
            </a>
            <?php foreach ($categories as $cat): ?>
                <a href="<?php echo base_url('mentoring?category=' . $cat->id); ?>" class="px-3 py-2 rounded-pill fw-semibold text-decoration-none flex-shrink-0" style="font-size: 0.72rem; background: <?php echo $selected_category == $cat->id ? '#059669' : '#f5f5f4'; ?>; color: <?php echo $selected_category == $cat->id ? '#fff' : '#57534e'; ?>;">
                    <?php echo htmlspecialchars(t($cat->name, $cat->name_en)); ?>
                </a>
            <?php endforeach; ?>
            <a href="<?php echo base_url('mentoring/packages'); ?>" class="px-3 py-2 rounded-pill fw-semibold text-decoration-none flex-shrink-0" style="font-size: 0.72rem; background: #fef3c7; color: #92400e;">
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
                            <span class="mob-avatar" style="background: linear-gradient(135deg,#059669,#10b981); font-size: 1rem; width: 46px; height: 46px; border-radius: 50%;">
                                <?php echo strtoupper(substr($mentor->name, 0, 1)); ?>
                            </span>
                            <div class="min-w-0 flex-fill">
                                <div class="fw-bold text-truncate" style="color: #1c1917; font-size: 0.85rem;"><?php echo htmlspecialchars($mentor->name); ?></div>
                                <div class="text-truncate" style="color: #78716c; font-size: 0.72rem;"><?php echo htmlspecialchars(t($mentor->title, $mentor->title_en)); ?></div>
                                <div class="d-flex align-items-center gap-1 mt-1">
                                    <i class="fas fa-star" style="color: #f59e0b; font-size: 0.6rem;"></i>
                                    <span class="fw-bold" style="color: #1c1917; font-size: 0.72rem;"><?php echo $mentor->avg_rating; ?></span>
                                    <span style="color: #a8a29e; font-size: 0.65rem;">(<?php echo $mentor->total_reviews; ?>)</span>
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
                            <span style="color: #059669; font-size: 0.72rem; font-weight: 600;"><?php echo t('Lihat', 'View'); ?> <i class="fas fa-chevron-right" style="font-size: 0.5rem;"></i></span>
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
                    <?php echo t('Mentoring', 'Mentoring'); ?>
                </h4>
                <p style="color: #78716c; font-size: 0.85rem; margin-bottom: 0;">
                    <?php echo t('Temukan mentor dan jadwalkan sesi 1-on-1.', 'Find mentors and schedule 1-on-1 sessions.'); ?>
                </p>
            </div>
            <a href="<?php echo base_url('mentoring/my_sessions'); ?>" class="btn px-3 py-2 fw-semibold rounded-pill" style="background:#ecfdf5; color:#059669; font-size:0.8rem;">
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
            <button type="submit" class="btn px-4 fw-semibold flex-shrink-0" style="background: #059669; color: #fff; border-radius: 100px; font-size: 0.85rem; height: 42px;">
                <i class="fas fa-search"></i>
            </button>
        </form>

        <!-- Category chips -->
        <div class="d-flex gap-2 overflow-auto pb-1 mb-3" style="scrollbar-width: none; -ms-overflow-style: none;">
            <a href="<?php echo base_url('mentoring'); ?>" class="px-3 py-2 rounded-pill fw-semibold text-decoration-none flex-shrink-0" style="font-size: 0.75rem; background: <?php echo !$selected_category ? '#059669' : '#f5f5f4'; ?>; color: <?php echo !$selected_category ? '#fff' : '#57534e'; ?>;">
                <?php echo t('Semua', 'All'); ?>
            </a>
            <?php foreach ($categories as $cat): ?>
                <a href="<?php echo base_url('mentoring?category=' . $cat->id); ?>" class="px-3 py-2 rounded-pill fw-semibold text-decoration-none flex-shrink-0" style="font-size: 0.75rem; background: <?php echo $selected_category == $cat->id ? '#059669' : '#f5f5f4'; ?>; color: <?php echo $selected_category == $cat->id ? '#fff' : '#57534e'; ?>;">
                    <?php echo htmlspecialchars(t($cat->name, $cat->name_en)); ?>
                </a>
            <?php endforeach; ?>
            <a href="<?php echo base_url('mentoring/packages'); ?>" class="px-3 py-2 rounded-pill fw-semibold text-decoration-none flex-shrink-0" style="font-size: 0.75rem; background: #fef3c7; color: #92400e;">
                <i class="fas fa-shopping-bag" style="font-size: 0.6rem;"></i> <?php echo t('Paket', 'Packages'); ?>
            </a>
        </div>

        <!-- Mentor grid -->
        <?php if (empty($mentors)): ?>
            <div class="text-center py-5">
                <div style="font-size: 2.5rem; color: #d4d4d4; margin-bottom: 0.75rem;"><i class="fas fa-user-tie"></i></div>
                <h5 class="fw-bold" style="color: #1c1917;"><?php echo t('Tidak Ada Mentor', 'No Mentors Found'); ?></h5>
                <p style="color: #78716c; font-size: 0.85rem;"><?php echo t('Coba ubah filter pencarian Anda.', 'Try changing your search filters.'); ?></p>
            </div>
        <?php else: ?>
            <div class="row g-3">
                <?php foreach ($mentors as $mentor): ?>
                    <div class="col-md-6 col-lg-4">
                        <a href="<?php echo base_url('mentoring/detail/' . encode_id($mentor->id)); ?>" class="text-decoration-none">
                            <div class="border rounded-3 h-100 p-3" style="border-color: #e7e5e4; border-radius: 14px; background: #fff; transition: all 0.15s;">
                                <div class="d-flex align-items-center gap-3 mb-3">
                                    <span class="mob-avatar" style="background: linear-gradient(135deg,#059669,#10b981); font-size: 1rem; width: 48px; height: 48px; border-radius: 50%;">
                                        <?php echo strtoupper(substr($mentor->name, 0, 1)); ?>
                                    </span>
                                    <div class="min-w-0 flex-fill">
                                        <h6 class="fw-bold mb-0 text-truncate" style="color: #1c1917; font-size: 0.9rem;"><?php echo htmlspecialchars($mentor->name); ?></h6>
                                        <small class="fw-medium text-truncate d-block" style="color: #78716c; font-size: 0.78rem;"><?php echo htmlspecialchars(t($mentor->title, $mentor->title_en)); ?></small>
                                        <div class="d-flex align-items-center gap-1 mt-1">
                                            <i class="fas fa-star" style="color: #f59e0b; font-size: 0.6rem;"></i>
                                            <span class="fw-bold" style="color: #1c1917; font-size: 0.78rem;"><?php echo $mentor->avg_rating; ?></span>
                                            <span style="color: #a8a29e; font-size: 0.7rem;">(<?php echo $mentor->total_reviews; ?>)</span>
                                        </div>
                                    </div>
                                </div>
                                <p class="mb-3" style="color: #78716c; font-size: 0.78rem; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; line-height: 1.5;">
                                    <?php echo htmlspecialchars(t($mentor->bio, $mentor->bio_en)); ?>
                                </p>
                                <div class="d-flex align-items-center justify-content-between pt-2" style="border-top: 1px solid #f0eeeb;">
                                    <div class="d-flex gap-3" style="color: #a8a29e; font-size: 0.72rem;">
                                        <span><i class="fas fa-clock me-1"></i><?php echo $mentor->total_sessions; ?> <?php echo t('sesi', 'sessions'); ?></span>
                                        <span><i class="fas fa-video me-1"></i><?php echo strtoupper(substr($mentor->meeting_platforms, 0, 10)); ?></span>
                                    </div>
                                    <span style="color: #059669; font-size: 0.78rem; font-weight: 600;"><?php echo t('Lihat', 'View'); ?> <i class="fas fa-chevron-right" style="font-size: 0.55rem;"></i></span>
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
<div style="border-bottom: 1px solid #e5e5e5;">
    <div class="container" style="padding-top: 2rem; padding-bottom: 1.5rem; max-width: 960px;">
        <div class="text-center mb-4">
            <span class="px-3 py-1 rounded-pill fw-semibold mb-3 d-inline-block" style="background: #111827; color: #fff; font-size: 0.72rem;">1-on-1 MENTORING</span>
            <h1 class="fw-extrabold mb-2" style="font-size: 1.6rem; letter-spacing: -0.02em; color: #111827;">
                <?php echo t('Dapatkan Mentoring Karirmu Bersama', 'Get Career Mentoring With'); ?>
                <br><span style="color: #059669;"><?php echo t('Mentor Ahli Terpercaya', 'Trusted Expert Mentors'); ?></span>
            </h1>
            <p class="mb-3 mx-auto" style="color: #737373; font-size: 0.9rem; max-width: 500px;">
                <?php echo t('Pilih mentor, jadwalkan sesi 1-on-1, dan mulai perjalanan karirmu.', 'Choose a mentor, schedule a 1-on-1 session, and start your career journey.'); ?>
            </p>
            <div class="d-flex justify-content-center gap-4 mb-2" style="font-size: 0.8rem;">
                <div><strong style="color: #111827;">16+</strong> <span style="color: #737373;"><?php echo t('Bidang', 'Fields'); ?></span></div>
                <div><strong style="color: #111827;"><?php echo count($mentors); ?>+</strong> <span style="color: #737373;"><?php echo t('Mentor', 'Mentors'); ?></span></div>
                <div><strong style="color: #111827;">200+</strong> <span style="color: #737373;"><?php echo t('Industri', 'Industries'); ?></span></div>
            </div>
        </div>

        <!-- 3 Steps -->
        <div class="d-flex justify-content-center gap-3 flex-wrap mb-2">
            <div class="d-flex align-items-center gap-2 px-3 py-2 rounded-3" style="background: #fafafa;">
                <div class="fw-bold d-inline-flex align-items-center justify-content-center" style="width: 24px; height: 24px; border-radius: 50%; background: #059669; color: #111827; font-size: 0.7rem;">1</div>
                <span style="color: #525252; font-size: 0.78rem; font-weight: 500;"><?php echo t('Jelajahi Mentor', 'Explore Mentors'); ?></span>
            </div>
            <div class="d-flex align-items-center gap-2 px-3 py-2 rounded-3" style="background: #fafafa;">
                <div class="fw-bold d-inline-flex align-items-center justify-content-center" style="width: 24px; height: 24px; border-radius: 50%; background: #059669; color: #111827; font-size: 0.7rem;">2</div>
                <span style="color: #525252; font-size: 0.78rem; font-weight: 500;"><?php echo t('Pilih Jadwal', 'Choose Schedule'); ?></span>
            </div>
            <div class="d-flex align-items-center gap-2 px-3 py-2 rounded-3" style="background: #fafafa;">
                <div class="fw-bold d-inline-flex align-items-center justify-content-center" style="width: 24px; height: 24px; border-radius: 50%; background: #059669; color: #111827; font-size: 0.7rem;">3</div>
                <span style="color: #525252; font-size: 0.78rem; font-weight: 500;"><?php echo t('Mentoring 1-on-1', '1-on-1 Mentoring'); ?></span>
            </div>
        </div>
    </div>
</div>

<!-- Category Tabs -->
<div style="border-bottom: 1px solid #f0f0f0;">
    <div class="container d-flex gap-2 overflow-auto py-3" style="max-width: 960px; scrollbar-width: none; -ms-overflow-style: none;">
        <a href="<?php echo base_url('mentoring'); ?>" class="px-3 py-2 rounded-pill fw-semibold text-decoration-none flex-shrink-0" style="font-size: 0.78rem; background: <?php echo !$selected_category ? '#111827' : '#f5f5f5'; ?>; color: <?php echo !$selected_category ? '#fff' : '#525252'; ?>;">
            <?php echo t('Semua', 'All'); ?>
        </a>
        <?php foreach ($categories as $cat): ?>
            <a href="<?php echo base_url('mentoring?category=' . $cat->id); ?>" class="px-3 py-2 rounded-pill fw-semibold text-decoration-none flex-shrink-0" style="font-size: 0.78rem; background: <?php echo $selected_category == $cat->id ? '#111827' : '#f5f5f5'; ?>; color: <?php echo $selected_category == $cat->id ? '#fff' : '#525252'; ?>;">
                <?php echo htmlspecialchars(t($cat->name, $cat->name_en)); ?>
            </a>
        <?php endforeach; ?>
        <a href="<?php echo base_url('mentoring/packages'); ?>" class="px-3 py-2 rounded-pill fw-semibold text-decoration-none flex-shrink-0" style="font-size: 0.78rem; background: #fef3c7; color: #92400e;">
            <i class="fas fa-shopping-bag" style="font-size: 0.65rem;"></i> <?php echo t('Paket', 'Packages'); ?>
        </a>
    </div>
</div>

<!-- Search -->
<div style="background: #fafafa; border-bottom: 1px solid #f0f0f0;">
    <div class="container py-3" style="max-width: 960px;">
        <form method="get" class="d-flex gap-2">
            <?php if ($selected_category): ?>
                <input type="hidden" name="category" value="<?php echo $selected_category; ?>">
            <?php endif; ?>
            <div class="flex-fill position-relative">
                <i class="fas fa-search position-absolute" style="left: 14px; top: 50%; transform: translateY(-50%); color: #a3a3a3; font-size: 0.8rem;"></i>
                <input type="text" name="search" class="form-control" value="<?php echo htmlspecialchars($search_query ?? ''); ?>" placeholder="<?php echo t('Cari mentor berdasarkan nama atau keahlian...', 'Search mentors by name or expertise...'); ?>" style="padding-left: 36px; border-radius: 100px; border-color: #e5e5e5; font-size: 0.85rem; height: 42px; background: #fff;">
            </div>
            <button type="submit" class="btn px-4 fw-semibold flex-shrink-0" style="background: #111827; color: #fff; border-radius: 100px; font-size: 0.85rem; height: 42px;">
                <i class="fas fa-search"></i>
            </button>
        </form>
    </div>
</div>

<!-- Mentor Grid -->
<div class="container" style="max-width: 960px; padding-top: 1.5rem; padding-bottom: 3rem;">
    <div class="mb-3" style="color: #737373; font-size: 0.85rem; font-weight: 500;">
        <?php echo t('Menampilkan', 'Showing'); ?> <strong style="color: #111827;"><?php echo count($mentors); ?></strong> <?php echo t('mentor', 'mentors'); ?>
    </div>

    <?php if (empty($mentors)): ?>
        <div class="text-center py-5">
            <div style="font-size: 2.5rem; color: #d4d4d4; margin-bottom: 0.75rem;"><i class="fas fa-search"></i></div>
            <h5 class="fw-bold" style="color: #111827;"><?php echo t('Tidak Ada Mentor', 'No Mentors Found'); ?></h5>
            <p style="color: #737373; font-size: 0.85rem;"><?php echo t('Coba ubah filter pencarian Anda.', 'Try changing your search filters.'); ?></p>
        </div>
    <?php else: ?>
        <div class="row g-3">
            <?php foreach ($mentors as $mentor): ?>
                <div class="col-md-6 col-lg-4">
                    <a href="<?php echo base_url('mentoring/detail/' . encode_id($mentor->id)); ?>" class="text-decoration-none">
                        <div class="card h-100" style="border: 1px solid #e5e5e5; border-radius: 12px; transition: all 0.15s;">
                            <div class="card-body p-3">
                                <!-- Mentor Header -->
                                <div class="d-flex align-items-center gap-3 mb-3">
                                    <img src="https://ui-avatars.com/api/?name=<?php echo urlencode($mentor->name); ?>&background=f59e0b&color=fff&size=48&font-size=0.45" alt="" style="width: 48px; height: 48px; border-radius: 50%; flex-shrink: 0;">
                                    <div class="min-w-0 flex-fill">
                                        <h6 class="fw-bold mb-0 text-truncate" style="color: #111827; font-size: 0.9rem;"><?php echo htmlspecialchars($mentor->name); ?></h6>
                                        <small class="fw-medium text-truncate d-block" style="color: #737373; font-size: 0.78rem;"><?php echo htmlspecialchars(t($mentor->title, $mentor->title_en)); ?></small>
                                        <div class="d-flex align-items-center gap-1 mt-1">
                                            <i class="fas fa-star" style="color: #059669; font-size: 0.6rem;"></i>
                                            <span class="fw-bold" style="color: #111827; font-size: 0.78rem;"><?php echo $mentor->avg_rating; ?></span>
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
                                        <span class="px-2 py-1 rounded-pill" style="background: #f5f5f5; color: #525252; font-size: 0.65rem; font-weight: 600;">
                                            <?php echo htmlspecialchars(t($mc->name, $mc->name_en)); ?>
                                        </span>
                                    <?php endforeach; ?>
                                </div>

                                <!-- Stats -->
                                <div class="d-flex align-items-center justify-content-between pt-2" style="border-top: 1px solid #f0f0f0;">
                                    <div class="d-flex gap-3" style="color: #a3a3a3; font-size: 0.72rem;">
                                        <span><i class="fas fa-clock me-1"></i><?php echo $mentor->total_sessions; ?> <?php echo t('sesi', 'sessions'); ?></span>
                                        <span><i class="fas fa-video me-1"></i><?php echo strtoupper(substr($mentor->meeting_platforms, 0, 10)); ?></span>
                                    </div>
                                    <span style="color: #059669; font-size: 0.78rem; font-weight: 600;">
                                        <?php echo t('Lihat', 'View'); ?> <i class="fas fa-chevron-right" style="font-size: 0.55rem;"></i>
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
