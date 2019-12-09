<?php

# Lets init our variables
$enteredBy = "";
$ticket = "";
$model = "";
$modelId[]="";
$category = "";
$problem ="";
$solution="";
$subCat="";
$newModelId="";


$success = "0";
//Connect to database
require("mysql_connect.php");

# Get data from the URL

if (isset($_REQUEST['modelId'])) {
	$modelId = $_REQUEST['modelId'];
	}else{
		echo "You did not enter any models.  Use the browser BACK button to go back and enter at least one model.";
	exit();
	}
$name= mysqli_real_escape_string($connection, $_REQUEST['enteredBy']);
$ticket = mysqli_real_escape_string($connection, $_REQUEST['ticket']);
//$model = mysqli_real_escape_string($connection, $_REQUEST['model']);
$category = mysqli_real_escape_string($connection, $_REQUEST['category']);
$problem = mysqli_real_escape_string($connection, $_REQUEST['problem']);
$solution = mysqli_real_escape_string($connection, $_REQUEST['solution']);
$jamCode = mysqli_real_escape_string($connection, $_REQUEST['jamCode']);
$serviceCode = mysqli_real_escape_string($connection, $_REQUEST['serviceCode']);
$scanCode = mysqli_real_escape_string($connection, $_REQUEST['scanCode']);
$imageCode = mysqli_real_escape_string($connection, $_REQUEST['imageCode']);
$faxCode = mysqli_real_escape_string($connection, $_REQUEST['faxCode']);
$printCode = mysqli_real_escape_string($connection, $_REQUEST['printCode']);
$statusCode = mysqli_real_escape_string($connection, $_REQUEST['statusCode']);
$bootCode = mysqli_real_escape_string($connection, $_REQUEST['bootCode']);
$finCode = mysqli_real_escape_string($connection, $_REQUEST['finCode']);
$authCode = mysqli_real_escape_string($connection, $_REQUEST['authCode']);
$procedureCode = mysqli_real_escape_string($connection, $_REQUEST['procedureCode']);



$howTo = mysqli_real_escape_string($connection, $_REQUEST['howTo']);
$subCat= $jamCode . $serviceCode . $scanCode . $faxCode . $printCode . $imageCode . $statusCode . $bootCode . $finCode . $authCode . $procedureCode; 
$subCat = trim($subCat); //Trim the leading white space if any


if($modelId) {

foreach ($modelId as &$selectedOption){
	$newModelId=$newModelId . ",".$selectedOption;
}
$modelId=trim($newModelId,",");//trim leading comma
$selectedModelIdArray=$_REQUEST['modelId'];
}else{print "You didnt enter any models";
exit();}

//print $model;


//Get author ID

$query="SELECT * FROM staff WHERE name = '$name'";
$result = mysqli_query($connection,$query);
$row = $result->fetch_assoc();
$staffID = $row['staffId'];


//Get model from modelId


//print "COUNT = ". count($selectedModelIdArray)."<br>";
$i=0;
while ($i < count($selectedModelIdArray)){
    $query="SELECT * FROM model WHERE modelId = '$selectedModelIdArray[$i]'";
    $result = mysqli_query($connection,$query);
    $row = $result->fetch_assoc();
    $model[$i] = $row['model'];    
    $i++;
    }

//Convert Model tp string

$model = implode(" ", $model);

//Strip tabs from problem solution

$solution = str_replace("\t","",$solution);
 
//Insert Query 

$query = "INSERT INTO sharp VALUES( NULL, '$model','$modelId','$ticket',1,' ',' ','$category', '$subCat','$problem','$solution', NOW(),'$staffID', '$success', '$howTo');";
//DEBUG/////////////////
//print $query;
////////////////////////
mysqli_query($connection,$query)or die(mysqli_error($connection));

//Send a Email

// The message
////$message = "Hello,\r\nA new entry has been added to KID.\r\nPlease Review.\r\nRegards, KID";

// In case any of our lines are larger than 70 characters, we should use wordwrap()
////$message = wordwrap($message, 70, "\r\n");


////$headers = 'From: laum@sharpsec.com' . "\r\n" .
 //   'Reply-To: laum@sharpsec.com' . "\r\n" .
 //   'X-Mailer: PHP/' . phpversion();


// Send


////mail('cassarar@sharpsec.com, laum@sharpsec.com, hammondb@sharpsec.com, pottsj@sharpsec.com', 'New KID entry', $message, $headers);

//redirect back to index

header('location:index.php?');


?>

