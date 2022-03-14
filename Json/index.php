<?php
//// Read the JSON file
$jsonWing = file_get_contents('stores-wings-import.json');
$jsonAssets = file_get_contents('brandedAssets.json');

// Decode the JSON file
$json_dataWing = json_decode($jsonWing, true);
$json_dataAssets = json_decode($jsonAssets, true);
//
//
//// Display data
echo "<pre>";
print_r($json_dataWing);
echo "</pre>";
//
//$test = $json_dataWing;
//$counting = 0;
//foreach ($test as $item) {
//    echo "<b>" . $item['Visiting address country'] . '</b><br> ';
//    echo $item['Website'] . '<br>';
//    echo $counting . '--------------------------------------------------------<br><br><br>';
//    $counting++;
//}
//
//
//echo "<br><br><br>";
//
//// Read the JSON file
//
//// Decode the JSON file
//$count = 0;
//
//// Display data
//echo "<pre>";
////print_r($json_data);
//echo "</pre>";
//echo "<br>";
//
//foreach ($json_dataAssets as $values) {
//    $count++;
//}
//echo $count . "<br><br><br><br>";
//foreach ($json_dataAssets as $values) {
////foreach ($json_dataAssets) {
////    if($values[''] = )
//    echo "Id: " . $values['Id'] . '<br>';
//    echo "Type: " . $values['Type'] . '<br>';
//    echo "Status: " . $values['Status'] . '<br>';
//    echo "Width: " . $values['Content width (DisplayUnit)'] . '<br>';
//    echo "Height: " . $values['Content height (DisplayUnit)'] . '<br>';
//    echo "Class: " . $values['Class'] . '<br>';
////    echo "email: " . $item['Email'] . '<br>';
//    echo "<br><br>";
//}
//
