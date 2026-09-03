<div class="container-fluid px-0">

    <!-- ============ HEADER (hero) ============ -->
    <div class="bento-card mb-4 overflow-hidden" style="background:linear-gradient(120deg,#0D1830 0%,#164e63 100%);border:none;color:#fff;">
        <div class="d-flex align-items-center justify-content-between gap-3 position-relative" style="z-index:1;">
            <div>
                <span class="d-inline-flex align-items-center gap-1" style="background:rgba(255,255,255,0.14);border:1px solid rgba(255,255,255,0.2);color:#FBBF24;font-size:0.66rem;font-weight:800;letter-spacing:0.12em;text-transform:uppercase;padding:0.3rem 0.7rem;border-radius:100px;">
                    <i data-lucide="tags" style="width:12px;height:12px;"></i>
                    <?php echo t('Konten', 'Content'); ?>
                </span>
                <h1 class="fw-extrabold text-white mb-1 mt-2 lh-sm" style="letter-spacing:-0.03em;font-size:1.6rem;">
                    <?php echo t('Tags', 'Tags'); ?>
                </h1>
                <p class="mb-0" style="color:rgba(255,255,255,0.72);font-size:0.82rem;">
                    <?php echo t('Kelola tag untuk konten pembelajaran.', 'Manage tags for learning content.'); ?>
                    <span class="fw-semibold text-white">(<?php echo count($tags); ?>)</span>
                </p>
            </div>
        </div>
    </div>

    <!-- ============ ADD TAG FORM ============ -->
    <div class="bento-card mb-4">
        <h6 class="fw-bold text-dark mb-3 d-flex align-items-center gap-2" style="font-size:0.85rem;">
            <i data-lucide="plus-circle" style="width:16px;height:16px;color:var(--primary);"></i> <?php echo t('Tambah Tag Baru', 'Add New Tag'); ?>
        </h6>
        <?php echo form_open('admin/create_tag', array('class' => 'row g-2 align-items-end')); ?>
            <div class="col-md-4">
                <label class="form-label fw-semibold small"><?php echo t('Nama (Indonesia)', 'Name (Indonesian)'); ?> *</label>
                <input type="text" name="name" class="form-control" required placeholder="<?php echo t('cth: JavaScript', 'e.g: JavaScript'); ?>" style="border-radius:12px;font-size:0.85rem;height:42px;">
            </div>
            <div class="col-md-4">
                <label class="form-label fw-semibold small"><?php echo t('Nama (English)', 'Name (English)'); ?></label>
                <input type="text" name="name_en" class="form-control" placeholder="English (optional)" style="border-radius:12px;font-size:0.85rem;height:42px;">
            </div>
            <div class="col-md-4">
                <button type="submit" class="btn fw-semibold rounded-pill d-inline-flex align-items-center justify-content-center gap-2 border-0 w-100" style="background:#0D1830;color:#fff;font-size:0.82rem;height:42px;">
                    <i data-lucide="plus" style="width:15px;height:15px;"></i> <?php echo t('Tambah Tag', 'Add Tag'); ?>
                </button>
            </div>
        <?php echo form_close(); ?>
    </div>

    <!-- ============ TAG LIST ============ -->
    <div class="bento-card">
        <div class="d-flex align-items-center justify-content-between mb-3">
            <h6 class="fw-bold text-dark mb-0 d-flex align-items-center gap-2" style="font-size:0.85rem;">
                <i data-lucide="list" style="width:16px;height:16px;color:var(--gray-400,#94a3b8);"></i> <?php echo t('Semua Tag', 'All Tags'); ?>
            </h6>
            <?php if (!empty($tags)): ?>
            <div class="position-relative" style="max-width:220px;">
                <i data-lucide="search" style="width:13px;height:13px;position:absolute;left:0.75rem;top:50%;transform:translateY(-50%);color:var(--gray-400,#94a3b8);"></i>
                <input type="text" class="form-control form-control-sm" style="padding-left:2rem;border-radius:100px;font-size:0.78rem;" placeholder="<?php echo t('Cari tag...', 'Search tags...'); ?>" id="tagSearch" onkeyup="filterTags()">
            </div>
            <?php endif; ?>
        </div>

        <?php if (empty($tags)): ?>
            <div class="text-center py-5">
                <div class="mx-auto d-inline-flex align-items-center justify-content-center rounded-circle mb-3" style="width:64px;height:64px;background:#E6EBEF;color:#94a3b8;">
                    <i data-lucide="tags" style="width:26px;height:26px;"></i>
                </div>
                <h6 class="fw-bold text-dark mb-1"><?php echo t('Belum ada tag.', 'No tags yet.'); ?></h6>
                <p class="text-secondary small mb-0"><?php echo t('Tambahkan tag pertama Anda menggunakan form di atas.', 'Add your first tag using the form above.'); ?></p>
            </div>
        <?php else: ?>
            <div class="d-flex flex-wrap gap-2" id="tagCloud">
                <?php
                    $palette = ['#009688','#2563eb','#ea580c','#c026d3','#16a34a','#dc2626','#7c3aed','#0284c7'];
                    foreach ($tags as $i => $tag):
                        $c = $palette[$i % count($palette)];
                        $search_blob = strtolower(htmlspecialchars($tag->name . ' ' . $tag->name_en));
                ?>
                    <div class="tag-chip" data-search="<?php echo $search_blob; ?>" style="border-color:<?php echo $c; ?>33;">
                        <span class="tag-chip-dot" style="background:<?php echo $c; ?>;"></span>
                        <span class="tag-chip-name"><?php echo htmlspecialchars($tag->name); ?></span>
                        <?php if ($tag->name_en): ?><span class="tag-chip-en">/ <?php echo htmlspecialchars($tag->name_en); ?></span><?php endif; ?>
                        <a href="<?php echo base_url('admin/delete_tag/' . $tag->id); ?>" class="tag-chip-del" data-confirm="<?php echo t('Hapus tag ini?', 'Delete this tag?'); ?>" title="<?php echo t('Hapus', 'Delete'); ?>">
                            <i class="fas fa-times"></i>
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="text-center mt-3" id="noTagMsg" style="display:none;">
                <span class="text-muted small"><?php echo t('Tidak ada tag yang cocok.', 'No matching tags.'); ?></span>
            </div>
        <?php endif; ?>
    </div>
</div>
<script>
function filterTags() {
    var q = (document.getElementById('tagSearch')?.value || '').toLowerCase();
    var visible = 0;
    document.querySelectorAll('#tagCloud .tag-chip').forEach(function(chip) {
        var text = chip.getAttribute('data-search') || '';
        var match = text.indexOf(q) !== -1;
        chip.style.display = match ? '' : 'none';
        if (match) visible++;
    });
    var msg = document.getElementById('noTagMsg');
    if (msg) msg.style.display = visible === 0 ? 'block' : 'none';
}
</script>
