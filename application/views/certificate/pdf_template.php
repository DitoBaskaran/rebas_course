<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Template PDF Sertifikat BISATUNTAS (A4 landscape, 1 halaman).
 * Data: $user_name, $title, $title_en, $certificate_code, $issued_at.
 * NOTE: dompdf CSS terbatas — hindari flex/grid modern, pakai table/float/absolute.
 * Logo: dipakai PNG resmi dari path absolut FCPATH (dompdf butuh file path, bukan URL remote).
 */
$site_name = function_exists('setting') ? setting('general_site_name', 'BISATUNTAS') : 'BISATUNTAS';
$course_disp = (function_exists('current_lang') && current_lang() === 'en' && !empty($title_en)) ? $title_en : $title;
$verify_url  = function_exists('base_url') ? base_url('certificate/verify/' . rawurlencode($certificate_code)) : '';
$issued_date = date('d F Y', strtotime($issued_at));
// Logo resmi — selalu pakai file lokal (dompdf andal dengan path file, hindari URL remote yang bisa diblokir)
$logo_path   = FCPATH . 'assets/img/bisatuntas-logo-v2.png';
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<style>
  @page { size: A4 landscape; margin: 0; }
  * { margin: 0; padding: 0; box-sizing: border-box; }
  body { width: 1122px; height: 793px; font-family: DejaVu Sans, sans-serif; color: #1e293b; }
  .page {
    width: 1122px; height: 793px; position: relative; overflow: hidden;
    background: #ffffff;
  }
  /* Outer frame */
  .frame-outer { position: absolute; top: 0; left: 0; right: 0; bottom: 0; border: 14px solid #0d3b31; }
  .frame-accent { position: absolute; top: 14px; left: 14px; right: 14px; bottom: 14px; border: 2px solid #c9a227; }
  .frame-inner { position: absolute; top: 26px; left: 26px; right: 26px; bottom: 26px; border: 1px solid #e2e8f0; }

  /* Corner ornaments (gold squares) */
  .corner { position: absolute; width: 26px; height: 26px; background: #c9a227; }
  .c1 { top: 26px; left: 26px; } .c2 { top: 26px; right: 26px; }
  .c3 { bottom: 26px; left: 26px; } .c4 { bottom: 26px; right: 26px; }

  /* Content */
  .content { position: absolute; top: 0; left: 0; right: 0; bottom: 0; padding: 46px 70px 30px; text-align: center; }
  .brand { text-align: center; margin-bottom: 4px; }
  .brand .tagline { font-size: 9px; letter-spacing: 4px; color: #94a3b8; text-transform: uppercase; margin-top: 2px; }

  /* Badge medali — bintang Unicode diposisikan absolute di tengah (dompdf dukung ini andal) */
  .medal-wrap { margin: 14px auto 10px; width: 86px; height: 86px; border: 3px solid #c9a227; border-radius: 50%; text-align: center; background: #fff; position: relative; }
  .medal-circle { width: 80px; height: 80px; margin: 0 auto; border-radius: 50%; background: #0d9488; position: relative; top: 0; }
  .medal-star { position: absolute; top: 50%; left: 50%; margin-top: -16px; margin-left: -16px; width: 32px; text-align: center; color: #ffd700; font-size: 26px; font-weight: normal; font-family: 'DejaVu Sans', sans-serif; line-height: 32px; }
  .title { font-size: 19px; font-weight: 800; letter-spacing: 8px; color: #0d3b31; text-transform: uppercase; }
  .subtitle { font-size: 11px; color: #64748b; margin-top: 3px; letter-spacing: 2px; }

  .line-gold { width: 140px; height: 3px; background: #c9a227; margin: 12px auto 0; }

  .statement { margin-top: 16px; font-size: 13px; color: #475569; }
  .recipient { margin-top: 12px; }
  .recipient .name {
    font-size: 36px; font-weight: 800; color: #0d3b31; letter-spacing: 1px;
    border-bottom: 3px solid #c9a227; display: inline-block; padding: 0 18px 5px;
  }
  .course-label { margin-top: 14px; font-size: 10px; color: #64748b; letter-spacing: 2px; text-transform: uppercase; }
  .course-name { margin-top: 4px; font-size: 19px; font-weight: 700; color: #0d9488; }

  /* Seal stempel cap pengesahan — tepat di atas garis tanda tangan kanan */
  .seal { position: absolute; left: 760px; top: 588px; width: 96px; height: 96px; border: 2px dashed #c9a227; border-radius: 50%; text-align: center; opacity: .9; }
  .seal-in { margin: 12px auto 0; width: 68px; height: 68px; border-radius: 50%; border: 1px solid #c9a227; text-align: center; }
  .seal-in .stext { font-size: 12px; font-weight: 800; color: #0d3b31; letter-spacing: 2px; padding-top: 24px; }

  /* Signature row — tabel 2 kolom (dompdf paling andal dengan table) */
  .sig-row { position: absolute; bottom: 120px; left: 70px; right: 70px; }
  table.sig-table { width: 100%; border-collapse: collapse; }
  table.sig-table td { width: 50%; text-align: center; vertical-align: bottom; }
  .sig-line { width: 220px; height: 1px; background: #1e293b; margin: 0 auto 5px; }
  .sig-name { font-size: 12px; font-weight: 700; color: #1e293b; }
  .sig-role { font-size: 9px; color: #64748b; margin-top: 2px; }

  /* Ornamen pengisi tengah: kutipan motivasi + garis */
  .mid-quote { position: absolute; left: 130px; right: 130px; top: 505px; text-align: center; }
  .mid-quote .q-line { width: 60px; height: 1px; background: #c9a227; margin: 0 auto 10px; }
  .mid-quote .q-text { font-size: 12px; font-style: italic; color: #94a3b8; letter-spacing: .5px; }

  /* Footer meta */
  .meta { position: absolute; bottom: 26px; left: 0; right: 0; text-align: center; }
  .meta .code { font-size: 10px; color: #475569; font-weight: 600; }
  .meta .verify { font-size: 9px; color: #0d9488; margin-top: 2px; }
</style>
</head>
<body>
<div class="page">
  <div class="frame-outer"></div>
  <div class="frame-accent"></div>
  <div class="frame-inner"></div>
  <div class="corner c1"></div><div class="corner c2"></div><div class="corner c3"></div><div class="corner c4"></div>

  <div class="seal">
    <div class="seal-in"><div class="stext">ASLI</div></div>
  </div>

  <div class="content">
    <!-- Brand -->
    <div class="brand">
      <img src="<?php echo $logo_path; ?>" alt="<?php echo htmlspecialchars($site_name); ?>" style="height:26px; width:auto;">
      <div class="tagline">Belajar Tuntas &bull; Sukses Pasti</div>
    </div>

    <div class="medal-wrap"><div class="medal-circle"><div class="medal-star">&#9733;</div></div></div>

    <div class="title">Sertifikat Kelulusan</div>
    <div class="subtitle">Certificate of Completion</div>
    <div class="line-gold"></div>

    <div class="statement">Dengan ini menyatakan bahwa</div>

    <div class="recipient">
      <div class="name"><?php echo htmlspecialchars($user_name); ?></div>
    </div>

    <div class="course-label">Telah menyelesaikan kursus &mdash; Has Completed The Course</div>
    <div class="course-name"><?php echo htmlspecialchars($course_disp); ?></div>
  </div>

  <!-- Kutipan pengisi ruang tengah -->
  <div class="mid-quote">
    <div class="q-line"></div>
    <div class="q-text">&ldquo;<?php echo t('Ilmu yang diamalkan adalah ilmu yang bermanfaat. Teruslah belajar, tuntaskan setiap langkahmu.', 'Knowledge applied is knowledge gained. Keep learning, complete every step.'); ?>&rdquo;</div>
    <div class="q-line" style="margin-top:10px;"></div>
  </div>

  <!-- Signature -->
  <div class="sig-row">
    <table class="sig-table">
      <tr>
        <td>
          <div class="sig-line"></div>
          <div class="sig-name">Admin BISATUNTAS</div>
          <div class="sig-role">Penerbit Sertifikat / Certificate Issuer</div>
        </td>
        <td>
          <div class="sig-line"></div>
          <div class="sig-name"><?php echo $site_name; ?></div>
          <div class="sig-role">Platform Resmi / Official Platform</div>
        </td>
      </tr>
    </table>
  </div>

  <!-- Footer -->
  <div class="meta">
    <div class="code">Kode Sertifikat: <?php echo htmlspecialchars($certificate_code); ?> &nbsp;|&nbsp; Tanggal Terbit: <?php echo $issued_date; ?></div>
    <div class="verify">Verifikasi keaslian: <?php echo $verify_url; ?></div>
  </div>
</div>
</body>
</html>
