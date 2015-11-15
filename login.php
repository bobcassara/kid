<?php
session_start();
//Connect to database
include("mysql_connect.php");

//Lets get the info
$password = mysqli_real_escape_string($connection, $_REQUEST['password']);
$username = mysqli_real_escape_string($connection, $_REQUEST['username']);

//DEBUG//
//print "Username " . $username;
//print "Password " . $password;


//Check for blank UN or PW
if ($username =="") {
	echo "<script type='text/javascript'>alert('You must enter a  UserName');
	 window.location.replace('index.php');</script>";}
if ($password=="") {
	echo "<script type='text/javascript'>alert('You must enter a Password');
	 window.location.replace('index.php');</script>";}


//Check credentials in database

$query= "SELECT * FROM staff WHERE username = '$username'";
$result = mysqli_query($connection,$query);
$row = $result->fetch_assoc();


if (($password !="") && ($password==$row['password'])){
	//Your golden
	
	
	//Are you an admin?
		if ($row['admin']!=0) {
			//setcookie('admin', 'yes', time() + (86400), "/"); // 86400 = 1 day
	        $_SESSION['admin']=$row['admin'];}
	//Set the cookie
	$_SESSION['user']=$row['username'];
	$_SESSION['name']=$row['name'];
	//$cookie_name = "user";
	//$cookie_value = $username;
	//setcookie($cookie_name, $cookie_value, time() + (86400), "/"); // 86400 = 1 day
	//print "SESSSION".$_SESSION['user'];
	//print "ADMIN=".$_SESSION['admin'];
	header('location:index.php?submit=true&id=0');
	
}else{ //wrong credentials provided
	
	echo "<script type='text/javascript'>alert('Wrong UserName or Password');
	 window.location.replace('/repairDEV/index.php');</script>";  //FIXME
	
}
?>
