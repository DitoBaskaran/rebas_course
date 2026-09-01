<div class="container-fluid px-0">
    <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between mb-5 gap-3">
        <div>
            <span class="text-primary fw-semibold small text-uppercase tracking-wide d-block mb-1">
                <a href="<?php echo base_url('admin/documents'); ?>" class="text-decoration-none text-primary">← <?php echo t('Dokumen', 'Documents'); ?></a>
            </span>
            <h1 class="display-6 fw-extrabold text-dark mb-1 lh-sm" style="letter-spacing: -0.03em;"><?php echo t('Diskusi Partnership', 'Partnership Discussion'); ?></h1>
            <p class="text-secondary mb-0"><?php echo t('Pertanyaan-pertanyaan kunci sebelum memulai bisnis bersama', 'Key questions before starting business together'); ?></p>
        </div>
        <div>
            <button onclick="window.print()" class="btn btn-outline-dark rounded-pill px-3 py-2 fw-semibold d-inline-flex align-items-center gap-2">
                <i data-lucide="printer" style="width:16px;height:16px;"></i> <?php echo t('Cetak / PDF', 'Print / PDF'); ?>
            </button>
        </div>
    </div>

    <div class="bento-card p-4 p-xl-5">
        <div class="d-flex flex-column gap-6" style="max-width: 800px; margin: 0 auto;">

            <!-- Intro -->
            <div class="p-4 rounded-3" style="background: #E6EBEF; border-left: 4px solid #009688;">
                <p class="mb-0" style="color: #475569; font-size: 0.95rem; line-height: 1.7;">
                    <strong><?php echo t('Panduan Diskusi', 'Discussion Guide'); ?>:</strong>
                    <?php echo t('Gunakan dokumen ini sebagai panduan diskusi dengan calon partner. Setiap bagian memiliki pertanyaan kunci yang perlu dijawab bersama sebelum memutuskan untuk berpartner. Centang atau catat jawaban di sela diskusi agar tidak ada poin yang terlewat.', 'Use this document as a discussion guide with potential partners. Each section has key questions that need to be answered together before deciding to partner. Check off or note answers during discussion so no points are missed.'); ?>
                </p>
            </div>

            <!-- Section 1: Business & Strategy -->
            <div class="section">
                <div class="d-flex align-items-center gap-2 mb-4 pb-2 border-bottom" style="border-color: #e2e8f0;">
                    <span style="display:flex;align-items:center;justify-content:center;width:32px;height:32px;background:#009688;color:#fff;font-weight:700;font-size:0.85rem;border-radius:8px;flex-shrink:0;">1</span>
                    <h2 class="mb-0" style="font-size:1.15rem;font-weight:700;color:#0D1830;"><?php echo t('Bisnis & Strategi', 'Business & Strategy'); ?></h2>
                </div>
                <ul class="list-unstyled">
                    <li class="p-3 rounded-2 mb-2" style="background:#E6EBEF; border:1px solid #e2e8f0;">
                        <span class="fw-semibold text-primary me-2">01</span><?php echo t('Bagaimana pembagian saham atau ekuitas masing-masing partner? Apakah ada vesting schedule?', 'How is equity split between partners? Is there a vesting schedule?'); ?>
                    </li>
                    <li class="p-3 rounded-2 mb-2" style="background:#E6EBEF; border:1px solid #e2e8f0;">
                        <span class="fw-semibold text-primary me-2">02</span><?php echo t('Fokus utama kita: B2C (siswa langsung) atau B2B (perusahaan, sekolah, institusi)? Atau keduanya?', 'Main focus: B2C (direct students) or B2B (companies, schools, institutions)? Or both?'); ?>
                    </li>
                    <li class="p-3 rounded-2 mb-2" style="background:#E6EBEF; border:1px solid #e2e8f0;">
                        <span class="fw-semibold text-primary me-2">03</span><?php echo t('Target pendapatan (revenue) 6 bulan pertama? 1 tahun? 3 tahun?', 'Revenue targets for first 6 months? 1 year? 3 years?'); ?>
                    </li>
                    <li class="p-3 rounded-2 mb-2" style="background:#E6EBEF; border:1px solid #e2e8f0;">
                        <span class="fw-semibold text-primary me-2">04</span><?php echo t('Siapa yang bertanggung jawab atas operasional harian? Siapa di posisi strategis?', 'Who handles daily operations? Who is in strategic role?'); ?>
                    </li>
                    <li class="p-3 rounded-2 mb-2" style="background:#E6EBEF; border:1px solid #e2e8f0;">
                        <span class="fw-semibold text-primary me-2">05</span><?php echo t('Bagaimana mekanisme jika salah satu partner ingin keluar? Buyout, jual saham, atau bubar?', 'What is the exit mechanism if a partner wants to leave? Buyout, sell shares, or dissolve?'); ?>
                    </li>
                    <li class="p-3 rounded-2 mb-2" style="background:#E6EBEF; border:1px solid #e2e8f0;">
                        <span class="fw-semibold text-primary me-2">06</span><?php echo t('Apakah kita akan mencari investor (angel, VC) atau bootstrap dulu hingga profit?', 'Will we seek investors (angel, VC) or bootstrap until profitable?'); ?>
                    </li>
                    <li class="p-3 rounded-2 mb-2" style="background:#E6EBEF; border:1px solid #e2e8f0;">
                        <span class="fw-semibold text-primary me-2">07</span><?php echo t('Sistem bagi hasil tiap kursus terjual: berapa persen untuk platform, untuk pengajar, untuk affiliate?', 'Revenue split per course sold: percentage for platform, teacher, affiliate?'); ?>
                    </li>
                    <li class="p-3 rounded-2 mb-2" style="background:#E6EBEF; border:1px solid #e2e8f0;">
                        <span class="fw-semibold text-primary me-2">08</span><?php echo t('Bagaimana proses pengambilan keputusan jika pendapat berbeda? Voting atau siapa yang decisive?', 'Decision process when opinions differ? Voting or who has final say?'); ?>
                    </li>
                </ul>
            </div>

            <!-- Section 2: Technical & Product -->
            <div class="section">
                <div class="d-flex align-items-center gap-2 mb-4 pb-2 border-bottom" style="border-color: #e2e8f0;">
                    <span style="display:flex;align-items:center;justify-content:center;width:32px;height:32px;background:#009688;color:#fff;font-weight:700;font-size:0.85rem;border-radius:8px;flex-shrink:0;">2</span>
                    <h2 class="mb-0" style="font-size:1.15rem;font-weight:700;color:#0D1830;"><?php echo t('Teknikal & Produk', 'Technical & Product'); ?></h2>
                </div>
                <ul class="list-unstyled">
                    <li class="p-3 rounded-2 mb-2" style="background:#E6EBEF; border:1px solid #e2e8f0;">
                        <span class="fw-semibold text-primary me-2">01</span><?php echo t('Tech stack saat ini: maintain dengan PHP CodeIgniter atau plan migrasi ke framework lain (Laravel, React, Next.js)?', 'Current tech stack: maintain PHP CodeIgniter or plan migration to other frameworks?'); ?>
                    </li>
                    <li class="p-3 rounded-2 mb-2" style="background:#E6EBEF; border:1px solid #e2e8f0;">
                        <span class="fw-semibold text-primary me-2">02</span><?php echo t('Prioritas fitur 30 hari pertama: apa yang HARUS selesai? Bug fixes, fitur baru, atau infrastruktur?', 'Feature priorities for first 30 days: what MUST be done? Bug fixes, new features, or infrastructure?'); ?>
                    </li>
                    <li class="p-3 rounded-2 mb-2" style="background:#E6EBEF; border:1px solid #e2e8f0;">
                        <span class="fw-semibold text-primary me-2">03</span><?php echo t('Bagaimana strategi scaling server seiring bertambahnya traffic dan user?', 'Server scaling strategy as traffic and users grow?'); ?>
                    </li>
                    <li class="p-3 rounded-2 mb-2" style="background:#E6EBEF; border:1px solid #e2e8f0;">
                        <span class="fw-semibold text-primary me-2">04</span><?php echo t('Siapa yang handle maintenance, bug fixing, deployment, dan monitoring?', 'Who handles maintenance, bug fixes, deployment, monitoring?'); ?>
                    </li>
                    <li class="p-3 rounded-2 mb-2" style="background:#E6EBEF; border:1px solid #e2e8f0;">
                        <span class="fw-semibold text-primary me-2">05</span><?php echo t('Proses review code (code review) seperti apa? Pakai GitHub flow, GitLab, atau langsung push?', 'Code review process? GitHub flow, GitLab, or direct push?'); ?>
                    </li>
                    <li class="p-3 rounded-2 mb-2" style="background:#E6EBEF; border:1px solid #e2e8f0;">
                        <span class="fw-semibold text-primary me-2">05</span><?php echo t('Strategi SEO, performa website (Core Web Vitals), dan aksesibilitas?', 'SEO strategy, website performance (Core Web Vitals), accessibility?'); ?>
                    </li>
                    <li class="p-3 rounded-2 mb-2" style="background:#E6EBEF; border:1px solid #e2e8f0;">
                        <span class="fw-semibold text-primary me-2">07</span><?php echo t('Database: apakah perlu migrasi dari MySQL ke yang lebih scalable? Bagaimana backup strategy?', 'Database: need migration from MySQL to more scalable? Backup strategy?'); ?>
                    </li>
                    <li class="p-3 rounded-2 mb-2" style="background:#E6EBEF; border:1px solid #e2e8f0;">
                        <span class="fw-semibold text-primary me-2">08</span><?php echo t('Mobile app: perlu atau web-first dulu? PWA cukup atau native?', 'Mobile app: needed or web-first? PWA enough or native?'); ?>
                    </li>
                </ul>
            </div>

            <!-- Section 3: Content & Academic -->
            <div class="section">
                <div class="d-flex align-items-center gap-2 mb-4 pb-2 border-bottom" style="border-color: #e2e8f0;">
                    <span style="display:flex;align-items:center;justify-content:center;width:32px;height:32px;background:#009688;color:#fff;font-weight:700;font-size:0.85rem;border-radius:8px;flex-shrink:0;">3</span>
                    <h2 class="mb-0" style="font-size:1.15rem;font-weight:700;color:#0D1830;"><?php echo t('Konten & Akademik', 'Content & Academic'); ?></h2>
                </div>
                <ul class="list-unstyled">
                    <li class="p-3 rounded-2 mb-2" style="background:#E6EBEF; border:1px solid #e2e8f0;">
                        <span class="fw-semibold text-primary me-2">01</span><?php echo t('Siapa yang bertugas mencari, merekrut, dan mengkurasi mentor atau pengajar baru?', 'Who is responsible for finding, recruiting, and curating mentors/teachers?'); ?>
                    </li>
                    <li class="p-3 rounded-2 mb-2" style="background:#E6EBEF; border:1px solid #e2e8f0;">
                        <span class="fw-semibold text-primary me-2">02</span><?php echo t('Standar kualitas konten: berapa minimal durasi video? Kualitas audio? Materi pendukung (modul, quiz)?', 'Content quality standards: minimum video duration? Audio quality? Supporting materials?'); ?>
                    </li>
                    <li class="p-3 rounded-2 mb-2" style="background:#E6EBEF; border:1px solid #e2e8f0;">
                        <span class="fw-semibold text-primary me-2">03</span><?php echo t('Bagaimana proses kurasi agar konten relevan dengan kebutuhan industri dan pasar kerja?', 'How is curation done to ensure content relevance to industry needs?'); ?>
                    </li>
                    <li class="p-3 rounded-2 mb-2" style="background:#E6EBEF; border:1px solid #e2e8f0;">
                        <span class="fw-semibold text-primary me-2">04</span><?php echo t('Konten original (buat sendiri) atau kurasi dari sumber lain? Atau kombinasi?', 'Original content or curated from other sources? Or combination?'); ?>
                    </li>
                    <li class="p-3 rounded-2 mb-2" style="background:#E6EBEF; border:1px solid #e2e8f0;">
                        <span class="fw-semibold text-primary me-2">05</span><?php echo t('Sistem sertifikasi: standar kelulusan (passing grade), verifikasi sertifikat, dan pengakuan industri?', 'Certification system: passing standards, certificate verification, industry recognition?'); ?>
                    </li>
                    <li class="p-3 rounded-2 mb-2" style="background:#E6EBEF; border:1px solid #e2e8f0;">
                        <span class="fw-semibold text-primary me-2">06</span><?php echo t('Update konten: berapa sering konten lama perlu direfresh? Siapa yang bertanggung jawab?', 'Content updates: how often refresh old content? Who is responsible?'); ?>
                    </li>
                    <li class="p-3 rounded-2 mb-2" style="background:#E6EBEF; border:1px solid #e2e8f0;">
                        <span class="fw-semibold text-primary me-2">07</span><?php echo t('Multi-bahasa: cukup Indonesia-Inggris atau perlu bahasa daerah/asing lainnya?', 'Multi-language: Indonesia-English enough or need other languages?'); ?>
                    </li>
                    <li class="p-3 rounded-2 mb-2" style="background:#E6EBEF; border:1px solid #e2e8f0;">
                        <span class="fw-semibold text-primary me-2">08</span><?php echo t('Bagaimana handle keluhan siswa tentang kualitas konten? Refund policy?', 'How to handle student complaints about content quality? Refund policy?'); ?>
                    </li>
                </ul>
            </div>

            <!-- Section 4: Marketing & Sales -->
            <div class="section">
                <div class="d-flex align-items-center gap-2 mb-4 pb-2 border-bottom" style="border-color: #e2e8f0;">
                    <span style="display:flex;align-items:center;justify-content:center;width:32px;height:32px;background:#009688;color:#fff;font-weight:700;font-size:0.85rem;border-radius:8px;flex-shrink:0;">4</span>
                    <h2 class="mb-0" style="font-size:1.15rem;font-weight:700;color:#0D1830;"><?php echo t('Marketing & Sales', 'Marketing & Sales'); ?></h2>
                </div>
                <ul class="list-unstyled">
                    <li class="p-3 rounded-2 mb-2" style="background:#E6EBEF; border:1px solid #e2e8f0;">
                        <span class="fw-semibold text-primary me-2">01</span><?php echo t('Budget marketing per bulan? Alokasi untuk platform apa (Instagram, TikTok, Google Ads, LinkedIn)?', 'Monthly marketing budget? Platform allocation (IG, TikTok, Google Ads, LinkedIn)?'); ?>
                    </li>
                    <li class="p-3 rounded-2 mb-2" style="background:#E6EBEF; border:1px solid #e2e8f0;">
                        <span class="fw-semibold text-primary me-2">02</span><?php echo t('Siapa yang handle social media, content creation, dan community management?', 'Who handles social media, content creation, community management?'); ?>
                    </li>
                    <li class="p-3 rounded-2 mb-2" style="background:#E6EBEF; border:1px solid #e2e8f0;">
                        <span class="fw-semibold text-primary me-2">03</span><?php echo t('Strategi affiliate marketing dan referral program: komisi berapa? Syarat payout?', 'Affiliate & referral strategy: commission rate? Payout terms?'); ?>
                    </li>
                    <li class="p-3 rounded-2 mb-2" style="background:#E6EBEF; border:1px solid #e2e8f0;">
                        <span class="fw-semibold text-primary me-2">04</span><?php echo t('Target biaya akuisisi pelanggan (CPA/CAC)? Berapa idealnya per siswa?', 'Target customer acquisition cost (CPA/CAC)? Ideal per student?'); ?>
                    </li>
                    <li class="p-3 rounded-2 mb-2" style="background:#E6EBEF; border:1px solid #e2e8f0;">
                        <span class="fw-semibold text-primary me-2">05</span><?php echo t('Kolaborasi dengan influencer, institusi pendidikan, atau perusahaan? Approach seperti apa?', 'Collaborations with influencers, educational institutions, companies? Approach?'); ?>
                    </li>
                    <li class="p-3 rounded-2 mb-2" style="background:#E6EBEF; border:1px solid #e2e8f0;">
                        <span class="fw-semibold text-primary me-2">06</span><?php echo t('Strategi email marketing: nurture sequence, promo, re-engagement?', 'Email marketing strategy: nurture sequence, promo, re-engagement?'); ?>
                    </li>
                    <li class="p-3 rounded-2 mb-2" style="background:#E6EBEF; border:1px solid #e2e8f0;">
                        <span class="fw-semibold text-primary me-2">07</span><?php echo t('Bagaimana mengukur ROI marketing? Tools apa yang dipakai (GA4, Meta Pixel, dll)?', 'How to measure marketing ROI? Tools used (GA4, Meta Pixel, etc)?'); ?>
                    </li>
                    <li class="p-3 rounded-2 mb-2" style="background:#E6EBEF; border:1px solid #e2e8f0;">
                        <span class="fw-semibold text-primary me-2">08</span><?php echo t('Sales funnel: free trial, discount, bundle, atau upsell? Bagaimana conversion strategy?', 'Sales funnel: free trial, discount, bundle, upsell? Conversion strategy?'); ?>
                    </li>
                </ul>
            </div>

            <!-- Section 5: Legal & Admin -->
            <div class="section">
                <div class="d-flex align-items-center gap-2 mb-4 pb-2 border-bottom" style="border-color: #e2e8f0;">
                    <span style="display:flex;align-items:center;justify-content:center;width:32px;height:32px;background:#009688;color:#fff;font-weight:700;font-size:0.85rem;border-radius:8px;flex-shrink:0;">5</span>
                    <h2 class="mb-0" style="font-size:1.15rem;font-weight:700;color:#0D1830;"><?php echo t('Legal & Administrasi', 'Legal & Admin'); ?></h2>
                </div>
                <ul class="list-unstyled">
                    <li class="p-3 rounded-2 mb-2" style="background:#E6EBEF; border:1px solid #e2e8f0;">
                        <span class="fw-semibold text-primary me-2">01</span><?php echo t('Bentuk badan hukum: PT, CV, Firma, atau lainnya? Kapan akan didaftarkan?', 'Legal entity type: PT, CV, Firma, etc? When to register?'); ?>
                    </li>
                    <li class="p-3 rounded-2 mb-2" style="background:#E6EBEF; border:1px solid #e2e8f0;">
                        <span class="fw-semibold text-primary me-2">02</span><?php echo t('Rekening perusahaan: rekening bersama atau masing-masing? Siapa yang punya akses?', 'Company bank account: joint or separate? Who has access?'); ?>
                    </li>
                    <li class="p-3 rounded-2 mb-2" style="background:#E6EBEF; border:1px solid #e2e8f0;">
                        <span class="fw-semibold text-primary me-2">03</span><?php echo t('Kontrak partnership: jangka waktu berapa lama? Auto-renew atau perlu diperpanjang manual?', 'Partnership contract duration? Auto-renew or manual renewal?'); ?>
                    </li>
                    <li class="p-3 rounded-2 mb-2" style="background:#E6EBEF; border:1px solid #e2e8f0;">
                        <span class="fw-semibold text-primary me-2">04</span><?php echo t('Perlindungan Hak Kekayaan Intelektual (HAKI): untuk konten kursus, logo, brand?', 'IP protection for course content, logo, brand?'); ?>
                    </li>
                    <li class="p-3 rounded-2 mb-2" style="background:#E6EBEF; border:1px solid #e2e8f0;">
                        <span class="fw-semibold text-primary me-2">05</span><?php echo t('Bagaimana kepatuhan terhadap UU Perlindungan Data Pribadi (PDP)? Handling data siswa?', 'PDP Law compliance? Student data handling?'); ?>
                    </li>
                    <li class="p-3 rounded-2 mb-2" style="background:#E6EBEF; border:1px solid #e2e8f0;">
                        <span class="fw-semibold text-primary me-2">06</span><?php echo t('Perjanjian kerahasiaan (NDA): diperlukan atau tidak antarpihak?', 'NDA required between partners?'); ?>
                    </li>
                    <li class="p-3 rounded-2 mb-2" style="background:#E6EBEF; border:1px solid #e2e8f0;">
                        <span class="fw-semibold text-primary me-2">07</span><?php echo t('Bagaimana handle jika ada sengketa? Mediasi, arbitrase, atau jalur hukum?', 'Dispute resolution: mediation, arbitration, or court?'); ?>
                    </li>
                    <li class="p-3 rounded-2 mb-2" style="background:#E6EBEF; border:1px solid #e2e8f0;">
                        <span class="fw-semibold text-primary me-2">08</span><?php echo t('Asuransi: apakah perlu asuransi untuk perlindungan bisnis?', 'Business insurance needed?'); ?>
                    </li>
                </ul>
            </div>

            <!-- Section 6: Financial -->
            <div class="section">
                <div class="d-flex align-items-center gap-2 mb-4 pb-2 border-bottom" style="border-color: #e2e8f0;">
                    <span style="display:flex;align-items:center;justify-content:center;width:32px;height:32px;background:#009688;color:#fff;font-weight:700;font-size:0.85rem;border-radius:8px;flex-shrink:0;">6</span>
                    <h2 class="mb-0" style="font-size:1.15rem;font-weight:700;color:#0D1830;"><?php echo t('Finansial & Akuntansi', 'Financial & Accounting'); ?></h2>
                </div>
                <ul class="list-unstyled">
                    <li class="p-3 rounded-2 mb-2" style="background:#E6EBEF; border:1px solid #e2e8f0;">
                        <span class="fw-semibold text-primary me-2">01</span><?php echo t('Modal awal: berapa masing-masing menyetor? Untuk apa saja alokasi dana tersebut?', 'Initial capital: how much each contributes? Allocation of funds?'); ?>
                    </li>
                    <li class="p-3 rounded-2 mb-2" style="background:#E6EBEF; border:1px solid #e2e8f0;">
                        <span class="fw-semibold text-primary me-2">02</span><?php echo t('Gaji: di awal ambil gaji atau tidak? Kapan mulai bisa gaji? Berapa nominalnya?', 'Salary: take salary from start? When start? How much?'); ?>
                    </li>
                    <li class="p-3 rounded-2 mb-2" style="background:#E6EBEF; border:1px solid #e2e8f0;">
                        <span class="fw-semibold text-primary me-2">03</span><?php echo t('Kapan target break-even point (BEP)? Berdasarkan revenue berapa per bulan?', 'Target break-even point (BEP)? Based on what monthly revenue?'); ?>
                    </li>
                    <li class="p-3 rounded-2 mb-2" style="background:#E6EBEF; border:1px solid #e2e8f0;">
                        <span class="fw-semibold text-primary me-2">04</span><?php echo t('Dana darurat: berapa bulan operasional yang harus dicadangkan?', 'Emergency fund: how many months of operations to reserve?'); ?>
                    </li>
                    <li class="p-3 rounded-2 mb-2" style="background:#E6EBEF; border:1px solid #e2e8f0;">
                        <span class="fw-semibold text-primary me-2">05</span><?php echo t('Laporan keuangan: bulanan atau mingguan? Siapa yang membuat dan memverifikasi?', 'Financial reports: monthly or weekly? Who prepares and verifies?'); ?>
                    </li>
                    <li class="p-3 rounded-2 mb-2" style="background:#E6EBEF; border:1px solid #e2e8f0;">
                        <span class="fw-semibold text-primary me-2">06</span><?php echo t('Pajak: siapa yang handle perpajakan (PPN, PPh)? Perlu konsultan pajak?', 'Taxes: who handles taxes (VAT, income tax)? Need tax consultant?'); ?>
                    </li>
                    <li class="p-3 rounded-2 mb-2" style="background:#E6EBEF; border:1px solid #e2e8f0;">
                        <span class="fw-semibold text-primary me-2">07</span><?php echo t('Reinvestasi: berapa persen profit yang di-reinvest ke bisnis vs dibagikan?', 'Reinvestment: what % of profit reinvested vs distributed?'); ?>
                    </li>
                    <li class="p-3 rounded-2 mb-2" style="background:#E6EBEF; border:1px solid #e2e8f0;">
                        <span class="fw-semibold text-primary me-2">08</span><?php echo t('Bagaimana pengelolaan cash flow? Tools apa yang dipakai (BukuWarung, Jurnal, Excel)?', 'Cash flow management? Tools used (BukuWarung, Jurnal, Excel)?'); ?>
                    </li>
                </ul>
            </div>

            <!-- Notes Section -->
            <div class="mt-5 pt-4 border-top" style="border-color: #e2e8f0;">
                <h3 class="fw-bold text-secondary small text-uppercase tracking-wide mb-3"><?php echo t('Catatan Diskusi', 'Discussion Notes'); ?></h3>
                <div style="height: 200px;">
                    <p style="border-bottom: 1px dashed #e2e8f0; padding-bottom: 20px; margin-bottom: 20px;"></p>
                    <p style="border-bottom: 1px dashed #e2e8f0; padding-bottom: 20px; margin-bottom: 20px;"></p>
                    <p style="border-bottom: 1px dashed #e2e8f0; padding-bottom: 20px; margin-bottom: 20px;"></p>
                    <p style="border-bottom: 1px dashed #e2e8f0; padding-bottom: 20px;"></p>
                </div>
            </div>

            <!-- Signature -->
            <div class="mt-5 pt-4 border-top" style="border-color: #e2e8f0;">
                <div class="row">
                    <div class="col-md-6">
                        <p class="text-secondary small mb-1"><?php echo t('Partner 1', 'Partner 1'); ?></p>
                        <p style="border-bottom: 1px solid #e2e8f0; height: 40px;"></p>
                        <p class="text-secondary small"><?php echo t('Tanggal', 'Date'); ?>: _______________</p>
                    </div>
                    <div class="col-md-6">
                        <p class="text-secondary small mb-1"><?php echo t('Partner 2', 'Partner 2'); ?></p>
                        <p style="border-bottom: 1px solid #e2e8f0; height: 40px;"></p>
                        <p class="text-secondary small"><?php echo t('Tanggal', 'Date'); ?>: _______________</p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<style>
@media print {
    .admin-topbar, .admin-sidebar, .admin-footer, .btn { display: none !important; }
    .admin-content { padding: 0 !important; margin: 0 !important; }
    .admin-wrapper { display: block !important; }
    body { background: #fff !important; }
    .bento-card { box-shadow: none !important; border: none !important; padding: 0 !important; }
    .section { page-break-inside: avoid; }
}
</style>