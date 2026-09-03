<div class="container-fluid px-0">

    <!-- ============ HEADER (hero) ============ -->
    <div class="bento-card mb-4 overflow-hidden" style="background:linear-gradient(120deg,#0D1830 0%,#164e63 100%);border:none;color:#fff;">
        <div class="d-flex align-items-center justify-content-between gap-3 position-relative" style="z-index:1;">
            <div>
                <span class="d-inline-flex align-items-center gap-1.5" style="background:rgba(255,255,255,0.14);border:1px solid rgba(255,255,255,0.2);color:#FBBF24;font-size:0.66rem;font-weight:800;letter-spacing:0.12em;text-transform:uppercase;padding:0.3rem 0.7rem;border-radius:100px;">
                    <i data-lucide="shield-check" style="width:12px;height:12px;"></i>
                    <?php echo t('Akses & Izin', 'Access & Permissions'); ?>
                </span>
                <h1 class="display-6 fw-extrabold text-white mb-1 mt-2 lh-sm" style="letter-spacing:-0.03em;font-size:1.6rem;">
                    <?php echo t('Role Default', 'Default Roles'); ?>
                </h1>
                <p class="mb-0" style="color:rgba(255,255,255,0.72);font-size:0.82rem;max-width:46rem;line-height:1.6;">
                    <?php echo t('Set izin standar per role. User yang tidak punya override mengikuti template ini — override per user diatur lewat menu Edit Pengguna.', 'Set standard permissions per role. Users without an override follow this template — per-user overrides are managed via the Edit User page.'); ?>
                </p>
            </div>
            <a href="<?php echo base_url('admin/users'); ?>" class="btn fw-semibold rounded-pill d-inline-flex align-items-center gap-2 border-0 flex-shrink-0" style="background:#FBBF24;color:#0D1830;font-size:0.78rem;padding:0.55rem 1.1rem;box-shadow:0 4px 14px rgba(251,191,36,0.3);">
                <i data-lucide="arrow-left" style="width:14px;height:14px;"></i> <?php echo t('Kembali', 'Back'); ?>
            </a>
        </div>
    </div>

    <?php echo form_open('admin/save_role_permissions', array('id' => 'rolePermForm')); ?>

    <!-- ============ ROLE CARDS ============ -->
    <div class="bento-grid bento-grid-3 mb-4" style="align-items:stretch;">
        <?php foreach ($roles as $role): ?>
            <?php
                // Hitung izin aktif role ini
                $active_total = 0;
                foreach ($modules as $module) {
                    foreach ($actions as $action) {
                        if (!empty($matrix[$role->id][$module][$action])) $active_total++;
                    }
                }
                $role_hue = '';
                if ($role->slug === 'guru')      $role_style = 'background:linear-gradient(135deg,#0D1830,#164e63);';
                elseif ($role->slug === 'mentor')$role_style = 'background:linear-gradient(135deg,#064e3b,#047857);';
                else                             $role_style = 'background:linear-gradient(135deg,#312e81,#4338ca);';
            ?>
            <div class="bento-card p-0 role-perm-card" style="display:flex;flex-direction:column;">
                <!-- Role header -->
                <div class="d-flex align-items-center gap-3 px-4 py-3 rounded-top" style="<?php echo $role_style; ?>">
                    <span class="d-inline-flex align-items-center justify-content-center rounded-circle flex-shrink-0" style="width:38px;height:38px;background:rgba(255,255,255,0.16);border:1px solid rgba(255,255,255,0.25);">
                        <i data-lucide="<?php echo $role->slug === 'guru' ? 'book-open' : ($role->slug === 'mentor' ? 'calendar-check' : 'graduation-cap'); ?>" style="width:18px;height:18px;color:#fff;"></i>
                    </span>
                    <div class="flex-grow-1">
                        <div class="fw-bold text-white" style="font-size:0.95rem;"><?php echo htmlspecialchars($role->name); ?></div>
                        <div class="text-white-50" style="font-size:0.68rem;text-transform:uppercase;letter-spacing:0.06em;"><?php echo $role->slug; ?></div>
                    </div>
                    <span class="badge rounded-pill flex-shrink-0" style="background:rgba(255,255,255,0.18);color:#fff;font-size:0.66rem;font-weight:700;">
                        <?php echo $active_total; ?>/<?php echo count($modules) * count($actions); ?> <?php echo t('izin', 'perms'); ?>
                    </span>
                </div>

                <!-- Column headers -->
                <div class="perm-grid perm-grid-head px-4 pt-3 pb-2">
                    <span><?php echo t('Modul', 'Module'); ?></span>
                    <?php foreach ($actions as $action): ?>
                        <span class="text-center perm-act-label perm-act-<?php echo $action; ?>" title="<?php echo ucfirst($action); ?>">
                            <?php echo t(ucfirst($action), ucfirst($action)); ?>
                        </span>
                    <?php endforeach; ?>
                </div>

                <!-- Module rows -->
                <div class="px-2 pb-2" style="flex:1;">
                    <?php foreach ($modules as $module): ?>
                        <div class="perm-grid perm-grid-row px-2 py-2" style="border-radius:10px;">
                            <span class="perm-module-name">
                                <?php $icon = 'folder'; if ($module==='courses') $icon='book-open'; elseif ($module==='lessons') $icon='list-video'; elseif ($module==='seminars') $icon='calendar'; elseif ($module==='assignments') $icon='clipboard-list'; elseif ($module==='submissions') $icon='code'; elseif ($module==='quizzes') $icon='help-circle'; elseif ($module==='forum') $icon='message-square'; elseif ($module==='mentoring') $icon='calendar-check'; elseif ($module==='learning_paths') $icon='route'; ?>
                                <i data-lucide="<?php echo $icon; ?>" style="width:14px;height:14px;color:var(--gray-400,#94a3b8);"></i>
                                <span><?php echo ucfirst(str_replace('_', ' ', $module)); ?></span>
                            </span>
                            <?php foreach ($actions as $action): ?>
                                <?php $checked = !empty($matrix[$role->id][$module][$action]); ?>
                                <label class="perm-cell perm-cell-<?php echo $action; ?>">
                                    <input type="hidden" name="perm_<?php echo $role->id; ?>_<?php echo $module; ?>_<?php echo $action; ?>" value="0">
                                    <input type="checkbox" class="perm-input" name="perm_<?php echo $role->id; ?>_<?php echo $module; ?>_<?php echo $action; ?>" value="1" <?php echo $checked ? 'checked' : ''; ?>>
                                    <span class="perm-box" title="<?php echo ucfirst($action) . ' ' . ucfirst(str_replace('_', ' ', $module)); ?>">
                                        <i class="<?php echo $action==='create' ? 'fas fa-plus' : ($action==='read' ? 'fas fa-eye' : ($action==='update' ? 'fas fa-pen' : 'fas fa-trash')); ?>"></i>
                                    </span>
                                </label>
                            <?php endforeach; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- ============ FOOTER ============ -->
    <div class="bento-card d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3" style="padding:1rem 1.25rem;">
        <div class="small text-muted d-flex align-items-center gap-2 flex-wrap">
            <i data-lucide="info" style="width:15px;height:15px;color:var(--primary);flex-shrink:0;"></i>
            <?php echo t('Perubahan langsung diterapkan ke semua user ber-role tersebut yang tidak memiliki override. Kelola pengecualian per user dari halaman Pengguna → Edit → Kelola Akses Menu.', 'Changes apply immediately to all users of that role who have no override. Manage per-user exceptions via Users → Edit → Manage Menu Access.'); ?>
        </div>
        <div class="d-flex gap-2 flex-shrink-0">
            <a href="<?php echo base_url('admin/users'); ?>" class="btn btn-outline-secondary btn-sm rounded-pill px-4"><?php echo t('Kembali', 'Back'); ?></a>
            <button type="submit" class="btn btn-primary btn-sm rounded-pill px-4 d-flex align-items-center gap-1">
                <i data-lucide="save" style="width:16px;height:16px;"></i> <?php echo t('Simpan Role Default', 'Save Default Roles'); ?>
            </button>
        </div>
    </div>

    <?php echo form_close(); ?>
</div>
