<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title>KID Knowledge Database</title>
        <link href="css/style.css" rel="stylesheet" type="text/css" />
        <script src="js/jquery-2.1.3.min.js"></script>
        <script src="js/jquery.cookie.js"></script>
        <script src="js/functions.js"></script>
        <link href="css/popup.css" rel="stylesheet" type="text/css";
    
    
    
    
    
    
    </head>
	
    <body>
<?php


include ("mysql_connect.php");


if (isset($_REQUEST['id'])) {
            $id = $_REQUEST['id'];
}

//Table


$query = "SELECT * FROM confirmedRepair WHERE repairId='$id'";

//echo $query;

$result = mysqli_query($connection, $query);
$totalRows= mysqli_num_rows($result);
echo"<table border=1><tr><th>Description</th><th>Reference</td><th>Source</th><th>Entered by</th><th>Date</th></tr>";
while($row = mysqli_fetch_array($result)){
    echo "<tr><td>".$row['confirmedRepairDescription']."</td><td>".$row['confirmedRepairTicket']."</td><td>".$row['confirmedRepairSource']."</td><td>".$row['name']."</td><td>".$row['date']."</tr>";
	
	
}
echo "</table>";
// $query = "SELECT DISTINCT confirmedRepairDescription FROM confirmedRepair WHERE repairId = '$id'";
// //print $query;
// $result = mysqli_query($connection, $query);
// while ($row = $result -> fetch_assoc()) {
// 	
//  
	// echo "
// 		
// 			
			// <td>".$row['confirmedRepairDescription']."</td>
// 	
			// <td>1</td></tr>";
// 		
// }		
	//echo "Total = ".$totalRows;
		
		
    
?>