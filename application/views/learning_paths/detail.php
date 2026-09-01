<div class="container" style="max-width: 900px; padding-top: 1.25rem; padding-bottom: 3rem;">

    <!-- ===== HERO CARD PATH ===== -->
    <div class="mb-4" style="background: linear-gradient(150deg,#0D1830 0%,#0D1830 55%,#00796B 100%); border-radius: 22px; overflow: hidden; color: #fff; position: relative; padding: 2rem;">
        <div style="position:absolute; top:-60px; right:-40px; width:220px; height:220px; border-radius:50%; background:rgba(251,191,36,0.13);"></div>
        <div style="position:absolute; bottom:-80px; left:25%; width:200px; height:200px; border-radius:50%; background:rgba(0,150,136,0.3);"></div>
        <div class="d-flex align-items-center gap-3 position-relative flex-column flex-sm-row text-center text-sm-start">
            <span class="d-flex align-items-center justify-content-center text-white rounded-3 flex-shrink-0" style="width: 64px; height: 64px; background: rgba(255,255,255,0.15); border: 1px solid rgba(255,255,255,0.2);">
                <i class="fas fa-<?php echo $path->icon ?: 'road'; ?> fa-lg"></i>
            </span>
            <div class="flex-fill">
                <h4 class="fw-extrabold mb-1" style="font-size: 1.4rem; letter-spacing: -0.02em;"><?php echo htmlspecialchars($path->title); ?></h4>
                <p class="mb-0" style="color: rgba(230,235,239,0.85); font-size: 0.88rem;"><?php echo htmlspecialchars($path->description); ?></p>
            </div>
        </div>
    </div>

    <?php if ($enrollment): ?>
        <div class="border rounded-4 p-4 mb-4" style="border-color: #E6EBEF; background: #fff; box-shadow: 0 1px 3px rgba(13,24,48,0.04);">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <span class="fw-bold" style="color: #0D1830; font-size: 0.85rem;"><?php echo t('Progress Anda', 'Your Progress'); ?></span>
                <span class="fw-extrabold" style="color: #009688; font-size: 0.95rem;"><?php echo $enrollment->progress_pct; ?>%</span>
            </div>
            <div class="rounded-pill overflow-hidden" style="height: 8px; background: #E6EBEF;">
                <div style="height: 100%; width: <?php echo $enrollment->progress_pct; ?>%; background: linear-gradient(90deg,#009688,#00796B); border-radius: 100px;"></div>
            </div>
            <?php if ($enrollment->completed_at): ?>
                <p class="mt-2 mb-0 fw-semibold" style="color: #009688; font-size: 0.8rem;"><i class="fas fa-check-circle me-1"></i> <?php echo t('Selesai!', 'Completed!'); ?></p>
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <!-- ===== TIMELINE KONTEN ===== -->
    <div class="d-flex flex-column gap-0 position-relative mb-4">
        <?php foreach ($contents as $i => $content): ?>
            <?php $done = isset($content->is_enrolled) && $content->is_enrolled; ?>
            <div class="d-flex gap-3">
                <div class="d-flex flex-column align-items-center flex-shrink-0" style="width: 36px;">
                    <div class="d-flex align-items-center justify-content-center rounded-circle fw-bold" style="width: 34px; height: 34px; font-size: 0.8rem; z-index: 1; background: <?php echo $done ? '#009688' : '#E6EBEF'; ?>; color: <?php echo $done ? '#fff' : '#57534E'; ?>;">
                        <?php echo $done ? '<i class="fas fa-check" style="font-size:0.75rem;"></i>' : ($i + 1); ?>
                    </div>
                    <?php if ($i < count($contents) - 1): ?>
                        <div class="flex-fill" style="width: 2px; background: #E6EBEF; min-height: 28px;"></div>
                    <?php endif; ?>
                </div>
                <div class="flex-fill pb-3 min-w-0">
                    <div class="border rounded-4 p-3 d-flex justify-content-between align-items-center gap-3" style="border-color: #E6EBEF; background: #fff; box-shadow: 0 1px 3px rgba(13,24,48,0.03);">
                        <div class="min-w-0">
                            <h6 class="fw-bold mb-1 text-truncate" style="color: #0D1830; font-size: 0.85rem;"><?php echo htmlspecialchars($content->title); ?></h6>
                            <div class="d-flex gap-2 flex-wrap">
                                <span class="px-2 py-1 rounded-pill fw-semibold" style="background:#E6EBEF; color:#57534E; font-size:0.62rem;"><?php echo content_type_label($content->content_type); ?></span>
                                <span class="px-2 py-1 rounded-pill fw-semibold" style="background:#E0F2F1; color:#009688; font-size:0.62rem;"><?php echo skill_level_label($content->skill_level); ?></span>
                            </div>
                        </div>
                        <a href="<?php echo base_url('courses/detail/' . $content->slug); ?>" class="btn btn-sm fw-bold rounded-pill px-3 flex-shrink-0" style="<?php echo $done ? 'background:#009688; color:#fff;' : 'border:1.5px solid #009688; color:#009688; background:#fff;'; ?> font-size: 0.72rem;">
                            <?php echo $done ? t('Mulai', 'Start') : t('Lihat', 'View'); ?>
                        </a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <?php if (!$enrollment): ?>
        <a href="<?php echo base_url('learning_paths/enroll/' . encode_id($path->id)); ?>" class="btn py-3 fw-bold rounded-pill w-100" style="background: linear-gradient(135deg,#009688,#00796B); color: #fff; font-size: 0.92rem; box-shadow: 0 8px 20px rgba(0,150,136,0.3);">
            <i class="fas fa-play me-2"></i> <?php echo t('Mulai Learning Path Ini', 'Start This Learning Path'); ?>
        </a>
    <?php endif; ?>
</div>
