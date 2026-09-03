<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Katalog publik Seminar & Webinar BISATUNTAS.
 * Data per kartu: title, description, price, quota, date_time, thumbnail, speaker_name.
 */
$se_now  = time();
$se_mo   = array(1 => 'Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des');
$se_dy   = array('Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab');

$se_total = count($seminars);
$se_free  = 0;
$se_up    = 0;
foreach ($seminars as $s) { if ((float)$s->price <= 0) $se_free++; if (strtotime($s->date_time) >= $se_now) $se_up++; }
?>

<!-- ================= HERO ================= -->
<section class="se-hero">
    <div class="se-hero-grid"></div>
    <div class="se-hero-blob se-hero-blob-a"></div>
    <div class="se-hero-blob se-hero-blob-b"></div>
    <div class="container se-hero-in">
        <span class="se-chip se-chip-hero"><i class="fas fa-chalkboard-user"></i> <?php echo t('Seminar & Webinar Live', 'Seminars & Live Webinars'); ?></span>
        <h1><?php echo t('Belajar Langsung dari Para Pakar.', 'Learn Directly from the Experts.'); ?></h1>
        <p><?php echo t('Ikuti diskusi interaktif, tanya jawab real-time, dan perluas wawasanmu bersama praktisi terbaik di bidangnya.', 'Join interactive discussions, ask questions in real-time, and broaden your insights with the best practitioners in their fields.'); ?></p>
        <div class="se-hero-stats">
            <div class="se-stat"><strong><?php echo $se_total; ?></strong><span><?php echo t('Total Acara', 'Total Events'); ?></span></div>
            <div class="se-stat"><strong><?php echo $se_up; ?></strong><span><?php echo t('Mendatang', 'Upcoming'); ?></span></div>
            <div class="se-stat"><strong><?php echo $se_free; ?></strong><span><?php echo t('Gratis', 'Free'); ?></span></div>
        </div>
        <a href="#seList" class="se-btn se-btn-light"><span><?php echo t('Jelajahi Acara', 'Explore Events'); ?></span><i class="fas fa-arrow-down"></i></a>
    </div>
</section>

