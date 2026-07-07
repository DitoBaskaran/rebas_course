<div class="container-fluid px-0">
    <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between mb-5 gap-3">
        <div>
            <span class="text-primary fw-semibold small text-uppercase tracking-wide d-block mb-1">Promo</span>
            <h1 class="display-6 fw-extrabold text-dark mb-1 lh-sm" style="letter-spacing: -0.03em;"><?php echo t('Kupon Diskon', 'Coupon Codes'); ?></h1>
            <p class="text-secondary mb-0"><?php echo t('Kelola kode promo dan diskon.', 'Manage promotional discount codes.'); ?></p>
        </div>
        <a href="<?php echo base_url('admin/create_coupon'); ?>" class="btn btn-dark btn-sm px-3 rounded-pill shadow-sm d-flex align-items-center gap-1">
            <i data-lucide="plus" style="width:16px;height:16px;"></i> <?php echo t('Buat Kupon', 'Create Coupon'); ?>
        </a>
    </div>
    <div class="bento-card p-4 p-xl-5">
        <?php if (empty($coupons)): ?>
            <div class="empty-state"><i data-lucide="ticket" style="width:48px;height:48px;color:var(--gray-300);"></i><h5><?php echo t('Belum ada kupon.', 'No coupons yet.'); ?></h5></div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table-modern">
                    <thead><tr><th>Code</th><th><?php echo t('Diskon', 'Discount'); ?></th><th><?php echo t('Min. Belanja', 'Min. Purchase'); ?></th><th><?php echo t('Pemakaian', 'Usage'); ?></th><th><?php echo t('Berlaku', 'Valid Until'); ?></th><th><?php echo t('Status', 'Status'); ?></th><th class="text-center"><?php echo t('Aksi', 'Action'); ?></th></tr></thead>
                    <tbody>
                        <?php foreach ($coupons as $c): ?>
                            <tr>
                                <td class="fw-bold text-dark"><?php echo htmlspecialchars($c->code); ?></td>
                                <td><?php echo $c->discount_type === 'percent' ? $c->discount_value . '%' : 'Rp ' . number_format($c->discount_value, 0, ',', '.'); ?></td>
                                <td><?php echo $c->min_purchase > 0 ? 'Rp ' . number_format($c->min_purchase, 0, ',', '.') : '-'; ?></td>
                                <td><?php echo $c->used_count . ($c->max_uses ? '/' . $c->max_uses : ''); ?></td>
                                <td class="small"><?php echo $c->expired_at ? date('d M Y', strtotime($c->expired_at)) : '-'; ?></td>
                                <td><?php echo $c->is_active ? '<span class="badge bg-success badge-modern">Active</span>' : '<span class="badge bg-secondary badge-modern">Inactive</span>'; ?></td>
                                <td class="text-center"><a href="<?php echo base_url('admin/delete_coupon/' . $c->id); ?>" class="btn btn-outline-danger btn-sm px-2" data-confirm="<?php echo t('Hapus kupon?', 'Delete coupon?'); ?>"><i data-lucide="trash-2" style="width:14px;height:14px;"></i></a></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>
