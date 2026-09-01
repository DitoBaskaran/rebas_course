<div class="app-page">
    <!-- Header -->
    <div class="app-page-head">
        <div>
            <h4 class="app-page-title"><i class="fas fa-layer-group"></i> <?php echo t('Paket Langganan', 'Subscription Packages'); ?></h4>
            <p class="app-page-sub"><?php echo t('Kelola paket langganan dan akses konten.', 'Manage subscription packages and content access.'); ?></p>
        </div>
        <div class="app-page-actions">
            <a href="<?php echo base_url('admin/packages/create'); ?>" class="app-btn app-btn-primary"><i class="fas fa-plus"></i> <?php echo t('Buat Paket Baru', 'Create New Package'); ?></a>
        </div>
    </div>

    <div class="app-card">
        <?php if (empty($packages)): ?>
            <div class="app-empty">
                <i class="fas fa-layer-group"></i>
                <h6><?php echo t('Belum ada paket langganan.', 'No subscription packages yet.'); ?></h6>
                <p><?php echo t('Buat paket langganan pertama Anda.', 'Create your first subscription package.'); ?></p>
            </div>
        <?php else: ?>

        <!-- Mobile: kartu eksplisit -->
        <div class="app-row-list app-list">
            <?php foreach ($packages as $p): ?>
                <div class="app-row app-row-card">
                    <div class="app-row-head">
                        <div class="app-avatar" style="width:38px;height:38px;font-size:0.8rem;background:#E0F2F1;color:#009688;"><i class="fas fa-layer-group"></i></div>
                        <div class="app-row-main">
                            <div class="app-row-title"><?php echo htmlspecialchars($p->name); ?></div>
                            <div class="app-row-sub"><?php echo $p->duration_days . ' ' . t('hari', 'days'); ?></div>
                        </div>
                        <?php echo $p->is_active ? '<span class="app-chip app-chip-green">Active</span>' : '<span class="app-chip app-chip-gray">Inactive</span>'; ?>
                    </div>
                    <div class="app-row-meta">
                        <span><b><?php echo t('Harga', 'Price'); ?>:</b> Rp <?php echo number_format($p->price, 0, ',', '.'); ?></span>
                        <span><b><?php echo t('Akses', 'Access'); ?>:</b>
                            <?php if ($p->access_scope === 'all') echo t('Semua Konten', 'All Content'); elseif ($p->access_scope === 'category') echo t('Per Kategori', 'By Category'); else echo t('Per Kursus', 'By Course'); ?>
                        </span>
                    </div>
                    <div class="app-actions">
                        <a href="<?php echo base_url('admin/packages/edit/' . $p->id); ?>" class="app-action app-action-dark" title="<?php echo t('Edit', 'Edit'); ?>"><i class="fas fa-edit"></i></a>
                        <a href="<?php echo base_url('admin/packages/delete/' . $p->id); ?>" data-confirm="<?php echo t('Hapus paket langganan?', 'Delete subscription package?'); ?>" class="app-action app-action-red" title="<?php echo t('Hapus', 'Delete'); ?>"><i class="fas fa-trash-alt"></i></a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Desktop: tabel -->
        <div class="app-card app-table-desktop">
            <div class="app-table-wrap">
                <table class="app-table">
                    <thead>
                        <tr>
                            <th><?php echo t('Nama Paket', 'Package Name'); ?></th>
                            <th><?php echo t('Harga', 'Price'); ?></th>
                            <th><?php echo t('Durasi', 'Duration'); ?></th>
                            <th><?php echo t('Akses', 'Access'); ?></th>
                            <th><?php echo t('Status', 'Status'); ?></th>
                            <th class="td-actions"><?php echo t('Aksi', 'Action'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($packages as $p): ?>
                            <tr>
                                <td class="td-title"><?php echo htmlspecialchars($p->name); ?></td>
                                <td class="td-title">Rp <?php echo number_format($p->price, 0, ',', '.'); ?></td>
                                <td style="color:#57534e;font-size:0.78rem;"><?php echo $p->duration_days . ' ' . t('hari', 'days'); ?></td>
                                <td>
                                    <span class="app-chip <?php echo $p->access_scope === 'all' ? 'app-chip-green' : 'app-chip-amber'; ?>">
                                        <?php if ($p->access_scope === 'all') echo t('Semua Konten', 'All Content'); elseif ($p->access_scope === 'category') echo t('Per Kategori', 'By Category'); else echo t('Per Kursus', 'By Course'); ?>
                                    </span>
                                </td>
                                <td><?php echo $p->is_active ? '<span class="app-chip app-chip-green">Active</span>' : '<span class="app-chip app-chip-gray">Inactive</span>'; ?></td>
                                <td class="td-actions">
                                    <a href="<?php echo base_url('admin/packages/edit/' . $p->id); ?>" class="app-action app-action-dark" title="<?php echo t('Edit', 'Edit'); ?>"><i class="fas fa-edit"></i></a>
                                    <a href="<?php echo base_url('admin/packages/delete/' . $p->id); ?>" data-confirm="<?php echo t('Hapus paket langganan?', 'Delete subscription package?'); ?>" class="app-action app-action-red" title="<?php echo t('Hapus', 'Delete'); ?>"><i class="fas fa-trash-alt"></i></a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <?php endif; ?>
</div>
