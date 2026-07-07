<div class="container-fluid px-0">
    <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between mb-5 gap-3">
        <div>
            <div class="d-flex align-items-center gap-2 mb-1">
                <a href="<?php echo base_url('admin/courses'); ?>" class="btn btn-outline-dark btn-sm rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                    <i data-lucide="arrow-left" style="width:14px;height:14px;"></i>
                </a>
                <h1 class="display-6 fw-extrabold text-dark mb-0 lh-sm" style="letter-spacing: -0.03em; font-size: 1.5rem;"><?php echo t('Tugas', 'Assignments'); ?>: <?php echo htmlspecialchars($course->title); ?></h1>
            </div>
            <p class="text-secondary mb-0 ms-5 ps-3"><?php echo t('Kelola tugas untuk kelas ini', 'Manage assignments for this course'); ?></p>
        </div>
        <a href="<?php echo base_url('admin/create_assignment/' . $course->id); ?>" class="btn btn-dark btn-sm px-3 rounded-pill shadow-sm d-flex align-items-center gap-1">
            <i data-lucide="plus" style="width:16px;height:16px;"></i> <?php echo t('Buat Tugas', 'Create Assignment'); ?>
        </a>
    </div>

    <div class="bento-card p-4 p-xl-5">
        <?php if (empty($assignments)): ?>
            <div class="empty-state">
                <i data-lucide="code" style="width:48px;height:48px;color:var(--gray-300);"></i>
                <h5><?php echo t('Belum ada tugas.', 'No assignments yet.'); ?></h5>
            </div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table-modern">
                    <thead>
                        <tr>
                            <th><?php echo t('Judul', 'Title'); ?></th>
                            <th><?php echo t('Tenggat', 'Due'); ?></th>
                            <th><?php echo t('Tipe File', 'File Type'); ?></th>
                            <th><?php echo t('Max File', 'Max Size'); ?></th>
                            <th><?php echo t('Pengumpulan', 'Submissions'); ?></th>
                            <th class="text-center col-w-120"><?php echo t('Aksi', 'Action'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($assignments as $a): ?>
                            <?php $sub_count = $this->Assignment_model->count_submissions($a->id); ?>
                            <tr>
                                <td class="fw-bold text-dark small"><?php echo htmlspecialchars($a->title); ?></td>
                                <td class="small"><?php echo $a->due_days; ?> <?php echo t('hari', 'days'); ?></td>
                                <td><span class="badge bg-light text-dark border rounded-pill px-3 py-2 fw-medium small"><?php echo strtoupper($a->allowed_file_types); ?></span></td>
                                <td class="small"><?php echo $a->max_file_size > 1024 ? round($a->max_file_size/1024, 1) . ' MB' : $a->max_file_size . ' KB'; ?></td>
                                <td><span class="badge bg-primary-subtle text-primary rounded-pill px-3 py-2 fw-medium"><?php echo $sub_count; ?></span></td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-1">
                                        <a href="<?php echo base_url('admin/delete_assignment/' . $a->id); ?>" class="btn btn-outline-danger btn-sm px-2 rounded-pill" data-confirm="<?php echo t('Hapus tugas?', 'Delete assignment?'); ?>">
                                            <i data-lucide="trash-2" style="width:14px;height:14px;"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>