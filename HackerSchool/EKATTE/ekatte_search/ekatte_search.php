<?php

include 'user_pass_ekatte.php';

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
} 	  
	
mysqli_set_charset($conn,"utf8");

$selishte = mysqli_real_escape_string($conn, $_GET['name']);

$sql = "SELECT DISTINCT selishta.type, selishta.name, oblasti.name as oblast_name, obshtini.name as obshtina_name FROM selishta 
											 JOIN oblasti on selishta.oblast_f = oblasti.oblast
											 JOIN obshtini on selishta.obstina_f = obshtini.obshtina
											 WHERE selishta.name LIKE '%{$selishte}%'";  
if ($result = $conn->query($sql)) {
	if($result->num_rows > 0) {
		while($row = mysqli_fetch_assoc($result)) {			
			echo "<tr>" 
			    ."<td>" . $row['type'] . " " . $row['name'] . "</td>"
			    ."<td>" . $row['oblast_name'] . "</td>"
			    ."<td>" . $row['obshtina_name'] . "</td>"
			    ."</tr>";			
		}
	} else {
		echo 0;
	}
} else {
	echo("Error description: " . $stmt->error);
}


$conn->close();


?>