<div class="container my-5 py-3">
    <div class="d-flex justify-content-between align-items-center mb-5 animate-fade-in-up">
        <div>
            <h4 class="fw-extrabold text-dark mb-1"><?php echo t('Sesi Mentoring Saya', 'My Mentoring Sessions'); ?></h4>
            <p class="text-secondary small mb-0"><?php echo t('Kelola jadwal mentoring Anda.', 'Manage your mentoring schedule.'); ?></p>
        </div>
        <a href="<?php echo base_url('mentoring'); ?>" class="btn btn-primary btn-sm px-3"><i class="fas fa-plus me-1"></i> <?php echo t('Booking Baru', 'New Booking'); ?></a>
    </div>

    <div class="d-flex flex-column gap-3">
        <?php if (empty($sessions)): ?>
            <div class="card-flat p-5 text-center text-muted">
                <i class="far fa-calendar-alt fa-3x mb-3"></i>
                <p class="mb-0"><?php echo t('Belum ada sesi mentoring.', 'No mentoring sessions yet.'); ?></p>
            </div>
        <?php else: ?>
            <?php foreach ($sessions as $s): ?>
                <div class="card-flat p-4 d-flex justify-content-between align-items-center">
                    <div>
                        <div class="d-flex align-items-center gap-2 mb-1">
                            <span class="fw-bold text-dark"><?php echo htmlspecialchars($s->student_name ?? $s->mentor_name); ?></span>
                            <?php if ($s->status === 'scheduled'): ?>
                                <span class="badge bg-warning text-dark badge-modern"><?php echo t('Terjadwal', 'Scheduled'); ?></span>
                            <?php elseif ($s->status === 'completed'): ?>
                                <span class="badge bg-success badge-modern"><?php echo t('Selesai', 'Completed'); ?></span>
                            <?php else: ?>
                                <span class="badge bg-secondary badge-modern"><?php echo t('Dibatalkan', 'Cancelled'); ?></span>
                            <?php endif; ?>
                        </div>
                        <p class="small text-secondary mb-0">
                            <i class="far fa-clock me-1"></i> <?php echo date('d M Y H:i', strtotime($s->scheduled_at)); ?> · <?php echo $s->duration; ?> <?php echo t('menit', 'min'); ?>
                        </p>
                    </div>
                    <div class="d-flex gap-1">
                        <?php if ($s->status === 'scheduled'): ?>
                            <a href="<?php echo base_url('mentoring/cancel/' . $s->id); ?>" class="btn btn-outline-danger btn-sm" onclick="return confirm('<?php echo t('Batalkan sesi ini?', 'Cancel this session?'); ?>')"><?php echo t('Batal', 'Cancel'); ?></a>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>
