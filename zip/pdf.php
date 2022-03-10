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
$yourUniqueCity = array_unique($city);
$yourUniqueCountry = array_unique($country);

/**************************************************************************
 *                          information                                   *
 **************************************************************************/


// Instanciation of inherited class
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Times', '', 12);


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
    $pdf->Cell(50, 10, 'LOCATIES', 1, 1);
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

            foreach ($wing as $wingItem2) {
                if ($wingItem2['Billing address city'] == $wingItem['Billing address city']) {
                    $pdf->AddPage();
                    $pdf->Cell(50, 10, $wingItem2['Store ID']);
                }
            }
        }
    }
}

$pdf->Output();
?>