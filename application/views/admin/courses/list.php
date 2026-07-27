<div class="container-fluid py-4" style="max-width: 1400px;">
    <!-- Header -->
    <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between mb-4 gap-3">
        <div>
            <div style="color: #f97316; font-weight: 700; font-size: 0.7rem; text-transform: uppercase; letter-spacing: 0.08em; margin-bottom: 0.15rem;"><?php echo t('Konten', 'Content'); ?></div>
            <h4 class="fw-extrabold mb-0" style="color: #1c1917; letter-spacing: -0.02em; font-size: 1.4rem;">
                <?php echo t('Daftar Konten', 'Content List'); ?>
            </h4>
            <p style="color: #78716c; font-size: 0.82rem; margin-bottom: 0;">
                <?php echo t('Kelola dan tambahkan konten pembelajaran.', 'Manage learning content.'); ?>
            </p>
        </div>
        <div class="d-flex gap-2">
            <button class="btn px-3 py-2 rounded-pill d-flex align-items-center gap-1" style="background: #f5f5f4; color: #57534e; font-size: 0.78rem;" id="viewToggle" onclick="toggleView()">
                <i class="fas fa-th" style="font-size: 0.7rem;"></i>
            </button>
            <a href="<?php echo base_url('admin/settings/general'); ?>" class="btn px-3 py-2 rounded-pill d-flex align-items-center gap-1" style="background: #f5f5f4; color: #57534e; font-size: 0.78rem;">
                <i class="fas fa-cog" style="font-size: 0.7rem;"></i>
            </a>
            <a href="<?php echo base_url('admin/create_course'); ?>" class="btn px-3 py-2 fw-semibold rounded-pill d-flex align-items-center gap-1" style="background: #f97316; color: #fff; font-size: 0.78rem;">
                <i class="fas fa-plus" style="font-size: 0.7rem;"></i> <?php echo t('Tambah Konten', 'Add Content'); ?>
            </a>
        </div>
    </div>

    <!-- Search & Filter -->
    <div class="d-flex gap-2 mb-4 flex-wrap">
        <div class="position-relative flex-fill" style="min-width: 220px; max-width: 340px;">
            <i class="fas fa-search" style="font-size: 0.75rem; position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: #a8a29e; pointer-events: none;"></i>
            <input type="text" class="form-control rounded-pill" style="padding-left: 36px; height: 40px; border-color: #e7e5e4; font-size: 0.82rem;" placeholder="<?php echo t('Cari konten...', 'Search content...'); ?>" id="searchInput" onkeyup="filterTable()">
        </div>
        <select class="form-select rounded-pill" style="width: auto; height: 40px; border-color: #e7e5e4; font-size: 0.82rem;" onchange="filterTable()" id="statusFilter">
            <option value=""><?php echo t('Semua Status', 'All Status'); ?></option>
            <option value="published"><?php echo t('Published', 'Published'); ?></option>
            <option value="draft"><?php echo t('Draft', 'Draft'); ?></option>
            <option value="archived"><?php echo t('Archived', 'Archived'); ?></option>
        </select>
    </div>

    <!-- Table View -->
    <div id="tableView">
        <?php if (empty($courses)): ?>
        <div class="border rounded-3 p-5 text-center" style="border-color: #e7e5e4; border-radius: 12px;">
            <div style="font-size: 2rem; color: #d6d3d1; margin-bottom: 0.5rem;"><i class="fas fa-book-open"></i></div>
            <h6 class="fw-bold" style="color: #1c1917;"><?php echo t('Belum Ada Konten', 'No Content Yet'); ?></h6>
            <p style="color: #78716c; font-size: 0.82rem;"><?php echo t('Tambahkan konten pembelajaran pertama Anda.', 'Add your first learning content.'); ?></p>
        </div>
        <?php else: ?>
        <div class="border rounded-3" style="border-color: #e7e5e4; border-radius: 12px; overflow: hidden;">
            <div class="table-responsive p-0">
                <table class="table mb-0" style="font-size: 0.8rem;" id="courseTable">
                    <thead>
                        <tr>
                            <th style="font-weight: 600; color: #78716c; font-size: 0.68rem; border-color: #e7e5e4; padding: 0.7rem 1rem; background: #fafaf9; text-transform: uppercase; letter-spacing: 0.05em; width: 72px;"><?php echo t('Cover', 'Cover'); ?></th>
                            <th style="font-weight: 600; color: #78716c; font-size: 0.68rem; border-color: #e7e5e4; padding: 0.7rem 1rem; background: #fafaf9; text-transform: uppercase; letter-spacing: 0.05em;"><?php echo t('Judul', 'Title'); ?></th>
                            <th style="font-weight: 600; color: #78716c; font-size: 0.68rem; border-color: #e7e5e4; padding: 0.7rem 1rem; background: #fafaf9; text-transform: uppercase; letter-spacing: 0.05em;"><?php echo t('Tipe', 'Type'); ?></th>
                            <th style="font-weight: 600; color: #78716c; font-size: 0.68rem; border-color: #e7e5e4; padding: 0.7rem 1rem; background: #fafaf9; text-transform: uppercase; letter-spacing: 0.05em;"><?php echo t('Kategori', 'Category'); ?></th>
                            <th style="font-weight: 600; color: #78716c; font-size: 0.68rem; border-color: #e7e5e4; padding: 0.7rem 1rem; background: #fafaf9; text-transform: uppercase; letter-spacing: 0.05em;"><?php echo t('Instruktur', 'Instructor'); ?></th>
                            <th style="font-weight: 600; color: #78716c; font-size: 0.68rem; border-color: #e7e5e4; padding: 0.7rem 1rem; background: #fafaf9; text-transform: uppercase; letter-spacing: 0.05em;"><?php echo t('Status', 'Status'); ?></th>
                            <th style="font-weight: 600; color: #78716c; font-size: 0.68rem; border-color: #e7e5e4; padding: 0.7rem 1rem; background: #fafaf9; text-transform: uppercase; letter-spacing: 0.05em;"><?php echo t('Harga', 'Price'); ?></th>
                            <th style="font-weight: 600; color: #78716c; font-size: 0.68rem; border-color: #e7e5e4; padding: 0.7rem 1rem; background: #fafaf9; text-transform: uppercase; letter-spacing: 0.05em; text-align: center;"><?php echo t('Materi', 'Lessons'); ?></th>
                            <th style="font-weight: 600; color: #78716c; font-size: 0.68rem; border-color: #e7e5e4; padding: 0.7rem 1rem; background: #fafaf9; text-transform: uppercase; letter-spacing: 0.05em; text-align: center; width: 100px;"><?php echo t('Aksi', 'Action'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($courses as $course): ?>
                            <tr data-status="<?php echo $course->status; ?>">
                                <td style="border-color: #f0eeeb; padding: 0.55rem 1rem;">
                                    <img src="<?php echo base_url('uploads/courses/' . $course->thumbnail); ?>" onerror="this.src='https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=80&auto=format&fit=crop&q=60';" alt="" class="rounded-2" style="width: 64px; height: 44px; object-fit: cover; border: 1px solid #e7e5e4;">
                                </td>
                                <td style="border-color: #f0eeeb; padding: 0.55rem 1rem; font-weight: 700; color: #1c1917; font-size: 0.82rem;">
                                    <?php echo htmlspecialchars($course->title); ?>
                                    <?php if ($course->featured): ?><i class="fas fa-star" style="color: #eab308; font-size: 0.6rem; margin-left: 0.25rem;"></i><?php endif; ?>
                                    <?php if ($course->price == 0): ?><span class="px-2 py-1 rounded-pill fw-semibold ms-1" style="background: #f0fdfa; color: #10b981; font-size: 0.6rem;"><?php echo t('Gratis', 'Free'); ?></span><?php endif; ?>
                                </td>
                                <td style="border-color: #f0eeeb; padding: 0.55rem 1rem;">
                                    <span class="px-2 py-1 rounded-pill fw-semibold mb-1 d-inline-block" style="background: #fff7ed; color: #f97316; font-size: 0.6rem;"><?php echo content_type_label($course->content_type); ?></span>
                                    <span class="px-2 py-1 rounded-pill fw-semibold" style="background: #f5f5f4; color: #57534e; font-size: 0.6rem;"><?php echo skill_level_label($course->skill_level); ?></span>
                                </td>
                                <td style="border-color: #f0eeeb; padding: 0.55rem 1rem; color: #57534e; font-size: 0.78rem;"><?php echo htmlspecialchars($course->category_name ?? '-'); ?></td>
                                <td style="border-color: #f0eeeb; padding: 0.55rem 1rem; color: #57534e; font-size: 0.78rem;"><?php echo htmlspecialchars($course->teacher_name); ?></td>
                                <td style="border-color: #f0eeeb; padding: 0.55rem 1rem;">
                                    <?php if ($course->status === 'published'): ?>
                                        <span class="px-2 py-1 rounded-pill fw-semibold" style="background: #f0fdfa; color: #10b981; font-size: 0.62rem;">
                                            <i class="fas fa-check-circle me-1" style="font-size: 0.5rem;"></i> <?php echo t('Published', 'Published'); ?>
                                        </span>
                                    <?php elseif ($course->status === 'draft'): ?>
                                        <span class="px-2 py-1 rounded-pill fw-semibold" style="background: #fff7ed; color: #f97316; font-size: 0.62rem;">
                                            <i class="fas fa-pencil-alt me-1" style="font-size: 0.5rem;"></i> <?php echo t('Draft', 'Draft'); ?>
                                        </span>
                                    <?php else: ?>
                                        <span class="px-2 py-1 rounded-pill fw-semibold" style="background: #f5f5f4; color: #78716c; font-size: 0.62rem;">
                                            <i class="fas fa-archive me-1" style="font-size: 0.5rem;"></i> <?php echo t('Archived', 'Archived'); ?>
                                        </span>
                                    <?php endif; ?>
                                </td>
                                <td style="border-color: #f0eeeb; padding: 0.55rem 1rem; font-weight: 700; color: #1c1917; font-size: 0.8rem;">
                                    <?php echo $course->price > 0 ? 'Rp ' . number_format($course->price, 0, ',', '.') : '<span style="color: #10b981;">' . t('Gratis', 'Free') . '</span>'; ?>
                                </td>
                                <td style="border-color: #f0eeeb; padding: 0.55rem 1rem;">
                                    <div class="d-flex gap-1 justify-content-center">
                                        <a href="<?php echo base_url('admin/lessons/' . $course->id); ?>" class="btn btn-sm rounded-pill px-2 fw-semibold d-inline-flex align-items-center gap-1" style="background: #f5f5f4; color: #57534e; font-size: 0.68rem;" title="<?php echo t('Materi', 'Lessons'); ?>">
                                            <i class="fas fa-list" style="font-size: 0.65rem;"></i>
                                        </a>
                                        <a href="<?php echo base_url('quiz/admin_quizzes/' . $course->id); ?>" class="btn btn-sm rounded-pill px-2 fw-semibold d-inline-flex align-items-center gap-1" style="background: #f5f5f4; color: #57534e; font-size: 0.68rem;" title="<?php echo t('Quiz', 'Quizzes'); ?>">
                                            <i class="fas fa-pencil-alt" style="font-size: 0.65rem;"></i>
                                        </a>
                                        <a href="<?php echo base_url('admin/assignments/' . $course->id); ?>" class="btn btn-sm rounded-pill px-2 fw-semibold d-inline-flex align-items-center gap-1" style="background: #f5f5f4; color: #57534e; font-size: 0.68rem;" title="<?php echo t('Tugas', 'Assignments'); ?>">
                                            <i class="fas fa-code" style="font-size: 0.65rem;"></i>
                                        </a>
                                    </div>
                                </td>
                                <td style="border-color: #f0eeeb; padding: 0.55rem 1rem;">
                                    <div class="d-flex justify-content-center gap-1">
                                        <a href="<?php echo base_url('admin/edit_course/' . $course->id); ?>" class="btn btn-sm rounded-pill px-2 fw-semibold d-inline-flex align-items-center" style="background: #f97316; color: #fff; font-size: 0.68rem;" title="<?php echo t('Edit', 'Edit'); ?>">
                                            <i class="fas fa-edit" style="font-size: 0.65rem;"></i>
                                        </a>
                                        <a href="<?php echo base_url('admin/delete_course/' . $course->id); ?>" data-confirm="<?php echo t('Hapus konten ini?', 'Delete this content?'); ?>" class="btn btn-sm rounded-pill px-2 d-inline-flex align-items-center" style="border: 1px solid #fca5a5; color: #f43f5e; font-size: 0.68rem;" title="<?php echo t('Hapus', 'Delete'); ?>">
                                            <i class="fas fa-trash-alt" style="font-size: 0.65rem;"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <?php endif; ?>
    </div>

    <!-- Grid View -->
    <div id="gridView" style="display: none;">
        <div class="row g-3">
            <?php if (!empty($courses)): ?>
                <?php foreach ($courses as $course): ?>
                    <div class="col-md-6 col-lg-4" data-status="<?php echo $course->status; ?>">
                        <div class="border rounded-3 h-100 d-flex flex-column" style="border-color: #e7e5e4; border-radius: 12px; overflow: hidden;">
                            <div class="position-relative" style="aspect-ratio: 16/9;">
                                <img src="<?php echo base_url('uploads/courses/' . $course->thumbnail); ?>" onerror="this.src='https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=400&auto=format&fit=crop&q=60';" alt="" class="w-100 h-100" style="object-fit: cover;">
                                <span class="position-absolute px-2 py-1 rounded-pill fw-semibold" style="bottom: 8px; left: 8px; background: #1c1917; color: #fff; font-size: 0.6rem;">
                                    <?php echo content_type_label($course->content_type); ?>
                                </span>
                            </div>
                            <div class="p-3 d-flex flex-column flex-fill">
                                <div style="color: #78716c; font-size: 0.72rem; margin-bottom: 0.25rem;">
                                    <?php echo htmlspecialchars($course->category_name ?? ''); ?> · <?php echo skill_level_label($course->skill_level); ?>
                                </div>
                                <h6 class="fw-bold mb-2" style="color: #1c1917; font-size: 0.85rem; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                                    <?php echo htmlspecialchars($course->title); ?>
                                </h6>
                                <p style="color: #78716c; font-size: 0.75rem; flex-grow: 1; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; line-height: 1.5;">
                                    <?php echo htmlspecialchars(substr($course->description, 0, 120)); ?>...
                                </p>
                                <div class="d-flex align-items-center justify-content-between pt-2" style="border-top: 1px solid #f0eeeb;">
                                    <span class="fw-bold" style="color: #f97316; font-size: 0.82rem;">
                                        <?php echo $course->price > 0 ? 'Rp ' . number_format($course->price, 0, ',', '.') : '<span style="color: #10b981;">' . t('Gratis', 'Free') . '</span>'; ?>
                                    </span>
                                    <div class="d-flex gap-1">
                                        <a href="<?php echo base_url('admin/edit_course/' . $course->id); ?>" class="btn btn-sm rounded-pill px-2 fw-semibold d-inline-flex align-items-center" style="background: #f97316; color: #fff; font-size: 0.68rem;">
                                            <i class="fas fa-edit" style="font-size: 0.65rem;"></i>
                                        </a>
                                        <a href="<?php echo base_url('admin/delete_course/' . $course->id); ?>" data-confirm="<?php echo t('Hapus konten ini?', 'Delete this content?'); ?>" class="btn btn-sm rounded-pill px-2 d-inline-flex align-items-center" style="border: 1px solid #fca5a5; color: #f43f5e; font-size: 0.68rem;">
                                            <i class="fas fa-trash-alt" style="font-size: 0.65rem;"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12">
                    <div class="border rounded-3 p-5 text-center" style="border-color: #e7e5e4; border-radius: 12px;">
                        <div style="font-size: 2rem; color: #d6d3d1; margin-bottom: 0.5rem;"><i class="fas fa-book-open"></i></div>
                        <h6 class="fw-bold" style="color: #1c1917;"><?php echo t('Belum Ada Konten', 'No Content Yet'); ?></h6>
                    </div>
                </div>
            <?php endif; ?>
        </div>
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
        btn.innerHTML = '<i class="fas fa-th" style="font-size: 0.7rem;"></i>';
    } else {
        table.style.display = 'none';
        grid.style.display = 'block';
        btn.innerHTML = '<i class="fas fa-list" style="font-size: 0.7rem;"></i>';
    }
}
function filterTable() {
    var q = document.getElementById('searchInput')?.value.toLowerCase() || '';
    var status = document.getElementById('statusFilter')?.value || '';
    var rows = document.querySelectorAll('#courseTable tbody tr, #gridView [data-status]');
    rows.forEach(function(row) {
        var text = row.textContent.toLowerCase();
        var rowStatus = row.getAttribute('data-status') || '';
        var match = text.indexOf(q) !== -1;
        var statusMatch = !status || rowStatus === status;
        row.style.display = (match && statusMatch) ? '' : 'none';
    });
}
</script>
