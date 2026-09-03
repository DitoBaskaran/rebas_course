<div class="container-fluid px-0">

    <!-- ============ HEADER (hero) ============ -->
    <div class="bento-card mb-4 overflow-hidden" style="background:linear-gradient(120deg,#0D1830 0%,#164e63 100%);border:none;color:#fff;">
        <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3 position-relative" style="z-index:1;">
            <div>
                <span class="d-inline-flex align-items-center gap-1" style="background:rgba(255,255,255,0.14);border:1px solid rgba(255,255,255,0.2);color:#FBBF24;font-size:0.66rem;font-weight:800;letter-spacing:0.12em;text-transform:uppercase;padding:0.3rem 0.7rem;border-radius:100px;">
                    <i data-lucide="layers" style="width:12px;height:12px;"></i>
                    <?php echo t('Langganan', 'Subscription'); ?>
                </span>
                <h1 class="fw-extrabold text-white mb-1 mt-2 lh-sm" style="letter-spacing:-0.03em;font-size:1.6rem;">
                    <?php echo t('Paket Langganan', 'Subscription Packages'); ?>
                </h1>
                <p class="mb-0" style="color:rgba(255,255,255,0.72);font-size:0.82rem;max-width:44rem;line-height:1.6;">
                    <?php echo t('Kelola paket langganan dan akses konten.', 'Manage subscription packages and content access.'); ?>
                </p>
            </div>
            <a href="<?php echo base_url('admin/packages/create'); ?>" class="btn fw-semibold rounded-pill d-inline-flex align-items-center gap-2 border-0 flex-shrink-0" style="background:#FBBF24;color:#0D1830;font-size:0.78rem;padding:0.55rem 1.1rem;box-shadow:0 4px 14px rgba(251,191,36,0.3);">
                <i data-lucide="plus" style="width:14px;height:14px;"></i> <?php echo t('Buat Paket Baru', 'Create New Package'); ?>
            </a>
        </div>
    </div>

    <?php if (empty($packages)): ?>
        <!-- Empty state -->
        <div class="bento-card p-5 text-center">
            <div class="mx-auto d-inline-flex align-items-center justify-content-center rounded-circle mb-3" style="width:72px;height:72px;background:#E0F2F1;color:#009688;font-size:1.6rem;">
                <i data-lucide="layers" style="width:30px;height:30px;"></i>
            </div>
            <h5 class="fw-extrabold text-dark mb-1"><?php echo t('Belum ada paket langganan.', 'No subscription packages yet.'); ?></h5>
            <p class="text-secondary small mb-4" style="max-width:26rem;margin:0 auto;"><?php echo t('Buat paket langganan pertama Anda.', 'Create your first subscription package.'); ?></p>
            <a href="<?php echo base_url('admin/packages/create'); ?>" class="btn btn-primary rounded-pill px-4 fw-semibold d-inline-flex align-items-center gap-2">
                <i data-lucide="plus" style="width:15px;height:15px;"></i> <?php echo t('Buat Paket Baru', 'Create New Package'); ?>
            </a>
        </div>
    <?php else: ?>
        <!-- ============ PACKAGE CARDS ============ -->
        <div class="bento-grid bento-grid-3 mb-4" style="align-items:stretch;">
            <?php foreach ($packages as $i => $p): ?>
                <?php
                    $active = (int)$p->is_active === 1;
                    $scope = $p->access_scope;
                    $scope_label = ($scope === 'all') ? t('Semua Konten', 'All Content') : (($scope === 'category') ? t('Per Kategori', 'By Category') : t('Per Kursus', 'By Course'));
                    $scope_ic = ($scope === 'all') ? 'infinity' : (($scope === 'category') ? 'folder-tree' : 'book-open');
                    $accent_bg = ($i % 3 === 0) ? '#E0F2F1' : (($i % 3 === 1) ? '#eff6ff' : '#fff7ed');
                    $accent_tx = ($i % 3 === 0) ? '#009688' : (($i % 3 === 1) ? '#2563eb' : '#ea580c');
                ?>
                <div class="bento-card p-0 package-card" style="display:flex;flex-direction:column;overflow:hidden;">
                    <!-- Top accent -->
                    <div style="height:5px;background:<?php echo $accent_tx; ?>;opacity:0.85;"></div>
                    <div class="d-flex align-items-start justify-content-between gap-2 px-4 pt-3">
                        <span class="d-inline-flex align-items-center justify-content-center rounded-3 flex-shrink-0" style="width:46px;height:46px;background:<?php echo $accent_bg; ?>;color:<?php echo $accent_tx; ?>;">
                            <i data-lucide="<?php echo $scope_ic; ?>" style="width:22px;height:22px;"></i>
                        </span>
                        <?php echo $active ? '<span class="mob-chip mob-chip-green"><i class="fas fa-check-circle me-1" style="font-size:0.55rem;"></i> Active</span>' : '<span class="mob-chip mob-chip-red">Inactive</span>'; ?>
                    </div>
                    <div class="px-4 mt-3">
                        <div class="fw-extrabold text-dark" style="font-size:1.02rem;letter-spacing:-0.01em;line-height:1.3;"><?php echo htmlspecialchars($p->name); ?></div>
                        <div class="d-flex align-items-baseline gap-1 mt-2">
                            <span class="fw-extrabold" style="color:<?php echo $accent_tx; ?>;font-size:1.55rem;letter-spacing:-0.02em;">Rp <?php echo number_format($p->price, 0, ',', '.'); ?></span>
                            <span class="text-secondary" style="font-size:0.72rem;">/ <?php echo $p->duration_days . ' ' . t('hari', 'days'); ?></span>
                        </div>
                        <div class="d-flex flex-wrap gap-2 mt-3">
                            <span class="d-inline-flex align-items-center gap-1 px-2 py-1 rounded-pill fw-semibold" style="background:<?php echo $accent_bg; ?>;color:<?php echo $accent_tx; ?>;font-size:0.68rem;">
                                <i data-lucide="<?php echo $scope_ic; ?>" style="width:12px;height:12px;"></i> <?php echo $scope_label; ?>
                            </span>
                            <span class="d-inline-flex align-items-center gap-1 px-2 py-1 rounded-pill fw-semibold" style="background:#E6EBEF;color:#57534e;font-size:0.68rem;">
                                <i data-lucide="calendar" style="width:12px;height:12px;"></i> <?php echo $p->duration_days . ' ' . t('hari', 'days'); ?>
                            </span>
                        </div>
                    </div>
                    <div class="d-flex gap-2 px-4 py-3 mt-auto">
                        <a href="<?php echo base_url('admin/packages/edit/' . $p->id); ?>" class="btn btn-sm fw-semibold rounded-pill flex-fill d-inline-flex align-items-center justify-content-center gap-1" style="background:#0D1830;color:#fff;font-size:0.72rem;">
                            <i data-lucide="pencil" style="width:12px;height:12px;"></i> <?php echo t('Edit', 'Edit'); ?>
                        </a>
                        <a href="<?php echo base_url('admin/packages/delete/' . $p->id); ?>" data-confirm="<?php echo t('Hapus paket langganan?', 'Delete subscription package?'); ?>" class="btn btn-sm fw-semibold rounded-pill d-inline-flex align-items-center justify-content-center gap-1" style="border:1px solid #fecaca;color:#dc2626;font-size:0.72rem;" title="<?php echo t('Hapus', 'Delete'); ?>">
                            <i data-lucide="trash-2" style="width:12px;height:12px;"></i>
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Legend / hint -->
        <div class="bento-card d-flex align-items-center gap-2" style="padding:0.9rem 1.1rem;">
            <i data-lucide="info" style="width:15px;height:15px;color:var(--primary);flex-shrink:0;"></i>
            <span class="small text-muted">
                <?php echo t('Paket ini menentukan akses konten untuk pelanggan berlangganan. Klik Edit untuk mengatur detail paket, kategori, atau kursus.', 'These packages determine content access for subscribed customers. Click Edit to manage package details, categories, or courses.'); ?>
            </span>
        </div>
    <?php endif; ?>
</div>
