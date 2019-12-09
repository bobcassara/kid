<?php

#  mysql_connect.php

// This file contains the database access information for the database.
// This file also establishes a connection to MySQL and selects the database.

// Set the database access information as constants.
define('DB_USER', 'root');
define('DB_PASSWORD', 'xj80e383');
define('DB_HOST', 'localhost');
define('DB_NAME', 'KID');

// Make the connection and then select the database.

// Improved MySQL Version:
$connection = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME) OR die('Could not connect to MySQL: ' . mysqli_connect_error());

//Status

$query = "SELECT * FROM status";
$result = mysqli_query($connection, $query);
$statusnumrows = mysqli_num_rows($result);

while ($row = $result -> fetch_assoc()) {
    $Status[] = $row['status'];
    $StatusId[] = $row['statusId'];
}

//Staff

$query = "SELECT * FROM staff WHERE datatable ='MFP'";
$result = mysqli_query($connection, $query);
$staffnumrows = mysqli_num_rows($result);

while ($row = $result -> fetch_assoc()) {
    $staff[] = $row['name'];
    $staffID[] = $row['staffId'];

}
//Category

$query = "SELECT * FROM categories ORDER BY category";
$result = mysqli_query($connection, $query);
$categorynumrows = mysqli_num_rows($result);

while ($row = $result -> fetch_assoc()) {
    $Category[] = $row['category'];
    $CategoryID[] = $row['catId'];

}
//Model ALL

$query = "SELECT * FROM model ORDER BY `family` ASC";
$result = mysqli_query($connection, $query);
$modelnumrows = mysqli_num_rows($result);

while ($row = $result -> fetch_assoc()) {
    $Model[] = $row['model'];
    $ModelID[] = $row['modelId'];
	$ModelFamily[]=$row['family'];

}

//Print Codes

$query = "SELECT * FROM printCodes ORDER by `printSub`";
$result = mysqli_query($connection, $query);
$printCodenumrows = mysqli_num_rows($result);
while ($row = $result -> fetch_assoc()) {
    $printCode[] = $row['printSub'];
}
//Scan Codes

$query = "SELECT * FROM scanCodes ORDER by `scanSub`";
$result = mysqli_query($connection, $query);
$scanCodenumrows = mysqli_num_rows($result);
while ($row = $result -> fetch_assoc()) {
    $scanCode[] = $row['scanSub'];
}
//Fax Codes

$query = "SELECT * FROM faxCodes ORDER by `faxSub`";
$result = mysqli_query($connection, $query);
$faxCodenumrows = mysqli_num_rows($result);
while ($row = $result -> fetch_assoc()) {
    $faxCode[] = $row['faxSub'];
}
//Jam Codes

$query = "SELECT * FROM jamCodes ORDER by `jamCode`";
$result = mysqli_query($connection, $query);
$jamCodenumrows = mysqli_num_rows($result);

while ($row = $result -> fetch_assoc()) {
    $jamCode[] = $row['jamCode'];
}
//Service Codes

$query = "SELECT * FROM serviceCodes ORDER by ServiceCode";
$result = mysqli_query($connection, $query);
$serviceCodenumrows = mysqli_num_rows($result);

while ($row = $result -> fetch_assoc()) {
    $serviceCode[] = $row['serviceCode'];
}
//Image Quality Codes

$query = "SELECT * FROM imageCodes ORDER by `imageSub`";
$result = mysqli_query($connection, $query);
$imageCodenumrows = mysqli_num_rows($result);
while ($row = $result -> fetch_assoc()) {
    $imageCode[] = $row['imageSub'];
}

//Status Message Codes

$query = "SELECT * FROM statusCodes ORDER by `StatusCode`";
$result = mysqli_query($connection, $query);
$statusCodenumrows = mysqli_num_rows($result);
while ($row = $result -> fetch_assoc()) {
    $statusCode[] = $row['statusCode'];
}

//Boot Failure Codes
$query = "SELECT * FROM bootCodes ORDER by `bootCode`";
$result = mysqli_query($connection, $query);
$bootCodenumrows = mysqli_num_rows($result);
while ($row = $result -> fetch_assoc()) {
    $bootCode[] = $row['bootCode'];
}

//Fin Codes
$query = "SELECT * FROM finCodes ORDER by `finCode`";
$result = mysqli_query($connection, $query);
$finCodenumrows = mysqli_num_rows($result);
while ($row = $result -> fetch_assoc()) {
    $finCode[] = $row['finCode'];
}
//Auth Codes
$query = "SELECT * FROM authCodes ORDER by `authCode`";
$result = mysqli_query($connection, $query);
$authCodenumrows = mysqli_num_rows($result);
while ($row = $result -> fetch_assoc()) {
    $authCode[] = $row['authCode'];
}
//Procedure Codes
$query = "SELECT * FROM procedureCodes ORDER by `procedureCode`";
$result = mysqli_query($connection, $query);
$procedureCodenumrows = mysqli_num_rows($result);
while ($row = $result -> fetch_assoc()) {
    $procedureCode[] = $row['procedureCode'];
}






//echo "<pre>";
//var_dump($serviceCode);
//echo "</pre>";
?>
