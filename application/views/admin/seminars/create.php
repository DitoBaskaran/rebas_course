<div class="container-fluid px-0">

    <!-- ============ HEADER (hero) ============ -->
    <div class="bento-card mb-4 overflow-hidden" style="background:linear-gradient(120deg,#0D1830 0%,#164e63 100%);border:none;color:#fff;">
        <div class="position-relative" style="z-index:1;">
            <a href="<?php echo base_url('admin/seminars'); ?>" class="d-inline-flex align-items-center gap-1 text-decoration-none mb-2" style="color:rgba(255,255,255,0.72);font-size:0.76rem;font-weight:600;">
                <i data-lucide="arrow-left" style="width:13px;height:13px;"></i> <?php echo t('Kembali ke Seminar', 'Back to Seminars'); ?>
            </a>
            <span class="d-inline-flex align-items-center gap-1" style="background:rgba(255,255,255,0.14);border:1px solid rgba(255,255,255,0.2);color:#FBBF24;font-size:0.66rem;font-weight:800;letter-spacing:0.12em;text-transform:uppercase;padding:0.3rem 0.7rem;border-radius:100px;">
                <i data-lucide="calendar-plus" style="width:12px;height:12px;"></i>
                <?php echo t('Event Baru', 'New Event'); ?>
            </span>
            <h1 class="fw-extrabold text-white mb-0 mt-2 lh-sm" style="letter-spacing:-0.03em;font-size:1.5rem;">
                <?php echo t('Buat Seminar Baru', 'Create New Seminar'); ?>
            </h1>
        </div>
    </div>

    <?php if (validation_errors()): ?>
        <div class="alert alert-danger border-0 mb-3 py-2 px-3 small rounded-3"><?php echo validation_errors('', ''); ?></div>
    <?php endif; ?>

    <?php echo form_open_multipart('admin/create_seminar', array('class' => 'needs-validation', 'id' => 'seminarForm')); ?>

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
                        <input type="text" name="title" id="pv_title" class="form-control" value="<?php echo set_value('title'); ?>" required placeholder="<?php echo t('cth: Workshop Public Speaking', 'e.g: Public Speaking Workshop'); ?>" style="border-radius:12px;font-size:0.88rem;height:44px;">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold small"><?php echo t('Judul (English)', 'Title (English)'); ?></label>
                        <input type="text" name="title_en" class="form-control" value="<?php echo set_value('title_en'); ?>" placeholder="Title (EN)" style="border-radius:12px;font-size:0.88rem;height:44px;">
                    </div>
                </div>
            </div>

            <!-- Jadwal & Kuota -->
            <div class="bento-card">
                <h6 class="fw-bold text-dark mb-3 d-flex align-items-center gap-2" style="font-size:0.85rem;">
                    <i data-lucide="calendar-clock" style="width:16px;height:16px;color:#2563eb;"></i> <?php echo t('Jadwal & Kuota', 'Schedule & Quota'); ?>
                </h6>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold small"><?php echo t('Tanggal & Jam', 'Date & Time'); ?> *</label>
                        <input type="datetime-local" name="date_time" id="pv_date" class="form-control" value="<?php echo set_value('date_time'); ?>" required style="border-radius:12px;font-size:0.85rem;height:44px;">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold small"><?php echo t('Kuota Peserta', 'Participant Quota'); ?> *</label>
                        <input type="number" name="quota" id="pv_quota" class="form-control" value="<?php echo set_value('quota', '100'); ?>" required min="1" style="border-radius:12px;font-size:0.85rem;height:44px;">
                    </div>
                </div>
            </div>

            <!-- Harga & Bahasa -->
            <div class="bento-card">
                <h6 class="fw-bold text-dark mb-3 d-flex align-items-center gap-2" style="font-size:0.85rem;">
                    <i data-lucide="wallet" style="width:16px;height:16px;color:var(--warning);"></i> <?php echo t('Harga & Bahasa', 'Price & Language'); ?>
                </h6>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold small"><?php echo t('Harga (Rp)', 'Price (IDR)'); ?> *</label>
                        <div class="input-group">
                            <span class="input-group-text border-0" style="background:var(--gray-100,#f1f5f9);border-radius:12px 0 0 12px;font-size:0.8rem;font-weight:700;color:var(--gray-600,#57534e);">Rp</span>
                            <input type="number" name="price" id="pv_price" class="form-control" value="<?php echo set_value('price', '0'); ?>" required min="0" step="1000" placeholder="0" style="border-radius:0 12px 12px 0;font-size:0.88rem;height:44px;">
                        </div>
                        <small class="field-hint"><i class="fas fa-info-circle" style="font-size:0.7rem;"></i> <?php echo t('Isi 0 untuk seminar gratis.', 'Set 0 for a free seminar.'); ?></small>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold small"><?php echo t('Bahasa', 'Language'); ?></label>
                        <select name="language" class="form-select" style="border-radius:12px;font-size:0.85rem;height:44px;">
                            <option value="id" <?php echo set_select('language', 'id', true); ?>>Indonesia</option>
                            <option value="en" <?php echo set_select('language', 'en'); ?>>English</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Media & Link -->
            <div class="bento-card">
                <h6 class="fw-bold text-dark mb-3 d-flex align-items-center gap-2" style="font-size:0.85rem;">
                    <i data-lucide="video" style="width:16px;height:16px;color:#c026d3;"></i> <?php echo t('Media & Lokasi', 'Media & Location'); ?>
                </h6>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold small"><?php echo t('Tautan Zoom / Live', 'Zoom / Live Link'); ?></label>
                        <input type="url" name="location_link" class="form-control" value="<?php echo set_value('location_link'); ?>" placeholder="https://zoom.us/..." style="border-radius:12px;font-size:0.85rem;height:44px;">
                        <small class="field-hint"><?php echo t('Opsional — ditampilkan setelah pendaftaran.', 'Optional — shown after registration.'); ?></small>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold small"><?php echo t('Poster', 'Poster'); ?></label>
                        <input type="file" name="thumbnail" id="pv_thumb" class="form-control" accept="image/*" style="border-radius:12px;font-size:0.82rem;height:44px;">
                        <small class="field-hint"><?php echo t('Format: JPG, PNG. Maks: 2MB', 'Format: JPG, PNG. Max: 2MB'); ?></small>
                    </div>
                </div>
            </div>

            <!-- Deskripsi -->
            <div class="bento-card">
                <h6 class="fw-bold text-dark mb-3 d-flex align-items-center gap-2" style="font-size:0.85rem;">
                    <i data-lucide="file-text" style="width:16px;height:16px;color:#0D1830;"></i> <?php echo t('Deskripsi', 'Description'); ?>
                </h6>
                <div class="d-flex flex-column gap-3">
                    <div>
                        <label class="form-label fw-semibold small d-flex align-items-center justify-content-between">
                            <span><i class="fas fa-language me-1" style="color:var(--primary);font-size:0.72rem;"></i> <?php echo t('Deskripsi (Indonesia)', 'Description (Indonesian)'); ?> *</span>
                            <span class="text-muted fw-normal" style="font-size:0.66rem;"><?php echo t('Wajib', 'Required'); ?></span>
                        </label>
                        <textarea name="description" rows="5" class="form-control" required data-max-chars="2000" style="border-radius:12px;font-size:0.85rem;line-height:1.65;"><?php echo set_value('description'); ?></textarea>
                    </div>
                    <div style="border-top:1px dashed var(--gray-200,#e7e5e4);"></div>
                    <div>
                        <label class="form-label fw-semibold small">
                            <i class="fas fa-globe me-1" style="color:var(--gray-400);font-size:0.72rem;"></i> <?php echo t('Deskripsi (English)', 'Description (English)'); ?>
                            <span class="text-muted fw-normal">— <?php echo t('Opsional', 'Optional'); ?></span>
                        </label>
                        <textarea name="description_en" rows="4" class="form-control" data-max-chars="2000" style="border-radius:12px;font-size:0.85rem;line-height:1.65;"><?php echo set_value('description_en'); ?></textarea>
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
                <div class="seminar-card" style="border:1px solid var(--card-border,#e7e5e4);border-radius:16px;overflow:hidden;">
                    <div class="position-relative" style="aspect-ratio:16/9;background:linear-gradient(135deg,#0D1830,#164e63);overflow:hidden;">
                        <img id="pv_thumb_img" src="" alt="" style="width:100%;height:100%;object-fit:cover;display:none;">
                        <div class="w-100 h-100 d-flex align-items-center justify-content-center" id="pv_thumb_placeholder">
                            <i data-lucide="calendar" style="width:28px;height:28px;color:rgba(255,255,255,0.4);"></i>
                        </div>
                    </div>
                    <div class="px-3 py-3">
                        <div class="fw-bold text-dark" style="font-size:0.9rem;line-height:1.35;min-height:1.4em;" id="pv_title_out"><?php echo t('Judul seminar akan tampil di sini', 'Seminar title will appear here'); ?></div>
                        <div class="d-flex align-items-center justify-content-between mt-2">
                            <span class="text-secondary" style="font-size:0.72rem;" id="pv_date_out"><?php echo t('Belum ada jadwal', 'No schedule yet'); ?></span>
                            <span class="fw-extrabold" style="color:#0D1830;font-size:0.92rem;" id="pv_price_out"><?php echo t('Gratis', 'Free'); ?></span>
                        </div>
                    </div>
                </div>
                <p class="small text-muted mt-3 mb-0"><?php echo t('Pratinjau mengikuti input di form secara langsung.', 'Preview updates live from the form inputs.'); ?></p>
            </div>

            <div class="bento-card d-flex flex-column gap-2">
                <button type="submit" form="seminarForm" class="btn fw-semibold rounded-pill d-inline-flex align-items-center justify-content-center gap-2 border-0" style="background:#0D1830;color:#fff;font-size:0.8rem;padding:0.65rem;">
                    <i data-lucide="save" style="width:16px;height:16px;"></i> <?php echo t('Simpan Seminar', 'Save Seminar'); ?>
                </button>
                <a href="<?php echo base_url('admin/seminars'); ?>" class="btn fw-semibold rounded-pill d-inline-flex align-items-center justify-content-center gap-2 border-0" style="background:#E6EBEF;color:#57534e;font-size:0.8rem;padding:0.65rem;">
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
    function fmtRp(v) { return 'Rp ' + Number(v || 0).toLocaleString('id-ID'); }
    function upd() {
        var t = el('pv_title');
        el('pv_title_out').textContent = (t && t.value.trim()) ? t.value.trim() : '<?php echo t('Judul seminar akan tampil di sini', 'Seminar title will appear here'); ?>';
        var d = el('pv_date');
        var pr = parseFloat((el('pv_price') || {}).value || '0');
        el('pv_price_out').textContent = pr > 0 ? fmtRp(pr) : '<?php echo t('Gratis', 'Free'); ?>';
        el('pv_price_out').style.color = pr > 0 ? '#0D1830' : '#009688';
        if (d && d.value) {
            var dt = new Date(d.value);
            el('pv_date_out').textContent = dt.toLocaleDateString('id-ID', { day: 'numeric', month: 'short', year: 'numeric' }) + ' · ' + dt.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' });
        } else {
            el('pv_date_out').textContent = '<?php echo t('Belum ada jadwal', 'No schedule yet'); ?>';
        }
    }
    ['pv_title','pv_price','pv_date'].forEach(function(id) {
        var e = el(id);
        if (e) { e.addEventListener('input', upd); e.addEventListener('change', upd); }
    });
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
