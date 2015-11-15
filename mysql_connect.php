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

$query = "SELECT * FROM staff";
$result = mysqli_query($connection, $query);
$staffnumrows = mysqli_num_rows($result);

while ($row = $result -> fetch_assoc()) {
    $staff[] = $row['name'];
    $staffID[] = $row['staffId'];

}
//Category

$query = "SELECT * FROM categories";
$result = mysqli_query($connection, $query);
$categorynumrows = mysqli_num_rows($result);

while ($row = $result -> fetch_assoc()) {
    $Category[] = $row['category'];
    $CategoryID[] = $row['catId'];

}
//Model ALL

$query = "SELECT * FROM model ORDER BY `modelNumber` ASC";
$result = mysqli_query($connection, $query);
$modelnumrows = mysqli_num_rows($result);

while ($row = $result -> fetch_assoc()) {
    $Model[] = $row['modelNumber'];
    $ModelID[] = $row['id'];

}

//Model Color

$query = "SELECT * FROM model WHERE `modelType` = 'color'";
$result = mysqli_query($connection, $query);
$modelcolornumrows = mysqli_num_rows($result);

while ($row = $result -> fetch_assoc()) {
    $ModelColor[] = $row['modelNumber'];
    $ModelIDColor[] = $row['id'];

}

//Model Black and White

$query = "SELECT * FROM model WHERE `modelType` = 'bw'";
$result = mysqli_query($connection, $query);
$modelbwnumrows = mysqli_num_rows($result);

while ($row = $result -> fetch_assoc()) {
    $ModelBw[] = $row['modelNumber'];
    $ModelIDBw[] = $row['id'];

}
//Model Solutions

$query = "SELECT * FROM model WHERE `modelType` = 'solutions'";
$result = mysqli_query($connection, $query);
$modelsolutionsnumrows = mysqli_num_rows($result);

while ($row = $result -> fetch_assoc()) {
    $ModelSolutions[] = $row['modelNumber'];
    $ModelIDSolutions[] = $row['id'];

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
//echo "<pre>";
//var_dump($serviceCode);
//echo "</pre>";
?>
