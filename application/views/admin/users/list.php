<div class="container-fluid px-0">
    <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between mb-5 gap-3">
        <div>
            <span class="text-primary fw-semibold small text-uppercase tracking-wide d-block mb-1">Pengguna</span>
            <h1 class="display-6 fw-extrabold text-dark mb-1 lh-sm" style="letter-spacing: -0.03em;"><?php echo t('Manajemen Pengguna', 'User Management'); ?></h1>
            <p class="text-secondary mb-0"><?php echo t('Kelola semua pengguna platform.', 'Manage all platform users.'); ?></p>
        </div>
        <div class="d-flex gap-2">
            <span class="badge bg-primary-subtle text-primary badge-modern"><?php echo $total; ?> <?php echo t('pengguna', 'users'); ?></span>
        </div>
    </div>

    <!-- Filter -->
    <div class="d-flex gap-2 mb-4 flex-wrap">
        <div class="position-relative flex-fill" style="min-width:200px;max-width:320px;">
            <i data-lucide="search" style="width:16px;height:16px;position:absolute;left:12px;top:50%;transform:translateY(-50%);color:var(--gray-400);pointer-events:none;"></i>
            <input type="text" class="form-control form-control-sm rounded-pill" style="padding-left:36px;" placeholder="<?php echo t('Cari pengguna...', 'Search users...'); ?>" id="searchInput" onkeyup="filterTable()">
        </div>
        <select class="form-select form-select-sm rounded-pill" style="width:auto;" onchange="filterTable()" id="roleFilter">
            <option value=""><?php echo t('Semua Role', 'All Roles'); ?></option>
            <option value="student">Student</option>
            <option value="teacher">Teacher</option>
            <option value="admin">Admin</option>
        </select>
        <select class="form-select form-select-sm rounded-pill" style="width:auto;" onchange="filterTable()" id="statusFilter">
            <option value=""><?php echo t('Semua Status', 'All Status'); ?></option>
            <option value="active">Active</option>
            <option value="suspended">Suspended</option>
            <option value="banned">Banned</option>
        </select>
    </div>

    <div class="bento-card p-4 p-xl-5">
        <div class="table-responsive">
            <table class="table-modern" id="userTable">
                <thead>
                    <tr>
                        <th><?php echo t('Nama', 'Name'); ?></th>
                        <th>Email</th>
                        <th><?php echo t('Role', 'Role'); ?></th>
                        <th><?php echo t('Status', 'Status'); ?></th>
                        <th><?php echo t('Terdaftar', 'Registered'); ?></th>
                        <th class="text-center col-w-120"><?php echo t('Aksi', 'Action'); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($users)): ?>
                        <tr><td colspan="6" class="text-center text-muted py-5"><?php echo t('Tidak ada pengguna.', 'No users found.'); ?></td></tr>
                    <?php else: ?>
                        <?php foreach ($users as $u): ?>
                            <tr>
                                <td class="fw-bold text-dark small"><?php echo htmlspecialchars($u->name); ?></td>
                                <td class="small"><?php echo htmlspecialchars($u->email); ?></td>
                                <td>
                                    <span class="badge badge-modern <?php echo $u->role === 'admin' ? 'bg-danger' : ($u->role === 'teacher' ? 'bg-warning text-dark' : 'bg-primary'); ?>">
                                        <?php echo ucfirst($u->role); ?>
                                    </span>
                                </td>
                                <td>
                                    <?php if ($u->status === 'active' || !$u->status): ?>
                                        <span class="badge bg-success badge-modern">Active</span>
                                    <?php elseif ($u->status === 'suspended'): ?>
                                        <span class="badge bg-warning text-dark badge-modern">Suspended</span>
                                    <?php else: ?>
                                        <span class="badge bg-danger badge-modern">Banned</span>
                                    <?php endif; ?>
                                </td>
                                <td class="small"><?php echo date('d M Y', strtotime($u->created_at)); ?></td>
                                <td class="text-center">
                                    <a href="<?php echo base_url('admin/edit_user/' . $u->id); ?>" class="btn btn-warning btn-sm px-2" title="<?php echo t('Edit', 'Edit'); ?>">
                                        <i data-lucide="edit" style="width:14px;height:14px;"></i>
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
function filterTable() {
    var q = document.getElementById('searchInput')?.value.toLowerCase() || '';
    var role = document.getElementById('roleFilter')?.value || '';
    var status = document.getElementById('statusFilter')?.value || '';
    var rows = document.querySelectorAll('#userTable tbody tr');
    rows.forEach(function(row) {
        if (row.cells.length < 6) return;
        var text = row.textContent.toLowerCase();
        var r = row.cells[2].textContent.trim().toLowerCase();
        var s = row.cells[3].textContent.trim().toLowerCase();
        var match = text.indexOf(q) !== -1;
        var roleMatch = !role || r === role;
        var statusMatch = !status || s === status;
        row.style.display = (match && roleMatch && statusMatch) ? '' : 'none';
    });
}
</script>
