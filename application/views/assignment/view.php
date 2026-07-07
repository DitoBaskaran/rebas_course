<div class="container py-5 my-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <nav aria-label="breadcrumb" class="mb-4 animate-fade-in-up">
                <ol class="breadcrumb small mb-0">
                    <li class="breadcrumb-item"><a href="<?php echo base_url('courses/detail/' . $course->slug); ?>" class="text-primary text-decoration-none fw-medium"><?php echo htmlspecialchars($course->title); ?></a></li>
                    <li class="breadcrumb-item active fw-medium text-dark"><?php echo htmlspecialchars($assignment->title); ?></li>
                </ol>
            </nav>

            <div class="card border-0 shadow-sm rounded-4 p-4 p-xl-5 animate-scale-in">
                <h4 class="fw-extrabold text-dark mb-2" style="letter-spacing: -0.03em;"><?php echo htmlspecialchars($assignment->title); ?></h4>
                <p class="text-secondary small mb-4"><?php echo nl2br(htmlspecialchars($assignment->description)); ?></p>

                <?php if (!empty($assignment->instructions)): ?>
                    <div class="bg-light rounded-4 p-4 mb-4">
                        <h6 class="fw-bold text-dark mb-2 d-flex align-items-center gap-2">
                            <span class="d-inline-flex align-items-center justify-content-center bg-primary-subtle text-primary rounded-2" style="width: 24px; height: 24px;"><i class="fas fa-list fa-xs"></i></span>
                            <?php echo t('Instruksi', 'Instructions'); ?>
                        </h6>
                        <div class="small text-secondary mb-0 lesson-content"><?php echo $assignment->instructions; ?></div>
                    </div>
                <?php endif; ?>

                <div class="d-flex gap-2 flex-wrap mb-4">
                    <span class="badge bg-primary-subtle text-primary rounded-pill px-3 py-2 fw-medium"><i class="far fa-calendar-alt me-1"></i> <?php echo $assignment->due_days; ?> <?php echo t('hari', 'days'); ?></span>
                    <span class="badge bg-warning-subtle text-warning rounded-pill px-3 py-2 fw-medium"><i class="fas fa-file me-1"></i> <?php echo strtoupper($assignment->allowed_file_types ?: 'text'); ?></span>
                    <span class="badge bg-info-subtle text-info rounded-pill px-3 py-2 fw-medium"><i class="fas fa-weight me-1"></i> <?php echo $assignment->max_file_size > 1024 ? round($assignment->max_file_size/1024, 1) . ' MB' : $assignment->max_file_size . ' KB'; ?></span>
                </div>

                <?php if ($submission): ?>
                    <div class="alert <?php echo $submission->status === 'graded' ? 'alert-success' : ($submission->status === 'returned' ? 'alert-warning' : 'alert-info'); ?> border-0 rounded-4 d-flex align-items-center gap-3 py-3 px-4">
                        <i class="fas fa-info-circle fa-lg"></i>
                        <div>
                            <?php if ($submission->status === 'graded'): ?>
                                <span class="fw-bold"><?php echo t('Sudah dinilai: ', 'Graded: '); ?><?php echo $submission->grade; ?>/100</span>
                                <?php if ($submission->feedback): ?>
                                    <br><small><?php echo t('Feedback: ', 'Feedback: '); ?><?php echo nl2br(htmlspecialchars($submission->feedback)); ?></small>
                                <?php endif; ?>
                            <?php elseif ($submission->status === 'returned'): ?>
                                <?php echo t('Dikembalikan, silakan upload ulang.', 'Returned, please resubmit.'); ?>
                                <?php if ($submission->feedback): ?><br><small><?php echo t('Alasan: ', 'Reason: '); ?><?php echo htmlspecialchars($submission->feedback); ?></small><?php endif; ?>
                            <?php else: ?>
                                <?php echo t('Tugas sudah dikumpulkan.', 'Assignment submitted.'); ?>
                                <?php if ($submission->file_url): ?><br><small><i class="fas fa-paperclip me-1"></i> <?php echo $submission->file_url; ?></small><?php endif; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endif; ?>

                <?php if (!$submission || $submission->status === 'returned'): ?>
                    <?php echo form_open_multipart('assignment/submit/' . $assignment->id, array('class' => 'd-flex flex-column gap-3 mt-4', 'id' => 'assignmentForm')); ?>
                        
                        <!-- Tab style: File Upload OR Online Text -->
                        <div class="d-flex gap-2 mb-3">
                            <button type="button" class="btn btn-sm rounded-pill fw-semibold btn-dark" id="tabFile" onclick="switchTab('file')"><?php echo t('Upload File', 'Upload File'); ?></button>
                            <button type="button" class="btn btn-sm rounded-pill fw-semibold btn-outline-secondary" id="tabText" onclick="switchTab('text')"><?php echo t('Teks Online', 'Online Text'); ?></button>
                        </div>

                        <div id="fileSection">
                            <label class="form-label small fw-bold text-dark"><?php echo t('Pilih File', 'Choose File'); ?></label>
                            <input type="file" name="submission_file" class="form-control rounded-pill" id="fileInput">
                            <small class="text-secondary"><?php echo t('Format: ', 'Format: '); ?><?php echo $assignment->allowed_file_types; ?></small>
                        </div>

                        <div id="textSection" class="d-none">
                            <label class="form-label small fw-bold text-dark"><?php echo t('Tulis Jawaban', 'Write Your Answer'); ?></label>
                            <textarea name="text_body" rows="8" class="form-control tinymce" placeholder="<?php echo t('Tulis jawaban tugas di sini...', 'Write your assignment answer here...'); ?>"></textarea>
                            <small class="text-secondary"><?php echo t('Anda bisa menulis jawaban langsung di sini dengan format rich text.', 'You can write your answer directly here with rich text format.'); ?></small>
                        </div>

                        <div>
                            <label class="form-label small fw-bold text-dark"><?php echo t('Catatan (opsional)', 'Notes (optional)'); ?></label>
                            <textarea name="notes" rows="2" class="form-control" placeholder="<?php echo t('Tambahkan catatan...', 'Add notes...'); ?>"></textarea>
                        </div>

                        <button type="submit" class="btn btn-dark rounded-pill px-4 py-2 fw-semibold align-self-start shadow-sm">
                            <i class="fas fa-upload me-2"></i> <?php echo t('Kumpulkan Tugas', 'Submit Assignment'); ?>
                        </button>
                    <?php echo form_close(); ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<script>
