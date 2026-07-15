<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-extrabold mb-1"><?php echo t('Atur Jadwal', 'Manage Schedule'); ?></h4>
            <p class="text-secondary small mb-0"><?php echo t('Tentukan kapan Anda tersedia untuk mentoring', 'Set when you are available for mentoring'); ?></p>
        </div>
    </div>

    <div class="row g-4">
        <!-- Form tambah slot -->
        <div class="col-lg-5">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4">
                    <h6 class="fw-bold mb-4"><?php echo t('Tambah Slot Baru', 'Add New Slot'); ?></h6>
                    <form method="post" action="<?php echo base_url('mentor/add-slot'); ?>">
                        <div class="mb-3">
                            <label class="form-label small fw-bold"><?php echo t('Hari', 'Day'); ?></label>
                            <select name="day_of_week" class="form-select">
                                <?php $day_names = array(t('Minggu', 'Sun'), t('Senin', 'Mon'), t('Selasa', 'Tue'), t('Rabu', 'Wed'), t('Kamis', 'Thu'), t('Jumat', 'Fri'), t('Sabtu', 'Sat')); ?>
                                <?php foreach ($day_names as $i => $d): ?>
                                    <option value="<?php echo $i; ?>"><?php echo $d; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="row g-3 mb-3">
                            <div class="col-6">
                                <label class="form-label small fw-bold"><?php echo t('Jam Mulai', 'Start Time'); ?></label>
                                <input type="time" name="start_time" class="form-control" required>
                            </div>
                            <div class="col-6">
                                <label class="form-label small fw-bold"><?php echo t('Jam Selesai', 'End Time'); ?></label>
                                <input type="time" name="end_time" class="form-control" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-bold"><?php echo t('Tanggal Spesifik (opsional)', 'Specific Date (optional)'); ?></label>
                            <input type="date" name="date_override" class="form-control">
                            <small class="text-secondary"><?php echo t('Kosongkan untuk jadwal mingguan', 'Leave empty for weekly recurring'); ?></small>
                        </div>
                        <button type="submit" class="btn btn-dark rounded-pill px-5 fw-semibold w-100">
                            <i data-lucide="plus" style="width:16px;height:16px;" class="me-1"></i> <?php echo t('Tambah Slot', 'Add Slot'); ?>
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Daftar slot -->
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4">
                    <h6 class="fw-bold mb-4"><?php echo t('Jadwal Saat Ini', 'Current Schedule'); ?></h6>
                    <?php if (empty($slots)): ?>
                        <p class="text-secondary small"><?php echo t('Belum ada jadwal. Tambahkan slot di samping.', 'No schedule yet. Add slots on the side.'); ?></p>
                    <?php else: ?>
                        <?php $current_day = null; ?>
                        <?php foreach ($slots as $slot): ?>
                            <?php if ($slot->day_of_week !== null && $slot->day_of_week != $current_day): ?>
                                <?php $current_day = $slot->day_of_week; ?>
                                <div class="fw-bold small text-primary mt-3 mb-2"><?php echo $day_names[$current_day]; ?></div>
                            <?php endif; ?>
                            <?php if ($slot->date_override): ?>
                                <div class="fw-bold small text-primary mt-3 mb-2"><?php echo date('d M Y', strtotime($slot->date_override)); ?></div>
                            <?php endif; ?>
                            <div class="d-flex align-items-center justify-content-between bg-light rounded-3 p-3 mb-2">
                                <div class="d-flex align-items-center gap-3">
                                    <i data-lucide="clock" style="width:16px;height:16px;" class="text-secondary"></i>
                                    <span class="fw-semibold small"><?php echo substr($slot->start_time, 0, 5); ?> - <?php echo substr($slot->end_time, 0, 5); ?></span>
                                    <?php if ($slot->is_booked): ?>
                                        <span class="badge bg-danger rounded-pill fw-medium" style="font-size:10px;"><?php echo t('Terbooking', 'Booked'); ?></span>
                                    <?php endif; ?>
                                </div>
                                <?php if (!$slot->is_booked): ?>
                                    <a href="<?php echo base_url('mentor/delete-slot/' . $slot->id); ?>" class="btn btn-sm btn-outline-danger rounded-pill" onclick="return confirm('<?php echo t('Hapus slot?', 'Delete slot?'); ?>')">
                                        <i data-lucide="trash-2" style="width:14px;height:14px;"></i>
                                    </a>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
