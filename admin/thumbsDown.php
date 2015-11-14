<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<title>Success by Agent</title>
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
$date="";
$success="";


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
//Lets get the form variables

if (isset($_REQUEST['startdate'])){  //Start DAte
	$startDate= mysqli_real_escape_string($connection, $_REQUEST['startdate']);
	}
	
if (isset($_REQUEST['enddate'])){ //End Date
	$endDate= mysqli_real_escape_string($connection, $_REQUEST['enddate']) ;
	}
if (isset($_REQUEST['success'])){  //Sucess
	$success=mysqli_real_escape_string($connection, $_REQUEST['success']);
	}
	
if (isset($_REQUEST['report'])){  //Report
	$report=mysqli_real_escape_string($connection, $_REQUEST['report']);
	}	
	//echo $report;
?>

<br><br><center>

<form action="thumbsDown.php" method = "get" id="successForm">
	<table border="1">
		<tr>
			<td colspan=2><center><b>Thumbs Down by Agent</b></center></td>
		
		
		</tr>
		<tr>
			<td>Start Date</td>
			<td><input id="startdate" type="datetime" name="startdate" value="<?php echo $date ?>"></td>
				<script type="text/javascript">
				new datepickr('startdate', { dateFormat: 'Y-m-d' });
				</script>
		</tr>
		<tr>
			<td>End Date</td><td><input id="enddate" type="datetime" name="enddate" value="<?php echo $date ?>"></td>
				<script type="text/javascript">
				new datepickr('enddate', { dateFormat: 'Y-m-d' });
				</script></td>
		</tr>
		<tr><input type="hidden" name="success" value="true"><td></td><td><center><input type="submit" name = "report" value = "View">&nbsp;&nbsp;<input type="submit" name = "report" value = "Export"></center></td>
		</tr>
	
</table>
</form><!--Report Form-->

<?php

if ($success=="true" AND $report=="View") {
	
	//Do the Query
	$query="SELECT * FROM nosuccess WHERE date BETWEEN'$startDate' AND '$endDate'";
	
	//print $query;
	echo "<br><br>";
	echo"<table border='1'>";
	$result = mysqli_query($connection,$query);
	$totalRows = mysqli_num_rows($result);
	echo "<b>".$totalRows." Thumbs Down reports have been submitted during this time period. (".$startDate." to ".$endDate.")</b><br><br>";
	//echo $totalRows;
	echo "<tr><td><b>Ticket</b></td><td><b>Model</b></td><td><b>Category</b></td><td><b>Sub Categoory</b></td><td><b>Problem</b></td><td><b>Agent</b></td><td><b>Date</b></td></tr>";
	while ($row = $result->fetch_assoc()) {
		if ($row['category']=="%") $row['category']="";
		
		echo "<tr>
		
		<td>".$row['ticket']."</td><td>".
		$row['model']."</td><td>".
		$row['category']."</td><td>".
		$row['subCat']."</td><td>".
		$row['problem']."</td><td>".
		$row['username']."</td><td>".
		$row['date']."</td></tr>";
		}
	echo "</table>";
	
}

if ($success=="true" AND $report=="Export") {
	
	//Session data to pass start date and end date
	
	$_SESSION['startdate']   = $startDate;
	$_SESSION['enddate']  = $endDate;
	
	//jump to export.php
	header("Location: thumbsDownExport.php");
}
?>
</center>


<!--Form Validation-->
<script type="text/javascript">
var frmvalidator  = new Validator("successForm");
frmvalidator.addValidation("startdate","req","You must enter a start date");
frmvalidator.addValidation("enddate","req","You must enter a end date");

</script>
</body>

</html>
