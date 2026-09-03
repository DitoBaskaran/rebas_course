<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Detail Seminar & Webinar publik.
 * Variabel: $seminar, $attendee_count, $is_registered (+ session logged_in).
 */
$sm_ts   = strtotime($seminar->date_time);
$sm_mo   = array(1 => 'Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des');
$sm_dy   = array('Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab');
$sm_date = $sm_dy[(int)date('w', $sm_ts)] . ', ' . (int)date('j', $sm_ts) . ' ' . $sm_mo[(int)date('n', $sm_ts)] . ' ' . (int)date('Y', $sm_ts);
$sm_time = date('H:i', $sm_ts) . ' WIB';
$sm_is_up  = ($sm_ts >= time());
$sm_free   = ((float)$seminar->price <= 0);
$sm_seats  = max(0, (int)$seminar->quota - (int)$attendee_count);
$sm_pct    = ((int)$seminar->quota > 0) ? min(100, round(((int)$attendee_count / (int)$seminar->quota) * 100)) : 0;
$sm_img    = base_url('uploads/seminars/' . $seminar->thumbnail);
$sm_img_fb = 'https://images.unsplash.com/photo-1540575467063-178a50c2df87?w=800&auto=format&fit=crop&q=60';
$sm_thumb  = "onerror=\"this.onerror=null;this.src='" . $sm_img_fb . "'\"";
$sm_quota_full = ((int)$seminar->quota > 0 && (int)$attendee_count >= (int)$seminar->quota);
?>

