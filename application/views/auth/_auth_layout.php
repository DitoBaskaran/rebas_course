<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Layout bersama halaman auth BISATUNTAS (login/register/OTP/lupa/reset).
 * Desain: split-screen — panel kiri brand visual (gradient teal, dekoratif),
 * panel kanan kartu form di atas latar pattern halus.
 * Responsif: < 1024px panel visual disembunyikan, kartu full-width ala mobile app.
 *
 * Variabel yang harus diset sebelum include:
 *   $auth_kicker, $auth_title, $auth_subtitle, $auth_icon,
 *   $auth_visual_title, $auth_visual_sub,
 *   $auth_form_action, $auth_form_fields, $auth_submit_text,
 *   $auth_submit_loading, $auth_google_text (opsional),
 *   $auth_footer_text, $auth_footer_link, $auth_footer_url
 */
?>
<div class="bta-wrap">
    <!-- ===== Panel kiri: visual brand ===== -->
    <aside class="bta-side">
        <div class="bta-side-inner">
            <div class="bta-grid-overlay"></div>
            <div class="bta-blob bta-blob-a"></div>
            <div class="bta-blob bta-blob-b"></div>
            <div class="bta-orb bta-orb-1"></div>
            <div class="bta-orb bta-orb-2"></div>

            <div class="bta-side-top">
                <span class="bta-side-chip">
                    <i class="fas fa-circle-check"></i>
                    <?php echo t('Platform Belajar & Konsultasi', 'Learning & Consultation Platform'); ?>
                </span>
            </div>

            <div class="bta-side-mid">
                <div class="bta-hero-icon">
                    <i class="fas <?php echo $auth_icon; ?>"></i>
                </div>
                <h2><?php echo $auth_visual_title; ?></h2>
                <p><?php echo $auth_visual_sub; ?></p>
                <ul class="bta-features">
                    <li><i class="fas fa-check"></i><span><?php echo t('Kelas video terstruktur & mudah dipahami', 'Structured, easy-to-understand video courses'); ?></span></li>
                    <li><i class="fas fa-check"></i><span><?php echo t('Sesi live bersama mentor berpengalaman', 'Live sessions with experienced mentors'); ?></span></li>
                    <li><i class="fas fa-check"></i><span><?php echo t('Akses seumur hidup, belajar di mana saja', 'Lifetime access, learn anywhere'); ?></span></li>
                </ul>
            </div>

            <div class="bta-side-bottom">
                <div class="bta-cats">
                    <span class="bta-cat"><i class="fas fa-book-open"></i> <?php echo t('Kursus', 'Courses'); ?></span>
                    <span class="bta-cat"><i class="fas fa-chalkboard-user"></i> <?php echo t('Seminar', 'Seminars'); ?></span>
                    <span class="bta-cat"><i class="fas fa-comments"></i> <?php echo t('Mentoring', 'Mentoring'); ?></span>
                </div>
                <p class="bta-side-copy"><?php echo t('Selesaikan setiap permasalahanmu secara tuntas bersama BISATUNTAS.', 'Resolve every problem completely with BISATUNTAS.'); ?></p>
            </div>
        </div>
    </aside>

    <!-- ===== Panel kanan: form ===== -->
    <main class="bta-main">
        <div class="bta-card">
            <?php if (!empty($auth_kicker)): ?>
                <div class="bta-kicker"><span class="bta-kicker-dot"></span><?php echo $auth_kicker; ?></div>
            <?php endif; ?>

            <div class="bta-head">
                <h1><?php echo $auth_title; ?></h1>
                <p><?php echo $auth_subtitle; ?></p>
            </div>

            <?php if ($err = $this->session->flashdata('error')): ?>
                <div class="bta-alert bta-alert-error" role="alert">
                    <span class="bta-alert-ic"><i class="fas fa-triangle-exclamation"></i></span>
                    <span class="bta-alert-tx"><?php echo $err; ?></span>
                    <button type="button" class="bta-alert-x" aria-label="Tutup">&times;</button>
                </div>
            <?php endif; ?>
            <?php if ($ok = $this->session->flashdata('success')): ?>
                <div class="bta-alert bta-alert-success" role="alert">
                    <span class="bta-alert-ic"><i class="fas fa-circle-check"></i></span>
                    <span class="bta-alert-tx"><?php echo $ok; ?></span>
                    <button type="button" class="bta-alert-x" aria-label="Tutup">&times;</button>
                </div>
            <?php endif; ?>

            <?php echo form_open($auth_form_action, array('class' => 'bta-form', 'novalidate' => 'novalidate')); ?>
                <?php echo $auth_form_fields; ?>

                <div class="bta-hp" aria-hidden="true">
                    <input type="text" name="website_url" tabindex="-1" autocomplete="off">
                </div>

                <button type="submit" class="bta-btn" data-loading="<?php echo $auth_submit_loading ?? t('Memproses…', 'Processing…'); ?>">
                    <span class="bta-btn-tx"><?php echo $auth_submit_text; ?></span>
                    <i class="fas fa-arrow-right bta-btn-arw"></i>
                </button>
            <?php echo form_close(); ?>

            <?php if (!empty($auth_google_text) && !empty($google_login_url)): ?>
                <div class="bta-or"><span><?php echo t('atau lanjutkan dengan', 'or continue with'); ?></span></div>
                <a href="<?php echo $google_login_url; ?>" class="bta-btn-google">
                    <svg width="17" height="17" viewBox="0 0 24 24" aria-hidden="true"><path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92a5.06 5.06 0 01-2.2 3.32v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.1z" fill="#4285F4"/><path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/><path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/><path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/></svg>
                    <?php echo $auth_google_text; ?>
                </a>
            <?php endif; ?>

            <?php if (!empty($auth_footer_text)): ?>
                <div class="bta-foot">
                    <p><?php echo $auth_footer_text; ?> <a href="<?php echo $auth_footer_url; ?>" class="bta-foot-link"><?php echo $auth_footer_link; ?></a></p>
                </div>
            <?php endif; ?>
        </div>

        <p class="bta-footnote"><?php echo t('© ', '© '); ?><?php echo date('Y'); ?> BISATUNTAS &middot; <?php echo t('Belajar Tuntas, Sukses Pasti', 'Learn Completely, Succeed Surely'); ?></p>
    </main>
