<div>
    <div class="row g-4">
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 p-4 p-xl-5 text-center">
                <div class="position-relative d-inline-block mb-4">
                    <img src="<?php echo base_url('uploads/avatars/' . ($user->avatar ?: 'default_avatar.png')); ?>" onerror="this.src='https://ui-avatars.com/api/?name=<?php echo urlencode($user->name); ?>&background=4361ee&color=fff&size=120';" alt="" class="rounded-circle mx-auto object-fit-cover shadow-sm border border-3 border-white" style="width: 120px; height: 120px;">
                    <span class="position-absolute bottom-0 end-0 bg-success border border-2 border-white rounded-circle p-2"></span>
                </div>
                <h5 class="fw-bold text-dark mb-1"><?php echo htmlspecialchars($user->name); ?></h5>
                <?php
                    $role_labels = array();
                    if ($user->role === 'admin') $role_labels[] = '<span class="badge bg-danger-subtle text-danger rounded-pill px-3 py-2 fw-medium">Admin</span>';
                    if ($user->is_teacher) $role_labels[] = '<span class="badge bg-warning-subtle text-warning rounded-pill px-3 py-2 fw-medium">Teacher</span>';
                    if ($user->is_mentor) $role_labels[] = '<span class="badge bg-purple-subtle text-purple rounded-pill px-3 py-2 fw-medium">Mentor</span>';
                    if (empty($role_labels)) $role_labels[] = '<span class="badge bg-primary-subtle text-primary rounded-pill px-3 py-2 fw-medium">Student</span>';
                    echo implode(' ', $role_labels);
                ?>
                <?php if ($user->bio): ?>
                    <p class="text-secondary small mb-4"><?php echo htmlspecialchars($user->bio); ?></p>
                <?php endif; ?>
                <?php if ($this->session->userdata('user_id') == $user->id): ?>
                    <div class="d-flex gap-2 justify-content-center mt-3 pt-3 border-top border-light">
                        <a href="<?php echo base_url('profile/edit'); ?>" class="btn btn-dark btn-sm rounded-pill px-3 fw-semibold"><?php echo t('Edit Profil', 'Edit Profile'); ?></a>
                        <a href="<?php echo base_url('profile/change_password'); ?>" class="btn btn-outline-dark btn-sm rounded-pill px-3 fw-semibold"><?php echo t('Ganti Password', 'Change Password'); ?></a>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <div class="col-lg-8 animate-fade-in-up stagger-1">
            <?php if ($user->is_teacher && !empty($courses)): ?>
                <div class="card border-0 shadow-sm rounded-4 p-4 p-xl-5 mb-4">
                    <h5 class="fw-bold text-dark mb-4 d-flex align-items-center gap-2">
                        <span class="icon-32 bg-primary-subtle text-primary rounded-2 d-inline-flex align-items-center justify-content-center"><i class="fas fa-chalkboard-teacher"></i></span>
                        <span><?php echo t('Konten yang Dibuat', 'Created Content'); ?></span>
                    </h5>
                    <div class="d-flex flex-column gap-2">
                        <?php foreach ($courses as $c): ?>
                            <a href="<?php echo base_url('courses/detail/' . $c->slug); ?>" class="text-decoration-none d-flex justify-content-between align-items-center p-3 rounded-3 bg-light" style="transition: all 0.2s;">
                                <span class="fw-semibold text-dark small"><?php echo htmlspecialchars($c->title); ?></span>
                                <span class="badge bg-light text-secondary rounded-pill px-3 py-2 fw-medium border"><?php echo content_type_label($c->content_type); ?></span>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>

            <div class="card border-0 shadow-sm rounded-4 p-4 p-xl-5 mb-4">
                <h5 class="fw-bold text-dark mb-4 d-flex align-items-center gap-2">
                    <span class="icon-32 bg-primary-subtle text-primary rounded-2 d-inline-flex align-items-center justify-content-center"><i class="fas fa-graduation-cap"></i></span>
                    <span><?php echo t('Kelas Terdaftar', 'Enrolled Courses'); ?></span>
                </h5>
                <?php if (empty($enrolled_courses)): ?>
                    <div class="text-center py-3">
                        <p class="text-secondary small mb-0"><?php echo t('Belum terdaftar di kelas apapun.', 'Not enrolled in any courses.'); ?></p>
                    </div>
                <?php else: ?>
                    <div class="d-flex flex-column gap-2">
                        <?php foreach ($enrolled_courses as $ec): ?>
                            <a href="<?php echo base_url('courses/learn/' . $ec->slug); ?>" class="text-decoration-none d-flex justify-content-between align-items-center p-3 rounded-3 bg-light" style="transition: all 0.2s;">
                                <span class="fw-semibold text-dark small"><?php echo htmlspecialchars($ec->title); ?></span>
                                <span class="badge bg-dark text-white rounded-pill px-3 py-2 fw-medium"><?php echo t('Belajar', 'Learn'); ?></span>
                            </a>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>

            <?php if ($this->session->userdata('user_id') == $user->id): ?>
                <div class="card border-0 shadow-sm rounded-4 p-4 p-xl-5">
                    <h5 class="fw-bold text-dark mb-4 d-flex align-items-center gap-2">
                        <span class="icon-32 bg-warning-subtle text-warning rounded-2 d-inline-flex align-items-center justify-content-center"><i class="fas fa-clock"></i></span>
                        <span><?php echo t('Aktivitas Terkini', 'Recent Activity'); ?></span>
                    </h5>
                    <?php if (empty($recent_activity)): ?>
                        <p class="text-secondary small mb-0"><?php echo t('Belum ada aktivitas.', 'No recent activity.'); ?></p>
                    <?php else: ?>
                        <div class="d-flex flex-column gap-2">
                            <?php foreach ($recent_activity as $act): ?>
                                <div class="d-flex align-items-center gap-3 p-3 rounded-3 bg-light">
                                    <div class="text-primary flex-shrink-0"><i class="fas fa-circle" style="font-size: 0.4rem;"></i></div>
                                    <span class="text-dark small"><?php echo htmlspecialchars($act->course_title . ' — ' . $act->lesson_title); ?></span>
                                    <span class="text-secondary small ms-auto flex-shrink-0"><?php echo time_elapsed($act->updated_at); ?></span>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
