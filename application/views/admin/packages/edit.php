<div class="container-fluid px-0">
    <div class="mb-5">
        <a href="<?php echo base_url('admin/packages'); ?>" class="text-decoration-none small text-primary d-flex align-items-center gap-1 mb-2"><i data-lucide="arrow-left" style="width:14px;height:14px;"></i> <?php echo t('Kembali', 'Back'); ?></a>
        <h1 class="display-6 fw-extrabold text-dark mb-1 lh-sm"><?php echo t('Edit Paket: ', 'Edit Package: '); ?><?php echo htmlspecialchars($package->name); ?></h1>
    </div>
    <div class="bento-card p-4 p-xl-5">
        <?php echo form_open('admin/packages/edit/' . $package->id); ?>
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-semibold"><?php echo t('Nama (ID)', 'Name (ID)'); ?> *</label>
                    <input type="text" name="name" class="form-control" required value="<?php echo set_value('name', $package->name); ?>">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold"><?php echo t('Nama (EN)', 'Name (EN)'); ?></label>
                    <input type="text" name="name_en" class="form-control" value="<?php echo set_value('name_en', $package->name_en); ?>">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold"><?php echo t('Harga (Rp)', 'Price (IDR)'); ?> *</label>
                    <input type="number" name="price" class="form-control" required min="0" step="1000" value="<?php echo set_value('price', $package->price); ?>">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold"><?php echo t('Durasi (hari)', 'Duration (days)'); ?> *</label>
                    <input type="number" name="duration_days" class="form-control" required min="1" value="<?php echo set_value('duration_days', $package->duration_days); ?>">
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold"><?php echo t('Diskon 6 Bulan (%)', '6 Month Discount (%)'); ?></label>
                    <input type="number" name="discount_6mo" class="form-control" min="0" max="100" step="0.01" value="<?php echo set_value('discount_6mo', $package->discount_6mo); ?>">
                    <small class="text-muted"><?php echo t('Persen diskon untuk langganan 6 bulan', 'Discount percentage for 6-month subscription'); ?></small>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold"><?php echo t('Cakupan Akses', 'Access Scope'); ?></label>
                    <select name="access_scope" class="form-select" id="access_scope_select">
                        <option value="all" <?php echo set_select('access_scope', 'all', $package->access_scope === 'all'); ?>><?php echo t('Semua Konten', 'All Content'); ?></option>
                        <option value="category" <?php echo set_select('access_scope', 'category', $package->access_scope === 'category'); ?>><?php echo t('Per Kategori', 'By Category'); ?></option>
                        <option value="course" <?php echo set_select('access_scope', 'course', $package->access_scope === 'course'); ?>><?php echo t('Per Kursus', 'By Course'); ?></option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold"><?php echo t('Status', 'Status'); ?></label>
                    <select name="is_active" class="form-select">
                        <option value="1" <?php echo set_select('is_active', '1', $package->is_active === '1'); ?>><?php echo t('Aktif', 'Active'); ?></option>
                        <option value="0" <?php echo set_select('is_active', '0', $package->is_active === '0'); ?>><?php echo t('Nonaktif', 'Inactive'); ?></option>
                    </select>
                </div>
                <div class="col-12" id="categories_group" style="display:<?php echo $package->access_scope === 'category' ? 'block' : 'none'; ?>;">
                    <label class="form-label fw-semibold"><?php echo t('Pilih Kategori', 'Select Categories'); ?></label>
                    <div class="row">
                        <?php 
                        $current_category_ids = array_column(array_filter($existing_items, function($item){ return $item->item_type === 'category'; }), 'item_id');
                        if (!empty($categories)): foreach ($categories as $cat): 
                        ?>
                        <div class="col-md-4 mb-2">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="categories[]" value="<?php echo $cat->id; ?>" id="cat_<?php echo $cat->id; ?>" <?php echo in_array($cat->id, $current_category_ids) ? 'checked' : ''; ?>>
                                <label class="form-check-label" for="cat_<?php echo $cat->id; ?>"><?php echo htmlspecialchars($cat->name); ?></label>
                            </div>
                        </div>
                        <?php endforeach; endif; ?>
                    </div>
                </div>
                <div class="col-12" id="courses_group" style="display:<?php echo $package->access_scope === 'course' ? 'block' : 'none'; ?>;">
                    <label class="form-label fw-semibold"><?php echo t('Pilih Kursus', 'Select Courses'); ?></label>
                    <div class="row">
                        <?php 
                        $current_course_ids = array_column(array_filter($existing_items, function($item){ return $item->item_type === 'course'; }), 'item_id');
                        if (!empty($courses)): foreach ($courses as $crs): 
                        ?>
                        <div class="col-md-4 mb-2">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="courses[]" value="<?php echo $crs->id; ?>" id="crs_<?php echo $crs->id; ?>" <?php echo in_array($crs->id, $current_course_ids) ? 'checked' : ''; ?>>
                                <label class="form-check-label" for="crs_<?php echo $crs->id; ?>"><?php echo htmlspecialchars($crs->title); ?></label>
                            </div>
                        </div>
                        <?php endforeach; endif; ?>
                    </div>
                </div>
                <div class="col-12">
                    <label class="form-label fw-semibold"><?php echo t('Deskripsi (ID)', 'Description (ID)'); ?></label>
                    <textarea name="description" class="form-control tinymce" rows="4"><?php echo set_value('description', $package->description); ?></textarea>
                </div>
                <div class="col-12">
                    <label class="form-label fw-semibold"><?php echo t('Deskripsi (EN)', 'Description (EN)'); ?></label>
                    <textarea name="description_en" class="form-control tinymce" rows="4"><?php echo set_value('description_en', $package->description_en); ?></textarea>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold"><?php echo t('Urutan', 'Sort Order'); ?></label>
                    <input type="number" name="sort_order" class="form-control" value="<?php echo set_value('sort_order', $package->sort_order); ?>">
                </div>
            </div>
            <div class="mt-4">
                <button type="submit" class="btn btn-dark px-4 rounded-pill"><i data-lucide="check" style="width:16px;height:16px;" class="me-1"></i><?php echo t('Simpan Perubahan', 'Save Changes'); ?></button>
            </div>
        </form>
    </div>
</div>
<script>
document.getElementById('access_scope_select').addEventListener('change', function(){
    document.getElementById('categories_group').style.display = this.value === 'category' ? 'block' : 'none';
    document.getElementById('courses_group').style.display = this.value === 'course' ? 'block' : 'none';
});
</script>