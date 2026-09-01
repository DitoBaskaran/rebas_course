<div class="container" style="max-width: 1000px; padding-top: 1.25rem; padding-bottom: 3rem;">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-3" style="font-size: 0.8rem;">
        <ol class="breadcrumb" style="background: none; padding: 0;">
            <li class="breadcrumb-item"><a href="<?php echo base_url('mentoring'); ?>" style="color: #78716c; text-decoration: none; font-weight: 500;"><?php echo t('Mentoring', 'Mentoring'); ?></a></li>
            <li class="breadcrumb-item"><a href="<?php echo base_url('mentoring/detail/' . encode_id($mentor->id)); ?>" style="color: #78716c; text-decoration: none; font-weight: 500;"><?php echo htmlspecialchars($mentor->name); ?></a></li>
            <li class="breadcrumb-item active" style="color: #0D1830; font-weight: 600;"><?php echo t('Booking', 'Booking'); ?></li>
        </ol>
    </nav>

    <!-- Mentor summary strip (semua ukuran layar) -->
    <div class="d-flex align-items-center gap-3 mb-4 p-3 rounded-4" style="background: linear-gradient(120deg,#0D1830 0%,#00796B 100%); color:#fff;">
        <?php if (!empty($mentor->avatar) && file_exists(FCPATH . 'uploads/mentors/' . $mentor->avatar)): ?>
        <img src="<?php echo base_url('uploads/mentors/' . $mentor->avatar); ?>" alt="" class="flex-shrink-0" style="width: 52px; height: 52px; border-radius: 50%; object-fit: cover; border: 2px solid rgba(255,255,255,0.3);">
        <?php else: ?>
        <span class="flex-shrink-0 d-flex align-items-center justify-content-center" style="width: 52px; height: 52px; border-radius: 50%; background: rgba(255,255,255,0.15); border: 2px solid rgba(255,255,255,0.3); font-weight: 800; font-size: 1.1rem;">
            <?php echo strtoupper(substr($mentor->name, 0, 1)); ?>
        </span>
        <?php endif; ?>
        <div class="min-w-0 flex-fill">
            <h6 class="fw-bold mb-0 text-truncate" style="font-size: 0.95rem;"><?php echo htmlspecialchars($mentor->name); ?></h6>
            <small class="text-truncate d-block" style="color: rgba(230,235,239,0.8); font-size: 0.76rem;"><?php echo htmlspecialchars(t($mentor->title, $mentor->title_en)); ?></small>
        </div>
        <div class="d-flex align-items-center gap-1 flex-shrink-0">
            <i class="fas fa-star" style="color: #FBBF24; font-size: 0.72rem;"></i>
            <span class="fw-bold" style="font-size: 0.82rem;"><?php echo $mentor->avg_rating; ?></span>
        </div>
    </div>

    <?php echo form_open('mentoring/confirm-booking', array('id' => 'bookForm')); ?>
        <input type="hidden" name="mentor_id" value="<?php echo $encoded_mentor_id; ?>">

        <!-- ===== STEP 1: Pilih Paket ===== -->
        <div class="border rounded-4 p-4 mb-3" style="border-color: #E6EBEF; background: #fff; box-shadow: 0 1px 3px rgba(13,24,48,0.04);">
            <h6 class="fw-bold mb-3 d-flex align-items-center gap-2" style="color: #0D1830; font-size: 0.88rem;">
                <span class="d-inline-flex align-items-center justify-content-center flex-shrink-0" style="width: 24px; height: 24px; border-radius: 50%; background: #009688; color: #fff; font-size: 0.68rem; font-weight: 700;">1</span>
                <?php echo t('Pilih Paket', 'Choose Package'); ?>
            </h6>
            <?php if (empty($balances)): ?>
                <div class="p-3 rounded-3 d-flex align-items-center gap-2" style="background: #FEF3C7; color: #92400E; font-size: 0.85rem;">
                    <i class="fas fa-exclamation-triangle flex-shrink-0"></i>
                    <span><?php echo t('Anda belum memiliki paket aktif.', 'You have no active packages.'); ?>
                    <a href="<?php echo base_url('mentoring/packages'); ?>" class="fw-bold text-decoration-underline" style="color: #92400E;"><?php echo t('Beli paket', 'Buy package'); ?></a></span>
                </div>
            <?php else: ?>
                <div class="d-flex flex-column gap-2">
                    <?php foreach ($balances as $bal): ?>
                        <label class="mn-pkg-option d-flex justify-content-between align-items-center gap-2 p-3 rounded-3">
                            <div class="d-flex align-items-center gap-2 min-w-0">
                                <input type="radio" name="balance_id" value="<?php echo $bal->id; ?>" class="mn-pkg-radio flex-shrink-0" required>
                                <div class="min-w-0">
                                    <strong class="d-block text-truncate" style="color: #0D1830; font-size: 0.85rem;"><?php echo htmlspecialchars(t($bal->name, $bal->name_en)); ?></strong>
                                    <small style="color: #78716c; font-size: 0.74rem;"><?php echo $bal->session_duration; ?> <?php echo t('mnt/sesi', 'min/session'); ?></small>
                                </div>
                            </div>
                            <span class="fw-bold px-2 py-1 rounded-pill flex-shrink-0" style="background: #E0F2F1; color: #009688; font-size: 0.7rem; white-space: nowrap;">
                                <?php echo $bal->remaining_sessions; ?>/<?php echo $bal->total_sessions; ?> <?php echo t('sesi', 'sessions'); ?>
                            </span>
                        </label>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>

        <!-- ===== STEP 2: Pilih Jadwal (tab hari) ===== -->
        <div class="border rounded-4 p-4 mb-3" style="border-color: #E6EBEF; background: #fff; box-shadow: 0 1px 3px rgba(13,24,48,0.04);">
            <h6 class="fw-bold mb-3 d-flex align-items-center gap-2" style="color: #0D1830; font-size: 0.88rem;">
                <span class="d-inline-flex align-items-center justify-content-center flex-shrink-0" style="width: 24px; height: 24px; border-radius: 50%; background: #009688; color: #fff; font-size: 0.68rem; font-weight: 700;">2</span>
                <?php echo t('Pilih Jadwal', 'Choose Schedule'); ?>
            </h6>

            <?php
                $day_names_short = array(t('Min', 'Sun'), t('Sen', 'Mon'), t('Sel', 'Tue'), t('Rab', 'Wed'), t('Kam', 'Thu'), t('Jum', 'Fri'), t('Sab', 'Sat'));
                $available_days = array();
                foreach ($week_slots as $day_idx => $slots) { if (!empty($slots)) $available_days[] = $day_idx; }
                $first_day = !empty($available_days) ? $available_days[0] : null;
            ?>

            <?php if (empty($available_days)): ?>
                <div class="text-center py-4" style="color: #a8a29e; font-size: 0.85rem;">
                    <i class="far fa-calendar-times d-block mb-2" style="font-size: 1.6rem; color: #d4d4d4;"></i>
                    <?php echo t('Mentor belum mengatur jadwal.', 'Mentor has not set a schedule.'); ?>
                </div>
            <?php else: ?>
                <!-- Day tabs (horizontal scroll) -->
                <div class="d-flex gap-2 overflow-auto pb-1 mb-3" id="dayTabs" style="scrollbar-width: none; -ms-overflow-style: none;">
                    <?php foreach ($available_days as $day_idx): ?>
                        <button type="button" class="mn-day-tab flex-shrink-0 <?php echo $day_idx === $first_day ? 'active' : ''; ?>" data-day="<?php echo $day_idx; ?>">
                            <?php echo $day_names_short[$day_idx]; ?>
                            <span class="mn-day-tab-count"><?php echo count($week_slots[$day_idx]); ?></span>
                        </button>
                    <?php endforeach; ?>
                </div>

                <!-- Slot panels (satu hari ditampilkan sekaligus) -->
                <?php foreach ($available_days as $day_idx): ?>
                    <div class="mn-day-panel" data-day-panel="<?php echo $day_idx; ?>" style="<?php echo $day_idx === $first_day ? '' : 'display:none;'; ?>">
                        <div class="row g-2">
                            <?php foreach ($week_slots[$day_idx] as $slot): ?>
                                <div class="col-6 col-sm-4 col-md-3">
                                    <input type="radio" name="availability_id" value="<?php echo $slot->id; ?>" id="slot_<?php echo $slot->id; ?>" class="d-none mn-slot-radio" required>
                                    <label for="slot_<?php echo $slot->id; ?>" class="mn-slot-option d-block text-center">
                                        <i class="far fa-clock me-1" style="font-size: 0.65rem;"></i>
                                        <?php echo substr($slot->start_time, 0, 5); ?>-<?php echo substr($slot->end_time, 0, 5); ?>
                                    </label>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <!-- ===== STEP 3: Catatan ===== -->
        <div class="border rounded-4 p-4 mb-4" style="border-color: #E6EBEF; background: #fff; box-shadow: 0 1px 3px rgba(13,24,48,0.04);">
            <h6 class="fw-bold mb-3 d-flex align-items-center gap-2" style="color: #0D1830; font-size: 0.88rem;">
                <span class="d-inline-flex align-items-center justify-content-center flex-shrink-0" style="width: 24px; height: 24px; border-radius: 50%; background: #009688; color: #fff; font-size: 0.68rem; font-weight: 700;">3</span>
                <?php echo t('Catatan (opsional)', 'Notes (optional)'); ?>
            </h6>
            <textarea name="notes" class="form-control" rows="3" style="border-radius: 10px; border-color: #E6EBEF; font-size: 0.85rem;" placeholder="<?php echo t('Topik yang ingin didiskusikan...', 'Topics to discuss...'); ?>"></textarea>
        </div>

        <button type="submit" class="btn py-3 fw-bold rounded-pill w-100 mn-book-submit" style="background: linear-gradient(135deg,#009688,#00796B); color: #fff; font-size: 0.92rem; box-shadow: 0 8px 20px rgba(0,150,136,0.3);" <?php echo empty($balances) ? 'disabled' : ''; ?>>
            <i class="fas fa-check-circle me-2"></i> <?php echo t('Konfirmasi Booking', 'Confirm Booking'); ?>
        </button>
    </form>
