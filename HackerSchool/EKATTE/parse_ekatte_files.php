<?php
// Тhis script parses xls files and inserts the data in database. The library used is PHPExcel. 
//A for loop is used to go through each row of the spreadsheet inserting the data from the row read into the db.
require_once dirname(__FILE__) . '/Classes/PHPExcel.php';

include 'user_pass_ekatte.php';

//$fileName = "ekatte_files/Ek_obl.xls";
//$fileName = "ekatte_files/Ek_obst.xls";
//$fileName = "ekatte_files/Ek_kmet.xls";
$fileName = "ekatte_files/Ek_atte.xls";

try {

$excelReader = PHPExcel_IOFactory::createReaderForFile($fileName);
$excelReader->setReadDataOnly();
$excelObj = $excelReader->load($fileName);
} catch(Exception $e) {
	die('Error loading file "'.pathinfo($fileName,PATHINFO_BASENAME).'": '.$e->getMessage());
}

$sheet = $excelObj->getSheet(0);
$highestRow = $sheet->getHighestRow();
$highestColumn = $sheet->getHighestColumn();

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
} 

mysqli_set_charset($conn,"utf8");

//$stmt = $conn->prepare("INSERT INTO oblasti (oblast, ekatte_num, name, region, document, abc) VALUES (?, ?, ?, ?, ?, ?)"); //oblasti
//$stmt = $conn->prepare("INSERT INTO obshtini (obshtina, ekatte_num, name, category, document, abc) VALUES (?, ?, ?, ?, ?, ?)"); // obshtini
//$stmt = $conn->prepare("INSERT INTO kmetstva (kmetstvo, name, center, document) VALUES (?, ?, ?, ?)"); // kmetstva
$stmt = $conn->prepare("INSERT INTO selishta (ekatte_num, type, name, oblast_f, obstina_f, kmetstvo_f, category, altitude, document, tsb, abc) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"); //selishta
//$param_types = "sissii"; // oblasti
//$param_types = "sisiii"; // obshtini
//$param_types = "ssii"; // kmetstva
$param_types = "ssssssiiisi"; // selishta


for ($row = 3; $row <= $highestRow; $row++){ // oblasti, obshtini, kmetstva $row = 2; selishta $row = 3;

    $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, NULL, TRUE, FALSE); 

    $conn2 = new mysqli($servername, $username, $password, $database);
	if ($conn2->connect_error) {
		die("Connection failed: " . $conn2->connect_error);
	} 	  
	$sql = "SELECT ekatte_num FROM selishta WHERE ekatte_num = '{$rowData[0][0]}'";  // oblasti - oblast, obshtini - obshtina, selishta - ekatte_num, kmetstva - kmetstvo, 	  
	if ($result = $conn2->query($sql)) {
		if($result->num_rows <= 0) {
			$conn2->close(); 
			$stmt->bind_param($param_types, $rowData[0][0], $rowData[0][1],$rowData[0][2], $rowData[0][3], // need to rebuild these lines based on the prepared statement above
			                                $rowData[0][4], $rowData[0][5], $rowData[0][7], $rowData[0][8],  
			                                $rowData[0][9], $rowData[0][10], $rowData[0][11] ); 
			if(!$stmt->execute()) echo $stmt->error;
		}
	} 
    
}

$conn->close(); 

?>
