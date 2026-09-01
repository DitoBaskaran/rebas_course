<div class="container py-3 my-1 checkout-panel" style="max-width: 760px;">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-7 animate-scale-in">
            <div class="card border-0 shadow-sm rounded-4 p-3 p-md-5">
                <?php
                    $method_logos = array(
                        'qris' => 'qris-logo.png',
                        'bri_va' => 'bri-logo.svg',
                        'bni_va' => 'bni-logo.svg',
                        'cimb_niaga_va' => 'cimb-logo.svg',
                        'maybank_va' => 'maybank-logo.svg',
                        'permata_va' => 'permata-logo.png',
                        'atm_bersama_va' => 'atm-bersama-logo.png',
                        'sampoerna_va' => '',
                        'bnc_va' => '',
                        'artha_graha_va' => '',
                    );
                    $logo_file = $method_logos[$method] ?? '';
                ?>
                <div class="text-center mb-4">
                    <?php if ($logo_file): ?>
                    <div class="d-inline-flex align-items-center justify-content-center bg-light rounded-3 mb-4 shadow-sm p-3" style="width: 80px; height: 80px;">
                        <img src="<?php echo base_url('assets/img/' . $logo_file); ?>" alt="<?php echo htmlspecialchars($method_label ?? $method); ?>" style="max-width:56px;max-height:40px;width:auto;height:auto;">
                    </div>
                    <?php else: ?>
                    <div class="d-inline-flex align-items-center justify-content-center bg-success text-white rounded-3 mb-4 shadow-sm" style="width: 64px; height: 64px;">
                        <i class="fas fa-credit-card fa-lg"></i>
                    </div>
                    <?php endif; ?>
                    <h3 class="fw-extrabold text-dark mb-2" style="letter-spacing: -0.03em;"><?php echo t('Pembayaran', 'Payment'); ?></h3>
                    <p class="text-secondary small mb-0"><?php echo htmlspecialchars($method_label ?? $method); ?></p>
                </div>

                <!-- ============ KODE PEMBAYARAN (ditampilkan PALING ATAS) ============ -->
                <?php if ($method === 'qris'): ?>
                <div class="text-center mb-4">
                    <h6 class="fw-bold text-dark mb-3"><?php echo t('Scan QRIS di bawah ini', 'Scan QRIS below'); ?></h6>
                    <div class="bg-white d-inline-block p-3 rounded-3 shadow-sm border mb-3">
                        <div id="qrisContainer">
                            <p class="text-secondary small mb-3"><?php echo t('Gunakan aplikasi pembayaran (GoPay, OVO, DANA, ShopeePay, dll) untuk scan QR code:', 'Use payment apps (GoPay, OVO, DANA, ShopeePay, etc.) to scan QR code:'); ?></p>
                            <div class="bg-light rounded-3 p-4 d-inline-block" id="qrCodeContainer"></div>
                            <p class="text-secondary small mt-3 mb-0">
                                <i class="fas fa-info-circle me-1"></i>
                                <?php echo t('Atau copy QR string di bawah:', 'Or copy the QR string below:'); ?>
                            </p>
                            <div class="input-group mt-2">
                                <input type="text" class="form-control font-monospace small" value="<?php echo htmlspecialchars($payment['payment_number']); ?>" readonly id="qrString">
                                <button class="btn btn-outline-dark" type="button" onclick="copyQR()"><?php echo t('Salin', 'Copy'); ?></button>
                            </div>
                        </div>
                    </div>
                </div>
                <?php else: ?>
                <div class="mb-4">
                    <h6 class="fw-bold text-dark mb-3"><?php echo t('Nomor Virtual Account', 'Virtual Account Number'); ?></h6>
                    <div class="bg-dark text-light p-4 rounded-3 small font-monospace text-center">
                        <p class="mb-2 text-white-50"><?php echo t('Transfer ke nomor VA berikut:', 'Transfer to the following VA number:'); ?></p>
                        <p class="fw-bold text-warning fs-4 mb-0" style="letter-spacing: 2px;"><?php echo htmlspecialchars($payment['payment_number']); ?></p>
                    </div>
                </div>
                <?php endif; ?>

                <!-- ============ RINGKASAN TRANSAKSI ============ -->
                <div class="bg-light rounded-4 p-4 mb-4">
                    <?php if ($item): ?>
                    <div class="d-flex align-items-center gap-2 mb-3 pb-3 border-bottom">
                        <div class="flex-fill min-w-0">
                            <div class="fw-bold text-dark"><?php echo htmlspecialchars($item->title ?? $item->name ?? ''); ?></div>
                            <div class="text-secondary small"><?php echo ucfirst($tx->item_type); ?> &middot; Rp <?php echo number_format($tx->amount, 0, ',', '.'); ?></div>
                        </div>
                    </div>
                    <?php endif; ?>
                    <div class="d-flex justify-content-between mb-3 small">
                        <span class="text-secondary"><?php echo t('Kode Transaksi', 'Transaction Code'); ?></span>
                        <span class="fw-bold text-dark">BT-<?php echo $tx->uuid; ?></span>
                    </div>
                    <div class="d-flex justify-content-between mb-3 small">
                        <span class="text-secondary"><?php echo t('Order ID', 'Order ID'); ?></span>
                        <span class="fw-bold text-dark font-monospace small"><?php echo htmlspecialchars($order_id); ?></span>
                    </div>
                    <hr class="my-4 opacity-25">
                    <div class="d-flex justify-content-between align-items-baseline">
                        <span class="fw-bold text-dark"><?php echo t('Total Pembayaran', 'Total Payment'); ?></span>
                        <span class="fw-extrabold text-primary fs-3">Rp <?php echo number_format($payment['total_payment'] ?? $tx->amount, 0, ',', '.'); ?></span>
                    </div>
                </div>

                <?php if (isset($payment['expired_at'])): ?>
                <?php $exp_ts = strtotime($payment['expired_at']); ?>
                <div class="text-center mb-4">
                    <p class="text-muted small mb-2"><?php echo t('Selesaikan pembayaran sebelum waktu habis:', 'Complete payment before time runs out:'); ?></p>
                    <div class="d-inline-flex align-items-center gap-1 px-3 py-2 rounded-3 border bg-white" id="countdownTimer">
                        <i class="far fa-clock text-danger me-1"></i>
                        <span class="fw-bold text-dark fs-6 font-monospace" id="cd-hours">00</span>
                        <span class="text-muted">:</span>
                        <span class="fw-bold text-dark fs-6 font-monospace" id="cd-minutes">00</span>
                        <span class="text-muted">:</span>
                        <span class="fw-bold text-dark fs-6 font-monospace" id="cd-seconds">00</span>
                    </div>
                </div>
                <script>
                document.addEventListener('DOMContentLoaded', function() {
                    var expiry = new Date('<?php echo date('Y/m/d H:i:s', $exp_ts); ?>').getTime();
                    var timer = document.getElementById('countdownTimer');
                    function updateCountdown() {
                        var diff = expiry - new Date().getTime();
                        if (diff <= 0) {
                            ['cd-hours','cd-minutes','cd-seconds'].forEach(function(id) { document.getElementById(id).textContent = '00'; });
                            timer.classList.remove('bg-white');
                            timer.classList.add('bg-light');
                            return;
                        }
                        var h = Math.floor(diff / 3600000);
                        var m = Math.floor((diff % 3600000) / 60000);
                        var s = Math.floor((diff % 60000) / 1000);
                        document.getElementById('cd-hours').textContent = String(h).padStart(2, '0');
                        document.getElementById('cd-minutes').textContent = String(m).padStart(2, '0');
                        document.getElementById('cd-seconds').textContent = String(s).padStart(2, '0');
                    }
                    updateCountdown();
                    setInterval(updateCountdown, 1000);
                });
                </script>
                <?php endif; ?>

                <!-- Status & Actions -->
                <div id="paymentStatus" class="text-center mb-3 d-none">
                    <div class="spinner-border spinner-border-sm text-primary me-2" role="status"></div>
                    <span class="small text-secondary" id="statusMessage"><?php echo t('Memeriksa pembayaran...', 'Checking payment...'); ?></span>
                </div>

                <div class="d-flex flex-column gap-2 pt-3">
                    <button type="button" class="btn w-100 py-3 rounded-pill fw-semibold text-white" id="checkPaymentBtn" onclick="checkPayment()" style="background:#0D1830; border-color:#0D1830;">
                        <i class="fas fa-search me-2"></i> <?php echo t('Cek Status Pembayaran', 'Check Payment Status'); ?>
                    </button>
                    <a href="<?php echo base_url('transactions/history'); ?>" class="btn btn-outline-secondary w-100 py-3 rounded-pill fw-semibold">
                        <i class="fas fa-arrow-left me-2"></i> <?php echo t('Kembali ke Riwayat Transaksi', 'Back to Transaction History'); ?>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/qrcodejs@1.0.0/qrcode.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var qrContainer = document.getElementById('qrCodeContainer');
    if (qrContainer) {
        new QRCode(qrContainer, {
            text: '<?php echo htmlspecialchars($payment['payment_number']); ?>',
            width: 200,
            height: 200,
            colorDark: '#1e293b',
            colorLight: '#ffffff',
            correctLevel: QRCode.CorrectLevel.H
        });
    }

    // Auto-check payment status every 10 seconds
    checkPaymentInterval = setInterval(autoCheckPayment, 10000);
});

