<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Detail transaksi (panel student). Variabel: $transaction, $item.
 * Payment method map terpusat: logo asli + label rapi (bukan 'BRI_VA' mentah).
 */
function tx_payment_meta($channel) {
    $map = array(
        'qris'            => array('label' => 'QRIS', 'logo' => 'qris-logo.png', 'group' => t('QRIS', 'QRIS')),
        'bri_va'          => array('label' => 'BRI Virtual Account', 'logo' => 'bri-logo.svg', 'group' => t('Virtual Account', 'Virtual Account')),
        'bni_va'          => array('label' => 'BNI Virtual Account', 'logo' => 'bni-logo.svg', 'group' => t('Virtual Account', 'Virtual Account')),
        'cimb_niaga_va'   => array('label' => 'CIMB Niaga Virtual Account', 'logo' => 'cimb-logo.svg', 'group' => t('Virtual Account', 'Virtual Account')),
        'maybank_va'      => array('label' => 'Maybank Virtual Account', 'logo' => 'maybank-logo.svg', 'group' => t('Virtual Account', 'Virtual Account')),
        'permata_va'      => array('label' => 'Permata Virtual Account', 'logo' => 'permata-logo.png', 'group' => t('Virtual Account', 'Virtual Account')),
        'atm_bersama_va'  => array('label' => 'ATM Bersama Virtual Account', 'logo' => 'atm-bersama-logo.png', 'group' => t('Virtual Account', 'Virtual Account')),
        'sampoerna_va'    => array('label' => 'Sampoerna Virtual Account', 'logo' => '', 'group' => t('Virtual Account', 'Virtual Account')),
        'bnc_va'          => array('label' => 'BNC Virtual Account', 'logo' => '', 'group' => t('Virtual Account', 'Virtual Account')),
        'artha_graha_va'  => array('label' => 'Artha Graha Virtual Account', 'logo' => '', 'group' => t('Virtual Account', 'Virtual Account')),
    );
    if (empty($channel) || !isset($map[$channel])) return null;
    return $map[$channel];
}

$pm = tx_payment_meta($transaction->payment_channel);
$pm_fallback_label = $transaction->payment_method ? strtoupper(str_replace('_', ' ', $transaction->payment_method)) : ($transaction->payment_channel ? strtoupper(str_replace('_', ' ', $transaction->payment_channel)) : null);

if ($transaction->status === 'approved') { $tx_st = array('cls' => 'tx-st-ok', 'ic' => 'fa-circle-check', 'label' => t('Berhasil', 'Success')); }
elseif ($transaction->status === 'pending') { $tx_st = array('cls' => 'tx-st-pending', 'ic' => 'fa-clock', 'label' => t('Menunggu', 'Pending')); }
else { $tx_st = array('cls' => 'tx-st-rejected', 'ic' => 'fa-circle-xmark', 'label' => t('Ditolak', 'Rejected')); }

$allowed_methods = array('qris','bri_va','bni_va','cimb_niaga_va','maybank_va','permata_va','atm_bersama_va','sampoerna_va','bnc_va','artha_graha_va');
$pay_url = (in_array($transaction->payment_channel, $allowed_methods) && !empty($transaction->payment_channel))
    ? base_url('checkout/pay/' . $transaction->uuid . '?method=' . $transaction->payment_channel)
    : base_url('checkout/confirm/' . $transaction->uuid);
?>

