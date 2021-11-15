<?php    

date_default_timezone_set("Africa/Cairo");
$currentTime=time();
$date=strftime("%B-%d-%Y  %H:%M:%S",$currentTime);
echo $date;



?>