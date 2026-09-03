<div class="container-fluid px-0">

    <!-- ============ HEADER (hero) ============ -->
    <?php
        $wa_connected = $device_status && !empty($device_status['connected']);
    ?>
    <div class="bento-card mb-4 overflow-hidden" style="background:linear-gradient(120deg,#0B3D2E 0%,#065f46 100%);border:none;color:#fff;">
        <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3 position-relative" style="z-index:1;">
            <div>
                <span class="d-inline-flex align-items-center gap-1" style="background:rgba(255,255,255,0.14);border:1px solid rgba(255,255,255,0.2);color:#25D366;font-size:0.66rem;font-weight:800;letter-spacing:0.12em;text-transform:uppercase;padding:0.3rem 0.7rem;border-radius:100px;">
                    <i class="fab fa-whatsapp" style="font-size:0.7rem;"></i> <?php echo t('Gateway', 'Gateway'); ?>
                </span>
                <h1 class="fw-extrabold text-white mb-1 mt-2 lh-sm" style="letter-spacing:-0.03em;font-size:1.5rem;">
                    <?php echo t('WhatsApp Gateway', 'WhatsApp Gateway'); ?>
                </h1>
                <p class="mb-0" style="color:rgba(255,255,255,0.72);font-size:0.8rem;">
                    <?php echo t('Kelola koneksi gateway wa.ditobaskaran.my.id, template pesan & antrian notifikasi', 'Manage gateway connection, message templates & notification queue'); ?>
                </p>
            </div>
            <?php if ($wa_connected): ?>
            <span class="d-inline-flex align-items-center gap-2 px-3 py-2 rounded-pill fw-semibold flex-shrink-0" style="background:rgba(37,211,102,0.18);border:1px solid rgba(37,211,102,0.4);color:#fff;font-size:0.76rem;">
                <span class="pulse-dot"></span> <?php echo t('Terhubung', 'Connected'); ?>
                <?php if (isset($device_status['pushName'])): ?>· <?php echo htmlspecialchars($device_status['pushName']); ?><?php endif; ?>
            </span>
            <?php else: ?>
            <span class="d-inline-flex align-items-center gap-2 px-3 py-2 rounded-pill fw-semibold flex-shrink-0" style="background:rgba(248,113,113,0.18);border:1px solid rgba(248,113,113,0.4);color:#fff;font-size:0.76rem;">
                <i class="fas fa-circle" style="font-size:0.45rem;"></i> <?php echo t('Tidak Terhubung', 'Not Connected'); ?>
            </span>
            <?php endif; ?>
        </div>
    </div>

    <!-- ============ STATUS + QUEUE SUMMARY ============ -->
    <div class="bento-grid bento-grid-4 mb-4">
        <div class="bento-card blob-warning">
            <div class="d-flex align-items-center gap-3">
                <div class="bento-icon bg-warning-subtle text-warning"><i data-lucide="clock" style="width:22px;height:22px;"></i></div>
                <div>
                    <div class="bento-label"><?php echo t('Antrian Menunggu', 'Pending Queue'); ?></div>
                    <div class="bento-value"><?php echo $queue_stats['pending']; ?></div>
                </div>
            </div>
        </div>
        <div class="bento-card blob-success">
            <div class="d-flex align-items-center gap-3">
                <div class="bento-icon bg-success-subtle text-success"><i data-lucide="check-circle" style="width:22px;height:22px;"></i></div>
                <div>
                    <div class="bento-label"><?php echo t('Terkirim', 'Sent'); ?></div>
                    <div class="bento-value"><?php echo $queue_stats['sent']; ?></div>
                </div>
            </div>
        </div>
        <div class="bento-card blob-danger">
            <div class="d-flex align-items-center gap-3">
                <div class="bento-icon bg-danger-subtle text-danger"><i data-lucide="alert-circle" style="width:22px;height:22px;"></i></div>
                <div>
                    <div class="bento-label"><?php echo t('Gagal', 'Failed'); ?></div>
                    <div class="bento-value"><?php echo $queue_stats['failed']; ?></div>
                </div>
            </div>
        </div>
        <div class="bento-card blob-primary">
            <div class="d-flex align-items-center gap-3">
                <div class="bento-icon bg-primary-subtle text-primary"><i data-lucide="activity" style="width:22px;height:22px;"></i></div>
                <div>
                    <div class="bento-label"><?php echo t('Koneksi Device', 'Device Status'); ?></div>
                    <?php if ($wa_connected): ?>
                        <div class="fw-extrabold" style="color:#009688;font-size:1rem;"><?php echo t('Online', 'Online'); ?></div>
                    <?php else: ?>
                        <div class="fw-extrabold" style="color:#dc2626;font-size:1rem;"><?php echo t('Offline', 'Offline'); ?></div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <div class="bento-grid bento-grid-2-1 mb-4" style="align-items:start;">
        <!-- ===== LEFT: DEVICE DETAIL + RECENT ===== -->
        <div class="d-flex flex-column gap-3">
            <!-- Device detail -->
            <div class="bento-card">
                <h6 class="fw-bold text-dark mb-3 d-flex align-items-center gap-2" style="font-size:0.85rem;">
                    <i data-lucide="smartphone" style="width:16px;height:16px;color:#25D366;"></i> <?php echo t('Detail Device', 'Device Details'); ?>
                </h6>
                <?php if ($wa_connected): ?>
                    <div class="d-flex flex-column gap-2">
                        <?php if (isset($device_status['jid'])): ?>
                        <div class="d-flex justify-content-between align-items-center py-1" style="border-bottom:1px dashed var(--gray-100,#f0eeeb);">
                            <span class="text-secondary" style="font-size:0.75rem;">JID</span>
                            <span class="fw-semibold text-dark" style="font-size:0.78rem;"><?php echo htmlspecialchars($device_status['jid']); ?></span>
                        </div>
                        <?php endif; ?>
                        <?php if (isset($device_status['package']['name'])): ?>
                        <div class="d-flex justify-content-between align-items-center py-1" style="border-bottom:1px dashed var(--gray-100,#f0eeeb);">
                            <span class="text-secondary" style="font-size:0.75rem;"><?php echo t('Paket', 'Package'); ?></span>
                            <span class="fw-semibold text-dark" style="font-size:0.78rem;"><?php echo htmlspecialchars($device_status['package']['name']); ?></span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center py-1" style="border-bottom:1px dashed var(--gray-100,#f0eeeb);">
                            <span class="text-secondary" style="font-size:0.75rem;"><?php echo t('Sisa Kuota', 'Remaining Quota'); ?></span>
                            <span class="fw-bold text-dark" style="font-size:0.78rem;"><?php echo (int)$device_status['package']['message_limit']; ?> <?php echo t('pesan', 'messages'); ?></span>
                        </div>
                        <?php if (isset($device_status['package']['subscription']['days_left'])): ?>
                        <div class="d-flex justify-content-between align-items-center py-1">
                            <span class="text-secondary" style="font-size:0.75rem;"><?php echo t('Berlaku', 'Valid'); ?></span>
                            <span class="fw-bold text-dark" style="font-size:0.78rem;"><?php echo (int)$device_status['package']['subscription']['days_left']; ?> <?php echo t('hari lagi', 'days left'); ?></span>
                        </div>
                        <?php endif; ?>
                        <?php endif; ?>
                    </div>
                <?php else: ?>
                    <div class="d-flex align-items-start gap-2 rounded-3 p-3" style="background:#fef2f2;">
                        <i class="fas fa-exclamation-triangle mt-1" style="color:#dc2626;font-size:0.8rem;"></i>
                        <div>
                            <div class="fw-semibold text-dark" style="font-size:0.8rem;"><?php echo t('Device belum terhubung', 'Device not connected'); ?></div>
                            <div style="color:#78716c;font-size:0.74rem;line-height:1.5;">
                                <?php if (isset($device_status['error'])): ?>
                                    <?php echo htmlspecialchars($device_status['error']); ?>
                                <?php else: ?>
                                    <?php echo t('Isi API Key & Device ID lalu simpan. Pastikan device sudah diverifikasi di panel whatsbas.', 'Fill API Key & Device ID then save. Make sure the device is verified in the whatsbas panel.'); ?>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Recent messages -->
            <div class="bento-card">
                <h6 class="fw-bold text-dark mb-3 d-flex align-items-center gap-2" style="font-size:0.85rem;">
                    <i data-lucide="history" style="width:16px;height:16px;color:var(--gray-400,#94a3b8);"></i> <?php echo t('Pesan Terbaru', 'Recent Messages'); ?>
                </h6>
                <?php if (empty($recent_messages)): ?>
                    <p class="text-muted small mb-0"><?php echo t('Belum ada pesan.', 'No messages yet.'); ?></p>
                <?php else: ?>
                    <div class="d-flex flex-column">
                        <?php foreach ($recent_messages as $m): ?>
                            <?php
                                if ($m->status === 'sent') { $mb='#E0F2F1'; $mt='#009688'; }
                                elseif ($m->status === 'failed') { $mb='#fef2f2'; $mt='#dc2626'; }
                                else { $mb='#fffbeb'; $mt='#d97706'; }
                            ?>
                            <div class="d-flex align-items-start gap-2 py-2" style="border-bottom:1px dashed var(--gray-100,#f0eeeb);">
                                <span class="px-2 py-0 rounded-pill fw-bold flex-shrink-0" style="background:<?php echo $mb; ?>;color:<?php echo $mt; ?>;font-size:0.58rem;"><?php echo $m->status; ?></span>
                                <div style="flex:1;min-width:0;">
                                    <div class="fw-semibold text-dark" style="font-size:0.75rem;"><?php echo htmlspecialchars($m->phone); ?></div>
                                    <div style="color:var(--gray-500,#78716c);font-size:0.72rem;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;"><?php echo htmlspecialchars($m->message); ?></div>
                                </div>
                                <span style="color:var(--gray-400,#a3a3a3);font-size:0.62rem;flex-shrink:0;"><?php echo date('d/m H:i', strtotime($m->created_at)); ?></span>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- ===== RIGHT: CONFIG + TEMPLATES ===== -->
        <div class="d-flex flex-column gap-3" style="position:sticky;top:1rem;">
            <?php
                $get_val = function($key, $default='') use ($settings) {
                    foreach ($settings as $s) { if ($s->key === $key) return $s->value; }
                    return $default;
                };
                $template_keys = array('wa_otp_template','wa_session_confirmed_template','wa_mentor_booking_template','wa_session_rejected_template','wa_reminder_h1_template');
            ?>
            <?php echo form_open('admin/whatsapp', array('id' => 'waForm')); ?>
            <div class="bento-card">
                <h6 class="fw-bold text-dark mb-3 d-flex align-items-center gap-2" style="font-size:0.85rem;">
                    <i data-lucide="plug" style="width:16px;height:16px;color:#25D366;"></i> <?php echo t('Konfigurasi Gateway', 'Gateway Configuration'); ?>
                </h6>
                <div class="d-flex flex-column gap-3">
                    <label class="toggle-switch">
                        <input type="checkbox" name="wa_enabled" id="wa_enabled" value="1" <?php echo $get_val('wa_enabled') === '1' ? 'checked' : ''; ?>>
                        <span class="track"></span>
                        <span class="toggle-label"><?php echo t('Aktifkan Notifikasi WhatsApp', 'Enable WhatsApp Notifications'); ?></span>
                    </label>
                    <div>
                        <label class="form-label fw-semibold small">API Key</label>
                        <input type="text" name="wa_api_key" class="form-control" value="<?php echo htmlspecialchars($get_val('wa_api_key')); ?>" placeholder="fe3318..." style="border-radius:12px;font-size:0.85rem;height:44px;font-family:monospace;">
                    </div>
                    <div class="row g-3">
                        <div class="col-6">
                            <label class="form-label fw-semibold small">Device ID</label>
                            <input type="text" name="wa_device_id" class="form-control" value="<?php echo htmlspecialchars($get_val('wa_device_id')); ?>" placeholder="3" style="border-radius:12px;font-size:0.85rem;height:44px;">
                        </div>
                        <div class="col-6">
                            <label class="form-label fw-semibold small"><?php echo t('OTP TTL (menit)', 'OTP TTL (min)'); ?></label>
                            <input type="number" name="wa_otp_ttl" class="form-control" value="<?php echo htmlspecialchars($get_val('wa_otp_ttl','5')); ?>" min="1" style="border-radius:12px;font-size:0.85rem;height:44px;">
                        </div>
                    </div>
                    <div>
                        <label class="form-label fw-semibold small"><?php echo t('Jeda Antar Pesan (detik)', 'Queue Delay (seconds)'); ?></label>
                        <input type="number" name="wa_queue_delay" class="form-control" value="<?php echo htmlspecialchars($get_val('wa_queue_delay','30')); ?>" min="1" style="border-radius:12px;font-size:0.85rem;height:44px;">
                        <small class="field-hint"><?php echo t('Perubahan berlaku setelah worker di-restart (systemctl restart wa-worker).', 'Changes apply after worker restart (systemctl restart wa-worker).'); ?></small>
                    </div>
                </div>
            </div>

            <!-- Templates -->
            <?php
                $template_meta = array(
                    'wa_otp_template' => array('label' => t('OTP Pendaftaran', 'Registration OTP'), 'vars' => array('{{otp}}','{{ttl}}','{{site}}','{{name}}'), 'icon' => 'key-round'),
                    'wa_session_confirmed_template' => array('label' => t('Sesi Dikonfirmasi (ke Siswa)', 'Session Confirmed (to Student)'), 'vars' => array('{{student_name}}','{{mentor_name}}','{{schedule}}','{{duration}}','{{site}}'), 'icon' => 'check-circle'),
                    'wa_mentor_booking_template' => array('label' => t('Booking Baru (ke Mentor)', 'New Booking (to Mentor)'), 'vars' => array('{{mentor_name}}','{{student_name}}','{{schedule}}','{{duration}}','{{site}}'), 'icon' => 'calendar-plus'),
                    'wa_session_rejected_template' => array('label' => t('Sesi Ditolak (ke Siswa)', 'Session Rejected (to Student)'), 'vars' => array('{{student_name}}','{{mentor_name}}','{{schedule}}','{{site}}'), 'icon' => 'x-circle'),
                    'wa_reminder_h1_template' => array('label' => t('Reminder H-1 (ke Mentor & Siswa)', 'H-1 Reminder (to Mentor & Student)'), 'vars' => array('{{nama}}','{{tanggal}}','{{jam}}','{{meeting_link}}'), 'icon' => 'bell'),
                );
            ?>
            <div class="bento-card">
                <h6 class="fw-bold text-dark mb-3 d-flex align-items-center gap-2" style="font-size:0.85rem;">
                    <i data-lucide="message-circle" style="width:16px;height:16px;color:#25D366;"></i> <?php echo t('Template Pesan', 'Message Templates'); ?>
                </h6>
                <div class="d-flex flex-column gap-3">
                    <?php foreach ($template_meta as $tkey => $tinfo): ?>
                    <div>
                        <label class="form-label fw-semibold small d-flex align-items-center gap-1">
                            <i data-lucide="<?php echo $tinfo['icon']; ?>" style="width:12px;height:12px;color:var(--gray-400);"></i> <?php echo $tinfo['label']; ?>
                        </label>
                        <textarea class="form-control" name="<?php echo $tkey; ?>" rows="3" style="border-radius:12px;font-size:0.78rem;font-family:monospace;line-height:1.5;"><?php echo htmlspecialchars($get_val($tkey)); ?></textarea>
                        <div class="mt-1 d-flex flex-wrap gap-1 align-items-center">
                            <?php foreach ($tinfo['vars'] as $v): ?><span class="px-1.5 py-0 rounded fw-semibold" style="background:var(--gray-100,#f1f5f9);color:#57534e;font-size:0.6rem;font-family:monospace;"><?php echo $v; ?></span><?php endforeach; ?>
                            <span style="color:#a8a29e;font-size:0.62rem;">— <?php echo t('variabel otomatis', 'auto variables'); ?></span>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Actions -->
            <div class="bento-card d-flex flex-column gap-2">
                <button type="submit" form="waForm" class="btn fw-semibold rounded-pill d-inline-flex align-items-center justify-content-center gap-2 border-0" style="background:#25D366;color:#fff;font-size:0.82rem;padding:0.7rem;">
                    <i class="fab fa-whatsapp" style="font-size:0.85rem;"></i> <?php echo t('Simpan Pengaturan', 'Save Settings'); ?>
                </button>
                <a href="<?php echo base_url('admin/dashboard'); ?>" class="btn fw-semibold rounded-pill d-inline-flex align-items-center justify-content-center gap-2 border-0" style="background:#E6EBEF;color:#57534e;font-size:0.8rem;padding:0.6rem;">
                    <?php echo t('Batal', 'Cancel'); ?>
                </a>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>
<style>
.pulse-dot {
  width: 8px; height: 8px;
  border-radius: 50%;
  background: #25D366;
  box-shadow: 0 0 0 0 rgba(37,211,102,0.6);
  animation: wa-pulse 2s infinite;
}
@keyframes wa-pulse {
  0% { box-shadow: 0 0 0 0 rgba(37,211,102,0.55); }
  70% { box-shadow: 0 0 0 8px rgba(37,211,102,0); }
  100% { box-shadow: 0 0 0 0 rgba(37,211,102,0); }
}
</style>
