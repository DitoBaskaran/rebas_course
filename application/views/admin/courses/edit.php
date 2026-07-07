<div class="container-fluid px-0">
    <div class="d-flex align-items-center gap-2 mb-5">
        <a href="<?php echo base_url('admin/courses'); ?>" class="btn btn-outline-dark btn-sm rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width: 36px; height: 36px;">
            <i data-lucide="arrow-left" style="width:16px;height:16px;"></i>
        </a>
        <div>
            <span class="text-primary fw-semibold small text-uppercase tracking-wide d-block mb-1">Konten</span>
            <h1 class="display-6 fw-extrabold text-dark mb-0 lh-sm" style="letter-spacing: -0.03em;"><?php echo t('Edit Konten', 'Edit Content'); ?></h1>
            <p class="text-secondary mb-0"><?php echo t('Perbarui informasi konten pembelajaran', 'Update learning content information'); ?></p>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="bento-card animate-scale-in overflow-hidden">
                <div class="d-flex align-items-center gap-2 px-4 px-xl-5 py-3 section-glass">
                    <i data-lucide="edit" style="width:18px;height:18px;"></i>
                    <span class="fw-semibold"><?php echo htmlspecialchars($course->title); ?></span>
                </div>
                <?php if (validation_errors()): ?>
                    <div class="alert alert-danger border-0 m-3 py-2 px-3 small"><?php echo validation_errors('', ''); ?></div>
                <?php endif; ?>
                <?php echo form_open_multipart('admin/edit_course/' . $course->id, array('class' => 'needs-validation')); ?>
                    <div class="card-body d-flex flex-column gap-4 p-4 p-xl-5">
                        <div class="row g-4">
                            <div class="col-md-6">
                                <div class="form-float">
                                    <input type="text" name="title" class="form-control" value="<?php echo set_value('title', $course->title); ?>" required placeholder=" ">
                                    <label class="fl-label"><?php echo t('Judul (ID)', 'Title (ID)'); ?> *</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-float">
                                    <input type="text" name="title_en" class="form-control" value="<?php echo set_value('title_en', $course->title_en); ?>" placeholder=" ">
                                    <label class="fl-label"><?php echo t('Judul (EN)', 'Title (EN)'); ?></label>
                                </div>
                            </div>
                        </div>
                        <div class="row g-4">
                            <div class="col-md-4">
                                <div class="form-float">
                                    <select name="content_type" class="form-select" required>
                                        <option value=""> </option>
                                        <?php foreach (['course','workshop','bootcamp','ebook','project','article','video','podcast','template'] as $ct): ?>
                                            <option value="<?php echo $ct; ?>" <?php echo $course->content_type === $ct ? 'selected' : ''; ?>><?php echo content_type_label($ct); ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <label class="fl-label"><?php echo t('Tipe Konten', 'Content Type'); ?> *</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-float">
                                    <select name="category_id" class="form-select" required>
                                        <option value=""> </option>
                                        <?php foreach ($categories as $cat): ?>
                                            <option value="<?php echo $cat->id; ?>" <?php echo set_select('category_id', $cat->id, $course->category_id == $cat->id); ?>><?php echo htmlspecialchars($cat->name); ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <label class="fl-label"><?php echo t('Kategori', 'Category'); ?> *</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-float">
                                    <select name="skill_level" class="form-select" required>
                                        <option value=""> </option>
                                        <?php foreach (['beginner','intermediate','advanced','all_levels'] as $sl): ?>
                                            <option value="<?php echo $sl; ?>" <?php echo set_select('skill_level', $sl, $course->skill_level === $sl); ?>><?php echo skill_level_label($sl); ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <label class="fl-label"><?php echo t('Level Skill', 'Skill Level'); ?> *</label>
                                </div>
                            </div>
                        </div>
                        <div class="row g-4">
                            <div class="col-md-3">
                                <div class="form-float">
                                    <div class="input-icon-wrap">
                                        <span class="input-icon-left">Rp</span>
                                        <input type="number" name="price" class="form-control" value="<?php echo set_value('price', round($course->price)); ?>" min="0" placeholder=" ">
                                    </div>
                                    <label class="fl-label"><?php echo t('Harga (Rp)', 'Price (Rp)'); ?></label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-float">
                                    <input type="number" name="duration_total" class="form-control" value="<?php echo set_value('duration_total', $course->duration_total); ?>" min="0" placeholder=" ">
                                    <label class="fl-label"><?php echo t('Durasi (menit)', 'Duration (min)'); ?></label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-float">
                                    <select name="language" class="form-select">
                                        <option value=""> </option>
                                        <option value="id" <?php echo $course->language === 'id' ? 'selected' : ''; ?>>Indonesia</option>
                                        <option value="en" <?php echo $course->language === 'en' ? 'selected' : ''; ?>>English</option>
                                    </select>
                                    <label class="fl-label"><?php echo t('Bahasa', 'Language'); ?></label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-float">
                                    <select name="status" class="form-select">
                                        <option value=""> </option>
                                        <option value="published" <?php echo $course->status === 'published' ? 'selected' : ''; ?>><?php echo t('Published', 'Published'); ?></option>
                                        <option value="draft" <?php echo $course->status === 'draft' ? 'selected' : ''; ?>><?php echo t('Draft', 'Draft'); ?></option>
                                        <option value="archived" <?php echo $course->status === 'archived' ? 'selected' : ''; ?>><?php echo t('Archived', 'Archived'); ?></option>
                                    </select>
                                    <label class="fl-label"><?php echo t('Status', 'Status'); ?></label>
                                </div>
                            </div>
                        </div>
                        <div class="row g-4">
                            <div class="col-md-8">
                                <label class="form-label fw-semibold"><?php echo t('Cover Baru', 'New Cover'); ?></label>
                                <input type="file" name="thumbnail" class="form-control">
                                <small class="field-hint"><?php echo t('Format: JPG, PNG. Maks: 2MB', 'Format: JPG, PNG. Max: 2MB'); ?></small>
                                <div class="mt-2 d-flex align-items-center gap-2">
                                    <img src="<?php echo base_url('uploads/courses/' . $course->thumbnail); ?>" onerror="this.src='https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=100&auto=format&fit=crop&q=60';" alt="" class="thumb-xs" style="border-radius:var(--radius-sm);">
                                    <span class="text-muted small"><?php echo t('Cover saat ini', 'Current cover'); ?></span>
                                </div>
                            </div>
                            <div class="col-md-4 d-flex align-items-end pb-2">
                                <label class="toggle-switch">
                                    <input type="checkbox" name="featured" value="1" id="featuredCheck" <?php echo $course->featured ? 'checked' : ''; ?>>
                                    <span class="track"></span>
                                    <span class="toggle-label"><?php echo t('Tandai sebagai Unggulan', 'Mark as Featured'); ?></span>
                                </label>
                            </div>
                        </div>
                        <div>
                            <div class="form-float">
                                <textarea name="description" rows="5" class="form-control" required data-max-chars="500"><?php echo set_value('description', $course->description); ?></textarea>
                                <label class="fl-label"><?php echo t('Deskripsi (ID)', 'Description (ID)'); ?> *</label>
                            </div>
                        </div>
                        <div>
                            <div class="form-float">
                                <textarea name="description_en" rows="5" class="form-control" data-max-chars="500"><?php echo set_value('description_en', $course->description_en); ?></textarea>
                                <label class="fl-label"><?php echo t('Deskripsi (EN)', 'Description (EN)'); ?></label>
                            </div>
                        </div>
                        <div>
                            <div class="form-float">
                                <select name="tags[]" class="form-select select-multiple-tags" multiple>
                                    <?php $ctag_ids = array_map(function($t) { return $t->id; }, $content_tags); ?>
                                    <?php foreach ($tags as $tag): ?>
                                        <option value="<?php echo $tag->id; ?>" <?php echo in_array($tag->id, $ctag_ids) ? 'selected' : ''; ?>><?php echo htmlspecialchars($tag->name); ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <label class="fl-label"><?php echo t('Tags', 'Tags'); ?></label>
                            </div>
                            <small class="field-hint"><?php echo t('Tahan Ctrl untuk memilih banyak', 'Hold Ctrl to select multiple'); ?></small>
                        </div>
                    </div>
                    <div class="form-footer-sticky d-flex justify-content-end gap-2 px-4 px-xl-5 py-3 border-top">
                        <a href="<?php echo base_url('admin/courses'); ?>" class="btn btn-outline-secondary btn-sm rounded-pill px-4"><?php echo t('Batal', 'Cancel'); ?></a>
                        <button type="submit" class="btn btn-primary btn-sm rounded-pill px-4 d-flex align-items-center gap-1">
                            <i data-lucide="save" style="width:16px;height:16px;"></i> <?php echo t('Simpan', 'Save'); ?>
                        </button>
                    </div>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
</div>
