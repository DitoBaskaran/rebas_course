<div class="container-fluid py-4" style="max-width: 1400px;">
    <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between mb-4 gap-3">
        <div>
            <div style="color: #f97316; font-weight: 700; font-size: 0.7rem; text-transform: uppercase; letter-spacing: 0.08em; margin-bottom: 0.15rem;"><?php echo t('Promo', 'Promo'); ?></div>
            <h4 class="fw-extrabold mb-0" style="color: #1c1917; letter-spacing: -0.02em; font-size: 1.4rem;"><?php echo t('Kupon Diskon', 'Coupon Codes'); ?></h4>
            <p style="color: #78716c; font-size: 0.82rem; margin-bottom: 0;"><?php echo t('Kelola kode promo dan diskon.', 'Manage promotional discount codes.'); ?></p>
        </div>
        <a href="<?php echo base_url('admin/create_coupon'); ?>" class="btn px-3 py-2 fw-semibold rounded-pill d-flex align-items-center gap-1" style="background: #f97316; color: #fff; font-size: 0.78rem;"><i class="fas fa-plus" style="font-size: 0.7rem;"></i> <?php echo t('Buat Kupon', 'Create Coupon'); ?></a>
    </div>

    <div class="border rounded-3" style="border-color: #e7e5e4; border-radius: 12px; overflow: hidden;">
        <?php if (empty($coupons)): ?>
            <div class="p-5 text-center"><div style="font-size: 2rem; color: #d6d3d1; margin-bottom: 0.5rem;"><i class="fas fa-ticket-alt"></i></div><h6 class="fw-bold" style="color: #1c1917;"><?php echo t('Belum ada kupon.', 'No coupons yet.'); ?></h6></div>
        <?php else: ?>
            <div class="table-responsive p-0">
                <table class="table mb-0" style="font-size: 0.8rem;">
                    <thead>
                        <tr>
                            <th style="font-weight: 600; color: #78716c; font-size: 0.68rem; border-color: #e7e5e4; padding: 0.7rem 1rem; background: #fafaf9; text-transform: uppercase; letter-spacing: 0.05em;">Code</th>
                            <th style="font-weight: 600; color: #78716c; font-size: 0.68rem; border-color: #e7e5e4; padding: 0.7rem 1rem; background: #fafaf9; text-transform: uppercase; letter-spacing: 0.05em;"><?php echo t('Diskon', 'Discount'); ?></th>
                            <th style="font-weight: 600; color: #78716c; font-size: 0.68rem; border-color: #e7e5e4; padding: 0.7rem 1rem; background: #fafaf9; text-transform: uppercase; letter-spacing: 0.05em;"><?php echo t('Min. Belanja', 'Min. Purchase'); ?></th>
                            <th style="font-weight: 600; color: #78716c; font-size: 0.68rem; border-color: #e7e5e4; padding: 0.7rem 1rem; background: #fafaf9; text-transform: uppercase; letter-spacing: 0.05em;"><?php echo t('Pemakaian', 'Usage'); ?></th>
                            <th style="font-weight: 600; color: #78716c; font-size: 0.68rem; border-color: #e7e5e4; padding: 0.7rem 1rem; background: #fafaf9; text-transform: uppercase; letter-spacing: 0.05em;"><?php echo t('Berlaku', 'Valid Until'); ?></th>
                            <th style="font-weight: 600; color: #78716c; font-size: 0.68rem; border-color: #e7e5e4; padding: 0.7rem 1rem; background: #fafaf9; text-transform: uppercase; letter-spacing: 0.05em;"><?php echo t('Status', 'Status'); ?></th>
                            <th style="font-weight: 600; color: #78716c; font-size: 0.68rem; border-color: #e7e5e4; padding: 0.7rem 1rem; background: #fafaf9; text-transform: uppercase; letter-spacing: 0.05em; text-align: center; width: 80px;"><?php echo t('Aksi', 'Action'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($coupons as $c): ?>
                            <tr>
                                <td style="border-color: #f0eeeb; padding: 0.65rem 1rem; font-weight: 700; color: #1c1917; font-family: monospace; font-size: 0.82rem;"><?php echo htmlspecialchars($c->code); ?></td>
                                <td style="border-color: #f0eeeb; padding: 0.65rem 1rem; color: #57534e; font-size: 0.78rem;"><?php echo $c->discount_type === 'percent' ? $c->discount_value . '%' : 'Rp ' . number_format($c->discount_value, 0, ',', '.'); ?></td>
                                <td style="border-color: #f0eeeb; padding: 0.65rem 1rem; color: #78716c; font-size: 0.78rem;"><?php echo $c->min_purchase > 0 ? 'Rp ' . number_format($c->min_purchase, 0, ',', '.') : '-'; ?></td>
                                <td style="border-color: #f0eeeb; padding: 0.65rem 1rem; color: #57534e; font-size: 0.78rem;"><?php echo $c->used_count . ($c->max_uses ? '/' . $c->max_uses : ''); ?></td>
                                <td style="border-color: #f0eeeb; padding: 0.65rem 1rem; color: #a8a29e; font-size: 0.72rem;"><?php echo $c->expired_at ? date('d M Y', strtotime($c->expired_at)) : '-'; ?></td>
                                <td style="border-color: #f0eeeb; padding: 0.65rem 1rem;"><?php echo $c->is_active ? '<span class="px-2 py-1 rounded-pill fw-semibold" style="background: #f0fdfa; color: #14b8a6; font-size: 0.6rem;">Active</span>' : '<span class="px-2 py-1 rounded-pill fw-semibold" style="background: #f5f5f4; color: #78716c; font-size: 0.6rem;">Inactive</span>'; ?></td>
                                <td style="border-color: #f0eeeb; padding: 0.65rem 1rem; text-align: center;"><a href="<?php echo base_url('admin/delete_coupon/' . $c->id); ?>" class="btn btn-sm rounded-pill px-2 d-inline-flex align-items-center" style="border: 1px solid #fca5a5; color: #f43f5e; font-size: 0.68rem;" data-confirm="<?php echo t('Hapus kupon?', 'Delete coupon?'); ?>"><i class="fas fa-trash-alt" style="font-size: 0.65rem;"></i></a></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>