<div class="sm-wrap">
    <!-- ===== Banner hero ===== -->
    <section class="sm-hero">
        <div class="sm-hero-grid"></div>
        <div class="sm-hero-blob sm-hero-blob-a"></div>
        <div class="sm-hero-blob sm-hero-blob-b"></div>
        <div class="container sm-hero-in">
            <nav class="sm-breadcrumb" aria-label="breadcrumb">
                <a href="<?php echo base_url(); ?>"><?php echo t('Beranda', 'Home'); ?></a>
                <i class="fas fa-chevron-right"></i>
                <a href="<?php echo base_url('seminars'); ?>"><?php echo t('Seminar', 'Seminars'); ?></a>
                <i class="fas fa-chevron-right"></i>
                <span><?php echo htmlspecialchars(mb_strimwidth($seminar->title, 0, 40, '…')); ?></span>
            </nav>

            <div class="sm-hero-main">
                <div class="sm-hero-tx">
                    <div class="sm-tags">
                        <span class="sm-tag <?php echo $sm_is_up ? 'sm-tag-up' : 'sm-tag-end'; ?>"><i class="fas <?php echo $sm_is_up ? 'fa-circle' : 'fa-circle-check'; ?>"></i> <?php echo $sm_is_up ? t('Segera Hadir', 'Upcoming') : t('Telah Selesai', 'Ended'); ?></span>
                        <span class="sm-tag"><i class="fas fa-video"></i> <?php echo t('Live Online', 'Live Online'); ?></span>
                        <?php if ($sm_free): ?>
                            <span class="sm-tag sm-tag-free"><i class="fas fa-gift"></i> <?php echo t('Gratis', 'Free'); ?></span>
                        <?php endif; ?>
                    </div>
                    <h1><?php echo htmlspecialchars($seminar->title); ?></h1>
                    <div class="sm-speaker">
                        <img src="https://ui-avatars.com/api/?name=<?php echo urlencode($seminar->speaker_name); ?>&background=0d9488&color=fff&size=96" alt="" width="44" height="44">
                        <div>
                            <span class="sm-speaker-role"><?php echo t('Pembicara', 'Speaker'); ?></span>
                            <span class="sm-speaker-name"><?php echo htmlspecialchars($seminar->speaker_name); ?></span>
                        </div>
                    </div>
                </div>
                <div class="sm-hero-img">
                    <img src="<?php echo $sm_img; ?>" <?php echo $sm_thumb; ?> alt="<?php echo htmlspecialchars($seminar->title); ?>">
                    <span class="sm-img-date">
                        <i class="far fa-calendar"></i> <?php echo $sm_date; ?>
                    </span>
                    <span class="sm-img-time">
                        <i class="far fa-clock"></i> <?php echo $sm_time; ?>
                    </span>
                </div>
            </div>
        </div>
    </section>

    <!-- ===== Konten + Sidebar ===== -->
    <div class="container sm-body">
        <div class="sm-grid">
            <!-- Kiri: deskripsi & benefit -->
            <div class="sm-main">
                <div class="sm-card">
                    <h2><span class="sm-h2-ic"><i class="fas fa-file-lines"></i></span><?php echo t('Tentang Acara', 'About This Event'); ?></h2>
                    <div class="sm-desc"><?php echo nl2br(htmlspecialchars($seminar->description)); ?></div>
                </div>

                <div class="sm-card">
                    <h2><span class="sm-h2-ic"><i class="fas fa-circle-check"></i></span><?php echo t('Yang Akan Kamu Dapatkan', 'What You Will Get'); ?></h2>
                    <div class="sm-benefit-grid">
                        <div class="sm-benefit"><span class="sm-benefit-ic"><i class="fas fa-chalkboard-user"></i></span><div><strong><?php echo t('Sesi Langsung', 'Live Session'); ?></strong><small><?php echo t('Materi dipandu langsung oleh pembicara', 'Material guided directly by the speaker'); ?></small></div></div>
                        <div class="sm-benefit"><span class="sm-benefit-ic"><i class="fas fa-message"></i></span><div><strong><?php echo t('Tanya Jawab', 'Live Q&A'); ?></strong><small><?php echo t('Diskusi interaktif real-time', 'Interactive real-time discussion'); ?></small></div></div>
                        <div class="sm-benefit"><span class="sm-benefit-ic"><i class="fas fa-certificate"></i></span><div><strong><?php echo t('E-Sertifikat', 'E-Certificate'); ?></strong><small><?php echo t('Sertifikat digital kehadiran', 'Digital attendance certificate'); ?></small></div></div>
                        <div class="sm-benefit"><span class="sm-benefit-ic"><i class="fas fa-file-pdf"></i></span><div><strong><?php echo t('Materi PDF', 'PDF Material'); ?></strong><small><?php echo t('File materi setelah acara', 'Material file after the event'); ?></small></div></div>
                    </div>
                </div>

                <div class="sm-info-cards">
                    <div class="sm-info">
                        <span class="sm-info-ic"><i class="far fa-calendar"></i></span>
                        <div><span><?php echo t('Tanggal', 'Date'); ?></span><strong><?php echo $sm_date; ?></strong></div>
                    </div>
                    <div class="sm-info">
                        <span class="sm-info-ic"><i class="far fa-clock"></i></span>
                        <div><span><?php echo t('Waktu', 'Time'); ?></span><strong><?php echo $sm_time; ?></strong></div>
                    </div>
                    <div class="sm-info">
                        <span class="sm-info-ic"><i class="fas fa-video"></i></span>
                        <div><span><?php echo t('Platform', 'Platform'); ?></span><strong><?php echo t('Online (Zoom/Meet)', 'Online (Zoom/Meet)'); ?></strong></div>
                    </div>
                </div>
            </div>

            <!-- Kanan: kartu pendaftaran -->
            <aside class="sm-side">
                <div class="sm-ticket">
                    <div class="sm-price-row">
                        <div>
                            <span class="sm-price-lbl"><?php echo t('Harga Tiket', 'Ticket Price'); ?></span>
                            <div class="sm-price <?php echo $sm_free ? 'sm-price-free' : ''; ?>">
                                <?php if ($sm_free): ?><?php echo t('Gratis', 'Free'); ?><?php else: ?>Rp <?php echo number_format($seminar->price, 0, ',', '.'); ?><?php endif; ?>
                            </div>
                        </div>
                        <?php if (!$sm_free): ?>
                            <span class="sm-save"><i class="fas fa-bolt"></i> <?php echo t('Ppn sudah termasuk', 'VAT included'); ?></span>
                        <?php endif; ?>
                    </div>

                    <?php if (!empty($seminar->quota)): ?>
                    <div class="sm-seats">
                        <div class="sm-seats-top">
                            <span><?php echo $sm_seats > 0 ? t('Sisa Kursi', 'Seats Left') : t('Kursi Penuh', 'Sold Out'); ?>: <strong><?php echo max(0, $sm_seats); ?></strong></span>
                            <span><?php echo $sm_pct; ?>% <?php echo t('terisi', 'filled'); ?></span>
                        </div>
                        <div class="sm-progress"><span style="width:<?php echo $sm_pct; ?>%"></span></div>
                    </div>
                    <?php endif; ?>

                    <div class="sm-cta">
                        <?php if ($is_registered): ?>
                            <div class="sm-registered"><i class="fas fa-circle-check"></i> <?php echo t('Kamu sudah terdaftar di seminar ini', 'You are registered for this seminar'); ?></div>
                            <?php if (!empty($seminar->location_link)): ?>
                                <a href="<?php echo $seminar->location_link; ?>" target="_blank" rel="noopener" class="sm-btn sm-btn-primary"><i class="fas fa-video"></i> <?php echo t('Masuk Webinar', 'Join Webinar'); ?></a>
                            <?php else: ?>
                                <div class="sm-coming"><?php echo t('Link webinar akan muncul saat acara dimulai.', 'The webinar link will appear when the event starts.'); ?></div>
                            <?php endif; ?>
                        <?php elseif ($sm_quota_full): ?>
                            <button class="sm-btn sm-btn-disabled" disabled><i class="fas fa-ban"></i> <?php echo t('Kuota Penuh', 'Quota Full'); ?></button>
                        <?php elseif (!$sm_is_up): ?>
                            <button class="sm-btn sm-btn-disabled" disabled><i class="fas fa-clock"></i> <?php echo t('Pendaftaran Ditutup', 'Registration Closed'); ?></button>
                        <?php else: ?>
                            <a href="<?php echo base_url('seminars/register/' . encode_id($seminar->id)); ?>" class="sm-btn sm-btn-primary">
                                <?php if ($sm_free): ?><i class="fas fa-user-plus"></i> <?php echo t('Daftar Gratis Sekarang', 'Register Free Now'); ?>
                                <?php else: ?><i class="fas fa-ticket"></i> <?php echo t('Beli Tiket Sekarang', 'Buy Ticket Now'); ?><?php endif; ?>
                            </a>
                        <?php endif; ?>
                    </div>

                    <ul class="sm-list">
                        <li><i class="fas fa-shield-halved"></i><?php echo t('Pembayaran aman & terverifikasi', 'Secure & verified payment'); ?></li>
                        <li><i class="fas fa-repeat"></i><?php echo t('Rekaman tersedia bagi peserta', 'Recording available for attendees'); ?></li>
                    </ul>
                </div>

                <div class="sm-need">
                    <div class="sm-need-ic"><i class="fas fa-circle-question"></i></div>
                    <div>
                        <strong><?php echo t('Butuh Bantuan?', 'Need Help?'); ?></strong>
                        <p><?php echo t('Hubungi kami jika ada pertanyaan seputar pendaftaran.', 'Contact us if you have any questions about registration.'); ?></p>
                        <a href="<?php echo base_url('pages/contact'); ?>"><i class="fas fa-headset"></i> <?php echo t('Hubungi Kami', 'Contact Us'); ?></a>
                    </div>
                </div>
            </aside>
        </div>
    </div>
