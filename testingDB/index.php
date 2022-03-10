<?php
//require '../db/db2.php';
//require '../functions.php';
//$db = new DB();
//$country = $db->Read('country');
//require('fpdf.php');
//require '../../RGNMamp/fpdf184/fpdf.php';
require '../../RGNMamp/fpdf184/fpdf.php';

class PDF extends FPDF
{
// Page header
    function Header()
    {
        // Logo
        $this->Image('logo.png',10,6,30);
        // Arial bold 15
        $this->SetFont('Arial','B',15);
        // Move to the right
        $this->Cell(80);
        // Title
        $this->Cell(30,10,'Title',1,0,'C');
        // Line break
        $this->Ln(20);
    }

// Page footer
    function Footer()
    {
        // Position at 1.5 cm from bottom
        $this->SetY(-15);
        // Arial italic 8
        $this->SetFont('Arial','I',8);
        // Page number
        $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
    }
}

// Instanciation of inherited class
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Times','',12);
for($i=1;$i<=40;$i++)
    $pdf->Cell(0,10,'Printing line number '.$i,0,1);
$pdf->Output();


//foreach($country as $countryItem) {
//    $city = $db->Read('city', '*', "countryId = " . $countryItem['countryId']);
////    echo "<strong>" . $countryItem['Name'] . "</strong><br><br>";
//    foreach ($city as $cityItem) {
//        $location = $db->Read('location', '*', 'CityId = ' . $cityItem['cityId']);
////        echo "<i>" . $cityItem['City'] . "</i><br>";
//        foreach ($location as $locationItem) {
//            $object = $db->Read('object', '*', 'locationId = ' . $locationItem['LocationId']);
////            echo "<b>" . $locationItem['Location'] . "</b><br>";
//            foreach($object as $objectItem) {
//
//            }
//        }
//    }
////    echo "<br><br>";
//}