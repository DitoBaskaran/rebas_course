<div class="admin-sidebar playful" id="adminSidebar">
    <?php $active_page = isset($active_page) ? $active_page : ''; ?>
    <?php $_ss_role = $this->session->userdata('role'); ?>
    <?php $_ss_is_teacher = $this->session->userdata('is_teacher'); ?>
    <?php $_ss_is_mentor = $this->session->userdata('is_mentor'); ?>
    <?php
        if ($_ss_is_mentor) $_ss_dash_url = 'mentor';
        elseif ($_ss_role === 'admin') $_ss_dash_url = 'admin/dashboard';
        elseif ($_ss_is_teacher) $_ss_dash_url = 'teacher/dashboard';
        else $_ss_dash_url = 'dashboard';
    ?>

    <!-- Grup: Pembelajaran & Komunitas -->
    <div class="sidebar-heading"><?php echo t('Pembelajaran & Komunitas', 'Learning & Community'); ?></div>
    <a class="nav-link <?php echo $active_page === 'dashboard' ? 'active' : ''; ?>" href="<?php echo base_url($_ss_dash_url); ?>">
        <i data-lucide="layout-dashboard"></i> <span><?php echo t('Dashboard', 'Dashboard'); ?></span>
    </a>
    <a class="nav-link <?php echo $active_page === 'my_courses' ? 'active' : ''; ?>" href="<?php echo base_url('courses/mine'); ?>">
        <i data-lucide="book-open"></i> <span><?php echo t('Kelas Saya', 'My Courses'); ?></span>
    </a>
    <a class="nav-link <?php echo $active_page === 'seminars' ? 'active' : ''; ?>" href="<?php echo base_url('seminars/mine'); ?>">
        <i data-lucide="calendar"></i> <span><?php echo t('Seminar', 'Seminars'); ?></span>
    </a>
    <a class="nav-link <?php echo $active_page === 'learning_paths' ? 'active' : ''; ?>" href="<?php echo base_url('learning_paths/mine'); ?>">
        <i data-lucide="route"></i> <span><?php echo t('Learning Paths', 'Learning Paths'); ?></span>
    </a>
    <a class="nav-link <?php echo $active_page === 'mentoring' ? 'active' : ''; ?>" href="<?php echo base_url($_ss_is_mentor ? 'mentor/sessions' : 'mentoring'); ?>">
        <i data-lucide="calendar-check"></i> <span><?php echo t('Mentoring', 'Mentoring'); ?></span>
    </a>
    <a class="nav-link <?php echo $active_page === 'forum' ? 'active' : ''; ?>" href="<?php echo base_url('forum'); ?>">
        <i data-lucide="message-square"></i> <span><?php echo t('Forum', 'Forum'); ?></span>
    </a>
    <a class="nav-link <?php echo $active_page === 'wishlist' ? 'active' : ''; ?>" href="<?php echo base_url('wishlist'); ?>">
        <i data-lucide="heart"></i> <span><?php echo t('Wishlist', 'Wishlist'); ?></span>
    </a>

    <!-- Divider -->
    <div class="sidebar-section-divider"></div>

    <!-- Grup: Akun & Keuangan -->
    <div class="sidebar-heading"><?php echo t('Akun & Keuangan', 'Account & Finance'); ?></div>
    <a class="nav-link <?php echo $active_page === 'subscription' ? 'active' : ''; ?>" href="<?php echo base_url('subscription'); ?>">
        <i data-lucide="layers"></i> <span><?php echo t('Langganan', 'Subscription'); ?></span>
    </a>
    <a class="nav-link <?php echo $active_page === 'transactions' ? 'active' : ''; ?>" href="<?php echo base_url('transactions/history'); ?>">
        <i data-lucide="receipt"></i> <span><?php echo t('Riwayat Transaksi', 'Transaction History'); ?></span>
    </a>
    <a class="nav-link <?php echo $active_page === 'certificates' ? 'active' : ''; ?>" href="<?php echo base_url('certificate/my'); ?>">
        <i data-lucide="award"></i> <span><?php echo t('Sertifikat', 'Certificates'); ?></span>
    </a>
    <a class="nav-link <?php echo $active_page === 'profile' ? 'active' : ''; ?>" href="<?php echo base_url('profile'); ?>">
        <i data-lucide="user"></i> <span><?php echo t('Profil Saya', 'My Profile'); ?></span>
    </a>
    <a class="nav-link <?php echo $active_page === 'affiliate' ? 'active' : ''; ?>" href="<?php echo base_url('affiliate'); ?>">
        <i data-lucide="gift"></i> <span><?php echo t('Affiliate', 'Affiliate'); ?></span>
    </a>

    <button class="sidebar-collapse-btn" title="Collapse sidebar">
        <i data-lucide="chevron-left" style="width:18px;height:18px;"></i>
    </button>
</div>
<div class="admin-sidebar-overlay playful" id="sidebarOverlay" onclick="document.getElementById('adminSidebar').classList.remove('mobile-show');this.classList.remove('mobile-show');"></div>
