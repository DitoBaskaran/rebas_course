<!-- Header -->
<div style="border-bottom: 1px solid #e5e5e5;">
    <div class="container" style="padding-top: 2rem; padding-bottom: 1.5rem; max-width: 960px;">
        <div class="text-center mb-4">
            <span class="px-3 py-1 rounded-pill fw-semibold mb-3 d-inline-block" style="background: #111827; color: #fff; font-size: 0.72rem;">EVENTS</span>
            <h1 class="fw-extrabold mb-2" style="font-size: 1.6rem; letter-spacing: -0.02em; color: #111827;">
                <?php echo t('Seminar & Webinar', 'Seminars & Webinars'); ?>
            </h1>
            <p class="mb-0 mx-auto" style="color: #737373; font-size: 0.9rem; max-width: 500px;">
                <?php echo t('Kembangkan skill dan wawasanmu melalui diskusi interaktif bersama para pakar.', 'Expand your knowledge through interactive discussions with experts.'); ?>
            </p>
        </div>
    </div>
</div>

<!-- Seminars Grid -->
<div class="container" style="max-width: 960px; padding-top: 1.5rem; padding-bottom: 3rem;">
    <?php if (empty($seminars)): ?>
        <div class="text-center py-5">
            <div style="font-size: 2.5rem; color: #d4d4d4; margin-bottom: 0.75rem;"><i class="far fa-calendar"></i></div>
            <h5 class="fw-bold" style="color: #111827;"><?php echo t('Belum Ada Seminar', 'No Seminars Yet'); ?></h5>
            <p style="color: #737373; font-size: 0.85rem;"><?php echo t('Kami sedang merencanakan seminar seru. Pantau terus!', 'We are planning exciting seminars. Stay tuned!'); ?></p>
        </div>
    <?php else: ?>
        <div class="row g-3">
            <?php foreach($seminars as $seminar): ?>
                <div class="col-md-6 col-lg-4">
                    <a href="<?php echo base_url('seminars/detail/' . encode_id($seminar->id)); ?>" class="text-decoration-none">
                        <div class="card h-100" style="border: 1px solid #e5e5e5; border-radius: 12px; transition: all 0.15s;">
                            <!-- Thumbnail -->
                            <div class="position-relative overflow-hidden" style="aspect-ratio: 16/9; border-radius: 12px 12px 0 0;">
                                <img src="<?php echo base_url('uploads/seminars/' . $seminar->thumbnail); ?>" onerror="this.src='https://images.unsplash.com/photo-1540575467063-178a50c2df87?w=500&auto=format&fit=crop&q=60';" alt="" class="w-100 h-100" style="object-fit: cover;">
                                <!-- Date badge -->
                                <div class="position-absolute top-0 start-0 m-2">
                                    <span class="px-2 py-1 rounded-pill fw-semibold" style="background: #111827; color: #fff; font-size: 0.65rem;">
                                        <i class="far fa-calendar me-1" style="font-size: 0.55rem;"></i><?php echo date('d M', strtotime($seminar->date_time)); ?>
                                    </span>
                                </div>
                                <!-- Price badge -->
                                <?php if ($seminar->price > 0): ?>
                                    <div class="position-absolute top-0 end-0 m-2">
                                        <span class="px-2 py-1 rounded-pill fw-bold" style="background: #eab308; color: #111827; font-size: 0.65rem;">
                                            Rp <?php echo number_format($seminar->price, 0, ',', '.'); ?>
                                        </span>
                                    </div>
                                <?php else: ?>
                                    <div class="position-absolute top-0 end-0 m-2">
                                        <span class="px-2 py-1 rounded-pill fw-semibold" style="background: #22c55e; color: #fff; font-size: 0.65rem;">
                                            <?php echo t('Gratis', 'Free'); ?>
                                        </span>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <!-- Content -->
                            <div class="card-body p-3 d-flex flex-column">
                                <!-- Time & Type -->
                                <div class="d-flex align-items-center gap-2 mb-1" style="color: #737373; font-size: 0.72rem; font-weight: 500;">
                                    <span class="d-flex align-items-center gap-1">
                                        <i class="far fa-clock" style="font-size: 0.6rem;"></i>
                                        <?php echo date('H:i', strtotime($seminar->date_time)); ?> WIB
                                    </span>
                                    <span style="color: #e5e5e5;">•</span>
                                    <span class="d-flex align-items-center gap-1">
                                        <i class="fas fa-video" style="font-size: 0.6rem;"></i>
                                        <?php echo t('Online', 'Online'); ?>
                                    </span>
                                </div>

                                <!-- Title -->
                                <h6 class="fw-bold mb-2 lh-sm" style="color: #111827; font-size: 0.875rem; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                                    <?php echo htmlspecialchars($seminar->title); ?>
                                </h6>

                                <!-- Description -->
                                <p class="mb-2 flex-grow-1" style="color: #737373; font-size: 0.78rem; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; line-height: 1.5;">
                                    <?php echo htmlspecialchars($seminar->description); ?>
                                </p>

                                <!-- Speaker -->
                                <div class="d-flex align-items-center gap-2 mb-2 py-2 px-3 rounded-3" style="background: #fafafa;">
                                    <img src="https://ui-avatars.com/api/?name=<?php echo urlencode($seminar->speaker_name); ?>&background=f59e0b&color=fff&size=28" alt="" style="width: 28px; height: 28px; border-radius: 50%; flex-shrink: 0;">
                                    <div>
                                        <div class="fw-semibold" style="color: #111827; font-size: 0.75rem;"><?php echo htmlspecialchars($seminar->speaker_name); ?></div>
                                        <div style="color: #a3a3a3; font-size: 0.65rem;"><?php echo t('Pembicara', 'Speaker'); ?></div>
                                    </div>
                                </div>

                                <!-- Bottom -->
                                <div class="d-flex align-items-center justify-content-between pt-2" style="border-top: 1px solid #f0f0f0;">
                                    <span style="color: #eab308; font-size: 0.8rem; font-weight: 600;">
                                        <?php echo t('Daftar', 'Register'); ?> <i class="fas fa-chevron-right" style="font-size: 0.55rem;"></i>
                                    </span>
                                    <?php if ($seminar->quota): ?>
                                        <span class="px-2 py-1 rounded-pill" style="background: #f5f5f5; color: #525252; font-size: 0.65rem; font-weight: 600;">
                                            <?php echo $seminar->quota; ?> <?php echo t('kuota', 'quota'); ?>
                                        </span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>
