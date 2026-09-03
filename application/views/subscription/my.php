<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Riwayat langganan pengguna (subscription/my). Wajib login.
 * Variabel: $subscriptions (name, access_scope, started_at, expires_at, status).
 */
function my_status_meta($status) {
    if ($status === 'active')  return array('cls' => 'my-st-active',  'ic' => 'fa-circle-check', 'label' => t('Aktif', 'Active'));
    if ($status === 'expired') return array('cls' => 'my-st-expired', 'ic' => 'fa-clock-rotate-left', 'label' => t('Habis', 'Expired'));
    return array('cls' => 'my-st-cancel', 'ic' => 'fa-circle-xmark', 'label' => t('Dibatalkan', 'Cancelled'));
}
$my_active_count = 0;
foreach ($subscriptions as $s) { if ($s->status === 'active') $my_active_count++; }
?>

<div class="my-wrap">
    <div class="container my-in">
        <div class="my-head">
            <div>
                <span class="my-kicker"><span class="my-kicker-dot"></span><?php echo t('Akun Saya', 'My Account'); ?></span>
                <h1><?php echo t('Langganan Saya', 'My Subscriptions'); ?></h1>
                <p><?php echo t('Pantau status dan masa aktif paket langganan Anda.', 'Track the status and active period of your subscription plans.'); ?></p>
            </div>
            <a href="<?php echo base_url('subscription'); ?>" class="my-btn-new"><i class="fas fa-plus"></i> <?php echo t('Paket Baru', 'New Plan'); ?></a>
        </div>

        <?php if (!empty($subscriptions)): ?>
        <div class="my-stats">
            <div class="my-stat"><span class="my-stat-ic my-stat-ic-a"><i class="fas fa-layer-group"></i></span><div><strong><?php echo count($subscriptions); ?></strong><span><?php echo t('Total Riwayat', 'Total History'); ?></span></div></div>
            <div class="my-stat"><span class="my-stat-ic my-stat-ic-b"><i class="fas fa-circle-check"></i></span><div><strong><?php echo $my_active_count; ?></strong><span><?php echo t('Sedang Aktif', 'Currently Active'); ?></span></div></div>
        </div>
        <?php endif; ?>

        <div class="my-card">
            <?php if (empty($subscriptions)): ?>
                <div class="my-empty">
                    <div class="my-empty-ic"><i class="fas fa-layer-group"></i></div>
                    <h3><?php echo t('Belum Ada Riwayat Langganan', 'No Subscription History Yet'); ?></h3>
                    <p><?php echo t('Pilih paket yang cocok dan mulai akses semua materi favoritmu.', 'Pick a plan that fits and start accessing all your favorite materials.'); ?></p>
                    <a href="<?php echo base_url('subscription'); ?>" class="my-btn-cta"><?php echo t('Pilih Paket Langganan', 'Choose a Plan'); ?></a>
                </div>
            <?php else: ?>
                <div class="my-list">
                    <?php foreach ($subscriptions as $sub):
                        $meta = my_status_meta($sub->status);
                        $started = strtotime($sub->started_at);
                        $expires = $sub->expires_at ? strtotime($sub->expires_at) : null;
                        $days_left = $expires ? ceil(($expires - time()) / 86400) : null;
                    ?>
                    <div class="my-row <?php echo $meta['cls']; ?>">
                        <div class="my-row-ic"><i class="fas <?php echo $sub->access_scope === 'all' ? 'fa-infinity' : ($sub->access_scope === 'category' ? 'fa-layer-group' : 'fa-book-open'); ?>"></i></div>
                        <div class="my-row-main">
                            <div class="my-row-top">
                                <strong><?php echo htmlspecialchars($sub->name); ?></strong>
                                <span class="my-status"><i class="fas <?php echo $meta['ic']; ?>"></i><?php echo $meta['label']; ?></span>
                            </div>
                            <span class="my-scope-lbl">
                                <?php
                                if ($sub->access_scope === 'all') echo t('Semua Konten', 'All Content');
                                elseif ($sub->access_scope === 'category') echo t('Per Kategori', 'By Category');
                                else echo t('Per Kursus', 'By Course');
                                ?>
                            </span>
                            <div class="my-row-dates">
                                <span><i class="far fa-calendar-check"></i> <?php echo t('Mulai', 'Started'); ?>: <?php echo date('d M Y', $started); ?></span>
                                <span><i class="far fa-calendar-xmark"></i> <?php echo t('Berakhir', 'Expires'); ?>: <?php echo $expires ? date('d M Y', $expires) : '—'; ?></span>
                                <?php if ($sub->status === 'active' && $days_left !== null): ?>
                                    <span class="my-days-left <?php echo $days_left <= 5 ? 'my-days-warn' : ''; ?>"><i class="fas fa-hourglass-half"></i> <?php echo max(0, $days_left); ?> <?php echo t('hari lagi', 'days left'); ?></span>
                                <?php endif; ?>
                            </div>
                        </div>
                        <?php if ($sub->status === 'expired'): ?>
                            <a href="<?php echo base_url('subscription'); ?>" class="my-renew"><i class="fas fa-rotate"></i> <?php echo t('Perpanjang', 'Renew'); ?></a>
                        <?php endif; ?>
                    </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>

        <div class="my-faq">
            <div class="my-faq-ic"><i class="fas fa-circle-question"></i></div>
            <div>
                <strong><?php echo t('Punya Pertanyaan?', 'Have Questions?'); ?></strong>
                <p><?php echo t('Akses materi berlaku selama masa langganan aktif. Setelah habis, akses ditutup kecuali diperpanjang.', 'Access to materials is valid during the active subscription period. Once expired, access is revoked unless renewed.'); ?></p>
                <a href="<?php echo base_url('subscription'); ?>"><?php echo t('Lihat Semua Paket', 'View All Plans'); ?> <i class="fas fa-arrow-right"></i></a>
            </div>
        </div>
    </div>
