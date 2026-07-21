<div class="affiliate-page">
    <div class="text-center mb-4 mb-md-5">
        <span class="badge bg-primary-subtle text-primary badge-modern mb-3"><?php echo t('Affiliate', 'Affiliate'); ?></span>
        <h1 class="fw-extrabold text-dark mb-2 mb-md-3 page-title" style="letter-spacing:-0.03em;"><?php echo t('Program Affiliate', 'Affiliate Program'); ?></h1>
        <p class="text-secondary mx-auto small mb-0" style="max-width:550px;"><?php echo t('Dapatkan komisi dengan merekomendasikan BISATUNTAS ke teman Anda!', 'Earn commissions by recommending BISATUNTAS to your friends!'); ?></p>
    </div>

    <div class="row g-3 g-md-4 mb-4 mb-md-5">
        <div class="col-6 col-md-4 d-flex">
            <div class="bento-card stat-mini text-center w-100 d-flex flex-column align-items-center justify-content-center">
                <div class="stat-mini-value text-primary"><?php echo $clicks; ?></div>
                <div class="stat-mini-label text-secondary"><?php echo t('Klik', 'Clicks'); ?></div>
            </div>
        </div>
        <div class="col-6 col-md-4 d-flex">
            <div class="bento-card stat-mini text-center w-100 d-flex flex-column align-items-center justify-content-center">
                <div class="stat-mini-value text-primary"><?php echo count($conversions); ?></div>
                <div class="stat-mini-label text-secondary"><?php echo t('Konversi', 'Conversions'); ?></div>
            </div>
        </div>
        <div class="col-12 col-md-4 d-flex">
            <div class="bento-card stat-mini text-center w-100 d-flex flex-column align-items-center justify-content-center">
                <div class="stat-mini-value text-success text-break">Rp <?php echo number_format($affiliate->total_commission, 0, ',', '.'); ?></div>
                <div class="stat-mini-label text-secondary"><?php echo t('Komisi', 'Commission'); ?></div>
            </div>
        </div>
    </div>

    <div class="bento-card p-3 p-md-4 p-lg-5 mb-4">
        <h5 class="fw-bold text-dark mb-3"><?php echo t('Link Referral Anda', 'Your Referral Link'); ?></h5>
        <div class="input-group flex-nowrap">
            <input type="text" class="form-control text-truncate" value="<?php echo $referral_link; ?>" id="refLink" readonly onclick="this.select();" style="min-width:0;">
            <button class="btn btn-dark flex-shrink-0 d-inline-flex align-items-center gap-1" onclick="copyRefLink()" type="button">
                <i data-lucide="copy" style="width:14px;height:14px;"></i>
                <span><?php echo t('Salin', 'Copy'); ?></span>
            </button>
        </div>
        <div class="mt-3 small text-muted">
            <?php echo t('Bagikan link ini ke teman Anda. Setiap pembelian melalui link Anda, Anda mendapat komisi 20%!', 'Share this link with your friends. For every purchase through your link, you earn 20% commission!'); ?>
        </div>
    </div>

    <?php if (!empty($conversions)): ?>
    <div class="bento-card p-3 p-md-4 p-xl-5">
        <h5 class="fw-bold text-dark mb-3"><?php echo t('Riwayat Komisi', 'Commission History'); ?></h5>
        <div class="table-responsive -mx-card">
            <table class="table-modern mb-0" style="min-width:420px;">
                <thead><tr><th><?php echo t('Tanggal', 'Date'); ?></th><th><?php echo t('Status', 'Status'); ?></th><th class="text-end"><?php echo t('Komisi', 'Commission'); ?></th></tr></thead>
                <tbody>
                    <?php foreach ($conversions as $conv): ?>
                    <tr>
                        <td class="small text-nowrap"><?php echo date('d M Y', strtotime($conv->created_at ?? $conv->id)); ?></td>
                        <td><span class="badge badge-modern bg-<?php echo $conv->status === 'paid' ? 'success' : ($conv->status === 'pending' ? 'warning' : 'danger'); ?>"><?php echo ucfirst($conv->status); ?></span></td>
                        <td class="fw-bold text-dark text-end text-nowrap">Rp <?php echo number_format($conv->commission, 0, ',', '.'); ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php endif; ?>
</div>

<style>
.affiliate-page .page-title { font-size: 1.5rem; }
.affiliate-page .stat-mini { padding: 1rem 0.75rem; min-height: 110px; }
.affiliate-page .stat-mini-value {
    font-size: 1.375rem;
    font-weight: 800;
    line-height: 1.15;
    word-break: break-word;
    max-width: 100%;
}
.affiliate-page .stat-mini-label {
    font-size: 0.7rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    margin-top: 0.375rem;
}
@media (min-width: 576px) {
    .affiliate-page .page-title { font-size: 1.75rem; }
    .affiliate-page .stat-mini-value { font-size: 1.75rem; }
}
@media (min-width: 768px) {
    .affiliate-page .page-title { font-size: 2.25rem; }
    .affiliate-page .stat-mini { padding: 1.5rem 1rem; min-height: 140px; }
    .affiliate-page .stat-mini-value { font-size: 2.25rem; }
    .affiliate-page .stat-mini-label { font-size: 0.75rem; }
}
@media (min-width: 992px) {
    .affiliate-page .page-title { font-size: 2.75rem; }
    .affiliate-page .stat-mini-value { font-size: 2.5rem; }
}
</style>

<script>
function copyRefLink() {
    var input = document.getElementById('refLink');
    input.select();
    input.setSelectionRange(0, 99999);
    try {
        document.execCommand('copy');
            Swal.fire({ toast: true, position: 'top-end', showConfirmButton: false, timer: 3000, icon: 'success', title: '<?php echo t('Link disalin!', 'Link copied!'); ?>' });
    } catch (e) {
        if (navigator.clipboard) {
            navigator.clipboard.writeText(input.value);
        Swal.fire({ toast: true, position: 'top-end', showConfirmButton: false, timer: 3000, icon: 'success', title: '<?php echo t('Link disalin!', 'Link copied!'); ?>' });
        }
    }
}
</script>
