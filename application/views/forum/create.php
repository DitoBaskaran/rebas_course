<div>
    <div class="mb-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb small mb-0">
                <li class="breadcrumb-item"><a href="<?php echo base_url('courses/detail/' . $course->slug); ?>" class="text-decoration-none"><?php echo htmlspecialchars($course->title); ?></a></li>
                <li class="breadcrumb-item"><a href="<?php echo base_url('forum/index/' . $course->slug); ?>" class="text-decoration-none"><?php echo t('Forum', 'Forum'); ?></a></li>
                <li class="breadcrumb-item active fw-medium text-dark"><?php echo t('Diskusi Baru', 'New Discussion'); ?></li>
            </ol>
        </nav>
    </div>

    <div class="card-modern p-4 p-md-5">
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
                <button type="submit" class="btn btn-primary rounded-pill px-4 py-2"><?php echo t('Buat Diskusi', 'Create Discussion'); ?></button>
                <a href="<?php echo base_url('forum/index/' . $course->slug); ?>" class="btn btn-outline-secondary rounded-pill px-4 py-2"><?php echo t('Batal', 'Cancel'); ?></a>
            </div>
        <?php echo form_close(); ?>
    </div>
</div>