<div class="tx-wrap">
    <!-- Breadcrumb -->
    <nav class="tx-breadcrumb" aria-label="breadcrumb">
        <a href="<?php echo base_url('dashboard'); ?>"><?php echo t('Dashboard', 'Dashboard'); ?></a>
        <i class="fas fa-chevron-right"></i>
        <a href="<?php echo base_url('transactions/history'); ?>"><?php echo t('Riwayat Transaksi', 'History'); ?></a>
        <i class="fas fa-chevron-right"></i>
        <span>BT-<?php echo htmlspecialchars($transaction->uuid); ?></span>
    </nav>

    <!-- Status Banner -->
    <div class="tx-banner <?php echo $tx_st['cls']; ?>">
        <div class="tx-banner-l">
            <span class="tx-banner-ic"><i class="fas fa-receipt"></i></span>
            <div>
                <h1><?php echo t('Detail Transaksi', 'Transaction Detail'); ?></h1>
                <span class="tx-code">BT-<?php echo htmlspecialchars($transaction->uuid); ?></span>
            </div>
        </div>
        <span class="tx-status"><i class="fas <?php echo $tx_st['ic']; ?>"></i> <?php echo $tx_st['label']; ?></span>
    </div>

    <!-- Grid info -->
    <div class="tx-grid">
        <div class="tx-card">
            <h2><?php echo t('Informasi Transaksi', 'Transaction Info'); ?></h2>
            <div class="tx-rows">
                <div class="tx-row"><span><?php echo t('Tipe', 'Type'); ?></span><span class="tx-pill"><?php echo htmlspecialchars($transaction->item_type); ?></span></div>
                <div class="tx-row"><span><?php echo t('Tanggal', 'Date'); ?></span><strong><?php echo date('d M Y, H:i', strtotime($transaction->created_at)); ?> WIB</strong></div>
                <div class="tx-row"><span><?php echo t('Nominal', 'Amount'); ?></span><strong class="tx-amount">Rp <?php echo number_format($transaction->amount, 0, ',', '.'); ?></strong></div>
                <?php if ($transaction->discount_amount > 0): ?>
                <div class="tx-row"><span><?php echo t('Diskon', 'Discount'); ?></span><strong class="tx-discount">- Rp <?php echo number_format($transaction->discount_amount, 0, ',', '.'); ?></strong></div>
                <?php endif; ?>
            </div>
        </div>

        <div class="tx-card">
            <h2><?php echo t('Informasi Pembayaran', 'Payment Info'); ?></h2>
            <?php if ($pm): ?>
                <div class="tx-method">
                    <?php if ($pm['logo']): ?>
                        <span class="tx-method-logo"><img src="<?php echo base_url('assets/img/' . $pm['logo']); ?>" alt="<?php echo htmlspecialchars($pm['label']); ?>"></span>
                    <?php else: ?>
                        <span class="tx-method-logo tx-method-logo-fb"><i class="fas fa-building-columns"></i></span>
                    <?php endif; ?>
                    <div>
                        <strong><?php echo htmlspecialchars($pm['label']); ?></strong>
                        <small><?php echo htmlspecialchars($pm['group']); ?></small>
                    </div>
                </div>
            <?php elseif ($pm_fallback_label): ?>
                <div class="tx-method">
                    <span class="tx-method-logo tx-method-logo-fb"><i class="fas fa-credit-card"></i></span>
                    <div><strong><?php echo htmlspecialchars($pm_fallback_label); ?></strong></div>
                </div>
            <?php else: ?>
                <p class="tx-muted">
                    <?php if ($transaction->status === 'approved'): ?>
                        <i class="fas fa-user-check" style="color:#0d9488;margin-right:.3rem;"></i><?php echo t('Dikonfirmasi manual oleh admin.', 'Manually confirmed by admin.'); ?>
                    <?php else: ?>
                        <?php echo t('Metode pembayaran belum dipilih.', 'Payment method not yet selected.'); ?>
                    <?php endif; ?>
                </p>
            <?php endif; ?>

            <div class="tx-rows tx-rows-pad">
                <?php if ($transaction->gateway_tx_id): ?>
                <div class="tx-row"><span><?php echo t('ID Gateway', 'Gateway ID'); ?></span><span class="tx-mono"><?php echo htmlspecialchars($transaction->gateway_tx_id); ?></span></div>
                <?php endif; ?>
                <?php if ($transaction->payment_proof): ?>
                <div class="tx-row"><span><?php echo t('Bukti Bayar', 'Proof'); ?></span>
                    <a href="<?php echo base_url('uploads/proofs/' . $transaction->payment_proof); ?>" target="_blank" rel="noopener" class="tx-link"><i class="fas fa-arrow-up-right-from-square"></i> <?php echo t('Lihat', 'View'); ?></a>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Item -->
    <?php if ($item): ?>
    <div class="tx-card tx-item-card">
        <h2><?php echo t('Item Pembelian', 'Purchased Item'); ?></h2>
        <div class="tx-item">
            <?php if (!empty($item->thumbnail) && $item->thumbnail !== 'default_course.png'): ?>
                <img src="<?php echo base_url('uploads/courses/' . $item->thumbnail); ?>" onerror="this.src='https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=120&auto=format&fit=crop&q=60';" alt="" class="tx-item-thumb">
            <?php else: ?>
                <span class="tx-item-thumb tx-item-thumb-fb"><i class="fas fa-book-open"></i></span>
            <?php endif; ?>
            <div>
                <strong><?php echo htmlspecialchars($item->title ?? $item->topic ?? $item->topic_en ?? ''); ?></strong>
                <span><?php echo ucfirst($transaction->item_type); ?></span>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <!-- Pending -->
    <?php if ($transaction->status === 'pending'): ?>
    <div class="tx-alert tx-alert-pending">
        <div class="tx-alert-head"><i class="fas fa-clock"></i> <?php echo t('Pembayaran Menunggu', 'Payment Pending'); ?></div>
        <p><?php echo t('Transaksi ini belum dibayar. Silakan lengkapi pembayaran untuk mengakses konten.', 'This transaction is waiting for payment. Please complete the payment to access the content.'); ?></p>
        <a href="<?php echo $pay_url; ?>" class="tx-btn tx-btn-primary"><i class="fas fa-credit-card"></i> <?php echo t('Bayar Sekarang', 'Pay Now'); ?></a>
    </div>
    <?php endif; ?>

    <!-- Rejected -->
    <?php if ($transaction->status === 'rejected'): ?>
    <div class="tx-alert tx-alert-rejected">
        <div class="tx-alert-head"><i class="fas fa-triangle-exclamation"></i> <?php echo t('Transaksi Ditolak', 'Transaction Rejected'); ?></div>
        <p><?php echo t('Transaksi ini ditolak. Silakan hubungi admin jika ada pertanyaan.', 'This transaction was rejected. Please contact admin if you have questions.'); ?></p>
        <a href="<?php echo base_url('courses'); ?>" class="tx-btn tx-btn-ghost"><i class="fas fa-arrow-left"></i> <?php echo t('Kembali Ke Katalog', 'Back to Catalog'); ?></a>
    </div>
    <?php endif; ?>

    <!-- Approved -->
    <?php if ($transaction->status === 'approved'): ?>
    <div class="tx-alert tx-alert-ok">
        <div class="tx-alert-head"><i class="fas fa-circle-check"></i> <?php echo t('Pembayaran Berhasil', 'Payment Successful'); ?></div>
        <p><?php echo t('Terima kasih! Item sudah bisa diakses dari dashboard Anda.', 'Thank you! The item is now accessible from your dashboard.'); ?></p>
        <a href="<?php echo base_url('dashboard'); ?>" class="tx-btn tx-btn-primary"><i class="fas fa-gauge"></i> <?php echo t('Ke Dashboard', 'Go to Dashboard'); ?></a>
    </div>
    <?php endif; ?>
