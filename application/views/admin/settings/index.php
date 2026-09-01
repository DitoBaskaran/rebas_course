<div class="container-fluid py-4" style="max-width: 1400px;">
    <!-- Settings Nav Pills -->
    <div class="d-flex gap-2 mb-4 flex-wrap">
        <a class="px-3 py-2 rounded-pill fw-semibold text-decoration-none d-inline-flex align-items-center gap-1" style="font-size: 0.8rem; background: <?php echo $active_group === 'general' ? '#0D1830' : '#E6EBEF'; ?>; color: <?php echo $active_group === 'general' ? '#fff' : '#57534e'; ?>;" href="<?php echo base_url('admin/settings/general'); ?>"><i class="fas fa-cog" style="font-size: 0.7rem;"></i> General</a>
        <a class="px-3 py-2 rounded-pill fw-semibold text-decoration-none d-inline-flex align-items-center gap-1" style="font-size: 0.8rem; background: <?php echo $active_group === 'appearance' ? '#0D1830' : '#E6EBEF'; ?>; color: <?php echo $active_group === 'appearance' ? '#fff' : '#57534e'; ?>;" href="<?php echo base_url('admin/settings/appearance'); ?>"><i class="fas fa-palette" style="font-size: 0.7rem;"></i> Appearance</a>
        <a class="px-3 py-2 rounded-pill fw-semibold text-decoration-none d-inline-flex align-items-center gap-1" style="font-size: 0.8rem; background: <?php echo $active_group === 'hero' ? '#0D1830' : '#E6EBEF'; ?>; color: <?php echo $active_group === 'hero' ? '#fff' : '#57534e'; ?>;" href="<?php echo base_url('admin/settings/hero'); ?>"><i class="fas fa-image" style="font-size: 0.7rem;"></i> Hero</a>
        <a class="px-3 py-2 rounded-pill fw-semibold text-decoration-none d-inline-flex align-items-center gap-1" style="font-size: 0.8rem; background: <?php echo $active_group === 'homepage' ? '#0D1830' : '#E6EBEF'; ?>; color: <?php echo $active_group === 'homepage' ? '#fff' : '#57534e'; ?>;" href="<?php echo base_url('admin/settings/homepage'); ?>"><i class="fas fa-home" style="font-size: 0.7rem;"></i> Homepage</a>
        <a class="px-3 py-2 rounded-pill fw-semibold text-decoration-none d-inline-flex align-items-center gap-1" style="font-size: 0.8rem; background: <?php echo $active_group === 'social' ? '#0D1830' : '#E6EBEF'; ?>; color: <?php echo $active_group === 'social' ? '#fff' : '#57534e'; ?>;" href="<?php echo base_url('admin/settings/social'); ?>"><i class="fas fa-share-alt" style="font-size: 0.7rem;"></i> Social</a>
        <a class="px-3 py-2 rounded-pill fw-semibold text-decoration-none d-inline-flex align-items-center gap-1" style="font-size: 0.8rem; background: <?php echo $active_group === 'footer' ? '#0D1830' : '#E6EBEF'; ?>; color: <?php echo $active_group === 'footer' ? '#fff' : '#57534e'; ?>;" href="<?php echo base_url('admin/settings/footer'); ?>"><i class="fas fa-shoe-prints" style="font-size: 0.7rem;"></i> Footer</a>
        <a class="px-3 py-2 rounded-pill fw-semibold text-decoration-none d-inline-flex align-items-center gap-1" style="font-size: 0.8rem; background: <?php echo $active_group === 'payment' ? '#0D1830' : '#E6EBEF'; ?>; color: <?php echo $active_group === 'payment' ? '#fff' : '#57534e'; ?>;" href="<?php echo base_url('admin/settings/payment'); ?>"><i class="fas fa-credit-card" style="font-size: 0.7rem;"></i> Payment</a>
        <a class="px-3 py-2 rounded-pill fw-semibold text-decoration-none d-inline-flex align-items-center gap-1" style="font-size: 0.8rem; background: #E6EBEF; color: #57534e;" href="<?php echo base_url('admin/whatsapp'); ?>"><i class="fab fa-whatsapp" style="font-size: 0.7rem;"></i> WhatsApp</a>
    </div>

    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h4 class="fw-extrabold mb-1" style="color: #0D1830; letter-spacing: -0.02em; font-size: 1.4rem;"><?php echo $page_title; ?></h4>
            <p style="color: #78716c; font-size: 0.82rem; margin-bottom: 0;"><?php echo t('Manage', 'Manage'); ?> <?php echo $active_group; ?> <?php echo t('settings', 'settings'); ?></p>
        </div>
    </div>

    <?php echo form_open_multipart(current_url(), 'class="needs-validation" novalidate'); ?>
    <div class="border rounded-3 p-3" style="border-color: #e7e5e4; border-radius: 12px;">
        <div class="d-flex align-items-center gap-2 px-1 py-2 mb-3" style="border-bottom: 1px solid #f0eeeb;">
            <i class="fas fa-sliders-h" style="color: #0D1830; font-size: 0.8rem;"></i>
            <span class="fw-semibold" style="color: #0D1830; font-size: 0.9rem;"><?php echo $page_title; ?></span>
        </div>

        <div class="d-flex flex-column gap-4 p-3">
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
                    <div class="d-flex align-items-center gap-3 p-3 rounded-3" style="background: #E6EBEF; border: 1px solid #f0eeeb;">
                        ' . $logo_html . '
                        <div class="flex-fill">
                            <div class="fw-semibold" style="color: #0D1830; font-size: 0.82rem;">' . $pm['label'] . '</div>
                            <div style="color: #78716c; font-size: 0.72rem;">' . $pm['desc'] . '</div>
                        </div>
                        <label class="form-check form-switch mb-0 flex-shrink-0" style="padding-left: 2.5rem;">
                            <input type="checkbox" name="' . $s->key . '" id="setting_' . $s->key . '" value="1" ' . $checked . ' class="form-check-input" style="width: 2rem; height: 1rem;">
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
                <div>
                    <?php if ($s->type === 'boolean'): ?>
                        <label class="fw-semibold mb-1 d-block" style="color: #0D1830; font-size: 0.82rem;"><?php echo htmlspecialchars($s->label ?: $s->key); ?></label>
                        <label class="form-check form-switch" style="padding-left: 2.5rem;">
                            <input type="checkbox" name="<?php echo $s->key; ?>" id="setting_<?php echo $s->key; ?>" value="1" <?php echo $s->value === '1' ? 'checked' : ''; ?> class="form-check-input" style="width: 2rem; height: 1rem;">
                            <span class="form-check-label small" style="color: #78716c; font-size: 0.78rem;"><?php echo t('Aktif', 'Enabled'); ?></span>
                        </label>
                    <?php elseif ($s->type === 'color'): ?>
                        <label class="fw-semibold mb-1 d-block" style="color: #0D1830; font-size: 0.82rem;"><?php echo htmlspecialchars($s->label ?: $s->key); ?></label>
                        <div class="d-flex align-items-center gap-3">
                            <input type="color" name="<?php echo $s->key; ?>_color" id="setting_<?php echo $s->key; ?>" value="<?php echo htmlspecialchars($s->value); ?>" style="width: 44px; height: 44px; padding: 3px; border: 2px solid #e7e5e4; border-radius: 8px; cursor: pointer;">
                            <input type="text" name="<?php echo $s->key; ?>" class="form-control" value="<?php echo htmlspecialchars($s->value); ?>" style="width: 100px; border-color: #e7e5e4; font-size: 0.85rem;">
                        </div>
                    <?php elseif ($s->type === 'image'): ?>
                        <label class="fw-semibold mb-1 d-block" style="color: #0D1830; font-size: 0.82rem;"><?php echo htmlspecialchars($s->label ?: $s->key); ?></label>
                        <div class="d-flex align-items-center gap-3">
                            <div style="width: 80px; height: 80px; border-radius: 8px; border: 2px dashed #e7e5e4; display: flex; align-items: center; justify-content: center; overflow: hidden; background: #E6EBEF;">
                                <?php if ($s->value): ?><img src="<?php echo base_url('uploads/settings/' . $s->value); ?>" alt="" style="width: 100%; height: 100%; object-fit: cover;"><?php else: ?><i class="fas fa-camera" style="color: #d6d3d1; font-size: 1.2rem;"></i><?php endif; ?>
                            </div>
                            <div>
                                <input type="file" name="<?php echo $s->key; ?>" class="form-control form-control-sm" accept="image/*" data-preview="preview_<?php echo $s->key; ?>" style="border-color: #e7e5e4; font-size: 0.82rem;">
                                <input type="hidden" name="<?php echo $s->key; ?>_existing" value="<?php echo htmlspecialchars($s->value); ?>">
                                <small style="color: #a8a29e; font-size: 0.7rem;"><?php echo t('Biarkan kosong jika tidak ingin mengubah', 'Leave empty to keep current'); ?></small>
                            </div>
                        </div>
                    <?php elseif ($s->type === 'textarea'): ?>
                        <textarea class="form-control" name="<?php echo $s->key; ?>" id="setting_<?php echo $s->key; ?>" rows="3" style="border-color: #e7e5e4; border-radius: 8px; font-size: 0.85rem;" data-max-chars="500"><?php echo htmlspecialchars($s->value); ?></textarea>
                    <?php elseif ($s->type === 'email'): ?>
                        <input type="email" class="form-control" name="<?php echo $s->key; ?>" id="setting_<?php echo $s->key; ?>" value="<?php echo htmlspecialchars($s->value); ?>" style="border-color: #e7e5e4; border-radius: 8px; font-size: 0.85rem;" placeholder="<?php echo htmlspecialchars($s->label ?: $s->key); ?>">
                    <?php elseif ($s->type === 'url'): ?>
                        <input type="url" class="form-control" name="<?php echo $s->key; ?>" id="setting_<?php echo $s->key; ?>" value="<?php echo htmlspecialchars($s->value); ?>" style="border-color: #e7e5e4; border-radius: 8px; font-size: 0.85rem;" placeholder="<?php echo htmlspecialchars($s->label ?: $s->key); ?>">
                    <?php elseif ($s->type === 'number'): ?>
                        <input type="number" class="form-control" name="<?php echo $s->key; ?>" id="setting_<?php echo $s->key; ?>" value="<?php echo htmlspecialchars($s->value); ?>" style="border-color: #e7e5e4; border-radius: 8px; font-size: 0.85rem;" placeholder="<?php echo htmlspecialchars($s->label ?: $s->key); ?>">
                    <?php else: ?>
                        <input type="text" class="form-control" name="<?php echo $s->key; ?>" id="setting_<?php echo $s->key; ?>" value="<?php echo htmlspecialchars($s->value); ?>" style="border-color: #e7e5e4; border-radius: 8px; font-size: 0.85rem;" placeholder="<?php echo htmlspecialchars($s->label ?: $s->key); ?>">
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="d-flex justify-content-end gap-2 pt-3" style="border-top: 1px solid #f0eeeb;">
            <a href="<?php echo base_url('admin/dashboard'); ?>" class="btn px-4 py-2 rounded-pill fw-semibold" style="border: 1px solid #e7e5e4; color: #57534e; font-size: 0.82rem;"><?php echo t('Batal', 'Cancel'); ?></a>
            <button type="submit" class="btn px-4 py-2 fw-bold rounded-pill d-flex align-items-center gap-1" style="background: #0D1830; color: #fff; font-size: 0.82rem;">
                <i class="fas fa-save" style="font-size: 0.7rem;"></i> <?php echo t('Simpan', 'Save'); ?>
            </button>
        </div>
    </div>
    <?php echo form_close(); ?>
</div>
