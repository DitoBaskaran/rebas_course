<div class="container-fluid px-0">

    <!-- ============ HEADER (hero) ============ -->
    <?php
        $total_pct = 0; $done_n = 0;
        foreach ($enrolled_courses as $course) {
            $total_pct += (int)($course->progress_pct ?? 0);
            if (($course->progress_pct ?? 0) >= 100) $done_n++;
        }
        $avg_pct = count($enrolled_courses) > 0 ? round($total_pct / count($enrolled_courses)) : 0;
    ?>
    <div class="bento-card mb-4 overflow-hidden" style="background:linear-gradient(120deg,#0D1830 0%,#009688 160%);border:none;color:#fff;">
        <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3 position-relative" style="z-index:1;">
            <div>
                <span class="d-inline-flex align-items-center gap-1" style="background:rgba(255,255,255,0.14);border:1px solid rgba(255,255,255,0.2);color:#FBBF24;font-size:0.66rem;font-weight:800;letter-spacing:0.12em;text-transform:uppercase;padding:0.3rem 0.7rem;border-radius:100px;">
                    <i data-lucide="book-open" style="width:12px;height:12px;"></i> <?php echo t('Belajarku', 'My Learning'); ?>
                </span>
                <h1 class="fw-extrabold text-white mb-1 mt-2 lh-sm" style="letter-spacing:-0.03em;font-size:1.6rem;">
                    <?php echo t('Kelas Saya', 'My Courses'); ?>
                </h1>
                <p class="mb-0" style="color:rgba(255,255,255,0.72);font-size:0.82rem;">
                    <?php echo t('Semua kelas yang sudah kamu daftar.', 'All courses you have enrolled in.'); ?>
                    <span class="fw-semibold text-white">(<?php echo count($enrolled_courses); ?>)</span>
                </p>
            </div>
            <a href="<?php echo base_url('courses'); ?>" class="btn fw-semibold rounded-pill d-inline-flex align-items-center gap-2 border-0 flex-shrink-0" style="background:#FBBF24;color:#0D1830;font-size:0.78rem;padding:0.55rem 1.1rem;box-shadow:0 4px 14px rgba(251,191,36,0.3);">
                <i data-lucide="plus" style="width:14px;height:14px;"></i> <?php echo t('Tambah Kelas', 'Add Course'); ?>
            </a>
        </div>
    </div>

    <!-- ============ STATS ============ -->
    <div class="bento-grid bento-grid-3 mb-4">
        <div class="bento-card blob-primary d-flex align-items-center gap-3">
            <div class="bento-icon bg-primary-subtle text-primary"><i data-lucide="book-open" style="width:22px;height:22px;"></i></div>
            <div>
                <div class="bento-label"><?php echo t('Kelas Diambil', 'Enrolled Courses'); ?></div>
                <div class="bento-value"><?php echo count($enrolled_courses); ?></div>
            </div>
        </div>
        <div class="bento-card blob-success d-flex align-items-center gap-3">
            <div class="bento-icon bg-success-subtle text-success"><i data-lucide="check-circle" style="width:22px;height:22px;"></i></div>
            <div>
                <div class="bento-label"><?php echo t('Selesai', 'Completed'); ?></div>
                <div class="bento-value"><?php echo $done_n; ?></div>
            </div>
        </div>
        <div class="bento-card blob-warning d-flex align-items-center gap-3">
            <div class="bento-icon bg-warning-subtle text-warning"><i data-lucide="trending-up" style="width:22px;height:22px;"></i></div>
            <div>
                <div class="bento-label"><?php echo t('Rata-rata Progress', 'Average Progress'); ?></div>
                <div class="bento-value"><?php echo $avg_pct; ?>%</div>
            </div>
        </div>
    </div>

    <?php if (empty($enrolled_courses)): ?>
        <div class="bento-card p-5 text-center">
            <div class="mx-auto d-inline-flex align-items-center justify-content-center rounded-circle mb-3" style="width:72px;height:72px;background:#E0F2F1;color:#009688;">
                <i data-lucide="book-open" style="width:30px;height:30px;"></i>
            </div>
            <h5 class="fw-extrabold text-dark mb-1"><?php echo t('Belum Ada Kelas', 'No Courses Yet'); ?></h5>
            <p class="text-secondary small mb-4" style="max-width:24rem;margin-left:auto;margin-right:auto;"><?php echo t('Kamu belum terdaftar di kelas apapun. Mulai eksplorasi dan temukan materi yang menarik.', 'You are not enrolled in any courses yet. Explore and find interesting content.'); ?></p>
            <a href="<?php echo base_url('courses'); ?>" class="btn btn-primary rounded-pill px-4 fw-semibold d-inline-flex align-items-center gap-2">
                <i data-lucide="search" style="width:15px;height:15px;"></i> <?php echo t('Jelajahi Konten', 'Explore Content'); ?>
            </a>
        </div>
    <?php else: ?>
        <!-- ============ COURSE GRID ============ -->
        <div class="bento-grid bento-grid-3" style="align-items:stretch;">
            <?php foreach ($enrolled_courses as $i => $course): ?>
                <?php
                    $grads = array(
                        'linear-gradient(135deg,#009688,#00796B)',
                        'linear-gradient(135deg,#2563eb,#38bdf8)',
                        'linear-gradient(135deg,#c026d3,#f472b6)',
                        'linear-gradient(135deg,#ea580c,#fbbf24)',
                        'linear-gradient(135deg,#0d9488,#2dd4bf)',
                        'linear-gradient(135deg,#7c3aed,#a78bfa)'
                    );
                    $gi = $i % 6;
                    $thumb_ok = !empty($course->thumbnail)
                        && file_exists(FCPATH . 'uploads/courses/' . $course->thumbnail)
                        && $course->thumbnail !== 'default_course.png';
                    $pct = (int)($course->progress_pct ?? 0);
                    $done = $pct >= 100;
                ?>
                <div class="bento-card p-0 my-course-card" style="display:flex;flex-direction:column;overflow:hidden;">
                    <a href="<?php echo base_url('courses/detail/' . $course->slug); ?>" class="position-relative d-block" style="aspect-ratio:16/9;background:<?php echo $grads[$gi]; ?>;overflow:hidden;">
                        <?php if ($thumb_ok): ?>
                            <img src="<?php echo base_url('uploads/courses/' . $course->thumbnail); ?>" alt="" class="w-100 h-100" style="object-fit:cover;">
                        <?php else: ?>
                            <div class="w-100 h-100 d-flex align-items-center justify-content-center fw-extrabold" style="color:rgba(255,255,255,0.9);font-size:2rem;">
                                <?php echo strtoupper(substr(trim($course->title), 0, 1)); ?>
                            </div>
                        <?php endif; ?>
                        <span class="position-absolute d-inline-flex align-items-center gap-1 px-2 py-1 rounded-pill fw-semibold" style="top:0.6rem;left:0.6rem;background:rgba(13,24,48,0.65);color:#fff;font-size:0.62rem;backdrop-filter:blur(4px);">
                            <?php echo content_type_label($course->content_type); ?>
                        </span>
                        <?php if ($done): ?>
                        <span class="position-absolute d-inline-flex align-items-center gap-1 px-2 py-1 rounded-pill fw-semibold" style="top:0.6rem;right:0.6rem;background:#E0F2F1;color:#009688;font-size:0.62rem;">
                            <i data-lucide="check-circle" style="width:11px;height:11px;"></i> <?php echo t('Selesai', 'Done'); ?>
                        </span>
                        <?php endif; ?>
                    </a>
                    <div class="p-3 d-flex flex-column" style="flex:1;">
                        <a href="<?php echo base_url('courses/detail/' . $course->slug); ?>" class="text-decoration-none">
                            <div class="fw-bold text-dark" style="font-size:0.88rem;line-height:1.35;min-height:2.4em;overflow:hidden;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;"><?php echo htmlspecialchars(t($course->title, $course->title_en ?: $course->title)); ?></div>
                        </a>
                        <div class="d-flex align-items-center gap-3 mt-2" style="color:#78716c;font-size:0.68rem;">
                            <?php if (!empty($course->teacher_name)): ?><span class="text-truncate"><i class="fas fa-chalkboard-teacher me-1" style="font-size:0.55rem;"></i><?php echo htmlspecialchars($course->teacher_name); ?></span><?php endif; ?>
                            <?php if (!empty($course->category_name)): ?><span class="text-truncate"><i class="fas fa-folder me-1" style="font-size:0.55rem;"></i><?php echo htmlspecialchars($course->category_name); ?></span><?php endif; ?>
                        </div>
                        <div class="d-flex align-items-center gap-2 mt-auto pt-3">
                            <div class="flex-fill rounded-pill overflow-hidden" style="height:6px;background:var(--gray-200,#e7e5e4);">
                                <div class="h-100 rounded-pill" style="width:<?php echo $pct; ?>%;background:<?php echo $done ? '#10b981' : 'linear-gradient(90deg,#009688,#34d399)'; ?>;"></div>
                            </div>
                            <span class="fw-extrabold text-dark" style="font-size:0.72rem;min-width:34px;text-align:right;"><?php echo $pct; ?>%</span>
                        </div>
                        <div class="d-flex gap-2 mt-2">
                            <a href="<?php echo base_url('courses/detail/' . $course->slug); ?>" class="btn btn-sm fw-semibold rounded-pill flex-fill" style="border:1px solid var(--gray-300,#d4d4d4);color:#57534e;font-size:0.7rem;"><?php echo t('Detail', 'Detail'); ?></a>
                            <a href="<?php echo base_url('courses/learn/' . $course->slug); ?>" class="btn btn-sm fw-bold rounded-pill flex-fill d-inline-flex align-items-center justify-content-center gap-1" style="background:#0D1830;color:#fff;font-size:0.7rem;border:none;">
                                <i class="fas fa-play" style="font-size:0.55rem;"></i> <?php echo $done ? t('Ulangi', 'Review') : t('Lanjut', 'Continue'); ?>
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>
