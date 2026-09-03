<div class="container-fluid px-0">

    <!-- ============ HEADER (hero) ============ -->
    <div class="bento-card mb-4 overflow-hidden" style="background:linear-gradient(120deg,#0D1830 0%,#164e63 100%);border:none;color:#fff;">
        <div class="position-relative" style="z-index:1;">
            <a href="<?php echo base_url('admin/coupons'); ?>" class="d-inline-flex align-items-center gap-1 text-decoration-none mb-2" style="color:rgba(255,255,255,0.72);font-size:0.76rem;font-weight:600;">
                <i data-lucide="arrow-left" style="width:13px;height:13px;"></i> <?php echo t('Kembali ke Kupon', 'Back to Coupons'); ?>
            </a>
            <span class="d-inline-flex align-items-center gap-1" style="background:rgba(255,255,255,0.14);border:1px solid rgba(255,255,255,0.2);color:#FBBF24;font-size:0.66rem;font-weight:800;letter-spacing:0.12em;text-transform:uppercase;padding:0.3rem 0.7rem;border-radius:100px;">
                <i data-lucide="ticket" style="width:12px;height:12px;"></i>
                <?php echo t('Promo', 'Promo'); ?>
            </span>
            <h1 class="fw-extrabold text-white mb-0 mt-2 lh-sm" style="letter-spacing:-0.03em;font-size:1.5rem;">
                <?php echo t('Buat Kupon', 'Create Coupon'); ?>
            </h1>
        </div>
    </div>

    <div class="bento-grid bento-grid-2-1 mb-4" style="align-items:start;">

        <!-- LEFT: form -->
        <div class="bento-card p-0">
            <div class="d-flex align-items-center gap-2 px-4 py-3" style="border-bottom:1px solid var(--card-border,#eef0f3);">
                <i data-lucide="ticket" style="width:17px;height:17px;color:var(--primary);"></i>
                <span class="fw-bold text-dark" style="font-size:0.88rem;"><?php echo t('Detail Kupon', 'Coupon Details'); ?></span>
            </div>
            <?php echo form_open_multipart('admin/create_coupon', array('id' => 'couponForm')); ?>
                <div class="d-flex flex-column gap-4 p-4 p-xl-5">
                    <div class="row g-4">
                        <div class="col-md-4">
                            <div class="form-float">
                                <input type="text" name="code" class="form-control text-uppercase" required placeholder=" ">
                                <label class="fl-label"><?php echo t('Kode', 'Code'); ?> *</label>
                            </div>
                            <small class="field-hint"><?php echo t('Kode akan otomatis diubah ke huruf kapital', 'Code will be auto-capitalized'); ?></small>
                        </div>
                        <div class="col-md-4">
                            <div class="form-float">
                                <select name="discount_type" id="discount_type" class="form-control" required>
                                    <option value=""> </option>
                                    <option value="percent"><?php echo t('Persen (%)', 'Percent (%)'); ?></option>
                                    <option value="fixed"><?php echo t('Nominal (Rp)', 'Fixed (Rp)'); ?></option>
                                </select>
                                <label class="fl-label"><?php echo t('Tipe', 'Type'); ?></label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-float">
                                <input type="number" name="discount_value" id="discount_value" class="form-control" required min="1" placeholder=" ">
                                <label class="fl-label"><?php echo t('Nilai', 'Value'); ?> *</label>
                            </div>
                        </div>
                    </div>
                    <div class="row g-4">
                        <div class="col-md-4">
                            <div class="form-float">
                                <input type="number" name="min_purchase" class="form-control" value="0" min="0" placeholder=" ">
                                <label class="fl-label"><?php echo t('Min. Belanja (Rp)', 'Min. Purchase (Rp)'); ?></label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-float">
                                <input type="number" name="max_uses" class="form-control" placeholder=" ">
                                <label class="fl-label"><?php echo t('Maks Pemakaian', 'Max Uses'); ?></label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-float">
                                <input type="datetime-local" name="expired_at" class="form-control" placeholder=" ">
                                <label class="fl-label"><?php echo t('Berlaku Hingga', 'Valid Until'); ?></label>
                            </div>
                        </div>
                    </div>
                    <div class="row g-4">
                        <div class="col-12">
                            <label class="fw-semibold mb-2 d-block" style="color:#0D1830;font-size:0.82rem;"><?php echo t('Gambar Kupon (opsional)', 'Coupon Image (optional)'); ?></label>
                            <div class="d-flex align-items-center gap-3">
                                <div id="couponImgPreview" style="width:72px;height:72px;border-radius:12px;border:2px dashed #e7e5e4;display:flex;align-items:center;justify-content:center;overflow:hidden;background:var(--gray-100,#f5f5f5);flex-shrink:0;">
                                    <i class="fas fa-ticket-alt" style="color:#d6d3d1;font-size:1.3rem;"></i>
                                </div>
                                <div>
                                    <input type="file" name="image" class="form-control form-control-sm" accept="image/*" id="couponImage" style="font-size:0.82rem;">
                                    <small style="color:#a8a29e;font-size:0.7rem;"><?php echo t('JPG/PNG/WebP, maks 2MB. Tampil sebagai thumbnail di list.', 'JPG/PNG/WebP, max 2MB. Shows as thumbnail in list.'); ?></small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php echo form_close(); ?>
        </div>

        <!-- RIGHT: ringkasan + aksi -->
        <div class="d-flex flex-column gap-3" style="position:sticky;top:1rem;">
            <div class="bento-card">
                <h6 class="fw-bold text-dark mb-3 d-flex align-items-center gap-2" style="font-size:0.8rem;">
                    <i data-lucide="eye" style="width:15px;height:15px;color:var(--gray-400,#94a3b8);"></i> <?php echo t('Ringkasan', 'Summary'); ?>
                </h6>
                <div class="coupon-demo mb-3">
                    <div class="coupon-demo-left">
                        <div class="coupon-demo-code" id="demo_code">KODE</div>
                        <div class="coupon-demo-meta" id="demo_meta">—</div>
                    </div>
                    <div class="coupon-demo-right" id="demo_value">0%</div>
                </div>
                <ul class="list-unstyled small mb-0 d-flex flex-column gap-1" style="color:#78716c;">
                    <li><i data-lucide="shopping-bag" style="width:12px;height:12px;" class="me-1"></i><span id="demo_min">Min. belanja: Rp 0</span></li>
                    <li><i data-lucide="repeat" style="width:12px;height:12px;" class="me-1"></i><span id="demo_uses">Pemakaian: tanpa batas</span></li>
                    <li><i data-lucide="clock" style="width:12px;height:12px;" class="me-1"></i><span id="demo_exp">Berlaku hingga: —</span></li>
                </ul>
            </div>
            <div class="bento-card d-flex flex-column gap-2">
                <button type="submit" form="couponForm" class="btn fw-semibold rounded-pill d-inline-flex align-items-center justify-content-center gap-2 border-0" style="background:#0D1830;color:#fff;font-size:0.8rem;padding:0.65rem;">
                    <i data-lucide="save" style="width:16px;height:16px;"></i> <?php echo t('Simpan Kupon', 'Save Coupon'); ?>
                </button>
                <a href="<?php echo base_url('admin/coupons'); ?>" class="btn fw-semibold rounded-pill d-inline-flex align-items-center justify-content-center gap-2 border-0" style="background:#E6EBEF;color:#57534e;font-size:0.8rem;padding:0.65rem;">
                    <?php echo t('Batal', 'Cancel'); ?>
                </a>
            </div>
        </div>
    </div>
