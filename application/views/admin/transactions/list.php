<div class="container-fluid py-4" style="max-width: 1400px;">
    <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between mb-4 gap-3">
        <div>
            <div style="color: #f97316; font-weight: 700; font-size: 0.7rem; text-transform: uppercase; letter-spacing: 0.08em; margin-bottom: 0.15rem;"><?php echo t('Keuangan', 'Finance'); ?></div>
            <h4 class="fw-extrabold mb-0" style="color: #1c1917; letter-spacing: -0.02em; font-size: 1.4rem;"><?php echo t('Transaksi', 'Transactions'); ?></h4>
            <p style="color: #78716c; font-size: 0.82rem; margin-bottom: 0;"><?php echo t('Kelola semua transaksi pembelian.', 'Manage all purchase transactions.'); ?></p>
        </div>
    </div>

    <?php $item_labels = array('course' => t('Kursus', 'Course'), 'seminar' => t('Seminar', 'Seminar'), 'workshop' => t('Workshop', 'Workshop'), 'bootcamp' => t('Bootcamp', 'Bootcamp'), 'ebook' => t('E-Book', 'E-Book'), 'project' => t('Proyek', 'Project'), 'mentoring' => t('Mentoring', 'Mentoring'), 'package' => t('Paket', 'Package'), 'package_6mo' => t('Paket 6 Bln', 'Package 6mo'), 'mentoring_package' => t('Paket Mentoring', 'Mentoring Package')); ?>
    <div class="border rounded-3" style="border-color: #e7e5e4; border-radius: 12px; overflow: hidden;">
        <?php if (empty($transactions)): ?>
            <div class="p-5 text-center"><div style="font-size: 2rem; color: #d6d3d1; margin-bottom: 0.5rem;"><i class="fas fa-receipt"></i></div><h6 class="fw-bold" style="color: #1c1917;"><?php echo t('Belum ada transaksi.', 'No transactions yet.'); ?></h6></div>
        <?php else: ?>
            <div class="table-responsive p-0">
                <table class="table mb-0" style="font-size: 0.8rem;">
                    <thead>
                        <tr>
                            <th style="font-weight: 600; color: #78716c; font-size: 0.68rem; border-color: #e7e5e4; padding: 0.7rem 1rem; background: #fafaf9; text-transform: uppercase; letter-spacing: 0.05em;">ID</th>
                            <th style="font-weight: 600; color: #78716c; font-size: 0.68rem; border-color: #e7e5e4; padding: 0.7rem 1rem; background: #fafaf9; text-transform: uppercase; letter-spacing: 0.05em;"><?php echo t('Pengguna', 'User'); ?></th>
                            <th style="font-weight: 600; color: #78716c; font-size: 0.68rem; border-color: #e7e5e4; padding: 0.7rem 1rem; background: #fafaf9; text-transform: uppercase; letter-spacing: 0.05em;"><?php echo t('Item', 'Item'); ?></th>
                            <th style="font-weight: 600; color: #78716c; font-size: 0.68rem; border-color: #e7e5e4; padding: 0.7rem 1rem; background: #fafaf9; text-transform: uppercase; letter-spacing: 0.05em;"><?php echo t('Tipe', 'Type'); ?></th>
                            <th style="font-weight: 600; color: #78716c; font-size: 0.68rem; border-color: #e7e5e4; padding: 0.7rem 1rem; background: #fafaf9; text-transform: uppercase; letter-spacing: 0.05em;"><?php echo t('Jumlah', 'Amount'); ?></th>
                            <th style="font-weight: 600; color: #78716c; font-size: 0.68rem; border-color: #e7e5e4; padding: 0.7rem 1rem; background: #fafaf9; text-transform: uppercase; letter-spacing: 0.05em;"><?php echo t('Kupon', 'Coupon'); ?></th>
                            <th style="font-weight: 600; color: #78716c; font-size: 0.68rem; border-color: #e7e5e4; padding: 0.7rem 1rem; background: #fafaf9; text-transform: uppercase; letter-spacing: 0.05em;"><?php echo t('Status', 'Status'); ?></th>
                            <th style="font-weight: 600; color: #78716c; font-size: 0.68rem; border-color: #e7e5e4; padding: 0.7rem 1rem; background: #fafaf9; text-transform: uppercase; letter-spacing: 0.05em;"><?php echo t('Tanggal', 'Date'); ?></th>
                            <th style="font-weight: 600; color: #78716c; font-size: 0.68rem; border-color: #e7e5e4; padding: 0.7rem 1rem; background: #fafaf9; text-transform: uppercase; letter-spacing: 0.05em; text-align: center; width: 90px;"><?php echo t('Aksi', 'Action'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($transactions as $tx): ?>
                            <tr>
                                <td style="border-color: #f0eeeb; padding: 0.65rem 1rem; font-family: monospace; font-size: 0.72rem; color: #1c1917;">BT-<?php echo $tx->uuid; ?></td>
                                <td style="border-color: #f0eeeb; padding: 0.65rem 1rem; font-weight: 600; color: #1c1917; font-size: 0.78rem;"><?php echo htmlspecialchars($tx->user_name); ?></td>
                                <td style="border-color: #f0eeeb; padding: 0.65rem 1rem; color: #57534e; font-size: 0.78rem;">
                                    <?php $item_name = ucfirst($tx->item_type) . ' #' . $tx->item_id; if ($tx->item_type === 'package' || $tx->item_type === 'package_6mo') { $pkg = $this->db->get_where('packages', array('id' => $tx->item_id))->row(); $item_name = $pkg ? $pkg->name : $item_name; } elseif (in_array($tx->item_type, ['course', 'workshop', 'bootcamp', 'ebook', 'project', 'mentoring_package'])) { $table = $tx->item_type === 'mentoring_package' ? 'mentoring_packages' : 'courses'; $pkg = $this->db->get_where($table, array('id' => $tx->item_id))->row(); $item_name = $pkg ? ($pkg->name ?? $pkg->title) : $item_name; } echo htmlspecialchars($item_name); ?>
                                </td>
                                <td style="border-color: #f0eeeb; padding: 0.65rem 1rem;"><span class="px-2 py-1 rounded-pill fw-semibold" style="background: #f5f5f4; color: #57534e; font-size: 0.6rem;"><?php echo $item_labels[$tx->item_type] ?? ucfirst($tx->item_type); ?></span></td>
                                <td style="border-color: #f0eeeb; padding: 0.65rem 1rem; font-weight: 700; color: #1c1917; font-size: 0.8rem;">Rp <?php echo number_format($tx->amount, 0, ',', '.'); ?><?php if ($tx->discount_amount > 0): ?><br><small style="color: #10b981; font-size: 0.65rem;">(-Rp <?php echo number_format($tx->discount_amount, 0, ',', '.'); ?>)</small><?php endif; ?></td>
                                <td style="border-color: #f0eeeb; padding: 0.65rem 1rem;"><?php if ($tx->coupon_id): $coupon = $this->db->get_where('coupons', array('id' => $tx->coupon_id))->row(); ?><span class="px-2 py-1 rounded-pill fw-semibold" style="background: #f0fdfa; color: #10b981; font-size: 0.6rem;"><?php echo $coupon ? htmlspecialchars($coupon->code) : '#' . $tx->coupon_id; ?></span><?php else: ?><span style="color: #a8a29e; font-size: 0.72rem;">-</span><?php endif; ?></td>
                                <td style="border-color: #f0eeeb; padding: 0.65rem 1rem;"><?php if ($tx->status === 'pending'): ?><span class="px-2 py-1 rounded-pill fw-semibold" style="background: #fff7ed; color: #f97316; font-size: 0.6rem;"><?php echo t('Pending', 'Pending'); ?></span><?php elseif ($tx->status === 'approved'): ?><span class="px-2 py-1 rounded-pill fw-semibold" style="background: #f0fdfa; color: #10b981; font-size: 0.6rem;"><?php echo t('Disetujui', 'Approved'); ?></span><?php else: ?><span class="px-2 py-1 rounded-pill fw-semibold" style="background: #fef2f2; color: #f43f5e; font-size: 0.6rem;"><?php echo t('Ditolak', 'Rejected'); ?></span><?php endif; ?></td>
                                <td style="border-color: #f0eeeb; padding: 0.65rem 1rem; color: #a8a29e; font-size: 0.72rem;"><?php echo date('d M Y H:i', strtotime($tx->created_at)); ?></td>
                                <td style="border-color: #f0eeeb; padding: 0.65rem 1rem; text-align: center;"><?php if ($tx->status === 'pending'): ?><div class="d-flex gap-1 justify-content-center"><a href="<?php echo base_url('admin/approve_transaction/' . $tx->id); ?>" class="btn btn-sm rounded-pill px-2 d-inline-flex align-items-center" style="background: #f0fdfa; color: #10b981; font-size: 0.68rem;" data-confirm="<?php echo t('Setujui transaksi ini?', 'Approve this transaction?'); ?>"><i class="fas fa-check" style="font-size: 0.65rem;"></i></a><a href="<?php echo base_url('admin/reject_transaction/' . $tx->id); ?>" class="btn btn-sm rounded-pill px-2 d-inline-flex align-items-center" style="border: 1px solid #fca5a5; color: #f43f5e; font-size: 0.68rem;" data-confirm="<?php echo t('Tolak transaksi ini?', 'Reject this transaction?'); ?>"><i class="fas fa-times" style="font-size: 0.65rem;"></i></a></div><?php else: ?><span style="color: #a8a29e; font-size: 0.72rem;">-</span><?php endif; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>
