<div class="container-fluid py-4" style="padding-top: 10px !important;">
    <div class="row g-4">
        <!-- Main Content -->
        <div class="col-lg-8">
            <!-- Breadcrumb -->
            <nav aria-label="breadcrumb" class="mb-3 small">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo base_url('courses/detail/' . $course->slug); ?>" class="text-primary text-decoration-none fw-medium"><?php echo htmlspecialchars($course->title); ?></a></li>
                    <li class="breadcrumb-item active fw-medium text-dark">Belajar</li>
                </ol>
            </nav>

            <div class="card border-0 shadow-sm rounded-4 overflow-hidden animate-scale-in">
                <!-- Video Section -->
                <?php if ($active_lesson->lesson_type === 'video' && !empty($active_lesson->video_url)): ?>
                    <div class="ratio ratio-16x9 bg-dark">
                        <?php if (strpos($active_lesson->video_url, 'youtube.com') !== false || strpos($active_lesson->video_url, 'youtu.be') !== false): ?>
                            <?php
                                parse_str(parse_url($active_lesson->video_url, PHP_URL_QUERY), $yt_params);
                                $yt_id = $yt_params['v'] ?? basename($active_lesson->video_url);
                            ?>
                            <iframe src="https://www.youtube.com/embed/<?php echo $yt_id; ?>?autoplay=0&rel=0" allowfullscreen allow="autoplay; encrypted-media"></iframe>
                        <?php elseif (strpos($active_lesson->video_url, 'vimeo.com') !== false): ?>
                            <?php $vm_id = (int) substr(parse_url($active_lesson->video_url, PHP_URL_PATH), 1); ?>
                            <iframe src="https://player.vimeo.com/video/<?php echo $vm_id; ?>" allowfullscreen></iframe>
                        <?php else: ?>
                            <video controls class="w-100 h-100" preload="metadata">
                                <source src="<?php echo $active_lesson->video_url; ?>" type="video/mp4">
                            </video>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>

                <!-- Live Section -->
                <?php if ($active_lesson->lesson_type === 'live_session'): ?>
                    <div class="bg-dark p-5 text-center">
                        <div class="d-inline-flex align-items-center justify-content-center bg-danger rounded-circle mb-4" style="width: 80px; height: 80px;">
                            <i class="fas fa-video text-white fa-2x"></i>
                        </div>
                        <h4 class="text-white fw-bold mb-2"><?php echo t('Sesi Live', 'Live Session'); ?></h4>
                        <p class="text-white-50 mb-4"><?php echo t('Bergabung dengan sesi langsung bersama instruktur', 'Join the live session with your instructor'); ?></p>
                        <?php if (!empty($active_lesson->live_url)): ?>
                            <a href="<?php echo $active_lesson->live_url; ?>" target="_blank" class="btn btn-danger btn-lg rounded-pill px-5 fw-semibold shadow-lg">
                                <i class="fas fa-video me-2"></i> <?php echo t('Bergabung Sekarang', 'Join Now'); ?>
                            </a>
                        <?php else: ?>
                            <div class="text-white-50">
                                <i class="fas fa-clock me-2"></i> <?php echo t('Link meeting akan muncul saat sesi dimulai', 'Meeting link will appear when session starts'); ?>
                            </div>
                        <?php endif; ?>
                        <?php if (!empty($active_lesson->description)): ?>
                            <p class="text-white-50 small mt-4 mb-0"><?php echo htmlspecialchars(t($active_lesson->description, $active_lesson->description_en ?: $active_lesson->description)); ?></p>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>

                <!-- Quiz Section -->
                <?php if ($active_lesson->lesson_type === 'quiz'): ?>
                    <div class="bg-light p-5 text-center">
                        <div class="d-inline-flex align-items-center justify-content-center bg-warning-subtle text-warning rounded-circle mb-4" style="width: 80px; height: 80px;">
                            <i class="fas fa-pencil-alt fa-2x"></i>
                        </div>
                        <h4 class="fw-extrabold text-dark mb-2"><?php echo t('Quiz', 'Quiz'); ?></h4>
                        <p class="text-secondary mb-4"><?php echo t('Uji pemahamanmu tentang materi ini', 'Test your understanding of this material'); ?></p>
                        <?php if (!empty($course_quiz)): ?>
                            <div class="d-inline-flex align-items-center gap-3 mb-4 bg-white rounded-pill px-4 py-2 shadow-sm">
                                <span class="text-dark fw-semibold small"><?php echo htmlspecialchars($course_quiz->title); ?></span>
                                <span class="badge bg-primary-subtle text-primary rounded-pill fw-medium"><?php echo $this->Quiz_model->count_questions($course_quiz->id); ?> <?php echo t('soal', 'questions'); ?></span>
                                <span class="text-secondary small"><?php echo t('Min lulus:', 'Passing:'); ?> <?php echo $course_quiz->passing_score; ?>%</span>
                            </div>
                            <a href="<?php echo base_url('quiz/start/' . encode_id($course_quiz->id)); ?>" class="btn btn-warning btn-lg rounded-pill px-5 fw-semibold shadow-sm">
                                <i class="fas fa-play me-2"></i> <?php echo t('Mulai Quiz', 'Start Quiz'); ?>
                            </a>
                        <?php else: ?>
                            <div class="text-secondary">
                                <i class="fas fa-info-circle me-2"></i> <?php echo t('Belum ada quiz untuk materi ini', 'No quiz for this lesson yet'); ?>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>

                <!-- Assignment Section -->
                <?php if ($active_lesson->lesson_type === 'assignment'): ?>
                    <div class="bg-light p-5 text-center">
                        <div class="d-inline-flex align-items-center justify-content-center bg-success-subtle text-success rounded-circle mb-4" style="width: 80px; height: 80px;">
                            <i class="fas fa-code fa-2x"></i>
                        </div>
                        <h4 class="fw-extrabold text-dark mb-2"><?php echo t('Tugas', 'Assignment'); ?></h4>
                        <p class="text-secondary mb-4"><?php echo t('Kerjakan tugas berikut untuk menguji kemampuan praktikmu', 'Complete the following task to test your practical skills'); ?></p>
                        <?php if (!empty($course_assignment)): ?>
                            <div class="d-inline-flex align-items-center gap-3 mb-4 bg-white rounded-pill px-4 py-2 shadow-sm">
                                <span class="text-dark fw-semibold small"><?php echo htmlspecialchars($course_assignment->title); ?></span>
                                <span class="badge bg-success-subtle text-success rounded-pill fw-medium"><i class="fas fa-file me-1"></i> <?php echo strtoupper($course_assignment->allowed_file_types); ?></span>
                            </div>
                            <a href="<?php echo base_url('assignment/view/' . encode_id($course_assignment->id)); ?>" class="btn btn-success btn-lg rounded-pill px-5 fw-semibold shadow-sm">
                                <i class="fas fa-upload me-2"></i> <?php echo t('Lihat & Kumpulkan', 'View & Submit'); ?>
                            </a>
                        <?php else: ?>
                            <div class="text-secondary">
                                <i class="fas fa-info-circle me-2"></i> <?php echo t('Belum ada tugas untuk materi ini', 'No assignment for this lesson yet'); ?>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>

                <!-- Text Content -->
                <div class="p-4 p-xl-5">
                    <div class="d-flex align-items-center gap-2 mb-3">
                        <span class="badge bg-dark text-white rounded-pill px-3 py-2 fw-medium d-inline-flex align-items-center gap-1">
                <?php
                    if ($active_lesson->lesson_type === 'video') echo t('Video', 'Video');
                    elseif ($active_lesson->lesson_type === 'text') echo t('Teks', 'Text');
                    elseif ($active_lesson->lesson_type === 'quiz') echo t('Quiz', 'Quiz');
                    elseif ($active_lesson->lesson_type === 'assignment') echo t('Tugas', 'Assignment');
                    else echo t('Live', 'Live');
                ?>
                        </span>
            <?php if ($active_lesson->duration > 0): ?>
                <small class="text-secondary"><i class="far fa-clock me-1"></i> <?php echo $active_lesson->duration; ?> <?php echo t('menit', 'min'); ?></small>
            <?php endif; ?>
        </div>

        <h4 class="fw-extrabold text-dark mb-3 lh-sm" style="letter-spacing: -0.03em;"><?php echo htmlspecialchars(t($active_lesson->title, $active_lesson->title_en ?: $active_lesson->title)); ?></h4>

        <?php if ($active_lesson->description): ?>
            <p class="text-secondary mb-4"><?php echo nl2br(htmlspecialchars(t($active_lesson->description, $active_lesson->description_en ?: $active_lesson->description))); ?></p>
        <?php endif; ?>

        <?php if (!empty($active_lesson->content) && $active_lesson->lesson_type === 'text'): ?>
            <div class="bg-light rounded-4 p-4 p-xl-5 mb-4 lesson-content">
                <?php echo t($active_lesson->content, $active_lesson->content_en ?: $active_lesson->content); ?>
            </div>
        <?php endif; ?>

        <!-- Navigation Buttons - Redesigned -->
        <div class="lesson-nav-wrapper mt-4 pt-4 border-top">
            <!-- Complete Button -->
            <div class="text-center mb-4">
                <?php if (in_array($active_lesson->id, $completed_lessons)): ?>
                    <div class="d-inline-flex align-items-center gap-2 px-4 py-3 rounded-pill fw-semibold" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: #fff; font-size: 0.9rem; box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);">
                        <i class="fas fa-check-circle" style="font-size: 1.1rem;"></i>
                        <?php echo t('Materi Selesai', 'Lesson Completed'); ?>
                    </div>
                <?php else: ?>
                    <a href="#" class="lesson-complete-btn d-inline-flex align-items-center gap-2 px-5 py-3 rounded-pill fw-bold text-decoration-none" style="background: linear-gradient(135deg, #eab308 0%, #f59e0b 100%); color: #111827; font-size: 0.95rem; box-shadow: 0 4px 16px rgba(234, 179, 8, 0.4); transition: all 0.3s;" onmouseover="this.style.transform='translateY(-2px)';this.style.boxShadow='0 6px 20px rgba(234, 179, 8, 0.5)'" onmouseout="this.style.transform='';this.style.boxShadow='0 4px 16px rgba(234, 179, 8, 0.4)'" data-lesson-id="<?php echo $active_lesson->id; ?>" data-course-id="<?php echo $course->id; ?>">
                        <i class="fas fa-check-circle" style="font-size: 1.1rem;"></i>
                        <?php echo t('Tandai Selesai', 'Mark Complete'); ?>
                    </a>
                <?php endif; ?>
            </div>

            <!-- Previous/Next Buttons -->
            <div class="d-flex justify-content-between gap-3">
                <?php
                    $prev_id = null;
                    $next_id = null;
                    $found = false;
                    foreach ($lessons as $lesson) {
                        if ($found) { $next_id = $lesson->id; break; }
                        if ($lesson->id == $active_lesson->id) { $found = true; continue; }
                        if (!$found) $prev_id = $lesson->id;
                    }
                ?>
                <?php if ($prev_id): ?>
                    <a href="<?php echo base_url('courses/learn/' . $course->slug . '/' . encode_id($prev_id)); ?>" class="flex-fill text-decoration-none">
                        <div class="d-flex align-items-center gap-3 p-3 rounded-3" style="background: #f9fafb; border: 2px solid #e5e7eb; transition: all 0.2s;" onmouseover="this.style.background='#f3f4f6';this.style.borderColor='#d1d5db'" onmouseout="this.style.background='#f9fafb';this.style.borderColor='#e5e7eb'">
                            <div class="d-flex align-items-center justify-content-center flex-shrink-0" style="width: 40px; height: 40px; border-radius: 50%; background: #e5e7eb;">
                                <i class="fas fa-chevron-left" style="color: #6b7280;"></i>
                            </div>
                            <div class="text-start">
                                <div style="font-size: 0.7rem; color: #9ca3af; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em;"><?php echo t('Sebelumnya', 'Previous'); ?></div>
                                <div style="font-size: 0.85rem; color: #374151; font-weight: 600;"><?php echo t('Materi Sebelumnya', 'Previous Lesson'); ?></div>
                            </div>
                        </div>
                    </a>
                <?php else: ?>
                    <div class="flex-fill"></div>
                <?php endif; ?>

                <?php if ($next_id): ?>
                    <a href="<?php echo base_url('courses/learn/' . $course->slug . '/' . encode_id($next_id)); ?>" class="flex-fill text-decoration-none">
                        <div class="d-flex align-items-center gap-3 p-3 rounded-3" style="background: #f9fafb; border: 2px solid #e5e7eb; transition: all 0.2s;" onmouseover="this.style.background='#f3f4f6';this.style.borderColor='#d1d5db'" onmouseout="this.style.background='#f9fafb';this.style.borderColor='#e5e7eb'">
                            <div class="text-end flex-grow-1">
                                <div style="font-size: 0.7rem; color: #9ca3af; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em;"><?php echo t('Selanjutnya', 'Next'); ?></div>
                                <div style="font-size: 0.85rem; color: #374151; font-weight: 600;"><?php echo t('Materi Selanjutnya', 'Next Lesson'); ?></div>
                            </div>
                            <div class="d-flex align-items-center justify-content-center flex-shrink-0" style="width: 40px; height: 40px; border-radius: 50%; background: #e5e7eb;">
                                <i class="fas fa-chevron-right" style="color: #6b7280;"></i>
                            </div>
                        </div>
                    </a>
                <?php else: ?>
                    <div class="flex-fill"></div>
                <?php endif; ?>
            </div>
        </div>

        <script>
        // Force reload when navigating back (bfcache fix)
        window.addEventListener('pageshow', function(event) {
            if (event.persisted || performance.navigation.type === 2) {
                window.location.reload(true);
            }
        });

        document.addEventListener('DOMContentLoaded', function() {
            const completeBtn = document.querySelector('.lesson-complete-btn');
            if (!completeBtn) return;

            completeBtn.addEventListener('click', function(e) {
                e.preventDefault();
                const lessonId = this.getAttribute('data-lesson-id');
                const courseId = this.getAttribute('data-course-id');
                const btn = this;
                const originalText = btn.innerHTML;

                // Disable button and show loading
                btn.disabled = true;
                btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> Sedang memproses...';

                const formData = new FormData();
                formData.append('lesson_id', lessonId);
                formData.append('course_id', courseId);
                formData.append('csrf_test_name', '<?php echo $this->security->get_csrf_hash(); ?>');

                fetch('<?php echo base_url('courses/ajax_complete_lesson'); ?>', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    console.log('Complete lesson response:', data);
                    if (data.ok) {
                        // Update button to success state
                        btn.classList.remove('btn-dark');
                        btn.classList.add('btn-success');
                        btn.innerHTML = '<i class="fas fa-check me-2"></i> Selesai!';
                        
                        // Update progress bar if exists
                        const progressBar = document.getElementById('progress-bar');
                        const progressText = document.getElementById('progress-text');
                        if (progressBar && progressText) {
                            progressBar.style.width = data.pct + '%';
                            progressText.textContent = data.pct + '%';
                        }
                        
                        // Show certificate message if exists
                        if (data.cert_msg) {
                            const certDiv = document.getElementById('cert-message');
                            if (certDiv) {
                                certDiv.style.display = 'block';
                                certDiv.textContent = data.cert_msg;
                            }
                        }
                        
                        // Auto-redirect to next lesson or detail page
                        setTimeout(function() {
                            if (data.next_lesson_encoded) {
                                window.location.href = '<?php echo base_url('courses/learn/' . $course->slug . '/'); ?>' + data.next_lesson_encoded;
                            } else {
                                window.location.href = '<?php echo base_url('courses/detail/' . $course->slug); ?>';
                            }
                        }, 1500);
                    } else {
                        Swal.fire('Error!', data.msg, 'error');
                        btn.disabled = false;
                        btn.innerHTML = originalText;
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire('Error!', 'Terjadi kesalahan. Silakan coba lagi.', 'error');
                    btn.disabled = false;
                    btn.innerHTML = originalText;
                });
            });
        });
        </script>
                </div>
            </div>
        </div>

        <!-- Sidebar - Playlist -->
        <div class="col-lg-4 animate-fade-in-up">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden sticky-top" style="top: 90px;">
                <div class="p-3 p-xl-4 border-bottom bg-light">
                    <h6 class="fw-bold text-dark mb-1"><?php echo htmlspecialchars($course->title); ?></h6>
                    <?php if ($course->duration_total > 0): ?>
                        <small class="text-secondary"><?php echo count($lessons); ?> <?php echo t('materi', 'lessons'); ?> · <?php echo $course->duration_total; ?> <?php echo t('menit', 'min'); ?></small>
                    <?php endif; ?>
                </div>
                <div class="scroll-area" style="max-height: 500px; overflow-y: auto;">
                    <?php foreach ($lessons as $i => $lesson): ?>
                        <a href="<?php echo base_url('courses/learn/' . $course->slug . '/' . encode_id($lesson->id)); ?>" class="text-decoration-none d-flex align-items-center gap-3 p-3 p-xl-4 border-bottom border-light <?php echo $lesson->id == $active_lesson->id ? 'bg-primary-subtle' : 'bg-white'; ?>" style="transition: all 0.15s ease;">
                            <div class="d-flex align-items-center justify-content-center rounded-circle flex-shrink-0 fw-bold" style="width: 32px; height: 32px; font-size: 0.75rem; <?php echo in_array($lesson->id, $completed_lessons) ? 'background: #d1fae5; color: #059669;' : ($lesson->id == $active_lesson->id ? 'background: #0f172a; color: #fff;' : 'background: #f1f5f9; color: #64748b;'); ?>">
                                <?php if (in_array($lesson->id, $completed_lessons)): ?>
                                    <i class="fas fa-check"></i>
                                <?php elseif ($lesson->id == $active_lesson->id): ?>
                                    <i class="fas fa-play"></i>
                                <?php else: ?>
                                    <?php echo $i + 1; ?>
                                <?php endif; ?>
                            </div>
                            <div class="flex-fill min-w-0">
                                <p class="fw-semibold small mb-0 text-truncate" style="color: <?php echo $lesson->id == $active_lesson->id ? '#0f172a' : '#1e293b'; ?>;">
                                    <?php echo htmlspecialchars(t($lesson->title, $lesson->title_en ?: $lesson->title)); ?>
                                </p>
                                <div class="d-flex align-items-center gap-2">
                                    <small class="text-secondary"><?php echo $lesson->duration > 0 ? $lesson->duration . ' ' . t('menit', 'min') : ''; ?></small>
                                    <small class="text-secondary-50">
                                        <?php if ($lesson->lesson_type === 'video'): ?><i class="fas fa-play-circle"></i>
                                        <?php elseif ($lesson->lesson_type === 'text'): ?><i class="fas fa-file-alt"></i>
                                        <?php elseif ($lesson->lesson_type === 'quiz'): ?><i class="fas fa-pencil-alt"></i>
                                        <?php elseif ($lesson->lesson_type === 'assignment'): ?><i class="fas fa-code"></i>
                                        <?php else: ?><i class="fas fa-video"></i><?php endif; ?>
                                    </small>
                                </div>
                            </div>
                        </a>
                    <?php endforeach; ?>
                </div>
                <div class="p-3 p-xl-4 border-top bg-light">
                    <?php $pct = $progress_pct; ?>
                    <div class="d-flex justify-content-between small mb-1">
                        <span class="text-dark fw-semibold"><?php echo t('Progress', 'Progress'); ?></span>
                        <span class="fw-bold text-dark"><?php echo $pct; ?>%</span>
                    </div>
                    <div class="progress" style="height: 6px; border-radius: 100px; background: #e2e8f0;">
                        <div class="progress-bar bg-dark rounded-pill" style="width: <?php echo $pct; ?>%; transition: width 0.5s ease;"></div>
                    </div>
                    <div class="text-center mt-3">
                        <a href="<?php echo base_url('courses/detail/' . $course->slug); ?>" class="text-primary small fw-medium text-decoration-none">
                            <i class="fas fa-arrow-left me-1"></i> <?php echo t('Kembali ke Detail', 'Back to Detail'); ?>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Style for rich text content -->
<script>

