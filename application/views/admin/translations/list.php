<div class="container-fluid px-0">
    <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between mb-5 gap-3">
        <div>
            <span class="text-primary fw-semibold small text-uppercase tracking-wide d-block mb-1">Localization</span>
            <h1 class="display-6 fw-extrabold text-dark mb-1 lh-sm" style="letter-spacing: -0.03em;"><?php echo t('Terjemahan', 'Translations'); ?></h1>
            <p class="text-secondary mb-0"><?php echo t('Atur teks UI dalam bahasa Indonesia dan Inggris.', 'Manage UI text in Indonesian and English.'); ?></p>
        </div>
    </div>

    <div class="bento-grid bento-grid-1-2">
        <!-- Add New -->
        <div class="bento-card">
            <h5 class="fw-bold text-dark mb-4 d-flex align-items-center gap-2">
                <span class="d-inline-flex align-items-center justify-content-center bg-primary-subtle text-primary rounded-2" style="width: 32px; height: 32px;">
                    <i data-lucide="plus" style="width:18px;height:18px;"></i>
                </span>
                <?php echo t('Tambah Terjemahan Baru', 'Add New Translation'); ?>
            </h5>
            <?php echo form_open('admin/translations', array('class' => 'd-flex flex-column gap-3')); ?>
                <input type="text" name="key" class="form-control rounded-pill" placeholder="Key (contoh: hello_world)" required>
                <div class="row g-2">
                    <div class="col-md-6">
                        <input type="text" name="value_id" class="form-control rounded-pill" placeholder="Bahasa Indonesia">
                    </div>
                    <div class="col-md-6">
                        <input type="text" name="value_en" class="form-control rounded-pill" placeholder="English">
                    </div>
                </div>
                <button type="submit" class="btn btn-dark rounded-pill px-4 py-2 fw-semibold d-flex align-items-center gap-1 justify-content-center">
                    <i data-lucide="save" style="width:16px;height:16px;"></i> <?php echo t('Simpan', 'Save'); ?>
                </button>
            <?php echo form_close(); ?>
        </div>

        <!-- Existing Translations -->
        <div class="bento-card">
            <div class="table-responsive">
                <table class="table-modern">
                    <thead>
                        <tr><th>Key</th><th>Indonesia</th><th>English</th><th class="text-center col-w-80"><?php echo t('Aksi', 'Action'); ?></th></tr>
                    </thead>
                    <tbody>
                        <?php if (empty($translations)): ?>
                            <tr><td colspan="4" class="text-center text-muted py-5"><?php echo t('Belum ada terjemahan.', 'No translations yet.'); ?></td></tr>
                        <?php else: ?>
                            <?php foreach ($translations as $t): ?>
                                <tr>
                                    <td class="fw-semibold text-dark small"><?php echo htmlspecialchars($t->key); ?></td>
                                    <td class="small"><?php echo htmlspecialchars($t->value_id ?: '-'); ?></td>
                                    <td class="small"><?php echo htmlspecialchars($t->value_en ?: '-'); ?></td>
                                    <td class="text-center">
                                        <a href="<?php echo base_url('admin/delete_translation/' . $t->id); ?>" class="btn btn-outline-danger btn-sm px-2 rounded-pill" data-confirm="<?php echo t('Hapus?', 'Delete?'); ?>">
                                            <i data-lucide="trash-2" style="width:14px;height:14px;"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>