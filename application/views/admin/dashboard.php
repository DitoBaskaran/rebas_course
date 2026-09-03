<!-- ============================================================
     ADMIN DASHBOARD v3.1 — bento design system
     (mobile & desktop share the same bento blocks, responsive)
     ============================================================ -->
<div class="container-fluid px-0">

    <!-- ============ HEADER ============ -->
    <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between mb-4 gap-3">
        <div>
            <span class="text-primary fw-semibold small text-uppercase tracking-wide d-block mb-1">
                <?php echo $is_teacher ? t('Panel Guru', 'Teacher Panel') : t('Panel Admin', 'Admin Panel'); ?>
            </span>
            <h4 class="fw-extrabold text-dark mb-1 lh-sm" style="letter-spacing:-0.02em;">
                <?php echo t('Dashboard', 'Dashboard'); ?>
            </h4>
            <p class="text-secondary mb-0 small">
                <?php echo $is_teacher
                    ? t('Kelola kelas dan seminar Anda.', 'Manage your courses and seminars.')
                    : t('Kelola kelas, seminar, dan verifikasi pembayaran.', 'Manage courses, seminars, and payment verification.'); ?>
            </p>
        </div>
        <div class="d-flex gap-2 flex-wrap">
            <a href="<?php echo base_url('admin/courses'); ?>" class="btn px-3 py-2 fw-semibold rounded-pill d-flex align-items-center gap-2 btn-dark border-0" style="font-size:0.78rem;">
                <i data-lucide="book-open" style="width:14px;height:14px;"></i> <?php echo t('Kelas', 'Courses'); ?>
            </a>
            <a href="<?php echo base_url('admin/seminars'); ?>" class="btn px-3 py-2 fw-semibold rounded-pill d-flex align-items-center gap-2 border-0" style="background:#E6EBEF;color:#57534e;font-size:0.78rem;">
                <i data-lucide="calendar" style="width:14px;height:14px;"></i> <?php echo t('Seminar', 'Seminars'); ?>
            </a>
            <?php if ($current_role === 'admin'): ?>
            <a href="<?php echo base_url('admin/settings/general'); ?>" class="btn px-3 py-2 fw-semibold rounded-pill d-inline-flex align-items-center justify-content-center border-0" style="background:#E6EBEF;color:#57534e;font-size:0.78rem;" title="<?php echo t('Pengaturan', 'Settings'); ?>">
                <i data-lucide="settings" style="width:15px;height:15px;"></i>
            </a>
            <?php endif; ?>
        </div>
    </div>

    <!-- ============ WELCOME / HERO STRIP ============ -->
    <div class="bento-card mb-4 overflow-hidden" style="background:linear-gradient(120deg,#0D1830 0%,#164e63 100%);border:none;color:#fff;">
        <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3 position-relative" style="z-index:1;">
            <div class="d-flex align-items-center gap-3">
                <span class="d-inline-flex align-items-center justify-content-center rounded-circle fw-bold text-white flex-shrink-0" style="width:52px;height:52px;background:rgba(255,255,255,0.16);font-size:1.25rem;border:1px solid rgba(255,255,255,0.25);">
                    <?php echo strtoupper(substr($this->session->userdata('name'), 0, 1)); ?>
                </span>
                <div>
                    <?php
                    $hour = (int)date('H');
                    if ($hour < 11) $greet = t('Selamat pagi', 'Good morning');
                    elseif ($hour < 15) $greet = t('Selamat siang', 'Good afternoon');
                    elseif ($hour < 19) $greet = t('Selamat sore', 'Good evening');
                    else $greet = t('Selamat malam', 'Good night');
                    ?>
                    <div class="fw-bold" style="font-size:1.15rem;"><?php echo $greet; ?>, <?php echo htmlspecialchars(ucfirst($this->session->userdata('name'))); ?> 👋</div>
                    <div style="color:rgba(255,255,255,0.72);font-size:0.82rem;">
                        <?php echo $is_teacher
                            ? t('Semua konten dan sesimu ada di sini.', 'Your content and sessions are all here.')
                            : t('Ringkasan aktivitas platform hari ini.', 'Today\'s platform activity summary.'); ?>
                    </div>
                </div>
            </div>
            <div class="d-flex gap-2 flex-wrap">
                <?php if ($current_role === 'admin'): ?>
                <a href="<?php echo base_url('admin/transactions'); ?>" class="btn btn-sm fw-semibold rounded-pill d-inline-flex align-items-center gap-2 border-0" style="background:#FBBF24;color:#0D1830;font-size:0.75rem;">
                    <i data-lucide="receipt" style="width:13px;height:13px;"></i> <?php echo t('Verifikasi Transaksi', 'Verify Transactions'); ?>
                </a>
                <?php endif; ?>
                <a href="<?php echo base_url('admin/create_course'); ?>" class="btn btn-sm fw-semibold rounded-pill d-inline-flex align-items-center gap-2 border-0" style="background:rgba(255,255,255,0.14);color:#fff;font-size:0.75rem;">
                    <i data-lucide="plus" style="width:13px;height:13px;"></i> <?php echo t('Konten Baru', 'New Content'); ?>
                </a>
            </div>
        </div>
    </div>

    <!-- ============ STATS (bento) ============ -->
    <div class="bento-grid bento-grid-4 mb-4">
        <div class="bento-card blob-primary">
            <div class="d-flex align-items-center gap-3">
                <div class="bento-icon bg-primary-subtle text-primary"><i data-lucide="book-open" style="width:22px;height:22px;"></i></div>
                <div>
                    <div class="bento-label"><?php echo t('Total Kelas', 'Total Courses'); ?></div>
                    <div class="bento-value"><?php echo $total_courses; ?></div>
                </div>
            </div>
        </div>
        <div class="bento-card blob-warning">
            <div class="d-flex align-items-center gap-3">
                <div class="bento-icon bg-warning-subtle text-warning"><i data-lucide="calendar" style="width:22px;height:22px;"></i></div>
                <div>
                    <div class="bento-label"><?php echo t('Total Seminar', 'Total Seminars'); ?></div>
                    <div class="bento-value"><?php echo $total_seminars; ?></div>
                </div>
            </div>
        </div>
        <div class="bento-card blob-success">
            <div class="d-flex align-items-center gap-3">
                <div class="bento-icon bg-success-subtle text-success"><i data-lucide="users" style="width:22px;height:22px;"></i></div>
                <div>
                    <div class="bento-label"><?php echo t('Siswa', 'Students'); ?></div>
                    <div class="bento-value"><?php echo $total_students; ?></div>
                </div>
            </div>
        </div>
        <?php if ($current_role === 'admin'): ?>
        <div class="bento-card blob-danger">
            <div class="d-flex align-items-center gap-3">
                <div class="bento-icon bg-danger-subtle text-danger"><i data-lucide="wallet" style="width:22px;height:22px;"></i></div>
                <div>
                    <div class="bento-label"><?php echo t('Total Revenue', 'Total Revenue'); ?></div>
                    <div class="bento-value" style="font-size:1.45rem;">Rp <?php echo number_format($total_revenue, 0, ',', '.'); ?></div>
                </div>
            </div>
        </div>
        <?php endif; ?>
    </div>

    <!-- ============ CHART + QUICK ACTIONS ============ -->
    <div class="bento-grid bento-grid-3-1 mb-4">
        <!-- Enrollment chart -->
        <div class="bento-card">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <h6 class="fw-bold text-dark mb-0 d-flex align-items-center gap-2" style="font-size:0.88rem;">
                    <i data-lucide="activity" style="width:17px;height:17px;color:var(--primary);"></i>
                    <?php echo t('Analytics Pendaftaran', 'Enrollment Analytics'); ?>
                </h6>
                <?php if ($current_role === 'admin'): ?>
                <a href="<?php echo base_url('admin/analytics'); ?>" class="fw-semibold text-decoration-none text-primary" style="font-size:0.72rem;">
                    <?php echo t('Analitik', 'Analytics'); ?> <i data-lucide="arrow-right" style="width:12px;height:12px;"></i>
                </a>
                <?php endif; ?>
            </div>
            <div class="chart-container" style="height:250px;"><canvas id="enrollmentChartDesktop"></canvas></div>
        </div>

        <!-- Quick actions -->
        <div class="bento-card">
            <h6 class="fw-bold text-dark mb-3 d-flex align-items-center gap-2" style="font-size:0.88rem;">
                <i data-lucide="zap" style="width:17px;height:17px;color:var(--warning);"></i>
                <?php echo t('Aksi Cepat', 'Quick Actions'); ?>
            </h6>
            <div class="quick-tile-grid">
                <a href="<?php echo base_url('admin/create_course'); ?>" class="quick-tile">
                    <span class="quick-tile-ic" style="background:#E0F2F1;color:#009688;"><i class="fas fa-plus-circle"></i></span>
                    <span class="quick-tile-label"><?php echo t('Buat Kelas', 'New Course'); ?></span>
                </a>
                <a href="<?php echo base_url('admin/create_seminar'); ?>" class="quick-tile">
                    <span class="quick-tile-ic" style="background:#fff7ed;color:#ea580c;"><i class="fas fa-calendar-plus"></i></span>
                    <span class="quick-tile-label"><?php echo t('Buat Seminar', 'New Seminar'); ?></span>
                </a>
                <?php if ($current_role === 'admin'): ?>
                <a href="<?php echo base_url('admin/analytics'); ?>" class="quick-tile">
                    <span class="quick-tile-ic" style="background:#eff6ff;color:#2563eb;"><i class="fas fa-chart-line"></i></span>
                    <span class="quick-tile-label"><?php echo t('Analitik', 'Analytics'); ?></span>
                </a>
                <a href="<?php echo base_url('admin/settings/appearance'); ?>" class="quick-tile">
                    <span class="quick-tile-ic" style="background:#fdf4ff;color:#c026d3;"><i class="fas fa-palette"></i></span>
                    <span class="quick-tile-label"><?php echo t('Tampilan', 'Appearance'); ?></span>
                </a>
                <?php else: ?>
                <a href="<?php echo base_url('admin/submissions'); ?>" class="quick-tile">
                    <span class="quick-tile-ic" style="background:#eff6ff;color:#2563eb;"><i class="fas fa-code"></i></span>
                    <span class="quick-tile-label"><?php echo t('Periksa Tugas', 'Submissions'); ?></span>
                </a>
                <a href="<?php echo base_url('admin/courses'); ?>" class="quick-tile">
                    <span class="quick-tile-ic" style="background:#fdf4ff;color:#c026d3;"><i class="fas fa-book-open"></i></span>
                    <span class="quick-tile-label"><?php echo t('Kelola Konten', 'Manage Content'); ?></span>
                </a>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- ============ TRANSACTIONS ============ -->
    <?php if ($current_role === 'admin'): ?>
    <div class="bento-card p-0">
        <div class="d-flex justify-content-between align-items-center px-4 py-3" style="border-bottom:1px solid var(--card-border,#eef0f3);">
            <h6 class="fw-bold text-dark mb-0 d-flex align-items-center gap-2" style="font-size:0.88rem;">
                <i data-lucide="receipt" style="width:17px;height:17px;color:var(--primary);"></i>
                <?php echo t('Verifikasi Transaksi', 'Transaction Verification'); ?>
                <?php
                    $pending_count = 0;
                    foreach ($transactions as $tx) { if ($tx->status === 'pending') $pending_count++; }
                ?>
                <?php if ($pending_count > 0): ?>
                <span class="badge rounded-pill" style="background:#fff7ed;color:#ea580c;font-size:0.62rem;font-weight:700;">
                    <?php echo $pending_count; ?> <?php echo t('pending', 'pending'); ?>
                </span>
                <?php endif; ?>
            </h6>
            <a href="<?php echo base_url('admin/transactions'); ?>" class="fw-semibold text-decoration-none text-primary d-inline-flex align-items-center gap-1" style="font-size:0.75rem;">
                <?php echo t('Lihat Semua', 'View All'); ?> <i data-lucide="arrow-right" style="width:12px;height:12px;"></i>
            </a>
        </div>
        <?php if (empty($transactions)): ?>
        <div class="p-5 text-center">
            <div style="font-size:2rem;color:#cbd5e1;margin-bottom:0.5rem;"><i class="fas fa-receipt"></i></div>
            <h6 class="fw-bold" style="color:var(--gray-900,#0D1830);"><?php echo t('Belum Ada Transaksi', 'No Transactions Yet'); ?></h6>
            <p style="color:var(--gray-500,#78716c);font-size:0.82rem;"><?php echo t('Transaksi akan muncul disini setelah ada pembelian.', 'Transactions will appear after purchases.'); ?></p>
        </div>
        <?php else: ?>
        <div>
            <?php foreach (array_slice($transactions, 0, 5) as $tx): ?>
                <?php
                    $avatar_bg = '#E6EBEF'; $avatar_tx = '#57534e';
                    if ($tx->status === 'approved') { $avatar_bg = '#E0F2F1'; $avatar_tx = '#009688'; }
                    elseif ($tx->status === 'rejected') { $avatar_bg = '#fef2f2'; $avatar_tx = '#f43f5e'; }
                    else { $avatar_bg = '#fff7ed'; $avatar_tx = '#d97706'; }
                    $channel = !empty($tx->payment_channel) ? strtoupper(str_replace('_', ' ', $tx->payment_channel)) : (empty($tx->payment_proof) ? 'Transfer' : 'Transfer');
                    $time = !empty($tx->created_at) ? date('d M H:i', strtotime($tx->created_at)) : '';
                ?>
                <div class="mob-list-row" style="cursor:default;padding:0.85rem 1.25rem;">
                    <div class="mob-avatar" style="background:<?php echo $avatar_bg; ?>;color:<?php echo $avatar_tx; ?>;font-size:0.85rem;">
                        <i class="fas fa-receipt"></i>
                    </div>
                    <div class="mob-list-body">
                        <div class="mob-list-title"><?php echo htmlspecialchars($tx->user_name); ?></div>
                        <div class="mob-list-sub">#<?php echo $tx->id; ?> · <?php echo htmlspecialchars($tx->item_type); ?> · <?php echo $channel; ?><?php echo $time ? ' · ' . $time : ''; ?></div>
                    </div>
                    <div class="d-flex align-items-center gap-2 flex-shrink-0">
                        <span class="fw-bold" style="color:var(--gray-900,#0D1830);font-size:0.82rem;">Rp <?php echo number_format($tx->amount, 0, ',', '.'); ?></span>
                        <?php if ($tx->status === 'pending'): ?>
                        <a href="<?php echo base_url('admin/approve_transaction/' . $tx->id); ?>" class="btn btn-sm rounded-pill px-2 fw-semibold d-inline-flex align-items-center" style="background:#E0F2F1;color:#009688;font-size:0.68rem;" data-confirm="<?php echo t('Setujui transaksi ini?', 'Approve this transaction?'); ?>" data-confirm-button="<?php echo t('Ya, Setujui', 'Yes, Approve'); ?>" data-icon="question" title="<?php echo t('Setujui', 'Approve'); ?>"><i class="fas fa-check"></i></a>
                        <a href="<?php echo base_url('admin/reject_transaction/' . $tx->id); ?>" class="btn btn-sm rounded-pill px-2 fw-semibold d-inline-flex align-items-center" style="border:1px solid #fca5a5;color:#f43f5e;font-size:0.68rem;" data-confirm="<?php echo t('Tolak transaksi ini?', 'Reject this transaction?'); ?>" data-confirm-button="<?php echo t('Ya, Tolak', 'Yes, Reject'); ?>" data-icon="warning" title="<?php echo t('Tolak', 'Reject'); ?>"><i class="fas fa-times"></i></a>
                        <?php else: ?>
                            <?php if ($tx->status === 'approved'): ?>
                                <span class="mob-chip mob-chip-green">Approved</span>
                            <?php elseif ($tx->status === 'rejected'): ?>
                                <span class="mob-chip mob-chip-red">Rejected</span>
                            <?php else: ?>
                                <span class="mob-chip mob-chip-amber">Pending</span>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </div>
    <?php endif; ?>
