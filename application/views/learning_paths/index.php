<div class="container py-5 my-4">
    <div class="row mb-5 animate-fade-in-up text-center">
        <div class="col-lg-8 mx-auto">
            <span class="text-primary fw-semibold small text-uppercase tracking-wide d-block mb-2">Skill Tree</span>
            <h1 class="display-5 fw-extrabold text-dark mb-3 lh-sm" style="letter-spacing: -0.03em;"><?php echo t('Learning Paths (Skill Tree)', 'Learning Paths (Skill Tree)'); ?></h1>
            <p class="text-secondary lead mb-0" style="font-size: 1.1rem;"><?php echo t('Ikuti jalur belajar terstruktur untuk menguasai skill dari dasar hingga mahir.', 'Follow structured learning paths to master skills from beginner to advanced.'); ?></p>
        </div>
    </div>

    <div class="row g-4">
        <?php if (empty($paths)): ?>
            <div class="col-12">
                <div class="text-center py-5">
                    <div class="icon-64 bg-light rounded-circle mx-auto mb-4 d-flex align-items-center justify-content-center">
                        <i class="fas fa-road fs-3 text-secondary"></i>
                    </div>
                    <h5 class="fw-bold text-dark"><?php echo t('Belum Ada Learning Path', 'No Learning Paths Yet'); ?></h5>
                    <p class="text-secondary small mb-0"><?php echo t('Learning path baru akan segera hadir.', 'New learning paths will be available soon.'); ?></p>
                </div>
            </div>
        <?php else: ?>
            <?php foreach ($paths as $i => $path): ?>
                <div class="col-md-6 col-lg-4 animate-fade-in-up stagger-<?php echo min($i + 1, 5); ?>">
                    <div class="card h-100 border-0 shadow-sm rounded-4 bg-white overflow-hidden hover-zoom d-flex flex-column" style="transition: all 0.3s ease;">
                        <div class="card-body p-4 p-xl-5 d-flex flex-column">
                            <div class="d-flex align-items-center gap-3 mb-4">
                                <div class="d-flex align-items-center justify-content-center text-white rounded-3 shadow-sm flex-shrink-0" style="width: 52px; height: 52px; background: <?php echo $path->color ?? '#4361ee'; ?>;">
                                    <i class="fas fa-<?php echo $path->icon ?: 'road'; ?> fs-5"></i>
                                </div>
                                <div>
                                    <h5 class="fw-bold text-dark mb-0" style="font-size: 1.15rem;"><?php echo htmlspecialchars($path->title); ?></h5>
                                    <small class="text-secondary fw-medium"><?php echo $path->content_count; ?> <?php echo t('konten', 'contents'); ?></small>
                                </div>
                            </div>
                            <?php if ($path->description): ?>
                                <p class="text-secondary small mb-4 flex-grow-1" style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;"><?php echo htmlspecialchars($path->description); ?></p>
                            <?php endif; ?>
                            <div class="d-flex gap-2 flex-wrap mb-4">
                                <span class="badge bg-primary-subtle text-primary rounded-pill px-3 py-2 fw-medium"><?php echo skill_level_label($path->skill_level); ?></span>
                                <?php if ($path->category_name): ?>
                                    <span class="badge bg-light text-secondary border rounded-pill px-3 py-2 fw-medium"><?php echo htmlspecialchars($path->category_name); ?></span>
                                <?php endif; ?>
                                <?php if ($path->estimated_hours > 0): ?>
                                    <span class="badge bg-info-subtle text-info rounded-pill px-3 py-2 fw-medium"><i class="far fa-clock me-1"></i> <?php echo $path->estimated_hours; ?> <?php echo t('jam', 'hours'); ?></span>
                                <?php endif; ?>
                            </div>
                            <div class="mt-auto">
                                <a href="<?php echo base_url('learning_paths/detail/' . $path->slug); ?>" class="btn btn-dark w-100 rounded-pill py-2 fw-semibold"><?php echo t('Lihat Detail', 'View Details'); ?> <i class="fas fa-arrow-right ms-2"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>
