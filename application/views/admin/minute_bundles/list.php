<div class="container-fluid px-0">
    <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between mb-5 gap-3">
        <div>
            <span class="text-success fw-semibold small text-uppercase tracking-wide d-block mb-1">Menit</span>
            <h1 class="display-6 fw-extrabold text-dark mb-1 lh-sm" style="letter-spacing: -0.03em;"><?php echo t('Bundel Menit', 'Minute Bundles'); ?></h1>
            <p class="text-secondary mb-0"><?php echo t('Kelola bundel menit untuk pembelian.', 'Manage minute bundles for purchase.'); ?></p>
        </div>
        <a href="<?php echo base_url('admin/minute_bundles/create'); ?>" class="btn btn-outline-success btn-sm px-3 rounded-pill shadow-sm d-flex align-items-center gap-1">
            <i data-lucide="plus" style="width:16px;height:16px;"></i> <?php echo t('Buat Bundel', 'Create Bundle'); ?>
        </a>
    </div>
    <div class="bento-card p-4 p-xl-5">
        <?php if (empty($bundles)): ?>
            <div class="empty-state"><i data-lucide="clock" style="width:48px;height:48px;color:var(--gray-300);"></i><h5><?php echo t('Belum ada bundel menit.', 'No minute bundles yet.'); ?></h5></div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table-modern">
                    <thead><tr><th><?php echo t('Nama', 'Name'); ?></th><th><?php echo t('Menit', 'Minutes'); ?></th><th><?php echo t('Harga (Rp)', 'Price (IDR)'); ?></th><th><?php echo t('Status', 'Status'); ?></th><th class="text-center"><?php echo t('Aksi', 'Action'); ?></th></tr></thead>
                    <tbody>
                        <?php foreach ($bundles as $b): ?>
                            <tr>
                                <td class="fw-bold text-dark"><?php echo htmlspecialchars($b->name); ?></td>
                                <td><?php echo $b->minutes; ?> <?php echo t('menit', 'minutes'); ?></td>
                                <td><?php echo 'Rp ' . number_format($b->price, 0, ',', '.'); ?></td>
                                <td><?php echo $b->is_active ? '<span class="badge bg-success badge-modern">Active</span>' : '<span class="badge bg-secondary badge-modern">Inactive</span>'; ?></td>
                                <td class="text-center">
                                    <a href="<?php echo base_url('admin/minute_bundles/edit/' . $b->id); ?>" class="btn btn-outline-primary btn-sm px-2 me-1" title="<?php echo t('Edit', 'Edit'); ?>"><i data-lucide="edit" style="width:14px;height:14px;"></i></a>
                                    <a href="<?php echo base_url('admin/minute_bundles/delete/' . $b->id); ?>" class="btn btn-outline-danger btn-sm px-2" data-confirm="<?php echo t('Hapus bundel menit?', 'Delete minute bundle?'); ?>"><i data-lucide="trash-2" style="width:14px;height:14px;"></i></a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>