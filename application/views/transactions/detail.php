<div>
    <div class="mb-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb small mb-0">
                <li class="breadcrumb-item"><a href="<?php echo base_url('dashboard'); ?>" class="text-decoration-none"><?php echo t('Dashboard', 'Dashboard'); ?></a></li>
                <li class="breadcrumb-item"><a href="<?php echo base_url('transactions/history'); ?>" class="text-decoration-none"><?php echo t('Riwayat Transaksi', 'Transaction History'); ?></a></li>
                <li class="breadcrumb-item active fw-medium text-dark">#<?php echo $transaction->uuid; ?></li>
            </ol>
        </nav>
    </div>

    <div class="card-modern p-4 p-md-5 mb-4">
        <div class="d-flex align-items-center gap-3 mb-3">
            <div class="d-flex align-items-center justify-content-center rounded-2 flex-shrink-0" style="width:48px;height:48px;background:var(--primary-light);color:var(--primary);">
                <i class="fas fa-receipt fa-lg"></i>
            </div>
            <div>
                <h5 class="fw-bold text-dark mb-0"><?php echo t('Detail Transaksi', 'Transaction Detail'); ?></h5>
                <small class="text-secondary">#<?php echo $transaction->uuid; ?></small>
            </div>
        </div>

        <div class="d-flex flex-column gap-3">
            <div class="d-flex justify-content-between align-items-center p-3 bg-light rounded-3">
                <div>
                    <div class="fw-semibold text-dark small"><?php echo ucfirst($transaction->item_type); ?></div>
                    <div class="text-secondary small"><?php echo date('d M Y H:i', strtotime($transaction->created_at)); ?></div>
                </div>
                <div class="text-end">
                    <div class="fw-bold text-dark">Rp <?php echo number_format($transaction->amount, 0, ',', '.'); ?></div>
                    <?php if ($transaction->status === 'approved'): ?>
                        <span class="badge bg-success rounded-pill px-3 py-1 fw-medium"><?php echo t('Berhasil', 'Success'); ?></span>
                    <?php elseif ($transaction->status === 'pending'): ?>
                        <span class="badge bg-warning text-dark rounded-pill px-3 py-1 fw-medium"><?php echo t('Menunggu', 'Pending'); ?></span>
                    <?php else: ?>
                        <span class="badge bg-danger rounded-pill px-3 py-1 fw-medium"><?php echo t('Ditolak', 'Rejected'); ?></span>
                    <?php endif; ?>
                </div>
            </div>

            <?php if ($item): ?>
            <div class="p-3 bg-light rounded-3">
                <div class="fw-semibold text-dark small mb-2"><?php echo t('Item Pembelian', 'Purchased Item'); ?></div>
                <div class="d-flex align-items-center gap-3">
                    <?php if (!empty($item->thumbnail) && $item->thumbnail !== 'default_course.png'): ?>
                    <img src="<?php echo base_url('uploads/courses/' . $item->thumbnail); ?>" onerror="this.src='https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=100&auto=format&fit=crop&q=60';" alt="" class="rounded-2 object-fit-cover flex-shrink-0" style="width:56px;height:40px;">
                    <?php else: ?>
                    <div class="d-flex align-items-center justify-content-center rounded-2 flex-shrink-0" style="width:56px;height:40px;background:var(--primary-light);color:var(--primary);">
                        <i class="fas fa-book-open"></i>
                    </div>
                    <?php endif; ?>
                    <div class="flex-fill min-w-0">
                        <div class="fw-bold text-dark small"><?php echo htmlspecialchars($item->title); ?></div>
                        <div class="text-secondary small"><?php echo ucfirst($transaction->item_type); ?></div>
                    </div>
                </div>
            </div>
            <?php endif; ?>

            <div class="p-3 bg-light rounded-3">
                <div class="fw-semibold text-dark small mb-2"><?php echo t('Informasi Pembayaran', 'Payment Info'); ?></div>
                <div class="d-flex flex-column gap-2 small">
                    <div class="d-flex justify-content-between"><span class="text-secondary"><?php echo t('Metode', 'Method'); ?></span><span class="fw-semibold text-dark"><?php echo $transaction->payment_method ? strtoupper(str_replace('_', ' ', $transaction->payment_method)) : '-'; ?></span></div>
                    <?php if ($transaction->payment_channel): ?>
                    <div class="d-flex justify-content-between"><span class="text-secondary"><?php echo t('Channel', 'Channel'); ?></span><span class="fw-semibold text-dark"><?php echo $transaction->payment_channel; ?></span></div>
                    <?php endif; ?>
                    <?php if ($transaction->gateway_tx_id): ?>
                    <div class="d-flex justify-content-between"><span class="text-secondary"><?php echo t('ID Transaksi Gateway', 'Gateway Tx ID'); ?></span><span class="fw-semibold text-dark font-monospace" style="font-size:0.75rem;"><?php echo $transaction->gateway_tx_id; ?></span></div>
                    <?php endif; ?>
                    <?php if ($transaction->payment_proof): ?>
                    <div class="d-flex justify-content-between"><span class="text-secondary"><?php echo t('Bukti Bayar', 'Proof'); ?></span><a href="<?php echo base_url('uploads/proofs/' . $transaction->payment_proof); ?>" target="_blank" class="fw-semibold text-primary text-decoration-none small"><?php echo t('Lihat', 'View'); ?></a></div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Payment action for pending transactions -->
            <?php if ($transaction->status === 'pending'): ?>
            <div class="p-3 bg-warning-subtle border border-warning rounded-3">
                <div class="d-flex align-items-center gap-2 mb-2">
                    <i class="fas fa-info-circle text-warning"></i>
                    <span class="fw-semibold text-dark small"><?php echo t('Pembayaran Menunggu', 'Payment Pending'); ?></span>
                </div>
                <p class="text-dark small mb-3"><?php echo t('Transaksi ini belum dibayar. Silakan lengkapi pembayaran untuk mengakses konten.', 'This transaction is waiting for payment. Please complete the payment to access the content.'); ?></p>
                <a href="<?php echo base_url('checkout/confirm/' . $transaction->uuid); ?>" class="btn btn-dark rounded-pill px-4 py-2 fw-semibold d-inline-flex align-items-center gap-2">
                    <i class="fas fa-credit-card"></i> <?php echo t('Bayar Sekarang', 'Pay Now'); ?>
                </a>
            </div>
            <?php endif; ?>

            <?php if ($transaction->status === 'rejected'): ?>
            <div class="p-3 bg-danger-subtle border border-danger rounded-3">
                <div class="d-flex align-items-center gap-2 mb-2">
                    <i class="fas fa-exclamation-triangle text-danger"></i>
                    <span class="fw-semibold text-dark small"><?php echo t('Transaksi Ditolak', 'Transaction Rejected'); ?></span>
                </div>
                <p class="text-dark small mb-2"><?php echo t('Transaksi ini ditolak. Silakan hubungi admin jika ada pertanyaan.', 'This transaction was rejected. Please contact admin if you have questions.'); ?></p>
                <a href="<?php echo base_url('courses'); ?>" class="btn btn-outline-danger rounded-pill px-4 py-2 fw-semibold"><?php echo t('Kembali Ke Katalog', 'Back to Catalog'); ?></a>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>