<?php

# Lets init our variables
$enteredBy = "";
$ticket = "";
$model = "";
$modelId="";
$category = "";
$problem ="";
$solution="";
$subCat="";

//TEMP SUCCESS//

$success = "0";
//Connect to database
require("mysql_connect.php");

# Lets get our data from the URL

foreach ($_GET['modelId'] as $selectedOption){
$modelId=$modelId . ",".$selectedOption;}
$modelId=trim($modelId,",");//trim leading comma
$selectedModelIdArray=$_GET['modelId'];


//print $model;

$name= mysqli_real_escape_string($connection, $_GET['enteredBy']);
$ticket = mysqli_real_escape_string($connection, $_GET['ticket']);
//$model = mysqli_real_escape_string($connection, $_GET['model']);
//$modelId = mysqli_real_escape_string($connection, $_GET['modelId']);
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

//Get author ID

$query="SELECT * FROM staff WHERE name = '$name'";
$result = mysqli_query($connection,$query);
$row = $result->fetch_assoc();
$staffID = $row['staffId'];


//Get model from modelId


print "COUNT = ". count($selectedModelIdArray)."<br>";
$i=0;
while ($i < count($selectedModelIdArray)){
    $query="SELECT * FROM model WHERE modelId = '$selectedModelIdArray[$i]'";
    $result = mysqli_query($connection,$query);
    $row = $result->fetch_assoc();
    $model[$i] = $row['modelNumber'];    
    $i++;
    }

//Convert Model tp string

$model = implode(" ", $model);

//Insert Query 

$query = "INSERT INTO sharp VALUES( NULL, '$model','$modelId','$ticket',1,' ',' ','$category', '$subCat','$problem','$solution', NOW(),'$staffID', '$success', '$howTo');";
//DEBUG/////////////////
//print $query;
////////////////////////
mysqli_query($connection,$query)or die(mysqli_error($connection));


//redirect back to index

header('location:index.php?ticket='.$ticket.'&model='.$model.'&problem='.$problem.'&submit=submitted');


?>

