<div class="container-fluid px-0">

    <!-- ============ HEADER (hero) ============ -->
    <div class="bento-card mb-4 overflow-hidden" style="background:linear-gradient(120deg,#0D1830 0%,#7c3aed 130%);border:none;color:#fff;">
        <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3 position-relative" style="z-index:1;">
            <div>
                <span class="d-inline-flex align-items-center gap-1" style="background:rgba(255,255,255,0.14);border:1px solid rgba(255,255,255,0.2);color:#FBBF24;font-size:0.66rem;font-weight:800;letter-spacing:0.12em;text-transform:uppercase;padding:0.3rem 0.7rem;border-radius:100px;">
                    <i data-lucide="gift" style="width:12px;height:12px;"></i> <?php echo t('Affiliate', 'Affiliate'); ?>
                </span>
                <h1 class="fw-extrabold text-white mb-1 mt-2 lh-sm" style="letter-spacing:-0.03em;font-size:1.6rem;">
                    <?php echo t('Program Affiliate', 'Affiliate Program'); ?>
                </h1>
                <p class="mb-0" style="color:rgba(255,255,255,0.72);font-size:0.82rem;max-width:34rem;">
                    <?php echo t('Dapatkan komisi dengan merekomendasikan BISATUNTAS ke teman Anda!', 'Earn commissions by recommending BISATUNTAS to your friends!'); ?>
                </p>
            </div>
            <div class="text-md-end flex-shrink-0">
                <div class="d-inline-flex align-items-center gap-2 px-3 py-2 rounded-pill fw-bold" style="background:rgba(251,191,36,0.18);border:1px solid rgba(251,191,36,0.4);color:#FBBF24;font-size:0.8rem;">
                    <i data-lucide="percent" style="width:14px;height:14px;"></i> <?php echo t('Komisi 20%', '20% Commission'); ?>
                </div>
            </div>
        </div>
    </div>

    <!-- ============ STATS ============ -->
    <div class="bento-grid bento-grid-3 mb-4">
        <div class="bento-card blob-primary d-flex align-items-center gap-3">
            <div class="bento-icon bg-primary-subtle text-primary"><i data-lucide="mouse-pointer-click" style="width:22px;height:22px;"></i></div>
            <div>
                <div class="bento-label"><?php echo t('Total Klik', 'Total Clicks'); ?></div>
                <div class="bento-value"><?php echo $clicks; ?></div>
            </div>
        </div>
        <div class="bento-card blob-warning d-flex align-items-center gap-3">
            <div class="bento-icon bg-warning-subtle text-warning"><i data-lucide="shopping-cart" style="width:22px;height:22px;"></i></div>
            <div>
                <div class="bento-label"><?php echo t('Konversi', 'Conversions'); ?></div>
                <div class="bento-value"><?php echo count($conversions); ?></div>
            </div>
        </div>
        <div class="bento-card blob-success d-flex align-items-center gap-3">
            <div class="bento-icon bg-success-subtle text-success"><i data-lucide="wallet" style="width:22px;height:22px;"></i></div>
            <div>
                <div class="bento-label"><?php echo t('Total Komisi', 'Total Commission'); ?></div>
                <div class="bento-value" style="font-size:1.4rem;">Rp <?php echo number_format($affiliate->total_commission, 0, ',', '.'); ?></div>
            </div>
        </div>
    </div>

    <!-- ============ REFERRAL LINK ============ -->
    <div class="bento-card mb-4 overflow-hidden">
        <div class="d-flex align-items-center gap-2 px-4 py-3" style="background:linear-gradient(90deg, rgba(0,150,136,0.08), transparent);border-bottom:1px solid var(--card-border,#eef0f3);">
            <i data-lucide="link-2" style="width:16px;height:16px;color:var(--primary);"></i>
            <span class="fw-bold text-dark" style="font-size:0.88rem;"><?php echo t('Link Referral Anda', 'Your Referral Link'); ?></span>
        </div>
        <div class="p-4">
            <div class="input-group input-group-lg">
                <input type="text" class="form-control text-truncate" value="<?php echo $referral_link; ?>" id="refLink" readonly onclick="this.select();" style="min-width:0;border-radius:12px 0 0 12px;font-family:monospace;font-size:0.82rem;height:48px;background:var(--gray-50,#f8fafc);">
                <button class="btn fw-bold d-inline-flex align-items-center gap-2 border-0" onclick="copyRefLink()" type="button" style="background:#0D1830;color:#fff;border-radius:0 12px 12px 0;font-size:0.8rem;padding:0 1.2rem;">
                    <i data-lucide="copy" style="width:15px;height:15px;"></i> <?php echo t('Salin', 'Copy'); ?>
                </button>
            </div>
            <div class="d-flex align-items-start gap-2 mt-3">
                <i data-lucide="info" style="width:14px;height:14px;color:var(--gray-400,#94a3b8);flex-shrink:0;margin-top:1px;"></i>
                <span class="text-secondary" style="font-size:0.76rem;line-height:1.6;"><?php echo t('Bagikan link ini ke teman Anda. Setiap pembelian melalui link Anda, Anda mendapat komisi 20%!', 'Share this link with your friends. For every purchase through your link, you earn 20% commission!'); ?></span>
            </div>
        </div>
    </div>

    <!-- ============ COMMISSION HISTORY ============ -->
    <?php if (!empty($conversions)): ?>
    <div class="bento-card">
        <div class="d-flex align-items-center justify-content-between px-4 py-3" style="border-bottom:1px solid var(--card-border,#eef0f3);">
            <h6 class="fw-bold text-dark mb-0 d-flex align-items-center gap-2" style="font-size:0.88rem;">
                <i data-lucide="history" style="width:16px;height:16px;color:var(--primary);"></i> <?php echo t('Riwayat Komisi', 'Commission History'); ?>
            </h6>
            <span class="px-2 py-1 rounded-pill fw-bold" style="background:#E6EBEF;color:#57534e;font-size:0.62rem;"><?php echo count($conversions); ?></span>
        </div>
        <div class="table-responsive">
            <table class="table mb-0 align-middle" style="font-size:0.82rem;">
                <thead>
                    <tr>
                        <th class="text-uppercase small" style="font-weight:600;color:var(--gray-500,#78716c);font-size:0.65rem;letter-spacing:0.05em;border-color:#f0eeeb;background:#f8fafc;"><?php echo t('Tanggal', 'Date'); ?></th>
                        <th class="text-uppercase small" style="font-weight:600;color:var(--gray-500,#78716c);font-size:0.65rem;letter-spacing:0.05em;border-color:#f0eeeb;background:#f8fafc;"><?php echo t('Status', 'Status'); ?></th>
                        <th class="text-uppercase small text-end" style="font-weight:600;color:var(--gray-500,#78716c);font-size:0.65rem;letter-spacing:0.05em;border-color:#f0eeeb;background:#f8fafc;"><?php echo t('Komisi', 'Commission'); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($conversions as $conv): ?>
                        <?php
                            if ($conv->status === 'paid') { $cb='#E0F2F1'; $ct='#009688'; }
                            elseif ($conv->status === 'pending') { $cb='#fffbeb'; $ct='#d97706'; }
                            else { $cb='#fef2f2'; $ct='#dc2626'; }
                        ?>
                    <tr>
                        <td style="border-color:#f0eeeb;padding:0.65rem 1rem;color:#57534e;"><?php echo date('d M Y', strtotime($conv->created_at ?? $conv->id)); ?></td>
                        <td style="border-color:#f0eeeb;padding:0.65rem 1rem;">
                            <span class="px-2 py-1 rounded-pill fw-semibold" style="background:<?php echo $cb; ?>;color:<?php echo $ct; ?>;font-size:0.65rem;"><?php echo ucfirst($conv->status); ?></span>
                        </td>
                        <td class="fw-bold text-dark text-end text-nowrap" style="border-color:#f0eeeb;padding:0.65rem 1rem;">Rp <?php echo number_format($conv->commission, 0, ',', '.'); ?></td>
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
