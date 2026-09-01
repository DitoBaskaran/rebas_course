<div class="admin-sidebar playful" id="adminSidebar">
    <?php $active_page = isset($active_page) ? $active_page : ''; ?>
    <?php $sidebar_role = $this->session->userdata('role'); ?>
    <div class="sidebar-heading"><?php echo t('Menu Utama', 'Main Menu'); ?></div>
    <a class="nav-link <?php echo $active_page === 'dashboard' ? 'active' : ''; ?>" href="<?php echo base_url('admin/dashboard'); ?>">
        <i data-lucide="layout-dashboard"></i> <span><?php echo t('Dashboard', 'Dashboard'); ?></span>
    </a>
    <?php if ($sidebar_role === 'admin'): ?>
    <a class="nav-link <?php echo $active_page === 'analytics' ? 'active' : ''; ?>" href="<?php echo base_url('admin/analytics'); ?>">
        <i data-lucide="bar-chart-3"></i> <span><?php echo t('Analitik', 'Analytics'); ?></span>
    </a>
    <?php endif; ?>
    <a class="nav-link <?php echo strpos($active_page, 'courses') === 0 ? 'active' : ''; ?>" href="<?php echo base_url('admin/courses'); ?>">
        <i data-lucide="book-open"></i> <span><?php echo t('Kelas', 'Courses'); ?></span>
    </a>
    <a class="nav-link <?php echo $active_page === 'seminars' ? 'active' : ''; ?>" href="<?php echo base_url('admin/seminars'); ?>">
        <i data-lucide="calendar"></i> <span><?php echo t('Seminar', 'Seminars'); ?></span>
    </a>
    <?php if ($sidebar_role === 'admin'): ?>
    <a class="nav-link <?php echo $active_page === 'learning_paths' ? 'active' : ''; ?>" href="<?php echo base_url('admin/learning_paths'); ?>">
        <i data-lucide="route"></i> <span><?php echo t('Learning Paths', 'Paths'); ?></span>
    </a>
    <a class="nav-link <?php echo $active_page === 'transactions' ? 'active' : ''; ?>" href="<?php echo base_url('admin/transactions'); ?>">
        <i data-lucide="receipt"></i> <span><?php echo t('Transaksi', 'Transactions'); ?></span>
    </a>
    <a class="nav-link <?php echo $active_page === 'tags' ? 'active' : ''; ?>" href="<?php echo base_url('admin/tags'); ?>">
        <i data-lucide="tags"></i> <span><?php echo t('Tags', 'Tags'); ?></span>
    </a>
    <a class="nav-link <?php echo $active_page === 'coupons' ? 'active' : ''; ?>" href="<?php echo base_url('admin/coupons'); ?>">
        <i data-lucide="ticket"></i> <span><?php echo t('Kupon', 'Coupons'); ?></span>
    </a>
    <a class="nav-link <?php echo $active_page === 'packages' ? 'active' : ''; ?>" href="<?php echo base_url('admin/packages'); ?>">
        <i data-lucide="layers"></i> <span><?php echo t('Paket Langganan', 'Subscription Packages'); ?></span>
    </a>
    <a class="nav-link <?php echo $active_page === 'banners' ? 'active' : ''; ?>" href="<?php echo base_url('admin/banners'); ?>">
        <i data-lucide="image"></i> <span><?php echo t('Banner Dashboard', 'Dashboard Banners'); ?></span>
    </a>
    <a class="nav-link <?php echo $active_page === 'users' ? 'active' : ''; ?>" href="<?php echo base_url('admin/users'); ?>">
        <i data-lucide="users"></i> <span><?php echo t('Pengguna', 'Users'); ?></span>
    </a>
    <?php endif; ?>
    <a class="nav-link <?php echo $active_page === 'submissions' ? 'active' : ''; ?>" href="<?php echo base_url('admin/submissions'); ?>">
        <i data-lucide="code"></i> <span><?php echo t('Tugas', 'Submissions'); ?></span>
    </a>
    <?php if ($this->session->userdata('is_mentor')): ?>
    <div class="sidebar-section-divider"></div>
    <div class="sidebar-heading"><?php echo t('Mentoring', 'Mentoring'); ?></div>
    <a class="nav-link <?php echo $active_page === 'dashboard_mentor' ? 'active' : ''; ?>" href="<?php echo base_url('mentor'); ?>">
        <i data-lucide="calendar-check"></i> <span><?php echo t('Dashboard Mentor', 'Mentor Dashboard'); ?></span>
    </a>
    <a class="nav-link <?php echo $active_page === 'availability' ? 'active' : ''; ?>" href="<?php echo base_url('mentor/availability'); ?>">
        <i data-lucide="clock"></i> <span><?php echo t('Jadwal', 'Schedule'); ?></span>
    </a>
    <a class="nav-link <?php echo $active_page === 'sessions' ? 'active' : ''; ?>" href="<?php echo base_url('mentor/sessions'); ?>">
        <i data-lucide="list"></i> <span><?php echo t('Sesi Masuk', 'Sessions'); ?></span>
    </a>
    <?php endif; ?>
    <?php if ($sidebar_role === 'admin'): ?>
    <a class="nav-link <?php echo $active_page === 'mentoring' ? 'active' : ''; ?>" href="<?php echo base_url('admin/mentoring'); ?>">
        <i data-lucide="calendar-check"></i> <span><?php echo t('Mentoring', 'Mentoring'); ?></span>
    </a>
    <a class="nav-link <?php echo $active_page === 'translations' ? 'active' : ''; ?>" href="<?php echo base_url('admin/translations'); ?>">
        <i data-lucide="languages"></i> <span><?php echo t('Translasi', 'Translations'); ?></span>
    </a>
    <a class="nav-link <?php echo $active_page === 'documents' ? 'active' : ''; ?>" href="<?php echo base_url('admin/documents'); ?>">
        <i data-lucide="file-text"></i> <span><?php echo t('Dokumen', 'Documents'); ?></span>
    </a>
    <?php endif; ?>

    <?php if ($sidebar_role === 'admin'): ?>
    <div class="sidebar-section-divider"></div>
    <div class="sidebar-heading"><?php echo t('Pengaturan', 'Settings'); ?></div>
    <a class="nav-link <?php echo strpos($active_page, 'settings-general') === 0 ? 'active' : ''; ?>" href="<?php echo base_url('admin/settings/general'); ?>">
        <i data-lucide="settings"></i> <span><?php echo t('Umum', 'General'); ?></span>
    </a>
    <a class="nav-link <?php echo strpos($active_page, 'settings-appearance') === 0 ? 'active' : ''; ?>" href="<?php echo base_url('admin/settings/appearance'); ?>">
        <i data-lucide="palette"></i> <span><?php echo t('Tampilan', 'Appearance'); ?></span>
    </a>
    <a class="nav-link <?php echo strpos($active_page, 'settings-hero') === 0 ? 'active' : ''; ?>" href="<?php echo base_url('admin/settings/hero'); ?>">
        <i data-lucide="image"></i> <span><?php echo t('Hero', 'Hero'); ?></span>
    </a>
    <a class="nav-link <?php echo strpos($active_page, 'settings-homepage') === 0 ? 'active' : ''; ?>" href="<?php echo base_url('admin/settings/homepage'); ?>">
        <i data-lucide="home"></i> <span><?php echo t('Beranda', 'Homepage'); ?></span>
    </a>
    <a class="nav-link <?php echo strpos($active_page, 'settings-social') === 0 ? 'active' : ''; ?>" href="<?php echo base_url('admin/settings/social'); ?>">
        <i data-lucide="share-2"></i> <span><?php echo t('Sosial Media', 'Social Media'); ?></span>
    </a>
    <a class="nav-link <?php echo strpos($active_page, 'settings-footer') === 0 ? 'active' : ''; ?>" href="<?php echo base_url('admin/settings/footer'); ?>">
        <i data-lucide="scroll-text"></i> <span><?php echo t('Footer', 'Footer'); ?></span>
    </a>
    <a class="nav-link <?php echo strpos($active_page, 'settings-payment') === 0 ? 'active' : ''; ?>" href="<?php echo base_url('admin/settings/payment'); ?>">
        <i data-lucide="credit-card"></i> <span><?php echo t('Pembayaran', 'Payment'); ?></span>
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