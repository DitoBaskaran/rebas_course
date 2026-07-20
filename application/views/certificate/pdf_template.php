<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<style>
  @page { size: A4 landscape; margin: 0; }
  * { margin: 0; padding: 0; box-sizing: border-box; }
  body { width: 1122px; height: 793px; font-family: sans-serif; }
  .page {
    width: 1122px; height: 793px; position: relative;
    background: #fff; border: 8px solid #1e293b;
    border-radius: 8px; overflow: hidden;
  }
  .border-inner {
    position: absolute; inset: 12px;
    border: 2px solid #eab308; border-radius: 4px;
  }
  .header { text-align: center; padding-top: 80px; }
  .badge {
    display: inline-block; width: 70px; height: 70px;
    background: #eab308; color: #111827; border-radius: 50%;
    line-height: 70px; font-size: 32px; font-weight: 800;
    margin-bottom: 15px;
  }
  .title { font-size: 28px; font-weight: 800; color: #111827; letter-spacing: 3px; text-transform: uppercase; }
  .subtitle { font-size: 13px; color: #64748b; margin-top: 5px; letter-spacing: 1px; }
  .body { text-align: center; margin-top: 25px; }
  .body p { font-size: 15px; color: #475569; line-height: 1.6; max-width: 700px; margin: 0 auto; }
  .recipient { margin-top: 18px; }
  .recipient .name {
    font-size: 38px; font-weight: 800; color: #111827;
    border-bottom: 3px solid #eab308; display: inline-block;
    padding-bottom: 5px; min-width: 350px;
  }
  .course-label { font-size: 13px; color: #64748b; margin-top: 10px; text-transform: uppercase; letter-spacing: 2px; }
  .course-name { font-size: 22px; font-weight: 700; color: #1e293b; margin-top: 3px; }
  .meta {
    display: flex; justify-content: center; gap: 80px;
    margin-top: 35px; padding-top: 20px;
    border-top: 1px solid #e2e8f0;
  }
  .meta-item { text-align: center; }
  .meta-item .label { font-size: 10px; color: #94a3b8; text-transform: uppercase; letter-spacing: 2px; }
  .meta-item .value { font-size: 14px; color: #1e293b; font-weight: 700; margin-top: 4px; }
  .footer-line {
    position: absolute; bottom: 40px; left: 50%; transform: translateX(-50%);
    text-align: center;
  }
  .footer-line .url { font-size: 11px; color: #94a3b8; }
  .footer-line .code { font-size: 11px; color: #64748b; margin-top: 3px; font-weight: 600; }
</style>
</head>
<body>
<div class="page">
  <div class="border-inner"></div>

  <div class="header">
    <div class="badge">B</div>
    <div class="title">Sertifikat Kelulusan</div>
    <div class="subtitle">Certificate of Completion</div>
  </div>

  <div class="body">
    <p>Dengan ini menyatakan bahwa</p>

    <div class="recipient">
      <div class="name"><?php echo htmlspecialchars($user_name); ?></div>
    </div>

    <div class="course-label">Telah menyelesaikan kursus</div>
    <div class="course-name"><?php echo htmlspecialchars(current_lang() === 'en' && !empty($title_en) ? $title_en : $title); ?></div>
  </div>

  <div class="meta">
    <div class="meta-item">
      <div class="label">Kode Sertifikat</div>
      <div class="value"><?php echo htmlspecialchars($certificate_code); ?></div>
    </div>
    <div class="meta-item">
      <div class="label">Tanggal Terbit</div>
      <div class="value"><?php echo date('d F Y', strtotime($issued_at)); ?></div>
    </div>
    <div class="meta-item">
      <div class="label">Platform</div>
      <div class="value"><?php echo htmlspecialchars(setting('general_site_name', 'BISATUNTAS')); ?></div>
    </div>
  </div>

  <div class="footer-line">
    <div class="url">Verifikasi: <?php echo base_url('certificate/verify/' . $certificate_code); ?></div>
    <div class="code">Kode: <?php echo htmlspecialchars($certificate_code); ?></div>
  </div>
</div>
</body>
</html>
