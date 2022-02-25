<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title></title>
</head>
<body>
<?php
require 'db/db.php';
?>
<a href="pdf.php">PDF</a><br>
<a href="pdf2.php">PDF2</a><br>
<a href="excel">Excel</a>

<br><br><br>
<h2>PDF 2</h2>
<form action="pdf2.php" method="post">
    <button name="I" value="I" type="submit">Preview</button><br><br>
    <button name="D" value="D" type="submit">Download</button>
</form>
</body>
</html>
