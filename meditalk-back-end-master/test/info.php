<?php
header("Content-type: image/png");
$font = "./nanum.ttf";

$hp_name     = "메디톡 병원";
$create_date = "2019.11.24";
$hp_staff    = "전룡호";
$care_item   = "일반질환(감기몸살)";
$booking_date= "2019.11.24 11:15";

$im     = imagecreatefrompng("medical_info.png");
$purple = imagecolorallocate($im, 52, 68, 110);
$gary   = imagecolorallocate($im, 152, 160, 181);
//병원이름 
imagettftext($im, 15, 0, 55, 99, $purple, $font, $hp_name); 
//발급일
imagettftext($im, 10, 0, 255, 161, $gary, $font, $create_date); 
//병원이름
imagettftext($im, 10, 0, 255, 196, $gary, $font, $hp_name); 
//의료진
imagettftext($im, 10, 0, 255, 231, $gary, $font, $hp_staff); 
//진료항목
imagettftext($im, 10, 0, 220, 318, $gary, $font, $care_item); 
//예약시간
imagettftext($im, 10, 0, 220, 355, $gary, $font, $booking_date); 

imagepng($im);
imagedestroy($im);
?>