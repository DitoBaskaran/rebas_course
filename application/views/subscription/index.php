<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Halaman paket berlangganan (pricing). Wajib login (controller).
 * Variabel: $packages (dengan six_month_option), $active_subscriptions.
 * Aturan highlight: paket 'all' & harga tertinggi = "Paling Laris".
 */
$sub_highlight_id = null;
$sub_max_price = -1;
foreach ($packages as $pkg) { if ((float)$pkg->price > $sub_max_price) { $sub_max_price = (float)$pkg->price; $sub_highlight_id = $pkg->id; } }

function sub_scope_label($scope) {
    if ($scope === 'all') return t('Akses SEMUA konten premium', 'Access ALL premium content');
    if ($scope === 'category') return t('Akses penuh per kategori', 'Full access by category');
    return t('Akses per kursus', 'Access by course');
}
function sub_scope_badge($scope) {
    if ($scope === 'all') return '<i class="fas fa-infinity"></i> ' . t('Semua Konten', 'All Content');
    if ($scope === 'category') return '<i class="fas fa-layer-group"></i> ' . t('Per Kategori', 'By Category');
    return '<i class="fas fa-book-open"></i> ' . t('Per Kursus', 'By Course');
}
function sub_price_format($n) { return number_format((float)$n, 0, ',', '.'); }
?>

