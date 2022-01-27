<?php
require 'db/db.php';

echo '<a href="pdf.php">PDF</a>';
echo "<p>Hey</p>";
$db = new DB();
$objectInformation = $db->Read('Object');
$country = $db->Read('country', '*', '1 ORDER BY `Name` ASC');
echo "<pre>";
//    var_dump($objectInformation);
var_dump($country);
echo "</pre>";
//