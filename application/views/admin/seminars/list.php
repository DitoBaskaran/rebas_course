<div class="container-fluid px-0">

    <!-- ============ HEADER (hero) ============ -->
    <div class="bento-card mb-4 overflow-hidden" style="background:linear-gradient(120deg,#0D1830 0%,#164e63 100%);border:none;color:#fff;">
        <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3 position-relative" style="z-index:1;">
            <div>
                <span class="d-inline-flex align-items-center gap-1" style="background:rgba(255,255,255,0.14);border:1px solid rgba(255,255,255,0.2);color:#FBBF24;font-size:0.66rem;font-weight:800;letter-spacing:0.12em;text-transform:uppercase;padding:0.3rem 0.7rem;border-radius:100px;">
                    <i data-lucide="calendar" style="width:12px;height:12px;"></i>
                    <?php echo t('Event', 'Event'); ?>
                </span>
                <h1 class="fw-extrabold text-white mb-1 mt-2 lh-sm" style="letter-spacing:-0.03em;font-size:1.6rem;">
                    <?php echo t('Daftar Seminar', 'Seminar List'); ?>
                </h1>
                <p class="mb-0" style="color:rgba(255,255,255,0.72);font-size:0.82rem;">
                    <?php echo t('Atur jadwal dan kuota seminar langsung.', 'Manage live seminar schedules and quotas.'); ?>
                    <span class="fw-semibold text-white">(<?php echo count($seminars); ?>)</span>
                </p>
            </div>
            <div class="d-flex gap-2 flex-shrink-0">
                <a href="<?php echo base_url('admin/settings/hero'); ?>" class="btn fw-semibold rounded-pill d-inline-flex align-items-center justify-content-center border-0" style="background:rgba(255,255,255,0.14);color:#fff;font-size:0.78rem;width:38px;height:38px;padding:0;" title="<?php echo t('Pengaturan', 'Settings'); ?>">
                    <i data-lucide="settings" style="width:15px;height:15px;"></i>
                </a>
                <a href="<?php echo base_url('admin/create_seminar'); ?>" class="btn fw-semibold rounded-pill d-inline-flex align-items-center gap-2 border-0" style="background:#FBBF24;color:#0D1830;font-size:0.78rem;padding:0.55rem 1.1rem;box-shadow:0 4px 14px rgba(251,191,36,0.3);">
                    <i data-lucide="plus" style="width:14px;height:14px;"></i> <?php echo t('Tambah Seminar', 'Add Seminar'); ?>
                </a>
            </div>
        </div>
    </div>

    <?php if (empty($seminars)): ?>
        <div class="bento-card p-5 text-center">
            <div class="mx-auto d-inline-flex align-items-center justify-content-center rounded-circle mb-3" style="width:72px;height:72px;background:#E0F2F1;color:#009688;">
                <i data-lucide="calendar" style="width:30px;height:30px;"></i>
            </div>
            <h5 class="fw-extrabold text-dark mb-1"><?php echo t('Belum ada seminar.', 'No seminars yet.'); ?></h5>
            <p class="text-secondary small mb-4"><?php echo t('Buat seminar langsung pertama Anda.', 'Create your first live seminar.'); ?></p>
            <a href="<?php echo base_url('admin/create_seminar'); ?>" class="btn btn-primary rounded-pill px-4 fw-semibold d-inline-flex align-items-center gap-2">
                <i data-lucide="plus" style="width:15px;height:15px;"></i> <?php echo t('Tambah Seminar', 'Add Seminar'); ?>
            </a>
        </div>
    <?php else: ?>

        <!-- ============ TOOLBAR ============ -->
        <div class="bento-card d-flex flex-column flex-md-row gap-2 mb-4" style="padding:0.8rem 1rem;">
            <div class="flex-fill position-relative">
                <i data-lucide="search" style="width:15px;height:15px;position:absolute;left:0.9rem;top:50%;transform:translateY(-50%);color:var(--gray-400,#94a3b8);"></i>
                <input type="text" class="form-control" style="padding-left:2.3rem;border-radius:100px;font-size:0.82rem;" placeholder="<?php echo t('Cari seminar...', 'Search seminars...'); ?>" id="searchInput" onkeyup="filterGrid()">
            </div>
        </div>

        <!-- ============ SEMINAR CARDS ============ -->
        <div class="bento-grid bento-grid-3" id="seminarGrid" style="align-items:stretch;">
            <?php foreach ($seminars as $sem): ?>
                <?php
                    $upcoming = strtotime($sem->date_time) > time();
                    $thumb_url = base_url('uploads/seminars/' . $sem->thumbnail);
                    $price_txt = $sem->price > 0 ? 'Rp ' . number_format($sem->price, 0, ',', '.') : t('Gratis', 'Free');
                    $d = date('d', strtotime($sem->date_time));
                    $m = date('M', strtotime($sem->date_time));
                    $y = date('Y', strtotime($sem->date_time));
                    $h = date('H:i', strtotime($sem->date_time));
                ?>
                <div class="bento-card p-0 seminar-card" data-search="<?php echo strtolower(htmlspecialchars($sem->title)); ?>" style="display:flex;flex-direction:column;overflow:hidden;">
                    <div class="position-relative" style="aspect-ratio:16/9;background:#E6EBEF;overflow:hidden;">
                        <img src="<?php echo $thumb_url; ?>" onerror="this.style.display='none';" alt="" style="width:100%;height:100%;object-fit:cover;">
                        <!-- Date badge -->
                        <span class="position-absolute d-flex flex-column align-items-center justify-content-center rounded-3 fw-bold" style="top:0.7rem;left:0.7rem;width:48px;height:52px;background:rgba(13,24,48,0.85);color:#fff;backdrop-filter:blur(4px);">
                            <span style="font-size:0.6rem;line-height:1;text-transform:uppercase;opacity:0.75;"><?php echo $m; ?></span>
                            <span style="font-size:1.1rem;line-height:1.1;"><?php echo $d; ?></span>
                        </span>
                        <?php if ($upcoming): ?>
                        <span class="position-absolute d-inline-flex align-items-center gap-1 px-2 py-1 rounded-pill fw-semibold" style="top:0.7rem;right:0.7rem;background:#E0F2F1;color:#009688;font-size:0.65rem;">
                            <i data-lucide="radio" style="width:11px;height:11px;"></i> <?php echo t('Mendatang', 'Upcoming'); ?>
                        </span>
                        <?php else: ?>
                        <span class="position-absolute d-inline-flex align-items-center gap-1 px-2 py-1 rounded-pill fw-semibold" style="top:0.7rem;right:0.7rem;background:#f1f5f9;color:#64748b;font-size:0.65rem;">
                            <?php echo t('Selesai', 'Ended'); ?>
                        </span>
                        <?php endif; ?>
                    </div>
                    <div class="px-3 pt-3">
                        <div class="fw-bold text-dark" style="font-size:0.88rem;line-height:1.35;min-height:2.4em;overflow:hidden;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;"><?php echo htmlspecialchars($sem->title); ?></div>
                        <div class="d-flex flex-column gap-1 mt-2" style="color:#78716c;font-size:0.72rem;">
                            <span class="d-flex align-items-center gap-1"><i data-lucide="calendar" style="width:11px;height:11px;"></i> <?php echo date('d M Y', strtotime($sem->date_time)); ?> · <?php echo $h; ?></span>
                            <span class="d-flex align-items-center gap-1"><i data-lucide="users" style="width:11px;height:11px;"></i> <?php echo (int)$sem->quota; ?> <?php echo t('kursi', 'seats'); ?></span>
                        </div>
                    </div>
                    <div class="d-flex align-items-center justify-content-between px-3 pt-3">
                        <span class="fw-extrabold" style="color:<?php echo $sem->price > 0 ? '#0D1830' : '#009688'; ?>;font-size:0.92rem;"><?php echo $price_txt; ?></span>
                        <div class="d-flex gap-1">
                            <a href="<?php echo base_url('admin/edit_seminar/' . $sem->id); ?>" class="btn btn-sm d-inline-flex align-items-center justify-content-center" style="background:#0D1830;color:#fff;border:none;border-radius:10px;font-size:0.72rem;width:34px;" title="<?php echo t('Edit', 'Edit'); ?>"><i class="fas fa-edit"></i></a>
                            <a href="<?php echo base_url('admin/delete_seminar/' . $sem->id); ?>" data-confirm="<?php echo t('Hapus seminar ini?', 'Delete this seminar?'); ?>" class="btn btn-sm d-inline-flex align-items-center justify-content-center" style="border:1px solid #fecaca;color:#dc2626;border-radius:10px;font-size:0.72rem;width:34px;" title="<?php echo t('Hapus', 'Delete'); ?>"><i class="fas fa-trash-alt"></i></a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="text-center mt-3" id="noResultsMsg" style="display:none;">
            <span class="text-muted small"><?php echo t('Tidak ada seminar yang cocok.', 'No matching seminars.'); ?></span>
        </div>
    <?php endif; ?>
</div>
<script>
function filterGrid() {
    var q = (document.getElementById('searchInput')?.value || '').toLowerCase();
    var visible = 0;
    document.querySelectorAll('#seminarGrid .seminar-card').forEach(function(card) {
        var text = card.getAttribute('data-search') || '';
        var match = text.indexOf(q) !== -1;
        card.style.display = match ? '' : 'none';
        if (match) visible++;
    });
    var msg = document.getElementById('noResultsMsg');
    if (msg) msg.style.display = visible === 0 ? 'block' : 'none';
}
</script>
