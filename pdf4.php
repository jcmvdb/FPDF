<?php
//require_once 'functions.php';
require 'functions.php';
require 'db/db2.php';
$db = new DB();

$country = $db->Read('country', '*', '1');

// Read the JSON file
$json = file_get_contents('zip/brandedAssets.json');

// Decode the JSON file
$json_data = json_decode($json, true);
$count = 0;




$pdf = new PDF();
$pdf->SetTitle('Big book');
$pdf->SetAuthor('RGN Brand Identity Services');
$pdf->SetSubject("Subject of something");
$pdf->SetKeywords('bigbook simple fine');

$pdf->AliasNbPages();
$pdf->SetFont('Times', '', 14);

//Front page
$pdf->SetMargins(0, 0, 0);
$pdf->AddPage();
$pdf->Ln(100);
$pdf->Cell($pdf->GetPageWidth() - 20, 10, 'Dit is een Test Bestand', 0 , 0, 'C');
//$pdf->Image('img/whiteCircle2.jpeg', 0, 0, $pdf->GetPageWidth(), $pdf->GetPageHeight());

$pdf->SetMargins(10, 10, 10);
$pdf->startPageNums();

$pdf->AddPage();
$pdf->Cell(50, 10, "test");
$pdf->TOC_Entry('tes  t', 1);
    $pdf->Cell(50, 10, $json_data[1] . " testing");
foreach ($json_data as $values) {
    if ($values['Prime costs (DisplayUnit)'] == 233) {
//    $pdf->TOC_Entry($values['Id'], 1);
        $pdf->AddPage();
        $pdf->Cell(30, 10, 'Id:');
//    $pdf->Cell(50, 10, $values['Id'], 0, 1);
        $pdf->MultiCell(50, 10, $values['Id']);
        $pdf->Cell(30, 10, 'Type:');
        $pdf->Cell(50, 10, $values['Type'], 0, 1);
        $pdf->Cell(30, 10, 'Status:');
        $pdf->Cell(50, 10, $values['Status'], 0, 1);
        $pdf->Cell(30, 10, 'Width:');
        $pdf->Cell(50, 10, $values['Content width (DisplayUnit)'], 0, 1);
        $pdf->Cell(30, 10, 'Height:');
        $pdf->Cell(50, 10, $values['Content height (DisplayUnit)'], 0, 1);
        $pdf->Cell(30, 10, 'Class:');
        $pdf->Cell(50, 10, $values['Class'], 0, 1);
        $pdf->Cell(30, 10, 'Class:');
        $pdf->Cell(50, 10, $values['Asset ID'], 0, 1);
    }
}

$pdf->stopPageNums();
$pdf->insertTOC(2);
$pdf->Output('I', 'RGN.pdf');