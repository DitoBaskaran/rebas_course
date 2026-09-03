<div class="container-fluid px-0">

    <!-- ============ HEADER (hero) ============ -->
    <div class="bento-card mb-4 overflow-hidden" style="background:linear-gradient(120deg,#0D1830 0%,#164e63 100%);border:none;color:#fff;">
        <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3 position-relative" style="z-index:1;">
            <div>
                <span class="d-inline-flex align-items-center gap-1" style="background:rgba(255,255,255,0.14);border:1px solid rgba(255,255,255,0.2);color:#FBBF24;font-size:0.66rem;font-weight:800;letter-spacing:0.12em;text-transform:uppercase;padding:0.3rem 0.7rem;border-radius:100px;">
                    <i data-lucide="route" style="width:12px;height:12px;"></i>
                    <?php echo t('Jalur Belajar', 'Learning Paths'); ?>
                </span>
                <h1 class="fw-extrabold text-white mb-1 mt-2 lh-sm" style="letter-spacing:-0.03em;font-size:1.6rem;">
                    <?php echo t('Learning Paths', 'Learning Paths'); ?>
                </h1>
                <p class="mb-0" style="color:rgba(255,255,255,0.72);font-size:0.82rem;">
                    <?php echo t('Kelola jalur belajar terstruktur.', 'Manage structured learning paths.'); ?>
                    <span class="fw-semibold text-white">(<?php echo count($paths); ?>)</span>
                </p>
            </div>
            <a href="<?php echo base_url('admin/create_learning_path'); ?>" class="btn fw-semibold rounded-pill d-inline-flex align-items-center gap-2 border-0 flex-shrink-0" style="background:#FBBF24;color:#0D1830;font-size:0.78rem;padding:0.55rem 1.1rem;box-shadow:0 4px 14px rgba(251,191,36,0.3);">
                <i data-lucide="plus" style="width:14px;height:14px;"></i> <?php echo t('Buat Jalur', 'Create Path'); ?>
            </a>
        </div>
    </div>

    <?php if (empty($paths)): ?>
        <div class="bento-card p-5 text-center">
            <div class="mx-auto d-inline-flex align-items-center justify-content-center rounded-circle mb-3" style="width:72px;height:72px;background:#eff6ff;color:#2563eb;">
                <i data-lucide="route" style="width:30px;height:30px;"></i>
            </div>
            <h5 class="fw-extrabold text-dark mb-1"><?php echo t('Belum ada learning path.', 'No learning paths yet.'); ?></h5>
            <p class="text-secondary small mb-4"><?php echo t('Buat jalur belajar terstruktur pertama Anda.', 'Create your first structured learning path.'); ?></p>
            <a href="<?php echo base_url('admin/create_learning_path'); ?>" class="btn btn-primary rounded-pill px-4 fw-semibold d-inline-flex align-items-center gap-2">
                <i data-lucide="plus" style="width:15px;height:15px;"></i> <?php echo t('Buat Jalur', 'Create Path'); ?>
            </a>
        </div>
    <?php else: ?>
        <!-- ============ PATH CARDS ============ -->
        <div class="bento-grid bento-grid-3" style="align-items:stretch;">
            <?php foreach ($paths as $p): ?>
                <?php
                    $color = $p->color ?? '#4361ee';
                    $items = (int)($p->content_count ?? 0);
                    $hours = (int)($p->estimated_hours ?? 0);
                ?>
                <div class="bento-card p-0 path-card" style="display:flex;flex-direction:column;overflow:hidden;">
                    <!-- Color top bar -->
                    <div style="height:6px;background:<?php echo $color; ?>;"></div>
                    <div class="px-4 pt-3">
                        <span class="d-inline-flex align-items-center justify-content-center rounded-3" style="width:44px;height:44px;background:<?php echo $color; ?>1a;color:<?php echo $color; ?>;">
                            <i data-lucide="route" style="width:22px;height:22px;"></i>
                        </span>
                        <div class="fw-extrabold text-dark mt-2" style="font-size:0.95rem;letter-spacing:-0.01em;line-height:1.3;"><?php echo htmlspecialchars($p->title); ?></div>
                        <div class="text-secondary mt-1" style="font-size:0.75rem;"><?php echo htmlspecialchars($p->category_name ?? '-'); ?></div>
                    </div>
                    <div class="px-4 py-3">
                        <div class="d-flex flex-wrap gap-1 mb-2">
                            <span class="d-inline-flex align-items-center px-2 py-1 rounded-pill fw-semibold" style="background:#eff6ff;color:#2563eb;font-size:0.64rem;"><?php echo skill_level_label($p->skill_level); ?></span>
                            <span class="d-inline-flex align-items-center gap-1 px-2 py-1 rounded-pill fw-semibold" style="background:#E6EBEF;color:#57534e;font-size:0.64rem;"><i data-lucide="book-open" style="width:10px;height:10px;"></i> <?php echo $items; ?> <?php echo t('konten', 'items'); ?></span>
                            <?php if ($hours > 0): ?>
                            <span class="d-inline-flex align-items-center gap-1 px-2 py-1 rounded-pill fw-semibold" style="background:#f0f9ff;color:#0284c7;font-size:0.64rem;"><i data-lucide="clock" style="width:10px;height:10px;"></i> <?php echo $hours; ?> jam</span>
                            <?php endif; ?>
                        </div>
                        <?php if (!empty($p->description)): ?>
                        <div class="text-secondary" style="font-size:0.75rem;line-height:1.55;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;"><?php echo htmlspecialchars($p->description); ?></div>
                        <?php endif; ?>
                    </div>
                    <div class="d-flex gap-2 px-4 py-3 mt-auto" style="border-top:1px solid var(--card-border,#eef0f3);">
                        <a href="<?php echo base_url('admin/edit_learning_path/' . $p->id); ?>" class="btn btn-sm fw-semibold rounded-pill flex-fill d-inline-flex align-items-center justify-content-center gap-1" style="background:#0D1830;color:#fff;font-size:0.72rem;">
                            <i data-lucide="pencil" style="width:12px;height:12px;"></i> <?php echo t('Edit', 'Edit'); ?>
                        </a>
                        <a href="<?php echo base_url('admin/delete_learning_path/' . $p->id); ?>" data-confirm="<?php echo t('Hapus learning path ini?', 'Delete this learning path?'); ?>" class="btn btn-sm d-inline-flex align-items-center justify-content-center" style="background:#dc2626;color:#fff;border:none;border-radius:100px;font-size:0.72rem;width:34px;box-shadow:0 2px 8px rgba(220,38,38,0.25);" title="<?php echo t('Hapus', 'Delete'); ?>"><i data-lucide="trash-2" style="width:13px;height:13px;"></i></a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>
