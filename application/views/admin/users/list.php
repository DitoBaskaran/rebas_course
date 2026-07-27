<div class="container-fluid py-4" style="max-width: 1400px;">
    <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between mb-4 gap-3">
        <div>
            <div style="color: #f97316; font-weight: 700; font-size: 0.7rem; text-transform: uppercase; letter-spacing: 0.08em; margin-bottom: 0.15rem;"><?php echo t('Pengguna', 'Users'); ?></div>
            <h4 class="fw-extrabold mb-0" style="color: #1c1917; letter-spacing: -0.02em; font-size: 1.4rem;"><?php echo t('Manajemen Pengguna', 'User Management'); ?></h4>
            <p style="color: #78716c; font-size: 0.82rem; margin-bottom: 0;"><?php echo t('Kelola semua pengguna platform.', 'Manage all platform users.'); ?></p>
        </div>
        <div><span class="px-3 py-2 rounded-pill fw-semibold" style="background: #fff7ed; color: #f97316; font-size: 0.78rem;"><?php echo $total; ?> <?php echo t('pengguna', 'users'); ?></span></div>
    </div>

    <?php $selected_role = $this->input->get('role'); ?>
    <?php $selected_status = $this->input->get('status'); ?>
    <?php $search_val = $this->input->get('search'); ?>
    <form method="get" class="d-flex gap-2 mb-4 flex-wrap" id="filterForm">
        <div class="position-relative flex-fill" style="min-width: 200px; max-width: 320px;">
            <i class="fas fa-search" style="font-size: 0.75rem; position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: #a8a29e; pointer-events: none;"></i>
            <input type="text" name="search" class="form-control rounded-pill" style="padding-left: 36px; height: 40px; border-color: #e7e5e4; font-size: 0.82rem;" placeholder="<?php echo t('Cari pengguna...', 'Search users...'); ?>" id="searchInput" value="<?php echo htmlspecialchars($search_val ?: ''); ?>">
        </div>
        <select name="role" class="form-select rounded-pill" style="width: auto; height: 40px; border-color: #e7e5e4; font-size: 0.82rem;" onchange="this.form.submit()" id="roleFilter">
            <option value=""><?php echo t('Semua Role', 'All Roles'); ?></option>
            <option value="student" <?php echo $selected_role === 'student' ? 'selected' : ''; ?>>Student</option>
            <option value="teacher" <?php echo $selected_role === 'teacher' ? 'selected' : ''; ?>>Teacher</option>
            <option value="mentor" <?php echo $selected_role === 'mentor' ? 'selected' : ''; ?>>Mentor</option>
            <option value="admin" <?php echo $selected_role === 'admin' ? 'selected' : ''; ?>>Admin</option>
        </select>
        <select name="status" class="form-select rounded-pill" style="width: auto; height: 40px; border-color: #e7e5e4; font-size: 0.82rem;" onchange="this.form.submit()" id="statusFilter">
            <option value=""><?php echo t('Semua Status', 'All Status'); ?></option>
            <option value="active" <?php echo $selected_status === 'active' ? 'selected' : ''; ?>>Active</option>
            <option value="banned" <?php echo $selected_status === 'banned' ? 'selected' : ''; ?>>Banned</option>
        </select>
    </form>

    <div class="border rounded-3" style="border-color: #e7e5e4; border-radius: 12px; overflow: hidden;">
        <div class="table-responsive p-0">
            <table class="table mb-0" style="font-size: 0.8rem;" id="userTable">
                <thead>
                    <tr>
                        <th style="font-weight: 600; color: #78716c; font-size: 0.68rem; border-color: #e7e5e4; padding: 0.7rem 1rem; background: #fafaf9; text-transform: uppercase; letter-spacing: 0.05em;"><?php echo t('Nama', 'Name'); ?></th>
                        <th style="font-weight: 600; color: #78716c; font-size: 0.68rem; border-color: #e7e5e4; padding: 0.7rem 1rem; background: #fafaf9; text-transform: uppercase; letter-spacing: 0.05em;">Email</th>
                        <th style="font-weight: 600; color: #78716c; font-size: 0.68rem; border-color: #e7e5e4; padding: 0.7rem 1rem; background: #fafaf9; text-transform: uppercase; letter-spacing: 0.05em;"><?php echo t('Role', 'Role'); ?></th>
                        <th style="font-weight: 600; color: #78716c; font-size: 0.68rem; border-color: #e7e5e4; padding: 0.7rem 1rem; background: #fafaf9; text-transform: uppercase; letter-spacing: 0.05em;"><?php echo t('Status', 'Status'); ?></th>
                        <th style="font-weight: 600; color: #78716c; font-size: 0.68rem; border-color: #e7e5e4; padding: 0.7rem 1rem; background: #fafaf9; text-transform: uppercase; letter-spacing: 0.05em;"><?php echo t('Terdaftar', 'Registered'); ?></th>
                        <th style="font-weight: 600; color: #78716c; font-size: 0.68rem; border-color: #e7e5e4; padding: 0.7rem 1rem; background: #fafaf9; text-transform: uppercase; letter-spacing: 0.05em; text-align: center; width: 80px;"><?php echo t('Aksi', 'Action'); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($users)): ?><tr><td colspan="6" class="text-center py-5" style="color: #a8a29e;"><?php echo t('Tidak ada pengguna.', 'No users found.'); ?></td></tr>
                    <?php else: ?>
                        <?php foreach ($users as $u): ?>
                            <tr>
                                <td style="border-color: #f0eeeb; padding: 0.65rem 1rem; font-weight: 700; color: #1c1917; font-size: 0.78rem;"><?php echo htmlspecialchars($u->name); ?></td>
                                <td style="border-color: #f0eeeb; padding: 0.65rem 1rem; color: #57534e; font-size: 0.78rem;"><?php echo htmlspecialchars($u->email); ?></td>
                                <?php
                                    $role_badges = array();
                                    if ($u->role === 'admin') { $role_badges[] = '<span class="px-2 py-1 rounded-pill fw-semibold" style="background: #fef2f2; color: #f43f5e; font-size: 0.6rem;">Admin</span>'; }
                                    if ($u->is_teacher) { $role_badges[] = '<span class="px-2 py-1 rounded-pill fw-semibold" style="background: #fff7ed; color: #f97316; font-size: 0.6rem;">Teacher</span>'; }
                                    if ($u->is_mentor) { $role_badges[] = '<span class="px-2 py-1 rounded-pill fw-semibold" style="background: #faf5ff; color: #a855f7; font-size: 0.6rem;">Mentor</span>'; }
                                    if (empty($role_badges)) { $role_badges[] = '<span class="px-2 py-1 rounded-pill fw-semibold" style="background: #f0fdfa; color: #10b981; font-size: 0.6rem;">Student</span>'; }
                                    echo implode(' ', $role_badges);
                                ?></td>
                                <td style="border-color: #f0eeeb; padding: 0.65rem 1rem;"><?php if ($u->status === 'active' || !$u->status): ?><span class="px-2 py-1 rounded-pill fw-semibold" style="background: #f0fdfa; color: #10b981; font-size: 0.6rem;">Active</span><?php elseif ($u->status === 'suspended'): ?><span class="px-2 py-1 rounded-pill fw-semibold" style="background: #fff7ed; color: #f97316; font-size: 0.6rem;">Suspended</span><?php else: ?><span class="px-2 py-1 rounded-pill fw-semibold" style="background: #fef2f2; color: #f43f5e; font-size: 0.6rem;">Banned</span><?php endif; ?></td>
                                <td style="border-color: #f0eeeb; padding: 0.65rem 1rem; color: #a8a29e; font-size: 0.72rem;"><?php echo date('d M Y', strtotime($u->created_at)); ?></td>
                                <td style="border-color: #f0eeeb; padding: 0.65rem 1rem; text-align: center;"><a href="<?php echo base_url('admin/edit_user/' . $u->id); ?>" class="btn btn-sm rounded-pill px-2 d-inline-flex align-items-center" style="background: #f97316; color: #fff; font-size: 0.68rem;" title="<?php echo t('Edit', 'Edit'); ?>"><i class="fas fa-edit" style="font-size: 0.65rem;"></i></a></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script>
document.getElementById('searchInput')?.addEventListener('keydown', function(e) {
    if (e.key === 'Enter') { e.preventDefault(); this.form.submit(); }
});
</script>
