<?php
/**
 * Alles in dit bestand is een hoax
 */

$pdf->AddPage();
$pdf->Cell(200, 15, $locationItem['name'], 1, 1);
$pdf->Ln(11);
$pdf->Cell(100, $cellH, 'LOCATION INFORMATION', 0, 1);
$pdf->Ln(11);
$pdf->Cell(40, $cellH, 'LocationCode:');
$pdf->Cell(120, $cellH, $countryItem['landcode'] . '-' . $locationItem['locationId']);
$pdf->Ln(10);
$pdf->Cell(40, $cellH, 'Adress:');
$pdf->Cell(120, $cellH, $locationItem['city']);
$pdf->cell(null, null, '', 0, 1);
$pdf->Ln(20);


/**
 * the information of all objects
 */
$pdf->SetFont('Times', 'B', 17);
$pdf->Cell(250, $cellH, 'OBJECTS', 0, 1);
$pdf->SetFont('Times', '', 14);

$pdf->Cell(30, 20, 'Code', 1, 0, '', true);
$pdf->Cell(70, 20, 'Type', 1, 0, '', true);
$pdf->Cell(30, 20, 'Width (in M)', 1, 0, '', true);
$pdf->Cell(30, 20, 'Height (in M)', 1, 0, '', true);
$pdf->Cell(30, 20, 'Store Section', 1, 0, '', true);
$pdf->Cell(60, 20, 'Material', 1, 1, '', true);

foreach ($object as $objectItem) {
    $pdf->Cell(30, $cellH, $countryItem['landcode'] . '-' . $locationItem['locationId'] . ' - ' . $objectItem['objectId'], 1);
    $pdf->Cell(70, $cellH, $objectItem['type'], 1);
    $pdf->Cell(30, $cellH, $objectItem['width'], 1);
    $pdf->Cell(30, $cellH, $objectItem['height'], 1);
    $pdf->Cell(30, $cellH, $objectItem['storeSection'], 1);
    $pdf->Cell(60, $cellH, $objectItem['material'], 1, 1);
}
//$pdf->Cell(50, $cellH, 'objectsummary.php', 1, 1);