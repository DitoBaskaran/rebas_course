<div class="container-fluid px-0">

    <!-- ============ HEADER (hero) ============ -->
    <?php
        $st_count = array('pending'=>0,'confirmed'=>0,'completed'=>0,'cancelled'=>0,'no_show'=>0);
        foreach ($sessions as $s) { if (isset($st_count[$s->status])) $st_count[$s->status]++; }
    ?>
    <div class="bento-card mb-4 overflow-hidden" style="background:linear-gradient(120deg,#0D1830 0%,#164e63 100%);border:none;color:#fff;">
        <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3 position-relative" style="z-index:1;">
            <div>
                <span class="d-inline-flex align-items-center gap-1" style="background:rgba(255,255,255,0.14);border:1px solid rgba(255,255,255,0.2);color:#FBBF24;font-size:0.66rem;font-weight:800;letter-spacing:0.12em;text-transform:uppercase;padding:0.3rem 0.7rem;border-radius:100px;">
                    <i data-lucide="calendar-check" style="width:12px;height:12px;"></i>
                    <?php echo t('Mentoring', 'Mentoring'); ?>
                </span>
                <h1 class="fw-extrabold text-white mb-1 mt-2 lh-sm" style="letter-spacing:-0.03em;font-size:1.6rem;">
                    <?php echo t('Jadwal Mentoring', 'Mentoring Schedule'); ?>
                </h1>
                <p class="mb-0" style="color:rgba(255,255,255,0.72);font-size:0.82rem;">
                    <?php echo t('Semua sesi mentoring dari siswa.', 'All student mentoring sessions.'); ?>
                    <span class="fw-semibold text-white">(<?php echo count($sessions); ?>)</span>
                </p>
            </div>
            <?php if ($st_count['pending'] > 0): ?>
            <span class="d-inline-flex align-items-center gap-2 px-3 py-2 rounded-pill fw-semibold flex-shrink-0" style="background:#FBBF24;color:#0D1830;font-size:0.78rem;">
                <i data-lucide="clock" style="width:14px;height:14px;"></i> <?php echo $st_count['pending']; ?> <?php echo t('menunggu konfirmasi', 'awaiting confirmation'); ?>
            </span>
            <?php endif; ?>
        </div>
    </div>

    <!-- ============ KPI ============ -->
    <div class="bento-grid bento-grid-4 mb-4">
        <div class="bento-card blob-warning">
            <div class="d-flex align-items-center gap-3">
                <div class="bento-icon bg-warning-subtle text-warning"><i data-lucide="clock" style="width:22px;height:22px;"></i></div>
                <div>
                    <div class="bento-label"><?php echo t('Menunggu', 'Pending'); ?></div>
                    <div class="bento-value"><?php echo $st_count['pending']; ?></div>
                </div>
            </div>
        </div>
        <div class="bento-card blob-primary">
            <div class="d-flex align-items-center gap-3">
                <div class="bento-icon bg-primary-subtle text-primary"><i data-lucide="calendar-check" style="width:22px;height:22px;"></i></div>
                <div>
                    <div class="bento-label"><?php echo t('Dikonfirmasi', 'Confirmed'); ?></div>
                    <div class="bento-value"><?php echo $st_count['confirmed']; ?></div>
                </div>
            </div>
        </div>
        <div class="bento-card blob-success">
            <div class="d-flex align-items-center gap-3">
                <div class="bento-icon bg-success-subtle text-success"><i data-lucide="check-circle" style="width:22px;height:22px;"></i></div>
                <div>
                    <div class="bento-label"><?php echo t('Selesai', 'Completed'); ?></div>
                    <div class="bento-value"><?php echo $st_count['completed']; ?></div>
                </div>
            </div>
        </div>
        <div class="bento-card blob-danger">
            <div class="d-flex align-items-center gap-3">
                <div class="bento-icon bg-danger-subtle text-danger"><i data-lucide="x-circle" style="width:22px;height:22px;"></i></div>
                <div>
                    <div class="bento-label"><?php echo t('Batal/No Show', 'Cancelled/No Show'); ?></div>
                    <div class="bento-value"><?php echo $st_count['cancelled'] + $st_count['no_show']; ?></div>
                </div>
            </div>
        </div>
    </div>

    <?php if (empty($sessions)): ?>
        <div class="bento-card p-5 text-center">
            <div class="mx-auto d-inline-flex align-items-center justify-content-center rounded-circle mb-3" style="width:72px;height:72px;background:#E0F2F1;color:#009688;">
                <i data-lucide="calendar-check" style="width:30px;height:30px;"></i>
            </div>
            <h5 class="fw-extrabold text-dark mb-1"><?php echo t('Belum ada sesi mentoring.', 'No mentoring sessions yet.'); ?></h5>
            <p class="text-secondary small mb-0"><?php echo t('Sesi mentoring akan tampil di sini.', 'Mentoring sessions will appear here.'); ?></p>
        </div>
    <?php else: ?>

        <!-- ============ TOOLBAR ============ -->
        <div class="bento-card d-flex flex-column flex-md-row gap-2 mb-4" style="padding:0.8rem 1rem;">
            <div class="flex-fill position-relative">
                <i data-lucide="search" style="width:15px;height:15px;position:absolute;left:0.9rem;top:50%;transform:translateY(-50%);color:var(--gray-400,#94a3b8);"></i>
                <input type="text" class="form-control" style="padding-left:2.3rem;border-radius:100px;font-size:0.82rem;" placeholder="<?php echo t('Cari siswa atau mentor...', 'Search student or mentor...'); ?>" id="searchInput" onkeyup="filterMentoring()">
            </div>
            <select class="form-select" style="max-width:190px;border-radius:100px;font-size:0.82rem;" onchange="filterMentoring()" id="statusFilter">
                <option value=""><?php echo t('Semua Status', 'All Status'); ?></option>
                <option value="pending"><?php echo t('Menunggu', 'Pending'); ?></option>
                <option value="confirmed"><?php echo t('Dikonfirmasi', 'Confirmed'); ?></option>
                <option value="completed"><?php echo t('Selesai', 'Completed'); ?></option>
                <option value="cancelled"><?php echo t('Dibatalkan', 'Cancelled'); ?></option>
                <option value="no_show">No Show</option>
            </select>
        </div>

        <!-- ============ SESSION LIST ============ -->
        <div class="d-flex flex-column" style="gap:10px;" id="mentoringList">
            <?php foreach ($sessions as $s): ?>
                <?php
                    if ($s->status === 'pending') { $st_bg='#fffbeb'; $st_tx='#d97706'; $st_label=t('Menunggu','Pending'); $st_ic='clock'; }
                    elseif ($s->status === 'confirmed') { $st_bg='#E0F2F1'; $st_tx='#009688'; $st_label=t('Dikonfirmasi','Confirmed'); $st_ic='calendar-check'; }
                    elseif ($s->status === 'completed') { $st_bg='#f1f5f9'; $st_tx='#64748b'; $st_label=t('Selesai','Completed'); $st_ic='check-circle'; }
                    elseif ($s->status === 'cancelled') { $st_bg='#fef2f2'; $st_tx='#dc2626'; $st_label=t('Dibatalkan','Cancelled'); $st_ic='x-circle'; }
                    else { $st_bg='#f1f5f9'; $st_tx='#64748b'; $st_label='No Show'; $st_ic='user-x'; }
                    $can_join = !empty($s->meeting_url) && in_array($s->status, array('confirmed', 'completed'));
                    $search_blob = strtolower(htmlspecialchars($s->student_name . ' ' . $s->mentor_name . ' ' . ($s->course_title ?? '')));
                ?>
                <div class="sub-item" data-status="<?php echo $s->status; ?>" data-search="<?php echo $search_blob; ?>">
                <div class="sub-card">
                    <!-- Date block -->
                    <div class="d-flex flex-column align-items-center justify-content-center rounded-3 flex-shrink-0" style="width:52px;height:52px;background:<?php echo $st_bg; ?>;color:<?php echo $st_tx; ?>;">
                        <span style="font-size:0.6rem;font-weight:700;text-transform:uppercase;line-height:1;"><?php echo date('M', strtotime($s->scheduled_at)); ?></span>
                        <span style="font-size:1.15rem;font-weight:800;line-height:1.2;"><?php echo date('d', strtotime($s->scheduled_at)); ?></span>
                    </div>
                    <div class="flex-fill" style="min-width:0;">
                        <div class="fw-bold text-dark text-truncate" style="font-size:0.88rem;"><?php echo htmlspecialchars($s->student_name); ?></div>
                        <div class="text-secondary text-truncate" style="font-size:0.74rem;">
                            <i data-lucide="user" style="width:11px;height:11px;" class="me-1"></i><?php echo t('Mentor', 'Mentor'); ?>: <?php echo htmlspecialchars($s->mentor_name); ?>
                            <?php if (!empty($s->course_title)): ?> <span style="opacity:0.6;">·</span> <?php echo htmlspecialchars($s->course_title); ?><?php endif; ?>
                        </div>
                        <div class="d-flex align-items-center gap-2 mt-1 flex-wrap">
                            <span class="px-2 py-0 rounded-pill fw-semibold d-inline-flex align-items-center gap-1" style="background:<?php echo $st_bg; ?>;color:<?php echo $st_tx; ?>;font-size:0.6rem;"><i data-lucide="<?php echo $st_ic; ?>" style="width:9px;height:9px;"></i><?php echo $st_label; ?></span>
                            <span class="text-muted" style="font-size:0.68rem;"><i data-lucide="clock" style="width:10px;height:10px;" class="me-1"></i><?php echo date('H:i', strtotime($s->scheduled_at)); ?> WIB · <?php echo $s->duration; ?> min</span>
                        </div>
                    </div>
                    <?php if ($can_join): ?>
                    <a href="<?php echo htmlspecialchars($s->meeting_url); ?>" target="_blank" class="btn btn-sm fw-semibold rounded-pill d-inline-flex align-items-center gap-1 flex-shrink-0" style="background:#0D1830;color:#fff;font-size:0.7rem;padding:0.4rem 0.9rem;">
                        <i class="fas fa-video" style="font-size:0.62rem;"></i> <?php echo t('Gabung', 'Join'); ?>
                    </a>
                    <?php endif; ?>
                </div>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="text-center mt-3" id="noMentoringMsg" style="display:none;">
            <span class="text-muted small"><?php echo t('Tidak ada sesi yang cocok.', 'No matching sessions.'); ?></span>
        </div>
    <?php endif; ?>
</div>
<script>
function filterMentoring() {
    var q = (document.getElementById('searchInput')?.value || '').toLowerCase();
    var st = document.getElementById('statusFilter')?.value || '';
    var visible = 0;
    document.querySelectorAll('#mentoringList .sub-item').forEach(function(item) {
        var text = item.getAttribute('data-search') || '';
        var status = item.getAttribute('data-status') || '';
        var match = text.indexOf(q) !== -1 && (!st || status === st);
        item.style.display = match ? '' : 'none';
        if (match) visible++;
    });
    var msg = document.getElementById('noMentoringMsg');
    if (msg) msg.style.display = visible === 0 ? 'block' : 'none';
}
</script>
