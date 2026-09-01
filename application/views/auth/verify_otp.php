<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$auth_title = t('Verifikasi WhatsApp 📱', 'Verify WhatsApp 📱');
$auth_subtitle = t('Masukkan kode OTP yang dikirim ke nomor WhatsApp Anda', 'Enter the OTP code sent to your WhatsApp number');
$auth_icon = 'fab fa-whatsapp';
$auth_visual_title = t('Konfirmasi Nomor Anda.', 'Confirm Your Number.');
$auth_visual_sub = t('Kode OTP dikirim ke nomor WhatsApp Anda untuk memverifikasi pendaftaran.', 'An OTP code was sent to your WhatsApp number to verify your registration.');
$auth_form_action = 'auth/register';
$auth_submit_text = t('Verifikasi Kode', 'Verify Code');
$auth_google_text = '';
$auth_footer_text = t('Belum menerima kode?', "Didn't receive the code?");
$auth_footer_link = t('Kirim Ulang', 'Resend');
$auth_footer_url = '#';

// Field form verifikasi OTP
ob_start();
?>
<div class="au2-field">
    <label for="otp_code"><?php echo t('Kode OTP', 'OTP Code'); ?></label>
    <div class="au2-input-wrap">
        <i class="fas fa-key"></i>
        <input type="text" name="otp_code" id="otp_code" required placeholder="6 digit" maxlength="6" inputmode="numeric" autocomplete="one-time-code" autofocus>
    </div>
    <small style="color:#9ca3af; font-size:0.72rem; display:block; margin-top:0.3rem;">
        <?php echo t('Dikirim ke: ', 'Sent to: '); ?><?php echo htmlspecialchars($phone); ?>
    </small>
</div>
<?php
$auth_form_fields = ob_get_clean();

include '_auth_layout.php';
?>

<script>
// Tombol "Kirim Ulang" → submit form dengan flag resend
document.addEventListener('DOMContentLoaded', function () {
    var foot = document.querySelector('.au2-form-foot a');
    if (foot) {
        foot.addEventListener('click', function (e) {
            e.preventDefault();
            var form = document.querySelector('.au2-form');
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
