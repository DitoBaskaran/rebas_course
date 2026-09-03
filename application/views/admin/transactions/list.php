<div class="container-fluid px-0">

    <!-- ============ HEADER (hero) ============ -->
    <?php
        $total_tx = count($transactions);
        $pending_n = 0; $approved_n = 0; $rejected_n = 0; $approved_rev = 0;
        foreach ($transactions as $tx) {
            if ($tx->status === 'pending') $pending_n++;
            elseif ($tx->status === 'approved') { $approved_n++; $approved_rev += (float)$tx->amount; }
            else $rejected_n++;
        }
    ?>
    <div class="bento-card mb-4 overflow-hidden" style="background:linear-gradient(120deg,#0D1830 0%,#164e63 100%);border:none;color:#fff;">
        <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3 position-relative" style="z-index:1;">
            <div>
                <span class="d-inline-flex align-items-center gap-1" style="background:rgba(255,255,255,0.14);border:1px solid rgba(255,255,255,0.2);color:#FBBF24;font-size:0.66rem;font-weight:800;letter-spacing:0.12em;text-transform:uppercase;padding:0.3rem 0.7rem;border-radius:100px;">
                    <i data-lucide="receipt" style="width:12px;height:12px;"></i>
                    <?php echo t('Keuangan', 'Finance'); ?>
                </span>
                <h1 class="fw-extrabold text-white mb-1 mt-2 lh-sm" style="letter-spacing:-0.03em;font-size:1.6rem;">
                    <?php echo t('Transaksi', 'Transactions'); ?>
                </h1>
                <p class="mb-0" style="color:rgba(255,255,255,0.72);font-size:0.82rem;">
                    <?php echo t('Kelola semua transaksi pembelian.', 'Manage all purchase transactions.'); ?>
                    <span class="fw-semibold text-white">(<?php echo $total_tx; ?>)</span>
                </p>
            </div>
            <?php if ($pending_n > 0): ?>
            <span class="d-inline-flex align-items-center gap-2 px-3 py-2 rounded-pill fw-semibold flex-shrink-0" style="background:#FBBF24;color:#0D1830;font-size:0.78rem;">
                <i data-lucide="clock" style="width:14px;height:14px;"></i> <?php echo $pending_n; ?> <?php echo t('menunggu verifikasi', 'awaiting review'); ?>
            </span>
            <?php endif; ?>
        </div>
    </div>

    <!-- ============ KPI ============ -->
    <div class="bento-grid bento-grid-4 mb-4">
        <div class="bento-card blob-primary">
            <div class="d-flex align-items-center gap-3">
                <div class="bento-icon bg-primary-subtle text-primary"><i data-lucide="receipt" style="width:22px;height:22px;"></i></div>
                <div>
                    <div class="bento-label"><?php echo t('Total Transaksi', 'Total Transactions'); ?></div>
                    <div class="bento-value"><?php echo $total_tx; ?></div>
                </div>
            </div>
        </div>
        <div class="bento-card blob-warning">
            <div class="d-flex align-items-center gap-3">
                <div class="bento-icon bg-warning-subtle text-warning"><i data-lucide="clock" style="width:22px;height:22px;"></i></div>
                <div>
                    <div class="bento-label"><?php echo t('Pending', 'Pending'); ?></div>
                    <div class="bento-value"><?php echo $pending_n; ?></div>
                </div>
            </div>
        </div>
        <div class="bento-card blob-success">
            <div class="d-flex align-items-center gap-3">
                <div class="bento-icon bg-success-subtle text-success"><i data-lucide="check-circle" style="width:22px;height:22px;"></i></div>
                <div>
                    <div class="bento-label"><?php echo t('Disetujui', 'Approved'); ?></div>
                    <div class="bento-value"><?php echo $approved_n; ?></div>
                </div>
            </div>
        </div>
        <div class="bento-card blob-success">
            <div class="d-flex align-items-center gap-3">
                <div class="bento-icon bg-success-subtle text-success"><i data-lucide="wallet" style="width:22px;height:22px;"></i></div>
                <div>
                    <div class="bento-label"><?php echo t('Revenue Disetujui', 'Approved Revenue'); ?></div>
                    <div class="bento-value" style="font-size:1.25rem;">Rp <?php echo number_format($approved_rev, 0, ',', '.'); ?></div>
                </div>
            </div>
        </div>
    </div>

    <?php $item_labels = array('course' => t('Kursus', 'Course'), 'seminar' => t('Seminar', 'Seminar'), 'workshop' => t('Workshop', 'Workshop'), 'bootcamp' => t('Bootcamp', 'Bootcamp'), 'ebook' => t('E-Book', 'E-Book'), 'project' => t('Proyek', 'Project'), 'mentoring' => t('Mentoring', 'Mentoring'), 'package' => t('Paket', 'Package'), 'package_6mo' => t('Paket 6 Bln', 'Package 6mo'), 'mentoring_package' => t('Paket Mentoring', 'Mentoring Package')); ?>

    <?php if (empty($transactions)): ?>
        <div class="bento-card p-5 text-center">
            <div class="mx-auto d-inline-flex align-items-center justify-content-center rounded-circle mb-3" style="width:72px;height:72px;background:#fff7ed;color:#c2410c;">
                <i data-lucide="receipt" style="width:30px;height:30px;"></i>
            </div>
            <h5 class="fw-extrabold text-dark mb-1"><?php echo t('Belum ada transaksi.', 'No transactions yet.'); ?></h5>
            <p class="text-secondary small mb-0"><?php echo t('Transaksi akan tampil di sini setelah ada pembelian.', 'Transactions will appear here after purchases.'); ?></p>
        </div>
    <?php else: ?>

        <!-- ============ TOOLBAR ============ -->
        <div class="bento-card d-flex flex-column flex-md-row gap-2 mb-4" style="padding:0.8rem 1rem;">
            <div class="flex-fill position-relative">
                <i data-lucide="search" style="width:15px;height:15px;position:absolute;left:0.9rem;top:50%;transform:translateY(-50%);color:var(--gray-400,#94a3b8);"></i>
                <input type="text" class="form-control" style="padding-left:2.3rem;border-radius:100px;font-size:0.82rem;" placeholder="<?php echo t('Cari nama, kode transaksi...', 'Search name, transaction code...'); ?>" id="searchInput" onkeyup="filterTx()">
            </div>
            <select class="form-select" style="max-width:180px;border-radius:100px;font-size:0.82rem;" onchange="filterTx()" id="statusFilter">
                <option value=""><?php echo t('Semua Status', 'All Status'); ?></option>
                <option value="pending"><?php echo t('Pending', 'Pending'); ?></option>
                <option value="approved"><?php echo t('Disetujui', 'Approved'); ?></option>
                <option value="rejected"><?php echo t('Ditolak', 'Rejected'); ?></option>
            </select>
        </div>

        <!-- ============ TRANSACTION LIST ============ -->
        <div class="bento-card p-0">
            <div id="txList">
                <?php foreach ($transactions as $tx): ?>
                    <?php
                        $item_name = ucfirst($tx->item_type) . ' #' . $tx->item_id;
                        if ($tx->item_type === 'package' || $tx->item_type === 'package_6mo') {
                            $pkg = $this->db->get_where('packages', array('id' => $tx->item_id))->row();
                            $item_name = $pkg ? $pkg->name : $item_name;
                        } elseif (in_array($tx->item_type, ['course', 'workshop', 'bootcamp', 'ebook', 'project', 'mentoring_package'])) {
                            $table = $tx->item_type === 'mentoring_package' ? 'mentoring_packages' : 'courses';
                            $pkg = $this->db->get_where($table, array('id' => $tx->item_id))->row();
                            $item_name = $pkg ? ($pkg->name ?? $pkg->title) : $item_name;
                        }
                        $coupon_code = null;
                        if ($tx->coupon_id) {
                            $coupon = $this->db->get_where('coupons', array('id' => $tx->coupon_id))->row();
                            $coupon_code = $coupon ? $coupon->code : '#' . $tx->coupon_id;
                        }
                        if ($tx->status === 'pending') { $st_bg='#fffbeb'; $st_tx='#d97706'; $st_label=t('Pending','Pending'); }
                        elseif ($tx->status === 'approved') { $st_bg='#E0F2F1'; $st_tx='#009688'; $st_label=t('Disetujui','Approved'); }
                        else { $st_bg='#fef2f2'; $st_tx='#dc2626'; $st_label=t('Ditolak','Rejected'); }
                        $search_blob = strtolower(htmlspecialchars($tx->user_name . ' ' . $tx->uuid . ' ' . $item_name));
                    ?>
                    <div class="tx-row" data-status="<?php echo $tx->status; ?>" data-search="<?php echo $search_blob; ?>" style="display:flex;align-items:center;gap:0.9rem;padding:0.9rem 1.25rem;border-bottom:1px solid var(--card-border,#eef0f3);">
                        <span class="d-inline-flex align-items-center justify-content-center rounded-circle fw-bold text-white flex-shrink-0" style="width:38px;height:38px;background:<?php echo $st_tx; ?>;font-size:0.85rem;">
                            <?php echo strtoupper(substr($tx->user_name, 0, 1)); ?>
                        </span>
                        <div class="flex-fill" style="min-width:0;">
                            <div class="d-flex align-items-center gap-2 flex-wrap">
                                <span class="fw-bold text-dark" style="font-size:0.85rem;"><?php echo htmlspecialchars($tx->user_name); ?></span>
                                <span class="text-muted" style="font-family:monospace;font-size:0.68rem;">BT-<?php echo $tx->uuid; ?></span>
                            </div>
                            <div class="text-secondary text-truncate" style="font-size:0.75rem;">
                                <?php echo htmlspecialchars($item_name); ?>
                                <span class="px-2 py-0 rounded-pill fw-semibold ms-1" style="background:#E6EBEF;color:#57534e;font-size:0.6rem;"><?php echo $item_labels[$tx->item_type] ?? ucfirst($tx->item_type); ?></span>
                                <?php if ($coupon_code): ?><span class="px-2 py-0 rounded-pill fw-semibold ms-1" style="background:#f0fdfa;color:#0d9488;font-size:0.6rem;"><i class="fas fa-tag" style="font-size:0.55rem;"></i> <?php echo htmlspecialchars($coupon_code); ?></span><?php endif; ?>
                            </div>
                            <div class="text-muted" style="font-size:0.66rem;"><?php echo date('d M Y, H:i', strtotime($tx->created_at)); ?></div>
                        </div>
                        <div class="text-end flex-shrink-0" style="min-width:110px;">
                            <div class="fw-extrabold text-dark" style="font-size:0.9rem;">Rp <?php echo number_format($tx->amount, 0, ',', '.'); ?></div>
                            <?php if ($tx->discount_amount > 0): ?>
                                <div style="color:#009688;font-size:0.65rem;">-Rp <?php echo number_format($tx->discount_amount, 0, ',', '.'); ?></div>
                            <?php endif; ?>
                        </div>
                        <div class="flex-shrink-0" style="min-width:90px;">
                            <span class="px-2 py-1 rounded-pill fw-semibold d-inline-block" style="background:<?php echo $st_bg; ?>;color:<?php echo $st_tx; ?>;font-size:0.65rem;"><?php echo $st_label; ?></span>
                        </div>
                        <div class="flex-shrink-0" style="width:76px;text-align:right;">
                            <?php if ($tx->status === 'pending'): ?>
                                <div class="d-flex gap-1 justify-content-end">
                                    <a href="<?php echo base_url('admin/approve_transaction/' . $tx->id); ?>" class="btn btn-sm rounded-pill px-2 fw-semibold d-inline-flex align-items-center" style="background:#E0F2F1;color:#009688;font-size:0.68rem;" data-confirm="<?php echo t('Setujui transaksi ini?', 'Approve this transaction?'); ?>" data-confirm-button="<?php echo t('Ya, Setujui', 'Yes, Approve'); ?>" data-icon="question" title="<?php echo t('Setujui', 'Approve'); ?>"><i class="fas fa-check"></i></a>
                                    <a href="<?php echo base_url('admin/reject_transaction/' . $tx->id); ?>" class="btn btn-sm rounded-pill px-2 fw-semibold d-inline-flex align-items-center" style="border:1px solid #fca5a5;color:#f43f5e;font-size:0.68rem;" data-confirm="<?php echo t('Tolak transaksi ini?', 'Reject this transaction?'); ?>" data-confirm-button="<?php echo t('Ya, Tolak', 'Yes, Reject'); ?>" data-icon="warning" title="<?php echo t('Tolak', 'Reject'); ?>"><i class="fas fa-times"></i></a>
                                </div>
                            <?php else: ?>
                                <span style="color:#cbd5e1;font-size:0.72rem;">—</span>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="text-center py-4" id="noTxMsg" style="display:none;">
                <span class="text-muted small"><?php echo t('Tidak ada transaksi yang cocok.', 'No matching transactions.'); ?></span>
            </div>
        </div>
    <?php endif; ?>
</div>
<script>
function filterTx() {
    var q = (document.getElementById('searchInput')?.value || '').toLowerCase();
    var st = document.getElementById('statusFilter')?.value || '';
    var visible = 0;
    document.querySelectorAll('#txList .tx-row').forEach(function(row) {
        var text = row.getAttribute('data-search') || '';
        var status = row.getAttribute('data-status') || '';
        var match = text.indexOf(q) !== -1 && (!st || status === st);
        row.style.display = match ? '' : 'none';
        if (match) visible++;
    });
    var msg = document.getElementById('noTxMsg');
    if (msg) msg.style.display = visible === 0 ? 'block' : 'none';
}
</script>
