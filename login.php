<?php
session_start();
//Connect to database
include ("mysql_connect.php");

//Lets get the info
$password = mysqli_real_escape_string($connection, $_REQUEST['password']);
$username = mysqli_real_escape_string($connection, $_REQUEST['username']);

//Check for blank UN or PW
if ($username == "") {
    echo "<script type='text/javascript'>alert('You must enter a  UserName');
	 window.location.replace('index.php');</script>";
}
if ($password == "") {
    echo "<script type='text/javascript'>alert('You must enter a Password');
	 window.location.replace('index.php');</script>";
}

//Check credentials in database

$query = "SELECT * FROM staff WHERE username = '$username'";
$result = mysqli_query($connection, $query);
$row = $result -> fetch_assoc();
setcookie('lastLog' , $row['lastLog']);
if (($password != "") && ($password == $row['password'])) {
    //Your golden

    //Are you an admin?
    if ($row['admin'] != 0) {
        //setcookie('admin', 'yes', time() + (86400), "/"); // 86400 = 1 day
        $_SESSION['admin'] = $row['admin'];
    }
    //Set the cookie
    $_SESSION['user'] = $row['username'];
    $_SESSION['name'] = $row['name'];

    //Record login
    
    $query = "UPDATE staff SET lastLog = NOW() WHERE username = '$username'";
    mysqli_query($connection,$query)or die(mysqli_error($connection));
    
    
    header('location:index.php?submit=true&id=0');

} else {//wrong credentials provided

    echo "<script type='text/javascript'>alert('Wrong UserName or Password');
	 window.location.replace('/repairDEV/index.php');</script>";
    //FIXME

}
?>
