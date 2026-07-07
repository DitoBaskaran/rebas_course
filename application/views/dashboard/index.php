<div class="container py-5 my-4">
    <!-- Header -->
    <div class="row mb-5 animate-fade-in-up">
        <div class="col-lg-8">
            <span class="text-primary fw-semibold small text-uppercase tracking-wide d-block mb-2">Akun Saya</span>
            <h1 class="display-5 fw-extrabold text-dark mb-2 lh-sm" style="letter-spacing: -0.03em;"><?php echo t('Dashboard', 'Dashboard'); ?></h1>
            <p class="text-secondary lead mb-0" style="font-size: 1.1rem;"><?php echo t('Pantau progress belajarmu.', 'Track your learning progress.'); ?></p>
        </div>
    </div>

    <div class="row g-4">
        <!-- Learning Paths -->
        <?php if (!empty($learning_paths)): ?>
        <div class="col-12 animate-fade-in-up">
            <div class="card border-0 shadow-sm rounded-4 p-4 p-xl-5">
                <h5 class="fw-bold text-dark mb-4 d-flex align-items-center gap-2">
                    <span class="icon-32 bg-info-subtle text-info rounded-2 d-inline-flex align-items-center justify-content-center"><i class="fas fa-road"></i></span>
                    <span><?php echo t('Learning Paths Saya', 'My Learning Paths'); ?></span>
                </h5>
                <div class="d-flex flex-column gap-3">
                    <?php foreach ($learning_paths as $lp): ?>
                        <div class="d-flex justify-content-between align-items-center p-3 rounded-3 bg-light">
                            <div class="flex-grow-1 me-4">
                                <span class="fw-bold text-dark small"><?php echo htmlspecialchars($lp->title); ?></span>
                            </div>
                            <div class="d-flex align-items-center gap-3 flex-shrink-0" style="min-width: 200px;">
                                <div class="progress-modern flex-grow-1" style="height: 8px;"><div class="progress-bar" style="width: <?php echo $lp->progress_pct; ?>%;"></div></div>
                                <span class="small fw-bold text-primary text-end flex-shrink-0"><?php echo $lp->progress_pct; ?>%</span>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <!-- Enrolled Courses -->
        <div class="col-12 animate-fade-in-up stagger-1">
            <div class="card border-0 shadow-sm rounded-4 p-4 p-xl-5">
                <h5 class="fw-bold text-dark mb-4 d-flex align-items-center gap-2">
                    <span class="icon-32 bg-primary-subtle text-primary rounded-2 d-inline-flex align-items-center justify-content-center"><i class="fas fa-book-open"></i></span>
                    <span><?php echo t('Kelas Saya', 'My Courses'); ?></span>
                </h5>
                <?php if (empty($enrolled_courses)): ?>
                    <div class="text-center py-4">
                        <div class="icon-48 bg-light rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center">
                            <i class="fas fa-book-open text-secondary"></i>
                        </div>
                        <h6 class="fw-bold text-dark"><?php echo t('Belum Ada Kelas', 'No Courses Yet'); ?></h6>
                        <p class="text-secondary small mb-3"><?php echo t('Belum terdaftar di kelas apapun.', 'Not enrolled in any courses.'); ?></p>
                        <a href="<?php echo base_url('courses'); ?>" class="btn btn-dark rounded-pill px-4 py-2 fw-semibold"><?php echo t('Jelajahi Konten', 'Explore Content'); ?></a>
                    </div>
                <?php else: ?>
                    <div class="row g-3">
                        <?php foreach ($enrolled_courses as $course): ?>
                            <div class="col-md-6">
                                <div class="d-flex align-items-center gap-3 p-3 rounded-3 bg-light h-100">
                                    <img src="<?php echo base_url('uploads/courses/' . $course->thumbnail); ?>" onerror="this.src='https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=100&auto=format&fit=crop&q=60';" alt="" class="rounded-2 object-fit-cover flex-shrink-0" style="width: 72px; height: 48px;">
                                    <div class="flex-fill min-w-0">
                                        <h6 class="fw-bold text-dark mb-2 small"><?php echo htmlspecialchars(t($course->title, $course->title_en ?: $course->title)); ?></h6>
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="progress-modern flex-fill" style="height: 6px;"><div class="progress-bar" style="width: <?php echo $course->progress_pct ?? 0; ?>%;"></div></div>
                                            <span class="small fw-bold text-primary flex-shrink-0"><?php echo $course->progress_pct ?? 0; ?>%</span>
                                        </div>
                                    </div>
                                    <a href="<?php echo base_url('courses/learn/' . $course->id); ?>" class="btn btn-dark btn-sm rounded-pill px-3 flex-shrink-0 fw-semibold"><?php echo t('Belajar', 'Learn'); ?></a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Registered Seminars -->
        <?php if (!empty($registered_seminars)): ?>
        <div class="col-12 animate-fade-in-up stagger-2">
            <div class="card border-0 shadow-sm rounded-4 p-4 p-xl-5">
                <h5 class="fw-bold text-dark mb-4 d-flex align-items-center gap-2">
                    <span class="icon-32 bg-danger-subtle text-danger rounded-2 d-inline-flex align-items-center justify-content-center"><i class="fas fa-calendar-alt"></i></span>
                    <span><?php echo t('Seminar Terdaftar', 'Registered Seminars'); ?></span>
                </h5>
                <div class="d-flex flex-column gap-3">
                    <?php foreach ($registered_seminars as $sem): ?>
                        <div class="d-flex justify-content-between align-items-center p-3 rounded-3 bg-light">
                            <div class="flex-grow-1 me-3">
                                <h6 class="fw-bold text-dark mb-1 small"><?php echo htmlspecialchars(t($sem->title, $sem->title_en ?: $sem->title)); ?></h6>
                                <small class="text-secondary"><i class="far fa-clock me-1"></i> <?php echo date('d M Y - H:i', strtotime($sem->date_time)); ?> WIB</small>
                            </div>
                            <?php if (!empty($sem->location_link)): ?>
                                <a href="<?php echo $sem->location_link; ?>" target="_blank" class="btn btn-success btn-sm rounded-pill px-3 flex-shrink-0 fw-semibold"><i class="fas fa-video me-1"></i> Zoom</a>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <!-- Certificates -->
        <?php if (!empty($certificates)): ?>
        <div class="col-12 animate-fade-in-up stagger-3">
            <div class="card border-0 shadow-sm rounded-4 p-4 p-xl-5">
                <h5 class="fw-bold text-dark mb-4 d-flex align-items-center gap-2">
                    <span class="icon-32 bg-warning-subtle text-warning rounded-2 d-inline-flex align-items-center justify-content-center"><i class="fas fa-award"></i></span>
                    <span><?php echo t('Sertifikat', 'Certificates'); ?></span>
                </h5>
                <div class="d-flex flex-wrap gap-3">
                    <?php foreach ($certificates as $cert): ?>
                        <a href="<?php echo base_url('certificate/view/' . $cert->id); ?>" class="text-decoration-none p-3 rounded-3 bg-light d-inline-flex align-items-center gap-2 hover-zoom border" style="transition: all 0.2s;">
                            <i class="fas fa-file-alt text-warning"></i>
                            <span class="fw-bold text-dark small"><?php echo htmlspecialchars($cert->course_title); ?></span>
                            <span class="badge bg-success text-white rounded-pill px-2 small"><?php echo htmlspecialchars($cert->status ?? 'Completed'); ?></span>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>
