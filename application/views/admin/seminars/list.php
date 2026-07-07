<div class="container-fluid px-0">
    <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between mb-5 gap-3">
        <div>
            <span class="text-primary fw-semibold small text-uppercase tracking-wide d-block mb-1">Event</span>
            <h1 class="display-6 fw-extrabold text-dark mb-1 lh-sm" style="letter-spacing: -0.03em;"><?php echo t('Daftar Seminar', 'Seminar List'); ?></h1>
            <p class="text-secondary mb-0"><?php echo t('Atur jadwal dan kuota seminar langsung.', 'Manage live seminar schedules and quotas.'); ?></p>
        </div>
        <div class="d-flex gap-2">
            <a href="<?php echo base_url('admin/settings/hero'); ?>" class="btn btn-outline-secondary btn-sm px-3 rounded-pill d-flex align-items-center gap-1">
                <i data-lucide="settings" style="width:16px;height:16px;"></i>
            </a>
            <a href="<?php echo base_url('admin/create_seminar'); ?>" class="btn btn-dark btn-sm px-3 rounded-pill shadow-sm d-flex align-items-center gap-1">
                <i data-lucide="plus" style="width:16px;height:16px;"></i> <?php echo t('Tambah Seminar', 'Add Seminar'); ?>
            </a>
        </div>
    </div>

    <div class="bento-grid bento-grid-3">
        <?php if (empty($seminars)): ?>
            <div class="bento-card" style="grid-column:1/-1;">
                <div class="empty-state">
                    <i data-lucide="calendar" style="width:48px;height:48px;color:var(--gray-300);"></i>
                    <h5><?php echo t('Belum ada seminar.', 'No seminars yet.'); ?></h5>
                </div>
            </div>
        <?php else: ?>
            <?php foreach ($seminars as $sem): ?>
                <div class="content-card">
                    <div class="card-thumb">
                        <img src="<?php echo base_url('uploads/seminars/' . $sem->thumbnail); ?>" onerror="this.src='https://images.unsplash.com/photo-1540575467063-178a50c2df87?w=400&auto=format&fit=crop&q=60';" alt="" style="height:140px;">
                    </div>
                    <div class="card-body-custom">
                        <div class="card-title"><?php echo htmlspecialchars($sem->title); ?></div>
                        <div class="d-flex flex-column gap-1 mt-2">
                            <span class="small d-flex align-items-center gap-1 text-muted">
                                <i data-lucide="calendar" style="width:14px;height:14px;"></i>
                                <?php echo date('d M Y', strtotime($sem->date_time)); ?> <?php echo date('H:i', strtotime($sem->date_time)); ?>
                            </span>
                            <span class="small d-flex align-items-center gap-1 text-muted">
                                <i data-lucide="users" style="width:14px;height:14px;"></i>
                                <?php echo $sem->quota; ?> <?php echo t('kursi', 'seats'); ?>
                            </span>
                            <span class="fw-bold text-dark small mt-1">
                                <?php echo $sem->price > 0 ? 'Rp ' . number_format($sem->price, 0, ',', '.') : t('Gratis', 'Free'); ?>
                            </span>
                        </div>
                        <div class="card-footer-custom mt-2 pt-2">
                            <span class="text-muted small"><?php echo $sem->language === 'en' ? 'English' : 'Indonesia'; ?></span>
                            <div class="d-flex gap-1">
                                <a href="<?php echo base_url('admin/edit_seminar/' . $sem->id); ?>" class="btn btn-warning btn-sm px-2" title="<?php echo t('Edit', 'Edit'); ?>">
                                    <i data-lucide="edit" style="width:14px;height:14px;"></i>
                                </a>
                                <a href="<?php echo base_url('admin/delete_seminar/' . $sem->id); ?>" data-confirm="<?php echo t('Hapus seminar ini?', 'Delete this seminar?'); ?>" class="btn btn-outline-danger btn-sm px-2">
                                    <i data-lucide="trash-2" style="width:14px;height:14px;"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>