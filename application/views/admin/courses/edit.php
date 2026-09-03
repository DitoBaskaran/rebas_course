<div class="container-fluid px-0">

    <!-- ============ HEADER (hero) ============ -->
    <div class="bento-card mb-4 overflow-hidden" style="background:linear-gradient(120deg,#0D1830 0%,#164e63 100%);border:none;color:#fff;">
        <div class="position-relative" style="z-index:1;">
            <a href="<?php echo base_url('admin/courses'); ?>" class="d-inline-flex align-items-center gap-1 text-decoration-none mb-2" style="color:rgba(255,255,255,0.72);font-size:0.76rem;font-weight:600;">
                <i data-lucide="arrow-left" style="width:13px;height:13px;"></i> <?php echo t('Kembali ke Konten', 'Back to Content'); ?>
            </a>
            <span class="d-inline-flex align-items-center gap-1" style="background:rgba(255,255,255,0.14);border:1px solid rgba(255,255,255,0.2);color:#FBBF24;font-size:0.66rem;font-weight:800;letter-spacing:0.12em;text-transform:uppercase;padding:0.3rem 0.7rem;border-radius:100px;">
                <i data-lucide="edit" style="width:12px;height:12px;"></i>
                <?php echo t('Edit Konten', 'Edit Content'); ?>
            </span>
            <h1 class="fw-extrabold text-white mb-1 mt-2 lh-sm" style="letter-spacing:-0.03em;font-size:1.5rem;">
                <?php echo htmlspecialchars($course->title); ?>
            </h1>
            <div class="d-flex flex-wrap gap-2 mt-1">
                <?php
                    $st = $course->status;
                    $st_bg = $st==='published' ? '#E0F2F1' : ($st==='draft' ? '#fffbeb' : '#f1f5f9');
                    $st_tx = $st==='published' ? '#009688' : ($st==='draft' ? '#d97706' : '#64748b');
                ?>
                <span class="d-inline-flex align-items-center gap-1 px-2 py-1 rounded-pill fw-semibold" style="background:<?php echo $st_bg; ?>;color:<?php echo $st_tx; ?>;font-size:0.68rem;"><?php echo t(ucfirst($st), ucfirst($st)); ?></span>
                <span class="d-inline-flex align-items-center gap-1 px-2 py-1 rounded-pill fw-semibold" style="background:rgba(255,255,255,0.14);color:#fff;font-size:0.68rem;"><?php echo content_type_label($course->content_type); ?></span>
                <?php if ($course->price > 0): ?>
                <span class="d-inline-flex align-items-center gap-1 px-2 py-1 rounded-pill fw-semibold" style="background:rgba(255,255,255,0.14);color:#fff;font-size:0.68rem;">Rp <?php echo number_format($course->price, 0, ',', '.'); ?></span>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="bento-grid bento-grid-2-1 mb-4" style="align-items:start;">
        <!-- LEFT: form -->
        <div class="bento-card animate-scale-in overflow-hidden">
            <div class="d-flex align-items-center gap-2 px-4 py-3 section-glass">
                <i data-lucide="edit" style="width:18px;height:18px;"></i>
                <span class="fw-semibold"><?php echo t('Informasi Konten', 'Content Information'); ?></span>
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

        <!-- RIGHT: related content shortcuts -->
        <div class="d-flex flex-column gap-3" style="position:sticky;top:1rem;">
            <div class="bento-card">
                <h6 class="fw-bold text-dark mb-3 d-flex align-items-center gap-2" style="font-size:0.8rem;">
                    <i data-lucide="link-2" style="width:15px;height:15px;color:var(--primary);"></i> <?php echo t('Konten Terkait', 'Related Content'); ?>
                </h6>
                <div class="d-flex flex-column gap-2">
                    <a href="<?php echo base_url('admin/lessons/' . $course->id); ?>" class="quick-act-btn">
                        <span class="qi-ic" style="background:#E0F2F1;color:#009688;"><i class="fas fa-list"></i></span>
                        <span><?php echo t('Kelola Materi', 'Manage Lessons'); ?></span>
                        <i data-lucide="chevron-right" style="width:14px;height:14px;color:#c2c8d0;"></i>
                    </a>
                    <a href="<?php echo base_url('quiz/admin_quizzes/' . $course->id); ?>" class="quick-act-btn">
                        <span class="qi-ic" style="background:#eff6ff;color:#2563eb;"><i class="fas fa-pencil-alt"></i></span>
                        <span><?php echo t('Kelola Quiz', 'Manage Quizzes'); ?></span>
                        <i data-lucide="chevron-right" style="width:14px;height:14px;color:#c2c8d0;"></i>
                    </a>
                    <a href="<?php echo base_url('admin/assignments/' . $course->id); ?>" class="quick-act-btn">
                        <span class="qi-ic" style="background:#fff7ed;color:#ea580c;"><i class="fas fa-code"></i></span>
                        <span><?php echo t('Kelola Tugas', 'Manage Assignments'); ?></span>
                        <i data-lucide="chevron-right" style="width:14px;height:14px;color:#c2c8d0;"></i>
                    </a>
                </div>
            </div>
            <div class="bento-card d-flex align-items-center gap-2" style="padding:0.9rem 1rem;">
                <i data-lucide="info" style="width:15px;height:15px;color:var(--primary);flex-shrink:0;"></i>
                <span class="small text-muted"><?php echo t('Simpan perubahan untuk memperbarui konten yang tampil di publik.', 'Save changes to update the content shown publicly.'); ?></span>
            </div>
        </div>
    </div>
</div>
