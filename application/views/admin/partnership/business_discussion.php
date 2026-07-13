<div class="container-fluid px-0">
    <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between mb-5 gap-3">
        <div>
            <span class="fw-semibold small text-uppercase tracking-wide d-block mb-1" style="color:#000;">
                <a href="<?php echo base_url('admin/documents'); ?>" class="text-decoration-none" style="color:#000;">← Kembali ke Dokumen</a>
            </span>
            <h1 class="display-6 fw-extrabold mb-1 lh-sm" style="color:#000;letter-spacing:-0.03em;">Diskusi Bisnis</h1>
            <p class="mb-0" style="color:#333;">Catatan internal diskusi bisnis: pembangunan fitur, arsitektur, model bisnis, pembayaran, marketing, legal, organisasi, metrik, dan rencana pengembangan ke depan.</p>
        </div>
        <div>
            <button onclick="window.print()" class="btn rounded-pill px-3 py-2 fw-semibold d-inline-flex align-items-center gap-2" style="background:#000;color:#fff;border:1px solid #000;">
                <i data-lucide="printer" style="width:16px;height:16px;"></i> Cetak / PDF
            </button>
        </div>
    </div>

    <div class="p-4 p-xl-5" style="border:1px solid #000;border-radius:1rem;">
        <div class="d-flex flex-column gap-6" style="max-width: 800px; margin: 0 auto;">

            <div class="p-4" style="background:#f5f5f5; border-left: 4px solid #000;">
                <p class="mb-0" style="color:#222;font-size:0.95rem;line-height:1.7;">
                    <strong>Panduan:</strong>
                    Dokumen ini merangkum poin-poin diskusi bisnis. Format: <b>Pertanyaan</b> (hal yang perlu diputuskan), <b>Pernyataan</b> (posisi atau asumsi saat ini), dan <b>Jawaban</b> (kesimpulan atau tindak lanjut). Setiap bagian ditulis untuk menjadi acuan pengambilan keputusan tim.
                </p>
            </div>

            <!-- BAGIAN 1: PEMBANGUNAN FITUR & ALUR -->
            <div class="section">
                <div class="d-flex align-items-center gap-2 mb-4 pb-2" style="border-bottom:2px solid #000;">
                    <span style="display:flex;align-items:center;justify-content:center;width:32px;height:32px;background:#000;color:#fff;font-weight:700;font-size:0.85rem;border-radius:8px;flex-shrink:0;">1</span>
                    <h2 class="mb-0" style="font-size:1.15rem;font-weight:700;color:#000;">Pembangunan Fitur & Alur</h2>
                </div>
                <ul class="list-unstyled">
                    <li class="p-3 mb-3" style="background:#fafafa;border:1px solid #000;border-radius:6px;">
                        <div class="fw-bold" style="color:#000;">Pertanyaan: Fitur apa yang menjadi prioritas pada 30 hari pertama?</div>
                        <div style="color:#333;"><b>Pernyataan:</b> Fokus pada stabilitas transaksi, langganan, dan saldo menit karena itu inti monetisasi. Banyak fitur pendukung seperti kuis dan sertifikat belum tersentuh.</div>
                        <div style="color:#333;"><b>Jawaban:</b> Selesaikan alur beli → bayar → aktivasi terlebih dahulu. Pastikan webhook berjalan stabil, status transaksi akurat, dan user mendapat konfirmasi yang jelas. Fitur pendukung bisa menyusul setelah fondasi moneter kokoh.</div>
                    </li>
                    <li class="p-3 mb-3" style="background:#fafafa;border:1px solid #000;border-radius:6px;">
                        <div class="fw-bold" style="color:#000;">Pertanyaan: Bagaimana alur checkout saat ini? Apakah sudah efisien?</div>
                        <div style="color:#333;"><b>Pernyataan:</b> User klik beli → masuk halaman konfirmasi → pilih metode bayar → dapat kode pembayaran. Namun ada celah: transaksi dibuat saat klik beli, menyebabkan data transaksi menganggur jika user tidak lanjut bayar.</div>
                        <div style="color:#333;"><b>Jawaban:</b> Ubah alur menjadi cart-based: user klik beli → cart disimpan di session → transaksi dibuat hanya saat klik bayar. Ini menghilangkan data sampah dan membuat rasio konversi lebih terukur.</div>
                    </li>
                    <li class="p-3 mb-3" style="background:#fafafa;border:1px solid #000;border-radius:6px;">
                        <div class="fw-bold" style="color:#000;">Pertanyaan: Apakah perlu role guru (teacher) untuk upload konten sendiri?</div>
                        <div style="color:#333;"><b>Pernyataan:</b> Saat ini admin yang mengelola seluruh konten. Untuk skala besar, admin akan menjadi bottleneck. Guru membutuhkan dashboard sendiri agar bisa mandiri.</div>
                        <div style="color:#333;"><b>Jawaban:</b> Rencanakan dashboard guru dengan workflow: guru upload → draft → admin review → publish. Sistem ini menjaga kualitas konten sambil memberikan otonomi kepada pengajar.</div>
                    </li>
                    <li class="p-3 mb-3" style="background:#fafafa;border:1px solid #000;border-radius:6px;">
                        <div class="fw-bold" style="color:#000;">Pertanyaan: Bagaimana penanganan error saat pembayaran gagal?</div>
                        <div style="color:#333;"><b>Pernyataan:</b> Webhook Pakasir atau Midtrans mengupdate status transaksi secara otomatis. Namun error handling di sisi user masih lemah: tidak ada notifikasi real-time jika bayar gagal.</div>
                        <div style="color:#333;"><b>Jawaban:</b> Tampilkan status "Menunggu", "Gagal", atau "Lunas" di riwayat transaksi user. Kirim notifikasi email dan WhatsApp untuk setiap perubahan status. Admin juga perlu panel monitoring transaksi yang gagal.</div>
                    </li>
                    <li class="p-3 mb-3" style="background:#fafafa;border:1px solid #000;border-radius:6px;">
                        <div class="fw-bold" style="color:#000;">Pertanyaan: Perlu tidak sistem diskusi forum di dalam kursus?</div>
                        <div style="color:#333;"><b>Pernyataan:</b> Forum umum sudah ada, tetapi belum terikat dengan materi tertentu. Diskusi per lesson bisa meningkatkan engagement dan membantu siswa yang kesulitan.</div>
                        <div style="color:#333;"><b>Jawaban:</b> Tambahkan thread diskusi per lesson. Moderasi oleh guru atau admin. Fitur ini bisa menjadi nilai jual: "belajar dengan diskusi langsung bersama pengajar".</div>
                    </li>
                    <li class="p-3 mb-3" style="background:#fafafa;border:1px solid #000;border-radius:6px;">
                        <div class="fw-bold" style="color:#000;">Pertanyaan: Kapan fitur kuis dan penilaian otomatis dikerjakan?</div>
                        <div style="color:#333;"><b>Pernyataan:</b> Kuis eksisting hanya menampilkan soal tanpa sistem penilaian otomatis yang terintegrasi dengan progress siswa.</div>
                        <div style="color:#333;"><b>Jawaban:</b> Implementasi kuis dengan grading otomatis, passing grade, dan retake limit. Hasil kuis mempengaruhi kelayakan sertifikat. Target pengerjaan setelah alur transaksi stabil.</div>
                    </li>
                </ul>
            </div>

            <!-- BAGIAN 2: ARSITEKTUR & TEKNOLOGI -->
            <div class="section">
                <div class="d-flex align-items-center gap-2 mb-4 pb-2" style="border-bottom:2px solid #000;">
                    <span style="display:flex;align-items:center;justify-content:center;width:32px;height:32px;background:#000;color:#fff;font-weight:700;font-size:0.85rem;border-radius:8px;flex-shrink:0;">2</span>
                    <h2 class="mb-0" style="font-size:1.15rem;font-weight:700;color:#000;">Arsitektur & Teknologi</h2>
                </div>
                <ul class="list-unstyled">
                    <li class="p-3 mb-3" style="background:#fafafa;border:1px solid #000;border-radius:6px;">
                        <div class="fw-bold" style="color:#000;">Pertanyaan: Tech stack yang dipakai dan perlukah migrasi?</div>
                        <div style="color:#333;"><b>Pernyataan:</b> PHP CodeIgniter 3 + MySQL + Bootstrap sudah berjalan di produksi. Memori dan performa mencukupi untuk trafik saat ini.</div>
                        <div style="color:#333;"><b>Jawaban:</b> Pertahankan CI3 sampai ekosistem benar-benar stabil. Jangan lakukan refactoring besar di tengah pengembangan fitur. Migrasi ke CI4 atau framework lain bisa dievaluasi setelah produk matang dan trafik naik signifikan.</div>
                    </li>
                    <li class="p-3 mb-3" style="background:#fafafa;border:1px solid #000;border-radius:6px;">
                        <div class="fw-bold" style="color:#000;">Pertanyaan: Strategi backup database seperti apa?</div>
                        <div style="color:#333;"><b>Pernyataan:</b> Backup masih manual via phpMyAdmin. Tidak ada jadwal rutin dan tidak ada backup off-site. Risiko kehilangan data cukup tinggi.</div>
                        <div style="color:#333;"><b>Jawaban:</b> Buat cron job harian yang menjalankan mysqldump dan menyimpan file backup 7 hari terakhir. Backup juga dikirim ke cloud storage (Google Drive atau S3) sebagai cadangan off-site. Uji restore secara berkala.</div>
                    </li>
                    <li class="p-3 mb-3" style="background:#fafafa;border:1px solid #000;border-radius:6px;">
                        <div class="fw-bold" style="color:#000;">Pertanyaan: Metode deployment ke server?</div>
                        <div style="color:#333;"><b>Pernyataan:</b> Saat ini upload via FTP atau copy langsung dari lokal. Tidak ada version control di server, menyulitkan rollback jika ada error.</div>
                        <div style="color:#333;"><b>Jawaban:</b> Gunakan Git di kedua environment. Production menarik dari branch stabil (main atau release). Buat script deploy satu langkah dan dokumentasikan prosedur rollback.</div>
                    </li>
                    <li class="p-3 mb-3" style="background:#fafafa;border:1px solid #000;border-radius:6px;">
                        <div class="fw-bold" style="color:#000;">Pertanyaan: Strategi hosting video pembelajaran?</div>
                        <div style="color:#333;"><b>Pernyataan:</b> Video disimpan di server lokal, berisiko membebani bandwidth dan storage server utama.</div>
                        <div style="color:#333;"><b>Jawaban:</b> Pindahkan video ke layanan khusus seperti Vimeo (pro), Cloudflare Stream, atau YouTube unlisted. Gunakan embed player agar bandwidth tidak membebani server. Ini juga meningkatkan kecepatan loading halaman.</div>
                    </li>
                    <li class="p-3 mb-3" style="background:#fafafa;border:1px solid #000;border-radius:6px;">
                        <div class="fw-bold" style="color:#000;">Pertanyaan: Apakah perlu sistem caching?</div>
                        <div style="color:#333;"><b>Pernyataan:</b> Belum ada caching layer. Setiap request mengenai database langsung. Jika trafik naik, server bisa kewalahan.</div>
                        <div style="color:#333;"><b>Jawaban:</b> Implementasi caching bertahap: query cache di MySQL, lalu page cache untuk halaman statis (home, daftar kursus). Jika budget memadai, tambahkan Redis atau Varnish.</div>
                    </li>
                    <li class="p-3 mb-3" style="background:#fafafa;border:1px solid #000;border-radius:6px;">
                        <div class="fw-bold" style="color:#000;">Pertanyaan: Metode pengujian (testing) seperti apa?</div>
                        <div style="color:#333;"><b>Pernyataan:</b> Belum ada automated test. Pengujian dilakukan manual, sangat bergantung pada ingatan dan ketelitian developer.</div>
                        <div style="color:#333;"><b>Jawaban:</b> Minimal, jalankan php -l pada setiap file sebelum commit. Buat checklist manual untuk alur kritis: registrasi, beli, bayar, aktivasi, akses konten. Pertimbangkan unit test untuk model dan helper jika waktu memungkinkan.</div>
                    </li>
                </ul>
            </div>

            <!-- BAGIAN 3: MODEL BISNIS -->
            <div class="section">
                <div class="d-flex align-items-center gap-2 mb-4 pb-2" style="border-bottom:2px solid #000;">
                    <span style="display:flex;align-items:center;justify-content:center;width:32px;height:32px;background:#000;color:#fff;font-weight:700;font-size:0.85rem;border-radius:8px;flex-shrink:0;">3</span>
                    <h2 class="mb-0" style="font-size:1.15rem;font-weight:700;color:#000;">Model Bisnis & Skema Harga</h2>
                </div>
                <ul class="list-unstyled">
                    <li class="p-3 mb-3" style="background:#fafafa;border:1px solid #000;border-radius:6px;">
                        <div class="fw-bold" style="color:#000;">Pertanyaan: Model harga apa saja yang ditawarkan?</div>
                        <div style="color:#333;"><b>Pernyataan:</b> Saat ini ada tiga model: course (beli sekali akses selamanya), package (langganan bulanan/tahunan), dan bundle (saldo menit). Ketiganya aktif tapi belum terdiferensiasi dengan jelas di mata user.</div>
                        <div style="color:#333;"><b>Jawaban:</b> Pisahkan positioning di halaman pricing. Course untuk akses spesifik, package untuk akses tak terbatas, saldo menit untuk fleksibilitas. Gunakan tabel perbandingan agar user paham mana yang paling sesuai.</div>
                    </li>
                    <li class="p-3 mb-3" style="background:#fafafa;border:1px solid #000;border-radius:6px;">
                        <div class="fw-bold" style="color:#000;">Pertanyaan: Berapa harga optimal untuk langganan?</div>
                        <div style="color:#333;"><b>Pernyataan:</b> Harga langganan saat ini Rp100.000 per bulan untuk paket Pro dan Rp250.000 untuk Mentorship. Belum ada data cukup untuk menentukan harga optimal.</div>
                        <div style="color:#333;"><b>Jawaban:</b> Lakukan A/B testing dengan harga berbeda. Pantau konversi di setiap titik harga. Bandingkan dengan kompetitor seperti Ruangguru, Zenius, atau Coursera. Jangan takut menaikkan harga jika konten berkualitas.</div>
                    </li>
                    <li class="p-3 mb-3" style="background:#fafafa;border:1px solid #000;border-radius:6px;">
                        <div class="fw-bold" style="color:#000;">Pertanyaan: Skema bagi hasil dengan guru atau kontributor konten?</div>
                        <div style="color:#333;"><b>Pernyataan:</b> Belum ada skema bagi hasil formal. Guru saat ini dibayar tetap per konten. Tidak ada insentif berbasis performa.</div>
                        <div style="color:#333;"><b>Jawaban:</b> Buat dua opsi: bayar di muka (fixed fee) atau royalti berbasis penjualan (misal 50-70% untuk guru). Skema royalti lebih menarik untuk guru berkualitas dan memotivasi mereka mempromosikan kursus.</div>
                    </li>
                    <li class="p-3 mb-3" style="background:#fafafa;border:1px solid #000;border-radius:6px;">
                        <div class="fw-bold" style="color:#000;">Pertanyaan: Kebijakan refund seperti apa?</div>
                        <div style="color:#333;"><b>Pernyataan:</b> Belum ada kebijakan refund tertulis. Jika user komplain, keputusan bersifat kasus per kasus tanpa standar.</div>
                        <div style="color:#333;"><b>Jawaban:</b> Tetapkan kebijakan: refund penuh dalam 7 hari jika konten tidak sesuai (dengan syarat progress < 20%). Untuk saldo menit, refund hanya untuk sisa saldo yang belum terpakai. Kebijakan ini harus ditampilkan di halaman checkout.</div>
                    </li>
                    <li class="p-3 mb-3" style="background:#fafafa;border:1px solid #000;border-radius:6px;">
                        <div class="fw-bold" style="color:#000;">Pertanyaan: Apakah perlu fitur bundling produk?</div>
                        <div style="color:#333;"><b>Pernyataan:</b> Setiap produk dijual terpisah. Tidak ada paket bundel yang menggabungkan course + menit + langganan dengan harga spesial.</div>
                        <div style="color:#333;"><b>Jawaban:</b> Siapkan bundling promosi, misal: "Paket Lengkap: 1 course favorit + 200 menit + 1 bulan langganan" dengan diskon 20%. Bundling meningkatkan average order value.</div>
                    </li>
                    <li class="p-3 mb-3" style="background:#fafafa;border:1px solid #000;border-radius:6px;">
                        <div class="fw-bold" style="color:#000;">Pertanyaan: Strategi diskon dan promosi?</div>
                        <div style="color:#333;"><b>Pernyataan:</b> Kupon diskon sudah bisa dibuat melalui admin (tabel coupons). Namun pemanfaatan masih minim karena belum ada kampanye promosi terjadwal.</div>
                        <div style="color:#333;"><b>Jawaban:</b> Buat kalender promosi: diskon awal tahun, Harbolnas, hari pendidikan, diskon ulang tahun platform. Kode seperti WELCOME20 untuk pengguna baru dan REFERRAL10 untuk program referral.</div>
                    </li>
                </ul>
            </div>

            <!-- BAGIAN 4: PEMBAYARAN & INTEGRASI -->
            <div class="section">
                <div class="d-flex align-items-center gap-2 mb-4 pb-2" style="border-bottom:2px solid #000;">
                    <span style="display:flex;align-items:center;justify-content:center;width:32px;height:32px;background:#000;color:#fff;font-weight:700;font-size:0.85rem;border-radius:8px;flex-shrink:0;">4</span>
                    <h2 class="mb-0" style="font-size:1.15rem;font-weight:700;color:#000;">Pembayaran & Integrasi Gateway</h2>
                </div>
                <ul class="list-unstyled">
                    <li class="p-3 mb-3" style="background:#fafafa;border:1px solid #000;border-radius:6px;">
                        <div class="fw-bold" style="color:#000;">Pertanyaan: Gateway apa yang aktif saat ini?</div>
                        <div style="color:#333;"><b>Pernyataan:</b> Pakasir terintegrasi sebagai gateway utama untuk QRIS dan Virtual Account. Midtrans tersedia sebagai opsi cadangan. Biaya transaksi Pakasir lebih rendah.</div>
                        <div style="color:#333;"><b>Jawaban:</b> Gunakan Pakasir sebagai primary gateway karena biaya kompetitif. Aktifkan Midtrans sebagai fallback jika user ingin metode kartu kredit atau metode lain yang tidak didukung Pakasir.</div>
                    </li>
                    <li class="p-3 mb-3" style="background:#fafafa;border:1px solid #000;border-radius:6px;">
                        <div class="fw-bold" style="color:#000;">Pertanyaan: Bagaimana alur webhook pembayaran?</div>
                        <div style="color:#333;"><b>Pernyataan:</b> Webhook dari gateway mengupdate status transaksi di database. Jika status approved, sistem mengaktivasi akses user secara otomatis. Namun ada jeda dan kadang webhook tidak sampai.</div>
                        <div style="color:#333;"><b>Jawaban:</b> Implementasikan retry mechanism untuk webhook yang gagal. Tambahkan fallback: user bisa cek status manual via tombol "Cek Pembayaran". Admin juga punya akses approve manual jika diperlukan.</div>
                    </li>
                    <li class="p-3 mb-3" style="background:#fafafa;border:1px solid #000;border-radius:6px;">
                        <div class="fw-bold" style="color:#000;">Pertanyaan: Kapan saldo menit atau langganan aktif setelah bayar?</div>
                        <div style="color:#333;"><b>Pernyataan:</b> Aktivasi terjadi saat webhook mengupdate status menjadi approved. Idealnya dalam hitungan detik, tetapi bisa tertunda jika webhook lambat.</div>
                        <div style="color:#333;"><b>Jawaban:</b> Target aktivasi otomatis kurang dari 5 detik. Jika lebih dari 2 menit, trigger notifikasi ke admin. Sediakan halaman status transaksi real-time agar user tidak bingung.</div>
                    </li>
                    <li class="p-3 mb-3" style="background:#fafafa;border:1px solid #000;border-radius:6px;">
                        <div class="fw-bold" style="color:#000;">Pertanyaan: Apakah perlu sistem auto-billing untuk langganan?</div>
                        <div style="color:#333;"><b>Pernyataan:</b> Langganan saat ini tidak otomatis memperpanjang. User harus membeli ulang setiap periode. Ini menyebabkan churn tinggi karena user lupa.</div>
                        <div style="color:#333;"><b>Jawaban:</b> Jika gateway mendukung recurring payment, aktifkan auto-billing. Jika tidak, kirim reminder email 3 hari sebelum masa berlaku habis dengan link pembayaran langsung.</div>
                    </li>
                    <li class="p-3 mb-3" style="background:#fafafa;border:1px solid #000;border-radius:6px;">
                        <div class="fw-bold" style="color:#000;">Pertanyaan: Bagaimana penanganan dispute atau chargeback?</div>
                        <div style="color:#333;"><b>Pernyataan:</b> Belum pernah mengalami dispute. Prosedur penanganan belum terdokumentasi.</div>
                        <div style="color:#333;"><b>Jawaban:</b> Buat SOP dispute: kumpulkan bukti transaksi, bukti akses user, dan komunikasi dengan gateway. Simpan log lengkap setiap transaksi untuk keperluan audit dan dispute.</div>
                    </li>
                    <li class="p-3 mb-3" style="background:#fafafa;border:1px solid #000;border-radius:6px;">
                        <div class="fw-bold" style="color:#000;">Pertanyaan: Perhitungan pajak untuk setiap transaksi?</div>
                        <div style="color:#333;"><b>Pernyataan:</b> Belum ada kalkulasi PPN atau PPh per transaksi. Harga yang ditampilkan adalah harga final tanpa breakdown pajak.</div>
                        <div style="color:#333;"><b>Jawaban:</b> Konsultasi dengan akuntan untuk kewajiban pajak digital. Siapkan sistem yang mencatat semua transaksi dengan detail untuk pelaporan SPT. Jika omzet sudah di atas 4,8 miliar, wajib PPN.</div>
                    </li>
                </ul>
            </div>

            <!-- BAGIAN 5: PEMASARAN & AKUISISI -->
            <div class="section">
                <div class="d-flex align-items-center gap-2 mb-4 pb-2" style="border-bottom:2px solid #000;">
                    <span style="display:flex;align-items:center;justify-content:center;width:32px;height:32px;background:#000;color:#fff;font-weight:700;font-size:0.85rem;border-radius:8px;flex-shrink:0;">5</span>
                    <h2 class="mb-0" style="font-size:1.15rem;font-weight:700;color:#000;">Pemasaran & Akuisisi</h2>
                </div>
                <ul class="list-unstyled">
                    <li class="p-3 mb-3" style="background:#fafafa;border:1px solid #000;border-radius:6px;">
                        <div class="fw-bold" style="color:#000;">Pertanyaan: Channel utama untuk akuisisi user?</div>
                        <div style="color:#333;"><b>Pernyataan:</b> TikTok dan Instagram untuk awareness, SEO untuk long-tail. Iklan berbayar masih kecil karena budget terbatas.</div>
                        <div style="color:#333;"><b>Jawaban:</b> Fokus pada 1-2 channel dulu. TikTok cocok untuk konten pendek yang viral. YouTube untuk konten edukasi depth. SEO adalah investasi jangka panjang yang harus dimulai sekarang.</div>
                    </li>
                    <li class="p-3 mb-3" style="background:#fafafa;border:1px solid #000;border-radius:6px;">
                        <div class="fw-bold" style="color:#000;">Pertanyaan: Apakah pakai affiliate atau referral program?</div>
                        <div style="color:#333;"><b>Pernyataan:</b> Tabel affiliates, affiliate_clicks, dan affiliate_conversions sudah ada di database. Frontend referral belum dibangun.</div>
                        <div style="color:#333;"><b>Jawaban:</b> Bangun program referral dengan komisi jelas: 10-20% untuk referrer, kode referral unik, dan dashboard tracking. Program referral adalah channel akuisisi biaya rendah yang efektif.</div>
                    </li>
                    <li class="p-3 mb-3" style="background:#fafafa;border:1px solid #000;border-radius:6px;">
                        <div class="fw-bold" style="color:#000;">Pertanyaan: Bagaimana mengukur ROI iklan?</div>
                        <div style="color:#333;"><b>Pernyataan:</b> GA4 dan Meta Pixel sudah dipasang di header. Namun conversion event belum dioptimalkan untuk tracking end-to-end.</div>
                        <div style="color:#333;"><b>Jawaban:</b> Pasang conversion event di halaman konfirmasi pembayaran. Lacak dari klik iklan → landing → checkout → bayar → aktivasi. Hitung CAC (Customer Acquisition Cost) per channel.</div>
                    </li>
                    <li class="p-3 mb-3" style="background:#fafafa;border:1px solid #000;border-radius:6px;">
                        <div class="fw-bold" style="color:#000;">Pertanyaan: Konten gratis sebagai funnel penjualan?</div>
                        <div style="color:#333;"><b>Pernyataan:</b> Beberapa course dan lesson gratis (is_free=1) untuk memberikan trial kepada user. Tapi belum ada strategi upsell yang sistematis.</div>
                        <div style="color:#333;"><b>Jawaban:</b> Gunakan free lesson sebagai lead magnet. Setelah user selesai menonton, tampilkan CTA untuk membuka lesson berikutnya dengan berlangganan. Email follow-up otomatis untuk user yang sudah mencoba konten gratis.</div>
                    </li>
                    <li class="p-3 mb-3" style="background:#fafafa;border:1px solid #000;border-radius:6px;">
                        <div class="fw-bold" style="color:#000;">Pertanyaan: Email marketing, perlukah drip sequence?</div>
                        <div style="color:#333;"><b>Pernyataan:</b> SMTP atau Mailgun sudah terkonfigurasi tetapi hanya digunakan untuk notifikasi transaksional, bukan marketing.</div>
                        <div style="color:#333;"><b>Jawaban:</b> Buat drip sequence: email selamat datang (hari 1), rekomendasi kursus (hari 3), diskon terbatas (hari 7), re-engagement (hari 30). Segmentasi berdasarkan perilaku user untuk relevansi lebih tinggi.</div>
                    </li>
                    <li class="p-3 mb-3" style="background:#fafafa;border:1px solid #000;border-radius:6px;">
                        <div class="fw-bold" style="color:#000;">Pertanyaan: Strategi konten organik (SEO)?</div>
                        <div style="color:#333;"><b>Pernyataan:</b> SEO belum dioptimalkan. Meta description, alt text gambar, dan struktur heading masih seadanya.</div>
                        <div style="color:#333;"><b>Jawaban:</b> Optimasi on-page: title unik, meta description, heading hierarchy, schema markup untuk course. Buat blog atau artikel yang menargetkan keyword long-tail seperti "cara belajar coding untuk pemula".</div>
                    </li>
                </ul>
            </div>

            <!-- BAGIAN 6: LEGALITAS & KEPATUHAN -->
            <div class="section">
                <div class="d-flex align-items-center gap-2 mb-4 pb-2" style="border-bottom:2px solid #000;">
                    <span style="display:flex;align-items:center;justify-content:center;width:32px;height:32px;background:#000;color:#fff;font-weight:700;font-size:0.85rem;border-radius:8px;flex-shrink:0;">6</span>
                    <h2 class="mb-0" style="font-size:1.15rem;font-weight:700;color:#000;">Legalitas & Kepatuhan</h2>
                </div>
                <ul class="list-unstyled">
                    <li class="p-3 mb-3" style="background:#fafafa;border:1px solid #000;border-radius:6px;">
                        <div class="fw-bold" style="color:#000;">Pertanyaan: Apakah perlu badan hukum (PT atau CV)?</div>
                        <div style="color:#333;"><b>Pernyataan:</b> Saat ini berjalan secara perorangan. Risiko: aset pribadi tidak terpisah, kesulitan kerja sama B2B, dan masalah pajak.</div>
                        <div style="color:#333;"><b>Jawaban:</b> Urus PT Perorangan (UU Cipta Kerja) sebagai langkah awal. Prosesnya cepat, biaya terjangkau, dan memberikan perlindungan hukum serta kemudahan administrasi pajak dan partnership.</div>
                    </li>
                    <li class="p-3 mb-3" style="background:#fafafa;border:1px solid #000;border-radius:6px;">
                        <div class="fw-bold" style="color:#000;">Pertanyaan: Hak cipta konten kursus milik siapa?</div>
                        <div style="color:#333;"><b>Pernyataan:</b> Konten dibuat internal oleh tim. Namun tidak ada perjanjian tertulis dengan kontributor atau freelancer tentang kepemilikan hak cipta.</div>
                        <div style="color:#333;"><b>Jawaban:</b> Buat kontrak kerja sama yang jelas: konten yang dibuat untuk platform menjadi milik platform (dengan lisensi penggunaan kepada guru). Cantumkan klausul royalti dan larangan distribusi ulang di platform lain.</div>
                    </li>
                    <li class="p-3 mb-3" style="background:#fafafa;border:1px solid #000;border-radius:6px;">
                        <div class="fw-bold" style="color:#000;">Pertanyaan: Kepatuhan terhadap UU Perlindungan Data Pribadi (PDP)?</div>
                        <div style="color:#333;"><b>Pernyataan:</b> Data pengguna disimpan di MySQL tanpa enkripsi untuk data sensitif selain password. Belum ada kebijakan privasi yang ditampilkan.</div>
                        <div style="color:#333;"><b>Jawaban:</b> Enkripsi data sensitif: email, nomor telepon, alamat. Buat halaman Privacy Policy yang menjelaskan data apa yang dikumpulkan, tujuan, dan hak user. Minta consent eksplisit saat pendaftaran.</div>
                    </li>
                    <li class="p-3 mb-3" style="background:#fafafa;border:1px solid #000;border-radius:6px;">
                        <div class="fw-bold" style="color:#000;">Pertanyaan: Apakah perlu Terms of Service?</div>
                        <div style="color:#333;"><b>Pernyataan:</b> Belum ada ToS yang ditampilkan saat pendaftaran atau checkout. Risiko: jika ada sengketa, tidak ada dasar hukum yang jelas.</div>
                        <div style="color:#333;"><b>Jawaban:</b> Buat ToS yang mencakup: hak dan kewajiban user, aturan penggunaan konten, kebijakan refund, batasan tanggung jawab, dan hukum yang berlaku. Wajib dicentang user saat daftar.</div>
                    </li>
                    <li class="p-3 mb-3" style="background:#fafafa;border:1px solid #000;border-radius:6px;">
                        <div class="fw-bold" style="color:#000;">Pertanyaan: Kewajiban perpajakan untuk bisnis digital?</div>
                        <div style="color:#333;"><b>Pernyataan:</b> Belum ada perhitungan dan pelaporan pajak untuk transaksi digital yang masuk.</div>
                        <div style="color:#333;"><b>Jawaban:</b> Konsultasi dengan akuntan. Siapkan sistem pencatatan yang rapi. Jika omzet di bawah 4,8 miliar, PPh final 0,5% (PP 23). Jika ada penjualan ke pemerintah, potong PPN dan PPh 23.</div>
                    </li>
                    <li class="p-3 mb-3" style="background:#fafafa;border:1px solid #000;border-radius:6px;">
                        <div class="fw-bold" style="color:#000;">Pertanyaan: Asuransi untuk risiko bisnis?</div>
                        <div style="color:#333;"><b>Pernyataan:</b> Tidak ada asurasi yang melindungi aset digital atau risiko operasional.</div>
                        <div style="color:#333;"><b>Jawaban:</b> Pertimbangkan asuransi properti (server, perangkat) dan asuransi cyber liability jika trafik dan nilai transaksi sudah besar. Untuk tahap awal, fokus pada pencegahan (backup, keamanan).</div>
                    </li>
                </ul>
            </div>

            <!-- BAGIAN 7: ORGANISASI & SDM -->
            <div class="section">
                <div class="d-flex align-items-center gap-2 mb-4 pb-2" style="border-bottom:2px solid #000;">
                    <span style="display:flex;align-items:center;justify-content:center;width:32px;height:32px;background:#000;color:#fff;font-weight:700;font-size:0.85rem;border-radius:8px;flex-shrink:0;">7</span>
                    <h2 class="mb-0" style="font-size:1.15rem;font-weight:700;color:#000;">Organisasi & SDM</h2>
                </div>
                <ul class="list-unstyled">
                    <li class="p-3 mb-3" style="background:#fafafa;border:1px solid #000;border-radius:6px;">
                        <div class="fw-bold" style="color:#000;">Pertanyaan: Struktur tim saat ini seperti apa?</div>
                        <div style="color:#333;"><b>Pernyataan:</b> Owner merangkap semua peran: developer, content creator, marketing, customer support. Tidak ada delegasi yang jelas.</div>
                        <div style="color:#333;"><b>Jawaban:</b> Buat struktur minimal: owner (strategi + bisdev), 1 developer (maintenance + fitur baru), 1 content creator (produksi konten), 1 admin (support + operasional). Mulai dengan part-time atau freelancer untuk masing-masing peran.</div>
                    </li>
                    <li class="p-3 mb-3" style="background:#fafafa;border:1px solid #000;border-radius:6px;">
                        <div class="fw-bold" style="color:#000;">Pertanyaan: Kapan saatnya merekrut karyawan tetap?</div>
                        <div style="color:#333;"><b>Pernyataan:</b> Belum ada karyawan tetap. Freelancer dipekerjakan per proyek jika ada kebutuhan spesifik.</div>
                        <div style="color:#333;"><b>Jawaban:</b> Rekrut tetap ketika pendapatan bulanan stabil > 3 kali gaji yang akan diberikan. Prioritaskan rekrut untuk peran yang paling menyita waktu owner agar bisa fokus pada pengembangan.</div>
                    </li>
                    <li class="p-3 mb-3" style="background:#fafafa;border:1px solid #000;border-radius:6px;">
                        <div class="fw-bold" style="color:#000;">Pertanyaan: Apakah perlu SOP tertulis?</div>
                        <div style="color:#333;"><b>Pernyataan:</b> SOP ada di kepala masing-masing, belum terdokumentasi. Jika ada anggota tim baru, proses onboarding tidak terstruktur.</div>
                        <div style="color:#333;"><b>Jawaban:</b> Dokumentasi SOP secara bertahap. Mulai dari alur paling kritis: penanganan transaksi, aktivasi user, penanganan komplain, dan publikasi konten. Gunakan platform knowledge base internal.</div>
                    </li>
                    <li class="p-3 mb-3" style="background:#fafafa;border:1px solid #000;border-radius:6px;">
                        <div class="fw-bold" style="color:#000;">Pertanyaan: Tools komunikasi dan project management?</div>
                        <div style="color:#333;"><b>Pernyataan:</b> WhatsApp grup untuk komunikasi, Git untuk version control code. Tidak ada tool untuk task tracking atau dokumentasi bersama.</div>
                        <div style="color:#333;"><b>Jawaban:</b> Gunakan Trello atau Asana untuk task management. Slack atau Discord untuk komunikasi terstruktur per kanal. Notion untuk dokumentasi bersama. Integrasikan semuanya agar tidak terpisah-pisah.</div>
                    </li>
                    <li class="p-3 mb-3" style="background:#fafafa;border:1px solid #000;border-radius:6px;">
                        <div class="fw-bold" style="color:#000;">Pertanyaan: Sistem kompensasi seperti apa?</div>
                        <div style="color:#333;"><b>Pernyataan:</b> Freelancer dibayar per proyek atau per jam. Tidak ada sistem bonus, insentif, atau benefit lain.</div>
                        <div style="color:#333;"><b>Jawaban:</b> Untuk karyawan tetap: gaji pokok + tunjangan komunikasi + bonus performa bulanan. Untuk freelancer: fee kompetitif + bonus jika proyek selesai sebelum deadline. Pertimbangkan opsi saham atau profit-sharing untuk talenta kunci.</div>
                    </li>
                    <li class="p-3 mb-3" style="background:#fafafa;border:1px solid #000;border-radius:6px;">
                        <div class="fw-bold" style="color:#000;">Pertanyaan: Frekuensi meeting dan reporting?</div>
                        <div style="color:#333;"><b>Pernyataan:</b> Meeting tidak terjadwal. Komunikasi terjadi secara ad-hoc via chat. Tidak ada laporan berkala.</div>
                        <div style="color:#333;"><b>Jawaban:</b> Daily standup 15 menit via chat untuk sync. Weekly meeting 30 menit via video call untuk review progress dan blocking. Monthly retrospective 1 jam untuk evaluasi besar. Dokumentasikan keputusan di setiap meeting.</div>
                    </li>
                </ul>
            </div>

            <!-- BAGIAN 8: METRIK & EVALUASI -->
            <div class="section">
                <div class="d-flex align-items-center gap-2 mb-4 pb-2" style="border-bottom:2px solid #000;">
                    <span style="display:flex;align-items:center;justify-content:center;width:32px;height:32px;background:#000;color:#fff;font-weight:700;font-size:0.85rem;border-radius:8px;flex-shrink:0;">8</span>
                    <h2 class="mb-0" style="font-size:1.15rem;font-weight:700;color:#000;">Metrik & Evaluasi</h2>
                </div>
                <ul class="list-unstyled">
                    <li class="p-3 mb-3" style="background:#fafafa;border:1px solid #000;border-radius:6px;">
                        <div class="fw-bold" style="color:#000;">Pertanyaan: Metrik apa yang perlu dimonitor harian?</div>
                        <div style="color:#333;"><b>Pernyataan:</b> Saat ini hanya melihat pendapatan total di dashboard admin. Tidak ada pemantauan harian yang terstruktur.</div>
                        <div style="color:#333;"><b>Jawaban:</b> Pantau setiap hari: jumlah user baru, transaksi pending, transaksi gagal, transaksi lunas, dan error log. Buat dashboard sederhana yang menampilkan metrik ini dalam satu halaman.</div>
                    </li>
                    <li class="p-3 mb-3" style="background:#fafafa;border:1px solid #000;border-radius:6px;">
                        <div class="fw-bold" style="color:#000;">Pertanyaan: Metrik mingguan dan bulanan?</div>
                        <div style="color:#333;"><b>Pernyataan:</b> Belum ada dashboard analitik yang menampilkan tren mingguan atau bulanan. Data mentah ada di database tetapi tidak divisualisasikan.</div>
                        <div style="color:#333;"><b>Jawaban:</b> Lacak mingguan: active users, conversion rate (kunjungan → registrasi → bayar), revenue. Lacak bulanan: MRR (Monthly Recurring Revenue), churn rate, LTV (Lifetime Value), CAC (Customer Acquisition Cost), gross margin.</div>
                    </li>
                    <li class="p-3 mb-3" style="background:#fafafa;border:1px solid #000;border-radius:6px;">
                        <div class="fw-bold" style="color:#000;">Pertanyaan: Bagaimana mengukur customer satisfaction?</div>
                        <div style="color:#333;"><b>Pernyataan:</b> Belum ada survey NPS (Net Promoter Score) atau feedback form. Kepuasan user hanya diketahui dari chat langsung.</div>
                        <div style="color:#333;"><b>Jawaban:</b> Kirim survey singkat (1-3 pertanyaan) setelah user menyelesaikan kursus atau 1 minggu setelah aktivasi. Gunakan skala 1-5 untuk rating. Tanyakan "Apa yang paling membantu?" dan "Apa yang perlu diperbaiki?"</div>
                    </li>
                    <li class="p-3 mb-3" style="background:#fafafa;border:1px solid #000;border-radius:6px;">
                        <div class="fw-bold" style="color:#000;">Pertanyaan: Evaluasi kompetitor?</div>
                        <div style="color:#333;"><b>Pernyataan:</b> Tidak ada proses formal untuk memantau kompetitor. Informasi didapat secara kebetulan dari media sosial atau iklan.</div>
                        <div style="color:#333;"><b>Jawaban:</b> Buat daftar kompetitor langsung (Ruangguru, Zenius, Skill Academy) dan tidak langsung (YouTube, Coursera). Pantau harga, fitur baru, dan strategi marketing mereka setiap kuartal.</div>
                    </li>
                    <li class="p-3 mb-3" style="background:#fafafa;border:1px solid #000;border-radius:6px;">
                        <div class="fw-bold" style="color:#000;">Pertanyaan: Seberapa sering perlu evaluasi produk?</div>
                        <div style="color:#333;"><b>Pernyataan:</b> Tidak ada jadwal evaluasi formal. Produk dikembangkan berdasarkan permintaan yang muncul mendadak.</div>
                        <div style="color:#333;"><b>Jawaban:</b> Adakan retrospektif bulanan: apa yang berjalan baik, apa yang tidak, apa prioritas bulan depan. Libatkan seluruh tim. Dokumentasikan keputusan dan follow-up action items.</div>
                    </li>
                    <li class="p-3 mb-3" style="background:#fafafa;border:1px solid #000;border-radius:6px;">
                        <div class="fw-bold" style="color:#000;">Pertanyaan: Tools analitik dan reporting?</div>
                        <div style="color:#333;"><b>Pernyataan:</b> GA4 dan Meta Pixel sudah terpasang untuk tracking pengunjung. Namun data transaksi tidak terintegrasi dengan tools ini.</div>
                        <div style="color:#333;"><b>Jawaban:</b> Buat admin dashboard sendiri dengan chart: tren pendapatan, user aktif, transaksi per metode bayar. Jika budget ada, integrasikan dengan Google Data Studio untuk visualisasi yang lebih advance.</div>
                    </li>
                </ul>
            </div>

            <!-- BAGIAN 9: UI/UX & AKSESIBILITAS -->
            <div class="section">
                <div class="d-flex align-items-center gap-2 mb-4 pb-2" style="border-bottom:2px solid #000;">
                    <span style="display:flex;align-items:center;justify-content:center;width:32px;height:32px;background:#000;color:#fff;font-weight:700;font-size:0.85rem;border-radius:8px;flex-shrink:0;">9</span>
                    <h2 class="mb-0" style="font-size:1.15rem;font-weight:700;color:#000;">UI/UX & Aksesibilitas</h2>
                </div>
                <ul class="list-unstyled">
                    <li class="p-3 mb-3" style="background:#fafafa;border:1px solid #000;border-radius:6px;">
                        <div class="fw-bold" style="color:#000;">Pertanyaan: Apakah dark mode diperlukan?</div>
                        <div style="color:#333;"><b>Pernyataan:</b> CSS dark mode sudah ada di file tema tetapi belum diaktifkan secara default atau toggleable oleh user.</div>
                        <div style="color:#333;"><b>Jawaban:</b> Aktifkan toggle dark/light mode di header. Simpan preferensi di localStorage. Dark mode penting untuk kenyamanan belajar di malam hari dan mengurangi mata lelah.</div>
                    </li>
                    <li class="p-3 mb-3" style="background:#fafafa;border:1px solid #000;border-radius:6px;">
                        <div class="fw-bold" style="color:#000;">Pertanyaan: Login sosial (Google, Facebook) perlu?</div>
                        <div style="color:#333;"><b>Pernyataan:</b> Registrasi hanya via email dan password. Banyak user enggan daftar karena harus isi form panjang.</div>
                        <div style="color:#333;"><b>Jawaban:</b> Integrasikan login dengan Google (OAuth) sebagai opsi. Ini menurunkan friction registrasi secara signifikan. Facebook dan Apple ID bisa menyusul.</div>
                    </li>
                    <li class="p-3 mb-3" style="background:#fafafa;border:1px solid #000;border-radius:6px;">
                        <div class="fw-bold" style="color:#000;">Pertanyaan: Optimalisasi mobile experience?</div>
                        <div style="color:#333;"><b>Pernyataan:</b> Website sudah responsive dengan Bootstrap. Namun navigasi mobile masih kurang intuitif, terutama di halaman kursus dan player video.</div>
                        <div style="color:#333;"><b>Jawaban:</b> Prioritaskan mobile-first design. Simplifikasi navigasi, perbesar touch target, optimalkan player video untuk layar kecil. Tes di berbagai perangkat (Android, iOS) secara berkala.</div>
                    </li>
                    <li class="p-3 mb-3" style="background:#fafafa;border:1px solid #000;border-radius:6px;">
                        <div class="fw-bold" style="color:#000;">Pertanyaan: User onboarding flow?</div>
                        <div style="color:#333;"><b>Pernyataan:</b> Setelah registrasi, user langsung diarahkan ke halaman utama tanpa panduan. Banyak user baru bingung harus mulai dari mana.</div>
                        <div style="color:#333;"><b>Jawaban:</b> Buat onboarding interaktif: sambutan → pilih minat → rekomendasi kursus → coba lesson gratis. Progress bar onboarding untuk memandu langkah demi langkah.</div>
                    </li>
                    <li class="p-3 mb-3" style="background:#fafafa;border:1px solid #000;border-radius:6px;">
                        <div class="fw-bold" style="color:#000;">Pertanyaan: Aksesibilitas untuk penyandang disabilitas?</div>
                        <div style="color:#333;"><b>Pernyataan:</b> Belum ada pertimbangan aksesibilitas. Alt text pada gambar sering kosong, kontras warna mungkin kurang.</div>
                        <div style="color:#333;"><b>Jawaban:</b> Ikuti standar WCAG 2.1 level AA: kontras rasio 4.5:1, alt text deskriptif, navigasi keyboard, label form yang jelas. Caption pada video untuk tuna rungu.</div>
                    </li>
                    <li class="p-3 mb-3" style="background:#fafafa;border:1px solid #000;border-radius:6px;">
                        <div class="fw-bold" style="color:#000;">Pertanyaan: A/B testing untuk konversi?</div>
                        <div style="color:#333;"><b>Pernyataan:</b> Tidak ada A/B testing. Semua perubahan dilakukan berdasarkan intuisi atau permintaan user.</div>
                        <div style="color:#333;"><b>Jawaban:</b> Mulai A/B testing sederhana: uji 2 versi harga, 2 versi CTA button, atau 2 versi landing page. Gunakan data untuk memutuskan perubahan, bukan asumsi.</div>
                    </li>
                </ul>
            </div>

            <!-- BAGIAN 10: DUKUNGAN PELANGGAN -->
            <div class="section">
                <div class="d-flex align-items-center gap-2 mb-4 pb-2" style="border-bottom:2px solid #000;">
                    <span style="display:flex;align-items:center;justify-content:center;width:32px;height:32px;background:#000;color:#fff;font-weight:700;font-size:0.85rem;border-radius:8px;flex-shrink:0;">10</span>
                    <h2 class="mb-0" style="font-size:1.15rem;font-weight:700;color:#000;">Dukungan Pelanggan</h2>
                </div>
                <ul class="list-unstyled">
                    <li class="p-3 mb-3" style="background:#fafafa;border:1px solid #000;border-radius:6px;">
                        <div class="fw-bold" style="color:#000;">Pertanyaan: Channel customer support yang aktif?</div>
                        <div style="color:#333;"><b>Pernyataan:</b> WhatsApp nomor admin untuk support langsung. Email kadang digunakan untuk pertanyaan formal. Tidak ada SLA yang jelas.</div>
                        <div style="color:#333;"><b>Jawaban:</b> Gunakan WhatsApp Business API untuk support terstruktur. Buat SLA: respon pertama < 1 jam (jam kerja), < 8 jam (di luar jam kerja). Siapkan template jawaban untuk pertanyaan umum.</div>
                    </li>
                    <li class="p-3 mb-3" style="background:#fafafa;border:1px solid #000;border-radius:6px;">
                        <div class="fw-bold" style="color:#000;">Pertanyaan: Apakah perlu FAQ atau knowledge base?</div>
                        <div style="color:#333;"><b>Pernyataan:</b> Tidak ada halaman FAQ. Pertanyaan yang sama muncul berulang kali dari user berbeda.</div>
                        <div style="color:#333;"><b>Jawaban:</b> Buat halaman FAQ yang mencakup: cara daftar, cara bayar, cara akses kursus, cara refund, cara hubungi support. Update FAQ secara berkala berdasarkan pertanyaan yang paling sering muncul.</div>
                    </li>
                    <li class="p-3 mb-3" style="background:#fafafa;border:1px solid #000;border-radius:6px;">
                        <div class="fw-bold" style="color:#000;">Pertanyaan: Sistem ticketing untuk komplain?</div>
                        <div style="color:#333;"><b>Pernyataan:</b> Komplain ditangani secara informal via chat. Tidak ada tracking apakah komplain sudah selesai atau belum.</div>
                        <div style="color:#333;"><b>Jawaban:</b> Implementasi sistem ticketing sederhana: user buat tiket, admin assign, tiket tertutup saat selesai. Beri user akses melihat status tiket mereka. Tools seperti Freshdesk gratis untuk tahap awal.</div>
                    </li>
                    <li class="p-3 mb-3" style="background:#fafafa;border:1px solid #000;border-radius:6px;">
                        <div class="fw-bold" style="color:#000;">Pertanyaan: Bagaimana feedback loop dari user ke produk?</div>
                        <div style="color:#333;"><b>Pernyataan:</b> Feedback diterima secara pasif (user chat). Tidak ada sistem untuk mengumpulkan, mengkategorisasi, dan menindaklanjuti feedback.</div>
                        <div style="color:#333;"><b>Jawaban:</b> Kategorikan feedback: bug, feature request, complaint. Review mingguan dan prioritaskan berdasarkan dampak dan effort. Beri tahu user jika feedback mereka ditindaklanjuti.</div>
                    </li>
                    <li class="p-3 mb-3" style="background:#fafafa;border:1px solid #000;border-radius:6px;">
                        <div class="fw-bold" style="color:#000;">Pertanyaan: Prosedur eskalasi untuk masalah kritis?</div>
                        <div style="color:#333;"><b>Pernyataan:</b> Tidak ada prosedur eskalasi. Masalah kritis (server down, data error) ditangani oleh siapa yang melihat pertama kali.</div>
                        <div style="color:#333;"><b>Jawaban:</b> Buat level eskalasi: L1 (admin support) untuk masalah umum, L2 (developer) untuk masalah teknis, L3 (owner) untuk keputusan strategis. Target resolusi per level: L1 < 4 jam, L2 < 24 jam, L3 < 48 jam.</div>
                    </li>
                    <li class="p-3 mb-3" style="background:#fafafa;border:1px solid #000;border-radius:6px;">
                        <div class="fw-bold" style="color:#000;">Pertanyaan: Fitur self-service untuk user?</div>
                        <div style="color:#333;"><b>Pernyataan:</b> User bisa melihat riwayat transaksi dan status langganan. Namun tidak bisa membatalkan langganan atau mengubah paket sendiri.</div>
                        <div style="color:#333;"><b>Jawaban:</b> Tambahkan fitur self-service: cancel subscription, change plan, download invoice, update profil. Semakin banyak yang bisa dilakukan user tanpa bantuan admin, semakin efisien operasional.</div>
                    </li>
                </ul>
            </div>

            <!-- BAGIAN 11: PETA JALAN & MASA DEPAN -->
            <div class="section">
                <div class="d-flex align-items-center gap-2 mb-4 pb-2" style="border-bottom:2px solid #000;">
                    <span style="display:flex;align-items:center;justify-content:center;width:32px;height:32px;background:#000;color:#fff;font-weight:700;font-size:0.85rem;border-radius:8px;flex-shrink:0;">11</span>
                    <h2 class="mb-0" style="font-size:1.15rem;font-weight:700;color:#000;">Peta Jalan & Masa Depan</h2>
                </div>
                <ul class="list-unstyled">
                    <li class="p-3 mb-3" style="background:#fafafa;border:1px solid #000;border-radius:6px;">
                        <div class="fw-bold" style="color:#000;">Pertanyaan: Fitur AI apa yang relevan untuk platform?</div>
                        <div style="color:#333;"><b>Pernyataan:</b> Belum ada fitur AI. Semua konten dan interaksi bersifat statis dan manual.</div>
                        <div style="color:#333;"><b>Jawaban:</b> Pertimbangkan AI Tutor untuk menjawab pertanyaan siswa secara real-time, rekomendasi konten personal berdasarkan minat dan riwayat belajar, serta auto-generate quiz dari materi. Mulai dengan integrasi API OpenAI untuk chat assistant.</div>
                    </li>
                    <li class="p-3 mb-3" style="background:#fafafa;border:1px solid #000;border-radius:6px;">
                        <div class="fw-bold" style="color:#000;">Pertanyaan: Gamifikasi untuk meningkatkan engagement?</div>
                        <div style="color:#333;"><b>Pernyataan:</b> Tidak ada elemen gamifikasi selain progress bar lesson. Tidak ada poin, badge, atau leaderboard.</div>
                        <div style="color:#333;"><b>Jawaban:</b> Implementasi gamifikasi bertahap: poin XP untuk setiap lesson selesai, badge untuk pencapaian (streak 7 hari, 10 kursus selesai), leaderboard mingguan. Gamifikasi meningkatkan retensi dan motivasi belajar.</div>
                    </li>
                    <li class="p-3 mb-3" style="background:#fafafa;border:1px solid #000;border-radius:6px;">
                        <div class="fw-bold" style="color:#000;">Pertanyaan: Live class atau webinar?</div>
                        <div style="color:#333;"><b>Pernyataan:</b> Semua konten bersifat on-demand (rekaman). Tidak ada sesi live.</div>
                        <div style="color:#333;"><b>Jawaban:</b> Tambahkan sesi live berkala: Q&A dengan guru, workshop, webinar tamu. Live class meningkatkan engagement dan memberikan nilai tambah dibanding platform lain. Rekaman live class bisa menjadi konten on-demand baru.</div>
                    </li>
                    <li class="p-3 mb-3" style="background:#fafafa;border:1px solid #000;border-radius:6px;">
                        <div class="fw-bold" style="color:#000;">Pertanyaan: Fitur microlearning (content singkat)?</div>
                        <div style="color:#333;"><b>Pernyataan:</b> Durasi video bervariasi 5-30 menit. Belum ada format microlearning khusus yang terstruktur.</div>
                        <div style="color:#333;"><b>Jawaban:</b> Buat format microlearning: video 2-5 menit per topik, fokus satu konsep, dilengkapi flashcard dan quick quiz. Microlearning cocok untuk user mobile yang belajar di sela-sela waktu.</div>
                    </li>
                    <li class="p-3 mb-3" style="background:#fafafa;border:1px solid #000;border-radius:6px;">
                        <div class="fw-bold" style="color:#000;">Pertanyaan: Sertifikat digital (blockchain)?</div>
                        <div style="color:#333;"><b>Pernyataan:</b> Sertifikat bisa di-generate sebagai PDF biasa. Tidak ada verifikasi digital.</div>
                        <div style="color:#333;"><b>Jawaban:</b> Untuk tahap awal, sertifikat PDF dengan QR code verifikasi sudah cukup. Blockchain certificate bisa dipertimbangkan untuk kursus premium yang membutuhkan keaslian tinggi.</div>
                    </li>
                    <li class="p-3 mb-3" style="background:#fafafa;border:1px solid #000;border-radius:6px;">
                        <div class="fw-bold" style="color:#000;">Pertanyaan: Market expansion: kursus untuk perusahaan?</div>
                        <div style="color:#333;"><b>Pernyataan:</b> Fokus saat ini adalah B2C (langsung ke siswa). Belum melayani B2B atau corporate training.</div>
                        <div style="color:#333;"><b>Jawaban:</b> Kembangkan paket corporate training untuk perusahaan. Fitur: admin perusahaan bisa manage akun karyawan, laporan progress, dan invoice terpusat. Ini membuka segmen pendapatan baru yang lebih stabil.</div>
                    </li>
                </ul>
            </div>

            <!-- BAGIAN 12: KOLABORASI & KEMITRAAN -->
            <div class="section">
                <div class="d-flex align-items-center gap-2 mb-4 pb-2" style="border-bottom:2px solid #000;">
                    <span style="display:flex;align-items:center;justify-content:center;width:32px;height:32px;background:#000;color:#fff;font-weight:700;font-size:0.85rem;border-radius:8px;flex-shrink:0;">12</span>
                    <h2 class="mb-0" style="font-size:1.15rem;font-weight:700;color:#000;">Kolaborasi & Kemitraan</h2>
                </div>
                <ul class="list-unstyled">
                    <li class="p-3 mb-3" style="background:#fafafa;border:1px solid #000;border-radius:6px;">
                        <div class="fw-bold" style="color:#000;">Pertanyaan: Peluang kemitraan dengan institusi pendidikan?</div>
                        <div style="color:#333;"><b>Pernyataan:</b> Belum ada kerja sama formal dengan sekolah, universitas, atau lembaga pelatihan.</div>
                        <div style="color:#333;"><b>Jawaban:</b> Tawarkan white-label platform ke sekolah atau universitas. Mereka bisa menggunakan platform dengan branding sendiri, konten bisa dari kita atau mereka. Model revenue: biaya lisensi per tahun atau bagi hasil.</div>
                    </li>
                    <li class="p-3 mb-3" style="background:#fafafa;border:1px solid #000;border-radius:6px;">
                        <div class="fw-bold" style="color:#000;">Pertanyaan: Program afiliasi untuk content creator?</div>
                        <div style="color:#333;"><b>Pernyataan:</b> Tabel afiliasi sudah siap di database. Belum ada frontend untuk mendaftar sebagai afiliasi.</div>
                        <div style="color:#333;"><b>Jawaban:</b> Bangun halaman daftar afiliasi: daftar gratis, dapatkan link unik, komisi 15-25% dari setiap penjualan melalui link. Afiliasi bisa berupa content creator, blogger, atau influencer kecil.</div>
                    </li>
                    <li class="p-3 mb-3" style="background:#fafafa;border:1px solid #000;border-radius:6px;">
                        <div class="fw-bold" style="color:#000;">Pertanyaan: Job placement atau talent pool?</div>
                        <div style="color:#333;"><b>Pernyataan:</b> Tidak ada program penyaluran kerja bagi lulusan kursus.</div>
                        <div style="color:#333;"><b>Jawaban:</b> Bangun talent pool: perusahaan bisa mencari lulusan berdasarkan skill. Ini menjadi nilai jual utama: "Belajar sampai dapat kerja". Kerja sama dengan HR agency atau perusahaan tech untuk placement.</div>
                    </li>
                    <li class="p-3 mb-3" style="background:#fafafa;border:1px solid #000;border-radius:6px;">
                        <div class="fw-bold" style="color:#000;">Pertanyaan: API partnership untuk integrasi pihak ketiga?</div>
                        <div style="color:#333;"><b>Pernyataan:</b> Tidak ada public API. Semua integrasi dilakukan internal.</div>
                        <div style="color:#333;"><b>Jawaban:</b> Kembangkan REST API untuk partner: akses konten, validasi user, report progress. API membuka peluang integrasi dengan platform lain (LMS perusahaan, portal universitas).</div>
                    </li>
                    <li class="p-3 mb-3" style="background:#fafafa;border:1px solid #000;border-radius:6px;">
                        <div class="fw-bold" style="color:#000;">Pertanyaan: Program corporate training?</div>
                        <div style="color:#333;"><b>Pernyataan:</b> Belum ada paket khusus untuk perusahaan. Harga dan konten sama untuk semua user.</div>
                        <div style="color:#333;"><b>Jawaban:</b> Siapkan paket corporate: akses grup, admin dashboard untuk HRD, laporan progress karyawan, invoice perusahaan. Harga berdasarkan jumlah user dan durasi. Tim sales khusus untuk B2B.</div>
                    </li>
                    <li class="p-3 mb-3" style="background:#fafafa;border:1px solid #000;border-radius:6px;">
                        <div class="fw-bold" style="color:#000;">Pertanyaan: Kolaborasi dengan pemerintah atau BUMN?</div>
                        <div style="color:#333;"><b>Pernyataan:</b> Belum ada pendekatan ke sektor pemerintahan untuk program pelatihan.</div>
                        <div style="color:#333;"><b>Jawaban:</b> Ajukan diri sebagai mitra program pelatihan digital (Kominfo, Kemendikbud, Kartu Prakerja). Sektor ini memiliki budget besar dan kebutuhan konten digital. Dibutuhkan administrasi yang rapi dan badan hukum yang jelas.</div>
                    </li>
                </ul>
            </div>

            <!-- CATATAN -->
            <div class="mt-5 pt-4" style="border-top:2px solid #000;">
                <h3 class="fw-bold small text-uppercase mb-3" style="color:#000;">Catatan Diskusi</h3>
                <div style="height: 200px;">
                    <p style="border-bottom: 1px dashed #000; padding-bottom: 20px; margin-bottom: 20px;"></p>
                    <p style="border-bottom: 1px dashed #000; padding-bottom: 20px; margin-bottom: 20px;"></p>
                    <p style="border-bottom: 1px dashed #000; padding-bottom: 20px; margin-bottom: 20px;"></p>
                    <p style="border-bottom: 1px dashed #000; padding-bottom: 20px;"></p>
                </div>
            </div>

            <!-- TTD -->
            <div class="mt-5 pt-4" style="border-top:2px solid #000;">
                <div class="row">
                    <div class="col-md-6">
                        <p class="small mb-1" style="color:#333;">Pihak 1</p>
                        <p style="border-bottom: 1px solid #000; height: 40px;"></p>
                        <p class="small" style="color:#333;">Tanggal: _______________</p>
                    </div>
                    <div class="col-md-6">
                        <p class="small mb-1" style="color:#333;">Pihak 2</p>
                        <p style="border-bottom: 1px solid #000; height: 40px;"></p>
                        <p class="small" style="color:#333;">Tanggal: _______________</p>
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
    .bento-card, .p-4.p-xl-5 { box-shadow: none !important; border: 1px solid #000 !important; padding: 1rem !important; }
    .section { page-break-inside: avoid; }
}
</style>