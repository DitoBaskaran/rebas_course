<div class="container-fluid px-0">
    <!-- Page Header -->
    <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between mb-5 gap-3">
        <div>
            <span class="text-primary fw-semibold small text-uppercase tracking-wide d-block mb-1">Panel Admin</span>
            <h1 class="display-6 fw-extrabold text-dark mb-1 lh-sm" style="letter-spacing: -0.03em;"><?php echo t('Dashboard', 'Dashboard'); ?></h1>
            <p class="text-secondary mb-0"><?php echo t('Kelola kelas, seminar, dan verifikasi pembayaran.', 'Manage courses, seminars, and payment verification.'); ?></p>
        </div>
        <div class="d-flex gap-2">
            <a href="<?php echo base_url('admin/courses'); ?>" class="btn btn-dark btn-sm px-3 rounded-pill shadow-sm d-flex align-items-center gap-1">
                <i data-lucide="book-open" style="width:16px;height:16px;"></i> <?php echo t('Kelas', 'Courses'); ?>
            </a>
            <a href="<?php echo base_url('admin/seminars'); ?>" class="btn btn-outline-dark btn-sm px-3 rounded-pill d-flex align-items-center gap-1">
                <i data-lucide="calendar" style="width:16px;height:16px;"></i> <?php echo t('Seminar', 'Seminars'); ?>
            </a>
            <a href="<?php echo base_url('admin/settings/general'); ?>" class="btn btn-outline-secondary btn-sm px-3 rounded-pill d-flex align-items-center gap-1">
                <i data-lucide="settings" style="width:16px;height:16px;"></i>
            </a>
        </div>
    </div>

    <!-- Bento Grid Stats -->
    <div class="bento-grid bento-grid-3 mb-4">
        <div class="bento-card blob-primary d-flex align-items-center gap-3 flex-row">
            <div class="bento-icon bg-primary-subtle text-primary">
                <i data-lucide="book-open" style="width:22px;height:22px;"></i>
            </div>
            <div>
                <div class="bento-label"><?php echo t('Total Kelas', 'Total Courses'); ?></div>
                <div class="bento-value"><?php echo $total_courses; ?></div>
            </div>
        </div>
        <div class="bento-card blob-warning d-flex align-items-center gap-3 flex-row">
            <div class="bento-icon bg-warning-subtle text-warning">
                <i data-lucide="calendar" style="width:22px;height:22px;"></i>
            </div>
            <div>
                <div class="bento-label"><?php echo t('Total Seminar', 'Total Seminars'); ?></div>
                <div class="bento-value"><?php echo $total_seminars; ?></div>
            </div>
        </div>
        <div class="bento-card blob-success d-flex align-items-center gap-3 flex-row">
            <div class="bento-icon bg-success-subtle text-success">
                <i data-lucide="users" style="width:22px;height:22px;"></i>
            </div>
            <div>
                <div class="bento-label"><?php echo t('Siswa', 'Students'); ?></div>
                <div class="bento-value"><?php echo $total_students; ?></div>
            </div>
        </div>
    </div>

    <!-- Chart + Quick Actions -->
    <div class="bento-grid bento-grid-2-1 mb-4">
        <div class="bento-card">
            <div class="d-flex align-items-center justify-content-between mb-4">
                <h5 class="fw-bold text-dark mb-0 d-flex align-items-center gap-2">
                    <span class="d-inline-flex align-items-center justify-content-center bg-primary-subtle text-primary rounded-2" style="width: 32px; height: 32px;"><i data-lucide="chart-line" style="width:18px;height:18px;"></i></span>
                    <span><?php echo t('Analytics Pendaftaran', 'Enrollment Analytics'); ?></span>
                </h5>
            </div>
            <div class="chart-container">
                <canvas id="enrollmentChart"></canvas>
            </div>
        </div>
        <div class="bento-card d-flex flex-column">
            <h5 class="fw-bold text-dark mb-3 d-flex align-items-center gap-2">
                <span class="d-inline-flex align-items-center justify-content-center bg-info-subtle text-info rounded-2" style="width: 32px; height: 32px;"><i data-lucide="zap" style="width:18px;height:18px;"></i></span>
                <span><?php echo t('Aksi Cepat', 'Quick Actions'); ?></span>
            </h5>
            <div class="d-flex flex-column gap-2 mt-2">
                <a href="<?php echo base_url('admin/create_course'); ?>" class="d-flex align-items-center gap-3 p-3 rounded-3 text-decoration-none transition-smooth" style="background: var(--primary-light); color: var(--primary);">
                    <i data-lucide="plus-circle" style="width:20px;height:20px;"></i>
                    <span class="fw-semibold small"><?php echo t('Buat Kelas Baru', 'Create New Course'); ?></span>
                </a>
                <a href="<?php echo base_url('admin/create_seminar'); ?>" class="d-flex align-items-center gap-3 p-3 rounded-3 text-decoration-none transition-smooth" style="background: var(--gray-100); color: var(--gray-700);">
                    <i data-lucide="plus-circle" style="width:20px;height:20px;"></i>
                    <span class="fw-semibold small"><?php echo t('Buat Seminar Baru', 'Create New Seminar'); ?></span>
                </a>
                <a href="<?php echo base_url('admin/settings/appearance'); ?>" class="d-flex align-items-center gap-3 p-3 rounded-3 text-decoration-none transition-smooth" style="background: var(--gray-100); color: var(--gray-700);">
                    <i data-lucide="palette" style="width:20px;height:20px;"></i>
                    <span class="fw-semibold small"><?php echo t('Ubah Tampilan', 'Change Appearance'); ?></span>
                </a>
            </div>
        </div>
    </div>

    <!-- Transactions -->
    <div class="bento-card">
        <h5 class="fw-bold text-dark mb-4 d-flex align-items-center gap-2">
            <span class="icon-32 bg-warning-subtle text-warning rounded-2"><i data-lucide="arrow-left-right" style="width:18px;height:18px;"></i></span>
            <span><?php echo t('Verifikasi Transaksi', 'Transaction Verification'); ?></span>
        </h5>
        <?php if (empty($transactions)): ?>
            <div class="empty-state">
                <i data-lucide="receipt" style="width:48px;height:48px;color:var(--gray-300);"></i>
                <h5><?php echo t('Belum Ada Transaksi', 'No Transactions Yet'); ?></h5>
                <p><?php echo t('Transaksi akan muncul disini setelah ada pembelian.', 'Transactions will appear here after purchases.'); ?></p>
            </div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table-modern">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th><?php echo t('Siswa', 'Student'); ?></th>
                            <th><?php echo t('Tipe', 'Type'); ?></th>
                            <th><?php echo t('Nominal', 'Amount'); ?></th>
                            <th><?php echo t('Channel', 'Channel'); ?></th>
                            <th><?php echo t('Status', 'Status'); ?></th>
                            <th class="text-center col-w-120"><?php echo t('Aksi', 'Action'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($transactions as $tx): ?>
                            <tr>
                                <td class="fw-bold text-dark">#<?php echo $tx->id; ?></td>
                                <td><span class="fw-semibold text-dark"><?php echo htmlspecialchars($tx->user_name); ?></span></td>
                                <td><span class="badge bg-secondary badge-modern text-uppercase"><?php echo $tx->item_type; ?></span></td>
                                <td class="fw-bold text-dark">Rp <?php echo number_format($tx->amount, 0, ',', '.'); ?></td>
                                <td>
                                    <span class="small text-muted"><?php echo !empty($tx->payment_channel) ? strtoupper(str_replace('_', ' ', $tx->payment_channel)) : (empty($tx->payment_proof) ? '-' : 'Transfer'); ?></span>
                                </td>
                                <td>
                                    <?php if ($tx->status === 'approved'): ?>
                                        <span class="badge bg-success badge-modern"><i class="fas fa-check-circle me-1"></i> Approved</span>
                                    <?php elseif ($tx->status === 'rejected'): ?>
                                        <span class="badge bg-danger badge-modern"><i class="fas fa-times-circle me-1"></i> Rejected</span>
                                    <?php else: ?>
                                        <span class="badge bg-warning text-dark badge-modern"><i class="fas fa-clock me-1"></i> Pending</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <?php if ($tx->status === 'pending'): ?>
                                        <div class="d-flex justify-content-center gap-1">
                                            <a href="<?php echo base_url('admin/approve_transaction/' . $tx->id); ?>" class="btn btn-success btn-sm px-2" data-confirm="<?php echo t('Setujui transaksi ini?', 'Approve this transaction?'); ?>" data-confirm-button="<?php echo t('Ya, Setujui', 'Yes, Approve'); ?>" data-icon="question" title="<?php echo t('Setujui', 'Approve'); ?>">
                                                <i class="fas fa-check"></i>
                                            </a>
                                            <a href="<?php echo base_url('admin/reject_transaction/' . $tx->id); ?>" class="btn btn-outline-danger btn-sm px-2" data-confirm="<?php echo t('Tolak transaksi ini?', 'Reject this transaction?'); ?>" data-confirm-button="<?php echo t('Ya, Tolak', 'Yes, Reject'); ?>" data-icon="warning" title="<?php echo t('Tolak', 'Reject'); ?>">
                                                <i class="fas fa-times"></i>
                                            </a>
                                        </div>
                                    <?php else: ?>
                                        <span class="text-muted small">-</span>
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
                    borderColor: '#0d6efd',
                    backgroundColor: 'rgba(13, 110, 253, 0.08)',
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: '#0d6efd',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointRadius: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: { color: 'rgba(0,0,0,0.04)' },
                        ticks: { stepSize: 5 }
                    },
                    x: {
                        grid: { display: false }
                    }
                }
            }
        });
    }
});
</script>