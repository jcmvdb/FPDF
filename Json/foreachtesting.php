<head>
    <link rel="icon" href="../img/oldFiat.jpeg"
</head>
<style>
    .colortran {
        color: transparent;
    }
</style>
<?php

$array = ['test', 'test1'];
// Read the JSON file
$jsonWing = file_get_contents('stores-wings-import.json');
$jsonAssets = file_get_contents('brandedAssets.json');

/** Decode the JSON file */
$json_dataWing = json_decode($jsonWing, true);
$json_dataAssets = json_decode($jsonAssets, true);

$i = 0;
foreach($json_dataWing as $yourValues){
    $wing[] = $yourValues;
    $city[] = $yourValues['Billing address city'];
    $country[] = $yourValues['Billing address country'];
    $i++;
}
$yourUniqueCity = array_unique($city);
$yourUniqueCountry = array_unique($country);



foreach ($yourUniqueCity as $cityItem) {
//    echo $cityItem . "<br>";
}

foreach ($yourUniqueCountry as $countryItem) {
    echo '<b>' . $countryItem . "</b><br>";
    $j = 3;
    $testing = array();
    foreach ($wing as $wingItem) {

        if ($wingItem['Billing address country'] == $countryItem) {
//            echo $wingItem['Billing address city'] . "<br>";
            if (in_array($wingItem['Billing address city'], $testing)) {
                continue;
            }
            $testing[] = $wingItem['Billing address city'];
            echo '<span class="colortran">----</span>' . $wingItem['Billing address city'] . "<br>";
            foreach ($array as $item) {
//                echo '<span class="colortran">--------</span>' . $item . '<br>';
            }
        }
    }
    echo "<br>";
}


echo "<pre>";

$count = 0;
foreach ($wing as $wingItem) {
//    var_dump($wingItem['Billing address city']);

    if ($wingItem['Billing address country'] == 'Italy') {
//            var_dump($wingItem['Billing address city']);
        echo $wingItem['Billing address city'] . "<br>";
    }
    $count++;
}
echo "</pre>";
