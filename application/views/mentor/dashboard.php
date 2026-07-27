<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-extrabold mb-1"><?php echo t('Dashboard Mentor', 'Mentor Dashboard'); ?></h4>
            <p class="text-secondary small mb-0"><?php echo t('Selamat datang, ' . $this->session->userdata('name'), 'Welcome, ' . $this->session->userdata('name')); ?></p>
        </div>
        <div class="d-flex gap-2">
            <?php if ($this->session->userdata('is_teacher')): ?>
            <a href="<?php echo base_url('admin/dashboard'); ?>" class="btn btn-outline-dark rounded-pill px-3 fw-semibold shadow-sm">
                <i data-lucide="layout-dashboard" style="width:16px;height:16px;" class="me-1"></i> <?php echo t('Panel Admin', 'Admin Panel'); ?>
            </a>
            <?php endif; ?>
            <a href="<?php echo base_url('mentor/availability'); ?>" class="btn btn-dark rounded-pill px-4 fw-semibold shadow-sm">
                <i data-lucide="calendar" style="width:16px;height:16px;" class="me-1"></i> <?php echo t('Atur Jadwal', 'Set Schedule'); ?>
            </a>
        </div>
    </div>

    <!-- Stats -->
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center gap-2">
                        <div class="bg-primary-subtle text-primary rounded-3 p-2"><i data-lucide="star" style="width:20px;height:20px;" fill="currentColor"></i></div>
                        <div>
                            <div class="fw-bold fs-4"><?php echo $mentor->avg_rating; ?></div>
                            <div class="text-secondary small"><?php echo t('Rating', 'Rating'); ?></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center gap-2">
                        <div class="bg-success-subtle text-success rounded-3 p-2"><i data-lucide="check-circle" style="width:20px;height:20px;"></i></div>
                        <div>
                            <div class="fw-bold fs-4"><?php echo $total_completed; ?></div>
                            <div class="text-secondary small"><?php echo t('Selesai', 'Completed'); ?></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center gap-2">
                        <div class="bg-warning-subtle text-warning rounded-3 p-2"><i data-lucide="clock" style="width:20px;height:20px;"></i></div>
                        <div>
                            <div class="fw-bold fs-4"><?php echo $total_pending; ?></div>
                            <div class="text-secondary small"><?php echo t('Pending', 'Pending'); ?></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center gap-2">
                        <div class="bg-info-subtle text-info rounded-3 p-2"><i data-lucide="users" style="width:20px;height:20px;"></i></div>
                        <div>
                            <div class="fw-bold fs-4"><?php echo $mentor->total_sessions; ?></div>
                            <div class="text-secondary small"><?php echo t('Total Sesi', 'Total Sessions'); ?></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Sesi Mendatang -->
    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-header bg-white border-0 pt-4 px-4">
            <h6 class="fw-bold mb-0"><?php echo t('Sesi Mendatang', 'Upcoming Sessions'); ?></h6>
        </div>
        <div class="card-body p-4">
            <?php if (empty($upcoming)): ?>
                <p class="text-secondary small mb-0"><?php echo t('Tidak ada sesi mendatang.', 'No upcoming sessions.'); ?></p>
            <?php else: ?>
                <?php foreach ($upcoming as $s): ?>
                    <div class="d-flex align-items-center justify-content-between border-bottom pb-3 mb-3">
                        <div class="d-flex align-items-center gap-3">
                            <div class="rounded-circle bg-dark text-white d-flex align-items-center justify-content-center fw-bold flex-shrink-0" style="width:40px;height:40px;font-size:0.8rem;">
                                <?php echo strtoupper(substr($s->user_name, 0, 1)); ?>
                            </div>
                            <div>
                                <div class="fw-semibold small"><?php echo htmlspecialchars($s->user_name); ?></div>
                                <small class="text-secondary"><?php echo date('d M Y H:i', strtotime($s->scheduled_at)); ?> · <?php echo $s->duration; ?> <?php echo t('mnt', 'min'); ?></small>
                            </div>
                        </div>
                        <span class="badge bg-<?php echo $s->status == 'confirmed' ? 'success' : 'warning'; ?> rounded-pill px-3 fw-medium">
                            <?php echo t(ucfirst($s->status), ucfirst($s->status)); ?>
                        </span>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
        <div class="card-footer bg-white border-0 px-4 pb-4">
            <a href="<?php echo base_url('mentor/sessions'); ?>" class="btn btn-outline-dark rounded-pill w-100 fw-semibold"><?php echo t('Lihat Semua', 'View All'); ?></a>
        </div>
    </div>

    <!-- Edit Profil -->
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-header bg-white border-0 pt-4 px-4">
            <h6 class="fw-bold mb-0"><?php echo t('Profil Mentor', 'Mentor Profile'); ?></h6>
        </div>
        <div class="card-body p-4">
            <?php echo form_open('mentor/update-schedule/' . $mentor->id); ?>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label small fw-bold"><?php echo t('Judul/Gelar', 'Title'); ?></label>
                        <input type="text" name="title" class="form-control" value="<?php echo htmlspecialchars($mentor->title); ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-bold">Title (EN)</label>
                        <input type="text" name="title_en" class="form-control" value="<?php echo htmlspecialchars($mentor->title_en); ?>">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-bold"><?php echo t('Bio', 'Bio'); ?></label>
                        <textarea name="bio" class="form-control" rows="3"><?php echo htmlspecialchars($mentor->bio ?? ''); ?></textarea>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-bold">Bio (EN)</label>
                        <textarea name="bio_en" class="form-control" rows="3"><?php echo htmlspecialchars($mentor->bio_en ?? ''); ?></textarea>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label small fw-bold"><?php echo t('Durasi Tersedia', 'Available Durations'); ?></label>
                        <input type="text" name="durations_available" class="form-control" value="<?php echo htmlspecialchars($mentor->durations_available); ?>" placeholder="15,30,45,60">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label small fw-bold"><?php echo t('Platform Meeting', 'Meeting Platforms'); ?></label>
                        <input type="text" name="meeting_platforms" class="form-control" value="<?php echo htmlspecialchars($mentor->meeting_platforms); ?>" placeholder="zoom,gmeet,whatsapp">
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn btn-dark rounded-pill px-5 fw-semibold"><?php echo t('Simpan', 'Save'); ?></button>
                    </div>
                </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>
