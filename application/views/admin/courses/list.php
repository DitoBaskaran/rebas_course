<div class="app-page">
    <!-- Header -->
    <div class="app-page-head">
        <div>
            <h4 class="app-page-title"><i class="fas fa-book-open"></i> <?php echo t('Daftar Konten', 'Content List'); ?></h4>
            <p class="app-page-sub"><?php echo t('Kelola dan tambahkan konten pembelajaran.', 'Manage learning content.'); ?></p>
        </div>
        <div class="app-page-actions">
            <a href="<?php echo base_url('admin/settings/general'); ?>" class="app-btn app-btn-icon" title="<?php echo t('Pengaturan', 'Settings'); ?>"><i class="fas fa-cog"></i></a>
            <a href="<?php echo base_url('admin/create_course'); ?>" class="app-btn app-btn-primary"><i class="fas fa-plus"></i> <?php echo t('Tambah Konten', 'Add Content'); ?></a>
        </div>
    </div>

    <!-- Search & Filter -->
    <div class="app-toolbar">
        <div class="app-search">
            <i class="fas fa-search"></i>
            <input type="text" placeholder="<?php echo t('Cari konten...', 'Search content...'); ?>" id="searchInput" onkeyup="filterTable()">
        </div>
        <select class="app-select" onchange="filterTable()" id="statusFilter">
            <option value=""><?php echo t('Semua Status', 'All Status'); ?></option>
            <option value="published"><?php echo t('Published', 'Published'); ?></option>
            <option value="draft"><?php echo t('Draft', 'Draft'); ?></option>
            <option value="archived"><?php echo t('Archived', 'Archived'); ?></option>
        </select>
    </div>

    <?php if (empty($courses)): ?>
    <div class="app-card">
        <div class="app-empty">
            <i class="fas fa-book-open"></i>
            <h6><?php echo t('Belum Ada Konten', 'No Content Yet'); ?></h6>
            <p><?php echo t('Tambahkan konten pembelajaran pertama Anda.', 'Add your first learning content.'); ?></p>
            <a href="<?php echo base_url('admin/create_course'); ?>" class="app-btn app-btn-primary app-btn-sm"><i class="fas fa-plus"></i> <?php echo t('Tambah Konten', 'Add Content'); ?></a>
        </div>
    </div>
    <?php else: ?>
    <div class="app-card">
        <div class="app-table-wrap">
            <table class="app-table" id="courseTable">
                <thead>
                    <tr>
                        <th><?php echo t('Cover', 'Cover'); ?></th>
                        <th><?php echo t('Judul', 'Title'); ?></th>
                        <th><?php echo t('Tipe', 'Type'); ?></th>
                        <th><?php echo t('Kategori', 'Category'); ?></th>
                        <th><?php echo t('Instruktur', 'Instructor'); ?></th>
                        <th><?php echo t('Status', 'Status'); ?></th>
                        <th><?php echo t('Harga', 'Price'); ?></th>
                        <th><?php echo t('Materi', 'Lessons'); ?></th>
                        <th class="td-actions"><?php echo t('Aksi', 'Action'); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($courses as $course): ?>
                        <tr data-status="<?php echo $course->status; ?>">
                            <td>
                                <img src="<?php echo base_url('uploads/courses/' . $course->thumbnail); ?>" onerror="this.style.visibility='hidden';" alt="" class="app-thumb">
                            </td>
                            <td class="td-title">
                                <?php echo htmlspecialchars($course->title); ?>
                                <?php if ($course->featured): ?><i class="fas fa-star" style="color:#FBBF24;font-size:0.6rem;margin-left:0.25rem;"></i><?php endif; ?>
                                <?php if ($course->price == 0): ?><span class="app-chip app-chip-green"><?php echo t('Gratis', 'Free'); ?></span><?php endif; ?>
                            </td>
                            <td>
                                <div class="d-flex gap-1 flex-wrap">
                                    <span class="app-chip app-chip-amber"><?php echo content_type_label($course->content_type); ?></span>
                                    <span class="app-chip app-chip-gray"><?php echo skill_level_label($course->skill_level); ?></span>
                                </div>
                            </td>
                            <td style="color:#57534e;font-size:0.78rem;"><?php echo htmlspecialchars($course->category_name ?? '-'); ?></td>
                            <td style="color:#57534e;font-size:0.78rem;"><?php echo htmlspecialchars($course->teacher_name); ?></td>
                            <td>
                                <?php if ($course->status === 'published'): ?>
                                    <span class="app-chip app-chip-green"><i class="fas fa-check-circle"></i> <?php echo t('Published', 'Published'); ?></span>
                                <?php elseif ($course->status === 'draft'): ?>
                                    <span class="app-chip app-chip-amber"><i class="fas fa-pencil-alt"></i> <?php echo t('Draft', 'Draft'); ?></span>
                                <?php else: ?>
                                    <span class="app-chip app-chip-gray"><i class="fas fa-archive"></i> <?php echo t('Archived', 'Archived'); ?></span>
                                <?php endif; ?>
                            </td>
                            <td class="td-title" style="font-size:0.8rem;">
                                <?php echo $course->price > 0 ? 'Rp ' . number_format($course->price, 0, ',', '.') : '<span style="color:#009688;">' . t('Gratis', 'Free') . '</span>'; ?>
                            </td>
                            <td>
                                <div class="d-flex gap-1">
                                    <a href="<?php echo base_url('admin/lessons/' . $course->id); ?>" class="app-action app-action-gray" title="<?php echo t('Materi', 'Lessons'); ?>"><i class="fas fa-list"></i></a>
                                    <a href="<?php echo base_url('quiz/admin_quizzes/' . $course->id); ?>" class="app-action app-action-gray" title="<?php echo t('Quiz', 'Quizzes'); ?>"><i class="fas fa-pencil-alt"></i></a>
                                    <a href="<?php echo base_url('admin/assignments/' . $course->id); ?>" class="app-action app-action-gray" title="<?php echo t('Tugas', 'Assignments'); ?>"><i class="fas fa-code"></i></a>
                                </div>
                            </td>
                            <td class="td-actions">
                                <a href="<?php echo base_url('admin/edit_course/' . $course->id); ?>" class="app-action app-action-dark" title="<?php echo t('Edit', 'Edit'); ?>"><i class="fas fa-edit"></i></a>
                                <a href="<?php echo base_url('admin/delete_course/' . $course->id); ?>" data-confirm="<?php echo t('Hapus konten ini?', 'Delete this content?'); ?>" class="app-action app-action-red" title="<?php echo t('Hapus', 'Delete'); ?>"><i class="fas fa-trash-alt"></i></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php endif; ?>
</div>

<script>
function filterTable() {
    var q = (document.getElementById('searchInput')?.value || '').toLowerCase();
    var st = document.getElementById('statusFilter')?.value || '';
    document.querySelectorAll('#courseTable tbody tr').forEach(function(tr) {
        var text = tr.textContent.toLowerCase();
        var status = tr.getAttribute('data-status') || '';
        tr.style.display = (text.indexOf(q) !== -1 && (!st || status === st)) ? '' : 'none';
    });
}
</script>
