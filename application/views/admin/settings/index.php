<div class="container-fluid px-0">

    <!-- ============ HEADER (hero) ============ -->
    <div class="bento-card mb-4 overflow-hidden" style="background:linear-gradient(120deg,#0D1830 0%,#164e63 100%);border:none;color:#fff;">
        <div class="d-flex align-items-center justify-content-between gap-3 position-relative" style="z-index:1;">
            <div>
                <span class="d-inline-flex align-items-center gap-1" style="background:rgba(255,255,255,0.14);border:1px solid rgba(255,255,255,0.2);color:#FBBF24;font-size:0.66rem;font-weight:800;letter-spacing:0.12em;text-transform:uppercase;padding:0.3rem 0.7rem;border-radius:100px;">
                    <i data-lucide="sliders-horizontal" style="width:12px;height:12px;"></i>
                    <?php echo t('Pengaturan', 'Settings'); ?>
                </span>
                <h1 class="fw-extrabold text-white mb-1 mt-2 lh-sm" style="letter-spacing:-0.03em;font-size:1.5rem;"><?php echo $page_title; ?></h1>
                <p class="mb-0" style="color:rgba(255,255,255,0.72);font-size:0.82rem;"><?php echo t('Kelola pengaturan', 'Manage'); ?> <?php echo ucfirst($active_group); ?></p>
            </div>
        </div>
    </div>

    <!-- ============ SETTINGS NAV PILLS ============ -->
    <div class="bento-card d-flex flex-wrap gap-2 mb-4" style="padding:0.7rem;">
        <?php
            $nav = array(
                'general' => array('icon' => 'cog', 'label' => 'General'),
                'appearance' => array('icon' => 'palette', 'label' => 'Appearance'),
                'hero' => array('icon' => 'image', 'label' => 'Hero'),
                'homepage' => array('icon' => 'home', 'label' => 'Homepage'),
                'social' => array('icon' => 'share-2', 'label' => 'Social'),
                'footer' => array('icon' => 'align-end-vertical', 'label' => 'Footer'),
                'payment' => array('icon' => 'credit-card', 'label' => 'Payment'),
            );
            foreach ($nav as $key => $n):
                $is_active = $active_group === $key;
        ?>
            <a href="<?php echo base_url('admin/settings/' . $key); ?>" class="settings-pill <?php echo $is_active ? 'settings-pill-active' : ''; ?>">
                <i data-lucide="<?php echo $n['icon']; ?>" style="width:14px;height:14px;"></i> <?php echo $n['label']; ?>
            </a>
        <?php endforeach; ?>
        <a href="<?php echo base_url('admin/whatsapp'); ?>" class="settings-pill">
            <i class="fab fa-whatsapp" style="color:#25D366;"></i> WhatsApp
        </a>
    </div>

    <?php echo form_open_multipart(current_url(), array('class' => 'needs-validation', 'novalidate' => true, 'id' => 'settingsForm')); ?>

    <?php
        $payment_methods_config = array(
            'payment_method_qris' => array('icon' => 'qris-logo.png', 'color' => '#009688', 'label' => 'QRIS', 'desc' => 'GoPay, OVO, DANA, ShopeePay, LinkAja'),
            'payment_method_bri_va' => array('icon' => 'bri-logo.svg', 'color' => '#065f46', 'label' => 'BRI Virtual Account', 'desc' => 'Bank Rakyat Indonesia'),
            'payment_method_bni_va' => array('icon' => 'bni-logo.svg', 'color' => '#1e40af', 'label' => 'BNI Virtual Account', 'desc' => 'Bank Negara Indonesia'),
            'payment_method_cimb_niaga_va' => array('icon' => 'cimb-logo.svg', 'color' => '#dc2626', 'label' => 'CIMB Niaga VA', 'desc' => 'CIMB Niaga'),
            'payment_method_maybank_va' => array('icon' => 'maybank-logo.svg', 'color' => '#FBBF24', 'label' => 'Maybank VA', 'desc' => 'Maybank Indonesia'),
            'payment_method_permata_va' => array('icon' => 'permata-logo.png', 'color' => '#4b5563', 'label' => 'Permata VA', 'desc' => 'Bank Permata'),
            'payment_method_atm_bersama_va' => array('icon' => 'atm-bersama-logo.png', 'color' => '#1e293b', 'label' => 'ATM Bersama VA', 'desc' => 'ATM Bersama'),
            'payment_method_sampoerna_va' => array('icon' => 'fa-university', 'color' => '#7c3aed', 'label' => 'Sampoerna VA', 'desc' => 'Bank Sampoerna'),
            'payment_method_bnc_va' => array('icon' => 'fa-university', 'color' => '#0891b2', 'label' => 'BNC VA', 'desc' => 'BNC'),
            'payment_method_artha_graha_va' => array('icon' => 'fa-university', 'color' => '#64748b', 'label' => 'Artha Graha VA', 'desc' => 'Bank Artha Graha'),
        );
        $payment_cards = array();
        $other_settings = array();
        foreach ($settings as $s) {
            if ($active_group === 'payment' && isset($payment_methods_config[$s->key])) {
                $payment_cards[] = $s;
            } else {
                $other_settings[] = $s;
            }
        }
    ?>

    <!-- ============ PAYMENT METHOD CARDS ============ -->
    <?php if (!empty($payment_cards)): ?>
    <div class="bento-card mb-3">
        <h6 class="fw-bold text-dark mb-3 d-flex align-items-center gap-2" style="font-size:0.85rem;">
            <i data-lucide="wallet" style="width:16px;height:16px;color:var(--primary);"></i> <?php echo t('Metode Pembayaran', 'Payment Methods'); ?>
        </h6>
        <div class="row g-2">
            <?php foreach ($payment_cards as $s): ?>
                <?php
                    $pm = $payment_methods_config[$s->key];
                    $checked = $s->value === '1';
                    $logo_html = strpos($pm['icon'], '.') !== false
                        ? '<span style="display:inline-block;width:52px;text-align:center;"><img src="' . base_url('assets/img/' . $pm['icon']) . '" alt="' . $pm['label'] . '" style="max-width:52px;max-height:22px;width:auto;height:auto;"></span>'
                        : '<span class="d-inline-flex align-items-center justify-content-center rounded-3" style="width:38px;height:38px;background:' . $pm['color'] . '15;color:' . $pm['color'] . ';"><i class="fas ' . $pm['icon'] . '"></i></span>';
                ?>
                <div class="col-md-6">
                    <label class="pay-method-row <?php echo $checked ? 'pay-method-row-active' : ''; ?>">
                        <?php echo $logo_html; ?>
                        <span class="flex-fill" style="min-width:0;">
                            <span class="d-block fw-semibold text-dark text-truncate" style="font-size:0.82rem;"><?php echo $pm['label']; ?></span>
                            <span class="d-block text-secondary text-truncate" style="font-size:0.7rem;"><?php echo $pm['desc']; ?></span>
                        </span>
                        <input type="checkbox" name="<?php echo $s->key; ?>" id="setting_<?php echo $s->key; ?>" value="1" <?php echo $checked ? 'checked' : ''; ?> class="pay-method-check">
                        <span class="pay-method-toggle"><span class="pay-method-toggle-dot"></span></span>
                    </label>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php endif; ?>

    <!-- ============ OTHER FIELDS ============ -->
    <?php if (!empty($other_settings)): ?>
    <div class="bento-card mb-3">
        <h6 class="fw-bold text-dark mb-3 d-flex align-items-center gap-2" style="font-size:0.85rem;">
            <i data-lucide="settings-2" style="width:16px;height:16px;color:#2563eb;"></i> <?php echo t('Detail Pengaturan', 'Setting Details'); ?>
        </h6>
        <div class="row g-3">
            <?php foreach ($other_settings as $s): ?>
                <div class="<?php echo in_array($s->type, array('textarea')) ? 'col-12' : 'col-md-6'; ?>">
                    <?php if ($s->type === 'boolean'): ?>
                        <label class="toggle-switch">
                            <input type="checkbox" name="<?php echo $s->key; ?>" id="setting_<?php echo $s->key; ?>" value="1" <?php echo $s->value === '1' ? 'checked' : ''; ?>>
                            <span class="track"></span>
                            <span class="toggle-label"><?php echo htmlspecialchars($s->label ?: $s->key); ?></span>
                        </label>
                    <?php elseif ($s->type === 'color'): ?>
                        <label class="form-label fw-semibold small"><?php echo htmlspecialchars($s->label ?: $s->key); ?></label>
                        <div class="d-flex align-items-center gap-2">
                            <input type="color" name="<?php echo $s->key; ?>_color" id="setting_<?php echo $s->key; ?>" value="<?php echo htmlspecialchars($s->value); ?>" class="form-control form-control-color" style="width:44px;height:44px;padding:3px;border-radius:10px;">
                            <input type="text" name="<?php echo $s->key; ?>" class="form-control" value="<?php echo htmlspecialchars($s->value); ?>" style="border-radius:12px;font-family:monospace;font-size:0.85rem;height:44px;max-width:140px;">
                        </div>
                    <?php elseif ($s->type === 'image'): ?>
                        <label class="form-label fw-semibold small"><?php echo htmlspecialchars($s->label ?: $s->key); ?></label>
                        <div class="d-flex align-items-center gap-3">
                            <div style="width:64px;height:64px;border-radius:12px;border:2px dashed var(--card-border,#e7e5e4);display:flex;align-items:center;justify-content:center;overflow:hidden;background:var(--gray-50,#f8fafc);flex-shrink:0;">
                                <?php if ($s->value): ?><img src="<?php echo base_url('uploads/settings/' . $s->value); ?>" alt="" style="width:100%;height:100%;object-fit:cover;"><?php else: ?><i class="fas fa-camera" style="color:#d6d3d1;font-size:1.1rem;"></i><?php endif; ?>
                            </div>
                            <div class="flex-fill">
                                <input type="file" name="<?php echo $s->key; ?>" class="form-control form-control-sm" accept="image/*" data-preview="preview_<?php echo $s->key; ?>" style="font-size:0.8rem;border-radius:10px;">
                                <input type="hidden" name="<?php echo $s->key; ?>_existing" value="<?php echo htmlspecialchars($s->value); ?>">
                                <small class="field-hint"><?php echo t('Biarkan kosong jika tidak ingin mengubah', 'Leave empty to keep current'); ?></small>
                            </div>
                        </div>
                    <?php elseif ($s->type === 'textarea'): ?>
                        <label class="form-label fw-semibold small"><?php echo htmlspecialchars($s->label ?: $s->key); ?></label>
                        <textarea class="form-control" name="<?php echo $s->key; ?>" id="setting_<?php echo $s->key; ?>" rows="3" data-max-chars="500" style="border-radius:12px;font-size:0.85rem;line-height:1.6;"><?php echo htmlspecialchars($s->value); ?></textarea>
                    <?php elseif ($s->type === 'email'): ?>
                        <label class="form-label fw-semibold small"><?php echo htmlspecialchars($s->label ?: $s->key); ?></label>
                        <input type="email" class="form-control" name="<?php echo $s->key; ?>" id="setting_<?php echo $s->key; ?>" value="<?php echo htmlspecialchars($s->value); ?>" placeholder="<?php echo htmlspecialchars($s->label ?: $s->key); ?>" style="border-radius:12px;font-size:0.85rem;height:44px;">
                    <?php elseif ($s->type === 'url'): ?>
                        <label class="form-label fw-semibold small"><?php echo htmlspecialchars($s->label ?: $s->key); ?></label>
                        <input type="url" class="form-control" name="<?php echo $s->key; ?>" id="setting_<?php echo $s->key; ?>" value="<?php echo htmlspecialchars($s->value); ?>" placeholder="<?php echo htmlspecialchars($s->label ?: $s->key); ?>" style="border-radius:12px;font-size:0.85rem;height:44px;">
                    <?php elseif ($s->type === 'number'): ?>
                        <label class="form-label fw-semibold small"><?php echo htmlspecialchars($s->label ?: $s->key); ?></label>
                        <input type="number" class="form-control" name="<?php echo $s->key; ?>" id="setting_<?php echo $s->key; ?>" value="<?php echo htmlspecialchars($s->value); ?>" placeholder="<?php echo htmlspecialchars($s->label ?: $s->key); ?>" style="border-radius:12px;font-size:0.85rem;height:44px;">
                    <?php else: ?>
                        <label class="form-label fw-semibold small"><?php echo htmlspecialchars($s->label ?: $s->key); ?></label>
                        <input type="text" class="form-control" name="<?php echo $s->key; ?>" id="setting_<?php echo $s->key; ?>" value="<?php echo htmlspecialchars($s->value); ?>" placeholder="<?php echo htmlspecialchars($s->label ?: $s->key); ?>" style="border-radius:12px;font-size:0.85rem;height:44px;">
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php endif; ?>

    <?php if (empty($payment_cards) && empty($other_settings)): ?>
    <div class="bento-card p-5 text-center">
        <div class="mx-auto d-inline-flex align-items-center justify-content-center rounded-circle mb-3" style="width:64px;height:64px;background:#E6EBEF;color:#94a3b8;">
            <i data-lucide="settings-2" style="width:26px;height:26px;"></i>
        </div>
        <p class="text-secondary small mb-0"><?php echo t('Belum ada pengaturan pada grup ini.', 'No settings in this group yet.'); ?></p>
    </div>
    <?php endif; ?>

    <!-- ============ ACTIONS ============ -->
    <div class="bento-card d-flex justify-content-end gap-2" style="padding:0.9rem 1.1rem;">
        <a href="<?php echo base_url('admin/dashboard'); ?>" class="btn btn-outline-secondary btn-sm rounded-pill px-4"><?php echo t('Batal', 'Cancel'); ?></a>
        <button type="submit" class="btn fw-semibold rounded-pill px-4 d-flex align-items-center gap-2 border-0" style="background:#0D1830;color:#fff;">
            <i data-lucide="save" style="width:16px;height:16px;"></i> <?php echo t('Simpan', 'Save'); ?>
        </button>
    </div>
    <?php echo form_close(); ?>
</div>
