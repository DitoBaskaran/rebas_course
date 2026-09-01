<div class="app-page">
    <!-- Header -->
    <div class="app-page-head">
        <div>
            <h4 class="app-page-title"><i class="fas fa-calendar"></i> <?php echo t('Daftar Seminar', 'Seminar List'); ?></h4>
            <p class="app-page-sub"><?php echo t('Atur jadwal dan kuota seminar langsung.', 'Manage live seminar schedules and quotas.'); ?></p>
        </div>
        <div class="app-page-actions">
            <a href="<?php echo base_url('admin/settings/hero'); ?>" class="app-btn app-btn-icon" title="<?php echo t('Pengaturan', 'Settings'); ?>"><i class="fas fa-cog"></i></a>
            <a href="<?php echo base_url('admin/create_seminar'); ?>" class="app-btn app-btn-primary"><i class="fas fa-plus"></i> <?php echo t('Tambah Seminar', 'Add Seminar'); ?></a>
        </div>
    </div>

    <?php if (empty($seminars)): ?>
        <div class="app-card">
            <div class="app-empty">
                <i class="fas fa-calendar"></i>
                <h6><?php echo t('Belum ada seminar.', 'No seminars yet.'); ?></h6>
                <p><?php echo t('Buat seminar langsung pertama Anda.', 'Create your first live seminar.'); ?></p>
            </div>
        </div>
    <?php else: ?>
        <div class="app-grid app-grid-3">
            <?php foreach ($seminars as $sem): ?>
                <div class="app-card d-flex flex-column">
                    <div style="aspect-ratio:16/9;overflow:hidden;">
                        <img src="<?php echo base_url('uploads/seminars/' . $sem->thumbnail); ?>" onerror="this.style.visibility='hidden';" alt="" style="width:100%;height:100%;object-fit:cover;">
                    </div>
                    <div class="app-card-pad d-flex flex-column gap-1" style="flex:1;">
                        <h6 class="app-row-title" style="font-size:0.88rem;white-space:normal;line-height:1.35;"><?php echo htmlspecialchars($sem->title); ?></h6>
                        <div style="color:#78716c;font-size:0.75rem;display:flex;flex-direction:column;gap:0.2rem;">
                            <span class="d-flex align-items-center gap-1"><i class="far fa-calendar" style="font-size:0.6rem;"></i> <?php echo date('d M Y', strtotime($sem->date_time)); ?> <?php echo date('H:i', strtotime($sem->date_time)); ?></span>
                            <span class="d-flex align-items-center gap-1"><i class="fas fa-users" style="font-size:0.6rem;"></i> <?php echo $sem->quota; ?> <?php echo t('kursi', 'seats'); ?></span>
                        </div>
                        <div style="margin-top:auto;padding-top:0.6rem;border-top:1px solid var(--gray-100,#f5f5f5);display:flex;align-items:center;justify-content:space-between;gap:0.5rem;flex-wrap:wrap;">
                            <span class="td-title" style="font-size:0.85rem;"><?php echo $sem->price > 0 ? 'Rp ' . number_format($sem->price, 0, ',', '.') : '<span style="color:#009688;">' . t('Gratis', 'Free') . '</span>'; ?></span>
                            <div class="app-actions">
                                <a href="<?php echo base_url('admin/edit_seminar/' . $sem->id); ?>" class="app-action app-action-dark" title="<?php echo t('Edit', 'Edit'); ?>"><i class="fas fa-edit"></i></a>
                                <a href="<?php echo base_url('admin/delete_seminar/' . $sem->id); ?>" data-confirm="<?php echo t('Hapus seminar ini?', 'Delete this seminar?'); ?>" class="app-action app-action-red" title="<?php echo t('Hapus', 'Delete'); ?>"><i class="fas fa-trash-alt"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>
