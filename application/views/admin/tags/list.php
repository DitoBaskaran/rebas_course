<div class="container-fluid px-0">
    <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between mb-5 gap-3">
        <div>
            <span class="text-primary fw-semibold small text-uppercase tracking-wide d-block mb-1">Tag</span>
            <h1 class="display-6 fw-extrabold text-dark mb-1 lh-sm" style="letter-spacing: -0.03em;"><?php echo t('Tags', 'Tags'); ?></h1>
            <p class="text-secondary mb-0"><?php echo t('Kelola tag untuk konten pembelajaran.', 'Manage tags for learning content.'); ?></p>
        </div>
        <form action="<?php echo base_url('admin/create_tag'); ?>" method="POST" class="d-flex gap-2">
            <input type="text" name="name" class="form-control form-control-sm rounded-pill" placeholder="<?php echo t('Nama tag', 'Tag name'); ?>" required style="min-width:140px;">
            <input type="text" name="name_en" class="form-control form-control-sm rounded-pill" placeholder="English" style="min-width:120px;">
            <button type="submit" class="btn btn-dark btn-sm rounded-pill shadow-sm px-3 d-flex align-items-center gap-1">
                <i data-lucide="plus" style="width:16px;height:16px;"></i> <?php echo t('Tambah', 'Add'); ?>
            </button>
        </form>
    </div>

    <div class="bento-card p-4 p-xl-5">
        <?php if (empty($tags)): ?>
            <div class="empty-state">
                <i data-lucide="tags" style="width:48px;height:48px;color:var(--gray-300);"></i>
                <h5><?php echo t('Belum ada tag.', 'No tags yet.'); ?></h5>
            </div>
        <?php else: ?>
            <div class="d-flex flex-wrap gap-2">
                <?php foreach ($tags as $tag): ?>
                    <div class="d-inline-flex align-items-center gap-2 bg-light rounded-pill px-3 py-2 border">
                        <span class="small fw-semibold text-dark"><?php echo htmlspecialchars($tag->name); ?></span>
                        <?php if ($tag->name_en): ?>
                            <span class="small text-muted">/ <?php echo htmlspecialchars($tag->name_en); ?></span>
                        <?php endif; ?>
                        <a href="<?php echo base_url('admin/delete_tag/' . $tag->id); ?>" class="d-inline-flex align-items-center text-danger ms-1" data-confirm="<?php echo t('Hapus tag?', 'Delete tag?'); ?>">
                            <i data-lucide="x" style="width:14px;height:14px;"></i>
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>