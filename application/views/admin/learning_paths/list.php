<div class="app-page">
    <!-- Header -->
    <div class="app-page-head">
        <div>
            <h4 class="app-page-title"><i class="fas fa-route"></i> <?php echo t('Learning Paths', 'Learning Paths'); ?></h4>
            <p class="app-page-sub"><?php echo t('Kelola jalur belajar terstruktur.', 'Manage structured learning paths.'); ?></p>
        </div>
        <div class="app-page-actions">
            <a href="<?php echo base_url('admin/create_learning_path'); ?>" class="app-btn app-btn-primary"><i class="fas fa-plus"></i> <?php echo t('Buat', 'Create'); ?></a>
        </div>
    </div>

    <div class="app-card app-table-desktop">
        <div class="app-table-wrap">
            <table class="app-table">
                <thead>
                    <tr>
                        <th><?php echo t('Judul', 'Title'); ?></th>
                        <th><?php echo t('Kategori', 'Category'); ?></th>
                        <th><?php echo t('Level', 'Level'); ?></th>
                        <th><?php echo t('Konten', 'Content'); ?></th>
                        <th class="td-actions"><?php echo t('Aksi', 'Actions'); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($paths)): ?>
                        <tr><td colspan="5" class="text-center py-5" style="color:#a8a29e;"><?php echo t('Belum ada learning path.', 'No learning paths.'); ?></td></tr>
                    <?php else: ?>
                        <?php foreach ($paths as $p): ?>
                            <tr>
                                <td class="td-title">
                                    <span class="d-inline-block rounded-2 me-2 align-middle" style="width:10px;height:10px;background:<?php echo $p->color ?? '#4361ee'; ?>;"></span>
                                    <?php echo htmlspecialchars($p->title); ?>
                                </td>
                                <td style="color:#57534e;font-size:0.78rem;"><?php echo htmlspecialchars($p->category_name ?? '-'); ?></td>
                                <td><span class="app-chip app-chip-amber"><?php echo skill_level_label($p->skill_level); ?></span></td>
                                <td style="color:#78716c;font-size:0.78rem;"><?php echo $p->content_count ?? 0; ?> <?php echo t('konten', 'items'); ?></td>
                                <td class="td-actions">
                                    <a href="<?php echo base_url('admin/edit_learning_path/' . $p->id); ?>" class="app-action app-action-dark" title="<?php echo t('Edit', 'Edit'); ?>"><i class="fas fa-edit"></i></a>
                                    <a href="<?php echo base_url('admin/delete_learning_path/' . $p->id); ?>" data-confirm="<?php echo t('Hapus?', 'Delete?'); ?>" class="app-action app-action-red" title="<?php echo t('Hapus', 'Delete'); ?>"><i class="fas fa-trash-alt"></i></a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Mobile: kartu eksplisit -->
    <?php if (!empty($paths)): ?>
    <div class="app-row-list app-list">
        <?php foreach ($paths as $p): ?>
            <div class="app-row app-row-card">
                <div class="app-row-head">
                    <span class="d-inline-block rounded-2" style="width:12px;height:38px;background:<?php echo $p->color ?? '#4361ee'; ?>;flex-shrink:0;"></span>
                    <div class="app-row-main">
                        <div class="app-row-title"><?php echo htmlspecialchars($p->title); ?></div>
                        <div class="app-row-sub"><?php echo htmlspecialchars($p->category_name ?? '-'); ?></div>
                    </div>
                    <span class="app-chip app-chip-amber"><?php echo skill_level_label($p->skill_level); ?></span>
                </div>
                <div class="app-row-meta">
                    <span><b><?php echo t('Konten', 'Content'); ?>:</b> <?php echo $p->content_count ?? 0; ?> <?php echo t('konten', 'items'); ?></span>
                </div>
                <div class="app-actions">
                    <a href="<?php echo base_url('admin/edit_learning_path/' . $p->id); ?>" class="app-action app-action-dark" title="<?php echo t('Edit', 'Edit'); ?>"><i class="fas fa-edit"></i></a>
                    <a href="<?php echo base_url('admin/delete_learning_path/' . $p->id); ?>" data-confirm="<?php echo t('Hapus?', 'Delete?'); ?>" class="app-action app-action-red" title="<?php echo t('Hapus', 'Delete'); ?>"><i class="fas fa-trash-alt"></i></a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>
</div>
