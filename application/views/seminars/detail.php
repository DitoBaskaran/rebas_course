<div class="container my-5 py-3">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4 animate-fade-in-up">
        <ol class="breadcrumb small mb-0">
            <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>" class="text-decoration-none">Home</a></li>
            <li class="breadcrumb-item"><a href="<?php echo base_url('seminars'); ?>" class="text-decoration-none">Seminar</a></li>
            <li class="breadcrumb-item active" aria-current="page"><?php echo htmlspecialchars($seminar->title); ?></li>
        </ol>
    </nav>

    <div class="row g-4">
        
        <!-- Left Side -->
        <div class="col-lg-8 animate-fade-in-up stagger-1">
            <span class="badge bg-danger badge-modern mb-3 d-inline-flex align-items-center gap-1">
                <i class="far fa-clock"></i> <?php echo date('d M Y - H:i', strtotime($seminar->date_time)); ?> WIB
            </span>
            <h1 class="fw-extrabold text-dark mb-3"><?php echo htmlspecialchars($seminar->title); ?></h1>
            
            <div class="d-flex flex-wrap gap-4 text-secondary small mb-4">
                <div class="d-flex align-items-center gap-2">
                    <div class="rounded-circle bg-primary-subtle text-primary d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                        <i class="fas fa-chalkboard-teacher"></i>
                    </div>
                    <span>Pembicara: <strong class="text-dark"><?php echo htmlspecialchars($seminar->speaker_name); ?></strong></span>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <i class="fas fa-users text-muted"></i>
                    <span>Pendaftar: <strong class="text-dark"><?php echo $attendee_count; ?> / <?php echo $seminar->quota; ?></strong></span>
                </div>
            </div>

            <!-- Mobile thumb -->
            <div class="d-block d-lg-none mb-4 rounded-3 overflow-hidden shadow-soft">
                <img src="<?php echo base_url('uploads/seminars/' . $seminar->thumbnail); ?>" onerror="this.src='https://images.unsplash.com/photo-1540575467063-178a50c2df87?w=500&auto=format&fit=crop&q=60';" alt="" class="w-100 object-fit-cover" style="height: 220px;">
            </div>

            <!-- Description -->
            <div class="card-flat p-4">
                <h5 class="fw-bold text-dark mb-3 d-flex align-items-center gap-2">
                    <i class="fas fa-file-alt text-primary"></i>
                    <span>Deskripsi Acara</span>
                </h5>
                <div class="text-secondary small leading-relaxed"><?php echo nl2br(htmlspecialchars($seminar->description)); ?></div>
            </div>
        </div>

        <!-- Right Sidebar -->
        <div class="col-lg-4 animate-fade-in-up stagger-2">
            <div class="card-flat p-4 position-sticky" style="top: 100px;">
                <img src="<?php echo base_url('uploads/seminars/' . $seminar->thumbnail); ?>" onerror="this.src='https://images.unsplash.com/photo-1540575467063-178a50c2df87?w=500&auto=format&fit=crop&q=60';" alt="" class="w-100 object-fit-cover rounded-3 mb-4" style="height: 190px;">
                
                <h4 class="fw-extrabold text-dark mb-1">
                    <?php echo $seminar->price > 0 ? 'Rp ' . number_format($seminar->price, 0, ',', '.') : 'Gratis'; ?>
                </h4>
                <p class="text-secondary small mb-4">Tiket masuk webinar</p>

                <div class="d-flex flex-column gap-2 mb-4">
                    <?php if ($is_registered): ?>
                        <div class="alert alert-success border-0 py-2 px-3 small d-flex align-items-center gap-2 mb-2">
                            <i class="fas fa-check-circle"></i> Kamu sudah terdaftar
                        </div>
                        <?php if (!empty($seminar->location_link)): ?>
                            <a href="<?php echo $seminar->location_link; ?>" target="_blank" class="btn btn-success w-100 py-2.5 shadow-sm">
                                <i class="fas fa-video me-2"></i> Masuk Webinar
                            </a>
                        <?php else: ?>
                            <span class="text-muted small text-center d-block py-2 bg-light rounded-2">Link akan muncul saat acara dimulai</span>
                        <?php endif; ?>
                    <?php else: ?>
                        <?php if ($attendee_count >= $seminar->quota): ?>
                            <button class="btn btn-secondary w-100 py-2.5" disabled>Kuota Penuh</button>
                        <?php else: ?>
                            <a href="<?php echo base_url('seminars/register/' . encode_id($seminar->id)); ?>" class="btn btn-warning w-100 py-2.5 shadow-sm">
                                <?php if ($seminar->price > 0): ?>
                                    <i class="fas fa-ticket-alt me-2"></i> Beli Tiket
                                <?php else: ?>
                                    <i class="fas fa-user-plus me-2"></i> Daftar Gratis
                                <?php endif; ?>
                            </a>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>

                <div class="d-flex flex-column gap-2 small text-secondary pt-3 border-top">
                    <div class="d-flex align-items-center gap-2">
                        <i class="fas fa-check-circle text-success"></i> Online via Zoom/Meet
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <i class="fas fa-check-circle text-success"></i> E-Sertifikat kehadiran
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <i class="fas fa-check-circle text-success"></i> Materi PDF
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
