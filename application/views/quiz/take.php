<div class="container py-5 my-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 p-4 p-xl-5 animate-scale-in">
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3 mb-5">
                    <div>
                        <nav aria-label="breadcrumb" class="mb-2">
                            <ol class="breadcrumb small mb-0">
                                <li class="breadcrumb-item"><a href="<?php echo base_url('courses/detail/' . $quiz->course_slug); ?>" class="text-primary text-decoration-none fw-medium">Kembali</a></li>
                                <li class="breadcrumb-item active fw-medium text-dark">Quiz</li>
                            </ol>
                        </nav>
                        <h4 class="fw-extrabold text-dark mb-1" style="letter-spacing: -0.03em;"><?php echo htmlspecialchars($quiz->title); ?></h4>
                        <p class="text-secondary small mb-0"><?php echo count($questions); ?> <?php echo t('soal', 'questions'); ?> <?php if ($quiz->max_attempts > 0): ?>· <?php echo $quiz->max_attempts; ?>x <?php echo t('percobaan', 'attempts'); ?><?php endif; ?></p>
                    </div>
                    <?php if ($quiz->time_limit > 0): ?>
                        <div class="bg-dark text-white rounded-pill px-4 py-2 small fw-bold shadow-sm flex-shrink-0" id="quizTimer">
                            <i class="far fa-clock me-1"></i> <span id="timeDisplay"><?php echo $quiz->time_limit; ?>:00</span>
                        </div>
                    <?php endif; ?>
                </div>

                <?php echo form_open('quiz/submit/' . $attempt->id, array('id' => 'quizForm')); ?>
                    <?php foreach ($questions as $i => $q): ?>
                        <div class="card border-0 shadow-sm rounded-4 p-4 p-xl-5 mb-4 question-card" data-qid="<?php echo $q->id; ?>" style="transition: all 0.2s;">
                            <div class="d-flex gap-3 mb-4">
                                <span class="d-flex align-items-center justify-content-center bg-dark text-white rounded-circle fw-bold flex-shrink-0" style="width: 32px; height: 32px; font-size: 0.875rem;"><?php echo $i + 1; ?></span>
                                <div>
                                    <p class="fw-semibold text-dark mb-1"><?php echo htmlspecialchars($q->question); ?></p>
                                    <?php if ($q->question_en): ?><p class="text-secondary small mb-1"><?php echo htmlspecialchars($q->question_en); ?></p><?php endif; ?>
                                    <p class="text-secondary small mb-0"><?php echo $q->points; ?> <?php echo t('poin', 'point(s)'); ?></p>
                                </div>
                            </div>

                            <?php if ($q->question_type === 'multiple_choice' && $q->options): ?>
                                <?php $options = json_decode($q->options, true); ?>
                                <div class="ms-5 d-flex flex-column gap-2">
                                    <?php foreach ($options as $j => $opt): ?>
                                        <label class="d-flex align-items-center gap-3 p-3 rounded-3 border option-label cursor-pointer bg-light" style="transition: all 0.2s;">
                                            <input type="radio" name="q_<?php echo $q->id; ?>" value="<?php echo htmlspecialchars($opt); ?>" class="form-check-input mt-0" required>
                                            <span class="small text-dark"><?php echo htmlspecialchars($opt); ?></span>
                                        </label>
                                    <?php endforeach; ?>
                                </div>
                            <?php elseif ($q->question_type === 'true_false'): ?>
                                <div class="ms-5 d-flex gap-3">
                                    <label class="d-flex align-items-center gap-2 p-3 rounded-3 border option-label cursor-pointer flex-fill bg-light" style="transition: all 0.2s;">
                                        <input type="radio" name="q_<?php echo $q->id; ?>" value="True" required>
                                        <span class="small fw-semibold text-success"><i class="fas fa-check-circle me-1"></i> True</span>
                                    </label>
                                    <label class="d-flex align-items-center gap-2 p-3 rounded-3 border option-label cursor-pointer flex-fill bg-light" style="transition: all 0.2s;">
                                        <input type="radio" name="q_<?php echo $q->id; ?>" value="False" required>
                                        <span class="small fw-semibold text-danger"><i class="fas fa-times-circle me-1"></i> False</span>
                                    </label>
                                </div>
                            <?php elseif ($q->question_type === 'short_answer'): ?>
                                <div class="ms-5">
                                    <input type="text" name="q_<?php echo $q->id; ?>" class="form-control rounded-pill" placeholder="<?php echo t('Tulis jawaban...', 'Type your answer...'); ?>" required>
                                </div>
                            <?php elseif ($q->question_type === 'essay'): ?>
                                <div class="ms-5">
                                    <textarea name="q_<?php echo $q->id; ?>" rows="4" class="form-control" placeholder="<?php echo t('Tulis jawaban esai...', 'Type your essay answer...'); ?>"></textarea>
                                    <small class="text-secondary"><?php echo t('Esai akan dinilai oleh pengajar', 'Essay will be graded by instructor'); ?></small>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>

                    <div class="text-center mt-4">
                        <button type="submit" class="btn btn-dark rounded-pill px-5 py-3 fw-semibold shadow-lg" id="submitQuizBtn">
                            <i class="fas fa-check-circle me-2"></i> <?php echo t('Kumpulkan Jawaban', 'Submit Answers'); ?>
                        </button>
                    </div>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
</div>

<style>
.option-label:hover { border-color: #0D1830 !important; background: #f1f5f9 !important; }
.option-label:has(input:checked) { border-color: #0D1830 !important; background: #e2e8f0 !important; }
</style>

<script>
// Quiz Timer - Countdown with auto-submit
<?php if ($quiz->time_limit > 0 && $attempt->started_at): ?>
(function() {
    var startTime = new Date("<?php echo $attempt->started_at; ?>").getTime();
    var timeLimit = <?php echo $quiz->time_limit; ?> * 60 * 1000;
    var endTime = startTime + timeLimit;
    var timerDisplay = document.getElementById('timeDisplay');
    var timerContainer = document.getElementById('quizTimer');
    
    function updateTimer() {
        var now = new Date().getTime();
        var remaining = endTime - now;
        
        if (remaining <= 0) {
            clearInterval(timerInterval);
            timerDisplay.textContent = '00:00';
            timerContainer.className = 'bg-danger text-white rounded-pill px-4 py-2 small fw-bold shadow-sm flex-shrink-0';
            // Auto-submit
            if (confirm('<?php echo t('Waktu habis! Kumpulkan jawaban?', 'Time is up! Submit your answers?'); ?>')) {
                document.getElementById('quizForm').submit();
            }
            return;
        }
        
        var minutes = Math.floor(remaining / 60000);
        var seconds = Math.floor((remaining % 60000) / 1000);
        timerDisplay.textContent = minutes + ':' + (seconds < 10 ? '0' : '') + seconds;
        
        // Warning at 5 minutes
        if (remaining <= 300000) {
            timerContainer.className = 'bg-warning text-dark rounded-pill px-4 py-2 small fw-bold shadow-sm flex-shrink-0';
        }
    }
    
    var timerInterval = setInterval(updateTimer, 1000);
    updateTimer();
})();
<?php endif; ?>
</script>
