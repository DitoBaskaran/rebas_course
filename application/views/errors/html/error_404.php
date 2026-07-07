<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Halaman Tidak Ditemukan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&family=Plus+Jakarta+Sans:wght@700;800&display=swap" rel="stylesheet">
    <style>
        :root { --primary: #0d6efd; --primary-rgb: 13,110,253; --info: #6366f1; --gray-300: #cbd5e1; --gray-500: #64748b; --gray-700: #334155; }
        body { font-family: 'Inter', sans-serif; background: #f8fafc; display: flex; align-items: center; justify-content: center; min-height: 100vh; margin: 0; }
        .error-code { font-size: 8rem; font-weight: 900; background: linear-gradient(135deg, var(--primary), var(--info)); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; line-height: 1; }
        .card { border: 1px solid rgba(0,0,0,0.05); border-radius: 16px; background: #fff; box-shadow: 0 1px 3px rgba(0,0,0,0.04); }
    </style>
</head>
<body>
    <div style="text-align: center; padding: 2rem; max-width: 480px;">
        <div class="card" style="padding: 3rem 2rem;">
            <div class="error-code">404</div>
            <h2 style="font-weight: 800; color: var(--gray-700); margin: 1rem 0 0.5rem;">Halaman Tidak Ditemukan</h2>
            <p style="color: var(--gray-500); font-size: 0.9rem; margin-bottom: 2rem;">Halaman yang Anda cari mungkin telah dipindahkan atau tidak tersedia.</p>
            <div style="display: flex; gap: 0.75rem; justify-content: center; flex-wrap: wrap;">
                <a href="<?php echo config_item('base_url'); ?>" style="display: inline-flex; align-items: center; gap: 0.5rem; background: linear-gradient(135deg, var(--primary), var(--info)); color: #fff; padding: 0.6rem 1.5rem; border-radius: 6px; text-decoration: none; font-weight: 600; font-size: 0.9rem; box-shadow: 0 4px 14px rgba(13,110,253,0.25);">
                    <i class="fas fa-home"></i> Kembali ke Beranda
                </a>
                <a href="<?php echo base_url('courses'); ?>" style="display: inline-flex; align-items: center; gap: 0.5rem; border: 2px solid var(--primary); color: var(--primary); padding: 0.6rem 1.5rem; border-radius: 6px; text-decoration: none; font-weight: 600; font-size: 0.9rem;">
                    <i class="fas fa-search"></i> Jelajahi Konten
                </a>
            </div>
        </div>
        <p style="color: var(--gray-500); font-size: 0.8rem; margin-top: 1.5rem;">&copy; <?php echo date('Y'); ?> REBAS COURSE</p>
    </div>
</body>
</html>
