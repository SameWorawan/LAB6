<?php
$myfile = fopen("newfile.txt", "a") or die("Unable to open file!");
$txt = "555+\n";
fwrite($myfile, $txt);
$txt = "555+\n";
fwrite($myfile, $txt);
fclose($myfile);

echo "บันทึกข้อมูลเรียบร้อย"
?>