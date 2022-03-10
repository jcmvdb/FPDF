<style>
    b {
        font-size: 1.2rem;
    }
</style>

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

foreach ($yourUniqueCountry as $countryItem) {
    echo '<b>' . $countryItem . "</b><br>";
        $cityArray = array();
        foreach ($wing as $wingItem){
            if ($wingItem['Billing address country'] == $countryItem) {
                if (in_array($wingItem['Billing address city'], $cityArray)) {
                    continue;
                }
                $cityArray[] = $wingItem['Billing address city'];
                echo $wingItem['Billing address city'] . "<br>";

                foreach ($wing as $wingItem2) {
                    if ($wingItem2['Billing address city'] == $wingItem['Billing address city']) {
                        echo $wingItem2['Store ID'] . "<br>";
                        foreach ($assets as $assetItem) {
                            if ($assetItem['Store ID'] == $wingItem2['Store ID']) {
                            echo '<p>' . $assetItem['Store ID'] . " test</p>";
                            }
                        }
                    }
                }
                echo "<br>";
            }
        }
    echo "<br>";
}

?>