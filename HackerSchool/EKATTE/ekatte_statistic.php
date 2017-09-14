<?php

include 'user_pass_ekatte.php';

    $conn = new mysqli($servername, $username, $password, $database);
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	} 	  
	//$sql = "SELECT COUNT(oblast) as oblasti_count, COUNT(obshtina) as obshtini_count, COUNT(kmetstvo) as selishta_count FROM oblasti, obshtini, selishta;"; 
	$sql = "SELECT COUNT(oblast) as oblasti_count FROM oblasti"; 
	if ($result = $conn->query($sql)) {
		if($result->num_rows > 0) {
			while($row = $result->fetch_assoc()) {
				//echo "Objects in Oblasti: " . $row["oblasti_count"]. "<br> Objects in Obshtini: " . $row["obshtini_count"]. "<br> Objects in Selishta: " . $row["selishta_count"]. "<br>";
				echo "Objects in Oblasti: " . $row["oblasti_count"];
			}
		}
	} 
	
	$conn->close(); 

?>
