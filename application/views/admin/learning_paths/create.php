<div class="container-fluid px-0">

    <!-- ============ HEADER (hero) ============ -->
    <div class="bento-card mb-4 overflow-hidden" style="background:linear-gradient(120deg,#0D1830 0%,#164e63 100%);border:none;color:#fff;">
        <div class="position-relative" style="z-index:1;">
            <a href="<?php echo base_url('admin/learning_paths'); ?>" class="d-inline-flex align-items-center gap-1 text-decoration-none mb-2" style="color:rgba(255,255,255,0.72);font-size:0.76rem;font-weight:600;">
                <i data-lucide="arrow-left" style="width:13px;height:13px;"></i> <?php echo t('Kembali ke Learning Paths', 'Back to Learning Paths'); ?>
            </a>
            <span class="d-inline-flex align-items-center gap-1" style="background:rgba(255,255,255,0.14);border:1px solid rgba(255,255,255,0.2);color:#FBBF24;font-size:0.66rem;font-weight:800;letter-spacing:0.12em;text-transform:uppercase;padding:0.3rem 0.7rem;border-radius:100px;">
                <i data-lucide="route" style="width:12px;height:12px;"></i>
                <?php echo t('Jalur Baru', 'New Path'); ?>
            </span>
            <h1 class="fw-extrabold text-white mb-0 mt-2 lh-sm" style="letter-spacing:-0.03em;font-size:1.5rem;">
                <?php echo t('Buat Learning Path', 'Create Learning Path'); ?>
            </h1>
        </div>
    </div>

    <?php echo form_open('admin/create_learning_path', array('class' => 'needs-validation', 'id' => 'pathForm')); ?>

    <div class="bento-grid bento-grid-2-1 mb-4" style="align-items:start;">
        <!-- ============ LEFT: FORM ============ -->
        <div class="d-flex flex-column gap-3">

            <!-- Judul -->
            <div class="bento-card">
                <h6 class="fw-bold text-dark mb-3 d-flex align-items-center gap-2" style="font-size:0.85rem;">
                    <i data-lucide="type" style="width:16px;height:16px;color:var(--primary);"></i> <?php echo t('Judul', 'Title'); ?>
                </h6>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold small"><?php echo t('Judul (Indonesia)', 'Title (Indonesian)'); ?> *</label>
                        <input type="text" name="title" id="pv_title" class="form-control" required placeholder="<?php echo t('cth: Jago Flutter dari Nol', 'e.g: Master Flutter from Zero'); ?>" style="border-radius:12px;font-size:0.88rem;height:44px;">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold small"><?php echo t('Judul (English)', 'Title (English)'); ?></label>
                        <input type="text" name="title_en" class="form-control" style="border-radius:12px;font-size:0.88rem;height:44px;">
                    </div>
                </div>
            </div>

            <!-- Klasifikasi -->
            <div class="bento-card">
                <h6 class="fw-bold text-dark mb-3 d-flex align-items-center gap-2" style="font-size:0.85rem;">
                    <i data-lucide="folder-tree" style="width:16px;height:16px;color:#2563eb;"></i> <?php echo t('Klasifikasi', 'Classification'); ?>
                </h6>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold small"><?php echo t('Kategori', 'Category'); ?></label>
                        <select name="category_id" class="form-select" style="border-radius:12px;font-size:0.85rem;height:44px;">
                            <option value=""><?php echo t('— Tanpa kategori —', '— No category —'); ?></option>
                            <?php foreach ($categories as $cat): ?>
                                <option value="<?php echo $cat->id; ?>"><?php echo htmlspecialchars($cat->name); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-semibold small"><?php echo t('Level', 'Level'); ?></label>
                        <select name="skill_level" id="pv_level" class="form-select" style="border-radius:12px;font-size:0.85rem;height:44px;">
                            <option value="all_levels"><?php echo t('Semua', 'All'); ?></option>
                            <option value="beginner"><?php echo t('Pemula', 'Beginner'); ?></option>
                            <option value="intermediate"><?php echo t('Menengah', 'Intermediate'); ?></option>
                            <option value="advanced"><?php echo t('Mahir', 'Advanced'); ?></option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-semibold small"><?php echo t('Estimasi (jam)', 'Est. Hours'); ?></label>
                        <input type="number" name="estimated_hours" class="form-control" min="0" placeholder="0" style="border-radius:12px;font-size:0.85rem;height:44px;">
                    </div>
                </div>
            </div>

            <!-- Warna aksen -->
            <div class="bento-card">
                <h6 class="fw-bold text-dark mb-3 d-flex align-items-center gap-2" style="font-size:0.85rem;">
                    <i data-lucide="palette" style="width:16px;height:16px;color:#c026d3;"></i> <?php echo t('Warna Aksen', 'Accent Color'); ?>
                </h6>
                <div class="row g-3 align-items-center">
                    <div class="col-auto">
                        <input type="color" name="color" id="colorPicker" value="#4361ee" class="form-control form-control-color" style="width:52px;height:44px;border-radius:10px;padding:3px;">
                    </div>
                    <div class="col">
                        <label class="form-label fw-semibold small mb-1"><?php echo t('Kode Hex', 'Hex Code'); ?></label>
                        <input type="text" name="color_text" id="colorText" class="form-control" value="#4361ee" maxlength="7" style="border-radius:12px;font-size:0.85rem;height:44px;font-family:monospace;text-transform:uppercase;">
                    </div>
                    <div class="col-12">
                        <div class="d-flex gap-1 flex-wrap">
                            <?php foreach (['#4361ee','#009688','#ea580c','#c026d3','#16a34a','#dc2626','#0D1830','#7c3aed'] as $preset): ?>
                            <button type="button" class="color-preset" data-color="<?php echo $preset; ?>" style="width:24px;height:24px;border-radius:50%;border:2px solid #fff;background:<?php echo $preset; ?>;box-shadow:0 0 0 1px var(--gray-200,#e7e5e4);cursor:pointer;" title="<?php echo $preset; ?>"></button>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Deskripsi -->
            <div class="bento-card">
                <h6 class="fw-bold text-dark mb-3 d-flex align-items-center gap-2" style="font-size:0.85rem;">
                    <i data-lucide="file-text" style="width:16px;height:16px;color:#0D1830;"></i> <?php echo t('Deskripsi', 'Description'); ?>
                </h6>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold small"><?php echo t('Deskripsi (Indonesia)', 'Description (Indonesian)'); ?></label>
                        <textarea name="description" rows="4" class="form-control" data-max-chars="1000" style="border-radius:12px;font-size:0.85rem;line-height:1.6;"><?php echo set_value('description'); ?></textarea>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold small"><?php echo t('Deskripsi (English)', 'Description (English)'); ?></label>
                        <textarea name="description_en" rows="4" class="form-control" data-max-chars="1000" style="border-radius:12px;font-size:0.85rem;line-height:1.6;"><?php echo set_value('description_en'); ?></textarea>
                    </div>
                </div>
            </div>
        </div>

        <!-- ============ RIGHT: PREVIEW + ACTION ============ -->
        <div class="d-flex flex-column gap-3" style="position:sticky;top:1rem;">
            <div class="bento-card">
                <h6 class="fw-bold text-dark mb-3 d-flex align-items-center gap-2" style="font-size:0.8rem;">
                    <i data-lucide="eye" style="width:15px;height:15px;color:var(--gray-400,#94a3b8);"></i> <?php echo t('Pratinjau Kartu', 'Card Preview'); ?>
                </h6>
                <div class="path-card" style="border:1px solid var(--card-border,#e7e5e4);border-radius:16px;overflow:hidden;">
                    <div id="pv_colorbar" style="height:6px;background:#4361ee;"></div>
                    <div class="px-3 py-3">
                        <span class="d-inline-flex align-items-center justify-content-center rounded-3" id="pv_iconbox" style="width:40px;height:40px;background:#4361ee1a;color:#4361ee;">
                            <i data-lucide="route" style="width:20px;height:20px;"></i>
                        </span>
                        <div class="fw-bold text-dark mt-2" style="font-size:0.92rem;line-height:1.35;" id="pv_title_out"><?php echo t('Judul path akan tampil di sini', 'Path title will appear here'); ?></div>
                        <div class="d-flex flex-wrap gap-1 mt-2">
                            <span class="px-2 py-1 rounded-pill fw-semibold" style="background:#eff6ff;color:#2563eb;font-size:0.62rem;" id="pv_level_out"><?php echo t('Level', 'Level'); ?></span>
                        </div>
                    </div>
                </div>
                <p class="small text-muted mt-3 mb-0"><?php echo t('Warna aksen & judul tampil real-time di preview.', 'Accent color & title update live in preview.'); ?></p>
            </div>

            <div class="bento-card d-flex flex-column gap-2">
                <button type="submit" form="pathForm" class="btn fw-semibold rounded-pill d-inline-flex align-items-center justify-content-center gap-2 border-0" style="background:#0D1830;color:#fff;font-size:0.8rem;padding:0.65rem;">
                    <i data-lucide="save" style="width:16px;height:16px;"></i> <?php echo t('Simpan Path', 'Save Path'); ?>
                </button>
                <a href="<?php echo base_url('admin/learning_paths'); ?>" class="btn fw-semibold rounded-pill d-inline-flex align-items-center justify-content-center gap-2 border-0" style="background:#E6EBEF;color:#57534e;font-size:0.8rem;padding:0.65rem;">
                    <?php echo t('Batal', 'Cancel'); ?>
                </a>
            </div>
        </div>
    </div>
    <?php echo form_close(); ?>
