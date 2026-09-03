<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Halaman verifikasi sertifikat publik (/certificate/verify/{code}).
 * Variabel: $error (bool), $cert (objek bila valid).
 */
$cf_code = !$error && !empty($cert) ? $cert->certificate_code : '';
$cf_code_disp = $cf_code ? $cf_code : t('Masukkan kode sertifikat', 'Enter the certificate code');
?>
<div class="cv-wrap">
    <div class="cv-inner">
        <!-- ===== Header + Pencarian ===== -->
        <div class="cv-head">
            <span class="cv-kicker"><span class="cv-kicker-dot"></span><?php echo t('Keaslian Sertifikat', 'Certificate Authenticity'); ?></span>
            <h1><?php echo t('Verifikasi Sertifikat', 'Certificate Verification'); ?></h1>
            <p><?php echo t('Periksa keaslian sertifikat BISATUNTAS secara instan.', 'Instantly check the authenticity of a BISATUNTAS certificate.'); ?></p>
        </div>

        <form class="cv-search" id="cvSearchForm" onsubmit="return cvSearch(event)">
            <div class="cv-search-box">
                <div class="cv-search-field">
                    <i class="fas fa-shield-halved"></i>
                    <input type="text" id="cvCode" value="<?php echo htmlspecialchars($cf_code); ?>" placeholder="<?php echo t('Contoh: CERT-884AF108D6', 'Example: CERT-884AF108D6'); ?>" autocomplete="off" spellcheck="false">
                </div>
                <button type="submit" class="cv-btn-search"><i class="fas fa-magnifying-glass"></i> <?php echo t('Verifikasi', 'Verify'); ?></button>
            </div>
            <p class="cv-hint"><i class="fas fa-circle-info"></i> <?php echo t('Masukkan kode sertifikat yang tertera pada dokumen Anda.', 'Enter the certificate code printed on your document.'); ?></p>
        </form>

        <!-- ===== State: Tidak ditemukan ===== -->
        <?php if ($error): ?>
        <div class="cv-result cv-invalid">
            <div class="cv-stamp cv-stamp-invalid"><i class="fas fa-circle-xmark"></i></div>
            <h2><?php echo t('Sertifikat Tidak Ditemukan', 'Certificate Not Found'); ?></h2>
            <p><?php echo t('Kode yang Anda masukkan tidak cocok dengan sertifikat mana pun di database kami. Periksa kembali kode Anda — pastikan tidak ada huruf yang tertukar (mis. 0/O, 1/I).', 'The code you entered does not match any certificate in our database. Please re-check — make sure no characters are swapped (e.g. 0/O, 1/I).'); ?></p>
            <div class="cv-invalid-tips">
                <span><i class="fas fa-circle-check"></i> <?php echo t('Gunakan kode dari dokumen asli', 'Use the code from the original document'); ?></span>
                <span><i class="fas fa-circle-check"></i> <?php echo t('Hubungi kami jika kode dicabut/diganti', 'Contact us if the code was revoked or replaced'); ?></span>
            </div>
            <a href="<?php echo base_url('pages/contact'); ?>" class="cv-btn-ghost"><i class="fas fa-headset"></i> <?php echo t('Hubungi Bantuan', 'Contact Support'); ?></a>
        </div>
        <?php endif; ?>

        <!-- ===== State: Valid ===== -->
        <?php if (!$error): ?>
        <div class="cv-result cv-valid">
            <!-- Ribbon atas -->
            <div class="cv-ribbon">
                <div class="cv-ribbon-in">
                    <div class="cv-medallion">
                        <div class="cv-medallion-ring">
                            <i class="fas fa-award"></i>
                        </div>
                    </div>
                    <span class="cv-ribbon-badge"><i class="fas fa-circle-check"></i> <?php echo t('TERVERIFIKASI', 'VERIFIED'); ?></span>
                </div>
            </div>

            <div class="cv-cert-head">
                <div class="cv-cert-title">
                    <span class="cv-small-lbl"><?php echo t('SERTIFIKAT PENYELESAIAN', 'CERTIFICATE OF COMPLETION'); ?></span>
                    <h2><?php echo t('Diberikan kepada', 'This certifies that'); ?></h2>
                    <div class="cv-name"><?php echo htmlspecialchars($cert->user_name); ?></div>
                    <p class="cv-over"><?php echo t('atas keberhasilan menyelesaikan program', 'for successfully completing the program'); ?></p>
                    <div class="cv-course">
                        <i class="fas fa-book-open"></i>
                        <span><?php echo htmlspecialchars($cert->title); ?></span>
                    </div>
                </div>
            </div>

            <div class="cv-seal">
                <div class="cv-seal-ring">
                    <div class="cv-seal-inner">
                        <i class="fas fa-shield-halved"></i>
                        <strong><?php echo t('ASLI', 'GENUINE'); ?></strong>
                    </div>
                </div>
            </div>

            <div class="cv-meta">
                <div class="cv-meta-item">
                    <span class="cv-meta-ic"><i class="fas fa-barcode"></i></span>
                    <div>
                        <span><?php echo t('Kode Sertifikat', 'Certificate Code'); ?></span>
                        <strong class="cv-code"><?php echo htmlspecialchars($cf_code); ?></strong>
                    </div>
                </div>
                <div class="cv-meta-div"></div>
                <div class="cv-meta-item">
                    <span class="cv-meta-ic"><i class="far fa-calendar-check"></i></span>
                    <div>
                        <span><?php echo t('Tanggal Terbit', 'Issued Date'); ?></span>
                        <strong><?php echo date('d M Y', strtotime($cert->issued_at)); ?></strong>
                    </div>
                </div>
                <div class="cv-meta-div"></div>
                <div class="cv-meta-item">
                    <span class="cv-meta-ic"><i class="fas fa-building-columns"></i></span>
                    <div>
                        <span><?php echo t('Lembaga', 'Institution'); ?></span>
                        <strong><?php echo t('BISATUNTAS', 'BISATUNTAS'); ?></strong>
                    </div>
                </div>
            </div>

            <div class="cv-footer-line">
                <div class="cv-footer-brand">
                    <img src="<?php echo base_url('assets/img/bisatuntas-logo-v2.png'); ?>" alt="BISATUNTAS" style="height:22px;width:auto;">
                    <span><?php echo t('Belajar Tuntas, Sukses Pasti', 'Learn Completely, Succeed Surely'); ?></span>
                </div>
                <div class="cv-footer-trust">
                    <span class="cv-trust-ic"><i class="fas fa-fingerprint"></i></span>
                    <span><?php echo t('Dokumen ini terdaftar di sistem resmi BISATUNTAS.', 'This document is registered in the official BISATUNTAS system.'); ?></span>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <!-- ===== Footer aksi ===== -->
        <div class="cv-actions">
            <span><?php echo t('Mencari sertifikat lain?', 'Looking for another certificate?'); ?></span>
            <button type="button" class="cv-link-btn" onclick="document.getElementById('cvCode').focus();document.getElementById('cvCode').select();">
                <i class="fas fa-arrow-up"></i> <?php echo t('Ganti kode di atas', 'Change the code above'); ?>
            </button>
        </div>
    </div>