<!-- ================= KATALOG ================= -->
<div class="container se-body" id="seList">
    <div class="se-toolbar">
        <div class="se-headline">
            <h2><?php echo t('Daftar Acara', 'Event Lineup'); ?></h2>
            <p><?php echo t('Pilih seminar yang sesuai minatmu, daftar, dan dapatkan e-sertifikat.', 'Pick a seminar that matches your interest, register, and earn an e-certificate.'); ?></p>
        </div>
        <div class="se-filters" role="tablist" aria-label="<?php echo t('Filter seminar', 'Seminar filter'); ?>">
            <button type="button" class="se-fchip is-active" data-filter="all"><?php echo t('Semua', 'All'); ?></button>
            <button type="button" class="se-fchip" data-filter="free"><?php echo t('Gratis', 'Free'); ?></button>
            <button type="button" class="se-fchip" data-filter="paid"><?php echo t('Berbayar', 'Paid'); ?></button>
        </div>
    </div>

    <?php if (empty($seminars)): ?>
        <div class="se-empty">
            <div class="se-empty-ic"><i class="far fa-calendar-xmark"></i></div>
            <h3><?php echo t('Belum Ada Seminar', 'No Seminars Yet'); ?></h3>
            <p><?php echo t('Kami sedang menyiapkan acara seru. Pantau terus halaman ini!', 'We are preparing exciting events. Keep an eye on this page!'); ?></p>
            <a href="<?php echo base_url('courses'); ?>" class="se-btn"><?php echo t('Lihat Kelas Dulu', 'Browse Courses Instead'); ?></a>
        </div>
    <?php else: ?>
        <div class="se-grid">
            <?php foreach ($seminars as $seminar):
                $se_ts    = strtotime($seminar->date_time);
                $se_day   = $se_dy[(int)date('w', $se_ts)];
                $se_date  = (int)date('j', $se_ts) . ' ' . $se_mo[(int)date('n', $se_ts)];
                $se_year  = (int)date('Y', $se_ts);
                $se_time  = date('H:i', $se_ts);
                $se_free  = ((float)$seminar->price <= 0);
                $se_is_up = ($se_ts >= $se_now);
                if ($se_is_up && date('Y-m-d', $se_ts) === date('Y-m-d', $se_now)) { $se_status = t('Hari Ini', 'Today'); $se_st_cls = 'se-st-live'; }
                elseif ($se_is_up) { $se_status = t('Mendatang', 'Upcoming'); $se_st_cls = 'se-st-up'; }
                else { $se_status = t('Selesai', 'Ended'); $se_st_cls = 'se-st-end'; }
            ?>
            <a class="se-card" href="<?php echo base_url('seminars/detail/' . encode_id($seminar->id)); ?>" data-price="<?php echo $se_free ? '0' : '1'; ?>">
                <div class="se-thumb">
                    <img src="<?php echo base_url('uploads/seminars/' . $seminar->thumbnail); ?>" onerror="this.src='https://images.unsplash.com/photo-1540575467063-178a50c2df87?w=600&auto=format&fit=crop&q=60';" alt="<?php echo htmlspecialchars($seminar->title); ?>" loading="lazy">
                    <span class="se-st <?php echo $se_st_cls; ?>"><i class="fas <?php echo $se_is_up ? 'fa-circle' : 'fa-circle-check'; ?>"></i><?php echo $se_status; ?></span>
                    <span class="se-price <?php echo $se_free ? 'se-price-free' : ''; ?>"><?php echo $se_free ? t('Gratis', 'Free') : 'Rp ' . number_format($seminar->price, 0, ',', '.'); ?></span>
                    <span class="se-live"><i class="fas fa-video"></i> <?php echo t('Live Online', 'Live Online'); ?></span>
                </div>
                <div class="se-body2">
                    <div class="se-meta">
                        <span class="se-dt"><i class="far fa-calendar"></i><?php echo $se_day . ', ' . $se_date . ' ' . $se_year; ?></span>
                        <span class="se-dt"><i class="far fa-clock"></i><?php echo $se_time; ?> WIB</span>
                    </div>
                    <h3 class="se-title"><?php echo htmlspecialchars($seminar->title); ?></h3>
                    <p class="se-desc"><?php echo htmlspecialchars($seminar->description); ?></p>
                    <div class="se-card-foot">
                        <div class="se-speaker">
                            <img src="https://ui-avatars.com/api/?name=<?php echo urlencode($seminar->speaker_name); ?>&background=0d9488&color=fff&size=64" alt="" loading="lazy">
                            <div>
                                <span class="se-speaker-name"><?php echo htmlspecialchars($seminar->speaker_name); ?></span>
                                <span class="se-speaker-role"><?php echo t('Pembicara', 'Speaker'); ?></span>
                            </div>
                        </div>
                        <span class="se-cta"><i class="fas fa-arrow-right"></i></span>
                    </div>
                </div>
            </a>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<style>
