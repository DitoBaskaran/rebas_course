<div class="app-page">
    <!-- Header -->
    <div class="app-page-head">
        <div>
            <h4 class="app-page-title"><i class="fas fa-ticket-alt"></i> <?php echo t('Kupon Diskon', 'Coupon Codes'); ?></h4>
            <p class="app-page-sub"><?php echo t('Kelola kode promo dan diskon.', 'Manage promotional discount codes.'); ?></p>
        </div>
        <div class="app-page-actions">
            <a href="<?php echo base_url('admin/create_coupon'); ?>" class="app-btn app-btn-primary"><i class="fas fa-plus"></i> <?php echo t('Buat Kupon', 'Create Coupon'); ?></a>
        </div>
    </div>

    <div class="app-card">
        <?php if (empty($coupons)): ?>
            <div class="app-empty">
                <i class="fas fa-ticket-alt"></i>
                <h6><?php echo t('Belum ada kupon.', 'No coupons yet.'); ?></h6>
                <p><?php echo t('Buat kode promo untuk diskon pembelian.', 'Create promo codes for purchase discounts.'); ?></p>
            </div>
        <?php else: ?>
            <div class="app-table-wrap">
                <table class="app-table">
                    <thead>
                        <tr>
                            <th>Code</th>
                            <th><?php echo t('Diskon', 'Discount'); ?></th>
                            <th><?php echo t('Min. Belanja', 'Min. Purchase'); ?></th>
                            <th><?php echo t('Pemakaian', 'Usage'); ?></th>
                            <th><?php echo t('Berlaku', 'Valid Until'); ?></th>
                            <th><?php echo t('Status', 'Status'); ?></th>
                            <th class="td-actions"><?php echo t('Aksi', 'Action'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($coupons as $c): ?>
                            <tr>
                                <td class="td-title" style="font-family:monospace;"><?php echo htmlspecialchars($c->code); ?></td>
                                <td style="color:#57534e;font-size:0.78rem;"><?php echo $c->discount_type === 'percent' ? $c->discount_value . '%' : 'Rp ' . number_format($c->discount_value, 0, ',', '.'); ?></td>
                                <td style="color:#78716c;font-size:0.78rem;"><?php echo $c->min_purchase > 0 ? 'Rp ' . number_format($c->min_purchase, 0, ',', '.') : '-'; ?></td>
                                <td style="color:#57534e;font-size:0.78rem;"><?php echo $c->used_count . ($c->max_uses ? '/' . $c->max_uses : ''); ?></td>
                                <td style="color:#a8a29e;font-size:0.72rem;"><?php echo $c->expired_at ? date('d M Y', strtotime($c->expired_at)) : '-'; ?></td>
                                <td><?php echo $c->is_active ? '<span class="app-chip app-chip-green">Active</span>' : '<span class="app-chip app-chip-gray">Inactive</span>'; ?></td>
                                <td class="td-actions">
                                    <a href="<?php echo base_url('admin/delete_coupon/' . $c->id); ?>" class="app-action app-action-red" data-confirm="<?php echo t('Hapus kupon?', 'Delete coupon?'); ?>" title="<?php echo t('Hapus', 'Delete'); ?>"><i class="fas fa-trash-alt"></i></a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>
