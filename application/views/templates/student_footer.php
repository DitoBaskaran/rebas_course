        </div><!-- /.admin-content -->
    </div><!-- /.admin-wrapper -->

    <!-- Student Footer -->
    <div class="admin-footer" id="studentFooter">
        <div class="admin-footer-inner">
            <span class="small text-secondary">&copy; <?php echo date('Y'); ?> <strong>BISATUNTAS</strong></span>
            <span class="small text-secondary">v3.0</span>
        </div>
    </div>

    <!-- Mobile App-Style Bottom Navigation (student pages only) -->
    <?php
        $_bn_role = $this->session->userdata('role');
        $_bn_is_teacher = $this->session->userdata('is_teacher');
        $_bn_is_mentor = $this->session->userdata('is_mentor');
        if ($_bn_is_mentor) $_bn_dash_url = 'mentor';
        elseif ($_bn_role === 'admin') $_bn_dash_url = 'admin/dashboard';
        elseif ($_bn_is_teacher) $_bn_dash_url = 'teacher/dashboard';
        else $_bn_dash_url = 'dashboard';
        $_bn_active = isset($active_page) ? $active_page : '';
    ?>
    <nav class="app-bottom-nav" aria-label="Mobile navigation">
        <div class="app-bottom-nav-inner">
            <a href="<?php echo base_url($_bn_dash_url); ?>" class="<?php echo in_array($_bn_active, array('dashboard', 'dashboard_mobile')) ? 'active' : ''; ?>">
                <i data-lucide="layout-dashboard"></i>
                <span><?php echo t('Beranda', 'Home'); ?></span>
            </a>
            <a href="<?php echo base_url('courses/mine'); ?>" class="<?php echo $_bn_active === 'my_courses' ? 'active' : ''; ?>">
                <i data-lucide="book-open"></i>
                <span><?php echo t('Kelas', 'Courses'); ?></span>
            </a>
            <a href="<?php echo base_url('mentoring'); ?>" class="<?php echo $_bn_active === 'mentoring' ? 'active' : ''; ?>">
                <i data-lucide="calendar-check"></i>
                <span><?php echo t('Mentor', 'Mentor'); ?></span>
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
    <!-- Bootstrap 5 Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- BISATUNTAS JS -->
    <script src="<?php echo base_url('assets/js/bisatuntas.js'); ?>"></script>
</body>
</html>
