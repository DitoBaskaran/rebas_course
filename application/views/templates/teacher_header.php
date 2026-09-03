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
    <!-- SweetAlert2 -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    <!-- BISATUNTAS Design System v3.0 -->
    <link rel="stylesheet" href="<?php echo base_url('assets/css/bisatuntas.css?v=32'); ?>">
    <!-- BISATUNTAS Colorful Playful Override -->
    <link rel="stylesheet" href="<?php echo base_url('assets/css/bisatuntas-playful-alt.css?v=2'); ?>">
    <!-- TinyMCE for rich text editing -->
    <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        if (typeof tinymce !== 'undefined' && document.querySelector('.tinymce')) {
            tinymce.init({
                selector: '.tinymce',
                plugins: 'advlist autolink lists link image charmap preview anchor searchreplace visualblocks code fullscreen insertdatetime media table code help wordcount',
                toolbar: 'undo redo | blocks | bold italic underline strikethrough | align bullist numlist | link image media | code | removeformat',
                height: 300,
                branding: false,
                promotion: false,
                menubar: false,
                statusbar: true,
                content_style: "body { font-family: Inter, sans-serif; font-size: 14px; line-height: 1.6; color: #1e293b; }"
            });
        }
    });
    </script>
    <style>
        :root {
            <?php echo settings_css_vars(); ?>
        }
        .role-badge { padding: 0.25rem 0.5rem; border-radius: 999px; font-size: 0.6rem; font-weight: 600; display: inline-block; line-height: 1.4; }
        .role-badge-admin { background: #fef2f2; color: #f43f5e; }
        .role-badge-teacher { background: #fff7ed; color: #0D1830; }
        .role-badge-mentor { background: #faf5ff; color: #a855f7; }
        .role-badge-student { background: #E0F2F1; color: #009688; }
        .status-badge { padding: 0.25rem 0.5rem; border-radius: 999px; font-size: 0.6rem; font-weight: 600; display: inline-block; line-height: 1.4; }
        .status-badge-active { background: #E0F2F1; color: #009688; }
        .status-badge-banned { background: #fef2f2; color: #f43f5e; }
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
<body class="playful has-bottom-nav">

    <!-- Top Bar -->
    <nav class="admin-topbar">
        <div class="admin-topbar-inner">
            <div class="admin-topbar-start">
                <button class="admin-topbar-toggle d-lg-none" onclick="toggleAdminSidebar()" aria-label="Toggle sidebar">
                    <i data-lucide="menu" style="width:18px;height:18px;"></i>
                </button>
                <button class="admin-topbar-toggle d-none d-lg-inline-flex" id="sidebarToggle" aria-label="Toggle sidebar">
                    <i data-lucide="panel-left-close" style="width:18px;height:18px;"></i>
                </button>
                <a href="<?php echo base_url('teacher/dashboard'); ?>" class="admin-topbar-brand">
                    <?php $logo_url = site_logo_url(); if ($logo_url): ?>
                        <img src="<?php echo $logo_url; ?>" alt="Logo" class="admin-topbar-logo">
                    <?php else: ?>
                        <img src="<?php echo base_url('assets/img/bisatuntas-logo-v2.png'); ?>" alt="BISATUNTAS" style="height:26px;width:auto;">
                    <?php endif; ?>
                </a>
            </div>
            <div class="admin-topbar-end">
                <!-- Command Palette -->
                <button class="admin-topbar-action" id="cmdTrigger" title="Search (Cmd+K)">
                    <i data-lucide="search" style="width:18px;height:18px;"></i>
                </button>
                <!-- Website Link -->
                <a href="<?php echo base_url(); ?>" class="admin-topbar-action d-none d-md-inline-flex" target="_blank" title="<?php echo t('Lihat Website', 'View Website'); ?>">
                    <i data-lucide="external-link" style="width:18px;height:18px;"></i>
                </a>
                <!-- Profile Dropdown -->
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

    <!-- Flash Messages (toast) -->
    <?php if ($this->session->flashdata('success')): ?>
        <div class="d-none flash-toast" data-toast="success" data-message="<?php echo htmlspecialchars($this->session->flashdata('success'), ENT_QUOTES, 'UTF-8'); ?>"></div>
    <?php endif; ?>
    <?php if ($this->session->flashdata('error')): ?>
        <div class="d-none flash-toast" data-toast="error" data-message="<?php echo htmlspecialchars($this->session->flashdata('error'), ENT_QUOTES, 'UTF-8'); ?>"></div>
    <?php endif; ?>

    <!-- Teacher Wrapper -->
    <div class="admin-wrapper playful" id="teacherWrapper">
        <?php $this->load->view('templates/teacher_sidebar'); ?>
        <div class="admin-content">

    <!-- Command Palette -->
    <div class="cmd-palette-overlay" id="cmdPalette">
        <div class="cmd-palette">
            <div class="cmd-palette-input-wrapper">
                <i data-lucide="search" style="width:20px;height:20px;"></i>
                <input type="text" class="cmd-palette-input" id="cmdPaletteInput" placeholder="Type to search pages..." autocomplete="off">
                <span class="cmd-palette-shortcut">ESC</span>
            </div>
            <div class="cmd-palette-results" id="cmdResults"></div>
        </div>
    </div>