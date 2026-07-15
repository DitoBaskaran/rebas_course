<div class="container-fluid py-4" style="max-width: 1400px;">
    <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between mb-4 gap-3">
        <div>
            <div style="color: #f97316; font-weight: 700; font-size: 0.7rem; text-transform: uppercase; letter-spacing: 0.08em; margin-bottom: 0.15rem;"><?php echo t('Jalur Belajar', 'Learning Paths'); ?></div>
            <h4 class="fw-extrabold mb-0" style="color: #1c1917; letter-spacing: -0.02em; font-size: 1.4rem;"><?php echo t('Learning Paths', 'Learning Paths'); ?></h4>
            <p style="color: #78716c; font-size: 0.82rem; margin-bottom: 0;"><?php echo t('Kelola jalur belajar terstruktur.', 'Manage structured learning paths.'); ?></p>
        </div>
        <a href="<?php echo base_url('admin/create_learning_path'); ?>" class="btn px-3 py-2 fw-semibold rounded-pill d-flex align-items-center gap-1" style="background: #f97316; color: #fff; font-size: 0.78rem;"><i class="fas fa-plus" style="font-size: 0.7rem;"></i> <?php echo t('Buat', 'Create'); ?></a>
    </div>

    <div class="border rounded-3" style="border-color: #e7e5e4; border-radius: 12px; overflow: hidden;">
        <div class="table-responsive p-0">
            <table class="table mb-0" style="font-size: 0.8rem;">
                <thead>
                    <tr>
                        <th style="font-weight: 600; color: #78716c; font-size: 0.68rem; border-color: #e7e5e4; padding: 0.7rem 1rem; background: #fafaf9; text-transform: uppercase; letter-spacing: 0.05em;"><?php echo t('Judul', 'Title'); ?></th>
                        <th style="font-weight: 600; color: #78716c; font-size: 0.68rem; border-color: #e7e5e4; padding: 0.7rem 1rem; background: #fafaf9; text-transform: uppercase; letter-spacing: 0.05em;"><?php echo t('Kategori', 'Category'); ?></th>
                        <th style="font-weight: 600; color: #78716c; font-size: 0.68rem; border-color: #e7e5e4; padding: 0.7rem 1rem; background: #fafaf9; text-transform: uppercase; letter-spacing: 0.05em;"><?php echo t('Level', 'Level'); ?></th>
                        <th style="font-weight: 600; color: #78716c; font-size: 0.68rem; border-color: #e7e5e4; padding: 0.7rem 1rem; background: #fafaf9; text-transform: uppercase; letter-spacing: 0.05em;"><?php echo t('Konten', 'Content'); ?></th>
                        <th style="font-weight: 600; color: #78716c; font-size: 0.68rem; border-color: #e7e5e4; padding: 0.7rem 1rem; background: #fafaf9; text-transform: uppercase; letter-spacing: 0.05em; text-align: center; width: 100px;"><?php echo t('Aksi', 'Actions'); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($paths)): ?>
                        <tr><td colspan="5" class="text-center py-5" style="color: #a8a29e; font-size: 0.85rem;"><?php echo t('Belum ada learning path.', 'No learning paths.'); ?></td></tr>
                    <?php else: ?>
                        <?php foreach ($paths as $p): ?>
                            <tr>
                                <td style="border-color: #f0eeeb; padding: 0.65rem 1rem; font-weight: 700; color: #1c1917; font-size: 0.82rem;">
                                    <span class="d-inline-block rounded-2 me-2 align-middle" style="width: 10px; height: 10px; background: <?php echo $p->color ?? '#4361ee'; ?>;"></span>
                                    <?php echo htmlspecialchars($p->title); ?>
                                </td>
                                <td style="border-color: #f0eeeb; padding: 0.65rem 1rem; color: #57534e; font-size: 0.78rem;"><?php echo htmlspecialchars($p->category_name ?? '-'); ?></td>
                                <td style="border-color: #f0eeeb; padding: 0.65rem 1rem;"><span class="px-2 py-1 rounded-pill fw-semibold" style="background: #fff7ed; color: #f97316; font-size: 0.6rem;"><?php echo skill_level_label($p->skill_level); ?></span></td>
                                <td style="border-color: #f0eeeb; padding: 0.65rem 1rem; color: #78716c; font-size: 0.78rem;"><?php echo $p->content_count ?? 0; ?> <?php echo t('konten', 'items'); ?></td>
                                <td style="border-color: #f0eeeb; padding: 0.65rem 1rem; text-align: center;">
                                    <div class="d-flex justify-content-center gap-1">
                                        <a href="<?php echo base_url('admin/edit_learning_path/' . $p->id); ?>" class="btn btn-sm rounded-pill px-2 d-inline-flex align-items-center" style="background: #f97316; color: #fff; font-size: 0.68rem;"><i class="fas fa-edit" style="font-size: 0.65rem;"></i></a>
                                        <a href="<?php echo base_url('admin/delete_learning_path/' . $p->id); ?>" data-confirm="<?php echo t('Hapus?', 'Delete?'); ?>" class="btn btn-sm rounded-pill px-2 d-inline-flex align-items-center" style="border: 1px solid #fca5a5; color: #f43f5e; font-size: 0.68rem;"><i class="fas fa-trash-alt" style="font-size: 0.65rem;"></i></a>
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
