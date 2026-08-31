<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Layout bersama untuk halaman auth (login/register).
 * Panel kiri: visual playful bertema belajar; panel kanan: form.
 * Variabel yang harus diset sebelum include: $auth_title, $auth_subtitle, $auth_icon (nama FA).
 */
?>
<div class="au2-wrap">
    <!-- ===== Panel Visual (playful) ===== -->
    <div class="au2-visual">
        <div class="au2-v-inner">
            <a href="<?php echo base_url(); ?>" class="au2-brand">
                <span class="au2-brand-dot"></span>
                <span>B</span>ISATUNTAS
            </a>

            <div class="au2-v-scene">
                <!-- elemen dekoratif melayang -->
                <div class="au2-float au2-float-1"><i class="fas fa-rocket"></i></div>
                <div class="au2-float au2-float-2"><i class="fas fa-lightbulb"></i></div>
                <div class="au2-float au2-float-3"><i class="fas fa-graduation-cap"></i></div>
                <div class="au2-float au2-float-4"><i class="fas fa-book-open"></i></div>
                <div class="au2-float au2-float-5"><i class="fas fa-trophy"></i></div>

                <div class="au2-card-emoji">
                    <div class="au2-emoji-ring">
                        <i class="fas <?php echo $auth_icon; ?>"></i>
                    </div>
                </div>

                <div class="au2-v-text">
                    <h2><?php echo $auth_visual_title ?? t('Belajar Tanpa Batas.', 'Learn Without Limits.'); ?></h2>
                    <p><?php echo $auth_visual_sub ?? t('Kelas terstruktur, mentor berpengalaman, dan komunitas yang mendukung perjalanan belajarmu.', 'Structured classes, experienced mentors, and a community that supports your learning journey.'); ?></p>
                </div>
            </div>

            <!-- floating badges -->
            <div class="au2-badge au2-badge-1">
                <i class="fas fa-check-circle"></i>
                <div><strong>+120 Sesi</strong><span>Mentoring Live</span></div>
            </div>
            <div class="au2-badge au2-badge-2">
                <i class="fas fa-users"></i>
                <div><strong>+2.500 Siswa</strong><span>Belajar Aktif</span></div>
            </div>

            <div class="au2-v-footer">
                <span class="au2-dot"></span><span class="au2-dot"></span><span class="au2-dot"></span>
                <span class="au2-dot"></span><span class="au2-dot"></span>
            </div>
        </div>
    </div>

    <!-- ===== Panel Form ===== -->
    <div class="au2-form-side">
        <div class="au2-form-box">
            <div class="au2-form-head">
                <h1><?php echo $auth_title; ?></h1>
                <p><?php echo $auth_subtitle; ?></p>
            </div>

            <?php if ($this->session->flashdata('error')): ?>
                <div class="au2-alert au2-alert-error">
                    <i class="fas fa-exclamation-circle"></i>
                    <span><?php echo $this->session->flashdata('error'); ?></span>
                </div>
            <?php endif; ?>
            <?php if ($this->session->flashdata('success')): ?>
                <div class="au2-alert au2-alert-success">
                    <i class="fas fa-check-circle"></i>
                    <span><?php echo $this->session->flashdata('success'); ?></span>
                </div>
            <?php endif; ?>
            <?php if (validation_errors()): ?>
                <div class="au2-alert au2-alert-error">
                    <i class="fas fa-exclamation-circle"></i>
                    <span><?php echo validation_errors('', ''); ?></span>
                </div>
            <?php endif; ?>

            <?php echo form_open($auth_form_action, array('class' => 'au2-form')); ?>
                <?php echo $auth_form_fields; ?>

                <div style="position:absolute;left:-9999px;" aria-hidden="true">
                    <input type="text" name="website_url" tabindex="-1" autocomplete="off">
                </div>

                <button type="submit" class="au2-btn">
                    <span><?php echo $auth_submit_text; ?></span>
                    <i class="fas fa-arrow-right"></i>
                </button>
            <?php echo form_close(); ?>

            <?php if (!empty($google_login_url)): ?>
                <div class="au2-divider"><span><?php echo t('atau', 'or'); ?></span></div>
                <a href="<?php echo $google_login_url; ?>" class="au2-btn-google">
                    <svg width="16" height="16" viewBox="0 0 24 24"><path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92a5.06 5.06 0 01-2.2 3.32v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.1z" fill="#4285F4"/><path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/><path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/><path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/></svg>
                    <?php echo $auth_google_text; ?>
                </a>
            <?php endif; ?>

            <div class="au2-form-foot">
                <p><?php echo $auth_footer_text; ?> <a href="<?php echo $auth_footer_url; ?>"><?php echo $auth_footer_link; ?></a></p>
            </div>
        </div>
    </div>
