<div class="container-fluid py-4" style="max-width: 1400px;">
    <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between mb-4 gap-3">
        <div>
            <div style="color: #f97316; font-weight: 700; font-size: 0.7rem; text-transform: uppercase; letter-spacing: 0.08em; margin-bottom: 0.15rem;"><?php echo t('Langganan', 'Subscription'); ?></div>
            <h4 class="fw-extrabold mb-0" style="color: #1c1917; letter-spacing: -0.02em; font-size: 1.4rem;"><?php echo t('Paket Langganan', 'Subscription Packages'); ?></h4>
            <p style="color: #78716c; font-size: 0.82rem; margin-bottom: 0;"><?php echo t('Kelola paket langganan dan akses konten.', 'Manage subscription packages and content access.'); ?></p>
        </div>
        <a href="<?php echo base_url('admin/packages/create'); ?>" class="btn px-3 py-2 fw-semibold rounded-pill d-flex align-items-center gap-1" style="background: #f97316; color: #fff; font-size: 0.78rem;"><i class="fas fa-plus" style="font-size: 0.7rem;"></i> <?php echo t('Buat Paket Baru', 'Create New Package'); ?></a>
    </div>

    <div class="border rounded-3" style="border-color: #e7e5e4; border-radius: 12px; overflow: hidden;">
        <?php if (empty($packages)): ?>
            <div class="p-5 text-center"><div style="font-size: 2rem; color: #d6d3d1; margin-bottom: 0.5rem;"><i class="fas fa-layer-group"></i></div><h6 class="fw-bold" style="color: #1c1917;"><?php echo t('Belum ada paket langganan.', 'No subscription packages yet.'); ?></h6></div>
        <?php else: ?>
            <div class="table-responsive p-0">
                <table class="table mb-0" style="font-size: 0.8rem;">
                    <thead>
                        <tr>
                            <th style="font-weight: 600; color: #78716c; font-size: 0.68rem; border-color: #e7e5e4; padding: 0.7rem 1rem; background: #fafaf9; text-transform: uppercase; letter-spacing: 0.05em;"><?php echo t('Nama Paket', 'Package Name'); ?></th>
                            <th style="font-weight: 600; color: #78716c; font-size: 0.68rem; border-color: #e7e5e4; padding: 0.7rem 1rem; background: #fafaf9; text-transform: uppercase; letter-spacing: 0.05em;"><?php echo t('Harga', 'Price'); ?></th>
                            <th style="font-weight: 600; color: #78716c; font-size: 0.68rem; border-color: #e7e5e4; padding: 0.7rem 1rem; background: #fafaf9; text-transform: uppercase; letter-spacing: 0.05em;"><?php echo t('Durasi', 'Duration'); ?></th>
                            <th style="font-weight: 600; color: #78716c; font-size: 0.68rem; border-color: #e7e5e4; padding: 0.7rem 1rem; background: #fafaf9; text-transform: uppercase; letter-spacing: 0.05em;"><?php echo t('Akses', 'Access'); ?></th>
                            <th style="font-weight: 600; color: #78716c; font-size: 0.68rem; border-color: #e7e5e4; padding: 0.7rem 1rem; background: #fafaf9; text-transform: uppercase; letter-spacing: 0.05em;"><?php echo t('Status', 'Status'); ?></th>
                            <th style="font-weight: 600; color: #78716c; font-size: 0.68rem; border-color: #e7e5e4; padding: 0.7rem 1rem; background: #fafaf9; text-transform: uppercase; letter-spacing: 0.05em; text-align: center; width: 100px;"><?php echo t('Aksi', 'Action'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($packages as $p): ?>
                            <tr>
                                <td style="border-color: #f0eeeb; padding: 0.65rem 1rem; font-weight: 700; color: #1c1917; font-size: 0.82rem;"><?php echo htmlspecialchars($p->name); ?></td>
                                <td style="border-color: #f0eeeb; padding: 0.65rem 1rem; font-weight: 700; color: #1c1917; font-size: 0.8rem;">Rp <?php echo number_format($p->price, 0, ',', '.'); ?></td>
                                <td style="border-color: #f0eeeb; padding: 0.65rem 1rem; color: #57534e; font-size: 0.78rem;"><?php echo $p->duration_days . ' ' . t('hari', 'days'); ?></td>
                                <td style="border-color: #f0eeeb; padding: 0.65rem 1rem;"><span class="px-2 py-1 rounded-pill fw-semibold" style="background: <?php echo $p->access_scope === 'all' ? '#f0fdfa' : '#fff7ed'; ?>; color: <?php echo $p->access_scope === 'all' ? '#14b8a6' : '#f97316'; ?>; font-size: 0.6rem;"><?php if ($p->access_scope === 'all') echo t('Semua Konten', 'All Content'); elseif ($p->access_scope === 'category') echo t('Per Kategori', 'By Category'); else echo t('Per Kursus', 'By Course'); ?></span></td>
                                <td style="border-color: #f0eeeb; padding: 0.65rem 1rem;"><?php echo $p->is_active ? '<span class="px-2 py-1 rounded-pill fw-semibold" style="background: #f0fdfa; color: #14b8a6; font-size: 0.6rem;">Active</span>' : '<span class="px-2 py-1 rounded-pill fw-semibold" style="background: #f5f5f4; color: #78716c; font-size: 0.6rem;">Inactive</span>'; ?></td>
                                <td style="border-color: #f0eeeb; padding: 0.65rem 1rem; text-align: center;"><div class="d-flex justify-content-center gap-1"><a href="<?php echo base_url('admin/packages/edit/' . $p->id); ?>" class="btn btn-sm rounded-pill px-2 d-inline-flex align-items-center" style="background: #f97316; color: #fff; font-size: 0.68rem;"><i class="fas fa-edit" style="font-size: 0.65rem;"></i></a><a href="<?php echo base_url('admin/packages/delete/' . $p->id); ?>" data-confirm="<?php echo t('Hapus paket langganan?', 'Delete subscription package?'); ?>" class="btn btn-sm rounded-pill px-2 d-inline-flex align-items-center" style="border: 1px solid #fca5a5; color: #f43f5e; font-size: 0.68rem;"><i class="fas fa-trash-alt" style="font-size: 0.65rem;"></i></a></div></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>
