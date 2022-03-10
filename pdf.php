<?php
//require_once 'functions.php';
require 'functions.php';
require 'db/db2.php';
$db = new DB();

$country = $db->Read('country', '*', '1');


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


/******************************************************************************
                                Country
 ******************************************************************************/
foreach ($country as $countryItem) {
    $city = $db->Read('city', '*', "countryId = " . $countryItem['countryId']);
    $pdf->AddPage();
    $pdf->TOC_Entry($countryItem['Name'], 1);
    $pdf->SetFont('Times', 'B', 20);
    $pdf->Cell($pdf->GetPageWidth() - 20, 20, $countryItem['Name'], 0, 1);
    $pdf->SetFont('Times', '', 14);
    $pdf->Ln(7.5); // gives a margin between country name and cities
    $count = 0;
    foreach ($city as $cityItem) {
        $location = $db->Read('location', '*', 'CityId = ' . $cityItem['cityId']);
        foreach ($location as $locationItem) {
            $count++;
        }
    }

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

        foreach ($city as $cityItem){
            $location = $db->Read('location', '*', 'CityId = ' . $cityItem['cityId']);
            foreach ($location as $locationItem) {
                $pdf->Cell(40, 10, $countryItem['landcode'] . '-' . $locationItem['LocationId']);
                $pdf->Cell(69.25, 10, $locationItem['Location']);
                $pdf->Cell(69.25, 10, $cityItem['City']);
                $pdf->Cell(69.25, 10, '[', 0, 1);
            }
        }

    /******************************************************************************
                                    City
     ******************************************************************************/
    foreach ($city as $cityItem) {
            $location = $db->Read('location', '*', 'CityId = ' . $cityItem['cityId']);
            $pdf->TOC_Entry($cityItem['City'], 2);

            /******************************************************************************
                                        Location
             ******************************************************************************/
            foreach($location as $locationItem) {
                $object = $db->Read('`object` `o` LEFT JOIN `material` `m` ON `o`.`materialId` = `m`.`materialId` LEFT JOIN `type` `t` ON `o`.`typeId` = `t`.`typeId` LEFT JOIN `picture` `p` ON `o`.`pictureId` = `p`.`pictureId`', '*', 'locationId = ' . $locationItem['LocationId']);
                $pdf->AddPage();
                $pdf->SetFont('Times', '', 17);
                $pdf->Cell(50, 10, $locationItem['Location'], 0, 1);
                $pdf->SetFont('Times', '', 14);
                $pdf->Ln(11);
                $pdf->Cell(100, 10, 'LOCATION INFORMATION', 0, 1);
                $pdf->Ln(11);
                $pdf->Cell(40, 10, 'LocationCode:');
                $pdf->Cell(120, 10, $countryItem['landcode'] . '-' . $locationItem['LocationId']);
                $pdf->Ln(10);
                $pdf->Cell(40, 10, 'Adress:');
                $pdf->Cell(120, 10, $cityItem['City']);
                $pdf->cell(null, null, '', 0, 1);
                $pdf->Ln(20);


                /**
                 * the information of all objects
                 */
                $pdf->SetFont('Times', 'B', 17);
                $pdf->Cell(250, 10, 'OBJECTS', 0, 1);
                $pdf->SetFont('Times', '', 14);

                $pdf->SetFillColor(200, 200, 200);
                $pdf->Cell(30, 20, 'Code', 1, 0, '', true);
                $pdf->Cell(70, 20, 'Type', 1, 0, '', true);
                $pdf->Cell(30, 20, 'Width (in M)', 1, 0, '', true);
                $pdf->Cell(30, 20, 'Height (in M)', 1, 0, '', true);
                $pdf->Cell(30, 20, 'Store Section', 1, 0, '', true);
                $pdf->Cell(60, 20, 'Material', 1, 1, '', true);

                foreach ($object as $objectItem) {
                    $pdf->Cell(30, 10, $countryItem['landcode'] . '-' . $locationItem['LocationId'] . ' - ' . $objectItem['objectId'], 1);
                    $pdf->Cell(70, 10, $objectItem['type'], 1);
                    $pdf->Cell(30, 10, $objectItem['width'], 1);
                    $pdf->Cell(30, 10, $objectItem['height'], 1);
                    $pdf->Cell(30, 10, $objectItem['storeSection'], 1);
                    $pdf->Cell(60, 10, $objectItem['material'], 1, 1);
                }

                /******************************************************************************
                                                Object
                 ******************************************************************************/
                foreach ($object as $objectItem) {
                    $pdf->AddPage();
                    $pdf->SetFont('Times', '', 25);
                    $pdf->Cell(50, 20, $countryItem['landcode'] . '-' . $locationItem['LocationId'] . '-' . $objectItem['objectId']);
                    $pdf->SetFont('Times', '', 14);
                    $pdf->Cell(25, 10, 'Type');
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
                    $pdf->Cell(20, 10, 'oh nee', 0, 1);
                    $pdf->Line(10, 40, $pdf->GetPageWidth() - 20, 40);

                    list($x1, $y1) = getimagesize('img/'.$objectItem['picture']);
                    $pictureHeight = 150;
                    $ratio = $y1 / $pictureHeight;
                    $y = ($x1 / $ratio) / 2;
                    $x2 = 10;
                    $y2 = 70;
                    if (($x1 / $x2) < ($y1 / $y2)) {$y2 = 0;} else {$x2 = 0;}
                    $pdf->Cell($pdf->GetPageWidth(), 120, "", 0, 1, 'C', $pdf->Image('img/'.$objectItem['picture'], $pdf->GetPageWidth() / 2 - ($y), 50, 0, $pictureHeight));
                }
            }
        }
}


$pdf->stopPageNums();
$pdf->insertTOC(2);
$pdf->Output('I', 'RGN.pdf');