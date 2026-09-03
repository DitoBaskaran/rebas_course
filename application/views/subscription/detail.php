<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Detail paket + pilih durasi (subscription/detail). Wajib login.
 * Variabel: $package (dengan six_month_option), $items, $item_details.
 */
$six = $package->six_month_option ?? null;
$d6  = (int)$package->duration_days * 6;
$has_item_detail = !empty($item_details);
?>
<div class="sdp-wrap">
    <div class="container sdp-in">
        <!-- Breadcrumb / back -->
        <a href="<?php echo base_url('subscription'); ?>" class="sdp-back"><i class="fas fa-arrow-left"></i> <?php echo t('Kembali ke Paket', 'Back to Packages'); ?></a>

        <div class="sdp-grid">
            <!-- ===== Kiri: info paket ===== -->
            <div class="sdp-main">
                <div class="sdp-card">
                    <div class="sdp-scope"><i class="fas <?php echo $package->access_scope === 'all' ? 'fa-infinity' : ($package->access_scope === 'category' ? 'fa-layer-group' : 'fa-book-open'); ?>"></i>
                        <?php
                        if ($package->access_scope === 'all') echo t('Akses SEMUA Konten', 'ALL Content Access');
                        elseif ($package->access_scope === 'category') echo t('Akses Per Kategori', 'Category Access');
                        else echo t('Akses Per Kursus', 'Course Access');
                        ?>
                    </div>
                    <h1><?php echo htmlspecialchars($package->name); ?></h1>
                    <p class="sdp-desc"><?php echo htmlspecialchars($package->description); ?></p>

                    <div class="sdp-price-row">
                        <div class="sdp-price">
                            <span class="sdp-cur">Rp</span>
                            <strong><?php echo number_format($package->price, 0, ',', '.'); ?></strong>
                            <span class="sdp-per">/ <?php echo (int)$package->duration_days; ?> <?php echo t('hari', 'days'); ?></span>
                        </div>
                        <?php if ($six): ?>
                            <div class="sdp-6mo-tag"><i class="fas fa-tag"></i> <?php echo t('6 bulan lebih hemat', '6 months saves more'); ?></div>
                        <?php endif; ?>
                    </div>

                    <?php if ($has_item_detail): ?>
                    <div class="sdp-items">
                        <h2><span class="sdp-h2-ic"><i class="fas fa-list-check"></i></span><?php echo t('Termasuk dalam Paket Ini', 'Included in This Plan'); ?></h2>
                        <div class="sdp-item-grid">
                            <?php foreach ($item_details as $det): ?>
                                <div class="sdp-item">
                                    <span class="sdp-item-ic"><i class="fas <?php echo $det['type'] === 'category' ? 'fa-layer-group' : 'fa-play-circle'; ?>"></i></span>
                                    <div>
                                        <strong><?php echo htmlspecialchars($det['name']); ?></strong>
                                        <small><?php echo $det['type'] === 'category' ? t('Kategori', 'Category') : t('Kursus', 'Course'); ?></small>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- ===== Kanan: pilih durasi & bayar ===== -->
            <aside class="sdp-side">
                <div class="sdp-ticket">
                    <h2><?php echo t('Pilih Durasi', 'Choose Duration'); ?></h2>
                    <?php echo form_open('subscription/buy/' . $package->slug, array('class' => 'sdp-form')); ?>
                        <label class="sdp-dur <?php echo $six ? '' : 'sdp-dur-only'; ?>">
                            <input type="radio" name="duration" id="dur_1" value="1" checked>
                            <span class="sdp-dur-body">
                                <span class="sdp-dur-name"><?php echo t('Bulanan', 'Monthly'); ?></span>
                                <span class="sdp-dur-desc"><?php echo (int)$package->duration_days; ?> <?php echo t('hari akses', 'days of access'); ?></span>
                            </span>
                            <span class="sdp-dur-price">Rp <?php echo number_format($package->price, 0, ',', '.'); ?></span>
                            <span class="sdp-radio"></span>
                        </label>

                        <?php if ($six): ?>
                        <label class="sdp-dur sdp-dur-best">
                            <input type="radio" name="duration" id="dur_6" value="6">
                            <span class="sdp-dur-badge"><i class="fas fa-fire"></i> <?php echo t('TERBAIK', 'BEST'); ?></span>
                            <span class="sdp-dur-body">
                                <span class="sdp-dur-name"><?php echo t('Paket 6 Bulan', '6-Month Plan'); ?></span>
                                <span class="sdp-dur-desc"><?php echo $d6; ?> <?php echo t('hari — hemat ', 'days — save '); ?><?php echo $six['discount_pct']; ?>%</span>
                            </span>
                            <span class="sdp-dur-price"><strong>Rp <?php echo number_format($six['discounted'], 0, ',', '.'); ?></strong><small><?php echo t('hemat Rp ', 'save Rp ') . number_format($six['savings'], 0, ',', '.'); ?></small></span>
                            <span class="sdp-radio"></span>
                        </label>
                        <?php endif; ?>

                        <button type="submit" class="sdp-submit"><i class="fas fa-lock"></i> <?php echo t('Berlangganan Sekarang', 'Subscribe Now'); ?></button>
                        <p class="sdp-secure"><i class="fas fa-shield-halved"></i> <?php echo t('Pembayaran aman — QRIS, VA, e-wallet, transfer', 'Secure payment — QRIS, VA, e-wallet, bank transfer'); ?></p>
                    <?php echo form_close(); ?>
                </div>

                <div class="sdp-help">
                    <div class="sdp-help-ic"><i class="fas fa-circle-question"></i></div>
                    <div>
                        <strong><?php echo t('Butuh Bantuan?', 'Need Help?'); ?></strong>
                        <p><?php echo t('Setelah pembayaran dikonfirmasi, langganan aktif otomatis. Hubungi admin jika ada kendala.', 'Once payment is confirmed, your subscription activates automatically. Contact admin if you face any issue.'); ?></p>
                    </div>
                </div>
            </aside>
        </div>
    </div>
