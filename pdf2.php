<?php
require 'functions.php';
require 'db/db.php';
require 'pdf2/sizes.php';
$height = new Height();
$width = new Width();
$pictureHeight = $height->pictureHeight;
$cellH = $height->cellHeight;

$db = new DB();
$country = $db->Read('country', '*', '1 ORDER BY `Name` ASC');

include 'pdf2/docInfo.php';

foreach ($country as $countryItem) {
    $location = $db->Read('location', '*', 'countryId = ' . $countryItem['countryId']);

//    counts how many location there are in a country
    $locationCount = 0;
    foreach ($location as $locationItem) {
        $locationCount++;
        $object = $db->Read('`object` `o` LEFT JOIN `type` `t` ON `o`.`typeId` = `t`.`typeId` LEFT JOIN `picture` `p` ON `o`.`pictureId` = `p`.`pictureId` LEFT JOIN `material` `m` ON `o`.`materialId` = `m`.`materialId`', '*', 'locationId = ' . $locationItem['locationId']);
        $objectCount = 0;
//        counts how many objects there are in a location
            foreach($object as $objectItem) {
                $objectCount++;
            }
    }

//    the index page of the location of a country
    if ($locationCount > 0 && $objectCount > 0){
        include 'pdf2/country-information.php';
        foreach ($location as $locationItem) {
            $object = $db->Read('`object` `o` LEFT JOIN `type` `t` ON `o`.`typeId` = `t`.`typeId` LEFT JOIN `picture` `p` ON `o`.`pictureId` = `p`.`pictureId` LEFT JOIN `material` `m` ON `o`.`materialId` = `m`.`materialId`', '*', 'locationId = ' . $locationItem['locationId']);
//            $pdf->TOC_Entry($locationItem['city'], 2);
            $pdf->TOC_Entry($locationItem['name'], 2);
//            the information that is shown on the object summary
            if ($objectCount > 0) {
                include 'pdf2/objectsummary.php';
                include 'pdf2/pictureOverview.php';

//                all the information that is shown on the object page
                foreach ($object as $objectItem) {
                    include 'pdf2/object.php';
                }
            }
        }
    }
}
$pdf->stopPageNums();
$pdf->insertTOC(2);
$pdf->Output($dest, 'RGN.pdf');
