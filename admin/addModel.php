<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<title>Add New Model</title>
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


//initialize some variables
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
	print "<form action = ../login.php method = get>
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
<h2>Add Model</h2>
<form action="addModelHandler.php" method="post" >
	<table align = center>
		<tr>
		<td>Model Name</td><td><input type="text" name="modelName" placeholder="example MX-4111" required></td>
	
	<?php
	
	//FamilyName
	$query = "SELECT * FROM familyName ORDER BY familyName";
	$result = mysqli_query($connection, $query);
	

    while ($row = $result -> fetch_assoc()) {
    $familyName[] = $row['familyName'];
    $familyNameId[] = $row['familyNameId'];
	$familyNameNumRows = mysqli_num_rows($result);
	
}
	
	?>
	<td>Family Name</td><td><select name="familyName" class = "familyName" required>
                    <option value="">Choose Family</option>
                    <?php
                    for ($i = 0; $i < $familyNameNumRows; $i++) {
                        echo "<option value = '" . $familyNameId[$i] . "'>" . $familyName[$i] . "</option>";
                        echo $i;
                    }
                    ?>
 </select></td></tr>
	
	
    
	
	<tr>
	<?php
	//Display Type
	$query = "SELECT * FROM display ORDER BY display";
	$result = mysqli_query($connection, $query);
	

    while ($row = $result -> fetch_assoc()) {
    $display[] = $row['display'];
    $displayId[] = $row['displayId'];
	$displayNumRows = mysqli_num_rows($result);
	
}
	
	?>
	<td>Display Type</td><td><select name="display" class = "display" required>
                    <option value="">Choose Display</option>
                    <?php
                    for ($i = 0; $i < $displayNumRows; $i++) {
                        echo "<option value = '" . $displayId[$i] . "'>" . $display[$i] . "</option>";
                        echo $i;
                    }
                    ?>
 </select></td>
	
	<?php
	
	//OSA Version
	$query = "SELECT * FROM OSA ORDER BY osa";
	$result = mysqli_query($connection, $query);
	

    while ($row = $result -> fetch_assoc()) {
    $osa[] = $row['osa'];
    $osaId[] = $row['osaId'];
	$osaNumRows = mysqli_num_rows($result);
	
}
	
	?>
	<td>OSA Version</td><td><select name="osa" class = "osa">
                    <option value="">Choose OSA</option>
                    <?php
                    for ($i = 0; $i < $osaNumRows; $i++) {
                        echo "<option value = '" . $osaId[$i] . "'>" . $osa[$i] . "</option>";
                        echo $i;
                    }
                    ?>
 </select></td></tr>
 
	<tr><?php
	
	//Machine Class
	$query = "SELECT * FROM class ORDER BY class";
	$result = mysqli_query($connection, $query);
	

    while ($row = $result -> fetch_assoc()) {
    $class[] = $row['class'];
    $classId[] = $row['classId'];
	$classNumRows = mysqli_num_rows($result);
	
}
	
	?>
	<td>Machine Class</td><td><select name="class" class = "class">
                    <option value="">Choose Class</option>
                    <?php
                    for ($i = 0; $i < $classNumRows; $i++) {
                        echo "<option value = '" . $classId[$i] . "'>" . $class[$i] . "</option>";
                        echo $i;
                    }
                    ?>
 </select></td>
 
 <?php
	
	//Fax Option
	$query = "SELECT * FROM fax ORDER BY fax";
	$result = mysqli_query($connection, $query);
	

    while ($row = $result -> fetch_assoc()) {
    $fax[] = $row['fax'];
    $faxId[] = $row['faxId'];
	$faxNumRows = mysqli_num_rows($result);
	
}
	
	?>
	<td>Fax Model</td><td><select name="fax" class = "fax">
                    <option value="">Choose Fax</option>
                    <?php
                    for ($i = 0; $i < $faxNumRows; $i++) {
                        echo "<option value = '" . $faxId[$i] . "'>" . $fax[$i] . "</option>";
                        echo $i;
                    }
                    ?>
 </select></td></tr>
 
 
 	<tr>
 		<?php
	
	//DSK Option
	$query = "SELECT * FROM dsk ORDER BY dsk";
	$result = mysqli_query($connection, $query);
	

    while ($row = $result -> fetch_assoc()) {
    $dsk[] = $row['dsk'];
    $dskId[] = $row['dskId'];
	$dskNumRows = mysqli_num_rows($result);
	
}
	
	?>
	<td>DSK Model</td><td><select name="dsk" class = "dsk">
                    <option value="">Choose DSK</option>
                    <?php
                    for ($i = 0; $i < $dskNumRows; $i++) {
                        echo "<option value = '" . $dskId[$i] . "'>" . $dsk[$i] . "</option>";
                        echo $i;
                    }
                    ?>
 </select></td>
 		
 		
	<?php
	//Controller Type
	$query = "SELECT * FROM controllerType ORDER BY controller";
	$result = mysqli_query($connection, $query);
	

    while ($row = $result -> fetch_assoc()) {
    $controller[] = $row['controller'];
    $controllerId[] = $row['controllerId'];
	$controllerNumRows = mysqli_num_rows($result);
	
}
	
	?>
	<td>Controller Type</td><td><select name="controller" class = "controller" required>
                    <option value="">Choose Controller</option>
                    <?php
                    for ($i = 0; $i < $controllerNumRows; $i++) {
                        echo "<option value = '" . $controllerId[$i] . "'>" . $controller[$i] . "</option>";
                        echo $i;
                    }
                    ?>
 </select></td>
 
	<tr><td>Finisher</td>
	<td><input type="text" name="finisher"></td>
	
	<td>Saddle Finisher</td>
	<td><input type="text" name="saddleFinisher"></td>
	</tr>
	<tr><td>Paper Deck</td>
	<td><input type="text" name="paperDeck"></td>
		
	<td>LCT</td>
	<td><input type="text" name="lct"></td>
	</tr>
	
	
	
	
	
	
	</table>
	<br /><br />
	<input type="submit">
</form>


</body>
</html>