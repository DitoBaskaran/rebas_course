<div class="app-page">
    <!-- Header with back -->
    <div class="app-page-head">
        <div class="d-flex align-items-center gap-2">
            <a href="<?php echo base_url('admin/courses'); ?>" class="app-btn app-btn-icon" title="<?php echo t('Kembali', 'Back'); ?>"><i class="fas fa-arrow-left"></i></a>
            <div>
                <h4 class="app-page-title mb-0"><?php echo t('Tugas', 'Assignments'); ?>: <?php echo htmlspecialchars($course->title); ?></h4>
                <p class="app-page-sub"><?php echo t('Kelola tugas untuk kelas ini', 'Manage assignments for this course'); ?></p>
            </div>
        </div>
        <div class="app-page-actions">
            <a href="<?php echo base_url('admin/create_assignment/' . $course->id); ?>" class="app-btn app-btn-primary"><i class="fas fa-plus"></i> <?php echo t('Buat Tugas', 'Create Assignment'); ?></a>
        </div>
    </div>

    <?php if (empty($assignments)): ?>
        <div class="app-card">
            <div class="app-empty">
                <i class="fas fa-code"></i>
                <h6><?php echo t('Belum ada tugas.', 'No assignments yet.'); ?></h6>
                <p><?php echo t('Buat tugas pertama untuk kelas ini.', 'Create the first assignment for this course.'); ?></p>
            </div>
        </div>
    <?php else: ?>
        <div class="app-card">
            <div class="app-table-wrap">
                <table class="app-table">
                    <thead>
                        <tr>
                            <th><?php echo t('Judul', 'Title'); ?></th>
                            <th><?php echo t('Tenggat', 'Due'); ?></th>
                            <th><?php echo t('Tipe File', 'File Type'); ?></th>
                            <th><?php echo t('Max File', 'Max Size'); ?></th>
                            <th><?php echo t('Pengumpulan', 'Submissions'); ?></th>
                            <th class="td-actions"><?php echo t('Aksi', 'Action'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($assignments as $a): ?>
                            <?php $sub_count = $this->Assignment_model->count_submissions($a->id); ?>
                            <tr>
                                <td class="td-title"><?php echo htmlspecialchars($a->title); ?></td>
                                <td style="font-size:0.78rem;"><?php echo $a->due_days; ?> <?php echo t('hari', 'days'); ?></td>
                                <td><span class="app-chip app-chip-gray"><?php echo strtoupper($a->allowed_file_types); ?></span></td>
                                <td style="font-size:0.78rem;"><?php echo $a->max_file_size > 1024 ? round($a->max_file_size/1024, 1) . ' MB' : $a->max_file_size . ' KB'; ?></td>
                                <td><span class="app-chip app-chip-blue"><?php echo $sub_count; ?></span></td>
                                <td class="td-actions">
                                    <a href="<?php echo base_url('admin/delete_assignment/' . $a->id); ?>" class="app-action app-action-red" data-confirm="<?php echo t('Hapus tugas?', 'Delete assignment?'); ?>" title="<?php echo t('Hapus', 'Delete'); ?>"><i class="fas fa-trash-alt"></i></a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php endif; ?>
</div>
