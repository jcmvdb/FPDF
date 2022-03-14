<?php

require 'functions.php';


/**************************************************************************
 *                          information                                   *
 **************************************************************************/

$arraytest = ['test', 'test1', 'test2'];
// Read the JSON file
$jsonWing = file_get_contents('stores-wings-import.json');
$jsonAssets = file_get_contents('brandedAssets.json');

/** Decode the JSON file */
$json_dataWing = json_decode($jsonWing, true);
$json_dataAssets = json_decode($jsonAssets, true);

foreach ($json_dataWing as $yourValues) {
    $wing[] = $yourValues;
    $city[] = $yourValues['Billing address city'];
    $country[] = $yourValues['Billing address country'];
}

foreach ($json_dataAssets as $AssetValue) {
    $assets[] = $AssetValue;
}
$yourUniqueCity = array_unique($city);
$yourUniqueCountry = array_unique($country);

/**************************************************************************
 *                          information                                   *
 **************************************************************************/



/** Front Page **/
// Instanciation of inherited class
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Times', '', 12);
//$pdf->SetMargins(0, 0);
$pdf->Image("../img/whiteCircle2.jpeg", 0, 0, $pdf->GetPageWidth(), $pdf->GetPageHeight());
//$pdf->SetMargins(10, 10);

/*****************************************************************************
 *                            Country                                      *
 *                              &                                          *
 *                          City summary                                   *
 *****************************************************************************/
foreach ($yourUniqueCountry as $countryItem) {
    $pdf->AddPage();
    $pdf->SetFontSize(20);
    $pdf->Cell($pdf->GetPageWidth() - 20, 20, $countryItem, 1, 1, 'C');
    $cityArray = array();
    $pdf->Ln(10);
    $pdf->SetFontSize(16);
        $pdf->Cell(50, 10, 'Cities', 0, 1);
        $pdf->Ln(7.5);
    $pdf->SetFontSize(12);
    foreach ($wing as $wingItem) {
        if ($wingItem['Billing address country'] == $countryItem) {
            if (in_array($wingItem['Billing address city'], $cityArray)) {
                continue;
            }
            $cityArray[] = $wingItem['Billing address city'];
            $pdf->Cell(50, 10, $wingItem['Billing address city'], 0, 1);
        }
    }

    /*****************************************************************************
     *                               Cities                                    *
     *                                  &                                      *
     *                          location summary                               *
     *****************************************************************************/
    $cityArray = array();
    foreach ($wing as $wingItem) {
        if ($wingItem['Billing address country'] == $countryItem) {
            if (in_array($wingItem['Billing address city'], $cityArray)) {
                continue;
            }
            $cityArray[] = $wingItem['Billing address city'];
            $pdf->AddPage();
            $pdf->SetFontSize(20);
            $pdf->Cell(50, 10, $wingItem['Billing address city'], 0, 1);
            $pdf->SetFontSize(12);
            $pdf->Ln(10);
            $pdf->Cell(50, 10, 'Locations', 1, 1);
            $pdf->SetFont('Times', 'B', 14);
            $pdf->Cell(50, 10, 'LocationId');
            $pdf->Cell(100, 10, 'Name');
            $pdf->Cell(50, 10, 'City');
            $pdf->Cell(50, 10, 'Page number', 0, 1);
            $pdf->SetFont('Times', '', 12);
            foreach ($wing as $wingItem2) {
                if ($wingItem2['Billing address city'] == $wingItem['Billing address city']) {
//                    $pdf->AddPage();
//                    $pdf->Cell(50, 10, $wingItem2['Name'], 0, 1);
//                    $pdf->Cell(50, 10, $wingItem2['Store ID']);
                    $pdf->Cell(50, 10, $wingItem2['Store ID']);
                    $pdf->Cell(100, 10, $wingItem2['Name']);
                    $pdf->Cell(50, 10, $wingItem2['Billing address city']);
                    $pdf->Cell(50, 10, $pdf->PageNo(), 0, 1);
                }
            }

            /**************************************************************************
             *                             location                                  *
             *                                 &                                     *
             *                           object summary                              *
             **************************************************************************/

            foreach ($wing as $wingItem2) {
                if ($wingItem2['Billing address city'] == $wingItem['Billing address city']) {
                    $pdf->AddPage();
                    $pdf->Cell(50, 10, $wingItem2['Name']);
                    $pdf->Ln(15);
                    $pdf->Cell(50, 10, 'LOCATION INFORMATION', 0, 1);
                    $pdf->Ln(10);

                    $pdf->Cell(30, 10, 'Location Code');
                    $pdf->Cell(50, 10, $wingItem2['Store ID'], 0, 1);
                    $pdf->Cell(30, 10, 'Address');
                    $pdf->Cell(50, 10, $wingItem2['Visiting address first line'], 0, 1);

//                    $pdf->SetTextColor(160, 160, 160);
                    $pdf->Cell(50, 10, 'OBJECTS', 0 , 1);
                    $pdf->SetTextColor(255, 255, 255);
                    $pdf->SetFillColor(160, 160, 160);


                    $pdf->Cell(25, 15, 'Object code', 1, 0, 'L', true);
                    $pdf->Cell(100, 15, 'Type', 1, 0, '', true);
                    $pdf->Cell(26, 15, 'Width (in M)', 1, 0, '', true);
                    $pdf->Cell(26, 15, 'Height (in M)', 1, 0, '', true);
                    $pdf->Cell(25, 15, 'Store Section', 1, 0, '', true);
                    $pdf->Cell(75, 15, 'Material', 1, 1, '', true);
                    $pdf->SetTextColor(0, 0, 0);


                    foreach ($assets as $Assetitem) {
                        if ($Assetitem['Store ID'] == $wingItem2['Store ID']) {
                            $pdf->Cell(25, 10, $Assetitem['Id'], 1);
                            $pdf->Cell(100, 10, $Assetitem['Type'], 1);
                            $pdf->Cell(26, 10, number_format($Assetitem['Content width (DisplayUnit)'] / 1000, 2), 1);
                            $pdf->Cell(26, 10, number_format($Assetitem['Content height (DisplayUnit)'] / 1000, 2), 1);
                            $pdf->Cell(25, 10, $Assetitem['Id'], 1);
                            $pdf->Cell(75, 10, $Assetitem['Id'], 1, 1);
                        }
                    }

                    /**************************************************************************
                     *                         object information                             *
                     **************************************************************************/
                    foreach ($assets as $Assetitem) {
                        if ($Assetitem['Store ID'] == $wingItem2['Store ID']) {
                            $pdf->AddPage();
                            $pdf->SetFontSize(25);
                            $pdf->Cell(50, 20,  $Assetitem['Id']);
                            $pdf->SetFontSize(12);
                            $pdf->Cell(15, 10, 'Type:');
                            $pdf->Cell(75, 10, $Assetitem['Type']);
                            $pdf->Cell(25, 10, 'Width');
                            $pdf->Cell(50, 10, $Assetitem['Content width (DisplayUnit)'], 0, 1);
                            $pdf->Cell(50);
                            $pdf->Cell(15, 10, 'Owner');
                            $pdf->Cell(75, 10, $Assetitem['Owner']);
                            $pdf->Cell(25, 10, 'Height');
                            $pdf->Cell(50, 10, $Assetitem['Content height (DisplayUnit)'], 0, 1);
                            $pdf->Line(10, 40, $pdf->GetPageWidth() - 20, 40);

                        }
                    }
                }
            }
        }
    }
}

$pdf->Output();
?>