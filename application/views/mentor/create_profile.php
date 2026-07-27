<div class="container py-5" style="max-width: 640px;">
    <div class="text-center mb-4">
        <div class="d-inline-flex align-items-center justify-content-center rounded-3 mb-3" style="width: 56px; height: 56px; background: #faf5ff;">
            <i data-lucide="calendar-check" style="width: 28px; height: 28px; color: #a855f7;"></i>
        </div>
        <h4 class="fw-extrabold mb-1"><?php echo t('Lengkapi Profil Mentor', 'Complete Mentor Profile'); ?></h4>
        <p class="text-secondary small mb-0"><?php echo t('Isi data diri Anda sebagai mentor sebelum memulai.', 'Fill in your mentor profile before getting started.'); ?></p>
    </div>

    <?php echo form_open('mentor/create-profile'); ?>
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-4 p-xl-5">
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-semibold small"><?php echo t('Judul / Gelar', 'Title'); ?> <span class="text-danger">*</span></label>
                    <input type="text" name="title" class="form-control" placeholder="<?php echo t('cth: Mentor Bahasa Inggris', 'e.g. English Mentor'); ?>" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold small">Title (EN)</label>
                    <input type="text" name="title_en" class="form-control" placeholder="e.g. English Mentor">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold small"><?php echo t('Bio', 'Bio'); ?></label>
                    <textarea name="bio" class="form-control" rows="3" placeholder="<?php echo t('Ceritakan tentang diri Anda...', 'Tell us about yourself...'); ?>"></textarea>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold small">Bio (EN)</label>
                    <textarea name="bio_en" class="form-control" rows="3" placeholder="Tell us about yourself..."></textarea>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold small"><?php echo t('Durasi Tersedia (menit)', 'Available Durations (minutes)'); ?></label>
                    <input type="text" name="durations_available" class="form-control" value="15,30,45,60" placeholder="15,30,45,60">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold small"><?php echo t('Platform Meeting', 'Meeting Platforms'); ?></label>
                    <input type="text" name="meeting_platforms" class="form-control" value="zoom,gmeet,whatsapp" placeholder="zoom,gmeet,whatsapp">
                </div>
            </div>
        </div>
        <div class="card-footer bg-white border-0 px-4 px-xl-5 py-3 d-flex justify-content-end gap-2">
            <a href="<?php echo base_url('dashboard'); ?>" class="btn btn-outline-secondary rounded-pill px-4 fw-semibold"><?php echo t('Nanti', 'Later'); ?></a>
            <button type="submit" class="btn btn-dark rounded-pill px-4 fw-semibold">
                <i data-lucide="save" style="width:16px;height:16px;" class="me-1"></i>
                <?php echo t('Simpan Profil', 'Save Profile'); ?>
            </button>
        </div>
    </div>
    <?php echo form_close(); ?>
</div>