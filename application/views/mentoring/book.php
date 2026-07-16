<div class="container" style="max-width: 960px; padding-top: 1.5rem; padding-bottom: 3rem;">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4" style="font-size: 0.8rem;">
        <ol class="breadcrumb" style="background: none; padding: 0;">
            <li class="breadcrumb-item"><a href="<?php echo base_url('mentoring'); ?>" style="color: #525252; text-decoration: none; font-weight: 500;"><?php echo t('Mentoring', 'Mentoring'); ?></a></li>
            <li class="breadcrumb-item"><a href="<?php echo base_url('mentoring/detail/' . encode_id($mentor->id)); ?>" style="color: #525252; text-decoration: none; font-weight: 500;"><?php echo htmlspecialchars($mentor->name); ?></a></li>
            <li class="breadcrumb-item active" style="color: #737373; font-weight: 500;"><?php echo t('Booking', 'Booking'); ?></li>
        </ol>
    </nav>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="border rounded-3 p-4" style="border-color: #e5e5e5; border-radius: 12px;">
                <h5 class="fw-bold mb-4" style="color: #111827; font-size: 1rem;"><?php echo t('Pilih Paket & Jadwal', 'Choose Package & Schedule'); ?></h5>

                <form method="post" action="<?php echo base_url('mentoring/confirm-booking'); ?>">
                    <input type="hidden" name="mentor_id" value="<?php echo $mentor->id; ?>">

                    <!-- Select Package -->
                    <div class="mb-4">
                        <label class="fw-semibold mb-2 d-block" style="color: #111827; font-size: 0.85rem;"><?php echo t('Pilih Paket', 'Choose Package'); ?></label>
                        <?php if (empty($balances)): ?>
                            <div class="p-3 rounded-3" style="background: #fef3c7; color: #92400e; font-size: 0.85rem;">
                                <?php echo t('Anda belum memiliki paket aktif.', 'You have no active packages.'); ?>
                                <a href="<?php echo base_url('mentoring/packages'); ?>" class="fw-bold" style="color: #111827;"><?php echo t('Beli paket', 'Buy package'); ?></a>
                            </div>
                        <?php else: ?>
                            <div class="d-flex flex-column gap-2">
                                <?php foreach ($balances as $bal): ?>
                                    <label class="d-flex justify-content-between align-items-center p-3 rounded-3" style="border: 1px solid #e5e5e5; cursor: pointer; transition: all 0.15s;">
                                        <input type="radio" name="balance_id" value="<?php echo $bal->id; ?>" class="me-2" required style="accent-color: #eab308;">
                                        <div class="flex-fill min-w-0">
                                            <strong style="color: #111827; font-size: 0.83rem;"><?php echo htmlspecialchars(t($bal->name, $bal->name_en)); ?></strong>
                                            <br><small style="color: #737373; font-size: 0.75rem;">
                                                <?php echo $bal->remaining_sessions; ?> / <?php echo $bal->total_sessions; ?> <?php echo t('sesi tersisa', 'sessions remaining'); ?> · <?php echo $bal->session_duration; ?> <?php echo t('mnt/sesi', 'min/session'); ?>
                                            </small>
                                        </div>
                                        <span class="fw-bold ms-2 px-2 py-1 rounded-pill" style="background: #f5f5f5; color: #525252; font-size: 0.7rem;">
                                            <?php echo t('Sisa: ' . $bal->remaining_sessions, 'Left: ' . $bal->remaining_sessions); ?>
                                        </span>
                                    </label>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Select Schedule -->
                    <div class="mb-4">
                        <label class="fw-semibold mb-2 d-block" style="color: #111827; font-size: 0.85rem;"><?php echo t('Pilih Jadwal', 'Choose Schedule'); ?></label>
                        <?php $day_names = array(t('Min', 'Sun'), t('Sen', 'Mon'), t('Sel', 'Tue'), t('Rab', 'Wed'), t('Kam', 'Thu'), t('Jum', 'Fri'), t('Sab', 'Sat')); ?>
                        <div class="d-flex gap-2 flex-wrap" id="slotContainer">
                            <?php foreach ($week_slots as $day_idx => $slots): ?>
                                <?php if (empty($slots)) continue; ?>
                                <div class="flex-fill text-center" style="min-width: 80px;">
                                    <div class="fw-bold mb-2" style="color: #525252; font-size: 0.7rem;"><?php echo $day_names[$day_idx]; ?></div>
                                    <?php foreach ($slots as $slot): ?>
                                        <div class="mb-1 position-relative">
                                            <input type="radio" name="availability_id" value="<?php echo $slot->id; ?>" id="slot_<?php echo $slot->id; ?>" class="d-none" required>
                                            <label for="slot_<?php echo $slot->id; ?>" class="d-block rounded-3 p-2 text-center" style="border: 1px solid #e5e5e5; color: #525252; font-size: 0.68rem; cursor: pointer; transition: all 0.15s;">
                                                <?php echo substr($slot->start_time, 0, 5); ?> - <?php echo substr($slot->end_time, 0, 5); ?>
                                            </label>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <!-- Notes -->
                    <div class="mb-4">
                        <label class="fw-semibold mb-2 d-block" style="color: #111827; font-size: 0.85rem;"><?php echo t('Catatan (opsional)', 'Notes (optional)'); ?></label>
                        <textarea name="notes" class="form-control" rows="3" style="border-radius: 8px; border-color: #e5e5e5; font-size: 0.85rem;" placeholder="<?php echo t('Topik yang ingin didiskusikan...', 'Topics to discuss...'); ?>"></textarea>
                    </div>

                    <button type="submit" class="btn py-3 fw-bold rounded-pill w-100" style="background: #eab308; color: #111827; font-size: 0.9rem;" <?php echo empty($balances) ? 'disabled' : ''; ?>>
                        <i class="fas fa-check-circle me-2"></i> <?php echo t('Konfirmasi Booking', 'Confirm Booking'); ?>
                    </button>
                </form>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <div class="border rounded-3 p-3 text-center" style="border-color: #e5e5e5; border-radius: 12px; position: sticky; top: 90px;">
                <img src="https://ui-avatars.com/api/?name=<?php echo urlencode($mentor->name); ?>&background=f59e0b&color=fff&size=56&font-size=0.4" alt="" style="width: 56px; height: 56px; border-radius: 50%; margin-bottom: 0.5rem;">
                <h6 class="fw-bold" style="color: #111827; font-size: 0.9rem;"><?php echo htmlspecialchars($mentor->name); ?></h6>
                <small class="fw-medium" style="color: #737373; font-size: 0.78rem;"><?php echo htmlspecialchars(t($mentor->title, $mentor->title_en)); ?></small>
                <div class="d-flex justify-content-center align-items-center gap-1 mt-1">
                    <i class="fas fa-star" style="color: #eab308; font-size: 0.7rem;"></i>
                    <span class="fw-bold" style="color: #111827; font-size: 0.8rem;"><?php echo $mentor->avg_rating; ?></span>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    input[type="radio"]:checked + label {
        background: #111827 !important;
        color: #fff !important;
        border-color: #111827 !important;
    }
    input[type="radio"]:not(:checked) + label:hover {
        border-color: #eab308 !important;
        background: #fefce8 !important;
    }
    input[name="balance_id"]:checked + div {
        border-color: #eab308 !important;
        background: #fefce8 !important;
    }
</style>
