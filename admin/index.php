<?php session_start(); ?>
<!DOCTYPE html>
<meta http-equiv="refresh" content="60; URL=http://172.29.23.23/repair/admin/index.php">
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

	include ("../mysql_connect.php");

	if (!isset($_SESSION['user'])) {
		print "<h2>Please Login</h2>";
		print "<form action = ../login.php method = post>
	<b>Name: </b><input type = text name = username>
	<b>Password: </b><input type = password name = password>
	<input type = submit name = submit value = Submit>
	</form>";
		exit();
	}
	if (isset($_SESSION['user'])) {
		$username = $_SESSION['user'];
		$query = "SELECT * FROM staff WHERE username = '$username'";
		$result = mysqli_query($connection, $query);
		$row = $result -> fetch_assoc();
		$name = $row['name'];
		$adminLevel=$row['admin'];
	}
	if ($adminLevel<3) {
		//redirect if not an admin	
		 header( 'Location: ../index.php');
	} 
?>
<body>
		<?php
	//Include the header

	require ('adminHeader.html');

	//Get Todays Date and display it
	$today = date("F j, Y, g:i a");

	echo "<h1>" . $today . "</h1>";
	echo "<div style='position:fixed; left:10; top:1;'><h2 align = left>Logged in</h2>";

	//GET Logged in Users
	$query = "SELECT name FROM KID.staff WHERE lastLog = CURDATE()";

	if (!$result = $connection -> query($query)) {
		die('There was an error running the query [' . $db -> error . ']');
	}

	echo "<table border=1><tr class='row1'><td>Agent</td></tr>";

	while ($row = $result -> fetch_assoc()) {
		echo "<tr><td>" . $row['name'] . '</td></tr>';

	}
	echo "</table></div>";
	$startDate = date("Ymd");
	$endDate = date("Ymd");
	echo "<h2>Agent Summary</h2>";
	//Get number of published entries
	$result = $connection->query("SELECT COUNT(*) FROM `sharp` WHERE statusId=2");
	$row = $result->fetch_row();
	echo '<h3>Published entries: ', $row[0]."</h3>";
	//Table
	echo "<table border='1' class='adminTable1' align='center'>";
	echo "<tr class='row1'><td>Agent</td><td>KID Help</td><td>KID No Help</td><td>Authored</td><td>Conf. Repairs</td><td>Content Edited</td><td>T UP + T DOWN</td>
    <td>Call Tracking</td><td>MICAS No Help</td><td>MICAS Help</td></tr>";

	//Check for valid Avaya Data in date range / Flag and notify of missing dates

	$query = "SELECT date from calendar WHERE date BETWEEN'$startDate' AND '$endDate' ORDER BY date";
	//calendar of working days
	$result = mysqli_query($connection, $query);
	while ($row = $result -> fetch_assoc()) {
		$tempDate = $row['date'];
		$avayaQuery = "Select * from avaya where date = '$tempDate'";
		$queryResult = mysqli_query($connection, $avayaQuery);
		$queryNumRows = mysqli_num_rows($queryResult);
		//if ($queryNumRows==0) {echo "<div style = 'color:red; font-weight:bold;'>Note: No Avaya data for".$row['date']."</div>";
	}//end echo

	//}//end Avaya valid data query

	//Get the staff from the staff database
	$query = "SELECT * FROM staff where display = '1' AND datatable = 'MFP'";
	$agentResult = mysqli_query($connection, $query);

	while ($row = $agentResult -> fetch_assoc()) {//Query all agents that display = 1

		$agent = $row['name'];
		$staffId = $row['staffId'];
		$techId = $row['techId'];
		//print $staffId;

		//Do the Success Query
		$query = "SELECT * FROM success WHERE date BETWEEN'$startDate' AND '$endDate' AND author = '$agent'";
		$result = mysqli_query($connection, $query);
		$totalSuccessRows = mysqli_num_rows($result);
		if ($totalSuccessRows == "0") {$totalSuccessRows = "";
		}
		//print $query;

		//Do the Confirmed Repair Query
		$query = "SELECT * FROM confirmedRepair WHERE date BETWEEN'$startDate' AND '$endDate' AND name = '$agent'";
		$result = mysqli_query($connection, $query);
		$totalConfirmedRepairRows = mysqli_num_rows($result);
		if ($totalConfirmedRepairRows == "0") {$totalConfirmedRepairRows = "";
		}
		//print $query;

		//Do the No Success Query
		$query = "SELECT * FROM nosuccess WHERE date BETWEEN'$startDate' AND '$endDate' AND username = '$agent'";
		$result = mysqli_query($connection, $query);
		$totalNoSuccessRows = mysqli_num_rows($result);
		if ($totalNoSuccessRows == "0") {$totalNoSuccessRows = "";
		}
		//print $query;

		//Do the Edit Query
		$query = "SELECT * FROM edits WHERE date BETWEEN'$startDate' AND '$endDate' AND editor = '$agent'";
		$result = mysqli_query($connection, $query);
		$totalEditRows = mysqli_num_rows($result);
		if ($totalEditRows == "0") {$totalEditRows = "";
		}
		//print $query;

		//Do the Author Query
		$query = "SELECT * FROM sharp WHERE date >= '$startDate' AND date <= '$endDate' AND staffId= '$staffId'";
		$result = mysqli_query($connection, $query);
		$totalAuthorRows = mysqli_num_rows($result);
		if ($totalAuthorRows == "0") {$totalAuthorRows = "";
		}
		//print $query;

		//Call Tracking Server Init

		$serverName = '172.29.99.92';
		$connectionOptions = array("Database" => 'SharpCallCenter', "Uid" => 'MSGREAD', "PWD" => 'blu-1r1s');
		//Establishes the connection
		$conn = sqlsrv_connect($serverName, $connectionOptions);
		
		if ($conn) {
		$ctendDate = $endDate . " 23:59:59";
		$query = "SELECT SupportTicketId FROM dbo.SharpCT_tblSupportTicketHistory WHERE (LastUpdateDate BETWEEN '$startDate' AND '$ctendDate') AND LastUpdateBy 
= $techId AND activitytypeid = 1";
		$ctquery = sqlsrv_query($conn, $query, array(), array("Scrollable" => SQLSRV_CURSOR_KEYSET));
		$CTCalls = sqlsrv_num_rows($ctquery);

		//print $query;
		
		}else{print "<h2 font-color=red>Failed to connect to Call Tracking.  Contact MSG Group for assistance.</h2>";
		die( print_r( sqlsrv_errors(), true));
		die();}

		//Initilize counters
		$suckCount = 0;
		$helpCount = 0;

		//Get array of Tickets

		//print $agent."<br>";
		while ($row = sqlsrv_fetch_array($ctquery)) {
			$micasTicket = $row['SupportTicketId'];

			$micasQuery = "SELECT ResID FROM dbo.SharpCT_tblSupportTicketResolutionSource 
		WHERE [TicketID]='$micasTicket'";
			$micasQueryResult = sqlsrv_query($conn, $micasQuery, array(), array("Scrollable" => SQLSRV_CURSOR_KEYSET));
			while ($row = sqlsrv_fetch_array($micasQueryResult)) {
				if ($row['ResID'] == 38 OR $row['ResID'] == 41) {
					//print $micasTicket." Micas sucked";
					$suckCount = $suckCount + 1;
				} else if ($row['ResID'] == 37 OR $row['ResID'] == 40) {//print $micasTicket." Micas Helped";
					$helpCount = $helpCount + 1;
				}

			}
			//print"<br>";

		}
		//print "MICAS Not Helpful Count =".$suckCount."<br>";
		//print "MICAS Helpful Count =".$helpCount;
		//print "<br>";

		//$micasTicket()=$row['SupportTicketId'];

		if ($suckCount == "0") {$suckCount = "";
		}
		if ($helpCount == "0") {$helpCount = "";
		}
		if ($CTCalls == "0") {$CTCalls = "";
		}

		//echo results

		$totalKid = ($totalSuccessRows + $totalNoSuccessRows);
		if ($totalKid == "0") {$totalKid = "";
		}

		echo "<tr><td>" . $agent . "</td><td>" . $totalSuccessRows . "</td><td>" . $totalNoSuccessRows . "</td><td>" . $totalAuthorRows . "</td><td>" . $totalConfirmedRepairRows . "</td><td>" . $totalEditRows . "</td><td bgcolor='#add8e6'>" . $totalKid . "</td><td bgcolor='#add8e6'>" . $CTCalls . "</td><td>" . $suckCount . "</td><td>" . $helpCount . "</td></tr>";

	}//agent loop
	echo "</table>";
?>
</center>
	</body>

</html>
