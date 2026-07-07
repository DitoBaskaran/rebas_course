<div class="container-fluid px-0">
    <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between mb-5 gap-3">
        <div>
            <span class="text-primary fw-semibold small text-uppercase tracking-wide d-block mb-1">Jalur Belajar</span>
            <h1 class="display-6 fw-extrabold text-dark mb-1 lh-sm" style="letter-spacing: -0.03em;"><?php echo t('Learning Paths', 'Learning Paths'); ?></h1>
            <p class="text-secondary mb-0"><?php echo t('Kelola jalur belajar terstruktur.', 'Manage structured learning paths.'); ?></p>
        </div>
        <a href="<?php echo base_url('admin/create_learning_path'); ?>" class="btn btn-dark btn-sm px-3 rounded-pill shadow-sm d-flex align-items-center gap-1">
            <i data-lucide="plus" style="width:16px;height:16px;"></i> <?php echo t('Buat', 'Create'); ?>
        </a>
    </div>

    <div class="bento-card p-4 p-xl-5">
        <div class="table-responsive">
            <table class="table-modern">
                <thead>
                    <tr><th><?php echo t('Judul', 'Title'); ?></th><th><?php echo t('Kategori', 'Category'); ?></th><th><?php echo t('Level', 'Level'); ?></th><th><?php echo t('Konten', 'Content'); ?></th><th class="text-center col-w-120"><?php echo t('Aksi', 'Actions'); ?></th></tr>
                </thead>
                <tbody>
                    <?php if (empty($paths)): ?>
                        <tr><td colspan="5" class="text-center text-muted py-5"><?php echo t('Belum ada learning path.', 'No learning paths.'); ?></td></tr>
                    <?php else: ?>
                        <?php foreach ($paths as $p): ?>
                            <tr>
                                <td class="fw-bold text-dark"><span class="d-inline-block rounded-2 me-2" style="width: 12px; height: 12px; background: <?php echo $p->color ?? '#4361ee'; ?>;"></span><?php echo htmlspecialchars($p->title); ?></td>
                                <td><?php echo htmlspecialchars($p->category_name ?? '-'); ?></td>
                                <td><span class="badge bg-primary-subtle text-primary rounded-pill px-3 py-2 fw-medium"><?php echo skill_level_label($p->skill_level); ?></span></td>
                                <td><?php echo $p->content_count ?? 0; ?> <?php echo t('konten', 'items'); ?></td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-1">
                                        <a href="<?php echo base_url('admin/edit_learning_path/' . $p->id); ?>" class="btn btn-warning btn-sm px-2 rounded-pill" title="<?php echo t('Edit', 'Edit'); ?>">
                                            <i data-lucide="edit" style="width:14px;height:14px;"></i>
                                        </a>
                                        <a href="<?php echo base_url('admin/delete_learning_path/' . $p->id); ?>" class="btn btn-outline-danger btn-sm px-2 rounded-pill" data-confirm="<?php echo t('Hapus?', 'Delete?'); ?>">
                                            <i data-lucide="trash-2" style="width:14px;height:14px;"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>