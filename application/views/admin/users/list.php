<div class="container-fluid py-4" style="max-width: 1400px;">
    <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between mb-4 gap-3">
        <div>
            <div class="text-uppercase fw-bold mb-0" style="color: #0D1830; font-size: 0.7rem; letter-spacing: 0.08em;"><?php echo t('Pengguna', 'Users'); ?></div>
            <h4 class="fw-extrabold mb-0" style="color: #0D1830; letter-spacing: -0.02em; font-size: 1.4rem;"><?php echo t('Manajemen Pengguna', 'User Management'); ?></h4>
            <p class="mb-0" style="color: #78716c; font-size: 0.82rem;"><?php echo t('Kelola semua pengguna platform.', 'Manage all platform users.'); ?></p>
        </div>
        <div><span class="px-3 py-2 rounded-pill fw-semibold" style="background: #fff7ed; color: #0D1830; font-size: 0.78rem;"><?php echo $total; ?> <?php echo t('pengguna', 'users'); ?></span></div>
    </div>

    <?php
        $selected_role = $this->input->get('role');
        $selected_status = $this->input->get('status');
        $search_val = $this->input->get('search');
    ?>
    <form method="get" class="d-flex gap-2 mb-4 flex-wrap" id="filterForm">
        <div class="position-relative flex-fill" style="min-width: 200px; max-width: 320px;">
            <i class="fas fa-search" style="font-size: 0.75rem; position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: #a8a29e; pointer-events: none;"></i>
            <input type="text" name="search" class="form-control rounded-pill" style="padding-left: 36px; height: 40px; border-color: #e7e5e4; font-size: 0.82rem;" placeholder="<?php echo t('Cari pengguna...', 'Search users...'); ?>" id="searchInput" value="<?php echo htmlspecialchars($search_val ?: ''); ?>">
        </div>
        <select name="role" class="form-select rounded-pill" style="width: auto; height: 40px; border-color: #e7e5e4; font-size: 0.82rem;" onchange="this.form.submit()">
            <option value=""><?php echo t('Semua Role', 'All Roles'); ?></option>
            <option value="student" <?php echo $selected_role === 'student' ? 'selected' : ''; ?>>Student</option>
            <option value="teacher" <?php echo $selected_role === 'teacher' ? 'selected' : ''; ?>>Teacher</option>
            <option value="mentor" <?php echo $selected_role === 'mentor' ? 'selected' : ''; ?>>Mentor</option>
            <option value="admin" <?php echo $selected_role === 'admin' ? 'selected' : ''; ?>>Admin</option>
        </select>
        <select name="status" class="form-select rounded-pill" style="width: auto; height: 40px; border-color: #e7e5e4; font-size: 0.82rem;" onchange="this.form.submit()">
            <option value=""><?php echo t('Semua Status', 'All Status'); ?></option>
            <option value="active" <?php echo $selected_status === 'active' ? 'selected' : ''; ?>>Active</option>
            <option value="banned" <?php echo $selected_status === 'banned' ? 'selected' : ''; ?>>Banned</option>
        </select>
    </form>

    <div class="border rounded-3" style="border-color: #e7e5e4; border-radius: 12px; overflow: hidden;">
        <div class="table-responsive p-0">
            <table class="table table-hover mb-0 align-middle" style="font-size: 0.8rem;" id="userTable">
                <thead>
                    <tr>
                        <th class="fw-semibold text-uppercase" style="color: #78716c; font-size: 0.68rem; border-color: #e7e5e4; padding: 0.7rem 1rem; background: #E6EBEF; letter-spacing: 0.05em; width: 30%;"><?php echo t('Nama', 'Name'); ?></th>
                        <th class="fw-semibold text-uppercase d-none d-md-table-cell" style="color: #78716c; font-size: 0.68rem; border-color: #e7e5e4; padding: 0.7rem 1rem; background: #E6EBEF; letter-spacing: 0.05em;">Email</th>
                        <th class="fw-semibold text-uppercase" style="color: #78716c; font-size: 0.68rem; border-color: #e7e5e4; padding: 0.7rem 1rem; background: #E6EBEF; letter-spacing: 0.05em; width: 18%;"><?php echo t('Role', 'Role'); ?></th>
                        <th class="fw-semibold text-uppercase" style="color: #78716c; font-size: 0.68rem; border-color: #e7e5e4; padding: 0.7rem 1rem; background: #E6EBEF; letter-spacing: 0.05em; width: 12%;"><?php echo t('Status', 'Status'); ?></th>
                        <th class="fw-semibold text-uppercase d-none d-lg-table-cell" style="color: #78716c; font-size: 0.68rem; border-color: #e7e5e4; padding: 0.7rem 1rem; background: #E6EBEF; letter-spacing: 0.05em; width: 15%;"><?php echo t('Terdaftar', 'Registered'); ?></th>
                        <th class="fw-semibold text-uppercase text-center" style="color: #78716c; font-size: 0.68rem; border-color: #e7e5e4; padding: 0.7rem 1rem; background: #E6EBEF; letter-spacing: 0.05em; width: 80px;"><?php echo t('Aksi', 'Action'); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($users)): ?>
                    <tr>
                        <td colspan="6" class="text-center py-5" style="color: #a8a29e;"><?php echo t('Tidak ada pengguna.', 'No users found.'); ?></td>
                    </tr>
                    <?php else: ?>
                        <?php foreach ($users as $u): ?>
                        <tr>
                            <td style="border-color: #f0eeeb; padding: 0.65rem 1rem; font-weight: 700; color: #0D1830; font-size: 0.78rem;">
                                <div class="d-flex align-items-center gap-2">
                                    <span class="d-flex align-items-center justify-content-center rounded-circle fw-bold text-white flex-shrink-0" style="width: 32px; height: 32px; background: #0D1830; font-size: 0.72rem;"><?php echo strtoupper(substr($u->name, 0, 1)); ?></span>
                                    <div class="min-w-0">
                                        <div class="text-truncate"><?php echo htmlspecialchars($u->name); ?></div>
                                        <div class="d-block d-md-none" style="color: #a8a29e; font-size: 0.68rem;"><?php echo htmlspecialchars($u->email); ?></div>
                                    </div>
                                </div>
                            </td>
                            <td class="d-none d-md-table-cell" style="border-color: #f0eeeb; padding: 0.65rem 1rem; color: #57534e; font-size: 0.78rem;"><?php echo htmlspecialchars($u->email); ?></td>
                            <td style="border-color: #f0eeeb; padding: 0.65rem 1rem;">
                                <?php
                                    $badges = array();
                                    if ($u->role === 'admin') $badges[] = '<span class="role-badge role-badge-admin">Admin</span>';
                                    if ($u->is_teacher) $badges[] = '<span class="role-badge role-badge-teacher">Teacher</span>';
                                    if ($u->is_mentor) $badges[] = '<span class="role-badge role-badge-mentor">Mentor</span>';
                                    if (empty($badges)) $badges[] = '<span class="role-badge role-badge-student">Student</span>';
                                    echo implode(' ', $badges);
                                ?>
                            </td>
                            <td style="border-color: #f0eeeb; padding: 0.65rem 1rem;">
                                <?php if ($u->status === 'active' || !$u->status): ?>
                                    <span class="status-badge status-badge-active">Active</span>
                                <?php else: ?>
                                    <span class="status-badge status-badge-banned">Banned</span>
                                <?php endif; ?>
                            </td>
                            <td class="d-none d-lg-table-cell" style="border-color: #f0eeeb; padding: 0.65rem 1rem; color: #a8a29e; font-size: 0.72rem;"><?php echo date('d M Y', strtotime($u->created_at)); ?></td>
                            <td style="border-color: #f0eeeb; padding: 0.65rem 1rem; text-align: center;">
                                <a href="<?php echo base_url('admin/edit_user/' . $u->id); ?>" class="btn btn-sm rounded-pill px-2 d-inline-flex align-items-center" style="background: #0D1830; color: #fff; font-size: 0.68rem;" title="<?php echo t('Edit', 'Edit'); ?>">
                                    <i class="fas fa-edit" style="font-size: 0.65rem;"></i>
                                </a>
                            </td>
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