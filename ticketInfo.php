<!DOCTYPE html>
<?php

//init variables

$ticketNumber=NULL;

$serverName = '172.29.99.92';
$connectionOptions = array(
    "Database" => 'SharpCallCenter',
    "Uid" => 'MSGREAD',
    "PWD" => 'blu-1r1s'
);
//Establishes the connection
$conn = sqlsrv_connect($serverName, $connectionOptions);
 

 
 //Get from URL



if (isset($_REQUEST['ticket'])) {
            $ticketNumber = $_REQUEST['ticket'];
            //$ticketNumber = "%".$ticketNumber."%";
        } 

 
//$query = sqlsrv_query($conn, $tsql);("SET ANSI_NULLS ON;");
//$query = sqlsrv_query($conn, $tsql);("SET ANSI_WARNINGS ON;"); 

$q = "SELECT * FROM dbo.SharpCT_tblSupportTickets WHERE SupportTicketID LIKE '$ticketNumber'";

$query = sqlsrv_query($conn, $q);
$numberOfResults = sqlsrv_num_rows($query);

//print $q;

print "<table border = 1 cellpadding = 4>
<tr style='background-color:#115db2;color:white;text-align:center;'><td>Ticket</td><td>Created Date</td><td>Model</td><td>Serial Number</td><td>Resolution Source</td><td>Description</td><td>Resolution</td></tr>";



while ($row = sqlsrv_fetch_array($query)) {
	
	
	//Get Resolution
	$qres = "SELECT * FROM dbo.SharpCT_tblSupportTicketResolutionSource WHERE TicketID LIKE '$ticketNumber'";
	//print $qres;
	$queryRes = sqlsrv_query($conn, $qres);
	$numberOfResults = sqlsrv_num_rows($queryRes);
	$resolutionText="";
	while ($rowRes = sqlsrv_fetch_array($queryRes)) {
		$resolutionSource=$rowRes['ResID'];
		if ($resolutionSource==32){$resolutionText="Exchange Requested";}
		if ($resolutionSource==33){$resolutionText="Exchange Approved";}
		if ($resolutionSource==34){$resolutionText="Exchange Processed";}
		if ($resolutionSource==35){$resolutionText="Replacement Recvd by Cust";}
	}

	//Get Models
	$modelID= $row['ModelID'];
	$qmod = "SELECT * FROM dbo.SharpCT_tblModels WHERE modelID LIKE '$modelID'";
	$queryMod = sqlsrv_query($conn, $qmod);
	$numberOfResults = sqlsrv_num_rows($queryMod);
	
	while ($rowMod = sqlsrv_fetch_array($queryMod)) {
		$modelName=$rowMod['ModelName'];}
  
  
  echo "<tr><td>";
  echo $row['SupportTicketID']. "</td><td>". date_format($row['CreatedDate'], 'Y-m-d')."</td><td>".$modelName."</td><td>".$row['SerialNumber']."</td><td>".$resolutionText."</td><td>".$row['Description']."</td><td>".$row['ResolutionSummary']."</td></tr>";
}


echo "</table>";



