<div class="container-fluid py-4" style="max-width: 1400px;">
    <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between mb-4 gap-3">
        <div>
            <div style="color: #0D1830; font-weight: 700; font-size: 0.7rem; text-transform: uppercase; letter-spacing: 0.08em; margin-bottom: 0.15rem;">Mentoring</div>
            <h4 class="fw-extrabold mb-0" style="color: #0D1830; letter-spacing: -0.02em; font-size: 1.4rem;"><?php echo t('Jadwal Mentoring', 'Mentoring Schedule'); ?></h4>
            <p style="color: #78716c; font-size: 0.82rem; margin-bottom: 0;"><?php echo t('Semua sesi mentoring dari siswa.', 'All student mentoring sessions.'); ?></p>
        </div>
    </div>

    <div class="border rounded-3" style="border-color: #e7e5e4; border-radius: 12px;">
        <?php if (empty($sessions)): ?>
            <div class="p-5 text-center"><div style="font-size: 2rem; color: #d6d3d1; margin-bottom: 0.5rem;"><i class="fas fa-calendar-check"></i></div><h6 class="fw-bold" style="color: #0D1830;"><?php echo t('Belum ada sesi mentoring.', 'No mentoring sessions yet.'); ?></h6></div>
        <?php else: ?>
            <div class="d-flex flex-column gap-2 p-3">
                <?php foreach ($sessions as $s): ?>
                    <div class="d-flex flex-column flex-md-row align-items-md-center gap-3 p-3 rounded-3" style="background: #E6EBEF; border: 1px solid #f0eeeb;">
                        <div class="d-flex align-items-center gap-3 flex-fill min-w-0">
                            <div class="d-flex align-items-center justify-content-center rounded-circle fw-bold flex-shrink-0" style="width: 38px; height: 38px; background: #fff7ed; color: #0D1830; font-size: 0.8rem;"><?php echo strtoupper(substr($s->student_name, 0, 1)); ?></div>
                            <div class="min-w-0">
                                <div class="fw-semibold" style="color: #0D1830; font-size: 0.8rem;"><?php echo htmlspecialchars($s->student_name); ?></div>
                                <div style="color: #78716c; font-size: 0.72rem;"><?php echo t('Mentor', 'Mentor'); ?>: <?php echo htmlspecialchars($s->mentor_name); ?><?php if ($s->course_title): ?> · <?php echo htmlspecialchars($s->course_title); ?><?php endif; ?></div>
                            </div>
                        </div>
                        <div class="d-flex align-items-center gap-3 flex-shrink-0">
                            <div class="text-end" style="font-size: 0.75rem;">
                                <div class="fw-semibold" style="color: #0D1830;"><?php echo date('d M Y', strtotime($s->scheduled_at)); ?></div>
                                <div style="color: #78716c;"><?php echo date('H:i', strtotime($s->scheduled_at)); ?> WIB · <?php echo $s->duration; ?> min</div>
                            </div>
                            <?php if ($s->status === 'scheduled'): ?><span class="px-2 py-1 rounded-pill fw-semibold" style="background: #E0F2F1; color: #009688; font-size: 0.6rem;"><?php echo t('Terjadwal', 'Scheduled'); ?></span>
                            <?php elseif ($s->status === 'completed'): ?><span class="px-2 py-1 rounded-pill fw-semibold" style="background: #E0F2F1; color: #009688; font-size: 0.6rem;"><?php echo t('Selesai', 'Completed'); ?></span>
                            <?php elseif ($s->status === 'cancelled'): ?><span class="px-2 py-1 rounded-pill fw-semibold" style="background: #fef2f2; color: #f43f5e; font-size: 0.6rem;"><?php echo t('Dibatalkan', 'Cancelled'); ?></span><?php endif; ?>
                        </div>
                        <?php if ($s->meeting_link && $s->status === 'scheduled'): ?><a href="<?php echo $s->meeting_link; ?>" target="_blank" class="btn btn-sm rounded-pill px-3 fw-semibold d-inline-flex align-items-center gap-1" style="border: 1px solid #e7e5e4; color: #57534e; font-size: 0.68rem;"><i class="fas fa-video" style="font-size: 0.65rem;"></i> <?php echo t('Gabung', 'Join'); ?></a><?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>
