<?php $_mob_mentor_panel = $this->session->userdata('logged_in'); ?>

<?php if ($_mob_mentor_panel): ?>
<!-- ============ PANEL STUDENT (desktop + mobile app-style) ============ -->
<div class="container-fluid py-4" style="padding-top: 0px !important; max-width: 1100px;">

    <!-- ===== Hero banner panel (ringkas) ===== -->
    <div class="mn-panel-hero mb-4" style="background: linear-gradient(120deg,#0D1830 0%,#0D1830 45%,#00796B 100%); border-radius: 18px; padding: 1.25rem 1.5rem; color: #fff; position: relative; overflow: hidden;">
        <div style="position:absolute; top:-50px; right:-30px; width:180px; height:180px; border-radius:50%; background:rgba(251,191,36,0.14);"></div>
        <div style="position:absolute; bottom:-70px; left:30%; width:160px; height:160px; border-radius:50%; background:rgba(0,150,136,0.3);"></div>
        <div class="d-flex align-items-center justify-content-between gap-3 flex-wrap position-relative">
            <div class="d-flex align-items-center gap-3">
                <div class="d-flex align-items-center justify-content-center rounded-3 flex-shrink-0" style="width:52px; height:52px; background: rgba(255,255,255,0.1); border:1px solid rgba(255,255,255,0.15); backdrop-filter: blur(6px);">
                    <i class="fas fa-users" style="color: #FBBF24; font-size: 1.2rem;"></i>
                </div>
                <div>
                    <h5 class="fw-extrabold mb-0" style="font-size: 1.1rem; letter-spacing: -0.02em;"><?php echo t('Mentoring', 'Mentoring'); ?></h5>
                    <small style="color: rgba(230,235,239,0.75); font-size: 0.75rem;"><?php echo t('Sesi 1-on-1 dengan mentor ahli', '1-on-1 sessions with expert mentors'); ?></small>
                    <div class="d-flex gap-3 mt-1" style="font-size: 0.72rem;">
                        <span><strong style="color:#FBBF24;"><?php echo count($mentors); ?></strong> <span style="color:rgba(230,235,239,0.6);"><?php echo t('Mentor', 'Mentors'); ?></span></span>
                        <span><strong style="color:#FBBF24;">16+</strong> <span style="color:rgba(230,235,239,0.6);"><?php echo t('Bidang', 'Fields'); ?></span></span>
                    </div>
                </div>
            </div>
            <a href="<?php echo base_url('mentoring/my_sessions'); ?>" class="btn fw-semibold rounded-pill flex-shrink-0" style="background:#FBBF24; color:#0D1830; font-size:0.8rem; padding:0.55rem 1.1rem; box-shadow: 0 4px 14px rgba(251,191,36,0.3);">
                <i class="fas fa-calendar-check me-1"></i> <?php echo t('Sesi Saya', 'My Sessions'); ?>
            </a>
        </div>
    </div>

    <!-- Mobile App-Style -->
    <div class="dashboard-mobile-only">
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
        <div class="d-flex gap-2 overflow-auto pb-1 mb-3" style="scrollbar-width: none; -ms-overflow-style: none;">
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
                    <a href="<?php echo base_url('mentoring/detail/' . encode_id($mentor->id)); ?>" class="mn-card text-decoration-none w-100">
                        <!-- Cover gradient + watermark -->
                        <div class="mn-cover" style="background: linear-gradient(135deg,#009688 0%,#0D1830 100%);">
                            <span class="mn-cover-watermark"><?php echo strtoupper(substr($mentor->name, 0, 1)); ?></span>
                            <?php if ((float)$mentor->price_per_session > 0): ?>
                            <span class="mn-price-badge">Rp <?php echo number_format($mentor->price_per_session / 1000, 0); ?>rb<span class="mn-price-unit">/ <?php echo t('sesi', 'session'); ?></span></span>
                            <?php endif; ?>
                        </div>
                        <!-- Avatar overlap -->
                        <div class="mn-avatar-wrap">
                            <?php if (!empty($mentor->avatar) && file_exists(FCPATH . 'uploads/mentors/' . $mentor->avatar)): ?>
                            <img src="<?php echo base_url('uploads/mentors/' . $mentor->avatar); ?>" alt="" class="mn-avatar">
                            <?php else: ?>
                            <span class="mn-avatar mn-avatar-initial"><?php echo strtoupper(substr($mentor->name, 0, 1)); ?></span>
                            <?php endif; ?>
                        </div>
                        <div class="mn-body">
                            <div class="d-flex align-items-center gap-1">
                                <span class="fw-bold text-truncate mn-name"><?php echo htmlspecialchars($mentor->name); ?></span>
                                <i class="fas fa-check-circle flex-shrink-0" style="color: #009688; font-size: 0.75rem;" title="<?php echo t('Terverifikasi', 'Verified'); ?>"></i>
                            </div>
                            <div class="text-truncate mn-title"><?php echo htmlspecialchars(t($mentor->title, $mentor->title_en)); ?></div>
                            <div class="d-flex align-items-center gap-1 mt-1">
                                <i class="fas fa-star" style="color: #FBBF24; font-size: 0.62rem;"></i>
                                <span class="fw-bold mn-rating"><?php echo $mentor->avg_rating; ?></span>
                                <span class="mn-reviews">(<?php echo $mentor->total_reviews; ?>)</span>
                            </div>
                            <?php
                            $m_cats = $this->db->select('mentor_categories.*')
                                ->from('mentor_category_pivot')
                                ->join('mentor_categories', 'mentor_categories.id = mentor_category_pivot.category_id')
                                ->where('mentor_category_pivot.mentor_id', $mentor->id)
                                ->get()->result();
                            ?>
                            <?php if (!empty($m_cats)): ?>
                            <div class="d-flex gap-1 overflow-auto mt-2" style="scrollbar-width:none; -ms-overflow-style:none;">
                                <?php foreach (array_slice($m_cats, 0, 3) as $mc): ?>
                                <span class="mn-chip"><?php echo htmlspecialchars(t($mc->name, $mc->name_en)); ?></span>
                                <?php endforeach; ?>
                            </div>
                            <?php endif; ?>
                            <?php if (!empty($mentor->bio)): ?>
                            <p class="mb-0 mt-2 mn-bio"><?php echo htmlspecialchars(t($mentor->bio, $mentor->bio_en)); ?></p>
                            <?php endif; ?>
                            <div class="d-flex align-items-center justify-content-between mt-2 pt-2 mn-footer">
                                <div class="d-flex gap-3 mn-meta">
                                    <span><i class="fas fa-clock me-1"></i><?php echo $mentor->total_sessions; ?> <?php echo t('sesi', 'sessions'); ?></span>
                                    <span><i class="fas fa-video me-1"></i><?php echo strtoupper(substr($mentor->meeting_platforms, 0, 8)); ?></span>
                                </div>
                                <span class="mn-view"><?php echo t('Lihat Profil', 'View Profile'); ?> <i class="fas fa-chevron-right" style="font-size: 0.5rem;"></i></span>
                            </div>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>

    <!-- Desktop Panel Version -->
    <div class="dashboard-desktop-only">
        <!-- Search + chips toolbar -->
        <div class="d-flex flex-column gap-3 mb-4">
            <form method="get" class="d-flex gap-2">
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
            <div class="d-flex gap-2 overflow-auto" style="scrollbar-width: none; -ms-overflow-style: none;">
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
                        <div class="mn-card mn-card-desktop h-100">
                            <!-- Cover gradient + watermark -->
                            <div class="mn-cover" style="background: linear-gradient(135deg,#009688 0%,#0D1830 100%);">
                                <span class="mn-cover-watermark"><?php echo strtoupper(substr($mentor->name, 0, 1)); ?></span>
                                <?php if ((float)$mentor->price_per_session > 0): ?>
                                <span class="mn-price-badge">Rp <?php echo number_format($mentor->price_per_session, 0, ',', '.'); ?><span class="mn-price-unit">/ <?php echo t('sesi', 'session'); ?></span></span>
                                <?php endif; ?>
                            </div>
                            <!-- Avatar overlap -->
                            <div class="mn-avatar-wrap">
                                <?php if (!empty($mentor->avatar) && file_exists(FCPATH . 'uploads/mentors/' . $mentor->avatar)): ?>
                                <img src="<?php echo base_url('uploads/mentors/' . $mentor->avatar); ?>" alt="" class="mn-avatar">
                                <?php else: ?>
                                <span class="mn-avatar mn-avatar-initial"><?php echo strtoupper(substr($mentor->name, 0, 1)); ?></span>
                                <?php endif; ?>
                            </div>
                            <div class="mn-body d-flex flex-column">
                                <div class="d-flex align-items-center gap-1">
                                    <span class="fw-bold text-truncate mn-name"><?php echo htmlspecialchars($mentor->name); ?></span>
                                    <i class="fas fa-check-circle flex-shrink-0" style="color: #009688; font-size: 0.78rem;" title="<?php echo t('Terverifikasi', 'Verified'); ?>"></i>
                                </div>
                                <div class="text-truncate mn-title"><?php echo htmlspecialchars(t($mentor->title, $mentor->title_en)); ?></div>
                                <div class="d-flex align-items-center gap-1 mt-1">
                                    <i class="fas fa-star" style="color: #FBBF24; font-size: 0.65rem;"></i>
                                    <span class="fw-bold mn-rating"><?php echo $mentor->avg_rating; ?></span>
                                    <span class="mn-reviews">(<?php echo $mentor->total_reviews; ?>)</span>
                                </div>
                                <p class="mb-0 mt-2 mn-bio"><?php echo htmlspecialchars(t($mentor->bio, $mentor->bio_en)); ?></p>
                                <?php
                                $m_cats = $this->db->select('mentor_categories.*')
                                    ->from('mentor_category_pivot')
                                    ->join('mentor_categories', 'mentor_categories.id = mentor_category_pivot.category_id')
                                    ->where('mentor_category_pivot.mentor_id', $mentor->id)
                                    ->get()->result();
                                ?>
                                <?php if (!empty($m_cats)): ?>
                                <div class="d-flex flex-wrap gap-1 mt-2">
                                    <?php foreach (array_slice($m_cats, 0, 3) as $mc): ?>
                                    <span class="mn-chip"><?php echo htmlspecialchars(t($mc->name, $mc->name_en)); ?></span>
                                    <?php endforeach; ?>
                                </div>
                                <?php endif; ?>
                                <div class="d-flex align-items-center justify-content-between mt-3 pt-2 mn-footer mt-auto">
                                    <div class="d-flex gap-3 mn-meta">
                                        <span><i class="fas fa-clock me-1"></i><?php echo $mentor->total_sessions; ?> <?php echo t('sesi', 'sessions'); ?></span>
                                        <span><i class="fas fa-video me-1"></i><?php echo strtoupper(substr($mentor->meeting_platforms, 0, 10)); ?></span>
                                    </div>
                                    <a href="<?php echo base_url('mentoring/detail/' . encode_id($mentor->id)); ?>" class="btn btn-sm fw-bold rounded-pill px-3 flex-shrink-0 text-decoration-none" style="background: #009688; color: #fff; font-size: 0.72rem;"><?php echo t('Lihat', 'View'); ?></a>
                                </div>
                            </div>
                        </div>
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
    <div class="container position-relative mh-hero-inner" style="max-width: 1000px;">
        <div class="text-center mb-4">
            <span class="px-3 py-1 rounded-pill fw-semibold mb-3 d-inline-block mh-badge" style="background: rgba(251,191,36,0.18); color: #FBBF24; border: 1px solid rgba(251,191,36,0.35); font-size: 0.72rem; letter-spacing: 0.04em;">
                <i class="fas fa-users me-1"></i> 1-ON-1 MENTORING
            </span>
            <h1 class="fw-extrabold mb-2 mh-title" style="letter-spacing: -0.03em; color: #fff; text-shadow: 0 2px 20px rgba(0,0,0,0.2);">
                <?php echo t('Dapatkan Mentoring Karirmu', 'Get Career Mentoring'); ?>
                <br><span style="color: #FBBF24;"><?php echo t('Bersama Mentor Ahli', 'With Expert Mentors'); ?></span>
            </h1>
            <p class="mb-3 mx-auto mh-sub" style="color: rgba(230,235,239,0.85); max-width: 540px;">
                <?php echo t('Pilih mentor, jadwalkan sesi 1-on-1, dan mulai perjalanan karirmu.', 'Choose a mentor, schedule a 1-on-1 session, and start your career journey.'); ?>
            </p>
            <div class="d-flex justify-content-center mh-stats mb-3">
                <div><strong style="color: #FBBF24;">16+</strong> <span style="color: rgba(230,235,239,0.75);"><?php echo t('Bidang', 'Fields'); ?></span></div>
                <div class="mh-stat-divider"></div>
                <div><strong style="color: #FBBF24;"><?php echo count($mentors); ?>+</strong> <span style="color: rgba(230,235,239,0.75);"><?php echo t('Mentor', 'Mentors'); ?></span></div>
                <div class="mh-stat-divider"></div>
                <div><strong style="color: #FBBF24;">200+</strong> <span style="color: rgba(230,235,239,0.75);"><?php echo t('Industri', 'Industries'); ?></span></div>
            </div>
        </div>

        <!-- 3 Steps -->
        <div class="d-flex justify-content-center gap-2 mh-steps mb-1">
            <div class="d-flex align-items-center gap-2 px-3 py-2 rounded-3 mh-step" style="background: rgba(255,255,255,0.08); border: 1px solid rgba(255,255,255,0.12); backdrop-filter: blur(8px);">
                <div class="fw-bold d-inline-flex align-items-center justify-content-center flex-shrink-0" style="width: 22px; height: 22px; border-radius: 50%; background: #FBBF24; color: #0D1830; font-size: 0.68rem;">1</div>
                <span style="color: rgba(255,255,255,0.9); font-weight: 500;"><?php echo t('Jelajahi Mentor', 'Explore Mentors'); ?></span>
            </div>
            <div class="d-flex align-items-center gap-2 px-3 py-2 rounded-3 mh-step" style="background: rgba(255,255,255,0.08); border: 1px solid rgba(255,255,255,0.12); backdrop-filter: blur(8px);">
                <div class="fw-bold d-inline-flex align-items-center justify-content-center flex-shrink-0" style="width: 22px; height: 22px; border-radius: 50%; background: #FBBF24; color: #0D1830; font-size: 0.68rem;">2</div>
                <span style="color: rgba(255,255,255,0.9); font-weight: 500;"><?php echo t('Pilih Jadwal', 'Choose Schedule'); ?></span>
            </div>
            <div class="d-flex align-items-center gap-2 px-3 py-2 rounded-3 mh-step" style="background: rgba(255,255,255,0.08); border: 1px solid rgba(255,255,255,0.12); backdrop-filter: blur(8px);">
                <div class="fw-bold d-inline-flex align-items-center justify-content-center flex-shrink-0" style="width: 22px; height: 22px; border-radius: 50%; background: #FBBF24; color: #0D1830; font-size: 0.68rem;">3</div>
                <span style="color: rgba(255,255,255,0.9); font-weight: 500;"><?php echo t('Mentoring 1-on-1', '1-on-1 Mentoring'); ?></span>
            </div>
        </div>
    </div>
