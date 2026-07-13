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
                    <li class="p-3 mb-3" style="background:#fafafa;border:1px solid #000;border-radius:6px;">
                        <div class="fw-bold" style="color:#000;">Pertanyaan: Fitur pencarian (search) kursus apakah perlu?</div>
                        <div style="color:#333;"><b>Pernyataan:</b> Saat ini user harus scroll atau filter manual. Tidak ada search bar yang menampilkan hasil berdasarkan judul, kategori, atau instruktur.</div>
                        <div style="color:#333;"><b>Jawaban:</b> Implementasi full-text search dengan filter kategori, level, harga, dan rating. Search bar di header dan halaman kursus. Gunakan MySQL LIKE untuk tahap awal, Elasticsearch jika data sudah besar.</div>
                    </li>
                    <li class="p-3 mb-3" style="background:#fafafa;border:1px solid #000;border-radius:6px;">
                        <div class="fw-bold" style="color:#000;">Pertanyaan: Sistem rating dan review untuk kursus?</div>
                        <div style="color:#333;"><b>Pernyataan:</b> Tidak ada fitur rating atau review. User tidak bisa memberikan feedback publik tentang kualitas kursus.</div>
                        <div style="color:#333;"><b>Jawaban:</b> Tambahkan rating bintang 1-5 + review tertulis setelah user menyelesaikan minimal 50% konten. Rating membantu user lain memilih kursus dan memberi insentif guru menjaga kualitas.</div>
                    </li>
                    <li class="p-3 mb-3" style="background:#fafafa;border:1px solid #000;border-radius:6px;">
                        <div class="fw-bold" style="color:#000;">Pertanyaan: Fitur bookmark dan continue watching?</div>
                        <div style="color:#333;"><b>Pernyataan:</b> User harus mengingat sendiri di mana terakhir kali berhenti menonton. Tidak ada progress tracker per video.</div>
                        <div style="color:#333;"><b>Jawaban:</b> Simpan posisi terakhir setiap video di database. Tampilkan "Lanjutkan Belajar" di dashboard dengan link langsung ke menit terakhir. Fitur bookmark untuk menandai momen penting.</div>
                    </li>
                    <li class="p-3 mb-3" style="background:#fafafa;border:1px solid #000;border-radius:6px;">
                        <div class="fw-bold" style="color:#000;">Pertanyaan: Fitur download materi untuk akses offline?</div>
                        <div style="color:#333;"><b>Pernyataan:</b> Semua konten hanya bisa diakses online. User di daerah dengan koneksi tidak stabil kesulitan belajar.</div>
                        <div style="color:#333;"><b>Jawaban:</b> Izinkan download video dan materi pendukung (PDF, slide) untuk akses offline. Konten yang sudah di-download bisa ditonton tanpa koneksi internet. Batasi jumlah download per hari.</div>
                    </li>
                    <li class="p-3 mb-3" style="background:#fafafa;border:1px solid #000;border-radius:6px;">
                        <div class="fw-bold" style="color:#000;">Pertanyaan: Fitur reminder dan jadwal belajar?</div>
                        <div style="color:#333;"><b>Pernyataan:</b> Tidak ada pengingat. user yang sibuk sering lupa belajar dan akhirnya drop out.</div>
                        <div style="color:#333;"><b>Jawaban:</b> Kirim reminder via WhatsApp atau email: "Hai, saatnya belajar! Kamu punya 3 lesson menunggumu." User bisa atur jadwal belajar mingguan dan dapat notifikasi sesuai jadwal.</div>
                    </li>
                    <li class="p-3 mb-3" style="background:#fafafa;border:1px solid #000;border-radius:6px;">
                        <div class="fw-bold" style="color:#000;">Pertanyaan: Fitur kolaborasi antar siswa (group project)?</div>
                        <div style="color:#333;"><b>Pernyataan:</b> Belajar bersifat individual. Tidak ada mekanisme untuk diskusi kelompok atau proyek bersama.</div>
                        <div style="color:#333;"><b>Jawaban:</b> Buat ruang kolaborasi: grup belajar per kursus, fitur assign tugas kelompok, forum diskusi terbatas anggota grup. Ini meningkatkan engagement dan hasil belajar.</div>
                    </li>
                    <li class="p-3 mb-3" style="background:#fafafa;border:1px solid #000;border-radius:6px;">
                        <div class="fw-bold" style="color:#000;">Pertanyaan: Fitur laporan progress untuk wali atau mentor?</div>
                        <div style="color:#333;"><b>Pernyataan:</b> Tidak ada akses bagi pihak ketiga untuk memantau progress belajar siswa.</div>
                        <div style="color:#333;"><b>Jawaban:</b> Sediakan dashboard orang tua atau mentor: lihat kursus yang diambil, progress, jam belajar, nilai kuis. Fitur ini penting untuk segmen siswa di bawah umur atau program corporate.</div>
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
                    <li class="p-3 mb-3" style="background:#fafafa;border:1px solid #000;border-radius:6px;">
                        <div class="fw-bold" style="color:#000;">Pertanyaan: Monitoring server dan uptime?</div>
                        <div style="color:#333;"><b>Pernyataan:</b> Tidak ada monitoring server otomatis. Jika server down, baru diketahui ketika user komplain.</div>
                        <div style="color:#333;"><b>Jawaban:</b> Gunakan UptimeRobot atau BetterStack untuk monitoring uptime gratis. Pasang notifikasi ke WhatsApp jika server down. Pantau resource (CPU, RAM, disk) secara berkala.</div>
                    </li>
                    <li class="p-3 mb-3" style="background:#fafafa;border:1px solid #000;border-radius:6px;">
                        <div class="fw-bold" style="color:#000;">Pertanyaan: Manajemen SSL certificate?</div>
                        <div style="color:#333;"><b>Pernyataan:</b> SSL sudah terpasang tetapi masa berlaku tidak dimonitor secara terjadwal.</div>
                        <div style="color:#333;"><b>Jawaban:</b> Gunakan Let's Encrypt dengan auto-renewal via cron job. Pantau expiry date dan kirim notifikasi 30 hari sebelum habis. SSL adalah syarat mutlak untuk keamanan data dan SEO.</div>
                    </li>
                    <li class="p-3 mb-3" style="background:#fafafa;border:1px solid #000;border-radius:6px;">
                        <div class="fw-bold" style="color:#000;">Pertanyaan: Strategi log management?</div>
                        <div style="color:#333;"><b>Pernyataan:</b> Log error hanya muncul di console atau file error_log tanpa rotasi. Log bertambah terus hingga memenuhi disk.</div>
                        <div style="color:#333;"><b>Jawaban:</b> Implementasi log rotasi harian. Pisahkan log berdasarkan level (error, warning, info). Gunakan format terstruktur (JSON) agar mudah dianalisis. Pertimbangkan tools seperti Sentry untuk error tracking.</div>
                    </li>
                    <li class="p-3 mb-3" style="background:#fafafa;border:1px solid #000;border-radius:6px;">
                        <div class="fw-bold" style="color:#000;">Pertanyaan: Containerization dengan Docker perlu?</div>
                        <div style="color:#333;"><b>Pernyataan:</b> Aplikasi berjalan langsung di server tanpa container. Environment development dan production bisa berbeda.</div>
                        <div style="color:#333;"><b>Jawaban:</b> Docker memastikan environment konsisten di semua tahap. Untuk saat ini prioritas rendah karena tim kecil. Evaluasi Docker ketika perlu scaling atau deployment lebih kompleks.</div>
                    </li>
                    <li class="p-3 mb-3" style="background:#fafafa;border:1px solid #000;border-radius:6px;">
                        <div class="fw-bold" style="color:#000;">Pertanyaan: CI/CD pipeline untuk otomatisasi?</div>
                        <div style="color:#333;"><b>Pernyataan:</b> Deployment manual: pull code lalu upload. Rentan human error dan makan waktu.</div>
                        <div style="color:#333;"><b>Jawaban:</b> Setup GitHub Actions atau GitLab CI: auto-run php -l, auto-deploy ke staging saat push ke branch develop, auto-deploy ke production saat merge ke main. Mulai sederhana, tingkatkan bertahap.</div>
                    </li>
                    <li class="p-3 mb-3" style="background:#fafafa;border:1px solid #000;border-radius:6px;">
                        <div class="fw-bold" style="color:#000;">Pertanyaan: Optimasi biaya server dan cloud?</div>
                        <div style="color:#333;"><b>Pernyataan:</b> Server berjalan di VPS dengan spesifikasi tetap. Biaya bulanan tetap walau trafik rendah.</div>
                        <div style="color:#333;"><b>Jawaban:</b> Evaluasi penggunaan resource secara berkala. Jika trafik fluktuatif, pertimbangkan auto-scaling cloud. Matikan service yang tidak perlu. Gunakan reserved instance untuk diskon.</div>
                    </li>
                    <li class="p-3 mb-3" style="background:#fafafa;border:1px solid #000;border-radius:6px;">
                        <div class="fw-bold" style="color:#000;">Pertanyaan: API rate limiting dan keamanan endpoint?</div>
                        <div style="color:#333;"><b>Pernyataan:</b> Tidak ada rate limiting. API endpoint publik bisa diakses tanpa batas, rentan abuse.</div>
                        <div style="color:#333;"><b>Jawaban:</b> Implementasi rate limiting per IP (misal 100 request/menit). Gunakan API key untuk akses endpoint. Validasi input di semua endpoint untuk cegah injection.</div>
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
                    <li class="p-3 mb-3" style="background:#fafafa;border:1px solid #000;border-radius:6px;">
                        <div class="fw-bold" style="color:#000;">Pertanyaan: Strategi free trial untuk akuisisi?</div>
                        <div style="color:#333;"><b>Pernyataan:</b> Tidak ada free trial untuk langganan. User harus bayar penuh untuk mencoba, menyebabkan阻力 tinggi.</div>
                        <div style="color:#333;"><b>Jawaban:</b> Tawarkan free trial 3-7 hari untuk paket langganan. User akses penuh selama trial, diminta input kartu (atau tidak). Konversi dari trial ke paid biasanya 20-40% jika produk bagus.</div>
                    </li>
                    <li class="p-3 mb-3" style="background:#fafafa;border:1px solid #000;border-radius:6px;">
                        <div class="fw-bold" style="color:#000;">Pertanyaan: Tiered pricing (beberapa level paket)?</div>
                        <div style="color:#333;"><b>Pernyataan:</b> Hanya ada dua paket: Pro dan Mentorship. Tidak ada tier menengah atau pemula.</div>
                        <div style="color:#333;"><b>Jawaban:</b> Buat tiga tier: Basic (akses kursus tertentu), Pro (akses semua kursus), Premium (semua fitur + mentoring 1-on-1). Setiap tier punya harga dan nilai yang jelas beda.</div>
                    </li>
                    <li class="p-3 mb-3" style="background:#fafafa;border:1px solid #000;border-radius:6px;">
                        <div class="fw-bold" style="color:#000;">Pertanyaan: Insentif untuk pembayaran tahunan?</div>
                        <div style="color:#333;"><b>Pernyataan:</b> Harga bulanan dan tahunan tidak dibedakan secara signifikan. Tidak ada diskon untuk komitmen panjang.</div>
                        <div style="color:#333;"><b>Jawaban:</b> Tawarkan diskon 20-30% untuk langganan tahunan vs bulanan. Annual billing meningkatkan cash flow dan mengurangi churn karena user cenderung tidak cancel setelah bayar tahunan.</div>
                    </li>
                    <li class="p-3 mb-3" style="background:#fafafa;border:1px solid #000;border-radius:6px;">
                        <div class="fw-bold" style="color:#000;">Pertanyaan: Program diskon khusus pelajar?</div>
                        <div style="color:#333;"><b>Pernyataan:</b> Harga sama untuk semua segmen. Tidak ada diskon pelajar atau mahasiswa.</div>
                        <div style="color:#333;"><b>Jawaban:</b> Verifikasi status pelajar via email .edu atau kartu pelajar. Beri diskon 40-50% untuk segmen ini. Pelajar adalah pangsa pasar besar untuk platform pendidikan.</div>
                    </li>
                    <li class="p-3 mb-3" style="background:#fafafa;border:1px solid #000;border-radius:6px;">
                        <div class="fw-bold" style="color:#000;">Pertanyaan: Bundle pricing psychology?</div>
                        <div style="color:#333;"><b>Pernyataan:</b> Harga ditampilkan polos tanpa strategi anchor pricing atau decoy effect.</div>
                        <div style="color:#333;"><b>Jawaban:</b> Gunakan anchor price: tampilkan harga asli yang dicoret di samping harga diskon. Sediakan opsi decoy (paket yang sengaja dibuat kurang menarik) untuk mendorong user memilih paket target.</div>
                    </li>
                    <li class="p-3 mb-3" style="background:#fafafa;border:1px solid #000;border-radius:6px;">
                        <div class="fw-bold" style="color:#000;">Pertanyaan: Dynamic pricing berdasarkan perilaku?</div>
                        <div style="color:#333;"><b>Pernyataan:</b> Harga statis untuk semua user di semua waktu. Tidak ada personalisasi harga.</div>
                        <div style="color:#333;"><b>Jawaban:</b> Pertimbangkan dynamic pricing untuk user yang sudah beberapa kali visit tapi belum checkout (tawarkan diskon kecil). Atau untuk user yang akan expire (tawarkan renewal discount).</div>
                    </li>
                    <li class="p-3 mb-3" style="background:#fafafa;border:1px solid #000;border-radius:6px;">
                        <div class="fw-bold" style="color:#000;">Pertanyaan: Program loyalitas dan reward?</div>
                        <div style="color:#333;"><b>Pernyataan:</b> Tidak ada program loyalitas. User lama dan user baru mendapat perlakuan sama.</div>
                        <div style="color:#333;"><b>Jawaban:</b> Buat program poin loyalitas: setiap transaksi dapat poin, poin bisa ditukar diskon atau akses konten eksklusif. User dengan masa aktif > 1 tahun dapat badge loyalitas dan benefit khusus.</div>
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
                    <li class="p-3 mb-3" style="background:#fafafa;border:1px solid #000;border-radius:6px;">
                        <div class="fw-bold" style="color:#000;">Pertanyaan: Dukungan multi-mata uang (multi-currency)?</div>
                        <div style="color:#333;"><b>Pernyataan:</b> Semua transaksi dalam Rupiah. User dari luar negeri tidak bisa membayar dengan mata uang mereka.</div>
                        <div style="color:#333;"><b>Jawaban:</b> Jika target pasar adalah diaspora atau internasional, tambahkan opsi USD. Gateway Pakasir dan Midtrans mendukung multi-currency. Tampilkan harga dalam IDR dan USD dengan kurs real-time.</div>
                    </li>
                    <li class="p-3 mb-3" style="background:#fafafa;border:1px solid #000;border-radius:6px;">
                        <div class="fw-bold" style="color:#000;">Pertanyaan: Opsi cicilan atau paylater?</div>
                        <div style="color:#333;"><b>Pernyataan:</b> Hanya bayar penuh di muka. Tidak ada opsi cicilan atau paylater.</div>
                        <div style="color:#333;"><b>Jawaban:</b> Integrasikan opsi cicilan via Midtrans (0% untuk kartu kredit tertentu) atau Akulaku. Paylater (GoPay Later, SPayLater) juga meningkatkan konversi untuk user dengan budget terbatas.</div>
                    </li>
                    <li class="p-3 mb-3" style="background:#fafafa;border:1px solid #000;border-radius:6px;">
                        <div class="fw-bold" style="color:#000;">Pertanyaan: Retry logic untuk pembayaran gagal?</div>
                        <div style="color:#333;"><b>Pernyataan:</b> Jika pembayaran gagal, user harus memulai dari awal. Tidak ada mekanisme retry otomatis.</div>
                        <div style="color:#333;"><b>Jawaban:</b> Jika user memilih VA atau QRIS dan tidak bayar dalam waktu tertentu, kirim reminder. Jika kartu ditolak, beri opsi ganti metode bayar tanpa harus ulang proses checkout.</div>
                    </li>
                    <li class="p-3 mb-3" style="background:#fafafa;border:1px solid #000;border-radius:6px;">
                        <div class="fw-bold" style="color:#000;">Pertanyaan: Sistem generate invoice otomatis?</div>
                        <div style="color:#333;"><b>Pernyataan:</b> Tidak ada invoice yang bisa di-download user. Bukti bayar hanya berupa screenshot.</div>
                        <div style="color:#333;"><b>Jawaban:</b> Generate invoice PDF otomatis setelah pembayaran sukses. Invoice mencakup: nomor invoice, tanggal, item, harga, pajak, total. User bisa download dari riwayat transaksi kapan saja.</div>
                    </li>
                    <li class="p-3 mb-3" style="background:#fafafa;border:1px solid #000;border-radius:6px;">
                        <div class="fw-bold" style="color:#000;">Pertanyaan: Pengiriman receipt (struk) pembayaran?</div>
                        <div style="color:#333;"><b>Pernyataan:</b> Tidak ada receipt otomatis. User tidak mendapat konfirmasi tertulis setelah bayar.</div>
                        <div style="color:#333;"><b>Jawaban:</b> Kirim receipt via email setelah pembayaran sukses. Sertakan detail transaksi, metode bayar, total, dan link ke invoice. Untuk WhatsApp, kirim ringkasan singkat.</div>
                    </li>
                    <li class="p-3 mb-3" style="background:#fafafa;border:1px solid #000;border-radius:6px;">
                        <div class="fw-bold" style="color:#000;">Pertanyaan: Rekonsiliasi transaksi harian?</div>
                        <div style="color:#333;"><b>Pernyataan:</b> Tidak ada proses rekonsiliasi. Admin tidak bisa mencocokkan transaksi di sistem dengan laporan dari gateway.</div>
                        <div style="color:#333;"><b>Jawaban:</b> Buat laporan rekonsiliasi: daftar transaksi di DB vs di gateway. Cocokkan setiap hari. Jika ada selisih (contoh: sukses di gateway tapi pending di sistem), admin bisa langsung tindak lanjuti.</div>
                    </li>
                    <li class="p-3 mb-3" style="background:#fafafa;border:1px solid #000;border-radius:6px;">
                        <div class="fw-bold" style="color:#000;">Pertanyaan: Fraud detection untuk transaksi mencurigakan?</div>
                        <div style="color:#333;"><b>Pernyataan:</b> Tidak ada sistem deteksi fraud. Transaksi mencurigakan tidak terfilter.</div>
                        <div style="color:#333;"><b>Jawaban:</b> Deteksi anomali: multiple transaksi dari IP berbeda dalam waktu singkat, nominal tidak wajar, email sementara. Flag transaksi mencurigakan untuk review manual admin sebelum aktivasi.</div>
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
                    <li class="p-3 mb-3" style="background:#fafafa;border:1px solid #000;border-radius:6px;">
                        <div class="fw-bold" style="color:#000;">Pertanyaan: Strategi retargeting iklan?</div>
                        <div style="color:#333;"><b>Pernyataan:</b> Meta Pixel sudah terpasang tetapi tidak ada campaign retargeting yang aktif.</div>
                        <div style="color:#333;"><b>Jawaban:</b> Buat audience retargeting untuk: pengunjung landing page, user yang belum selesai checkout, user yang sudah trial tapi tidak konversi. Tawarkan diskon khusus untuk retargeting.</div>
                    </li>
                    <li class="p-3 mb-3" style="background:#fafafa;border:1px solid #000;border-radius:6px;">
                        <div class="fw-bold" style="color:#000;">Pertanyaan: Kalender konten marketing?</div>
                        <div style="color:#333;"><b>Pernyataan:</b> Konten marketing dipublikasikan secara sporadis tanpa jadwal tetap.</div>
                        <div style="color:#333;"><b>Jawaban:</b> Buat editorial calendar bulanan: tema mingguan, jadwal posting (TikTok 3x/minggu, Instagram 2x/minggu, YouTube 1x/minggu, blog 1x/minggu). Konsistensi lebih penting dari volume.</div>
                    </li>
                    <li class="p-3 mb-3" style="background:#fafafa;border:1px solid #000;border-radius:6px;">
                        <div class="fw-bold" style="color:#000;">Pertanyaan: Kolaborasi dengan influencer?</div>
                        <div style="color:#333;"><b>Pernyataan:</b> Belum pernah kerja sama dengan influencer atau content creator untuk promosi.</div>
                        <div style="color:#333;"><b>Jawaban:</b> Cari micro-influencer (5k-50k followers) di niche pendidikan. Tawarkan akses gratis + komisi afiliasi. Micro-influencer lebih engaged dan biaya lebih rendah dibanding macro-influencer.</div>
                    </li>
                    <li class="p-3 mb-3" style="background:#fafafa;border:1px solid #000;border-radius:6px;">
                        <div class="fw-bold" style="color:#000;">Pertanyaan: Viral marketing dan share mechanics?</div>
                        <div style="color:#333;"><b>Pernyataan:</b> Tidak ada mekanisme yang mendorong sharing. Konten tidak mudah di-share ke media sosial.</div>
                        <div style="color:#333;"><b>Jawaban:</b> Tambahkan tombol share di setiap lesson. Buat fitur "Bagikan Progress": user bisa share sertifikat atau capaian ke Instagram/LinkedIn. Beri reward untuk share tertentu.</div>
                    </li>
                    <li class="p-3 mb-3" style="background:#fafafa;border:1px solid #000;border-radius:6px;">
                        <div class="fw-bold" style="color:#000;">Pertanyaan: Community building sebagai channel marketing?</div>
                        <div style="color:#333;"><b>Pernyataan:</b> Tidak ada komunitas resmi. User tidak terhubung satu sama lain di luar forum.</div>
                        <div style="color:#333;"><b>Jawaban:</b> Bangun grup komunitas (WhatsApp, Telegram, atau Discord) untuk setiap kursus. Komunitas aktif meningkatkan retensi dan word-of-mouth marketing. Anggota komunitas bisa menjadi brand advocate.</div>
                    </li>
                    <li class="p-3 mb-3" style="background:#fafafa;border:1px solid #000;border-radius:6px;">
                        <div class="fw-bold" style="color:#000;">Pertanyaan: Mekanisme referral program yang efektif?</div>
                        <div style="color:#333;"><b>Pernyataan:</b> Tabel referral sudah siap tetapi belum ada mekanisme yang mengatur kapan komisi dibayarkan.</div>
                        <div style="color:#333;"><b>Jawaban:</b> Komisi referral dibayar setelah teman yang direferensikan melakukan pembayaran pertama. Beri reward dua arah: referrer dapat diskon, referee dapat diskon pertama. Buat dashboard tracking referral.</div>
                    </li>
                    <li class="p-3 mb-3" style="background:#fafafa;border:1px solid #000;border-radius:6px;">
                        <div class="fw-bold" style="color:#000;">Pertanyaan: Brand awareness measurement?</div>
                        <div style="color:#333;"><b>Pernyataan:</b> Tidak ada metrik brand awareness. Sulit mengukur efektivitas campaign branding.</div>
                        <div style="color:#333;"><b>Jawaban:</b> Gunakan Google Trends untuk melihat minat pencarian. Pantau brand mention di media sosial. Survey sederhana ke user baru: "Dari mana Anda tahu tentang kami?" untuk mengukur source of awareness.</div>
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
                    <li class="p-3 mb-3" style="background:#fafafa;border:1px solid #000;border-radius:6px;">
                        <div class="fw-bold" style="color:#000;">Pertanyaan: Kepatuhan GDPR untuk user internasional?</div>
                        <div style="color:#333;"><b>Pernyataan:</b> Jika ada user dari Eropa, GDPR berlaku. Saat ini belum ada mekanisme kepatuhan.</div>
                        <div style="color:#333;"><b>Jawaban:</b> Untuk tahap awal, blokir akses dari EU atau tampilkan banner consent cookie. Jika target pasar internasional, perlu data processing agreement, right to be forgotten, dan data portability.</div>
                    </li>
                    <li class="p-3 mb-3" style="background:#fafafa;border:1px solid #000;border-radius:6px;">
                        <div class="fw-bold" style="color:#000;">Pertanyaan: Verifikasi umur pengguna?</div>
                        <div style="color:#333;"><b>Pernyataan:</b> Tidak ada verifikasi umur saat registrasi. Anak di bawah umur bisa mendaftar tanpa persetujuan orang tua.</div>
                        <div style="color:#333;"><b>Jawaban:</b> Tambahkan field tanggal lahir saat registrasi. Jika user di bawah 13 tahun, minta persetujuan orang tua (COPPA compliance). Batasi fitur tertentu untuk pengguna di bawah umur.</div>
                    </li>
                    <li class="p-3 mb-3" style="background:#fafafa;border:1px solid #000;border-radius:6px;">
                        <div class="fw-bold" style="color:#000;">Pertanyaan: Kebijakan moderasi konten?</div>
                        <div style="color:#333;"><b>Pernyataan:</b> Konten yang diupload tidak melalui proses moderasi formal selain review admin.</div>
                        <div style="color:#333;"><b>Jawaban:</b> Buat pedoman konten: larangan plagiarisme, konten SARA, kekerasan, dan pornografi. Jika ada dashboard guru, setiap konten harus melewati moderasi sebelum publikasi. Sediakan tombol report untuk user.</div>
                    </li>
                    <li class="p-3 mb-3" style="background:#fafafa;border:1px solid #000;border-radius:6px;">
                        <div class="fw-bold" style="color:#000;">Pertanyaan: Prosedur DMCA takedown?</div>
                        <div style="color:#333;"><b>Pernyataan:</b> Tidak ada prosedur penanganan klaim hak cipta dari pihak ketiga.</div>
                        <div style="color:#333;"><b>Jawaban:</b> Siapkan formulir DMCA takedown: identitas pelapor, bukti kepemilikan, URL konten yang dilanggar. Target respon < 48 jam. Tentukan kontak resmi untuk penerimaan klaim.</div>
                    </li>
                    <li class="p-3 mb-3" style="background:#fafafa;border:1px solid #000;border-radius:6px;">
                        <div class="fw-bold" style="color:#000;">Pertanyaan: Non-disclosure agreement untuk kontraktor?</div>
                        <div style="color:#333;"><b>Pernyataan:</b> Freelancer dan kontraktor tidak menandatangani NDA. Data dan kode bisa bocor tanpa konsekuensi hukum.</div>
                        <div style="color:#333;"><b>Jawaban:</b> Wajibkan NDA untuk semua pihak yang memiliki akses ke source code, data user, atau informasi bisnis sensitif. Sediakan template NDA yang sudah direview konsultan hukum.</div>
                    </li>
                    <li class="p-3 mb-3" style="background:#fafafa;border:1px solid #000;border-radius:6px;">
                        <div class="fw-bold" style="color:#000;">Pertanyaan: Template perjanjian partnership?</div>
                        <div style="color:#333;"><b>Pernyataan:</b> Setiap kerja sama dibuat secara informal via chat. Tidak ada dokumen hukum yang mengikat.</div>
                        <div style="color:#333;"><b>Jawaban:</b> Buat template perjanjian partnership standar: scope of work, hak dan kewajiban, pembagian revenue, durasi, termination clause. Setiap mitra harus menandatangani sebelum kerja sama dimulai.</div>
                    </li>
                    <li class="p-3 mb-3" style="background:#fafafa;border:1px solid #000;border-radius:6px;">
                        <div class="fw-bold" style="color:#000;">Pertanyaan: Strategi perlindungan kekayaan intelektual?</div>
                        <div style="color:#333;"><b>Pernyataan:</b> Konten kursus tidak terdaftar di HAKI. Rentan dicuri dan didistribusikan ulang.</div>
                        <div style="color:#333;"><b>Jawaban:</b> Daftarkan konten utama ke HAKI (Kemenkumham). Pasang watermark pada video preview. Gunakan teknologi DRM untuk video premium. Pantau platform ilegal yang mungkin membajak konten.</div>
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
                    <li class="p-3 mb-3" style="background:#fafafa;border:1px solid #000;border-radius:6px;">
                        <div class="fw-bold" style="color:#000;">Pertanyaan: Kebijakan kerja remote?</div>
                        <div style="color:#333;"><b>Pernyataan:</b> Tidak ada kebijakan formal tentang work from home atau jam kerja fleksibel.</div>
                        <div style="color:#333;"><b>Jawaban:</b> Buat kebijakan remote-friendly: jam kerja inti (misal 10.00-15.00), sisanya fleksibel. Target output-based, bukan jam-based. Sediakan budget internet dan tools kolaborasi untuk tim remote.</div>
                    </li>
                    <li class="p-3 mb-3" style="background:#fafafa;border:1px solid #000;border-radius:6px;">
                        <div class="fw-bold" style="color:#000;">Pertanyaan: Sistem performance review?</div>
                        <div style="color:#333;"><b>Pernyataan:</b> Tidak ada evaluasi performa formal. Feedback hanya diberikan jika ada masalah.</div>
                        <div style="color:#333;"><b>Jawaban:</b> Lakukan performance review setiap 6 bulan. Tetapkan KPI individu sesuai peran. Gunakan metode 360-degree feedback untuk gambaran lengkap. Hubungkan hasil review dengan kenaikan gaji atau bonus.</div>
                    </li>
                    <li class="p-3 mb-3" style="background:#fafafa;border:1px solid #000;border-radius:6px;">
                        <div class="fw-bold" style="color:#000;">Pertanyaan: Budget pengembangan kompetensi tim?</div>
                        <div style="color:#333;"><b>Pernyataan:</b> Tidak ada alokasi budget untuk pelatihan atau kursus bagi anggota tim.</div>
                        <div style="color:#333;"><b>Jawaban:</b> Alokasikan minimal 5% dari gaji untuk pengembangan: langganan course, conference, sertifikasi. Tim yang terus belajar akan meningkatkan kualitas produk secara langsung.</div>
                    </li>
                    <li class="p-3 mb-3" style="background:#fafafa;border:1px solid #000;border-radius:6px;">
                        <div class="fw-bold" style="color:#000;">Pertanyaan: Company culture dan nilai-nilai?</div>
                        <div style="color:#333;"><b>Pernyataan:</b> Tidak ada company culture yang didefinisikan. Nilai-nilai tim tidak tertulis.</div>
                        <div style="color:#333;"><b>Jawaban:</b> Definisikan core values: misal "Student First", "Quality over Quantity", "Continuous Improvement". Tempelkan di mana-mana. Rekrut orang yang sesuai dengan nilai ini. Nilai yang kuat menyatukan tim.</div>
                    </li>
                    <li class="p-3 mb-3" style="background:#fafafa;border:1px solid #000;border-radius:6px;">
                        <div class="fw-bold" style="color:#000;">Pertanyaan: Proses rekrutmen yang efektif?</div>
                        <div style="color:#333;"><b>Pernyataan:</b> Rekrutmen dilakukan tanpa proses baku: lihat CV, chat, langsung kerja.</div>
                        <div style="color:#333;"><b>Jawaban:</b> Buat proses: screening CV → tugas kecil (paid) → interview → keputusan. Tugas kecil lebih indikatif daripada CV. Libatkan minimal 2 orang dalam interview untuk mengurangi bias.</div>
                    </li>
                    <li class="p-3 mb-3" style="background:#fafafa;border:1px solid #000;border-radius:6px;">
                        <div class="fw-bold" style="color:#000;">Pertanyaan: Onboarding anggota tim baru?</div>
                        <div style="color:#333;"><b>Pernyataan:</b> Anggota baru langsung diberi tugas tanpa onboarding formal. Butuh waktu lama untuk produktif.</div>
                        <div style="color:#333;"><b>Jawaban:</b> Buat onboarding checklist: pengenalan tim, akses tools, baca dokumentasi, tugas kecil pertama, mentoring dengan anggota senior. Target: anggota baru bisa produktif dalam 2 minggu.</div>
                    </li>
                    <li class="p-3 mb-3" style="background:#fafafa;border:1px solid #000;border-radius:6px;">
                        <div class="fw-bold" style="color:#000;">Pertanyaan: Strategi retensi talenta?</div>
                        <div style="color:#333;"><b>Pernyataan:</b> Tidak ada program retensi. Talenta bisa pergi kapan saja tanpa golden handcuffs.</div>
                        <div style="color:#333;"><b>Jawaban:</b> Retensi dimulai dari: gaji kompetitif, lingkungan kerja positif, peluang berkembang, dan apresiasi. Pertimbangkan opsi saham atau profit-sharing untuk talenta kunci. Exit interview untuk belajar dari yang resign.</div>
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
                    <li class="p-3 mb-3" style="background:#fafafa;border:1px solid #000;border-radius:6px;">
                        <div class="fw-bold" style="color:#000;">Pertanyaan: Cohort analysis untuk retensi?</div>
                        <div style="color:#333;"><b>Pernyataan:</b> Tidak ada cohort analysis. Tidak tahu apakah user yang daftar bulan ini bertahan lebih baik dari bulan lalu.</div>
                        <div style="color:#333;"><b>Jawaban:</b> Buat cohort analysis per bulan registrasi. Lihat persentase user yang masih aktif di bulan ke-1, ke-3, ke-6, ke-12. Cohort analysis adalah metrik paling penting untuk bisnis subscription.</div>
                    </li>
                    <li class="p-3 mb-3" style="background:#fafafa;border:1px solid #000;border-radius:6px;">
                        <div class="fw-bold" style="color:#000;">Pertanyaan: Funnel analysis konversi?</div>
                        <div style="color:#333;"><b>Pernyataan:</b> Tidak ada funnel tracking. Tidak tahu di tahap mana user paling banyak drop out.</div>
                        <div style="color:#333;"><b>Jawaban:</b> Identifikasi funnel: Landing Page → Registrasi → Pilih Produk → Checkout → Bayar → Aktivasi. Hitung konversi di setiap step. Fokus optimasi di step dengan drop tertinggi.</div>
                    </li>
                    <li class="p-3 mb-3" style="background:#fafafa;border:1px solid #000;border-radius:6px;">
                        <div class="fw-bold" style="color:#000;">Pertanyaan: Retention curve analysis?</div>
                        <div style="color:#333;"><b>Pernyataan:</b> Tidak ada retention curve. Churn rate hanya diperkirakan secara kasar.</div>
                        <div style="color:#333;"><b>Jawaban:</b> Plot retention curve: berapa persen user kembali setiap minggu setelah registrasi. Bandingkan retention antar cohort. Identifikasi point di mana retention drop tajam dan lakukan intervensi.</div>
                    </li>
                    <li class="p-3 mb-3" style="background:#fafafa;border:1px solid #000;border-radius:6px;">
                        <div class="fw-bold" style="color:#000;">Pertanyaan: Net Revenue Retention (NRR)?</div>
                        <div style="color:#333;"><b>Pernyataan:</b> Tidak ada metrik NRR. Revenue dari existing customer tidak dipantau.</div>
                        <div style="color:#333;"><b>Jawaban:</b> Hitung NRR: (revenue awal periode + upgrade - downgrade - churn) / revenue awal periode. NRR > 100% berarti existing customer tumbuh. Ini adalah metrik kesehatan bisnis subscription.</div>
                    </li>
                    <li class="p-3 mb-3" style="background:#fafafa;border:1px solid #000;border-radius:6px;">
                        <div class="fw-bold" style="color:#000;">Pertanyaan: Customer Health Score?</div>
                        <div style="color:#333;"><b>Pernyataan:</b> Tidak ada sistem yang mengidentifikasi user berisiko churn sebelum mereka pergi.</div>
                        <div style="color:#333;"><b>Jawaban:</b> Buat health score berdasarkan: frekuensi login, jumlah lesson ditonton, interaksi dengan forum, status pembayaran. User dengan skor rendah dapat di-intervensi dengan email khusus atau diskon.</div>
                    </li>
                    <li class="p-3 mb-3" style="background:#fafafa;border:1px solid #000;border-radius:6px;">
                        <div class="fw-bold" style="color:#000;">Pertanyaan: Time to Value (TTV) metric?</div>
                        <div style="color:#333;"><b>Pernyataan:</b> Tidak diukur berapa lama waktu yang dibutuhkan user untuk mendapat value pertama.</div>
                        <div style="color:#333;"><b>Jawaban:</b> TTV adalah waktu dari registrasi hingga user menyelesaikan lesson pertama atau mendapat "aha moment". Semakin pendek TTV, semakin tinggi retensi. Optimasi onboarding untuk memperpendek TTV.</div>
                    </li>
                    <li class="p-3 mb-3" style="background:#fafafa;border:1px solid #000;border-radius:6px;">
                        <div class="fw-bold" style="color:#000;">Pertanyaan: Feature adoption rate?</div>
                        <div style="color:#333;"><b>Pernyataan:</b> Tidak tahu fitur mana yang paling banyak dipakai dan mana yang diabaikan.</div>
                        <div style="color:#333;"><b>Jawaban:</b> Track event: play video, download materi, buka forum, ikut kuis, generate sertifikat. Hitung adoption rate per fitur. Fitur dengan adopsi rendah perlu dievaluasi: apakah tidak berguna atau tidak diketahui user.</div>
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
                    <li class="p-3 mb-3" style="background:#fafafa;border:1px solid #000;border-radius:6px;">
                        <div class="fw-bold" style="color:#000;">Pertanyaan: Personalisasi konten untuk setiap user?</div>
                        <div style="color:#333;"><b>Pernyataan:</b> Semua user melihat konten yang sama. Tidak ada rekomendasi personal.</div>
                        <div style="color:#333;"><b>Jawaban:</b> Implementasi rekomendasi berdasarkan: minat saat registrasi, riwayat menonton, kursus yang dibeli. Tampilkan "Kursus untuk Anda" di dashboard. Personalisasi meningkatkan engagement dan konversi.</div>
                    </li>
                    <li class="p-3 mb-3" style="background:#fafafa;border:1px solid #000;border-radius:6px;">
                        <div class="fw-bold" style="color:#000;">Pertanyaan: Push notification di browser?</div>
                        <div style="color:#333;"><b>Pernyataan:</b> Tidak ada push notification. User hanya dapat notifikasi via email atau WhatsApp.</div>
                        <div style="color:#333;"><b>Jawaban:</b> Minta izin push notification saat registrasi. Kirim notifikasi: reminder belajar, kursus baru, diskon, progress. Push notification memiliki open rate lebih tinggi dari email.</div>
                    </li>
                    <li class="p-3 mb-3" style="background:#fafafa;border:1px solid #000;border-radius:6px;">
                        <div class="fw-bold" style="color:#000;">Pertanyaan: Optimasi UX pencarian (search)?</div>
                        <div style="color:#333;"><b>Pernyataan:</b> Search hanya mencari judul. Tidak ada autocomplete, filter, atau sorting.</div>
                        <div style="color:#333;"><b>Jawaban:</b> Tambahkan autocomplete dengan saran populer. Filter berdasarkan kategori, level, harga, durasi. Sorting: terbaru, terpopuler, rating tertinggi. Tampilkan jumlah hasil untuk feedback cepat.</div>
                    </li>
                    <li class="p-3 mb-3" style="background:#fafafa;border:1px solid #000;border-radius:6px;">
                        <div class="fw-bold" style="color:#000;">Pertanyaan: Loading state dan skeleton screen?</div>
                        <div style="color:#333;"><b>Pernyataan:</b> Saat loading, halaman kosong atau spinner. User tidak tahu apa yang terjadi.</div>
                        <div style="color:#333;"><b>Jawaban:</b> Gunakan skeleton screen (placeholder abu-abu yang menyerupai layout) saat konten dimuat. Ini memberikan persepsi kecepatan lebih baik. Tambahkan progress bar untuk proses yang panjang.</div>
                    </li>
                    <li class="p-3 mb-3" style="background:#fafafa;border:1px solid #000;border-radius:6px;">
                        <div class="fw-bold" style="color:#000;">Pertanyaan: Desain halaman error (404, 500)?</div>
                        <div style="color:#333;"><b>Pernyataan:</b> Halaman error menampilkan pesan default browser atau teks polos tidak membantu.</div>
                        <div style="color:#333;"><b>Jawaban:</b> Buat halaman 404 dan 500 yang user-friendly: ilustrasi, pesan jelas, tombol navigasi ke home atau kontak support. Jangan tampilkan error detail ke user (security risk).</div>
                    </li>
                    <li class="p-3 mb-3" style="background:#fafafa;border:1px solid #000;border-radius:6px;">
                        <div class="fw-bold" style="color:#000;">Pertanyaan: Desain empty state yang informatif?</div>
                        <div style="color:#333;"><b>Pernyataan:</b> Halaman kosong (belum ada kursus, belum ada transaksi) hanya menampilkan teks "Tidak ada data".</div>
                        <div style="color:#333;"><b>Jawaban:</b> Empty state yang baik: ilustrasi, pesan positif, dan CTA. Contoh: "Belum ada kursus, yuk mulai belajar!" dengan tombol "Jelajahi Kursus". Empty state adalah kesempatan untuk guiding user.</div>
                    </li>
                    <li class="p-3 mb-3" style="background:#fafafa;border:1px solid #000;border-radius:6px;">
                        <div class="fw-bold" style="color:#000;">Pertanyaan: Micro-interactions untuk engagement?</div>
                        <div style="color:#333;"><b>Pernyataan:</b> Tidak ada animasi atau feedback visual saat user melakukan aksi. UI terasa kaku.</div>
                        <div style="color:#333;"><b>Jawaban:</b> Tambahkan micro-interactions: button hover effect, loading animation, success checkmark, subtle transition antar halaman. Micro-interactions membuat pengalaman lebih hidup dan profesional.</div>
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
                    <li class="p-3 mb-3" style="background:#fafafa;border:1px solid #000;border-radius:6px;">
                        <div class="fw-bold" style="color:#000;">Pertanyaan: Implementasi chatbot untuk support awal?</div>
                        <div style="color:#333;"><b>Pernyataan:</b> Semua pertanyaan dilayani manual oleh admin. Pertanyaan berulang menyita waktu.</div>
                        <div style="color:#333;"><b>Jawaban:</b> Implementasi chatbot sederhana untuk FAQ: "Cara reset password", "Cara bayar", "Cara refund". Jika tidak bisa menjawab, escalate ke admin. Chatbot bisa handle 60-80% pertanyaan umum.</div>
                    </li>
                    <li class="p-3 mb-3" style="background:#fafafa;border:1px solid #000;border-radius:6px;">
                        <div class="fw-bold" style="color:#000;">Pertanyaan: Self-help resources selain FAQ?</div>
                        <div style="color:#333;"><b>Pernyataan:</b> Tidak ada video tutorial atau panduan interaktif tentang cara menggunakan platform.</div>
                        <div style="color:#333;"><b>Jawaban:</b> Buat video tutorial pendek (1-2 menit) untuk setiap fitur utama: cara daftar, cara beli, cara akses kursus, cara download sertifikat. Letakkan di halaman help atau kirim sebagai email onboarding.</div>
                    </li>
                    <li class="p-3 mb-3" style="background:#fafafa;border:1px solid #000;border-radius:6px;">
                        <div class="fw-bold" style="color:#000;">Pertanyaan: Community forum sebagai support alternatif?</div>
                        <div style="color:#333;"><b>Pernyataan:</b> Forum ada tetapi kurang aktif. User lebih suka chat langsung daripada posting di forum.</div>
                        <div style="color:#333;"><b>Jawaban:</b> Aktifkan forum dengan moderator yang responsif. Beri badge untuk user yang aktif membantu. Kategorikan forum: teknis, diskusi kursus, feedback. Forum mengurangi beban support tim.</div>
                    </li>
                    <li class="p-3 mb-3" style="background:#fafafa;border:1px solid #000;border-radius:6px;">
                        <div class="fw-bold" style="color:#000;">Pertanyaan: Proactive support berdasarkan perilaku user?</div>
                        <div style="color:#333;"><b>Pernyataan:</b> Support hanya reaktif. Menunggu user datang dengan masalah.</div>
                        <div style="color:#333;"><b>Jawaban:</b> Deteksi sinyal user kesulitan: gagal bayar 2x, tidak login 7 hari, error saat akses konten. Kirim pesan proaktif: "Hai, kami lihat Anda mengalami kendala, ada yang bisa dibantu?"</div>
                    </li>
                    <li class="p-3 mb-3" style="background:#fafafa;border:1px solid #000;border-radius:6px;">
                        <div class="fw-bold" style="color:#000;">Pertanyaan: Dukungan multi-bahasa?</div>
                        <div style="color:#333;"><b>Pernyataan:</b> Support hanya dalam Bahasa Indonesia. User asing tidak bisa mendapatkan bantuan.</div>
                        <div style="color:#333;"><b>Jawaban:</b> Jika target pasar meluas, siapkan support Bahasa Inggris. Gunakan Google Translate untuk chat awal, lalu human agent jika perlu. Terjemahkan FAQ ke Bahasa Inggris.</div>
                    </li>
                    <li class="p-3 mb-3" style="background:#fafafa;border:1px solid #000;border-radius:6px;">
                        <div class="fw-bold" style="color:#000;">Pertanyaan: Analitik support: metrik apa yang dipantau?</div>
                        <div style="color:#333;"><b>Pernyataan:</b> Tidak ada metrik support. Tidak tahu berapa rata-rata waktu respon atau resolusi.</div>
                        <div style="color:#333;"><b>Jawaban:</b> Pantau: First Response Time, Average Resolution Time, CSAT (Customer Satisfaction Score), Ticket Volume per hari. Target: FRT < 1 jam, ART < 8 jam, CSAT > 4.0/5.0.</div>
                    </li>
                    <li class="p-3 mb-3" style="background:#fafafa;border:1px solid #000;border-radius:6px;">
                        <div class="fw-bold" style="color:#000;">Pertanyaan: VIP support tier untuk user premium?</div>
                        <div style="color:#333;"><b>Pernyataan:</b> Semua user mendapat level support yang sama, tidak peduli paketnya.</div>
                        <div style="color:#333;"><b>Jawaban:</b> Untuk paket Mentorship atau Premium, sediakan support prioritas: response < 15 menit, dedicated account manager, direct line ke owner. Ini menambah nilai paket premium.</div>
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
                    <li class="p-3 mb-3" style="background:#fafafa;border:1px solid #000;border-radius:6px;">
                        <div class="fw-bold" style="color:#000;">Pertanyaan: Pengembangan aplikasi mobile?</div>
                        <div style="color:#333;"><b>Pernyataan:</b> Website sudah responsive. Namun user mobile masih mengalami UX yang kurang optimal.</div>
                        <div style="color:#333;"><b>Jawaban:</b> Jika traffic mobile > 60%, kembangkan PWA (Progressive Web App) dulu. PWA lebih murah dari native app, bisa di-install di home screen, dan mendukung push notification. Native app untuk fase berikutnya.</div>
                    </li>
                    <li class="p-3 mb-3" style="background:#fafafa;border:1px solid #000;border-radius:6px;">
                        <div class="fw-bold" style="color:#000;">Pertanyaan: Social learning features (belajar bersama)?</div>
                        <div style="color:#333;"><b>Pernyataan:</b> Belajar bersifat individual. Tidak ada interaksi sosial selama proses belajar.</div>
                        <div style="color:#333;"><b>Jawaban:</b> Tambahkan fitur social: study group, leaderboard teman, tantangan mingguan, fitur "belajar bersama" real-time. Social learning meningkatkan motivasi dan retensi signifikan.</div>
                    </li>
                    <li class="p-3 mb-3" style="background:#fafafa;border:1px solid #000;border-radius:6px;">
                        <div class="fw-bold" style="color:#000;">Pertanyaan: Peer review untuk tugas?</div>
                        <div style="color:#333;"><b>Pernyataan:</b> Tidak ada tugas yang dikumpulkan dan dinilai. Semua pembelajaran bersifat pasif (nonton video).</div>
                        <div style="color:#333;"><b>Jawaban:</b> Untuk kursus tertentu, tambahkan tugas praktik yang dikumpulkan. Sistem peer review: siswa menilai tugas teman berdasarkan rubrik. Ini meningkatkan pemahaman dan membangun komunitas.</div>
                    </li>
                    <li class="p-3 mb-3" style="background:#fafafa;border:1px solid #000;border-radius:6px;">
                        <div class="fw-bold" style="color:#000;">Pertanyaan: Project-based learning?</div>
                        <div style="color:#333;"><b>Pernyataan:</b> Tidak ada proyek akhir (capstone project). Sertifikat diberikan berdasarkan penyelesaian video saja.</div>
                        <div style="color:#333;"><b>Jawaban:</b> Implementasi capstone project untuk kursus advanced. Siswa mengerjakan proyek nyata, dikumpulkan, dinilai. Sertifikat hanya diberikan jika lulus kuis dan proyek. Ini meningkatkan kredibilitas sertifikat.</div>
                    </li>
                    <li class="p-3 mb-3" style="background:#fafafa;border:1px solid #000;border-radius:6px;">
                        <div class="fw-bold" style="color:#000;">Pertanyaan: Mentorship matching system?</div>
                        <div style="color:#333;"><b>Pernyataan:</b> Paket Mentorship ada tetapi proses matching mentor-mentee masih manual.</div>
                        <div style="color:#333;"><b>Jawaban:</b> Buat algoritma matching: mentor dipilih berdasarkan bidang keahlian, ketersediaan waktu, dan preferensi mentee. Sediakan dashboard untuk jadwal sesi mentoring dan tracking progress.</div>
                    </li>
                    <li class="p-3 mb-3" style="background:#fafafa;border:1px solid #000;border-radius:6px;">
                        <div class="fw-bold" style="color:#000;">Pertanyaan: Career path dan guidance?</div>
                        <div style="color:#333;"><b>Pernyataan:</b> Tidak ada panduan karir. User belajar tanpa tahu jalur karir yang tersedia.</div>
                        <div style="color:#333;"><b>Jawaban:</b> Buat learning path berdasarkan tujuan karir: "Web Developer", "Data Analyst", "UI/UX Designer". Setiap path berisi rekomendasi kursus berurutan. Tambahkan artikel tentang prospek karir dan gaji.</div>
                    </li>
                    <li class="p-3 mb-3" style="background:#fafafa;border:1px solid #000;border-radius:6px;">
                        <div class="fw-bold" style="color:#000;">Pertanyaan: Alumni network?</div>
                        <div style="color:#333;"><b>Pernyataan:</b> Tidak ada jaringan alumni. Lulusan tidak terhubung satu sama lain.</div>
                        <div style="color:#333;"><b>Jawaban:</b> Bangun alumni network: grup khusus, event reunian, forum lowongan kerja. Alumni yang sukses bisa menjadi mentor atau brand ambassador. Jaringan alumni meningkatkan kredibilitas platform.</div>
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
                    <li class="p-3 mb-3" style="background:#fafafa;border:1px solid #000;border-radius:6px;">
                        <div class="fw-bold" style="color:#000;">Pertanyaan: Co-branding dengan brand lain?</div>
                        <div style="color:#333;"><b>Pernyataan:</b> Tidak ada kerja sama co-branding. Brand sendiri belum cukup kuat untuk kolaborasi besar.</div>
                        <div style="color:#333;"><b>Jawaban:</b> Cari brand non-kompetitif untuk co-branding: platform kursus dengan penyedia tools (contoh: Canva, Notion, GitHub). Buat konten bersama, masing-masing promosi ke audiens sendiri. Co-branding memperluas reach secara organik.</div>
                    </li>
                    <li class="p-3 mb-3" style="background:#fafafa;border:1px solid #000;border-radius:6px;">
                        <div class="fw-bold" style="color:#000;">Pertanyaan: Sponsorship event pendidikan?</div>
                        <div style="color:#333;"><b>Pernyataan:</b> Tidak ada sponsorship event. Brand awareness masih rendah di komunitas pendidikan.</div>
                        <div style="color:#333;"><b>Jawaban:</b> Sponsor event seperti hackathon, seminar pendidikan, atau kompetisi coding. Biaya sponsorship bisa Rp5-20 juta tergantung skala. Dampaknya: brand awareness dan leads langsung dari audiens yang relevan.</div>
                    </li>
                    <li class="p-3 mb-3" style="background:#fafafa;border:1px solid #000;border-radius:6px;">
                        <div class="fw-bold" style="color:#000;">Pertanyaan: Cross-promotion dengan platform lain?</div>
                        <div style="color:#333;"><b>Pernyataan:</b> Tidak ada cross-promotion. Bekerja sendiri tanpa memanfaatkan audiens platform lain.</div>
                        <div style="color:#333;"><b>Jawaban:</b> Lakukan cross-promotion dengan platform non-kompetitif: forum coding, grup belajar, newsletter pendidikan. Tawarkan diskon khusus untuk audiens mereka. Mereka dapat komisi atau konten gratis.</div>
                    </li>
                    <li class="p-3 mb-3" style="background:#fafafa;border:1px solid #000;border-radius:6px;">
                        <div class="fw-bold" style="color:#000;">Pertanyaan: Content syndication ke platform lain?</div>
                        <div style="color:#333;"><b>Pernyataan:</b> Konten hanya ada di platform sendiri. Tidak didistribusikan ke channel lain.</div>
                        <div style="color:#333;"><b>Jawaban:</b> Syndicate konten ke platform seperti Medium, LinkedIn Articles, atau YouTube. Gunakan excerpt atau versi ringkas dengan link ke platform utama. Content syndication meningkatkan backlink dan traffic SEO.</div>
                    </li>
                    <li class="p-3 mb-3" style="background:#fafafa;border:1px solid #000;border-radius:6px;">
                        <div class="fw-bold" style="color:#000;">Pertanyaan: Joint research dengan institusi akademik?</div>
                        <div style="color:#333;"><b>Pernyataan:</b> Tidak ada penelitian bersama dengan universitas atau lembaga riset.</div>
                        <div style="color:#333;"><b>Jawaban:</b> Tawarkan data agregat anonim (tren belajar, efektivitas metode) untuk penelitian. Hasil penelitian bisa menjadi publikasi bersama yang meningkatkan reputasi platform.</div>
                    </li>
                    <li class="p-3 mb-3" style="background:#fafafa;border:1px solid #000;border-radius:6px;">
                        <div class="fw-bold" style="color:#000;">Pertanyaan: University credit transfer (konversi SKS)?</div>
                        <div style="color:#333;"><b>Pernyataan:</b> Tidak ada kerja sama dengan universitas untuk konversi nilai kursus ke SKS.</div>
                        <div style="color:#333;"><b>Jawaban:</b> Jalin MoU dengan universitas untuk program MBKM (Merdeka Belajar Kampus Merdeka). Mahasiswa bisa mengambil kursus dan dikonversi ke SKS. Ini membuka akses ke jutaan mahasiswa.</div>
                    </li>
                    <li class="p-3 mb-3" style="background:#fafafa;border:1px solid #000;border-radius:6px;">
                        <div class="fw-bold" style="color:#000;">Pertanyaan: Sertifikasi resmi dari pemerintah?</div>
                        <div style="color:#333;"><b>Pernyataan:</b> Sertifikat dari platform tidak diakui secara resmi oleh pemerintah atau industri.</div>
                        <div style="color:#333;"><b>Jawaban:</b> Ajukan sertifikasi ke BNSP (Badan Nasional Sertifikasi Profesi) untuk kursus tertentu. Sertifikat ber-BNSP lebih bernilai di industri. Prosesnya panjang tapi worth it untuk kredibilitas jangka panjang.</div>
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