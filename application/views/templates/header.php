<!DOCTYPE html>
<html lang="<?php echo current_lang(); ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($title) ? $title . ' — ' . setting('general_site_name', 'REBAS COURSE') : setting('general_site_name', 'REBAS COURSE'); ?></title>
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
    <!-- REBAS Design System -->
    <link rel="stylesheet" href="<?php echo base_url('assets/css/rebas.css'); ?>">
    <style>
        :root {
            <?php echo settings_css_vars(); ?>
        }
    </style>

    <!-- Open Graph -->
    <meta property="og:title" content="<?php echo isset($og_title) ? $og_title : (isset($title) ? $title : setting('general_site_name', 'REBAS COURSE')); ?>">
    <meta property="og:description" content="<?php echo isset($og_description) ? $og_description : htmlspecialchars(setting('general_site_description', '')); ?>">
    <meta property="og:image" content="<?php echo isset($og_image) ? $og_image : base_url('assets/img/og-default.png'); ?>">
    <meta property="og:url" content="<?php echo current_url(); ?>">
    <meta property="og:type" content="website">
    <meta name="twitter:card" content="summary_large_image">

    <?php $ga4_id = setting('analytics_ga4_id', ''); if ($ga4_id): ?>
    <script async src="https://www.googletagmanager.com/gtag/js?id=<?php echo $ga4_id; ?>"></script>
    <script>window.dataLayer = window.dataLayer || []; function gtag(){dataLayer.push(arguments);} gtag('js', new Date()); gtag('config', '<?php echo $ga4_id; ?>');</script>
    <?php endif; ?>

    <?php $fb_pixel = setting('analytics_fb_pixel', ''); if ($fb_pixel): ?>
    <script>!function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';n.queue=[];t=b.createElement(e);t.async=!0;t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}(window,document,'script','https://connect.facebook.net/en_US/fbevents.js');fbq('init','<?php echo $fb_pixel; ?>');fbq('track','PageView');</script>
    <?php endif; ?>
