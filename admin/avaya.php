<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<title>Add Avaya Data</title>
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
$startDate="";
$success="";
//get start date fron url

if (isset($_REQUEST['startDate']))
	{$startDate=$_REQUEST['startDate'];}
if (isset($_REQUEST['success']))
	{$success=$_REQUEST['success'];}
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




?>
<br><br><center>

<form action="avaya.php" method = "get" id="avayaForm">
	<table border="1" class="dateTable">
		<tr class="row1">
                    <td colspan=2> <center>Avaya</center></td>
		
		
		</tr>
		<tr>
			<td>Enter Date:</td>
			<td><input id="startdate" type="datetime" name="startDate" required value="<?php echo $startDate ?>"></td>
				<script type="text/javascript">
				new datepickr('startdate', { dateFormat: 'Y-m-d' });
				</script>
		</tr>
		
		<tr><input type="hidden" name="success" value="true"><td></td><td><center>
			<input class = "button" type="submit" name = "report" value = "Continue"></center></td>
		</tr>
	
</table>
<br><br><br><br><br><br><br><br><br><br>
</form>

<?php
	if ($success=="true"){


//Check if data ecistes for this date

	$query = "SELECT * FROM avaya WHERE date = '$startDate'";
	//print $query;
	$result = mysqli_query($connection, $query);
	$rows = mysqli_num_rows($result);
	
	if ($rows == 0){ //present empty form if NO data exits for date

?>

<form action = "avayaHandler.php" method = "get">
<?php
//Table
	echo "<h2>".$startDate."</h2>";
	
    echo"<table border='1' class='adminTable'>";
    echo "<tr class='row1'><td>Agent</td><td>Number of Calls &nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;<input type = 'submit' value = 'Save' class='button'></td></td></tr>";
    
    //Author selection goes here
    
    //Get the staff from the staff database
    $query = "SELECT * FROM staff where display = 1 and datatable='MFP'";
    $agentResult = mysqli_query($connection, $query);
    
    while ($row = $agentResult -> fetch_assoc()) {  //Query all agents that display = 1

		echo "<tr><td>".$row['name']."</td>";
		echo "<td><input type='text' name='".$row['staffId']."'type = number size='3' required></td></tr>";
} //agent loop

?>
</table>
<br>

<input type = 'hidden' value = '<?php echo $startDate ?>' name='startDate'>
</form>
<?php 
} else{ //no data exits loop

print "Data already entered for this date";
}
}//success loop

?>
