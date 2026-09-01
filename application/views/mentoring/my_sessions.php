<div class="container" style="max-width: 960px; padding-top: 1.5rem; padding-bottom: 3rem;">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h4 class="fw-extrabold mb-1" style="color: #111827; font-size: 1.2rem; letter-spacing: -0.02em;">
                <?php echo t('Sesi Mentoring Saya', 'My Mentoring Sessions'); ?>
            </h4>
            <p style="color: #737373; font-size: 0.82rem; margin-bottom: 0;">
                <?php echo t('Riwayat sesi konsultasi Anda', 'Your consultation session history'); ?>
            </p>
        </div>
        <a href="<?php echo base_url('mentoring'); ?>" class="btn px-3 py-2 fw-semibold rounded-pill flex-shrink-0" style="background: #f5f5f5; color: #111827; font-size: 0.8rem;">
            <i class="fas fa-search" style="font-size: 0.7rem;"></i> <?php echo t('Cari Mentor', 'Find Mentor'); ?>
        </a>
    </div>

    <!-- Active Balances -->
    <?php if (!empty($balances)): ?>
        <div class="d-flex gap-3 mb-4 flex-wrap">
            <?php foreach ($balances as $bal): ?>
                <div class="rounded-3 p-3 d-flex align-items-center gap-3" style="border: 1px solid #e5e5e5; min-width: 180px;">
                    <div class="d-flex align-items-center justify-content-center rounded-circle fw-bold" style="width: 40px; height: 40px; background: #fef3c7; color: #92400e; font-size: 0.85rem;">
                        <?php echo $bal->remaining_sessions; ?>
                    </div>
                    <div>
                        <small class="fw-semibold" style="color: #111827; font-size: 0.75rem;"><?php echo htmlspecialchars(t($bal->name, $bal->name_en)); ?></small>
                        <br><small style="color: #a3a3a3; font-size: 0.68rem;">/ <?php echo $bal->total_sessions; ?> <?php echo t('sesi', 'sessions'); ?> · <?php echo $bal->session_duration; ?>m</small>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <!-- Sessions -->
    <?php if (empty($sessions)): ?>
        <div class="text-center py-5">
            <div style="font-size: 2.5rem; color: #d4d4d4; margin-bottom: 0.75rem;"><i class="fas fa-calendar"></i></div>
            <h5 class="fw-bold" style="color: #111827;"><?php echo t('Belum Ada Sesi', 'No Sessions Yet'); ?></h5>
            <p style="color: #737373; font-size: 0.85rem;"><?php echo t('Belum ada sesi mentoring.', 'No mentoring sessions yet.'); ?></p>
        </div>
    <?php else: ?>
        <div class="border rounded-3" style="border-color: #e5e5e5; border-radius: 12px; overflow: hidden;">
            <div class="table-responsive">
                <table class="table mb-0" style="font-size: 0.83rem;">
                    <thead>
                        <tr>
                            <th style="font-weight: 600; color: #525252; font-size: 0.7rem; border-color: #e5e5e5; padding: 0.75rem 1rem; background: #fafafa;"><?php echo t('Mentor', 'Mentor'); ?></th>
                            <th style="font-weight: 600; color: #525252; font-size: 0.7rem; border-color: #e5e5e5; padding: 0.75rem 1rem; background: #fafafa;"><?php echo t('Tanggal', 'Date'); ?></th>
                            <th style="font-weight: 600; color: #525252; font-size: 0.7rem; border-color: #e5e5e5; padding: 0.75rem 1rem; background: #fafafa;"><?php echo t('Durasi', 'Duration'); ?></th>
                            <th style="font-weight: 600; color: #525252; font-size: 0.7rem; border-color: #e5e5e5; padding: 0.75rem 1rem; background: #fafafa;"><?php echo t('Status', 'Status'); ?></th>
                            <th style="font-weight: 600; color: #525252; font-size: 0.7rem; border-color: #e5e5e5; padding: 0.75rem 1rem; background: #fafafa;"><?php echo t('Aksi', 'Action'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($sessions as $s): ?>
                            <tr>
                                <td style="border-color: #f0f0f0; padding: 0.75rem 1rem;">
                                    <div class="d-flex align-items-center gap-2">
                                        <img src="https://ui-avatars.com/api/?name=<?php echo urlencode($s->mentor_name); ?>&background=f5f5f5&color=525252&size=28" alt="" style="width: 28px; height: 28px; border-radius: 50%;">
                                        <div>
                                            <div class="fw-semibold" style="color: #111827; font-size: 0.8rem;"><?php echo htmlspecialchars($s->mentor_name); ?></div>
                                            <small style="color: #a3a3a3; font-size: 0.68rem;"><?php echo $s->title; ?></small>
                                        </div>
                                    </div>
                                </td>
                                <td style="border-color: #f0f0f0; padding: 0.75rem 1rem; color: #525252; font-size: 0.8rem;"><?php echo date('d M Y H:i', strtotime($s->scheduled_at)); ?></td>
                                <td style="border-color: #f0f0f0; padding: 0.75rem 1rem; color: #525252; font-size: 0.8rem;"><?php echo $s->duration; ?>m</td>
                                <td style="border-color: #f0f0f0; padding: 0.75rem 1rem;">
                                    <?php $badge = array('pending' => '#fef3c7', 'confirmed' => '#E0F2F1', 'completed' => '#f5f5f5', 'cancelled' => '#fef2f2', 'no_show' => '#f5f5f5'); ?>
                                    <?php $color = array('pending' => '#92400e', 'confirmed' => '#065f46', 'completed' => '#525252', 'cancelled' => '#991b1b', 'no_show' => '#a3a3a3'); ?>
                                    <span class="px-2 py-1 rounded-pill fw-medium" style="background: <?php echo $badge[$s->status] ?? '#f5f5f5'; ?>; color: <?php echo $color[$s->status] ?? '#525252'; ?>; font-size: 0.7rem;">
                                        <?php echo t(ucfirst($s->status), ucfirst($s->status)); ?>
                                    </span>
                                </td>
                                <td style="border-color: #f0f0f0; padding: 0.75rem 1rem;">
                                    <div class="d-flex gap-1">
                                        <?php if ($s->status == 'pending'): ?>
                                            <a href="<?php echo base_url('mentoring/approve-booking/' . encode_id($s->id)); ?>" class="btn btn-sm fw-semibold rounded-pill px-2" style="font-size: 0.72rem; background: #111827; color: #fff;"><?php echo t('Konfirmasi', 'Confirm'); ?></a>
                                            <a href="<?php echo base_url('mentoring/cancel/' . encode_id($s->id)); ?>" class="btn btn-sm fw-semibold rounded-pill px-2" style="font-size: 0.72rem; border: 1px solid #e5e5e5; color: #ef4444;" onclick="return confirm('<?php echo t('Batalkan sesi?', 'Cancel session?'); ?>')"><?php echo t('Batal', 'Cancel'); ?></a>
                                        <?php elseif ($s->status == 'confirmed'): ?>
                                            <a href="<?php echo base_url('mentoring/cancel/' . encode_id($s->id)); ?>" class="btn btn-sm fw-semibold rounded-pill px-2" style="font-size: 0.72rem; border: 1px solid #e5e5e5; color: #ef4444;" onclick="return confirm('<?php echo t('Batalkan sesi?', 'Cancel session?'); ?>')"><?php echo t('Batal', 'Cancel'); ?></a>
                                        <?php elseif ($s->status == 'completed'): ?>
                                            <?php $reviewed = $this->db->where('session_id', $s->id)->count_all_results('mentor_reviews'); ?>
                                            <?php if (!$reviewed): ?>
                                                <button class="btn btn-sm fw-semibold rounded-pill px-2" style="font-size: 0.72rem; background: #fef3c7; color: #92400e;" data-bs-toggle="modal" data-bs-target="#reviewModal_<?php echo $s->id; ?>"><?php echo t('Review', 'Review'); ?></button>
                                            <?php else: ?>
                                                <span class="px-2 py-1 rounded-pill" style="background: #f5f5f5; color: #a3a3a3; font-size: 0.7rem;"><?php echo t('Sudah', 'Done'); ?></span>
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

<!-- Review Modals -->
<?php foreach ($sessions as $s): if ($s->status == 'completed'): ?>
<div class="modal fade" id="reviewModal_<?php echo $s->id; ?>" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content" style="border-radius: 12px; border: none; box-shadow: 0 20px 60px rgba(0,0,0,0.12);">
            <?php echo form_open('mentoring/review/' . encode_id($s->id)); ?>
                <div class="modal-header" style="border-bottom: 1px solid #f0f0f0; padding: 1rem 1.25rem;">
                    <h6 class="fw-bold mb-0" style="font-size: 0.9rem;"><?php echo t('Review Mentor', 'Review Mentor'); ?></h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" style="font-size: 0.75rem;"></button>
                </div>
                <div class="modal-body p-4 text-center">
                    <h6 class="fw-bold mb-3" style="color: #111827;"><?php echo htmlspecialchars($s->mentor_name); ?></h6>
                    <label class="fw-semibold mb-2 d-block" style="color: #525252; font-size: 0.8rem;"><?php echo t('Rating', 'Rating'); ?></label>
                    <div class="d-flex justify-content-center gap-2 mb-3">
                        <?php for ($i = 5; $i >= 1; $i--): ?>
                            <label class="d-inline-flex align-items-center justify-content-center" style="width: 36px; height: 36px; cursor: pointer;">
                                <input type="radio" name="rating" value="<?php echo $i; ?>" class="d-none" required>
                                <i class="fas fa-star" style="color: #d4d4d4; font-size: 1.2rem;"></i>
                            </label>
                        <?php endfor; ?>
                    </div>
                    <textarea name="review_text" class="form-control" rows="3" style="border-radius: 8px; border-color: #e5e5e5; font-size: 0.85rem;" placeholder="<?php echo t('Tulis pengalaman Anda...', 'Write your experience...'); ?>"></textarea>
                </div>
                <div class="modal-footer" style="border-top: 1px solid #f0f0f0; padding: 0.875rem 1.25rem;">
                    <button type="submit" class="btn py-2 fw-bold rounded-pill w-100" style="background: #111827; color: #fff; font-size: 0.85rem;"><?php echo t('Kirim Review', 'Submit Review'); ?></button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php endif; endforeach; ?>

<style>
    input[name="rating"]:checked + i { color: #009688 !important; }
    input[name="rating"]:not(:checked) + i { color: #d4d4d4; }
</style>