</div>

<style>
/* Paket */
.mn-pkg-option { border: 1.5px solid #E6EBEF; cursor: pointer; transition: all 0.15s; }
.mn-pkg-radio { accent-color: #009688; width: 18px; height: 18px; }
.mn-pkg-option:has(.mn-pkg-radio:checked) { border-color: #009688 !important; background: #E0F2F1 !important; }
.mn-pkg-option.mn-pkg-selected { border-color: #009688 !important; background: #E0F2F1 !important; }

/* Day tabs */
.mn-day-tab {
    border: 1.5px solid #E6EBEF;
    background: #fff;
    color: #57534E;
    border-radius: 100px;
    padding: 0.5rem 1rem;
    font-size: 0.78rem;
    font-weight: 700;
    display: flex;
    align-items: center;
    gap: 0.4rem;
    transition: all 0.15s;
}
.mn-day-tab-count {
    background: #E6EBEF;
    color: #57534E;
    font-size: 0.62rem;
    font-weight: 700;
    padding: 0.05rem 0.4rem;
    border-radius: 100px;
}
.mn-day-tab.active {
    background: #0D1830;
    border-color: #0D1830;
    color: #fff;
}
.mn-day-tab.active .mn-day-tab-count { background: #FBBF24; color: #0D1830; }

/* Slot */
.mn-slot-option {
    border: 1.5px solid #E6EBEF;
    color: #57534E;
    font-size: 0.78rem;
    font-weight: 600;
    padding: 0.65rem 0.5rem;
    border-radius: 10px;
    cursor: pointer;
    transition: all 0.15s;
}
.mn-slot-option:hover { border-color: #009688; background: #E0F2F1; }
.mn-slot-radio:checked + .mn-slot-option {
    background: #009688;
    border-color: #009688;
    color: #fff;
    box-shadow: 0 4px 10px rgba(0,150,136,0.3);
}

@media (max-width: 767.98px) {
    .mn-book-submit { position: sticky; bottom: 12px; z-index: 10; }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var tabs = document.querySelectorAll('.mn-day-tab');
    tabs.forEach(function(tab) {
        tab.addEventListener('click', function() {
            var day = tab.getAttribute('data-day');
            tabs.forEach(function(t) { t.classList.remove('active'); });
            tab.classList.add('active');
            document.querySelectorAll('.mn-day-panel').forEach(function(panel) {
                panel.style.display = panel.getAttribute('data-day-panel') === day ? '' : 'none';
            });
        });
    });

    // Fallback highlight paket terpilih (browser tanpa :has)
    var pkgRadios = document.querySelectorAll('.mn-pkg-radio');
    pkgRadios.forEach(function(r) {
        r.addEventListener('change', function() {
            pkgRadios.forEach(function(x) { x.closest('.mn-pkg-option').classList.remove('mn-pkg-selected'); });
            r.closest('.mn-pkg-option').classList.add('mn-pkg-selected');
        });
    });
});
</script>
