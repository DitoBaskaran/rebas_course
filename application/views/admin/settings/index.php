<div class="app-page">
    <!-- Settings Nav Pills -->
    <div class="app-toolbar" style="margin-bottom:1.1rem;">
        <a class="app-btn app-btn-sm <?php echo $active_group === 'general' ? 'app-btn-primary' : ''; ?>" href="<?php echo base_url('admin/settings/general'); ?>"><i class="fas fa-cog"></i> General</a>
        <a class="app-btn app-btn-sm <?php echo $active_group === 'appearance' ? 'app-btn-primary' : ''; ?>" href="<?php echo base_url('admin/settings/appearance'); ?>"><i class="fas fa-palette"></i> Appearance</a>
        <a class="app-btn app-btn-sm <?php echo $active_group === 'hero' ? 'app-btn-primary' : ''; ?>" href="<?php echo base_url('admin/settings/hero'); ?>"><i class="fas fa-image"></i> Hero</a>
        <a class="app-btn app-btn-sm <?php echo $active_group === 'homepage' ? 'app-btn-primary' : ''; ?>" href="<?php echo base_url('admin/settings/homepage'); ?>"><i class="fas fa-home"></i> Homepage</a>
        <a class="app-btn app-btn-sm <?php echo $active_group === 'social' ? 'app-btn-primary' : ''; ?>" href="<?php echo base_url('admin/settings/social'); ?>"><i class="fas fa-share-alt"></i> Social</a>
        <a class="app-btn app-btn-sm <?php echo $active_group === 'footer' ? 'app-btn-primary' : ''; ?>" href="<?php echo base_url('admin/settings/footer'); ?>"><i class="fas fa-shoe-prints"></i> Footer</a>
        <a class="app-btn app-btn-sm <?php echo $active_group === 'payment' ? 'app-btn-primary' : ''; ?>" href="<?php echo base_url('admin/settings/payment'); ?>"><i class="fas fa-credit-card"></i> Payment</a>
        <a class="app-btn app-btn-sm" href="<?php echo base_url('admin/whatsapp'); ?>"><i class="fab fa-whatsapp" style="color:#25D366;"></i> WhatsApp</a>
    </div>

    <div class="app-page-head">
        <div>
            <h4 class="app-page-title"><i class="fas fa-sliders-h"></i> <?php echo $page_title; ?></h4>
            <p class="app-page-sub"><?php echo t('Manage', 'Manage'); ?> <?php echo $active_group; ?> <?php echo t('settings', 'settings'); ?></p>
        </div>
    </div>

    <?php echo form_open_multipart(current_url(), 'class="needs-validation" novalidate'); ?>
    <div class="app-card app-card-pad app-form-card">
        <div class="app-form-grid">
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
            ?>
            <?php
            $payment_cards = '';
            $other_settings = array();
            foreach ($settings as $s):
                if ($active_group === 'payment' && isset($payment_methods_config[$s->key])):
                    $pm = $payment_methods_config[$s->key];
                    $checked = $s->value === '1' ? 'checked' : '';
                    $logo_html = strpos($pm['icon'], '.') !== false ? '<span style="display:inline-block;width:60px;text-align:center;"><img src="' . base_url('assets/img/' . $pm['icon']) . '" alt="' . $pm['label'] . '" style="max-width:60px;max-height:24px;width:auto;height:auto;"></span>' : '<i class="fas ' . $pm['icon'] . '"></i>';
                    $payment_cards .= '
                    <div class="d-flex align-items-center gap-3 p-3 rounded-3" style="background:var(--gray-50,#fafafa);border:1px solid var(--card-border,#e7e5e4);">
                        ' . $logo_html . '
                        <div style="flex:1;">
                            <div class="fw-semibold" style="color:#0D1830;font-size:0.82rem;">' . $pm['label'] . '</div>
                            <div style="color:#78716c;font-size:0.72rem;">' . $pm['desc'] . '</div>
                        </div>
                        <label class="form-check form-switch mb-0" style="padding-left:2.5rem;flex-shrink:0;">
                            <input type="checkbox" name="' . $s->key . '" id="setting_' . $s->key . '" value="1" ' . $checked . ' class="form-check-input" style="width:2rem;height:1rem;">
                        </label>
                    </div>';
                else:
                    $other_settings[] = $s;
                endif;
            endforeach;
            ?>
            <?php if ($payment_cards): ?>
            <div class="d-flex flex-column gap-2"><?php echo $payment_cards; ?></div>
            <?php endif; ?>
            <?php foreach ($other_settings as $s): ?>
                <div class="app-field">
                    <?php if ($s->type === 'boolean'): ?>
                        <label><?php echo htmlspecialchars($s->label ?: $s->key); ?></label>
                        <label class="form-check form-switch" style="padding-left:2.5rem;">
                            <input type="checkbox" name="<?php echo $s->key; ?>" id="setting_<?php echo $s->key; ?>" value="1" <?php echo $s->value === '1' ? 'checked' : ''; ?> class="form-check-input" style="width:2rem;height:1rem;">
                            <span class="form-check-label" style="color:#78716c;font-size:0.78rem;"><?php echo t('Aktif', 'Enabled'); ?></span>
                        </label>
                    <?php elseif ($s->type === 'color'): ?>
                        <label><?php echo htmlspecialchars($s->label ?: $s->key); ?></label>
                        <div class="d-flex align-items-center gap-3">
                            <input type="color" name="<?php echo $s->key; ?>_color" id="setting_<?php echo $s->key; ?>" value="<?php echo htmlspecialchars($s->value); ?>" style="width:44px;height:44px;padding:3px;border:2px solid #e7e5e4;border-radius:8px;cursor:pointer;">
                            <input type="text" name="<?php echo $s->key; ?>" class="form-control" value="<?php echo htmlspecialchars($s->value); ?>" style="width:100px;">
                        </div>
                    <?php elseif ($s->type === 'image'): ?>
                        <label><?php echo htmlspecialchars($s->label ?: $s->key); ?></label>
                        <div class="d-flex align-items-center gap-3">
                            <div style="width:80px;height:80px;border-radius:8px;border:2px dashed #e7e5e4;display:flex;align-items:center;justify-content:center;overflow:hidden;background:var(--gray-100,#f5f5f5);flex-shrink:0;">
                                <?php if ($s->value): ?><img src="<?php echo base_url('uploads/settings/' . $s->value); ?>" alt="" style="width:100%;height:100%;object-fit:cover;"><?php else: ?><i class="fas fa-camera" style="color:#d6d3d1;font-size:1.2rem;"></i><?php endif; ?>
                            </div>
                            <div>
                                <input type="file" name="<?php echo $s->key; ?>" class="form-control form-control-sm" accept="image/*" data-preview="preview_<?php echo $s->key; ?>" style="font-size:0.82rem;">
                                <input type="hidden" name="<?php echo $s->key; ?>_existing" value="<?php echo htmlspecialchars($s->value); ?>">
                                <div class="app-hint"><?php echo t('Biarkan kosong jika tidak ingin mengubah', 'Leave empty to keep current'); ?></div>
                            </div>
                        </div>
                    <?php elseif ($s->type === 'textarea'): ?>
                        <label><?php echo htmlspecialchars($s->label ?: $s->key); ?></label>
                        <textarea class="form-control" name="<?php echo $s->key; ?>" id="setting_<?php echo $s->key; ?>" rows="3" data-max-chars="500"><?php echo htmlspecialchars($s->value); ?></textarea>
                    <?php elseif ($s->type === 'email'): ?>
                        <label><?php echo htmlspecialchars($s->label ?: $s->key); ?></label>
                        <input type="email" class="form-control" name="<?php echo $s->key; ?>" id="setting_<?php echo $s->key; ?>" value="<?php echo htmlspecialchars($s->value); ?>" placeholder="<?php echo htmlspecialchars($s->label ?: $s->key); ?>">
                    <?php elseif ($s->type === 'url'): ?>
                        <label><?php echo htmlspecialchars($s->label ?: $s->key); ?></label>
                        <input type="url" class="form-control" name="<?php echo $s->key; ?>" id="setting_<?php echo $s->key; ?>" value="<?php echo htmlspecialchars($s->value); ?>" placeholder="<?php echo htmlspecialchars($s->label ?: $s->key); ?>">
                    <?php elseif ($s->type === 'number'): ?>
                        <label><?php echo htmlspecialchars($s->label ?: $s->key); ?></label>
                        <input type="number" class="form-control" name="<?php echo $s->key; ?>" id="setting_<?php echo $s->key; ?>" value="<?php echo htmlspecialchars($s->value); ?>" placeholder="<?php echo htmlspecialchars($s->label ?: $s->key); ?>">
                    <?php else: ?>
                        <label><?php echo htmlspecialchars($s->label ?: $s->key); ?></label>
                        <input type="text" class="form-control" name="<?php echo $s->key; ?>" id="setting_<?php echo $s->key; ?>" value="<?php echo htmlspecialchars($s->value); ?>" placeholder="<?php echo htmlspecialchars($s->label ?: $s->key); ?>">
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="app-form-actions" style="border-top:1px solid var(--gray-100,#f5f5f5);margin-top:1rem;padding-top:1rem;">
            <a href="<?php echo base_url('admin/dashboard'); ?>" class="app-btn"><?php echo t('Batal', 'Cancel'); ?></a>
            <button type="submit" class="app-btn app-btn-primary"><i class="fas fa-save"></i> <?php echo t('Simpan', 'Save'); ?></button>
        </div>
    </div>
    <?php echo form_close(); ?>
</div>
