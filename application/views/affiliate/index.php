<div class="container py-5 my-4">
    <div class="text-center mb-5">
        <span class="badge bg-primary-subtle text-primary badge-modern mb-3"><?php echo t('Affiliate', 'Affiliate'); ?></span>
        <h1 class="display-5 fw-extrabold text-dark mb-3" style="letter-spacing:-0.03em;"><?php echo t('Program Affiliate', 'Affiliate Program'); ?></h1>
        <p class="text-secondary mx-auto" style="max-width:550px;"><?php echo t('Dapatkan komisi dengan merekomendasikan REBAS COURSE ke teman Anda!', 'Earn commissions by recommending REBAS COURSE to your friends!'); ?></p>
    </div>

    <div class="row g-4 mb-5">
        <div class="col-md-4">
            <div class="bento-card text-center">
                <div class="display-5 fw-extrabold text-primary"><?php echo $clicks; ?></div>
                <div class="text-secondary small fw-semibold text-uppercase"><?php echo t('Klik', 'Clicks'); ?></div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="bento-card text-center">
                <div class="display-5 fw-extrabold text-primary"><?php echo count($conversions); ?></div>
                <div class="text-secondary small fw-semibold text-uppercase"><?php echo t('Konversi', 'Conversions'); ?></div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="bento-card text-center">
                <div class="display-5 fw-extrabold text-success">Rp <?php echo number_format($affiliate->total_commission, 0, ',', '.'); ?></div>
                <div class="text-secondary small fw-semibold text-uppercase"><?php echo t('Komisi', 'Commission'); ?></div>
            </div>
        </div>
    </div>

    <div class="bento-card p-4 p-lg-5 mb-4">
        <h5 class="fw-bold text-dark mb-3"><?php echo t('Link Referral Anda', 'Your Referral Link'); ?></h5>
        <div class="d-flex gap-2">
            <input type="text" class="form-control" value="<?php echo $referral_link; ?>" id="refLink" readonly onclick="this.select();">
            <button class="btn btn-dark flex-shrink-0" onclick="copyRefLink()"><?php echo t('Salin', 'Copy'); ?></button>
        </div>
        <div class="mt-3 small text-muted">
            <?php echo t('Bagikan link ini ke teman Anda. Setiap pembelian melalui link Anda, Anda mendapat komisi 20%!', 'Share this link with your friends. For every purchase through your link, you earn 20% commission!'); ?>
        </div>
    </div>

    <?php if (!empty($conversions)): ?>
    <div class="bento-card p-4 p-xl-5">
        <h5 class="fw-bold text-dark mb-3"><?php echo t('Riwayat Komisi', 'Commission History'); ?></h5>
        <div class="table-responsive">
            <table class="table-modern">
                <thead><tr><th><?php echo t('Tanggal', 'Date'); ?></th><th><?php echo t('Status', 'Status'); ?></th><th><?php echo t('Komisi', 'Commission'); ?></th></tr></thead>
                <tbody>
                    <?php foreach ($conversions as $conv): ?>
                    <tr>
                        <td class="small"><?php echo date('d M Y', strtotime($conv->created_at ?? $conv->id)); ?></td>
                        <td><span class="badge badge-modern bg-<?php echo $conv->status === 'paid' ? 'success' : ($conv->status === 'pending' ? 'warning' : 'danger'); ?>"><?php echo ucfirst($conv->status); ?></span></td>
                        <td class="fw-bold text-dark">Rp <?php echo number_format($conv->commission, 0, ',', '.'); ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php endif; ?>
</div>
<script>
function copyRefLink() {
    var input = document.getElementById('refLink');
    input.select();
    document.execCommand('copy');
    alert('<?php echo t('Link disalin!', 'Link copied!'); ?>');
}
</script>
