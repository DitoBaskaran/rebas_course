<div class="container-fluid px-0">
    <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between mb-5 gap-3">
        <div>
            <span class="text-primary fw-semibold small text-uppercase tracking-wide d-block mb-1">Analytics</span>
            <h1 class="display-6 fw-extrabold text-dark mb-1 lh-sm" style="letter-spacing: -0.03em;"><?php echo t('Analitik', 'Analytics'); ?></h1>
            <p class="text-secondary mb-0"><?php echo t('Data dan insight bisnis platform.', 'Platform data and business insights.'); ?></p>
        </div>
    </div>

    <div class="bento-grid bento-grid-2 mb-4">
        <div class="bento-card">
            <h5 class="fw-bold text-dark mb-3 d-flex align-items-center gap-2"><i data-lucide="trending-up" style="width:18px;height:18px;color:var(--primary);"></i> <?php echo t('Revenue per Bulan', 'Monthly Revenue'); ?></h5>
            <div class="chart-container"><canvas id="revenueChart"></canvas></div>
        </div>
        <div class="bento-card">
            <h5 class="fw-bold text-dark mb-3 d-flex align-items-center gap-2"><i data-lucide="bar-chart-3" style="width:18px;height:18px;color:var(--warning);"></i> <?php echo t('Kursus Terpopuler', 'Popular Courses'); ?></h5>
            <div style="max-height:260px;overflow-y:auto;">
                <?php foreach ($popular_courses as $i => $c): ?>
                    <div class="d-flex align-items-center gap-2 py-1">
                        <span class="badge bg-light text-dark fw-bold" style="width:24px;"><?php echo $i + 1; ?></span>
                        <span class="small flex-fill text-truncate"><?php echo htmlspecialchars($c->title); ?></span>
                        <span class="badge bg-primary-subtle text-primary fw-bold"><?php echo $c->students; ?></span>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <div class="bento-grid bento-grid-3 mb-4">
        <?php foreach ($revenue_by_type as $t): ?>
            <div class="bento-card d-flex align-items-center gap-3">
                <div class="bento-icon bg-primary-subtle text-primary"><i data-lucide="package" style="width:22px;height:22px;"></i></div>
                <div>
                    <div class="bento-label"><?php echo content_type_label($t->content_type); ?></div>
                    <div class="bento-value" style="font-size:1.1rem;">Rp <?php echo number_format($t->revenue, 0, ',', '.'); ?></div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var ctx = document.getElementById('revenueChart');
    if (ctx) {
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: <?php $months = array(); foreach($revenue_by_month as $r) { $months[] = $r->month; } echo json_encode($months); ?>,
                datasets: [{
                    label: 'Revenue',
                    data: <?php $revs = array(); foreach($revenue_by_month as $r) { $revs[] = (int)$r->revenue; } echo json_encode($revs); ?>,
                    backgroundColor: 'rgba(99,102,241,0.2)',
                    borderColor: '#6366f1',
                    borderWidth: 2,
                    borderRadius: 6,
                }]
            },
            options: {
                responsive: true, maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    y: { beginAtZero: true, grid: { color: 'rgba(0,0,0,0.04)' }, ticks: { callback: function(v) { return 'Rp ' + v.toLocaleString('id-ID'); } } },
                    x: { grid: { display: false } }
                }
            }
        });
    }
});
</script>
