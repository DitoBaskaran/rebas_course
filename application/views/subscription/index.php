<div class="container py-5">
    <div class="text-center mb-5">
        <span class="text-primary fw-semibold small text-uppercase">Langganan</span>
        <h1 class="display-5 fw-bold mb-2"><?php echo t('Pilih Paket Berlangganan', 'Choose a Subscription Plan'); ?></h1>
        <p class="text-muted"><?php echo t('Akses semua materi sesuai paket yang kamu pilih. Berlangganan sekali, nikmati selama masa aktif.', 'Access all materials per your selected plan. Subscribe once, enjoy for the active period.'); ?></p>
    </div>

    <?php if (!empty($active_subscriptions)): ?>
        <div class="alert alert-success border-0 shadow-sm">
            <i data-lucide="check-circle" style="width:18px;height:18px;" class="me-1"></i>
            <?php echo t('Kamu memiliki langganan aktif.', 'You have an active subscription.'); ?>
            <a href="<?php echo base_url('subscription/my'); ?>" class="alert-link"><?php echo t('Lihat detail', 'View details'); ?></a>
        </div>
    <?php endif; ?>

    <div class="row g-4 justify-content-center">
        <?php if (empty($packages)): ?>
            <div class="col-12 text-center text-muted py-5">
                <i data-lucide="layers" style="width:48px;height:48px;"></i>
                <p class="mt-3"><?php echo t('Belum ada paket langganan.', 'No subscription packages available.'); ?></p>
            </div>
        <?php else: ?>
            <?php foreach ($packages as $pkg): ?>
                <?php $six = $pkg->six_month_option ?? null; ?>
                <div class="col-lg-4 col-md-6">
                    <div class="card border-0 shadow-sm h-100 rounded-4 <?php echo $pkg->access_scope === 'all' ? 'border-primary border-2' : ''; ?>">
                        <div class="card-body p-4 d-flex flex-column">
                            <h5 class="fw-bold"><?php echo htmlspecialchars($pkg->name); ?></h5>
                            <p class="text-muted small mb-3"><?php echo htmlspecialchars($pkg->description); ?></p>
                            <div class="mb-3">
                                <span class="display-6 fw-bold text-primary">Rp <?php echo number_format($pkg->price, 0, ',', '.'); ?></span>
                                <span class="text-muted">/ <?php echo $pkg->duration_days; ?> <?php echo t('hari', 'days'); ?></span>
                            </div>
                            <?php if ($six): ?>
                                <div class="bg-success bg-opacity-10 rounded-3 p-3 mb-3">
                                    <small class="text-success fw-bold"><?php echo t('Efektif Rp ', 'Effective Rp ') . number_format(round($six['discounted'] / 6), 0, ',', '.') . ' / ' . $pkg->duration_days . ' ' . t('hari (langganan 6 bulan)', 'days (6mo sub)'); ?></small>
                                    <small class="text-muted d-block"><?php echo t('Hemat Rp ', 'Save Rp ') . number_format($six['savings'], 0, ',', '.') . ' (' . $six['discount_pct'] . '%)'; ?></small>
                                </div>
                            <?php endif; ?>
                            <ul class="list-unstyled mb-4 flex-grow-1">
                                <li class="mb-2"><i data-lucide="check" style="width:16px;height:16px;color:var(--bs-success);" class="me-2"></i>
                                    <?php
                                    if ($pkg->access_scope === 'all') echo t('Akses SEMUA konten', 'Access to ALL content');
                                    elseif ($pkg->access_scope === 'category') echo t('Akses per kategori', 'Access by category');
                                    else echo t('Akses per kursus', 'Access by course');
                                    ?>
                                </li>
                                <li class="mb-2"><i data-lucide="check" style="width:16px;height:16px;color:var(--bs-success);" class="me-2"></i><?php echo $pkg->duration_days; ?> <?php echo t('hari akses', 'days access'); ?></li>
                                <li class="mb-2"><i data-lucide="check" style="width:16px;height:16px;color:var(--bs-success);" class="me-2"></i><?php echo t('Sertifikat (jika tersedia)', 'Certificate (if available)'); ?></li>
                            </ul>
                            <div class="d-grid gap-2">
                                <a href="<?php echo base_url('subscription/buy/' . $pkg->slug); ?>" class="btn <?php echo $pkg->access_scope === 'all' ? 'btn-primary' : 'btn-outline-primary'; ?> rounded-pill">
                                    <?php echo t('Berlangganan', 'Subscribe'); ?>
                                </a>
                                <?php if ($six): ?>
                                    <a href="<?php echo base_url('subscription/buy/' . $pkg->slug . '/6'); ?>" class="btn btn-outline-success rounded-pill small"><?php echo t('Langganan 6 Bulan', '6 Month Subscription'); ?></a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

</div>