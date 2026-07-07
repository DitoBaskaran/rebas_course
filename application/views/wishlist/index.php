<div class="container py-5 my-4">
    <div class="d-flex align-items-center justify-content-between mb-5">
        <div>
            <h1 class="display-6 fw-extrabold text-dark mb-1" style="letter-spacing:-0.03em;"><?php echo t('Wishlist Saya', 'My Wishlist'); ?></h1>
            <p class="text-secondary mb-0"><?php echo t('Kursus yang Anda simpan.', 'Courses you have saved.'); ?></p>
        </div>
    </div>
    <?php if (empty($wishlists)): ?>
        <div class="bento-card text-center py-5">
            <i data-lucide="heart" style="width:48px;height:48px;color:var(--gray-300);margin-bottom:1rem;"></i>
            <h5><?php echo t('Belum ada wishlist.', 'No wishlist yet.'); ?></h5>
            <p class="text-muted small"><?php echo t('Klik icon hati di kursus untuk menyimpannya.', 'Click the heart icon on courses to save them.'); ?></p>
            <a href="<?php echo base_url('courses'); ?>" class="btn btn-dark rounded-pill px-4 mt-2"><?php echo t('Jelajahi Kursus', 'Browse Courses'); ?></a>
        </div>
    <?php else: ?>
        <div class="bento-grid bento-grid-3">
            <?php foreach ($wishlists as $c): ?>
                <div class="content-card">
                    <div class="card-thumb">
                        <img src="<?php echo base_url('uploads/courses/' . $c->thumbnail); ?>" onerror="this.src='https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=400&auto=format&fit=crop&q=60';" alt="">
                        <button class="btn btn-sm position-absolute top-0 end-0 m-2" onclick="toggleWishlist('<?php echo $c->slug; ?>')" style="background:rgba(255,255,255,0.9);border-radius:50%;width:32px;height:32px;">
                            <i data-lucide="heart" style="width:16px;height:16px;fill:var(--danger);color:var(--danger);"></i>
                        </button>
                    </div>
                    <div class="card-body-custom">
                        <div class="card-meta"><span><?php echo htmlspecialchars($c->category_name ?? ''); ?></span><span class="dot"></span><span><?php echo skill_level_label($c->skill_level); ?></span></div>
                        <div class="card-title"><?php echo htmlspecialchars($c->title); ?></div>
                        <div class="d-flex justify-content-between align-items-center mt-auto pt-2 border-top">
                            <span class="card-price"><?php echo $c->price > 0 ? 'Rp ' . number_format($c->price, 0, ',', '.') : t('Gratis', 'Free'); ?></span>
                            <a href="<?php echo base_url('courses/detail/' . $c->slug); ?>" class="btn btn-dark btn-sm rounded-pill px-3"><?php echo t('Detail', 'Detail'); ?></a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>
<script>
function toggleWishlist(id) {
    fetch('<?php echo base_url('wishlist/toggle/'); ?>' + id).then(function() { location.reload(); });
}
</script>
