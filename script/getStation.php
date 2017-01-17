<?php

$file_content = file_get_contents('ScriptLogErr-2016-11-25.log');

$line_arr = explode("\n", $file_content);
foreach ($line_arr as $row) {
	
	$temp = json_decode($row, true);
	
	echo $temp['q']."\n";
	file_put_contents('Not_get_station_name.txt', $temp['q']."\n", FILE_APPEND);
}

die;