<div class="container py-5">
    <h1 class="display-6 fw-bold mb-2"><?php echo t('Saldo Menit', 'Minute Balance'); ?></h1>
    <p class="text-muted mb-5"><?php echo t('Beli menit akses untuk menonton materi apa pun secara bebas. Menit akan berkurang secara real-time saat Anda menonton.', 'Buy minutes to freely access any content. Minutes are consumed in real-time as you watch.'); ?></p>

    <!-- Current Balance Card -->
    <div class="row g-4 mb-5">
        <div class="col-md-6 col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 p-4 text-center bg-success bg-opacity-10">
                <h6 class="text-success fw-semibold mb-1"><?php echo t('Sisa Saldo', 'Remaining Balance'); ?></h6>
                <div class="display-4 fw-bold text-success mb-0" id="remainingBalance"><?php echo format_seconds_for_timer($balance->balance_seconds ?? 0); ?></div>
                <small class="text-muted"><?php echo t('jam:menit:detik', 'hh:mm:ss'); ?></small>
            </div>
        </div>
        <div class="col-md-6 col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 p-4 text-center bg-primary bg-opacity-10">
                <h6 class="text-primary fw-semibold mb-1"><?php echo t('Total Dibeli', 'Total Purchased'); ?></h6>
                <div class="display-6 fw-bold text-primary mb-0"><?php echo format_duration($balance->total_purchased_seconds ?? 0); ?></div>
            </div>
        </div>
        <div class="col-md-6 col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 p-4 text-center bg-warning bg-opacity-10">
                <h6 class="text-warning fw-semibold mb-1"><?php echo t('Total Terpakai', 'Total Used'); ?></h6>
                <div class="display-6 fw-bold text-warning mb-0"><?php echo format_duration($balance->total_used_seconds ?? 0); ?></div>
            </div>
        </div>
    </div>

    <!-- Buy More Bundles -->
    <h3 class="fw-bold mb-3"><?php echo t('Beli Menit', 'Buy Minutes'); ?></h3>
    <div class="row g-3 mb-5">
        <?php if (empty($bundles)): ?>
            <div class="col-12 text-muted"><?php echo t('Belum ada bundel menit tersedia.', 'No minute bundles available.'); ?></div>
        <?php else: ?>
            <?php foreach ($bundles as $b): ?>
                <div class="col-md-4 col-lg-2">
                    <div class="card border-0 shadow-sm rounded-4 p-3 text-center h-100">
                        <h5 class="fw-bold mb-1"><?php echo $b->minutes; ?> <small class="text-muted fw-normal"><?php echo t('menit', 'min'); ?></small></h5>
                        <p class="fw-bold text-success mb-2">Rp <?php echo number_format($b->price, 0, ',', '.'); ?></p>
                        <a href="<?php echo base_url('minute_balance/buy/' . $b->id); ?>" class="btn btn-outline-success btn-sm rounded-pill w-100"><?php echo t('Beli', 'Buy'); ?></a>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <!-- Consumption Log -->
    <h4 class="fw-bold mb-3"><?php echo t('Riwayat Pemakaian', 'Usage History'); ?></h4>
    <div class="card border-0 shadow-sm rounded-4 p-4">
        <?php if (empty($consumption_logs)): ?>
            <div class="text-center text-muted py-4">
                <i data-lucide="clock" style="width:36px;height:36px;"></i>
                <p class="mt-2 mb-0"><?php echo t('Belum ada pemakaian.', 'No usage yet.'); ?></p>
            </div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th><?php echo t('Kursus / Materi', 'Course / Lesson'); ?></th>
                            <th><?php echo t('Durasi', 'Duration'); ?></th>
                            <th><?php echo t('Saldo Sebelum', 'Before'); ?></th>
                            <th><?php echo t('Saldo Setelah', 'After'); ?></th>
                            <th><?php echo t('Waktu', 'Time'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($consumption_logs as $log): ?>
                            <tr>
                                <td>
                                    <div><?php echo htmlspecialchars($log->course_title ?? t('Tidak diketahui', 'Unknown')); ?></div>
                                    <small class="text-muted"><?php echo htmlspecialchars($log->lesson_title ?? ''); ?></small>
                                </td>
                                <td><?php echo format_duration($log->seconds_consumed); ?></td>
                                <td><?php echo format_duration($log->balance_before); ?></td>
                                <td><?php echo format_duration($log->balance_after); ?></td>
                                <td class="small text-muted"><?php echo date('d M H:i', strtotime($log->created_at)); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>