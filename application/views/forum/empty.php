<div class="container-fluid py-4" style="padding-top: 0px !important; max-width: 900px;">
    <div class="mn-panel-hero mb-4" style="background: linear-gradient(120deg,#0D1830 0%,#0D1830 45%,#00796B 100%); border-radius: 18px; padding: 1.5rem; color: #fff; position: relative; overflow: hidden;">
        <div style="position:absolute; top:-50px; right:-30px; width:180px; height:180px; border-radius:50%; background:rgba(251,191,36,0.14);"></div>
        <div style="position:absolute; bottom:-70px; left:30%; width:160px; height:160px; border-radius:50%; background:rgba(0,150,136,0.3);"></div>
        <div class="d-flex align-items-center gap-3 position-relative">
            <div class="d-flex align-items-center justify-content-center rounded-3 flex-shrink-0" style="width:52px; height:52px; background: rgba(255,255,255,0.1); border:1px solid rgba(255,255,255,0.15);">
                <i class="fas fa-comments" style="color: #FBBF24; font-size: 1.2rem;"></i>
            </div>
            <div>
                <h5 class="fw-extrabold mb-0" style="font-size: 1.1rem; letter-spacing: -0.02em;"><?php echo t('Forum Diskusi', 'Discussion Forum'); ?></h5>
                <small style="color: rgba(230,235,239,0.75); font-size: 0.75rem;"><?php echo t('Pilih kelas untuk melihat diskusi.', 'Select a course to view discussions.'); ?></small>
            </div>
        </div>
    </div>

    <div class="mob-empty" style="padding: 2.5rem 1rem;">
        <i class="fas fa-comment-dots"></i>
        <p style="font-size: 0.85rem; font-weight: 600; color: #0D1830;"><?php echo t('Belum Ada Kelas', 'No Courses Yet'); ?></p>
        <p style="max-width: 320px; margin: 0 auto 0.75rem;"><?php echo t('Daftar di kelas untuk mengakses forum diskusi.', 'Enroll in a course to access the discussion forum.'); ?></p>
        <a href="<?php echo base_url('courses'); ?>" class="btn fw-semibold rounded-pill px-4 py-2" style="background:#009688; color:#fff; font-size:0.8rem;"><?php echo t('Jelajahi Konten', 'Explore Content'); ?></a>
    </div>
</div>
