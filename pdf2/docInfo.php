<?php
/**
 * the basic information for the PDF
 * SetTitle() is for the title of the PDF
 * SetAuthor() is for the name of the author
 */
$pdf = new PDF();
$pdf->SetTitle('Big book2');
$pdf->SetAuthor('RGN Brand Identity Services testing');
$pdf->SetSubject("inventory of a store");
$pdf->SetKeywords('bigbook simple fine');

$pdf->AliasNbPages();
$pdf->SetFont('Times', '', 14);

include 'frontpage.php';

$pdf->SetMargins(10, 10, 10);
$pdf->startPageNums();

// controls if you want to download the pdf or sent the pdf to the browser to look at the pdf
$dest = $_POST['D'];

if ($dest === null) {
    $dest = $_POST['I'];
}