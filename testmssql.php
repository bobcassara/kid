<?php
$serverName = "72.29.99.92, 1433"; //serverName\instanceName, portNumber (1433 by default)
$connectionInfo = array( "SharpCallCenter"=>"dbName", "UID"=>"MSGREAD", "PWD"=>"blu-1r1s");



$dsn= 'dblib:host=172.29.99.92:1433;dbname=SharpCallCenter;';
$dbusername="MSGREAD";
$dbpassword="blu-1r1s";
try
{
    $mspdo = new PDO($dsn,$dbusername,$dbpassword);
    $mspdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $pe)
{
    die("database connect error:". $pe->getMessage());
}

if(mssql_select_db($dsn, $mspdo))
	{
	echo "Selected $database ok<br />";
	}
	else
	{
	die('Failed to select DB');
	}
