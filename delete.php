<?php

//Error Reporting
error_reporting(0);

//Lets Connect to the db

include ("mysql_connect.php");

//Lets get the form variables

if (isset($_REQUEST['id'])) {//ID
	$id = $_REQUEST['id'];
}

//DEBUG

//echo $id;

//Delete this ID from the database

$query = "DELETE FROM sharp WHERE id='$id' LIMIT=1";

print $query;

if (mysqli_query($connection, $query)) {

	mysqli_close($connection);
}

header('location:index.php');
?>
