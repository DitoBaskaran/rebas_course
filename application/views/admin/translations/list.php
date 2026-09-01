<div class="container-fluid py-4" style="max-width: 1400px;">
    <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between mb-4 gap-3">
        <div>
            <div style="color: #0D1830; font-weight: 700; font-size: 0.7rem; text-transform: uppercase; letter-spacing: 0.08em; margin-bottom: 0.15rem;">Localization</div>
            <h4 class="fw-extrabold mb-0" style="color: #0D1830; letter-spacing: -0.02em; font-size: 1.4rem;"><?php echo t('Terjemahan', 'Translations'); ?></h4>
            <p style="color: #78716c; font-size: 0.82rem; margin-bottom: 0;"><?php echo t('Atur teks UI dalam bahasa Indonesia dan Inggris.', 'Manage UI text in Indonesian and English.'); ?></p>
        </div>
    </div>

    <div class="row g-3">
        <div class="col-lg-4">
            <div class="border rounded-3 p-3" style="border-color: #e7e5e4; border-radius: 12px;">
                <h5 class="fw-bold mb-4 d-flex align-items-center gap-2" style="color: #0D1830; font-size: 0.9rem;">
                    <span class="d-inline-flex align-items-center justify-content-center rounded-2" style="width: 32px; height: 32px; background: #fff7ed;"><i class="fas fa-plus" style="color: #0D1830; font-size: 0.75rem;"></i></span>
                    <?php echo t('Tambah Terjemahan Baru', 'Add New Translation'); ?>
                </h5>
                <?php echo form_open('admin/translations', array('class' => 'd-flex flex-column gap-3')); ?>
                    <input type="text" name="key" class="form-control rounded-pill" placeholder="Key (contoh: hello_world)" required style="border-color: #e7e5e4; font-size: 0.85rem;">
                    <div class="row g-2">
                        <div class="col-md-6"><input type="text" name="value_id" class="form-control rounded-pill" placeholder="Bahasa Indonesia" style="border-color: #e7e5e4; font-size: 0.85rem;"></div>
                        <div class="col-md-6"><input type="text" name="value_en" class="form-control rounded-pill" placeholder="English" style="border-color: #e7e5e4; font-size: 0.85rem;"></div>
                    </div>
                    <button type="submit" class="btn py-2 fw-bold rounded-pill d-flex align-items-center gap-1 justify-content-center" style="background: #0D1830; color: #fff; font-size: 0.85rem;"><i class="fas fa-save" style="font-size: 0.7rem;"></i> <?php echo t('Simpan', 'Save'); ?></button>
                <?php echo form_close(); ?>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="border rounded-3" style="border-color: #e7e5e4; border-radius: 12px; overflow: hidden;">
                <div class="table-responsive p-0">
                    <table class="table mb-0" style="font-size: 0.8rem;">
                        <thead>
                            <tr>
                                <th style="font-weight: 600; color: #78716c; font-size: 0.68rem; border-color: #e7e5e4; padding: 0.7rem 1rem; background: #E6EBEF; text-transform: uppercase; letter-spacing: 0.05em;">Key</th>
                                <th style="font-weight: 600; color: #78716c; font-size: 0.68rem; border-color: #e7e5e4; padding: 0.7rem 1rem; background: #E6EBEF; text-transform: uppercase; letter-spacing: 0.05em;">Indonesia</th>
                                <th style="font-weight: 600; color: #78716c; font-size: 0.68rem; border-color: #e7e5e4; padding: 0.7rem 1rem; background: #E6EBEF; text-transform: uppercase; letter-spacing: 0.05em;">English</th>
                                <th style="font-weight: 600; color: #78716c; font-size: 0.68rem; border-color: #e7e5e4; padding: 0.7rem 1rem; background: #E6EBEF; text-transform: uppercase; letter-spacing: 0.05em; text-align: center; width: 80px;"><?php echo t('Aksi', 'Action'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($translations)): ?><tr><td colspan="4" class="text-center py-5" style="color: #a8a29e;"><?php echo t('Belum ada terjemahan.', 'No translations yet.'); ?></td></tr>
                            <?php else: ?>
                                <?php foreach ($translations as $t): ?>
                                    <tr>
                                        <td style="border-color: #f0eeeb; padding: 0.65rem 1rem; font-weight: 600; color: #0D1830; font-size: 0.78rem;"><?php echo htmlspecialchars($t->key); ?></td>
                                        <td style="border-color: #f0eeeb; padding: 0.65rem 1rem; color: #57534e; font-size: 0.78rem;"><?php echo htmlspecialchars($t->value_id ?: '-'); ?></td>
                                        <td style="border-color: #f0eeeb; padding: 0.65rem 1rem; color: #57534e; font-size: 0.78rem;"><?php echo htmlspecialchars($t->value_en ?: '-'); ?></td>
                                        <td style="border-color: #f0eeeb; padding: 0.65rem 1rem; text-align: center;"><a href="<?php echo base_url('admin/delete_translation/' . $t->id); ?>" class="btn btn-sm rounded-pill px-2 d-inline-flex align-items-center" style="border: 1px solid #fca5a5; color: #f43f5e; font-size: 0.68rem;" data-confirm="<?php echo t('Hapus?', 'Delete?'); ?>"><i class="fas fa-trash-alt" style="font-size: 0.65rem;"></i></a></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
