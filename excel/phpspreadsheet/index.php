<head>
    <title>Big Book Excel</title>
</head>
<style>
    strong {
        margin-left: 20px;
    }

    i {
        margin-left: 40px;
    }
</style>

<?php
require '../vendor/autoload.php';
require '../../db/db.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$db = new DB();
$country = $db->Read('country');

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Gives the Excel sheet a name
$spreadsheet->getActiveSheet()->setTitle('Big Book Excel');

$sheet->setCellValue('A1', 'Hey');


echo '<pre>';
//    var_dump($country);

foreach ($country as $countryItem) {
    print_r($countryItem);
    $location = $db->Read('location', '*', 'countryId = ' . $countryItem['countryId']);
    foreach ($location as $locationItem) {
        echo "<strong>";
        print_r($locationItem);
        echo "</strong>";
        $object = $db->Read('`object` `o` LEFT JOIN `type` `t` ON `o`.`typeId` = `t`.`typeId` LEFT JOIN `picture` `p` ON `o`.`pictureId` = `p`.`pictureId` LEFT JOIN `material` `m` ON `o`.`materialId` = `m`.`materialId`', '*', 'locationId = ' . $locationItem['locationId']);
        foreach ($object as $objectItem) {
            echo "<i><strong>";
            print_r($objectItem);
            echo "</i></strong>";
//            echo '<br>';
        }
        echo "<br><br>";
    }
    for ($i = 0; $i <= 3; $i++) {
        echo "<br><br>";
    }
}

echo '</pre>';

$max = 'AZ';
$spreadsheet->getActiveSheet()->getColumnDimension($max)->setAutoSize(true);
for ($i = 'A'; $i != $spreadsheet->getActiveSheet()->getHighestColumn(); $i++) {
    $spreadsheet->getActiveSheet()->getColumnDimension($i)->setAutoSize(TRUE);
}

$count = 0;
foreach ($country as $countryItem) {
    $location = $db->Read('location', '*', 'countryId = ' . $countryItem['countryId']);
    foreach ($location as $locationItem) {
        $locationCount++;
    }
    if ($locationCount > 0) {
        $row = 1;
        $spreadsheet->createSheet();
        // Zero based, so set the second tab as active sheet
        $count++;
        $spreadsheet->setActiveSheetIndex($count);
        $spreadsheet->getActiveSheet()->setTitle($countryItem['Name']);
        $sheet = $spreadsheet->getActiveSheet();
        $spreadsheet->getActiveSheet()->getColumnDimension($max)->setAutoSize(true + 100);
        for ($i = 'A'; $i != $spreadsheet->getActiveSheet()->getHighestColumn(); $i++) {
            $spreadsheet->getActiveSheet()->getColumnDimension($i)->setAutoSize(TRUE + 100);
        }

        $sheet->fromArray($countryItem, null, 'A' . $row);
        $row += 1;
        $locationCount = 0;

            foreach ($location as $locationItem) {
                echo "<strong>";
                $sheet->fromArray($locationItem, null, 'A' . $row);
                $row += 1;
                echo "</strong>";
                $object = $db->Read('`object` `o` LEFT JOIN `type` `t` ON `o`.`typeId` = `t`.`typeId` LEFT JOIN `picture` `p` ON `o`.`pictureId` = `p`.`pictureId` LEFT JOIN `material` `m` ON `o`.`materialId` = `m`.`materialId`', '*', 'locationId = ' . $locationItem['locationId']);
                $objectCount = 0;

//            foreach ($object as $objectItem) {
//                $objectCount++;
//            }
                foreach ($object as $objectItem) {
                    echo "<i><strong>";
//                  print_r($objectItem);
                    $sheet->fromArray($objectItem, null, 'D' . $row);
                    $row += 4;
                    echo "</i></strong>";
//            echo '<br>';
//            $row += 1;
                }
//        $row += 2;
            }
    }
//    $spreadsheet->createSheet($countryItem['Name']);

}

$spreadsheet->setActiveSheetIndex(0);
$writer = new Xlsx($spreadsheet);
$writer->save('Big_Book.xlsx');