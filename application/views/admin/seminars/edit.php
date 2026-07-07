<div class="container-fluid px-0">
    <div class="d-flex align-items-center gap-2 mb-5">
        <a href="<?php echo base_url('admin/seminars'); ?>" class="btn btn-outline-dark btn-sm rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width: 36px; height: 36px;">
            <i data-lucide="arrow-left" style="width:16px;height:16px;"></i>
        </a>
        <div>
            <span class="text-primary fw-semibold small text-uppercase tracking-wide d-block mb-1">Event</span>
            <h1 class="display-6 fw-extrabold text-dark mb-0 lh-sm" style="letter-spacing: -0.03em;"><?php echo t('Edit Seminar', 'Edit Seminar'); ?></h1>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="bento-card animate-scale-in overflow-hidden">
                <div class="d-flex align-items-center gap-2 px-4 px-xl-5 py-3 section-glass">
                    <i data-lucide="calendar" style="width:18px;height:18px;"></i>
                    <span class="fw-semibold"><?php echo t('Informasi Seminar', 'Seminar Information'); ?></span>
                </div>
                <?php if (validation_errors()): ?>
                    <div class="alert alert-danger border-0 m-3 py-2 px-3 small"><?php echo validation_errors('', ''); ?></div>
                <?php endif; ?>
                <?php echo form_open_multipart('admin/edit_seminar/' . $seminar->id, array('class' => 'needs-validation')); ?>
                    <div class="card-body d-flex flex-column gap-4 p-4 p-xl-5">
                        <div class="row g-4">
                            <div class="col-md-6">
                                <div class="form-float">
                                    <input type="text" name="title" class="form-control" value="<?php echo set_value('title', $seminar->title); ?>" required placeholder=" ">
                                    <label class="fl-label"><?php echo t('Judul (ID)', 'Title (ID)'); ?> *</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-float">
                                    <input type="text" name="title_en" class="form-control" value="<?php echo set_value('title_en', $seminar->title_en ?? ''); ?>" placeholder=" ">
                                    <label class="fl-label"><?php echo t('Judul (EN)', 'Title (EN)'); ?></label>
                                </div>
                            </div>
                        </div>
                        <div>
                            <div class="form-float">
                                <textarea name="description" rows="4" class="form-control" required placeholder=" " data-max-chars="2000"><?php echo set_value('description', $seminar->description); ?></textarea>
                                <label class="fl-label"><?php echo t('Deskripsi (ID)', 'Description (ID)'); ?> *</label>
                            </div>
                        </div>
                        <div>
                            <div class="form-float">
                                <textarea name="description_en" rows="4" class="form-control" placeholder=" " data-max-chars="2000"><?php echo set_value('description_en', $seminar->description_en ?? ''); ?></textarea>
                                <label class="fl-label"><?php echo t('Deskripsi (EN)', 'Description (EN)'); ?></label>
                            </div>
                        </div>
                        <div class="row g-4">
                            <div class="col-md-4">
                                <div class="form-float">
                                    <input type="datetime-local" name="date_time" class="form-control" value="<?php echo set_value('date_time', date('Y-m-d\TH:i', strtotime($seminar->date_time))); ?>" required placeholder=" ">
                                    <label class="fl-label"><?php echo t('Tanggal & Jam', 'Date & Time'); ?> *</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-float">
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-secondary border-opacity-25 fw-semibold small">Rp</span>
                                        <input type="number" name="price" class="form-control" value="<?php echo set_value('price', round($seminar->price)); ?>" required placeholder=" ">
                                    </div>
                                    <label class="fl-label"><?php echo t('Harga (Rp)', 'Price (Rp)'); ?> *</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-float">
                                    <input type="number" name="quota" class="form-control" value="<?php echo set_value('quota', round($seminar->quota)); ?>" required placeholder=" ">
                                    <label class="fl-label"><?php echo t('Kuota', 'Quota'); ?> *</label>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-float">
                                    <select name="language" class="form-select">
                                        <option value=""> </option>
                                        <option value="id" <?php echo $seminar->language === 'id' ? 'selected' : ''; ?>>Indonesia</option>
                                        <option value="en" <?php echo $seminar->language === 'en' ? 'selected' : ''; ?>>English</option>
                                    </select>
                                    <label class="fl-label"><?php echo t('Bahasa', 'Language'); ?></label>
                                </div>
                            </div>
                        </div>
                        <div class="row g-4">
                            <div class="col-md-6">
                                <div class="form-float">
                                    <input type="url" name="location_link" class="form-control" value="<?php echo set_value('location_link', $seminar->location_link ?? ''); ?>" placeholder=" ">
                                    <label class="fl-label"><?php echo t('Tautan Zoom (opsional)', 'Zoom Link (optional)'); ?></label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-float">
                                    <input type="file" name="thumbnail" class="form-control" placeholder=" ">
                                    <label class="fl-label"><?php echo t('Poster Baru', 'New Poster'); ?></label>
                                </div>
                                <div class="mt-2 d-flex align-items-center gap-2">
                                    <img src="<?php echo base_url('uploads/seminars/' . $seminar->thumbnail); ?>" onerror="this.src='https://images.unsplash.com/photo-1540575467063-178a50c2df87?w=100&auto=format&fit=crop&q=60';" alt="" class="thumb-xs" style="border-radius:var(--radius-sm);">
                                    <span class="text-muted small"><?php echo t('Poster saat ini', 'Current poster'); ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end gap-2 px-4 px-xl-5 py-3 form-footer-sticky">
                        <a href="<?php echo base_url('admin/seminars'); ?>" class="btn btn-outline-secondary btn-sm rounded-pill px-4"><?php echo t('Kembali', 'Back'); ?></a>
                        <button type="submit" class="btn btn-primary btn-sm rounded-pill px-4 d-flex align-items-center gap-1">
                            <i data-lucide="save" style="width:16px;height:16px;"></i> <?php echo t('Simpan', 'Save'); ?>
                        </button>
                    </div>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
</div>
