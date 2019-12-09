<?php session_start();?>
<!DOCTYPE html> 
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<title>KID Administrator</title>
	<link rel="stylesheet" type="text/css" href="../css/style.css">
	<script type="text/javascript" src="../js/datepickr.js"></script>
	<script src="../js/jquery-2.1.3.min.js"></script>
	<script src="../js/functions.js"></script>
	
</head>
<?php
//Error Reporting
//error_reporting(0);

//Lets Connect to the db

include("../mysql_connect.php");

if(!isset($_SESSION['user'])) {
	print "<h2>Please Login</h2>";
	print "<form action = login.php method = post>
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
<body>
<?php	
//Include the header

require('adminHeader.html');

//Get Todays Date and display it
$today = date("F j, Y, g:i a");   

echo "<h1>".$today."</h1>";
echo "<div style='position:fixed; left:10; top:1;'><h2 align = left>Logged in</h2>";

//GET Logged in Users
$query = "SELECT name FROM KID.staff WHERE lastLog = CURDATE()";


if(!$result = $connection->query($query)){
    die('There was an error running the query [' . $db->error . ']');
}

echo "<table border=1><tr class='row1'><td>Agent</td></tr>";

while($row = $result->fetch_assoc()){
    echo "<tr><td>".$row['name'] .'</td></tr>';
    
    }
echo "</table></div>";
$startDate = date("Ymd");
$endDate = date("Ymd");
echo "<h2>Agent Summary</h2>";
  
    //Table
    echo"<table border='1' class='adminTable1' align='center'>";
    echo "<tr class='row1'><td>Agent</td><td>Success</td><td>No Success</td><td>MFP Authored</td><td>IDP Authored</td><td>Conf. Repairs</td><td>Content Edited</td><td>T UP + T DOWN</td>
    <td>Avaya Calls</td><td>Difference</td><td>Call Tracking</td></tr>";
    
    //Check for valid Avaya Data in date range / Flag and notify of missing dates
    
    $query ="SELECT date from calendar WHERE date BETWEEN'$startDate' AND '$endDate' ORDER BY date"; //calendar of working days
    $result = mysqli_query($connection, $query);
    while ($row=$result -> fetch_assoc()) {
		$tempDate=$row['date'];
		$avayaQuery = "Select * from avaya where date = '$tempDate'";
		$queryResult=mysqli_query($connection, $avayaQuery);
		$queryNumRows=mysqli_num_rows($queryResult);
		if ($queryNumRows==0) {echo "<div style = 'color:red; font-weight:bold;'>Note: No Avaya data for".$row['date']."</div>";
	}//end echo
		
		}//end Avaya valid data query
    
    
    //Get the staff from the staff database
    $query = "SELECT * FROM staff where display = 1";
    $agentResult = mysqli_query($connection, $query);
    
    while ($row = $agentResult -> fetch_assoc()) {  //Query all agents that display = 1
    
    $agent=$row['name'];
    $staffId = $row['staffId'];
    $techId= $row['techId'];
    //print $staffId;
    
    //Do the Success Query
    $query="SELECT * FROM success WHERE date BETWEEN'$startDate' AND '$endDate' AND author = '$agent'";
    $result = mysqli_query($connection,$query);
    $totalSuccessRows = mysqli_num_rows($result);
    //print $query;
    
    //Do the Confirmed Repair Query
    $query="SELECT * FROM confirmedRepair WHERE date BETWEEN'$startDate' AND '$endDate' AND name = '$agent'";
    $result = mysqli_query($connection,$query);
    $totalConfirmedRepairRows = mysqli_num_rows($result);
    //print $query;
    
    
    //Do the No Success Query
    $query="SELECT * FROM nosuccess WHERE date BETWEEN'$startDate' AND '$endDate' AND username = '$agent'";
    $result = mysqli_query($connection,$query);
    $totalNoSuccessRows = mysqli_num_rows($result);
    //print $query;
    
    //Do the Edit Query
    $query="SELECT * FROM edits WHERE date BETWEEN'$startDate' AND '$endDate' AND editor = '$agent'";
    $result = mysqli_query($connection,$query);
    $totalEditRows = mysqli_num_rows($result);
    //print $query;
    
    //Do the MFP Author Query
    $query="SELECT * FROM sharp WHERE date >= '$startDate' AND date <= '$endDate' AND staffId= '$staffId'";
    $result = mysqli_query($connection,$query);
    $totalAuthorRows = mysqli_num_rows($result);
    //print $query;
    
    //Do the IDP Author Query
    $query="SELECT * FROM _IDPsharp WHERE date >= '$startDate' AND date <= '$endDate' AND staffId= '$staffId'";
    $result = mysqli_query($connection,$query);
    $totalIDPAuthorRows = mysqli_num_rows($result);
    
    
    //Do the Avaya Query
    $query="SELECT * FROM avaya WHERE date >= '$startDate' AND date <= '$endDate' AND agent= '$agent'";
    $result = mysqli_query($connection,$query);
    //initilize 
    settype($totalAvayaCalls, "integer");
    $totalAvayaCalls=0;
    
    //While Data sum # of calls
    while ($row = $result -> fetch_assoc()) {
    
		
		$totalAvayaCalls = $totalAvayaCalls + $row['calls'];
    }//AvayaLoop
    
    //Call Tracking DATA query
    
    //$ctserver = '172.29.103.32\CALLTRACKING';
	$ctserver = '172.29.99.92';
	$ctusername = 'MSGREAD';
	$ctpassword = 'blu-1r1s';
	$ctdatabase = 'SharpCallCenter';
	//$ctconnection = mssql_connect($ctserver, $ctusername, $ctpassword); 
	$connectionInfo=array( "Database"=>"SharpCallCenter", "UID"=>"MSGREAD", "PWD"=>"blu-1r1s");
	
	
	$ctconnection = sqlsrv_connect($ctserver, $connectionInfo); 
	 
	if($ctconnection != FALSE)
	{
	echo "Connected to the database server OK<br />";
	}
	else
	{
	die( print_r( sqlsrv_errors(), true));
	}
	 
	if(mssql_select_db($ctdatabase, $ctconnection))
	{
	//echo "Selected $database ok<br />";
	}
	else
	{
	die('Failed to select DB');
	}
 

$ctquery = mssql_query("SET ANSI_NULLS ON;");
$ctquery = mssql_query("SET ANSI_WARNINGS ON;"); 
$ctendDate = $endDate." 23:59:59";
$query="SELECT * FROM dbo.SharpCT_tblSupportTicketHistory WHERE (LastUpdateDate BETWEEN '$startDate' AND '$ctendDate') AND LastUpdateBy = $techId AND activitytypeid = 1";
$ctquery = mssql_query($query);



$CTCalls = mssql_num_rows($ctquery);
while ($row = mssql_fetch_array($ctquery)) {
  //echo $row['LastUpdateBy']. " ".$row['LastUpdateDate']."<br>";
}

//mssql_free_result($query);
//mssql_close($connection);
    
    
    
    
    //echo results
    
	$totalKid = ($totalSuccessRows + $totalNoSuccessRows);
    $difference = $totalKid-$totalAvayaCalls;
    echo "<tr><td>".$agent."</td><td>".$totalSuccessRows."</td><td>"
    .$totalNoSuccessRows."</td><td>"
    .$totalAuthorRows."</td><td>"
    .$totalIDPAuthorRows."</td><td>"
    .$totalConfirmedRepairRows."</td><td>"
    .$totalEditRows."</td><td bgcolor='#add8e6'>".$totalKid."</td><td bgcolor='#add8e6'>".$totalAvayaCalls."</td><td bgcolor='#dfff80'>".$difference."</td><td>".$CTCalls."</td></tr>";
        
    
}//agent loop
echo "</table>";
?>
</center>


</body>

</html>
