<div class="container-fluid px-0">

    <!-- ============ HEADER (hero) ============ -->
    <div class="bento-card mb-4 overflow-hidden" style="background:linear-gradient(120deg,#0D1830 0%,#164e63 100%);border:none;color:#fff;">
        <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3 position-relative" style="z-index:1;">
            <div>
                <span class="d-inline-flex align-items-center gap-1" style="background:rgba(255,255,255,0.14);border:1px solid rgba(255,255,255,0.2);color:#FBBF24;font-size:0.66rem;font-weight:800;letter-spacing:0.12em;text-transform:uppercase;padding:0.3rem 0.7rem;border-radius:100px;">
                    <i data-lucide="languages" style="width:12px;height:12px;"></i>
                    <?php echo t('Lokalisasi', 'Localization'); ?>
                </span>
                <h1 class="fw-extrabold text-white mb-1 mt-2 lh-sm" style="letter-spacing:-0.03em;font-size:1.6rem;">
                    <?php echo t('Terjemahan', 'Translations'); ?>
                </h1>
                <p class="mb-0" style="color:rgba(255,255,255,0.72);font-size:0.82rem;">
                    <?php echo t('Atur teks UI dalam bahasa Indonesia dan Inggris.', 'Manage UI text in Indonesian and English.'); ?>
                    <span class="fw-semibold text-white">(<?php echo count($translations); ?>)</span>
                </p>
            </div>
        </div>
    </div>

    <!-- ============ FORM EDIT/SIMPAN ============ -->
    <div class="bento-card mb-4">
        <h6 class="fw-bold text-dark mb-3 d-flex align-items-center gap-2" style="font-size:0.85rem;">
            <i data-lucide="key-round" style="width:16px;height:16px;color:var(--primary);"></i> <?php echo t('Ubah / Simpan Terjemahan', 'Edit / Save Translation'); ?>
        </h6>
        <?php echo form_open('admin/translations', array('class' => 'row g-2 align-items-end')); ?>
            <div class="col-md-3">
                <label class="form-label fw-semibold small">Key</label>
                <input type="text" name="key" class="form-control" placeholder="hello_world" required style="border-radius:12px;font-family:monospace;font-size:0.82rem;height:42px;">
            </div>
            <div class="col-md-3">
                <label class="form-label fw-semibold small"><i class="fas fa-language me-1" style="font-size:0.68rem;color:var(--primary);"></i><?php echo t('Indonesia', 'Indonesian'); ?></label>
                <input type="text" name="value_id" class="form-control" placeholder="Halo dunia" style="border-radius:12px;font-size:0.85rem;height:42px;">
            </div>
            <div class="col-md-3">
                <label class="form-label fw-semibold small"><i class="fas fa-globe me-1" style="font-size:0.68rem;color:var(--gray-400);"></i>English</label>
                <input type="text" name="value_en" class="form-control" placeholder="Hello world" style="border-radius:12px;font-size:0.85rem;height:42px;">
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn fw-semibold rounded-pill d-inline-flex align-items-center justify-content-center gap-2 border-0 w-100" style="background:#0D1830;color:#fff;font-size:0.82rem;height:42px;">
                    <i data-lucide="save" style="width:15px;height:15px;"></i> <?php echo t('Simpan', 'Save'); ?>
                </button>
            </div>
            <div class="col-12">
                <small class="text-muted"><i class="fas fa-info-circle me-1" style="font-size:0.7rem;"></i><?php echo t('Key harus sudah ada di sistem; form ini memperbarui nilainya.', 'Key must already exist in the system; this form updates its values.'); ?></small>
            </div>
        <?php echo form_close(); ?>
    </div>

    <!-- ============ TOOLBAR ============ -->
    <div class="bento-card d-flex align-items-center gap-2 mb-4" style="padding:0.8rem 1rem;">
        <div class="flex-fill position-relative">
            <i data-lucide="search" style="width:15px;height:15px;position:absolute;left:0.9rem;top:50%;transform:translateY(-50%);color:var(--gray-400,#94a3b8);"></i>
            <input type="text" class="form-control" style="padding-left:2.3rem;border-radius:100px;font-size:0.82rem;" placeholder="<?php echo t('Cari key atau teks...', 'Search key or text...'); ?>" id="searchInput" onkeyup="filterTr()">
        </div>
    </div>

    <?php if (empty($translations)): ?>
        <div class="bento-card p-5 text-center">
            <div class="mx-auto d-inline-flex align-items-center justify-content-center rounded-circle mb-3" style="width:72px;height:72px;background:#eff6ff;color:#2563eb;">
                <i data-lucide="languages" style="width:30px;height:30px;"></i>
            </div>
            <h5 class="fw-extrabold text-dark mb-1"><?php echo t('Belum ada terjemahan.', 'No translations yet.'); ?></h5>
            <p class="text-secondary small mb-0"><?php echo t('Terjemahan baru muncul otomatis saat key dipakai pertama kali.', 'New translations appear automatically when a key is first used.'); ?></p>
        </div>
    <?php else: ?>
        <!-- ============ TRANSLATION ROWS ============ -->
        <div class="d-flex flex-column" style="gap:10px;" id="trList">
            <?php foreach ($translations as $t): ?>
                <?php $search_blob = strtolower(htmlspecialchars($t->key . ' ' . $t->value_id . ' ' . $t->value_en)); ?>
                <div class="tr-row" data-search="<?php echo $search_blob; ?>">
                    <div class="tr-key">
                        <i data-lucide="key-round" style="width:13px;height:13px;color:var(--gray-400,#94a3b8);flex-shrink:0;"></i>
                        <span><?php echo htmlspecialchars($t->key); ?></span>
                    </div>
                    <div class="flex-fill tr-values" style="min-width:0;">
                        <div class="d-flex align-items-baseline gap-2">
                            <span class="tr-lang" style="color:var(--primary);"><i class="fas fa-language me-1" style="font-size:0.55rem;"></i>ID</span>
                            <span class="text-dark" style="font-size:0.8rem;"><?php echo htmlspecialchars($t->value_id); ?></span>
                        </div>
                        <div class="d-flex align-items-baseline gap-2 mt-1">
                            <span class="tr-lang" style="color:var(--gray-400);"><i class="fas fa-globe me-1" style="font-size:0.55rem;"></i>EN</span>
                            <span class="text-secondary" style="font-size:0.78rem;"><?php echo htmlspecialchars($t->value_en); ?></span>
                        </div>
                    </div>
                    <a href="<?php echo base_url('admin/delete_translation/' . $t->id); ?>" class="btn btn-sm fw-semibold rounded-pill d-inline-flex align-items-center justify-content-center flex-shrink-0" style="background:#dc2626;color:#fff;border:none;font-size:0.7rem;width:32px;height:32px;padding:0;box-shadow:0 2px 8px rgba(220,38,38,0.2);" data-confirm="<?php echo t('Hapus terjemahan ini?', 'Delete this translation?'); ?>" title="<?php echo t('Hapus', 'Delete'); ?>"><i class="fas fa-trash-alt" style="color:#fff;font-size:0.66rem;"></i></a>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="text-center mt-3" id="noTrMsg" style="display:none;">
            <span class="text-muted small"><?php echo t('Tidak ada terjemahan yang cocok.', 'No matching translations.'); ?></span>
        </div>
    <?php endif; ?>
</div>
<script>
function filterTr() {
    var q = (document.getElementById('searchInput')?.value || '').toLowerCase();
    var visible = 0;
    document.querySelectorAll('#trList .tr-row').forEach(function(row) {
        var text = row.getAttribute('data-search') || '';
        var match = text.indexOf(q) !== -1;
        row.style.display = match ? '' : 'none';
        if (match) visible++;
    });
    var msg = document.getElementById('noTrMsg');
    if (msg) msg.style.display = visible === 0 ? 'block' : 'none';
}
</script>
