<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Agent Summary</title>
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
   
?>

<br><br><center>

<form action="summary.php" method = "get" id="summaryForm">
    <table border="1" class="dateTable">
        <tr class="row1">
                    <td colspan=2> <center>Agent Summary</center></td>
        
        
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
        <tr><input type="hidden" name="success" value="true"><td></td><td><center><input class = "button" type="submit" name = "report" value = "View"><!--&nbsp;&nbsp;<input type="submit" name = "report" value = "Export" class="button"></center>--></td>
        </tr>
    
</table>
<br><br><br><br><br><br><br><br><br><br>
</form><!--Report Form-->
<?php

if ($success=="true" AND $report=="View") {
    echo "<h2>Agent Summary </h2><h3>".$startDate." to ".$endDate."</h3>";
    
    //Table
    echo"<table border='1' class='adminTable'>";
    echo "<tr class='row1'><td>Agent</td><td>Success</td><td>No Success</td><td>Authored</td><td>Conf. Repairs</td><td>Content Edited</td><td>T UP + T DOWN</td>
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
    $query = "SELECT * FROM staff where display = 1 AND datatable='MFP'";
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
    
    //Do the Author Query
    $query="SELECT * FROM sharp WHERE date >= '$startDate' AND date <= '$endDate' AND staffId= '$staffId'";
    $result = mysqli_query($connection,$query);
    $totalAuthorRows = mysqli_num_rows($result);
    //print $query;
    
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
	//$ctserver = '172.29.99.92';
	//$ctusername = 'MSGREAD';
	//$ctpassword = 'blu-1r1s';
	//////$ctdatabase = '';
	//$ctdatabase = 'SharpCallCenter';
	//$ctconnection = mssql_connect($ctserver, $ctusername, $ctpassword);
	// 
	//if($ctconnection != FALSE)
	//{
	//echo "Connected to the database server OK<br />";
	//}
	//else
	//{
	//die("Couldn't connect");
	//}
	 
	//if(mssql_select_db($ctdatabase, $ctconnection))
	//{
	//echo "Selected $database ok<br />";
	//}
	//else
	//{
	//die('Failed to select DB');
	//}
 

//$ctquery = mssql_query("SET ANSI_NULLS ON;");
//$ctquery = mssql_query("SET ANSI_WARNINGS ON;"); 
//$ctendDate = $endDate." 23:59:59";
////$query="SELECT * FROM dbo.CallTickets WHERE (LastUpdateDate BETWEEN '$startDate' AND '$ctendDate') AND LastUpdateBy = $techId AND activitytypeid = 1";
//$query="SELECT * FROM dbo.SharpCT_tblSupportTicketHistory WHERE (LastUpdateDate BETWEEN '$startDate' AND '$ctendDate') AND LastUpdateBy = $techId AND activitytypeid = 1";
//$ctquery = mssql_query($query);



//$CTCalls = mssql_num_rows($ctquery);
//while ($row = mssql_fetch_array($ctquery)) {
 // //echo $row['LastUpdateBy']. " ".$row['LastUpdateDate']."<br>";
//}

//mssql_free_result($query);
//mssql_close($connection);
    
    //Call Tracking Server Init

$serverName = '172.29.99.92';
$connectionOptions = array(
    "Database" => 'SharpCallCenter',
    "Uid" => 'MSGREAD',
    "PWD" => 'blu-1r1s'
);
//Establishes the connection
$conn = sqlsrv_connect($serverName, $connectionOptions);
 

 


$ctendDate = $endDate." 23:59:59";
$query="SELECT * FROM dbo.SharpCT_tblSupportTicketHistory WHERE (LastUpdateDate BETWEEN '$startDate' AND '$ctendDate') AND LastUpdateBy 
= $techId AND activitytypeid = 1";
$ctquery = sqlsrv_query($conn, $query, array(), array("Scrollable"=>SQLSRV_CURSOR_KEYSET));


$CTCalls = sqlsrv_num_rows($ctquery);
while ($row = sqlsrv_fetch_array($ctquery)) {
  //echo $row['LastUpdateBy']."".date_format($row['LastUpdateDate'], 'Y-m-d')."<br>";
}
//print "CT_CALLS=".$CTCalls."<br />";
//mssql_free_result($query);
//mssql_close($connection);   
    
    
    //echo results
    
	$totalKid = ($totalSuccessRows + $totalNoSuccessRows);
    $difference = $totalKid-$totalAvayaCalls;
    echo "<tr><td>".$agent."</td><td>".$totalSuccessRows."</td><td>"
    .$totalNoSuccessRows."</td><td>".$totalAuthorRows."</td><td>"
    .$totalConfirmedRepairRows."</td><td>"
    .$totalEditRows."</td><td bgcolor='#add8e6'>"
    .$totalKid."</td><td bgcolor='#add8e6'>"
    .$totalAvayaCalls."</td><td bgcolor='#dfff80'>"
    .$difference."</td><td>"
    .$CTCalls
    ."</td></tr>";
        
    
}//agent loop
echo "</table>";
}//view loop

if ($success=="true" AND $report=="Export") {
    
    //Session data to pass start date and end date
    
    $_SESSION['startdate']   = $startDate;
    $_SESSION['enddate']  = $endDate;
    
    //jump to export.php
    //header("Location: successExport.php");
    print "<b>Code Not yet written ... Sorry :(</b>";
}
?>
</center>


<!--Form Validation-->
<script type="text/javascript">
var frmvalidator  = new Validator("summaryForm");
frmvalidator.addValidation("startdate","req","You must enter a start date");
frmvalidator.addValidation("enddate","req","You must enter a end date");

</script>
</body>

</html>
