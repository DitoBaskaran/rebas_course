<div class="container-fluid px-0">
    <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between mb-5 gap-3">
        <div>
            <span class="text-primary fw-semibold small text-uppercase tracking-wide d-block mb-1">Konten</span>
            <h1 class="display-6 fw-extrabold text-dark mb-1 lh-sm" style="letter-spacing: -0.03em;"><?php echo t('Kategori', 'Categories'); ?></h1>
            <p class="text-secondary mb-0"><?php echo t('Kelola kategori konten pembelajaran.', 'Manage learning content categories.'); ?></p>
        </div>
        <a href="<?php echo base_url('admin/create_category'); ?>" class="btn btn-dark btn-sm px-3 rounded-pill shadow-sm d-flex align-items-center gap-1">
            <i data-lucide="plus" style="width:16px;height:16px;"></i> <?php echo t('Tambah Kategori', 'Add Category'); ?>
        </a>
    </div>

    <div class="bento-card p-4 p-xl-5">
        <?php if (empty($categories)): ?>
            <div class="empty-state">
                <i data-lucide="folder-tree" style="width:48px;height:48px;color:var(--gray-300);"></i>
                <h5><?php echo t('Belum ada kategori.', 'No categories yet.'); ?></h5>
            </div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table-modern">
                    <thead>
                        <tr>
                            <th><?php echo t('Nama', 'Name'); ?></th>
                            <th><?php echo t('English', 'English'); ?></th>
                            <th><?php echo t('Parent', 'Parent'); ?></th>
                            <th><?php echo t('Icon', 'Icon'); ?></th>
                            <th><?php echo t('Urutan', 'Order'); ?></th>
                            <th><?php echo t('Konten', 'Content'); ?></th>
                            <th class="text-center col-w-120"><?php echo t('Aksi', 'Action'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php function render_category_row($cat, $depth = 0) { ?>
                            <tr>
                                <td class="fw-bold text-dark small" style="padding-left: <?php echo 20 + ($depth * 20); ?>px;">
                                    <?php if ($cat->icon): ?><?php echo $cat->icon; ?> <?php endif; ?>
                                    <?php echo htmlspecialchars($cat->name); ?>
                                </td>
                                <td class="small"><?php echo htmlspecialchars($cat->name_en ?: '-'); ?></td>
                                <td class="small"><?php echo $cat->parent_id ? 'Yes' : '-'; ?></td>
                                <td class="small"><?php echo htmlspecialchars($cat->icon ?: '-'); ?></td>
                                <td class="small"><?php echo $cat->sort_order; ?></td>
                                <td class="small"><?php echo isset($cat->content_count) ? $cat->content_count : '-'; ?></td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-1">
                                        <a href="<?php echo base_url('admin/edit_category/' . $cat->id); ?>" class="btn btn-warning btn-sm px-2" title="Edit">
                                            <i data-lucide="edit" style="width:14px;height:14px;"></i>
                                        </a>
                                        <a href="<?php echo base_url('admin/delete_category/' . $cat->id); ?>" class="btn btn-outline-danger btn-sm px-2" data-confirm="<?php echo t('Hapus kategori?', 'Delete category?'); ?>">
                                            <i data-lucide="trash-2" style="width:14px;height:14px;"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            <?php if (!empty($cat->children)): ?>
                                <?php foreach ($cat->children as $child): ?>
                                    <?php render_category_row($child, $depth + 1); ?>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        <?php } ?>
                        <?php foreach ($categories as $cat): ?>
                            <?php render_category_row($cat); ?>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>
