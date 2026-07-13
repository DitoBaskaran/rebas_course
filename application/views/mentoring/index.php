<div>
    <div class="row mb-5 animate-fade-in-up text-center">
        <div class="col-lg-8 mx-auto">
            <span class="text-primary fw-semibold small text-uppercase tracking-wide d-block mb-2">Bimbingan Ahli</span>
            <h1 class="display-5 fw-extrabold text-dark mb-3 lh-sm" style="letter-spacing: -0.03em;"><?php echo t('Mentoring & Konsultasi', 'Mentoring & Consultation'); ?></h1>
            <p class="text-secondary lead mb-0" style="font-size: 1.1rem;"><?php echo t('Belajar 1-on-1 dengan mentor ahli di bidangnya.', 'Learn 1-on-1 with expert mentors in their field.'); ?></p>
        </div>
    </div>

    <div class="row g-4 justify-content-center">
        <?php if (empty($mentors)): ?>
            <div class="col-12">
                <div class="text-center py-5">
                    <div class="icon-64 bg-light rounded-circle mx-auto mb-4 d-flex align-items-center justify-content-center">
                        <i class="fas fa-chalkboard-teacher fs-3 text-secondary"></i>
                    </div>
                    <h5 class="fw-bold text-dark"><?php echo t('Belum Ada Mentor', 'No Mentors Available'); ?></h5>
                    <p class="text-secondary small mb-0"><?php echo t('Mentor akan segera bergabung. Pantau terus!', 'Mentors will be available soon. Stay tuned!'); ?></p>
                </div>
            </div>
        <?php else: ?>
            <?php $loop = 0; ?>
            <?php foreach ($mentors as $mentor): ?>
                <?php $loop++; ?>
                <div class="col-md-6 col-lg-4 animate-fade-in-up stagger-<?php echo min($loop, 5); ?>">
                    <div class="card h-100 border-0 shadow-sm rounded-4 bg-white overflow-hidden hover-zoom d-flex flex-column text-center" style="transition: all 0.3s ease;">
                        <div class="p-4 p-xl-5 d-flex flex-column align-items-center">
                            <div class="position-relative mb-4">
                                <img src="<?php echo base_url('uploads/avatars/' . ($mentor->avatar ?: 'default_avatar.png')); ?>" onerror="this.src='https://ui-avatars.com/api/?name=<?php echo urlencode($mentor->name); ?>&background=4361ee&color=fff&size=96';" alt="" class="rounded-circle object-fit-cover shadow-sm border border-3 border-white" style="width: 96px; height: 96px;">
                                <span class="position-absolute bottom-0 end-0 bg-success border border-2 border-white rounded-circle p-1"></span>
                            </div>
                            <h5 class="fw-bold text-dark mb-1"><?php echo htmlspecialchars($mentor->name); ?></h5>
                            <?php if ($mentor->bio): ?>
                                <p class="text-secondary small mb-4 flex-grow-1" style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;"><?php echo htmlspecialchars($mentor->bio); ?></p>
                            <?php endif; ?>
                            <div class="mt-auto w-100 pt-3 border-top border-light">
                                <a href="<?php echo base_url('mentoring/book/' . $mentor->id); ?>" class="btn btn-dark w-100 rounded-pill py-2 fw-semibold">
                                    <i class="fas fa-calendar-check me-2"></i> <?php echo t('Booking Sesi', 'Book Session'); ?>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
