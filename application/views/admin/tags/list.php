<div class="container-fluid py-4" style="max-width: 1400px;">
    <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between mb-4 gap-3">
        <div>
            <div style="color: #f97316; font-weight: 700; font-size: 0.7rem; text-transform: uppercase; letter-spacing: 0.08em; margin-bottom: 0.15rem;">Tag</div>
            <h4 class="fw-extrabold mb-0" style="color: #1c1917; letter-spacing: -0.02em; font-size: 1.4rem;"><?php echo t('Tags', 'Tags'); ?></h4>
            <p style="color: #78716c; font-size: 0.82rem; margin-bottom: 0;"><?php echo t('Kelola tag untuk konten pembelajaran.', 'Manage tags for learning content.'); ?></p>
        </div>
        <form action="<?php echo base_url('admin/create_tag'); ?>" method="POST" class="d-flex gap-2">
            <input type="text" name="name" class="form-control rounded-pill" placeholder="<?php echo t('Nama tag', 'Tag name'); ?>" required style="min-width: 130px; height: 40px; border-color: #e7e5e4; font-size: 0.82rem;">
            <input type="text" name="name_en" class="form-control rounded-pill" placeholder="English" style="min-width: 100px; height: 40px; border-color: #e7e5e4; font-size: 0.82rem;">
            <button type="submit" class="btn px-3 py-2 fw-semibold rounded-pill d-flex align-items-center gap-1" style="background: #f97316; color: #fff; font-size: 0.78rem; height: 40px;"><i class="fas fa-plus" style="font-size: 0.7rem;"></i> <?php echo t('Tambah', 'Add'); ?></button>
        </form>
    </div>

    <div class="border rounded-3 p-3" style="border-color: #e7e5e4; border-radius: 12px;">
        <?php if (empty($tags)): ?>
            <div class="p-5 text-center"><div style="font-size: 2rem; color: #d6d3d1; margin-bottom: 0.5rem;"><i class="fas fa-tags"></i></div><h6 class="fw-bold" style="color: #1c1917;"><?php echo t('Belum ada tag.', 'No tags yet.'); ?></h6></div>
        <?php else: ?>
            <div class="d-flex flex-wrap gap-2">
                <?php foreach ($tags as $tag): ?>
                    <div class="d-inline-flex align-items-center gap-2 px-3 py-2 rounded-pill" style="background: #fafaf9; border: 1px solid #e7e5e4;">
                        <span class="fw-semibold" style="color: #1c1917; font-size: 0.8rem;"><?php echo htmlspecialchars($tag->name); ?></span>
                        <?php if ($tag->name_en): ?><span style="color: #a8a29e; font-size: 0.72rem;">/ <?php echo htmlspecialchars($tag->name_en); ?></span><?php endif; ?>
                        <a href="<?php echo base_url('admin/delete_tag/' . $tag->id); ?>" class="d-inline-flex align-items-center ms-1" style="color: #f43f5e; text-decoration: none;" data-confirm="<?php echo t('Hapus tag?', 'Delete tag?'); ?>"><i class="fas fa-times" style="font-size: 0.65rem;"></i></a>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>
