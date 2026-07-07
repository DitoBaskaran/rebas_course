<div class="container py-5 my-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 p-4 p-xl-5 text-center animate-scale-in">
                <?php if ($passed): ?>
                    <div class="d-inline-flex align-items-center justify-content-center bg-success-subtle text-success rounded-circle mb-4 shadow-sm" style="width: 72px; height: 72px;">
                        <i class="fas fa-check-circle fa-2x"></i>
                    </div>
                    <h3 class="fw-extrabold text-dark mb-2" style="letter-spacing: -0.03em;"><?php echo t('Selamat, Anda Lulus!', 'Congratulations, You Passed!'); ?></h3>
                <?php else: ?>
                    <div class="d-inline-flex align-items-center justify-content-center bg-danger-subtle text-danger rounded-circle mb-4 shadow-sm" style="width: 72px; height: 72px;">
                        <i class="fas fa-times-circle fa-2x"></i>
                    </div>
                    <h3 class="fw-extrabold text-dark mb-2" style="letter-spacing: -0.03em;"><?php echo t('Belum Lulus', 'Not Passed'); ?></h3>
                <?php endif; ?>
                <p class="text-secondary mb-4"><?php echo htmlspecialchars($quiz->title); ?></p>

                <div class="d-flex justify-content-center gap-5 mb-5 p-4 bg-light rounded-4">
                    <div class="text-center">
                        <h2 class="fw-black <?php echo $passed ? 'text-success' : 'text-danger'; ?> mb-0" style="font-size: 2.5rem;"><?php echo $pct; ?>%</h2>
                        <small class="text-secondary fw-medium"><?php echo t('Nilai', 'Score'); ?></small>
                    </div>
                    <div class="text-center">
                        <h2 class="fw-black text-dark mb-0" style="font-size: 2.5rem;"><?php echo $attempt->score; ?>/<?php echo $attempt->total_points; ?></h2>
                        <small class="text-secondary fw-medium"><?php echo t('Poin', 'Points'); ?></small>
                    </div>
                    <div class="text-center">
                        <h2 class="fw-black text-dark mb-0" style="font-size: 2.5rem;"><?php echo $quiz->passing_score; ?>%</h2>
                        <small class="text-secondary fw-medium"><?php echo t('Minimal Lulus', 'Passing Score'); ?></small>
                    </div>
                </div>

                <div class="text-start mt-4">
                    <h6 class="fw-bold text-dark mb-4 d-flex align-items-center gap-2">
                        <span class="icon-28 bg-primary-subtle text-primary rounded-2 d-inline-flex align-items-center justify-content-center"><i class="fas fa-list-check"></i></span>
                        <span><?php echo t('Detail Jawaban', 'Answer Details'); ?></span>
                    </h6>
                    <?php foreach ($questions as $i => $q): ?>
                        <?php $is_correct = (isset($answers['q_' . $q->id]) && $answers['q_' . $q->id] == $q->correct_answer); ?>
                        <div class="p-4 rounded-4 mb-3 border-start border-4 <?php echo $is_correct ? 'border-success bg-success-subtle' : 'border-danger bg-danger-subtle'; ?>">
                            <p class="small fw-semibold text-dark mb-2"><?php echo ($i + 1) . '. ' . htmlspecialchars($q->question); ?></p>
                            <p class="small mb-0">
                                <?php echo t('Jawaban: ', 'Answer: '); ?>
                                <span class="fw-bold"><?php echo htmlspecialchars($answers['q_' . $q->id] ?? '-'); ?></span>
                                <?php if ($q->type !== 'essay'): ?>
                                    <span class="text-success ms-2 fw-medium">(<?php echo t('Benar: ', 'Correct: '); ?><?php echo htmlspecialchars($q->correct_answer); ?>)</span>
                                <?php endif; ?>
                            </p>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div class="d-flex justify-content-center gap-3 pt-4 mt-4 border-top border-light">
                    <a href="<?php echo base_url('courses/detail/' . $quiz->course_id); ?>" class="btn btn-dark rounded-pill px-5 py-2 fw-semibold"><?php echo t('Kembali ke Kelas', 'Back to Course'); ?></a>
                </div>
            </div>
        </div>
    </div>
</div>