</div>

<style>
.sdp-wrap{background:#f4f7f6;padding:2.4rem 0 4rem;}
.sdp-in{max-width:1120px;}
.sdp-back{display:inline-flex;align-items:center;gap:.5rem;font-size:.8rem;font-weight:600;color:#0d9488;text-decoration:none;margin-bottom:1.4rem;}
.sdp-back:hover{text-decoration:underline;}
.sdp-grid{display:grid;grid-template-columns:minmax(0,1fr) 400px;gap:1.6rem;align-items:start;}
/* ===== Kiri ===== */
.sdp-card{background:#fff;border:1px solid #e6edec;border-radius:18px;padding:1.8rem 1.8rem 1.5rem;box-shadow:0 4px 16px rgba(15,23,42,.04);}
.sdp-scope{display:inline-flex;align-items:center;gap:.4rem;font-size:.62rem;font-weight:800;text-transform:uppercase;letter-spacing:.05em;color:#0d9488;background:#f0fdfa;border:1px solid #ccfbf1;padding:.35rem .7rem;border-radius:99px;}
.sdp-card h1{font-size:1.6rem;font-weight:800;letter-spacing:-.03em;color:#0f172a;margin:.9rem 0 .35rem;}
.sdp-desc{font-size:.85rem;line-height:1.6;color:#64748b;margin:0 0 1.2rem;}
.sdp-price-row{display:flex;align-items:center;justify-content:space-between;gap:1rem;flex-wrap:wrap;padding-bottom:1.2rem;border-bottom:1px solid #f1f5f9;margin-bottom:1.4rem;}
.sdp-price{display:flex;align-items:baseline;gap:.35rem;}
.sdp-cur{font-size:1rem;font-weight:800;color:#0f172a;}
.sdp-price strong{font-size:2.2rem;font-weight:800;letter-spacing:-.04em;color:#0f172a;line-height:1;}
.sdp-per{font-size:.76rem;color:#94a3b8;font-weight:500;}
.sdp-6mo-tag{display:inline-flex;align-items:center;gap:.4rem;font-size:.66rem;font-weight:700;color:#b45309;background:#fef3c7;border:1px solid #fde68a;padding:.4rem .75rem;border-radius:99px;}
.sdp-items h2{display:flex;align-items:center;gap:.6rem;font-size:.98rem;font-weight:800;color:#0f172a;margin:0 0 1rem;}
.sdp-h2-ic{width:30px;height:30px;flex:0 0 auto;border-radius:9px;background:#f0fdfa;color:#0d9488;display:inline-flex;align-items:center;justify-content:center;font-size:.72rem;}
.sdp-item-grid{display:grid;grid-template-columns:1fr 1fr;gap:.65rem;}
.sdp-item{display:flex;align-items:center;gap:.65rem;background:#f8fafc;border:1px solid #eef2f6;border-radius:12px;padding:.7rem .8rem;}
.sdp-item-ic{width:34px;height:34px;flex:0 0 auto;border-radius:9px;background:#fff;border:1px solid #e2e8f0;color:#0d9488;display:inline-flex;align-items:center;justify-content:center;font-size:.75rem;}
.sdp-item strong{display:block;font-size:.74rem;font-weight:700;color:#0f172a;line-height:1.3;}
.sdp-item small{font-size:.6rem;color:#94a3b8;}
/* ===== Kanan ===== */
.sdp-side{position:sticky;top:76px;display:flex;flex-direction:column;gap:1rem;}
.sdp-ticket{background:#fff;border:1px solid #e6edec;border-radius:18px;padding:1.5rem;box-shadow:0 18px 40px -18px rgba(6,48,43,.18);}
.sdp-ticket h2{font-size:1rem;font-weight:800;color:#0f172a;margin:0 0 1rem;}
.sdp-form{display:flex;flex-direction:column;gap:.8rem;}
.sdp-dur{position:relative;display:flex;align-items:center;gap:.8rem;border:1.5px solid #e2e8f0;border-radius:14px;padding:.85rem .95rem;cursor:pointer;transition:all .18s;background:#fff;}
.sdp-dur:hover{border-color:#99f6e4;}
.sdp-dur input{position:absolute;opacity:0;pointer-events:none;}
.sdp-dur:has(input:checked){border-color:#0d9488;background:#f0fdfa;box-shadow:0 0 0 4px rgba(13,148,136,.1);}
.sdp-dur-best{flex-wrap:wrap;}
.sdp-dur-badge{display:inline-flex;align-items:center;gap:.35rem;font-size:.6rem;font-weight:800;letter-spacing:.05em;color:#fff;background:linear-gradient(135deg,#f59e0b,#ea580c);padding:.28rem .65rem;border-radius:99px;margin-left:.2rem;}
.sdp-dur-body{flex:1;min-width:0;}
.sdp-dur-name{display:block;font-size:.84rem;font-weight:700;color:#0f172a;}
.sdp-dur-desc{display:block;font-size:.68rem;color:#64748b;margin-top:.1rem;}
.sdp-dur-price{font-size:.88rem;font-weight:700;color:#0f172a;text-align:right;}
.sdp-dur-price strong{display:block;color:#0d9488;}
.sdp-dur-price small{display:block;font-size:.62rem;color:#b45309;font-weight:600;}
.sdp-radio{width:18px;height:18px;flex:0 0 auto;border-radius:50%;border:2px solid #cbd5e1;position:relative;transition:all .18s;}
.sdp-dur:has(input:checked) .sdp-radio{border-color:#0d9488;}
.sdp-dur:has(input:checked) .sdp-radio::after{content:'';position:absolute;inset:2.5px;border-radius:50%;background:#0d9488;}
.sdp-submit{display:inline-flex;align-items:center;justify-content:center;gap:.5rem;width:100%;padding:.95rem 1rem;border:none;border-radius:13px;background:linear-gradient(135deg,#0d9488,#0b6b5c);color:#fff;font-weight:800;font-size:.9rem;cursor:pointer;font-family:inherit;box-shadow:0 12px 26px -10px rgba(13,148,136,.55);transition:all .2s;margin-top:.3rem;}
.sdp-submit:hover{transform:translateY(-2px);box-shadow:0 16px 30px -10px rgba(13,148,136,.6);}
.sdp-secure{display:flex;align-items:center;justify-content:center;gap:.4rem;font-size:.64rem;color:#94a3b8;margin:.2rem 0 0;}
.sdp-help{display:flex;gap:.8rem;align-items:flex-start;background:#fff;border:1px solid #e6edec;border-radius:16px;padding:1.1rem 1.2rem;}
.sdp-help-ic{width:38px;height:38px;flex:0 0 auto;border-radius:11px;background:#fffbeb;color:#f59e0b;display:inline-flex;align-items:center;justify-content:center;font-size:.95rem;}
.sdp-help strong{display:block;font-size:.8rem;color:#0f172a;margin-bottom:.2rem;}
.sdp-help p{font-size:.7rem;line-height:1.55;color:#64748b;margin:0;}
/* ===== Responsive ===== */
@media (max-width:1023px){
  .sdp-grid{grid-template-columns:1fr;}
  .sdp-side{position:static;}
}
@media (max-width:560px){
  .sdp-wrap{padding:1.6rem 0 3rem;}
  .sdp-card{padding:1.3rem 1.1rem 1.2rem;}
  .sdp-item-grid{grid-template-columns:1fr;}
  .sdp-price strong{font-size:1.9rem;}
  .sdp-dur{flex-wrap:wrap;}
}
</style>
