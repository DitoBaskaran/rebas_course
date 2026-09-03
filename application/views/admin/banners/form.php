<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="container-fluid px-0">

    <!-- ============ HEADER (hero) ============ -->
    <div class="bento-card mb-4 overflow-hidden" style="background:linear-gradient(120deg,#0D1830 0%,#164e63 100%);border:none;color:#fff;">
        <div class="position-relative" style="z-index:1;">
            <a href="<?php echo base_url('admin/banners'); ?>" class="d-inline-flex align-items-center gap-1 text-decoration-none mb-2" style="color:rgba(255,255,255,0.72);font-size:0.76rem;font-weight:600;">
                <i data-lucide="arrow-left" style="width:13px;height:13px;"></i> <?php echo t('Kembali ke Banner', 'Back to Banners'); ?>
            </a>
            <span class="d-inline-flex align-items-center gap-1" style="background:rgba(255,255,255,0.14);border:1px solid rgba(255,255,255,0.2);color:#FBBF24;font-size:0.66rem;font-weight:800;letter-spacing:0.12em;text-transform:uppercase;padding:0.3rem 0.7rem;border-radius:100px;">
                <i data-lucide="image" style="width:12px;height:12px;"></i>
                <?php echo isset($banner) ? t('Edit', 'Edit') : t('Baru', 'New'); ?>
            </span>
            <h1 class="fw-extrabold text-white mb-0 mt-2 lh-sm" style="letter-spacing:-0.03em;font-size:1.5rem;">
                <?php echo isset($banner) ? t('Edit Banner', 'Edit Banner') : t('Tambah Banner', 'Add Banner'); ?>
            </h1>
        </div>
    </div>

    <?php echo form_open_multipart(isset($banner) ? 'admin/banners_edit/' . $banner->id : 'admin/banners_create', array('id' => 'bannerForm')); ?>

    <div class="bento-grid bento-grid-2-1 mb-4" style="align-items:start;">
        <!-- ============ LEFT: FORM ============ -->
        <div class="d-flex flex-column gap-3">

            <!-- Info -->
            <div class="bento-card">
                <h6 class="fw-bold text-dark mb-3 d-flex align-items-center gap-2" style="font-size:0.85rem;">
                    <i data-lucide="type" style="width:16px;height:16px;color:var(--primary);"></i> <?php echo t('Informasi Banner', 'Banner Information'); ?>
                </h6>
                <div class="row g-3">
                    <div class="col-12">
                        <label class="form-label fw-semibold small"><?php echo t('Judul Banner', 'Banner Title'); ?> *</label>
                        <input type="text" name="title" id="pv_title" class="form-control" value="<?php echo isset($banner) ? htmlspecialchars($banner->title) : ''; ?>" required placeholder="<?php echo t('cth: Diskon 50% Kelas Programming', 'e.g: 50% Off Programming Courses'); ?>" style="border-radius:12px;font-size:0.88rem;height:44px;">
                        <?php echo form_error('title', '<div class="text-danger small mt-1">', '</div>'); ?>
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-semibold small"><?php echo t('Tautan (opsional)', 'Link (optional)'); ?></label>
                        <input type="url" name="link" class="form-control" value="<?php echo isset($banner) ? htmlspecialchars($banner->link) : ''; ?>" placeholder="https://course.ditobaskaran.my.id/courses" style="border-radius:12px;font-size:0.85rem;height:44px;">
                        <small class="field-hint"><i class="fas fa-info-circle" style="font-size:0.7rem;"></i> <?php echo t('Banner akan mengarah ke tautan ini saat diklik.', 'Banner will navigate to this link when clicked.'); ?></small>
                    </div>
                </div>
            </div>

            <!-- Target & Status -->
            <div class="bento-card">
                <h6 class="fw-bold text-dark mb-3 d-flex align-items-center gap-2" style="font-size:0.85rem;">
                    <i data-lucide="target" style="width:16px;height:16px;color:#2563eb;"></i> <?php echo t('Target & Status', 'Target & Status'); ?>
                </h6>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold small"><?php echo t('Target Tampil', 'Display Target'); ?></label>
                        <select name="target" id="pv_target" class="form-select" style="border-radius:12px;font-size:0.85rem;height:44px;">
                            <option value="both" <?php echo isset($banner) && $banner->target === 'both' ? 'selected' : ''; ?>><?php echo t('Student & Mentor', 'Student & Mentor'); ?></option>
                            <option value="student" <?php echo isset($banner) && $banner->target === 'student' ? 'selected' : ''; ?>><?php echo t('Student Saja', 'Student Only'); ?></option>
                            <option value="mentor" <?php echo isset($banner) && $banner->target === 'mentor' ? 'selected' : ''; ?>><?php echo t('Mentor Saja', 'Mentor Only'); ?></option>
                        </select>
                    </div>
                    <div class="col-md-6 d-flex align-items-end">
                        <label class="toggle-switch">
                            <input type="checkbox" name="is_active" value="1" id="isActive" <?php echo !isset($banner) || $banner->is_active ? 'checked' : ''; ?>>
                            <span class="track"></span>
                            <span class="toggle-label"><?php echo t('Tampilkan Banner Ini', 'Show This Banner'); ?></span>
                        </label>
                    </div>
                </div>
            </div>

            <!-- Gambar -->
            <div class="bento-card">
                <h6 class="fw-bold text-dark mb-3 d-flex align-items-center gap-2" style="font-size:0.85rem;">
                    <i data-lucide="image" style="width:16px;height:16px;color:#c026d3;"></i> <?php echo t('Gambar Banner', 'Banner Image'); ?>
                </h6>
                <input type="file" name="image" id="pv_thumb" class="form-control" accept="image/*" style="border-radius:12px;font-size:0.82rem;height:44px;">
                <small class="field-hint d-block mt-2"><i class="fas fa-info-circle" style="font-size:0.7rem;"></i> <?php echo t('Rekomendasi: 1200×400px (rasio 3:1), JPG/WebP, maks 500KB. Teks penting di tengah.', 'Recommended: 1200x400px (3:1 ratio), JPG/WebP, max 500KB. Keep text centered.'); ?></small>
                <?php if (isset($banner) && $banner->image): ?>
                    <small class="field-hint d-block mt-1"><?php echo t('Kosongkan jika tidak ingin mengganti gambar.', 'Leave empty to keep current image.'); ?></small>
                <?php endif; ?>
            </div>
        </div>

        <!-- ============ RIGHT: PREVIEW + ACTION ============ -->
        <div class="d-flex flex-column gap-3" style="position:sticky;top:1rem;">
            <div class="bento-card">
                <h6 class="fw-bold text-dark mb-3 d-flex align-items-center gap-2" style="font-size:0.8rem;">
                    <i data-lucide="eye" style="width:15px;height:15px;color:var(--gray-400,#94a3b8);"></i> <?php echo t('Pratinjau Banner', 'Banner Preview'); ?>
                </h6>
                <div class="position-relative" style="aspect-ratio:3/1;border-radius:14px;overflow:hidden;background:linear-gradient(120deg,#0D1830,#164e63);border:1px solid var(--card-border,#e7e5e4);">
                    <img id="pv_thumb_img" src="<?php echo (isset($banner) && $banner->image && file_exists(FCPATH . 'uploads/banners/' . $banner->image)) ? base_url('uploads/banners/' . $banner->image) : ''; ?>" alt="" style="width:100%;height:100%;object-fit:cover;<?php echo (isset($banner) && $banner->image) ? '' : 'display:none;'; ?>">
                    <div class="w-100 h-100 d-flex align-items-center justify-content-center" id="pv_thumb_placeholder" style="<?php echo (isset($banner) && $banner->image) ? 'display:none;' : ''; ?>">
                        <i data-lucide="image" style="width:26px;height:26px;color:rgba(255,255,255,0.35);"></i>
                    </div>
                    <div class="position-absolute d-flex align-items-end p-3" style="inset:0;background:linear-gradient(to top, rgba(0,0,0,0.55), transparent 60%);">
                        <span class="fw-bold text-white text-truncate" id="pv_title_out" style="font-size:0.9rem;"><?php echo isset($banner) ? htmlspecialchars($banner->title) : t('Judul banner akan tampil di sini', 'Banner title will appear here'); ?></span>
                    </div>
                    <span class="position-absolute px-2 py-1 rounded-pill fw-semibold" id="pv_target_out" style="top:0.5rem;left:0.5rem;background:#E0F2F1;color:#009688;font-size:0.6rem;"><?php echo t('Student & Mentor', 'Student & Mentor'); ?></span>
                </div>
                <p class="small text-muted mt-3 mb-0"><?php echo t('Rasio 3:1 sesuai carousel dashboard.', 'Ratio matches the dashboard carousel.'); ?></p>
            </div>

            <div class="bento-card d-flex flex-column gap-2">
                <button type="submit" form="bannerForm" class="btn fw-semibold rounded-pill d-inline-flex align-items-center justify-content-center gap-2 border-0" style="background:#0D1830;color:#fff;font-size:0.8rem;padding:0.65rem;">
                    <i data-lucide="save" style="width:16px;height:16px;"></i> <?php echo t('Simpan Banner', 'Save Banner'); ?>
                </button>
                <a href="<?php echo base_url('admin/banners'); ?>" class="btn fw-semibold rounded-pill d-inline-flex align-items-center justify-content-center gap-2 border-0" style="background:#E6EBEF;color:#57534e;font-size:0.8rem;padding:0.65rem;">
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
    function upd() {
        var t = el('pv_title');
        el('pv_title_out').textContent = (t && t.value.trim()) ? t.value.trim() : '<?php echo t('Judul banner akan tampil di sini', 'Banner title will appear here'); ?>';
        var target = el('pv_target');
        var labels = { both: '<?php echo t('Student & Mentor', 'Student & Mentor'); ?>', student: '<?php echo t('Student', 'Student'); ?>', mentor: '<?php echo t('Mentor', 'Mentor'); ?>' };
        el('pv_target_out').textContent = labels[target.value] || labels.both;
    }
    el('pv_title').addEventListener('input', upd);
    el('pv_target').addEventListener('change', upd);
    var file = el('pv_thumb');
    if (file) file.addEventListener('change', function() {
        var img = el('pv_thumb_img'), ph = el('pv_thumb_placeholder');
        if (file.files && file.files[0]) {
            var r = new FileReader();
            r.onload = function(e2) { img.src = e2.target.result; img.style.display = ''; ph.style.display = 'none'; };
            r.readAsDataURL(file.files[0]);
        }
    });
    upd();
});
</script>