<div class="sub-wrap">
    <!-- ===== HERO ===== -->
    <section class="sub-hero">
        <div class="sub-hero-grid"></div>
        <div class="sub-hero-blob sub-hero-blob-a"></div>
        <div class="sub-hero-blob sub-hero-blob-b"></div>
        <div class="container sub-hero-in">
            <span class="sub-chip"><i class="fas fa-crown"></i> <?php echo t('BISATUNTAS Membership', 'BISATUNTAS Membership'); ?></span>
            <h1><?php echo t('Pilih Paket, Buka Akses Tanpa Batas.', 'Pick a Plan, Unlock Unlimited Access.'); ?></h1>
            <p><?php echo t('Satu langganan untuk membuka kursus, seminar, workshop, hingga sesi mentoring pilihanmu.', 'One subscription to unlock courses, seminars, workshops, and your choice of mentoring sessions.'); ?></p>

            <?php if (!empty($active_subscriptions)): ?>
                <div class="sub-has-plan">
                    <i class="fas fa-circle-check"></i>
                    <span><?php echo t('Kamu punya langganan aktif', 'You have an active subscription'); ?> — <a href="<?php echo base_url('subscription/my'); ?>"><?php echo t('Lihat detail', 'View details'); ?></a></span>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <!-- ===== PRICING ===== -->
    <div class="container sub-body">
        <div class="sub-headline">
            <h2><?php echo t('Pilih Sesuai Kebutuhanmu', 'Choose What Fits You'); ?></h2>
            <p><?php echo t('Semua paket bisa dibatalkan kapan saja. Harga sudah termasuk pajak.', 'All plans can be cancelled anytime. Prices include tax.'); ?></p>
        </div>

        <?php if (empty($packages)): ?>
            <div class="sub-empty">
                <div class="sub-empty-ic"><i class="fas fa-box-open"></i></div>
                <h3><?php echo t('Belum Ada Paket', 'No Packages Yet'); ?></h3>
                <p><?php echo t('Tim kami sedang menyiapkan paket langganan. Nantikan segera!', 'We are preparing subscription plans. Stay tuned!'); ?></p>
            </div>
        <?php else: ?>
            <div class="sub-grid">
                <?php foreach ($packages as $pkg):
                    $six = $pkg->six_month_option ?? null;
                    $is_hot = ((float)$pkg->price === $sub_max_price && count($packages) > 1);
                    $is_best = ($pkg->access_scope === 'all' && (float)$pkg->price >= 200000);
                    $pkg_badge = $is_hot ? t('Paling Laris', 'Most Popular') : ($is_best ? t('Terlaris', 'Best Value') : '');
                ?>
                <div class="sub-card <?php echo $is_hot ? 'sub-card-hot' : ($is_best ? 'sub-card-best' : ''); ?>">
                    <?php if ($pkg_badge): ?><span class="sub-badge"><i class="fas fa-fire"></i> <?php echo $pkg_badge; ?></span><?php endif; ?>

                    <div class="sub-card-head">
                        <span class="sub-scope"><?php echo sub_scope_badge($pkg->access_scope); ?></span>
                        <h3><?php echo htmlspecialchars($pkg->name); ?></h3>
                        <p><?php echo htmlspecialchars($pkg->description); ?></p>
                    </div>

                    <div class="sub-price">
                        <span class="sub-currency">Rp</span>
                        <strong><?php echo sub_price_format($pkg->price); ?></strong>
                        <span class="sub-per">/ <?php echo (int)$pkg->duration_days; ?> <?php echo t('hari', 'days'); ?></span>
                    </div>

                    <?php if ($six): ?>
                        <div class="sub-save">
                            <span class="sub-save-tag"><i class="fas fa-tag"></i> <?php echo t('HEMAT', 'SAVE'); ?> <?php echo $six['discount_pct']; ?>%</span>
                            <span class="sub-save-tx">
                                <?php echo t('6 bulan hanya', '6 months only'); ?> <strong>Rp <?php echo sub_price_format($six['discounted']); ?></strong>
                                <small>(<?php echo t('hemat Rp ', 'save Rp ') . sub_price_format($six['savings']); ?>)</small>
                            </span>
                        </div>
                    <?php endif; ?>

                    <ul class="sub-feats">
                        <li class="sub-feat-ok"><i class="fas fa-check"></i><?php echo sub_scope_label($pkg->access_scope); ?></li>
                        <li class="sub-feat-ok"><i class="fas fa-check"></i><?php echo (int)$pkg->duration_days; ?> <?php echo t('hari akses penuh', 'days of full access'); ?></li>
                        <li class="sub-feat-ok"><i class="fas fa-check"></i><?php echo t('Akses di HP, tablet & laptop', 'Access on mobile, tablet & laptop'); ?></li>
                        <li class="sub-feat-ok"><i class="fas fa-check"></i><?php echo t('Sertifikat (jika tersedia)', 'Certificate (if available)'); ?></li>
                        <?php if ($pkg->access_scope === 'all'): ?>
                            <li class="sub-feat-ok"><i class="fas fa-check"></i><?php echo t('Update konten baru gratis', 'Free access to new content'); ?></li>
                            <li class="sub-feat-plus"><i class="fas fa-plus"></i><?php echo t('Prioritas dukungan', 'Priority support'); ?></li>
                        <?php endif; ?>
                    </ul>

                    <div class="sub-actions">
                        <a href="<?php echo base_url('subscription/buy/' . $pkg->slug); ?>" class="sub-btn <?php echo ($is_hot || $is_best) ? 'sub-btn-solid' : 'sub-btn-ghost'; ?>"><?php echo t('Langganan Sekarang', 'Subscribe Now'); ?></a>
                        <?php if ($six): ?>
                            <a href="<?php echo base_url('subscription/buy/' . $pkg->slug . '/6'); ?>" class="sub-btn sub-btn-six"><i class="fas fa-bolt"></i> <?php echo t('6 Bulan', '6 Months'); ?></a>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <div class="sub-note-line">
            <div class="sub-note-item"><i class="fas fa-shield-halved"></i><div><strong><?php echo t('Pembayaran Aman', 'Secure Payment'); ?></strong><span><?php echo t('QRIS, VA, e-wallet & transfer bank', 'QRIS, VA, e-wallet & bank transfer'); ?></span></div></div>
            <div class="sub-note-item"><i class="fas fa-bolt"></i><div><strong><?php echo t('Aktivasi Cepat', 'Instant Activation'); ?></strong><span><?php echo t('Langsung aktif setelah pembayaran dikonfirmasi', 'Active right after payment is confirmed'); ?></span></div></div>
            <div class="sub-note-item"><i class="fas fa-headset"></i><div><strong><?php echo t('Dukungan 1-on-1', '1-on-1 Support'); ?></strong><span><?php echo t('Tim kami siap membantu kapan pun', 'Our team is ready to help anytime'); ?></span></div></div>
        </div>
    </div>
</div>

