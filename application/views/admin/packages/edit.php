<div class="container-fluid px-0">

    <!-- ============ HEADER (hero) ============ -->
    <div class="bento-card mb-4 overflow-hidden" style="background:linear-gradient(120deg,#0D1830 0%,#164e63 100%);border:none;color:#fff;">
        <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3 position-relative" style="z-index:1;">
            <div>
                <a href="<?php echo base_url('admin/packages'); ?>" class="d-inline-flex align-items-center gap-1 text-decoration-none mb-2" style="color:rgba(255,255,255,0.72);font-size:0.76rem;font-weight:600;">
                    <i data-lucide="arrow-left" style="width:13px;height:13px;"></i> <?php echo t('Kembali ke Paket', 'Back to Packages'); ?>
                </a>
                <span class="d-inline-flex align-items-center gap-1" style="background:rgba(255,255,255,0.14);border:1px solid rgba(255,255,255,0.2);color:#FBBF24;font-size:0.66rem;font-weight:800;letter-spacing:0.12em;text-transform:uppercase;padding:0.3rem 0.7rem;border-radius:100px;">
                    <i data-lucide="pencil" style="width:12px;height:12px;"></i>
                    <?php echo t('Edit Paket', 'Edit Package'); ?>
                </span>
                <h1 class="fw-extrabold text-white mb-0 mt-2 lh-sm" style="letter-spacing:-0.03em;font-size:1.5rem;">
                    <?php echo htmlspecialchars($package->name); ?>
                </h1>
            </div>
            <div class="d-flex align-items-baseline gap-1 flex-shrink-0">
                <span class="fw-extrabold text-white" style="font-size:1.6rem;letter-spacing:-0.02em;">Rp <?php echo number_format($package->price, 0, ',', '.'); ?></span>
                <span style="color:rgba(255,255,255,0.6);font-size:0.75rem;">/ <?php echo $package->duration_days; ?> <?php echo t('hari', 'days'); ?></span>
            </div>
        </div>
    </div>

    <?php echo form_open('admin/packages/edit/' . $package->id); ?>

    <div class="bento-grid bento-grid-2-1 mb-4" style="align-items:start;">
        <!-- LEFT: form sections -->
        <div class="d-flex flex-column gap-3">

            <!-- Informasi Dasar -->
            <div class="bento-card">
                <h6 class="fw-bold text-dark mb-3 d-flex align-items-center gap-2" style="font-size:0.85rem;">
                    <i data-lucide="tag" style="width:16px;height:16px;color:var(--primary);"></i> <?php echo t('Informasi Dasar', 'Basic Information'); ?>
                </h6>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold small"><?php echo t('Nama (ID)', 'Name (ID)'); ?> *</label>
                        <input type="text" name="name" class="form-control" required value="<?php echo set_value('name', $package->name); ?>">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold small"><?php echo t('Nama (EN)', 'Name (EN)'); ?></label>
                        <input type="text" name="name_en" class="form-control" value="<?php echo set_value('name_en', $package->name_en); ?>">
                    </div>
                </div>
            </div>

            <!-- Harga & Durasi -->
            <div class="bento-card">
                <h6 class="fw-bold text-dark mb-3 d-flex align-items-center gap-2" style="font-size:0.85rem;">
                    <i data-lucide="wallet" style="width:16px;height:16px;color:var(--warning);"></i> <?php echo t('Harga & Durasi', 'Price & Duration'); ?>
                </h6>
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label fw-semibold small"><?php echo t('Harga (Rp)', 'Price (IDR)'); ?> *</label>
                        <input type="number" name="price" class="form-control" required min="0" step="1000" value="<?php echo set_value('price', $package->price); ?>">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold small"><?php echo t('Durasi (hari)', 'Duration (days)'); ?> *</label>
                        <input type="number" name="duration_days" class="form-control" required min="1" value="<?php echo set_value('duration_days', $package->duration_days); ?>">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold small"><?php echo t('Diskon 6 Bulan (%)', '6mo Discount (%)'); ?></label>
                        <input type="number" name="discount_6mo" class="form-control" min="0" max="100" step="0.01" value="<?php echo set_value('discount_6mo', $package->discount_6mo); ?>">
                    </div>
                    <div class="col-12">
                        <small class="text-muted"><i data-lucide="info" style="width:12px;height:12px;" class="me-1"></i><?php echo t('Persen diskon otomatis untuk langganan 6 bulan sekaligus.', 'Automatic discount percentage for 6-month subscriptions.'); ?></small>
                    </div>
                </div>
            </div>

            <!-- Cakupan Akses -->
            <div class="bento-card">
                <h6 class="fw-bold text-dark mb-3 d-flex align-items-center gap-2" style="font-size:0.85rem;">
                    <i data-lucide="shield-check" style="width:16px;height:16px;color:#2563eb;"></i> <?php echo t('Cakupan Akses & Status', 'Access Scope & Status'); ?>
                </h6>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold small"><?php echo t('Cakupan Akses', 'Access Scope'); ?></label>
                        <select name="access_scope" class="form-select" id="access_scope_select">
                            <option value="all" <?php echo set_select('access_scope', 'all', $package->access_scope === 'all'); ?>><?php echo t('Semua Konten', 'All Content'); ?></option>
                            <option value="category" <?php echo set_select('access_scope', 'category', $package->access_scope === 'category'); ?>><?php echo t('Per Kategori', 'By Category'); ?></option>
                            <option value="course" <?php echo set_select('access_scope', 'course', $package->access_scope === 'course'); ?>><?php echo t('Per Kursus', 'By Course'); ?></option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold small"><?php echo t('Status', 'Status'); ?></label>
                        <select name="is_active" class="form-select">
                            <option value="1" <?php echo set_select('is_active', '1', $package->is_active === '1'); ?>><?php echo t('Aktif', 'Active'); ?></option>
                            <option value="0" <?php echo set_select('is_active', '0', $package->is_active === '0'); ?>><?php echo t('Nonaktif', 'Inactive'); ?></option>
                        </select>
                    </div>
                    <div class="col-12" id="categories_group" style="display:<?php echo $package->access_scope === 'category' ? 'block' : 'none'; ?>;">
                        <label class="form-label fw-semibold small"><?php echo t('Pilih Kategori', 'Select Categories'); ?></label>
                        <div class="perm-chip-picker">
                            <?php
                            $current_category_ids = array_column(array_filter($existing_items, function($item){ return $item->item_type === 'category'; }), 'item_id');
                            if (!empty($categories)): foreach ($categories as $cat):
                                $on = in_array($cat->id, $current_category_ids);
                            ?>
                            <label class="chip-check <?php echo $on ? 'chip-check-active' : ''; ?>">
                                <input type="checkbox" name="categories[]" value="<?php echo $cat->id; ?>" <?php echo $on ? 'checked' : ''; ?>>
                                <span><?php echo htmlspecialchars($cat->name); ?></span>
                            </label>
                            <?php endforeach; endif; ?>
                        </div>
                    </div>
                    <div class="col-12" id="courses_group" style="display:<?php echo $package->access_scope === 'course' ? 'block' : 'none'; ?>;">
                        <label class="form-label fw-semibold small"><?php echo t('Pilih Kursus', 'Select Courses'); ?></label>
                        <div class="perm-chip-picker">
                            <?php
                            $current_course_ids = array_column(array_filter($existing_items, function($item){ return $item->item_type === 'course'; }), 'item_id');
                            if (!empty($courses)): foreach ($courses as $crs):
                                $on = in_array($crs->id, $current_course_ids);
                            ?>
                            <label class="chip-check <?php echo $on ? 'chip-check-active' : ''; ?>">
                                <input type="checkbox" name="courses[]" value="<?php echo $crs->id; ?>" <?php echo $on ? 'checked' : ''; ?>>
                                <span><?php echo htmlspecialchars($crs->title); ?></span>
                            </label>
                            <?php endforeach; endif; ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Deskripsi -->
            <div class="bento-card">
                <h6 class="fw-bold text-dark mb-3 d-flex align-items-center gap-2" style="font-size:0.85rem;">
                    <i data-lucide="file-text" style="width:16px;height:16px;color:#c026d3;"></i> <?php echo t('Deskripsi', 'Description'); ?>
                </h6>
                <div class="row g-3">
                    <div class="col-12">
                        <label class="form-label fw-semibold small"><?php echo t('Deskripsi (ID)', 'Description (ID)'); ?></label>
                        <textarea name="description" class="form-control tinymce" rows="4"><?php echo set_value('description', $package->description); ?></textarea>
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-semibold small"><?php echo t('Deskripsi (EN)', 'Description (EN)'); ?></label>
                        <textarea name="description_en" class="form-control tinymce" rows="4"><?php echo set_value('description_en', $package->description_en); ?></textarea>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-semibold small"><?php echo t('Urutan', 'Sort Order'); ?></label>
                        <input type="number" name="sort_order" class="form-control" value="<?php echo set_value('sort_order', $package->sort_order); ?>">
                    </div>
                </div>
            </div>
        </div>

        <!-- RIGHT: live preview + actions -->
        <div class="d-flex flex-column gap-3" style="position:sticky;top:1rem;">
            <div class="bento-card">
                <h6 class="fw-bold text-dark mb-3 d-flex align-items-center gap-2" style="font-size:0.8rem;">
                    <i data-lucide="eye" style="width:15px;height:15px;color:var(--gray-400,#94a3b8);"></i> <?php echo t('Pratinjau Kartu', 'Card Preview'); ?>
                </h6>
                <div class="package-card" style="border:1px solid var(--card-border,#e7e5e4);border-radius:16px;overflow:hidden;">
                    <div style="height:5px;background:#009688;"></div>
                    <div class="px-3 pt-3">
                        <span class="d-inline-flex align-items-center justify-content-center rounded-3" style="width:40px;height:40px;background:#E0F2F1;color:#009688;">
                            <i data-lucide="layers" style="width:19px;height:19px;"></i>
                        </span>
                    </div>
                    <div class="px-3 mt-2">
                        <div class="fw-extrabold text-dark" style="font-size:0.95rem;"><?php echo htmlspecialchars($package->name); ?></div>
                        <div class="fw-extrabold" style="color:#009688;font-size:1.3rem;">Rp <?php echo number_format($package->price, 0, ',', '.'); ?></div>
                        <div class="text-secondary" style="font-size:0.7rem;margin-bottom:0.9rem;"><?php echo $package->duration_days; ?> <?php echo t('hari', 'days'); ?></div>
                    </div>
                </div>
                <p class="small text-muted mt-3 mb-0"><?php echo t('Simpan perubahan untuk memperbarui tampilan sebenarnya di halaman Paket.', 'Save changes to update the actual view on the Packages page.'); ?></p>
            </div>

            <div class="bento-card d-flex flex-column gap-2">
                <button type="submit" class="btn fw-semibold rounded-pill d-inline-flex align-items-center justify-content-center gap-2 border-0" style="background:#0D1830;color:#fff;font-size:0.8rem;padding:0.65rem;">
                    <i data-lucide="check" style="width:16px;height:16px;"></i> <?php echo t('Simpan Perubahan', 'Save Changes'); ?>
                </button>
                <a href="<?php echo base_url('admin/packages'); ?>" class="btn fw-semibold rounded-pill d-inline-flex align-items-center justify-content-center gap-2 border-0" style="background:#E6EBEF;color:#57534e;font-size:0.8rem;padding:0.65rem;">
                    <?php echo t('Batal', 'Cancel'); ?>
                </a>
            </div>
        </div>
    </div>
    <?php echo form_close(); ?>
</div>
<script>
document.getElementById('access_scope_select').addEventListener('change', function(){
    document.getElementById('categories_group').style.display = this.value === 'category' ? 'block' : 'none';
    document.getElementById('courses_group').style.display = this.value === 'course' ? 'block' : 'none';
});
</script>
