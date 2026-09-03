<div class="container-fluid px-0">

    <?php if (isset($error_db)): ?>
        <div class="bento-card mb-4" style="border:1px solid #fecaca;background:#fff5f5;">
            <div class="d-flex align-items-center gap-3 p-3">
                <i data-lucide="database" style="width:20px;height:20px;color:#dc2626;flex-shrink:0;"></i>
                <span class="small" style="color:#991b1b;"><?php echo htmlspecialchars($error_db); ?></span>
            </div>
        </div>
    <?php endif; ?>

    <!-- ============ HEADER (hero) ============ -->
    <div class="bento-card mb-4 overflow-hidden" style="background:linear-gradient(120deg,#0D1830 0%,#164e63 100%);border:none;color:#fff;">
        <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3 position-relative" style="z-index:1;">
            <div>
                <span class="d-inline-flex align-items-center gap-1" style="background:rgba(255,255,255,0.14);border:1px solid rgba(255,255,255,0.2);color:#FBBF24;font-size:0.66rem;font-weight:800;letter-spacing:0.12em;text-transform:uppercase;padding:0.3rem 0.7rem;border-radius:100px;">
                    <i data-lucide="bot" style="width:12px;height:12px;"></i>
                    <?php echo t('Kecerdasan Buatan', 'Artificial Intelligence'); ?>
                </span>
                <h1 class="fw-extrabold text-white mb-1 mt-2 lh-sm" style="letter-spacing:-0.03em;font-size:1.6rem;">
                    <?php echo t('Riwayat Penggunaan AI', 'AI Usage History'); ?>
                </h1>
                <p class="mb-0" style="color:rgba(255,255,255,0.72);font-size:0.82rem;">
                    <?php echo t('Pantau percakapan user dengan asisten AI rekomendasi mentor & kursus beserta konsumsi token.', 'Monitor user conversations with the AI mentor & course recommender, including token usage.'); ?>
                </p>
            </div>
            <a href="<?php echo base_url('admin/dashboard'); ?>" class="btn fw-semibold rounded-pill d-inline-flex align-items-center gap-2 border-0 flex-shrink-0" style="background:rgba(255,255,255,0.12);color:#fff;font-size:0.78rem;padding:0.55rem 1.1rem;border:1px solid rgba(255,255,255,0.2);">
                <i data-lucide="arrow-left" style="width:14px;height:14px;"></i> <?php echo t('Dashboard', 'Dashboard'); ?>
            </a>
        </div>
    </div>

    <?php if (!isset($error_db) && !empty($logs)): ?>
        <?php
            $avatar_colors = array('#0ea5e9', '#8b5cf6', '#f59e0b', '#10b981', '#f43f5e', '#0D1830', '#009688', '#d946ef');
            $idx_avatar = 0;
        ?>
    <?php endif; ?>

    <!-- ============ KPI ============ -->
    <div class="bento-grid bento-grid-4 mb-4">
        <div class="bento-card blob-primary">
            <div class="d-flex align-items-center gap-3">
                <div class="bento-icon bg-primary-subtle text-primary"><i data-lucide="bot" style="width:22px;height:22px;"></i></div>
                <div>
                    <div class="bento-label"><?php echo t('Total Percakapan', 'Total Conversations'); ?></div>
                    <div class="bento-value"><?php echo number_format($stats['total_calls']); ?></div>
                </div>
            </div>
        </div>
        <div class="bento-card blob-success">
            <div class="d-flex align-items-center gap-3">
                <div class="bento-icon bg-success-subtle text-success"><i data-lucide="coins" style="width:22px;height:22px;"></i></div>
                <div>
                    <div class="bento-label"><?php echo t('Total Token', 'Total Tokens'); ?></div>
                    <div class="bento-value"><?php echo number_format($stats['total_tokens']); ?></div>
                </div>
            </div>
        </div>
        <div class="bento-card blob-warning">
            <div class="d-flex align-items-center gap-3">
                <div class="bento-icon bg-warning-subtle text-warning"><i data-lucide="users" style="width:22px;height:22px;"></i></div>
                <div>
                    <div class="bento-label"><?php echo t('User Aktif', 'Active Users'); ?></div>
                    <div class="bento-value"><?php echo number_format($stats['total_users']); ?></div>
                </div>
            </div>
        </div>
        <div class="bento-card" style="background:linear-gradient(135deg,#312e81,#4338ca);border:none;color:#fff;">
            <div class="d-flex align-items-center gap-3">
                <div class="bento-icon" style="background:rgba(255,255,255,0.16);color:#fff;"><i data-lucide="sparkles" style="width:22px;height:22px;"></i></div>
                <div>
                    <div class="bento-label" style="color:rgba(255,255,255,0.6);"><?php echo t('Pemakaian', 'Usage'); ?></div>
                    <div class="d-flex align-items-center gap-2 flex-wrap" style="font-size:0.9rem;">
                        <span class="fw-extrabold text-white"><?php echo $stats['mentor_calls']; ?> <span style="font-size:0.65rem;font-weight:600;color:rgba(255,255,255,0.65);">Mentor</span></span>
                        <span style="color:rgba(255,255,255,0.3);">·</span>
                        <span class="fw-extrabold text-white"><?php echo $stats['course_calls']; ?> <span style="font-size:0.65rem;font-weight:600;color:rgba(255,255,255,0.65);">Kursus</span></span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ============ FILTER TOOLBAR ============ -->
    <div class="bento-card mb-4" style="padding:0.8rem 1rem;">
        <form method="get" action="<?php echo base_url('admin/ai_history'); ?>" class="d-flex flex-column flex-md-row gap-2 align-items-md-center">
            <div class="flex-fill position-relative">
                <i data-lucide="search" style="width:15px;height:15px;position:absolute;left:0.9rem;top:50%;transform:translateY(-50%);color:var(--gray-400,#94a3b8);"></i>
                <input type="text" name="search" value="<?php echo htmlspecialchars($search); ?>" class="form-control" style="padding-left:2.3rem;border-radius:100px;font-size:0.82rem;" placeholder="<?php echo t('Cari nama user, email, isi pesan...', 'Search user, email, message...'); ?>">
            </div>
            <select name="module" class="form-select" style="max-width:200px;border-radius:100px;font-size:0.82rem;" onchange="this.form.submit()">
                <option value=""><?php echo t('Semua Fitur AI', 'All AI Features'); ?></option>
                <option value="mentor" <?php echo $module_filter === 'mentor' ? 'selected' : ''; ?>><?php echo t('Rekomendasi Mentor', 'Mentor Recommendation'); ?></option>
                <option value="course" <?php echo $module_filter === 'course' ? 'selected' : ''; ?>><?php echo t('Rekomendasi Kursus', 'Course Recommendation'); ?></option>
            </select>
            <button type="submit" class="btn btn-sm rounded-pill px-4 fw-semibold flex-shrink-0 d-inline-flex align-items-center gap-1" style="background:#0D1830;color:#fff;font-size:0.75rem;">
                <i data-lucide="filter" style="width:13px;height:13px;"></i> <?php echo t('Filter', 'Filter'); ?>
            </button>
            <?php if ($module_filter !== '' || $search !== ''): ?>
                <a href="<?php echo base_url('admin/ai_history'); ?>" class="btn btn-sm rounded-pill px-3 flex-shrink-0" style="border:1px solid #cbd5e1;color:#475569;font-size:0.75rem;">
                    <i data-lucide="x" style="width:13px;height:13px;"></i>
                </a>
            <?php endif; ?>
        </form>
    </div>

    <!-- ============ STATUS INFO ============ -->
    <?php if (isset($error_db)): ?>
        <!-- pesan error sudah tampil di atas -->
    <?php elseif (empty($logs)): ?>
        <div class="bento-card p-5 text-center">
            <div class="mx-auto d-inline-flex align-items-center justify-content-center rounded-circle mb-3" style="width:72px;height:72px;background:#E0F2F1;color:#009688;">
                <i data-lucide="bot" style="width:30px;height:30px;"></i>
            </div>
            <h5 class="fw-extrabold text-dark mb-1">
                <?php echo ($module_filter !== '' || $search !== '') ? t('Tidak ada hasil yang cocok.', 'No matching results.') : t('Belum ada penggunaan AI.', 'No AI usage yet.'); ?>
            </h5>
            <p class="text-secondary small mb-0">
                <?php echo ($module_filter !== '' || $search !== '') ? t('Coba ubah kata kunci atau filter fitur AI.', 'Try changing the keyword or AI feature filter.') : t('Riwayat akan muncul setelah user mencoba rekomendasi mentor atau kursus.', 'History will appear after users try the mentor or course recommender.'); ?>
            </p>
        </div>
    <?php else: ?>
        <!-- ============ LOG LIST ============ -->
        <div class="bento-card p-0">
            <?php foreach ($logs as $log): ?>
                <?php
                    // Warna avatar per user (deterministik dari id)
                    $color = $avatar_colors[$log->user_id % count($avatar_colors)];
                    if ($log->user_id > 0 && $log->role === 'admin') $color = '#f43f5e';
                    elseif ($log->user_id > 0 && $log->is_teacher) $color = '#0D1830';
                    elseif ($log->user_id > 0 && $log->is_mentor) $color = '#a855f7';

                    $is_course = ($log->module === 'course');
                    $badge_bg   = $is_course ? '#eff6ff' : '#faf5ff';
                    $badge_tx   = $is_course ? '#2563eb' : '#a855f7';
                    $badge_icon = $is_course ? 'book-open' : 'calendar-check';
                    $badge_label = $is_course ? t('Kursus', 'Course') : t('Mentor', 'Mentor');

                    $is_error = ($log->status === 'error');
                    $st_bg  = $is_error ? '#fef2f2' : '#E0F2F1';
                    $st_tx  = $is_error ? '#dc2626' : '#009688';
                    $st_label = $is_error ? t('Gagal', 'Failed') : t('Sukses', 'Success');

                    $display_name = ($log->user_id > 0 && $log->user_name) ? $log->user_name : t('Anonim', 'Guest');
                    $initial = strtoupper(mb_substr($display_name, 0, 1));

                    $ai_display = trim($log->ai_response);
                    $is_raw_json = (strpos($ai_display, '{') === 0 && function_exists('json_decode') && json_decode($ai_display) !== null);
                ?>
                <div class="tx-row ai-log-row" style="display:flex;align-items:flex-start;gap:0.9rem;padding:1.1rem 1.25rem;border-bottom:1px solid var(--card-border,#eef0f3);">
                    <!-- Avatar user -->
                    <span class="d-inline-flex align-items-center justify-content-center rounded-circle fw-bold text-white flex-shrink-0" style="width:38px;height:38px;background:<?php echo $color; ?>;font-size:0.85rem;">
                        <?php echo $initial; ?>
                    </span>

                    <!-- Konten utama -->
                    <div class="flex-fill" style="min-width:0;">
                        <div class="d-flex align-items-center gap-2 flex-wrap">
                            <span class="fw-bold text-dark" style="font-size:0.85rem;"><?php echo htmlspecialchars($display_name); ?></span>
                            <?php if ($log->user_id > 0 && $log->user_email): ?>
                                <span class="text-muted" style="font-size:0.68rem;"><?php echo htmlspecialchars($log->user_email); ?></span>
                            <?php endif; ?>
                            <span class="px-2 py-0 rounded-pill fw-semibold d-inline-flex align-items-center gap-1" style="background:<?php echo $badge_bg; ?>;color:<?php echo $badge_tx; ?>;font-size:0.6rem;">
                                <i data-lucide="<?php echo $badge_icon; ?>" style="width:10px;height:10px;"></i> <?php echo $badge_label; ?>
                            </span>
                            <span class="px-2 py-0 rounded-pill fw-semibold" style="background:<?php echo $st_bg; ?>;color:<?php echo $st_tx; ?>;font-size:0.6rem;">
                                <?php echo $st_label; ?>
                            </span>
                            <?php if ($log->model_name): ?>
                                <span class="px-2 py-0 rounded-pill fw-semibold" style="background:#E6EBEF;color:#57534e;font-size:0.6rem;">
                                    <i data-lucide="cpu" style="width:10px;height:10px;"></i> <?php echo htmlspecialchars($log->model_name); ?>
                                </span>
                            <?php endif; ?>
                            <span class="text-muted ms-auto" style="font-size:0.66rem;"><?php echo date('d M Y, H:i', strtotime($log->created_at)); ?></span>
                        </div>

                        <!-- Pesan user -->
                        <div class="mt-2 p-2 px-3 rounded-3" style="background:var(--card-bg,#f8fafc);border:1px solid var(--card-border,#eef0f3);">
                            <div class="d-flex align-items-center gap-1 mb-1">
                                <i data-lucide="user" style="width:11px;height:11px;color:var(--gray-400,#94a3b8);"></i>
                                <span class="fw-semibold" style="font-size:0.62rem;letter-spacing:0.08em;text-transform:uppercase;color:var(--gray-400,#94a3b8);"><?php echo t('Pesan User', 'User Message'); ?></span>
                            </div>
                            <div class="text-secondary" style="font-size:0.8rem;line-height:1.55;white-space:pre-wrap;word-break:break-word;"><?php echo htmlspecialchars($log->user_message); ?></div>
                        </div>

                        <!-- Respons AI -->
                        <div class="mt-2 p-2 px-3 rounded-3" style="background:<?php echo $is_error ? '#fff7f7' : '#f0fdfa'; ?>;border:1px solid <?php echo $is_error ? '#fecaca' : '#ccfbf1'; ?>;">
                            <div class="d-flex align-items-center gap-1 mb-1">
                                <i data-lucide="bot" style="width:11px;height:11px;color:<?php echo $is_error ? '#dc2626' : '#0d9488'; ?>;"></i>
                                <span class="fw-semibold" style="font-size:0.62rem;letter-spacing:0.08em;text-transform:uppercase;color:<?php echo $is_error ? '#dc2626' : '#0d9488'; ?>;">
                                    <?php echo t('Respons AI', 'AI Response'); ?>
                                </span>
                            </div>
                            <div class="text-secondary" style="font-size:0.8rem;line-height:1.55;white-space:pre-wrap;word-break:break-word;">
                                <?php if ($is_raw_json && function_exists('json_encode')): ?>
                                    <?php echo htmlspecialchars(json_encode(json_decode($ai_display), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)); ?>
                                <?php else: ?>
                                    <?php echo htmlspecialchars($ai_display); ?>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Token usage -->
                        <div class="d-flex align-items-center gap-2 mt-2 flex-wrap">
                            <span class="px-2 py-1 rounded-pill fw-semibold d-inline-flex align-items-center gap-1" style="background:var(--card-bg,#f8fafc);border:1px solid var(--card-border,#eef0f3);color:#475569;font-size:0.62rem;">
                                <i data-lucide="arrow-down-to-line" style="width:11px;height:11px;color:#0ea5e9;"></i>
                                <?php echo t('Input', 'Input'); ?>: <?php echo number_format($log->prompt_tokens); ?>
                            </span>
                            <span class="px-2 py-1 rounded-pill fw-semibold d-inline-flex align-items-center gap-1" style="background:var(--card-bg,#f8fafc);border:1px solid var(--card-border,#eef0f3);color:#475569;font-size:0.62rem;">
                                <i data-lucide="arrow-up-from-line" style="width:11px;height:11px;color:#8b5cf6;"></i>
                                <?php echo t('Output', 'Output'); ?>: <?php echo number_format($log->completion_tokens); ?>
                            </span>
                            <span class="px-2 py-1 rounded-pill fw-bold d-inline-flex align-items-center gap-1" style="background:#fff7ed;color:#c2410c;font-size:0.62rem;">
                                <i data-lucide="coins" style="width:11px;height:11px;"></i>
                                <?php echo t('Total', 'Total'); ?>: <?php echo number_format($log->total_tokens); ?> <?php echo t('token', 'tokens'); ?>
                            </span>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <?php if (count($logs) >= 100): ?>
            <div class="text-center small text-muted mt-3">
                <i data-lucide="info" style="width:12px;height:12px;"></i>
                <?php echo t('Menampilkan 100 riwayat terbaru. Gunakan filter untuk mempersempit.', 'Showing the 100 most recent entries. Use filters to narrow down.'); ?>
            </div>
        <?php endif; ?>
    <?php endif; ?>
</div>
