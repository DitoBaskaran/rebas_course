<div class="container-fluid px-0">

    <!-- ============ HEADER (hero) ============ -->
    <?php
        // Hitung KPI inline dari data yang sudah ada
        $total_rev_12 = 0; $max_month = null; $max_month_val = 0;
        foreach ($revenue_by_month as $r) {
            $total_rev_12 += (float)$r->revenue;
            if ((float)$r->revenue > $max_month_val) { $max_month_val = (float)$r->revenue; $max_month = $r->month; }
        }
        $total_students_top = 0;
        foreach ($popular_courses as $pc) { $total_students_top += (int)$pc->students; }
        $type_count = count($revenue_by_type);
        $max_students = !empty($popular_courses) ? max(array_map(function($x){ return (int)$x->students; }, $popular_courses)) : 1;
        $max_type_rev = !empty($revenue_by_type) ? max(array_map(function($x){ return (float)$x->revenue; }, $revenue_by_type)) : 1;
        if ($max_month) { $max_month_label = date('M Y', strtotime($max_month . '-01')); } else { $max_month_label = '-'; }
    ?>
    <div class="bento-card mb-4 overflow-hidden" style="background:linear-gradient(120deg,#0D1830 0%,#164e63 100%);border:none;color:#fff;">
        <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3 position-relative" style="z-index:1;">
            <div>
                <span class="d-inline-flex align-items-center gap-1" style="background:rgba(255,255,255,0.14);border:1px solid rgba(255,255,255,0.2);color:#FBBF24;font-size:0.66rem;font-weight:800;letter-spacing:0.12em;text-transform:uppercase;padding:0.3rem 0.7rem;border-radius:100px;">
                    <i data-lucide="bar-chart-3" style="width:12px;height:12px;"></i>
                    <?php echo t('Insight', 'Insights'); ?>
                </span>
                <h1 class="fw-extrabold text-white mb-1 mt-2 lh-sm" style="letter-spacing:-0.03em;font-size:1.6rem;">
                    <?php echo t('Analitik', 'Analytics'); ?>
                </h1>
                <p class="mb-0" style="color:rgba(255,255,255,0.72);font-size:0.82rem;">
                    <?php echo t('Data dan insight bisnis platform.', 'Platform data and business insights.'); ?>
                </p>
            </div>
            <div class="d-flex gap-2 flex-wrap flex-shrink-0">
                <a href="<?php echo base_url('admin/dashboard'); ?>" class="btn fw-semibold rounded-pill d-inline-flex align-items-center gap-2 border-0" style="background:rgba(255,255,255,0.14);color:#fff;font-size:0.76rem;padding:0.5rem 1rem;">
                    <i data-lucide="layout-dashboard" style="width:13px;height:13px;"></i> <?php echo t('Dashboard', 'Dashboard'); ?>
                </a>
                <a href="<?php echo base_url('admin/transactions'); ?>" class="btn fw-semibold rounded-pill d-inline-flex align-items-center gap-2 border-0" style="background:#FBBF24;color:#0D1830;font-size:0.76rem;padding:0.5rem 1rem;box-shadow:0 4px 14px rgba(251,191,36,0.3);">
                    <i data-lucide="receipt" style="width:13px;height:13px;"></i> <?php echo t('Transaksi', 'Transactions'); ?>
                </a>
            </div>
        </div>
    </div>

    <!-- ============ KPI CARDS ============ -->
    <div class="bento-grid bento-grid-4 mb-4">
        <div class="bento-card blob-success">
            <div class="d-flex align-items-center gap-3">
                <div class="bento-icon bg-success-subtle text-success"><i data-lucide="wallet" style="width:22px;height:22px;"></i></div>
                <div>
                    <div class="bento-label"><?php echo t('Revenue 12 Bulan', 'Revenue 12 Months'); ?></div>
                    <div class="bento-value" style="font-size:1.35rem;">Rp <?php echo number_format($total_rev_12, 0, ',', '.'); ?></div>
                </div>
            </div>
        </div>
        <div class="bento-card blob-primary">
            <div class="d-flex align-items-center gap-3">
                <div class="bento-icon bg-primary-subtle text-primary"><i data-lucide="users" style="width:22px;height:22px;"></i></div>
                <div>
                    <div class="bento-label"><?php echo t('Pendaftar (Top 10)', 'Students (Top 10)'); ?></div>
                    <div class="bento-value"><?php echo number_format($total_students_top); ?></div>
                </div>
            </div>
        </div>
        <div class="bento-card blob-warning">
            <div class="d-flex align-items-center gap-3">
                <div class="bento-icon bg-warning-subtle text-warning"><i data-lucide="calendar" style="width:22px;height:22px;"></i></div>
                <div>
                    <div class="bento-label"><?php echo t('Bulan Terbaik', 'Best Month'); ?></div>
                    <div class="bento-value" style="font-size:1.35rem;"><?php echo $max_month_label; ?></div>
                    <div class="bento-trend up"><i data-lucide="trending-up" style="width:12px;height:12px;"></i> Rp <?php echo number_format($max_month_val, 0, ',', '.'); ?></div>
                </div>
            </div>
        </div>
        <div class="bento-card blob-danger">
            <div class="d-flex align-items-center gap-3">
                <div class="bento-icon bg-danger-subtle text-danger"><i data-lucide="package" style="width:22px;height:22px;"></i></div>
                <div>
                    <div class="bento-label"><?php echo t('Tipe Konten', 'Content Types'); ?></div>
                    <div class="bento-value"><?php echo $type_count; ?></div>
                </div>
            </div>
        </div>
    </div>

    <!-- ============ REVENUE CHART + POPULAR COURSES ============ -->
    <div class="bento-grid bento-grid-3-1 mb-4">
        <!-- Revenue chart -->
        <div class="bento-card">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <h6 class="fw-bold text-dark mb-0 d-flex align-items-center gap-2" style="font-size:0.88rem;">
                    <i data-lucide="trending-up" style="width:17px;height:17px;color:var(--primary);"></i>
                    <?php echo t('Revenue per Bulan', 'Monthly Revenue'); ?>
                </h6>
                <span class="badge rounded-pill" style="background:#E0F2F1;color:#009688;font-size:0.62rem;font-weight:700;">
                    <?php echo count($revenue_by_month); ?> <?php echo t('bulan', 'months'); ?>
                </span>
            </div>
            <div class="chart-container" style="height:280px;"><canvas id="revenueChart"></canvas></div>
        </div>

        <!-- Popular courses -->
        <div class="bento-card">
            <h6 class="fw-bold text-dark mb-3 d-flex align-items-center gap-2" style="font-size:0.88rem;">
                <i data-lucide="bar-chart-3" style="width:17px;height:17px;color:var(--warning);"></i>
                <?php echo t('Kursus Terpopuler', 'Popular Courses'); ?>
            </h6>
            <div class="d-flex flex-column gap-2" style="max-height:280px;overflow-y:auto;padding-right:2px;">
                <?php foreach ($popular_courses as $i => $c): ?>
                    <?php $pct = $max_students > 0 ? round(((int)$c->students / $max_students) * 100) : 0; ?>
                    <div>
                        <div class="d-flex align-items-center gap-2 mb-1">
                            <span class="d-inline-flex align-items-center justify-content-center rounded-circle flex-shrink-0 fw-bold" style="width:20px;height:20px;font-size:0.6rem;background:<?php echo $i < 3 ? '#FBBF24' : '#E6EBEF'; ?>;color:<?php echo $i < 3 ? '#0D1830' : '#57534e'; ?>;"><?php echo $i + 1; ?></span>
                            <span class="small flex-fill text-truncate fw-semibold" style="color:var(--gray-800,#262626);" title="<?php echo htmlspecialchars($c->title); ?>"><?php echo htmlspecialchars($c->title); ?></span>
                            <span class="fw-bold text-dark small"><?php echo $c->students; ?></span>
                        </div>
                        <div class="progress" style="height:6px;background:var(--gray-100,#f1f5f9);border-radius:100px;margin-left:28px;">
                            <div class="progress-bar" role="progressbar" style="width:<?php echo $pct; ?>%;border-radius:100px;background:<?php echo $i === 0 ? '#FBBF24' : ($i === 1 ? '#009688' : '#4361ee'); ?>;"></div>
                        </div>
                    </div>
                <?php endforeach; ?>
                <?php if (empty($popular_courses)): ?>
                    <p class="text-muted small mb-0"><?php echo t('Belum ada data pendaftaran.', 'No enrollment data yet.'); ?></p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- ============ REVENUE BY CONTENT TYPE ============ -->
    <?php if (!empty($revenue_by_type)): ?>
    <div class="bento-card">
        <h6 class="fw-bold text-dark mb-3 d-flex align-items-center gap-2" style="font-size:0.88rem;">
            <i data-lucide="pie-chart" style="width:17px;height:17px;color:#c026d3;"></i>
            <?php echo t('Revenue per Tipe Konten', 'Revenue by Content Type'); ?>
        </h6>
        <div class="row g-3">
            <?php foreach ($revenue_by_type as $t): ?>
                <?php $tpct = $max_type_rev > 0 ? round(((float)$t->revenue / $max_type_rev) * 100) : 0; ?>
                <div class="col-md-4">
                    <div class="d-flex align-items-center gap-3 p-3 rounded-3" style="background:var(--gray-50,#f8fafc);">
                        <div class="bento-icon bg-primary-subtle text-primary flex-shrink-0"><i data-lucide="package" style="width:20px;height:20px;"></i></div>
                        <div class="flex-fill" style="min-width:0;">
                            <div class="bento-label"><?php echo content_type_label($t->content_type); ?></div>
                            <div class="fw-extrabold text-dark" style="font-size:0.95rem;">Rp <?php echo number_format($t->revenue, 0, ',', '.'); ?></div>
                            <div class="progress mt-1" style="height:5px;background:var(--gray-200,#e7e5e4);border-radius:100px;">
                                <div class="progress-bar" role="progressbar" style="width:<?php echo $tpct; ?>%;border-radius:100px;background:linear-gradient(90deg,#009688,#4361ee);"></div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php endif; ?>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var ctx = document.getElementById('revenueChart');
    if (ctx && window.Chart) {
        var labels = <?php
            $months = array();
            foreach ($revenue_by_month as $r) { $months[] = date('M Y', strtotime($r->month . '-01')); }
            echo json_encode($months);
        ?>;
        var vals = <?php
            $revs = array();
            foreach ($revenue_by_month as $r) { $revs[] = (int)$r->revenue; }
            echo json_encode($revs);
        ?>;
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: '<?php echo t('Revenue', 'Revenue'); ?>',
                    data: vals,
                    backgroundColor: function(c) {
                        var chart = c.chart;
                        var grad = chart.ctx.createLinearGradient(0, 0, 0, 280);
                        grad.addColorStop(0, 'rgba(13,148,136,0.55)');
                        grad.addColorStop(1, 'rgba(67,97,238,0.12)');
                        return grad;
                    },
                    borderColor: '#0d9488',
                    borderWidth: 1.5,
                    borderRadius: 8,
                    maxBarThickness: 42
                }]
            },
            options: {
                responsive: true, maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: '#0D1830', cornerRadius: 10, padding: 10,
                        callbacks: { label: function(c) { return ' Rp ' + c.parsed.y.toLocaleString('id-ID'); } },
                        displayColors: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: { color: 'rgba(0,0,0,0.04)', drawBorder: false },
                        ticks: { color: '#a8a29e', font: { size: 10 }, callback: function(v) { if (v >= 1000000) return 'Rp ' + (v/1000000).toLocaleString('id-ID',{maximumFractionDigits:1}) + 'jt'; return 'Rp ' + v.toLocaleString('id-ID'); } }
                    },
                    x: { grid: { display: false }, ticks: { color: '#a8a29e', font: { size: 10 } } }
                }
            }
        });
    }
});
</script>
