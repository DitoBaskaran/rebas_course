<div class="container-fluid py-4" style="max-width: 1200px;">
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
        <div>
            <h1 class="h4 fw-extrabold text-dark mb-1">
                <?php echo t('Akses Menu', 'Menu Access'); ?> —
                <span class="text-primary"><?php echo htmlspecialchars($target_user->name); ?></span>
            </h1>
            <div class="small text-muted">
                <?php echo t('Override akses menu untuk user ini. Kosong = ikut role default.', 'Override this user\'s menu access. Empty = follow role default.'); ?>
                <?php if (!empty($role_slugs)): ?>
                    <br><?php echo t('Role user ini', 'This user\'s roles'); ?>: <strong><?php echo implode(', ', $role_slugs); ?></strong>
                <?php else: ?>
                    <br><span class="text-danger"><?php echo t('User admin — akses penuh, tidak perlu diatur.', 'Admin user — full access, no need to configure.'); ?></span>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <?php if (!empty($role_slugs)): ?>
    <?php echo form_open('admin/save_permissions/' . $target_user->id); ?>
    <div class="table-responsive">
        <table class="table table-bordered bg-white align-middle" style="border-color:#e9ecef;">
            <thead class="table-light">
                <tr>
                    <th style="min-width:180px;"><?php echo t('Modul', 'Module'); ?></th>
                    <?php foreach ($actions as $action): ?>
                        <th class="text-center text-nowrap"><?php echo ucfirst($action); ?></th>
                    <?php endforeach; ?>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($modules as $module): ?>
                <tr>
                    <td class="fw-semibold"><?php echo ucfirst($module); ?></td>
                    <?php foreach ($actions as $action): ?>
                        <?php
                            $state = 'inherit';
                            if (isset($overrides[$module][$action])) $state = $overrides[$module][$action] ? 'allow' : 'deny';
                            $default = !empty($role_default[$module][$action]);
                        ?>
                        <td class="text-center text-nowrap">
                            <select name="perm_<?php echo $module; ?>_<?php echo $action; ?>" class="form-select form-select-sm d-inline-block w-auto <?php echo $state !== 'inherit' ? 'border-primary' : ''; ?>">
                                <option value="inherit" <?php echo $state === 'inherit' ? 'selected' : ''; ?>>
                                    <?php echo t('Ikut Role', 'Inherit'); ?><?php echo $default ? ' (✓)' : ' (—)'; ?>
                                </option>
                                <option value="allow" <?php echo $state === 'allow' ? 'selected' : ''; ?>>✓ <?php echo t('Izinkan', 'Allow'); ?></option>
                                <option value="deny" <?php echo $state === 'deny' ? 'selected' : ''; ?>>✗ <?php echo t('Larang', 'Deny'); ?></option>
                            </select>
                        </td>
                    <?php endforeach; ?>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="d-flex justify-content-end gap-2">
        <a href="<?php echo base_url('admin/users'); ?>" class="btn btn-outline-secondary btn-sm rounded-pill px-4"><?php echo t('Kembali', 'Back'); ?></a>
        <button type="submit" class="btn btn-primary btn-sm rounded-pill px-4 d-flex align-items-center gap-1">
            <i data-lucide="save" style="width:16px;height:16px;"></i> <?php echo t('Simpan Akses', 'Save Access'); ?>
        </button>
    </div>
    <?php echo form_close(); ?>
    <?php endif; ?>
</div>