</div>

<style>
.cv-wrap{background:radial-gradient(circle at 50% -20%,rgba(13,148,136,.08),transparent 55%),#f4f7f6;padding:3.2rem 1rem 4.2rem;}
.cv-inner{max-width:680px;margin:0 auto;}
/* ===== Head ===== */
.cv-head{text-align:center;margin-bottom:1.7rem;}
.cv-kicker{display:inline-flex;align-items:center;gap:.45rem;font-size:.64rem;font-weight:800;letter-spacing:.13em;text-transform:uppercase;color:#0d9488;margin-bottom:.65rem;}
.cv-kicker-dot{width:7px;height:7px;border-radius:50%;background:#0d9488;box-shadow:0 0 0 4px rgba(13,148,136,.15);}
.cv-head h1{font-size:clamp(1.5rem,3.6vw,2rem);font-weight:800;letter-spacing:-.03em;color:#0f172a;margin:0 0 .4rem;}
.cv-head p{font-size:.88rem;color:#64748b;margin:0;}
/* ===== Search ===== */
.cv-search{background:#fff;border:1px solid #e6edec;border-radius:18px;padding:1.1rem;box-shadow:0 14px 40px -18px rgba(6,48,43,.18);margin-bottom:1.4rem;}
.cv-search-box{display:flex;align-items:center;gap:.6rem;background:#f8fafc;border:1.5px solid #e2e8f0;border-radius:13px;padding:.35rem;transition:border-color .18s,box-shadow .18s;}
.cv-search-box:focus-within{border-color:#0d9488;box-shadow:0 0 0 4px rgba(13,148,136,.12);background:#fff;}
.cv-search-field{flex:1;min-width:0;display:flex;align-items:center;gap:.6rem;padding-left:.7rem;}
.cv-search-field > i{color:#0d9488;font-size:.9rem;flex-shrink:0;}
.cv-search-field input{flex:1;min-width:0;border:none;background:transparent;outline:none;font-family:ui-monospace,'Cascadia Mono',monospace;font-size:.85rem;font-weight:600;color:#0f172a;padding:.6rem 0;letter-spacing:.02em;width:100%;}
.cv-search-field input::placeholder{color:#a3b1c6;font-family:inherit;font-weight:500;text-transform:none;}
.cv-btn-search{flex-shrink:0;display:inline-flex;align-items:center;gap:.5rem;background:linear-gradient(135deg,#0d9488,#0b6b5c);color:#fff;border:none;border-radius:10px;padding:.72rem 1.15rem;font-weight:700;font-size:.82rem;cursor:pointer;font-family:inherit;transition:filter .18s,transform .18s;}
.cv-btn-search:hover{filter:brightness(1.08);transform:translateY(-1px);}
.cv-hint{display:flex;align-items:center;gap:.4rem;font-size:.7rem;color:#94a3b8;margin:.7rem .3rem 0;}
.cv-hint i{color:#0d9488;}
/* ===== Result card ===== */
.cv-result{position:relative;background:#fff;border-radius:22px;box-shadow:0 24px 60px -24px rgba(6,48,43,.22);overflow:hidden;}
/* Valid */
.cv-valid{border:1px solid #e6edec;}
.cv-ribbon{background:linear-gradient(135deg,#065f46,#0d9488);padding:1.5rem 1rem 1.2rem;display:flex;justify-content:center;}
.cv-ribbon-in{display:flex;flex-direction:column;align-items:center;gap:.65rem;position:relative;width:100%;}
.cv-medallion{flex:0 0 auto;}
.cv-medallion-ring{width:62px;height:62px;border-radius:50%;background:linear-gradient(135deg,#f59e0b,#d97706);border:3px solid #fff;box-shadow:0 8px 22px rgba(217,119,6,.4),0 0 0 6px rgba(245,158,11,.18);display:flex;align-items:center;justify-content:center;color:#fff;font-size:1.45rem;}
.cv-ribbon-badge{display:inline-flex;align-items:center;gap:.5rem;background:rgba(255,255,255,.14);border:1px solid rgba(255,255,255,.3);color:#fff;font-size:.7rem;font-weight:800;letter-spacing:.16em;padding:.45rem 1.35rem;border-radius:99px;white-space:nowrap;}
.cv-ribbon-badge i{color:#fbbf24;}
.cv-cert-head{position:relative;display:flex;flex-direction:column;align-items:center;text-align:center;padding:0.4rem 1.5rem 1.4rem;}.cv-cert-title{padding-top:.4rem;}
.cv-small-lbl{font-size:.62rem;font-weight:800;letter-spacing:.22em;color:#0d9488;}
.cv-cert-title h2{font-size:.82rem;font-weight:600;color:#64748b;margin:.5rem 0 .15rem;}
.cv-name{font-size:clamp(1.5rem,4vw,2rem);font-weight:800;letter-spacing:-.02em;color:#0f172a;line-height:1.25;}
.cv-over{font-size:.76rem;color:#94a3b8;margin:.55rem 0 .85rem;font-style:italic;}
.cv-course{display:inline-flex;align-items:center;gap:.6rem;background:#f0fdfa;border:1px solid #99f6e4;border-radius:12px;padding:.6rem 1.1rem;font-size:.92rem;font-weight:700;color:#0f766e;max-width:100%;}
.cv-course i{color:#0d9488;font-size:1rem !important;line-height:1;}
.cv-seal{position:absolute;top:64px;right:30px;width:92px;height:92px;pointer-events:none;}
.cv-seal-ring{width:100%;height:100%;border-radius:50%;border:2px dashed rgba(245,158,11,.55);display:flex;align-items:center;justify-content:center;padding:4px;background:rgba(255,255,255,.92);}
.cv-seal-inner{width:100%;height:100%;border-radius:50%;background:#fffbeb;border:1.5px solid #f59e0b;display:flex;flex-direction:column;align-items:center;justify-content:center;gap:.12rem;color:#b45309;transform:rotate(-12deg);}
.cv-seal-inner i{font-size:1.05rem;line-height:1;}
.cv-seal-inner strong{font-size:.55rem;letter-spacing:.08em;}
.cv-meta{display:flex;align-items:center;justify-content:center;gap:1.3rem;background:#f8fafc;border-top:1px dashed #e2e8f0;border-bottom:1px dashed #e2e8f0;padding:1rem 1.2rem;flex-wrap:wrap;}
.cv-meta-item{display:flex;align-items:center;gap:.7rem;min-width:150px;}
.cv-meta-ic{width:36px;height:36px;flex:0 0 auto;border-radius:10px;background:#fff;border:1px solid #e2e8f0;color:#0d9488;display:flex !important;align-items:center;justify-content:center;font-size:1rem !important;line-height:1 !important;}
.cv-meta-ic i{font-size:inherit !important;line-height:1 !important;}
.cv-meta-item > div span{display:block;font-size:.6rem;font-weight:700;text-transform:uppercase;letter-spacing:.05em;color:#94a3b8;}
.cv-meta-item strong{display:block;font-size:.82rem;font-weight:700;color:#0f172a;margin-top:.12rem;}
.cv-code{font-family:ui-monospace,monospace;letter-spacing:.03em;color:#0d9488 !important;}
.cv-meta-div{width:1px;height:38px;background:#e2e8f0;}
.cv-footer-line{display:flex;align-items:center;justify-content:space-between;gap:1rem;flex-wrap:wrap;padding:1.1rem 1.5rem;}
.cv-footer-brand{display:flex;align-items:center;gap:.6rem;}
.cv-footer-brand span{font-size:.66rem;color:#94a3b8;font-style:italic;}
.cv-footer-trust{display:flex;align-items:center;gap:.55rem;font-size:.68rem;color:#64748b;font-weight:500;}
.cv-trust-ic{width:28px;height:28px;flex:0 0 auto;border-radius:9px;background:#f0fdfa;color:#0d9488;display:inline-flex;align-items:center;justify-content:center;font-size:.85rem;border:1px solid #99f6e4;}
/* Invalid */
.cv-invalid{padding:2.6rem 1.8rem 2.2rem;text-align:center;border:1px solid #fecaca;}
.cv-stamp{width:84px;height:84px;margin:0 auto 1.2rem;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:2.1rem;color:#fff;}
.cv-stamp-invalid{background:linear-gradient(135deg,#f87171,#dc2626);box-shadow:0 10px 26px rgba(220,38,38,.3);}
.cv-invalid h2{font-size:1.3rem;font-weight:800;color:#0f172a;margin:0 0 .5rem;}
.cv-invalid > p{font-size:.85rem;line-height:1.65;color:#64748b;max-width:440px;margin:0 auto 1.2rem;}
.cv-invalid-tips{display:flex;flex-direction:column;gap:.5rem;max-width:360px;margin:0 auto 1.5rem;background:#fef2f2;border:1px solid #fecaca;border-radius:14px;padding:1rem 1.2rem;}
.cv-invalid-tips span{display:flex;align-items:center;gap:.55rem;font-size:.78rem;color:#7f1d1d;text-align:left;font-weight:500;}
.cv-invalid-tips i{color:#dc2626;font-size:.85rem;flex-shrink:0;}
.cv-btn-ghost{display:inline-flex;align-items:center;gap:.5rem;background:linear-gradient(135deg,#0d9488,#0b6b5c);color:#fff;border:none;border-radius:12px;padding:.75rem 1.35rem;font-weight:700;font-size:.82rem;text-decoration:none;transition:all .18s;box-shadow:0 10px 22px -10px rgba(13,148,136,.5);}
.cv-btn-ghost:hover{transform:translateY(-2px);color:#fff;}
/* ===== Actions ===== */
.cv-actions{display:flex;align-items:center;justify-content:center;gap:.6rem;flex-wrap:wrap;margin-top:1.5rem;}
.cv-actions span{font-size:.8rem;color:#64748b;}
.cv-link-btn{display:inline-flex;align-items:center;gap:.45rem;background:none;border:none;color:#0d9488;font-weight:700;font-size:.8rem;cursor:pointer;font-family:inherit;text-decoration:underline;text-underline-offset:3px;}
.cv-link-btn i{font-size:.72rem;}
.cv-link-btn:hover{color:#0f766e;}
/* ===== Responsive ===== */
@media (max-width:640px){
  .cv-wrap{padding:2.2rem .8rem 3rem;}
  .cv-search-box{flex-direction:column;align-items:stretch;padding:.6rem;}
  .cv-search-field{width:100%;padding:.2rem .5rem;}
  .cv-btn-search{width:100%;justify-content:center;padding:.75rem 1.15rem;}
  .cv-seal{display:none;}
  .cv-meta{gap:.9rem;}
  .cv-meta-div{display:none;}
  .cv-meta-item{flex:1 1 100%;min-width:0;}
  .cv-cert-head{padding:1.9rem 1.1rem 1.2rem;}
  .cv-cert-title{padding-top:.4rem;}
  .cv-footer-line{flex-direction:column;text-align:center;}
}
</style>

<script>
function cvSearch(e) {
    if (e) e.preventDefault();
    var code = (document.getElementById('cvCode').value || '').trim();
    if (!code) {
        document.getElementById('cvCode').focus();
        return false;
    }
    window.location.href = '<?php echo base_url('certificate/verify/'); ?>' + encodeURIComponent(code);
    return false;
}
document.addEventListener('DOMContentLoaded', function () {
    var inp = document.getElementById('cvCode');
    inp.addEventListener('keydown', function (e) {
        if (e.key === 'Enter') cvSearch(e);
    });
    // trim live
    inp.addEventListener('input', function () {
        this.value = this.value.replace(/\s+/g, ' ');
    });

    // auto-scroll ke hasil verifikasi jika ada
    var result = document.querySelector('.cv-result');
    if (result) {
        setTimeout(function () {
            result.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }, 150);
    }
});
</script>
