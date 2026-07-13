<div class="container py-5">
    <a href="<?php echo base_url('subscription'); ?>" class="text-decoration-none small text-primary mb-3 d-inline-block"><i data-lucide="arrow-left" style="width:14px;height:14px;"></i> <?php echo t('Kembali ke Paket', 'Back to Packages'); ?></a>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 p-4">
                <h1 class="display-5 fw-bold"><?php echo htmlspecialchars($package->name); ?></h1>
                <p class="text-muted lead"><?php echo htmlspecialchars($package->description); ?></p>
                <div class="mb-4">
                    <span class="display-6 fw-bold text-primary">Rp <?php echo number_format($package->price, 0, ',', '.'); ?></span>
                    <span class="text-muted">/ <?php echo $package->duration_days; ?> <?php echo t('hari', 'days'); ?></span>
                </div>

                <?php $six = $package->six_month_option ?? null; ?>
                <form method="POST" action="<?php echo base_url('subscription/buy/' . $package->slug); ?>" class="mb-4">
                    <h5 class="fw-bold mb-3"><?php echo t('Pilih Durasi', 'Choose Duration'); ?></h5>
                    <div class="card border-0 bg-light p-3 rounded-4 mb-3">
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="radio" name="duration" id="dur_1" value="1" checked>
                            <label class="form-check-label" for="dur_1">
                                <strong><?php echo t('Bulanan', 'Monthly'); ?></strong> - Rp <?php echo number_format($package->price, 0, ',', '.'); ?> <small class="text-muted">/ <?php echo $package->duration_days; ?> <?php echo t('hari', 'days'); ?></small>
                            </label>
                        </div>
                        <?php if ($six): ?>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="duration" id="dur_6" value="6">
                                <label class="form-check-label" for="dur_6">
                                    <strong class="text-success"><?php echo t('Paket 6 Bulan (Hemat!)', '6 Months Package (Save!)'); ?></strong> - Rp <?php echo number_format($six['discounted'], 0, ',', '.'); ?> <small class="text-muted">/ <?php echo $package->duration_days * 6; ?> <?php echo t('hari', 'days'); ?></small>
                                    <div class="text-muted small mt-1"><?php echo t('Hemat Rp ', 'Save Rp ') . number_format($six['savings'], 0, ',', '.') . ' (' . $six['discount_pct'] . '% discount)'; ?></div>
                                </label>
                            </div>
                        <?php endif; ?>
                    </div>
                    <button type="submit" class="btn btn-primary btn-lg rounded-pill w-100 mt-2"><?php echo t('Berlangganan Sekarang', 'Subscribe Now'); ?></button>
                </form>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-light">
                <h5 class="fw-bold mb-3"><?php echo t('Butuh Bantuan?', 'Need Help?'); ?></h5>
                <p class="small text-muted"><?php echo t('Setelah pembelian dikonfirmasi, langganan Anda akan aktif secara otomatis. Admin akan memverifikasi pembayaran Anda.', 'After payment is confirmed, your subscription will be activated automatically. Admin will verify your payment.'); ?></p>
            </div>
        </div>
    </div>
</div>