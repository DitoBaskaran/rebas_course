<div class="container-fluid py-4" style="max-width: 1400px;">
    <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between mb-4 gap-3">
        <div>
            <div style="color: #0D1830; font-weight: 700; font-size: 0.7rem; text-transform: uppercase; letter-spacing: 0.08em; margin-bottom: 0.15rem;">Event</div>
            <h4 class="fw-extrabold mb-0" style="color: #0D1830; letter-spacing: -0.02em; font-size: 1.4rem;"><?php echo t('Daftar Seminar', 'Seminar List'); ?></h4>
            <p style="color: #78716c; font-size: 0.82rem; margin-bottom: 0;"><?php echo t('Atur jadwal dan kuota seminar langsung.', 'Manage live seminar schedules and quotas.'); ?></p>
        </div>
        <div class="d-flex gap-2">
            <a href="<?php echo base_url('admin/settings/hero'); ?>" class="btn px-3 py-2 rounded-pill d-flex align-items-center gap-1" style="background: #E6EBEF; color: #57534e; font-size: 0.78rem;"><i class="fas fa-cog" style="font-size: 0.7rem;"></i></a>
            <a href="<?php echo base_url('admin/create_seminar'); ?>" class="btn px-3 py-2 fw-semibold rounded-pill d-flex align-items-center gap-1" style="background: #0D1830; color: #fff; font-size: 0.78rem;"><i class="fas fa-plus" style="font-size: 0.7rem;"></i> <?php echo t('Tambah Seminar', 'Add Seminar'); ?></a>
        </div>
    </div>

    <div class="row g-3">
        <?php if (empty($seminars)): ?>
            <div class="col-12"><div class="border rounded-3 p-5 text-center" style="border-color: #e7e5e4; border-radius: 12px;"><div style="font-size: 2rem; color: #d6d3d1; margin-bottom: 0.5rem;"><i class="fas fa-calendar"></i></div><h6 class="fw-bold" style="color: #0D1830;"><?php echo t('Belum ada seminar.', 'No seminars yet.'); ?></h6></div></div>
        <?php else: ?>
            <?php foreach ($seminars as $sem): ?>
                <div class="col-md-6 col-lg-4">
                    <div class="border rounded-3 h-100 overflow-hidden" style="border-color: #e7e5e4; border-radius: 12px;">
                        <div style="aspect-ratio: 16/9; overflow: hidden;">
                            <img src="<?php echo base_url('uploads/seminars/' . $sem->thumbnail); ?>" onerror="this.src='https://images.unsplash.com/photo-1540575467063-178a50c2df87?w=400&auto=format&fit=crop&q=60';" alt="" class="w-100 h-100" style="object-fit: cover;">
                        </div>
                        <div class="p-3 d-flex flex-column">
                            <h6 class="fw-bold mb-2" style="color: #0D1830; font-size: 0.85rem;"><?php echo htmlspecialchars($sem->title); ?></h6>
                            <div class="d-flex flex-column gap-1 mb-2" style="color: #78716c; font-size: 0.75rem;">
                                <span class="d-flex align-items-center gap-1"><i class="far fa-calendar" style="font-size: 0.6rem;"></i> <?php echo date('d M Y', strtotime($sem->date_time)); ?> <?php echo date('H:i', strtotime($sem->date_time)); ?></span>
                                <span class="d-flex align-items-center gap-1"><i class="fas fa-users" style="font-size: 0.6rem;"></i> <?php echo $sem->quota; ?> <?php echo t('kursi', 'seats'); ?></span>
                                <span class="fw-bold" style="color: #0D1830; font-size: 0.82rem;"><?php echo $sem->price > 0 ? 'Rp ' . number_format($sem->price, 0, ',', '.') : t('Gratis', 'Free'); ?></span>
                            </div>
                            <div class="d-flex align-items-center justify-content-between pt-2" style="border-top: 1px solid #f0eeeb;">
                                <span style="color: #a8a29e; font-size: 0.7rem;"><?php echo $sem->language === 'en' ? 'English' : 'Indonesia'; ?></span>
                                <div class="d-flex gap-1">
                                    <a href="<?php echo base_url('admin/edit_seminar/' . $sem->id); ?>" class="btn btn-sm rounded-pill px-2 d-inline-flex align-items-center" style="background: #0D1830; color: #fff; font-size: 0.68rem;"><i class="fas fa-edit" style="font-size: 0.65rem;"></i></a>
                                    <a href="<?php echo base_url('admin/delete_seminar/' . $sem->id); ?>" data-confirm="<?php echo t('Hapus seminar ini?', 'Delete this seminar?'); ?>" class="btn btn-sm rounded-pill px-2 d-inline-flex align-items-center" style="border: 1px solid #fca5a5; color: #f43f5e; font-size: 0.68rem;"><i class="fas fa-trash-alt" style="font-size: 0.65rem;"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>
