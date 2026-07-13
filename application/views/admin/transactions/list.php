<div class="container-fluid px-0">
    <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between mb-5 gap-3">
        <div>
            <span class="text-primary fw-semibold small text-uppercase tracking-wide d-block mb-1">Keuangan</span>
            <h1 class="display-6 fw-extrabold text-dark mb-1 lh-sm" style="letter-spacing: -0.03em;"><?php echo t('Transaksi', 'Transactions'); ?></h1>
            <p class="text-secondary mb-0"><?php echo t('Kelola semua transaksi pembelian.', 'Manage all purchase transactions.'); ?></p>
        </div>
    </div>

    <div class="bento-card p-4 p-xl-5">
        <?php if (empty($transactions)): ?>
            <div class="empty-state">
                <i data-lucide="receipt" style="width:48px;height:48px;color:var(--gray-300);"></i>
                <h5><?php echo t('Belum ada transaksi.', 'No transactions yet.'); ?></h5>
            </div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table-modern">
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
                            <th class="text-center"><?php echo t('Aksi', 'Action'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $item_labels = array(
                            'course' => t('Kursus', 'Course'),
                            'seminar' => t('Seminar', 'Seminar'),
                            'workshop' => t('Workshop', 'Workshop'),
                            'bootcamp' => t('Bootcamp', 'Bootcamp'),
                            'ebook' => t('E-Book', 'E-Book'),
                            'project' => t('Proyek', 'Project'),
                            'mentoring' => t('Mentoring', 'Mentoring'),
                            'package' => t('Paket', 'Package'),
                            'package_6mo' => t('Paket 6 Bln', 'Package 6mo'),
                            'minute_bundle' => t('Bundel Menit', 'Minute Bundle'),
                        ); ?>
                        <?php foreach ($transactions as $tx): ?>
                            <tr>
                                <td class="font-monospace small">#<?php echo $tx->uuid; ?></td>
                                <td class="fw-semibold text-dark small"><?php echo htmlspecialchars($tx->user_name); ?></td>
                                <td class="small">
                                    <?php
                                    $item_name = ucfirst($tx->item_type) . ' #' . $tx->item_id;
                                    if ($tx->item_type === 'package' || $tx->item_type === 'package_6mo') {
                                        $pkg = $this->db->get_where('packages', array('id' => $tx->item_id))->row();
                                        $item_name = $pkg ? $pkg->name : $item_name;
                                    } elseif (in_array($tx->item_type, ['course', 'workshop', 'bootcamp', 'ebook', 'project'])) {
                                        $course = $this->db->get_where('courses', array('id' => $tx->item_id))->row();
                                        $item_name = $course ? $course->title : $item_name;
                                    } elseif ($tx->item_type === 'minute_bundle') {
                                        $bundle = $this->db->get_where('minute_bundles', array('id' => $tx->item_id))->row();
                                        $item_name = $bundle ? $bundle->name : $item_name;
                                    }
                                    echo htmlspecialchars($item_name);
                                    ?>
                                </td>
                                <td><span class="badge bg-secondary badge-modern"><?php echo $item_labels[$tx->item_type] ?? ucfirst($tx->item_type); ?></span></td>
                                <td class="fw-bold text-dark">
                                    Rp <?php echo number_format($tx->amount, 0, ',', '.'); ?>
                                    <?php if ($tx->discount_amount > 0): ?>
                                        <br><small class="text-success">(-Rp <?php echo number_format($tx->discount_amount, 0, ',', '.'); ?>)</small>
                                    <?php endif; ?>
                                </td>
                                <td class="small">
                                    <?php if ($tx->coupon_id): ?>
                                        <span class="badge bg-success badge-modern">
                                            <?php
                                            $coupon = $this->db->get_where('coupons', array('id' => $tx->coupon_id))->row();
                                            echo $coupon ? htmlspecialchars($coupon->code) : '#'.$tx->coupon_id;
                                            ?>
                                        </span>
                                    <?php else: ?>
                                        <span class="text-muted small">-</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if ($tx->status === 'pending'): ?>
                                        <span class="badge bg-warning text-dark badge-modern"><?php echo t('Pending', 'Pending'); ?></span>
                                    <?php elseif ($tx->status === 'approved'): ?>
                                        <span class="badge bg-success badge-modern"><?php echo t('Disetujui', 'Approved'); ?></span>
                                    <?php else: ?>
                                        <span class="badge bg-danger badge-modern"><?php echo t('Ditolak', 'Rejected'); ?></span>
                                    <?php endif; ?>
                                </td>
                                <td class="small text-muted"><?php echo date('d M Y H:i', strtotime($tx->created_at)); ?></td>
                                <td class="text-center">
                                    <?php if ($tx->status === 'pending'): ?>
                                        <div class="d-flex gap-1 justify-content-center">
                                            <a href="<?php echo base_url('admin/approve_transaction/' . $tx->id); ?>" class="btn btn-success btn-sm px-2" data-confirm="<?php echo t('Setujui transaksi ini?', 'Approve this transaction?'); ?>">
                                                <i data-lucide="check" style="width:14px;height:14px;"></i>
                                            </a>
                                            <a href="<?php echo base_url('admin/reject_transaction/' . $tx->id); ?>" class="btn btn-outline-danger btn-sm px-2" data-confirm="<?php echo t('Tolak transaksi ini?', 'Reject this transaction?'); ?>">
                                                <i data-lucide="x" style="width:14px;height:14px;"></i>
                                            </a>
                                        </div>
                                    <?php else: ?>
                                        <span class="text-muted small">-</span>
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
