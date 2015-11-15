<?php

# Lets init our variables
$models = "";
$ticket = "";
$statusId = "";
$family = "";
$class = "";
$category = "";
$subCat = "";
$problem = "";
$solution = "";
$date = "";
$enteredBy = "";
$howTo = "";

//Connect to database

require ("mysql_connect.php");

# Lets get our data from the URL

$id = mysqli_real_escape_string($connection, $_GET['id']);
$models = mysqli_real_escape_string($connection, $_GET['models']);
$enteredBy = mysqli_real_escape_string($connection, $_GET['enteredBy']);
$ticket = mysqli_real_escape_string($connection, $_GET['ticket']);
$statusId = mysqli_real_escape_string($connection, $_GET['statusId']);
$family = mysqli_real_escape_string($connection, $_GET['family']);
$class = mysqli_real_escape_string($connection, $_GET['class']);
$category = mysqli_real_escape_string($connection, $_GET['category']);
$subCat = mysqli_real_escape_string($connection, $_GET['subCat']);
$problem = mysqli_real_escape_string($connection, $_GET['problem']);
$solution = mysqli_real_escape_string($connection, $_GET['solution']);
$date = mysqli_real_escape_string($connection, $_GET['date']);
$howTo = mysqli_real_escape_string($connection, $_GET['howTo']);

//Define Status default value
//$query = "SELECT * FROM status WHERE status = '$status'";
//$result = mysqli_query($connection,$query);
//$row = $result->fetch_assoc();
//$status = $row['statusID'];

//Debug//

//print $id . "<br>";
//print $models . "<br>";
//print $enteredBy . "<br>";
//print $ticket . "<br>";
//print $status . "<br>";
//print $family . "<br>";
//print $class . "<br>";
//print $category . "<br>";
//print $problem . "<br>";
//print $solution . "<br>";
//print $date;

$query = "UPDATE sharp 
			SET date = '" . $date . "',StaffId = '" . $enteredBy . "',model= '" . $models . "',ticket= '" . $ticket . "',statusId= '" . $statusId . "',family= '" . $family . "',class= '" . $class . "',category= '" . $category . "',subCat= '" . $subCat . "',problem= '" . $problem . "',solution= '" . $solution . "',howTo= '" . $howTo . "' WHERE id = " . $id . "";

//print "QUERY: " . $query;

mysqli_query($connection, $query) OR die('Could not connect to MySQL: ' . mysqli_error($connection));

header('location:index.php?id=' . $id . '');

mysqli_close;
?>
