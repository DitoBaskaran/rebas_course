    <!-- Footer — Dealls-style -->
    <footer class="bg-white mt-auto" style="border-top: 1px solid #e5e5e5;">
        <div class="container py-4">
            <div class="row g-4">
                <div class="col-lg-4">
                    <div class="fw-bold text-dark mb-3" style="font-size: 1rem; letter-spacing: -0.02em;">
                        <?php echo htmlspecialchars(setting('general_site_name', 'BISATUNTAS')); ?>
                    </div>
                    <p class="small mb-4" style="color: #737373; line-height: 1.6; max-width: 320px;">
                        <?php echo htmlspecialchars(t(setting('footer_about_text', 'Platform belajar online modern dengan kelas terstruktur dan seminar interaktif dari para ahli terbaik Indonesia.'), setting('footer_about_text_en', ''))); ?>
                    </p>
                    <div class="d-flex gap-2">
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
                                <a href="<?php echo $url; ?>" class="d-flex align-items-center justify-content-center rounded-circle text-decoration-none" style="width: 34px; height: 34px; background: #f5f5f5; color: #737373; transition: all 0.15s;" target="_blank" rel="noopener">
                                    <i class="<?php echo $icon; ?>" style="font-size: 0.85rem;"></i>
                                </a>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                </div>
                <div class="col-6 col-lg-2">
                    <h6 class="fw-bold text-dark mb-3" style="font-size: 0.8rem; letter-spacing: 0.02em;"><?php echo t('Navigasi', 'Navigation'); ?></h6>
                    <ul class="list-unstyled small d-flex flex-column gap-2">
                        <li><a href="<?php echo base_url(); ?>" style="color: #737373; text-decoration: none; transition: color 0.15s;" onmouseover="this.style.color='#111827'" onmouseout="this.style.color='#737373'"><?php echo t('Beranda', 'Home'); ?></a></li>
                        <li><a href="<?php echo base_url('courses'); ?>" style="color: #737373; text-decoration: none; transition: color 0.15s;" onmouseover="this.style.color='#111827'" onmouseout="this.style.color='#737373'"><?php echo t('Kelas', 'Courses'); ?></a></li>
                        <li><a href="<?php echo base_url('seminars'); ?>" style="color: #737373; text-decoration: none; transition: color 0.15s;" onmouseover="this.style.color='#111827'" onmouseout="this.style.color='#737373'"><?php echo t('Seminar', 'Seminars'); ?></a></li>
                        <li><a href="<?php echo base_url('learning_paths'); ?>" style="color: #737373; text-decoration: none; transition: color 0.15s;" onmouseover="this.style.color='#111827'" onmouseout="this.style.color='#737373'"><?php echo t('Learning Paths', 'Paths'); ?></a></li>
                        <li><a href="<?php echo base_url('mentoring'); ?>" style="color: #737373; text-decoration: none; transition: color 0.15s;" onmouseover="this.style.color='#111827'" onmouseout="this.style.color='#737373'"><?php echo t('Mentoring', 'Mentoring'); ?></a></li>
                    </ul>
                </div>
                <div class="col-6 col-lg-2">
                    <h6 class="fw-bold text-dark mb-3" style="font-size: 0.8rem; letter-spacing: 0.02em;"><?php echo t('Akun', 'Account'); ?></h6>
                    <ul class="list-unstyled small d-flex flex-column gap-2">
                        <?php if ($this->session->userdata('logged_in')): ?>
                            <li><a href="<?php echo base_url('dashboard'); ?>" style="color: #737373; text-decoration: none; transition: color 0.15s;" onmouseover="this.style.color='#111827'" onmouseout="this.style.color='#737373'"><?php echo t('Dashboard', 'Dashboard'); ?></a></li>
                            <li><a href="<?php echo base_url('profile'); ?>" style="color: #737373; text-decoration: none; transition: color 0.15s;" onmouseover="this.style.color='#111827'" onmouseout="this.style.color='#737373'"><?php echo t('Profil', 'Profile'); ?></a></li>
                            <li><a href="<?php echo base_url('auth/logout'); ?>" style="color: #737373; text-decoration: none; transition: color 0.15s;" onmouseover="this.style.color='#111827'" onmouseout="this.style.color='#737373'"><?php echo t('Keluar', 'Logout'); ?></a></li>
                        <?php else: ?>
                            <li><a href="<?php echo base_url('auth/login'); ?>" style="color: #737373; text-decoration: none; transition: color 0.15s;" onmouseover="this.style.color='#111827'" onmouseout="this.style.color='#737373'"><?php echo t('Masuk', 'Login'); ?></a></li>
                            <li><a href="<?php echo base_url('auth/register'); ?>" style="color: #737373; text-decoration: none; transition: color 0.15s;" onmouseover="this.style.color='#111827'" onmouseout="this.style.color='#737373'"><?php echo t('Daftar', 'Register'); ?></a></li>
                        <?php endif; ?>
                    </ul>
                </div>
                <div class="col-lg-4">
                    <h6 class="fw-bold text-dark mb-3" style="font-size: 0.8rem; letter-spacing: 0.02em;"><?php echo t('Hubungi Kami', 'Contact Us'); ?></h6>
                    <ul class="list-unstyled small d-flex flex-column gap-2" style="color: #737373;">
                        <li class="d-flex align-items-center gap-2">
                            <i class="fas fa-envelope" style="width: 14px;"></i>
                            <span><?php echo htmlspecialchars(setting('general_contact_email', 'hello@bisatuntas.com')); ?></span>
                        </li>
                        <li class="d-flex align-items-center gap-2">
                            <i class="fas fa-phone-alt" style="width: 14px;"></i>
                            <span><?php echo htmlspecialchars(setting('general_contact_phone', '021-1234-5678')); ?></span>
                        </li>
                        <li class="d-flex align-items-center gap-2">
                            <i class="fas fa-map-marker-alt" style="width: 14px;"></i>
                            <span><?php echo htmlspecialchars(setting('general_contact_address', 'Jakarta, Indonesia')); ?></span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="border-top" style="border-color: #e5e5e5;">
            <div class="container py-3">
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-2">
                    <p class="small mb-0" style="color: #a3a3a3;">
                        &copy; <?php echo date('Y'); ?> <?php echo htmlspecialchars(setting('footer_copyright', 'BISATUNTAS. All rights reserved.')); ?>
                    </p>
                    <p class="small mb-0" style="color: #a3a3a3;">
                        <?php echo t('Dibuat dengan', 'Made with'); ?> <i class="fas fa-heart" style="color: #eab308;"></i> <?php echo t('untuk pendidikan', 'for education'); ?>
                    </p>
                </div>
            </div>
        </div>
    </footer>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Bootstrap 5 Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- AOS - Animate On Scroll -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
    <!-- Analytics JS -->
    <script src="<?php echo base_url('assets/js/analytics.js'); ?>"></script>
    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
    <!-- REBAS JS -->
    <script src="<?php echo base_url('assets/js/rebas.js'); ?>"></script>
    <script>
    // Auto-mark video lesson as complete when video ends
    document.addEventListener('DOMContentLoaded', function() {
        var video = document.querySelector('video');
        if (video) {
            video.addEventListener('ended', function() {
                var completeBtn = document.querySelector('.lesson-complete-btn');
                if (completeBtn) completeBtn.click();
            });
        }
    });
    </script>
    <style>
        .text-white-50 { color: rgba(255,255,255,0.5) !important; }
    </style>
