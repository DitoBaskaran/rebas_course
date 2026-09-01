<div class="app-page">
    <!-- Header -->
    <div class="app-page-head">
        <div>
            <h4 class="app-page-title"><i class="fab fa-whatsapp" style="color:#25D366;"></i> <?php echo t('WhatsApp Gateway', 'WhatsApp Gateway'); ?></h4>
            <p class="app-page-sub"><?php echo t('Kelola koneksi gateway wa.ditobaskaran.my.id, template pesan & antrian notifikasi', 'Manage wa.ditobaskaran.my.id gateway connection, message templates & notification queue'); ?></p>
        </div>
    </div>

    <div class="app-grid app-grid-2" style="grid-template-columns:1fr;align-items:start;">

        <!-- ===== Kolom kiri: Koneksi & Status ===== -->
        <div class="app-list" style="gap:0.8rem;">
            <!-- Status Device -->
            <div class="app-card app-card-pad">
                <div class="app-card-head" style="padding:0 0 0.6rem;margin-bottom:0.7rem;">
                    <h6><i class="fas fa-plug" style="color:#0D1830;"></i> <?php echo t('Status Koneksi', 'Connection Status'); ?></h6>
                </div>
                <?php if ($device_status && !empty($device_status['connected'])): ?>
                    <div class="d-flex align-items-center gap-2 mb-2">
                        <span class="app-chip app-chip-green"><i class="fas fa-circle" style="font-size:0.45rem;"></i> <?php echo t('Terhubung', 'Connected'); ?></span>
                        <?php if (isset($device_status['pushName'])): ?><span style="color:var(--gray-500,#78716c);font-size:0.75rem;"><?php echo htmlspecialchars($device_status['pushName']); ?></span><?php endif; ?>
                    </div>
                    <?php if (isset($device_status['jid'])): ?><div style="color:var(--gray-500,#78716c);font-size:0.75rem;margin-bottom:0.25rem;"><?php echo t('JID:', 'JID:'); ?> <?php echo htmlspecialchars($device_status['jid']); ?></div><?php endif; ?>
                    <?php if (isset($device_status['package']['name'])): ?>
                        <div style="color:var(--gray-500,#78716c);font-size:0.75rem;"><?php echo t('Paket:', 'Package:'); ?> <span class="fw-semibold" style="color:var(--gray-800,#262626);"><?php echo htmlspecialchars($device_status['package']['name']); ?></span>
                            · <?php echo t('Sisa', 'Remaining'); ?> <span class="fw-semibold" style="color:var(--gray-800,#262626);"><?php echo (int)$device_status['package']['message_limit']; ?></span> <?php echo t('pesan', 'messages'); ?>
                            <?php if (isset($device_status['package']['subscription']['days_left'])): ?>· <?php echo (int)$device_status['package']['subscription']['days_left']; ?> <?php echo t('hari lagi', 'days left'); ?><?php endif; ?>
                        </div>
                    <?php endif; ?>
                <?php else: ?>
                    <div class="d-flex align-items-center gap-2 mb-2">
                        <span class="app-chip app-chip-red"><i class="fas fa-circle" style="font-size:0.45rem;"></i> <?php echo t('Tidak Terhubung', 'Not Connected'); ?></span>
                    </div>
                    <div style="color:var(--gray-500,#78716c);font-size:0.75rem;">
                        <?php if (isset($device_status['error'])): ?>
                            <?php echo htmlspecialchars($device_status['error']); ?>
                        <?php else: ?>
                            <?php echo t('Isi API Key & Device ID lalu simpan. Pastikan device sudah diverifikasi di panel whatsbas.', 'Fill API Key & Device ID then save. Make sure the device is verified in the whatsbas panel.'); ?>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Statistik Antrian -->
            <div class="app-card app-card-pad">
                <div class="app-card-head" style="padding:0 0 0.6rem;margin-bottom:0.7rem;">
                    <h6><i class="fas fa-tasks" style="color:#0D1830;"></i> <?php echo t('Antrian Pesan', 'Message Queue'); ?></h6>
                </div>
                <div class="app-grid app-grid-4" style="gap:0.5rem;grid-template-columns:repeat(3,1fr);">
                    <div class="rounded-3 py-2 text-center" style="background:#fff7ed;color:#c2410c;"><div class="fw-extrabold" style="font-size:1.2rem;"><?php echo $queue_stats['pending']; ?></div><div style="font-size:0.68rem;"><?php echo t('Menunggu', 'Pending'); ?></div></div>
                    <div class="rounded-3 py-2 text-center" style="background:#f0fdf4;color:#15803d;"><div class="fw-extrabold" style="font-size:1.2rem;"><?php echo $queue_stats['sent']; ?></div><div style="font-size:0.68rem;"><?php echo t('Terkirim', 'Sent'); ?></div></div>
                    <div class="rounded-3 py-2 text-center" style="background:#fef2f2;color:#dc2626;"><div class="fw-extrabold" style="font-size:1.2rem;"><?php echo $queue_stats['failed']; ?></div><div style="font-size:0.68rem;"><?php echo t('Gagal', 'Failed'); ?></div></div>
                </div>
            </div>

            <!-- Pesan Terbaru -->
            <div class="app-card app-card-pad">
                <div class="app-card-head" style="padding:0 0 0.6rem;margin-bottom:0.7rem;">
                    <h6><i class="fas fa-history" style="color:#0D1830;"></i> <?php echo t('Pesan Terbaru', 'Recent Messages'); ?></h6>
                </div>
                <?php if (empty($recent_messages)): ?>
                    <div style="color:var(--gray-500,#78716c);font-size:0.75rem;"><?php echo t('Belum ada pesan.', 'No messages yet.'); ?></div>
                <?php else: ?>
                    <?php foreach ($recent_messages as $m): ?>
                        <?php $badge_cls = array('pending'=>'app-chip-amber','sent'=>'app-chip-green','failed'=>'app-chip-red'); ?>
                        <div class="d-flex align-items-start gap-2 py-2" style="border-bottom:1px dashed #f0eeeb;">
                            <span class="app-chip <?php echo $badge_cls[$m->status] ?? 'app-chip-gray'; ?>" style="font-size:0.55rem;"><?php echo $m->status; ?></span>
                            <div style="flex:1;min-width:0;">
                                <div class="fw-semibold" style="color:#0D1830;font-size:0.75rem;"><?php echo htmlspecialchars($m->phone); ?></div>
                                <div style="color:var(--gray-500,#78716c);font-size:0.72rem;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;max-width:180px;"><?php echo htmlspecialchars($m->message); ?></div>
                            </div>
                            <span style="color:var(--gray-400,#a3a3a3);font-size:0.62rem;flex-shrink:0;"><?php echo date('d/m H:i', strtotime($m->created_at)); ?></span>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>

        <!-- ===== Kolom kanan: Form Konfigurasi & Template ===== -->
        <div class="app-card app-card-pad app-form-card" style="max-width:100%;">
            <?php echo form_open('admin/whatsapp', 'class="needs-validation" novalidate'); ?>
            <div class="app-form-grid">
                <div class="app-card-head" style="padding:0 0 0.6rem;">
                    <h6><i class="fas fa-cog" style="color:#0D1830;"></i> <?php echo t('Konfigurasi Gateway', 'Gateway Configuration'); ?></h6>
                </div>

                <?php
                // Ambil nilai settings per key
                $get_val = function($key, $default='') use ($settings) {
                    foreach ($settings as $s) { if ($s->key === $key) return $s->value; }
                    return $default;
                };
                $template_keys = array('wa_otp_template','wa_session_confirmed_template','wa_mentor_booking_template','wa_session_rejected_template','wa_reminder_h1_template');
                ?>

                <div class="app-form-grid app-form-grid-2">
                    <div class="app-field">
                        <label><?php echo t('Aktifkan Notifikasi WhatsApp', 'Enable WhatsApp Notifications'); ?></label>
                        <label class="form-check form-switch" style="padding-left:2.5rem;">
                            <input type="checkbox" name="wa_enabled" id="wa_enabled" value="1" <?php echo $get_val('wa_enabled') === '1' ? 'checked' : ''; ?> class="form-check-input" style="width:2rem;height:1rem;">
                            <span class="form-check-label" style="color:#78716c;font-size:0.78rem;"><?php echo t('Aktif', 'Enabled'); ?></span>
                        </label>
                    </div>
                    <div class="app-field">
                        <label>API Key</label>
                        <input type="text" name="wa_api_key" class="form-control" value="<?php echo htmlspecialchars($get_val('wa_api_key')); ?>" placeholder="fe3318...">
                    </div>
                    <div class="app-field">
                        <label>Device ID</label>
                        <input type="text" name="wa_device_id" class="form-control" value="<?php echo htmlspecialchars($get_val('wa_device_id')); ?>" placeholder="3">
                    </div>
                    <div class="app-field">
                        <label><?php echo t('Masa Berlaku OTP (menit)', 'OTP Validity (minutes)'); ?></label>
                        <input type="number" name="wa_otp_ttl" class="form-control" value="<?php echo htmlspecialchars($get_val('wa_otp_ttl','5')); ?>" min="1">
                    </div>
                    <div class="app-field">
                        <label><?php echo t('Jeda Antar Pesan Antrian (detik)', 'Queue Delay Between Messages (seconds)'); ?></label>
                        <input type="number" name="wa_queue_delay" class="form-control" value="<?php echo htmlspecialchars($get_val('wa_queue_delay','30')); ?>" min="1">
                        <div class="app-hint"><?php echo t('Perubahan berlaku setelah worker di-restart (systemctl restart wa-worker).', 'Changes apply after worker restart (systemctl restart wa-worker).'); ?></div>
                    </div>
                </div>

                <div class="app-card-head" style="padding:0 0 0.6rem;">
                    <h6><i class="fas fa-comment-dots" style="color:#0D1830;"></i> <?php echo t('Template Pesan', 'Message Templates'); ?></h6>
                </div>

                <?php
                $template_meta = array(
                    'wa_otp_template' => array('label' => t('OTP Pendaftaran', 'Registration OTP'), 'vars' => array('{{otp}}','{{ttl}}','{{site}}','{{name}}')),
                    'wa_session_confirmed_template' => array('label' => t('Sesi Dikonfirmasi (ke Siswa)', 'Session Confirmed (to Student)'), 'vars' => array('{{student_name}}','{{mentor_name}}','{{schedule}}','{{duration}}','{{site}}')),
                    'wa_mentor_booking_template' => array('label' => t('Booking Baru (ke Mentor)', 'New Booking (to Mentor)'), 'vars' => array('{{mentor_name}}','{{student_name}}','{{schedule}}','{{duration}}','{{site}}')),
                    'wa_session_rejected_template' => array('label' => t('Sesi Ditolak (ke Siswa)', 'Session Rejected (to Student)'), 'vars' => array('{{student_name}}','{{mentor_name}}','{{schedule}}','{{site}}')),
                    'wa_reminder_h1_template' => array('label' => t('Reminder H-1 (ke Mentor & Siswa)', 'H-1 Reminder (to Mentor & Student)'), 'vars' => array('{{nama}}','{{tanggal}}','{{jam}}','{{meeting_link}}')),
                );
                foreach ($template_meta as $tkey => $tinfo): ?>
                    <div class="app-field">
                        <label><?php echo $tinfo['label']; ?></label>
                        <textarea class="form-control" name="<?php echo $tkey; ?>" rows="4" style="font-family:monospace;"><?php echo htmlspecialchars($get_val($tkey)); ?></textarea>
                        <div class="mt-1 d-flex flex-wrap gap-1">
                            <?php foreach ($tinfo['vars'] as $v): ?><span class="app-chip app-chip-gray" style="font-family:monospace;"><?php echo $v; ?></span><?php endforeach; ?>
                            <span style="color:#a8a29e;font-size:0.68rem;"><?php echo t('— variabel otomatis', '— auto variables'); ?></span>
                        </div>
                    </div>
                <?php endforeach; ?>

                <div class="app-form-actions" style="border-top:1px solid #f0eeeb;padding-top:1rem;">
                    <a href="<?php echo base_url('admin/dashboard'); ?>" class="app-btn"><?php echo t('Batal', 'Cancel'); ?></a>
                    <button type="submit" class="app-btn app-btn-success" style="background:#25D366;"><i class="fas fa-save"></i> <?php echo t('Simpan Pengaturan', 'Save Settings'); ?></button>
                </div>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>