</section>

<!-- Category Tabs -->
<div style="border-bottom: 1px solid #E6EBEF; background: #fff; position: sticky; top: 0; z-index: 20;">
    <div class="container d-flex gap-2 overflow-auto py-2 py-md-3" style="max-width: 1000px; scrollbar-width: none; -ms-overflow-style: none;">
        <a href="<?php echo base_url('mentoring'); ?>" class="px-3 py-2 rounded-pill fw-semibold text-decoration-none flex-shrink-0 mh-chip" style="background: <?php echo !$selected_category ? '#009688' : '#E6EBEF'; ?>; color: <?php echo !$selected_category ? '#fff' : '#525252'; ?>;">
            <?php echo t('Semua', 'All'); ?>
        </a>
        <?php foreach ($categories as $cat): ?>
            <a href="<?php echo base_url('mentoring?category=' . $cat->id); ?>" class="px-3 py-2 rounded-pill fw-semibold text-decoration-none flex-shrink-0 mh-chip" style="background: <?php echo $selected_category == $cat->id ? '#009688' : '#E6EBEF'; ?>; color: <?php echo $selected_category == $cat->id ? '#fff' : '#525252'; ?>;">
                <?php echo htmlspecialchars(t($cat->name, $cat->name_en)); ?>
            </a>
        <?php endforeach; ?>
        <a href="<?php echo base_url('mentoring/packages'); ?>" class="px-3 py-2 rounded-pill fw-semibold text-decoration-none flex-shrink-0 mh-chip" style="background: #FEF3C7; color: #92400E;">
            <i class="fas fa-shopping-bag" style="font-size: 0.65rem;"></i> <?php echo t('Paket', 'Packages'); ?>
        </a>
    </div>
