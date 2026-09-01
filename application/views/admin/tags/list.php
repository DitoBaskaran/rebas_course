<div class="app-page">
    <!-- Header -->
    <div class="app-page-head">
        <div>
            <h4 class="app-page-title"><i class="fas fa-tags"></i> <?php echo t('Tags', 'Tags'); ?></h4>
            <p class="app-page-sub"><?php echo t('Kelola tag untuk konten pembelajaran.', 'Manage tags for learning content.'); ?></p>
        </div>
    </div>

    <?php echo form_open('admin/create_tag', array('class' => 'app-toolbar')); ?>
        <div class="app-search" style="flex:0 1 260px;">
            <input type="text" name="name" placeholder="<?php echo t('Nama tag', 'Tag name'); ?>" required>
        </div>
        <div class="app-search" style="flex:0 1 200px;">
            <input type="text" name="name_en" placeholder="English">
        </div>
        <button type="submit" class="app-btn app-btn-primary"><i class="fas fa-plus"></i> <?php echo t('Tambah', 'Add'); ?></button>
    </form>

    <div class="app-card app-card-pad">
        <?php if (empty($tags)): ?>
            <div class="app-empty">
                <i class="fas fa-tags"></i>
                <h6><?php echo t('Belum ada tag.', 'No tags yet.'); ?></h6>
                <p><?php echo t('Tambahkan tag pertama Anda.', 'Add your first tag.'); ?></p>
            </div>
        <?php else: ?>
            <div class="d-flex flex-wrap gap-2">
                <?php foreach ($tags as $tag): ?>
                    <div class="d-inline-flex align-items-center gap-2 px-3 py-2 rounded-pill" style="background:#E6EBEF;border:1px solid #e7e5e4;">
                        <span class="fw-semibold" style="color:#0D1830;font-size:0.8rem;"><?php echo htmlspecialchars($tag->name); ?></span>
                        <?php if ($tag->name_en): ?><span style="color:#a8a29e;font-size:0.72rem;">/ <?php echo htmlspecialchars($tag->name_en); ?></span><?php endif; ?>
                        <a href="<?php echo base_url('admin/delete_tag/' . $tag->id); ?>" class="d-inline-flex align-items-center ms-1" style="color:#f43f5e;text-decoration:none;" data-confirm="<?php echo t('Hapus tag?', 'Delete tag?'); ?>"><i class="fas fa-times" style="font-size:0.65rem;"></i></a>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>
