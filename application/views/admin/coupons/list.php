<div class="container-fluid px-0">

    <!-- ============ HEADER (hero) ============ -->
    <?php
        $active_n = 0;
        foreach ($coupons as $c) { if ($c->is_active) $active_n++; }
    ?>
    <div class="bento-card mb-4 overflow-hidden" style="background:linear-gradient(120deg,#0D1830 0%,#164e63 100%);border:none;color:#fff;">
        <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3 position-relative" style="z-index:1;">
            <div>
                <span class="d-inline-flex align-items-center gap-1" style="background:rgba(255,255,255,0.14);border:1px solid rgba(255,255,255,0.2);color:#FBBF24;font-size:0.66rem;font-weight:800;letter-spacing:0.12em;text-transform:uppercase;padding:0.3rem 0.7rem;border-radius:100px;">
                    <i data-lucide="ticket" style="width:12px;height:12px;"></i>
                    <?php echo t('Promo', 'Promo'); ?>
                </span>
                <h1 class="fw-extrabold text-white mb-1 mt-2 lh-sm" style="letter-spacing:-0.03em;font-size:1.6rem;">
                    <?php echo t('Kupon Diskon', 'Coupon Codes'); ?>
                </h1>
                <p class="mb-0" style="color:rgba(255,255,255,0.72);font-size:0.82rem;">
                    <?php echo t('Kelola kode promo dan diskon.', 'Manage promotional discount codes.'); ?>
                    <span class="fw-semibold text-white">(<?php echo count($coupons); ?> · <?php echo $active_n; ?> <?php echo t('aktif', 'active'); ?>)</span>
                </p>
            </div>
            <a href="<?php echo base_url('admin/create_coupon'); ?>" class="btn fw-semibold rounded-pill d-inline-flex align-items-center gap-2 border-0 flex-shrink-0" style="background:#FBBF24;color:#0D1830;font-size:0.78rem;padding:0.55rem 1.1rem;box-shadow:0 4px 14px rgba(251,191,36,0.3);">
                <i data-lucide="plus" style="width:14px;height:14px;"></i> <?php echo t('Buat Kupon', 'Create Coupon'); ?>
            </a>
        </div>
    </div>

    <?php if (empty($coupons)): ?>
        <div class="bento-card p-5 text-center">
            <div class="mx-auto d-inline-flex align-items-center justify-content-center rounded-circle mb-3" style="width:72px;height:72px;background:#fef3c7;color:#d97706;">
                <i data-lucide="ticket" style="width:30px;height:30px;"></i>
            </div>
            <h5 class="fw-extrabold text-dark mb-1"><?php echo t('Belum ada kupon.', 'No coupons yet.'); ?></h5>
            <p class="text-secondary small mb-4"><?php echo t('Buat kode promo untuk diskon pembelian.', 'Create promo codes for purchase discounts.'); ?></p>
            <a href="<?php echo base_url('admin/create_coupon'); ?>" class="btn btn-primary rounded-pill px-4 fw-semibold d-inline-flex align-items-center gap-2">
                <i data-lucide="plus" style="width:15px;height:15px;"></i> <?php echo t('Buat Kupon', 'Create Coupon'); ?>
            </a>
        </div>
    <?php else: ?>
        <!-- ============ COUPON CARDS ============ -->
        <div class="bento-grid bento-grid-3" style="align-items:stretch;">
            <?php foreach ($coupons as $c): ?>
                <?php
                    $discount_txt = $c->discount_type === 'percent' ? $c->discount_value . '%' : 'Rp ' . number_format($c->discount_value, 0, ',', '.');
                    $img_ok = !empty($c->image) && file_exists(FCPATH . 'uploads/coupons/' . $c->image);
                    $is_expired = !empty($c->expired_at) && strtotime($c->expired_at) < time();
                    $is_disabled = !$c->is_active || $is_expired;
                    $sold_out = $c->max_uses > 0 && $c->used_count >= $c->max_uses;
                    if ($is_disabled) { $st_bg='#f1f5f9'; $st_tx='#64748b'; $st_label=t('Nonaktif', 'Inactive'); }
                    else { $st_bg='#E0F2F1'; $st_tx='#009688'; $st_label=t('Aktif', 'Active'); }
                ?>
                <div class="bento-card p-0 coupon-ticket" style="display:flex;flex-direction:column;overflow:hidden;opacity:<?php echo $is_disabled ? '0.75' : '1'; ?>;">
                    <!-- Ticket head -->
                    <div class="d-flex align-items-center gap-3 px-3 pt-3">
                        <?php if ($img_ok): ?>
                            <img src="<?php echo base_url('uploads/coupons/' . $c->image); ?>" alt="" style="width:52px;height:52px;object-fit:cover;border-radius:12px;" loading="lazy">
                        <?php else: ?>
                            <span class="d-inline-flex align-items-center justify-content-center rounded-3 flex-shrink-0" style="width:52px;height:52px;background:#fef3c7;color:#d97706;">
                                <i class="fas fa-ticket-alt" style="font-size:1.2rem;"></i>
                            </span>
                        <?php endif; ?>
                        <div class="flex-fill" style="min-width:0;">
                            <div class="fw-extrabold" style="font-family:'Courier New',monospace;font-size:1rem;letter-spacing:0.04em;color:<?php echo $is_disabled ? '#64748b' : '#0D1830'; ?>;"><?php echo htmlspecialchars($c->code); ?></div>
                            <div class="d-flex align-items-center gap-1 mt-1">
                                <span class="fw-extrabold" style="color:#d97706;font-size:1.05rem;"><?php echo $discount_txt; ?></span>
                                <?php if ($c->discount_type === 'percent'): ?><span class="px-1 rounded" style="background:#fef3c7;color:#d97706;font-size:0.6rem;font-weight:800;">%</span><?php endif; ?>
                            </div>
                        </div>
                        <span class="px-2 py-1 rounded-pill fw-semibold flex-shrink-0" style="background:<?php echo $st_bg; ?>;color:<?php echo $st_tx; ?>;font-size:0.62rem;"><?php echo $st_label; ?></span>
                    </div>

                    <!-- Dashed divider -->
                    <div class="coupon-divider mt-3"></div>

                    <!-- Body -->
                    <div class="px-3 py-3 d-flex flex-column gap-2">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="text-secondary" style="font-size:0.72rem;"><i data-lucide="shopping-bag" style="width:12px;height:12px;" class="me-1"></i><?php echo t('Min. Belanja', 'Min. Purchase'); ?></span>
                            <span class="fw-bold text-dark" style="font-size:0.78rem;"><?php echo $c->min_purchase > 0 ? 'Rp ' . number_format($c->min_purchase, 0, ',', '.') : '-'; ?></span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="text-secondary" style="font-size:0.72rem;"><i data-lucide="repeat" style="width:12px;height:12px;" class="me-1"></i><?php echo t('Pemakaian', 'Usage'); ?></span>
                            <?php $pct_used = $c->max_uses > 0 ? min(100, round(($c->used_count / $c->max_uses) * 100)) : 0; ?>
                            <span class="fw-bold text-dark" style="font-size:0.78rem;">
                                <?php echo $c->used_count; ?><?php echo $c->max_uses ? ' / ' . $c->max_uses : ''; ?>
                                <?php if ($sold_out): ?><span class="ms-1 px-2 py-0 rounded-pill fw-bold" style="background:#fef2f2;color:#dc2626;font-size:0.58rem;"><?php echo t('Habis', 'Used up'); ?></span><?php endif; ?>
                            </span>
                        </div>
                        <?php if ($c->max_uses > 0): ?>
                        <div class="progress" style="height:5px;background:var(--gray-100,#f1f5f9);border-radius:100px;">
                            <div class="progress-bar" role="progressbar" style="width:<?php echo $pct_used; ?>%;border-radius:100px;background:<?php echo $sold_out ? '#dc2626' : '#d97706'; ?>;"></div>
                        </div>
                        <?php endif; ?>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="text-secondary" style="font-size:0.72rem;"><i data-lucide="calendar" style="width:12px;height:12px;" class="me-1"></i><?php echo t('Berlaku Hingga', 'Valid Until'); ?></span>
                            <?php if (!empty($c->expired_at)): ?>
                                <?php $exp = strtotime($c->expired_at); ?>
                                <span class="fw-bold" style="font-size:0.75rem;color:<?php echo $exp < time() ? '#dc2626' : '#0D1830'; ?>;">
                                    <?php echo date('d M Y', $exp); ?>
                                    <?php if ($exp < time()): ?><span class="ms-1 px-2 py-0 rounded-pill fw-bold" style="background:#fef2f2;color:#dc2626;font-size:0.58rem;"><?php echo t('Kadaluarsa', 'Expired'); ?></span><?php endif; ?>
                                </span>
                            <?php else: ?>
                                <span class="fw-bold text-dark" style="font-size:0.75rem;">-</span>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Footer action -->
                    <div class="d-flex justify-content-center px-3 pb-3 mt-auto">
                        <a href="<?php echo base_url('admin/delete_coupon/' . $c->id); ?>" data-confirm="<?php echo t('Hapus kupon ini?', 'Delete this coupon?'); ?>" class="btn btn-sm fw-semibold rounded-pill d-inline-flex align-items-center justify-content-center gap-1 px-4 w-100" style="border:1px solid #fecaca;color:#dc2626;font-size:0.74rem;">
                            <i class="fas fa-trash-alt" style="font-size:0.68rem;"></i> <?php echo t('Hapus Kupon', 'Delete Coupon'); ?>
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>
