<div class="app-page">
    <!-- Header -->
    <div class="app-page-head">
        <div>
            <h4 class="app-page-title"><i class="fas fa-language"></i> <?php echo t('Terjemahan', 'Translations'); ?></h4>
            <p class="app-page-sub"><?php echo t('Atur teks UI dalam bahasa Indonesia dan Inggris.', 'Manage UI text in Indonesian and English.'); ?></p>
        </div>
    </div>

    <div class="app-grid app-grid-2" style="grid-template-columns:1fr;align-items:start;">
        <!-- Form tambah -->
        <div class="app-card app-card-pad app-form-card" style="max-width:100%;">
            <h5 class="app-page-title mb-3" style="font-size:0.95rem;"><i class="fas fa-plus"></i> <?php echo t('Tambah Terjemahan Baru', 'Add New Translation'); ?></h5>
            <?php echo form_open('admin/translations', array('class' => 'app-form-grid')); ?>
                <div class="app-field">
                    <label>Key (contoh: hello_world)</label>
                    <input type="text" name="key" class="form-control" placeholder="hello_world" required>
                </div>
                <div class="app-form-grid app-form-grid-2" style="gap:0.8rem;">
                    <div class="app-field">
                        <label>Bahasa Indonesia</label>
                        <input type="text" name="value_id" class="form-control" placeholder="Halo dunia">
                    </div>
                    <div class="app-field">
                        <label>English</label>
                        <input type="text" name="value_en" class="form-control" placeholder="Hello world">
                    </div>
                </div>
                <div class="app-form-actions">
                    <button type="submit" class="app-btn app-btn-primary"><i class="fas fa-save"></i> <?php echo t('Simpan', 'Save'); ?></button>
                </div>
            <?php echo form_close(); ?>
        </div>

        <!-- Tabel -->
        <div class="app-card">
            <div class="app-table-wrap">
                <table class="app-table">
                    <thead>
                        <tr>
                            <th>Key</th>
                            <th>Indonesia</th>
                            <th>English</th>
                            <th class="td-actions"><?php echo t('Aksi', 'Action'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($translations)): ?><tr><td colspan="4" class="text-center py-5" style="color:#a8a29e;"><?php echo t('Belum ada terjemahan.', 'No translations yet.'); ?></td></tr>
                        <?php else: ?>
                            <?php foreach ($translations as $t): ?>
                                <tr>
                                    <td style="font-weight:600;color:#0D1830;font-size:0.78rem;"><?php echo htmlspecialchars($t->key); ?></td>
                                    <td style="font-size:0.78rem;"><?php echo htmlspecialchars($t->value_id); ?></td>
                                    <td style="font-size:0.78rem;"><?php echo htmlspecialchars($t->value_en); ?></td>
                                    <td class="td-actions">
                                        <a href="<?php echo base_url('admin/delete_translation/' . $t->id); ?>" class="app-action app-action-red" data-confirm="<?php echo t('Hapus terjemahan?', 'Delete translation?'); ?>" title="<?php echo t('Hapus', 'Delete'); ?>"><i class="fas fa-trash-alt"></i></a>
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