</div>

<style>
.my-wrap{background:#f4f7f6;padding:2.4rem 0 4rem;min-height:60vh;}
.my-in{max-width:920px;}
.my-head{display:flex;align-items:flex-start;justify-content:space-between;gap:1rem;flex-wrap:wrap;margin-bottom:1.6rem;}
.my-kicker{display:inline-flex;align-items:center;gap:.45rem;font-size:.64rem;font-weight:800;letter-spacing:.12em;text-transform:uppercase;color:#0d9488;margin-bottom:.5rem;}
.my-kicker-dot{width:7px;height:7px;border-radius:50%;background:#0d9488;box-shadow:0 0 0 4px rgba(13,148,136,.15);}
.my-head h1{font-size:1.55rem;font-weight:800;letter-spacing:-.03em;color:#0f172a;margin:0 0 .3rem;}
.my-head p{font-size:.84rem;color:#64748b;margin:0;max-width:440px;}
.my-btn-new{display:inline-flex;align-items:center;gap:.5rem;background:linear-gradient(135deg,#0d9488,#0b6b5c);color:#fff;padding:.7rem 1.1rem;border-radius:12px;font-weight:700;font-size:.82rem;text-decoration:none;box-shadow:0 10px 22px -10px rgba(13,148,136,.55);transition:transform .18s;flex-shrink:0;}
.my-btn-new:hover{transform:translateY(-2px);color:#fff;}
.my-stats{display:grid;grid-template-columns:repeat(2,1fr);gap:.9rem;margin-bottom:1.4rem;}
.my-stat{display:flex;align-items:center;gap:.8rem;background:#fff;border:1px solid #e6edec;border-radius:14px;padding:1rem 1.1rem;}
.my-stat-ic{width:42px;height:42px;flex:0 0 auto;border-radius:12px;display:inline-flex;align-items:center;justify-content:center;font-size:1rem;}
.my-stat-ic-a{background:#f0fdfa;color:#0d9488;}
.my-stat-ic-b{background:#f0fdf4;color:#15803d;}
.my-stat strong{display:block;font-size:1.3rem;font-weight:800;color:#0f172a;line-height:1;}
.my-stat span{font-size:.68rem;color:#94a3b8;}
.my-card{background:#fff;border:1px solid #e6edec;border-radius:18px;padding:.6rem;box-shadow:0 4px 16px rgba(15,23,42,.03);margin-bottom:1.4rem;}
.my-list{display:flex;flex-direction:column;gap:.55rem;}
.my-row{display:flex;align-items:flex-start;gap:.9rem;padding:1.05rem 1rem;border-radius:14px;border:1px solid #f1f5f9;transition:background .15s;}
.my-row:hover{background:#fafcfc;}
.my-row-ic{width:42px;height:42px;flex:0 0 auto;border-radius:12px;background:#f0fdfa;color:#0d9488;display:inline-flex;align-items:center;justify-content:center;font-size:1rem;}
.my-st-expired .my-row-ic{background:#f1f5f9;color:#94a3b8;}
.my-st-cancel .my-row-ic{background:#fef2f2;color:#dc2626;}
.my-row-main{flex:1;min-width:0;}
.my-row-top{display:flex;align-items:center;justify-content:space-between;gap:.6rem;flex-wrap:wrap;margin-bottom:.2rem;}
.my-row-top strong{font-size:.92rem;font-weight:700;color:#0f172a;}
.my-status{display:inline-flex;align-items:center;gap:.35rem;font-size:.66rem;font-weight:700;padding:.28rem .65rem;border-radius:99px;}
.my-st-active .my-status{background:#dcfce7;color:#15803d;}
.my-st-expired .my-status{background:#f1f5f9;color:#64748b;}
.my-st-cancel .my-status{background:#fef2f2;color:#dc2626;}
.my-scope-lbl{display:inline-block;font-size:.68rem;color:#0d9488;background:#f0fdfa;padding:.15rem .55rem;border-radius:99px;margin-bottom:.55rem;font-weight:600;}
.my-row-dates{display:flex;flex-wrap:wrap;gap:.9rem;font-size:.7rem;color:#64748b;}
.my-row-dates i{margin-right:.3rem;color:#94a3b8;}
.my-days-left{color:#0d9488;font-weight:700;}
.my-days-warn{color:#dc2626;}
.my-renew{flex-shrink:0;align-self:center;display:inline-flex;align-items:center;gap:.4rem;font-size:.74rem;font-weight:700;color:#0d9488;background:#f0fdfa;border:1px solid #99f6e4;padding:.5rem .9rem;border-radius:10px;text-decoration:none;transition:all .18s;}
.my-renew:hover{background:#0d9488;color:#fff;}
.my-empty{text-align:center;padding:3.2rem 1rem;}
.my-empty-ic{width:74px;height:74px;margin:0 auto 1rem;border-radius:22px;background:#f0fdfa;color:#0d9488;font-size:1.7rem;display:flex;align-items:center;justify-content:center;}
.my-empty h3{font-size:1.05rem;font-weight:700;color:#0f172a;margin:0 0 .4rem;}
.my-empty p{font-size:.82rem;color:#64748b;margin:0 0 1.2rem;}
.my-btn-cta{display:inline-flex;align-items:center;gap:.5rem;background:linear-gradient(135deg,#0d9488,#0b6b5c);color:#fff;padding:.75rem 1.3rem;border-radius:12px;font-weight:700;font-size:.84rem;text-decoration:none;box-shadow:0 10px 22px -10px rgba(13,148,136,.55);}
.my-faq{display:flex;gap:.85rem;align-items:flex-start;background:#fff;border:1px solid #e6edec;border-radius:16px;padding:1.15rem 1.25rem;}
.my-faq-ic{width:40px;height:40px;flex:0 0 auto;border-radius:11px;background:#fffbeb;color:#f59e0b;display:inline-flex;align-items:center;justify-content:center;font-size:1rem;}
.my-faq strong{display:block;font-size:.84rem;color:#0f172a;margin-bottom:.25rem;}
.my-faq p{font-size:.74rem;line-height:1.55;color:#64748b;margin:0 0 .5rem;}
.my-faq a{font-size:.76rem;font-weight:700;color:#0d9488;text-decoration:none;display:inline-flex;align-items:center;gap:.35rem;}
.my-faq a:hover{text-decoration:underline;}
@media (max-width:640px){
  .my-wrap{padding:1.6rem 0 3rem;}
  .my-head{flex-direction:column;}
  .my-btn-new{align-self:stretch;justify-content:center;}
  .my-stats{grid-template-columns:1fr;}
  .my-row{flex-wrap:wrap;}
  .my-renew{width:100%;justify-content:center;}
}
</style>
