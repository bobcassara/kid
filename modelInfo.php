<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title>KID Knowledge Database</title>
        <link href="css/style.css" rel="stylesheet" type="text/css" />
        <script src="js/jquery-2.1.3.min.js"></script>
        <script src="js/jquery.cookie.js"></script>
        <script src="js/functions.js"></script>
        
    </head>

    <body>
    	
<?php
//Lets Connect to the db

        include ("mysql_connect.php");


if (isset($_REQUEST['model'])) {
            $model = $_REQUEST['model'];
}


//Get model ID

$query = "SELECT * FROM model WHERE model = '$model'";
$result = mysqli_query($connection, $query);
while ($row = $result -> fetch_assoc()) {
    $modelId = $row['modelId'];
    $family = $row['family'];
	$modelType = $row['modelType'];
	$displayType=$row['displayType'];
	$osa=$row['osa'];
	$dsk=$row['dsk'];
	$fax=$row['fax'];
	$photo=$row['photo'];
		$photo="images/imagers/".$photo;
	$finisher=$row['finisher'];
	$saddleFinisher=$row['saddleFinisher'];
	$paperDeck=$row['paperDeck'];
	$lct=$row['lct'];
}

echo "<div class='modelinfo'>";
echo "<h1 align=left>&nbsp;&nbsp; ".$model." Machine Details (ID:".$modelId.")</h1>";
echo "<table align=left border=1 cell-padding=10>
<tr>
	<td><b>Family:</b></td><td>". $family."</td>

	<td><b>Model Type:</b></td><td>". $modelType."</td></tr>
<tr>
	<td><b>Display Size:</b></td><td>". $displayType."</td>

	<td><b>OSA Version:</b></td><td>". $osa."</td></tr>	
<tr>
	<td><b>Fax Model:</b></td><td>". $fax."</td>
	<td><b>DSK Model:</b></td><td>". $dsk."</td></tr>
	
<tr>
	<td><b>Finisher:</b></td><td>". $finisher."</td>
	
	<td><b>Saddle Finisher:</b></td><td>". $saddleFinisher."</td></tr>
<tr>
		<td><b>Paper Deck:</b></td><td>". $paperDeck."</td>
		<td><b>LCT:</b></td><td>". $lct."</td></tr>
</table>
<br><br><br><br><br><br><br><br><br><br>
<table align=left>
<tr>
	<td><img align=left width=250 src=".$photo."></td></tr></table>";	



