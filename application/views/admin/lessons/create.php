<div class="container-fluid px-0">
    <div class="d-flex align-items-center gap-2 mb-5">
        <a href="<?php echo base_url('admin/lessons/' . $course->id); ?>" class="btn btn-outline-dark btn-sm rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width: 36px; height: 36px;">
            <i data-lucide="arrow-left" style="width:16px;height:16px;"></i>
        </a>
        <div>
            <span class="text-primary fw-semibold small text-uppercase tracking-wide d-block mb-1">Materi</span>
            <h1 class="display-6 fw-extrabold text-dark mb-0 lh-sm" style="letter-spacing: -0.03em;"><?php echo t('Tambah Materi', 'Add Lesson'); ?></h1>
            <p class="text-secondary mb-0"><?php echo t('Kelas:', 'Course:'); ?> <strong><?php echo htmlspecialchars(t($course->title, $course->title_en ?: $course->title)); ?></strong></p>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="bento-card animate-scale-in overflow-hidden">
                <div class="d-flex align-items-center gap-2 px-4 px-xl-5 py-3 section-glass">
                    <i data-lucide="plus-circle" style="width:18px;height:18px;"></i>
                    <span class="fw-semibold"><?php echo t('Detail Materi', 'Lesson Details'); ?></span>
                </div>
                <?php if (validation_errors()): ?>
                    <div class="alert alert-danger border-0 m-3 py-2 px-3 small"><?php echo validation_errors('', ''); ?></div>
                <?php endif; ?>
                <?php echo form_open('admin/create_lesson/' . $course->id, array('class' => 'needs-validation')); ?>
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
                            <div class="col-md-3">
                                <div class="form-float">
                                    <select name="lesson_type" class="form-select" required id="lessonTypeSelect">
                                        <option value=""> </option>
                                        <option value="video" <?php echo set_select('lesson_type', 'video'); ?>><?php echo t('Video', 'Video'); ?></option>
                                        <option value="text" <?php echo set_select('lesson_type', 'text'); ?>><?php echo t('Teks', 'Text'); ?></option>
                                        <option value="quiz" <?php echo set_select('lesson_type', 'quiz'); ?>><?php echo t('Quiz', 'Quiz'); ?></option>
                                        <option value="assignment" <?php echo set_select('lesson_type', 'assignment'); ?>><?php echo t('Tugas', 'Assignment'); ?></option>
                                        <option value="live_session" <?php echo set_select('lesson_type', 'live_session'); ?>><?php echo t('Live', 'Live Session'); ?></option>
                                    </select>
                                    <label class="fl-label"><?php echo t('Tipe', 'Type'); ?> *</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-float">
                                    <input type="number" name="duration" class="form-control" value="<?php echo set_value('duration', '15'); ?>" required placeholder=" ">
                                    <label class="fl-label"><?php echo t('Durasi (menit)', 'Duration (min)'); ?></label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-float">
                                    <input type="number" name="sort_order" class="form-control" value="<?php echo set_value('sort_order', '1'); ?>" required placeholder=" ">
                                    <label class="fl-label"><?php echo t('Urutan', 'Sort Order'); ?></label>
                                </div>
                            </div>
                            <div class="col-md-3 d-flex align-items-end pb-2">
                                <label class="toggle-switch">
                                    <input class="form-check-input" type="checkbox" name="is_free" value="1" id="isFreeCheck" <?php echo set_checkbox('is_free', '1'); ?>>
                                    <span class="track"></span>
                                    <span class="toggle-label"><?php echo t('Gratis', 'Free Preview'); ?></span>
                                </label>
                            </div>
                        </div>
                        <div id="videoUrlGroup">
                            <div class="form-float">
                                <input type="url" name="video_url" class="form-control" value="<?php echo set_value('video_url'); ?>" placeholder=" ">
                                <label class="fl-label"><?php echo t('Video URL', 'Video URL'); ?></label>
                            </div>
                            <small class="field-hint"><?php echo t('Dukung YouTube, Vimeo, atau URL MP4 langsung', 'Supports YouTube, Vimeo, or direct MP4 URL'); ?></small>
                        </div>
                        <div id="liveUrlGroup" class="d-none">
                            <div class="form-float">
                                <input type="url" name="live_url" class="form-control" value="<?php echo set_value('live_url'); ?>" placeholder=" ">
                                <label class="fl-label"><?php echo t('Link Live / Zoom / Meet', 'Live / Zoom / Meet Link'); ?></label>
                            </div>
                            <small class="field-hint"><?php echo t('Bagikan link meeting untuk sesi live', 'Share the meeting link for live session'); ?></small>
                        </div>
                        <div>
                            <div class="form-float">
                                <textarea name="description" rows="2" class="form-control" placeholder=" " data-max-chars="500"><?php echo set_value('description'); ?></textarea>
                                <label class="fl-label"><?php echo t('Deskripsi (ID)', 'Description (ID)'); ?></label>
                            </div>
                        </div>
                        <div>
                            <div class="form-float">
                                <textarea name="description_en" rows="2" class="form-control" placeholder=" " data-max-chars="500"><?php echo set_value('description_en'); ?></textarea>
                                <label class="fl-label"><?php echo t('Deskripsi (EN)', 'Description (EN)'); ?></label>
                            </div>
                        </div>
                        <div>
                            <div class="form-float">
                                <textarea name="content" rows="8" class="form-control tinymce" placeholder=" "><?php echo set_value('content'); ?></textarea>
                                <label class="fl-label"><?php echo t('Konten Bacaan', 'Reading Content'); ?></label>
                            </div>
                        </div>
                        <div>
                            <div class="form-float">
                                <textarea name="content_en" rows="8" class="form-control tinymce" placeholder=" "><?php echo set_value('content_en'); ?></textarea>
                                <label class="fl-label"><?php echo t('Konten Bacaan (EN)', 'Reading Content (EN)'); ?></label>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end gap-2 px-4 px-xl-5 py-3 form-footer-sticky">
                        <a href="<?php echo base_url('admin/lessons/' . $course->id); ?>" class="btn btn-outline-secondary btn-sm rounded-pill px-4"><?php echo t('Batal', 'Cancel'); ?></a>
                        <button type="submit" class="btn btn-dark btn-sm rounded-pill px-4 d-flex align-items-center gap-1">
                            <i data-lucide="save" style="width:16px;height:16px;"></i> <?php echo t('Simpan', 'Save'); ?>
                        </button>
                    </div>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('lessonTypeSelect').addEventListener('change', function() {
    var v = document.getElementById('videoUrlGroup');
    var l = document.getElementById('liveUrlGroup');
    if (this.value === 'video') { v.classList.remove('d-none'); l.classList.add('d-none'); }
    else if (this.value === 'live_session') { v.classList.add('d-none'); l.classList.remove('d-none'); }
    else { v.classList.add('d-none'); l.classList.add('d-none'); }
});
</script>
