<!DOCTYPE html>
<html lang="<?php echo current_lang(); ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($title) ? $title . ' — ' . setting('general_site_name', 'BISATUNTAS') : setting('general_site_name', 'BISATUNTAS'); ?></title>
    <meta name="description" content="<?php echo htmlspecialchars(setting('general_site_description', '')); ?>">
    <meta name="keywords" content="<?php echo htmlspecialchars(setting('general_site_keywords', '')); ?>">
    <?php $favicon = site_favicon_url(); if ($favicon): ?>
    <link rel="icon" type="image/x-icon" href="<?php echo $favicon; ?>">
    <link rel="shortcut icon" href="<?php echo $favicon; ?>">
    <?php endif; ?>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome 6 Free -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- BISATUNTAS Design System v3.0 -->
    <link rel="stylesheet" href="<?php echo base_url('assets/css/bisatuntas.css'); ?>">
    <!-- BISATUNTAS Colorful Playful Override -->
    <link rel="stylesheet" href="<?php echo base_url('assets/css/bisatuntas-playful-alt.css'); ?>">
    <style>
        :root {
            <?php echo settings_css_vars(); ?>
        }
    </style>

    <!-- Open Graph -->
    <meta property="og:title" content="<?php echo isset($title) ? $title : setting('general_site_name', 'BISATUNTAS'); ?>">
    <meta property="og:description" content="<?php echo htmlspecialchars(setting('general_site_description', '')); ?>">
    <meta property="og:image" content="<?php echo base_url('assets/img/og-default.png'); ?>">
    <meta property="og:url" content="<?php echo current_url(); ?>">

    <?php $ga4_id = setting('analytics_ga4_id', ''); if ($ga4_id): ?>
    <script async src="https://www.googletagmanager.com/gtag/js?id=<?php echo $ga4_id; ?>"></script>
    <script>window.dataLayer = window.dataLayer || []; function gtag(){dataLayer.push(arguments);} gtag('js', new Date()); gtag('config', '<?php echo $ga4_id; ?>');</script>
    <?php endif; ?>

    <?php $fb_pixel = setting('analytics_fb_pixel', ''); if ($fb_pixel): ?>
    <script>!function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';n.queue=[];t=b.createElement(e);t.async=!0;t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}(window,document,'script','https://connect.facebook.net/en_US/fbevents.js');fbq('init','<?php echo $fb_pixel; ?>');fbq('track','PageView');</script>
    <?php endif; ?>
</head>
<body class="playful">

    <!-- Top Bar (Glass) -->
    <nav class="admin-topbar">
        <div class="admin-topbar-inner">
            <div class="admin-topbar-start">
                <button class="admin-topbar-toggle d-lg-none" onclick="toggleAdminSidebar()" aria-label="Toggle sidebar">
                    <i data-lucide="menu" style="width:18px;height:18px;"></i>
                </button>
                <button class="admin-topbar-toggle d-none d-lg-inline-flex" id="sidebarToggle" aria-label="Toggle sidebar">
                    <i data-lucide="panel-left-close" style="width:18px;height:18px;"></i>
                </button>
                <a href="<?php echo base_url('dashboard'); ?>" class="admin-topbar-brand">
                    <?php $logo_url = site_logo_url(); if ($logo_url): ?>
                        <img src="<?php echo $logo_url; ?>" alt="Logo" class="admin-topbar-logo">
                    <?php else: ?>
                        <span class="admin-topbar-logo-icon">
                            <i data-lucide="graduation-cap" style="width:16px;height:16px;"></i>
                        </span>
                        <span class="admin-topbar-brand-text">BISATUNTAS</span>
                    <?php endif; ?>
                </a>
                <span class="admin-topbar-badge"><?php echo $this->session->userdata('role') === 'mentor' ? t('Mentor', 'Mentor') : t('Siswa', 'Student'); ?></span>
            </div>
            <div class="admin-topbar-end">
                <button class="theme-toggle" id="themeToggle" title="Toggle theme">
                    <i data-lucide="moon" class="moon-icon" style="width:18px;height:18px;"></i>
                    <i data-lucide="sun" class="sun-icon" style="width:18px;height:18px;"></i>
                </button>
                <a href="<?php echo base_url(); ?>" class="admin-topbar-action d-none d-md-inline-flex" target="_blank" title="<?php echo t('Lihat Website', 'View Website'); ?>">
                    <i data-lucide="external-link" style="width:18px;height:18px;"></i>
                </a>
                <div class="dropdown">
                    <button class="admin-topbar-avatar dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                        <span class="avatar-circle">
                            <?php echo strtoupper(substr($this->session->userdata('name'), 0, 1)); ?>
                        </span>
                        <span class="admin-topbar-avatar-name"><?php echo htmlspecialchars(ucfirst($this->session->userdata('name'))); ?></span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0 py-1" style="min-width: 180px;">
                        <li><a class="dropdown-item small py-2" href="<?php echo base_url('profile'); ?>"><i data-lucide="user" style="width:16px;height:16px;" class="me-2"></i><?php echo t('Profil', 'Profile'); ?></a></li>
                        <li><hr class="dropdown-divider my-1"></li>
                        <li><a class="dropdown-item small py-2 text-danger" href="<?php echo base_url('auth/logout'); ?>"><i data-lucide="log-out" style="width:16px;height:16px;" class="me-2"></i><?php echo t('Keluar', 'Logout'); ?></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <!-- Flash Messages -->
    <div class="container-fluid px-4 mt-3">
        <?php if ($this->session->flashdata('success')): ?>
            <div class="alert alert-success border-0 shadow-soft d-flex align-items-center gap-2 py-3 px-4 alert-dismissible fade show flash-toast" role="alert" data-toast="success" data-message="<?php echo htmlspecialchars($this->session->flashdata('success'), ENT_QUOTES, 'UTF-8'); ?>">
                <span class="icon-24 bg-success-subtle rounded-circle d-inline-flex align-items-center justify-content-center flex-shrink-0"><i class="fas fa-check-circle text-success fs-8"></i></span>
                <span class="small"><?php echo $this->session->flashdata('success'); ?></span>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
        <?php if ($this->session->flashdata('error')): ?>
            <div class="alert alert-danger border-0 shadow-soft d-flex align-items-center gap-2 py-3 px-4 alert-dismissible fade show" role="alert">
                <span class="icon-24 bg-danger-subtle rounded-circle d-inline-flex align-items-center justify-content-center flex-shrink-0"><i class="fas fa-exclamation-triangle text-danger fs-8"></i></span>
                <span class="small"><?php echo $this->session->flashdata('error'); ?></span>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
    </div>

    <!-- Student Wrapper -->
    <div class="admin-wrapper playful" id="studentWrapper">
        <?php $this->load->view('templates/student_sidebar'); ?>
        <div class="admin-content">
