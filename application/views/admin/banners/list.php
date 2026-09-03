<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="container-fluid px-0">

    <!-- ============ HEADER (hero) ============ -->
    <?php
        $active_n = 0;
        foreach ($banners as $b) { if ($b->is_active) $active_n++; }
    ?>
    <div class="bento-card mb-4 overflow-hidden" style="background:linear-gradient(120deg,#0D1830 0%,#164e63 100%);border:none;color:#fff;">
        <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3 position-relative" style="z-index:1;">
            <div>
                <span class="d-inline-flex align-items-center gap-1" style="background:rgba(255,255,255,0.14);border:1px solid rgba(255,255,255,0.2);color:#FBBF24;font-size:0.66rem;font-weight:800;letter-spacing:0.12em;text-transform:uppercase;padding:0.3rem 0.7rem;border-radius:100px;">
                    <i data-lucide="images" style="width:12px;height:12px;"></i>
                    <?php echo t('Dashboard', 'Dashboard'); ?>
                </span>
                <h1 class="fw-extrabold text-white mb-1 mt-2 lh-sm" style="letter-spacing:-0.03em;font-size:1.6rem;">
                    <?php echo t('Banner Dashboard', 'Dashboard Banners'); ?>
                </h1>
                <p class="mb-0" style="color:rgba(255,255,255,0.72);font-size:0.82rem;">
                    <?php echo t('Kelola carousel banner di dashboard student & mentor.', 'Manage banner carousel on student & mentor dashboard.'); ?>
                    <span class="fw-semibold text-white">(<?php echo count($banners); ?> · <?php echo $active_n; ?> <?php echo t('aktif', 'active'); ?>)</span>
                </p>
            </div>
            <a href="<?php echo base_url('admin/banners_create'); ?>" class="btn fw-semibold rounded-pill d-inline-flex align-items-center gap-2 border-0 flex-shrink-0" style="background:#FBBF24;color:#0D1830;font-size:0.78rem;padding:0.55rem 1.1rem;box-shadow:0 4px 14px rgba(251,191,36,0.3);">
                <i data-lucide="plus" style="width:14px;height:14px;"></i> <?php echo t('Tambah Banner', 'Add Banner'); ?>
            </a>
        </div>
    </div>

    <?php if (empty($banners)): ?>
        <div class="bento-card p-5 text-center">
            <div class="mx-auto d-inline-flex align-items-center justify-content-center rounded-circle mb-3" style="width:72px;height:72px;background:#E6EBEF;color:#94a3b8;">
                <i data-lucide="images" style="width:30px;height:30px;"></i>
            </div>
            <h5 class="fw-extrabold text-dark mb-1"><?php echo t('Belum ada banner.', 'No banners yet.'); ?></h5>
            <p class="text-secondary small mb-4"><?php echo t('Tambahkan banner pertama Anda.', 'Add your first banner.'); ?></p>
            <a href="<?php echo base_url('admin/banners_create'); ?>" class="btn btn-primary rounded-pill px-4 fw-semibold d-inline-flex align-items-center gap-2">
                <i data-lucide="plus" style="width:15px;height:15px;"></i> <?php echo t('Tambah Banner', 'Add Banner'); ?>
            </a>
        </div>
    <?php else: ?>
        <!-- ============ BANNER CARDS ============ -->
        <div class="bento-grid bento-grid-3" style="align-items:stretch;">
            <?php foreach ($banners as $b): ?>
                <?php
                    $has_img = !empty($b->image) && file_exists(FCPATH . 'uploads/banners/' . $b->image);
                    if ($b->target === 'both') { $t_bg='#E0F2F1'; $t_tx='#009688'; $t_label=t('Student & Mentor','Student & Mentor'); }
                    elseif ($b->target === 'student') { $t_bg='#dbeafe'; $t_tx='#2563eb'; $t_label=t('Student','Student'); }
                    else { $t_bg='#f3e8ff'; $t_tx='#a855f7'; $t_label=t('Mentor','Mentor'); }
                ?>
                <div class="bento-card p-0 banner-card" style="display:flex;flex-direction:column;overflow:hidden;">
                    <!-- Banner image area -->
                    <div class="position-relative" style="aspect-ratio:16/7;background:linear-gradient(120deg,#0D1830,#164e63);overflow:hidden;">
                        <?php if ($has_img): ?>
                            <img src="<?php echo base_url('uploads/banners/' . $b->image); ?>" alt="" style="width:100%;height:100%;object-fit:cover;" loading="lazy">
                        <?php else: ?>
                            <div class="w-100 h-100 d-flex align-items-center justify-content-center">
                                <i data-lucide="image" style="width:30px;height:30px;color:rgba(255,255,255,0.3);"></i>
                            </div>
                        <?php endif; ?>
                        <span class="position-absolute px-2 py-1 rounded-pill fw-semibold" style="top:0.6rem;left:0.6rem;background:<?php echo $t_bg; ?>;color:<?php echo $t_tx; ?>;font-size:0.62rem;">
                            <i data-lucide="users" style="width:10px;height:10px;" class="me-1"></i><?php echo $t_label; ?>
                        </span>
                        <?php if ($b->is_active): ?>
                            <span class="position-absolute d-inline-flex align-items-center gap-1 px-2 py-1 rounded-pill fw-semibold" style="top:0.6rem;right:0.6rem;background:rgba(13,24,48,0.7);color:#fff;font-size:0.62rem;">
                                <i data-lucide="eye" style="width:10px;height:10px;"></i> <?php echo t('Tampil', 'Live'); ?>
                            </span>
                        <?php else: ?>
                            <span class="position-absolute d-inline-flex align-items-center gap-1 px-2 py-1 rounded-pill fw-semibold" style="top:0.6rem;right:0.6rem;background:rgba(148,163,184,0.85);color:#fff;font-size:0.62rem;">
                                <i data-lucide="eye-off" style="width:10px;height:10px;"></i> <?php echo t('Disembunyikan', 'Hidden'); ?>
                            </span>
                        <?php endif; ?>
                    </div>
                    <!-- Body -->
                    <div class="px-3 py-3">
                        <div class="fw-bold text-dark" style="font-size:0.88rem;line-height:1.35;"><?php echo htmlspecialchars($b->title); ?></div>
                        <?php if (!empty($b->link)): ?>
                        <a href="<?php echo htmlspecialchars($b->link); ?>" target="_blank" class="text-decoration-none small d-inline-flex align-items-center gap-1 mt-1" style="color:var(--primary,#009688);font-size:0.72rem;">
                            <i data-lucide="external-link" style="width:11px;height:11px;"></i> <?php echo htmlspecialchars(substr($b->link, 0, 45)); ?><?php echo strlen($b->link) > 45 ? '…' : ''; ?>
                        </a>
                        <?php else: ?>
                        <div class="text-muted mt-1" style="font-size:0.72rem;"><?php echo t('Tanpa tautan', 'No link'); ?></div>
                        <?php endif; ?>
                    </div>
                    <!-- Actions -->
                    <div class="d-flex gap-2 px-3 pb-3 mt-auto">
                        <a href="<?php echo base_url('admin/banners_edit/' . $b->id); ?>" class="btn btn-sm fw-semibold rounded-pill flex-fill d-inline-flex align-items-center justify-content-center gap-1" style="background:#0D1830;color:#fff;font-size:0.72rem;">
                            <i data-lucide="pencil" style="width:12px;height:12px;"></i> <?php echo t('Edit', 'Edit'); ?>
                        </a>
                        <a href="<?php echo base_url('admin/banners_delete/' . $b->id); ?>" data-confirm="<?php echo t('Hapus banner ini?', 'Delete this banner?'); ?>" class="btn btn-sm fw-semibold rounded-pill d-inline-flex align-items-center justify-content-center" style="background:#dc2626;color:#fff;border:none;font-size:0.72rem;width:34px;box-shadow:0 2px 8px rgba(220,38,38,0.25);" title="<?php echo t('Hapus', 'Delete'); ?>"><i class="fas fa-trash-alt" style="color:#fff;font-size:0.7rem;"></i></a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>
