<div class="container py-5 my-4">
    <div class="row mb-5 animate-fade-in-up">
        <div class="col-lg-8">
            <span class="text-primary fw-semibold small text-uppercase tracking-wide d-block mb-2">Event</span>
            <h1 class="display-5 fw-extrabold text-dark mb-2 lh-sm" style="letter-spacing: -0.03em;"><?php echo t('Seminar & Webinar', 'Seminars & Webinars'); ?></h1>
            <p class="text-secondary lead mb-0" style="font-size: 1.1rem; max-width: 600px;"><?php echo t('Kembangkan skill dan wawasanmu melalui diskusi interaktif bersama para pakar.', 'Expand your knowledge through interactive discussions with experts.'); ?></p>
        </div>
    </div>

    <div class="row g-4">
        <?php if (empty($seminars)): ?>
            <div class="col-12">
                <div class="text-center py-5">
                    <div class="icon-64 bg-light rounded-circle mx-auto mb-4 d-flex align-items-center justify-content-center">
                        <i class="far fa-calendar-times fs-3 text-secondary"></i>
                    </div>
                    <h5 class="fw-bold text-dark"><?php echo t('Belum Ada Seminar', 'No Seminars Yet'); ?></h5>
                    <p class="text-secondary small mb-0"><?php echo t('Kami sedang merencanakan webinar seru. Pantau terus!', 'We are planning exciting webinars. Stay tuned!'); ?></p>
                </div>
            </div>
        <?php else: ?>
            <?php $loop = 0; ?>
            <?php foreach($seminars as $seminar): ?>
                <?php $loop++; ?>
                <div class="col-md-6 col-lg-4 animate-fade-in-up stagger-<?php echo min($loop, 8); ?>">
                    <div class="card h-100 border-0 shadow-sm rounded-4 bg-white overflow-hidden hover-zoom d-flex flex-column" style="transition: all 0.3s ease;">
                        <div class="position-relative overflow-hidden" style="aspect-ratio: 16/10;">
                            <img src="<?php echo base_url('uploads/seminars/' . $seminar->thumbnail); ?>" onerror="this.src='https://images.unsplash.com/photo-1540575467063-178a50c2df87?w=500&auto=format&fit=crop&q=60';" alt="" class="w-100 h-100 object-fit-cover">
                            <div class="position-absolute top-0 start-0 m-3">
                                <span class="badge bg-white text-dark rounded-pill px-3 py-2 shadow-sm fw-medium border">
                                    <i class="far fa-clock text-primary me-1"></i> <?php echo date('d M Y', strtotime($seminar->date_time)); ?>
                                </span>
                            </div>
                        </div>
                        <div class="card-body p-4 d-flex flex-column flex-grow-1">
                            <div class="d-flex align-items-center gap-2 mb-3 text-secondary small fw-medium">
                                <i class="far fa-clock text-primary"></i> <?php echo date('H:i', strtotime($seminar->date_time)); ?> WIB
                                <span class="opacity-50 mx-1">•</span>
                                <i class="fas fa-video text-primary"></i> Live Online
                            </div>
                            
                            <h5 class="fw-bold text-dark mb-3 lh-sm" style="font-size: 1.15rem;"><?php echo htmlspecialchars($seminar->title); ?></h5>
                            <p class="text-secondary small mb-4 flex-grow-1" style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;"><?php echo htmlspecialchars($seminar->description); ?></p>
                            
                            <div class="d-flex align-items-center gap-3 mb-4 p-3 bg-light rounded-3">
                                <div class="icon-40 bg-primary text-white rounded-circle d-flex align-items-center justify-content-center flex-shrink-0 fw-bold">
                                    <?php echo substr($seminar->speaker_name, 0, 1); ?>
                                </div>
                                <div>
                                    <div class="text-dark fw-bold small"><?php echo htmlspecialchars($seminar->speaker_name); ?></div>
                                    <div class="text-secondary" style="font-size: 0.75rem;">Pembicara</div>
                                </div>
                            </div>
                            
                            <div class="mt-auto pt-3 border-top border-light d-flex align-items-center justify-content-between">
                                <span class="fs-5 fw-bold text-dark"><?php echo $seminar->price > 0 ? 'Rp ' . number_format($seminar->price, 0, ',', '.') : '<span class="text-success">' . t('Gratis', 'Free') . '</span>'; ?></span>
                                <a href="<?php echo base_url('seminars/detail/' . $seminar->id); ?>" class="btn btn-primary btn-sm rounded-pill px-4 py-2 fw-semibold shadow-sm">
                                    <?php echo t('Daftar', 'Register'); ?> <i class="fas fa-arrow-right ms-1"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>
