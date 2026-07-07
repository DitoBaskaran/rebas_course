<div class="container-fluid px-0">
    <div class="d-flex align-items-center gap-2 mb-5">
        <a href="<?php echo base_url('admin/assignments/' . $course->id); ?>" class="btn btn-outline-dark btn-sm rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width: 36px; height: 36px;">
            <i data-lucide="arrow-left" style="width:16px;height:16px;"></i>
        </a>
        <div>
            <span class="text-primary fw-semibold small text-uppercase tracking-wide d-block mb-1">Tugas</span>
            <h1 class="display-6 fw-extrabold text-dark mb-0 lh-sm" style="letter-spacing: -0.03em;"><?php echo t('Buat Tugas', 'Create Assignment'); ?></h1>
            <p class="text-secondary mb-0"><?php echo t('Kelas:', 'Course:'); ?> <strong><?php echo htmlspecialchars($course->title); ?></strong></p>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="bento-card animate-scale-in overflow-hidden">
                <div class="section-glass">
                    <i data-lucide="plus-circle" style="width:18px;height:18px;color:var(--primary);"></i>
                    <span class="fw-semibold"><?php echo t('Detail Tugas', 'Assignment Details'); ?></span>
                </div>
                <?php if (validation_errors()): ?>
                    <div class="alert alert-danger border-0 m-3 py-2 px-3 small"><?php echo validation_errors('', ''); ?></div>
                <?php endif; ?>
                <?php echo form_open('admin/create_assignment/' . $course->id, array('class' => 'needs-validation')); ?>
                    <div class="d-flex flex-column gap-4 p-4 p-xl-5">
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
                            <div class="col-md-3">
                                <div class="form-float">
                                    <select name="lesson_id" class="form-control">
                                        <option value=""> </option>
                                        <?php foreach ($lessons as $l): ?>
                                            <option value="<?php echo $l->id; ?>"><?php echo htmlspecialchars($l->title); ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <label class="fl-label"><?php echo t('Link ke Materi', 'Link to Lesson'); ?></label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-float">
                                    <input type="number" name="due_days" class="form-control" value="<?php echo set_value('due_days', '7'); ?>" min="1" placeholder=" ">
                                    <label class="fl-label"><?php echo t('Tenggat (hari)', 'Due (days)'); ?></label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-float">
                                    <input type="number" name="max_file_size" class="form-control" value="<?php echo set_value('max_file_size', '10240'); ?>" min="1" placeholder=" ">
                                    <label class="fl-label"><?php echo t('Max File (KB)', 'Max File (KB)'); ?></label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-float">
                                    <input type="number" name="max_score" class="form-control" value="<?php echo set_value('max_score', '100'); ?>" min="1" max="100" placeholder=" ">
                                    <label class="fl-label"><?php echo t('Nilai Max', 'Max Score'); ?></label>
                                </div>
                            </div>
                        </div>
                        <div>
                            <div class="form-float">
                                <input type="text" name="allowed_file_types" class="form-control" value="<?php echo set_value('allowed_file_types', 'pdf,zip,doc,docx,jpg,png'); ?>" placeholder=" ">
                                <label class="fl-label"><?php echo t('Tipe File Diizinkan', 'Allowed File Types'); ?></label>
                            </div>
                            <small class="field-hint"><?php echo t('Pisahkan dengan koma.', 'Comma separated.'); ?></small>
                        </div>
                        <div>
                            <div class="form-float">
                                <textarea name="description" rows="2" class="form-control" placeholder=" "><?php echo set_value('description'); ?></textarea>
                                <label class="fl-label"><?php echo t('Deskripsi (ID)', 'Description (ID)'); ?></label>
                            </div>
                        </div>
                        <div>
                            <div class="form-float">
                                <textarea name="description_en" rows="2" class="form-control" placeholder=" "><?php echo set_value('description_en'); ?></textarea>
                                <label class="fl-label"><?php echo t('Deskripsi (EN)', 'Description (EN)'); ?></label>
                            </div>
                        </div>
                        <div>
                            <div class="form-float">
                                <textarea name="instructions" rows="3" class="form-control tinymce" placeholder=" "><?php echo set_value('instructions'); ?></textarea>
                                <label class="fl-label"><?php echo t('Instruksi (ID)', 'Instructions (ID)'); ?></label>
                            </div>
                        </div>
                        <div>
                            <div class="form-float">
                                <textarea name="instructions_en" rows="3" class="form-control tinymce" placeholder=" "><?php echo set_value('instructions_en'); ?></textarea>
                                <label class="fl-label"><?php echo t('Instruksi (EN)', 'Instructions (EN)'); ?></label>
                            </div>
                        </div>
                    </div>
                    <div class="form-footer-sticky">
                        <a href="<?php echo base_url('admin/assignments/' . $course->id); ?>" class="btn btn-outline-secondary btn-sm rounded-pill px-4"><?php echo t('Batal', 'Cancel'); ?></a>
                        <button type="submit" class="btn btn-dark btn-sm rounded-pill px-4 d-flex align-items-center gap-1">
                            <i data-lucide="save" style="width:16px;height:16px;"></i> <?php echo t('Simpan', 'Save'); ?>
                        </button>
                    </div>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
</div>
