<div class="container-fluid px-0">

    <!-- ============ HEADER (hero) ============ -->
    <div class="bento-card mb-4 overflow-hidden" style="background:linear-gradient(120deg,#0D1830 0%,#164e63 100%);border:none;color:#fff;">
        <div class="d-flex align-items-center justify-content-between gap-3 position-relative" style="z-index:1;">
            <div class="d-flex align-items-center gap-3">
                <a href="<?php echo base_url('admin/users'); ?>" class="d-inline-flex align-items-center justify-content-center rounded-circle flex-shrink-0" style="width:38px;height:38px;background:rgba(255,255,255,0.14);border:1px solid rgba(255,255,255,0.2);color:#fff;">
                    <i data-lucide="arrow-left" style="width:16px;height:16px;"></i>
                </a>
                <span class="d-inline-flex align-items-center justify-content-center rounded-circle fw-bold text-white flex-shrink-0" style="width:52px;height:52px;background:rgba(255,255,255,0.16);border:1px solid rgba(255,255,255,0.25);font-size:1.25rem;">
                    <?php echo strtoupper(substr($user->name, 0, 1)); ?>
                </span>
                <div>
                    <span class="d-inline-flex align-items-center gap-1 mb-1" style="background:rgba(255,255,255,0.14);border:1px solid rgba(255,255,255,0.2);color:#FBBF24;font-size:0.62rem;font-weight:800;letter-spacing:0.1em;text-transform:uppercase;padding:0.22rem 0.6rem;border-radius:100px;">
                        <i data-lucide="user-cog" style="width:11px;height:11px;"></i> <?php echo t('Edit Pengguna', 'Edit User'); ?>
                    </span>
                    <h1 class="fw-extrabold text-white mb-0 lh-sm" style="letter-spacing:-0.03em;font-size:1.35rem;"><?php echo htmlspecialchars($user->name); ?></h1>
                    <div style="color:rgba(255,255,255,0.65);font-size:0.78rem;"><?php echo htmlspecialchars($user->email); ?></div>
                </div>
            </div>
        </div>
    </div>

    <?php echo form_open('admin/update_user/' . $user->id, array('id' => 'userForm')); ?>

    <div class="bento-grid bento-grid-2-1 mb-4" style="align-items:start;">
        <!-- ============ LEFT: FORM ============ -->
        <div class="d-flex flex-column gap-3">

            <!-- Identitas -->
            <div class="bento-card">
                <h6 class="fw-bold text-dark mb-3 d-flex align-items-center gap-2" style="font-size:0.85rem;">
                    <i data-lucide="id-card" style="width:16px;height:16px;color:var(--primary);"></i> <?php echo t('Identitas', 'Identity'); ?>
                </h6>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold small"><?php echo t('Nama', 'Name'); ?> *</label>
                        <input type="text" name="name" class="form-control" value="<?php echo htmlspecialchars($user->name); ?>" required style="border-radius:12px;font-size:0.88rem;height:44px;">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold small">Email *</label>
                        <input type="email" name="email" class="form-control" value="<?php echo htmlspecialchars($user->email); ?>" required style="border-radius:12px;font-size:0.88rem;height:44px;">
                    </div>
                </div>
            </div>

            <!-- Role & Peran -->
            <?php $is_super_admin = ($user->role === 'admin' && !$user->is_teacher && !$user->is_mentor); ?>
            <div class="bento-card">
                <h6 class="fw-bold text-dark mb-3 d-flex align-items-center gap-2" style="font-size:0.85rem;">
                    <i data-lucide="shield" style="width:16px;height:16px;color:#2563eb;"></i> <?php echo t('Role & Peran', 'Role & Positions'); ?>
                </h6>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold small"><?php echo t('Role Utama', 'Primary Role'); ?></label>
                        <select name="role" class="form-select" style="border-radius:12px;font-size:0.85rem;height:44px;">
                            <option value="student" <?php echo (!$is_super_admin && $user->role !== 'admin') ? 'selected' : ''; ?>>Student</option>
                            <option value="admin" <?php echo $is_super_admin ? 'selected' : ''; ?>>Admin</option>
                        </select>
                        <small class="field-hint"><?php echo t('Admin memiliki akses penuh ke seluruh panel.', 'Admin has full access to the entire panel.'); ?></small>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold small d-block"><?php echo t('Peran Tambahan', 'Additional Roles'); ?></label>
                        <div class="d-flex flex-column gap-2 mt-1">
                            <label class="toggle-switch">
                                <input type="checkbox" name="is_teacher" value="1" id="isTeacher" <?php echo $user->is_teacher ? 'checked' : ''; ?>>
                                <span class="track"></span>
                                <span class="toggle-label"><?php echo t('Juga Guru (Teacher)', 'Also Teacher'); ?></span>
                            </label>
                            <label class="toggle-switch">
                                <input type="checkbox" name="is_mentor" value="1" id="isMentor" <?php echo $user->is_mentor ? 'checked' : ''; ?>>
                                <span class="track"></span>
                                <span class="toggle-label"><?php echo t('Juga Mentor', 'Also Mentor'); ?></span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Status Akun -->
            <div class="bento-card">
                <h6 class="fw-bold text-dark mb-3 d-flex align-items-center gap-2" style="font-size:0.85rem;">
                    <i data-lucide="activity" style="width:16px;height:16px;color:var(--warning);"></i> <?php echo t('Status Akun', 'Account Status'); ?>
                </h6>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold small"><?php echo t('Status', 'Status'); ?></label>
                        <select name="status" id="pv_status" class="form-select" style="border-radius:12px;font-size:0.85rem;height:44px;">
                            <option value="active" <?php echo ($user->status === 'active' || !$user->status) ? 'selected' : ''; ?>>Active</option>
                            <option value="suspended" <?php echo $user->status === 'suspended' ? 'selected' : ''; ?>>Suspended</option>
                            <option value="banned" <?php echo $user->status === 'banned' ? 'selected' : ''; ?>>Banned</option>
                        </select>
                    </div>
                    <div class="col-md-6 d-flex align-items-end">
                        <small class="field-hint"><i class="fas fa-info-circle" style="font-size:0.7rem;"></i> <?php echo t('Banned/Suspended memblokir login user ini.', 'Banned/Suspended blocks this user from logging in.'); ?></small>
                    </div>
                </div>
            </div>
        </div>

        <!-- ============ RIGHT: INFO + ACTIONS ============ -->
        <div class="d-flex flex-column gap-3" style="position:sticky;top:1rem;">
            <div class="bento-card">
                <h6 class="fw-bold text-dark mb-3 d-flex align-items-center gap-2" style="font-size:0.8rem;">
                    <i data-lucide="info" style="width:15px;height:15px;color:var(--gray-400,#94a3b8);"></i> <?php echo t('Info Akun', 'Account Info'); ?>
                </h6>
                <div class="d-flex flex-column gap-2">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="text-secondary" style="font-size:0.75rem;"><i data-lucide="calendar" style="width:12px;height:12px;" class="me-1"></i><?php echo t('Terdaftar', 'Registered'); ?></span>
                        <span class="fw-bold text-dark" style="font-size:0.78rem;"><?php echo date('d M Y', strtotime($user->created_at)); ?></span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="text-secondary" style="font-size:0.75rem;"><i data-lucide="hash" style="width:12px;height:12px;" class="me-1"></i>User ID</span>
                        <span class="fw-bold text-dark" style="font-size:0.78rem;">#<?php echo $user->id; ?></span>
                    </div>
                    <?php if (!empty($enrolled_count)): ?>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="text-secondary" style="font-size:0.75rem;"><i data-lucide="book-open" style="width:12px;height:12px;" class="me-1"></i><?php echo t('Kelas Diikuti', 'Enrolled Courses'); ?></span>
                        <span class="fw-bold text-dark" style="font-size:0.78rem;"><?php echo $enrolled_count; ?></span>
                    </div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="bento-card d-flex flex-column gap-2">
                <a href="<?php echo base_url('admin/permissions/' . $user->id); ?>" class="btn fw-semibold rounded-pill d-inline-flex align-items-center justify-content-center gap-2 border-0" style="background:#eff6ff;color:#2563eb;font-size:0.8rem;padding:0.65rem;">
                    <i data-lucide="shield-check" style="width:16px;height:16px;"></i> <?php echo t('Kelola Akses Menu', 'Manage Menu Access'); ?>
                </a>
                <button type="submit" form="userForm" class="btn fw-semibold rounded-pill d-inline-flex align-items-center justify-content-center gap-2 border-0" style="background:#0D1830;color:#fff;font-size:0.8rem;padding:0.65rem;">
                    <i data-lucide="save" style="width:16px;height:16px;"></i> <?php echo t('Simpan Perubahan', 'Save Changes'); ?>
                </button>
                <a href="<?php echo base_url('admin/users'); ?>" class="btn fw-semibold rounded-pill d-inline-flex align-items-center justify-content-center gap-2 border-0" style="background:#E6EBEF;color:#57534e;font-size:0.8rem;padding:0.65rem;">
                    <?php echo t('Batal', 'Cancel'); ?>
                </a>
            </div>
        </div>
    </div>
    <?php echo form_close(); ?>
</div>
