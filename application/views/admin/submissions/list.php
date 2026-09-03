<div class="container-fluid px-0">

    <!-- ============ HEADER (hero) ============ -->
    <?php
        $need_grade = 0; $graded_n = 0;
        foreach ($submissions as $s) {
            if ($s->status === 'submitted' || $s->status === 'returned') $need_grade++;
            elseif ($s->status === 'graded') $graded_n++;
        }
    ?>
    <div class="bento-card mb-4 overflow-hidden" style="background:linear-gradient(120deg,#0D1830 0%,#164e63 100%);border:none;color:#fff;">
        <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3 position-relative" style="z-index:1;">
            <div>
                <span class="d-inline-flex align-items-center gap-1" style="background:rgba(255,255,255,0.14);border:1px solid rgba(255,255,255,0.2);color:#FBBF24;font-size:0.66rem;font-weight:800;letter-spacing:0.12em;text-transform:uppercase;padding:0.3rem 0.7rem;border-radius:100px;">
                    <i data-lucide="code" style="width:12px;height:12px;"></i>
                    <?php echo t('Tugas', 'Assignments'); ?>
                </span>
                <h1 class="fw-extrabold text-white mb-1 mt-2 lh-sm" style="letter-spacing:-0.03em;font-size:1.6rem;">
                    <?php echo t('Tugas Siswa', 'Student Submissions'); ?>
                </h1>
                <p class="mb-0" style="color:rgba(255,255,255,0.72);font-size:0.82rem;">
                    <?php echo t('Nilai tugas yang dikumpulkan siswa.', 'Grade student assignment submissions.'); ?>
                    <span class="fw-semibold text-white">(<?php echo count($submissions); ?>)</span>
                </p>
            </div>
            <?php if ($need_grade > 0): ?>
            <span class="d-inline-flex align-items-center gap-2 px-3 py-2 rounded-pill fw-semibold flex-shrink-0" style="background:#FBBF24;color:#0D1830;font-size:0.78rem;">
                <i data-lucide="clipboard-check" style="width:14px;height:14px;"></i> <?php echo $need_grade; ?> <?php echo t('perlu dinilai', 'need grading'); ?>
            </span>
            <?php endif; ?>
        </div>
    </div>

    <!-- ============ KPI ============ -->
    <div class="bento-grid bento-grid-3 mb-4">
        <div class="bento-card blob-warning">
            <div class="d-flex align-items-center gap-3">
                <div class="bento-icon bg-warning-subtle text-warning"><i data-lucide="inbox" style="width:22px;height:22px;"></i></div>
                <div>
                    <div class="bento-label"><?php echo t('Perlu Dinilai', 'Need Grading'); ?></div>
                    <div class="bento-value"><?php echo $need_grade; ?></div>
                </div>
            </div>
        </div>
        <div class="bento-card blob-success">
            <div class="d-flex align-items-center gap-3">
                <div class="bento-icon bg-success-subtle text-success"><i data-lucide="check-circle" style="width:22px;height:22px;"></i></div>
                <div>
                    <div class="bento-label"><?php echo t('Sudah Dinilai', 'Graded'); ?></div>
                    <div class="bento-value"><?php echo $graded_n; ?></div>
                </div>
            </div>
        </div>
        <div class="bento-card blob-primary">
            <div class="d-flex align-items-center gap-3">
                <div class="bento-icon bg-primary-subtle text-primary"><i data-lucide="files" style="width:22px;height:22px;"></i></div>
                <div>
                    <div class="bento-label"><?php echo t('Total Submission', 'Total Submissions'); ?></div>
                    <div class="bento-value"><?php echo count($submissions); ?></div>
                </div>
            </div>
        </div>
    </div>

    <!-- ============ TOOLBAR ============ -->
    <div class="bento-card d-flex flex-column flex-md-row gap-2 mb-4" style="padding:0.8rem 1rem;">
        <div class="flex-fill position-relative">
            <i data-lucide="search" style="width:15px;height:15px;position:absolute;left:0.9rem;top:50%;transform:translateY(-50%);color:var(--gray-400,#94a3b8);"></i>
            <input type="text" class="form-control" style="padding-left:2.3rem;border-radius:100px;font-size:0.82rem;" placeholder="<?php echo t('Cari siswa atau tugas...', 'Search student or assignment...'); ?>" id="searchInput" onkeyup="filterSub()">
        </div>
        <select class="form-select" style="max-width:190px;border-radius:100px;font-size:0.82rem;" onchange="filterSub()" id="statusFilter">
            <option value=""><?php echo t('Semua Status', 'All Status'); ?></option>
            <option value="submitted"><?php echo t('Perlu Dinilai', 'Need Grading'); ?></option>
            <option value="graded"><?php echo t('Dinilai', 'Graded'); ?></option>
            <option value="returned"><?php echo t('Dikembalikan', 'Returned'); ?></option>
        </select>
    </div>

    <?php if (empty($submissions)): ?>
        <div class="bento-card p-5 text-center">
            <div class="mx-auto d-inline-flex align-items-center justify-content-center rounded-circle mb-3" style="width:72px;height:72px;background:#E6EBEF;color:#94a3b8;">
                <i data-lucide="code" style="width:30px;height:30px;"></i>
            </div>
            <h5 class="fw-extrabold text-dark mb-1"><?php echo t('Belum ada submission.', 'No submissions yet.'); ?></h5>
            <p class="text-secondary small mb-0"><?php echo t('Submissions akan tampil di sini.', 'Submissions will appear here.'); ?></p>
        </div>
    <?php else: ?>
        <!-- ============ SUBMISSION LIST ============ -->
        <div class="d-flex flex-column" style="gap:10px;" id="subList">
            <?php foreach ($submissions as $s): ?>
                <?php
                    if ($s->status === 'graded') { $st_bg='#E0F2F1'; $st_tx='#009688'; $st_label=t('Dinilai','Graded'); }
                    elseif ($s->status === 'returned') { $st_bg='#fffbeb'; $st_tx='#d97706'; $st_label=t('Dikembalikan','Returned'); }
                    else { $st_bg='#dbeafe'; $st_tx='#2563eb'; $st_label=t('Perlu Dinilai','Need Grading'); }
                    $search_blob = strtolower(htmlspecialchars($s->user_name . ' ' . ($s->assignment_title ?? '') . ' ' . ($s->course_title ?? '')));
                ?>
                <div class="sub-item" data-status="<?php echo $s->status; ?>" data-search="<?php echo $search_blob; ?>">
                <div class="sub-card">
                    <span class="d-inline-flex align-items-center justify-content-center rounded-circle fw-bold text-white flex-shrink-0" style="width:38px;height:38px;background:<?php echo $st_tx; ?>;font-size:0.85rem;">
                        <?php echo strtoupper(substr($s->user_name, 0, 1)); ?>
                    </span>
                    <div class="flex-fill" style="min-width:0;">
                        <div class="fw-bold text-dark text-truncate" style="font-size:0.88rem;"><?php echo htmlspecialchars($s->user_name); ?></div>
                        <div class="text-secondary text-truncate" style="font-size:0.74rem;"><?php echo htmlspecialchars($s->assignment_title ?? ''); ?> <span style="opacity:0.6;">·</span> <?php echo htmlspecialchars($s->course_title ?? ''); ?></div>
                        <div class="d-flex align-items-center gap-1 mt-1 flex-wrap">
                            <span class="px-2 py-0 rounded-pill fw-semibold" style="background:<?php echo $st_bg; ?>;color:<?php echo $st_tx; ?>;font-size:0.6rem;"><?php echo $st_label; ?></span>
                            <?php if ($s->status === 'graded'): ?>
                                <span class="fw-extrabold" style="color:<?php echo $s->grade >= 75 ? '#009688' : '#dc2626'; ?>;font-size:0.8rem;"><?php echo $s->grade; ?>/100</span>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="d-flex align-items-center gap-2 flex-shrink-0 flex-wrap">
                        <?php if ($s->file_url): ?>
                        <a href="<?php echo base_url('uploads/assignments/' . $s->file_url); ?>" target="_blank" class="btn btn-sm fw-semibold rounded-pill d-inline-flex align-items-center gap-1" style="background:#E6EBEF;color:#57534e;font-size:0.7rem;padding:0.35rem 0.75rem;">
                            <i class="fas fa-download" style="font-size:0.62rem;"></i> <?php echo t('File', 'File'); ?>
                        </a>
                        <?php endif; ?>
                        <?php if ($s->status === 'submitted' || $s->status === 'returned'): ?>
                            <a href="<?php echo base_url('admin/grade_submission/' . $s->id); ?>" class="btn btn-sm fw-semibold rounded-pill d-inline-flex align-items-center gap-1" style="background:#0D1830;color:#fff;font-size:0.7rem;padding:0.35rem 0.75rem;" onclick="event.preventDefault();document.getElementById('gradeBox<?php echo $s->id; ?>').classList.toggle('d-none');">
                                <i class="fas fa-check-circle" style="font-size:0.62rem;"></i> <?php echo t('Nilai', 'Grade'); ?>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
                <?php if ($s->status === 'submitted' || $s->status === 'returned'): ?>
                <!-- Inline grade form -->
                <div id="gradeBox<?php echo $s->id; ?>" class="d-none" style="margin-top:6px;">
                    <?php echo form_open('admin/grade_submission/' . $s->id, array('class' => 'bento-card d-flex flex-column flex-md-row gap-2')); ?>
                        <input type="number" name="grade" class="form-control" placeholder="0-100" min="0" max="100" required style="max-width:110px;border-radius:10px;font-size:0.8rem;height:40px;">
                        <input type="text" name="feedback" class="form-control" placeholder="<?php echo t('Feedback untuk siswa...', 'Feedback for student...'); ?>" style="flex:1;min-width:140px;border-radius:10px;font-size:0.8rem;height:40px;">
                        <button type="submit" class="btn fw-semibold rounded-pill d-inline-flex align-items-center gap-1" style="background:#009688;color:#fff;font-size:0.75rem;padding:0.35rem 1rem;border:none;"><i class="fas fa-check"></i> <?php echo t('Simpan Nilai', 'Save Grade'); ?></button>
                        <a href="<?php echo base_url('admin/return_submission/' . $s->id); ?>" class="btn fw-semibold rounded-pill d-inline-flex align-items-center gap-1" style="background:#fff7ed;color:#d97706;font-size:0.75rem;padding:0.35rem 1rem;border:1px solid #fed7aa;" onclick="return confirm('<?php echo t('Kembalikan untuk revisi?', 'Return for revision?'); ?>')"><i class="fas fa-undo"></i> <?php echo t('Kembalikan', 'Return'); ?></a>
                    <?php echo form_close(); ?>
                </div>
                <?php endif; ?>
                </div>

            <?php endforeach; ?>
        </div>
        <div class="text-center mt-3" id="noSubMsg" style="display:none;">
            <span class="text-muted small"><?php echo t('Tidak ada submission yang cocok.', 'No matching submissions.'); ?></span>
        </div>
    <?php endif; ?>
</div>
<script>
function filterSub() {
    var q = (document.getElementById('searchInput')?.value || '').toLowerCase();
    var st = document.getElementById('statusFilter')?.value || '';
    var visible = 0;
    document.querySelectorAll('#subList .sub-item').forEach(function(item) {
        var text = item.getAttribute('data-search') || '';
        var status = item.getAttribute('data-status') || '';
        var match = text.indexOf(q) !== -1 && (!st || status === st);
        item.style.display = match ? '' : 'none';
        if (match) visible++;
    });
    var msg = document.getElementById('noSubMsg');
    if (msg) msg.style.display = visible === 0 ? 'block' : 'none';
}
</script>
