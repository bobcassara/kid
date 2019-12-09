<?php session_start();?>
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
//Lets Connect to the db

        include ("mysql_connect.php");


if (isset($_REQUEST['id'])) {
            $id = $_REQUEST['id'];
}

//Table

echo "<br /><br />";

//Get model ID

$query = "SELECT DISTINCT confirmedRepairDescription FROM confirmedRepair WHERE repairId = '$id'";
$result = mysqli_query($connection, $query);
$totalRows=mysqli_num_rows($result);

//Open Form
?><form action="newConfirmedRepairHandler.php" method="get" id= "confirmedRepairForm"><?php

//If exists then display the results
if ($totalRows>0){
	echo "<table border=1>
	<tr><th>Exsisting Confirmed Repair(s)</th></tr>
	";
	
	while ($row = $result -> fetch_assoc()) {
		echo "
			<tr>
				
				<td><input type = radio name = 'existing' value='".$row['confirmedRepairDescription']."' required>".$row['confirmedRepairDescription']."
			</td></tr>";}
		echo "<td><input type = radio name = 'existing' value='new' required id='new'>Other (Enter information below)</td></tr></table><h4 align='left'>Choose a solution from the table above or enter a new solution</h4>";
	
	}else{echo "<br /><table><tr><td>There are currently no Confirmed Repairs for ID ".$id."</td></tr>
	<tr><td><input type = radio name = 'existing' value='new' required id='new'>NEW (enter below)</td></tr></table><br />";}
	
	?>
	
	<?php  
	  if (!isset($submitted)){
	  
	  echo "<table border=0>
	    <tr class='newConfirmedRepair'>
	      <td>Confirmed Solution: </td>
	      <td><input type = 'text' name='confirmedSolution' id='confirmedSolution' required></td></tr>
	   <tr>
	    <td>TAC Ticket or reference: </td>
	    <td><input type='text' name = 'ticket' required></td></tr>
	   <tr>
	    <td>Source: </td>
	    <td><input type = radio name = 'source' value='TAC' required>TAC Ticket
	        <input type = radio name='source' value = EQuality>EQuaity
	        <input type = radio name = 'source' value = 'DSS'>DSS
	        <input type = radio name = 'source' value = 'Tech'>Tech
	        </td></tr>
	      
	      
	      </table>";
	  }
	  
	  
	  
	?>
	<br />
	<input type = 'hidden' name='id' value ='<?php echo $id; ?>'>
	<input type = 'hidden' name="name" value = '<?php echo $_SESSION['name']; ?>'>
	<div align='left'><input type="submit" class='button' value ="Save"></div>
	</form>
	
