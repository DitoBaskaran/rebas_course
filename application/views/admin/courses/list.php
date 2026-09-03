<div class="container-fluid px-0">

    <!-- ============ HEADER (hero) ============ -->
    <div class="bento-card mb-4 overflow-hidden" style="background:linear-gradient(120deg,#0D1830 0%,#164e63 100%);border:none;color:#fff;">
        <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3 position-relative" style="z-index:1;">
            <div>
                <span class="d-inline-flex align-items-center gap-1" style="background:rgba(255,255,255,0.14);border:1px solid rgba(255,255,255,0.2);color:#FBBF24;font-size:0.66rem;font-weight:800;letter-spacing:0.12em;text-transform:uppercase;padding:0.3rem 0.7rem;border-radius:100px;">
                    <i data-lucide="book-open" style="width:12px;height:12px;"></i>
                    <?php echo t('Konten', 'Content'); ?>
                </span>
                <h1 class="fw-extrabold text-white mb-1 mt-2 lh-sm" style="letter-spacing:-0.03em;font-size:1.6rem;">
                    <?php echo t('Daftar Konten', 'Content List'); ?>
                </h1>
                <p class="mb-0" style="color:rgba(255,255,255,0.72);font-size:0.82rem;">
                    <?php echo t('Kelola dan tambahkan konten pembelajaran.', 'Manage learning content.'); ?>
                    <span class="fw-semibold text-white">(<?php echo count($courses); ?>)</span>
                </p>
            </div>
            <div class="d-flex gap-2 flex-shrink-0">
                <a href="<?php echo base_url('admin/settings/general'); ?>" class="btn fw-semibold rounded-pill d-inline-flex align-items-center justify-content-center border-0" style="background:rgba(255,255,255,0.14);color:#fff;font-size:0.78rem;width:38px;height:38px;padding:0;" title="<?php echo t('Pengaturan', 'Settings'); ?>">
                    <i data-lucide="settings" style="width:15px;height:15px;"></i>
                </a>
                <a href="<?php echo base_url('admin/create_course'); ?>" class="btn fw-semibold rounded-pill d-inline-flex align-items-center gap-2 border-0" style="background:#FBBF24;color:#0D1830;font-size:0.78rem;padding:0.55rem 1.1rem;box-shadow:0 4px 14px rgba(251,191,36,0.3);">
                    <i data-lucide="plus" style="width:14px;height:14px;"></i> <?php echo t('Tambah Konten', 'Add Content'); ?>
                </a>
            </div>
        </div>
    </div>

    <!-- ============ TOOLBAR ============ -->
    <div class="bento-card d-flex flex-column flex-md-row gap-2 mb-4" style="padding:0.8rem 1rem;">
        <div class="flex-fill position-relative">
            <i data-lucide="search" style="width:15px;height:15px;position:absolute;left:0.9rem;top:50%;transform:translateY(-50%);color:var(--gray-400,#94a3b8);"></i>
            <input type="text" class="form-control" style="padding-left:2.3rem;border-radius:100px;font-size:0.82rem;" placeholder="<?php echo t('Cari konten...', 'Search content...'); ?>" id="searchInput" onkeyup="filterTable()">
        </div>
        <select class="form-select" style="max-width:180px;border-radius:100px;font-size:0.82rem;" onchange="filterTable()" id="statusFilter">
            <option value=""><?php echo t('Semua Status', 'All Status'); ?></option>
            <option value="published"><?php echo t('Published', 'Published'); ?></option>
            <option value="draft"><?php echo t('Draft', 'Draft'); ?></option>
            <option value="archived"><?php echo t('Archived', 'Archived'); ?></option>
        </select>
    </div>

    <?php if (empty($courses)): ?>
        <div class="bento-card p-5 text-center">
            <div class="mx-auto d-inline-flex align-items-center justify-content-center rounded-circle mb-3" style="width:72px;height:72px;background:#E0F2F1;color:#009688;">
                <i data-lucide="book-open" style="width:30px;height:30px;"></i>
            </div>
            <h5 class="fw-extrabold text-dark mb-1"><?php echo t('Belum Ada Konten', 'No Content Yet'); ?></h5>
            <p class="text-secondary small mb-4"><?php echo t('Tambahkan konten pembelajaran pertama Anda.', 'Add your first learning content.'); ?></p>
            <a href="<?php echo base_url('admin/create_course'); ?>" class="btn btn-primary rounded-pill px-4 fw-semibold d-inline-flex align-items-center gap-2">
                <i data-lucide="plus" style="width:15px;height:15px;"></i> <?php echo t('Tambah Konten', 'Add Content'); ?>
            </a>
        </div>
    <?php else: ?>
        <!-- ============ COURSE CARDS ============ -->
        <div class="bento-grid bento-grid-3" id="courseGrid" style="align-items:stretch;">
            <?php foreach ($courses as $course): ?>
                <?php
                    $thumb_url = base_url('uploads/courses/' . $course->thumbnail);
                    if ($course->status === 'published') { $st_bg='#E0F2F1'; $st_tx='#009688'; $st_ic='check-circle'; $st_label=t('Published','Published'); }
                    elseif ($course->status === 'draft') { $st_bg='#fffbeb'; $st_tx='#d97706'; $st_ic='pencil'; $st_label=t('Draft','Draft'); }
                    else { $st_bg='#f1f5f9'; $st_tx='#64748b'; $st_ic='archive'; $st_label=t('Archived','Archived'); }
                    $price_txt = $course->price > 0 ? 'Rp ' . number_format($course->price, 0, ',', '.') : t('Gratis', 'Free');
                ?>
                <div class="bento-card p-0 course-card" data-status="<?php echo $course->status; ?>" data-search="<?php echo strtolower(htmlspecialchars($course->title . ' ' . $course->teacher_name . ' ' . ($course->category_name ?? ''))); ?>" style="display:flex;flex-direction:column;overflow:hidden;">
                    <div class="position-relative" style="aspect-ratio:16/9;background:#E6EBEF;overflow:hidden;">
                        <img src="<?php echo $thumb_url; ?>" onerror="this.style.display='none';" alt="" style="width:100%;height:100%;object-fit:cover;">
                        <span class="position-absolute d-inline-flex align-items-center gap-1 px-2 py-1 rounded-pill fw-semibold" style="top:0.6rem;left:0.6rem;background:<?php echo $st_bg; ?>;color:<?php echo $st_tx; ?>;font-size:0.65rem;">
                            <i data-lucide="<?php echo $st_ic; ?>" style="width:11px;height:11px;"></i> <?php echo $st_label; ?>
                        </span>
                        <?php if ($course->featured): ?>
                        <span class="position-absolute d-inline-flex align-items-center justify-content-center rounded-circle" style="top:0.6rem;right:0.6rem;width:26px;height:26px;background:#FBBF24;color:#0D1830;">
                            <i data-lucide="star" style="width:13px;height:13px;"></i>
                        </span>
                        <?php endif; ?>
                    </div>
                    <div class="px-3 pt-3">
                        <div class="fw-bold text-dark" style="font-size:0.88rem;line-height:1.35;min-height:2.4em;overflow:hidden;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;"><?php echo htmlspecialchars($course->title); ?></div>
                        <div class="d-flex flex-wrap gap-1 mt-2">
                            <span class="d-inline-flex align-items-center px-2 py-1 rounded-pill fw-semibold" style="background:#E6EBEF;color:#57534e;font-size:0.62rem;"><?php echo content_type_label($course->content_type); ?></span>
                            <span class="d-inline-flex align-items-center px-2 py-1 rounded-pill fw-semibold" style="background:#eff6ff;color:#2563eb;font-size:0.62rem;"><?php echo skill_level_label($course->skill_level); ?></span>
                        </div>
                        <div class="d-flex align-items-center justify-content-between mt-2">
                            <span class="fw-extrabold" style="color:<?php echo $course->price > 0 ? '#0D1830' : '#009688'; ?>;font-size:0.92rem;"><?php echo $price_txt; ?></span>
                            <span class="text-secondary text-truncate" style="font-size:0.7rem;max-width:9rem;"><?php echo htmlspecialchars($course->teacher_name); ?></span>
                        </div>
                    </div>
                    <div class="d-flex gap-1 px-3 py-3 mt-auto">
                        <a href="<?php echo base_url('admin/lessons/' . $course->id); ?>" class="btn btn-sm flex-fill d-inline-flex align-items-center justify-content-center" style="background:#E6EBEF;color:#57534e;border:none;border-radius:10px;font-size:0.72rem;" title="<?php echo t('Materi', 'Lessons'); ?>"><i class="fas fa-list"></i></a>
                        <a href="<?php echo base_url('quiz/admin_quizzes/' . $course->id); ?>" class="btn btn-sm flex-fill d-inline-flex align-items-center justify-content-center" style="background:#E6EBEF;color:#57534e;border:none;border-radius:10px;font-size:0.72rem;" title="<?php echo t('Quiz', 'Quizzes'); ?>"><i class="fas fa-pencil-alt"></i></a>
                        <a href="<?php echo base_url('admin/assignments/' . $course->id); ?>" class="btn btn-sm flex-fill d-inline-flex align-items-center justify-content-center" style="background:#E6EBEF;color:#57534e;border:none;border-radius:10px;font-size:0.72rem;" title="<?php echo t('Tugas', 'Assignments'); ?>"><i class="fas fa-code"></i></a>
                        <a href="<?php echo base_url('admin/edit_course/' . $course->id); ?>" class="btn btn-sm flex-fill d-inline-flex align-items-center justify-content-center" style="background:#0D1830;color:#fff;border:none;border-radius:10px;font-size:0.72rem;" title="<?php echo t('Edit', 'Edit'); ?>"><i class="fas fa-edit"></i></a>
                        <a href="<?php echo base_url('admin/delete_course/' . $course->id); ?>" data-confirm="<?php echo t('Hapus konten ini?', 'Delete this content?'); ?>" class="btn btn-sm d-inline-flex align-items-center justify-content-center" style="border:1px solid #fecaca;color:#dc2626;border-radius:10px;font-size:0.72rem;flex:0 0 auto;width:34px;" title="<?php echo t('Hapus', 'Delete'); ?>"><i class="fas fa-trash-alt"></i></a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="text-center mt-3" id="noResultsMsg" style="display:none;">
            <span class="text-muted small"><?php echo t('Tidak ada konten yang cocok.', 'No matching content.'); ?></span>
        </div>
    <?php endif; ?>
</div>

<script>
function filterTable() {
    var q = (document.getElementById('searchInput')?.value || '').toLowerCase();
    var st = document.getElementById('statusFilter')?.value || '';
    var visible = 0;
    document.querySelectorAll('#courseGrid .course-card').forEach(function(card) {
        var text = card.getAttribute('data-search') || '';
        var status = card.getAttribute('data-status') || '';
        var match = text.indexOf(q) !== -1 && (!st || status === st);
        card.style.display = match ? '' : 'none';
        if (match) visible++;
    });
    var msg = document.getElementById('noResultsMsg');
    if (msg) msg.style.display = visible === 0 ? 'block' : 'none';
}
</script>
