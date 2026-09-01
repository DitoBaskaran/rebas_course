<div class="container py-3 my-1 checkout-panel" style="max-width: 760px;">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-7 animate-scale-in">
            <div class="card border-0 shadow-sm rounded-4 p-3 p-md-5">
                <div class="text-center mb-4">
                    <div class="d-inline-flex align-items-center justify-content-center bg-dark text-white rounded-3 mb-4 shadow-sm" style="width: 64px; height: 64px;">
                        <i class="fas fa-receipt fa-lg"></i>
                    </div>
                    <h3 class="fw-extrabold text-dark mb-2" style="letter-spacing: -0.03em;"><?php echo t('Konfirmasi Pembayaran', 'Payment Confirmation'); ?></h3>
                    <p class="text-secondary small mb-0"><?php echo t('Lakukan transfer sesuai nominal di bawah untuk mengaktifkan akses Anda.', 'Complete the payment below to activate your access.'); ?></p>
                </div>

                <div class="bg-light rounded-4 p-4 mb-4">
                    <div class="d-flex justify-content-between mb-3 small">
                        <span class="text-secondary"><?php echo t('Item', 'Item'); ?></span>
                        <span class="fw-bold text-dark"><?php echo htmlspecialchars($item_name); ?></span>
                    </div>
                    <div class="d-flex justify-content-between mb-3 small">
                        <span class="text-secondary"><?php echo t('ID Transaksi', 'Transaction ID'); ?></span>
                        <span class="fw-bold text-dark font-monospace small"><?php echo $tx_ref; ?></span>
                    </div>
                    <?php if ($applied_coupon): ?>
                    <div class="d-flex justify-content-between mb-3 small">
                        <span class="text-secondary"><?php echo t('Kupon', 'Coupon'); ?></span>
                        <span class="fw-bold text-success"><?php echo htmlspecialchars($applied_coupon->code); ?> (-Rp <?php echo number_format($transaction->discount_amount, 0, ',', '.'); ?>)</span>
                    </div>
                    <div class="d-flex justify-content-between mb-3 small">
                        <span class="text-secondary"><?php echo t('Harga Asli', 'Original Price'); ?></span>
                        <span class="fw-bold text-muted text-decoration-line-through">Rp <?php echo number_format($transaction->original_amount, 0, ',', '.'); ?></span>
                    </div>
                    <?php endif; ?>
                    <div class="d-flex justify-content-between mb-3 small">
                        <span class="text-secondary"><?php echo t('Status', 'Status'); ?></span>
                        <span class="badge bg-warning text-dark rounded-pill px-3 py-2 fw-medium"><?php echo t('Menunggu Pembayaran', 'Awaiting Payment'); ?></span>
                    </div>
                    <hr class="my-4 opacity-25">
                    <div class="d-flex justify-content-between align-items-baseline">
                        <span class="fw-bold text-dark"><?php echo t('Total Transfer', 'Total Transfer'); ?></span>
                        <span class="fw-extrabold text-primary fs-3">Rp <?php echo number_format($transaction->amount, 0, ',', '.'); ?></span>
                    </div>
                </div>

                <div class="mb-4">
                    <h6 class="fw-bold text-dark mb-3 d-flex align-items-center gap-2">
                        <span class="icon-28 bg-primary-subtle text-primary rounded-2 d-inline-flex align-items-center justify-content-center"><i class="fas fa-ticket-alt"></i></span>
                        <span><?php echo t('Punya Kupon Diskon?', 'Have a Discount Coupon?'); ?></span>
                    </h6>
                    <div id="couponSection">
                        <div class="input-group mb-2">
                            <input type="text" class="form-control" id="couponCode" placeholder="<?php echo t('Masukkan kode kupon', 'Enter coupon code'); ?>" <?php echo $applied_coupon ? 'disabled' : ''; ?> value="<?php echo $applied_coupon ? htmlspecialchars($applied_coupon->code) : ''; ?>">
                            <?php if ($applied_coupon): ?>
                            <button class="btn btn-outline-danger" type="button" id="removeCouponBtn"><i class="fas fa-times"></i></button>
                            <?php else: ?>
                            <button class="btn btn-primary" type="button" id="applyCouponBtn"><?php echo t('Pakai', 'Apply'); ?></button>
                            <?php endif; ?>
                        </div>
                        <div id="couponMessage" class="small <?php echo $applied_coupon ? 'text-success' : 'd-none'; ?>">
                            <?php if ($applied_coupon): ?>
                                <i class="fas fa-check-circle me-1"></i><?php echo t('Kupon diterapkan! Hemat Rp ', 'Coupon applied! Save Rp ') . number_format($transaction->discount_amount, 0, ',', '.'); ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <div class="mb-4">
                    <h6 class="fw-bold text-dark mb-3 d-flex align-items-center gap-2">
                        <span class="icon-28 bg-primary-subtle text-primary rounded-2 d-inline-flex align-items-center justify-content-center"><i class="fas fa-info-circle"></i></span>
                        <span><?php echo t('Pilih Metode Pembayaran', 'Choose Payment Method'); ?></span>
                    </h6>

                    <?php $pakasir_configured = function_exists('setting') && !empty(setting('pakasir_slug', '')) && !empty(setting('pakasir_api_key', '')); ?>

                    <?php if ($pakasir_configured):
                        $qris_enabled = setting('payment_method_qris', '1') === '1';
                        $va_methods = array();
                        $va_list = array(
                            'bri_va' => array('name' => 'BRI', 'logo' => 'bri-logo.svg'),
                            'bni_va' => array('name' => 'BNI', 'logo' => 'bni-logo.svg'),
                            'cimb_niaga_va' => array('name' => 'CIMB Niaga', 'logo' => 'cimb-logo.svg'),
                            'maybank_va' => array('name' => 'Maybank', 'logo' => 'maybank-logo.svg'),
                            'permata_va' => array('name' => 'Permata', 'logo' => 'permata-logo.png'),
                            'atm_bersama_va' => array('name' => 'ATM Bersama', 'logo' => 'atm-bersama-logo.png'),
                            'sampoerna_va' => array('name' => 'Sampoerna', 'logo' => ''),
                            'bnc_va' => array('name' => 'BNC', 'logo' => ''),
                            'artha_graha_va' => array('name' => 'Artha Graha', 'logo' => ''),
                        );
                        foreach ($va_list as $key => $info) {
                            if (setting('payment_method_' . $key, '1') === '1') {
                                $va_methods[$key] = $info;
                            }
                        }
                    ?>
                    <?php if ($qris_enabled): ?>
                    <a href="<?php echo base_url('checkout/' . $pay_method . '/' . $tx_ref . '?method=qris'); ?>" class="d-flex align-items-center gap-3 p-4 rounded-3 bg-light border border-primary border-opacity-25 text-decoration-none mb-3" style="transition: all 0.2s;">
                        <div class="d-flex align-items-center justify-content-center rounded-2 flex-shrink-0" style="width: 60px; height: 60px; background: #f0f5ff;">
                            <img src="<?php echo base_url('assets/img/qris-logo.png'); ?>" alt="QRIS" style="max-width:36px;max-height:36px;width:auto;height:auto;">
                        </div>
                        <div class="flex-fill">
                            <span class="fw-bold text-dark d-block"><?php echo t('QRIS', 'QRIS'); ?></span>
                            <span class="text-secondary small"><?php echo t('GoPay, OVO, DANA, ShopeePay, LinkAja, dll.', 'GoPay, OVO, DANA, ShopeePay, LinkAja, etc.'); ?></span>
                        </div>
                        <span class="badge bg-success rounded-pill px-3 py-2 fw-medium flex-shrink-0"><?php echo t('Cepat', 'Fast'); ?></span>
                        <i class="fas fa-chevron-right text-primary flex-shrink-0"></i>
                    </a>
                    <?php endif; ?>

                    <?php if (!empty($va_methods)): ?>
                    <div class="border rounded-3 overflow-hidden">
                        <button class="d-flex align-items-center gap-3 w-100 p-3 border-0 bg-light text-start" type="button" data-bs-toggle="collapse" data-bs-target="#vaCollapse" aria-expanded="false" style="transition: all 0.2s; cursor: pointer;">
                            <div class="d-flex align-items-center justify-content-center rounded-2 flex-shrink-0" style="width: 40px; height: 40px; background: var(--primary-light); color: var(--primary);">
                                <i class="fas fa-university"></i>
                            </div>
                            <div class="flex-fill">
                                <span class="fw-bold text-dark small d-block"><?php echo t('Virtual Account', 'Virtual Account'); ?></span>
                                <span class="text-secondary small"><?php echo count($va_methods); ?> <?php echo t('bank tersedia', 'banks available'); ?></span>
                            </div>
                            <i class="fas fa-chevron-down text-secondary flex-shrink-0 transition-smooth" id="vaChevron"></i>
                        </button>
                        <div class="collapse" id="vaCollapse">
                            <div class="d-flex flex-column" style="border-top: 1px solid var(--card-border);">
                                <?php foreach ($va_methods as $method_key => $info): ?>
                                <a href="<?php echo base_url('checkout/' . $pay_method . '/' . $tx_ref . '?method=' . $method_key); ?>" class="d-flex align-items-center gap-3 px-4 py-3 text-decoration-none border-bottom" style="transition: all 0.1s;">
                                    <?php if ($info['logo']): ?>
                                    <span style="display:inline-block;width:50px;text-align:center;"><img src="<?php echo base_url('assets/img/' . $info['logo']); ?>" alt="<?php echo $info['name']; ?>" style="max-width:50px;max-height:18px;width:auto;height:auto;"></span>
                                    <?php else: ?>
                                    <span style="display:inline-block;width:50px;text-align:center;"><div class="d-inline-flex align-items-center justify-content-center rounded-circle fw-bold" style="width:24px;height:24px;background:var(--gray-200);color:var(--gray-600);font-size:0.6rem;"><?php echo strtoupper(substr($info['name'], 0, 1)); ?></div></span>
                                    <?php endif; ?>
                                    <span class="fw-semibold text-dark small flex-fill"><?php echo $info['name']; ?></span>
                                    <i class="fas fa-chevron-right text-secondary" style="font-size: 0.65rem;"></i>
                                </a>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>

                    <?php if (!$qris_enabled && empty($va_methods)): ?>
                    <div class="alert alert-warning border-0 rounded-4 text-center py-4 mb-0" role="alert">
                        <i class="fas fa-exclamation-triangle mb-3" style="font-size: 1.5rem;"></i>
                        <p class="fw-semibold mb-1"><?php echo t('Belum ada metode pembayaran tersedia.', 'No payment method available yet.'); ?></p>
                        <p class="small mb-0"><?php echo t('Silakan hubungi admin untuk informasi lebih lanjut.', 'Please contact admin for further information.'); ?></p>
                    </div>
                    <?php endif; ?>
                    <style>[data-bs-target="#vaCollapse"][aria-expanded="true"] #vaChevron { transform: rotate(180deg); }</style>
                    <?php else: ?>
                    <div class="alert alert-warning border-0 rounded-4 text-center py-4 mb-0" role="alert">
                        <i class="fas fa-exclamation-triangle mb-3" style="font-size: 1.5rem;"></i>
                        <p class="fw-semibold mb-1"><?php echo t('Belum ada metode pembayaran tersedia.', 'No payment method available yet.'); ?></p>
                        <p class="small mb-0"><?php echo t('Silakan hubungi admin untuk informasi lebih lanjut.', 'Please contact admin for further information.'); ?></p>
                    </div>
                    <?php endif; ?>
                </div>

                <div class="d-flex pt-2">
                    <a href="<?php echo base_url('dashboard'); ?>" class="btn btn-outline-secondary w-100 py-3 rounded-pill fw-semibold"><?php echo t('Kembali ke Dashboard', 'Back to Dashboard'); ?></a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var applyBtn = document.getElementById('applyCouponBtn');
    var removeBtn = document.getElementById('removeCouponBtn');
    var codeInput = document.getElementById('couponCode');
    var msgDiv = document.getElementById('couponMessage');

    if (applyBtn) {
        applyBtn.addEventListener('click', function() {
            var code = codeInput.value.trim();
            if (!code) { Swal.fire({ icon: 'warning', text: '<?php echo t('Masukkan kode kupon.', 'Enter coupon code.'); ?>', showConfirmButton: false }); return; }
            applyBtn.disabled = true;
            applyBtn.innerHTML = '<span class="spinner-border spinner-border-sm"></span>';
            fetch('<?php echo base_url('checkout/apply_' . $coupon_method . '/' . $tx_ref); ?>', {
                method: 'POST',
                headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                body: 'code=' + encodeURIComponent(code)
            }).then(function(r) { return r.json(); }).then(function(data) {
                if (data.status === 'ok') {
                    location.reload();
                } else {
                    msgDiv.className = 'small text-danger';
                    msgDiv.innerHTML = '<i class="fas fa-exclamation-circle me-1"></i>' + data.message;
                    applyBtn.disabled = false;
                    applyBtn.innerHTML = '<?php echo t('Pakai', 'Apply'); ?>';
                }
            }).catch(function() {
                msgDiv.className = 'small text-danger';
                msgDiv.innerHTML = '<i class="fas fa-exclamation-circle me-1"></i><?php echo t('Gagal.', 'Failed.'); ?>';
                applyBtn.disabled = false;
                applyBtn.innerHTML = '<?php echo t('Pakai', 'Apply'); ?>';
            });
        });
    }

    if (removeBtn) {
        removeBtn.addEventListener('click', function() {
            if (!confirm('<?php echo t('Hapus kupon?', 'Remove coupon?'); ?>')) return;
            fetch('<?php echo base_url('checkout/remove_' . $coupon_method . '/' . $tx_ref); ?>').then(function(r) { return r.json(); }).then(function(data) {
                if (data.status === 'ok') location.reload();
            });
        });
    }
});
</script>