/* ===== Hero ===== */
.se-hero{position:relative;overflow:hidden;background:linear-gradient(140deg,#06302b 0%,#0b4a3d 45%,#0d7c68 100%);color:#fff;padding:3.6rem 0 4.2rem;}
.se-hero-grid{position:absolute;inset:0;background-image:linear-gradient(rgba(255,255,255,.05) 1px,transparent 1px),linear-gradient(90deg,rgba(255,255,255,.05) 1px,transparent 1px);background-size:46px 46px;mask-image:radial-gradient(ellipse at 60% 40%,#000 0%,transparent 80%);-webkit-mask-image:radial-gradient(ellipse at 60% 40%,#000 0%,transparent 80%);}
.se-hero-blob{position:absolute;border-radius:50%;filter:blur(3px);}
.se-hero-blob-a{width:460px;height:460px;background:radial-gradient(circle,rgba(20,184,166,.3),transparent 65%);top:-160px;right:-120px;}
.se-hero-blob-b{width:420px;height:420px;background:radial-gradient(circle,rgba(251,191,36,.12),transparent 65%);bottom:-180px;left:-120px;}
.se-hero-in{position:relative;z-index:2;max-width:820px;text-align:center;}
.se-hero-in h1{font-size:clamp(1.7rem,4.4vw,2.7rem);font-weight:800;letter-spacing:-.035em;line-height:1.16;margin:0 0 .9rem;}
.se-hero-in > p{font-size:.95rem;line-height:1.7;color:rgba(255,255,255,.78);max-width:600px;margin:0 auto 1.7rem;}
.se-chip{display:inline-flex;align-items:center;gap:.45rem;font-size:.68rem;font-weight:700;letter-spacing:.06em;text-transform:uppercase;padding:.4rem .85rem;border-radius:99px;}
.se-chip-hero{background:rgba(255,255,255,.12);border:1px solid rgba(255,255,255,.2);color:#fff;margin-bottom:1.2rem;}
.se-chip-hero i{color:#fbbf24;}
.se-hero-stats{display:flex;justify-content:center;gap:2.2rem;margin:0 0 1.9rem;}
.se-stat strong{display:block;font-size:1.45rem;font-weight:800;color:#fff;}
.se-stat span{font-size:.72rem;color:rgba(255,255,255,.6);}
.se-btn{display:inline-flex;align-items:center;gap:.55rem;padding:.8rem 1.5rem;border-radius:12px;font-weight:700;font-size:.87rem;text-decoration:none;cursor:pointer;border:none;font-family:inherit;transition:transform .18s,box-shadow .18s,background .18s;}
.se-btn-light{background:linear-gradient(135deg,#0d9488,#0b6b5c);color:#fff;box-shadow:0 12px 30px -10px rgba(0,0,0,.4);}
.se-btn-light:hover{transform:translateY(-2px);}
.se-btn-dark{background:#0d9488;color:#fff;box-shadow:0 10px 26px -10px rgba(13,148,136,.55);}
.se-btn-dark:hover{transform:translateY(-2px);color:#fff;}
/* ===== Body ===== */
.se-body{padding:2.6rem 1rem 4rem;max-width:1200px;}
.se-toolbar{display:flex;align-items:flex-end;justify-content:space-between;gap:1.2rem;flex-wrap:wrap;margin-bottom:1.8rem;}
.se-headline h2{font-size:1.45rem;font-weight:800;letter-spacing:-.025em;color:#0f172a;margin:0 0 .3rem;}
.se-headline p{font-size:.82rem;color:#64748b;margin:0;}
.se-filters{display:flex;gap:.45rem;background:#eef2f1;padding:.3rem;border-radius:12px;}
.se-fchip{border:none;background:transparent;padding:.5rem 1.05rem;border-radius:9px;font-size:.78rem;font-weight:600;color:#475569;cursor:pointer;font-family:inherit;transition:all .18s;}
.se-fchip:hover{color:#0d9488;}
.se-fchip.is-active{background:#fff;color:#0d9488;box-shadow:0 3px 10px rgba(15,23,42,.08);}
/* ===== Grid & kartu ===== */
.se-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(300px,1fr));gap:1.4rem;}
.se-card{background:#fff;border:1px solid #e6edec;border-radius:18px;overflow:hidden;text-decoration:none;display:flex;flex-direction:column;box-shadow:0 2px 10px rgba(15,23,42,.04);transition:transform .22s,box-shadow .22s,border-color .22s;}
.se-card:hover{transform:translateY(-5px);box-shadow:0 22px 44px -18px rgba(6,48,43,.25);border-color:#cfe8e2;}
.se-thumb{position:relative;aspect-ratio:16/9;overflow:hidden;}
.se-thumb img{width:100%;height:100%;object-fit:cover;display:block;transition:transform .35s;}
.se-card:hover .se-thumb img{transform:scale(1.05);}
.se-thumb::after{content:'';position:absolute;inset:0;background:linear-gradient(180deg,rgba(6,26,22,.16) 0%,transparent 42%);}
.se-st{position:absolute;top:.75rem;left:.75rem;z-index:2;display:inline-flex;align-items:center;gap:.35rem;padding:.34rem .7rem;border-radius:99px;font-size:.64rem;font-weight:700;backdrop-filter:blur(6px);box-shadow:0 4px 12px rgba(0,0,0,.18);}
.se-st i{font-size:.45rem;}
.se-st-up{background:rgba(13,148,136,.92);color:#fff;}
.se-st-live{background:#fbbf24;color:#06251f;}
.se-st-end{background:rgba(15,23,42,.8);color:#e2e8f0;}
.se-price{position:absolute;top:.75rem;right:.75rem;z-index:2;padding:.34rem .72rem;border-radius:99px;font-size:.66rem;font-weight:800;background:#fff;color:#0f172a;box-shadow:0 4px 12px rgba(0,0,0,.18);}
.se-price-free{background:#dcfce7;color:#15803d;}
.se-live{position:absolute;bottom:.7rem;left:.75rem;z-index:2;display:inline-flex;align-items:center;gap:.4rem;font-size:.62rem;font-weight:600;color:#fff;background:rgba(6,48,43,.55);border:1px solid rgba(255,255,255,.25);backdrop-filter:blur(6px);padding:.28rem .6rem;border-radius:99px;}
.se-body2{display:flex;flex-direction:column;flex:1;padding:1rem 1.05rem 1.05rem;}
.se-meta{display:flex;align-items:center;gap:.9rem;font-size:.68rem;font-weight:600;color:#64748b;margin-bottom:.55rem;}
.se-dt{display:inline-flex;align-items:center;gap:.35rem;}
.se-dt i{font-size:.62rem;color:#0d9488;}
.se-title{font-size:.95rem;font-weight:700;color:#0f172a;line-height:1.4;margin:0 0 .4rem;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;letter-spacing:-.01em;}
.se-desc{font-size:.78rem;line-height:1.55;color:#64748b;margin:0 0 .9rem;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;}
.se-card-foot{display:flex;align-items:center;justify-content:space-between;gap:.6rem;border-top:1px solid #f1f5f9;padding-top:.8rem;margin-top:auto;}
.se-speaker{display:flex;align-items:center;gap:.55rem;min-width:0;}
.se-speaker img{width:34px;height:34px;border-radius:50%;flex-shrink:0;background:#0d9488;}
.se-speaker-name{display:block;font-size:.72rem;font-weight:700;color:#0f172a;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;max-width:150px;}
.se-speaker-role{font-size:.6rem;color:#94a3b8;}
.se-cta{flex-shrink:0;width:32px;height:32px;border-radius:10px;background:#f0fdfa;color:#0d9488;display:inline-flex;align-items:center;justify-content:center;font-size:.72rem;transition:all .2s;}
.se-card:hover .se-cta{background:#0d9488;color:#fff;transform:translateX(2px);}
/* ===== Empty state ===== */
.se-empty{text-align:center;padding:3.5rem 1rem;border:1.5px dashed #d7e2e0;border-radius:18px;background:#fbfdfd;}
.se-empty-ic{width:74px;height:74px;margin:0 auto 1rem;border-radius:22px;background:#f0fdfa;color:#0d9488;font-size:1.7rem;display:flex;align-items:center;justify-content:center;}
.se-empty h3{font-size:1.1rem;font-weight:700;color:#0f172a;margin:0 0 .4rem;}
.se-empty p{font-size:.84rem;color:#64748b;margin:0 0 1.2rem;}
/* ===== Responsive ===== */
@media (max-width:640px){
  .se-hero{padding:2.6rem 0 3rem;}
  .se-hero-stats{gap:1.4rem;}
  .se-toolbar{flex-direction:column;align-items:stretch;}
  .se-filters{width:100%;}
  .se-fchip{flex:1;text-align:center;}
  .se-grid{gap:1.1rem;}
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
    var chips = document.querySelectorAll('.se-fchip');
    var cards = document.querySelectorAll('.se-card');
    if (!chips.length || !cards.length) return;
    chips.forEach(function (chip) {
        chip.addEventListener('click', function () {
            chips.forEach(function (c) { c.classList.remove('is-active'); });
            chip.classList.add('is-active');
            var f = chip.getAttribute('data-filter');
            cards.forEach(function (card) {
                var show = (f === 'all') || (f === 'free' && card.getAttribute('data-price') === '0') || (f === 'paid' && card.getAttribute('data-price') === '1');
                card.style.display = show ? '' : 'none';
            });
        });
    });
});
</script>
