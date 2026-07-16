<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <url><loc><?php echo base_url(); ?></loc><priority>1.0</priority></url>
    <url><loc><?php echo base_url('courses'); ?></loc><priority>0.9</priority></url>
    <url><loc><?php echo base_url('seminars'); ?></loc><priority>0.8</priority></url>
    <url><loc><?php echo base_url('learning_paths'); ?></loc><priority>0.7</priority></url>
    <url><loc><?php echo base_url('about'); ?></loc><priority>0.6</priority></url>
    <url><loc><?php echo base_url('contact'); ?></loc><priority>0.6</priority></url>
    <url><loc><?php echo base_url('faq'); ?></loc><priority>0.6</priority></url>
    <url><loc><?php echo base_url('pricing'); ?></loc><priority>0.8</priority></url>
    <url><loc><?php echo base_url('blog'); ?></loc><priority>0.7</priority></url>
    <?php if (!empty($courses)): foreach ($courses as $c): ?>
    <url><loc><?php echo base_url('courses/detail/' . $c->slug); ?></loc><priority>0.6</priority></url>
    <?php endforeach; endif; ?>
    <?php if (!empty($seminars)): foreach ($seminars as $s): ?>
    <url><loc><?php echo base_url('seminars/detail/' . encode_id($s->id)); ?></loc><priority>0.5</priority></url>
    <?php endforeach; endif; ?>
    <?php if (!empty($categories)): foreach ($categories as $cat): ?>
    <url><loc><?php echo base_url('courses?category=' . $cat->id); ?></loc><priority>0.4</priority></url>
    <?php endforeach; endif; ?>
</urlset>
