<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$auth_kicker = t('Langkah Terakhir', 'Final Step');
$auth_title = t('Verifikasi WhatsApp 📱', 'Verify WhatsApp 📱');
$auth_subtitle = t('Masukkan 6 digit kode OTP yang dikirim ke WhatsApp Anda', 'Enter the 6-digit OTP code sent to your WhatsApp');
$auth_icon = 'fa-shield-halved';
$auth_visual_title = t('Hampir Selesai.', 'Almost There.');
$auth_visual_sub = t('Verifikasi nomor WhatsApp membantu kami menjaga keamanan akunmu.', 'Verifying your WhatsApp number helps us keep your account secure.');
$auth_form_action = 'auth/register';
$auth_submit_text = t('Verifikasi Kode', 'Verify Code');
$auth_submit_loading = t('Memverifikasi…', 'Verifying…');
$auth_google_text = '';
$auth_footer_text = t('Belum menerima kode?', "Didn't receive the code?");
$auth_footer_link = t('Kirim Ulang', 'Resend');
$auth_footer_url = '#';

// Field form verifikasi OTP
ob_start();
?>
<div class="bta-field">
    <label for="otp_code"><?php echo t('Kode OTP', 'OTP Code'); ?></label>
    <div class="bta-input-wrap">
        <i class="fas fa-key"></i>
        <input type="text" name="otp_code" id="otp_code" class="bta-input" style="letter-spacing:0.35em;font-weight:700;" required placeholder="000000" maxlength="6" inputmode="numeric" pattern="[0-9]{6}" autocomplete="one-time-code" autofocus>
    </div>
    <span class="bta-note"><?php echo t('Dikirim ke: ', 'Sent to: '); ?><strong><?php echo htmlspecialchars($phone); ?></strong></span>
</div>
<?php
$auth_form_fields = ob_get_clean();

include '_auth_layout.php';
?>

<script>
document.addEventListener('DOMContentLoaded', function () {
    var foot = document.querySelector('.bta-foot-link');
    if (foot) {
        foot.addEventListener('click', function (e) {
            e.preventDefault();
            var form = document.querySelector('.bta-form');
            form.action = '<?php echo base_url("auth/verify-otp"); ?>';
            var input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'resend';
            input.value = '1';
            form.appendChild(input);
            form.submit();
        });
    }
});
</script>
