<div class="container-fluid px-0">
    <div class="d-flex align-items-center gap-2 mb-5">
        <a href="<?php echo base_url('admin/coupons'); ?>" class="btn btn-outline-dark btn-sm rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width:36px;height:36px;"><i data-lucide="arrow-left" style="width:16px;height:16px;"></i></a>
        <div><span class="text-primary fw-semibold small text-uppercase tracking-wide d-block mb-1">Promo</span><h1 class="display-6 fw-extrabold text-dark mb-0 lh-sm" style="letter-spacing:-0.03em;"><?php echo t('Buat Kupon', 'Create Coupon'); ?></h1></div>
    </div>
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="bento-card">
                <div class="section-glass">
                    <i data-lucide="ticket" style="width:18px;height:18px;color:var(--primary);"></i>
                    <span class="fw-semibold"><?php echo t('Detail Kupon', 'Coupon Details'); ?></span>
                </div>
                <?php echo form_open('admin/create_coupon'); ?>
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
                                    <select name="discount_type" class="form-control">
                                        <option value=""> </option>
                                        <option value="percent"><?php echo t('Persen (%)', 'Percent (%)'); ?></option>
                                        <option value="fixed"><?php echo t('Nominal (Rp)', 'Fixed (Rp)'); ?></option>
                                    </select>
                                    <label class="fl-label"><?php echo t('Tipe', 'Type'); ?></label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-float">
                                    <input type="number" name="discount_value" class="form-control" required min="1" placeholder=" ">
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
                    </div>
                    <div class="form-footer-sticky">
                        <a href="<?php echo base_url('admin/coupons'); ?>" class="btn btn-outline-secondary btn-sm rounded-pill px-4"><?php echo t('Batal', 'Cancel'); ?></a>
                        <button type="submit" class="btn btn-primary btn-sm rounded-pill px-4 d-flex align-items-center gap-1"><i data-lucide="save" style="width:16px;height:16px;"></i> <?php echo t('Simpan', 'Save'); ?></button>
                    </div>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
</div>
