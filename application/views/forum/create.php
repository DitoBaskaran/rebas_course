<div class="container my-5 py-3">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card-modern p-4 p-md-5 animate-scale-in">
                <h4 class="fw-extrabold text-dark mb-1"><?php echo t('Buat Diskusi Baru', 'New Discussion'); ?></h4>
                <p class="text-secondary small mb-4"><?php echo t('Kelas: ', 'Course: '); ?><?php echo htmlspecialchars($course->title); ?></p>

                <?php echo form_open('forum/create/' . $course->slug, array('class' => 'd-flex flex-column gap-3')); ?>
                    <div>
                        <label class="form-label small fw-bold text-dark"><?php echo t('Judul Diskusi', 'Discussion Title'); ?></label>
                        <input type="text" name="title" class="form-control" required>
                    </div>
                    <div>
                        <label class="form-label small fw-bold text-dark"><?php echo t('Isi Diskusi', 'Discussion Content'); ?></label>
                        <textarea name="content" rows="6" class="form-control" required></textarea>
                    </div>
                    <div class="d-flex gap-3">
                        <button type="submit" class="btn btn-primary px-4 py-2.5"><?php echo t('Buat Diskusi', 'Create Discussion'); ?></button>
                        <a href="<?php echo base_url('forum/index/' . $course->slug); ?>" class="btn btn-outline-secondary px-4 py-2.5"><?php echo t('Batal', 'Cancel'); ?></a>
                    </div>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
</div>
