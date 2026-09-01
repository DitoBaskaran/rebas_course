<?php $_lp_logged = $this->session->userdata('logged_in'); ?>

<?php if ($_lp_logged): ?>
<!-- ============ PANEL STUDENT (mobile app-style + desktop) ============ -->
<div class="container-fluid py-4" style="padding-top: 0px !important; max-width: 1100px;">

    <!-- Mobile App-Style -->
    <div class="dashboard-mobile-only">
        <div class="d-flex align-items-center justify-content-between mb-3">
            <div>
                <h5 class="fw-extrabold mb-0" style="color: #0D1830; font-size: 1.15rem; letter-spacing: -0.02em;">
                    <?php echo t('Learning Paths', 'Learning Paths'); ?>
                </h5>
                <small style="color: #78716c; font-size: 0.72rem;"><?php echo t('Jalur belajar terstruktur', 'Structured learning paths'); ?></small>
            </div>
            <a href="<?php echo base_url('learning_paths/mine'); ?>" class="btn px-3 py-2 fw-semibold rounded-pill" style="background:#E0F2F1; color:#009688; font-size:0.72rem;">
                <i class="fas fa-route me-1" style="font-size:0.65rem;"></i> <?php echo t('Saya', 'Mine'); ?>
            </a>
        </div>

        <?php if (empty($paths)): ?>
            <div class="mob-empty">
                <i class="fas fa-road"></i>
                <p><?php echo t('Belum ada learning path.', 'No learning paths yet.'); ?></p>
            </div>
        <?php else: ?>
            <div class="d-flex flex-column gap-3">
                <?php foreach ($paths as $i => $path): ?>
                    <a href="<?php echo base_url('learning_paths/detail/' . $path->slug); ?>" class="lp-mob-card text-decoration-none w-100">
                        <div class="d-flex align-items-center gap-3 mb-2">
                            <span class="flex-shrink-0 d-flex align-items-center justify-content-center text-white rounded-2" style="width: 46px; height: 46px; background: <?php echo $path->color ?? '#009688'; ?>;">
                                <i class="fas fa-<?php echo $path->icon ?: 'road'; ?>" style="font-size: 0.95rem;"></i>
                            </span>
                            <div class="min-w-0 flex-fill">
                                <div class="fw-bold text-truncate" style="color: #0D1830; font-size: 0.88rem;"><?php echo htmlspecialchars($path->title); ?></div>
                                <div style="color: #78716c; font-size: 0.72rem;"><?php echo $path->content_count; ?> <?php echo t('konten', 'contents'); ?></div>
                            </div>
                            <span class="mob-chev"><i class="fas fa-chevron-right"></i></span>
                        </div>
                        <?php if ($path->description): ?>
                        <p class="mb-2" style="color: #78716c; font-size: 0.72rem; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; line-height: 1.4;">
                            <?php echo htmlspecialchars($path->description); ?>
                        </p>
                        <?php endif; ?>
                        <div class="d-flex gap-2 flex-wrap pt-2" style="border-top: 1px solid #f0eeeb;">
                            <span class="px-2 py-1 rounded-pill fw-semibold" style="background:#E0F2F1; color:#009688; font-size:0.62rem;"><?php echo skill_level_label($path->skill_level); ?></span>
                            <?php if ($path->estimated_hours > 0): ?>
                            <span class="px-2 py-1 rounded-pill fw-semibold" style="background:#E6EBEF; color:#57534E; font-size:0.62rem;"><i class="far fa-clock me-1"></i><?php echo $path->estimated_hours; ?> <?php echo t('jam', 'hours'); ?></span>
                            <?php endif; ?>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>

    <!-- Desktop Panel -->
    <div class="dashboard-desktop-only">
        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
            <div>
                <h4 class="fw-extrabold mb-1" style="color: #0D1830; letter-spacing: -0.02em;">
                    <?php echo t('Learning Paths', 'Learning Paths'); ?>
                </h4>
                <p style="color: #78716c; font-size: 0.85rem; margin-bottom: 0;">
                    <?php echo t('Ikuti jalur belajar terstruktur dari dasar hingga mahir.', 'Follow structured paths from beginner to advanced.'); ?>
                </p>
            </div>
            <a href="<?php echo base_url('learning_paths/mine'); ?>" class="btn px-3 py-2 fw-semibold rounded-pill" style="background:#E0F2F1; color:#009688; font-size:0.8rem;">
                <i class="fas fa-route me-1"></i> <?php echo t('Learning Path Saya', 'My Learning Paths'); ?>
            </a>
        </div>

        <?php if (empty($paths)): ?>
            <div class="text-center py-5">
                <div style="font-size: 2.5rem; color: #d4d4d4; margin-bottom: 0.75rem;"><i class="fas fa-road"></i></div>
                <h5 class="fw-bold" style="color: #0D1830;"><?php echo t('Belum Ada Learning Path', 'No Learning Paths Yet'); ?></h5>
            </div>
        <?php else: ?>
            <div class="row g-3">
                <?php foreach ($paths as $i => $path): ?>
                    <div class="col-md-6 col-lg-4">
                        <a href="<?php echo base_url('learning_paths/detail/' . $path->slug); ?>" class="text-decoration-none">
                            <div class="border rounded-3 h-100 p-3 mentor-card-hover" style="border-color: #e7e5e4; border-radius: 16px; background: #fff; transition: all 0.15s; box-shadow: 0 1px 3px rgba(0,0,0,0.03);">
                                <div class="d-flex align-items-center gap-3 mb-3">
                                    <span class="d-flex align-items-center justify-content-center text-white rounded-2 flex-shrink-0" style="width: 48px; height: 48px; background: <?php echo $path->color ?? '#009688'; ?>;">
                                        <i class="fas fa-<?php echo $path->icon ?: 'road'; ?>"></i>
                                    </span>
                                    <div class="min-w-0 flex-fill">
                                        <h6 class="fw-bold mb-0 text-truncate" style="color: #0D1830; font-size: 0.92rem;"><?php echo htmlspecialchars($path->title); ?></h6>
                                        <small class="fw-medium" style="color: #78716c; font-size: 0.75rem;"><?php echo $path->content_count; ?> <?php echo t('konten', 'contents'); ?></small>
                                    </div>
                                </div>
                                <?php if ($path->description): ?>
                                <p class="mb-3" style="color: #78716c; font-size: 0.78rem; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; line-height: 1.5;">
                                    <?php echo htmlspecialchars($path->description); ?>
                                </p>
                                <?php endif; ?>
                                <div class="d-flex gap-2 flex-wrap mb-3">
                                    <span class="px-2 py-1 rounded-pill fw-semibold" style="background:#E0F2F1; color:#009688; font-size:0.65rem;"><?php echo skill_level_label($path->skill_level); ?></span>
                                    <?php if ($path->category_name): ?>
                                    <span class="px-2 py-1 rounded-pill fw-semibold" style="background:#E6EBEF; color:#57534E; font-size:0.65rem;"><?php echo htmlspecialchars($path->category_name); ?></span>
                                    <?php endif; ?>
                                    <?php if ($path->estimated_hours > 0): ?>
                                    <span class="px-2 py-1 rounded-pill fw-semibold" style="background:#E6EBEF; color:#57534E; font-size:0.65rem;"><i class="far fa-clock me-1"></i><?php echo $path->estimated_hours; ?> <?php echo t('jam', 'hours'); ?></span>
                                    <?php endif; ?>
                                </div>
                                <span class="btn btn-sm fw-bold rounded-pill px-3 w-100" style="background: #009688; color: #fff; font-size: 0.75rem;"><?php echo t('Lihat Detail', 'View Details'); ?> <i class="fas fa-arrow-right ms-1" style="font-size: 0.6rem;"></i></span>
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
<section style="background: linear-gradient(160deg,#0D1830 0%,#0D1830 40%,#00796B 100%); color:#fff; position:relative; overflow:hidden;">
    <div style="position:absolute; top:-70px; right:-50px; width:260px; height:260px; border-radius:50%; background:rgba(251,191,36,0.12);"></div>
    <div style="position:absolute; bottom:-90px; left:-40px; width:300px; height:300px; border-radius:50%; background:rgba(0,150,136,0.3);"></div>
    <div class="container position-relative" style="padding-top: 3.2rem; padding-bottom: 3rem; max-width: 1000px; text-align:center;">
        <span class="px-3 py-1 rounded-pill fw-semibold d-inline-block mb-3" style="background: rgba(251,191,36,0.18); color: #FBBF24; border: 1px solid rgba(251,191,36,0.35); font-size: 0.72rem; letter-spacing: 0.05em;">
            <i class="fas fa-route me-1"></i> SKILL TREE
        </span>
        <h1 class="fw-extrabold mb-3" style="font-size: 2rem; letter-spacing: -0.03em; text-shadow: 0 2px 20px rgba(0,0,0,0.2);">
            <?php echo t('Learning Paths', 'Learning Paths'); ?> <span style="color: #FBBF24;">(Skill Tree)</span>
        </h1>
        <p class="mx-auto mb-0" style="color: rgba(230,235,239,0.85); font-size: 0.95rem; max-width: 540px;">
            <?php echo t('Ikuti jalur belajar terstruktur untuk menguasai skill dari dasar hingga mahir.', 'Follow structured learning paths to master skills from beginner to advanced.'); ?>
        </p>
    </div>
