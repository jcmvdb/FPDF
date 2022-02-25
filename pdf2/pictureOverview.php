<?php
$image = 'img/plategrond.png';
$pdf->AddPage();
list($x1, $y1) = getimagesize($image);
$ratio = $y1 / $pictureHeight;
$y = ($x1 / $ratio) / 2;
$x2 = 10;
$y2 = 70;

if (($x1 / $x2) < ($y1 / $y2)) {
    $y2 = 0;
} else {
    $x2 = 0;
}
$pdf->Image($image, $pdf->GetPageWidth() / 2 - ($y), 10, 0, $pictureHeight);