<div class="container-fluid px-0">
    <div class="d-flex align-items-center gap-2 mb-5">
        <a href="<?php echo base_url('admin/learning_paths'); ?>" class="btn btn-outline-dark btn-sm rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width: 36px; height: 36px;">
            <i data-lucide="arrow-left" style="width:16px;height:16px;"></i>
        </a>
        <div>
            <span class="text-primary fw-semibold small text-uppercase tracking-wide d-block mb-1">Jalur Belajar</span>
            <h1 class="display-6 fw-extrabold text-dark mb-0 lh-sm" style="letter-spacing: -0.03em;"><?php echo t('Buat Learning Path', 'Create Learning Path'); ?></h1>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="bento-card animate-scale-in overflow-hidden">
                <div class="d-flex align-items-center gap-2 px-4 px-xl-5 py-3 section-glass">
                    <i data-lucide="route" style="width:18px;height:18px;"></i>
                    <span class="fw-semibold"><?php echo t('Informasi Jalur Belajar', 'Learning Path Information'); ?></span>
                </div>
                <?php echo form_open('admin/create_learning_path', array('class' => 'needs-validation')); ?>
                    <div class="card-body d-flex flex-column gap-4 p-4 p-xl-5">
                        <div class="row g-4">
                            <div class="col-md-6">
                                <div class="form-float">
                                    <input type="text" name="title" class="form-control" required placeholder=" ">
                                    <label class="fl-label"><?php echo t('Judul (ID)', 'Title (ID)'); ?></label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-float">
                                    <input type="text" name="title_en" class="form-control" placeholder=" ">
                                    <label class="fl-label"><?php echo t('Judul (EN)', 'Title (EN)'); ?></label>
                                </div>
                            </div>
                        </div>
                        <div class="row g-4">
                            <div class="col-md-6">
                                <div class="form-float">
                                    <select name="category_id" class="form-select">
                                        <option value=""> </option>
                                        <?php foreach ($categories as $cat): ?>
                                            <option value="<?php echo $cat->id; ?>"><?php echo htmlspecialchars($cat->name); ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <label class="fl-label"><?php echo t('Kategori', 'Category'); ?></label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-float">
                                    <select name="skill_level" class="form-select">
                                        <option value=""> </option>
                                        <option value="all_levels"><?php echo t('Semua', 'All'); ?></option>
                                        <option value="beginner"><?php echo t('Pemula', 'Beginner'); ?></option>
                                        <option value="intermediate"><?php echo t('Menengah', 'Intermediate'); ?></option>
                                        <option value="advanced"><?php echo t('Mahir', 'Advanced'); ?></option>
                                    </select>
                                    <label class="fl-label"><?php echo t('Level', 'Level'); ?></label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-float">
                                    <input type="number" name="estimated_hours" class="form-control" placeholder=" ">
                                    <label class="fl-label"><?php echo t('Estimasi (jam)', 'Est. Hours'); ?></label>
                                </div>
                            </div>
                        </div>
                        <div class="row g-4">
                            <div class="col-md-6">
                                <div class="form-float">
                                    <textarea name="description" rows="3" class="form-control" placeholder=" " data-max-chars="1000"><?php echo set_value('description'); ?></textarea>
                                    <label class="fl-label"><?php echo t('Deskripsi (ID)', 'Description (ID)'); ?></label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-float">
                                    <textarea name="description_en" rows="3" class="form-control" placeholder=" " data-max-chars="1000"><?php echo set_value('description_en'); ?></textarea>
                                    <label class="fl-label"><?php echo t('Deskripsi (EN)', 'Description (EN)'); ?></label>
                                </div>
                            </div>
                        </div>
                        <div>
                            <label class="fl-label d-block mb-1 fw-semibold"><?php echo t('Warna', 'Color'); ?></label>
                            <div class="color-picker-wrapper">
                                <input type="color" name="color" id="colorPicker" value="#4361ee" style="width:44px;height:44px;">
                                <div class="form-float flex-grow-1">
                                    <input type="text" name="color_text" class="form-control form-control-sm" value="#4361ee" placeholder=" ">
                                    <label class="fl-label">#hex</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end gap-2 px-4 px-xl-5 py-3 form-footer-sticky">
                        <a href="<?php echo base_url('admin/learning_paths'); ?>" class="btn btn-outline-secondary btn-sm rounded-pill px-4"><?php echo t('Batal', 'Cancel'); ?></a>
                        <button type="submit" class="btn btn-primary btn-sm rounded-pill px-4 d-flex align-items-center gap-1">
                            <i data-lucide="save" style="width:16px;height:16px;"></i> <?php echo t('Simpan', 'Save'); ?>
                        </button>
                    </div>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
</div>