function copyQR() {
    var input = document.getElementById('qrString');
    if (input) {
        input.select();
        document.execCommand('copy');
        Swal.fire({ toast: true, position: 'top-end', showConfirmButton: false, timer: 3000, icon: 'success', title: '<?php echo t('QR string berhasil disalin!', 'QR string copied!'); ?>' });
    }
}

function checkPayment() {
    var btn = document.getElementById('checkPaymentBtn');
    var status = document.getElementById('paymentStatus');
    var msg = document.getElementById('statusMessage');

    btn.disabled = true;
    btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span> <?php echo t('Memeriksa...', 'Checking...'); ?>';
    status.classList.remove('d-none');
    msg.textContent = '<?php echo t('Memeriksa pembayaran...', 'Checking payment...'); ?>';

    fetch('<?php echo base_url('checkout/pakasir_check/' . $tx->uuid); ?>')
        .then(function(r) { return r.json(); })
        .then(function(data) {
            if (data.status === 'completed') {
                clearInterval(checkPaymentInterval);
                status.innerHTML = '<div class="alert alert-success border-0 mb-0 py-2 small">✅ ' + data.message + ' <?php echo t('Mengalihkan...', 'Redirecting...'); ?></div>';
                setTimeout(function() { window.location.href = '<?php echo base_url('dashboard'); ?>'; }, 2000);
            } else {
                status.classList.add('d-none');
                btn.disabled = false;
                btn.innerHTML = '<i class="fas fa-search me-2"></i> <?php echo t('Cek Status Pembayaran', 'Check Payment Status'); ?>';
            }
        })
        .catch(function() {
            status.classList.add('d-none');
            btn.disabled = false;
            btn.innerHTML = '<i class="fas fa-search me-2"></i> <?php echo t('Cek Status Pembayaran', 'Check Payment Status'); ?>';
        });
}

function autoCheckPayment() {
    fetch('<?php echo base_url('checkout/pakasir_check/' . $tx->uuid); ?>')
        .then(function(r) { return r.json(); })
        .then(function(data) {
            if (data.status === 'completed') {
                clearInterval(checkPaymentInterval);
                var status = document.getElementById('paymentStatus');
                status.classList.remove('d-none');
                status.innerHTML = '<div class="alert alert-success border-0 mb-0 py-2 small">✅ ' + data.message + ' <?php echo t('Mengalihkan...', 'Redirecting...'); ?></div>';
                setTimeout(function() { window.location.href = '<?php echo base_url('dashboard'); ?>'; }, 2000);
            }
        });
}
</script>
