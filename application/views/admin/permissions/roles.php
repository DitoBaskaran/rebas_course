<div class="container-fluid py-4" style="max-width: 1200px;">
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
        <div>
            <h1 class="h4 fw-extrabold text-dark mb-1"><?php echo t('Role Default', 'Default Roles'); ?></h1>
            <div class="small text-muted">
                <?php echo t('Set izin standar per role (GURU / MENTOR / USER). Semua user ber-role itu mengikuti template ini, kecuali yang punya override per-user.', 'Set standard permissions per role. Users follow this template unless overridden per-user.'); ?>
            </div>
        </div>
        <div class="d-flex gap-2">
            <a href="<?php echo base_url('admin/users'); ?>" class="btn btn-outline-secondary btn-sm rounded-pill px-4"><?php echo t('Kembali', 'Back'); ?></a>
        </div>
    </div>

    <?php echo form_open('admin/save_role_permissions'); ?>
    <div class="table-responsive">
        <table class="table table-bordered bg-white align-middle" style="border-color:#e9ecef;">
            <thead class="table-light">
                <tr>
                    <th style="min-width:180px;"><?php echo t('Modul', 'Module'); ?></th>
                    <?php foreach ($roles as $role): ?>
                        <th class="text-center text-nowrap"><?php echo htmlspecialchars($role->name); ?></th>
                    <?php endforeach; ?>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($modules as $module): ?>
                <tr>
                    <td class="fw-semibold"><?php echo ucfirst($module); ?></td>
                    <?php foreach ($roles as $role): ?>
                        <td class="text-center text-nowrap">
                            <?php foreach ($actions as $action): ?>
                                <?php $checked = !empty($matrix[$role->id][$module][$action]); ?>
                                <label class="form-check form-check-inline mb-1" title="<?php echo ucfirst($action); ?>">
                                    <input type="hidden" name="perm_<?php echo $role->id; ?>_<?php echo $module; ?>_<?php echo $action; ?>" value="0">
                                    <input type="checkbox" class="form-check-input" name="perm_<?php echo $role->id; ?>_<?php echo $module; ?>_<?php echo $action; ?>" value="1" <?php echo $checked ? 'checked' : ''; ?>>
                                    <span class="small text-muted" style="font-size:.7rem;"><?php echo substr($action, 0, 1); ?></span>
                                </label>
                            <?php endforeach; ?>
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
            <i data-lucide="save" style="width:16px;height:16px;"></i> <?php echo t('Simpan Role Default', 'Save Default Roles'); ?>
        </button>
    </div>
    <?php echo form_close(); ?>
</div>
