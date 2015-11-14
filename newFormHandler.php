<?php

# Lets init our variables
$enteredBy = "";
$ticket = "";
$model = "";
$category = "";
$problem ="";
$solution="";
$subCat="";

//TEMP SUCCESS//

$success = "0";
//Connect to database
require("mysql_connect.php");

# Lets get our data from the URL

foreach ($_GET['model'] as $selectedOption)
$model=$model . " ".$selectedOption;
$name= mysqli_real_escape_string($connection, $_GET['enteredBy']);
$ticket = mysqli_real_escape_string($connection, $_GET['ticket']);
//$model = mysqli_real_escape_string($connection, $_GET['model']);
$category = mysqli_real_escape_string($connection, $_GET['category']);
$problem = mysqli_real_escape_string($connection, $_GET['problem']);
$solution = mysqli_real_escape_string($connection, $_GET['solution']);
$jamCode = mysqli_real_escape_string($connection, $_GET['jamCode']);
$serviceCode = mysqli_real_escape_string($connection, $_GET['serviceCode']);
$scanCode = mysqli_real_escape_string($connection, $_GET['scanCode']);
$imageCode = mysqli_real_escape_string($connection, $_GET['imageCode']);
$faxCode = mysqli_real_escape_string($connection, $_GET['faxCode']);
$printCode = mysqli_real_escape_string($connection, $_GET['printCode']);
$howTo = mysqli_real_escape_string($connection, $_GET['howTo']);
$subCat= $jamCode . $serviceCode . $scanCode . $faxCode . $printCode . $imageCode;
$subCat = ltrim($subCat); //Trim the leading white space if any

$query="SELECT * FROM staff WHERE name = '$name'";
$result = mysqli_query($connection,$query);
$row = $result->fetch_assoc();
$staffID = $row['staffId'];

$query = "INSERT INTO sharp VALUES( NULL, '$model','$ticket',1,' ',' ','$category', '$subCat','$problem','$solution', NOW(),'$staffID', '$success', '$howTo');";
//DEBUG/////////////////
//print $query;
////////////////////////
mysqli_query($connection,$query)or die(mysqli_error($connection));

header('location:index.php?ticket='.$ticket.'&model='.$model.'&problem='.$problem.'&submit=submitted');


?>

