<?php
$myfile = fopen("newfile.txt", "w") or die("Unable to open file!");
$txt = "Worawan\n";
fwrite($myfile, $txt);
$txt = "Worawan\n";
fwrite($myfile, $txt);
fclose($myfile);

echo "บันทึกขอมูลเรียบร้อย";
?>