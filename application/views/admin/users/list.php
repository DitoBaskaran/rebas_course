<div class="container-fluid px-0">

    <!-- ============ HEADER (hero) ============ -->
    <?php
        $active_n = 0; $banned_n = 0; $teacher_n = 0;
        foreach ($users as $u) {
            if ($u->status === 'banned') $banned_n++;
            else $active_n++;
            if ($u->is_teacher) $teacher_n++;
        }
    ?>
    <div class="bento-card mb-4 overflow-hidden" style="background:linear-gradient(120deg,#0D1830 0%,#164e63 100%);border:none;color:#fff;">
        <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3 position-relative" style="z-index:1;">
            <div>
                <span class="d-inline-flex align-items-center gap-1" style="background:rgba(255,255,255,0.14);border:1px solid rgba(255,255,255,0.2);color:#FBBF24;font-size:0.66rem;font-weight:800;letter-spacing:0.12em;text-transform:uppercase;padding:0.3rem 0.7rem;border-radius:100px;">
                    <i data-lucide="users" style="width:12px;height:12px;"></i>
                    <?php echo t('Anggota', 'Members'); ?>
                </span>
                <h1 class="fw-extrabold text-white mb-1 mt-2 lh-sm" style="letter-spacing:-0.03em;font-size:1.6rem;">
                    <?php echo t('Manajemen Pengguna', 'User Management'); ?>
                </h1>
                <p class="mb-0" style="color:rgba(255,255,255,0.72);font-size:0.82rem;">
                    <?php echo t('Kelola semua pengguna platform.', 'Manage all platform users.'); ?>
                    <span class="fw-semibold text-white">(<?php echo $total; ?>)</span>
                </p>
            </div>
            <div class="d-flex gap-2 flex-wrap flex-shrink-0">
                <a href="<?php echo base_url('admin/role_permissions'); ?>" class="btn fw-semibold rounded-pill d-inline-flex align-items-center gap-2 border-0" style="background:rgba(255,255,255,0.14);color:#fff;font-size:0.76rem;padding:0.5rem 1rem;">
                    <i data-lucide="shield-check" style="width:13px;height:13px;"></i> <?php echo t('Role Default', 'Default Roles'); ?>
                </a>
            </div>
        </div>
    </div>

    <!-- ============ KPI ============ -->
    <div class="bento-grid bento-grid-3 mb-4">
        <div class="bento-card blob-primary">
            <div class="d-flex align-items-center gap-3">
                <div class="bento-icon bg-primary-subtle text-primary"><i data-lucide="users" style="width:22px;height:22px;"></i></div>
                <div>
                    <div class="bento-label"><?php echo t('Total Pengguna', 'Total Users'); ?></div>
                    <div class="bento-value"><?php echo $total; ?></div>
                </div>
            </div>
        </div>
        <div class="bento-card blob-success">
            <div class="d-flex align-items-center gap-3">
                <div class="bento-icon bg-success-subtle text-success"><i data-lucide="user-check" style="width:22px;height:22px;"></i></div>
                <div>
                    <div class="bento-label"><?php echo t('Aktif', 'Active'); ?></div>
                    <div class="bento-value"><?php echo $active_n; ?></div>
                </div>
            </div>
        </div>
        <div class="bento-card blob-danger">
            <div class="d-flex align-items-center gap-3">
                <div class="bento-icon bg-danger-subtle text-danger"><i data-lucide="user-x" style="width:22px;height:22px;"></i></div>
                <div>
                    <div class="bento-label"><?php echo t('Banned', 'Banned'); ?></div>
                    <div class="bento-value"><?php echo $banned_n; ?></div>
                </div>
            </div>
        </div>
    </div>

    <?php
        $selected_role = $this->input->get('role');
        $selected_status = $this->input->get('status');
        $search_val = $this->input->get('search');
    ?>

    <!-- ============ TOOLBAR ============ -->
    <form method="get" class="bento-card d-flex flex-column flex-md-row gap-2 mb-4" id="filterForm" style="padding:0.8rem 1rem;">
        <div class="flex-fill position-relative">
            <i data-lucide="search" style="width:15px;height:15px;position:absolute;left:0.9rem;top:50%;transform:translateY(-50%);color:var(--gray-400,#94a3b8);"></i>
            <input type="text" name="search" placeholder="<?php echo t('Cari nama atau email...', 'Search name or email...'); ?>" id="searchInput" value="<?php echo htmlspecialchars($search_val ?: ''); ?>" style="padding-left:2.3rem;border-radius:100px;font-size:0.82rem;" class="form-control">
        </div>
        <select name="role" class="form-select" style="max-width:170px;border-radius:100px;font-size:0.82rem;" onchange="this.form.submit()">
            <option value=""><?php echo t('Semua Role', 'All Roles'); ?></option>
            <option value="student" <?php echo $selected_role === 'student' ? 'selected' : ''; ?>>Student</option>
            <option value="teacher" <?php echo $selected_role === 'teacher' ? 'selected' : ''; ?>>Teacher</option>
            <option value="mentor" <?php echo $selected_role === 'mentor' ? 'selected' : ''; ?>>Mentor</option>
            <option value="admin" <?php echo $selected_role === 'admin' ? 'selected' : ''; ?>>Admin</option>
        </select>
        <select name="status" class="form-select" style="max-width:160px;border-radius:100px;font-size:0.82rem;" onchange="this.form.submit()">
            <option value=""><?php echo t('Semua Status', 'All Status'); ?></option>
            <option value="active" <?php echo $selected_status === 'active' ? 'selected' : ''; ?>>Active</option>
            <option value="banned" <?php echo $selected_status === 'banned' ? 'selected' : ''; ?>>Banned</option>
        </select>
    </form>

    <!-- ============ USER LIST ============ -->
    <?php if (empty($users)): ?>
        <div class="bento-card p-5 text-center">
            <div class="mx-auto d-inline-flex align-items-center justify-content-center rounded-circle mb-3" style="width:72px;height:72px;background:#E6EBEF;color:#94a3b8;">
                <i data-lucide="users" style="width:30px;height:30px;"></i>
            </div>
            <h5 class="fw-extrabold text-dark mb-1"><?php echo t('Tidak ada pengguna ditemukan.', 'No users found.'); ?></h5>
            <p class="text-secondary small mb-0"><?php echo t('Coba ubah kata kunci atau filter.', 'Try adjusting your search or filters.'); ?></p>
        </div>
    <?php else: ?>
        <div class="d-flex flex-column" style="gap:10px;">
            <?php foreach ($users as $u): ?>
                <?php
                    $badges = array();
                    if ($u->role === 'admin') $badges[] = 'Admin';
                    elseif ($u->is_teacher && $u->is_mentor) $badges[] = 'Teacher · Mentor';
                    elseif ($u->is_teacher) $badges[] = 'Teacher';
                    elseif ($u->is_mentor) $badges[] = 'Mentor';
                    else $badges[] = 'Student';
                    $role_txt = implode(', ', $badges);
                    $is_banned = ($u->status === 'banned');
                    $avatar_color = $u->role === 'admin' ? '#f43f5e' : ($u->is_teacher ? '#0D1830' : ($u->is_mentor ? '#a855f7' : '#009688'));
                ?>
                <div class="user-row-card">
                    <span class="d-inline-flex align-items-center justify-content-center rounded-circle fw-bold text-white flex-shrink-0" style="width:38px;height:38px;background:<?php echo $avatar_color; ?>;font-size:0.85rem;">
                        <?php echo strtoupper(substr($u->name, 0, 1)); ?>
                    </span>
                    <div class="flex-fill" style="min-width:0;">
                        <div class="fw-bold text-dark text-truncate" style="font-size:0.86rem;"><?php echo htmlspecialchars($u->name); ?></div>
                        <div class="text-secondary text-truncate d-flex align-items-center gap-1" style="font-size:0.74rem;">
                            <?php echo htmlspecialchars($u->email); ?><span class="mob-sub-sep">·</span><?php echo $role_txt; ?>
                        </div>
                    </div>
                    <?php if ($is_banned): ?>
                        <span class="px-2 py-1 rounded-pill fw-semibold flex-shrink-0" style="background:#fef2f2;color:#dc2626;font-size:0.62rem;"><i class="fas fa-ban me-1" style="font-size:0.55rem;"></i><?php echo t('Banned', 'Banned'); ?></span>
                    <?php else: ?>
                        <span class="px-2 py-1 rounded-pill fw-semibold flex-shrink-0" style="background:#E0F2F1;color:#009688;font-size:0.62rem;"><i class="fas fa-check-circle me-1" style="font-size:0.55rem;"></i><?php echo t('Aktif', 'Active'); ?></span>
                    <?php endif; ?>
                    <a href="<?php echo base_url('admin/edit_user/' . $u->id); ?>" class="btn btn-sm fw-semibold rounded-pill d-inline-flex align-items-center justify-content-center flex-shrink-0" style="background:#0D1830;color:#fff;font-size:0.72rem;width:32px;height:32px;padding:0;" title="<?php echo t('Edit', 'Edit'); ?>">
                        <i class="fas fa-edit" style="font-size:0.68rem;"></i>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>
<script>
document.getElementById('searchInput')?.addEventListener('keydown', function(e) {
    if (e.key === 'Enter') { e.preventDefault(); this.form.submit(); }
});
</script>
