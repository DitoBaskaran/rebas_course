<div class="container-fluid px-0">

    <!-- ============ HEADER (hero) ============ -->
    <div class="bento-card mb-4 overflow-hidden" style="background:linear-gradient(120deg,#0D1830 0%,#164e63 100%);border:none;color:#fff;">
        <div class="position-relative" style="z-index:1;">
            <a href="<?php echo base_url('admin/courses'); ?>" class="d-inline-flex align-items-center gap-1 text-decoration-none mb-2" style="color:rgba(255,255,255,0.72);font-size:0.76rem;font-weight:600;">
                <i data-lucide="arrow-left" style="width:13px;height:13px;"></i> <?php echo t('Kembali ke Konten', 'Back to Content'); ?>
            </a>
            <span class="d-inline-flex align-items-center gap-1" style="background:rgba(255,255,255,0.14);border:1px solid rgba(255,255,255,0.2);color:#FBBF24;font-size:0.66rem;font-weight:800;letter-spacing:0.12em;text-transform:uppercase;padding:0.3rem 0.7rem;border-radius:100px;">
                <i data-lucide="plus" style="width:12px;height:12px;"></i>
                <?php echo t('Konten Baru', 'New Content'); ?>
            </span>
            <h1 class="fw-extrabold text-white mb-0 mt-2 lh-sm" style="letter-spacing:-0.03em;font-size:1.5rem;">
                <?php echo t('Buat Konten Baru', 'Create New Content'); ?>
            </h1>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="bento-card animate-scale-in overflow-hidden">
                <div class="d-flex align-items-center gap-2 px-4 px-xl-5 py-3 section-glass">
                    <i data-lucide="book-open" style="width:18px;height:18px;"></i>
                    <span class="fw-semibold"><?php echo t('Informasi Konten', 'Content Information'); ?></span>
                </div>
                <?php if (validation_errors()): ?>
                    <div class="alert alert-danger border-0 m-3 py-2 px-3 small"><?php echo validation_errors('', ''); ?></div>
                <?php endif; ?>
                <?php echo form_open_multipart('admin/create_course', array('class' => 'needs-validation')); ?>
                    <div class="card-body d-flex flex-column gap-4 p-4 p-xl-5">
                        <div class="row g-4">
                            <div class="col-md-6">
                                <div class="form-float">
                                    <input type="text" name="title" class="form-control" value="<?php echo set_value('title'); ?>" required placeholder=" ">
                                    <label class="fl-label"><?php echo t('Judul (ID)', 'Title (ID)'); ?> *</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-float">
                                    <input type="text" name="title_en" class="form-control" value="<?php echo set_value('title_en'); ?>" placeholder=" ">
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
                                            <option value="<?php echo $ct; ?>"><?php echo content_type_label($ct); ?></option>
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
                                            <option value="<?php echo $cat->id; ?>"><?php echo htmlspecialchars($cat->name); ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <label class="fl-label"><?php echo t('Kategori', 'Category'); ?> *</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-float">
                                    <select name="skill_level" class="form-select" required>
                                        <option value=""> </option>
                                        <option value="all_levels"><?php echo t('Semua Level', 'All Levels'); ?></option>
                                        <option value="beginner"><?php echo t('Pemula', 'Beginner'); ?></option>
                                        <option value="intermediate"><?php echo t('Menengah', 'Intermediate'); ?></option>
                                        <option value="advanced"><?php echo t('Mahir', 'Advanced'); ?></option>
                                    </select>
                                    <label class="fl-label"><?php echo t('Level Skill', 'Skill Level'); ?> *</label>
                                </div>
                            </div>
                        </div>
                        <div class="row g-4">
                            <div class="col-md-4">
                                <div class="form-float">
                                    <div class="input-icon-wrap">
                                        <span class="input-icon-left">Rp</span>
                                        <input type="number" name="price" class="form-control" value="<?php echo set_value('price', '0'); ?>" min="0" placeholder=" ">
                                    </div>
                                    <label class="fl-label"><?php echo t('Harga (Rp)', 'Price (Rp)'); ?> *</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-float">
                                    <input type="number" name="duration_total" class="form-control" value="0" min="0" placeholder=" ">
                                    <label class="fl-label"><?php echo t('Durasi (menit)', 'Duration (min)'); ?></label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-float">
                                    <select name="language" class="form-select">
                                        <option value=""> </option>
                                        <option value="id">Indonesia</option>
                                        <option value="en">English</option>
                                    </select>
                                    <label class="fl-label"><?php echo t('Bahasa', 'Language'); ?></label>
                                </div>
                            </div>
                        </div>
                        <div class="row g-4">
                            <div class="col-md-8">
                                <label class="form-label fw-semibold"><?php echo t('Cover Image', 'Cover Image'); ?></label>
                                <input type="file" name="thumbnail" class="form-control">
                                <small class="field-hint"><?php echo t('Format: JPG, PNG. Maks: 2MB', 'Format: JPG, PNG. Max: 2MB'); ?></small>
                            </div>
                            <div class="col-md-4 d-flex align-items-end pb-2">
                                <label class="toggle-switch">
                                    <input type="checkbox" name="featured" value="1" id="featuredCheck">
                                    <span class="track"></span>
                                    <span class="toggle-label"><?php echo t('Tandai sebagai Unggulan', 'Mark as Featured'); ?></span>
                                </label>
                            </div>
                        </div>
                        <div>
                            <div class="form-float">
                                <textarea name="description" rows="5" class="form-control tinymce" required data-max-chars="500"><?php echo set_value('description'); ?></textarea>
                                <label class="fl-label"><?php echo t('Deskripsi (ID)', 'Description (ID)'); ?> *</label>
                            </div>
                        </div>
                        <div>
                            <div class="form-float">
                                <textarea name="description_en" rows="5" class="form-control tinymce" data-max-chars="500"><?php echo set_value('description_en'); ?></textarea>
                                <label class="fl-label"><?php echo t('Deskripsi (EN)', 'Description (EN)'); ?></label>
                            </div>
                        </div>
                        <div>
                            <div class="form-float">
                                <select name="tags[]" class="form-select select-multiple-tags" multiple>
                                    <?php foreach ($tags as $tag): ?>
                                        <option value="<?php echo $tag->id; ?>"><?php echo htmlspecialchars($tag->name); ?></option>
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
