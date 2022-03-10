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

$i = 0;
foreach ($json_dataWing as $yourValues) {
    $wing[] = $yourValues;
    $city[] = $yourValues['Billing address city'];
    $country[] = $yourValues['Billing address country'];
    $i++;
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
    $pdf->SetFontSize(12);
    $cityArray = array();
    $pdf->Ln(10);
    $pdf->Cell(50, 10, 'CITIES', 1, 1);
    foreach ($wing as $wingItem) {
        if ($wingItem['Billing address country'] == $countryItem) {
            if (in_array($wingItem['Billing address city'], $cityArray)) {
                continue;
            }
            $cityArray[] = $wingItem['Billing address city'];
//            $pdf->AddPage();
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
            foreach ($wing as $wingItem2) {
                if ($wingItem2['Billing address city'] == $wingItem['Billing address city']) {
//                    $pdf->AddPage();
                    $pdf->Cell(50, 10, $wingItem2['Name'], 0, 1);
//                    $pdf->Cell(50, 10, $wingItem2['Store ID']);
                }
            }

            /**************************************************************************
             *                          information                                   *
             **************************************************************************/

            foreach ($wing as $wingItem2) {
                if ($wingItem2['Billing address city'] == $wingItem['Billing address city']) {
                    $pdf->AddPage();
                    $pdf->Cell(50, 10, $wingItem2['Name']);
//                    foreach ($arraytest as $item) {
                    $pdf->Ln(15);
                    $pdf->Cell(50, 10, 'Winkel', 1, 1);
                    foreach ($assets as $item) {
                        if ($item['Store ID'] == $wingItem2['Store ID']) {
//                            $pdf->AddPage();
                            $pdf->Cell(50, 10, $item['Id'], 0, 1);
                        }
                    }
                    foreach ($assets as $item) {
                        if ($item['Store ID'] == $wingItem2['Store ID']) {
                            $pdf->AddPage();
                            $pdf->Cell(50, 10, $item['Id'], 0, 1);
                            $pdf->Cell(25, 10, 'Height', 1);
                            $pdf->Cell(50, 10, $item['Content height (DisplayUnit)'], 0, 1);
                            $pdf->Cell(50, 10, $item['Id'], 0, 1);
                            $pdf->Cell(50, 10, $item['Id'], 0, 1);
                        }
                    }
                }
            }
        }
    }
}

$pdf->Output();
?>