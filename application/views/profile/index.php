<div class="container-fluid px-0">

    <?php
        $role_labels = array();
        if ($user->role === 'admin') $role_labels[] = '<span style="background:#fef2f2;color:#f43f5e;">Admin</span>';
        if ($user->is_teacher) $role_labels[] = '<span style="background:#fff7ed;color:#0D1830;">Teacher</span>';
        if ($user->is_mentor) $role_labels[] = '<span style="background:#faf5ff;color:#a855f7;">Mentor</span>';
        if (empty($role_labels)) $role_labels[] = '<span style="background:#E0F2F1;color:#009688;">Student</span>';
    ?>
    <div class="row g-4">
        <!-- ============ LEFT: IDENTITY CARD ============ -->
        <div class="col-lg-4">
            <div class="bento-card text-center p-4" style="position:sticky;top:1rem;">
                <div class="position-relative d-inline-block mb-3">
                    <img src="<?php echo base_url('uploads/avatars/' . ($user->avatar ?: 'default_avatar.png')); ?>" onerror="this.src='https://ui-avatars.com/api/?name=<?php echo urlencode($user->name); ?>&background=4361ee&color=fff&size=120';" alt="" class="rounded-circle object-fit-cover mx-auto" style="width:110px;height:110px;object-fit:cover;border:4px solid #fff;box-shadow:var(--shadow-md);">
                    <span class="position-absolute bottom-0 end-0 border border-2 border-white rounded-circle" style="width:16px;height:16px;background:#22c55e;"></span>
                </div>
                <h5 class="fw-extrabold text-dark mb-1"><?php echo htmlspecialchars($user->name); ?></h5>
                <div class="d-flex justify-content-center gap-1 mb-3">
                    <?php foreach ($role_labels as $rl): ?>
                        <span class="px-2 py-1 rounded-pill fw-bold" style="font-size:0.66rem;"><?php echo $rl; ?></span>
                    <?php endforeach; ?>
                </div>
                <?php if (!empty($user->bio)): ?>
                    <p class="text-secondary small mb-4" style="font-size:0.78rem;line-height:1.6;"><?php echo htmlspecialchars($user->bio); ?></p>
                <?php endif; ?>

                <div class="text-start d-flex flex-column gap-2 px-1 pb-2">
                    <div class="d-flex justify-content-between align-items-center py-1" style="border-bottom:1px dashed var(--gray-100,#f0eeeb);">
                        <span class="text-secondary" style="font-size:0.74rem;"><i data-lucide="mail" style="width:12px;height:12px;" class="me-1"></i>Email</span>
                        <span class="fw-semibold text-dark text-truncate" style="font-size:0.76rem;max-width:12rem;"><?php echo htmlspecialchars($user->email); ?></span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center py-1" style="border-bottom:1px dashed var(--gray-100,#f0eeeb);">
                        <span class="text-secondary" style="font-size:0.74rem;"><i data-lucide="phone" style="width:12px;height:12px;" class="me-1"></i><?php echo t('HP', 'Phone'); ?></span>
                        <span class="fw-semibold text-dark" style="font-size:0.76rem;"><?php echo !empty($user->phone) ? htmlspecialchars($user->phone) : '-'; ?></span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center py-1">
                        <span class="text-secondary" style="font-size:0.74rem;"><i data-lucide="calendar" style="width:12px;height:12px;" class="me-1"></i><?php echo t('Bergabung', 'Joined'); ?></span>
                        <span class="fw-semibold text-dark" style="font-size:0.76rem;"><?php echo date('d M Y', strtotime($user->created_at)); ?></span>
                    </div>
                </div>

                <?php if ($this->session->userdata('user_id') == $user->id): ?>
                <div class="d-flex flex-column gap-2 mt-2">
                    <a href="<?php echo base_url('profile/edit'); ?>" class="btn fw-semibold rounded-pill d-inline-flex align-items-center justify-content-center gap-2 border-0 w-100" style="background:#0D1830;color:#fff;font-size:0.8rem;padding:0.6rem;">
                        <i data-lucide="pencil" style="width:15px;height:15px;"></i> <?php echo t('Edit Profil', 'Edit Profile'); ?>
                    </a>
                    <a href="<?php echo base_url('profile/change_password'); ?>" class="btn fw-semibold rounded-pill d-inline-flex align-items-center justify-content-center gap-2 border-0 w-100" style="background:#E6EBEF;color:#57534e;font-size:0.8rem;padding:0.6rem;">
                        <i data-lucide="key-round" style="width:15px;height:15px;"></i> <?php echo t('Ganti Password', 'Change Password'); ?>
                    </a>
                </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- ============ RIGHT: CONTENT ============ -->
        <div class="col-lg-8">

            <!-- Mini stats -->
            <div class="bento-grid bento-grid-3 mb-4">
                <div class="bento-card blob-primary d-flex align-items-center gap-3">
                    <div class="bento-icon bg-primary-subtle text-primary"><i data-lucide="book-open" style="width:20px;height:20px;"></i></div>
                    <div>
                        <div class="bento-label"><?php echo t('Kelas', 'Courses'); ?></div>
                        <div class="bento-value" style="font-size:1.3rem;"><?php echo count($enrolled_courses); ?></div>
                    </div>
                </div>
                <div class="bento-card blob-warning d-flex align-items-center gap-3">
                    <div class="bento-icon bg-warning-subtle text-warning"><i data-lucide="award" style="width:20px;height:20px;"></i></div>
                    <div>
                        <div class="bento-label"><?php echo t('Sertifikat', 'Certificates'); ?></div>
                        <div class="bento-value" style="font-size:1.3rem;"><?php echo count($certificates); ?></div>
                    </div>
                </div>
                <div class="bento-card blob-success d-flex align-items-center gap-3">
                    <div class="bento-icon bg-success-subtle text-success"><i data-lucide="activity" style="width:20px;height:20px;"></i></div>
                    <div>
                        <div class="bento-label"><?php echo t('Aktivitas', 'Activities'); ?></div>
                        <div class="bento-value" style="font-size:1.3rem;"><?php echo count($recent_activity); ?></div>
                    </div>
                </div>
            </div>

            <!-- Created content (teacher) -->
            <?php if ($user->is_teacher && !empty($courses)): ?>
            <div class="bento-card mb-4">
                <h5 class="fw-bold text-dark mb-3 d-flex align-items-center gap-2" style="font-size:0.95rem;">
                    <span class="d-inline-flex align-items-center justify-content-center rounded-2" style="width:30px;height:30px;background:rgba(13,24,48,0.07);"><i data-lucide="presentation" style="width:15px;height:15px;color:#0D1830;"></i></span>
                    <?php echo t('Konten yang Dibuat', 'Created Content'); ?>
                </h5>
                <div class="d-flex flex-column gap-2">
                    <?php foreach ($courses as $c): ?>
                        <a href="<?php echo base_url('courses/detail/' . $c->slug); ?>" class="profile-link-row">
                            <i class="fas fa-file-alt" style="font-size:0.7rem;color:#94a3b8;"></i>
                            <span class="fw-semibold text-dark text-truncate" style="font-size:0.82rem;"><?php echo htmlspecialchars($c->title); ?></span>
                            <span class="px-2 py-1 rounded-pill fw-semibold flex-shrink-0" style="background:#E6EBEF;color:#57534e;font-size:0.62rem;"><?php echo content_type_label($c->content_type); ?></span>
                            <i data-lucide="chevron-right" style="width:13px;height:13px;color:#c2c8d0;flex-shrink:0;"></i>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endif; ?>

            <!-- Enrolled courses -->
            <div class="bento-card mb-4">
                <h5 class="fw-bold text-dark mb-3 d-flex align-items-center gap-2" style="font-size:0.95rem;">
                    <span class="d-inline-flex align-items-center justify-content-center rounded-2" style="width:30px;height:30px;background:rgba(0,150,136,0.1);"><i data-lucide="book-open" style="width:15px;height:15px;color:#009688;"></i></span>
                    <?php echo t('Kelas Terdaftar', 'Enrolled Courses'); ?>
                </h5>
                <?php if (empty($enrolled_courses)): ?>
                    <p class="text-secondary small mb-0"><?php echo t('Belum terdaftar di kelas apapun.', 'Not enrolled in any courses.'); ?></p>
                <?php else: ?>
                    <div class="d-flex flex-column gap-2">
                        <?php foreach ($enrolled_courses as $ec): ?>
                            <a href="<?php echo base_url('courses/learn/' . $ec->slug); ?>" class="profile-link-row">
                                <i class="fas fa-play-circle" style="font-size:0.75rem;color:#009688;"></i>
                                <span class="fw-semibold text-dark text-truncate" style="font-size:0.82rem;"><?php echo htmlspecialchars($ec->title); ?></span>
                                <span class="px-2 py-1 rounded-pill fw-semibold flex-shrink-0" style="background:#0D1830;color:#fff;font-size:0.62rem;"><?php echo t('Belajar', 'Learn'); ?></span>
                                <i data-lucide="chevron-right" style="width:13px;height:13px;color:#c2c8d0;flex-shrink:0;"></i>
                            </a>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Recent activity -->
            <?php if ($this->session->userdata('user_id') == $user->id): ?>
            <div class="bento-card">
                <h5 class="fw-bold text-dark mb-3 d-flex align-items-center gap-2" style="font-size:0.95rem;">
                    <span class="d-inline-flex align-items-center justify-content-center rounded-2" style="width:30px;height:30px;background:rgba(245,158,11,0.12);"><i data-lucide="history" style="width:15px;height:15px;color:#d97706;"></i></span>
                    <?php echo t('Aktivitas Terkini', 'Recent Activity'); ?>
                </h5>
                <?php if (empty($recent_activity)): ?>
                    <p class="text-secondary small mb-0"><?php echo t('Belum ada aktivitas.', 'No recent activity.'); ?></p>
                <?php else: ?>
                    <div class="d-flex flex-column">
                        <?php foreach ($recent_activity as $act): ?>
                            <div class="d-flex align-items-center gap-3 py-2" style="border-bottom:1px dashed var(--gray-100,#f0eeeb);">
                                <span class="d-inline-flex align-items-center justify-content-center rounded-circle flex-shrink-0" style="width:26px;height:26px;background:rgba(0,150,136,0.1);">
                                    <i data-lucide="check" style="width:12px;height:12px;color:#009688;"></i>
                                </span>
                                <div style="flex:1;min-width:0;">
                                    <div class="fw-semibold text-dark text-truncate" style="font-size:0.78rem;"><?php echo htmlspecialchars($act->lesson_title); ?></div>
                                    <div class="text-secondary text-truncate" style="font-size:0.7rem;"><?php echo htmlspecialchars($act->course_title); ?></div>
                                </div>
                                <span class="text-secondary flex-shrink-0" style="font-size:0.68rem;"><?php echo time_elapsed($act->updated_at); ?></span>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>
