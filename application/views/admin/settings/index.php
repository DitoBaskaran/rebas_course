    <!-- Settings Nav Pills -->
    <div class="settings-nav-pills">
        <a class="pill <?php echo $active_group === 'general' ? 'active' : ''; ?>" href="<?php echo base_url('admin/settings/general'); ?>">
            <i data-lucide="settings" style="width:16px;height:16px;"></i> General
        </a>
        <a class="pill <?php echo $active_group === 'appearance' ? 'active' : ''; ?>" href="<?php echo base_url('admin/settings/appearance'); ?>">
            <i data-lucide="palette" style="width:16px;height:16px;"></i> Appearance
        </a>
        <a class="pill <?php echo $active_group === 'hero' ? 'active' : ''; ?>" href="<?php echo base_url('admin/settings/hero'); ?>">
            <i data-lucide="image" style="width:16px;height:16px;"></i> Hero Section
        </a>
        <a class="pill <?php echo $active_group === 'homepage' ? 'active' : ''; ?>" href="<?php echo base_url('admin/settings/homepage'); ?>">
            <i data-lucide="home" style="width:16px;height:16px;"></i> Homepage
        </a>
        <a class="pill <?php echo $active_group === 'social' ? 'active' : ''; ?>" href="<?php echo base_url('admin/settings/social'); ?>">
            <i data-lucide="share-2" style="width:16px;height:16px;"></i> Social Media
        </a>
        <a class="pill <?php echo $active_group === 'footer' ? 'active' : ''; ?>" href="<?php echo base_url('admin/settings/footer'); ?>">
            <i data-lucide="shovel" style="width:16px;height:16px;"></i> Footer
        </a>
        <a class="pill <?php echo $active_group === 'payment' ? 'active' : ''; ?>" href="<?php echo base_url('admin/settings/payment'); ?>">
            <i data-lucide="credit-card" style="width:16px;height:16px;"></i> Payment
        </a>
    </div>
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h4 class="fw-extrabold text-dark mb-1" style="letter-spacing: -0.03em; font-size: 1.5rem;"><?php echo $page_title; ?></h4>
            <p class="text-secondary mb-0">Manage <?php echo $active_group; ?> settings</p>
        </div>
    </div>

    <?php echo form_open_multipart(current_url(), 'class="needs-validation" novalidate'); ?>
        <div class="settings-section">
            <div class="bento-card">
                <div class="section-glass">
                    <i data-lucide="sliders" style="width:18px;height:18px;color:var(--primary);"></i>
                    <span><?php echo $page_title; ?></span>
                </div>
                <div class="d-flex flex-column gap-4 p-4 p-xl-5">
                    <?php
                    $payment_methods_config = array(
                        'payment_method_qris' => array('icon' => 'qris-logo.png', 'color' => '#0d6efd', 'label' => 'QRIS', 'desc' => 'GoPay, OVO, DANA, ShopeePay, LinkAja'),
                        'payment_method_bri_va' => array('icon' => 'bri-logo.svg', 'color' => '#065f46', 'label' => 'BRI Virtual Account', 'desc' => 'Bank Rakyat Indonesia'),
                        'payment_method_bni_va' => array('icon' => 'bni-logo.svg', 'color' => '#1e40af', 'label' => 'BNI Virtual Account', 'desc' => 'Bank Negara Indonesia'),
                        'payment_method_cimb_niaga_va' => array('icon' => 'cimb-logo.svg', 'color' => '#dc2626', 'label' => 'CIMB Niaga VA', 'desc' => 'CIMB Niaga'),
                        'payment_method_maybank_va' => array('icon' => 'maybank-logo.svg', 'color' => '#f59e0b', 'label' => 'Maybank VA', 'desc' => 'Maybank Indonesia'),
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
                            <div class="payment-method-card p-3 rounded-3 border" style="background:var(--card-bg);border-color:var(--card-border)!important;transition:all 0.2s;">
                                <div class="d-flex align-items-center gap-2 mb-1">
                                    ' . $logo_html . '
                                    <span class="fw-semibold text-dark small">' . $pm['label'] . '</span>
                                    <label class="toggle-switch flex-shrink-0 ms-auto">
                                        <input type="checkbox" name="' . $s->key . '" id="setting_' . $s->key . '" value="1" ' . $checked . '>
                                        <div class="track"></div>
                                    </label>
                                </div>
                                <div class="text-secondary small">' . $pm['desc'] . '</div>
                            </div>';
                        else:
                            $other_settings[] = $s;
                        endif;
                    endforeach;
                    ?>
                    <?php if ($payment_cards): ?>
                    <div class="payment-methods-grid">
                        <?php echo $payment_cards; ?>
                    </div>
                    <hr class="my-3 opacity-25">
                    <?php endif; ?>
                    <?php foreach ($other_settings as $s): ?>
                        <div>
                            <?php if ($s->type === 'boolean'): ?>
                                <label class="form-label fw-semibold text-dark small" for="setting_<?php echo $s->key; ?>">
                                    <?php echo htmlspecialchars($s->label ?: $s->key); ?>
                                </label>
                                <div class="toggle-switch">
                                    <input type="checkbox" name="<?php echo $s->key; ?>" id="setting_<?php echo $s->key; ?>" value="1" <?php echo $s->value === '1' ? 'checked' : ''; ?>>
                                    <div class="track"></div>
                                    <label class="toggle-label" for="setting_<?php echo $s->key; ?>"><?php echo t('Aktif', 'Enabled'); ?></label>
                                </div>

                            <?php elseif ($s->type === 'color'): ?>
                                <label class="form-label fw-semibold text-dark small" for="setting_<?php echo $s->key; ?>">
                                    <?php echo htmlspecialchars($s->label ?: $s->key); ?>
                                </label>
                                <div class="color-picker-wrapper">
                                    <input type="color" name="<?php echo $s->key; ?>_color" id="setting_<?php echo $s->key; ?>" value="<?php echo htmlspecialchars($s->value); ?>">
                                    <div class="form-float" style="flex:1;">
                                        <input type="text" name="<?php echo $s->key; ?>" class="form-control" value="<?php echo htmlspecialchars($s->value); ?>" placeholder=" ">
                                        <label class="fl-label">Hex</label>
                                    </div>
                                </div>

                            <?php elseif ($s->type === 'image'): ?>
                                <label class="form-label fw-semibold text-dark small" for="setting_<?php echo $s->key; ?>">
                                    <?php echo htmlspecialchars($s->label ?: $s->key); ?>
                                </label>
                                <div class="image-upload-wrapper">
                                    <div class="preview">
                                        <?php if ($s->value): ?>
                                            <img src="<?php echo base_url('uploads/settings/' . $s->value); ?>" alt="">
                                        <?php else: ?>
                                            <i data-lucide="camera" style="width:24px;height:24px;color:var(--gray-400);"></i>
                                        <?php endif; ?>
                                    </div>
                                    <div class="upload-controls">
                                        <input type="file" name="<?php echo $s->key; ?>" class="form-control form-control-sm" accept="image/*" data-preview="preview_<?php echo $s->key; ?>">
                                        <input type="hidden" name="<?php echo $s->key; ?>_existing" value="<?php echo htmlspecialchars($s->value); ?>">
                                        <small class="text-muted"><?php echo t('Biarkan kosong jika tidak ingin mengubah', 'Leave empty to keep current'); ?></small>
                                    </div>
                                </div>

                            <?php elseif ($s->type === 'textarea'): ?>
                                <div class="form-float">
                                    <textarea class="form-control" name="<?php echo $s->key; ?>" id="setting_<?php echo $s->key; ?>" rows="3" placeholder=" " data-max-chars="500"><?php echo htmlspecialchars($s->value); ?></textarea>
                                    <label class="fl-label"><?php echo htmlspecialchars($s->label ?: $s->key); ?></label>
                                </div>

                            <?php elseif ($s->type === 'email'): ?>
                                <div class="form-float">
                                    <input type="email" class="form-control" name="<?php echo $s->key; ?>" id="setting_<?php echo $s->key; ?>" value="<?php echo htmlspecialchars($s->value); ?>" placeholder=" ">
                                    <label class="fl-label"><?php echo htmlspecialchars($s->label ?: $s->key); ?></label>
                                </div>

                            <?php elseif ($s->type === 'url'): ?>
                                <div class="form-float">
                                    <input type="url" class="form-control" name="<?php echo $s->key; ?>" id="setting_<?php echo $s->key; ?>" value="<?php echo htmlspecialchars($s->value); ?>" placeholder=" ">
                                    <label class="fl-label"><?php echo htmlspecialchars($s->label ?: $s->key); ?></label>
                                </div>

                            <?php elseif ($s->type === 'number'): ?>
                                <div class="form-float">
                                    <input type="number" class="form-control" name="<?php echo $s->key; ?>" id="setting_<?php echo $s->key; ?>" value="<?php echo htmlspecialchars($s->value); ?>" placeholder=" ">
                                    <label class="fl-label"><?php echo htmlspecialchars($s->label ?: $s->key); ?></label>
                                </div>

                            <?php else: ?>
                                <div class="form-float">
                                    <input type="text" class="form-control" name="<?php echo $s->key; ?>" id="setting_<?php echo $s->key; ?>" value="<?php echo htmlspecialchars($s->value); ?>" placeholder=" ">
                                    <label class="fl-label"><?php echo htmlspecialchars($s->label ?: $s->key); ?></label>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="form-footer-sticky">
                    <a href="<?php echo base_url('admin/dashboard'); ?>" class="btn btn-outline-secondary btn-sm rounded-pill px-4"><?php echo t('Batal', 'Cancel'); ?></a>
                    <button type="submit" class="btn btn-dark btn-sm rounded-pill px-4 d-flex align-items-center gap-1">
                        <i data-lucide="save" style="width:16px;height:16px;"></i> <?php echo t('Simpan', 'Save'); ?>
                    </button>
                </div>
            </div>
        </div>
    </form>