</div>

<!-- Chart.js — dua canvas (desktop utama; yang mobile memakai canvas yang sama & responsif) -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    var ctx = document.getElementById('enrollmentChartDesktop');
    if (ctx && window.Chart) {
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: <?php echo $chart_labels; ?>,
                datasets: [{
                    label: '<?php echo t('Pendaftaran', 'Enrollments'); ?>',
                    data: <?php echo $chart_data; ?>,
                    borderColor: '#0D1830',
                    backgroundColor: function(c) {
                        var g = c.chart.ctx.createLinearGradient(0, 0, 0, 250);
                        g.addColorStop(0, 'rgba(13,24,48,0.12)');
                        g.addColorStop(1, 'rgba(13,24,48,0)');
                        return g;
                    },
                    fill: true, tension: 0.4,
                    pointBackgroundColor: '#0D1830',
                    pointBorderColor: '#fff', pointBorderWidth: 2,
                    pointRadius: 4, pointHoverRadius: 6,
                    borderWidth: 2.5
                }]
            },
            options: {
                responsive: true, maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: { backgroundColor: '#0D1830', cornerRadius: 8, padding: 8, bodyFont: { size: 12 }, displayColors: false }
                },
                scales: {
                    y: { beginAtZero: true, grid: { color: 'rgba(0,0,0,0.04)', drawBorder: false }, ticks: { color: '#a8a29e', font: { size: 10 } } },
                    x: { grid: { display: false }, ticks: { color: '#a8a29e', font: { size: 10 } } }
                }
            }
        });
    }
});
</script>
