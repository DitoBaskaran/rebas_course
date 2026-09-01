<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$banners = isset($banners) ? $banners : array();
?>
<?php if (!empty($banners)): ?>
<!-- ===== Banner Carousel (Dashboard) ===== -->
<div class="banner-carousel-wrap">
    <div id="bannerCarousel" class="carousel slide banner-carousel" data-bs-ride="carousel" data-bs-interval="5000">
        <div class="carousel-indicators banner-indicators">
            <?php foreach ($banners as $i => $b): ?>
                <button type="button" data-bs-target="#bannerCarousel" data-bs-slide-to="<?php echo $i; ?>" class="<?php echo $i === 0 ? 'active' : ''; ?>" aria-label="Slide <?php echo $i + 1; ?>"></button>
            <?php endforeach; ?>
        </div>
        <div class="carousel-inner">
            <?php foreach ($banners as $i => $b): ?>
                <?php
                $banner_img = ($b->image && file_exists(FCPATH . 'uploads/banners/' . $b->image))
                    ? base_url('uploads/banners/' . $b->image)
                    : '';
                ?>
                <div class="carousel-item <?php echo $i === 0 ? 'active' : ''; ?>">
                    <?php if ($b->link): ?>
                        <a href="<?php echo htmlspecialchars($b->link); ?>" class="d-block" <?php echo preg_match('/^https?:\/\//', $b->link) ? 'target="_blank" rel="noopener"' : ''; ?>>
                    <?php endif; ?>
                        <?php if ($banner_img): ?>
                            <img src="<?php echo $banner_img; ?>" class="d-block w-100 banner-img" alt="<?php echo htmlspecialchars($b->title); ?>">
                        <?php else: ?>
                            <div class="banner-placeholder d-flex align-items-center justify-content-center">
                                <div class="text-center px-4">
                                    <div class="banner-ph-title"><?php echo htmlspecialchars($b->title); ?></div>
                                    <div class="banner-ph-sub"><?php echo t('BISATUNTAS', 'BISATUNTAS'); ?></div>
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php if ($b->link): ?>
                        </a>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#bannerCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon banner-ctrl" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#bannerCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon banner-ctrl" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
</div>
<?php endif; ?>
