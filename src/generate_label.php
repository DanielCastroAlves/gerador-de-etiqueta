<?php
require_once __DIR__ . '/../vendor/autoload.php';

use TCPDF;

try {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $larguraEtiqueta = (float)$_POST['largura'];
        $alturaEtiqueta = (float)$_POST['altura'];

        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, 'A4', true, 'UTF-8', false);

        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Seu Nome');
        $pdf->SetTitle('Etiqueta WMS');
        $pdf->SetSubject('Etiqueta WMS');
        $pdf->SetKeywords('TCPDF, PDF, etiqueta, WMS');

        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);

        $pdf->SetMargins(0, 0, 0);

        $pdf->AddPage();

        $xEtiqueta = (210 - $larguraEtiqueta) / 2; 
        $yEtiqueta = (297 - $alturaEtiqueta) / 2;
        $pdf->Rect($xEtiqueta, $yEtiqueta, $larguraEtiqueta, $alturaEtiqueta, 'D');

        $pdf->SetFont('helvetica', '', 12);

        $fields = ['produto', 'codigo_barras', 'peso', 'validade'];
        foreach ($fields as $field) {
            if (isset($_POST[$field . '_x']) && isset($_POST[$field . '_y']) && isset($_POST[$field])) {
                $x = (float)$_POST[$field . '_x'] + $xEtiqueta;
                $y = (float)$_POST[$field . '_y'] + $yEtiqueta; 
                $content = $_POST[$field];
                $pdf->SetXY($x, $y);
                if ($field === 'codigo_barras') {
                    $style = array(
                        'position' => '',
                        'align' => 'C',
                        'stretch' => false,
                        'fitwidth' => true,
                        'cellfitalign' => '',
                        'border' => true,
                        'hpadding' => 'auto',
                        'vpadding' => 'auto',
                        'fgcolor' => array(0,0,0),
                        'bgcolor' => false,
                        'text' => true,
                        'font' => 'helvetica',
                        'fontsize' => 10,
                        'stretchtext' => 4
                    );
                    $pdf->write1DBarcode($content, 'C128', $x, $y, '', 18, 0.4, $style, 'N');
                } else {
                    $pdf->Cell(0, 10, $content, 0, 1);
                }
            }
        }

        ob_clean(); 
        $pdf->Output('etiqueta_wms.pdf', 'I');
    } else {
        echo "Método de requisição inválido.";
    }
} catch (Exception $e) {
    ob_clean(); 
    echo 'Erro ao gerar o PDF: ' . $e->getMessage();
}
?>
