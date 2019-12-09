<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<title>Add New Model</title>
	<link rel="stylesheet" type="text/css" href="../css/style.css">
	<script type="text/javascript" src="../js/datepickr.js"></script>
	<script src="../js/jquery-2.1.3.min.js"></script>
	<script src="../js/functions.js"></script>
	<script src="../js/gen_validatorv4.js" type="text/javascript"></script>
</head>
<body>
<?php
//Start the session

session_start();

//Include the header

require('adminHeader.html');
include("../mysql_connect.php");

$query = "";

foreach ($_POST as $key => $entry)
{
     if (is_array($entry)) {
        foreach($entry as $value) {
           print $key . ": " . $value . "<br>";
		   print "here";
        }
     } else {
        print $key . ": " . $entry . "<br>";
		$query=$query.$key.$entry.",";
		if ($key=="modelName") {$modelName = $entry;}
		
		
		//FamilyName
	if ($key=="familyName") {	
	$query = "SELECT * FROM familyName WHERE familyNameId = $entry";
	$result = mysqli_query($connection, $query);
	if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
	$familyName=$row["familyName"];}
    }}
	
	
		if ($key=="familyName") {$familyId = $entry;}
		if ($key=="display") {$display = $entry;}
		if ($key=="osa") {$osa = $entry;}
		if ($key=="class") {$class = $entry;}
		if ($key=="fax") {$fax = $entry;}
		if ($key=="dsk") {$dsk = $entry;}
		if ($key=="controller") {$controller = $entry;}
		
     }
}
//print "Query = ".$query;

print "<br>".$modelName;
print "<br>".$familyName;
print "<br>".$familyId;
print "<br>".$display;
print "<br><br>";

//SEND THE SQL to the Model Table
$sql = "INSERT INTO model (model, family, familyId) VALUES ('".$modelName."','".$familyName."','".$familyId."')";
print $sql;
mysqli_query($connection, $sql) OR die('Could not connect to MySQL: ' . mysqli_error($connection));


print "<br>".$osa;
print "<br>".$class;
print "<br>".$fax;
print "<br>".$dsk;
print "<br>".$controller;


?>