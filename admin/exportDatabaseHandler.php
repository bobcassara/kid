<?php

session_start();

//Lets Connect to the db

include("../mysql_connect.php");

//Init variables
$startdate="";
$enddate="";
$published = "";
$internal = "";
$editor="";
$sme="";
$duplicate="";
$rejected = "";
$underReview = "";
//Get form variables

if (isset($_REQUEST['startdate'])){  //Start Date
	$startdate= mysqli_real_escape_string($connection, $_REQUEST['startdate']);
	}
	
if (isset($_REQUEST['enddate'])){ //End Date
	$enddate= mysqli_real_escape_string($connection, $_REQUEST['enddate']) ;
	}


if (isset($_REQUEST['published'])){ //Published
	$published= mysqli_real_escape_string($connection, $_REQUEST['published']) ;
	}
if (isset($_REQUEST['editor'])){ //Editor
	$editor= mysqli_real_escape_string($connection, $_REQUEST['editor']) ;
	}
if (isset($_REQUEST['internal'])){ //Internal
	$internal= mysqli_real_escape_string($connection, $_REQUEST['internal']) ;
	}
if (isset($_REQUEST['sme'])){ //SME
	$sme= mysqli_real_escape_string($connection, $_REQUEST['sme']) ;
	}
if (isset($_REQUEST['underReview'])){ //UnderReview
	$underReview= mysqli_real_escape_string($connection, $_REQUEST['underReview']) ;
	}	
if (isset($_REQUEST['duplicate'])){ //Duplicate
	$duplicate= mysqli_real_escape_string($connection, $_REQUEST['duplicate']) ;
	}
if (isset($_REQUEST['rejected'])){ //Rejected
	$rejected= mysqli_real_escape_string($connection, $_REQUEST['rejected']) ;
	}
		
// print "Published = ".$published;	
// print "Editor = ".$editor;
// print "Internal = ".$internal;	
// print "SME = ".$sme;
// print "Duplicate = ".$duplicate;
// print "Rejected = ".$rejected;
//print $startdate;

$query1 = "SELECT * FROM sharp WHERE ((date BETWEEN '$startdate' AND '$enddate') AND ((statusId =0) ";

if ($published) 
{$query1.= " OR (statusId=2)";}
if ($editor) 
{$query1.= " OR (statusId=5)";}
if ($internal) 
{$query1.= " OR (statusId=6)";}
if ($sme) 
{$query1.= " OR (statusId=4)";}
if ($duplicate) 
{$query1.= " OR (statusId=7)";}
if ($rejected) 
{$query1.= " OR (statusId=3)";}
if ($underReview) 
{$query1.= " OR (statusId=9)";}

$query1.=")) ORDER BY LENGTH(solution) DESC";

//print "QUERY = ".$query1;
//exit(); 
 
 
$result1 = mysqli_query($connection, $query1);


$page_print = "id\tModels\tTicket\tStatus\tCategory\tSubCategory\tSymptom\tSuggestion\tDate\tAuthor\tSuccess\n" ;



while($row = mysqli_fetch_array($result1)) { //MAIN LOOP

//Staff ID to Staff Name

$staffQuery="Select name FROM staff WHERE `staffId` = '$row[staffId]'";
		//print $staffQuery;
		$staffResult=mysqli_query($connection,$staffQuery);
		
		
		
		while($staffRow = mysqli_fetch_assoc($staffResult)) {
        $staffName=$staffRow['name'];
        //print "STAFFBNAME = ".$staffName;
    }


//status ID to Status Name


$statusName = $Status[$row['statusId']-1];

$solution = nl2br($row['solution']);
$solution = trim(preg_replace('/\s+/', ' ', $solution));
//$solution = trim(preg_replace('/\s+/', ' ', $row['solution']));
//$solution = trim($row['solution']);
//ModelId to modelName
$modelId = $row['modelId'];
$modelId = rtrim($modelId, ","); //Trim trailing comma
    
$modelId=(explode(',',$modelId));  //Put selected models into array

$modelName="";

foreach($modelId as $value){
	if (in_array($value,$ModelID)){
    	$query = "SELECT model from model WHERE modelId='$value' LIMIT 1";
		$result = mysqli_query($connection, $query);
		
		while ($row1 = $result -> fetch_assoc()) {
    $modelName.= $row1['model'].",";		
 		}	
 	}
}
$modelName = trim(preg_replace('/\s+/', ' ', $modelName));

$problem = nl2br($row['problem']);
$problem = trim(preg_replace('/\s+/', ' ', $problem));
//$problem = trim($row['problem']);
$success = $row['success'];

$page_print .= $row['id'] 
. " \t " . $modelName 
. " \t " . $row['ticket'] 
. " \t " . $statusName 
. " \t " . $row['category'] 
. " \t " . $row['subCat']
. " \t " . $problem
. " \t " . $solution
. " \t " . $row['date']
. " \t " . $staffName
. " \t " . $success
."\n";

}


$fh = fopen('export.xls', 'w');
$stringData = trim($page_print);
fwrite($fh, $stringData);
fclose($fh);


//Download File

$file = 'export.xls';

if (file_exists($file)) {
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="'.basename($file).'"');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($file));
    readfile($file);
    exit;
}
?>
