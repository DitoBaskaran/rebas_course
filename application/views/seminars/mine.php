<div>
    <div class="mb-4">
        <h2 class="fw-extrabold text-dark mb-1" style="letter-spacing: -0.03em;"><?php echo t('Seminar Saya', 'My Seminars'); ?></h2>
        <p class="text-secondary mb-0"><?php echo t('Seminar yang sudah kamu daftar.', 'Seminars you have registered for.'); ?></p>
    </div>

    <?php if (empty($registered_seminars)): ?>
    <div class="text-center py-5">
        <div class="icon-48 bg-light rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center">
            <i class="fas fa-calendar-alt text-secondary"></i>
        </div>
        <h6 class="fw-bold text-dark"><?php echo t('Belum Ada Seminar', 'No Seminars Yet'); ?></h6>
        <p class="text-secondary small mb-3"><?php echo t('Kamu belum mendaftar seminar apapun.', 'You have not registered for any seminars.'); ?></p>
        <a href="<?php echo base_url('seminars'); ?>" class="btn btn-dark rounded-pill px-4 py-2 fw-semibold"><?php echo t('Cari Seminar', 'Browse Seminars'); ?></a>
    </div>
    <?php else: ?>
    <div class="d-flex flex-column gap-3">
        <?php foreach ($registered_seminars as $sem): ?>
        <div class="d-flex align-items-center gap-3 p-4 rounded-3 bg-white border">
            <div class="d-flex align-items-center justify-content-center rounded-2 flex-shrink-0" style="width:56px;height:56px;background:var(--primary-light);color:var(--primary);">
                <i class="fas fa-calendar-alt fa-lg"></i>
            </div>
            <div class="flex-fill min-w-0">
                <h6 class="fw-bold text-dark mb-1 small"><?php echo htmlspecialchars(t($sem->title, $sem->title_en ?: $sem->title)); ?></h6>
                <div class="text-secondary small"><i class="far fa-clock me-1"></i> <?php echo date('d M Y - H:i', strtotime($sem->date_time)); ?> WIB</div>
            </div>
            <?php if (!empty($sem->location_link)): ?>
            <a href="<?php echo $sem->location_link; ?>" target="_blank" class="btn btn-success btn-sm rounded-pill px-3 fw-semibold"><i class="fas fa-video me-1"></i> Zoom</a>
            <?php endif; ?>
        </div>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>
</div>
