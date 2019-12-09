<?php

# Lets init our variables
$confirmedSolution="";
$ticket="";
$source="";
$id="";
$name="";

//Connect to database
require("mysql_connect.php");

# Get data from the URL

if (isset($_REQUEST['confirmedSolution'])) {
	$confirmedSolution = $_REQUEST['confirmedSolution'];}

if (isset($_REQUEST['ticket'])) {
	$ticket = $_REQUEST['ticket'];}

if (isset($_REQUEST['source'])) {
	$source = $_REQUEST['source'];}	

if (isset($_REQUEST['id'])) {
	$id = $_REQUEST['id'];}	

	if (isset($_REQUEST['name'])) {
	$name = $_REQUEST['name'];}	

	// print $confirmedSolution. "<br />";
	// print $ticket."<br />";
	// print $source."<br />";
	// print $id."<br />";
	// print $name."<br/>";
// 	
	//prepare query
	
	$query = "INSERT INTO confirmedRepair (repairId, confirmedRepairDescription, confirmedRepairTicket, confirmedRepairSource, name, date)VALUES ('$id', '$confirmedSolution', '$ticket','$source', '$name', NOW())";
	
	mysqli_query($connection,$query)or die(mysqli_error($connection));


//close the window

echo "<script>window.close();</script>";
