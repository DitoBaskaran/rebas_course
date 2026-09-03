<div class="container-fluid px-0">
    <div class="d-flex align-items-center gap-2 mb-5">
        <a href="<?php echo base_url('admin/users'); ?>" class="btn btn-outline-dark btn-sm rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width: 36px; height: 36px;">
            <i data-lucide="arrow-left" style="width:16px;height:16px;"></i>
        </a>
        <div>
            <span class="text-primary fw-semibold small text-uppercase tracking-wide d-block mb-1">Pengguna</span>
            <h1 class="display-6 fw-extrabold text-dark mb-0 lh-sm" style="letter-spacing: -0.03em;"><?php echo t('Edit Pengguna', 'Edit User'); ?></h1>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="bento-card">
                <div class="d-flex align-items-center gap-2 px-4 px-xl-5 py-3 border-bottom" style="background:var(--card-bg);">
                    <i data-lucide="user" style="width:18px;height:18px;color:var(--primary);"></i>
                    <span class="fw-semibold"><?php echo htmlspecialchars($user->name); ?></span>
                </div>
                <?php echo form_open('admin/update_user/' . $user->id); ?>
                    <div class="card-body d-flex flex-column gap-4 p-4 p-xl-5">
                        <div class="d-flex align-items-center gap-3 mb-2">
                            <span class="d-flex align-items-center justify-content-center rounded-circle fw-bold text-white" style="width:56px;height:56px;background:var(--primary);font-size:1.2rem;">
                                <?php echo strtoupper(substr($user->name, 0, 1)); ?>
                            </span>
                            <div>
                                <div class="fw-bold text-dark"><?php echo htmlspecialchars($user->name); ?></div>
                                <div class="small text-muted"><?php echo htmlspecialchars($user->email); ?></div>
                                <div class="small text-muted"><?php echo t('Terdaftar:', 'Registered:'); ?> <?php echo date('d M Y', strtotime($user->created_at)); ?></div>
                            </div>
                        </div>
                        <div class="row g-4">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold"><?php echo t('Nama', 'Name'); ?></label>
                                <input type="text" name="name" class="form-control" value="<?php echo htmlspecialchars($user->name); ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Email</label>
                                <input type="email" name="email" class="form-control" value="<?php echo htmlspecialchars($user->email); ?>" required>
                            </div>
                        </div>
                        <div class="row g-4">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold"><?php echo t('Role', 'Role'); ?></label>
                                <?php $is_super_admin = ($user->role === 'admin' && !$user->is_teacher && !$user->is_mentor); ?>
                                <select name="role" class="form-select mb-2">
                                    <option value="student" <?php echo (!$is_super_admin && $user->role !== 'admin') ? 'selected' : ''; ?>>Student</option>
                                    <option value="admin" <?php echo $is_super_admin ? 'selected' : ''; ?>>Admin</option>
                                </select>
                                <div class="d-flex gap-3 mt-2">
                                    <div class="form-check">
                                        <input type="checkbox" name="is_teacher" value="1" class="form-check-input" id="isTeacher" <?php echo $user->is_teacher ? 'checked' : ''; ?>>
                                        <label class="form-check-label fw-semibold small" for="isTeacher"><?php echo t('Juga Teacher', 'Also Teacher'); ?></label>
                                    </div>
                                    <div class="form-check">
                                        <input type="checkbox" name="is_mentor" value="1" class="form-check-input" id="isMentor" <?php echo $user->is_mentor ? 'checked' : ''; ?>>
                                        <label class="form-check-label fw-semibold small" for="isMentor"><?php echo t('Juga Mentor', 'Also Mentor'); ?></label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold"><?php echo t('Status', 'Status'); ?></label>
                                <select name="status" class="form-select">
                                    <option value="active" <?php echo ($user->status === 'active' || !$user->status) ? 'selected' : ''; ?>>Active</option>
                                    <option value="suspended" <?php echo $user->status === 'suspended' ? 'selected' : ''; ?>>Suspended</option>
                                    <option value="banned" <?php echo $user->status === 'banned' ? 'selected' : ''; ?>>Banned</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end gap-2 px-4 px-xl-5 py-3 border-top">
                        <a href="<?php echo base_url('admin/users'); ?>" class="btn btn-outline-secondary btn-sm rounded-pill px-4"><?php echo t('Kembali', 'Back'); ?></a>
                        <a href="<?php echo base_url('admin/permissions/' . $user->id); ?>" class="btn btn-outline-primary btn-sm rounded-pill px-4 d-flex align-items-center gap-1">
                            <i data-lucide="shield" style="width:16px;height:16px;"></i> <?php echo t('Kelola Akses Menu', 'Manage Menu Access'); ?>
                        </a>
                        <button type="submit" class="btn btn-primary btn-sm rounded-pill px-4 d-flex align-items-center gap-1">
                            <i data-lucide="save" style="width:16px;height:16px;"></i> <?php echo t('Simpan', 'Save'); ?>
                        </button>
                    </div>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
</div>
