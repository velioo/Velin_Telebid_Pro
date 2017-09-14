<?php

$file = fopen("markers_big.csv", "a+") or die("Unable to open file!");

$contents = fread($file,filesize("markers_big.csv")/1000);


for($i = 0; $i < 1000; $i++) {
	
	fwrite($file, $contents);
	
}

fclose($file);

?>
