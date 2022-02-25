<?php
$pdf->AddPage();
$pdf->SetFont('Times', '', 25);
$pdf->Cell(50, 20, $countryItem['landcode'] . '-' . $locationItem['locationId'] . ' - ' . $objectItem['objectId']);
$pdf->SetFont('Times', '', 14);
$pdf->Cell(25, $cellH, 'type');
$pdf->Cell(80, $cellH, $objectItem['type']);
$pdf->Cell(20, $cellH, 'Width: ');
$pdf->Cell(20, $cellH, $objectItem['width']);
$pdf->Cell(30, $cellH, 'Store section: ');
$pdf->Cell(20, $cellH, $objectItem['storeSection'], 0, 1);

$pdf->Cell(50);
$pdf->Cell(25, $cellH, 'material');
$pdf->Cell(80, $cellH, $objectItem['material']);
$pdf->Cell(20, $cellH, 'Height: ');
$pdf->Cell(20, $cellH, $objectItem['height']);
$pdf->Cell(30, $cellH, 'Refresh: ');
$pdf->Cell(20, $cellH, 'oh nee', 0, 1);

$pdf->Line(10, 40, $pdf->GetPageWidth() - 20, 40);


list($x1, $y1) = getimagesize('img/'.$objectItem['picture']);
$ratio = $y1 / $pictureHeight;
$y = ($x1 / $ratio) / 2;
$x2 = 10;
$y2 = 70;
if (($x1 / $x2) < ($y1 / $y2)) {
    $y2 = 0;
} else {
    $x2 = 0;
}
$pdf->Cell($pdf->GetPageWidth(), 120, "", 0, 1, 'C', $pdf->Image('img/'.$objectItem['picture'], $pdf->GetPageWidth() / 2 - ($y), 50, 0, $pictureHeight));
//$pdf->Cell(50, 10, 'img/'.$objectItem['picture'], 1, 1);
//$pdf->Cell(50, 10, 'object.php', 1);