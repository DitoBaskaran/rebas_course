<div class="container-fluid py-4" style="padding-top: 86px !important; max-width: 960px;">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-3" style="font-size: 0.8rem;">
        <ol class="breadcrumb" style="background: none; padding: 0;">
            <li class="breadcrumb-item"><a href="<?php echo base_url('dashboard'); ?>" style="color: #78716c; text-decoration: none; font-weight: 500;"><?php echo t('Dashboard', 'Dashboard'); ?></a></li>
            <li class="breadcrumb-item"><a href="<?php echo base_url('transactions/history'); ?>" style="color: #78716c; text-decoration: none; font-weight: 500;"><?php echo t('Riwayat', 'History'); ?></a></li>
            <li class="breadcrumb-item active" style="color: #0D1830; font-weight: 600;">BT-<?php echo $transaction->uuid; ?></li>
        </ol>
    </nav>

    <!-- Status Banner -->
    <div class="border rounded-3 p-4 mb-4" style="border-color: #e7e5e4; border-radius: 12px;">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
            <div class="d-flex align-items-center gap-3">
                <div class="d-flex align-items-center justify-content-center rounded-2 flex-shrink-0" style="width: 44px; height: 44px; background: #E0F2F1;">
                    <i class="fas fa-receipt" style="color: #009688; font-size: 1rem;"></i>
                </div>
                <div>
                    <h5 class="fw-bold mb-0" style="color: #0D1830; font-size: 1rem;">
                        <?php echo t('Detail Transaksi', 'Transaction Detail'); ?>
                    </h5>
                    <small style="color: #a8a29e; font-size: 0.72rem; font-family: monospace;">BT-<?php echo $transaction->uuid; ?></small>
                </div>
            </div>
            <div>
                <?php if ($transaction->status === 'approved'): ?>
                    <span class="px-3 py-2 rounded-pill fw-semibold d-inline-flex align-items-center" style="background: #E0F2F1; color: #009688; font-size: 0.75rem;">
                        <i class="fas fa-check-circle me-1"></i> <?php echo t('Berhasil', 'Success'); ?>
                    </span>
                <?php elseif ($transaction->status === 'pending'): ?>
                    <span class="px-3 py-2 rounded-pill fw-semibold d-inline-flex align-items-center" style="background: #E0F2F1; color: #009688; font-size: 0.75rem;">
                        <i class="fas fa-clock me-1"></i> <?php echo t('Menunggu', 'Pending'); ?>
                    </span>
                <?php else: ?>
                    <span class="px-3 py-2 rounded-pill fw-semibold d-inline-flex align-items-center" style="background: #fef2f2; color: #009688; font-size: 0.75rem;">
                        <i class="fas fa-times-circle me-1"></i> <?php echo t('Ditolak', 'Rejected'); ?>
                    </span>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Detail Grid -->
    <div class="row g-3 mb-4">
        <div class="col-md-6">
            <div class="border rounded-3 p-3 h-100" style="border-color: #e7e5e4; border-radius: 12px;">
                <h6 class="fw-bold mb-2" style="color: #0D1830; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.05em;">
                    <?php echo t('Informasi Transaksi', 'Transaction Info'); ?>
                </h6>
                <div class="d-flex flex-column gap-2" style="font-size: 0.8rem;">
                    <div class="d-flex justify-content-between">
                        <span style="color: #78716c;"><?php echo t('Tipe', 'Type'); ?></span>
                        <span class="px-2 py-1 rounded-pill fw-semibold" style="background: #E6EBEF; color: #57534e; font-size: 0.65rem; text-transform: uppercase;">
                            <?php echo $transaction->item_type; ?>
                        </span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span style="color: #78716c;"><?php echo t('Tanggal', 'Date'); ?></span>
                        <span class="fw-semibold" style="color: #0D1830;"><?php echo date('d M Y H:i', strtotime($transaction->created_at)); ?></span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span style="color: #78716c;"><?php echo t('Nominal', 'Amount'); ?></span>
                        <span class="fw-bold" style="color: #0D1830; font-size: 1rem;">
                            Rp <?php echo number_format($transaction->amount, 0, ',', '.'); ?>
                        </span>
                    </div>
                    <?php if ($transaction->discount_amount > 0): ?>
                    <div class="d-flex justify-content-between">
                        <span style="color: #78716c;"><?php echo t('Diskon', 'Discount'); ?></span>
                        <span class="fw-semibold" style="color: #009688;">- Rp <?php echo number_format($transaction->discount_amount, 0, ',', '.'); ?></span>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="border rounded-3 p-3 h-100" style="border-color: #e7e5e4; border-radius: 12px;">
                <h6 class="fw-bold mb-2" style="color: #0D1830; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.05em;">
                    <?php echo t('Informasi Pembayaran', 'Payment Info'); ?>
                </h6>
                <div class="d-flex flex-column gap-2" style="font-size: 0.8rem;">
                    <div class="d-flex justify-content-between">
                        <span style="color: #78716c;"><?php echo t('Metode', 'Method'); ?></span>
                        <span class="fw-semibold" style="color: #0D1830;">
                            <?php echo $transaction->payment_method ? strtoupper(str_replace('_', ' ', $transaction->payment_method)) : '-'; ?>
                        </span>
                    </div>
                    <?php if ($transaction->payment_channel): ?>
                    <div class="d-flex justify-content-between">
                        <span style="color: #78716c;"><?php echo t('Channel', 'Channel'); ?></span>
                        <span class="fw-semibold" style="color: #0D1830;"><?php echo $transaction->payment_channel; ?></span>
                    </div>
                    <?php endif; ?>
                    <?php if ($transaction->gateway_tx_id): ?>
                    <div class="d-flex justify-content-between">
                        <span style="color: #78716c;"><?php echo t('ID Gateway', 'Gateway ID'); ?></span>
                        <span class="fw-semibold" style="color: #0D1830; font-family: monospace; font-size: 0.72rem;">
                            <?php echo $transaction->gateway_tx_id; ?>
                        </span>
                    </div>
                    <?php endif; ?>
                    <?php if ($transaction->payment_proof): ?>
                    <div class="d-flex justify-content-between">
                        <span style="color: #78716c;"><?php echo t('Bukti Bayar', 'Proof'); ?></span>
                        <a href="<?php echo base_url('uploads/proofs/' . $transaction->payment_proof); ?>" target="_blank" class="fw-semibold" style="color: #009688; text-decoration: none; font-size: 0.78rem;">
                            <i class="fas fa-external-link-alt me-1"></i> <?php echo t('Lihat', 'View'); ?>
                        </a>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Item Detail -->
    <?php if ($item): ?>
    <div class="border rounded-3 p-3 mb-4" style="border-color: #e7e5e4; border-radius: 12px;">
        <h6 class="fw-bold mb-2" style="color: #0D1830; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.05em;">
            <?php echo t('Item Pembelian', 'Purchased Item'); ?>
        </h6>
        <div class="d-flex align-items-center gap-3">
            <?php if (!empty($item->thumbnail) && $item->thumbnail !== 'default_course.png'): ?>
                <img src="<?php echo base_url('uploads/courses/' . $item->thumbnail); ?>" onerror="this.src='https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=80&auto=format&fit=crop&q=60';" alt="" class="rounded-2 flex-shrink-0" style="width: 60px; height: 44px; object-fit: cover; border: 1px solid #e7e5e4;">
            <?php else: ?>
                <div class="d-flex align-items-center justify-content-center rounded-2 flex-shrink-0" style="width: 60px; height: 44px; background: #E0F2F1;">
                    <i class="fas fa-book-open" style="color: #009688; font-size: 0.85rem;"></i>
                </div>
            <?php endif; ?>
            <div class="flex-fill min-w-0">
                <div class="fw-bold" style="color: #0D1830; font-size: 0.85rem;">
                    <?php echo htmlspecialchars($item->title ?? $item->topic ?? $item->topic_en ?? ''); ?>
                </div>
                <div style="color: #78716c; font-size: 0.72rem;">
                    <?php echo ucfirst($transaction->item_type); ?>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <!-- Pending Payment -->
    <?php if ($transaction->status === 'pending'): ?>
    <div class="border rounded-3 p-3 mb-4" style="border-color: #009688; background: #E0F2F1; border-radius: 12px;">
        <div class="d-flex align-items-center gap-2 mb-2">
            <i class="fas fa-clock" style="color: #009688; font-size: 0.8rem;"></i>
            <span class="fw-bold" style="color: #0D1830; font-size: 0.85rem;"><?php echo t('Pembayaran Menunggu', 'Payment Pending'); ?></span>
        </div>
        <p style="color: #57534e; font-size: 0.8rem; margin-bottom: 0.75rem;">
            <?php echo t('Transaksi ini belum dibayar. Silakan lengkapi pembayaran untuk mengakses konten.', 'This transaction is waiting for payment. Please complete the payment to access the content.'); ?>
        </p>
        <?php
            $allowed_methods = array('qris','bri_va','bni_va','cimb_niaga_va','maybank_va','permata_va','atm_bersama_va','sampoerna_va','bnc_va','artha_graha_va');
            $pay_url = (in_array($transaction->payment_channel, $allowed_methods) && !empty($transaction->payment_channel))
                ? base_url('checkout/pay/' . $transaction->uuid . '?method=' . $transaction->payment_channel)
                : base_url('checkout/confirm/' . $transaction->uuid);
        ?>
        <a href="<?php echo $pay_url; ?>" class="btn px-4 py-2 fw-bold rounded-pill d-inline-flex align-items-center gap-2" style="background: #009688; color: #fff; font-size: 0.8rem;">
            <i class="fas fa-credit-card"></i> <?php echo t('Bayar Sekarang', 'Pay Now'); ?>
        </a>
    </div>
    <?php endif; ?>

    <!-- Rejected -->
    <?php if ($transaction->status === 'rejected'): ?>
    <div class="border rounded-3 p-3" style="border-color: #fca5a5; background: #fef2f2; border-radius: 12px;">
        <div class="d-flex align-items-center gap-2 mb-2">
            <i class="fas fa-exclamation-triangle" style="color: #009688; font-size: 0.8rem;"></i>
            <span class="fw-bold" style="color: #0D1830; font-size: 0.85rem;"><?php echo t('Transaksi Ditolak', 'Transaction Rejected'); ?></span>
        </div>
        <p style="color: #57534e; font-size: 0.8rem; margin-bottom: 0.75rem;">
            <?php echo t('Transaksi ini ditolak. Silakan hubungi admin jika ada pertanyaan.', 'This transaction was rejected. Please contact admin if you have questions.'); ?>
        </p>
        <a href="<?php echo base_url('courses'); ?>" class="btn px-4 py-2 fw-bold rounded-pill" style="border: 1.5px solid #009688; color: #009688; background: transparent; font-size: 0.8rem;">
            <i class="fas fa-arrow-left me-1"></i> <?php echo t('Kembali Ke Katalog', 'Back to Catalog'); ?>
        </a>
    </div>
    <?php endif; ?>
</div>
