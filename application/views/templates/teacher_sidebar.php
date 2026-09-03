<div class="admin-sidebar playful" id="adminSidebar">
    <?php $active_page = isset($active_page) ? $active_page : ''; ?>
    <?php $sidebar_is_mentor = $this->session->userdata('is_mentor'); ?>
    <div class="sidebar-heading"><?php echo t('Menu Guru', 'Teacher Menu'); ?></div>
    <a class="nav-link <?php echo $active_page === 'dashboard' ? 'active' : ''; ?>" href="<?php echo base_url('teacher/dashboard'); ?>">
        <i data-lucide="layout-dashboard"></i> <span><?php echo t('Dashboard', 'Dashboard'); ?></span>
    </a>
    <?php if ($this->access_library->can('courses', 'read')): ?>
    <a class="nav-link <?php echo strpos($active_page, 'courses') === 0 ? 'active' : ''; ?>" href="<?php echo base_url('teacher/courses'); ?>">
        <i data-lucide="book-open"></i> <span><?php echo t('Kelas', 'Courses'); ?></span>
    </a>
    <?php endif; ?>
    <?php if ($this->access_library->can('seminars', 'read')): ?>
    <a class="nav-link <?php echo $active_page === 'seminars' ? 'active' : ''; ?>" href="<?php echo base_url('teacher/seminars'); ?>">
        <i data-lucide="calendar"></i> <span><?php echo t('Seminar', 'Seminars'); ?></span>
    </a>
    <?php endif; ?>
    <?php if ($this->access_library->can('submissions', 'read')): ?>
    <a class="nav-link <?php echo $active_page === 'submissions' ? 'active' : ''; ?>" href="<?php echo base_url('teacher/submissions'); ?>">
        <i data-lucide="code"></i> <span><?php echo t('Tugas', 'Submissions'); ?></span>
    </a>
    <?php endif; ?>

    <?php if ($sidebar_is_mentor && $this->access_library->can('mentoring', 'read')): ?>
    <div class="sidebar-section-divider"></div>
    <div class="sidebar-heading"><?php echo t('Mentoring', 'Mentoring'); ?></div>
    <a class="nav-link <?php echo $active_page === 'dashboard_mentor' ? 'active' : ''; ?>" href="<?php echo base_url('mentor'); ?>">
        <i data-lucide="calendar-check"></i> <span><?php echo t('Dashboard Mentor', 'Mentor Dashboard'); ?></span>
    </a>
    <?php if ($this->access_library->can('mentoring', 'create') || $this->access_library->can('mentoring', 'update')): ?>
    <a class="nav-link <?php echo $active_page === 'availability' ? 'active' : ''; ?>" href="<?php echo base_url('mentor/availability'); ?>">
        <i data-lucide="clock"></i> <span><?php echo t('Jadwal', 'Schedule'); ?></span>
    </a>
    <?php endif; ?>
    <a class="nav-link <?php echo $active_page === 'sessions' ? 'active' : ''; ?>" href="<?php echo base_url('mentor/sessions'); ?>">
        <i data-lucide="list"></i> <span><?php echo t('Sesi Masuk', 'Sessions'); ?></span>
    </a>
    <?php endif; ?>

    <div class="sidebar-section-divider"></div>
    <div class="sidebar-heading"><?php echo t('Akun', 'Account'); ?></div>
    <a class="nav-link <?php echo $active_page === 'profile' ? 'active' : ''; ?>" href="<?php echo base_url('profile'); ?>">
        <i data-lucide="user-circle"></i> <span><?php echo t('Profil Saya', 'My Profile'); ?></span>
    </a>
    <a class="nav-link <?php echo $active_page === 'affiliate' ? 'active' : ''; ?>" href="<?php echo base_url('affiliate'); ?>">
        <i data-lucide="gift"></i> <span><?php echo t('Affiliate', 'Affiliate'); ?></span>
    </a>

    <button class="sidebar-collapse-btn" title="Collapse sidebar">
        <i data-lucide="chevron-left" style="width:18px;height:18px;"></i>
    </button>
</div>
<div class="admin-sidebar-overlay playful" id="sidebarOverlay"></div>