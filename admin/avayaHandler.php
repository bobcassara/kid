<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<title>Add Avaya Data</title>
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


//initilize some variables
$startDate="";
$success="";
//get start date fron url

if (isset($_REQUEST['startDate']))
	{$startDate=$_REQUEST['startDate'];}

//Error Reporting
//error_reporting(0);

//Lets Connect to the db

include("../mysql_connect.php");

//Check if user is logged in

if(!isset($_SESSION['user'])) {
	print "<h2>Please Login</h2>";
	print "<form action = ../login.php method = post>
	<b>Name: </b><input type = text name = username>
	<b>Password: </b><input type = password name = password>
	<input type = submit name = submit value = Submit>
	</form>";
	exit();
} 
if (isset($_SESSION['user'])){
	$username=$_SESSION['user'];
    $query="SELECT * FROM staff WHERE username = '$username'";
	$result = mysqli_query($connection,$query);
	$row = $result->fetch_assoc();
    $name = $row['name'];
	}

//Get the agents

    $query = "SELECT * FROM staff where display = 1 AND datatable = 'MFP'";
    $agentResult = mysqli_query($connection, $query);
    
    while ($row = $agentResult -> fetch_assoc()) {  //Query all agents that display = 1
	
	$agentIdTemp=$row['staffId'];
	
	if (isset($_REQUEST[$agentIdTemp]))
	{$tempCalls=$_REQUEST[$agentIdTemp];}

	$tempName = $row['name'];
	//print $tempName." ".$tempCalls."<br>";
	



//insert into Avaya table

	$query = "INSERT INTO avaya VALUES (NULL, '$tempName', '$tempCalls', '$startDate')";
	mysqli_query($connection, $query) OR die('Could not connect to MySQL: ' . mysqli_error($connection));
	


}//agent loop

mysqli_close($connection);
?>

<script>alert("Saved Successfully!");</script> 




