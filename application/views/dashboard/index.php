<div class="container-fluid py-4" style="padding-top: 0px !important; max-width: 1200px;">
    <!-- Header with greeting -->
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
        <div>
            <div style="color: #78716c; font-size: 0.82rem; font-weight: 500; margin-bottom: 0.15rem;">
                <?php
                $hour = (int)date('H');
                if ($hour < 12) echo t('Selamat pagi', 'Good morning');
                elseif ($hour < 15) echo t('Selamat siang', 'Good afternoon');
                elseif ($hour < 18) echo t('Selamat sore', 'Good evening');
                else echo t('Selamat malam', 'Good night');
                ?>
            </div>
            <h4 class="fw-extrabold mb-0" style="color: #1c1917; letter-spacing: -0.02em; font-size: 1.4rem;">
                <?php echo htmlspecialchars(ucfirst($this->session->userdata('name'))); ?> 👋
            </h4>
        </div>
        <div>
            <a href="<?php echo base_url('courses'); ?>" class="btn px-3 py-2 fw-semibold rounded-pill" style="background: #059669; color: #fff; font-size: 0.8rem;">
                <i class="fas fa-search me-1"></i> <?php echo t('Cari Kelas', 'Find Courses'); ?>
            </a>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="row g-3 mb-4">
        <div class="col-6 col-md-3">
            <div class="border rounded-3 p-3 text-center" style="border-color: #e7e5e4; border-radius: 12px;">
                <div class="d-inline-flex align-items-center justify-content-center rounded-2 mb-2" style="width: 38px; height: 38px; background: #f0fdfa;">
                    <i class="fas fa-book-open" style="color: #059669; font-size: 0.85rem;"></i>
                </div>
                <div class="fw-bold" style="color: #1c1917; font-size: 1.1rem; line-height: 1;"><?php echo count($enrolled_courses); ?></div>
                <small style="color: #a8a29e; font-size: 0.7rem;"><?php echo t('Kelas Aktif', 'Active Courses'); ?></small>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="border rounded-3 p-3 text-center" style="border-color: #e7e5e4; border-radius: 12px;">
                <div class="d-inline-flex align-items-center justify-content-center rounded-2 mb-2" style="width: 38px; height: 38px; background: #f0fdfa;">
                    <i class="fas fa-certificate" style="color: #10b981; font-size: 0.85rem;"></i>
                </div>
                <div class="fw-bold" style="color: #1c1917; font-size: 1.1rem; line-height: 1;"><?php echo count($certificates); ?></div>
                <small style="color: #a8a29e; font-size: 0.7rem;"><?php echo t('Sertifikat', 'Certificates'); ?></small>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="border rounded-3 p-3 text-center" style="border-color: #e7e5e4; border-radius: 12px;">
                <div class="d-inline-flex align-items-center justify-content-center rounded-2 mb-2" style="width: 38px; height: 38px; background: #faf5ff;">
                    <i class="fas fa-calendar" style="color: #a855f7; font-size: 0.85rem;"></i>
                </div>
                <div class="fw-bold" style="color: #1c1917; font-size: 1.1rem; line-height: 1;"><?php echo count($registered_seminars); ?></div>
                <small style="color: #a8a29e; font-size: 0.7rem;"><?php echo t('Seminar', 'Seminars'); ?></small>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="border rounded-3 p-3 text-center" style="border-color: #e7e5e4; border-radius: 12px;">
                <div class="d-inline-flex align-items-center justify-content-center rounded-2 mb-2" style="width: 38px; height: 38px; background: #f0fdfa;">
                    <i class="fas fa-calendar-check" style="color: #059669; font-size: 0.85rem;"></i>
                </div>
                <div class="fw-bold" style="color: #1c1917; font-size: 1.1rem; line-height: 1;"><?php echo count($mentoring_sessions ?? []); ?></div>
                <small style="color: #a8a29e; font-size: 0.7rem;"><?php echo t('Mentoring', 'Mentoring'); ?></small>
            </div>
        </div>
    </div>

    <!-- Learning Paths -->
    <?php if (!empty($learning_paths)): ?>
    <div class="border rounded-3 mb-4" style="border-color: #e7e5e4; border-radius: 12px; overflow: hidden;">
        <div class="d-flex justify-content-between align-items-center p-3" style="border-bottom: 1px solid #f0eeeb;">
            <h6 class="fw-bold mb-0 d-flex align-items-center gap-2" style="color: #1c1917; font-size: 0.88rem;">
                <i class="fas fa-route" style="color: #10b981; font-size: 0.75rem;"></i>
                <?php echo t('Learning Paths', 'Learning Paths'); ?>
            </h6>
        </div>
        <div class="p-3">
            <div class="d-flex flex-column gap-2">
                <?php foreach ($learning_paths as $lp): ?>
                    <div class="d-flex justify-content-between align-items-center p-2 rounded-3" style="background: #fafaf9;">
                        <div class="flex-fill me-3 min-w-0">
                            <span class="fw-semibold" style="color: #1c1917; font-size: 0.8rem;"><?php echo htmlspecialchars($lp->title); ?></span>
                        </div>
                        <div class="d-flex align-items-center gap-2 flex-shrink-0" style="min-width: 130px;">
                            <div class="flex-fill rounded-pill overflow-hidden" style="height: 6px; background: #e7e5e4;">
                                <div class="h-100 rounded-pill" style="width: <?php echo $lp->progress_pct; ?>%; background: #059669;"></div>
                            </div>
                            <span class="fw-bold" style="color: #1c1917; font-size: 0.75rem; min-width: 35px; text-align: right;"><?php echo $lp->progress_pct; ?>%</span>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <!-- Main Content Grid -->
    <div class="row g-3 mb-4">
        <!-- My Courses -->
        <div class="col-lg-8">
            <div class="border rounded-3 h-100" style="border-color: #e7e5e4; border-radius: 12px; overflow: hidden;">
                <div class="d-flex justify-content-between align-items-center p-3" style="border-bottom: 1px solid #f0eeeb;">
                    <h6 class="fw-bold mb-0 d-flex align-items-center gap-2" style="color: #1c1917; font-size: 0.88rem;">
                        <i class="fas fa-book-open" style="color: #059669; font-size: 0.75rem;"></i>
                        <?php echo t('Kelas Saya', 'My Courses'); ?>
                    </h6>
                    <a href="<?php echo base_url('courses/mine'); ?>" class="fw-semibold text-decoration-none" style="color: #059669; font-size: 0.75rem;">
                        <?php echo t('Lihat Semua', 'View All'); ?> <i class="fas fa-chevron-right" style="font-size: 0.5rem;"></i>
                    </a>
                </div>
                <div class="p-3">
                    <?php if (empty($enrolled_courses)): ?>
                        <div class="text-center py-4">
                            <div style="font-size: 1.5rem; color: #d6d3d1; margin-bottom: 0.5rem;"><i class="fas fa-book-open"></i></div>
                            <h6 class="fw-bold" style="color: #1c1917;"><?php echo t('Belum Ada Kelas', 'No Courses Yet'); ?></h6>
                            <p style="color: #78716c; font-size: 0.8rem; margin-bottom: 0.75rem; max-width: 280px; margin-left: auto; margin-right: auto;">
                                <?php echo t('Mulai perjalanan belajarmu dengan mendaftar ke kelas yang tersedia.', 'Start your learning journey by enrolling in available courses.'); ?>
                            </p>
                            <a href="<?php echo base_url('courses'); ?>" class="btn px-4 py-2 fw-bold rounded-pill" style="background: #059669; color: #fff; font-size: 0.8rem;">
                                <i class="fas fa-search me-1"></i> <?php echo t('Jelajahi Konten', 'Explore Content'); ?>
                            </a>
                        </div>
                    <?php else: ?>
                        <div class="d-flex flex-column gap-2">
                            <?php foreach (array_slice($enrolled_courses, 0, 5) as $course): ?>
                                <div class="d-flex align-items-center gap-3 p-2 rounded-3" style="background: #fafaf9;">
                                    <img src="https://ui-avatars.com/api/?name=<?php echo urlencode($course->title); ?>&background=fafaf9&color=78716c&size=44&font-size=0.35" alt="" class="rounded-2 flex-shrink-0" style="width: 40px; height: 32px; border: 1px solid #e7e5e4;">
                                    <div class="flex-fill min-w-0">
                                        <h6 class="fw-bold mb-1 text-truncate" style="color: #1c1917; font-size: 0.8rem;">
                                            <?php echo htmlspecialchars(t($course->title, $course->title_en ?: $course->title)); ?>
                                        </h6>
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="flex-fill rounded-pill overflow-hidden" style="height: 4px; background: #e7e5e4;">
                                                <div class="h-100 rounded-pill" style="width: <?php echo $course->progress_pct ?? 0; ?>%; background: #059669;"></div>
                                            </div>
                                            <span class="fw-bold" style="color: #1c1917; font-size: 0.7rem; min-width: 30px; text-align: right;">
                                                <?php echo $course->progress_pct ?? 0; ?>%
                                            </span>
                                        </div>
                                    </div>
                                    <a href="<?php echo base_url('courses/learn/' . $course->slug); ?>" class="btn btn-sm fw-bold rounded-pill px-3 flex-shrink-0" style="background: #059669; color: #fff; font-size: 0.72rem;">
                                        <?php echo t('Belajar', 'Learn'); ?>
                                    </a>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Right Column: Seminars + Certificates -->
        <div class="col-lg-4 d-flex flex-column gap-3">
            <!-- Upcoming Seminars -->
            <div class="border rounded-3" style="border-color: #e7e5e4; border-radius: 12px; overflow: hidden;">
                <div class="p-3" style="border-bottom: 1px solid #f0eeeb;">
                    <h6 class="fw-bold mb-0 d-flex align-items-center gap-2" style="color: #1c1917; font-size: 0.88rem;">
                        <i class="fas fa-calendar" style="color: #a855f7; font-size: 0.75rem;"></i>
                        <?php echo t('Seminar Terbaru', 'Latest Seminars'); ?>
                    </h6>
                </div>
                <div class="p-3">
                    <?php $upcoming_sems = array_slice(array_filter($registered_seminars ?? array(), function($s) { return strtotime($s->date_time) > time(); }), 0, 3); ?>
                    <?php if (empty($upcoming_sems)): ?>
                        <p style="color: #78716c; font-size: 0.78rem; margin-bottom: 0;">
                            <?php echo t('Belum ada seminar.', 'No seminars yet.'); ?>
                            <a href="<?php echo base_url('seminars'); ?>" style="color: #059669; font-weight: 600; text-decoration: none;"><?php echo t('Cari Seminar', 'Find Seminars'); ?></a>
                        </p>
                    <?php else: ?>
                        <div class="d-flex flex-column gap-2">
                            <?php foreach ($upcoming_sems as $sem): ?>
                                <div class="d-flex align-items-start gap-2">
                                    <div class="rounded-2 d-flex align-items-center justify-content-center fw-bold flex-shrink-0" style="width: 36px; height: 36px; background: #fafaf9; border: 1px solid #e7e5e4; font-size: 0.65rem; color: #78716c; flex-direction: column; line-height: 1.1;">
                                        <span style="font-size: 0.6rem;"><?php echo date('M', strtotime($sem->date_time)); ?></span>
                                        <span style="font-size: 0.75rem;"><?php echo date('d', strtotime($sem->date_time)); ?></span>
                                    </div>
                                    <div class="min-w-0 flex-fill">
                                        <h6 class="fw-bold mb-0 text-truncate" style="color: #1c1917; font-size: 0.78rem;">
                                            <?php echo htmlspecialchars(t($sem->title, $sem->title_en ?: $sem->title)); ?>
                                        </h6>
                                        <small style="color: #a8a29e; font-size: 0.68rem;"><?php echo date('H:i', strtotime($sem->date_time)); ?> WIB</small>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                            <?php if (count($upcoming_sems) < count($registered_seminars)): ?>
                                <a href="<?php echo base_url('seminars/mine'); ?>" class="fw-semibold text-decoration-none text-center pt-1" style="color: #059669; font-size: 0.72rem;">
                                    <?php echo t('Lihat semua', 'View all'); ?> <i class="fas fa-chevron-right" style="font-size: 0.5rem;"></i>
                                </a>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Certificates -->
            <div class="border rounded-3" style="border-color: #e7e5e4; border-radius: 12px; overflow: hidden;">
                <div class="p-3" style="border-bottom: 1px solid #f0eeeb;">
                    <h6 class="fw-bold mb-0 d-flex align-items-center gap-2" style="color: #1c1917; font-size: 0.88rem;">
                        <i class="fas fa-award" style="color: #10b981; font-size: 0.75rem;"></i>
                        <?php echo t('Sertifikat', 'Certificates'); ?>
                    </h6>
                </div>
                <div class="p-3">
                    <?php if (empty($certificates)): ?>
                        <p style="color: #78716c; font-size: 0.78rem; margin-bottom: 0;">
                            <?php echo t('Belum ada sertifikat.', 'No certificates yet.'); ?>
                            <?php if (!empty($enrolled_courses)): ?>
                                <a href="<?php echo base_url('courses/mine'); ?>" style="color: #059669; font-weight: 600; text-decoration: none;"><?php echo t('Selesaikan kelas', 'Complete a course'); ?></a>
                            <?php endif; ?>
                        </p>
                    <?php else: ?>
                        <div class="d-flex flex-wrap gap-2">
                            <?php foreach ($certificates as $cert): ?>
                                <a href="<?php echo base_url('certificate/view/' . encode_id($cert->id)); ?>" class="text-decoration-none d-inline-flex align-items-center gap-2 px-3 py-2 rounded-pill" style="border: 1px solid #e7e5e4; color: #1c1917; font-size: 0.75rem; font-weight: 600;">
                                    <i class="fas fa-file-alt" style="color: #10b981; font-size: 0.65rem;"></i>
                                    <?php echo htmlspecialchars($cert->title); ?>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Bottom Row: Mentoring + Transactions -->
    <div class="row g-3">
        <!-- Mentoring -->
        <div class="col-md-6">
            <div class="border rounded-3 h-100" style="border-color: #e7e5e4; border-radius: 12px; overflow: hidden;">
                <div class="d-flex justify-content-between align-items-center p-3" style="border-bottom: 1px solid #f0eeeb;">
                    <h6 class="fw-bold mb-0 d-flex align-items-center gap-2" style="color: #1c1917; font-size: 0.88rem;">
                        <i class="fas fa-calendar-check" style="color: #059669; font-size: 0.75rem;"></i>
                        <?php echo t('Sesi Mentoring', 'Mentoring Sessions'); ?>
                    </h6>
                    <a href="<?php echo base_url('mentoring'); ?>" class="fw-semibold text-decoration-none" style="color: #059669; font-size: 0.75rem;">
                        <?php echo t('Cari Mentor', 'Find Mentor'); ?> <i class="fas fa-chevron-right" style="font-size: 0.5rem;"></i>
                    </a>
                </div>
                <div class="p-3">
                    <?php $upcoming = array_filter($mentoring_sessions ?? array(), fn($s) => strtotime($s->scheduled_at) > time()); ?>
                    <?php $upcoming = array_slice($upcoming, 0, 4); ?>
                    <?php if (empty($upcoming)): ?>
                        <p style="color: #78716c; font-size: 0.78rem; margin-bottom: 0;">
                            <?php echo t('Tidak ada sesi mendatang.', 'No upcoming sessions.'); ?>
                            <a href="<?php echo base_url('mentoring'); ?>" style="color: #059669; font-weight: 600; text-decoration: none;"><?php echo t('Temukan mentor', 'Find a mentor'); ?></a>
                        </p>
                    <?php else: ?>
                        <div class="d-flex flex-column gap-2">
                            <?php foreach ($upcoming as $s): ?>
                                <div class="d-flex align-items-center justify-content-between p-2 rounded-3" style="background: #fafaf9;">
                                    <div class="d-flex align-items-center gap-2 min-w-0">
                                        <img src="https://ui-avatars.com/api/?name=<?php echo urlencode($s->mentor_name ?? 'M'); ?>&background=fafaf9&color=78716c&size=28" alt="" style="width: 28px; height: 28px; border-radius: 50%; border: 1px solid #e7e5e4;">
                                        <div class="min-w-0">
                                            <div class="fw-semibold text-truncate" style="color: #1c1917; font-size: 0.75rem;"><?php echo htmlspecialchars($s->mentor_name ?? 'Mentor'); ?></div>
                                            <small style="color: #a8a29e; font-size: 0.65rem;"><?php echo date('d M H:i', strtotime($s->scheduled_at)); ?></small>
                                        </div>
                                    </div>
                                    <span class="px-2 py-1 rounded-pill fw-medium" style="font-size: 0.6rem; background: <?php echo $s->status === 'confirmed' ? '#f0fdfa' : '#f0fdfa'; ?>; color: <?php echo $s->status === 'confirmed' ? '#10b981' : '#059669'; ?>;">
                                        <?php echo $s->status === 'confirmed' ? t('Dikonfirmasi', 'Confirmed') : t('Menunggu', 'Pending'); ?>
                                    </span>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Recent Transactions -->
        <?php if (!empty($transactions)): ?>
        <div class="col-md-6">
            <div class="border rounded-3 h-100" style="border-color: #e7e5e4; border-radius: 12px; overflow: hidden;">
                <div class="d-flex justify-content-between align-items-center p-3" style="border-bottom: 1px solid #f0eeeb;">
                    <h6 class="fw-bold mb-0 d-flex align-items-center gap-2" style="color: #1c1917; font-size: 0.88rem;">
                        <i class="fas fa-receipt" style="color: #78716c; font-size: 0.75rem;"></i>
                        <?php echo t('Transaksi Terakhir', 'Recent Transactions'); ?>
                    </h6>
                    <a href="<?php echo base_url('transactions/history'); ?>" class="fw-semibold text-decoration-none" style="color: #059669; font-size: 0.75rem;">
                        <?php echo t('Riwayat', 'History'); ?> <i class="fas fa-chevron-right" style="font-size: 0.5rem;"></i>
                    </a>
                </div>
                <div class="p-3">
                    <div class="d-flex flex-column gap-2">
                        <?php foreach (array_slice($transactions, 0, 4) as $tx): ?>
                            <div class="d-flex align-items-center gap-3 p-2 rounded-3" style="background: #fafaf9;">
                                <div class="d-flex align-items-center justify-content-center rounded-2 flex-shrink-0" style="width: 32px; height: 32px; background: #f5f5f4;">
                                    <i class="fas fa-receipt" style="color: #78716c; font-size: 0.7rem;"></i>
                                </div>
                                <div class="flex-fill min-w-0">
                                    <div class="fw-semibold text-truncate" style="color: #1c1917; font-size: 0.78rem;">
                                        <?php echo t(ucfirst($tx->item_type), ucfirst($tx->item_type)); ?>
                                    </div>
                                    <div style="color: #a8a29e; font-size: 0.68rem;">
                                        <?php echo date('d M Y', strtotime($tx->created_at)); ?> · Rp <?php echo number_format($tx->amount, 0, ',', '.'); ?>
                                    </div>
                                </div>
                                <span class="px-2 py-1 rounded-pill fw-semibold" style="font-size: 0.6rem; 
                                    background: <?php echo $tx->status === 'approved' ? '#f0fdfa' : ($tx->status === 'pending' ? '#f0fdfa' : '#fef2f2'); ?>;
                                    color: <?php echo $tx->status === 'approved' ? '#10b981' : ($tx->status === 'pending' ? '#059669' : '#059669'); ?>;">
                                    <?php echo $tx->status === 'approved' ? t('Berhasil', 'Success') : ($tx->status === 'pending' ? t('Pending', 'Pending') : t('Ditolak', 'Failed')); ?>
                                </span>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>
