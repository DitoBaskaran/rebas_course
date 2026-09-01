<div class="app-page">
    <!-- Header -->
    <div class="app-page-head">
        <div>
            <h4 class="app-page-title"><i class="fas fa-file-text"></i> <?php echo t('Dokumen Referensi', 'Reference Documents'); ?></h4>
            <p class="app-page-sub"><?php echo t('Pilih dokumen untuk dibaca atau dicetak (Ctrl+P → Save as PDF).', 'Select a document to read or print (Ctrl+P → Save as PDF).'); ?></p>
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

    <div class="app-grid app-grid-3">
        <?php foreach ($documents as $doc): ?>
        <a href="<?php echo $doc['key'] === 'coming_soon' ? '#' : base_url('admin/document/view/' . $doc['key']); ?>" class="app-card app-card-pad d-flex flex-column text-decoration-none" style="<?php echo $doc['key'] === 'coming_soon' ? 'opacity:0.55;pointer-events:none;' : ''; ?>">
            <div class="d-flex align-items-center justify-content-center rounded-2 mb-3" style="width:52px;height:52px;background:<?php echo $doc['color']; ?>15;color:<?php echo $doc['color']; ?>;font-size:1.2rem;">
                <i class="fas <?php echo $doc['icon']; ?>"></i>
            </div>
            <h5 class="app-row-title mb-1" style="font-size:0.95rem;white-space:normal;"><?php echo t($doc['title_id'], $doc['title_en']); ?></h5>
            <p style="color:var(--gray-500,#78716c);font-size:0.76rem;margin-bottom:0.8rem;flex:1;"><?php echo t($doc['desc_id'], $doc['desc_en']); ?></p>
            <div class="d-flex align-items-center justify-content-between pt-3" style="border-top:1px solid var(--gray-100,#f5f5f5);">
                <?php if ($doc['pages'] > 0): ?>
                <span style="color:var(--gray-500,#78716c);font-size:0.72rem;"><?php echo $doc['pages']; ?> <?php echo t('bagian', 'sections'); ?></span>
                <span style="color:var(--primary,#009688);font-weight:700;font-size:0.75rem;"><?php echo t('Baca', 'Read'); ?> <i class="fas fa-arrow-right ms-1"></i></span>
                <?php else: ?>
                <span style="color:var(--gray-500,#78716c);font-size:0.72rem;"><?php echo t('Segera hadir', 'Coming soon'); ?></span>
                <?php endif; ?>
            </div>
        </a>
        <?php endforeach; ?>
    </div>
</div>
