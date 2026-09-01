<div class="app-page">
    <!-- Header -->
    <div class="app-page-head">
        <div>
            <h4 class="app-page-title"><i class="fas fa-calendar-check"></i> <?php echo t('Jadwal Mentoring', 'Mentoring Schedule'); ?></h4>
            <p class="app-page-sub"><?php echo t('Semua sesi mentoring dari siswa.', 'All student mentoring sessions.'); ?></p>
        </div>
    </div>

    <?php if (empty($sessions)): ?>
        <div class="app-card">
            <div class="app-empty">
                <i class="fas fa-calendar-check"></i>
                <h6><?php echo t('Belum ada sesi mentoring.', 'No mentoring sessions yet.'); ?></h6>
                <p><?php echo t('Sesi mentoring akan tampil di sini.', 'Mentoring sessions will appear here.'); ?></p>
            </div>
        </div>
    <?php else: ?>
        <div class="app-list" style="gap:0.7rem;">
            <?php foreach ($sessions as $s): ?>
                <div class="app-card app-card-pad">
                    <div class="d-flex align-items-center gap-3">
                        <div class="app-avatar" style="width:38px;height:38px;font-size:0.8rem;"><?php echo strtoupper(substr($s->student_name, 0, 1)); ?></div>
                        <div class="flex-fill min-w-0">
                            <div class="app-row-title"><?php echo htmlspecialchars($s->student_name); ?></div>
                            <div class="app-row-sub"><?php echo t('Mentor', 'Mentor'); ?>: <?php echo htmlspecialchars($s->mentor_name); ?><?php if ($s->course_title): ?> · <?php echo htmlspecialchars($s->course_title); ?><?php endif; ?></div>
                        </div>
                        <?php if ($s->status === 'pending'): ?><span class="app-chip app-chip-amber"><?php echo t('Menunggu', 'Pending'); ?></span>
                        <?php elseif ($s->status === 'confirmed'): ?><span class="app-chip app-chip-green"><?php echo t('Dikonfirmasi', 'Confirmed'); ?></span>
                        <?php elseif ($s->status === 'completed'): ?><span class="app-chip app-chip-gray"><?php echo t('Selesai', 'Completed'); ?></span>
                        <?php elseif ($s->status === 'cancelled'): ?><span class="app-chip app-chip-red"><?php echo t('Dibatalkan', 'Cancelled'); ?></span>
                        <?php elseif ($s->status === 'no_show'): ?><span class="app-chip app-chip-gray"><?php echo t('No Show', 'No Show'); ?></span><?php endif; ?>
                    </div>
                    <div class="d-flex align-items-center justify-content-between gap-2 flex-wrap mt-3" style="border-top:1px solid var(--gray-100,#f5f5f5);padding-top:0.7rem;">
                        <div style="font-size:0.75rem;">
                            <div class="fw-semibold" style="color:#0D1830;"><?php echo date('d M Y', strtotime($s->scheduled_at)); ?></div>
                            <div style="color:#78716c;"><?php echo date('H:i', strtotime($s->scheduled_at)); ?> WIB · <?php echo $s->duration; ?> min</div>
                        </div>
                        <?php if (!empty($s->meeting_url) && in_array($s->status, array('confirmed', 'completed'))): ?><a href="<?php echo htmlspecialchars($s->meeting_url); ?>" target="_blank" class="app-btn app-btn-sm"><i class="fas fa-video"></i> <?php echo t('Gabung', 'Join'); ?></a><?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>
