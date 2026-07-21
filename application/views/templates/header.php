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
    <!-- BISATUNTAS Design System -->
    <link rel="stylesheet" href="<?php echo base_url('assets/css/bisatuntas.css'); ?>">
    <?php if (!isset($is_homepage) || !$is_homepage): ?>
    <link rel="stylesheet" href="<?php echo base_url('assets/css/bisatuntas-playful-alt.css'); ?>">
    <?php endif; ?>
    <!-- SweetAlert2 -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    <style>
        :root { <?php echo settings_css_vars(); ?> }
        body { padding-top: 72px; }
        .navbar { padding-top: 0.75rem; padding-bottom: 0.75rem; }
        .navbar-brand { font-weight: 800; font-size: 1.15rem; letter-spacing: -0.03em; color: #111827 !important; }
        .nav-link-home { font-weight: 600; font-size: 0.875rem; color: #525252 !important; padding: 0.5rem 0.75rem !important; border-radius: 8px; transition: all 0.15s; text-decoration: none !important; background-image: none !important; }
        .nav-link-home:hover { color: #111827 !important; background: #f5f5f5 !important; background-image: none !important; }
        .nav-link-home.active { color: #eab308 !important; background: #fefce8 !important; background-image: none !important; }
        .nav-link-home::after, .nav-link-home::before, nav .nav-item a::after, nav .nav-item a::before, .navbar .nav-link::after, .navbar .nav-link::before, .offcanvas .nav-link::after, .offcanvas .nav-link::before { display: none !important; content: none !important; }
        .navbar-scrolled { box-shadow: 0 1px 3px rgba(0,0,0,0.04); }
        .social-bar { background: #111827; color: #d4d4d4; text-align: center; padding: 0.5rem; font-size: 0.75rem; font-weight: 500; border-bottom: 1px solid #1f1f1f; }
        .social-bar strong { color: #eab308; }
        .alert-flash { border-radius: 12px; border: none; padding: 0.75rem 1rem; }
    </style>
</head>
<body class="<?php echo (!isset($is_homepage) || !$is_homepage) ? 'playful' : ''; ?>">

    <!-- Social Proof Bar -->
    <?php if (setting('marketing_social_proof', '1') === '1'): ?>
    <?php
        $CI =& get_instance();
        $recent_count = $CI->db->where('enrolled_at >=', date('Y-m-d', strtotime('-30 days')))->count_all_results('enrollments');
    ?>
    <div class="social-bar"><?php echo t('🎉 ', '🎉 '); ?><strong><?php echo $recent_count; ?></strong> <?php echo t('siswa telah mendaftar dalam 30 hari terakhir! ', 'students enrolled in the last 30 days! '); ?>
        <a href="<?php echo base_url('courses'); ?>" style="color: #eab308; text-decoration: underline; font-weight: 700;"><?php echo t('Mulai Belajar', 'Start Learning'); ?> →</a>
    </div>
    <?php endif; ?>

    <!-- Navbar — Dealls-style -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white fixed-top" style="border-bottom: 1px solid #f0f0f0;" id="mainNavbar">
        <div class="container">
            <!-- Mobile toggler -->
            <button class="navbar-toggler border-0 d-lg-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Brand -->
            <a class="navbar-brand text-dark d-flex align-items-center gap-2" href="<?php echo base_url(); ?>">
                <span class="d-inline-flex align-items-center justify-content-center fw-bold rounded-2" style="width: 30px; height: 30px; background: #eab308; color: #111827; font-size: 0.8rem;">B</span>
                BISATUNTAS
            </a>

            <!-- Desktop -->
            <div class="collapse navbar-collapse d-none d-lg-flex" id="navbarNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                    <li class="nav-item"><a class="nav-link-home <?php echo uri_string() === '' ? 'active' : ''; ?>" href="<?php echo base_url(); ?>"><?php echo t('Beranda', 'Home'); ?></a></li>
                    <li class="nav-item"><a class="nav-link-home <?php echo strpos(uri_string(), 'courses') === 0 ? 'active' : ''; ?>" href="<?php echo base_url('courses'); ?>"><?php echo t('Kelas', 'Courses'); ?></a></li>
                    <li class="nav-item"><a class="nav-link-home <?php echo strpos(uri_string(), 'seminars') === 0 ? 'active' : ''; ?>" href="<?php echo base_url('seminars'); ?>"><?php echo t('Seminar', 'Seminars'); ?></a></li>
                    <li class="nav-item"><a class="nav-link-home <?php echo strpos(uri_string(), 'learning_paths') === 0 ? 'active' : ''; ?>" href="<?php echo base_url('learning_paths'); ?>"><?php echo t('Learning Paths', 'Paths'); ?></a></li>
                    <li class="nav-item"><a class="nav-link-home <?php echo strpos(uri_string(), 'mentoring') === 0 ? 'active' : ''; ?>" href="<?php echo base_url('mentoring'); ?>"><?php echo t('Mentoring', 'Mentoring'); ?></a></li>
                    <li class="nav-item"><a class="nav-link-home <?php echo strpos(uri_string(), 'subscription') === 0 ? 'active' : ''; ?>" href="<?php echo base_url('subscription'); ?>"><?php echo t('Langganan', 'Subscription'); ?></a></li>
                </ul>
                <div class="d-flex align-items-center gap-2">
                    <?php if ($this->session->userdata('logged_in')): ?>
                        <div class="dropdown">
                            <button class="btn btn-sm d-flex align-items-center gap-2 px-2 fw-semibold" style="background: #f5f5f5; border: none; border-radius: 100px; padding: 0.25rem 0.5rem 0.25rem 0.25rem !important;" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <span class="d-inline-flex align-items-center justify-content-center fw-bold rounded-circle" style="width: 28px; height: 28px; background: #111827; color: #fff; font-size: 0.7rem;">
                                    <?php echo strtoupper(substr($this->session->userdata('name'), 0, 1)); ?>
                                </span>
                                <span class="d-none d-md-inline small" style="color: #111827;"><?php echo htmlspecialchars(ucfirst($this->session->userdata('name'))); ?></span>
                                <i class="fas fa-chevron-down" style="color: #a3a3a3; font-size: 0.55rem;"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end shadow-sm border py-2" style="border-radius: 12px; min-width: 180px; border-color: #e5e5e5;">
                                <?php if (in_array($this->session->userdata('role'), ['admin', 'teacher', 'mentor'])): ?>
                                    <li><a class="dropdown-item small py-2" href="<?php echo base_url('admin/dashboard'); ?>"><i class="fas fa-user-shield me-2" style="width: 16px;"></i><?php echo t('Panel Admin', 'Admin Panel'); ?></a></li>
                                <?php else: ?>
                                    <li><a class="dropdown-item small py-2" href="<?php echo base_url('dashboard'); ?>"><i class="fas fa-th-large me-2" style="width: 16px;"></i><?php echo t('Dashboard', 'Dashboard'); ?></a></li>
                                <?php endif; ?>
                                <li><a class="dropdown-item small py-2" href="<?php echo base_url('profile'); ?>"><i class="fas fa-user-circle me-2" style="width: 16px;"></i><?php echo t('Profil', 'Profile'); ?></a></li>
                                <li><hr class="dropdown-divider my-1"></li>
                                <li><a class="dropdown-item small py-2 text-danger" href="<?php echo base_url('auth/logout'); ?>"><i class="fas fa-sign-out-alt me-2" style="width: 16px;"></i><?php echo t('Keluar', 'Logout'); ?></a></li>
                            </ul>
                        </div>
                    <?php else: ?>
                        <a href="<?php echo base_url('auth/login'); ?>" class="btn btn-sm px-3 fw-semibold rounded-pill" style="background: none; border: 1px solid #e5e5e5; color: #525252;"><?php echo t('Masuk', 'Login'); ?></a>
                        <a href="<?php echo base_url('auth/register'); ?>" class="btn btn-sm px-4 fw-bold rounded-pill" style="background: #eab308; color: #111827; border: none;"><?php echo t('Daftar', 'Register'); ?></a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>

    <!-- Mobile offcanvas (outside nav to avoid backdrop-filter containing block issue) -->
    <div class="offcanvas offcanvas-start d-lg-none" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
        <div class="offcanvas-header" style="border-bottom: 1px solid #f0f0f0;">
            <h5 class="offcanvas-title d-flex align-items-center gap-2 fw-bold">BISATUNTAS</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body p-0">
            <ul class="navbar-nav me-auto">
                <li class="nav-item"><a class="nav-link-home d-block px-3 py-2 active" href="<?php echo base_url(); ?>"><?php echo t('Beranda', 'Home'); ?></a></li>
                <li class="nav-item"><a class="nav-link-home d-block px-3 py-2" href="<?php echo base_url('courses'); ?>"><?php echo t('Kelas', 'Courses'); ?></a></li>
                <li class="nav-item"><a class="nav-link-home d-block px-3 py-2" href="<?php echo base_url('seminars'); ?>"><?php echo t('Seminar', 'Seminars'); ?></a></li>
                <li class="nav-item"><a class="nav-link-home d-block px-3 py-2" href="<?php echo base_url('learning_paths'); ?>"><?php echo t('Learning Paths', 'Paths'); ?></a></li>
                <li class="nav-item"><a class="nav-link-home d-block px-3 py-2" href="<?php echo base_url('mentoring'); ?>"><?php echo t('Mentoring', 'Mentoring'); ?></a></li>
                <li class="nav-item"><a class="nav-link-home d-block px-3 py-2" href="<?php echo base_url('subscription'); ?>"><?php echo t('Langganan', 'Subscription'); ?></a></li>
            </ul>
            <hr class="my-0">
            <div class="p-3 d-flex flex-column gap-2">
                <?php if ($this->session->userdata('logged_in')): ?>
                    <a href="<?php echo base_url('dashboard'); ?>" class="btn btn-dark btn-sm w-100 rounded-pill fw-semibold"><?php echo t('Dashboard', 'Dashboard'); ?></a>
                    <?php if (in_array($this->session->userdata('role'), ['admin', 'teacher', 'mentor'])): ?>
                        <a href="<?php echo base_url('admin/dashboard'); ?>" class="btn btn-outline-dark btn-sm w-100 rounded-pill fw-semibold"><?php echo t('Panel Admin', 'Admin Panel'); ?></a>
                    <?php endif; ?>
                    <a href="<?php echo base_url('profile'); ?>" class="btn btn-outline-dark btn-sm w-100 rounded-pill fw-semibold"><?php echo t('Profil', 'Profile'); ?></a>
                    <div class="border-top pt-2 mt-1">
                        <a href="<?php echo base_url('auth/logout'); ?>" class="btn btn-outline-danger btn-sm w-100 rounded-pill fw-semibold"><?php echo t('Keluar', 'Logout'); ?></a>
                    </div>
                <?php else: ?>
                    <a href="<?php echo base_url('auth/login'); ?>" class="btn btn-outline-dark btn-sm w-100 rounded-pill fw-semibold"><?php echo t('Masuk', 'Login'); ?></a>
                    <a href="<?php echo base_url('auth/register'); ?>" class="btn btn-sm w-100 rounded-pill fw-semibold" style="background: #eab308; color: #111827;"><?php echo t('Daftar', 'Register'); ?></a>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Flash Messages -->
    <div class="container mt-3">
        <?php if ($this->session->flashdata('success')): ?>
            <div class="alert alert-flash d-flex align-items-center gap-2 alert-dismissible fade show" role="alert" style="background: #f0fdf4; color: #166534;">
                <i class="fas fa-check-circle"></i>
                <span class="small"><?php echo $this->session->flashdata('success'); ?></span>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close" style="font-size: 0.6rem;"></button>
            </div>
        <?php endif; ?>
        <?php if ($this->session->flashdata('error')): ?>
            <div class="alert alert-flash d-flex align-items-center gap-2 alert-dismissible fade show" role="alert" style="background: #fef2f2; color: #991b1b;">
                <i class="fas fa-exclamation-triangle"></i>
                <span class="small"><?php echo $this->session->flashdata('error'); ?></span>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close" style="font-size: 0.6rem;"></button>
            </div>
        <?php endif; ?>
    </div>
