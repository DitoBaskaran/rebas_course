<div class="app-page">
    <!-- Header -->
    <div class="app-page-head">
        <div>
            <h4 class="app-page-title"><i class="fas fa-users"></i> <?php echo t('Manajemen Pengguna', 'User Management'); ?></h4>
            <p class="app-page-sub"><?php echo t('Kelola semua pengguna platform.', 'Manage all platform users.'); ?></p>
        </div>
        <div class="app-page-actions">
            <span class="app-chip app-chip-amber"><i class="fas fa-user-check"></i> <?php echo $total; ?> <?php echo t('pengguna', 'users'); ?></span>
        </div>
    </div>

    <?php
        $selected_role = $this->input->get('role');
        $selected_status = $this->input->get('status');
        $search_val = $this->input->get('search');
    ?>
    <form method="get" class="app-toolbar" id="filterForm">
        <div class="app-search">
            <i class="fas fa-search"></i>
            <input type="text" name="search" placeholder="<?php echo t('Cari pengguna...', 'Search users...'); ?>" id="searchInput" value="<?php echo htmlspecialchars($search_val ?: ''); ?>">
        </div>
        <select name="role" class="app-select" onchange="this.form.submit()">
            <option value=""><?php echo t('Semua Role', 'All Roles'); ?></option>
            <option value="student" <?php echo $selected_role === 'student' ? 'selected' : ''; ?>>Student</option>
            <option value="teacher" <?php echo $selected_role === 'teacher' ? 'selected' : ''; ?>>Teacher</option>
            <option value="mentor" <?php echo $selected_role === 'mentor' ? 'selected' : ''; ?>>Mentor</option>
            <option value="admin" <?php echo $selected_role === 'admin' ? 'selected' : ''; ?>>Admin</option>
        </select>
        <select name="status" class="app-select" onchange="this.form.submit()">
            <option value=""><?php echo t('Semua Status', 'All Status'); ?></option>
            <option value="active" <?php echo $selected_status === 'active' ? 'selected' : ''; ?>>Active</option>
            <option value="banned" <?php echo $selected_status === 'banned' ? 'selected' : ''; ?>>Banned</option>
        </select>
    </form>

    <!-- Mobile: kartu eksplisit (1 baris kompak) -->
    <div class="app-row-list app-list">
        <?php foreach ($users as $u): ?>
            <?php
                $badges = array();
                if ($u->role === 'admin') $badges[] = 'Admin';
                elseif ($u->is_teacher && $u->is_mentor) $badges[] = 'Teacher · Mentor';
                elseif ($u->is_teacher) $badges[] = 'Teacher';
                elseif ($u->is_mentor) $badges[] = 'Mentor';
                else $badges[] = 'Student';
                $role_txt = implode(', ', $badges);
                $status_chip = ($u->status === 'active' || !$u->status)
                    ? '<span class="app-chip app-chip-green"><i class="fas fa-check-circle"></i> Active</span>'
                    : '<span class="app-chip app-chip-red"><i class="fas fa-ban"></i> Banned</span>';
            ?>
            <div class="app-row app-row-card">
                <div class="app-row-head">
                    <span class="app-avatar" style="width:38px;height:38px;font-size:0.8rem;flex-shrink:0;"><?php echo strtoupper(substr($u->name, 0, 1)); ?></span>
                    <div class="app-row-main">
                        <div class="app-row-title"><?php echo htmlspecialchars($u->name); ?></div>
                        <div class="app-row-sub"><?php echo htmlspecialchars($u->email); ?><span class="mob-sub-sep">·</span><?php echo $role_txt; ?></div>
                    </div>
                    <?php echo $status_chip; ?>
                </div>
                <div class="app-actions">
                    <a href="<?php echo base_url('admin/edit_user/' . $u->id); ?>" class="app-action app-action-dark" title="<?php echo t('Edit', 'Edit'); ?>"><i class="fas fa-edit"></i></a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- Desktop: tabel -->
    <div class="app-card app-table-desktop">
        <div class="app-table-wrap">
            <table class="app-table">
                <thead>
                    <tr>
                        <th><?php echo t('Nama', 'Name'); ?></th>
                        <th>Email</th>
                        <th><?php echo t('Role', 'Role'); ?></th>
                        <th><?php echo t('Status', 'Status'); ?></th>
                        <th><?php echo t('Terdaftar', 'Registered'); ?></th>
                        <th class="td-actions"><?php echo t('Aksi', 'Action'); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $u): ?>
                        <tr>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <span class="app-avatar" style="width:34px;height:34px;font-size:0.75rem;"><?php echo strtoupper(substr($u->name, 0, 1)); ?></span>
                                    <div class="min-w-0">
                                        <div class="app-row-title"><?php echo htmlspecialchars($u->name); ?></div>
                                    </div>
                                </div>
                            </td>
                            <td style="color:#57534e;font-size:0.78rem;"><?php echo htmlspecialchars($u->email); ?></td>
                            <td>
                                <?php
                                    $badges = array();
                                    if ($u->role === 'admin') $badges[] = '<span class="role-badge role-badge-admin">Admin</span>';
                                    if ($u->is_teacher) $badges[] = '<span class="role-badge role-badge-teacher">Teacher</span>';
                                    if ($u->is_mentor) $badges[] = '<span class="role-badge role-badge-mentor">Mentor</span>';
                                    if (empty($badges)) $badges[] = '<span class="role-badge role-badge-student">Student</span>';
                                    echo implode(' ', $badges);
                                ?>
                            </td>
                            <td>
                                <?php if ($u->status === 'active' || !$u->status): ?>
                                    <span class="app-chip app-chip-green"><i class="fas fa-check-circle"></i> Active</span>
                                <?php else: ?>
                                    <span class="app-chip app-chip-red"><i class="fas fa-ban"></i> Banned</span>
                                <?php endif; ?>
                            </td>
                            <td style="color:#a8a29e;font-size:0.72rem;"><?php echo date('d M Y', strtotime($u->created_at)); ?></td>
                            <td class="td-actions">
                                <a href="<?php echo base_url('admin/edit_user/' . $u->id); ?>" class="app-action app-action-dark" title="<?php echo t('Edit', 'Edit'); ?>"><i class="fas fa-edit"></i></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
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
