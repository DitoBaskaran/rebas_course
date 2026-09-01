<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="app-page">
    <!-- Header -->
    <div class="app-page-head">
        <div>
            <h4 class="app-page-title"><i class="fas fa-images"></i> <?php echo t('Banner Dashboard', 'Dashboard Banners'); ?></h4>
            <p class="app-page-sub"><?php echo t('Kelola carousel banner di dashboard student & mentor.', 'Manage banner carousel on student & mentor dashboard.'); ?></p>
        </div>
        <div class="app-page-actions">
            <a href="<?php echo base_url('admin/banners_create'); ?>" class="app-btn app-btn-primary"><i class="fas fa-plus"></i> <?php echo t('Tambah Banner', 'Add Banner'); ?></a>
        </div>
    </div>

    <div class="app-card app-table-desktop">
        <div class="app-table-wrap">
            <table class="app-table">
                <thead>
                    <tr>
                        <th><?php echo t('Gambar', 'Image'); ?></th>
                        <th><?php echo t('Judul', 'Title'); ?></th>
                        <th><?php echo t('Tautan', 'Link'); ?></th>
                        <th><?php echo t('Target', 'Target'); ?></th>
                        <th><?php echo t('Status', 'Status'); ?></th>
                        <th class="td-actions"><?php echo t('Aksi', 'Action'); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($banners)): ?>
                        <tr>
                            <td colspan="6" class="text-center py-5" style="color:#a8a29e;">
                                <div style="font-size:2rem;color:#d6d3d1;margin-bottom:0.5rem;"><i class="fas fa-images"></i></div>
                                <?php echo t('Belum ada banner. Tambahkan banner pertama Anda.', 'No banners yet. Add your first banner.'); ?>
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($banners as $b): ?>
                            <tr>
                                <td>
                                    <?php if ($b->image && file_exists(FCPATH . 'uploads/banners/' . $b->image)): ?>
                                        <img src="<?php echo base_url('uploads/banners/' . $b->image); ?>" alt="" class="app-thumb" style="width:70px;height:40px;">
                                    <?php else: ?>
                                        <span class="app-chip app-chip-gray"><?php echo t('No Img', 'No Img'); ?></span>
                                    <?php endif; ?>
                                </td>
                                <td class="td-title"><?php echo htmlspecialchars($b->title); ?></td>
                                <td>
                                    <?php if ($b->link): ?>
                                        <a href="<?php echo htmlspecialchars($b->link); ?>" target="_blank" class="text-decoration-none" style="color:#009688;font-size:0.75rem;"><i class="fas fa-external-link-alt me-1" style="font-size:0.6rem;"></i><?php echo htmlspecialchars(substr($b->link, 0, 40)); ?></a>
                                    <?php else: ?>
                                        <span style="color:#a8a29e;">—</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <span class="app-chip <?php echo $b->target === 'student' ? 'app-chip-blue' : ($b->target === 'mentor' ? 'app-chip-purple' : 'app-chip-green'); ?>">
                                        <?php echo $b->target === 'both' ? t('Semua', 'All') : ucfirst($b->target); ?>
                                    </span>
                                </td>
                                <td>
                                    <?php if ($b->is_active): ?><span class="app-chip app-chip-green">Active</span><?php else: ?><span class="app-chip app-chip-gray">Inactive</span><?php endif; ?>
                                </td>
                                <td class="td-actions">
                                    <a href="<?php echo base_url('admin/banners_edit/' . $b->id); ?>" class="app-action app-action-dark" title="<?php echo t('Edit', 'Edit'); ?>"><i class="fas fa-edit"></i></a>
                                    <a href="<?php echo base_url('admin/banners_delete/' . $b->id); ?>" class="app-action app-action-red" data-confirm="<?php echo t('Hapus banner?', 'Delete banner?'); ?>" title="<?php echo t('Hapus', 'Delete'); ?>"><i class="fas fa-trash-alt"></i></a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Mobile: kartu eksplisit (1 baris kompak) -->
    <?php if (!empty($banners)): ?>
    <div class="app-row-list app-list">
        <?php foreach ($banners as $b): ?>
            <div class="app-row app-row-card">
                <div class="app-row-head">
                    <?php if ($b->image && file_exists(FCPATH . 'uploads/banners/' . $b->image)): ?>
                        <img src="<?php echo base_url('uploads/banners/' . $b->image); ?>" alt="" class="app-thumb" style="width:52px;height:32px;flex-shrink:0;">
                    <?php else: ?>
                        <div class="app-avatar" style="width:38px;height:38px;font-size:0.8rem;background:#E6EBEF;color:#78716c;flex-shrink:0;"><i class="fas fa-image"></i></div>
                    <?php endif; ?>
                    <div class="app-row-main">
                        <div class="app-row-title"><?php echo htmlspecialchars($b->title); ?></div>
                        <div class="app-row-sub"><?php echo $b->target === 'both' ? t('Semua', 'All') : ucfirst($b->target); ?></div>
                    </div>
                    <?php echo $b->is_active ? '<span class="app-chip app-chip-green">Active</span>' : '<span class="app-chip app-chip-gray">Inactive</span>'; ?>
                </div>
                <div class="app-actions">
                    <a href="<?php echo base_url('admin/banners_edit/' . $b->id); ?>" class="app-action app-action-dark" title="<?php echo t('Edit', 'Edit'); ?>"><i class="fas fa-edit"></i></a>
                    <a href="<?php echo base_url('admin/banners_delete/' . $b->id); ?>" class="app-action app-action-red" data-confirm="<?php echo t('Hapus banner?', 'Delete banner?'); ?>" title="<?php echo t('Hapus', 'Delete'); ?>"><i class="fas fa-trash-alt"></i></a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>
</div>
