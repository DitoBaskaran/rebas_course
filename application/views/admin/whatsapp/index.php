<div class="container-fluid py-4" style="max-width: 1400px;">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h4 class="fw-extrabold mb-1" style="color: #0D1830; letter-spacing: -0.02em; font-size: 1.4rem;"><i class="fab fa-whatsapp me-2" style="color:#25D366;"></i><?php echo t('WhatsApp Gateway', 'WhatsApp Gateway'); ?></h4>
            <p style="color: #78716c; font-size: 0.82rem; margin-bottom: 0;"><?php echo t('Kelola koneksi gateway wa.ditobaskaran.my.id, template pesan & antrian notifikasi', 'Manage wa.ditobaskaran.my.id gateway connection, message templates & notification queue'); ?></p>
        </div>
    </div>

    <div class="row g-3">
        <!-- ===== Kolom kiri: Koneksi & Status ===== -->
        <div class="col-lg-4 d-flex flex-column gap-3">
            <!-- Status Device -->
            <div class="border rounded-3 p-3" style="border-color:#e7e5e4; border-radius:12px;">
                <div class="d-flex align-items-center gap-2 mb-2" style="border-bottom:1px solid #f0eeeb; padding-bottom:0.6rem;">
                    <i class="fas fa-plug" style="color:#0D1830; font-size:0.8rem;"></i>
                    <span class="fw-semibold" style="color:#0D1830; font-size:0.9rem;"><?php echo t('Status Koneksi', 'Connection Status'); ?></span>
                </div>
                <?php if ($device_status && !empty($device_status['connected'])): ?>
                    <div class="d-flex align-items-center gap-2 mb-2">
                        <span class="badge rounded-pill" style="background:#dcfce7;color:#15803d;font-weight:600;"><i class="fas fa-circle me-1" style="font-size:0.45rem;color:#16a34a;"></i><?php echo t('Terhubung', 'Connected'); ?></span>
                        <?php if (isset($device_status['pushName'])): ?><span class="small text-secondary"><?php echo htmlspecialchars($device_status['pushName']); ?></span><?php endif; ?>
                    </div>
                    <?php if (isset($device_status['jid'])): ?><div class="small text-secondary mb-1"><?php echo t('JID:', 'JID:'); ?> <?php echo htmlspecialchars($device_status['jid']); ?></div><?php endif; ?>
                    <?php if (isset($device_status['package']['name'])): ?>
                        <div class="small text-secondary mb-1"><?php echo t('Paket:', 'Package:'); ?> <span class="fw-semibold text-dark"><?php echo htmlspecialchars($device_status['package']['name']); ?></span>
                            · <?php echo t('Sisa', 'Remaining'); ?> <span class="fw-semibold text-dark"><?php echo (int)$device_status['package']['message_limit']; ?></span> <?php echo t('pesan', 'messages'); ?>
                            <?php if (isset($device_status['package']['subscription']['days_left'])): ?>· <?php echo (int)$device_status['package']['subscription']['days_left']; ?> <?php echo t('hari lagi', 'days left'); ?><?php endif; ?>
                        </div>
                    <?php endif; ?>
                <?php else: ?>
                    <div class="d-flex align-items-center gap-2 mb-2">
                        <span class="badge rounded-pill" style="background:#fef2f2;color:#dc2626;font-weight:600;"><i class="fas fa-circle me-1" style="font-size:0.45rem;color:#dc2626;"></i><?php echo t('Tidak Terhubung', 'Not Connected'); ?></span>
                    </div>
                    <div class="small text-secondary">
                        <?php if (isset($device_status['error'])): ?>
                            <?php echo htmlspecialchars($device_status['error']); ?>
                        <?php else: ?>
                            <?php echo t('Isi API Key & Device ID lalu simpan. Pastikan device sudah diverifikasi di panel whatsbas.', 'Fill API Key & Device ID then save. Make sure the device is verified in the whatsbas panel.'); ?>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Statistik Antrian -->
            <div class="border rounded-3 p-3" style="border-color:#e7e5e4; border-radius:12px;">
                <div class="d-flex align-items-center gap-2 mb-2" style="border-bottom:1px solid #f0eeeb; padding-bottom:0.6rem;">
                    <i class="fas fa-tasks" style="color:#0D1830; font-size:0.8rem;"></i>
                    <span class="fw-semibold" style="color:#0D1830; font-size:0.9rem;"><?php echo t('Antrian Pesan', 'Message Queue'); ?></span>
                </div>
                <div class="row text-center g-2">
                    <div class="col-4">
                        <div class="rounded-3 py-2" style="background:#fff7ed;color:#c2410c;"><div class="fw-extrabold" style="font-size:1.2rem;"><?php echo $queue_stats['pending']; ?></div><div class="small" style="font-size:0.68rem;"><?php echo t('Menunggu', 'Pending'); ?></div></div>
                    </div>
                    <div class="col-4">
                        <div class="rounded-3 py-2" style="background:#f0fdf4;color:#15803d;"><div class="fw-extrabold" style="font-size:1.2rem;"><?php echo $queue_stats['sent']; ?></div><div class="small" style="font-size:0.68rem;"><?php echo t('Terkirim', 'Sent'); ?></div></div>
                    </div>
                    <div class="col-4">
                        <div class="rounded-3 py-2" style="background:#fef2f2;color:#dc2626;"><div class="fw-extrabold" style="font-size:1.2rem;"><?php echo $queue_stats['failed']; ?></div><div class="small" style="font-size:0.68rem;"><?php echo t('Gagal', 'Failed'); ?></div></div>
                    </div>
                </div>
            </div>

            <!-- Pesan Terbaru -->
            <div class="border rounded-3 p-3" style="border-color:#e7e5e4; border-radius:12px;">
                <div class="d-flex align-items-center gap-2 mb-2" style="border-bottom:1px solid #f0eeeb; padding-bottom:0.6rem;">
                    <i class="fas fa-history" style="color:#0D1830; font-size:0.8rem;"></i>
                    <span class="fw-semibold" style="color:#0D1830; font-size:0.9rem;"><?php echo t('Pesan Terbaru', 'Recent Messages'); ?></span>
                </div>
                <?php if (empty($recent_messages)): ?>
                    <div class="small text-secondary"><?php echo t('Belum ada pesan.', 'No messages yet.'); ?></div>
                <?php else: ?>
                    <?php foreach ($recent_messages as $m): ?>
                        <?php $badge = array('pending'=>'warning','sent'=>'success','failed'=>'danger'); ?>
                        <div class="d-flex align-items-start gap-2 py-2" style="border-bottom:1px dashed #f0eeeb;">
                            <span class="badge bg-<?php echo $badge[$m->status] ?? 'secondary'; ?> rounded-pill px-2 fw-medium" style="font-size:0.6rem;"><?php echo $m->status; ?></span>
                            <div class="flex-fill" style="min-width:0;">
                                <div class="small fw-semibold" style="color:#0D1830;"><?php echo htmlspecialchars($m->phone); ?></div>
                                <div class="small text-secondary text-truncate" style="max-width:180px;"><?php echo htmlspecialchars($m->message); ?></div>
                            </div>
                            <span class="small text-secondary flex-shrink-0" style="font-size:0.62rem;"><?php echo date('d/m H:i', strtotime($m->created_at)); ?></span>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>

        <!-- ===== Kolom kanan: Form Konfigurasi & Template ===== -->
        <div class="col-lg-8">
            <?php echo form_open('admin/whatsapp', 'class="needs-validation" novalidate'); ?>
            <div class="border rounded-3 p-3" style="border-color:#e7e5e4; border-radius:12px;">
                <div class="d-flex align-items-center gap-2 px-1 py-2 mb-3" style="border-bottom:1px solid #f0eeeb;">
                    <i class="fas fa-cog" style="color:#0D1830; font-size:0.8rem;"></i>
                    <span class="fw-semibold" style="color:#0D1830; font-size:0.9rem;"><?php echo t('Konfigurasi Gateway', 'Gateway Configuration'); ?></span>
                </div>

                <?php
                // Ambil nilai settings per key
                $get_val = function($key, $default='') use ($settings) {
                    foreach ($settings as $s) { if ($s->key === $key) return $s->value; }
                    return $default;
                };
                $template_keys = array('wa_otp_template','wa_session_confirmed_template','wa_mentor_booking_template','wa_session_rejected_template','wa_reminder_h1_template');
                ?>

                <div class="row g-3 mb-3">
                    <div class="col-md-4">
                        <label class="fw-semibold mb-1 d-block" style="color:#0D1830; font-size:0.82rem;"><?php echo t('Aktifkan Notifikasi WhatsApp', 'Enable WhatsApp Notifications'); ?></label>
                        <label class="form-check form-switch" style="padding-left:2.5rem;">
                            <input type="checkbox" name="wa_enabled" id="wa_enabled" value="1" <?php echo $get_val('wa_enabled') === '1' ? 'checked' : ''; ?> class="form-check-input" style="width:2rem;height:1rem;">
                            <span class="form-check-label small" style="color:#78716c; font-size:0.78rem;"><?php echo t('Aktif', 'Enabled'); ?></span>
                        </label>
                    </div>
                    <div class="col-md-4">
                        <label class="fw-semibold mb-1 d-block" style="color:#0D1830; font-size:0.82rem;">API Key</label>
                        <input type="text" name="wa_api_key" class="form-control" value="<?php echo htmlspecialchars($get_val('wa_api_key')); ?>" style="border-color:#e7e5e4; border-radius:8px; font-size:0.85rem;" placeholder="fe3318...">
                    </div>
                    <div class="col-md-4">
                        <label class="fw-semibold mb-1 d-block" style="color:#0D1830; font-size:0.82rem;">Device ID</label>
                        <input type="text" name="wa_device_id" class="form-control" value="<?php echo htmlspecialchars($get_val('wa_device_id')); ?>" style="border-color:#e7e5e4; border-radius:8px; font-size:0.85rem;" placeholder="3">
                    </div>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="fw-semibold mb-1 d-block" style="color:#0D1830; font-size:0.82rem;"><?php echo t('Masa Berlaku OTP (menit)', 'OTP Validity (minutes)'); ?></label>
                        <input type="number" name="wa_otp_ttl" class="form-control" value="<?php echo htmlspecialchars($get_val('wa_otp_ttl','5')); ?>" min="1" style="border-color:#e7e5e4; border-radius:8px; font-size:0.85rem;">
                    </div>
                    <div class="col-md-6">
                        <label class="fw-semibold mb-1 d-block" style="color:#0D1830; font-size:0.82rem;"><?php echo t('Jeda Antar Pesan Antrian (detik)', 'Queue Delay Between Messages (seconds)'); ?></label>
                        <input type="number" name="wa_queue_delay" class="form-control" value="<?php echo htmlspecialchars($get_val('wa_queue_delay','30')); ?>" min="1" style="border-color:#e7e5e4; border-radius:8px; font-size:0.85rem;">
                        <small style="color:#a8a29e; font-size:0.7rem;"><?php echo t('Perubahan berlaku setelah worker di-restart (systemctl restart wa-worker).', 'Changes apply after worker restart (systemctl restart wa-worker).'); ?></small>
                    </div>
                </div>

                <!-- Template messages -->
                <div class="d-flex align-items-center gap-2 px-1 py-2 mb-2" style="border-bottom:1px solid #f0eeeb;">
                    <i class="fas fa-comment-dots" style="color:#0D1830; font-size:0.8rem;"></i>
                    <span class="fw-semibold" style="color:#0D1830; font-size:0.9rem;"><?php echo t('Template Pesan', 'Message Templates'); ?></span>
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
                    <div class="mb-3">
                        <label class="fw-semibold mb-1 d-block" style="color:#0D1830; font-size:0.82rem;"><?php echo $tinfo['label']; ?></label>
                        <textarea class="form-control" name="<?php echo $tkey; ?>" rows="4" style="border-color:#e7e5e4; border-radius:8px; font-size:0.82rem; font-family:monospace;"><?php echo htmlspecialchars($get_val($tkey)); ?></textarea>
                        <div class="mt-1">
                            <?php foreach ($tinfo['vars'] as $v): ?><span class="badge rounded-pill me-1" style="background:#E6EBEF;color:#0D1830;font-size:0.62rem;font-family:monospace;"><?php echo $v; ?></span><?php endforeach; ?>
                            <span class="small" style="color:#a8a29e; font-size:0.68rem;"><?php echo t('— variabel otomatis', '— auto variables'); ?></span>
                        </div>
                    </div>
                <?php endforeach; ?>

                <div class="d-flex justify-content-end gap-2 pt-3" style="border-top:1px solid #f0eeeb;">
                    <a href="<?php echo base_url('admin/dashboard'); ?>" class="btn px-4 py-2 rounded-pill fw-semibold" style="border:1px solid #e7e5e4;color:#57534e;font-size:0.82rem;"><?php echo t('Batal', 'Cancel'); ?></a>
                    <button type="submit" class="btn px-4 py-2 fw-bold rounded-pill d-flex align-items-center gap-1" style="background:#25D366;color:#fff;font-size:0.82rem;">
                        <i class="fas fa-save" style="font-size:0.7rem;"></i> <?php echo t('Simpan Pengaturan', 'Save Settings'); ?>
                    </button>
                </div>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>
