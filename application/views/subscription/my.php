<div class="container py-5">
    <div class="mb-5">
        <h1 class="display-6 fw-bold"><?php echo t('Langganan Saya', 'My Subscriptions'); ?></h1>
        <p class="text-muted"><?php echo t('Daftar riwayat paket langganan aktif dan tidak aktif Anda.', 'List of your active and inactive subscription plans.'); ?></p>
    </div>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 p-4">
                <?php if (empty($subscriptions)): ?>
                    <div class="text-center py-5 text-muted">
                        <i data-lucide="layers" style="width:48px;height:48px;"></i>
                        <p class="mt-3 mb-0"><?php echo t('Anda belum memiliki riwayat langganan.', 'You have no subscription history.'); ?></p>
                        <a href="<?php echo base_url('subscription'); ?>" class="btn btn-primary btn-sm rounded-pill mt-3"><?php echo t('Pilih Paket', 'Choose Package'); ?></a>
                    </div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table align-middle">
                            <thead>
                                <tr>
                                    <th><?php echo t('Paket', 'Package'); ?></th>
                                    <th><?php echo t('Mulai', 'Started'); ?></th>
                                    <th><?php echo t('Selesai', 'Expires'); ?></th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($subscriptions as $sub): ?>
                                    <tr>
                                        <td>
                                            <div class="fw-bold"><?php echo htmlspecialchars($sub->name); ?></div>
                                            <small class="text-muted">
                                                <?php
                                                if ($sub->access_scope === 'all') echo t('Semua Konten', 'All Content');
                                                elseif ($sub->access_scope === 'category') echo t('Per Kategori', 'By Category');
                                                else echo t('Per Kursus', 'By Course');
                                                ?>
                                            </small>
                                        </td>
                                        <td><?php echo date('d M Y H:i', strtotime($sub->started_at)); ?></td>
                                        <td><?php echo $sub->expires_at ? date('d M Y H:i', strtotime($sub->expires_at)) : '-'; ?></td>
                                        <td>
                                            <?php if ($sub->status === 'active'): ?>
                                                <span class="badge bg-success rounded-pill px-3 py-1"><?php echo t('Aktif', 'Active'); ?></span>
                                            <?php elseif ($sub->status === 'expired'): ?>
                                                <span class="badge bg-secondary rounded-pill px-3 py-1"><?php echo t('Habis', 'Expired'); ?></span>
                                            <?php else: ?>
                                                <span class="badge bg-danger rounded-pill px-3 py-1"><?php echo t('Dibatalkan', 'Cancelled'); ?></span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-light">
                <h5 class="fw-bold mb-3"><?php echo t('Punya Pertanyaan?', 'Have Questions?'); ?></h5>
                <p class="small text-muted mb-3"><?php echo t('Bagaimana paket langganan bekerja? Anda bisa mengakses materi selama masa langganan aktif. Begitu habis, akses akan ditutup kecuali diperpanjang.', 'How do subscription plans work? You can access courses during the active subscription period. Once expired, access is revoked unless renewed.'); ?></p>
                <a href="<?php echo base_url('subscription'); ?>" class="btn btn-outline-primary btn-sm rounded-pill w-100"><?php echo t('Lihat Paket Langganan', 'View Subscription Plans'); ?></a>
            </div>
        </div>
    </div>
</div>