<div class="container py-5 my-4">
    <div class="row justify-content-center">
        <div class="col-lg-6 text-center">
            <div class="bento-card p-5">
                <div class="mb-4">
                    <i data-lucide="credit-card" style="width:48px;height:48px;color:var(--primary);"></i>
                </div>
                <h4 class="fw-extrabold text-dark mb-2"><?php echo t('Pembayaran Online', 'Online Payment'); ?></h4>
                <p class="text-muted small mb-4"><?php echo t('Pilih metode pembayaran Anda.', 'Choose your payment method.'); ?></p>
                <div class="text-muted small mb-4">
                    <?php echo t('Total:', 'Total:'); ?> <strong class="text-dark">Rp <?php echo number_format($tx->amount, 0, ',', '.'); ?></strong>
                </div>

                <button id="payBtn" class="btn btn-primary btn-lg rounded-pill px-5 py-3 fw-semibold">
                    <i data-lucide="shield" style="width:18px;height:18px;" class="me-2"></i>
                    <?php echo t('Bayar Sekarang', 'Pay Now'); ?>
                </button>

                <div class="mt-4 d-flex justify-content-center gap-3 flex-wrap">
                    <span class="badge bg-light text-dark border rounded-pill px-3 py-2"><i data-lucide="smartphone" style="width:14px;height:14px;" class="me-1"></i> QRIS</span>
                    <span class="badge bg-light text-dark border rounded-pill px-3 py-2"><i data-lucide="building" style="width:14px;height:14px;" class="me-1"></i> Virtual Account</span>
                    <span class="badge bg-light text-dark border rounded-pill px-3 py-2"><i data-lucide="credit-card" style="width:14px;height:14px;" class="me-1"></i> Kartu Kredit</span>
                    <span class="badge bg-light text-dark border rounded-pill px-3 py-2"><i data-lucide="wallet" style="width:14px;height:14px;" class="me-1"></i> E-Wallet</span>
                </div>

                <div class="mt-4 pt-3 border-top">
                    <a href="<?php echo base_url('checkout/confirm/' . $tx->id); ?>" class="text-muted small text-decoration-none">
                        <i data-lucide="arrow-left" style="width:14px;height:14px;" class="me-1"></i>
                        <?php echo t('Kembali ke transfer manual', 'Back to manual transfer'); ?>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="<?php echo $client_key; ?>"></script>
<script>
document.getElementById('payBtn').addEventListener('click', function() {
    snap.pay('<?php echo $snap_token; ?>', {
        onSuccess: function(result) {
            window.location.href = '<?php echo base_url('dashboard'); ?>?purchase=success&tx_id=<?php echo $tx->id; ?>';
        },
        onPending: function(result) {
            alert('<?php echo t('Pembayaran sedang diproses.', 'Payment is being processed.'); ?>');
        },
        onError: function(result) {
            alert('<?php echo t('Pembayaran gagal. Silakan coba lagi.', 'Payment failed. Please try again.'); ?>');
        }
    });
});
</script>
