<div class="container-fluid py-4" style="max-width: 1400px;">
    <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between mb-4 gap-3">
        <div>
            <div style="color: #f97316; font-weight: 700; font-size: 0.7rem; text-transform: uppercase; letter-spacing: 0.08em; margin-bottom: 0.15rem;"><?php echo t('Pengguna', 'Users'); ?></div>
            <h4 class="fw-extrabold mb-0" style="color: #1c1917; letter-spacing: -0.02em; font-size: 1.4rem;"><?php echo t('Manajemen Pengguna', 'User Management'); ?></h4>
            <p style="color: #78716c; font-size: 0.82rem; margin-bottom: 0;"><?php echo t('Kelola semua pengguna platform.', 'Manage all platform users.'); ?></p>
        </div>
        <div><span class="px-3 py-2 rounded-pill fw-semibold" style="background: #fff7ed; color: #f97316; font-size: 0.78rem;"><?php echo $total; ?> <?php echo t('pengguna', 'users'); ?></span></div>
    </div>

    <div class="d-flex gap-2 mb-4 flex-wrap">
        <div class="position-relative flex-fill" style="min-width: 200px; max-width: 320px;">
            <i class="fas fa-search" style="font-size: 0.75rem; position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: #a8a29e; pointer-events: none;"></i>
            <input type="text" class="form-control rounded-pill" style="padding-left: 36px; height: 40px; border-color: #e7e5e4; font-size: 0.82rem;" placeholder="<?php echo t('Cari pengguna...', 'Search users...'); ?>" id="searchInput" onkeyup="filterTable()">
        </div>
        <select class="form-select rounded-pill" style="width: auto; height: 40px; border-color: #e7e5e4; font-size: 0.82rem;" onchange="filterTable()" id="roleFilter">
            <option value=""><?php echo t('Semua Role', 'All Roles'); ?></option>
            <option value="student">Student</option>
            <option value="teacher">Teacher</option>
            <option value="admin">Admin</option>
        </select>
        <select class="form-select rounded-pill" style="width: auto; height: 40px; border-color: #e7e5e4; font-size: 0.82rem;" onchange="filterTable()" id="statusFilter">
            <option value=""><?php echo t('Semua Status', 'All Status'); ?></option>
            <option value="active">Active</option>
            <option value="suspended">Suspended</option>
            <option value="banned">Banned</option>
        </select>
    </div>

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
                                <td style="border-color: #f0eeeb; padding: 0.65rem 1rem;"><span class="px-2 py-1 rounded-pill fw-semibold" style="background: <?php echo $u->role === 'admin' ? '#fef2f2' : ($u->role === 'teacher' ? '#fff7ed' : '#f0fdfa'); ?>; color: <?php echo $u->role === 'admin' ? '#f43f5e' : ($u->role === 'teacher' ? '#f97316' : '#14b8a6'); ?>; font-size: 0.6rem;"><?php echo ucfirst($u->role); ?></span></td>
                                <td style="border-color: #f0eeeb; padding: 0.65rem 1rem;"><?php if ($u->status === 'active' || !$u->status): ?><span class="px-2 py-1 rounded-pill fw-semibold" style="background: #f0fdfa; color: #14b8a6; font-size: 0.6rem;">Active</span><?php elseif ($u->status === 'suspended'): ?><span class="px-2 py-1 rounded-pill fw-semibold" style="background: #fff7ed; color: #f97316; font-size: 0.6rem;">Suspended</span><?php else: ?><span class="px-2 py-1 rounded-pill fw-semibold" style="background: #fef2f2; color: #f43f5e; font-size: 0.6rem;">Banned</span><?php endif; ?></td>
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
<script>function filterTable(){var q = document.getElementById('searchInput')?.value.toLowerCase() || ''; var role = document.getElementById('roleFilter')?.value || ''; var status = document.getElementById('statusFilter')?.value || ''; var rows = document.querySelectorAll('#userTable tbody tr'); rows.forEach(function(row){if (row.cells.length < 6) return; var text = row.textContent.toLowerCase(); var r = row.cells[2].textContent.trim().toLowerCase(); var s = row.cells[3].textContent.trim().toLowerCase(); var match = text.indexOf(q) !== -1; var roleMatch = !role || r === role; var statusMatch = !status || s === status; row.style.display = (match && roleMatch && statusMatch) ? '' : 'none';});}</script>
