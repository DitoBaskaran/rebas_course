<div class="container py-5 my-4">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6 animate-scale-in">
            <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5">
                <div class="text-center mb-4">
                    <div class="d-inline-flex align-items-center justify-content-center bg-dark text-white rounded-3 mb-4 shadow-sm" style="width: 64px; height: 64px;">
                        <i class="fas fa-receipt fa-lg"></i>
                    </div>
                    <h3 class="fw-extrabold text-dark mb-2" style="letter-spacing: -0.03em;">Konfirmasi Pembayaran</h3>
                    <p class="text-secondary small mb-0">Lakukan transfer sesuai nominal di bawah untuk mengaktifkan akses Anda.</p>
                </div>

                <!-- Detail Transaksi -->
                <div class="bg-light rounded-4 p-4 mb-4">
                    <div class="d-flex justify-content-between mb-3 small">
                        <span class="text-secondary">Item</span>
                        <span class="fw-bold text-dark"><?php echo htmlspecialchars($item->title); ?></span>
                    </div>
                    <div class="d-flex justify-content-between mb-3 small">
                        <span class="text-secondary">ID Transaksi</span>
                        <span class="fw-bold text-dark">#<?php echo $transaction->id; ?></span>
                    </div>
                    <div class="d-flex justify-content-between mb-3 small">
                        <span class="text-secondary">Status</span>
                        <span class="badge bg-warning text-dark rounded-pill px-3 py-2 fw-medium">Menunggu Pembayaran</span>
                    </div>
                    <hr class="my-4 opacity-25">
                    <div class="d-flex justify-content-between align-items-baseline">
                        <span class="fw-bold text-dark">Total Transfer</span>
                        <span class="fw-extrabold text-primary fs-3">Rp <?php echo number_format($transaction->amount, 0, ',', '.'); ?></span>
                    </div>
                </div>

                <!-- Panduan Bayar -->
                <div class="mb-4">
                    <h6 class="fw-bold text-dark mb-4 d-flex align-items-center gap-2">
                        <span class="icon-28 bg-primary-subtle text-primary rounded-2 d-inline-flex align-items-center justify-content-center"><i class="fas fa-info-circle"></i></span>
                        <span>Panduan Pembayaran</span>
                    </h6>
                    
                    <?php $bank_name = setting('payment_bank_name', 'Bank Mandiri'); ?>
                    <?php $account_number = setting('payment_account_number', '1234567890'); ?>
                    <?php $account_name = setting('payment_account_name', 'REBAS COURSE'); ?>

                    <div class="d-flex gap-3 mb-4">
                        <div class="d-flex align-items-center justify-content-center bg-dark text-white rounded-circle fw-bold flex-shrink-0" style="width: 32px; height: 32px; font-size: 0.875rem;">1</div>
                        <div>
                            <p class="fw-semibold text-dark small mb-2">Transfer ke Rekening <?php echo htmlspecialchars($account_name); ?></p>
                            <div class="bg-dark text-light p-4 rounded-3 small font-monospace">
                                <p class="mb-2">Bank: <strong class="text-white-50"><?php echo htmlspecialchars($bank_name); ?></strong></p>
                                <p class="mb-2">No. Rek: <strong class="text-warning fs-6"><?php echo htmlspecialchars($account_number); ?></strong></p>
                                <p class="mb-0">A/N: <strong class="text-white-50"><?php echo htmlspecialchars($account_name); ?></strong></p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="d-flex gap-3">
                        <div class="d-flex align-items-center justify-content-center bg-light text-dark border rounded-circle fw-bold flex-shrink-0" style="width: 32px; height: 32px; font-size: 0.875rem;">2</div>
                        <div>
                            <p class="fw-semibold text-dark small mb-1">Upload Bukti Transfer</p>
                            <p class="text-secondary small mb-0">Format JPG/PNG, maks 2MB.</p>
                        </div>
                    </div>
                </div>

                <!-- Form Upload -->
                <?php echo form_open_multipart('checkout/submit_proof/' . $transaction->id, array('class' => 'd-flex flex-column gap-3')); ?>
                    <div>
                        <label class="form-label small fw-bold text-dark mb-2">Pilih File Bukti Bayar</label>
                        <input type="file" name="payment_proof" class="form-control rounded-pill" required>
                    </div>
                    <div class="d-flex gap-3 pt-3">
                        <button type="submit" class="btn btn-dark w-100 py-3 rounded-pill fw-semibold">
                            <i class="fas fa-upload me-2"></i> Kirim Bukti
                        </button>
                        <a href="<?php echo base_url('dashboard'); ?>" class="btn btn-outline-secondary w-100 py-3 rounded-pill fw-semibold">Nanti Saja</a>
                    </div>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
</div>
