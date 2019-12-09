<?php
ini_set("session.gc_maxlifetime", 32400);
ini_set("session.cache_expire", 540);
session_start();

# Lets init our variables
$modelId = "";
$ticket = "";
$statusId = "";
$family = "";
$class = "";
$category = "";
$problem = "";
$solution = "";
$date = "";
$enteredBy = "";
$howTo = "";
$subCat = "";
$scanCat = "";
$printCat = "";
$imageCat = "";
$faxCat = "";
$jamCat = "";
$serviceCat = "";
$statusCat = "";
$bootCat = "";
$finCat = "";

//Connect to database

require ("mysql_connect.php");

# Lets get our data from the URL

$id = mysqli_real_escape_string($connection, $_REQUEST['id']);
if (isset($_REQUEST['modelId'])){$modelId = $_REQUEST['modelId'];}
//$enteredBy = mysqli_real_escape_string($connection, $_REQUEST['enteredBy']);
$ticket = mysqli_real_escape_string($connection, $_REQUEST['ticket']);
$statusId = mysqli_real_escape_string($connection, $_REQUEST['statusId']);
$family = mysqli_real_escape_string($connection, $_REQUEST['family']);
$class = mysqli_real_escape_string($connection, $_REQUEST['class']);
$category = mysqli_real_escape_string($connection, $_REQUEST['category']);

$problem = mysqli_real_escape_string($connection, $_REQUEST['problem']);
$solution = mysqli_real_escape_string($connection, $_REQUEST['solution']);
//$date = mysqli_real_escape_string($connection, $_REQUEST['date']);
$howTo = mysqli_real_escape_string($connection, $_REQUEST['howTo']);

$scanCat = mysqli_real_escape_string($connection, $_REQUEST['scanCat']);
$printCat = mysqli_real_escape_string($connection, $_REQUEST['printCat']);
$imageCat = mysqli_real_escape_string($connection, $_REQUEST['imageCat']);
$faxCat = mysqli_real_escape_string($connection, $_REQUEST['faxCat']);
$jamCat = mysqli_real_escape_string($connection, $_REQUEST['jamCat']);
$serviceCat = mysqli_real_escape_string($connection, $_REQUEST['serviceCat']);
$statusCat = mysqli_real_escape_string($connection, $_REQUEST['statusCat']);
$bootCat = mysqli_real_escape_string($connection, $_REQUEST['bootCat']);
$finCat = mysqli_real_escape_string($connection, $_REQUEST['finCat']);
$authCat = mysqli_real_escape_string($connection, $_REQUEST['authCat']);
$procedureCat = mysqli_real_escape_string($connection, $_REQUEST['procedureCat']);

//Create subCat

//Code to strip more than one subcat

////print "Category=".$category;

if ($category=="Authentication"){$subCat=$authCat;}
elseif($category=="Boot Failure"){$subCat=$bootCat;}
elseif($category=="Error Code"){$subCat=$serviceCat;}
elseif($category=="Fax"){$subCat=$faxCat;}
elseif($category=="Image Quality"){$subCat=$imageCat;}
elseif($category=="Jam Codes"){$subCat=$jamCat;}
elseif($category=="Noise"){$subCat="";}
elseif($category=="Output or Finishing"){$subCat=$finCat;}
elseif($category=="Presales"){$subCat="";}
elseif($category=="Print or Copy"){$subCat=$printCat;}
elseif($category=="Procedure"){$subCat=$procedureCat;}
elseif($category=="Scan"){$subCat=$scanCat;}
elseif($category=="Status or Alert Msg"){$subCat=$statusCat;}
else {print "AN ERROR OCCURRED";}	

//print "SUBCAT=".$subCat;

//$subCat = trim($scanCat . $printCat . $imageCat . $faxCat . $jamCat . $serviceCat . $statusCat . $bootCat . $finCat . $authCat . $procedureCat);

//Convert ModelId to string

$strModelId = "";

if ($modelId!=""){foreach ($modelId as $key => $value) {$strModelId .= $value . ",";
}}else{print "MODELID=".$modelId;}

$query = "UPDATE sharp 
			SET modelId= '" . $strModelId . "',
			ticket= '" . $ticket . "',
			statusId= '" . $statusId . "',
			family= '" . $family . "',
			class= '" . $class . "',
			category= '" . $category . "',
			subCat= '" . $subCat . "',
			problem= '" . $problem . "',
			solution= '" . $solution . "',
			howTo= '" . $howTo . "' 
			WHERE id = " . $id . "";

print $query;

mysqli_query($connection, $query) OR die('Could not connect to MySQL: ' . mysqli_error($connection));  //inserts into sharp table

//Add in edit table

$editor = $_SESSION['name'];

$query = "INSERT INTO edits VALUES (
			NULL,
			NOW(),
			'$editor',
			'$statusId',
			'$id',
			'$strModelId',
			'$problem',
			'$solution'
			 )";

//print $query;
mysqli_query($connection, $query) OR die('Could not connect to MySQL: ' . mysqli_error($connection));  //inserts into edits table

//Send a Email if rejected
	//Get the Author
	
		//Get the Row
		
		$query = "SELECT * FROM sharp WHERE id = " . $id . " LIMIT 1";
		$result = mysqli_query($connection, $query);
		
		if (!$result) {
			print "Entered row ID is invalid";
			exit();
		}
		//And the Values
		
		while ($row = $result -> fetch_assoc()) {
		
			$authorId = $row['staffId'];
		
		}
		
		//Get Author name and email
		
		//Staff
		
		$query = "SELECT * FROM staff WHERE staffId='$authorId'";
		$result = mysqli_query($connection, $query);
		
		while ($row = $result -> fetch_assoc()) {
			$author = $row['name'];
			$authorEmail = $row['email'];
		
		}
	
	//Is it rejected?
	
	if ($statusId == "3") {
	
		// The message
		$message = "Hello " . $author . "\r\n" . "Your entry " . $id . " has been rejected.\r\nPlease Review.\r\nRegards, KID";
	
		// In case any of our lines are larger than 70 characters, we should use wordwrap()
		$message = wordwrap($message, 70, "\r\n");
	
		$headers = 'From: ' . $author . "\r\n" . 'Reply-To: laum@sharpsec.com' . "\r\n" . "CC: kelseyda@sharpsec.com, cassarar@sharpsec.com";
		'X-Mailer: PHP/' . phpversion();
	
		$to = $authorEmail;
		$subject = "Rejected KID Entry";
	
		// Send
	
		mail($to, $subject, $message, $headers);
	
	}


header('location:index.php?id=' . $id . '');

mysqli_close($connection);
?>
