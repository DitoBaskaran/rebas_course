<div class="container-fluid px-0">

    <!-- ============ HEADER (hero) ============ -->
    <div class="bento-card mb-4 overflow-hidden" style="background:linear-gradient(120deg,#0D1830 0%,#164e63 100%);border:none;color:#fff;">
        <div class="position-relative" style="z-index:1;">
            <a href="<?php echo base_url('admin/courses'); ?>" class="d-inline-flex align-items-center gap-1 text-decoration-none mb-2" style="color:rgba(255,255,255,0.72);font-size:0.76rem;font-weight:600;">
                <i data-lucide="arrow-left" style="width:13px;height:13px;"></i> <?php echo t('Kembali ke Konten', 'Back to Content'); ?>
            </a>
            <span class="d-inline-flex align-items-center gap-1" style="background:rgba(255,255,255,0.14);border:1px solid rgba(255,255,255,0.2);color:#FBBF24;font-size:0.66rem;font-weight:800;letter-spacing:0.12em;text-transform:uppercase;padding:0.3rem 0.7rem;border-radius:100px;">
                <i data-lucide="plus" style="width:12px;height:12px;"></i>
                <?php echo t('Konten Baru', 'New Content'); ?>
            </span>
            <h1 class="fw-extrabold text-white mb-0 mt-2 lh-sm" style="letter-spacing:-0.03em;font-size:1.5rem;">
                <?php echo t('Buat Konten Baru', 'Create New Content'); ?>
            </h1>
        </div>
    </div>

    <?php if (validation_errors()): ?>
        <div class="alert alert-danger border-0 mb-3 py-2 px-3 small rounded-3"><?php echo validation_errors('', ''); ?></div>
    <?php endif; ?>

    <?php echo form_open_multipart('admin/create_course', array('class' => 'needs-validation', 'id' => 'courseForm')); ?>

    <div class="bento-grid bento-grid-2-1 mb-4" style="align-items:start;">
        <!-- ============ LEFT: FORM ============ -->
        <div class="d-flex flex-column gap-3">

            <!-- Informasi dasar -->
            <div class="bento-card">
                <h6 class="fw-bold text-dark mb-3 d-flex align-items-center gap-2" style="font-size:0.85rem;">
                    <i data-lucide="type" style="width:16px;height:16px;color:var(--primary);"></i> <?php echo t('Judul', 'Title'); ?>
                </h6>
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="form-float">
                            <input type="text" name="title" id="pv_title" class="form-control" value="<?php echo set_value('title'); ?>" required placeholder=" ">
                            <label class="fl-label"><?php echo t('Judul (ID)', 'Title (ID)'); ?> *</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-float">
                            <input type="text" name="title_en" class="form-control" value="<?php echo set_value('title_en'); ?>" placeholder=" ">
                            <label class="fl-label"><?php echo t('Judul (EN)', 'Title (EN)'); ?></label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Klasifikasi -->
            <div class="bento-card">
                <h6 class="fw-bold text-dark mb-3 d-flex align-items-center gap-2" style="font-size:0.85rem;">
                    <i data-lucide="folder-tree" style="width:16px;height:16px;color:#2563eb;"></i> <?php echo t('Klasifikasi', 'Classification'); ?>
                </h6>
                <div class="row g-3">
                    <div class="col-md-4">
                        <div class="form-float">
                            <select name="content_type" id="pv_type" class="form-select" required>
                                <option value=""> </option>
                                <?php foreach (['course','workshop','bootcamp','ebook','project','article','video','podcast','template'] as $ct): ?>
                                    <option value="<?php echo $ct; ?>"><?php echo content_type_label($ct); ?></option>
                                <?php endforeach; ?>
                            </select>
                            <label class="fl-label"><?php echo t('Tipe Konten', 'Content Type'); ?> *</label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-float">
                            <select name="category_id" class="form-select" required>
                                <option value=""> </option>
                                <?php foreach ($categories as $cat): ?>
                                    <option value="<?php echo $cat->id; ?>"><?php echo htmlspecialchars($cat->name); ?></option>
                                <?php endforeach; ?>
                            </select>
                            <label class="fl-label"><?php echo t('Kategori', 'Category'); ?> *</label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-float">
                            <select name="skill_level" id="pv_level" class="form-select" required>
                                <option value=""> </option>
                                <option value="all_levels"><?php echo t('Semua Level', 'All Levels'); ?></option>
                                <option value="beginner"><?php echo t('Pemula', 'Beginner'); ?></option>
                                <option value="intermediate"><?php echo t('Menengah', 'Intermediate'); ?></option>
                                <option value="advanced"><?php echo t('Mahir', 'Advanced'); ?></option>
                            </select>
                            <label class="fl-label"><?php echo t('Level Skill', 'Skill Level'); ?> *</label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Harga & detail -->
            <div class="bento-card">
                <h6 class="fw-bold text-dark mb-3 d-flex align-items-center gap-2" style="font-size:0.85rem;">
                    <i data-lucide="wallet" style="width:16px;height:16px;color:var(--warning);"></i> <?php echo t('Harga & Detail', 'Price & Details'); ?>
                </h6>
                <div class="row g-3">
                    <div class="col-md-4">
                        <div class="form-float">
                            <div class="input-icon-wrap">
                                <span class="input-icon-left">Rp</span>
                                <input type="number" name="price" id="pv_price" class="form-control" value="<?php echo set_value('price', '0'); ?>" min="0" placeholder=" ">
                            </div>
                            <label class="fl-label"><?php echo t('Harga (Rp)', 'Price (Rp)'); ?> *</label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-float">
                            <input type="number" name="duration_total" class="form-control" value="0" min="0" placeholder=" ">
                            <label class="fl-label"><?php echo t('Durasi (menit)', 'Duration (min)'); ?></label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-float">
                            <select name="language" class="form-select">
                                <option value=""> </option>
                                <option value="id">Indonesia</option>
                                <option value="en">English</option>
                            </select>
                            <label class="fl-label"><?php echo t('Bahasa', 'Language'); ?></label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Media & status -->
            <div class="bento-card">
                <h6 class="fw-bold text-dark mb-3 d-flex align-items-center gap-2" style="font-size:0.85rem;">
                    <i data-lucide="image" style="width:16px;height:16px;color:#c026d3;"></i> <?php echo t('Cover & Unggulan', 'Cover & Featured'); ?>
                </h6>
                <div class="row g-3">
                    <div class="col-md-8">
                        <label class="form-label fw-semibold small"><?php echo t('Cover Image', 'Cover Image'); ?></label>
                        <input type="file" name="thumbnail" class="form-control" id="pv_thumb" accept="image/*">
                        <small class="field-hint"><?php echo t('Format: JPG, PNG. Maks: 2MB', 'Format: JPG, PNG. Max: 2MB'); ?></small>
                    </div>
                    <div class="col-md-4 d-flex align-items-end pb-2">
                        <label class="toggle-switch">
                            <input type="checkbox" name="featured" value="1" id="featuredCheck">
                            <span class="track"></span>
                            <span class="toggle-label"><?php echo t('Tandai sebagai Unggulan', 'Mark as Featured'); ?></span>
                        </label>
                    </div>
                </div>
            </div>

            <!-- Deskripsi -->
            <div class="bento-card">
                <h6 class="fw-bold text-dark mb-3 d-flex align-items-center gap-2" style="font-size:0.85rem;">
                    <i data-lucide="file-text" style="width:16px;height:16px;color:#0D1830;"></i> <?php echo t('Deskripsi', 'Description'); ?>
                </h6>
                <div class="d-flex flex-column gap-3">
                    <div class="form-float">
                        <textarea name="description" rows="5" class="form-control tinymce" required data-max-chars="500"><?php echo set_value('description'); ?></textarea>
                        <label class="fl-label"><?php echo t('Deskripsi (ID)', 'Description (ID)'); ?> *</label>
                    </div>
                    <div class="form-float">
                        <textarea name="description_en" rows="5" class="form-control tinymce" data-max-chars="500"><?php echo set_value('description_en'); ?></textarea>
                        <label class="fl-label"><?php echo t('Deskripsi (EN)', 'Description (EN)'); ?></label>
                    </div>
                    <div>
                        <div class="form-float">
                            <select name="tags[]" class="form-select select-multiple-tags" multiple>
                                <?php foreach ($tags as $tag): ?>
                                    <option value="<?php echo $tag->id; ?>"><?php echo htmlspecialchars($tag->name); ?></option>
                                <?php endforeach; ?>
                            </select>
                            <label class="fl-label"><?php echo t('Tags', 'Tags'); ?></label>
                        </div>
                        <small class="field-hint"><?php echo t('Tahan Ctrl untuk memilih banyak', 'Hold Ctrl to select multiple'); ?></small>
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
                <div class="course-card" style="border:1px solid var(--card-border,#e7e5e4);border-radius:16px;overflow:hidden;">
                    <div class="position-relative" style="aspect-ratio:16/9;background:linear-gradient(135deg,#0D1830,#164e63);overflow:hidden;">
                        <img id="pv_thumb_img" src="" alt="" style="width:100%;height:100%;object-fit:cover;display:none;">
                        <div class="w-100 h-100 d-flex align-items-center justify-content-center" id="pv_thumb_placeholder">
                            <i data-lucide="book-open" style="width:28px;height:28px;color:rgba(255,255,255,0.4);"></i>
                        </div>
                    </div>
                    <div class="px-3 py-3">
                        <div class="fw-bold text-dark" style="font-size:0.9rem;line-height:1.35;" id="pv_title_out"><?php echo t('Judul konten akan tampil di sini', 'Course title will appear here'); ?></div>
                        <div class="d-flex flex-wrap gap-1 mt-2">
                            <span class="px-2 py-1 rounded-pill fw-semibold" style="background:#E6EBEF;color:#57534e;font-size:0.62rem;" id="pv_type_out"><?php echo t('Tipe', 'Type'); ?></span>
                            <span class="px-2 py-1 rounded-pill fw-semibold" style="background:#eff6ff;color:#2563eb;font-size:0.62rem;" id="pv_level_out"><?php echo t('Level', 'Level'); ?></span>
                        </div>
                        <div class="d-flex align-items-center justify-content-between mt-2">
                            <span class="fw-extrabold" style="color:#0D1830;font-size:0.95rem;" id="pv_price_out"><?php echo t('Gratis', 'Free'); ?></span>
                            <span class="d-inline-flex align-items-center gap-1" style="color:#FBBF24;font-size:0.7rem;" id="pv_featured_out"><i data-lucide="star" style="width:12px;height:12px;"></i></span>
                        </div>
                    </div>
                </div>
                <p class="small text-muted mt-3 mb-0"><?php echo t('Pratinjau mengikuti input di form secara langsung.', 'Preview updates live from the form inputs.'); ?></p>
            </div>

            <div class="bento-card d-flex flex-column gap-2">
                <button type="submit" form="courseForm" class="btn fw-semibold rounded-pill d-inline-flex align-items-center justify-content-center gap-2 border-0" style="background:#0D1830;color:#fff;font-size:0.8rem;padding:0.65rem;">
                    <i data-lucide="save" style="width:16px;height:16px;"></i> <?php echo t('Simpan Konten', 'Save Content'); ?>
                </button>
                <a href="<?php echo base_url('admin/courses'); ?>" class="btn fw-semibold rounded-pill d-inline-flex align-items-center justify-content-center gap-2 border-0" style="background:#E6EBEF;color:#57534e;font-size:0.8rem;padding:0.65rem;">
                    <?php echo t('Batal', 'Cancel'); ?>
                </a>
            </div>
        </div>
    </div>
    <?php echo form_close(); ?>
