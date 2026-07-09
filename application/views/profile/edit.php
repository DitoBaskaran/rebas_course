<div>
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card-modern p-4 p-md-5 animate-scale-in">
                <h4 class="fw-extrabold text-dark mb-4"><?php echo t('Edit Profil', 'Edit Profile'); ?></h4>
                <?php echo form_open_multipart('profile/edit', array('class' => 'd-flex flex-column gap-3')); ?>
                    <div class="text-center mb-3">
                        <img src="<?php echo base_url('uploads/avatars/' . ($user->avatar ?: 'default_avatar.png')); ?>" onerror="this.src='https://ui-avatars.com/api/?name=<?php echo urlencode($user->name); ?>&background=0d6efd&color=fff&size=100';" alt="" class="rounded-circle object-fit-cover mb-2" style="width: 100px; height: 100px;">
                        <input type="file" name="avatar" class="form-control form-control-sm">
                    </div>
                    <div>
                        <label class="form-label small fw-bold text-dark"><?php echo t('Nama', 'Name'); ?></label>
                        <input type="text" name="name" class="form-control" value="<?php echo set_value('name', $user->name); ?>" required>
                    </div>
                    <div>
                        <label class="form-label small fw-bold text-dark"><?php echo t('Bio', 'Bio'); ?></label>
                        <textarea name="bio" rows="3" class="form-control"><?php echo set_value('bio', $user->bio); ?></textarea>
                    </div>
                    <div>
                        <label class="form-label small fw-bold text-dark"><?php echo t('No. HP', 'Phone'); ?></label>
                        <input type="text" name="phone" class="form-control" value="<?php echo set_value('phone', $user->phone); ?>">
                    </div>
                    <button type="submit" class="btn btn-primary py-2.5"><?php echo t('Simpan', 'Save'); ?></button>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
</div>
