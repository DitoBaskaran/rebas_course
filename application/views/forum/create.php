<div class="container-fluid py-4" style="padding-top: 0px !important; max-width: 900px;">

    <!-- ===== HEADER + TOMBOL BACK ===== -->
    <div class="d-flex align-items-center gap-3 mb-4">
        <a href="<?php echo base_url('forum/index/' . $course->slug); ?>" class="text-decoration-none d-flex align-items-center justify-content-center flex-shrink-0 rounded-circle border" style="width:38px; height:38px; border-color:#e7e5e4 !important; background:#fff; color:#0D1830; box-shadow:0 1px 3px rgba(0,0,0,0.04);">
            <i class="fas fa-arrow-left" style="font-size:0.8rem;"></i>
        </a>
        <div class="flex-fill min-w-0">
            <h5 class="fw-extrabold mb-0 text-truncate" style="color:#0D1830; letter-spacing:-0.02em; font-size:1.05rem;"><?php echo t('Buat Diskusi Baru', 'New Discussion'); ?></h5>
            <small style="color:#a8a29e; font-size:0.72rem;" class="text-truncate d-block"><?php echo htmlspecialchars(t($course->title, $course->title_en ?? $course->title)); ?></small>
        </div>
    </div>

    <div class="bg-white rounded-4 border p-4" style="border-color:#f0eeeb !important; box-shadow:0 1px 4px rgba(0,0,0,0.03);">
        <?php echo form_open('forum/create/' . $course->slug, array('class' => 'd-flex flex-column gap-3')); ?>
            <div>
                <label class="form-label small fw-bold text-dark"><?php echo t('Judul Diskusi', 'Discussion Title'); ?></label>
                <input type="text" name="title" class="form-control" placeholder="<?php echo t('Contoh: Bagaimana cara mulai belajar dari nol?', 'e.g. How do I start learning from zero?'); ?>" required style="border-color:#e7e5e4; border-radius:10px; font-size:0.85rem;">
            </div>
            <div>
                <label class="form-label small fw-bold text-dark"><?php echo t('Isi Diskusi', 'Discussion Content'); ?></label>
                <textarea name="content" rows="6" class="form-control" placeholder="<?php echo t('Jelaskan pertanyaan atau topikmu dengan detail agar mudah dipahami...', 'Explain your question or topic in detail...'); ?>" required style="border-color:#e7e5e4; border-radius:10px; font-size:0.85rem; resize:vertical;"></textarea>
                <div class="form-text" style="font-size:0.68rem;"><?php echo t('Tips: tulis judul yang spesifik agar diskusi lebih mudah ditemukan.', 'Tip: write a specific title so the discussion is easier to find.'); ?></div>
            </div>
            <div class="d-flex gap-2">
                <button type="submit" class="btn fw-bold rounded-pill px-4 py-2 flex-shrink-0" style="background:#009688; color:#fff; font-size:0.8rem;"><i class="fas fa-paper-plane me-1" style="font-size:0.7rem;"></i> <?php echo t('Buat Diskusi', 'Create Discussion'); ?></button>
                <a href="<?php echo base_url('forum/index/' . $course->slug); ?>" class="btn rounded-pill px-4 py-2 flex-shrink-0" style="background:#E6EBEF; color:#57534e; font-size:0.8rem; font-weight:600;"><?php echo t('Batal', 'Cancel'); ?></a>
            </div>
        <?php echo form_close(); ?>
    </div>
</div>
