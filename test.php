<?php

$date_from_laporan = '2020-12-26';
$date_to_laporan = '2021-01-25';
$total_day=intval(((round(abs(strtotime($date_from_laporan) - strtotime($date_to_laporan)) / (60*60*24),0))+1)/2);


$date=date_create($date_from_laporan);
date_add($date,date_interval_create_from_date_string("{$total_day} days"));
echo intval(date_format($date,"m"));

        


?>