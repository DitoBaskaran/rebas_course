<?php $site_settings = settings(); ?>
<?php $cat_colors = array('#009688', '#FBBF24', '#0D1830', '#009688', '#FBBF24', '#0D1830', '#009688', '#FBBF24'); ?>

<style>
/* ============================================================
   BISATUNTAS — Startup Landing (Prompt Tailwind structure)
   Palet: Navy #0D1830 | Teal #009688 | Amber #FBBF24 | Abu #E6EBEF
   ============================================================ */
:root{
  --bt-navy:#0D1830;
  --bt-teal:#009688;
  --bt-teal-dark:#00796B;
  --bt-amber:#FBBF24;
  --bt-amber-soft:#FEF3C7;
  --bt-gray:#E6EBEF;
  --bt-text:#334155;
  --bt-muted:#64748b;
}
/* ===== HERO (light, yellow-soft gradient + underline highlight) ===== */
.bt-hero{position:relative;background:linear-gradient(to bottom,rgba(251,191,36,0.16) 0%,rgba(251,191,36,0.05) 55%,#ffffff 100%);padding:9rem 0 5rem;overflow:hidden;}
.bt-hero::before{content:'';position:absolute;width:520px;height:520px;border-radius:50%;background:radial-gradient(circle,rgba(0,150,136,0.10) 0%,transparent 65%);top:-160px;right:-120px;pointer-events:none;}
.bt-hero-inner{display:grid;grid-template-columns:3fr 4fr;gap:4rem;align-items:center;position:relative;z-index:1;}
.bt-hero-title{font-size:2.6rem;line-height:1.15;font-weight:700;letter-spacing:-0.035em;color:var(--bt-navy);margin:0 0 1.1rem;}
.bt-hero-title .bt-mark{position:relative;z-index:0;color:var(--bt-navy);white-space:nowrap;}
.bt-hero-title .bt-mark::after{content:'';position:absolute;z-index:-1;left:0;right:0;bottom:0.08em;height:0.55em;background:rgba(251,191,36,0.45);border-radius:4px;}
.bt-hero-sub{font-size:0.95rem;color:var(--bt-muted);max-width:460px;margin:0 0 2.2rem;line-height:1.7;}
.bt-hero-cta{display:flex;gap:0.8rem;flex-wrap:wrap;}
.bt-btn{border-radius:8px;padding:0.7rem 1.4rem;font-size:0.88rem;font-weight:600;display:inline-flex;align-items:center;gap:8px;text-decoration:none;transition:all 0.3s ease;cursor:pointer;border:none;font-family:inherit;}
.bt-btn i{font-size:0.8rem;}
.bt-btn-solid{background:var(--bt-teal);color:#fff;}
.bt-btn-solid:hover{background:var(--bt-teal-dark);color:#fff;box-shadow:0 12px 26px rgba(0,150,136,0.35);transform:translateY(-2px);}
.bt-btn-outline{border:1.5px solid var(--bt-teal);color:var(--bt-teal);background:transparent;}
.bt-btn-outline:hover{background:var(--bt-teal);color:#fff;box-shadow:0 12px 26px rgba(0,150,136,0.35);transform:translateY(-2px);}
.bt-btn-dark{background:var(--bt-navy);color:#fff;}
.bt-btn-dark:hover{background:#152447;color:#fff;box-shadow:0 12px 26px rgba(13,24,48,0.35);transform:translateY(-2px);}
.bt-btn-amber{background:var(--bt-amber);color:var(--bt-navy);}
.bt-btn-amber:hover{background:#f6a800;color:var(--bt-navy);box-shadow:0 12px 26px rgba(251,191,36,0.4);transform:translateY(-2px);}
.bt-hero-visual{position:relative;}
.bt-hero-visual img{width:100%;max-width:520px;display:block;margin:0 auto;border-radius:16px;box-shadow:0 30px 60px rgba(13,24,48,0.16);}
.bt-hero-chip{position:absolute;display:flex;align-items:center;gap:10px;background:#fff;border-radius:14px;padding:0.75rem 1rem;box-shadow:0 16px 40px rgba(13,24,48,0.12);animation:btFloat 5.5s ease-in-out infinite;}
.bt-hero-chip i{font-size:1rem;}
.bt-chip-1{top:-14px;left:-10px;}
.bt-chip-1 i{color:var(--bt-amber);}
.bt-chip-2{bottom:-18px;right:-6px;animation-delay:1.6s;}
.bt-chip-2 i{color:var(--bt-teal);}
.bt-hero-chip strong{display:block;font-size:0.78rem;color:var(--bt-navy);line-height:1.2;}
.bt-hero-chip span{font-size:0.64rem;color:var(--bt-muted);}
@keyframes btFloat{0%,100%{transform:translateY(0)}50%{transform:translateY(-11px)}}
/* ===== CLIENTS ===== */
.bt-clients{padding:3rem 0;}
.bt-clients-text{text-align:center;font-size:0.95rem;font-weight:600;color:var(--bt-navy);margin-bottom:1.6rem;}
.bt-clients-text span{color:var(--bt-teal);}
.bt-clients-logos{display:flex;flex-wrap:wrap;justify-content:center;gap:2.6rem;opacity:0.55;filter:grayscale(100%);}
.bt-clients-logos span{display:flex;align-items:center;gap:7px;font-size:0.95rem;font-weight:700;color:#334155;}
.bt-clients-logos i{font-size:1.25rem;}
/* ===== FEATURE SPLIT ===== */
.bt-feature{padding:4.5rem 0;overflow-x:hidden;}
.bt-feature-grid{display:grid;grid-template-columns:1fr 1fr;gap:3.5rem;align-items:center;}
.bt-chip-tag{display:inline-block;font-size:0.72rem;font-weight:700;background:rgba(0,150,136,0.10);color:var(--bt-teal);border-radius:99px;padding:0.3rem 0.8rem;margin-bottom:0.9rem;}
.bt-chip-tag-amber{background:rgba(251,191,36,0.14);color:#b45309;}
.bt-feature-title{font-size:1.85rem;font-weight:600;letter-spacing:-0.02em;color:var(--bt-navy);margin:0 0 0.8rem;line-height:1.25;}
.bt-feature-desc{font-size:0.92rem;color:var(--bt-muted);line-height:1.7;margin:0 0 1.8rem;}
.bt-feature-media img{width:100%;border-radius:14px;box-shadow:0 22px 48px rgba(13,24,48,0.12);display:block;}
/* ===== INTEGRATIONS / SERVICES GRID ===== */
.bt-integrations{background:var(--bt-gray);padding:4.5rem 0;}
.bt-center{text-align:center;}
.bt-title{font-size:1.85rem;font-weight:600;letter-spacing:-0.02em;color:var(--bt-navy);margin:0.7rem 0 0.6rem;}
.bt-sub{font-size:0.92rem;color:var(--bt-muted);margin:0;}
.bt-sub .bt-teal{color:var(--bt-teal);font-weight:600;}
.bt-grid-2{display:grid;grid-template-columns:1fr 1fr;gap:1.5rem;margin-top:3rem;}
.bt-integ-card{background:#fff;border-radius:12px;padding:1.3rem;display:flex;gap:1.1rem;align-items:flex-start;box-shadow:0 2px 10px rgba(13,24,48,0.05);transition:all 0.25s ease;text-decoration:none;color:inherit;}
.bt-integ-card:hover{transform:translateY(-3px);box-shadow:0 16px 34px rgba(13,24,48,0.10);}
.bt-integ-icon{width:56px;height:56px;border-radius:14px;display:flex;align-items:center;justify-content:center;font-size:1.25rem;color:#fff;flex-shrink:0;background:linear-gradient(135deg,var(--bt-teal),var(--bt-navy));}
.bt-integ-icon.alt{background:linear-gradient(135deg,var(--bt-amber),#f59e0b);color:var(--bt-navy);}
.bt-integ-icon.navy{background:linear-gradient(135deg,var(--bt-navy),#233358);}
.bt-integ-icon.soft{background:linear-gradient(135deg,#E0F2F1,var(--bt-teal));}
.bt-integ-card h5{font-size:0.95rem;font-weight:700;color:var(--bt-navy);margin:0 0 0.4rem;}
.bt-integ-card p{font-size:0.8rem;color:var(--bt-muted);line-height:1.55;margin:0;}
/* ===== COURSES (portfolio-style grid) ===== */
.bt-courses{padding:4.5rem 0;}
.bt-course-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:1.2rem;margin-top:3rem;}
.bt-course-card{display:flex;flex-direction:column;border:1px solid #eef1f5;border-radius:16px;overflow:hidden;text-decoration:none;color:inherit;background:#fff;transition:transform 0.22s ease,box-shadow 0.22s ease;}
.bt-course-card:hover{transform:translateY(-4px);box-shadow:0 18px 38px rgba(13,24,48,0.10);}
.bt-course-img{position:relative;aspect-ratio:16/10;overflow:hidden;background:#f4f6f9;}
.bt-course-img img{width:100%;height:100%;object-fit:cover;transition:transform 0.35s;}
.bt-course-card:hover .bt-course-img img{transform:scale(1.05);}
.bt-course-badge{position:absolute;top:10px;left:10px;background:rgba(255,255,255,0.94);color:var(--bt-navy);font-size:0.6rem;font-weight:700;padding:0.22rem 0.55rem;border-radius:6px;}
.bt-course-price{position:absolute;top:10px;right:10px;background:rgba(0,150,136,0.92);color:#fff;font-size:0.62rem;font-weight:700;padding:0.22rem 0.55rem;border-radius:6px;}
.bt-course-body{padding:0.9rem;display:flex;flex-direction:column;flex:1;}
.bt-course-meta{display:flex;gap:9px;font-size:0.65rem;color:#94a3b8;margin-bottom:0.4rem;}
.bt-course-meta i{font-size:0.55rem;color:var(--bt-teal);margin-right:2px;}
.bt-course-title{font-size:0.85rem;font-weight:700;color:var(--bt-navy);margin:0 0 0.5rem;line-height:1.4;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;}
.bt-course-foot{display:flex;justify-content:space-between;align-items:center;margin-top:auto;font-size:0.82rem;font-weight:700;color:var(--bt-navy);}
.bt-course-free{color:var(--bt-teal);font-weight:600;}
.bt-learn{width:28px;height:28px;border-radius:8px;background:var(--bt-gray);color:var(--bt-teal);display:inline-flex;align-items:center;justify-content:center;font-size:0.65rem;transition:all 0.2s;}
.bt-course-card:hover .bt-learn{background:var(--bt-teal);color:#fff;}
/* ===== STEPS (3 angka) ===== */
.bt-steps-section{background:var(--bt-navy);padding:4.5rem 0;position:relative;overflow:hidden;}
.bt-steps-section::before{content:'';position:absolute;width:420px;height:420px;border-radius:50%;background:radial-gradient(circle,rgba(251,191,36,0.12),transparent 70%);top:-140px;right:-90px;}
.bt-steps-section .bt-title{color:#fff;}
.bt-steps-section .bt-sub{color:rgba(255,255,255,0.65);}
.bt-steps{display:grid;grid-template-columns:repeat(3,1fr);gap:2rem;margin-top:3.2rem;position:relative;z-index:1;}
.bt-step{text-align:center;padding:1.8rem 1.2rem;}
.bt-step-num{width:52px;height:52px;border-radius:50%;background:var(--bt-amber);color:var(--bt-navy);font-weight:800;font-size:1rem;display:flex;align-items:center;justify-content:center;margin:0 auto 1.3rem;box-shadow:0 0 0 8px rgba(251,191,36,0.14);}
.bt-step-icon{width:58px;height:58px;border-radius:16px;background:rgba(255,255,255,0.08);border:1px solid rgba(255,255,255,0.16);display:flex;align-items:center;justify-content:center;font-size:1.25rem;color:var(--bt-amber);margin:0 auto 1rem;}
.bt-step h5{font-size:0.95rem;font-weight:700;color:#fff;margin:0 0 0.45rem;}
.bt-step p{font-size:0.8rem;color:rgba(255,255,255,0.6);line-height:1.6;margin:0;}
/* ===== PRICING TABLE ===== */
.bt-pricing{padding:4.5rem 0;}
.bt-price-table{width:100%;border-collapse:collapse;margin-top:3rem;min-width:640px;}
.bt-price-table th,.bt-price-table td{padding:0.95rem 1rem;text-align:center;border-bottom:1px solid #eef1f5;font-size:0.85rem;color:var(--bt-text);}
.bt-price-table thead th{background:#fff;border-top:2px solid #eef1f5;}
.bt-price-table th:first-child,.bt-price-table td:first-child{text-align:left;width:40%;}
.bt-price-table th h5{font-size:0.98rem;font-weight:700;color:var(--bt-navy);margin:0;}
.bt-price-table th p{font-size:0.72rem;color:var(--bt-muted);margin:0.2rem 0 0;}
.bt-price-table td:first-child{color:var(--bt-text);}
.bt-price-check{color:#16a34a;font-size:0.9rem;}
.bt-popular-badge{display:inline-block;font-size:0.6rem;font-weight:700;background:var(--bt-amber);color:var(--bt-navy);border-radius:99px;padding:0.2rem 0.6rem;margin-left:6px;vertical-align:middle;}
.bt-addon{display:inline-block;font-size:0.62rem;font-weight:700;background:rgba(0,150,136,0.10);color:var(--bt-teal);border-radius:99px;padding:0.18rem 0.55rem;}
.bt-col-popular{background:rgba(251,191,36,0.05);}
/* ===== TESTIMONIALS ===== */
.bt-testi-section{background:var(--bt-gray);padding:4.5rem 0;}
.bt-testi-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:1.4rem;margin-top:3rem;}
.bt-testi{border-radius:16px;padding:1.5rem;background:#fff;box-shadow:0 2px 10px rgba(13,24,48,0.05);}
.bt-testi .bt-stars{display:flex;gap:3px;margin-bottom:0.8rem;}
.bt-testi .bt-stars i{font-size:0.75rem;color:var(--bt-amber);}
.bt-testi p{font-size:0.82rem;color:#475569;line-height:1.65;margin:0 0 1.1rem;font-style:italic;}
.bt-testi-by{display:flex;align-items:center;gap:10px;}
.bt-avatar{width:38px;height:38px;border-radius:50%;color:#fff;font-size:0.68rem;font-weight:700;display:flex;align-items:center;justify-content:center;flex-shrink:0;}
.bt-testi-by strong{display:block;font-size:0.8rem;color:var(--bt-navy);}
.bt-testi-by small{font-size:0.68rem;color:var(--bt-muted);}
/* ===== FOOTER CTA ===== */
.bt-cta-section{padding:4rem 0;}
.bt-cta{display:flex;align-items:center;justify-content:space-between;gap:1.5rem;flex-wrap:wrap;background:linear-gradient(120deg,var(--bt-navy),#12306b 60%,var(--bt-teal));border-radius:18px;padding:2.4rem 2.6rem;box-shadow:0 24px 60px rgba(13,24,48,0.28);position:relative;overflow:hidden;}
.bt-cta::after{content:'';position:absolute;width:300px;height:300px;border-radius:50%;background:radial-gradient(circle,rgba(251,191,36,0.18),transparent 65%);top:-120px;right:-80px;}
.bt-cta h2{font-size:1.5rem;font-weight:700;color:#fff;margin:0 0 0.4rem;}
.bt-cta p{font-size:0.86rem;color:rgba(255,255,255,0.75);margin:0;}
.bt-cta .bt-btn{position:relative;z-index:1;}
/* ===== AI RECOMMENDATION (interactive wow) ===== */
.bt-ai-section{background:linear-gradient(180deg,#ffffff,#f0fdfa 100%);padding:4.5rem 0;}
.bt-ai-box{max-width:760px;margin:2.6rem auto 0;background:#fff;border:1px solid #e4ecef;border-radius:22px;padding:2rem;box-shadow:0 24px 60px rgba(13,24,48,0.10);position:relative;}
.bt-ai-box::before{content:'';position:absolute;inset:-1px;border-radius:22px;padding:1.5px;background:linear-gradient(120deg,var(--bt-teal),var(--bt-amber));-webkit-mask:linear-gradient(#fff 0 0) content-box,linear-gradient(#fff 0 0);-webkit-mask-composite:xor;mask-composite:exclude;pointer-events:none;}
.bt-ai-label{display:flex;align-items:center;gap:8px;font-size:0.72rem;font-weight:700;letter-spacing:0.04em;text-transform:uppercase;color:var(--bt-teal);margin-bottom:0.8rem;}
.bt-ai-label i{color:var(--bt-amber);}
.bt-ai-inputwrap{display:flex;gap:0.6rem;flex-wrap:wrap;}
.bt-ai-inputwrap input{flex:1;min-width:220px;border:1.5px solid #d7e2e6;border-radius:10px;padding:0.72rem 1rem;font-size:0.88rem;font-family:inherit;transition:border 0.2s;}
.bt-ai-inputwrap input:focus{outline:none;border-color:var(--bt-teal);box-shadow:0 0 0 3px rgba(0,150,136,0.12);}
.bt-ai-inputwrap .bt-btn{white-space:nowrap;}
.bt-ai-hint{font-size:0.7rem;color:var(--bt-muted);margin:0.6rem 0 0;}
.bt-ai-result{margin-top:1.1rem;display:none;}
.bt-ai-loading{display:none;align-items:center;gap:10px;color:var(--bt-muted);font-size:0.84rem;margin-top:1.1rem;}
.bt-ai-loading .spinner{width:16px;height:16px;border:2.5px solid #d1e7e6;border-top-color:var(--bt-teal);border-radius:50%;animation:btSpin 0.7s linear infinite;}
@keyframes btSpin{to{transform:rotate(360deg)}}
.bt-ai-msg{background:#f0fdfa;border:1px solid #ccfbf1;border-radius:12px;padding:0.9rem 1.1rem;font-size:0.86rem;line-height:1.65;color:#134e4a;margin-bottom:0.9rem;display:none;}
.bt-ai-cards{display:flex;flex-direction:column;gap:0.7rem;}
.bt-ai-mentor{display:flex;align-items:center;gap:0.9rem;background:#fff;border:1px solid #e8eef1;border-radius:14px;padding:0.85rem 1rem;text-decoration:none;transition:all 0.2s;}
.bt-ai-mentor:hover{border-color:var(--bt-teal);box-shadow:0 10px 24px rgba(13,24,48,0.08);transform:translateY(-2px);}
.bt-ai-avatar{width:44px;height:44px;border-radius:50%;display:flex;align-items:center;justify-content:center;color:#fff;font-weight:700;font-size:0.85rem;flex-shrink:0;background:linear-gradient(135deg,var(--bt-teal),var(--bt-navy));}
.bt-ai-mentor h6{font-size:0.86rem;font-weight:700;color:var(--bt-navy);margin:0;}
.bt-ai-mentor small{font-size:0.7rem;color:var(--bt-muted);display:block;margin-top:1px;}
.bt-ai-go{margin-left:auto;width:34px;height:34px;border-radius:10px;background:var(--bt-amber);color:var(--bt-navy);display:flex;align-items:center;justify-content:center;font-size:0.72rem;flex-shrink:0;}
.bt-ai-login-note{font-size:0.74rem;color:var(--bt-muted);text-align:center;margin-top:0.9rem;}
.bt-ai-login-note a{color:var(--bt-teal);font-weight:700;text-decoration:none;}
/* ===== MENTOR GRID ===== */
.bt-mentors{background:var(--bt-gray);padding:4.5rem 0;}
.bt-mentor-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:1.3rem;margin-top:3rem;}
.bt-mentor-card{background:#fff;border-radius:16px;overflow:hidden;text-decoration:none;color:inherit;transition:all 0.22s ease;border:1px solid #eef1f5;display:flex;flex-direction:column;}
.bt-mentor-card:hover{transform:translateY(-4px);box-shadow:0 18px 38px rgba(13,24,48,0.12);border-color:transparent;}
.bt-mentor-head{padding:1.4rem 1.2rem 1rem;text-align:center;background:linear-gradient(180deg,#f4f8f9,#fff);}
.bt-mentor-avatar{width:74px;height:74px;border-radius:50%;margin:0 auto 0.7rem;display:flex;align-items:center;justify-content:center;color:#fff;font-size:1.3rem;font-weight:700;box-shadow:0 8px 20px rgba(13,24,48,0.18);}
.bt-mentor-name{font-size:0.92rem;font-weight:700;color:var(--bt-navy);margin:0;}
.bt-mentor-title{font-size:0.7rem;color:var(--bt-muted);margin:0.15rem 0 0;}
.bt-mentor-body{padding:0.9rem 1.2rem 1.2rem;display:flex;flex-direction:column;gap:0.6rem;flex:1;}
.bt-mentor-cats{display:flex;flex-wrap:wrap;gap:5px;justify-content:center;}
.bt-mentor-cats span{font-size:0.6rem;font-weight:700;background:rgba(0,150,136,0.09);color:var(--bt-teal);padding:0.2rem 0.55rem;border-radius:99px;}
.bt-mentor-rate{display:flex;align-items:center;justify-content:center;gap:6px;font-size:0.75rem;color:#475569;}
.bt-mentor-rate i{color:var(--bt-amber);font-size:0.7rem;}
.bt-mentor-rate strong{color:var(--bt-navy);}
.bt-mentor-foot{border-top:1px solid #f0f3f6;padding:0.8rem 1.2rem;display:flex;justify-content:space-between;align-items:center;}
.bt-mentor-price{font-size:0.72rem;color:var(--bt-muted);}
.bt-mentor-price strong{font-size:0.85rem;color:var(--bt-teal);display:block;}
.bt-mentor-book{font-size:0.7rem;font-weight:700;color:var(--bt-teal);}
.bt-mentor-book i{margin-left:3px;}
/* ===== MENTOR STEPS (dark, reuse steps) ===== */
.bt-steps-mentor .bt-step-icon i{color:var(--bt-amber);}
/* responsive */
@media (max-width:992px){
  .bt-hero{padding:7rem 0 4rem;}
  .bt-hero-inner{grid-template-columns:1fr;gap:3rem;}
  .bt-hero-title{font-size:2.1rem;}
  .bt-feature-grid{grid-template-columns:1fr;gap:2rem;}
  .bt-feature-media{order:-1;}
  .bt-grid-2{grid-template-columns:1fr;}
  .bt-course-grid{grid-template-columns:repeat(2,1fr);}
  .bt-steps{grid-template-columns:1fr;max-width:440px;margin-left:auto;margin-right:auto;}
  .bt-testi-grid{grid-template-columns:1fr;}
  .bt-mentor-grid{grid-template-columns:repeat(2,1fr);}
}
@media (max-width:768px){
  .bt-hero-title{font-size:1.75rem;}
  .bt-course-grid{grid-template-columns:1fr;}
  .bt-cta{padding:2rem 1.4rem;text-align:center;justify-content:center;}
  .bt-mentor-grid{grid-template-columns:1fr;max-width:400px;margin-left:auto;margin-right:auto;}
}
</style>

<!-- ================= HERO (Mentoring-first) ================= -->
<?php if (!isset($site_settings['hero_enabled']) || $site_settings['hero_enabled'] === '1'): ?>
<section class="bt-hero">
    <div class="container">
        <div class="bt-hero-inner">
            <div class="text-center sm:text-start" style="text-align:center;">
                <h1 class="bt-hero-title">
                    <?php echo t(setting('hero_title', 'Masalahmu <span class="bt-mark">Tuntas</span> Bersama Mentor Ahli'), setting('hero_title_en', '<span class="bt-mark">Solve It</span> with Expert Mentors')); ?>
                </h1>
                <p class="bt-hero-sub" style="margin-left:auto;margin-right:auto;">
                    <?php echo t(setting('hero_subtitle', 'Konsultasi 1-on-1 langsung dengan praktisi berpengalaman — karier, bisnis, coding, hingga pengembangan diri. Dilengkapi materi belajar mandiri untuk persiapanmu.'), setting('hero_subtitle_en', 'Get 1-on-1 consultation directly with experienced practitioners — career, business, coding, and personal growth. Complete with self-paced materials to prepare.')); ?>
                </p>
                <div class="bt-hero-cta" style="justify-content:center;">
                    <a href="<?php echo base_url(setting('hero_cta_link', 'mentoring')); ?>" class="bt-btn bt-btn-solid"><?php echo t(setting('hero_cta_text', 'Cari Mentor Sekarang'), setting('hero_cta_text_en', 'Find a Mentor Now')); ?> <i class="fas fa-arrow-right"></i></a>
                    <a href="<?php echo base_url(setting('hero_secondary_cta_link', 'courses')); ?>" class="bt-btn bt-btn-outline"><?php echo t(setting('hero_secondary_cta_text', 'Jelajahi Kelas'), setting('hero_secondary_cta_text_en', 'Explore Courses')); ?></a>
                </div>
            </div>
            <div class="bt-hero-visual" data-aos="fade-left" data-aos-duration="1000">
                <img src="https://images.unsplash.com/photo-1573497620053-ea5300f94f21?w=900&auto=format&fit=crop&q=70" alt="<?php echo t('Sesi mentoring 1-on-1', '1-on-1 mentoring session'); ?>">
                <div class="bt-hero-chip bt-chip-1"><i class="fas fa-user-tie"></i><div><strong><?php echo $total_teachers_count; ?>+</strong><span><?php echo t('Mentor Ahli', 'Expert Mentors'); ?></span></div></div>
                <div class="bt-hero-chip bt-chip-2"><i class="fas fa-comments"></i><div><strong><?php echo $total_certificates; ?>+</strong><span><?php echo t('Sesi Berhasil', 'Sessions Completed'); ?></span></div></div>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- ================= AI RECOMMENDATION (interactive) ================= -->
<section class="bt-ai-section" id="ai-recommend">
    <div class="container" data-aos="fade-up" data-aos-duration="1000">
        <div class="bt-center">
            <span class="bt-chip-tag"><?php echo t('Rekomendasi Cerdas', 'Smart Recommendation'); ?> <i class="fas fa-robot" style="margin-left:4px;"></i></span>
            <h2 class="bt-title"><?php echo t('Bingung Mulai dari Mana?', 'Not Sure Where to Start?'); ?></h2>
            <p class="bt-sub"><?php echo t('Ceritakan masalah atau tujuanmu, AI kami akan', 'Tell us your problem or goal, our AI will'); ?> <span class="bt-teal"><?php echo t('mencocokkan mentor yang tepat', 'match you with the right mentor'); ?></span> <?php echo t('untukmu.', 'for you.'); ?></p>
        </div>

        <div class="bt-ai-box">
            <div class="bt-ai-label"><i class="fas fa-magic"></i> <?php echo t('Asisten BISATUNTAS', 'BISATUNTAS Assistant'); ?></div>
            <div class="bt-ai-inputwrap">
                <input type="text" id="aiProblemInput" maxlength="200" placeholder="<?php echo t('Misal: Saya bingung memilih karir antara programmer atau desainer…', 'E.g. I am confused choosing a career between programmer or designer…'); ?>">
                <button type="button" class="bt-btn bt-btn-solid" id="aiRecommendBtn"><i class="fas fa-wand-magic-sparkles"></i> <?php echo t('Rekomendasikan', 'Recommend'); ?></button>
            </div>
            <p class="bt-ai-hint"><i class="fas fa-lightbulb" style="color:var(--bt-amber);"></i> <?php echo t('Coba: bingung pilih karir · persiapan interview kerja · ingin belajar coding dari nol · mengembangkan bisnis', 'Try: career choice · job interview prep · learning to code from scratch · growing a business'); ?></p>

            <div class="bt-ai-loading" id="aiLoading"><span class="spinner"></span> <?php echo t('AI sedang mencari mentor terbaik untukmu…', 'AI is finding the best mentors for you…'); ?></div>
            <div class="bt-ai-msg" id="aiMsg"></div>
            <div class="bt-ai-result" id="aiResult"></div>
            <div class="bt-ai-login-note" id="aiLoginNote" style="display:none;">
                <?php echo t('Silakan', 'Please'); ?> <a href="<?php echo base_url('auth/login'); ?>"><?php echo t('masuk', 'login'); ?></a> <?php echo t('atau', 'or'); ?> <a href="<?php echo base_url('auth/register'); ?>"><?php echo t('daftar gratis', 'register free'); ?></a> <?php echo t('untuk mencoba rekomendasi AI dan booking mentor.', 'to try AI recommendations and book mentors.'); ?>
            </div>
        </div>
    </div>
</section>

<!-- ================= FEATURED MENTORS ================= -->
<?php if (!empty($featured_mentors)): ?>
<section class="bt-mentors">
    <div class="container" data-aos="fade-up" data-aos-duration="1500">
        <div class="bt-center">
            <span class="bt-chip-tag"><?php echo t('Mentor Unggulan', 'Featured Mentors'); ?></span>
            <h2 class="bt-title"><?php echo t('Belajar Langsung dari Praktisi', 'Learn Directly from Practitioners'); ?></h2>
            <p class="bt-sub"><?php echo t('Mentor berpengalaman siap membantu', 'Experienced mentors ready to help'); ?> <span class="bt-teal"><?php echo t('masalahmu tuntas.', 'solve your problem.'); ?></span></p>
        </div>
        <div class="bt-mentor-grid">
            <?php $mc = 0; $mentor_colors = array('linear-gradient(135deg,#009688,#0D1830)', 'linear-gradient(135deg,#FBBF24,#f59e0b)', 'linear-gradient(135deg,#0D1830,#233358)', 'linear-gradient(135deg,#a855f7,#6d28d9)'); ?>
            <?php foreach ($featured_mentors as $mentor): $mc++; ?>
                <a href="<?php echo base_url('mentoring/detail/' . encode_id($mentor->id)); ?>" class="bt-mentor-card">
                    <div class="bt-mentor-head">
                        <div class="bt-mentor-avatar" style="background:<?php echo $mentor_colors[($mc - 1) % count($mentor_colors)]; ?>;">
                            <?php echo strtoupper(mb_substr($mentor->name, 0, 1)); ?>
                        </div>
                        <h5 class="bt-mentor-name"><?php echo htmlspecialchars($mentor->name); ?></h5>
                        <p class="bt-mentor-title"><?php echo htmlspecialchars(t($mentor->title, $mentor->title_en ?: $mentor->title)); ?></p>
                    </div>
                    <div class="bt-mentor-body">
                        <?php if (!empty($mentor->categories)): ?>
                        <div class="bt-mentor-cats">
                            <?php foreach (array_slice($mentor->categories, 0, 2) as $cat): ?>
                                <span><?php echo htmlspecialchars($cat->name ?: $cat->name_en); ?></span>
                            <?php endforeach; ?>
                        </div>
                        <?php endif; ?>
                        <div class="bt-mentor-rate">
                            <i class="fas fa-star"></i> <strong><?php echo number_format((float)$mentor->avg_rating, 1); ?></strong>
                            <span>(<?php echo (int)$mentor->total_reviews; ?> <?php echo t('ulasan', 'reviews'); ?>)</span>
                        </div>
                    </div>
                    <div class="bt-mentor-foot">
                        <span class="bt-mentor-price"><?php echo t('Mulai dari', 'Starting from'); ?><strong>Rp <?php echo number_format((float)$mentor->price_per_session, 0, ',', '.'); ?></strong></span>
                        <span class="bt-mentor-book"><?php echo t('Booking', 'Book'); ?> <i class="fas fa-arrow-right"></i></span>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
        <div class="bt-center" style="margin-top:2.2rem;">
            <a href="<?php echo base_url('mentoring'); ?>" class="bt-btn bt-btn-solid"><?php echo t('Lihat Semua Mentor', 'View All Mentors'); ?> <i class="fas fa-arrow-right"></i></a>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- ================= CLIENTS ================= -->
<section class="bt-clients" data-aos="fade-up" data-aos-duration="1000">
    <div class="container">
        <p class="bt-clients-text"><?php echo t('Bergabung dengan', 'Join'); ?> <span><?php echo $total_students_count; ?>+</span> <?php echo t('siswa di Indonesia yang mempercayai BISATUNTAS', 'students across Indonesia who trust BISATUNTAS'); ?></p>
        <div class="bt-clients-logos">
            <span><i class="fab fa-google"></i> Google</span>
            <span><i class="fab fa-microsoft"></i> Microsoft</span>
            <span><i class="fab fa-github"></i> GitHub</span>
            <span><i class="fab fa-aws"></i> AWS</span>
            <span><i class="fab fa-figma"></i> Figma</span>
        </div>
    </div>
</section>

<!-- ================= FEATURE: MENTORING (1-on-1) ================= -->
<section class="bt-feature">
    <div class="container">
        <div class="bt-feature-grid">
            <div class="bt-feature-media" data-aos="fade-right" data-aos-duration="1000">
                <img src="https://images.unsplash.com/photo-1531482615713-2afd69097998?w=800&auto=format&fit=crop&q=70" alt="">
            </div>
            <div data-aos="fade-left" data-aos-duration="1000">
                <span class="bt-chip-tag bt-chip-tag-amber"><?php echo t('Sesi 1-on-1', 'One-on-One Sessions'); ?></span>
                <h2 class="bt-feature-title"><?php echo t('Diskusi Langsung, Solusi Personal', 'Direct Talk, Personal Solution'); ?></h2>
                <p class="bt-feature-desc"><?php echo t('Tidak sekadar menonton video — ajukan pertanyaanmu, dapatkan arahan yang personal, dan selesaikan hambatanmu bersama mentor praktisi yang sudah malang melintang di industri.', 'Not just watching videos — ask your questions, get personal guidance, and resolve your blockers with practitioner mentors who have real industry experience.'); ?></p>
                <ul style="list-style:none;padding:0;margin:0 0 1.6rem;display:flex;flex-direction:column;gap:0.5rem;">
                    <li style="font-size:0.84rem;color:var(--bt-text);"><i class="fas fa-check-circle" style="color:var(--bt-teal);margin-right:8px;"></i><?php echo t('Feedback personal & rencana aksi nyata', 'Personal feedback & actionable plan'); ?></li>
                    <li style="font-size:0.84rem;color:var(--bt-text);"><i class="fas fa-check-circle" style="color:var(--bt-teal);margin-right:8px;"></i><?php echo t('Jadwal fleksibel, sesi online dari mana saja', 'Flexible schedule, online from anywhere'); ?></li>
                    <li style="font-size:0.84rem;color:var(--bt-text);"><i class="fas fa-check-circle" style="color:var(--bt-teal);margin-right:8px;"></i><?php echo t('Didukung materi mandiri sebagai persiapan', 'Supported by self-paced materials to prepare'); ?></li>
                </ul>
                <a href="<?php echo base_url('mentoring'); ?>" class="bt-btn bt-btn-solid"><?php echo t('Temukan Mentor yang Tepat', 'Find the Right Mentor'); ?> <i class="fas fa-arrow-right"></i></a>
            </div>
        </div>
    </div>
</section>

<!-- ================= FEATURE: KURSUS (pendukung) ================= -->
<section class="bt-feature" style="padding-top:0;">
    <div class="container">
        <div class="bt-feature-grid">
            <div data-aos="fade-right" data-aos-duration="1000">
                <span class="bt-chip-tag"><?php echo t('Materi Mandiri', 'Self-Paced Materials'); ?></span>
                <h2 class="bt-feature-title"><?php echo t('Persiapan Terbaik Sebelum Mentoring', 'Best Preparation Before Mentoring'); ?></h2>
                <p class="bt-feature-desc"><?php echo t('Kuasai dasar lewat video, kuis interaktif, dan studi kasus — lalu maksimalkan sesi mentoringmu dengan pertanyaan yang lebih dalam dan spesifik.', 'Master the basics through videos, interactive quizzes, and case studies — then maximize your mentoring session with deeper, more specific questions.'); ?></p>
                <a href="<?php echo base_url('courses'); ?>" class="bt-btn bt-btn-outline"><?php echo t('Jelajahi Kelas', 'Explore Courses'); ?> <i class="fas fa-arrow-right"></i></a>
            </div>
            <div class="bt-feature-media" data-aos="fade-left" data-aos-duration="1000">
                <img src="https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=800&auto=format&fit=crop&q=70" alt="">
            </div>
        </div>
    </div>
</section>

<!-- ================= KATEGORI / INTEGRATIONS ================= -->
<?php if ((!isset($site_settings['home_show_categories']) || $site_settings['home_show_categories'] === '1') && !empty($categories)): ?>
<section class="bt-integrations">
    <div class="container" data-aos="fade-up" data-aos-duration="1500">
        <div class="bt-center">
            <span class="bt-chip-tag"><?php echo t('Kategori', 'Categories'); ?></span>
            <h2 class="bt-title"><?php echo t('Temukan Bidang yang Kamu Minati', 'Find Your Field of Interest'); ?></h2>
            <p class="bt-sub"><?php echo t('Pilih kategori dan mulai perjalanan belajarmu', 'Choose a category and start your learning journey'); ?> <span class="bt-teal"><?php echo t('di mana pun kamu berada.', 'from anywhere.'); ?></span></p>
        </div>
        <div class="bt-grid-2">
            <?php $ci = 0; foreach ($categories as $cat): $c = $cat_colors[$ci % count($cat_colors)]; $ci++; ?>
                <a href="<?php echo base_url('courses?category_id=' . $cat->id); ?>" class="bt-integ-card" style="--ic:<?php echo $c; ?>">
                    <span class="bt-integ-icon <?php echo $ci % 4 == 0 ? 'alt' : ($ci % 4 == 1 ? 'navy' : ($ci % 4 == 2 ? 'soft' : '')); ?>"><i class="fas fa-<?php echo $cat->icon ?: 'folder-open'; ?>"></i></span>
                    <div>
                        <h5><?php echo htmlspecialchars($cat->name); ?></h5>
                        <p><?php echo t('Jelajahi kelas & materi', 'Explore classes & materials'); ?> — <strong style="color:var(--bt-teal);"><?php echo htmlspecialchars($cat->name); ?></strong></p>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- ================= FEATURED COURSES ================= -->
<?php if ((!isset($site_settings['home_show_featured']) || $site_settings['home_show_featured'] === '1') && !empty($featured_courses)): ?>
<section class="bt-courses">
    <div class="container" data-aos="fade-up" data-aos-duration="1500">
        <div class="bt-center">
            <span class="bt-chip-tag"><?php echo t('Rekomendasi', 'Recommended'); ?></span>
            <h2 class="bt-title"><?php echo t('Konten Pilihan', 'Featured Content'); ?></h2>
            <p class="bt-sub"><?php echo t('Rekomendasi materi belajar terbaik untukmu', 'Recommended learning content for you'); ?></p>
        </div>
        <div class="bt-course-grid">
            <?php foreach ($featured_courses as $course): ?>
                <a href="<?php echo base_url('courses/detail/' . $course->slug); ?>" class="bt-course-card">
                    <div class="bt-course-img">
                        <img src="<?php echo base_url('uploads/courses/' . $course->thumbnail); ?>" onerror="this.src='https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=400&auto=format&fit=crop&q=60';" alt="">
                        <span class="bt-course-badge"><?php echo content_type_label($course->content_type); ?></span>
                        <?php if ($course->price > 0): ?><span class="bt-course-price">Rp <?php echo number_format($course->price, 0, ',', '.'); ?></span><?php endif; ?>
                    </div>
                    <div class="bt-course-body">
                        <div class="bt-course-meta">
                            <span><i class="fas fa-folder-open"></i><?php echo htmlspecialchars($course->category_name ?? ''); ?></span>
                            <span><i class="fas fa-user"></i><?php echo htmlspecialchars($course->teacher_name); ?></span>
                        </div>
                        <h6 class="bt-course-title"><?php echo htmlspecialchars($course->title); ?></h6>
                        <div class="bt-course-foot">
                            <?php echo $course->price > 0 ? '<span>Rp ' . number_format($course->price, 0, ',', '.') . '</span>' : '<span class="bt-course-free">' . t('Gratis', 'Free') . '</span>'; ?>
                            <span class="bt-learn"><i class="fas fa-arrow-right"></i></span>
                        </div>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
        <div class="bt-center" style="margin-top:2.2rem;">
            <a href="<?php echo base_url('courses'); ?>" class="bt-btn bt-btn-outline"><?php echo t('Lihat Semua Konten', 'View All Content'); ?> <i class="fas fa-arrow-right"></i></a>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- ================= STEPS (dark) ================= -->
<section class="bt-steps-section">
    <div class="container" data-aos="fade-up" data-aos-duration="1500">
        <div class="bt-center">
            <span class="bt-chip-tag" style="background:rgba(251,191,36,0.15);color:var(--bt-amber);"><?php echo t('Cara Kerja', 'How It Works'); ?></span>
            <h2 class="bt-title"><?php echo t('3 Langkah Menuju Tuntas', '3 Steps to Get Solved'); ?></h2>
            <p class="bt-sub"><?php echo t('Dari masalah ke solusi dalam hitungan menit', 'From problem to solution in minutes'); ?></p>
        </div>
        <div class="bt-steps">
            <div class="bt-step">
                <div class="bt-step-num">01</div>
                <div class="bt-step-icon"><i class="fas fa-comments"></i></div>
                <h5><?php echo t('Ceritakan Masalahmu', 'Tell Us Your Problem'); ?></h5>
                <p><?php echo t('Tulis kesulitan atau tujuanmu — AI kami bantu cocokkan dengan mentor yang paling relevan.', 'Describe your challenge or goal — our AI helps match you with the most relevant mentor.'); ?></p>
            </div>
            <div class="bt-step">
                <div class="bt-step-num">02</div>
                <div class="bt-step-icon"><i class="fas fa-calendar-check"></i></div>
                <h5><?php echo t('Pilih Mentor & Jadwal', 'Pick Mentor & Schedule'); ?></h5>
                <p><?php echo t('Lihat profil, rating, dan bidang mentor. Booking sesi 1-on-1 di waktu yang fleksibel.', 'Review profiles, ratings, and specialties. Book a 1-on-1 session at a time that suits you.'); ?></p>
            </div>
            <div class="bt-step">
                <div class="bt-step-num">03</div>
                <div class="bt-step-icon"><i class="fas fa-flag-checkered"></i></div>
                <h5><?php echo t('Selesaikan Bersama', 'Get It Solved'); ?></h5>
                <p><?php echo t('Diskusi langsung, dapatkan solusi & rencana aksi. Kembangkan dirimu sampai tuntas.', 'Talk directly, get solutions & action plans. Grow until your problem is fully solved.'); ?></p>
            </div>
        </div>
    </div>
</section>

<!-- ================= PRICING ================= -->
<?php if (!empty($packages)): ?>
<section class="bt-pricing">
    <div class="container" data-aos="fade-up" data-aos-duration="1500">
        <div class="bt-center">
            <span class="bt-chip-tag"><?php echo t('Paket', 'Pricing'); ?></span>
            <h2 class="bt-title"><?php echo t('Paket Langganan', 'Subscription Plans'); ?></h2>
            <p class="bt-sub"><?php echo t('Harga yang', 'Pricing that'); ?> <span class="bt-teal"><?php echo t('bersahabat', 'works'); ?></span> <?php echo t('untuk semua orang.', 'for everyone.'); ?></p>
        </div>
        <div class="overflow-auto">
            <table class="bt-price-table">
                <thead>
                    <tr>
                        <th></th>
                        <?php foreach ($packages as $i => $pkg): ?>
                            <th class="<?php echo ($i == 1) ? 'bt-col-popular' : ''; ?>">
                                <h5><?php echo htmlspecialchars(t($pkg->name, $pkg->name_en ?: $pkg->name)); ?>
                                    <?php if ($i == 1): ?><span class="bt-popular-badge"><?php echo t('Populer', 'Popular'); ?></span><?php endif; ?>
                                </h5>
                                <p>Rp <?php echo number_format($pkg->price, 0, ',', '.'); ?>/<?php echo t('bulan', 'mo'); ?></p>
                            </th>
                        <?php endforeach; ?>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><?php echo t('Akses konten belajar', 'Access learning content'); ?></td>
                        <?php foreach ($packages as $i => $pkg): ?><td class="<?php echo ($i == 1) ? 'bt-col-popular' : ''; ?>"><i class="fas fa-check bt-price-check"></i></td><?php endforeach; ?>
                    </tr>
                    <tr>
                        <td><?php echo t('Video & kuis interaktif', 'Video & interactive quizzes'); ?></td>
                        <?php foreach ($packages as $i => $pkg): ?><td class="<?php echo ($i == 1) ? 'bt-col-popular' : ''; ?>"><i class="fas fa-check bt-price-check"></i></td><?php endforeach; ?>
                    </tr>
                    <tr>
                        <td><?php echo t('Sertifikat resmi', 'Official certificate'); ?></td>
                        <?php foreach ($packages as $i => $pkg): ?>
                            <td class="<?php echo ($i == 1) ? 'bt-col-popular' : ''; ?>">
                                <?php if ($pkg->access_scope === 'all'): ?><i class="fas fa-check bt-price-check"></i>
                                <?php else: ?><span class="bt-addon"><?php echo t('Add-on', 'Add-on'); ?></span><?php endif; ?>
                            </td>
                        <?php endforeach; ?>
                    </tr>
                    <tr>
                        <td><?php echo t('Diskon langganan 6 bulan', '6-month subscription discount'); ?></td>
                        <?php foreach ($packages as $i => $pkg): ?>
                            <td class="<?php echo ($i == 1) ? 'bt-col-popular' : ''; ?>">
                                <?php if ($pkg->discount_6mo > 0): ?><i class="fas fa-check bt-price-check"></i>
                                <?php else: ?><span class="bt-addon"><?php echo t('Add-on', 'Add-on'); ?></span><?php endif; ?>
                            </td>
                        <?php endforeach; ?>
                    </tr>
                    <tr>
                        <td><?php echo t('Mentoring langsung', 'Direct mentoring'); ?></td>
                        <?php foreach ($packages as $i => $pkg): ?><td class="<?php echo ($i == 1) ? 'bt-col-popular' : ''; ?>">—</td><?php endforeach; ?>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- ================= TESTIMONIALS ================= -->
<section class="bt-testi-section">
    <div class="container" data-aos="fade-up" data-aos-duration="1500">
        <div class="bt-center">
            <span class="bt-chip-tag"><?php echo t('Testimoni', 'Testimonials'); ?></span>
            <h2 class="bt-title"><?php echo t('Apa Kata Mereka', 'What They Say'); ?></h2>
            <p class="bt-sub"><?php echo t('Review dari siswa yang sudah bergabung', 'Reviews from students who have joined'); ?></p>
        </div>
        <div class="bt-testi-grid">
            <div class="bt-testi">
                <div class="bt-stars"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i></div>
                <p>"Materinya sangat terstruktur dan mudah dipahami. Dari yang awalnya tidak bisa coding, sekarang sudah bisa membuat website sendiri."</p>
                <div class="bt-testi-by"><span class="bt-avatar" style="background:var(--bt-teal);">RK</span><div><strong>Rina Kusuma</strong><small><?php echo t('Siswa Web Development', 'Web Development Student'); ?></small></div></div>
            </div>
            <div class="bt-testi">
                <div class="bt-stars"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i></div>
                <p>"Sesi mentoring benar-benar membantu memahami konsep yang sulit. Mentor sangat sabar dan memberikan feedback yang detail."</p>
                <div class="bt-testi-by"><span class="bt-avatar" style="background:var(--bt-navy);">DP</span><div><strong>Dimas Pratama</strong><small><?php echo t('Siswa Program Mentorship', 'Mentorship Program Student'); ?></small></div></div>
            </div>
            <div class="bt-testi">
                <div class="bt-stars"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i></div>
                <p>"Sertifikat dari BISATUNTAS membantu saya mendapat promosi di kantor. Materi yang diajarkan sangat relevan dengan kebutuhan industri saat ini."</p>
                <div class="bt-testi-by"><span class="bt-avatar" style="background:var(--bt-amber);color:var(--bt-navy);">SI</span><div><strong>Sari Indah</strong><small><?php echo t('Siswa Digital Marketing', 'Digital Marketing Student'); ?></small></div></div>
            </div>
        </div>
    </div>
</section>

<!-- ================= CTA ================= -->
<?php if (!isset($site_settings['home_show_cta']) || $site_settings['home_show_cta'] === '1'): ?>
<section class="bt-cta-section">
    <div class="container" data-aos="fade-up" data-aos-duration="1000">
        <div class="bt-cta">
            <div>
                <h2><?php echo t(setting('home_cta_title', 'Siap Menguasai Skill Baru?'), setting('home_cta_title_en', 'Ready to Master a New Skill?')); ?></h2>
                <p><?php echo t(setting('home_cta_subtitle', 'Daftar gratis sekarang dan mulai perjalanan belajarmu bersama ribuan siswa lainnya.'), setting('home_cta_subtitle_en', 'Register for free and start your learning journey with thousands of other students.')); ?></p>
            </div>
            <a href="<?php echo base_url(setting('home_cta_button_link', 'auth/register')); ?>" class="bt-btn bt-btn-amber">
                <i class="fas fa-user-plus"></i>
                <?php echo t(setting('home_cta_button_text', 'Daftar Gratis Sekarang'), setting('home_cta_button_text_en', 'Register Free Now')); ?>
            </a>
        </div>
    </div>
</section>
<?php endif; ?>

<script>
(function() {
    var loggedIn = <?php echo $this->session->userdata('logged_in') ? 'true' : 'false'; ?>;
    var input = document.getElementById('aiProblemInput');
    var btn = document.getElementById('aiRecommendBtn');
    var loading = document.getElementById('aiLoading');
    var msgEl = document.getElementById('aiMsg');
    var resultEl = document.getElementById('aiResult');
    var noteEl = document.getElementById('aiLoginNote');

    function esc(s) {
        var d = document.createElement('div');
        d.textContent = s == null ? '' : s;
        return d.innerHTML;
    }
    function showMsg(html, isErr) {
        msgEl.innerHTML = html;
        msgEl.style.display = '';
        msgEl.style.background = isErr ? '#fff5f5' : '#f0fdfa';
        msgEl.style.borderColor = isErr ? '#fecaca' : '#ccfbf1';
        msgEl.style.color = isErr ? '#b91c1c' : '#134e4a';
    }
    function doRecommend() {
        if (!loggedIn) {
            resultEl.style.display = 'none';
            msgEl.style.display = 'none';
            if (noteEl) noteEl.style.display = '';
            return;
        }
        var problem = (input ? input.value.trim() : '');
        if (problem === '') {
            input.focus();
            input.style.borderColor = '#ef4444';
            setTimeout(function() { input.style.borderColor = ''; }, 1500);
            return;
        }
        if (btn) btn.disabled = true;
        if (loading) loading.style.display = 'flex';
        msgEl.style.display = 'none';
        resultEl.style.display = 'none';
        if (noteEl) noteEl.style.display = 'none';

        var fd = new FormData();
        fd.append('problem', problem);
        fd.append('<?php echo $this->security->get_csrf_token_name(); ?>', '<?php echo $this->security->get_csrf_hash(); ?>');

        fetch('<?php echo base_url('mentoring/ai-recommend'); ?>', {
            method: 'POST', body: fd, headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(function(r) { return r.json(); })
        .then(function(d) {
            if (loading) loading.style.display = 'none';
            if (btn) btn.disabled = false;
            if (d.status !== 'ok') {
                showMsg(esc(d.message || 'Terjadi kesalahan.'), true);
                return;
            }
            if (d.reason) showMsg(esc(d.reason), false);
            var cards = '';
            if (d.mentors && d.mentors.length) {
                d.mentors.forEach(function(m) {
                    cards += '<a class="bt-ai-mentor" href="<?php echo base_url('mentoring/detail/'); ?>' + esc(m.encoded_id) + '">'
                        + '<span class="bt-ai-avatar">' + esc((m.name || '?').charAt(0).toUpperCase()) + '</span>'
                        + '<div><h6>' + esc(m.name) + '</h6><small>' + esc(m.title || '') + ' · ★ ' + esc(m.avg_rating || '0') + '</small></div>'
                        + '<span class="bt-ai-go"><i class="fas fa-arrow-right"></i></span>'
                        + '</a>';
                });
                resultEl.innerHTML = cards;
                resultEl.style.display = '';
            } else {
                resultEl.style.display = 'none';
            }
        })
        .catch(function() {
            if (loading) loading.style.display = 'none';
            if (btn) btn.disabled = false;
            showMsg('<?php echo t('Terjadi kesalahan jaringan. Silakan coba lagi.', 'Network error. Please try again.'); ?>', true);
        });
    }
    if (btn) btn.addEventListener('click', doRecommend);
    if (input) input.addEventListener('keydown', function(e) { if (e.key === 'Enter') doRecommend(); });
})();
</script>