</div>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var el = function(id) { return document.getElementById(id); };
    function labelFor(value, map) {
        var s = el(value);
        if (!s || !s.options) return '';
        for (var i = 0; i < s.options.length; i++) {
            if (s.options[i].value === s.value) return s.options[i].text;
        }
        return '';
    }
    function upd() {
        var t = el('pv_title');
        el('pv_title_out').textContent = (t && t.value.trim()) ? t.value.trim() : '<?php echo t('Judul konten akan tampil di sini', 'Course title will appear here'); ?>';
        var type = el('pv_type');
        el('pv_type_out').textContent = type && type.value ? labelFor('pv_type') : '<?php echo t('Tipe', 'Type'); ?>';
        var lvl = el('pv_level');
        el('pv_level_out').textContent = lvl && lvl.value ? labelFor('pv_level') : '<?php echo t('Level', 'Level'); ?>';
        var pr = parseFloat((el('pv_price') || {}).value || '0');
        el('pv_price_out').textContent = pr > 0 ? 'Rp ' + pr.toLocaleString('id-ID') : '<?php echo t('Gratis', 'Free'); ?>';
        el('pv_price_out').style.color = pr > 0 ? '#0D1830' : '#009688';
        el('pv_featured_out').style.visibility = el('featuredCheck').checked ? 'visible' : 'hidden';
    }
    ['pv_title','pv_type','pv_level','pv_price'].forEach(function(id) {
        var e = el(id);
        if (e) e.addEventListener('input', upd);
        if (e) e.addEventListener('change', upd);
    });
    el('featuredCheck').addEventListener('change', upd);
    // Preview thumbnail
    var file = el('pv_thumb');
    if (file) file.addEventListener('change', function() {
        var img = el('pv_thumb_img'), ph = el('pv_thumb_placeholder');
        if (file.files && file.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e2) { img.src = e2.target.result; img.style.display = ''; ph.style.display = 'none'; };
            reader.readAsDataURL(file.files[0]);
        }
    });
    upd();
});
</script>
