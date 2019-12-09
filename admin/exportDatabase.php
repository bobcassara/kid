<!DOCTYPE html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<title>Export Database</title>
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



//initilize some variables
$date="";
$success="";
$modelId="";
$model="";
//Error Reporting
//error_reporting(0);

//Lets Connect to the db

include("../mysql_connect.php");


//Lets get the form variables

if (isset($_REQUEST['startdate'])){  //Start DAte
	$startDate= mysqli_real_escape_string($connection, $_REQUEST['startdate']);
	}
	
if (isset($_REQUEST['enddate'])){ //End Date
	$endDate= mysqli_real_escape_string($connection, $_REQUEST['enddate']) ;
	}

	
	
	
?>
<!--Header Area-->
<?php
include("adminHeader.html");
?>

<br><br><center>

<form action="exportDatabaseHandler.php" method = "get" id="successForm">
	<table border="1" class="dateTable">
		<tr class="row1">
                    <td colspan=2> <center>Export Database</center></td>
		
		
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
		
		<tr>
			<td colspan=2><div style="text-align:center;"><input type="checkbox" name="published" value="published" checked>Published<input type="checkbox" name="editor" value="editor" checked>Editor
			<input type="checkbox" name="sme" value="sme" checked>SME<br /><input type="checkbox" name="internal" value="internal" checked>Internal
			<input type="checkbox" name="duplicate" value="duplicate">Duplicate<input type="checkbox" name="rejected" value="rejected" >Rejected<input type="checkbox" name="underReview" value="underReview" >Under Review</div></td></tr>
		
		
		<tr><td colspan=2><input type="hidden" name="success" value="true"><center><input type="submit" name = "report" value = "Export" class="button"></center></td>
		</tr>
	
</table>

</form><!--Report Form-->


</body>
</html>