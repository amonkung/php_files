<?php
$myfile = fopen("newfile.txt", "a") or die("Unable to open file!");

$txt = "amonkung123\n";
fwrite($myfile, $txt);

$txt = "just monika just monika\n";
fwrite($myfile, $txt);

fclose($myfile);
echo "บันทึกข้อมูลเรียบร้อย (append)";
?>
