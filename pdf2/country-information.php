<?php
/**
 *  This is all the information that is shown in the summary of a country
 * all the locations of acountry are shown in 1 summary
 */
$pdf->AddPage();
/** this is the information what is shown in the Table of content **/
$pdf->TOC_Entry($countryItem['Name']);
$pdf->SetFont('Times', 'B', 20);


$pdf->Cell($pdf->GetPageWidth() - 20, 20, $countryItem['Name'], 0, 1);
$pdf->SetFont('Times', '', 14);
$pdf->Ln(7.5); // gives a margin between country name and cities

$pdf->Cell(50, 10, 'Number of location: ' . $count, 0, 1);
$pdf->Ln(5);
$pdf->setFillColor(150, 150, 150); // grey
$pdf->SetFont('Times', 'B', 16);
$pdf->Cell(40, $cellH, 'LocationId');
$pdf->Cell(69.25, $cellH, 'Name');
$pdf->Cell(69.25, $cellH, 'City');
$pdf->Cell(69.25, $cellH, 'PageNumber', 0, 1);
$pdf->SetFont('Times', '', 14);
$pdf->Ln(4.5);
foreach ($location as $locationItem) {
    $pdf->Cell(40, $cellH, $countryItem['landcode'] . '-' . $locationItem['locationId']);
    $pdf->Cell(69.25, $cellH, $locationItem['name']);
    $pdf->Cell(69.25, $cellH, $locationItem['city']);
    $pdf->Cell(69.25, $cellH, 'niet beschikbaar', 0, 1);
}
$pdf->Cell(50, $cellH, 'County-Information.php', 1, 1);