<script>
// Frontend Dark Mode
(function() {
    var btn = document.getElementById('frontendThemeToggle');
    var html = document.documentElement;
    var saved = localStorage.getItem('rebas-theme');
    if (saved === 'dark') {
        html.setAttribute('data-theme', 'dark');
        document.querySelector('#frontendThemeToggle .moon-icon').style.display = 'none';
        document.querySelector('#frontendThemeToggle .sun-icon').style.display = 'block';
    }
    if (btn) {
        btn.addEventListener('click', function() {
            var isDark = html.getAttribute('data-theme') === 'dark';
            if (isDark) {
                html.removeAttribute('data-theme');
                localStorage.setItem('rebas-theme', 'light');
                document.querySelector('#frontendThemeToggle .moon-icon').style.display = 'block';
                document.querySelector('#frontendThemeToggle .sun-icon').style.display = 'none';
            } else {
                html.setAttribute('data-theme', 'dark');
                localStorage.setItem('rebas-theme', 'dark');
                document.querySelector('#frontendThemeToggle .moon-icon').style.display = 'none';
                document.querySelector('#frontendThemeToggle .sun-icon').style.display = 'block';
            }
        });
    }
})();
</script>
    <!-- WhatsApp FAB -->
    <?php $wa_url = setting('social_whatsapp', ''); if ($wa_url && $wa_url !== '#'): ?>
    <a href="<?php echo $wa_url; ?>" target="_blank" class="whatsapp-fab" style="position:fixed;bottom:24px;right:24px;width:56px;height:56px;border-radius:50%;background:#25d366;color:#fff;display:flex;align-items:center;justify-content:center;text-decoration:none;box-shadow:0 4px 16px rgba(37,211,102,0.4);z-index:9999;transition:transform 0.2s;" onmouseover="this.style.transform='scale(1.1)'" onmouseout="this.style.transform='scale(1)'">
        <i data-lucide="message-circle" style="width:24px;height:24px;color:#fff;"></i>
    </a>
    <?php endif; ?>
</body>
</html>
