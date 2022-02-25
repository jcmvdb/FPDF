<?php
//require_once 'functions.php';
require 'functions.php';
require 'db/db.php';
$db = new DB();

$country = $db->Read('country', '*', '1 ORDER BY `Name` ASC');


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
//$pdf->Cell($pdf->GetPageWidth() - 20, 10, 'text');
$pdf->Image('img/whiteCircle2.jpeg', 0, 0, $pdf->GetPageWidth(), $pdf->GetPageHeight());

$pdf->SetMargins(10, 10, 10);
$pdf->startPageNums();

// counting how many locations there are for every country
foreach ($country as $countryItem) {
    $location = $db->Read('location', '*', 'countryId = ' . $countryItem['countryId']);
    $count = 0;
//    counting how many objects there are for every location
    foreach ($location as $locationItem) {
        $count++;
        $object = $db->Read('`object` `o` LEFT JOIN `type` `t` ON `o`.`typeId` = `t`.`typeId` LEFT JOIN `picture` `p` ON `o`.`pictureId` = `p`.`pictureId` LEFT JOIN `material` `m` ON `o`.`materialId` = `m`.`materialId`', '*', 'locationId = ' . $locationItem['locationId']);
        $objectCount = 0;
        foreach($object as $objectItem) {
            $objectCount++;
        }
    }
    //    the index page of the location of a country
    if ($count > 0 && $objectCount > 0) {
        $pdf->AddPage();
        $pdf->TOC_Entry($countryItem['Name']);
        $pdf->SetFont('Times', 'B', 20);
        $pdf->Cell($pdf->GetPageWidth() - 20, 20, $countryItem['Name'], 0, 1);
        $pdf->SetFont('Times', '', 14);
        $pdf->Ln(7.5); // gives a margin between country name and cities

        $pdf->Cell(50, 10, 'Number of location: ' . $count, 0, 1);
        $pdf->Ln(5);
        $pdf->setFillColor(150, 150, 150); // grey
        $pdf->SetFont('Times', 'B', 16);
        $pdf->Cell(40, 10, 'LocationId');
        $pdf->Cell(69.25, 10, 'Name');
        $pdf->Cell(69.25, 10, 'City');
        $pdf->Cell(69.25, 10, 'PageNumber', 0, 1);
        $pdf->SetFont('Times', '', 14);
        $pdf->Ln(4.5);
        foreach ($location as $locationItem) {
            $pdf->Cell(40, 10, $countryItem['landcode'] . '-' . $locationItem['locationId']);
            $pdf->Cell(69.25, 10, $locationItem['name']);
            $pdf->Cell(69.25, 10, $locationItem['city']);
            $pdf->Cell(69.25, 10, 'niet beschikbaar', 0, 1);
        }

        foreach ($location as $locationItem) {
//            $pdf->AddPage();
            $object = $db->Read('`object` `o` LEFT JOIN `type` `t` ON `o`.`typeId` = `t`.`typeId` LEFT JOIN `picture` `p` ON `o`.`pictureId` = `p`.`pictureId` LEFT JOIN `material` `m` ON `o`.`materialId` = `m`.`materialId`', '*', 'locationId = ' . $locationItem['locationId']);
            $objectCount = 0;
//            controls how many object a location have
            foreach ($object as $objectItem) {
                $objectCount++;
            }

//           let see every object that a location has
            if ($objectCount > 0) {
                $pdf->AddPage();
                $pdf->Cell(200, 15, $locationItem['name'], 1, 1);
                $pdf->Ln(11);
                $pdf->Cell(100, 10, 'LOCATION INFORMATION', 0, 1);
                $pdf->Ln(11);
                $pdf->Cell(40, 10, 'LocationCode:');
                $pdf->Cell(120, 10, $countryItem['landcode'] . '-' . $locationItem['locationId']);
                $pdf->Ln(10);
                $pdf->Cell(40, 10, 'Adress:');
                $pdf->Cell(120, 10, $locationItem['city']);
                $pdf->cell(null, null, '', 0, 1);
                $pdf->Ln(20);
                $pdf->SetFont('Times', 'B', 17);
                $pdf->Cell(250, 10, 'OBJECTS', 0, 1);
                $pdf->SetFont('Times', '', 14);


                $pdf->Cell(30, 20, 'Code', 1, 0, '', true);
                $pdf->Cell(70, 20, 'Type', 1, 0, '', true);
                $pdf->Cell(30, 20, 'Width (in M)', 1, 0, '', true);
                $pdf->Cell(30, 20, 'Height (in M)', 1, 0, '', true);
                $pdf->Cell(30, 20, 'Store Section', 1, 0, '', true);
                $pdf->Cell(60, 20, 'Material', 1, 1, '', true);

                foreach ($object as $objectItem) {
                    $pdf->Cell(30, 10, $countryItem['landcode'] . '-' . $locationItem['locationId'] . ' - ' . $objectItem['objectId'], 1);
                    $pdf->Cell(70, 10, $objectItem['type'], 1);
                    $pdf->Cell(30, 10, $objectItem['width'], 1);
                    $pdf->Cell(30, 10, $objectItem['height'], 1);
                    $pdf->Cell(30, 10, $objectItem['storeSection'], 1);
                    $pdf->Cell(60, 10, $objectItem['material'], 1, 1);
                }

//                All the information that is shown on the object pages
                foreach ($object as $objectItem) {
                    $pdf->AddPage();
                    $pdf->SetFont('Times', '', 25);
                    $pdf->Cell(50, 20, $countryItem['landcode'] . '-' . $locationItem['locationId'] . ' - ' . $objectItem['objectId']);
                    $pdf->SetFont('Times', '', 14);
                    $pdf->Cell(25, 10, 'type');
                    $pdf->Cell(80, 10, $objectItem['type']);
                    $pdf->Cell(20, 10, 'Width: ');
                    $pdf->Cell(20, 10, $objectItem['width']);
                    $pdf->Cell(30, 10, 'Store section: ');
                    $pdf->Cell(20, 10, $objectItem['storeSection'], 0, 1);

                    $pdf->Cell(50);
                    $pdf->Cell(25, 10, 'material');
                    $pdf->Cell(80, 10, $objectItem['material']);
                    $pdf->Cell(20, 10, 'Height: ');
                    $pdf->Cell(20, 10, $objectItem['height']);
                    $pdf->Cell(30, 10, 'Refresh: ');
                    $pdf->Cell(20, 10, 'null', 0, 1);

                    $pdf->Line(10, 40, $pdf->GetPageWidth() - 20, 40);

                    list($x1, $y1) = getimagesize('img/'.$objectItem['picture']);
                    $height = 150;
                    $ratio = $y1 / $height;
                    $y = ($x1 / $ratio) / 2;
                    $x2 = 10;
                    $y2 = 70;
                    if (($x1 / $x2) < ($y1 / $y2)) {
                        $y2 = 0;
                    } else {
                        $x2 = 0;
                    }
                    $pdf->Cell($pdf->GetPageWidth(), 120, "", 0, 1, 'C', $pdf->Image('img/'.$objectItem['picture'], $pdf->GetPageWidth() / 2 - ($y), 50, 0, $height));
                }
            }
        }
    }
}

$pdf->stopPageNums();
$pdf->insertTOC(2);
$pdf->Output('I', 'RGN.pdf');