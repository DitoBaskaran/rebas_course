<?php defined('BASEPATH') OR exit('No direct script allowed');

/**
 * PDF Helper — Generate certificate PDF using dompdf
 */
function generate_certificate_pdf($cert_data) {
    $CI =& get_instance();

    $html = $CI->load->view('certificate/pdf_template', $cert_data, TRUE);

    $options = new \Dompdf\Options();
    $options->set('isRemoteEnabled', true);
    $options->set('isHtml5ParserEnabled', true);
    $options->set('defaultFont', 'sans-serif');
    $options->set('isFontSubsettingEnabled', true);
    $options->set('isPhpEnabled', true);
    // Izinkan dompdf mengakses file lokal (logo, aset) dari root project
    $options->set('chroot', FCPATH);

    $dompdf = new \Dompdf\Dompdf($options);
    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'landscape');
    $dompdf->render();

    return $dompdf;
}

function download_certificate_pdf($cert_data) {
    $dompdf = generate_certificate_pdf($cert_data);
    $filename = 'Sertifikat-' . $cert_data['certificate_code'] . '.pdf';
    $dompdf->stream($filename, array('Attachment' => true));
    exit;
}
