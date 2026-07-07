<?php
defined('BASEPATH') OR exit('No direct script access allowed');

function send_email($to, $subject, $html_body, $from = null) {
    $CI =& get_instance();

    $api_key = setting('mailgun_api_key', '');
    $domain = setting('mailgun_domain', '');

    if ($api_key && $domain) {
        return _send_mailgun($api_key, $domain, $to, $subject, $html_body, $from);
    }

    $smtp_host = setting('smtp_host', '');
    if ($smtp_host) {
        return _send_smtp($to, $subject, $html_body, $from);
    }

    return false;
}

function _send_mailgun($api_key, $domain, $to, $subject, $html_body, $from = null) {
    $CI =& get_instance();
    $from = $from ?: setting('general_admin_email', 'admin@rebas-course.com');
    $from_name = setting('general_site_name', 'REBAS COURSE');

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://api.mailgun.net/v3/{$domain}/messages");
    curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    curl_setopt($ch, CURLOPT_USERPWD, "api:{$api_key}");
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, array(
        'from'    => "{$from_name} <{$from}>",
        'to'      => $to,
        'subject' => $subject,
        'html'    => $html_body,
    ));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    $result = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    return $http_code >= 200 && $http_code < 300;
}

function _send_smtp($to, $subject, $html_body, $from = null) {
    $CI =& get_instance();
    $from = $from ?: setting('general_admin_email', 'admin@rebas-course.com');
    $from_name = setting('general_site_name', 'REBAS COURSE');

    $headers = "MIME-Version: 1.0\r\n";
    $headers .= "Content-type: text/html; charset=UTF-8\r\n";
    $headers .= "From: {$from_name} <{$from}>\r\n";
    $headers .= "Reply-To: {$from}\r\n";

    return mail($to, $subject, $html_body, $headers);
}

function email_template($title, $body, $cta_text = '', $cta_link = '') {
    $site_name = setting('general_site_name', 'REBAS COURSE');
    $logo = site_logo_url();
    $logo_html = $logo ? "<img src=\"{$logo}\" alt=\"{$site_name}\" style=\"height:32px;\">" : "<strong>{$site_name}</strong>";

    return <<<HTML
<!DOCTYPE html>
<html>
<head><meta charset="UTF-8"></head>
<body style="margin:0;padding:0;background:#f4f6f9;font-family:'Inter',Arial,sans-serif;">
    <table width="100%" cellpadding="0" cellspacing="0">
        <tr><td align="center" style="padding:40px 20px;">
            <table width="560" cellpadding="0" cellspacing="0" style="background:#fff;border-radius:16px;overflow:hidden;">
                <tr><td style="padding:32px 32px 8px;text-align:center;border-bottom:1px solid #eee;">
                    {$logo_html}
                </td></tr>
                <tr><td style="padding:32px;">
                    <h1 style="font-size:22px;font-weight:800;color:#0f172a;margin:0 0 16px;">{$title}</h1>
                    <p style="font-size:14px;color:#475569;line-height:1.7;margin:0 0 24px;">{$body}</p>
HTML;
    if ($cta_text && $cta_link) {
        $html .= <<<HTML
                    <a href="{$cta_link}" style="display:inline-block;padding:12px 28px;background:#6366f1;color:#fff;text-decoration:none;border-radius:100px;font-weight:600;font-size:14px;">{$cta_text}</a>
HTML;
    }
    $html .= <<<HTML
                </td></tr>
                <tr><td style="padding:24px 32px;background:#f8fafc;text-align:center;">
                    <p style="font-size:12px;color:#94a3b8;margin:0;">&copy; 2026 {$site_name}. All rights reserved.</p>
                </td></tr>
            </table>
        </td></tr>
    </table>
</body>
</html>
HTML;
}
