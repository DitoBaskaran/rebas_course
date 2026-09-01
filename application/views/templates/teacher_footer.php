        </div><!-- /.admin-content -->
    </div><!-- /.teacher-wrapper -->

    <!-- Teacher Footer -->
    <div class="admin-footer" id="adminFooter">
        <div class="admin-footer-inner">
            <span class="small text-secondary">&copy; <?php echo date('Y'); ?> <strong>BISATUNTAS</strong></span>
            <span class="small text-secondary">v3.0</span>
        </div>
    </div>

    <!-- Mobile App-Style Bottom Navigation (teacher pages only) -->
    <?php
        $_bn_active = isset($active_page) ? $active_page : '';
    ?>
    <nav class="app-bottom-nav" aria-label="Mobile navigation">
        <div class="app-bottom-nav-inner">
            <a href="<?php echo base_url('teacher/dashboard'); ?>" class="<?php echo $_bn_active === 'dashboard' ? 'active' : ''; ?>">
                <i data-lucide="layout-dashboard"></i>
                <span><?php echo t('Beranda', 'Home'); ?></span>
            </a>
            <a href="<?php echo base_url('teacher/courses'); ?>" class="<?php echo strpos($_bn_active, 'courses') === 0 ? 'active' : ''; ?>">
                <i data-lucide="book-open"></i>
                <span><?php echo t('Kelas', 'Courses'); ?></span>
            </a>
            <a href="<?php echo base_url('teacher/seminars'); ?>" class="<?php echo $_bn_active === 'seminars' ? 'active' : ''; ?>">
                <i data-lucide="calendar"></i>
                <span><?php echo t('Seminar', 'Seminars'); ?></span>
            </a>
            <a href="<?php echo base_url('admin/submissions'); ?>" class="<?php echo $_bn_active === 'submissions' ? 'active' : ''; ?>">
                <i data-lucide="code"></i>
                <span><?php echo t('Tugas', 'Tasks'); ?></span>
            </a>
            <a href="<?php echo base_url('profile'); ?>" class="<?php echo $_bn_active === 'profile' ? 'active' : ''; ?>">
                <i data-lucide="user"></i>
                <span><?php echo t('Profil', 'Profile'); ?></span>
            </a>
        </div>
    </nav>

    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
    <!-- GSAP -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Bootstrap 5 Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <?php if (isset($load_aos) && $load_aos): ?>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <?php endif; ?>
    <?php if (isset($load_chartjs) && $load_chartjs): ?>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
    <?php endif; ?>
    <!-- BISATUNTAS JS -->
    <script src="<?php echo base_url('assets/js/bisatuntas.js?v=6'); ?>"></script>
</body>
</html>