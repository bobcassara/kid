<?php
/***** EDIT BELOW LINES *****/
$DB_Server = "localhost"; // MySQL Server
$DB_Username = "root"; // MySQL Username
$DB_Password = "xj80e383"; // MySQL Password
$DB_DBName = "KID"; // MySQL Database Name
$DB_TBLName = "edits"; // MySQL Table Name
$xls_filename = 'editExport_'.date('Y-m-d').'.xls'; // Define Excel (.xls) file name
 
 
session_start();
$startdate   = $_SESSION['startdate'];
$enddate  = $_SESSION['enddate'];
 
 
/***** DO NOT EDIT BELOW LINES *****/
// Create MySQL connection
$sql = "SELECT id,date,editor,repairId,problem,solution FROM edits WHERE date BETWEEN'$startdate' AND '$enddate' ";
$Connect = @mysqli_connect($DB_Server, $DB_Username, $DB_Password) or die("Failed to connect to MySQL:<br />" . mysqli_error() . "<br />" . mysqli_errno());
// Select database
$Db = @mysqli_select_db($Connect, $DB_DBName ) or die("Failed to select database:<br />" . mysqli_error(). "<br />" . mysqli_errno());
// Execute queryi
$result = @mysqli_query($Connect,$sql) or die("Failed to execute query:<br />" . mysqli_error(). "<br />" . mysqli_errno());
 
// Header info settings
header("Content-Type: application/xls");
header("Content-Disposition: attachment; filename=$xls_filename");
header("Pragma: no-cache");
header("Expires: 0");
 
/***** Start of Formatting for Excel *****/
// Define separator (defines columns in excel &amp; tabs in word)
$sep = "\t"; // tabbed character
 
// Start of printing column names as names of MySQL fields
//for ($i = 0; $i<mysql_num_fields($result); $i++) {
//  echo mysql_field_name($result, $i) . "\t";
//}

print "_id_ \t Date \t Author \t Repair ID \t Sympthom \t Suggestion";

print("\n");
// End of printing column names
 
// Start while loop to get data
while($row = mysqli_fetch_row($result))
{
  $schema_insert = "";
  for($j=0; $j<mysqli_num_fields($result); $j++)
  {
    if(!isset($row[$j])) {
      $schema_insert .= "NULL".$sep;
    }
    elseif ($row[$j] != "") {
      $schema_insert .= "$row[$j]".$sep;
    }
    else {
      $schema_insert .= "".$sep;
    }
  }
  $schema_insert = str_replace($sep."$", "", $schema_insert);
  $schema_insert = preg_replace("/\r\n|\n\r|\n|\r/", " ", $schema_insert);
  $schema_insert .= "\t";
  print(trim($schema_insert));
  print "\n";
}
?>