</div>

<style>
.tx-wrap{max-width:840px;margin:0 auto;padding:0 0 2rem;}
.tx-breadcrumb{display:flex;align-items:center;gap:.5rem;font-size:.76rem;margin-bottom:1.1rem;flex-wrap:wrap;}
.tx-breadcrumb a{color:#64748b;text-decoration:none;font-weight:500;}
.tx-breadcrumb a:hover{color:#0d9488;}
.tx-breadcrumb i{color:#cbd5e1;font-size:.55rem;}
.tx-breadcrumb span{color:#0f172a;font-weight:700;}
/* ===== Banner ===== */
.tx-banner{display:flex;align-items:center;justify-content:space-between;gap:1rem;flex-wrap:wrap;background:#fff;border:1px solid #e6edec;border-radius:16px;padding:1.2rem 1.4rem;margin-bottom:1.2rem;box-shadow:0 2px 10px rgba(15,23,42,.04);}
.tx-banner-l{display:flex;align-items:center;gap:.9rem;}
.tx-banner-ic{width:46px;height:46px;flex:0 0 auto;border-radius:13px;background:#f0fdfa;color:#0d9488;display:inline-flex;align-items:center;justify-content:center;font-size:1.1rem;}
.tx-st-rejected .tx-banner-ic{background:#fef2f2;color:#dc2626;}
.tx-banner-l h1{font-size:1.02rem;font-weight:800;color:#0f172a;margin:0;}
.tx-code{font-size:.72rem;color:#94a3b8;font-family:ui-monospace,monospace;}
.tx-status{display:inline-flex;align-items:center;gap:.45rem;font-size:.78rem;font-weight:700;padding:.5rem .95rem;border-radius:99px;}
.tx-st-ok .tx-status{background:#dcfce7;color:#15803d;}
.tx-st-pending .tx-status{background:#fef3c7;color:#b45309;}
.tx-st-rejected .tx-status{background:#fef2f2;color:#dc2626;}
/* ===== Grid & card ===== */
.tx-grid{display:grid;grid-template-columns:1fr 1fr;gap:1rem;margin-bottom:1rem;}
.tx-card{background:#fff;border:1px solid #e6edec;border-radius:16px;padding:1.3rem 1.35rem;box-shadow:0 2px 10px rgba(15,23,42,.03);}
.tx-card h2{font-size:.66rem;font-weight:800;text-transform:uppercase;letter-spacing:.06em;color:#94a3b8;margin:0 0 .9rem;}
.tx-rows{display:flex;flex-direction:column;gap:.65rem;}
.tx-rows-pad{margin-top:.9rem;padding-top:.9rem;border-top:1px dashed #f1f5f9;}
.tx-row{display:flex;align-items:center;justify-content:space-between;gap:.7rem;font-size:.82rem;}
.tx-row > span:first-child{color:#64748b;}
.tx-row strong{color:#0f172a;font-weight:700;}
.tx-amount{font-size:1.05rem;}
.tx-discount{color:#0d9488;}
.tx-pill{background:#eef2f1;color:#475569;font-size:.66rem;font-weight:700;text-transform:uppercase;padding:.28rem .65rem;border-radius:99px;}
.tx-mono{font-family:ui-monospace,monospace;font-size:.72rem;color:#0f172a;font-weight:600;}
.tx-link{font-size:.78rem;font-weight:700;color:#0d9488;text-decoration:none;display:inline-flex;align-items:center;gap:.35rem;}
.tx-link:hover{text-decoration:underline;}
.tx-muted{font-size:.78rem;color:#94a3b8;margin:0;}
/* ===== Payment method (logo asli, bukan teks mentah) ===== */
.tx-method{display:flex;align-items:center;gap:.85rem;}
.tx-method-logo{width:52px;height:52px;flex:0 0 auto;border-radius:12px;background:#f8fafc;border:1px solid #e2e8f0;display:inline-flex;align-items:center;justify-content:center;padding:.5rem;}
.tx-method-logo img{max-width:100%;max-height:100%;object-fit:contain;}
.tx-method-logo-fb{color:#0d9488;font-size:1.2rem;background:#f0fdfa;border-color:#ccfbf1;}
.tx-method strong{display:block;font-size:.86rem;font-weight:700;color:#0f172a;}
.tx-method small{font-size:.68rem;color:#94a3b8;}
/* ===== Item pembelian ===== */
.tx-item-card{margin-bottom:1rem;}
.tx-item{display:flex;align-items:center;gap:.9rem;}
.tx-item-thumb{width:62px;height:46px;border-radius:10px;object-fit:cover;border:1px solid #e2e8f0;flex:0 0 auto;}
.tx-item-thumb-fb{display:inline-flex;align-items:center;justify-content:center;background:#f0fdfa;color:#0d9488;font-size:1rem;}
.tx-item strong{display:block;font-size:.88rem;font-weight:700;color:#0f172a;}
.tx-item span{font-size:.7rem;color:#94a3b8;}
/* ===== Alert states ===== */
.tx-alert{border-radius:16px;padding:1.2rem 1.35rem;}
.tx-alert-head{display:flex;align-items:center;gap:.55rem;font-size:.9rem;font-weight:800;margin-bottom:.5rem;}
.tx-alert p{font-size:.82rem;line-height:1.55;margin:0 0 1rem;}
.tx-alert-pending{background:#fffbeb;border:1px solid #fde68a;}
.tx-alert-pending .tx-alert-head{color:#92400e;}
.tx-alert-pending p{color:#a16207;}
.tx-alert-rejected{background:#fef2f2;border:1px solid #fecaca;}
.tx-alert-rejected .tx-alert-head{color:#991b1b;}
.tx-alert-rejected p{color:#b91c1c;}
.tx-alert-ok{background:#f0fdf4;border:1px solid #bbf7d0;}
.tx-alert-ok .tx-alert-head{color:#15803d;}
.tx-alert-ok p{color:#166534;}
.tx-btn{display:inline-flex;align-items:center;gap:.5rem;padding:.75rem 1.3rem;border-radius:12px;font-weight:700;font-size:.82rem;text-decoration:none;transition:all .18s;}
.tx-btn-primary{background:linear-gradient(135deg,#0d9488,#0b6b5c);color:#fff;box-shadow:0 10px 22px -10px rgba(13,148,136,.55);}
.tx-btn-primary:hover{transform:translateY(-2px);color:#fff;}
.tx-btn-ghost{background:#fff;color:#0d9488;border:1.5px solid #0d9488;}
.tx-btn-ghost:hover{background:#f0fdfa;}
/* ===== Responsive ===== */
@media (max-width:720px){
  .tx-grid{grid-template-columns:1fr;}
  .tx-banner{flex-direction:column;align-items:flex-start;}
}
</style>
