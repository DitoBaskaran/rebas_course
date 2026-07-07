<div class="container my-5 py-3">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card-modern p-4 p-md-5 animate-scale-in">
                <h4 class="fw-extrabold text-dark mb-1"><?php echo t('Booking Sesi Mentoring', 'Book Mentoring Session'); ?></h4>
                <p class="text-secondary small mb-4"><?php echo t('Mentor: ', 'Mentor: '); ?><strong><?php echo htmlspecialchars($mentor->name); ?></strong></p>

                <?php echo form_open('mentoring/book/' . $mentor->id, array('class' => 'd-flex flex-column gap-3')); ?>
                    <div>
                        <label class="form-label small fw-bold text-dark"><?php echo t('Pilih Jadwal', 'Choose Schedule'); ?></label>
                        <input type="datetime-local" name="scheduled_at" class="form-control" required>
                    </div>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-dark"><?php echo t('Durasi (menit)', 'Duration (minutes)'); ?></label>
                            <select name="duration" class="form-select">
                                <option value="30">30 <?php echo t('menit', 'min'); ?></option>
                                <option value="60" selected>60 <?php echo t('menit', 'min'); ?></option>
                                <option value="90">90 <?php echo t('menit', 'min'); ?></option>
                                <option value="120">120 <?php echo t('menit', 'min'); ?></option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-dark"><?php echo t('Topik (opsional)', 'Topic (optional)'); ?></label>
                            <select name="course_id" class="form-select">
                                <option value="">—</option>
                                <?php foreach ($courses as $c): ?>
                                    <option value="<?php echo $c->id; ?>"><?php echo htmlspecialchars($c->title); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="d-flex gap-3 pt-2">
                        <button type="submit" class="btn btn-primary px-4 py-2.5"><?php echo t('Booking Sekarang', 'Book Now'); ?></button>
                        <a href="<?php echo base_url('mentoring'); ?>" class="btn btn-outline-secondary px-4 py-2.5"><?php echo t('Batal', 'Cancel'); ?></a>
                    </div>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
</div>
