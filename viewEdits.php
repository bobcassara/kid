<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<title>Success by Agent</title>
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<script type="text/javascript" src="js/datepickr.js"></script>
	<script src="js/jquery-2.1.3.min.js"></script>
	<script src="js/functions.js"></script>
	<script src="js/gen_validatorv4.js" type="text/javascript"></script>
</head>
<body>
<?php
//Start the session

session_start();



//initilize some variables
$date="";
$success="";


//Error Reporting
//error_reporting(0);

//Lets Connect to the db

include("mysql_connect.php");


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

<form action="viewEdits.php" method = "get" id="successForm">
	<table border="1" class="adminTable">
		<tr class="row1">
                    <td colspan=2> <center><b>Edits by Agent</b></center></td>
		
		
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
		<tr><input type="hidden" name="success" value="true"><td><a href="index.php"><img src="images/back-icon.png" width="50"></a></td><td><center><input class = "button" type="submit" name = "report" value = "View">&nbsp;&nbsp;<input type="submit" name = "report" value = "Export" class="button"></center></td>
		</tr>
	
</table>

</form><!--Report Form-->
<?php

if ($success=="true" AND $report=="View") {
	
	//Do the Query
	$query="SELECT * FROM edits WHERE date BETWEEN'$startDate' AND '$endDate' AND statusId='5' ORDER by 'editor' ";
	
	//print $query;
	
	echo"<br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><table border='1' class='adminTable'>";
	$result = mysqli_query($connection,$query);
	$totalRows = mysqli_num_rows($result);
	echo "<b>".$totalRows." Edits were made during this time period (".$startDate." to ".$endDate.")</b><br><br>";
	//echo $totalRows;
	echo "<tr><td><b>ID</b></td><td><b>Date</b></td><td><b>Editor</b></td><td><b>StatusID</b></td><td><b>RepairID</b></td><td><b>Models</b></td>
		<td><b>Problem</b></td><td><b>Solution</b></td></tr>";
	while ($row = $result->fetch_assoc()) {
		echo "<tr>
		
		<td>".$row['id']."</td><td>".
		$row['date']."</td><td>".
		$row['editor']."</td><td>".
		$row['statusId']."</td><td>
		<a href='index.php?id=".$row['repairId']."'>".$row['repairId']."</a></td><td>".
		$row['models']."</td><td>".
		$row['problem']."</td><td>".
		$row['solution']."</td></tr>";
		
		}
	echo "</table>";
	
}

if ($success=="true" AND $report=="Export") {
	
	//Session data to pass start date and end date
	
	$_SESSION['startdate']   = $startDate;
	$_SESSION['enddate']  = $endDate;
	
	//jump to export.php
	header("Location: admin/editExport.php");
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