</div>
<script>
// Live summary
document.addEventListener('DOMContentLoaded', function() {
    function fmtRp(v) {
        return 'Rp ' + Number(v || 0).toLocaleString('id-ID');
    }
    function upd() {
        var code = (document.querySelector('[name="code"]').value || 'KODE').toUpperCase();
        var type = document.querySelector('[name="discount_type"]').value;
        var val = parseFloat(document.querySelector('[name="discount_value"]').value || '0');
        var min = parseFloat(document.querySelector('[name="min_purchase"]').value || '0');
        var uses = document.querySelector('[name="max_uses"]').value;
        var exp = document.querySelector('[name="expired_at"]').value;
        document.getElementById('demo_code').textContent = code;
        document.getElementById('demo_value').textContent = type === 'percent' ? val + '%' : fmtRp(val);
        document.getElementById('demo_meta').textContent = type === 'percent' ? 'diskon' : (type === 'fixed' ? 'potongan' : '—');
        document.getElementById('demo_min').textContent = 'Min. belanja: ' + fmtRp(min);
        document.getElementById('demo_uses').textContent = uses ? ('Pemakaian: ' + uses + 'x') : 'Pemakaian: tanpa batas';
        document.getElementById('demo_exp').textContent = exp ? ('Berlaku hingga: ' + new Date(exp).toLocaleDateString('id-ID')) : 'Berlaku hingga: —';
    }
    ['code','discount_type','discount_value','min_purchase','max_uses','expired_at'].forEach(function(n) {
        var el = document.querySelector('[name="' + n + '"]');
        if (el) el.addEventListener('input', upd);
    });
    upd();
});
</script>
