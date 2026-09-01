<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Error</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root { --primary: #009688; --primary-rgb: 13,110,253; --info: #0D1830; --gray-500: #64748b; --gray-700: #334155; --danger: #ef4444; }
        body { font-family: 'Inter', sans-serif; background: #E6EBEF; display: flex; align-items: center; justify-content: center; min-height: 100vh; margin: 0; }
        .card { border: 1px solid rgba(0,0,0,0.05); border-radius: 16px; background: #fff; box-shadow: 0 1px 3px rgba(0,0,0,0.04); }
    </style>
</head>
<body>
    <div style="text-align: center; padding: 2rem; max-width: 520px;">
        <div class="card" style="padding: 3rem 2rem;">
            <div style="font-size: 3.5rem; color: var(--danger); margin-bottom: 1rem;">
                <i class="fas fa-exclamation-circle"></i>
            </div>
            <h2 style="font-weight: 800; color: var(--gray-700); margin: 0 0 0.5rem;">PHP Error</h2>
            <p style="color: var(--gray-500); font-size: 0.9rem; margin-bottom: 2rem;"><?php echo $message; ?></p>
            <a href="<?php echo config_item('base_url'); ?>" style="display: inline-flex; align-items: center; gap: 0.5rem; background: linear-gradient(135deg, var(--primary), var(--info)); color: #fff; padding: 0.6rem 1.5rem; border-radius: 6px; text-decoration: none; font-weight: 600; font-size: 0.9rem; box-shadow: 0 4px 14px rgba(13,110,253,0.25);">
                <i class="fas fa-home"></i> Kembali ke Beranda
            </a>
        </div>
    </div>
</body>
</html>
