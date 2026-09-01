<div class="app-page">
    <!-- Header -->
    <div class="app-page-head">
        <div>
            <h4 class="app-page-title"><i class="fas fa-receipt"></i> <?php echo t('Transaksi', 'Transactions'); ?></h4>
            <p class="app-page-sub"><?php echo t('Kelola semua transaksi pembelian.', 'Manage all purchase transactions.'); ?></p>
        </div>
    </div>

    <?php $item_labels = array('course' => t('Kursus', 'Course'), 'seminar' => t('Seminar', 'Seminar'), 'workshop' => t('Workshop', 'Workshop'), 'bootcamp' => t('Bootcamp', 'Bootcamp'), 'ebook' => t('E-Book', 'E-Book'), 'project' => t('Proyek', 'Project'), 'mentoring' => t('Mentoring', 'Mentoring'), 'package' => t('Paket', 'Package'), 'package_6mo' => t('Paket 6 Bln', 'Package 6mo'), 'mentoring_package' => t('Paket Mentoring', 'Mentoring Package')); ?>
    <div class="app-card">
        <?php if (empty($transactions)): ?>
            <div class="app-empty">
                <i class="fas fa-receipt"></i>
                <h6><?php echo t('Belum ada transaksi.', 'No transactions yet.'); ?></h6>
                <p><?php echo t('Transaksi akan tampil di sini setelah ada pembelian.', 'Transactions will appear here after purchases.'); ?></p>
            </div>
        <?php else: ?>
            <div class="app-table-wrap">
                <table class="app-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th><?php echo t('Pengguna', 'User'); ?></th>
                            <th><?php echo t('Item', 'Item'); ?></th>
                            <th><?php echo t('Tipe', 'Type'); ?></th>
                            <th><?php echo t('Jumlah', 'Amount'); ?></th>
                            <th><?php echo t('Kupon', 'Coupon'); ?></th>
                            <th><?php echo t('Status', 'Status'); ?></th>
                            <th><?php echo t('Tanggal', 'Date'); ?></th>
                            <th class="td-actions"><?php echo t('Aksi', 'Action'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($transactions as $tx): ?>
                            <tr>
                                <td style="font-family:monospace;font-size:0.72rem;color:#0D1830;" class="td-title">BT-<?php echo $tx->uuid; ?></td>
                                <td class="td-title"><?php echo htmlspecialchars($tx->user_name); ?></td>
                                <td style="color:#57534e;font-size:0.78rem;">
                                    <?php $item_name = ucfirst($tx->item_type) . ' #' . $tx->item_id; if ($tx->item_type === 'package' || $tx->item_type === 'package_6mo') { $pkg = $this->db->get_where('packages', array('id' => $tx->item_id))->row(); $item_name = $pkg ? $pkg->name : $item_name; } elseif (in_array($tx->item_type, ['course', 'workshop', 'bootcamp', 'ebook', 'project', 'mentoring_package'])) { $table = $tx->item_type === 'mentoring_package' ? 'mentoring_packages' : 'courses'; $pkg = $this->db->get_where($table, array('id' => $tx->item_id))->row(); $item_name = $pkg ? ($pkg->name ?? $pkg->title) : $item_name; } echo htmlspecialchars($item_name); ?>
                                </td>
                                <td><span class="app-chip app-chip-gray"><?php echo $item_labels[$tx->item_type] ?? ucfirst($tx->item_type); ?></span></td>
                                <td class="td-title">Rp <?php echo number_format($tx->amount, 0, ',', '.'); ?><?php if ($tx->discount_amount > 0): ?><br><small style="color:#009688;font-size:0.65rem;">(-Rp <?php echo number_format($tx->discount_amount, 0, ',', '.'); ?>)</small><?php endif; ?></td>
                                <td><?php if ($tx->coupon_id): $coupon = $this->db->get_where('coupons', array('id' => $tx->coupon_id))->row(); ?><span class="app-chip app-chip-teal"><?php echo $coupon ? htmlspecialchars($coupon->code) : '#' . $tx->coupon_id; ?></span><?php else: ?><span style="color:#a8a29e;font-size:0.72rem;">-</span><?php endif; ?></td>
                                <td>
                                    <?php if ($tx->status === 'pending'): ?><span class="app-chip app-chip-amber"><?php echo t('Pending', 'Pending'); ?></span>
                                    <?php elseif ($tx->status === 'approved'): ?><span class="app-chip app-chip-green"><?php echo t('Disetujui', 'Approved'); ?></span>
                                    <?php else: ?><span class="app-chip app-chip-red"><?php echo t('Ditolak', 'Rejected'); ?></span><?php endif; ?>
                                </td>
                                <td style="color:#a8a29e;font-size:0.72rem;"><?php echo date('d M Y H:i', strtotime($tx->created_at)); ?></td>
                                <td class="td-actions">
                                    <?php if ($tx->status === 'pending'): ?>
                                        <div class="d-flex gap-1 justify-content-end">
                                            <a href="<?php echo base_url('admin/approve_transaction/' . $tx->id); ?>" class="app-action app-action-green" data-confirm="<?php echo t('Setujui transaksi ini?', 'Approve this transaction?'); ?>" title="<?php echo t('Setujui', 'Approve'); ?>"><i class="fas fa-check"></i></a>
                                            <a href="<?php echo base_url('admin/reject_transaction/' . $tx->id); ?>" class="app-action app-action-red" data-confirm="<?php echo t('Tolak transaksi ini?', 'Reject this transaction?'); ?>" title="<?php echo t('Tolak', 'Reject'); ?>"><i class="fas fa-times"></i></a>
                                        </div>
                                    <?php else: ?>
                                        <span style="color:#a8a29e;font-size:0.72rem;">-</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>
