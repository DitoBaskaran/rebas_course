<div class="container-fluid py-4" style="padding-top: 0px !important; max-width: 1200px;">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h4 class="fw-extrabold mb-1" style="color: #1c1917; letter-spacing: -0.02em; font-size: 1.3rem;">
                <?php echo t('Wishlist Saya', 'My Wishlist'); ?>
            </h4>
            <p style="color: #78716c; font-size: 0.82rem; margin-bottom: 0;">
                <?php echo t('Kursus yang kamu simpan.', 'Courses you have saved.'); ?>
            </p>
        </div>
        <a href="<?php echo base_url('courses'); ?>" class="btn px-3 py-2 fw-semibold rounded-pill" style="background: #f97316; color: #fff; font-size: 0.8rem;">
            <i class="fas fa-search me-1"></i> <?php echo t('Cari Kursus', 'Browse Courses'); ?>
        </a>
    </div>

    <?php if (empty($wishlists)): ?>
    <!-- Empty State -->
    <div class="border rounded-3 p-5 text-center" style="border-color: #e7e5e4; border-radius: 12px;">
        <div style="font-size: 2rem; color: #d6d3d1; margin-bottom: 0.75rem;">
            <i class="fas fa-heart"></i>
        </div>
        <h5 class="fw-bold" style="color: #1c1917; margin-bottom: 0.375rem;">
            <?php echo t('Belum Ada Wishlist', 'No Wishlist Yet'); ?>
        </h5>
        <p style="color: #78716c; font-size: 0.85rem; max-width: 350px; margin: 0 auto 1rem;">
            <?php echo t('Klik icon hati pada kursus untuk menyimpannya dan akses cepat kapan saja.', 'Click the heart icon on courses to save them for quick access anytime.'); ?>
        </p>
        <a href="<?php echo base_url('courses'); ?>" class="btn px-4 py-2 fw-bold rounded-pill" style="background: #f97316; color: #fff; font-size: 0.85rem;">
            <i class="fas fa-search me-1"></i> <?php echo t('Jelajahi Kursus', 'Browse Courses'); ?>
        </a>
    </div>

    <?php else: ?>
    <!-- Course Grid -->
    <div class="row g-3">
        <?php foreach ($wishlists as $c): ?>
            <div class="col-md-6 col-lg-4">
                <div class="border rounded-3 h-100 d-flex flex-column" style="border-color: #e7e5e4; border-radius: 12px; transition: all 0.15s; position: relative; background: #fff;">
                    <!-- Thumbnail -->
                    <div class="position-relative overflow-hidden" style="aspect-ratio: 16/9; border-radius: 12px 12px 0 0;">
                        <img src="<?php echo base_url('uploads/courses/' . $c->thumbnail); ?>" onerror="this.src='https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=400&auto=format&fit=crop&q=60';" alt="" class="w-100 h-100" style="object-fit: cover;">
                        <!-- Remove button -->
                        <button onclick="toggleWishlist('<?php echo $c->slug; ?>')" class="btn d-flex align-items-center justify-content-center position-absolute" style="top: 8px; right: 8px; width: 30px; height: 30px; border-radius: 50%; background: rgba(255,255,255,0.9); border: none; color: #f43f5e; padding: 0; cursor: pointer;">
                            <i class="fas fa-heart" style="font-size: 0.75rem;"></i>
                        </button>
                        <!-- Type badge -->
                        <span class="position-absolute px-2 py-1 rounded-pill fw-semibold" style="bottom: 8px; left: 8px; background: #1c1917; color: #fff; font-size: 0.6rem;">
                            <?php echo content_type_label($c->content_type); ?>
                        </span>
                    </div>

                    <!-- Content -->
                    <div class="card-body p-3 d-flex flex-column" style="flex: 1;">
                        <div class="d-flex align-items-center gap-2 mb-1" style="color: #78716c; font-size: 0.7rem;">
                            <?php if ($c->category_name): ?>
                                <span><i class="fas fa-folder me-1" style="font-size: 0.55rem;"></i><?php echo htmlspecialchars($c->category_name); ?></span>
                                <span style="color: #e7e5e4;">·</span>
                            <?php endif; ?>
                            <span><i class="fas fa-signal me-1" style="font-size: 0.55rem;"></i><?php echo skill_level_label($c->skill_level); ?></span>
                        </div>

                        <h6 class="fw-bold mb-2 lh-sm" style="color: #1c1917; font-size: 0.85rem; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                            <?php echo htmlspecialchars($c->title); ?>
                        </h6>

                        <div class="mt-auto pt-2 d-flex align-items-center justify-content-between" style="border-top: 1px solid #f0eeeb;">
                            <span class="fw-bold" style="color: #f97316; font-size: 0.8rem;">
                                <?php echo $c->price > 0 ? 'Rp ' . number_format($c->price, 0, ',', '.') : '<span style="color: #14b8a6;">' . t('Gratis', 'Free') . '</span>'; ?>
                            </span>
                            <a href="<?php echo base_url('courses/detail/' . $c->slug); ?>" class="btn btn-sm fw-bold rounded-pill px-3" style="background: #f97316; color: #fff; font-size: 0.72rem;">
                                <i class="fas fa-eye me-1" style="font-size: 0.6rem;"></i> <?php echo t('Detail', 'Detail'); ?>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>
</div>

<script>
function toggleWishlist(id) {
    fetch('<?php echo base_url('wishlist/toggle/'); ?>' + id)
        .then(function(r) { return r.json(); })
        .then(function(d) { if (d.status) location.reload(); });
}
</script>
