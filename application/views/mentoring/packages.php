<!-- Header -->
<div style="border-bottom: 1px solid #e5e5e5;">
    <div class="container text-center" style="padding-top: 2rem; padding-bottom: 1.5rem; max-width: 960px;">
        <h1 class="fw-extrabold mb-2" style="font-size: 1.5rem; letter-spacing: -0.02em; color: #111827;">
            <?php echo t('Paket Mentoring', 'Mentoring Packages'); ?>
        </h1>
        <p class="mb-0 mx-auto" style="color: #737373; font-size: 0.9rem; max-width: 500px;">
            <?php echo t('Pilih paket yang sesuai dengan kebutuhanmu', 'Choose the package that suits your needs'); ?>
        </p>
    </div>
</div>

<!-- Packages -->
<div class="container" style="max-width: 960px; padding-top: 2rem; padding-bottom: 3rem;">
    <div class="row g-4 justify-content-center">
        <?php foreach ($packages as $i => $pkg): ?>
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 <?php echo $i === 1 ? 'border-2' : ''; ?>" style="border-color: <?php echo $i === 1 ? '#009688' : '#e5e5e5'; ?>; border-radius: 12px; transition: all 0.15s; position: relative; overflow: visible;">
                    <?php if ($i === 1): ?>
                        <div class="position-absolute px-3 py-1 rounded-pill fw-bold" style="top: -10px; left: 50%; transform: translateX(-50%); background: #009688; color: #111827; font-size: 0.65rem;">
                            <?php echo t('Paling Populer', 'Most Popular'); ?>
                        </div>
                    <?php endif; ?>
                    <div class="card-body p-4 text-center d-flex flex-column">
                        <div class="mb-3">
                            <div class="d-inline-flex align-items-center justify-content-center rounded-3" style="width: 48px; height: 48px; background: #fef3c7;">
                                <i class="fas fa-user-graduate" style="color: #d97706; font-size: 1.1rem;"></i>
                            </div>
                        </div>
                        <h5 class="fw-bold mb-1" style="color: #111827; font-size: 1rem;"><?php echo htmlspecialchars(t($pkg->name, $pkg->name_en)); ?></h5>
                        <p class="mb-3" style="color: #737373; font-size: 0.8rem; line-height: 1.5;">
                            <?php echo htmlspecialchars(t($pkg->description, $pkg->description_en)); ?>
                        </p>
                        <div class="d-flex justify-content-center gap-4 mb-3 py-3 border-top border-bottom" style="border-color: #f0f0f0 !important;">
                            <div class="text-center">
                                <div class="fw-bold" style="color: #111827; font-size: 1.3rem; line-height: 1;"><?php echo $pkg->session_count; ?>x</div>
                                <small style="color: #a3a3a3; font-size: 0.7rem;"><?php echo t('Sesi', 'Sessions'); ?></small>
                            </div>
                            <div style="width: 1px; background: #f0f0f0;"></div>
                            <div class="text-center">
                                <div class="fw-bold" style="color: #111827; font-size: 1.3rem; line-height: 1;"><?php echo $pkg->session_duration; ?>m</div>
                                <small style="color: #a3a3a3; font-size: 0.7rem;"><?php echo t('/Sesi', '/Session'); ?></small>
                            </div>
                        </div>
                        <div class="fw-bold mb-3" style="color: #111827; font-size: 1.6rem;">
                            Rp <?php echo number_format($pkg->price, 0, ',', '.'); ?>
                        </div>
                        <a href="<?php echo base_url('mentoring/buy-package/' . encode_id($pkg->id)); ?>" class="btn py-2 fw-bold rounded-pill w-100 mt-auto" style="background: <?php echo $i === 1 ? '#111827' : '#f5f5f5'; ?>; color: <?php echo $i === 1 ? '#fff' : '#111827'; ?>; font-size: 0.85rem;">
                            <?php echo t('Pilih Paket', 'Choose Package'); ?>
                        </a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
