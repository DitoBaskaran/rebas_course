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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/bisatuntas.css'); ?>">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    <style>
        :root { <?php echo settings_css_vars(); ?> }
        body { padding-top: 56px; font-family: 'Inter', -apple-system, sans-serif; background: #fff; color: #171717; }
        .fe-navbar { height: 56px; background: rgba(255,255,255,0.72); backdrop-filter: blur(20px) saturate(180%); -webkit-backdrop-filter: blur(20px) saturate(180%); border-bottom: 1px solid rgba(0,0,0,0.04); transition: box-shadow 0.3s ease, background 0.3s ease; }
        .fe-navbar.is-scrolled { background: rgba(255,255,255,0.9); box-shadow: 0 1px 20px rgba(0,0,0,0.06); }
        .fe-brand { font-size: 1rem; font-weight: 800; letter-spacing: -0.04em; color: #171717; text-decoration: none; display: flex; align-items: center; gap: 1px; }
        .fe-brand-accent { color: #059669; }
        .fe-nav-link { position: relative; font-size: 0.8125rem; font-weight: 500; color: #525252; padding: 0.25rem 0; margin: 0 0.5rem; text-decoration: none; transition: color 0.2s; white-space: nowrap; }
        .fe-nav-link::after { content: ''; position: absolute; bottom: -2px; left: 50%; width: 0; height: 2px; background: #059669; border-radius: 2px; transition: width 0.25s ease, left 0.25s ease; }
        .fe-nav-link:hover { color: #171717; }
        .fe-nav-link:hover::after { width: 100%; left: 0; }
        .fe-nav-link.active { color: #171717; font-weight: 600; }
        .fe-nav-link.active::after { width: 100%; left: 0; }
        .navbar-toggler { border: none !important; box-shadow: none !important; padding: 0.25rem 0.4rem; }
        .navbar-toggler:focus { box-shadow: none !important; }
        .fe-nav-divider { width: 1px; height: 20px; background: rgba(0,0,0,0.06); margin: 0 0.75rem; flex-shrink: 0; }
        .fe-btn-login { font-size: 0.8125rem; font-weight: 500; color: #525252; border: 1px solid rgba(0,0,0,0.08); border-radius: 6px; padding: 0.35rem 0.85rem; text-decoration: none; transition: all 0.2s ease; background: transparent; }
        .fe-btn-login:hover { border-color: rgba(0,0,0,0.15); color: #171717; transform: translateY(-1px); }
        .fe-btn-register { font-size: 0.8125rem; font-weight: 600; color: #fff; background: #059669; border: none; border-radius: 6px; padding: 0.4rem 0.9rem; text-decoration: none; transition: all 0.2s ease; }
        .fe-btn-register:hover { background: #047857; box-shadow: 0 4px 12px rgba(5, 150, 105,0.3); transform: translateY(-1px); }
        .fe-user-btn { display: flex; align-items: center; gap: 6px; background: rgba(0,0,0,0.04); border: none; border-radius: 99px; padding: 0.2rem 0.65rem 0.2rem 0.2rem; cursor: pointer; transition: background 0.2s ease; }
        .fe-user-btn:hover { background: rgba(0,0,0,0.08); }
        .fe-avatar { width: 26px; height: 26px; border-radius: 50%; background: #171717; color: #fff; font-size: 0.65rem; font-weight: 700; display: inline-flex; align-items: center; justify-content: center; flex-shrink: 0; }
        .fe-user-name { font-size: 0.8rem; font-weight: 500; color: #171717; }
        .fe-chevron { color: #a3a3a3; font-size: 0.5rem; }
        .fe-dropdown { border-radius: 10px; border: 1px solid rgba(0,0,0,0.06); box-shadow: 0 4px 20px rgba(0,0,0,0.08); min-width: 172px; padding: 0.35rem 0; }
        .fe-dropdown .dropdown-item { font-size: 0.8125rem; padding: 0.45rem 0.9rem; color: #525252; }
        .fe-dropdown .dropdown-item:hover { background: #f5f5f5; color: #171717; }
        .fe-dropdown .dropdown-item.text-danger:hover { background: #fff1f2; }
        .fe-dropdown .dropdown-divider { margin: 0.25rem 0; border-color: #f0f0f0; }
        .fe-alert { border-radius: 8px; border: none; padding: 0.65rem 0.9rem; font-size: 0.8125rem; }
        .fe-notice { background: rgba(0,0,0,0.03); color: #737373; text-align: center; padding: 0.35rem 1rem; font-size: 0.7rem; font-weight: 500; border-bottom: 1px solid rgba(0,0,0,0.04); }
        .fe-notice strong { color: #171717; }
        .fe-notice a { color: #059669; text-decoration: none; font-weight: 600; }
        .fe-notice a:hover { text-decoration: underline; }
        .fe-offcanvas-link { display: flex; align-items: center; gap: 12px; padding: 0.5rem 0.75rem; border-radius: 6px; text-decoration: none; font-size: 0.8125rem; font-weight: 500; color: #525252; transition: all 0.15s; margin: 0 0.5rem; }
        .fe-offcanvas-link:hover, .fe-offcanvas-link.active { background: #f5f5f5; color: #171717; }
        .fe-offcanvas-link.active { color: #059669; font-weight: 600; }
        .fe-offcanvas-icon { width: 16px; text-align: center; font-size: 0.75rem; flex-shrink: 0; }
    </style>
</head>
<body>

    <?php if (setting('marketing_social_proof', '1') === '1'): ?>
    <?php
        $CI =& get_instance();
        $recent_count = $CI->db->where('enrolled_at >=', date('Y-m-d', strtotime('-30 days')))->count_all_results('enrollments');
    ?>
    <div class="fe-notice">
        <strong><?php echo $recent_count; ?></strong> <?php echo t('siswa bergabung dalam 30 hari terakhir.', 'students joined in the last 30 days.'); ?>
        <a href="<?php echo base_url('courses'); ?>"><?php echo t('Mulai belajar', 'Start learning'); ?> &rarr;</a>
    </div>
    <?php endif; ?>

    <nav class="navbar fixed-top fe-navbar" id="mainNavbar">
        <div class="container d-flex align-items-center gap-3">
            <button class="navbar-toggler d-lg-none me-1" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-label="Menu">
                <i class="fas fa-bars" style="font-size:0.9rem;color:#525252;"></i>
            </button>

            <a class="fe-brand me-lg-4" href="<?php echo base_url(); ?>">
                <?php echo '<span class="fe-brand-accent">' . mb_substr(setting('general_site_name', 'BISATUNTAS'), 0, 1) . '</span>' . mb_substr(setting('general_site_name', 'BISATUNTAS'), 1); ?>
            </a>

            <div class="d-none d-lg-flex align-items-center gap-1 me-auto">
                <a class="fe-nav-link <?php echo uri_string() === '' ? 'active' : ''; ?>" href="<?php echo base_url(); ?>"><?php echo t('Beranda', 'Home'); ?></a>
                <a class="fe-nav-link <?php echo strpos(uri_string(), 'courses') === 0 ? 'active' : ''; ?>" href="<?php echo base_url('courses'); ?>"><?php echo t('Kelas', 'Courses'); ?></a>
                <a class="fe-nav-link <?php echo strpos(uri_string(), 'seminars') === 0 ? 'active' : ''; ?>" href="<?php echo base_url('seminars'); ?>"><?php echo t('Seminar', 'Seminars'); ?></a>
                <a class="fe-nav-link <?php echo strpos(uri_string(), 'learning_paths') === 0 ? 'active' : ''; ?>" href="<?php echo base_url('learning_paths'); ?>"><?php echo t('Learning Paths', 'Paths'); ?></a>
                <a class="fe-nav-link <?php echo strpos(uri_string(), 'mentoring') === 0 ? 'active' : ''; ?>" href="<?php echo base_url('mentoring'); ?>"><?php echo t('Mentoring', 'Mentoring'); ?></a>
                <a class="fe-nav-link <?php echo strpos(uri_string(), 'subscription') === 0 ? 'active' : ''; ?>" href="<?php echo base_url('subscription'); ?>"><?php echo t('Langganan', 'Subscription'); ?></a>
            </div>

            <div class="d-none d-lg-block fe-nav-divider"></div>

            <div class="d-flex align-items-center gap-2 ms-auto ms-lg-0">
                <?php if ($this->session->userdata('logged_in')): ?>
                    <div class="dropdown">
                        <button class="fe-user-btn" type="button" data-bs-toggle="dropdown">
                            <span class="fe-avatar"><?php echo strtoupper(substr($this->session->userdata('name'), 0, 1)); ?></span>
                            <span class="fe-user-name d-none d-md-inline"><?php echo htmlspecialchars(ucfirst(explode(' ', $this->session->userdata('name'))[0])); ?></span>
                            <i class="fas fa-chevron-down fe-chevron"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end fe-dropdown">
                            <?php if (in_array($this->session->userdata('role'), ['admin', 'teacher', 'mentor'])): ?>
                                <li><a class="dropdown-item" href="<?php echo base_url('admin/dashboard'); ?>"><i class="fas fa-th-large me-2" style="width:14px;opacity:.5;"></i><?php echo t('Panel Admin', 'Admin Panel'); ?></a></li>
                            <?php else: ?>
                                <li><a class="dropdown-item" href="<?php echo base_url('dashboard'); ?>"><i class="fas fa-th-large me-2" style="width:14px;opacity:.5;"></i><?php echo t('Dashboard', 'Dashboard'); ?></a></li>
                            <?php endif; ?>
                            <li><a class="dropdown-item" href="<?php echo base_url('profile'); ?>"><i class="fas fa-user me-2" style="width:14px;opacity:.5;"></i><?php echo t('Profil', 'Profile'); ?></a></li>
                            <li><div class="fe-dropdown-divider dropdown-divider"></div></li>
                            <li><a class="dropdown-item text-danger" href="<?php echo base_url('auth/logout'); ?>"><i class="fas fa-sign-out-alt me-2" style="width:14px;opacity:.6;"></i><?php echo t('Keluar', 'Logout'); ?></a></li>
                        </ul>
                    </div>
                <?php else: ?>
                    <a href="<?php echo base_url('auth/login'); ?>" class="fe-btn-login"><?php echo t('Masuk', 'Login'); ?></a>
                    <a href="<?php echo base_url('auth/register'); ?>" class="fe-btn-register"><?php echo t('Daftar', 'Register'); ?></a>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <div class="offcanvas offcanvas-start d-lg-none" style="width:280px;border-right:1px solid #e5e5e5;" tabindex="-1" id="offcanvasNavbar">
        <div class="offcanvas-header" style="border-bottom:1px solid rgba(0,0,0,0.04);padding:1rem 1.25rem;">
            <div class="fe-brand">
                <?php echo '<span class="fe-brand-accent">' . mb_substr(setting('general_site_name', 'BISATUNTAS'), 0, 1) . '</span>' . mb_substr(setting('general_site_name', 'BISATUNTAS'), 1); ?>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
        </div>

        <?php if ($this->session->userdata('logged_in')): ?>
        <div style="padding:0.75rem 1.25rem;border-bottom:1px solid #f0f0f0;">
            <div class="d-flex align-items-center gap-2">
                <span class="fe-avatar" style="width:32px;height:32px;font-size:0.75rem;"><?php echo strtoupper(substr($this->session->userdata('name'), 0, 1)); ?></span>
                <div>
                    <div style="font-size:0.8125rem;font-weight:600;color:#171717;"><?php echo htmlspecialchars(ucfirst($this->session->userdata('name'))); ?></div>
                    <div style="font-size:0.7rem;color:#a3a3a3;text-transform:capitalize;"><?php echo $this->session->userdata('role'); ?></div>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <div class="offcanvas-body p-0 d-flex flex-column">
            <div style="padding:0.75rem 0.5rem 0.25rem;font-size:0.6rem;font-weight:700;text-transform:uppercase;letter-spacing:0.08em;color:#a3a3a3;padding-left:1.25rem;"><?php echo t('Navigasi', 'Navigation'); ?></div>
            <div style="display:flex;flex-direction:column;gap:2px;padding:0 0.25rem;">
                <a class="fe-offcanvas-link <?php echo uri_string()==='' ? 'active' : ''; ?>" href="<?php echo base_url(); ?>"><i class="fas fa-home fe-offcanvas-icon"></i><span><?php echo t('Beranda', 'Home'); ?></span></a>
                <a class="fe-offcanvas-link <?php echo strpos(uri_string(),'courses')===0 ? 'active' : ''; ?>" href="<?php echo base_url('courses'); ?>"><i class="fas fa-book-open fe-offcanvas-icon"></i><span><?php echo t('Kelas', 'Courses'); ?></span></a>
                <a class="fe-offcanvas-link <?php echo strpos(uri_string(),'seminars')===0 ? 'active' : ''; ?>" href="<?php echo base_url('seminars'); ?>"><i class="fas fa-calendar fe-offcanvas-icon"></i><span><?php echo t('Seminar', 'Seminars'); ?></span></a>
                <a class="fe-offcanvas-link <?php echo strpos(uri_string(),'learning_paths')===0 ? 'active' : ''; ?>" href="<?php echo base_url('learning_paths'); ?>"><i class="fas fa-route fe-offcanvas-icon"></i><span><?php echo t('Learning Paths', 'Paths'); ?></span></a>
                <a class="fe-offcanvas-link <?php echo strpos(uri_string(),'mentoring')===0 ? 'active' : ''; ?>" href="<?php echo base_url('mentoring'); ?>"><i class="fas fa-calendar-check fe-offcanvas-icon"></i><span><?php echo t('Mentoring', 'Mentoring'); ?></span></a>
                <a class="fe-offcanvas-link <?php echo strpos(uri_string(),'subscription')===0 ? 'active' : ''; ?>" href="<?php echo base_url('subscription'); ?>"><i class="fas fa-cube fe-offcanvas-icon"></i><span><?php echo t('Langganan', 'Subscription'); ?></span></a>
            </div>

            <div class="mt-auto" style="border-top:1px solid #f0f0f0;padding:0.75rem;">
                <?php if ($this->session->userdata('logged_in')): ?>
                    <a href="<?php echo base_url('dashboard'); ?>" style="display:flex;align-items:center;justify-content:center;gap:6px;background:#171717;color:#fff;border-radius:6px;padding:0.5rem;font-size:0.8125rem;font-weight:600;text-decoration:none;margin-bottom:0.4rem;">
                        <i class="fas fa-th-large" style="font-size:0.75rem;"></i> <?php echo t('Dashboard', 'Dashboard'); ?>
                    </a>
                    <a href="<?php echo base_url('auth/logout'); ?>" style="display:flex;align-items:center;justify-content:center;gap:6px;border:1px solid #e5e5e5;color:#737373;border-radius:6px;padding:0.45rem;font-size:0.8125rem;font-weight:500;text-decoration:none;">
                        <i class="fas fa-sign-out-alt" style="font-size:0.75rem;"></i> <?php echo t('Keluar', 'Logout'); ?>
                    </a>
                <?php else: ?>
                    <a href="<?php echo base_url('auth/register'); ?>" style="display:flex;align-items:center;justify-content:center;background:#059669;color:#fff;border-radius:6px;padding:0.5rem;font-size:0.8125rem;font-weight:600;text-decoration:none;margin-bottom:0.4rem;"><?php echo t('Daftar Gratis', 'Register Free'); ?></a>
                    <a href="<?php echo base_url('auth/login'); ?>" style="display:flex;align-items:center;justify-content:center;border:1px solid #e5e5e5;color:#525252;border-radius:6px;padding:0.45rem;font-size:0.8125rem;font-weight:500;text-decoration:none;"><?php echo t('Masuk', 'Login'); ?></a>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="container" style="padding-top:0.75rem;padding-bottom:0;">
        <?php if ($this->session->flashdata('success')): ?>
            <div class="fe-alert d-flex align-items-center gap-2 alert-dismissible fade show" role="alert" style="background:#f0fdf4;color:#166534;margin-bottom:0;">
                <i class="fas fa-check-circle" style="font-size:0.8rem;flex-shrink:0;"></i>
                <span><?php echo $this->session->flashdata('success'); ?></span>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" style="font-size:0.55rem;"></button>
            </div>
        <?php endif; ?>
        <?php if ($this->session->flashdata('error')): ?>
            <div class="fe-alert d-flex align-items-center gap-2 alert-dismissible fade show" role="alert" style="background:#fef2f2;color:#991b1b;margin-bottom:0;">
                <i class="fas fa-exclamation-circle" style="font-size:0.8rem;flex-shrink:0;"></i>
                <span><?php echo $this->session->flashdata('error'); ?></span>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" style="font-size:0.55rem;"></button>
            </div>
        <?php endif; ?>
    </div>
