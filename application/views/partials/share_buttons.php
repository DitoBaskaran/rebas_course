<div class="d-flex align-items-center gap-2">
    <span class="small text-muted fw-semibold me-1"><?php echo t('Bagikan:', 'Share:'); ?></span>
    <?php
    $share_url = isset($share_url) ? urlencode($share_url) : urlencode(current_url());
    $share_text = isset($share_text) ? urlencode($share_text) : urlencode($title ?? setting('general_site_name', 'REBAS COURSE'));
    $share_image = isset($share_image) ? urlencode($share_image) : '';
    ?>
    <a href="https://www.facebook.com/sharer.php?u=<?php echo $share_url; ?>" target="_blank" class="btn btn-sm btn-outline-secondary rounded-circle" style="width:32px;height:32px;" data-track-share="<?php echo $share_url; ?>" data-track-platform="facebook" title="Facebook">
        <i data-lucide="facebook" style="width:14px;height:14px;"></i>
    </a>
    <a href="https://twitter.com/intent/tweet?text=<?php echo $share_text; ?>&url=<?php echo $share_url; ?>" target="_blank" class="btn btn-sm btn-outline-secondary rounded-circle" style="width:32px;height:32px;" data-track-share="<?php echo $share_url; ?>" data-track-platform="twitter" title="Twitter">
        <i data-lucide="twitter" style="width:14px;height:14px;"></i>
    </a>
    <a href="https://wa.me/?text=<?php echo $share_text . '%20' . $share_url; ?>" target="_blank" class="btn btn-sm btn-outline-secondary rounded-circle" style="width:32px;height:32px;" data-track-share="<?php echo $share_url; ?>" data-track-platform="whatsapp" title="WhatsApp">
        <i data-lucide="message-circle" style="width:14px;height:14px;"></i>
    </a>
    <a href="https://www.linkedin.com/sharing/share-offsite/?url=<?php echo $share_url; ?>" target="_blank" class="btn btn-sm btn-outline-secondary rounded-circle" style="width:32px;height:32px;" data-track-share="<?php echo $share_url; ?>" data-track-platform="linkedin" title="LinkedIn">
        <i data-lucide="linkedin" style="width:14px;height:14px;"></i>
    </a>
</div>
