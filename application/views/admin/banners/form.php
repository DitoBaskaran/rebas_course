<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="page-header mb-4">
    <h1 class="h3 fw-bold mb-1"><?php echo isset($banner) ? t('Edit Banner', 'Edit Banner') : t('Tambah Banner', 'Add Banner'); ?></h1>
    <p class="text-muted small mb-0"><?php echo t('Banner tampil di carousel dashboard student & mentor.', 'Banner shows on the student & mentor dashboard carousel.'); ?></p>
</div>

<?php echo form_open_multipart(isset($banner) ? 'admin/banners_edit/' . $banner->id : 'admin/banners_create', array('class' => 'card-modern p-4')); ?>
    <div class="row g-4">
        <div class="col-md-8">
            <div class="mb-3">
                <label class="form-label fw-semibold"><?php echo t('Judul Banner', 'Banner Title'); ?> <span class="text-danger">*</span></label>
                <input type="text" name="title" class="form-control" value="<?php echo isset($banner) ? htmlspecialchars($banner->title) : ''; ?>" required placeholder="<?php echo t('cth: Diskon 50% Kelas Programming', 'e.g: 50% Off Programming Courses'); ?>">
                <?php echo form_error('title', '<div class="text-danger small mt-1">', '</div>'); ?>
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold"><?php echo t('Tautan (opsional)', 'Link (optional)'); ?></label>
                <input type="url" name="link" class="form-control" value="<?php echo isset($banner) ? htmlspecialchars($banner->link) : ''; ?>" placeholder="<?php echo t('cth: https://course.ditobaskaran.my.id/courses', 'e.g: https://course.ditobaskaran.my.id/courses'); ?>">
                <div class="form-text"><?php echo t('Banner akan mengarah ke tautan ini saat diklik.', 'Banner will navigate to this link when clicked.'); ?></div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold"><?php echo t('Target', 'Target'); ?></label>
                    <select name="target" class="form-select">
                        <option value="both" <?php echo isset($banner) && $banner->target === 'both' ? 'selected' : ''; ?>><?php echo t('Student & Mentor', 'Student & Mentor'); ?></option>
                        <option value="student" <?php echo isset($banner) && $banner->target === 'student' ? 'selected' : ''; ?>><?php echo t('Student Saja', 'Student Only'); ?></option>
                        <option value="mentor" <?php echo isset($banner) && $banner->target === 'mentor' ? 'selected' : ''; ?>><?php echo t('Mentor Saja', 'Mentor Only'); ?></option>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold"><?php echo t('Status', 'Status'); ?></label>
                    <div class="form-check form-switch mt-2">
                        <input class="form-check-input" type="checkbox" name="is_active" value="1" id="isActive" <?php echo !isset($banner) || $banner->is_active ? 'checked' : ''; ?>>
                        <label class="form-check-label" for="isActive"><?php echo t('Aktif', 'Active'); ?></label>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <label class="form-label fw-semibold"><?php echo t('Gambar', 'Image'); ?></label>
            <div class="border rounded-3 p-3 text-center bg-light" style="border-style: dashed !important;">
                <?php if (isset($banner) && $banner->image && file_exists(FCPATH . 'uploads/banners/' . $banner->image)): ?>
                    <img src="<?php echo base_url('uploads/banners/' . $banner->image); ?>" alt="" class="img-fluid rounded-2 mb-3" style="max-height: 120px; object-fit: cover;">
                    <div class="small text-muted mb-2"><?php echo t('Gambar saat ini', 'Current image'); ?></div>
                <?php else: ?>
                    <div style="font-size: 2rem; color: #d6d3d1; margin-bottom: 0.5rem;"><i class="fas fa-image"></i></div>
                    <div class="small text-muted mb-3"><?php echo t('Rekomendasi: 1200×400px (rasio 3:1), JPG/WebP, maks 500KB. Teks penting di tengah.', 'Recommended: 1200x400px (3:1 ratio), JPG/WebP, max 500KB. Keep text centered.'); ?></div>
                <?php endif; ?>
                <input type="file" name="image" class="form-control form-control-sm" accept="image/*">
                <?php if (isset($banner) && $banner->image): ?>
                    <div class="form-text mt-1"><?php echo t('Kosongkan jika tidak ingin mengganti.', 'Leave empty to keep current.'); ?></div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <div class="d-flex gap-2 mt-4">
        <button type="submit" class="btn btn-primary rounded-pill px-4">
            <i class="fas fa-save me-1"></i> <?php echo isset($banner) ? t('Simpan Perubahan', 'Save Changes') : t('Simpan Banner', 'Save Banner'); ?>
        </button>
        <a href="<?php echo base_url('admin/banners'); ?>" class="btn btn-outline-secondary rounded-pill px-4"><?php echo t('Batal', 'Cancel'); ?></a>
    </div>
<?php echo form_close(); ?>
