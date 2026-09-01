<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$banners = isset($banners) ? $banners : array();
?>
<?php if (!empty($banners)): ?>
<!-- ===== Banner Carousel (Gaya Tokopedia/Shopee) ===== -->
<div class="tp-carousel" id="tpBannerCarousel">
    <div class="carousel slide tp-carousel-inner" data-bs-ride="carousel" data-bs-interval="4500" data-bs-wrap="true">
        <div class="carousel-inner tp-slides">
            <?php foreach ($banners as $i => $b): ?>
                <?php
                $banner_img = ($b->image && file_exists(FCPATH . 'uploads/banners/' . $b->image))
                    ? base_url('uploads/banners/' . $b->image)
                    : '';
                ?>
                <div class="carousel-item <?php echo $i === 0 ? 'active' : ''; ?>">
                    <?php if ($b->link): ?>
                        <a href="<?php echo htmlspecialchars($b->link); ?>" class="d-block tp-slide-link" <?php echo preg_match('/^https?:\/\//', $b->link) ? 'target="_blank" rel="noopener"' : ''; ?>>
                    <?php endif; ?>
                        <?php if ($banner_img): ?>
                            <img src="<?php echo $banner_img; ?>" class="d-block w-100 tp-banner-img" alt="<?php echo htmlspecialchars($b->title); ?>" loading="lazy">
                        <?php else: ?>
                            <div class="tp-banner-placeholder d-flex align-items-center justify-content-center">
                                <div class="text-center px-4">
                                    <div class="tp-ph-title"><?php echo htmlspecialchars($b->title); ?></div>
                                    <div class="tp-ph-sub">BISATUNTAS</div>
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php if ($b->link): ?>
                        </a>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Dots di kiri bawah (khas Tokopedia) -->
        <div class="tp-dots">
            <?php foreach ($banners as $i => $b): ?>
                <button type="button" data-bs-target="#tpBannerCarousel" data-bs-slide-to="<?php echo $i; ?>" class="<?php echo $i === 0 ? 'active' : ''; ?>" aria-label="Slide <?php echo $i + 1; ?>"></button>
            <?php endforeach; ?>
        </div>

        <!-- Panah kiri/kanan (muncul saat hover di desktop) -->
        <button class="carousel-control-prev tp-arrow tp-arrow-prev" type="button" data-bs-target="#tpBannerCarousel" data-bs-slide="prev">
            <span class="tp-arrow-ic" aria-hidden="true"><i class="fas fa-chevron-left"></i></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next tp-arrow tp-arrow-next" type="button" data-bs-target="#tpBannerCarousel" data-bs-slide="next">
            <span class="tp-arrow-ic" aria-hidden="true"><i class="fas fa-chevron-right"></i></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
</div>
<?php endif; ?>
