<div class="container my-5 py-3">
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card-modern p-4 p-md-5 animate-scale-in">
                <h4 class="fw-extrabold text-dark mb-4"><?php echo t('Ganti Password', 'Change Password'); ?></h4>
                <?php echo form_open('profile/change_password', array('class' => 'd-flex flex-column gap-3')); ?>
                    <div>
                        <label class="form-label small fw-bold text-dark"><?php echo t('Password Saat Ini', 'Current Password'); ?></label>
                        <input type="password" name="current_password" class="form-control" required>
                    </div>
                    <div>
                        <label class="form-label small fw-bold text-dark"><?php echo t('Password Baru', 'New Password'); ?></label>
                        <input type="password" name="new_password" class="form-control" required>
                    </div>
                    <div>
                        <label class="form-label small fw-bold text-dark"><?php echo t('Konfirmasi Password Baru', 'Confirm New Password'); ?></label>
                        <input type="password" name="confirm_password" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary py-2.5"><?php echo t('Ganti Password', 'Change Password'); ?></button>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
</div>
