<div class="container-fluid px-0">

    <!-- ============ HEADER (hero) ============ -->
    <div class="bento-card mb-4 overflow-hidden" style="background:linear-gradient(120deg,#0D1830 0%,#164e63 100%);border:none;color:#fff;">
        <div class="d-flex align-items-center justify-content-between gap-3 position-relative" style="z-index:1;">
            <div>
                <span class="d-inline-flex align-items-center gap-1" style="background:rgba(255,255,255,0.14);border:1px solid rgba(255,255,255,0.2);color:#FBBF24;font-size:0.66rem;font-weight:800;letter-spacing:0.12em;text-transform:uppercase;padding:0.3rem 0.7rem;border-radius:100px;">
                    <i data-lucide="file-text" style="width:12px;height:12px;"></i>
                    <?php echo t('Referensi', 'References'); ?>
                </span>
                <h1 class="fw-extrabold text-white mb-1 mt-2 lh-sm" style="letter-spacing:-0.03em;font-size:1.6rem;">
                    <?php echo t('Dokumen Referensi', 'Reference Documents'); ?>
                </h1>
                <p class="mb-0" style="color:rgba(255,255,255,0.72);font-size:0.82rem;">
                    <?php echo t('Pilih dokumen untuk dibaca atau dicetak (Ctrl+P → Save as PDF).', 'Select a document to read or print (Ctrl+P → Save as PDF).'); ?>
                </p>
            </div>
        </div>
    </div>

    <?php
    $documents = array(
        array(
            'key' => 'partnership_discussion',
            'icon' => 'fa-handshake',
            'color' => '#0D1830',
            'title_id' => 'Diskusi Partnership',
            'title_en' => 'Partnership Discussion',
            'desc_id' => 'Pertanyaan-pertanyaan kunci sebelum memulai bisnis bersama calon partner.',
            'desc_en' => 'Key questions before starting a business with a potential partner.',
            'pages' => 6,
        ),
        array(
            'key' => 'business_discussion',
            'icon' => 'fa-briefcase',
            'color' => '#334155',
            'title_id' => 'Diskusi Bisnis',
            'title_en' => 'Business Discussion',
            'desc_id' => 'Pembahasan fitur, alur, metode, pembayaran, marketing, dan topik diskusi bisnis.',
            'desc_en' => 'Discussion on features, flow, methods, payment, marketing, and business topics.',
            'pages' => 5,
        ),
        array(
            'key' => 'business_plan',
            'icon' => 'fa-chart-bar',
            'color' => '#00796B',
            'title_id' => 'Rencana Bisnis',
            'title_en' => 'Business Plan',
            'desc_id' => 'Rencana bisnis lengkap: analisis pasar, strategi, proyeksi keuangan 5 tahun, analisis risiko, dan milestone implementasi.',
            'desc_en' => 'Complete business plan: market analysis, strategy, 5-year financial projections, risk analysis, and implementation milestones.',
            'pages' => 14,
        ),
        array(
            'key' => 'coming_soon',
            'icon' => 'fa-file',
            'color' => '#94a3b8',
            'title_id' => 'Dokumen Lainnya',
            'title_en' => 'Other Documents',
            'desc_id' => 'Dokumen tambahan akan tersedia segera.',
            'desc_en' => 'Additional documents coming soon.',
            'pages' => 0,
        ),
    );
    ?>

    <!-- ============ DOCUMENT CARDS ============ -->
    <div class="bento-grid bento-grid-3" style="align-items:stretch;">
        <?php foreach ($documents as $doc): ?>
            <?php $is_soon = ($doc['key'] === 'coming_soon'); ?>
            <div class="bento-card p-0 doc-card <?php echo $is_soon ? 'doc-card-soon' : ''; ?>" style="display:flex;flex-direction:column;overflow:hidden;<?php echo $is_soon ? 'opacity:0.6;' : ''; ?>">
                <!-- Color top bar -->
                <div style="height:5px;background:<?php echo $doc['color']; ?>;opacity:0.85;"></div>
                <div class="p-4 d-flex flex-column" style="flex:1;">
                    <div class="d-flex align-items-start justify-content-between gap-2">
                        <span class="d-inline-flex align-items-center justify-content-center rounded-3" style="width:52px;height:52px;background:<?php echo $doc['color']; ?>15;color:<?php echo $doc['color']; ?>;font-size:1.2rem;">
                            <i class="fas <?php echo $doc['icon']; ?>"></i>
                        </span>
                        <?php if ($is_soon): ?>
                            <span class="px-2 py-1 rounded-pill fw-semibold" style="background:#f1f5f9;color:#94a3b8;font-size:0.6rem;"><?php echo t('Segera hadir', 'Coming soon'); ?></span>
                        <?php else: ?>
                            <span class="px-2 py-1 rounded-pill fw-semibold" style="background:#E0F2F1;color:#009688;font-size:0.6rem;"><i class="fas fa-check-circle me-1" style="font-size:0.5rem;"></i><?php echo t('Tersedia', 'Available'); ?></span>
                        <?php endif; ?>
                    </div>
                    <h5 class="fw-extrabold text-dark mt-3 mb-1" style="font-size:1rem;letter-spacing:-0.01em;"><?php echo t($doc['title_id'], $doc['title_en']); ?></h5>
                    <p style="color:var(--gray-500,#78716c);font-size:0.78rem;line-height:1.6;margin-bottom:1rem;flex:1;"><?php echo t($doc['desc_id'], $doc['desc_en']); ?></p>
                    <?php if (!$is_soon): ?>
                    <a href="<?php echo base_url('admin/document/view/' . $doc['key']); ?>" class="btn fw-semibold rounded-pill d-inline-flex align-items-center justify-content-center gap-2 border-0 w-100" style="background:#0D1830;color:#fff;font-size:0.78rem;padding:0.55rem;">
                        <i class="fas fa-book-open" style="font-size:0.68rem;"></i> <?php echo t('Baca Dokumen', 'Read Document'); ?>
                        <span class="ms-auto badge rounded-pill" style="background:rgba(255,255,255,0.15);font-size:0.6rem;"><?php echo $doc['pages']; ?> <?php echo t('bagian', 'sections'); ?></span>
                    </a>
                    <?php else: ?>
                    <div class="btn fw-semibold rounded-pill border-0 w-100" style="background:var(--gray-100,#f1f5f9);color:#94a3b8;font-size:0.78rem;padding:0.55rem;cursor:not-allowed;">
                        <i class="fas fa-hourglass-half me-1" style="font-size:0.65rem;"></i> <?php echo t('Segera hadir', 'Coming soon'); ?>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
