<div class="container py-5 my-4">
    <div class="text-center mb-5">
        <span class="badge bg-primary-subtle text-primary badge-modern mb-3">FAQ</span>
        <h1 class="display-5 fw-extrabold text-dark mb-3" style="letter-spacing:-0.03em;"><?php echo t('Pertanyaan Umum', 'Frequently Asked Questions'); ?></h1>
    </div>
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="accordion" id="faqAccordion">
                <?php $faqs = array(
                    array('q' => 'Bagaimana cara mendaftar?', 'q_en' => 'How do I register?', 'a' => 'Klik tombol Daftar di pojok kanan atas, isi nama, email, dan password. Akun Anda akan langsung aktif.', 'a_en' => 'Click the Register button in the top right corner, fill in your name, email, and password. Your account will be active immediately.'),
                    array('q' => 'Apa saja metode pembayaran?', 'q_en' => 'What payment methods are available?', 'a' => 'Kami menerima pembayaran online melalui QRIS, Virtual Account, GoPay, OVO, dan Kartu Kredit.', 'a_en' => 'We accept online payments via QRIS, Virtual Account, GoPay, OVO, and Credit Card.'),
                    array('q' => 'Apakah ada sertifikat?', 'q_en' => 'Is there a certificate?', 'a' => 'Ya! Setelah menyelesaikan 100% materi kursus, Anda akan mendapatkan sertifikat digital dengan kode unik yang bisa diverifikasi secara publik.', 'a_en' => 'Yes! After completing 100% of the course material, you will receive a digital certificate with a unique code that can be verified publicly.'),
                    array('q' => 'Berapa lama akses kursus?', 'q_en' => 'How long do I have access to courses?', 'a' => 'Setelah membeli kursus, Anda mendapatkan akses seumur hidup. Untuk membership, akses aktif selama periode berlangganan.', 'a_en' => 'After purchasing a course, you get lifetime access. For memberships, access is active during the subscription period.'),
                    array('q' => 'Bagaimana cara mendapatkan refund?', 'q_en' => 'How do I get a refund?', 'a' => 'Kami menyediakan garansi uang kembali 7 hari untuk kursus yang belum melebihi 30% progress.', 'a_en' => 'We provide a 7-day money-back guarantee for courses with less than 30% progress.'),
                ); ?>
                <?php foreach ($faqs as $i => $f): ?>
                    <div class="accordion-item border-0 mb-2 rounded-3 overflow-hidden">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#faq<?php echo $i; ?>">
                                <?php echo t($f['q'], $f['q_en']); ?>
                            </button>
                        </h2>
                        <div id="faq<?php echo $i; ?>" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body text-secondary small">
                                <?php echo t($f['a'], $f['a_en']); ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>