</div>

<style>
.bta-wrap{display:grid;grid-template-columns:minmax(0,1.05fr) minmax(0,1fr);min-height:calc(100vh - 56px);background:#f4f7f6;}
/* ============ Panel visual ============ */
.bta-side{position:relative;overflow:hidden;background:linear-gradient(155deg,#06302b 0%,#0b4a3d 38%,#0d7c68 100%);color:#fff;display:flex;align-items:center;justify-content:center;padding:2.8rem 3rem;min-height:calc(100vh - 56px);}
.bta-grid-overlay{position:absolute;inset:0;background-image:linear-gradient(rgba(255,255,255,.05) 1px,transparent 1px),linear-gradient(90deg,rgba(255,255,255,.05) 1px,transparent 1px);background-size:44px 44px;mask-image:radial-gradient(ellipse at 30% 20%,#000 0%,transparent 75%);-webkit-mask-image:radial-gradient(ellipse at 30% 20%,#000 0%,transparent 75%);}
.bta-blob{position:absolute;border-radius:50%;filter:blur(2px);}
.bta-blob-a{width:430px;height:430px;background:radial-gradient(circle,rgba(20,184,166,.28),transparent 65%);top:-120px;right:-110px;}
.bta-blob-b{width:360px;height:360px;background:radial-gradient(circle,rgba(251,191,36,.14),transparent 65%);bottom:-110px;left:-90px;}
.bta-orb{position:absolute;border-radius:14px;border:1px solid rgba(255,255,255,.14);background:rgba(255,255,255,.06);backdrop-filter:blur(4px);animation:btaFloat 7s ease-in-out infinite;}
.bta-orb-1{width:64px;height:64px;top:9%;right:8%;transform:rotate(18deg);animation-delay:.6s;}
.bta-orb-2{width:34px;height:34px;border-radius:50%;bottom:16%;right:14%;animation-delay:2.2s;}
@keyframes btaFloat{0%,100%{transform:translateY(0) rotate(18deg);}50%{transform:translateY(-16px) rotate(28deg);}}
.bta-orb-2{animation-name:btaFloat2;}
@keyframes btaFloat2{0%,100%{transform:translateY(0);}50%{transform:translateY(-14px);}}
.bta-side-inner{position:relative;z-index:2;width:100%;max-width:460px;display:flex;flex-direction:column;min-height:100%;}
.bta-side-chip{display:inline-flex;align-items:center;gap:.45rem;background:rgba(255,255,255,.1);border:1px solid rgba(255,255,255,.18);backdrop-filter:blur(8px);padding:.42rem .8rem;border-radius:99px;font-size:.68rem;font-weight:600;letter-spacing:.02em;color:rgba(255,255,255,.92);}
.bta-side-chip i{color:#fbbf24;font-size:.72rem;}
.bta-side-mid{margin:auto 0;padding:2.2rem 0;}
.bta-hero-icon{width:92px;height:92px;border-radius:26px;background:rgba(255,255,255,.12);border:1px solid rgba(255,255,255,.2);display:flex;align-items:center;justify-content:center;font-size:2rem;color:#fbbf24;box-shadow:0 18px 44px rgba(0,0,0,.22);transform:rotate(-5deg);margin-bottom:1.7rem;transition:transform .4s cubic-bezier(.34,1.56,.64,1);}
.bta-side:hover .bta-hero-icon{transform:rotate(0deg) scale(1.05);}
.bta-side-mid h2{font-size:1.85rem;font-weight:800;letter-spacing:-.03em;line-height:1.2;margin:0 0 .7rem;}
.bta-side-mid p{font-size:.9rem;line-height:1.7;color:rgba(255,255,255,.72);margin:0 0 1.5rem;max-width:400px;}
.bta-features{list-style:none;margin:0;padding:0;display:flex;flex-direction:column;gap:.72rem;}
.bta-features li{display:flex;align-items:center;gap:.65rem;font-size:.83rem;color:rgba(255,255,255,.9);}
.bta-features i{width:20px;height:20px;flex:0 0 auto;border-radius:50%;background:rgba(20,184,166,.35);color:#5eead4;font-size:.58rem;display:inline-flex;align-items:center;justify-content:center;}
.bta-side-bottom{margin-top:1rem;}
.bta-cats{display:flex;flex-wrap:wrap;gap:.5rem;margin-bottom:.9rem;}
.bta-cat{display:inline-flex;align-items:center;gap:.4rem;background:rgba(255,255,255,.08);border:1px solid rgba(255,255,255,.16);padding:.38rem .7rem;border-radius:10px;font-size:.7rem;font-weight:600;color:rgba(255,255,255,.92);}
.bta-cat i{color:#5eead4;font-size:.68rem;}
.bta-side-copy{font-size:.72rem;color:rgba(255,255,255,.55);margin:0;line-height:1.6;}
/* ============ Panel form ============ */
.bta-main{position:relative;display:flex;flex-direction:column;align-items:center;justify-content:center;padding:2.6rem 1.4rem 1.4rem;background:radial-gradient(circle at 12% 8%,rgba(13,148,136,.07),transparent 42%),radial-gradient(circle at 92% 96%,rgba(13,148,136,.07),transparent 42%),#f4f7f6;}
.bta-main::before{content:'';position:absolute;inset:0;background-image:radial-gradient(rgba(15,23,42,.05) 1px,transparent 1px);background-size:22px 22px;pointer-events:none;}
.bta-card{position:relative;z-index:1;width:100%;max-width:430px;background:#fff;border:1px solid #e6edec;border-radius:22px;box-shadow:0 24px 70px -24px rgba(6,48,43,.28);padding:2.35rem 2.3rem 1.6rem;}
.bta-kicker{display:flex;align-items:center;gap:.45rem;font-size:.64rem;font-weight:800;letter-spacing:.14em;text-transform:uppercase;color:#0d9488;margin-bottom:.85rem;}
.bta-kicker-dot{width:7px;height:7px;border-radius:50%;background:#0d9488;box-shadow:0 0 0 4px rgba(13,148,136,.15);}
.bta-head h1{font-size:1.45rem;font-weight:800;letter-spacing:-.03em;color:#0f172a;margin:0 0 .32rem;}
.bta-head p{font-size:.85rem;color:#64748b;line-height:1.55;margin:0 0 1.35rem;}
.bta-alert{display:flex;align-items:flex-start;gap:.6rem;padding:.72rem .85rem;border-radius:12px;font-size:.8rem;line-height:1.5;margin-bottom:1.1rem;animation:btaPop .25s ease;}
@keyframes btaPop{from{opacity:0;transform:translateY(-4px);}to{opacity:1;transform:translateY(0);}}
.bta-alert-error{background:#fef2f2;border:1px solid #fecaca;color:#b91c1c;}
.bta-alert-success{background:#f0fdf4;border:1px solid #bbf7d0;color:#15803d;}
.bta-alert-ic{flex:0 0 auto;margin-top:.08rem;}
.bta-alert-x{margin-left:auto;background:none;border:none;color:inherit;opacity:.55;font-size:1.05rem;line-height:1;cursor:pointer;padding:0 0 0 .4rem;}
.bta-alert-x:hover{opacity:1;}
.bta-form .bta-field{margin-bottom:1rem;}
.bta-form label{display:block;font-size:.78rem;font-weight:600;color:#334155;margin-bottom:.4rem;}
.bta-input-wrap{position:relative;}
.bta-input{width:100%;height:47px;padding:.72rem 2.85rem .72rem 2.7rem;border:1.5px solid #e2e8f0;border-radius:13px;font-size:.88rem;color:#0f172a;background:#f8fafc;outline:none;transition:border-color .18s,box-shadow .18s,background .18s;font-family:inherit;}
.bta-input::placeholder{color:#a3b1c6;}
.bta-input:focus{border-color:#0d9488;background:#fff;box-shadow:0 0 0 4px rgba(13,148,136,.13);}
.bta-input.bta-invalid{border-color:#f87171;background:#fffbfb;box-shadow:0 0 0 4px rgba(248,113,113,.12);}
.bta-input-wrap > i{position:absolute;left:1rem;top:50%;transform:translateY(-50%);color:#94a3b8;font-size:.85rem;pointer-events:none;transition:color .18s;}
.bta-input-wrap:focus-within > i{color:#0d9488;}
.bta-input-wrap.has-eye .bta-input{padding-right:2.85rem;}
.bta-eye{position:absolute;right:.55rem;top:50%;transform:translateY(-50%);width:32px;height:32px;display:inline-flex;align-items:center;justify-content:center;background:none;border:none;color:#94a3b8;cursor:pointer;font-size:.82rem;border-radius:8px;z-index:1;}
.bta-eye:hover{background:#f1f5f9;color:#475569;}
.bta-err{display:flex;align-items:flex-start;gap:.35rem;font-size:.73rem;font-weight:500;color:#dc2626;margin-top:.42rem;line-height:1.4;}
.bta-err i{font-size:.62rem;margin-top:.2rem;}
.bta-extra{display:flex;align-items:center;justify-content:space-between;margin:.1rem 0 1.15rem;font-size:.78rem;gap:.5rem;}
.bta-extra .bta-rem{display:flex;align-items:center;gap:.42rem;color:#475569;font-weight:500;cursor:pointer;margin:0;}
.bta-extra .bta-rem input{width:15px;height:15px;accent-color:#0d9488;margin:0;cursor:pointer;}
.bta-forgot{color:#0d9488;font-weight:600;text-decoration:none;white-space:nowrap;}
.bta-forgot:hover{text-decoration:underline;color:#0f766e;}
.bta-btn{width:100%;height:49px;margin-top:.15rem;background:linear-gradient(135deg,#0d9488,#0b6b5c);color:#fff;border:none;border-radius:13px;font-weight:700;font-size:.9rem;cursor:pointer;font-family:inherit;display:flex;align-items:center;justify-content:center;gap:.6rem;box-shadow:0 10px 26px -8px rgba(13,148,136,.5);transition:transform .18s,box-shadow .18s,filter .18s;}
.bta-btn:hover{transform:translateY(-1px);box-shadow:0 14px 30px -8px rgba(13,148,136,.55);}
.bta-btn:active{transform:translateY(0);}
.bta-btn:disabled{opacity:.75;cursor:not-allowed;transform:none;}
.bta-btn-arw{transition:transform .2s;}
.bta-btn:hover .bta-btn-arw{transform:translateX(4px);}
.bta-spin{width:15px;height:15px;border:2px solid rgba(255,255,255,.4);border-top-color:#fff;border-radius:50%;animation:btaSpin .7s linear infinite;display:inline-block;}
@keyframes btaSpin{to{transform:rotate(360deg);}}
.bta-or{display:flex;align-items:center;gap:.9rem;margin:1.15rem 0;}
.bta-or::before,.bta-or::after{content:'';flex:1;height:1px;background:#edf2f7;}
.bta-or span{font-size:.68rem;color:#94a3b8;font-weight:500;text-transform:uppercase;letter-spacing:.05em;}
.bta-btn-google{width:100%;height:47px;display:flex;align-items:center;justify-content:center;gap:.65rem;background:#fff;color:#334155;border:1.5px solid #e2e8f0;border-radius:13px;font-weight:600;font-size:.85rem;text-decoration:none;font-family:inherit;transition:background .18s,border-color .18s;}
.bta-btn-google:hover{background:#f8fafc;border-color:#cbd5e1;}
.bta-foot{margin-top:1.3rem;padding-top:1.1rem;border-top:1px dashed #e9eef2;text-align:center;}
.bta-foot p{font-size:.82rem;color:#64748b;margin:0;}
.bta-foot-link{color:#0d9488;font-weight:700;text-decoration:none;}
.bta-foot-link:hover{text-decoration:underline;color:#0f766e;}
.bta-footnote{position:relative;z-index:1;font-size:.68rem;color:#94a3b8;margin:1.1rem 0 0;text-align:center;}
.bta-note{font-size:.72rem;color:#94a3b8;display:block;margin-top:.4rem;}
/* Honeypot anti-spam: sembunyikan dari mata & interaksi, tetap ada di DOM */
.bta-hp{position:absolute;left:-9999px;top:auto;width:1px;height:1px;overflow:hidden;opacity:0;pointer-events:none;}
/* ============ Responsive ============ */
@media (max-width:1023px){
  .bta-side{display:none;}
  .bta-wrap{grid-template-columns:1fr;min-height:calc(100vh - 56px);background:radial-gradient(circle at 50% -10%,rgba(13,148,136,.12),transparent 55%),#f4f7f6;}
  .bta-main{padding:2rem 1.1rem 1.2rem;background:transparent;justify-content:flex-start;}
  .bta-card{margin:0 auto;padding:1.9rem 1.4rem 1.4rem;box-shadow:0 18px 50px -20px rgba(6,48,43,.3);}
}
@media (max-width:360px){
  .bta-card{padding:1.6rem 1.05rem 1.25rem;}
  .bta-extra{flex-wrap:wrap;row-gap:.35rem;}
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // 1) Toggle tampil/sembunyi password
    document.querySelectorAll('.bta-eye').forEach(function (btn) {
        btn.addEventListener('click', function () {
            var inp = btn.parentElement.querySelector('input');
            var ic = btn.querySelector('i');
            var show = inp.type === 'password';
            inp.type = show ? 'text' : 'password';
            ic.className = show ? 'fas fa-eye-slash' : 'fas fa-eye';
        });
    });

    // 2) Tutup alert
    document.querySelectorAll('.bta-alert-x').forEach(function (x) {
        x.addEventListener('click', function () {
            var al = x.closest('.bta-alert');
            if (al) { al.style.transition = 'opacity .2s'; al.style.opacity = '0'; setTimeout(function(){ al.remove(); }, 200); }
        });
    });

    // 3) State loading saat submit (cegah dobel kirim)
    document.querySelectorAll('.bta-form').forEach(function (f) {
        f.addEventListener('submit', function () {
            var b = f.querySelector('button[type="submit"]');
            if (!b || b.disabled) return;
            b.disabled = true;
            var loading = b.getAttribute('data-loading') || 'Processing…';
            b.innerHTML = '<span class="bta-spin"></span> ' + loading;
        });
    });
});
</script>