</div>

<!-- Search -->
<div style="background: #E6EBEF; border-bottom: 1px solid #d6dde4;">
    <div class="container py-2 py-md-3" style="max-width: 1000px;">
        <form method="get" class="d-flex gap-2">
            <?php if ($selected_category): ?>
                <input type="hidden" name="category" value="<?php echo $selected_category; ?>">
            <?php endif; ?>
            <div class="flex-fill position-relative">
                <i class="fas fa-search position-absolute" style="left: 14px; top: 50%; transform: translateY(-50%); color: #a3a3a3; font-size: 0.8rem;"></i>
                <input type="text" name="search" class="form-control" value="<?php echo htmlspecialchars($search_query ?? ''); ?>" placeholder="<?php echo t('Cari mentor...', 'Search mentors...'); ?>" style="padding-left: 36px; border-radius: 100px; border-color: #d6dde4; font-size: 0.85rem; height: 42px; background: #fff;">
            </div>
            <button type="submit" class="btn px-4 fw-semibold flex-shrink-0" style="background: #0D1830; color: #fff; border-radius: 100px; font-size: 0.85rem; height: 42px;">
                <i class="fas fa-search"></i>
            </button>
        </form>
    </div>
</div>

<!-- Mentor List -->
<div class="container" style="max-width: 1000px; padding-top: 1.25rem; padding-bottom: 3rem;">
    <div class="mb-3 d-flex align-items-center justify-content-between" style="color: #737373; font-size: 0.82rem; font-weight: 500;">
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

        <!-- ==== MOBILE: app-style vertical list ==== -->
        <div class="d-lg-none d-flex flex-column gap-3">
            <?php foreach ($mentors as $mentor): ?>
                <a href="<?php echo base_url('mentoring/detail/' . encode_id($mentor->id)); ?>" class="text-decoration-none mh-mob-card">
                    <div class="d-flex align-items-center gap-3 mb-2">
                        <?php if (!empty($mentor->avatar) && file_exists(FCPATH . 'uploads/mentors/' . $mentor->avatar)): ?>
                        <img src="<?php echo base_url('uploads/mentors/' . $mentor->avatar); ?>" alt="" class="flex-shrink-0" style="width: 50px; height: 50px; border-radius: 50%; object-fit: cover; background: #E0F2F1;">
                        <?php else: ?>
                        <span class="flex-shrink-0" style="background: linear-gradient(135deg,#009688,#00796B); color:#fff; font-size: 1.05rem; width: 50px; height: 50px; border-radius: 50%; display:inline-flex; align-items:center; justify-content:center; font-weight:700;">
                            <?php echo strtoupper(substr($mentor->name, 0, 1)); ?>
                        </span>
                        <?php endif; ?>
                        <div class="min-w-0 flex-fill">
                            <div class="fw-bold text-truncate" style="color: #0D1830; font-size: 0.9rem;"><?php echo htmlspecialchars($mentor->name); ?></div>
                            <div class="text-truncate" style="color: #78716c; font-size: 0.75rem;"><?php echo htmlspecialchars(t($mentor->title, $mentor->title_en)); ?></div>
                            <div class="d-flex align-items-center gap-1 mt-1">
                                <i class="fas fa-star" style="color: #FBBF24; font-size: 0.62rem;"></i>
                                <span class="fw-bold" style="color: #0D1830; font-size: 0.75rem;"><?php echo $mentor->avg_rating; ?></span>
                                <span style="color: #a8a29e; font-size: 0.68rem;">(<?php echo $mentor->total_reviews; ?>)</span>
                            </div>
                        </div>
                        <?php if ((float)$mentor->price_per_session > 0): ?>
                        <div class="text-end flex-shrink-0">
                            <div class="fw-bold" style="color: #009688; font-size: 0.82rem; white-space: nowrap;">Rp <?php echo number_format($mentor->price_per_session / 1000, 0); ?>rb</div>
                            <div style="color:#a8a29e; font-size:0.62rem;">/ <?php echo t('sesi', 'session'); ?></div>
                        </div>
                        <?php endif; ?>
                    </div>
                    <?php if (!empty($mentor->bio)): ?>
                    <p class="mb-2" style="color: #78716c; font-size: 0.75rem; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; line-height: 1.45;">
                        <?php echo htmlspecialchars(t($mentor->bio, $mentor->bio_en)); ?>
                    </p>
                    <?php endif; ?>
                    <div class="d-flex align-items-center justify-content-between pt-2" style="border-top: 1px solid #E6EBEF;">
                        <div class="d-flex gap-3" style="color: #a8a29e; font-size: 0.68rem;">
                            <span><i class="fas fa-clock me-1"></i><?php echo $mentor->total_sessions; ?> <?php echo t('sesi', 'sessions'); ?></span>
                            <span><i class="fas fa-video me-1"></i><?php echo strtoupper(substr($mentor->meeting_platforms, 0, 8)); ?></span>
                        </div>
                        <span style="color: #009688; font-size: 0.75rem; font-weight: 600;"><?php echo t('Lihat', 'View'); ?> <i class="fas fa-chevron-right" style="font-size: 0.5rem;"></i></span>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>

        <!-- ==== DESKTOP: grid ==== -->
        <div class="row g-3 d-none d-lg-flex">
            <?php foreach ($mentors as $mentor): ?>
                <div class="col-lg-4">
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
