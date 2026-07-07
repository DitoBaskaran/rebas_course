<div class="container-fluid px-0">
    <div class="d-flex align-items-center gap-2 mb-5">
        <a href="<?php echo base_url('quiz/admin_quizzes/' . $course->id); ?>" class="btn btn-outline-dark btn-sm rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width: 36px; height: 36px;">
            <i data-lucide="arrow-left" style="width:16px;height:16px;"></i>
        </a>
        <div>
            <span class="text-primary fw-semibold small text-uppercase tracking-wide d-block mb-1">Quiz</span>
            <h1 class="display-6 fw-extrabold text-dark mb-0 lh-sm" style="letter-spacing: -0.03em;"><?php echo t('Buat Quiz', 'Create Quiz'); ?></h1>
            <p class="text-secondary mb-0"><?php echo t('Kelas:', 'Course:'); ?> <strong><?php echo htmlspecialchars($course->title); ?></strong></p>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="bento-card animate-scale-in overflow-hidden">
                <div class="section-glass">
                    <i data-lucide="plus-circle" style="width:18px;height:18px;color:var(--primary);"></i>
                    <span class="fw-semibold"><?php echo t('Detail Quiz', 'Quiz Details'); ?></span>
                </div>
                <?php echo form_open('quiz/admin_create_quiz/' . $course->id, array('class' => 'needs-validation')); ?>
                    <div class="d-flex flex-column gap-4 p-4 p-xl-5">
                        <div class="row g-4">
                            <div class="col-md-6">
                                <div class="form-float">
                                    <input type="text" name="title" class="form-control" required placeholder=" ">
                                    <label class="fl-label"><?php echo t('Judul Quiz', 'Quiz Title'); ?> *</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-float">
                                    <select name="lesson_id" class="form-control">
                                        <option value=""> </option>
                                        <?php $lessons = $this->Course_model->get_lessons_by_course($course->id); ?>
                                        <?php foreach ($lessons as $l): ?>
                                            <option value="<?php echo $l->id; ?>"><?php echo htmlspecialchars($l->title); ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <label class="fl-label"><?php echo t('Link ke Materi', 'Link to Lesson'); ?></label>
                                </div>
                            </div>
                        </div>
                        <div class="row g-4">
                            <div class="col-md-4">
                                <div class="form-float">
                                    <input type="number" name="passing_score" class="form-control" value="70" min="1" max="100" required placeholder=" ">
                                    <label class="fl-label"><?php echo t('Nilai Lulus (%)', 'Passing Score (%)'); ?> *</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-float">
                                    <input type="number" name="time_limit" class="form-control" value="0" placeholder=" ">
                                    <label class="fl-label"><?php echo t('Batas Waktu (menit)', 'Time Limit (min)'); ?></label>
                                </div>
                                <small class="field-hint"><?php echo t('0 = tanpa batas waktu', '0 = no time limit'); ?></small>
                            </div>
                            <div class="col-md-4">
                                <div class="form-float">
                                    <input type="number" name="max_attempts" class="form-control" value="3" min="1" placeholder=" ">
                                    <label class="fl-label"><?php echo t('Maks Percobaan', 'Max Attempts'); ?></label>
                                </div>
                                <small class="field-hint"><?php echo t('0 = unlimited', '0 = unlimited'); ?></small>
                            </div>
                        </div>
                    </div>
                    <div class="form-footer-sticky">
                        <button type="submit" class="btn btn-dark rounded-pill px-4 py-2 fw-semibold d-flex align-items-center gap-1">
                            <i data-lucide="check" style="width:16px;height:16px;"></i> <?php echo t('Buat Quiz', 'Create Quiz'); ?>
                        </button>
                        <a href="<?php echo base_url('quiz/admin_quizzes/' . $course->id); ?>" class="btn btn-outline-secondary rounded-pill px-4 py-2 fw-semibold"><?php echo t('Batal', 'Cancel'); ?></a>
                    </div>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
</div>
