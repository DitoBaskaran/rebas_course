<div class="container-fluid px-0">
    <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between mb-5 gap-3">
        <div>
            <span class="text-primary fw-semibold small text-uppercase tracking-wide d-block mb-1">Langganan</span>
            <h1 class="display-6 fw-extrabold text-dark mb-1 lh-sm" style="letter-spacing: -0.03em;"><?php echo t('Paket Langganan', 'Subscription Packages'); ?></h1>
            <p class="text-secondary mb-0"><?php echo t('Kelola paket langganan dan akses konten.', 'Manage subscription packages and content access.'); ?></p>
        </div>
        <a href="<?php echo base_url('admin/packages/create'); ?>" class="btn btn-dark btn-sm px-3 rounded-pill shadow-sm d-flex align-items-center gap-1">
            <i data-lucide="plus" style="width:16px;height:16px;"></i> <?php echo t('Buat Paket Baru', 'Create New Package'); ?>
        </a>
    </div>
    <div class="bento-card p-4 p-xl-5">
        <?php if (empty($packages)): ?>
            <div class="empty-state"><i data-lucide="layers" style="width:48px;height:48px;color:var(--gray-300);"></i><h5><?php echo t('Belum ada paket langganan.', 'No subscription packages yet.'); ?></h5></div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table-modern">
                    <thead><tr><th><?php echo t('Nama Paket', 'Package Name'); ?></th><th><?php echo t('Harga', 'Price'); ?></th><th><?php echo t('Durasi', 'Duration'); ?></th><th><?php echo t('Akses', 'Access'); ?></th><th><?php echo t('Status', 'Status'); ?></th><th class="text-center"><?php echo t('Aksi', 'Action'); ?></th></tr></thead>
                    <tbody>
                        <?php foreach ($packages as $p): ?>
                            <tr>
                                <td class="fw-bold text-dark"><?php echo htmlspecialchars($p->name); ?></td>
                                <td><?php echo 'Rp ' . number_format($p->price, 0, ',', '.'); ?></td>
                                <td><?php echo $p->duration_days . ' ' . t('hari', 'days'); ?></td>
                                <td>
                                    <?php 
                                        if ($p->access_scope === 'all') echo t('Semua Konten', 'All Content');
                                        elseif ($p->access_scope === 'category') echo t('Per Kategori', 'By Category');
                                        else echo t('Per Kursus', 'By Course');
                                    ?>
                                </td>
                                <td><?php echo $p->is_active ? '<span class="badge bg-success badge-modern">Active</span>' : '<span class="badge bg-secondary badge-modern">Inactive</span>'; ?></td>
                                <td class="text-center">
                                    <a href="<?php echo base_url('admin/packages/edit/' . $p->id); ?>" class="btn btn-outline-primary btn-sm px-2 me-1" title="<?php echo t('Edit', 'Edit'); ?>"><i data-lucide="edit" style="width:14px;height:14px;"></i></a>
                                    <a href="<?php echo base_url('admin/packages/delete/' . $p->id); ?>" class="btn btn-outline-danger btn-sm px-2" data-confirm="<?php echo t('Hapus paket langganan?', 'Delete subscription package?'); ?>"><i data-lucide="trash-2" style="width:14px;height:14px;"></i></a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>