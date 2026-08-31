    <footer class="fe-footer mt-auto">
        <div class="container fe-footer-inner">
            <div class="row g-4 fe-footer-grid">
                <div class="col-lg-5">
                    <div class="fe-footer-brand">
                        <img src="<?php echo base_url('assets/img/bisatuntas-logo-v2.png'); ?>" alt="<?php echo htmlspecialchars(setting('general_site_name', 'BISATUNTAS')); ?>" style="height:28px;width:auto;">
                    </div>
                    <p class="fe-footer-about">
                        <?php echo htmlspecialchars(t(setting('footer_about_text', 'Platform belajar online modern dengan kelas terstruktur dan seminar interaktif dari para ahli terbaik Indonesia.'), setting('footer_about_text_en', ''))); ?>
                    </p>
                    <div class="fe-social">
                        <?php $social_platforms = array(
                            'instagram' => 'fab fa-instagram',
                            'youtube' => 'fab fa-youtube',
                            'linkedin' => 'fab fa-linkedin-in',
                            'facebook' => 'fab fa-facebook-f',
                            'twitter' => 'fab fa-twitter',
                            'tiktok' => 'fab fa-tiktok',
                        ); ?>
                        <?php foreach ($social_platforms as $platform => $icon): ?>
                            <?php $url = setting('social_' . $platform); if ($url && $url !== '#'): ?>
                                <a href="<?php echo $url; ?>" class="fe-social-link" target="_blank" rel="noopener" aria-label="<?php echo $platform; ?>">
                                    <i class="<?php echo $icon; ?>"></i>
                                </a>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                </div>
                <div class="col-6 col-lg-2">
                    <h6 class="fe-footer-title"><?php echo t('Navigasi', 'Navigation'); ?></h6>
                    <ul class="fe-footer-list">
                        <li><a href="<?php echo base_url(); ?>"><?php echo t('Beranda', 'Home'); ?></a></li>
                        <li><a href="<?php echo base_url('courses'); ?>"><?php echo t('Kelas', 'Courses'); ?></a></li>
                        <li><a href="<?php echo base_url('seminars'); ?>"><?php echo t('Seminar', 'Seminars'); ?></a></li>
                        <li><a href="<?php echo base_url('learning_paths'); ?>"><?php echo t('Learning Paths', 'Paths'); ?></a></li>
                        <li><a href="<?php echo base_url('mentoring'); ?>"><?php echo t('Mentoring', 'Mentoring'); ?></a></li>
                    </ul>
                </div>
                <div class="col-6 col-lg-2">
                    <h6 class="fe-footer-title"><?php echo t('Akun', 'Account'); ?></h6>
                    <ul class="fe-footer-list">
                        <?php if ($this->session->userdata('logged_in')): ?>
                            <li><a href="<?php echo base_url('dashboard'); ?>"><?php echo t('Dashboard', 'Dashboard'); ?></a></li>
                            <li><a href="<?php echo base_url('profile'); ?>"><?php echo t('Profil', 'Profile'); ?></a></li>
                            <li><a href="<?php echo base_url('auth/logout'); ?>"><?php echo t('Keluar', 'Logout'); ?></a></li>
                        <?php else: ?>
                            <li><a href="<?php echo base_url('auth/login'); ?>"><?php echo t('Masuk', 'Login'); ?></a></li>
                            <li><a href="<?php echo base_url('auth/register'); ?>"><?php echo t('Daftar', 'Register'); ?></a></li>
                        <?php endif; ?>
                    </ul>
                </div>
                <div class="col-lg-3">
                    <h6 class="fe-footer-title"><?php echo t('Hubungi Kami', 'Contact'); ?></h6>
                    <ul class="fe-footer-list fe-footer-contact">
                        <li><i class="fas fa-envelope"></i><span><?php echo htmlspecialchars(setting('general_contact_email', 'hello@bisatuntas.com')); ?></span></li>
                        <li><i class="fas fa-phone-alt"></i><span><?php echo htmlspecialchars(setting('general_contact_phone', '021-1234-5678')); ?></span></li>
                        <li><i class="fas fa-map-marker-alt"></i><span><?php echo htmlspecialchars(setting('general_contact_address', 'Jakarta, Indonesia')); ?></span></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="fe-footer-bottom">
            <div class="container fe-footer-bottom-inner">
                <p>&copy; <?php echo date('Y'); ?> <?php echo htmlspecialchars(setting('footer_copyright', 'BISATUNTAS. All rights reserved.')); ?></p>
                <div class="fe-footer-links">
                    <a href="<?php echo base_url('pages/terms'); ?>"><?php echo t('Syarat', 'Terms'); ?></a>
                    <span>·</span>
                    <a href="<?php echo base_url('pages/privacy'); ?>"><?php echo t('Privasi', 'Privacy'); ?></a>
                </div>
            </div>
        </div>
    </footer>

    <style>
        .fe-footer { background: #fff; border-top: 1px solid #e5e5e5; }
        .fe-footer-inner { padding: 2.5rem 1rem 2rem; }
        .fe-footer-brand { display: flex; align-items: center; gap: 8px; font-size: 1rem; font-weight: 700; letter-spacing: -0.03em; color: #171717; margin-bottom: 0.85rem; }
        .fe-footer-about { font-size: 0.8125rem; line-height: 1.6; color: #737373; max-width: 320px; margin-bottom: 1rem; }
        .fe-social { display: flex; gap: 6px; }
        .fe-social-link { width: 32px; height: 32px; display: inline-flex; align-items: center; justify-content: center; border-radius: 6px; background: #fafafa; color: #737373; text-decoration: none; font-size: 0.8rem; transition: all 0.15s; border: 1px solid #f0f0f0; }
        .fe-social-link:hover { background: #059669; color: #fff; border-color: #059669; }
        .fe-footer-title { font-size: 0.72rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.06em; color: #737373; margin-bottom: 0.85rem; }
        .fe-footer-list { list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 0.55rem; }
        .fe-footer-list a { font-size: 0.8125rem; color: #525252; text-decoration: none; transition: color 0.15s; }
        .fe-footer-list a:hover { color: #171717; }
        .fe-footer-contact li { display: flex; align-items: center; gap: 8px; font-size: 0.8125rem; color: #525252; }
        .fe-footer-contact i { width: 14px; font-size: 0.75rem; color: #a3a3a3; }
        .fe-footer-bottom { border-top: 1px solid #f0f0f0; padding: 1rem 0; }
        .fe-footer-bottom-inner { display: flex; align-items: center; justify-content: space-between; gap: 1rem; flex-wrap: wrap; }
        .fe-footer-bottom p { font-size: 0.75rem; color: #a3a3a3; margin: 0; }
        .fe-footer-links { display: flex; align-items: center; gap: 8px; }
        .fe-footer-links a { font-size: 0.75rem; color: #737373; text-decoration: none; }
        .fe-footer-links a:hover { color: #171717; }
        .fe-footer-links span { color: #d4d4d4; font-size: 0.7rem; }
    </style>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
    <script src="<?php echo base_url('assets/js/analytics.js'); ?>"></script>
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
    <script src="<?php echo base_url('assets/js/bisatuntas.js'); ?>"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        var video = document.querySelector('video');
        if (video) {
            video.addEventListener('ended', function() {
                var completeBtn = document.querySelector('.lesson-complete-btn');
                if (completeBtn) completeBtn.click();
            });
        }
        if (typeof lucide !== 'undefined') { try { lucide.createIcons(); } catch(e){} }
    });
    </script>
    <?php $wa_url = setting('social_whatsapp', ''); if ($wa_url && $wa_url !== '#'): ?>
    <a href="<?php echo $wa_url; ?>" target="_blank" class="fe-whatsapp" aria-label="WhatsApp"
       style="position:fixed;bottom:20px;right:20px;width:48px;height:48px;border-radius:50%;background:#25d366;color:#fff;display:flex;align-items:center;justify-content:center;text-decoration:none;box-shadow:0 4px 14px rgba(37,211,102,0.35);z-index:9999;transition:transform 0.2s;"
       onmouseover="this.style.transform='scale(1.06)'" onmouseout="this.style.transform='scale(1)'">
        <i class="fab fa-whatsapp" style="font-size:1.4rem;"></i>
    </a>
    <?php endif; ?>
</body>
</html>