function switchTab(tab) {
    var fileSection = document.getElementById('fileSection');
    var textSection = document.getElementById('textSection');
    var tabFile = document.getElementById('tabFile');
    var tabText = document.getElementById('tabText');
    
    if (tab === 'file') {
        fileSection.classList.remove('d-none');
        textSection.classList.add('d-none');
        tabFile.className = 'btn btn-sm rounded-pill fw-semibold btn-dark';
        tabText.className = 'btn btn-sm rounded-pill fw-semibold btn-outline-secondary';
        document.getElementById('fileInput').required = true;
        document.querySelector('[name="text_body"]').required = false;
    } else {
        fileSection.classList.add('d-none');
        textSection.classList.remove('d-none');
        tabFile.className = 'btn btn-sm rounded-pill fw-semibold btn-outline-secondary';
        tabText.className = 'btn btn-sm rounded-pill fw-semibold btn-dark';
        document.getElementById('fileInput').required = false;
        document.querySelector('[name="text_body"]').required = true;
    }
}
</script>

<!-- Reuse lesson content styles for instructions -->
<style>
.lesson-content { line-height: 1.8; color: #1e293b; font-size: 0.9375rem; }
.lesson-content p { margin-bottom: 1rem; }
.lesson-content img { max-width: 100%; height: auto; border-radius: 0.5rem; margin: 1rem 0; }
.lesson-content ul, .lesson-content ol { margin-bottom: 1rem; padding-left: 1.5rem; }
.lesson-content pre { background: #0f172a; color: #e2e8f0; padding: 1rem; border-radius: 0.5rem; overflow-x: auto; margin: 1rem 0; }
.lesson-content code { background: #f1f5f9; padding: 0.2rem 0.4rem; border-radius: 0.25rem; font-size: 0.875rem; }
</style>
