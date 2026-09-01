<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-extrabold mb-1"><?php echo t('Sesi Masuk', 'Incoming Sessions'); ?></h4>
            <p class="text-secondary small mb-0"><?php echo t('Kelola permintaan sesi mentoring', 'Manage mentoring session requests'); ?></p>
        </div>
        <a href="<?php echo base_url('mentor/availability'); ?>" class="btn btn-outline-dark rounded-pill px-4 fw-semibold">
            <i data-lucide="calendar" style="width:16px;height:16px;" class="me-1"></i> <?php echo t('Atur Jadwal', 'Set Schedule'); ?>
        </a>
    </div>

    <?php if (empty($sessions)): ?>
        <div class="text-center py-5">
            <i data-lucide="inbox" style="width:48px;height:48px;" class="text-muted mb-3"></i>
            <p class="text-secondary"><?php echo t('Belum ada sesi masuk.', 'No incoming sessions.'); ?></p>
        </div>
    <?php else: ?>
        <div class="card border-0 shadow-sm rounded-4">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="small fw-bold px-4"><?php echo t('User', 'User'); ?></th>
                            <th class="small fw-bold"><?php echo t('Tanggal', 'Date'); ?></th>
                            <th class="small fw-bold"><?php echo t('Durasi', 'Duration'); ?></th>
                            <th class="small fw-bold"><?php echo t('Catatan', 'Notes'); ?></th>
                            <th class="small fw-bold"><?php echo t('Status', 'Status'); ?></th>
                            <th class="small fw-bold"><?php echo t('Aksi', 'Action'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($sessions as $s): ?>
                            <tr>
                                <td class="px-4">
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="rounded-circle bg-dark text-white d-flex align-items-center justify-content-center fw-bold flex-shrink-0" style="width:32px;height:32px;font-size:0.7rem;">
                                            <?php echo strtoupper(substr($s->user_name, 0, 1)); ?>
                                        </div>
                                        <div class="fw-semibold small"><?php echo htmlspecialchars($s->user_name); ?></div>
                                    </div>
                                </td>
                                <td><span class="small"><?php echo date('d M Y H:i', strtotime($s->scheduled_at)); ?></span></td>
                                <td><span class="small"><?php echo $s->duration; ?> <?php echo t('mnt', 'min'); ?></span></td>
                                <td><span class="small text-secondary"><?php echo htmlspecialchars(substr($s->notes ?? '', 0, 50)); ?></span></td>
                                <td>
                                    <?php $badge = array('pending' => 'warning', 'confirmed' => 'success', 'completed' => 'dark', 'cancelled' => 'danger', 'no_show' => 'secondary'); ?>
                                    <span class="badge bg-<?php echo $badge[$s->status] ?? 'secondary'; ?> rounded-pill px-3 fw-medium">
                                        <?php echo t(ucfirst($s->status), ucfirst($s->status)); ?>
                                    </span>
                                </td>
                                <td>
                                    <div class="d-flex gap-1">
                                        <?php if ($s->status == 'pending'): ?>
                                            <button type="button" class="btn btn-sm btn-success rounded-pill px-3 fw-medium" data-bs-toggle="modal" data-bs-target="#confirmModal_<?php echo $s->id; ?>"><?php echo t('Terima', 'Accept'); ?></button>
                                            <a href="<?php echo base_url('mentor/reject-session/' . encode_id($s->id)); ?>" class="btn btn-sm btn-outline-danger rounded-pill px-3 fw-medium" onclick="return confirm('<?php echo t('Tolak sesi?', 'Reject session?'); ?>')"><?php echo t('Tolak', 'Reject'); ?></a>
                                        <?php elseif ($s->status == 'confirmed'): ?>
                                            <?php if (!empty($s->meeting_url)): ?>
                                                <a href="<?php echo htmlspecialchars($s->meeting_url); ?>" target="_blank" class="btn btn-sm btn-outline-primary rounded-pill px-3 fw-medium"><i data-lucide="video" style="width:14px;height:14px;" class="me-1"></i><?php echo t('Link Meet', 'Meet Link'); ?></a>
                                            <?php endif; ?>
                                            <a href="<?php echo base_url('mentor/complete-session/' . encode_id($s->id)); ?>" class="btn btn-sm btn-dark rounded-pill px-3 fw-medium"><?php echo t('Selesai', 'Complete'); ?></a>
                                        <?php elseif ($s->status == 'completed'): ?>
                                            <?php $rated = $this->db->where('session_id', $s->id)->count_all_results('user_reputations'); ?>
                                            <?php if (!$rated): ?>
                                                <button class="btn btn-sm btn-outline-warning rounded-pill px-3 fw-medium" data-bs-toggle="modal" data-bs-target="#rateModal_<?php echo $s->id; ?>"><?php echo t('Nilai User', 'Rate User'); ?></button>
                                            <?php else: ?>
                                                <span class="badge bg-light text-dark rounded-pill fw-medium"><?php echo t('Dinilai', 'Rated'); ?></span>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php endif; ?>
</div>

<!-- Confirm Session Modals (isi link meeting) -->
<?php foreach ($sessions as $s): if ($s->status == 'pending'): ?>
<div class="modal fade" id="confirmModal_<?php echo $s->id; ?>" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <?php echo form_open('mentor/confirm-session/' . encode_id($s->id)); ?>
                <div class="modal-header border-0 pb-0">
                    <h6 class="fw-bold"><?php echo t('Konfirmasi Sesi', 'Confirm Session'); ?></h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <div class="fw-semibold small"><?php echo htmlspecialchars($s->user_name); ?></div>
                        <div class="text-secondary small"><?php echo date('d M Y H:i', strtotime($s->scheduled_at)); ?> · <?php echo $s->duration; ?> <?php echo t('menit', 'min'); ?></div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold small"><?php echo t('Platform', 'Platform'); ?></label>
                        <select name="meeting_platform" class="form-select">
                            <option value="gmeet">Google Meet</option>
                            <option value="zoom">Zoom</option>
                            <option value="whatsapp">WhatsApp</option>
                            <option value="other"><?php echo t('Lainnya', 'Other'); ?></option>
                        </select>
                    </div>
                    <div class="mb-1">
                        <label class="form-label fw-bold small"><?php echo t('Link Meeting', 'Meeting Link'); ?></label>
                        <input type="url" name="meeting_url" class="form-control" placeholder="https://meet.google.com/xxx-xxxx-xxx">
                        <small class="text-secondary" style="font-size:0.7rem;"><?php echo t('Opsional — bisa ditambahkan nanti. Link ini akan disertakan di notifikasi WhatsApp ke siswa & reminder H-1.', 'Optional — can be added later. This link will be included in the WhatsApp notification to the student & H-1 reminder.'); ?></small>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="submit" class="btn btn-success rounded-pill px-5 fw-semibold w-100"><?php echo t('Konfirmasi Sesi', 'Confirm Session'); ?></button>
                </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>
<?php endif; endforeach; ?>

<!-- Rate User Modals -->
<?php foreach ($sessions as $s): if ($s->status == 'completed'): ?>
<div class="modal fade" id="rateModal_<?php echo $s->id; ?>" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <?php echo form_open('mentor/rate-user/' . encode_id($s->id)); ?>
                <div class="modal-header border-0 pb-0">
                    <h6 class="fw-bold"><?php echo t('Nilai User', 'Rate User'); ?></h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="text-center mb-3">
                        <h6 class="fw-bold"><?php echo htmlspecialchars($s->user_name); ?></h6>
                    </div>
                    <div class="mb-3 text-center">
                        <label class="form-label fw-bold small"><?php echo t('Rating', 'Rating'); ?></label>
                        <div class="d-flex justify-content-center gap-2" style="font-size:1.5rem;">
                            <?php for ($i = 5; $i >= 1; $i--): ?>
                                <input type="radio" name="rating" value="<?php echo $i; ?>" id="rate_<?php echo $s->id; ?>_<?php echo $i; ?>" class="btn-check" required>
                                <label class="btn btn-outline-warning rounded-circle p-2" for="rate_<?php echo $s->id; ?>_<?php echo $i; ?>" style="width:44px;height:44px;display:flex;align-items:center;justify-content:center;">
                                    <?php echo $i; ?>
                                </label>
                            <?php endfor; ?>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold small"><?php echo t('Ulasan', 'Review'); ?></label>
                        <textarea name="review_text" class="form-control" rows="3" placeholder="<?php echo t('Kesan Anda terhadap user...', 'Your impression of the user...'); ?>"></textarea>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="submit" class="btn btn-dark rounded-pill px-5 fw-semibold w-100"><?php echo t('Kirim', 'Submit'); ?></button>
                </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>
<?php endif; endforeach; ?>
