<div class="container-fluid py-4" style="max-width: 1400px;">
    <!-- Header -->
    <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between mb-4 gap-3">
        <div>
            <div style="color: #f97316; font-weight: 700; font-size: 0.7rem; text-transform: uppercase; letter-spacing: 0.08em; margin-bottom: 0.15rem;"><?php echo t('Panel Admin', 'Admin Panel'); ?></div>
            <h4 class="fw-extrabold mb-0" style="color: #1c1917; letter-spacing: -0.02em; font-size: 1.4rem;">
                <?php echo t('Dashboard', 'Dashboard'); ?>
            </h4>
            <p style="color: #78716c; font-size: 0.82rem; margin-bottom: 0;">
                <?php if ($current_role === 'teacher'): ?>
                    <?php echo t('Kelola kelas dan seminar Anda.', 'Manage your courses and seminars.'); ?>
                <?php else: ?>
                    <?php echo t('Kelola kelas, seminar, dan verifikasi pembayaran.', 'Manage courses, seminars, and payment verification.'); ?>
                <?php endif; ?>
            </p>
        </div>
        <div class="d-flex gap-2">
            <a href="<?php echo base_url('admin/courses'); ?>" class="btn px-3 py-2 fw-semibold rounded-pill d-flex align-items-center gap-1" style="background: #f97316; color: #fff; font-size: 0.78rem;">
                <i class="fas fa-book-open" style="font-size: 0.7rem;"></i> <?php echo t('Kelas', 'Courses'); ?>
            </a>
            <a href="<?php echo base_url('admin/seminars'); ?>" class="btn px-3 py-2 fw-semibold rounded-pill d-flex align-items-center gap-1" style="border: 1px solid #e7e5e4; color: #57534e; font-size: 0.78rem;">
                <i class="fas fa-calendar" style="font-size: 0.7rem;"></i> <?php echo t('Seminar', 'Seminars'); ?>
            </a>
            <?php if ($current_role === 'admin'): ?>
            <a href="<?php echo base_url('admin/settings/general'); ?>" class="btn px-3 py-2 fw-semibold rounded-pill d-flex align-items-center gap-1" style="border: 1px solid #e7e5e4; color: #57534e; font-size: 0.78rem;">
                <i class="fas fa-cog" style="font-size: 0.7rem;"></i>
            </a>
            <?php endif; ?>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="row g-3 mb-4">
        <div class="col-6 col-md-3">
            <div class="border rounded-3 p-3" style="border-color: #e7e5e4; border-radius: 12px;">
                <div class="d-flex align-items-center gap-3">
                    <div class="d-inline-flex align-items-center justify-content-center rounded-2" style="width: 40px; height: 40px; background: #fff7ed;">
                        <i class="fas fa-book-open" style="color: #f97316; font-size: 0.9rem;"></i>
                    </div>
                    <div>
                        <div class="fw-bold" style="color: #1c1917; font-size: 1.2rem; line-height: 1;"><?php echo $total_courses; ?></div>
                        <small style="color: #a8a29e; font-size: 0.7rem;"><?php echo t('Total Kelas', 'Total Courses'); ?></small>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="border rounded-3 p-3" style="border-color: #e7e5e4; border-radius: 12px;">
                <div class="d-flex align-items-center gap-3">
                    <div class="d-inline-flex align-items-center justify-content-center rounded-2" style="width: 40px; height: 40px; background: #fef3c7;">
                        <i class="fas fa-calendar" style="color: #d97706; font-size: 0.9rem;"></i>
                    </div>
                    <div>
                        <div class="fw-bold" style="color: #1c1917; font-size: 1.2rem; line-height: 1;"><?php echo $total_seminars; ?></div>
                        <small style="color: #a8a29e; font-size: 0.7rem;"><?php echo t('Total Seminar', 'Total Seminars'); ?></small>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="border rounded-3 p-3" style="border-color: #e7e5e4; border-radius: 12px;">
                <div class="d-flex align-items-center gap-3">
                    <div class="d-inline-flex align-items-center justify-content-center rounded-2" style="width: 40px; height: 40px; background: #f0fdfa;">
                        <i class="fas fa-users" style="color: #10b981; font-size: 0.9rem;"></i>
                    </div>
                    <div>
                        <div class="fw-bold" style="color: #1c1917; font-size: 1.2rem; line-height: 1;"><?php echo $total_students; ?></div>
                        <small style="color: #a8a29e; font-size: 0.7rem;"><?php echo t('Siswa', 'Students'); ?></small>
                    </div>
                </div>
            </div>
        </div>
        <?php if ($current_role === 'admin'): ?>
        <div class="col-6 col-md-3">
            <div class="border rounded-3 p-3" style="border-color: #e7e5e4; border-radius: 12px;">
                <div class="d-flex align-items-center gap-3">
                    <div class="d-inline-flex align-items-center justify-content-center rounded-2" style="width: 40px; height: 40px; background: #faf5ff;">
                        <i class="fas fa-wallet" style="color: #a855f7; font-size: 0.9rem;"></i>
                    </div>
                    <div>
                        <div class="fw-bold" style="color: #1c1917; font-size: 1.2rem; line-height: 1;">Rp <?php echo number_format($total_revenue / 1000000, 1, ',', '.'); ?>jt</div>
                        <small style="color: #a8a29e; font-size: 0.7rem;"><?php echo t('Total Revenue', 'Total Revenue'); ?></small>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>
    </div>

    <!-- Chart + Quick Actions -->
    <div class="row g-3 mb-4">
        <div class="col-lg-8">
            <div class="border rounded-3 p-3 h-100" style="border-color: #e7e5e4; border-radius: 12px;">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <h6 class="fw-bold mb-0 d-flex align-items-center gap-2" style="color: #1c1917; font-size: 0.88rem;">
                        <i class="fas fa-chart-line" style="color: #f97316; font-size: 0.75rem;"></i>
                        <?php echo t('Analytics Pendaftaran', 'Enrollment Analytics'); ?>
                    </h6>
                </div>
                <div style="position: relative; width: 100%; height: 240px;">
                    <canvas id="enrollmentChart"></canvas>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="border rounded-3 p-3 h-100" style="border-color: #e7e5e4; border-radius: 12px;">
                <h6 class="fw-bold mb-3 d-flex align-items-center gap-2" style="color: #1c1917; font-size: 0.88rem;">
                    <i class="fas fa-bolt" style="color: #10b981; font-size: 0.75rem;"></i>
                    <?php echo t('Aksi Cepat', 'Quick Actions'); ?>
                </h6>
                <div class="d-flex flex-column gap-2">
                    <a href="<?php echo base_url('admin/create_course'); ?>" class="d-flex align-items-center gap-3 p-3 rounded-3 text-decoration-none fw-semibold" style="background: #fff7ed; color: #f97316; font-size: 0.8rem; transition: all 0.15s;">
                        <i class="fas fa-plus-circle" style="font-size: 0.85rem;"></i>
                        <span><?php echo t('Buat Kelas Baru', 'New Course'); ?></span>
                    </a>
                    <a href="<?php echo base_url('admin/create_seminar'); ?>" class="d-flex align-items-center gap-3 p-3 rounded-3 text-decoration-none fw-semibold" style="background: #f5f5f4; color: #57534e; font-size: 0.8rem; transition: all 0.15s;">
                        <i class="fas fa-plus-circle" style="font-size: 0.85rem;"></i>
                        <span><?php echo t('Buat Seminar Baru', 'New Seminar'); ?></span>
                    </a>
                    <?php if ($current_role === 'admin'): ?>
                    <a href="<?php echo base_url('admin/transactions'); ?>" class="d-flex align-items-center gap-3 p-3 rounded-3 text-decoration-none fw-semibold" style="background: #f5f5f4; color: #57534e; font-size: 0.8rem; transition: all 0.15s;">
                        <i class="fas fa-receipt" style="font-size: 0.85rem;"></i>
                        <span><?php echo t('Verifikasi Transaksi', 'Verify Trx'); ?></span>
                    </a>
                    <a href="<?php echo base_url('admin/settings/appearance'); ?>" class="d-flex align-items-center gap-3 p-3 rounded-3 text-decoration-none fw-semibold" style="background: #f5f5f4; color: #57534e; font-size: 0.8rem; transition: all 0.15s;">
                        <i class="fas fa-palette" style="font-size: 0.85rem;"></i>
                        <span><?php echo t('Ubah Tampilan', 'Appearance'); ?></span>
                    </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Transactions -->
    <?php if ($current_role === 'admin'): ?>
    <div class="border rounded-3" style="border-color: #e7e5e4; border-radius: 12px; overflow: hidden;">
        <div class="d-flex justify-content-between align-items-center p-3" style="border-bottom: 1px solid #f0eeeb;">
            <h6 class="fw-bold mb-0 d-flex align-items-center gap-2" style="color: #1c1917; font-size: 0.88rem;">
                <i class="fas fa-receipt" style="color: #78716c; font-size: 0.75rem;"></i>
                <?php echo t('Verifikasi Transaksi', 'Transaction Verification'); ?>
                <span class="px-2 py-1 rounded-pill fw-semibold" style="background: #fff7ed; color: #f97316; font-size: 0.6rem;"><?php echo count($transactions); ?></span>
            </h6>
            <a href="<?php echo base_url('admin/transactions'); ?>" class="fw-semibold text-decoration-none" style="color: #f97316; font-size: 0.75rem;">
                <?php echo t('Lihat Semua', 'View All'); ?> <i class="fas fa-chevron-right" style="font-size: 0.5rem;"></i>
            </a>
        </div>
        <?php if (empty($transactions)): ?>
        <div class="p-5 text-center">
            <div style="font-size: 2rem; color: #d6d3d1; margin-bottom: 0.5rem;"><i class="fas fa-receipt"></i></div>
            <h6 class="fw-bold" style="color: #1c1917;"><?php echo t('Belum Ada Transaksi', 'No Transactions Yet'); ?></h6>
            <p style="color: #78716c; font-size: 0.82rem;"><?php echo t('Transaksi akan muncul disini setelah ada pembelian.', 'Transactions will appear after purchases.'); ?></p>
        </div>
        <?php else: ?>
        <div class="table-responsive p-0">
            <table class="table mb-0" style="font-size: 0.8rem;">
                <thead>
                    <tr>
                        <th style="font-weight: 600; color: #78716c; font-size: 0.68rem; border-color: #e7e5e4; padding: 0.7rem 1rem; background: #fafaf9; text-transform: uppercase; letter-spacing: 0.05em;">ID</th>
                        <th style="font-weight: 600; color: #78716c; font-size: 0.68rem; border-color: #e7e5e4; padding: 0.7rem 1rem; background: #fafaf9; text-transform: uppercase; letter-spacing: 0.05em;"><?php echo t('Siswa', 'Student'); ?></th>
                        <th style="font-weight: 600; color: #78716c; font-size: 0.68rem; border-color: #e7e5e4; padding: 0.7rem 1rem; background: #fafaf9; text-transform: uppercase; letter-spacing: 0.05em;"><?php echo t('Tipe', 'Type'); ?></th>
                        <th style="font-weight: 600; color: #78716c; font-size: 0.68rem; border-color: #e7e5e4; padding: 0.7rem 1rem; background: #fafaf9; text-transform: uppercase; letter-spacing: 0.05em;"><?php echo t('Nominal', 'Amount'); ?></th>
                        <th style="font-weight: 600; color: #78716c; font-size: 0.68rem; border-color: #e7e5e4; padding: 0.7rem 1rem; background: #fafaf9; text-transform: uppercase; letter-spacing: 0.05em;"><?php echo t('Channel', 'Channel'); ?></th>
                        <th style="font-weight: 600; color: #78716c; font-size: 0.68rem; border-color: #e7e5e4; padding: 0.7rem 1rem; background: #fafaf9; text-transform: uppercase; letter-spacing: 0.05em;"><?php echo t('Status', 'Status'); ?></th>
                        <th style="font-weight: 600; color: #78716c; font-size: 0.68rem; border-color: #e7e5e4; padding: 0.7rem 1rem; background: #fafaf9; text-transform: uppercase; letter-spacing: 0.05em; text-align: center;"><?php echo t('Aksi', 'Action'); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($transactions as $tx): ?>
                        <tr>
                            <td style="border-color: #f0eeeb; padding: 0.65rem 1rem; font-weight: 700; color: #1c1917;">#<?php echo $tx->id; ?></td>
                            <td style="border-color: #f0eeeb; padding: 0.65rem 1rem;"><span class="fw-semibold" style="color: #1c1917;"><?php echo htmlspecialchars($tx->user_name); ?></span></td>
                            <td style="border-color: #f0eeeb; padding: 0.65rem 1rem;">
                                <span class="px-2 py-1 rounded-pill fw-semibold" style="background: #f5f5f4; color: #57534e; font-size: 0.65rem; text-transform: uppercase;">
                                    <?php echo $tx->item_type; ?>
                                </span>
                            </td>
                            <td style="border-color: #f0eeeb; padding: 0.65rem 1rem; font-weight: 700; color: #1c1917;">
                                Rp <?php echo number_format($tx->amount, 0, ',', '.'); ?>
                            </td>
                            <td style="border-color: #f0eeeb; padding: 0.65rem 1rem;">
                                <span style="color: #78716c; font-size: 0.75rem;">
                                    <?php echo !empty($tx->payment_channel) ? strtoupper(str_replace('_', ' ', $tx->payment_channel)) : (empty($tx->payment_proof) ? '-' : 'Transfer'); ?>
                                </span>
                            </td>
                            <td style="border-color: #f0eeeb; padding: 0.65rem 1rem;">
                                <?php if ($tx->status === 'approved'): ?>
                                    <span class="px-2 py-1 rounded-pill fw-semibold" style="background: #f0fdfa; color: #10b981; font-size: 0.65rem;">
                                        <i class="fas fa-check-circle me-1" style="font-size: 0.55rem;"></i> Approved
                                    </span>
                                <?php elseif ($tx->status === 'rejected'): ?>
                                    <span class="px-2 py-1 rounded-pill fw-semibold" style="background: #fef2f2; color: #f43f5e; font-size: 0.65rem;">
                                        <i class="fas fa-times-circle me-1" style="font-size: 0.55rem;"></i> Rejected
                                    </span>
                                <?php else: ?>
                                    <span class="px-2 py-1 rounded-pill fw-semibold" style="background: #fff7ed; color: #f97316; font-size: 0.65rem;">
                                        <i class="fas fa-clock me-1" style="font-size: 0.55rem;"></i> Pending
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td style="border-color: #f0eeeb; padding: 0.65rem 1rem; text-align: center;">
                                <?php if ($tx->status === 'pending'): ?>
                                    <div class="d-flex justify-content-center gap-1">
                                        <a href="<?php echo base_url('admin/approve_transaction/' . $tx->id); ?>" class="btn btn-sm rounded-pill px-2 fw-semibold d-inline-flex align-items-center" style="background: #f0fdfa; color: #10b981; font-size: 0.68rem;" data-confirm="<?php echo t('Setujui transaksi ini?', 'Approve this transaction?'); ?>" data-confirm-button="<?php echo t('Ya, Setujui', 'Yes, Approve'); ?>" data-icon="question" title="<?php echo t('Setujui', 'Approve'); ?>">
                                            <i class="fas fa-check"></i>
                                        </a>
                                        <a href="<?php echo base_url('admin/reject_transaction/' . $tx->id); ?>" class="btn btn-sm rounded-pill px-2 fw-semibold d-inline-flex align-items-center" style="border: 1px solid #fca5a5; color: #f43f5e; font-size: 0.68rem;" data-confirm="<?php echo t('Tolak transaksi ini?', 'Reject this transaction?'); ?>" data-confirm-button="<?php echo t('Ya, Tolak', 'Yes, Reject'); ?>" data-icon="warning" title="<?php echo t('Tolak', 'Reject'); ?>">
                                            <i class="fas fa-times"></i>
                                        </a>
                                    </div>
                                <?php else: ?>
                                    <span style="color: #a8a29e; font-size: 0.72rem;">-</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php endif; ?>
    </div>
    <?php endif; ?>
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var ctx = document.getElementById('enrollmentChart');
    if (ctx) {
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: <?php echo $chart_labels; ?>,
                datasets: [{
                    label: '<?php echo t('Pendaftaran', 'Enrollments'); ?>',
                    data: <?php echo $chart_data; ?>,
                    borderColor: '#f97316',
                    backgroundColor: function(ctx) {
                        var g = ctx.chart.ctx.createLinearGradient(0, 0, 0, 240);
                        g.addColorStop(0, 'rgba(249,115,22,0.15)');
                        g.addColorStop(1, 'rgba(249,115,22,0)');
                        return g;
                    },
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: '#f97316',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointRadius: 4,
                    pointHoverRadius: 6,
                    borderWidth: 2.5
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: '#1c1917',
                        cornerRadius: 8,
                        padding: 8,
                        bodyFont: { size: 12 },
                        displayColors: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: { color: 'rgba(0,0,0,0.04)', drawBorder: false },
                        ticks: { stepSize: 5, color: '#a8a29e', font: { size: 10 } }
                    },
                    x: {
                        grid: { display: false },
                        ticks: { color: '#a8a29e', font: { size: 10 } }
                    }
                }
            }
        });
    }
});
</script>
