<div class="container-fluid px-0">
    <div class="d-flex align-items-center gap-2 mb-5">
        <a href="<?php echo base_url('quiz/admin_questions/' . $quiz->id); ?>" class="btn btn-outline-dark btn-sm rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width: 36px; height: 36px;">
            <i data-lucide="arrow-left" style="width:16px;height:16px;"></i>
        </a>
        <div>
            <span class="text-primary fw-semibold small text-uppercase tracking-wide d-block mb-1">Quiz</span>
            <h1 class="display-6 fw-extrabold text-dark mb-0 lh-sm" style="letter-spacing: -0.03em;"><?php echo t('Tambah Soal', 'Add Question'); ?></h1>
            <p class="text-secondary mb-0"><?php echo t('Quiz:', 'Quiz:'); ?> <strong><?php echo htmlspecialchars($quiz->title); ?></strong></p>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="bento-card animate-scale-in overflow-hidden">
                <div class="section-glass">
                    <i data-lucide="plus-circle" style="width:18px;height:18px;color:var(--primary);"></i>
                    <span class="fw-semibold"><?php echo t('Detail Soal', 'Question Details'); ?></span>
                </div>
                <?php echo form_open('quiz/admin_create_question/' . $quiz->id, array('class' => 'needs-validation', 'id' => 'questionForm')); ?>
                    <div class="d-flex flex-column gap-4 p-4 p-xl-5">
                        <div class="row g-4">
                            <div class="col-md-6">
                                <div class="form-float">
                                    <textarea name="question" rows="3" class="form-control" required placeholder=" "></textarea>
                                    <label class="fl-label"><?php echo t('Soal (ID)', 'Question (ID)'); ?> *</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-float">
                                    <textarea name="question_en" rows="3" class="form-control" placeholder=" "></textarea>
                                    <label class="fl-label"><?php echo t('Soal (EN)', 'Question (EN)'); ?></label>
                                </div>
                            </div>
                        </div>
                        <div class="row g-4">
                            <div class="col-md-3">
                                <div class="form-float">
                                    <select name="type" class="form-control" id="questionType" required>
                                        <option value=""> </option>
                                        <option value="multiple_choice"><?php echo t('Pilihan Ganda', 'Multiple Choice'); ?></option>
                                        <option value="true_false">True / False</option>
                                        <option value="short_answer"><?php echo t('Jawaban Singkat', 'Short Answer'); ?></option>
                                        <option value="essay"><?php echo t('Esai', 'Essay'); ?></option>
                                    </select>
                                    <label class="fl-label"><?php echo t('Tipe', 'Type'); ?> *</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-float">
                                    <input type="number" name="points" class="form-control" value="1" min="1" required placeholder=" ">
                                    <label class="fl-label"><?php echo t('Poin', 'Points'); ?> *</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-float">
                                    <input type="number" name="sort_order" class="form-control" value="0" placeholder=" ">
                                    <label class="fl-label"><?php echo t('Urutan', 'Sort Order'); ?></label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-float">
                                    <input type="text" name="correct_answer" class="form-control" id="correctAnswer" required placeholder=" ">
                                    <label class="fl-label"><?php echo t('Jawaban Benar', 'Correct Answer'); ?> *</label>
                                </div>
                                <small class="field-hint" id="correctAnswerHelp"><?php echo t('Isi dengan jawaban yang benar', 'Fill with the correct answer'); ?></small>
                            </div>
                        </div>
                        <div id="optionsSection">
                            <div class="form-float">
                                <textarea name="options_text" rows="5" class="form-control" placeholder="A. Pilihan 1&#10;B. Pilihan 2&#10;C. Pilihan 3&#10;D. Pilihan 4">A. 
B. 
C. 
D. </textarea>
                                <label class="fl-label"><?php echo t('Pilihan Jawaban', 'Answer Choices'); ?></label>
                            </div>
                            <small class="field-hint"><?php echo t('Tulis satu pilihan per baris.', 'Write one option per line.'); ?></small>
                        </div>
                    </div>
                    <div class="form-footer-sticky">
                        <button type="submit" class="btn btn-dark rounded-pill px-4 py-2 fw-semibold d-flex align-items-center gap-1">
                            <i data-lucide="check" style="width:16px;height:16px;"></i> <?php echo t('Simpan Soal', 'Save Question'); ?>
                        </button>
                        <a href="<?php echo base_url('quiz/admin_questions/' . $quiz->id); ?>" class="btn btn-outline-secondary rounded-pill px-4 py-2 fw-semibold"><?php echo t('Batal', 'Cancel'); ?></a>
                    </div>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var typeSelect = document.getElementById('questionType');
    var optionsSection = document.getElementById('optionsSection');
    var correctAnswer = document.getElementById('correctAnswer');
    var correctHelp = document.getElementById('correctAnswerHelp');

    function toggleFields() {
        if (typeSelect.value === 'true_false') {
            optionsSection.style.display = 'none';
            correctAnswer.value = 'True';
            correctHelp.textContent = '<?php echo t('Pilih True atau False', 'Choose True or False'); ?>';
        } else if (typeSelect.value === 'multiple_choice') {
            optionsSection.style.display = 'block';
            correctHelp.textContent = '<?php echo t('Isi dengan jawaban yang benar (salah satu pilihan di atas)', 'Fill with the correct answer (one of the options above)'); ?>';
        } else if (typeSelect.value === 'short_answer') {
            optionsSection.style.display = 'none';
            correctHelp.textContent = '<?php echo t('Isi dengan jawaban singkat yang benar', 'Fill with the correct short answer'); ?>';
        } else {
            optionsSection.style.display = 'none';
            correctHelp.textContent = '<?php echo t('Esai akan dinilai manual oleh pengajar', 'Essay will be graded manually by the instructor'); ?>';
        }
    }

    typeSelect.addEventListener('change', toggleFields);
    toggleFields();
});
</script>
