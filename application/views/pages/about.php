<div class="container py-5 my-4">
    <div class="text-center mb-5">
        <span class="badge bg-primary-subtle text-primary badge-modern mb-3">Tentang Kami</span>
        <h1 class="display-5 fw-extrabold text-dark mb-3" style="letter-spacing:-0.03em;"><?php echo t('Membangun Masa Depan Melalui Pendidikan', 'Building the Future Through Education'); ?></h1>
        <p class="text-secondary mx-auto" style="max-width:600px;"><?php echo t('BISATUNTAS adalah platform belajar online yang berkomitmen untuk menyediakan pendidikan berkualitas tinggi untuk semua orang, di mana pun mereka berada.', 'BISATUNTAS is an online learning platform committed to providing quality education for everyone, everywhere.'); ?></p>
    </div>

    <div class="row g-4 mb-5">
        <div class="col-md-4">
            <div class="bento-card text-center">
                <div class="display-5 fw-extrabold text-primary"><?php echo $total_students; ?>+</div>
                <div class="text-secondary small fw-semibold text-uppercase"><?php echo t('Siswa', 'Students'); ?></div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="bento-card text-center">
                <div class="display-5 fw-extrabold text-primary"><?php echo $total_courses; ?>+</div>
                <div class="text-secondary small fw-semibold text-uppercase"><?php echo t('Kursus', 'Courses'); ?></div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="bento-card text-center">
                <div class="display-5 fw-extrabold text-primary"><?php echo $total_teachers; ?>+</div>
                <div class="text-secondary small fw-semibold text-uppercase"><?php echo t('Pengajar', 'Teachers'); ?></div>
            </div>
        </div>
    </div>

    <div class="bento-card p-5">
        <h3 class="fw-extrabold text-dark mb-4"><?php echo t('Misi Kami', 'Our Mission'); ?></h3>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="d-flex align-items-start gap-3">
                    <span class="d-flex align-items-center justify-content-center bg-primary-subtle text-primary rounded-2 flex-shrink-0" style="width:40px;height:40px;"><i data-lucide="graduation-cap" style="width:20px;height:20px;"></i></span>
                    <div><h5 class="fw-bold"><?php echo t('Akses Universal', 'Universal Access'); ?></h5><p class="small text-muted mb-0"><?php echo t('Pendidikan berkualitas untuk semua kalangan.', 'Quality education for all.'); ?></p></div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="d-flex align-items-start gap-3">
                    <span class="d-flex align-items-center justify-content-center bg-success-subtle text-success rounded-2 flex-shrink-0" style="width:40px;height:40px;"><i data-lucide="zap" style="width:20px;height:20px;"></i></span>
                    <div><h5 class="fw-bold"><?php echo t('Belajar Aktif', 'Active Learning'); ?></h5><p class="small text-muted mb-0"><?php echo t('Kombinasi teori dan praktik langsung.', 'Theory and hands-on practice.'); ?></p></div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="d-flex align-items-start gap-3">
                    <span class="d-flex align-items-center justify-content-center bg-warning-subtle text-warning rounded-2 flex-shrink-0" style="width:40px;height:40px;"><i data-lucide="users" style="width:20px;height:20px;"></i></span>
                    <div><h5 class="fw-bold"><?php echo t('Komunitas', 'Community'); ?></h5><p class="small text-muted mb-0"><?php echo t('Belajar bersama, tumbuh bersama.', 'Learn together, grow together.'); ?></p></div>
                </div>
            </div>
        </div>
    </div>
</div>
