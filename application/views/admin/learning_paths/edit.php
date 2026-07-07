<div class="container-fluid px-0">
    <div class="d-flex align-items-center gap-2 mb-5">
        <a href="<?php echo base_url('admin/learning_paths'); ?>" class="btn btn-outline-dark btn-sm rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width: 36px; height: 36px;">
            <i data-lucide="arrow-left" style="width:16px;height:16px;"></i>
        </a>
        <div>
            <span class="text-primary fw-semibold small text-uppercase tracking-wide d-block mb-1">Jalur Belajar</span>
            <h1 class="display-6 fw-extrabold text-dark mb-0 lh-sm" style="letter-spacing: -0.03em;"><?php echo t('Edit Learning Path', 'Edit Learning Path'); ?></h1>
        </div>
    </div>
    <div class="row g-4">
        <div class="col-lg-8">
            <div class="bento-card animate-scale-in overflow-hidden">
                <div class="d-flex align-items-center gap-2 px-4 px-xl-5 py-3 section-glass">
                    <i data-lucide="route" style="width:18px;height:18px;"></i>
                    <span class="fw-semibold"><?php echo t('Informasi Jalur Belajar', 'Learning Path Information'); ?></span>
                </div>
                <?php echo form_open('admin/edit_learning_path/' . $path->id, array('class' => 'needs-validation')); ?>
                    <div class="card-body d-flex flex-column gap-4 p-4 p-xl-5">
                        <div class="row g-4">
                            <div class="col-md-6">
                                <div class="form-float">
                                    <input type="text" name="title" class="form-control" value="<?php echo set_value('title', $path->title); ?>" required placeholder=" ">
                                    <label class="fl-label"><?php echo t('Judul (ID)', 'Title (ID)'); ?></label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-float">
                                    <input type="text" name="title_en" class="form-control" value="<?php echo set_value('title_en', $path->title_en); ?>" placeholder=" ">
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
                                            <option value="<?php echo $cat->id; ?>" <?php echo $path->category_id == $cat->id ? 'selected' : ''; ?>><?php echo htmlspecialchars($cat->name); ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <label class="fl-label"><?php echo t('Kategori', 'Category'); ?></label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-float">
                                    <select name="skill_level" class="form-select">
                                        <option value=""> </option>
                                        <option value="all_levels" <?php echo $path->skill_level === 'all_levels' ? 'selected' : ''; ?>><?php echo t('Semua', 'All'); ?></option>
                                        <option value="beginner" <?php echo $path->skill_level === 'beginner' ? 'selected' : ''; ?>>Pemula</option>
                                        <option value="intermediate" <?php echo $path->skill_level === 'intermediate' ? 'selected' : ''; ?>>Menengah</option>
                                        <option value="advanced" <?php echo $path->skill_level === 'advanced' ? 'selected' : ''; ?>>Mahir</option>
                                    </select>
                                    <label class="fl-label"><?php echo t('Level', 'Level'); ?></label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-float">
                                    <input type="number" name="estimated_hours" class="form-control" value="<?php echo $path->estimated_hours; ?>" placeholder=" ">
                                    <label class="fl-label"><?php echo t('Estimasi (jam)', 'Est. Hours'); ?></label>
                                </div>
                            </div>
                        </div>
                        <div class="row g-4">
                            <div class="col-md-6">
                                <div class="form-float">
                                    <textarea name="description" rows="3" class="form-control" placeholder=" " data-max-chars="1000"><?php echo set_value('description', $path->description); ?></textarea>
                                    <label class="fl-label"><?php echo t('Deskripsi (ID)', 'Description (ID)'); ?></label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-float">
                                    <textarea name="description_en" rows="3" class="form-control" placeholder=" " data-max-chars="1000"><?php echo set_value('description_en', $path->description_en); ?></textarea>
                                    <label class="fl-label"><?php echo t('Deskripsi (EN)', 'Description (EN)'); ?></label>
                                </div>
                            </div>
                        </div>
                        <div>
                            <label class="fl-label d-block mb-1 fw-semibold"><?php echo t('Warna', 'Color'); ?></label>
                            <div class="color-picker-wrapper">
                                <input type="color" name="color" id="colorPicker" value="<?php echo $path->color ?? '#4361ee'; ?>" style="width:44px;height:44px;">
                                <div class="form-float flex-grow-1">
                                    <input type="text" name="color_text" class="form-control form-control-sm" value="<?php echo $path->color ?? '#4361ee'; ?>" placeholder=" ">
                                    <label class="fl-label">#hex</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end gap-2 px-4 px-xl-5 py-3 form-footer-sticky">
                        <a href="<?php echo base_url('admin/learning_paths'); ?>" class="btn btn-outline-secondary btn-sm rounded-pill px-4"><?php echo t('Kembali', 'Back'); ?></a>
                        <button type="submit" class="btn btn-primary btn-sm rounded-pill px-4 d-flex align-items-center gap-1">
                            <i data-lucide="save" style="width:16px;height:16px;"></i> <?php echo t('Simpan', 'Save'); ?>
                        </button>
                    </div>
                <?php echo form_close(); ?>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="bento-card">
                <h6 class="fw-bold text-dark mb-3 d-flex align-items-center gap-2">
                    <i data-lucide="list" style="width:18px;height:18px;color:var(--primary);"></i>
                    <?php echo t('Konten dalam Path', 'Path Contents'); ?>
                </h6>
                <div class="d-flex flex-column gap-2 mb-3">
                    <?php foreach ($contents as $c): ?>
                        <div class="d-flex justify-content-between align-items-center p-2 rounded-2" style="background:var(--gray-50);">
                            <span class="small text-truncate fw-medium"><?php echo $c->sort_order; ?>. <?php echo htmlspecialchars($c->title); ?></span>
                            <a href="<?php echo base_url('admin/remove_path_content/' . $c->id); ?>" class="text-danger small ms-2 flex-shrink-0" data-confirm="Hapus?">
                                <i data-lucide="x" style="width:14px;height:14px;"></i>
                            </a>
                        </div>
                    <?php endforeach; ?>
                    <?php if (empty($contents)): ?>
                        <p class="text-muted small"><?php echo t('Belum ada konten.', 'No contents yet.'); ?></p>
                    <?php endif; ?>
                </div>

                <h6 class="fw-bold text-dark mb-2"><?php echo t('Tambah Konten', 'Add Content'); ?></h6>
                <?php echo form_open('admin/add_path_content/' . $path->id, array('class' => 'd-flex flex-column gap-2')); ?>
                    <select name="course_id" class="form-select form-select-sm" required>
                        <option value=""><?php echo t('Pilih konten...', 'Select content...'); ?></option>
                        <?php foreach ($all_courses as $c): ?>
                            <option value="<?php echo $c->id; ?>"><?php echo htmlspecialchars($c->title); ?></option>
                        <?php endforeach; ?>
                    </select>
                    <div class="input-group">
                        <input type="number" name="sort_order" class="form-control form-control-sm" placeholder="<?php echo t('Urutan', 'Order'); ?>" value="1">
                        <button type="submit" class="btn btn-primary btn-sm d-flex align-items-center gap-1">
                            <i data-lucide="plus" style="width:14px;height:14px;"></i>
                        </button>
                    </div>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
</div>
