<?php
require 'db/db.php';

echo '<a href="pdf.php">PDF</a><br>';
echo '<a href="pdf2.php">PDF2</a>';
echo "<p>Hey</p>";
$db = new DB();
$objectInformation = $db->Read('Object');
$country = $db->Read('country', '*', '1 ORDER BY `Name` ASC');
echo "<pre>";
//    var_dump($objectInformation);
var_dump($country);
echo "<br>";
var_dump(getimagesize('img/greenpepper.png'));
echo "</pre>";
//