</div>

<style>
.au2-wrap{min-height:calc(100vh - 56px);display:grid;grid-template-columns:1.05fr 1fr;background:#fff;}
/* ===== Panel visual ===== */
.au2-visual{position:relative;overflow:hidden;background:linear-gradient(150deg,#0b3d2e 0%,#065f46 45%,#059669 100%);display:flex;align-items:center;justify-content:center;padding:2.5rem;min-height:calc(100vh - 56px);}
.au2-visual::before{content:'';position:absolute;width:520px;height:520px;border-radius:50%;background:radial-gradient(circle,rgba(255,255,255,0.09) 0%,transparent 65%);top:-140px;right:-140px;}
.au2-visual::after{content:'';position:absolute;width:380px;height:380px;border-radius:50%;background:radial-gradient(circle,rgba(255,255,255,0.06) 0%,transparent 65%);bottom:-100px;left:-100px;}
.au2-v-inner{position:relative;z-index:2;width:100%;max-width:440px;}
.au2-brand{display:inline-flex;align-items:center;gap:2px;font-weight:800;letter-spacing:-0.04em;color:#fff;font-size:1.05rem;text-decoration:none;margin-bottom:3rem;}
.au2-brand-dot{width:10px;height:10px;border-radius:50%;background:#fbbf24;margin-right:2px;box-shadow:0 0 12px rgba(251,191,36,0.7);}
.au2-v-scene{position:relative;min-height:300px;}
.au2-card-emoji{position:relative;display:flex;align-items:center;justify-content:center;min-height:260px;}
.au2-emoji-ring{width:190px;height:190px;border-radius:38px;background:rgba(255,255,255,0.12);backdrop-filter:blur(6px);border:1px solid rgba(255,255,255,0.18);display:flex;align-items:center;justify-content:center;box-shadow:0 24px 60px rgba(0,0,0,0.25);transform:rotate(-6deg);transition:transform 0.4s cubic-bezier(0.34,1.56,0.64,1);}
.au2-card-emoji:hover .au2-emoji-ring{transform:rotate(0deg) scale(1.04);}
.au2-emoji-ring i{font-size:4.2rem;color:#fbbf24;filter:drop-shadow(0 6px 16px rgba(251,191,36,0.45));}
.au2-v-text{margin-top:1.6rem;text-align:center;}
.au2-v-text h2{font-size:1.55rem;font-weight:800;letter-spacing:-0.03em;color:#fff;margin:0 0 0.5rem;line-height:1.25;}
.au2-v-text p{font-size:0.86rem;color:rgba(255,255,255,0.75);margin:0;line-height:1.65;max-width:360px;margin-inline:auto;}
.au2-float{position:absolute;color:rgba(255,255,255,0.5);font-size:1.15rem;animation:au2Float 5s ease-in-out infinite;}
.au2-float-1{top:4%;left:4%;animation-delay:0s;}
.au2-float-2{top:14%;right:6%;animation-delay:1.2s;color:#fbbf24;}
.au2-float-3{bottom:18%;left:2%;animation-delay:0.6s;}
.au2-float-4{bottom:8%;right:10%;animation-delay:1.8s;}
.au2-float-5{top:40%;left:-2%;animation-delay:2.4s;color:#fbbf24;}
@keyframes au2Float{0%,100%{transform:translateY(0) rotate(0deg);}50%{transform:translateY(-14px) rotate(8deg);}}
.au2-badge{position:absolute;background:rgba(255,255,255,0.14);backdrop-filter:blur(8px);border:1px solid rgba(255,255,255,0.2);border-radius:14px;padding:0.6rem 0.85rem;display:flex;align-items:center;gap:0.55rem;box-shadow:0 10px 30px rgba(0,0,0,0.2);animation:au2Float 6s ease-in-out infinite;}
.au2-badge i{font-size:1rem;color:#fbbf24;}
.au2-badge strong{display:block;font-size:0.75rem;color:#fff;font-weight:700;line-height:1.2;}
.au2-badge span{display:block;font-size:0.62rem;color:rgba(255,255,255,0.7);}
.au2-badge-1{top:16%;right:-14px;animation-delay:0.8s;}
.au2-badge-2{bottom:26%;left:-18px;animation-delay:1.6s;}
.au2-v-footer{display:flex;gap:0.4rem;margin-top:2.2rem;justify-content:center;}
.au2-dot{width:6px;height:6px;border-radius:50%;background:rgba(255,255,255,0.35);}
.au2-dot:nth-child(1){background:#fbbf24;width:22px;border-radius:99px;}
/* ===== Panel form ===== */
.au2-form-side{display:flex;align-items:center;justify-content:center;padding:2.5rem 1.5rem;background:#fff;}
.au2-form-box{width:100%;max-width:400px;}
.au2-form-head h1{font-size:1.6rem;font-weight:800;letter-spacing:-0.035em;color:#171717;margin:0 0 0.3rem;}
.au2-form-head p{font-size:0.86rem;color:#737373;margin:0 0 1.6rem;}
.au2-alert{display:flex;align-items:flex-start;gap:0.55rem;padding:0.7rem 0.9rem;margin-bottom:1rem;border-radius:10px;font-size:0.8rem;line-height:1.45;}
.au2-alert i{margin-top:0.1rem;}
.au2-alert-error{background:#fef2f2;border:1px solid #fecaca;color:#dc2626;}
.au2-alert-success{background:#f0fdf4;border:1px solid #bbf7d0;color:#15803d;}
.au2-form .au2-field{margin-bottom:0.95rem;}
.au2-form label{display:block;font-size:0.78rem;font-weight:600;color:#374151;margin-bottom:0.35rem;}
.au2-input-wrap{position:relative;}
.au2-input-wrap input{width:100%;padding:0.78rem 1rem 0.78rem 2.6rem;border:1.5px solid #e5e7eb;border-radius:12px;font-size:0.88rem;color:#111827;background:#fafafa;transition:all 0.18s;outline:none;font-family:inherit;}
.au2-input-wrap input:focus{border-color:#059669;background:#fff;box-shadow:0 0 0 4px rgba(5,150,105,0.12);}
.au2-input-wrap input::placeholder{color:#a3a3a3;}
.au2-input-wrap > i{position:absolute;left:1rem;top:50%;transform:translateY(-50%);color:#9ca3af;font-size:0.85rem;pointer-events:none;transition:color 0.18s;}
.au2-input-wrap:focus-within > i{color:#059669;}
.au2-eye{position:absolute;right:0.9rem;top:50%;transform:translateY(-50%);color:#9ca3af;cursor:pointer;font-size:0.82rem;background:none;border:none;padding:0;line-height:1;z-index:1;}
.au2-eye:hover{color:#6b7280;}
.au2-extra{display:flex;align-items:center;justify-content:space-between;margin:0.2rem 0 1.1rem;font-size:0.78rem;}
.au2-extra label{display:flex;align-items:center;gap:0.4rem;color:#6b7280;font-weight:500;cursor:pointer;margin:0;}
.au2-extra input{accent-color:#059669;width:14px;height:14px;margin:0;}
.au2-forgot{color:#059669;font-weight:600;text-decoration:none;}
.au2-forgot:hover{text-decoration:underline;}
.au2-btn{width:100%;padding:0.82rem;background:linear-gradient(135deg,#059669,#047857);color:#fff;border:none;border-radius:12px;font-weight:700;font-size:0.9rem;cursor:pointer;transition:all 0.2s;display:flex;align-items:center;justify-content:center;gap:0.55rem;font-family:inherit;box-shadow:0 6px 18px rgba(5,150,105,0.28);}
.au2-btn:hover{transform:translateY(-1px);box-shadow:0 10px 24px rgba(5,150,105,0.35);}
.au2-btn:active{transform:translateY(0);}
.au2-btn i{transition:transform 0.2s;}
.au2-btn:hover i{transform:translateX(4px);}
.au2-btn-google{width:100%;padding:0.72rem;background:#fff;color:#374151;border:1.5px solid #e5e7eb;border-radius:12px;font-weight:600;font-size:0.84rem;cursor:pointer;transition:all 0.18s;display:flex;align-items:center;justify-content:center;gap:0.6rem;text-decoration:none;font-family:inherit;}
.au2-btn-google:hover{border-color:#d1d5db;background:#f9fafb;}
.au2-divider{display:flex;align-items:center;gap:1rem;margin:1.1rem 0;}
.au2-divider::before,.au2-divider::after{content:'';flex:1;height:1px;background:#f0f0f0;}
.au2-divider span{font-size:0.72rem;color:#9ca3af;font-weight:500;}
.au2-form-foot{text-align:center;margin-top:1.4rem;padding-top:1rem;border-top:1px solid #f5f5f5;}
.au2-form-foot p{font-size:0.82rem;color:#6b7280;margin:0;}
.au2-form-foot a{color:#059669;font-weight:700;text-decoration:none;}
.au2-form-foot a:hover{text-decoration:underline;}
/* ===== Responsive ===== */
@media (max-width: 900px){
  .au2-wrap{grid-template-columns:1fr;}
  .au2-visual{display:none;}
  .au2-form-side{min-height:calc(100vh - 56px);padding:2rem 1.25rem;}
}
</style>
