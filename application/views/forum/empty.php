<div>
    <div class="mb-4">
        <h2 class="fw-extrabold text-dark mb-1" style="letter-spacing: -0.03em;"><?php echo t('Forum Diskusi', 'Discussion Forum'); ?></h2>
        <p class="text-secondary mb-0"><?php echo t('Pilih kelas untuk melihat diskusi.', 'Select a course to view discussions.'); ?></p>
    </div>
    <div class="text-center py-5">
        <div class="icon-48 bg-light rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center">
            <i class="fas fa-message-square text-secondary"></i>
        </div>
        <h6 class="fw-bold text-dark"><?php echo t('Belum Ada Kelas', 'No Courses Yet'); ?></h6>
        <p class="text-secondary small mb-3"><?php echo t('Daftar di kelas untuk mengakses forum diskusi.', 'Enroll in a course to access the discussion forum.'); ?></p>
        <a href="<?php echo base_url('courses'); ?>" class="btn btn-dark rounded-pill px-4 py-2 fw-semibold"><?php echo t('Jelajahi Konten', 'Explore Content'); ?></a>
    </div>
</div>
