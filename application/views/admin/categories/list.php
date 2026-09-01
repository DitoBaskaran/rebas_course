<div class="app-page">
    <!-- Header -->
    <div class="app-page-head">
        <div>
            <h4 class="app-page-title"><i class="fas fa-folder-tree"></i> <?php echo t('Kategori', 'Categories'); ?></h4>
            <p class="app-page-sub"><?php echo t('Kelola kategori konten pembelajaran.', 'Manage learning content categories.'); ?></p>
        </div>
        <div class="app-page-actions">
            <a href="<?php echo base_url('admin/create_category'); ?>" class="app-btn app-btn-primary"><i class="fas fa-plus"></i> <?php echo t('Tambah Kategori', 'Add Category'); ?></a>
        </div>
    </div>

    <?php if (empty($categories)): ?>
        <div class="app-card">
            <div class="app-empty">
                <i class="fas fa-folder-tree"></i>
                <h6><?php echo t('Belum ada kategori.', 'No categories yet.'); ?></h6>
                <p><?php echo t('Tambahkan kategori konten pertama.', 'Add your first content category.'); ?></p>
            </div>
        </div>
    <?php else: ?>
        <div class="app-card">
            <div class="app-table-wrap">
                <table class="app-table">
                    <thead>
                        <tr>
                            <th><?php echo t('Nama', 'Name'); ?></th>
                            <th><?php echo t('English', 'English'); ?></th>
                            <th><?php echo t('Parent', 'Parent'); ?></th>
                            <th><?php echo t('Icon', 'Icon'); ?></th>
                            <th><?php echo t('Urutan', 'Order'); ?></th>
                            <th><?php echo t('Konten', 'Content'); ?></th>
                            <th class="td-actions"><?php echo t('Aksi', 'Action'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php function render_category_row($cat, $depth = 0) { ?>
                            <tr>
                                <td class="td-title" style="padding-left: <?php echo 20 + ($depth * 20); ?>px;">
                                    <?php if ($cat->icon): ?><?php echo $cat->icon; ?> <?php endif; ?>
                                    <?php echo htmlspecialchars($cat->name); ?>
                                </td>
                                <td style="font-size:0.78rem;"><?php echo htmlspecialchars($cat->name_en ?: '-'); ?></td>
                                <td style="font-size:0.78rem;"><?php echo $cat->parent_id ? 'Yes' : '-'; ?></td>
                                <td style="font-size:0.78rem;"><?php echo htmlspecialchars($cat->icon ?: '-'); ?></td>
                                <td style="font-size:0.78rem;"><?php echo $cat->sort_order; ?></td>
                                <td style="font-size:0.78rem;"><?php echo isset($cat->content_count) ? $cat->content_count : '-'; ?></td>
                                <td class="td-actions">
                                    <a href="<?php echo base_url('admin/edit_category/' . $cat->id); ?>" class="app-action app-action-dark" title="Edit"><i class="fas fa-edit"></i></a>
                                    <a href="<?php echo base_url('admin/delete_category/' . $cat->id); ?>" class="app-action app-action-red" data-confirm="<?php echo t('Hapus kategori?', 'Delete category?'); ?>" title="<?php echo t('Hapus', 'Delete'); ?>"><i class="fas fa-trash-alt"></i></a>
                                </td>
                            </tr>
                        <?php } ?>
                        <?php foreach ($categories as $cat): ?>
                            <?php render_category_row($cat, 0); ?>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php endif; ?>
</div>
