<div class="container-fluid py-4" style="padding-top: 0px !important; max-width: 900px;">

    <!-- ===== HERO / JUDUL HALAMAN ===== -->
    <div class="mb-4">
        <div class="d-flex flex-wrap align-items-center gap-3 justify-content-between">
            <div>
                <div class="d-flex align-items-center gap-2 mb-1">
                    <span class="fw-semibold rounded-pill px-2 py-0" style="background:#E0F2F1; color:#009688; font-size:0.62rem; letter-spacing:0.03em; text-transform:uppercase;"><?php echo htmlspecialchars(t($course->title, $course->title_en ?? $course->title)); ?></span>
                </div>
                <h4 class="fw-extrabold mb-0" style="color:#0D1830; letter-spacing:-0.02em; font-size:1.3rem;"><?php echo t('Forum Diskusi', 'Discussion Forum'); ?></h4>
                <div class="d-flex align-items-center gap-3 mt-1" style="color:#a8a29e; font-size:0.72rem;">
                    <span class="d-inline-flex align-items-center gap-1"><i class="fas fa-comment-dots"></i> <strong style="color:#57534e;"><?php echo count($discussions); ?></strong> <?php echo t('topik', 'topics'); ?></span>
                    <a href="<?php echo base_url('courses/detail/' . $course->slug); ?>" class="text-decoration-none d-inline-flex align-items-center gap-1" style="color:#009688; font-weight:600;"><i class="fas fa-arrow-left"></i> <?php echo t('Ke Kelas', 'Back to Course'); ?></a>
                </div>
            </div>
            <a href="<?php echo base_url('forum/create/' . $course->slug); ?>" class="btn fw-bold rounded-pill px-4 py-2 shadow-sm flex-shrink-0" style="background:#0D1830; color:#fff; font-size:0.8rem;">
                <i class="fas fa-plus me-1" style="font-size:0.7rem;"></i> <?php echo t('Diskusi Baru', 'New Discussion'); ?>
            </a>
        </div>
    </div>

    <?php if (empty($discussions)): ?>
        <div class="mob-empty" style="background:#fff; border:1px solid #f0eeeb; border-radius:16px; padding:2.6rem 1rem;">
            <i class="fas fa-comment-dots"></i>
            <p style="font-size:0.85rem; font-weight:600; color:#0D1830;"><?php echo t('Belum Ada Diskusi', 'No Discussions Yet'); ?></p>
            <p style="max-width:300px; margin:0 auto 0.9rem;"><?php echo t('Belum ada diskusi. Jadilah yang pertama!', 'No discussions yet. Be the first!'); ?></p>
            <a href="<?php echo base_url('forum/create/' . $course->slug); ?>" class="btn fw-semibold rounded-pill px-4 py-2" style="background:#009688; color:#fff; font-size:0.8rem;"><i class="fas fa-plus me-1" style="font-size:0.65rem;"></i> <?php echo t('Buat Diskusi', 'Create Discussion'); ?></a>
        </div>
    <?php else: ?>
        <!-- ===== DAFTAR DISKUSI: 1 kolom (mobile & desktop, panel student) ===== -->
        <div class="d-flex flex-column gap-3">
            <?php foreach ($discussions as $i => $d):
                $fg = $i % 6;
                $f_grads = array(
                    'linear-gradient(135deg,#0D1830,#009688)',
                    'linear-gradient(135deg,#2563eb,#38bdf8)',
                    'linear-gradient(135deg,#c026d3,#f472b6)',
                    'linear-gradient(135deg,#ea580c,#fbbf24)',
                    'linear-gradient(135deg,#0d9488,#2dd4bf)',
                    'linear-gradient(135deg,#7c3aed,#a78bfa)'
                );
            ?>
            <a href="<?php echo base_url('forum/view/' . encode_id($d->id)); ?>" class="text-decoration-none" style="display:block;">
                <div class="bg-white rounded-4 border p-3" style="border-color:#f0eeeb !important; box-shadow:0 1px 4px rgba(0,0,0,0.03); transition: box-shadow .15s ease, transform .15s ease;" onmouseover="this.style.boxShadow='0 6px 20px rgba(13,24,48,0.08)'; this.style.transform='translateY(-1px)';" onmouseout="this.style.boxShadow=''; this.style.transform='';">
                    <div class="d-flex align-items-start gap-3">
                        <div class="rounded-3 flex-shrink-0 d-flex align-items-center justify-content-center position-relative" style="width:44px; height:44px; background:<?php echo $f_grads[$fg]; ?>; color:#fff; font-weight:800; font-size:0.95rem;">
                            <?php $dthumb = !empty($d->thumbnail) && $d->thumbnail !== 'default_course.png' && file_exists(FCPATH . 'uploads/courses/' . $d->thumbnail); ?>
                            <?php if ($dthumb): ?>
                                <img src="<?php echo base_url('uploads/courses/' . $d->thumbnail); ?>" alt="" class="w-100 h-100 rounded-3" style="object-fit:cover;">
                            <?php else: ?>
                                <i class="fas fa-comments" style="font-size:0.85rem;"></i>
                            <?php endif; ?>
                            <?php if (!empty($d->is_pinned)): ?>
                                <span class="position-absolute d-flex align-items-center justify-content-center rounded-circle" style="top:-5px; right:-5px; width:17px; height:17px; background:#FBBF24; color:#0D1830; font-size:0.5rem; border:2px solid #fff;"><i class="fas fa-thumbtack"></i></span>
                            <?php endif; ?>
                        </div>
                        <div class="flex-fill min-w-0">
                            <div class="fw-bold text-dark" style="font-size:0.85rem; line-height:1.35; display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; overflow:hidden;"><?php echo htmlspecialchars($d->title); ?></div>
                            <div class="d-flex align-items-center gap-2 mt-1" style="color:#a8a29e; font-size:0.7rem;">
                                <span class="d-inline-flex align-items-center gap-1 text-truncate" style="max-width:45%;"><span class="rounded-circle d-inline-flex align-items-center justify-content-center" style="width:16px; height:16px; font-size:0.5rem; font-weight:700; color:#fff; background:linear-gradient(135deg,#0D1830,#009688); flex-shrink:0;"><?php echo strtoupper(substr(trim($d->user_name), 0, 1)); ?></span> <?php echo htmlspecialchars($d->user_name); ?></span>
                                <span class="opacity-50">·</span>
                                <span class="text-truncate"><?php echo time_elapsed($d->created_at); ?></span>
                            </div>
                        </div>
                        <div class="d-flex align-items-center flex-shrink-0 rounded-pill px-2 py-1 gap-1" style="background:#f5f5f4; color:#78716c; font-size:0.68rem; font-weight:700;">
                            <i class="far fa-comment"></i> <?php echo $d->reply_count; ?>
                        </div>
                    </div>
                </div>
            </a>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>