</head>
<body>

    <?php if (setting('marketing_social_proof', '1') === '1'): ?>
    <?php
        $CI =& get_instance();
        $recent_count = $CI->db->where('enrolled_at >=', date('Y-m-d', strtotime('-30 days')))->count_all_results('enrollments');
        $site_name = setting('general_site_name', 'REBAS COURSE');
    ?>
    <div class="social-proof-bar" style="background:linear-gradient(135deg,#6366f1,#06b6d4);color:#fff;text-align:center;padding:0.4rem;font-size:0.75rem;font-weight:500;">
        🎉 <strong><?php echo $recent_count; ?></strong> <?php echo t('siswa telah mendaftar dalam 30 hari terakhir! Mulai belajar sekarang.', 'students have enrolled in the last 30 days! Start learning now.'); ?>
        <a href="<?php echo base_url('courses'); ?>" style="color:#fff;text-decoration:underline;font-weight:700;margin-left:0.5rem;"><?php echo t('Lihat Kursus', 'View Courses'); ?> →</a>
    </div>
    <?php endif; ?>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom border-light fixed-top shadow-sm" id="mainNavbar">
        <div class="container py-1">
            <a class="navbar-brand text-dark d-flex align-items-center gap-2 fw-bold" href="<?php echo base_url(); ?>">
                <?php $logo_url = site_logo_url(); if ($logo_url): ?>
                    <img src="<?php echo $logo_url; ?>" alt="<?php echo htmlspecialchars(setting('general_site_name', 'REBAS COURSE')); ?>" style="height: 28px; width: auto;">
                <?php else: ?>
                    <span class="d-inline-flex align-items-center justify-content-center bg-dark text-white rounded-2 p-1 me-1" style="width: 32px; height: 32px;">
                        <i class="fas fa-graduation-cap fa-sm"></i>
                    </span>
                    <span style="letter-spacing: -0.02em;"><?php echo htmlspecialchars(setting('general_site_name', 'REBAS COURSE')); ?></span>
                <?php endif; ?>
            </a>
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                    <li class="nav-item">
                        <a class="nav-link<?php echo uri_string() === '' ? ' active' : ''; ?>" href="<?php echo base_url(); ?>"><?php echo t('Beranda', 'Home'); ?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link<?php echo strpos(uri_string(), 'courses') === 0 ? ' active' : ''; ?>" href="<?php echo base_url('courses'); ?>"><?php echo t('Kelas', 'Courses'); ?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link<?php echo strpos(uri_string(), 'seminars') === 0 ? ' active' : ''; ?>" href="<?php echo base_url('seminars'); ?>"><?php echo t('Seminar', 'Seminars'); ?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link<?php echo strpos(uri_string(), 'learning_paths') === 0 ? ' active' : ''; ?>" href="<?php echo base_url('learning_paths'); ?>"><?php echo t('Learning Paths', 'Paths'); ?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link<?php echo strpos(uri_string(), 'mentoring') === 0 ? ' active' : ''; ?>" href="<?php echo base_url('mentoring'); ?>"><?php echo t('Mentoring', 'Mentoring'); ?></a>
                    </li>
                </ul>
                <div class="d-flex align-items-center gap-2">
                    <button class="btn btn-sm btn-ghost rounded-circle d-flex align-items-center justify-content-center" id="frontendThemeToggle" style="width:34px;height:34px;" title="Toggle theme">
                        <i data-lucide="moon" class="moon-icon" style="width:16px;height:16px;"></i>
                        <i data-lucide="sun" class="sun-icon" style="width:16px;height:16px;display:none;"></i>
                    </button>
                    <?php if ($this->session->userdata('logged_in')): ?>
                        <div class="dropdown">
                            <button class="btn btn-sm btn-ghost d-flex align-items-center gap-2 px-2" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <span class="d-inline-flex align-items-center justify-content-center bg-dark text-white rounded-circle fw-bold" style="width: 32px; height: 32px; font-size: 0.75rem;">
                                    <?php echo strtoupper(substr($this->session->userdata('name'), 0, 1)); ?>
                                </span>
                                <span class="d-none d-md-inline small fw-semibold"><?php echo htmlspecialchars(ucfirst($this->session->userdata('name'))); ?></span>
                                <i class="fas fa-chevron-down text-muted" style="font-size: 0.6rem;"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0 py-1" style="border-radius: var(--radius-sm); min-width: 180px;">
                                <?php if (in_array($this->session->userdata('role'), ['admin', 'teacher'])): ?>
                                    <li><a class="dropdown-item small py-2" href="<?php echo base_url('admin/dashboard'); ?>"><i class="fas fa-user-shield me-2" style="width: 16px;"></i><?php echo t('Panel Admin', 'Admin Panel'); ?></a></li>
                                <?php else: ?>
                                    <li><a class="dropdown-item small py-2" href="<?php echo base_url('dashboard'); ?>"><i class="fas fa-th-large me-2" style="width: 16px;"></i><?php echo t('Dashboard', 'Dashboard'); ?></a></li>
                                <?php endif; ?>
                                <li><a class="dropdown-item small py-2" href="<?php echo base_url('profile'); ?>"><i class="fas fa-user-circle text-muted me-2" style="width: 16px;"></i><?php echo t('Profil', 'Profile'); ?></a></li>
                                <li><hr class="dropdown-divider my-1"></li>
                                <li><a class="dropdown-item small py-2 text-danger" href="<?php echo base_url('auth/logout'); ?>"><i class="fas fa-sign-out-alt me-2" style="width: 16px;"></i><?php echo t('Keluar', 'Logout'); ?></a></li>
                            </ul>
                        </div>
                    <?php else: ?>
                        <a href="<?php echo base_url('auth/login'); ?>" class="btn btn-ghost btn-sm px-3 rounded-pill fw-semibold"><?php echo t('Masuk', 'Login'); ?></a>
                        <a href="<?php echo base_url('auth/register'); ?>" class="btn btn-dark btn-sm px-4 rounded-pill fw-semibold shadow-sm"><?php echo t('Daftar', 'Register'); ?></a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>
    
    <!-- Add padding to body to account for fixed navbar -->
    <style>
        body {
            padding-top: 76px;
        }
    </style>

    <!-- Flash Messages -->
    <div class="container mt-3">
        <?php if ($this->session->flashdata('success')): ?>
            <div class="alert alert-success border-0 shadow-soft d-flex align-items-center gap-2 py-3 px-4 alert-dismissible fade show" style="border-radius: var(--radius-sm);" role="alert">
                <div class="d-inline-flex align-items-center justify-content-center bg-success-subtle rounded-circle flex-shrink-0" style="width: 24px; height: 24px;">
                    <i class="fas fa-check-circle text-success" style="font-size: 0.75rem;"></i>
                </div>
                <span class="small"><?php echo $this->session->flashdata('success'); ?></span>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close" style="font-size: 0.625rem;"></button>
            </div>
        <?php endif; ?>
        <?php if ($this->session->flashdata('error')): ?>
            <div class="alert alert-danger border-0 shadow-soft d-flex align-items-center gap-2 py-3 px-4 alert-dismissible fade show" style="border-radius: var(--radius-sm);" role="alert">
                <div class="d-inline-flex align-items-center justify-content-center bg-danger-subtle rounded-circle flex-shrink-0" style="width: 24px; height: 24px;">
                    <i class="fas fa-exclamation-triangle text-danger" style="font-size: 0.75rem;"></i>
                </div>
                <span class="small"><?php echo $this->session->flashdata('error'); ?></span>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close" style="font-size: 0.625rem;"></button>
            </div>
        <?php endif; ?>
    </div>
