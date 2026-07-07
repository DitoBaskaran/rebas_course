<div class="container-fluid px-0">
    <div class="d-flex align-items-center gap-2 mb-5">
        <a href="<?php echo base_url('quiz/admin_questions/' . $quiz->id); ?>" class="btn btn-outline-dark btn-sm rounded-circle d-flex align-items-center justify-content-center" style="width:36px;height:36px;"><i data-lucide="arrow-left" style="width:16px;height:16px;"></i></a>
        <div>
            <span class="text-primary fw-semibold small text-uppercase tracking-wide d-block mb-1">Quiz</span>
            <h1 class="display-6 fw-extrabold text-dark mb-0 lh-sm" style="letter-spacing:-0.03em;"><?php echo t('Nilai Essay', 'Grade Essays'); ?>: <?php echo htmlspecialchars($quiz->title); ?></h1>
        </div>
    </div>

    <?php if (empty($attempts)): ?>
        <div class="bento-card text-center py-5">
            <i data-lucide="file-text" style="width:48px;height:48px;color:var(--gray-300);margin-bottom:1rem;"></i>
            <h5><?php echo t('Belum ada attempt.', 'No attempts yet.'); ?></h5>
        </div>
    <?php else: ?>
        <?php foreach ($attempts as $a): ?>
            <?php $answers = json_decode($a->answers, true); ?>
            <div class="bento-card mb-4">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <div>
                        <strong class="text-dark"><?php echo htmlspecialchars($a->user_name); ?></strong>
                        <span class="text-muted small ms-2"><?php echo date('d M Y H:i', strtotime($a->finished_at)); ?></span>
                    </div>
                    <span class="badge bg-primary badge-modern"><?php echo $a->score; ?>/<?php echo $a->total_points; ?></span>
                </div>
                <?php if ($answers): foreach ($answers as $i => $ans): ?>
                    <?php if (isset($ans['type']) && $ans['type'] === 'essay'): ?>
                        <div class="border rounded-3 p-3 mb-2" style="background:var(--gray-50);">
                            <div class="small fw-semibold text-dark mb-2"><?php echo t('Soal', 'Question'); ?> #<?php echo $i + 1; ?></div>
                            <p class="small mb-2"><?php echo htmlspecialchars($ans['question'] ?? '-'); ?></p>
                            <div class="small fw-semibold text-dark mb-1"><?php echo t('Jawaban:', 'Answer:'); ?></div>
                            <p class="small text-muted bg-white rounded-2 p-2 border mb-2"><?php echo nl2br(htmlspecialchars($ans['answer'] ?? '-')); ?></p>
                            <form method="POST" action="<?php echo base_url('admin/save_essay_grade/' . $a->id . '/' . $i); ?>" class="d-flex align-items-center gap-2">
                                <label class="small fw-semibold"><?php echo t('Nilai:', 'Score:'); ?></label>
                                <input type="number" name="score" class="form-control form-control-sm" style="width:80px;" value="<?php echo $ans['essay_score'] ?? $ans['score'] ?? 0; ?>" min="0" max="<?php echo $ans['points'] ?? 100; ?>">
                                <span class="small text-muted">/ <?php echo $ans['points'] ?? 100; ?></span>
                                <button type="submit" class="btn btn-sm btn-primary rounded-pill px-3"><?php echo t('Simpan', 'Save'); ?></button>
                            </form>
                        </div>
                    <?php endif; ?>
                <?php endforeach; endif; ?>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>
