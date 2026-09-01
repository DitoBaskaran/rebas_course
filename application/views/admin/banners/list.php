<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="page-header d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
    <div>
        <h1 class="h3 fw-bold mb-1"><?php echo t('Banner Dashboard', 'Dashboard Banners'); ?></h1>
        <p class="text-muted small mb-0"><?php echo t('Kelola carousel banner di dashboard student & mentor.', 'Manage banner carousel on student & mentor dashboard.'); ?></p>
    </div>
    <a href="<?php echo base_url('admin/banners_create'); ?>" class="btn btn-primary rounded-pill px-4">
        <i class="fas fa-plus me-1"></i> <?php echo t('Tambah Banner', 'Add Banner'); ?>
    </a>
</div>

<div class="card-modern">
    <div class="table-responsive">
        <table class="table table-modern table-hover align-middle mb-0" style="font-size: 0.85rem;">
            <thead>
                <tr>
                    <th style="width: 90px;"><?php echo t('Gambar', 'Image'); ?></th>
                    <th><?php echo t('Judul', 'Title'); ?></th>
                    <th><?php echo t('Tautan', 'Link'); ?></th>
                    <th><?php echo t('Target', 'Target'); ?></th>
                    <th><?php echo t('Status', 'Status'); ?></th>
                    <th class="text-end"><?php echo t('Aksi', 'Action'); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($banners)): ?>
                    <tr>
                        <td colspan="6" class="text-center text-muted py-5">
                            <div style="font-size: 2rem; color: #d6d3d1; margin-bottom: 0.5rem;"><i class="fas fa-images"></i></div>
                            <?php echo t('Belum ada banner. Tambahkan banner pertama Anda.', 'No banners yet. Add your first banner.'); ?>
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($banners as $b): ?>
                        <tr>
                            <td>
                                <?php if ($b->image && file_exists(FCPATH . 'uploads/banners/' . $b->image)): ?>
                                    <img src="<?php echo base_url('uploads/banners/' . $b->image); ?>" alt="" style="width: 80px; height: 45px; object-fit: cover; border-radius: 8px; border: 1px solid #e7e5e4;">
                                <?php else: ?>
                                    <span class="badge bg-light text-muted"><?php echo t('No Img', 'No Img'); ?></span>
                                <?php endif; ?>
                            </td>
                            <td class="fw-semibold"><?php echo htmlspecialchars($b->title); ?></td>
                            <td>
                                <?php if ($b->link): ?>
                                    <a href="<?php echo htmlspecialchars($b->link); ?>" target="_blank" class="text-decoration-none small" style="color: #059669;"><i class="fas fa-external-link-alt me-1" style="font-size: 0.6rem;"></i><?php echo htmlspecialchars(substr($b->link, 0, 40)); ?></a>
                                <?php else: ?>
                                    <span class="text-muted">—</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <span class="badge rounded-pill <?php echo $b->target === 'student' ? 'bg-info-subtle text-info' : ($b->target === 'mentor' ? 'bg-warning-subtle text-warning' : 'bg-success-subtle text-success'); ?>" style="font-size: 0.65rem;">
                                    <?php echo $b->target === 'both' ? t('Semua', 'All') : ucfirst($b->target); ?>
                                </span>
                            </td>
                            <td>
                                <a href="<?php echo base_url('admin/banners_toggle/' . $b->id); ?>" class="text-decoration-none">
                                    <span class="badge rounded-pill <?php echo $b->is_active ? 'bg-success-subtle text-success' : 'bg-secondary-subtle text-secondary'; ?>" style="font-size: 0.65rem;">
                                        <?php echo $b->is_active ? t('Aktif', 'Active') : t('Nonaktif', 'Inactive'); ?>
                                    </span>
                                </a>
                            </td>
                            <td class="text-end">
                                <a href="<?php echo base_url('admin/banners_edit/' . $b->id); ?>" class="btn btn-sm btn-outline-secondary rounded-pill px-3"><i class="fas fa-edit me-1" style="font-size: 0.65rem;"></i><?php echo t('Edit', 'Edit'); ?></a>
                                <a href="<?php echo base_url('admin/banners_delete/' . $b->id); ?>" class="btn btn-sm btn-outline-danger rounded-pill px-3" onclick="return confirm('<?php echo t('Hapus banner ini?', 'Delete this banner?'); ?>');"><i class="fas fa-trash me-1" style="font-size: 0.65rem;"></i><?php echo t('Hapus', 'Delete'); ?></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
