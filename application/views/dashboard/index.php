<!-- ============================================================
     STUDENT DASHBOARD — responsive bento (mobile-first, desktop-ok)
     ============================================================ -->
<div class="container-fluid px-0">

    <!-- ============ BANNER CAROUSEL ============ -->
    <?php $this->load->view('partials/banner_carousel'); ?>

    <!-- ============ WELCOME HERO ============ -->
    <?php
        $hour = (int)date('H');
        if ($hour < 11) $greet = t('Selamat pagi', 'Good morning');
        elseif ($hour < 15) $greet = t('Selamat siang', 'Good afternoon');
        elseif ($hour < 19) $greet = t('Selamat sore', 'Good evening');
        else $greet = t('Selamat malam', 'Good night');
    ?>
    <div class="bento-card mb-4 overflow-hidden" style="background:linear-gradient(120deg,#0D1830 0%,#009688 160%);border:none;color:#fff;">
        <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3 position-relative" style="z-index:1;">
            <div class="d-flex align-items-center gap-3">
                <span class="d-inline-flex align-items-center justify-content-center rounded-circle fw-bold text-white flex-shrink-0" style="width:54px;height:54px;background:rgba(255,255,255,0.16);border:1px solid rgba(255,255,255,0.25);font-size:1.3rem;">
                    <?php echo strtoupper(substr($this->session->userdata('name'), 0, 1)); ?>
                </span>
                <div>
                    <div class="fw-extrabold" style="font-size:1.2rem;"><?php echo $greet; ?>, <?php echo htmlspecialchars(ucfirst($this->session->userdata('name'))); ?> 👋</div>
                    <div style="color:rgba(255,255,255,0.72);font-size:0.8rem;"><?php echo t('Lanjutkan perjalanan belajarmu hari ini.', 'Continue your learning journey today.'); ?></div>
                </div>
            </div>
            <div class="d-flex gap-2 flex-shrink-0">
                <a href="<?php echo base_url('courses'); ?>" class="btn fw-semibold rounded-pill d-inline-flex align-items-center gap-2 border-0" style="background:rgba(255,255,255,0.14);color:#fff;font-size:0.76rem;padding:0.5rem 1rem;">
                    <i data-lucide="search" style="width:13px;height:13px;"></i> <?php echo t('Cari Kelas', 'Find Courses'); ?>
                </a>
                <a href="<?php echo base_url('mentoring'); ?>" class="btn fw-semibold rounded-pill d-inline-flex align-items-center gap-2 border-0 d-none d-md-inline-flex" style="background:#FBBF24;color:#0D1830;font-size:0.76rem;padding:0.5rem 1rem;">
                    <i data-lucide="calendar-check" style="width:13px;height:13px;"></i> <?php echo t('Mentoring', 'Mentoring'); ?>
                </a>
            </div>
        </div>
    </div>

    <!-- ============ STATS ============ -->
    <div class="bento-grid bento-grid-4 mb-4">
        <div class="bento-card blob-primary d-flex align-items-center gap-2">
            <div class="bento-icon bg-primary-subtle text-primary"><i data-lucide="book-open" style="width:20px;height:20px;"></i></div>
            <div>
                <div class="bento-value" style="font-size:1.4rem;"><?php echo count($enrolled_courses); ?></div>
                <div class="bento-label"><?php echo t('Kelas', 'Courses'); ?></div>
            </div>
        </div>
        <div class="bento-card blob-warning d-flex align-items-center gap-2">
            <div class="bento-icon bg-warning-subtle text-warning"><i data-lucide="calendar" style="width:20px;height:20px;"></i></div>
            <div>
                <div class="bento-value" style="font-size:1.4rem;"><?php echo count($registered_seminars); ?></div>
                <div class="bento-label"><?php echo t('Seminar', 'Seminars'); ?></div>
            </div>
        </div>
        <div class="bento-card blob-success d-flex align-items-center gap-2">
            <div class="bento-icon bg-success-subtle text-success"><i data-lucide="award" style="width:20px;height:20px;"></i></div>
            <div>
                <div class="bento-value" style="font-size:1.4rem;"><?php echo count($certificates); ?></div>
                <div class="bento-label"><?php echo t('Sertifikat', 'Certificates'); ?></div>
            </div>
        </div>
        <div class="bento-card blob-danger d-flex align-items-center gap-2">
            <div class="bento-icon bg-danger-subtle text-danger"><i data-lucide="calendar-check" style="width:20px;height:20px;"></i></div>
            <div>
                <div class="bento-value" style="font-size:1.4rem;"><?php echo count($mentoring_sessions ?? array()); ?></div>
                <div class="bento-label"><?php echo t('Mentoring', 'Mentoring'); ?></div>
            </div>
        </div>
    </div>

    <!-- ============ LEARNING PATHS ============ -->
    <?php if (!empty($learning_paths)): ?>
    <div class="bento-card mb-4">
        <div class="d-flex align-items-center justify-content-between mb-3">
            <h6 class="fw-bold text-dark mb-0 d-flex align-items-center gap-2" style="font-size:0.88rem;">
                <i data-lucide="route" style="width:16px;height:16px;color:var(--primary);"></i> <?php echo t('Learning Paths', 'Learning Paths'); ?>
            </h6>
            <a href="<?php echo base_url('learning_paths/mine'); ?>" class="fw-semibold text-decoration-none text-primary d-inline-flex align-items-center gap-1" style="font-size:0.72rem;"><?php echo t('Semua', 'All'); ?> <i data-lucide="arrow-right" style="width:12px;height:12px;"></i></a>
        </div>
        <div class="d-flex flex-column gap-2">
            <?php foreach ($learning_paths as $lp): ?>
                <div class="d-flex align-items-center justify-content-between gap-3 p-2 rounded-3" style="background:var(--gray-50,#f8fafc);">
                    <div class="d-flex align-items-center gap-2 flex-fill min-w-0">
                        <span class="d-inline-flex align-items-center justify-content-center rounded-circle flex-shrink-0" style="width:8px;height:8px;background:<?php echo $lp->color ?? '#4361ee'; ?>;"></span>
                        <span class="fw-semibold text-dark text-truncate" style="font-size:0.8rem;"><?php echo htmlspecialchars($lp->title); ?></span>
                    </div>
                    <div class="d-flex align-items-center gap-2 flex-shrink-0" style="min-width:120px;">
                        <div class="flex-fill rounded-pill overflow-hidden" style="height:6px;background:var(--gray-200,#e7e5e4);">
                            <div class="h-100 rounded-pill" style="width:<?php echo $lp->progress_pct ?? 0; ?>%;background:<?php echo $lp->color ?? '#4361ee'; ?>;"></div>
                        </div>
                        <span class="fw-bold text-dark" style="font-size:0.72rem;min-width:34px;text-align:right;"><?php echo $lp->progress_pct ?? 0; ?>%</span>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php endif; ?>

    <!-- ============ MAIN GRID ============ -->
    <div class="bento-grid bento-grid-3-1 mb-4" style="align-items:start;">
        <!-- ===== KIRI: KELAS + MENTORING ===== -->
        <div class="d-flex flex-column gap-3">
            <!-- Continue learning -->
            <div class="bento-card">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <h6 class="fw-bold text-dark mb-0 d-flex align-items-center gap-2" style="font-size:0.88rem;">
                        <i data-lucide="book-open" style="width:16px;height:16px;color:var(--primary);"></i> <?php echo t('Lanjutkan Belajar', 'Continue Learning'); ?>
                    </h6>
                    <a href="<?php echo base_url('courses/mine'); ?>" class="fw-semibold text-decoration-none text-primary d-inline-flex align-items-center gap-1" style="font-size:0.72rem;"><?php echo t('Lihat Semua', 'View All'); ?> <i data-lucide="arrow-right" style="width:12px;height:12px;"></i></a>
                </div>
                <?php if (empty($enrolled_courses)): ?>
                    <div class="text-center py-4">
                        <div class="mx-auto d-inline-flex align-items-center justify-content-center rounded-circle mb-3" style="width:56px;height:56px;background:#E0F2F1;color:#009688;"><i data-lucide="book-open" style="width:24px;height:24px;"></i></div>
                        <p class="text-secondary small mb-3"><?php echo t('Belum ada kelas diambil. Mulai jelajahi kelas yang tersedia!', 'No courses enrolled yet. Start exploring available courses!'); ?></p>
                        <a href="<?php echo base_url('courses'); ?>" class="btn btn-primary rounded-pill px-4 fw-semibold btn-sm"><?php echo t('Jelajahi Kelas', 'Explore Courses'); ?></a>
                    </div>
                <?php else: ?>
                    <div class="row g-2">
                        <?php foreach (array_slice($enrolled_courses, 0, 4) as $course): ?>
                            <?php $pct = $course->progress_pct ?? 0; ?>
                            <div class="col-md-6">
                                <a href="<?php echo base_url('courses/learn/' . $course->slug); ?>" class="course-mini-card text-decoration-none d-block">
                                    <div class="d-flex align-items-center gap-2 mb-2">
                                        <span class="d-inline-flex align-items-center justify-content-center rounded-2 fw-bold text-white flex-shrink-0" style="width:34px;height:34px;background:linear-gradient(135deg,#009688,#0d9488);font-size:0.8rem;">
                                            <?php echo strtoupper(substr(trim($course->title), 0, 1)); ?>
                                        </span>
                                        <span class="fw-bold text-dark text-truncate" style="font-size:0.78rem;"><?php echo htmlspecialchars(t($course->title, $course->title_en ?: $course->title)); ?></span>
                                    </div>
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="flex-fill rounded-pill overflow-hidden" style="height:5px;background:var(--gray-200,#e7e5e4);">
                                            <div class="h-100 rounded-pill" style="width:<?php echo $pct; ?>%;background:linear-gradient(90deg,#009688,#34d399);"></div>
                                        </div>
                                        <span class="fw-bold text-dark" style="font-size:0.7rem;"><?php echo $pct; ?>%</span>
                                    </div>
                                    <div class="text-primary mt-1" style="font-size:0.68rem;font-weight:600;"><?php echo t('Belajar', 'Learn'); ?> <i class="fas fa-arrow-right" style="font-size:0.5rem;"></i></div>
                                </a>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Mentoring sessions -->
            <div class="bento-card">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <h6 class="fw-bold text-dark mb-0 d-flex align-items-center gap-2" style="font-size:0.88rem;">
                        <i data-lucide="calendar-check" style="width:16px;height:16px;color:var(--warning);"></i> <?php echo t('Sesi Mentoring', 'Mentoring Sessions'); ?>
                    </h6>
                    <a href="<?php echo base_url('mentoring'); ?>" class="fw-semibold text-decoration-none text-primary d-inline-flex align-items-center gap-1" style="font-size:0.72rem;"><?php echo t('Cari Mentor', 'Find Mentor'); ?> <i data-lucide="arrow-right" style="width:12px;height:12px;"></i></a>
                </div>
                <?php
                    $upcoming_m = array_slice(array_filter($mentoring_sessions ?? array(), fn($s) => strtotime($s->scheduled_at) > time()), 0, 3);
                ?>
                <?php if (empty($upcoming_m)): ?>
                    <p class="text-secondary small mb-0"><?php echo t('Tidak ada sesi mendatang.', 'No upcoming sessions.'); ?> <a href="<?php echo base_url('mentoring'); ?>" class="fw-semibold text-primary text-decoration-none"><?php echo t('Temukan mentor', 'Find a mentor'); ?></a></p>
                <?php else: ?>
                    <div class="d-flex flex-column gap-2">
                        <?php foreach ($upcoming_m as $s): ?>
                            <div class="d-flex align-items-center gap-2 p-2 rounded-3" style="background:var(--gray-50,#f8fafc);">
                                <span class="d-inline-flex align-items-center justify-content-center rounded-circle fw-bold text-white flex-shrink-0" style="width:30px;height:30px;background:linear-gradient(135deg,#009688,#34d399);font-size:0.75rem;"><?php echo strtoupper(substr($s->mentor_name ?? 'M', 0, 1)); ?></span>
                                <div class="flex-fill min-w-0">
                                    <div class="fw-semibold text-dark text-truncate" style="font-size:0.76rem;"><?php echo htmlspecialchars($s->mentor_name ?? 'Mentor'); ?></div>
                                    <div class="text-secondary" style="font-size:0.66rem;"><?php echo date('d M · H:i', strtotime($s->scheduled_at)); ?></div>
                                </div>
                                <?php if ($s->status === 'confirmed'): ?><span class="px-2 py-1 rounded-pill fw-bold flex-shrink-0" style="background:#E0F2F1;color:#009688;font-size:0.6rem;"><?php echo t('Dikonfirmasi', 'Confirmed'); ?></span>
                                <?php elseif ($s->status === 'completed'): ?><span class="px-2 py-1 rounded-pill fw-bold flex-shrink-0" style="background:#f1f5f9;color:#64748b;font-size:0.6rem;"><?php echo t('Selesai', 'Done'); ?></span>
                                <?php else: ?><span class="px-2 py-1 rounded-pill fw-bold flex-shrink-0" style="background:#fffbeb;color:#d97706;font-size:0.6rem;"><?php echo t('Menunggu', 'Pending'); ?></span><?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Recent transactions -->
            <?php if (!empty($transactions)): ?>
            <div class="bento-card">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <h6 class="fw-bold text-dark mb-0 d-flex align-items-center gap-2" style="font-size:0.88rem;">
                        <i data-lucide="receipt" style="width:16px;height:16px;color:var(--gray-400,#94a3b8);"></i> <?php echo t('Transaksi Terakhir', 'Recent Transactions'); ?>
                    </h6>
                    <a href="<?php echo base_url('transactions/history'); ?>" class="fw-semibold text-decoration-none text-primary d-inline-flex align-items-center gap-1" style="font-size:0.72rem;"><?php echo t('Riwayat', 'History'); ?> <i data-lucide="arrow-right" style="width:12px;height:12px;"></i></a>
                </div>
                <div class="d-flex flex-column">
                    <?php foreach (array_slice($transactions, 0, 3) as $tx): ?>
                        <?php if ($tx->status === 'approved') { $tb='#E0F2F1'; $tt='#009688'; $tl=t('Berhasil','Success'); }
                        elseif ($tx->status === 'pending') { $tb='#fffbeb'; $tt='#d97706'; $tl=t('Pending','Pending'); }
                        else { $tb='#fef2f2'; $tt='#dc2626'; $tl=t('Ditolak','Failed'); } ?>
                        <div class="d-flex align-items-center gap-3 py-2" style="border-bottom:1px dashed var(--gray-100,#f0eeeb);">
                            <span class="d-inline-flex align-items-center justify-content-center rounded-2 flex-shrink-0" style="width:32px;height:32px;background:#E6EBEF;color:#78716c;"><i class="fas fa-receipt" style="font-size:0.68rem;"></i></span>
                            <div class="flex-fill min-w-0">
                                <div class="fw-semibold text-dark text-truncate" style="font-size:0.76rem;"><?php echo t(ucfirst($tx->item_type), ucfirst($tx->item_type)); ?></div>
                                <div class="text-secondary" style="font-size:0.68rem;"><?php echo date('d M Y', strtotime($tx->created_at)); ?> · Rp <?php echo number_format($tx->amount, 0, ',', '.'); ?></div>
                            </div>
                            <span class="px-2 py-1 rounded-pill fw-bold flex-shrink-0" style="background:<?php echo $tb; ?>;color:<?php echo $tt; ?>;font-size:0.6rem;"><?php echo $tl; ?></span>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endif; ?>
        </div>

        <!-- ===== KANAN: SEMINAR + SERTIFIKAT ===== -->
        <div class="d-flex flex-column gap-3">
            <!-- Seminars -->
            <div class="bento-card">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <h6 class="fw-bold text-dark mb-0 d-flex align-items-center gap-2" style="font-size:0.88rem;">
                        <i data-lucide="calendar" style="width:16px;height:16px;color:var(--warning);"></i> <?php echo t('Seminar Terdekat', 'Upcoming Seminars'); ?>
                    </h6>
                    <a href="<?php echo base_url('seminars/mine'); ?>" class="fw-semibold text-decoration-none text-primary" style="font-size:0.72rem;"><?php echo t('Semua', 'All'); ?></a>
                </div>
                <?php $upcoming_sems = array_slice(array_filter($registered_seminars ?? array(), function($s) { return strtotime($s->date_time) > time(); }), 0, 3); ?>
                <?php if (empty($upcoming_sems)): ?>
                    <p class="text-secondary small mb-0"><?php echo t('Belum ada seminar mendatang.', 'No upcoming seminars.'); ?> <a href="<?php echo base_url('seminars'); ?>" class="fw-semibold text-primary text-decoration-none"><?php echo t('Cari Seminar', 'Find Seminars'); ?></a></p>
                <?php else: ?>
                    <div class="d-flex flex-column gap-2">
                        <?php foreach ($upcoming_sems as $sem): ?>
                            <div class="d-flex align-items-center gap-2 p-2 rounded-3" style="background:var(--gray-50,#f8fafc);">
                                <div class="d-flex flex-column align-items-center justify-content-center rounded-2 flex-shrink-0 fw-bold" style="width:38px;height:42px;background:#E0F2F1;color:#009688;line-height:1.1;">
                                    <span style="font-size:0.55rem;"><?php echo date('M', strtotime($sem->date_time)); ?></span>
                                    <span style="font-size:0.85rem;"><?php echo date('d', strtotime($sem->date_time)); ?></span>
                                </div>
                                <div class="flex-fill min-w-0">
                                    <div class="fw-semibold text-dark text-truncate" style="font-size:0.75rem;"><?php echo htmlspecialchars(t($sem->title, $sem->title_en ?: $sem->title)); ?></div>
                                    <div class="text-secondary" style="font-size:0.66rem;"><?php echo date('H:i', strtotime($sem->date_time)); ?> WIB</div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Certificates -->
            <div class="bento-card">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <h6 class="fw-bold text-dark mb-0 d-flex align-items-center gap-2" style="font-size:0.88rem;">
                        <i data-lucide="award" style="width:16px;height:16px;color:#d97706;"></i> <?php echo t('Sertifikat', 'Certificates'); ?>
                    </h6>
                    <a href="<?php echo base_url('certificate/my'); ?>" class="fw-semibold text-decoration-none text-primary" style="font-size:0.72rem;"><?php echo t('Semua', 'All'); ?></a>
                </div>
                <?php if (empty($certificates)): ?>
                    <p class="text-secondary small mb-0"><?php echo t('Belum ada sertifikat.', 'No certificates yet.'); ?></p>
                <?php else: ?>
                    <div class="d-flex flex-column gap-2">
                        <?php foreach (array_slice($certificates, 0, 3) as $cert): ?>
                            <a href="<?php echo base_url('certificate/view/' . encode_id($cert->id)); ?>" class="profile-link-row">
                                <i class="fas fa-file-alt" style="font-size:0.75rem;color:#d97706;"></i>
                                <span class="fw-semibold text-dark text-truncate" style="font-size:0.78rem;"><?php echo htmlspecialchars($cert->title); ?></span>
                                <i data-lucide="chevron-right" style="width:13px;height:13px;color:#c2c8d0;flex-shrink:0;"></i>
                            </a>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
