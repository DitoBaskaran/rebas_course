<div class="container-fluid px-0">
    <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between mb-5 gap-3">
        <div>
            <span class="text-primary fw-semibold small text-uppercase tracking-wide d-block mb-1">Dokumen</span>
            <h1 class="display-6 fw-extrabold text-dark mb-1 lh-sm" style="letter-spacing: -0.03em;"><?php echo t('Dokumen Referensi', 'Reference Documents'); ?></h1>
            <p class="text-secondary mb-0"><?php echo t('Pilih dokumen untuk dibaca atau dicetak (Ctrl+P → Save as PDF).', 'Select a document to read or print (Ctrl+P → Save as PDF).'); ?></p>
        </div>
    </div>

    <?php
    $documents = array(
        array(
            'key' => 'partnership_discussion',
            'icon' => 'handshake',
            'color' => '#6366f1',
            'title_id' => 'Diskusi Partnership',
            'title_en' => 'Partnership Discussion',
            'desc_id' => 'Pertanyaan-pertanyaan kunci sebelum memulai bisnis bersama calon partner.',
            'desc_en' => 'Key questions before starting a business with a potential partner.',
            'pages' => 6,
        ),
        array(
            'key' => 'business_discussion',
            'icon' => 'briefcase',
            'color' => '#334155',
            'title_id' => 'Diskusi Bisnis',
            'title_en' => 'Business Discussion',
            'desc_id' => 'Pembahasan fitur, alur, metode, pembayaran, marketing, dan topik diskusi bisnis.',
            'desc_en' => 'Discussion on features, flow, methods, payment, marketing, and business topics.',
            'pages' => 5,
        ),
        array(
            'key' => 'coming_soon',
            'icon' => 'file-text',
            'color' => '#94a3b8',
            'title_id' => 'Dokumen Lainnya',
            'title_en' => 'Other Documents',
            'desc_id' => 'Dokumen tambahan akan tersedia segera.',
            'desc_en' => 'Additional documents coming soon.',
            'pages' => 0,
        ),
    );
    ?>

    <div class="row g-4">
        <?php foreach ($documents as $doc): ?>
        <div class="col-md-6 col-lg-4">
            <a href="<?php echo $doc['key'] === 'coming_soon' ? '#' : base_url('admin/document/view/' . $doc['key']); ?>" class="card border-0 shadow-sm text-decoration-none h-100" style="border-radius: 1rem; transition: all 0.2s; <?php echo $doc['key'] === 'coming_soon' ? 'opacity:0.5;pointer-events:none;' : ''; ?>">
                <div class="card-body p-4 p-xl-5 d-flex flex-column">
                    <div class="d-flex align-items-center justify-content-center rounded-2 mb-4 flex-shrink-0" style="width: 56px; height: 56px; background: <?php echo $doc['color']; ?>15; color: <?php echo $doc['color']; ?>;">
                        <i data-lucide="<?php echo $doc['icon']; ?>" style="width: 24px; height: 24px;"></i>
                    </div>
                    <h5 class="fw-bold text-dark mb-2"><?php echo t($doc['title_id'], $doc['title_en']); ?></h5>
                    <p class="text-secondary small mb-4 flex-fill"><?php echo t($doc['desc_id'], $doc['desc_en']); ?></p>
                    <div class="d-flex align-items-center justify-content-between pt-3 border-top" style="border-color: #e2e8f0;">
                        <?php if ($doc['pages'] > 0): ?>
                        <span class="small text-secondary"><?php echo $doc['pages']; ?> <?php echo t('bagian', 'sections'); ?></span>
                        <span class="small fw-semibold text-primary"><?php echo t('Baca', 'Read'); ?> <i class="fas fa-arrow-right ms-1"></i></span>
                        <?php else: ?>
                        <span class="small text-secondary"><?php echo t('Segera hadir', 'Coming soon'); ?></span>
                        <?php endif; ?>
                    </div>
                </div>
            </a>
        </div>
        <?php endforeach; ?>
    </div>
</div>
