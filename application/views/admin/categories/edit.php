<div class="container-fluid px-0">
    <div class="d-flex align-items-center gap-2 mb-5">
        <a href="<?php echo base_url('admin/categories'); ?>" class="btn btn-outline-dark btn-sm rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width: 36px; height: 36px;">
            <i data-lucide="arrow-left" style="width:16px;height:16px;"></i>
        </a>
        <div>
            <span class="text-primary fw-semibold small text-uppercase tracking-wide d-block mb-1">Konten</span>
            <h1 class="display-6 fw-extrabold text-dark mb-0 lh-sm" style="letter-spacing: -0.03em;"><?php echo t('Edit Kategori', 'Edit Category'); ?></h1>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="bento-card">
                <div class="section-glass">
                    <i data-lucide="folder-edit" style="width:18px;height:18px;color:var(--primary);"></i>
                    <span class="fw-semibold"><?php echo t('Informasi Kategori', 'Category Information'); ?></span>
                </div>
                <?php echo form_open('admin/update_category/' . $category->id, array('class' => 'needs-validation')); ?>
                    <div class="d-flex flex-column gap-4 p-4 p-xl-5">
                        <div class="row g-4">
                            <div class="col-md-6">
                                <div class="form-float">
                                    <input type="text" name="name" class="form-control" value="<?php echo htmlspecialchars($category->name); ?>" required placeholder=" ">
                                    <label class="fl-label"><?php echo t('Nama (ID)', 'Name (ID)'); ?> *</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-float">
                                    <input type="text" name="name_en" class="form-control" value="<?php echo htmlspecialchars($category->name_en); ?>" placeholder=" ">
                                    <label class="fl-label"><?php echo t('Nama (EN)', 'Name (EN)'); ?></label>
                                </div>
                            </div>
                        </div>
                        <div class="row g-4">
                            <div class="col-md-6">
                                <div class="form-float">
                                    <select name="parent_id" class="form-control">
                                        <option value=""> </option>
                                        <?php foreach ($categories as $cat): ?>
                                            <option value="<?php echo $cat->id; ?>" <?php echo ($cat->id == $category->parent_id) ? 'selected' : ''; ?>><?php echo htmlspecialchars($cat->name); ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <label class="fl-label"><?php echo t('Parent Kategori', 'Parent Category'); ?></label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-float">
                                    <input type="text" name="icon" class="form-control" value="<?php echo htmlspecialchars($category->icon); ?>" placeholder=" ">
                                    <label class="fl-label"><?php echo t('Icon (emoji)', 'Icon (emoji)'); ?></label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-float">
                                    <input type="number" name="sort_order" class="form-control" value="<?php echo $category->sort_order; ?>" placeholder=" ">
                                    <label class="fl-label"><?php echo t('Urutan', 'Sort Order'); ?></label>
                                </div>
                            </div>
                        </div>
                        <div>
                            <div class="form-float">
                                <textarea name="description" rows="2" class="form-control" placeholder=" "><?php echo htmlspecialchars($category->description); ?></textarea>
                                <label class="fl-label"><?php echo t('Deskripsi (ID)', 'Description (ID)'); ?></label>
                            </div>
                        </div>
                        <div>
                            <div class="form-float">
                                <textarea name="description_en" rows="2" class="form-control" placeholder=" "><?php echo htmlspecialchars($category->description_en); ?></textarea>
                                <label class="fl-label"><?php echo t('Deskripsi (EN)', 'Description (EN)'); ?></label>
                            </div>
                        </div>
                    </div>
                    <div class="form-footer-sticky">
                        <a href="<?php echo base_url('admin/categories'); ?>" class="btn btn-outline-secondary btn-sm rounded-pill px-4"><?php echo t('Batal', 'Cancel'); ?></a>
                        <button type="submit" class="btn btn-primary btn-sm rounded-pill px-4 d-flex align-items-center gap-1">
                            <i data-lucide="save" style="width:16px;height:16px;"></i> <?php echo t('Simpan', 'Save'); ?>
                        </button>
                    </div>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
</div>
