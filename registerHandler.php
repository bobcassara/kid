<?php
ini_set("session.gc_maxlifetime", 32400);
ini_set("session.cache_expire", 540);
session_start();

////////////////////////////////////////////////////////////////////////////////
////////////////////////// SET INVITATION CODE /////////////////////////////////

$invitationCode = "Sharp990";

///////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////

//Error Reporting
		//error_reporting(0);
		ini_set('display_errors', 1);
		ini_set('display_startup_errors', 1);
		error_reporting(E_ALL);
		
# Lets init our variables
$invitation= "";
$name = "";
$techId = "";
$username = "";
$password = "";
$confirmedPassword = "";
$date = "";
$lastLog = "";
$admin = "";


//Connect to database

require ("mysql_connect.php");

# Lets get our data from the URL
$invitation = mysqli_real_escape_string($connection, $_REQUEST['invitation']);
$name = mysqli_real_escape_string($connection, $_REQUEST['name']);
$techId = mysqli_real_escape_string($connection, $_REQUEST['techId']);
$username = mysqli_real_escape_string($connection, $_REQUEST['username']);
$password = mysqli_real_escape_string($connection, $_REQUEST['password']);
$confirmedPassword = mysqli_real_escape_string($connection, $_REQUEST['confirmedPassword']);


if ($invitation !=$invitationCode) {
	print "<h2 align = center>Invalid Invitation Code</h2>";
	exit();
	
}

if ($password != $confirmedPassword){
	
	print "<h2 align=center>Passwords do not match</h2>";
	exit();
}else{
	
	//Insert Query 

//check username

$query = "SELECT * FROM staff WHERE username = '$username'";
$result = mysqli_query($connection, $query);
$row = $result -> fetch_assoc();
if ($row) {echo "<h2 align=center>User name '".$username."' is already in use.  Choose another user name</h2>";
	exit();}

$query = "INSERT INTO staff VALUES( NULL, '$name','$techId', '0','0','$username', '$password','1',NOW(), 'MFP')";
//DEBUG/////////////////
//print $query;
////////////////////////
mysqli_query($connection,$query)or die(mysqli_error($connection));

//redirect back to index
header('Location:login.php?username='.$username.'&password='.$password);
}