</div>
<script>
document.addEventListener('DOMContentLoaded', function() {
    function el(id) { return document.getElementById(id); }
    function shade(hex, alpha) {
        var r = parseInt(hex.slice(1,3),16), g = parseInt(hex.slice(3,5),16), b = parseInt(hex.slice(5,7),16);
        return 'rgba(' + r + ',' + g + ',' + b + ',' + alpha + ')';
    }
    function upd() {
        var t = el('pv_title');
        el('pv_title_out').textContent = (t && t.value.trim()) ? t.value.trim() : '<?php echo t('Judul path akan tampil di sini', 'Path title will appear here'); ?>';
        var lvl = el('pv_level');
        if (lvl && lvl.options) {
            for (var i=0;i<lvl.options.length;i++) if (lvl.options[i].value===lvl.value) el('pv_level_out').textContent = lvl.options[i].text;
        }
    }
    function updColor(c) {
        el('pv_colorbar').style.background = c;
        el('pv_iconbox').style.background = shade(c, 0.12);
        el('pv_iconbox').style.color = c;
    }
    el('pv_title').addEventListener('input', upd);
    el('pv_level').addEventListener('change', upd);
    var cp = el('colorPicker'), ct = el('colorText');
    cp.addEventListener('input', function() { ct.value = cp.value; updColor(cp.value); });
    ct.addEventListener('input', function() {
        var v = ct.value.trim();
        if (/^#[0-9a-fA-F]{6}$/.test(v)) { cp.value = v; updColor(v); }
    });
    document.querySelectorAll('.color-preset').forEach(function(btn) {
        btn.addEventListener('click', function() {
            var c = btn.getAttribute('data-color');
            cp.value = c; ct.value = c; updColor(c);
        });
    });
    upd();
});
</script>