</section>

<!-- List -->
<div class="container" style="max-width: 1000px; padding-top: 1.5rem; padding-bottom: 3rem;">
    <?php if (empty($paths)): ?>
        <div class="text-center py-5">
            <div style="font-size: 2.5rem; color: #d4d4d4; margin-bottom: 0.75rem;"><i class="fas fa-road"></i></div>
            <h5 class="fw-bold" style="color: #0D1830;"><?php echo t('Belum Ada Learning Path', 'No Learning Paths Yet'); ?></h5>
        </div>
    <?php else: ?>
        <div class="row g-3">
            <?php foreach ($paths as $i => $path): ?>
                <div class="col-md-6 col-lg-4">
                    <a href="<?php echo base_url('learning_paths/detail/' . $path->slug); ?>" class="text-decoration-none">
                        <div class="card h-100 mentor-card-hover" style="border: 1px solid #E6EBEF; border-radius: 14px; transition: all 0.18s; box-shadow: 0 1px 3px rgba(13,24,48,0.04);">
                            <div class="card-body p-3 d-flex flex-column">
                                <div class="d-flex align-items-center gap-3 mb-3">
                                    <span class="d-flex align-items-center justify-content-center text-white rounded-2 flex-shrink-0" style="width: 48px; height: 48px; background: <?php echo $path->color ?? '#009688'; ?>;">
                                        <i class="fas fa-<?php echo $path->icon ?: 'road'; ?>"></i>
                                    </span>
                                    <div class="min-w-0 flex-fill">
                                        <h6 class="fw-bold mb-0 text-truncate" style="color: #0D1830; font-size: 0.92rem;"><?php echo htmlspecialchars($path->title); ?></h6>
                                        <small class="fw-medium" style="color: #737373; font-size: 0.75rem;"><?php echo $path->content_count; ?> <?php echo t('konten', 'contents'); ?></small>
                                    </div>
                                </div>
                                <?php if ($path->description): ?>
                                <p class="mb-3" style="color: #737373; font-size: 0.78rem; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; line-height: 1.5;">
                                    <?php echo htmlspecialchars($path->description); ?>
                                </p>
                                <?php endif; ?>
                                <div class="d-flex gap-2 flex-wrap mb-3">
                                    <span class="px-2 py-1 rounded-pill fw-semibold" style="background:#E0F2F1; color:#009688; font-size:0.65rem;"><?php echo skill_level_label($path->skill_level); ?></span>
                                    <?php if ($path->category_name): ?>
                                    <span class="px-2 py-1 rounded-pill fw-semibold" style="background:#E6EBEF; color:#57534E; font-size:0.65rem;"><?php echo htmlspecialchars($path->category_name); ?></span>
                                    <?php endif; ?>
                                    <?php if ($path->estimated_hours > 0): ?>
                                    <span class="px-2 py-1 rounded-pill fw-semibold" style="background:#E6EBEF; color:#57534E; font-size:0.65rem;"><i class="far fa-clock me-1"></i><?php echo $path->estimated_hours; ?> <?php echo t('jam', 'hours'); ?></span>
                                    <?php endif; ?>
                                </div>
                                <span class="btn btn-sm fw-bold rounded-pill px-3 w-100 mt-auto" style="background: #009688; color: #fff; font-size: 0.75rem;"><?php echo t('Lihat Detail', 'View Details'); ?> <i class="fas fa-arrow-right ms-1" style="font-size: 0.6rem;"></i></span>
                            </div>
                        </div>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>
<?php endif; ?>
