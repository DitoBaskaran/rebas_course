<div class="container-fluid px-0">
    <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between mb-5 gap-3">
        <div>
            <span class="text-primary fw-semibold small text-uppercase tracking-wide d-block mb-1">Konten</span>
            <h1 class="display-6 fw-extrabold text-dark mb-1 lh-sm" style="letter-spacing: -0.03em;"><?php echo t('Daftar Konten', 'Content List'); ?></h1>
            <p class="text-secondary mb-0"><?php echo t('Kelola dan tambahkan konten pembelajaran.', 'Manage learning content.'); ?></p>
        </div>
        <div class="d-flex gap-2">
            <button class="btn btn-outline-secondary btn-sm px-3 rounded-pill d-flex align-items-center gap-1" id="viewToggle" onclick="toggleView()">
                <i data-lucide="layout-grid" style="width:16px;height:16px;"></i>
            </button>
            <a href="<?php echo base_url('admin/settings/general'); ?>" class="btn btn-outline-secondary btn-sm px-3 rounded-pill d-flex align-items-center gap-1">
                <i data-lucide="settings" style="width:16px;height:16px;"></i>
            </a>
            <a href="<?php echo base_url('admin/create_course'); ?>" class="btn btn-dark btn-sm px-3 rounded-pill shadow-sm d-flex align-items-center gap-1">
                <i data-lucide="plus" style="width:16px;height:16px;"></i> <?php echo t('Tambah Konten', 'Add Content'); ?>
            </a>
        </div>
    </div>

    <!-- Search & Filter Bar -->
    <div class="d-flex gap-2 mb-4 flex-wrap">
        <div class="position-relative flex-fill" style="min-width:200px;max-width:320px;">
            <i data-lucide="search" style="width:16px;height:16px;position:absolute;left:12px;top:50%;transform:translateY(-50%);color:var(--gray-400);pointer-events:none;"></i>
            <input type="text" class="form-control form-control-sm rounded-pill" style="padding-left:36px;" placeholder="<?php echo t('Cari konten...', 'Search content...'); ?>" id="searchInput" onkeyup="filterTable()">
        </div>
        <select class="form-select form-select-sm rounded-pill" style="width:auto;" onchange="filterTable()" id="statusFilter">
            <option value=""><?php echo t('Semua Status', 'All Status'); ?></option>
            <option value="published"><?php echo t('Published', 'Published'); ?></option>
            <option value="draft"><?php echo t('Draft', 'Draft'); ?></option>
            <option value="archived"><?php echo t('Archived', 'Archived'); ?></option>
        </select>
    </div>

    <!-- Table View -->
    <div class="bento-card p-4 p-xl-5" id="tableView">
        <div class="table-responsive">
            <table class="table-modern" id="courseTable">
                <thead>
                    <tr>
                        <th class="col-w-80"><?php echo t('Cover', 'Cover'); ?></th>
                        <th><?php echo t('Judul', 'Title'); ?></th>
                        <th><?php echo t('Tipe', 'Type'); ?></th>
                        <th><?php echo t('Kategori', 'Category'); ?></th>
                        <th><?php echo t('Instruktur', 'Instructor'); ?></th>
                        <th><?php echo t('Status', 'Status'); ?></th>
                        <th><?php echo t('Harga', 'Price'); ?></th>
                        <th class="text-center"><?php echo t('Materi', 'Lessons'); ?></th>
                        <th class="text-center col-w-120"><?php echo t('Aksi', 'Action'); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($courses)): ?>
                        <tr><td colspan="9" class="text-center text-muted py-5"><?php echo t('Belum ada konten.', 'No content yet.'); ?></td></tr>
                    <?php else: ?>
                        <?php foreach ($courses as $course): ?>
                            <tr data-status="<?php echo $course->status; ?>">
                                <td>
                                    <img src="<?php echo base_url('uploads/courses/' . $course->thumbnail); ?>" onerror="this.src='https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=100&auto=format&fit=crop&q=60';" alt="" class="thumb-md">
                                </td>
                                <td class="fw-bold text-dark small">
                                    <?php echo htmlspecialchars($course->title); ?>
                                    <?php if ($course->featured): ?> <i data-lucide="star" style="width:14px;height:14px;color:var(--warning);" class="ms-1"></i><?php endif; ?>
                                    <?php if ($course->price == 0): ?> <span class="badge bg-success badge-modern ms-1"><?php echo t('Gratis', 'Free'); ?></span><?php endif; ?>
                                </td>
                                <td>
                                    <span class="badge bg-primary-subtle text-primary badge-modern small"><?php echo content_type_label($course->content_type); ?></span>
                                    <span class="badge bg-info bg-opacity-10 text-info badge-modern small mt-1 d-block d-md-inline"><?php echo skill_level_label($course->skill_level); ?></span>
                                </td>
                                <td class="small"><?php echo htmlspecialchars($course->category_name ?? '-'); ?></td>
                                <td class="small"><?php echo htmlspecialchars($course->teacher_name); ?></td>
                                <td>
                                    <?php if ($course->status === 'published'): ?>
                                        <span class="badge bg-success badge-modern"><i class="fas fa-check-circle me-1"></i> <?php echo t('Published', 'Published'); ?></span>
                                    <?php elseif ($course->status === 'draft'): ?>
                                        <span class="badge bg-warning text-dark badge-modern"><i class="fas fa-pencil-alt me-1"></i> <?php echo t('Draft', 'Draft'); ?></span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary badge-modern"><i class="fas fa-archive me-1"></i> <?php echo t('Archived', 'Archived'); ?></span>
                                    <?php endif; ?>
                                </td>
                                <td class="fw-bold text-dark small"><?php echo $course->price > 0 ? 'Rp ' . number_format($course->price, 0, ',', '.') : t('Gratis', 'Free'); ?></td>
                                <td class="text-center">
                                    <div class="d-flex align-items-center gap-1 justify-content-center flex-wrap">
                                        <a href="<?php echo base_url('admin/lessons/' . $course->id); ?>" class="btn btn-sm fw-bold border-0 btn-ghost-primary" title="<?php echo t('Materi', 'Lessons'); ?>">
                                            <i data-lucide="list" style="width:16px;height:16px;"></i>
                                        </a>
                                        <a href="<?php echo base_url('quiz/admin_quizzes/' . $course->id); ?>" class="btn btn-sm fw-bold border-0 btn-ghost-primary" title="<?php echo t('Quiz', 'Quizzes'); ?>">
                                            <i data-lucide="pencil" style="width:16px;height:16px;"></i>
                                        </a>
                                        <a href="<?php echo base_url('admin/assignments/' . $course->id); ?>" class="btn btn-sm fw-bold border-0 btn-ghost-primary" title="<?php echo t('Tugas', 'Assignments'); ?>">
                                            <i data-lucide="code" style="width:16px;height:16px;"></i>
                                        </a>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-1">
                                        <a href="<?php echo base_url('admin/edit_course/' . $course->id); ?>" class="btn btn-warning btn-sm px-2" title="<?php echo t('Edit', 'Edit'); ?>">
                                            <i data-lucide="edit" style="width:14px;height:14px;"></i>
                                        </a>
                                        <a href="<?php echo base_url('admin/delete_course/' . $course->id); ?>" data-confirm="<?php echo t('Hapus konten ini?', 'Delete this content?'); ?>" class="btn btn-outline-danger btn-sm px-2" title="<?php echo t('Hapus', 'Delete'); ?>">
                                            <i data-lucide="trash-2" style="width:14px;height:14px;"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Grid View (hidden by default) -->
    <div class="bento-grid bento-grid-3" id="gridView" style="display:none;">
        <?php if (!empty($courses)): ?>
            <?php foreach ($courses as $course): ?>
                <div class="content-card" data-status="<?php echo $course->status; ?>">
                    <div class="card-thumb">
                        <img src="<?php echo base_url('uploads/courses/' . $course->thumbnail); ?>" onerror="this.src='https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=400&auto=format&fit=crop&q=60';" alt="">
                        <div class="card-badge">
                            <span class="badge bg-dark badge-modern"><?php echo content_type_label($course->content_type); ?></span>
                        </div>
                    </div>
                    <div class="card-body-custom">
                        <div class="card-meta">
                            <span><?php echo htmlspecialchars($course->category_name ?? ''); ?></span>
                            <span class="dot"></span>
                            <span><?php echo skill_level_label($course->skill_level); ?></span>
                        </div>
                        <div class="card-title"><?php echo htmlspecialchars($course->title); ?></div>
                        <div class="card-desc"><?php echo htmlspecialchars(substr($course->description, 0, 120)) . '...'; ?></div>
                        <div class="card-footer-custom">
                            <span class="card-price"><?php echo $course->price > 0 ? 'Rp ' . number_format($course->price, 0, ',', '.') : t('Gratis', 'Free'); ?></span>
                            <div class="d-flex gap-1">
                                <a href="<?php echo base_url('admin/edit_course/' . $course->id); ?>" class="btn btn-warning btn-sm px-2" title="<?php echo t('Edit', 'Edit'); ?>">
                                    <i data-lucide="edit" style="width:14px;height:14px;"></i>
                                </a>
                                <a href="<?php echo base_url('admin/delete_course/' . $course->id); ?>" data-confirm="<?php echo t('Hapus konten ini?', 'Delete this content?'); ?>" class="btn btn-outline-danger btn-sm px-2" title="<?php echo t('Hapus', 'Delete'); ?>">
                                    <i data-lucide="trash-2" style="width:14px;height:14px;"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-12">
                <div class="empty-state">
                    <i data-lucide="book-open" style="width:48px;height:48px;color:var(--gray-300);"></i>
                    <h5><?php echo t('Belum ada konten.', 'No content yet.'); ?></h5>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<script>
var tableView = true;
function toggleView() {
    var table = document.getElementById('tableView');
    var grid = document.getElementById('gridView');
    var btn = document.getElementById('viewToggle');
    tableView = !tableView;
    if (tableView) {
        table.style.display = 'block';
        grid.style.display = 'none';
        btn.innerHTML = '<i data-lucide="layout-grid" style="width:16px;height:16px;"></i>';
    } else {
        table.style.display = 'none';
        grid.style.display = 'grid';
        btn.innerHTML = '<i data-lucide="list" style="width:16px;height:16px;"></i>';
    }
    if (typeof lucide !== 'undefined') { lucide.createIcons(); }
}
function filterTable() {
    var q = document.getElementById('searchInput')?.value.toLowerCase() || '';
    var status = document.getElementById('statusFilter')?.value || '';
    var rows = document.querySelectorAll('#courseTable tbody tr, #gridView .content-card');
    rows.forEach(function(row) {
        var text = row.textContent.toLowerCase();
        var rowStatus = row.getAttribute('data-status') || '';
        var match = text.indexOf(q) !== -1;
        var statusMatch = !status || rowStatus === status;
        row.style.display = (match && statusMatch) ? '' : 'none';
    });
}
</script>