</div>

<style>
.sm-wrap{background:#f4f7f6;padding-bottom:3.5rem;}
/* ===== Hero ===== */
.sm-hero{position:relative;overflow:hidden;background:linear-gradient(140deg,#06302b 0%,#0b4a3d 45%,#0d7c68 100%);color:#fff;}
.sm-hero-grid{position:absolute;inset:0;background-image:linear-gradient(rgba(255,255,255,.05) 1px,transparent 1px),linear-gradient(90deg,rgba(255,255,255,.05) 1px,transparent 1px);background-size:46px 46px;mask-image:radial-gradient(ellipse at 70% 30%,#000 0%,transparent 75%);-webkit-mask-image:radial-gradient(ellipse at 70% 30%,#000 0%,transparent 75%);}
.sm-hero-blob{position:absolute;border-radius:50%;filter:blur(3px);}
.sm-hero-blob-a{width:400px;height:400px;background:radial-gradient(circle,rgba(20,184,166,.28),transparent 65%);top:-150px;right:-100px;}
.sm-hero-blob-b{width:340px;height:340px;background:radial-gradient(circle,rgba(251,191,36,.12),transparent 65%);bottom:-140px;left:-80px;}
.sm-hero-in{position:relative;z-index:2;padding:1.6rem 1rem 2.4rem;max-width:1200px;}
.sm-breadcrumb{display:flex;align-items:center;gap:.5rem;font-size:.72rem;margin-bottom:1.6rem;}
.sm-breadcrumb a{color:rgba(255,255,255,.65);text-decoration:none;}
.sm-breadcrumb a:hover{color:#fff;}
.sm-breadcrumb i{color:rgba(255,255,255,.3);font-size:.5rem;}
.sm-breadcrumb span{color:rgba(255,255,255,.85);white-space:nowrap;overflow:hidden;text-overflow:ellipsis;max-width:280px;}
.sm-hero-main{display:grid;grid-template-columns:1.1fr .9fr;gap:2.6rem;align-items:center;}
.sm-hero-tx h1{font-size:clamp(1.45rem,3vw,2.2rem);font-weight:800;letter-spacing:-.03em;line-height:1.22;margin:.9rem 0 1.1rem;}
.sm-tags{display:flex;flex-wrap:wrap;gap:.45rem;}
.sm-tag{display:inline-flex;align-items:center;gap:.4rem;font-size:.66rem;font-weight:700;padding:.38rem .8rem;border-radius:99px;background:rgba(255,255,255,.12);border:1px solid rgba(255,255,255,.18);color:#fff;}
.sm-tag i{font-size:.5rem;}
.sm-tag-up{background:rgba(251,191,36,.18);border-color:rgba(251,191,36,.45);color:#fcd34d;}
.sm-tag-up i{color:#fbbf24;}
.sm-tag-end{background:rgba(15,23,42,.35);color:#cbd5e1;}
.sm-tag-free{background:rgba(74,222,128,.16);border-color:rgba(74,222,128,.4);color:#86efac;}
.sm-speaker{display:inline-flex;align-items:center;gap:.75rem;background:rgba(255,255,255,.1);border:1px solid rgba(255,255,255,.16);padding:.55rem .95rem .55rem .6rem;border-radius:14px;}
.sm-speaker img{border-radius:50%;background:#0d9488;}
.sm-speaker-role{display:block;font-size:.6rem;color:rgba(255,255,255,.6);text-transform:uppercase;letter-spacing:.05em;}
.sm-speaker-name{font-size:.85rem;font-weight:700;color:#fff;}
.sm-hero-img{position:relative;border-radius:18px;overflow:hidden;box-shadow:0 26px 60px -20px rgba(0,0,0,.5);border:1px solid rgba(255,255,255,.16);transform:rotate(1.2deg);transition:transform .3s;}
.sm-hero-img:hover{transform:rotate(0deg);}
.sm-hero-img img{width:100%;aspect-ratio:16/10;object-fit:cover;display:block;}
.sm-hero-img::after{content:'';position:absolute;inset:0;background:linear-gradient(180deg,transparent 55%,rgba(6,26,22,.55));}
.sm-img-date,.sm-img-time{position:absolute;z-index:2;display:inline-flex;align-items:center;gap:.45rem;font-size:.7rem;font-weight:700;color:#fff;background:rgba(6,48,43,.7);backdrop-filter:blur(8px);border:1px solid rgba(255,255,255,.2);padding:.42rem .8rem;border-radius:99px;}
.sm-img-date{bottom:.9rem;left:.9rem;}
.sm-img-time{bottom:.9rem;right:.9rem;}
.sm-img-date i,.sm-img-time i{color:#fbbf24;}
/* ===== Body ===== */
.sm-body{padding:2.2rem 1rem 0;max-width:1200px;}
.sm-grid{display:grid;grid-template-columns:minmax(0,1fr) 370px;gap:1.6rem;align-items:start;}
.sm-card{background:#fff;border:1px solid #e6edec;border-radius:16px;padding:1.5rem 1.5rem 1.2rem;margin-bottom:1.2rem;box-shadow:0 2px 8px rgba(15,23,42,.03);}
.sm-card h2{display:flex;align-items:center;gap:.6rem;font-size:1rem;font-weight:800;color:#0f172a;margin:0 0 1rem;letter-spacing:-.01em;}
.sm-h2-ic{width:32px;height:32px;flex:0 0 auto;border-radius:9px;background:#f0fdfa;color:#0d9488;display:inline-flex;align-items:center;justify-content:center;font-size:.75rem;}
.sm-desc{font-size:.88rem;line-height:1.8;color:#475569;white-space:normal;}
.sm-desc p{margin:0 0 .8rem;}
.sm-benefit-grid{display:grid;grid-template-columns:1fr 1fr;gap:.7rem;}
.sm-benefit{display:flex;gap:.7rem;align-items:flex-start;padding:.85rem;border-radius:12px;background:#f8fafc;border:1px solid #eef2f6;}
.sm-benefit-ic{width:36px;height:36px;flex:0 0 auto;border-radius:10px;background:#fff;border:1px solid #e2e8f0;color:#0d9488;display:inline-flex;align-items:center;justify-content:center;font-size:.8rem;}
.sm-benefit strong{display:block;font-size:.78rem;font-weight:700;color:#0f172a;margin-bottom:.15rem;}
.sm-benefit small{font-size:.68rem;color:#64748b;line-height:1.45;display:block;}
.sm-info-cards{display:grid;grid-template-columns:repeat(3,1fr);gap:.9rem;}
.sm-info{display:flex;align-items:center;gap:.7rem;background:#fff;border:1px solid #e6edec;border-radius:13px;padding:.85rem .9rem;}
.sm-info-ic{width:36px;height:36px;flex:0 0 auto;border-radius:10px;background:#f0fdfa;color:#0d9488;display:inline-flex;align-items:center;justify-content:center;font-size:.85rem;}
.sm-info span{display:block;font-size:.62rem;color:#94a3b8;text-transform:uppercase;letter-spacing:.04em;font-weight:600;}
.sm-info strong{font-size:.75rem;color:#0f172a;font-weight:700;display:block;margin-top:.1rem;}
/* ===== Sidebar ===== */
.sm-side{position:sticky;top:76px;display:flex;flex-direction:column;gap:1rem;}
.sm-ticket{background:#fff;border:1px solid #e6edec;border-radius:18px;padding:1.5rem;box-shadow:0 18px 40px -18px rgba(6,48,43,.18);}
.sm-price-row{display:flex;align-items:flex-start;justify-content:space-between;gap:.8rem;margin-bottom:1rem;}
.sm-price-lbl{display:block;font-size:.64rem;font-weight:700;text-transform:uppercase;letter-spacing:.06em;color:#94a3b8;margin-bottom:.25rem;}
.sm-price{font-size:1.75rem;font-weight:800;letter-spacing:-.03em;color:#0f172a;line-height:1;}
.sm-price-free{color:#15803d;}
.sm-save{display:inline-flex;align-items:center;gap:.35rem;font-size:.62rem;font-weight:600;color:#0d9488;background:#f0fdfa;border:1px solid #ccfbf1;padding:.3rem .6rem;border-radius:99px;}
.sm-seats{margin-bottom:1.1rem;}
.sm-seats-top{display:flex;justify-content:space-between;font-size:.7rem;color:#64748b;margin-bottom:.4rem;}
.sm-seats-top strong{color:#0f172a;}
.sm-progress{height:7px;background:#eef2f1;border-radius:99px;overflow:hidden;}
.sm-progress span{display:block;height:100%;border-radius:99px;background:linear-gradient(90deg,#0d9488,#14b8a6);transition:width .5s;}
.sm-cta{display:flex;flex-direction:column;gap:.65rem;margin-bottom:1.1rem;}
.sm-btn{display:inline-flex;align-items:center;justify-content:center;gap:.55rem;width:100%;padding:.9rem 1rem;border-radius:13px;font-weight:700;font-size:.88rem;text-decoration:none;border:none;cursor:pointer;font-family:inherit;transition:all .2s;}
.sm-btn-primary{background:linear-gradient(135deg,#0d9488,#0b6b5c);color:#fff;box-shadow:0 12px 26px -10px rgba(13,148,136,.6);}
.sm-btn-primary:hover{transform:translateY(-2px);box-shadow:0 16px 30px -10px rgba(13,148,136,.65);color:#fff;}
.sm-btn-disabled{background:#e2e8f0;color:#94a3b8;cursor:not-allowed;}
.sm-registered{display:flex;align-items:center;gap:.5rem;font-size:.8rem;font-weight:700;color:#15803d;background:#f0fdf4;border:1px solid #bbf7d0;padding:.7rem .9rem;border-radius:12px;}
.sm-coming{font-size:.74rem;color:#64748b;background:#f8fafc;border:1px dashed #e2e8f0;border-radius:12px;padding:.75rem .9rem;text-align:center;}
.sm-list{list-style:none;margin:0;padding:1rem 0 0;border-top:1px solid #f1f5f9;display:flex;flex-direction:column;gap:.55rem;}
.sm-list li{display:flex;align-items:center;gap:.6rem;font-size:.72rem;color:#64748b;}
.sm-list i{color:#0d9488;font-size:.72rem;width:16px;text-align:center;}
.sm-need{display:flex;gap:.8rem;align-items:flex-start;background:#fff;border:1px solid #e6edec;border-radius:16px;padding:1.1rem 1.2rem;}
.sm-need-ic{width:38px;height:38px;flex:0 0 auto;border-radius:11px;background:#fffbeb;color:#f59e0b;display:inline-flex;align-items:center;justify-content:center;font-size:.95rem;}
.sm-need strong{display:block;font-size:.82rem;color:#0f172a;margin-bottom:.2rem;}
.sm-need p{font-size:.7rem;line-height:1.5;color:#64748b;margin:0 0 .45rem;}
.sm-need a{font-size:.74rem;font-weight:700;color:#0d9488;text-decoration:none;}
.sm-need a:hover{text-decoration:underline;}
/* ===== Responsive ===== */
@media (max-width:1023px){
  .sm-hero-main{grid-template-columns:1fr;gap:1.6rem;}
  .sm-hero-img{max-width:560px;}
  .sm-grid{grid-template-columns:1fr;}
  .sm-side{position:static;}
}
@media (max-width:640px){
  .sm-hero-in{padding:1.2rem .9rem 1.8rem;}
  .sm-hero-main h1{font-size:1.3rem;}
  .sm-benefit-grid{grid-template-columns:1fr;}
  .sm-info-cards{grid-template-columns:1fr;}
  .sm-body{padding:1.4rem .9rem 0;}
  .sm-img-date,.sm-img-time{font-size:.62rem;padding:.34rem .6rem;}
}
</style>
