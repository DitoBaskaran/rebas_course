<div class="container-fluid px-0">
    <div class="mb-5">
        <a href="<?php echo base_url('admin/minute_bundles'); ?>" class="text-decoration-none small text-success d-flex align-items-center gap-1 mb-2"><i data-lucide="arrow-left" style="width:14px;height:14px;"></i> <?php echo t('Kembali', 'Back'); ?></a>
        <h1 class="display-6 fw-extrabold text-dark mb-1 lh-sm"><?php echo t('Buat Bundel Baru', 'Create New Bundle'); ?></h1>
        <p class="text-secondary">Bundel menit sebagai alternatif dari paket langganan.</p>
    </div>
    <div class="bento-card p-4 p-xl-5">
        <form method="POST" action="<?php echo base_url('admin/minute_bundles/create'); ?>">
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-semibold"><?php echo t('Nama (ID)', 'Name (ID)'); ?> *</label>
                    <input type="text" name="name" class="form-control" required value="<?php echo set_value('name'); ?>">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold"><?php echo t('Nama (EN)', 'Name (EN)'); ?></label>
                    <input type="text" name="name_en" class="form-control" value="<?php echo set_value('name_en'); ?>">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold"><?php echo t('Menit', 'Minutes'); ?> *</label>
                    <input type="number" name="minutes" class="form-control" required min="1" value="<?php echo set_value('minutes', '30'); ?>">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold"><?php echo t('Harga (Rp)', 'Price (IDR)'); ?> *</label>
                    <input type="number" name="price" class="form-control" required min="0" step="1000" value="<?php echo set_value('price', '0'); ?>">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold"><?php echo t('Status', 'Status'); ?></label>
                    <select name="is_active" class="form-select">
                        <option value="1" <?php echo set_select('is_active', '1'); ?>><?php echo t('Aktif', 'Active'); ?></option>
                        <option value="0" <?php echo set_select('is_active', '0'); ?>><?php echo t('Nonaktif', 'Inactive'); ?></option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold"><?php echo t('Urutan', 'Sort Order'); ?></label>
                    <input type="number" name="sort_order" class="form-control" value="<?php echo set_value('sort_order', '0'); ?>">
                </div>
                <div class="col-12">
                    <hr class="my-3">
                    <small class="text-muted">* Sekali dibeli, menit akan ditambahkan ke saldo user_minute_balances.balance_seconds.</small>
                </div>
            </div>
            <div class="mt-4">
                <button type="submit" class="btn btn-success px-4 rounded-pill"><i data-lucide="check" style="width:16px;height:16px;" class="me-1"></i><?php echo t('Simpan Bundel', 'Save Bundle'); ?></button>
            </div>
        </form>
    </div>
</div>