<style>
.sub-wrap{background:#f4f7f6;}
/* ===== Hero ===== */
.sub-hero{position:relative;overflow:hidden;background:linear-gradient(140deg,#06302b 0%,#0b4a3d 45%,#0d7c68 100%);color:#fff;padding:3.6rem 0 4.4rem;}
.sub-hero-grid{position:absolute;inset:0;background-image:linear-gradient(rgba(255,255,255,.05) 1px,transparent 1px),linear-gradient(90deg,rgba(255,255,255,.05) 1px,transparent 1px);background-size:46px 46px;mask-image:radial-gradient(ellipse at 50% 30%,#000 0%,transparent 78%);-webkit-mask-image:radial-gradient(ellipse at 50% 30%,#000 0%,transparent 78%);}
.sub-hero-blob{position:absolute;border-radius:50%;filter:blur(3px);}
.sub-hero-blob-a{width:480px;height:480px;background:radial-gradient(circle,rgba(20,184,166,.3),transparent 65%);top:-170px;left:35%;}
.sub-hero-blob-b{width:400px;height:400px;background:radial-gradient(circle,rgba(251,191,36,.12),transparent 65%);bottom:-170px;right:-110px;}
.sub-hero-in{position:relative;z-index:2;max-width:800px;text-align:center;}
.sub-hero-in h1{font-size:clamp(1.7rem,4.2vw,2.6rem);font-weight:800;letter-spacing:-.035em;line-height:1.16;margin:0 0 .9rem;}
.sub-hero-in > p{font-size:.95rem;line-height:1.7;color:rgba(255,255,255,.78);max-width:620px;margin:0 auto 1.7rem;}
.sub-chip{display:inline-flex;align-items:center;gap:.5rem;font-size:.68rem;font-weight:700;letter-spacing:.08em;text-transform:uppercase;padding:.42rem .9rem;border-radius:99px;background:rgba(251,191,36,.16);border:1px solid rgba(251,191,36,.45);color:#fcd34d;margin-bottom:1.3rem;}
.sub-chip i{color:#fbbf24;}
.sub-has-plan{display:inline-flex;align-items:center;gap:.55rem;background:rgba(74,222,128,.14);border:1px solid rgba(74,222,128,.4);padding:.55rem 1rem;border-radius:12px;font-size:.8rem;color:#d1fae5;margin-top:.4rem;}
.sub-has-plan i{color:#4ade80;}
.sub-has-plan a{color:#6ee7b7;font-weight:700;text-decoration:none;}
.sub-has-plan a:hover{text-decoration:underline;}
/* ===== Body ===== */
.sub-body{padding:2.6rem 1rem 4rem;max-width:1180px;}
.sub-headline{text-align:center;margin-bottom:2.2rem;}
.sub-headline h2{font-size:1.6rem;font-weight:800;letter-spacing:-.03em;color:#0f172a;margin:0 0 .35rem;}
.sub-headline p{font-size:.86rem;color:#64748b;margin:0;}
.sub-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(300px,1fr));gap:1.5rem;align-items:stretch;}
/* ===== Kartu paket ===== */
.sub-card{position:relative;display:flex;flex-direction:column;background:#fff;border:1px solid #e6edec;border-radius:20px;padding:1.7rem 1.6rem 1.5rem;box-shadow:0 4px 16px rgba(15,23,42,.04);transition:transform .22s,box-shadow .22s,border-color .22s;}
.sub-card:hover{transform:translateY(-5px);box-shadow:0 24px 48px -18px rgba(6,48,43,.22);}
.sub-card-hot{border:2px solid #f59e0b;box-shadow:0 18px 40px -16px rgba(245,158,11,.35);}
.sub-card-best{border:2px solid #0d9488;}
.sub-badge{position:absolute;top:-13px;left:50%;transform:translateX(-50%);display:inline-flex;align-items:center;gap:.4rem;font-size:.66rem;font-weight:800;letter-spacing:.04em;text-transform:uppercase;padding:.38rem .95rem;border-radius:99px;color:#fff;white-space:nowrap;box-shadow:0 6px 16px rgba(0,0,0,.12);}
.sub-card-hot .sub-badge{background:linear-gradient(135deg,#f59e0b,#ea580c);}
.sub-card-best .sub-badge{background:linear-gradient(135deg,#0d9488,#0b6b5c);}
.sub-card-head{display:flex;flex-direction:column;gap:.35rem;min-height:108px;}
.sub-scope{display:inline-flex;align-items:center;gap:.4rem;font-size:.62rem;font-weight:700;text-transform:uppercase;letter-spacing:.05em;color:#0d9488;background:#f0fdfa;border:1px solid #ccfbf1;padding:.3rem .65rem;border-radius:99px;width:fit-content;}
.sub-card-head h3{font-size:1.25rem;font-weight:800;letter-spacing:-.02em;color:#0f172a;margin:0;}
.sub-card-head p{font-size:.78rem;line-height:1.55;color:#64748b;margin:0;}
.sub-price{display:flex;align-items:baseline;gap:.35rem;margin:1.1rem 0 .3rem;}
.sub-currency{font-size:.95rem;font-weight:800;color:#0f172a;}
.sub-price strong{font-size:2.1rem;font-weight:800;letter-spacing:-.04em;color:#0f172a;line-height:1;}
.sub-per{font-size:.72rem;color:#94a3b8;font-weight:500;}
.sub-save{display:flex;align-items:center;gap:.6rem;background:#fefce8;border:1px solid #fde68a;border-radius:12px;padding:.6rem .75rem;margin:.75rem 0 .2rem;}
.sub-save-tag{flex:0 0 auto;display:inline-flex;align-items:center;gap:.3rem;font-size:.6rem;font-weight:800;color:#92400e;background:#fef3c7;padding:.28rem .55rem;border-radius:8px;}
.sub-save-tx{font-size:.72rem;color:#92400e;line-height:1.4;}
.sub-save-tx strong{color:#b45309;}
.sub-save-tx small{display:block;color:#a16207;font-size:.62rem;}
.sub-feats{list-style:none;margin:1rem 0 1.3rem;padding:0;display:flex;flex-direction:column;gap:.65rem;flex-grow:1;}
.sub-feats li{display:flex;align-items:flex-start;gap:.6rem;font-size:.8rem;color:#475569;line-height:1.45;}
.sub-feats i{width:18px;height:18px;flex:0 0 auto;margin-top:.06rem;border-radius:50%;display:inline-flex;align-items:center;justify-content:center;font-size:.5rem;}
.sub-feat-ok i{background:#dcfce7;color:#15803d;}
.sub-feat-plus i{background:#f0fdfa;color:#0d9488;}
.sub-actions{display:flex;flex-direction:column;gap:.55rem;}
.sub-btn{display:inline-flex;align-items:center;justify-content:center;gap:.5rem;width:100%;padding:.82rem 1rem;border-radius:13px;font-weight:700;font-size:.86rem;text-decoration:none;transition:all .2s;font-family:inherit;border:1.5px solid transparent;}
.sub-btn-solid{background:linear-gradient(135deg,#0d9488,#0b6b5c);color:#fff;box-shadow:0 12px 26px -10px rgba(13,148,136,.55);}
.sub-btn-solid:hover{transform:translateY(-2px);color:#fff;box-shadow:0 16px 30px -10px rgba(13,148,136,.6);}
.sub-btn-ghost{background:#fff;color:#0d9488;border-color:#0d9488;}
.sub-btn-ghost:hover{background:#f0fdfa;transform:translateY(-2px);}
.sub-btn-six{background:#f0fdfa;color:#0f766e;border-color:#99f6e4;}
.sub-btn-six:hover{background:#ccfbf1;}
/* ===== Trust line ===== */
.sub-note-line{display:grid;grid-template-columns:repeat(3,1fr);gap:1rem;margin-top:2.8rem;padding-top:2rem;border-top:1px solid #e6edec;}
.sub-note-item{display:flex;align-items:flex-start;gap:.7rem;background:#fff;border:1px solid #eef2f6;border-radius:14px;padding:1rem 1.1rem;}
.sub-note-item i{width:36px;height:36px;flex:0 0 auto;border-radius:10px;background:#f0fdfa;color:#0d9488;display:inline-flex;align-items:center;justify-content:center;font-size:.9rem;}
.sub-note-item strong{display:block;font-size:.78rem;font-weight:700;color:#0f172a;}
.sub-note-item span{font-size:.68rem;color:#64748b;line-height:1.45;display:block;margin-top:.1rem;}
.sub-empty{text-align:center;padding:3.5rem 1rem;border:1.5px dashed #d7e2e0;border-radius:18px;background:#fff;}
.sub-empty-ic{width:74px;height:74px;margin:0 auto 1rem;border-radius:22px;background:#f0fdfa;color:#0d9488;font-size:1.7rem;display:flex;align-items:center;justify-content:center;}
.sub-empty h3{font-size:1.1rem;font-weight:700;color:#0f172a;margin:0 0 .4rem;}
.sub-empty p{font-size:.84rem;color:#64748b;margin:0;}
/* ===== Responsive ===== */
@media (max-width:900px){.sub-grid{grid-template-columns:1fr 1fr;}}
@media (max-width:640px){
  .sub-hero{padding:2.6rem 0 3.2rem;}
  .sub-grid{grid-template-columns:1fr;}
  .sub-note-line{grid-template-columns:1fr;}
  .sub-card-head{min-height:0;}
}
</style>
