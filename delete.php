<?php

//Error Reporting
//error_reporting(0);

//Lets Connect to the db

require ("mysql_connect.php");

//Lets get the form variables

if (isset($_REQUEST['id'])) {//ID
    $id = $_REQUEST['id'];
}

//Delete this ID from the database

// delete record from database
if ($stmt = $connection->prepare("DELETE FROM sharp WHERE id = ? LIMIT 1"))
{
$stmt->bind_param("i",$id);
$stmt->execute();
$stmt->close();
}
else
{
echo "ERROR: could not prepare SQL statement.";
}
$connection->close();
header('location:index.php');
?>
