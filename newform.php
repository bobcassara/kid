<?php session_start(); ?>
<!DOCTYPE html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>Add KB Content</title>
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<script src="js/gen_validatorv4.js" type="text/javascript"></script>
	<script src="js/jquery-2.1.3.min.js"></script>
	<script src="js/functions.js"></script>
</head>
</head>
<body>
	<?php
//Lets Connect to the db
include("mysql_connect.php");


//Who are you??

if(!isset($_SESSION['user'])) {
    header('location:index.php');

} else {
    //echo "Cookie '" . 'user' . "' is set!<br>";
    //echo "Value is: " . $_COOKIE['user'];
    $username=$_SESSION['user'];
    $query="SELECT * FROM staff WHERE username = '$username'";
	$result = mysqli_query($connection,$query);
	$row = $result->fetch_assoc();
    $name = $row['name'];
    //print "NAME = " . $name;
}
?>

<form method='GET' action='newFormHandler.php' id="editForm">
<br>

<table width="100%" border="0">
  <tr>
    <td><img align="left" name="logo" type="image" src="images/sharp-transparent.png" width="250"/></td>
    <td><h1 align="right">Add Content</h1></td>
    
  </tr>
</table>

<hr>

<table border=0 align=center bgcolor=''>

<!--ENtered By-->
<tr>
<td>Author:</td>
<td><?php echo $name;?></td>
</tr>

<!--Ticket-->

<tr>
<td>Ticket No.:</td>
<td><input type=text name=ticket value=""id = "ticket"></td>
</tr>

<!--Model-->

<tr>
<td>Model(s):<br><br><br><small>(Hold CTRL<br>to select<br>multiple models)</small></td>
<td><select multiple name="model[]" size = "30" type="text" id = "model" />
	
	<?php
	for ($i=0; $i< $modelnumrows; $i++) {
    echo "<option value = '". $Model[$i] . "'>". $Model[$i] . "</option>";
}
    ?></select></td>
</tr>

<!--Category-->
<tr>
<td>Category:</td>
<td><select name="category" type="text" />
	<option value=" "></option>
	<?php
	for ($i=0; $i< $categorynumrows; $i++) {
    echo "<option value = '". $Category[$i] . "'>". $Category[$i] . "</option>";
}
    ?></select></td></tr>
    
<!--Print Codes--> 
<tr>
 <td class = "printCode" >Print Code:</td><td class = "printCode"><select type="text" name=printCode>
	<option value = ""</option>
	<?php
	for ($i=0; $i< $printCodenumrows; $i++) {
    echo "<option value = '". $printCode[$i] . "'>". $printCode[$i] . "</option>";
}
    ?></select>
</td>
</tr>
<!--Scan Codes--> 
<tr>
 <td class = "scanCode">Scan Code:</td><td class = "scanCode"><select type="text" name=scanCode>
	<option value = ""</option>
	<?php
	for ($i=0; $i< $scanCodenumrows; $i++) {
    echo "<option value = '". $scanCode[$i] . "'>". $scanCode[$i] . "</option>";
}
    ?></select>
</td>
</tr>
<!--Image Codes--> 
<tr>
 <td class = "imageCode">Image Quality Code:</td><td class = "imageCode"><select type="text" name=imageCode>
	<option value = ""</option>
	<?php
	for ($i=0; $i< $imageCodenumrows; $i++) {
    echo "<option value = '". $imageCode[$i] . "'>". $imageCode[$i] . "</option>";
}
    ?></select>
</td>
</tr>
<!--Fax Codes--> 
<tr><div class="validate">
 <td class = "faxCode">Fax Code:</td><td class = "faxCode"><select type="text" name=faxCode>
	<option value = ""</option>
	<?php
	for ($i=0; $i< $faxCodenumrows; $i++) {
    echo "<option value = '". $faxCode[$i] . "'>". $faxCode[$i] . "</option>";
}
    ?></select>
</td>
</tr>
<!--Jam Codes--> 
<tr>
 <td class = "jam">Jam Code:</td><td class = "jam"><select type="text" name=jamCode>
	<option value = ""</option>
	<?php
	for ($i=0; $i< $jamCodenumrows; $i++) {
    echo "<option value = '". $jamCode[$i] . "'>". $jamCode[$i] . "</option>";
}
    ?></select>
</td>
</tr></div>
<!--Service Codes-->
<tr>
    
<td class="serviceCode">Service Code:</td><td class="serviceCode"><select type="text" name=serviceCode>
	<option value = " "</option>
	<?php
	for ($i=0; $i< $serviceCodenumrows; $i++) {
    echo "<option value = '". $serviceCode[$i] . "'>". $serviceCode[$i] . "</option>";  
}
    ?></select>



</td>
</tr>
<tr>
	<td>How To?</td>
	<td><input type="radio" value="No" name="howTo" id="howToNo" select="notselected">No<br>
	<input type="radio" id = "howToYes" value="Yes" name="howTo">Yes
	
	</td>
</tr>
<tr>
<tr>
<td>Symptom:</td>
<td><input type="text" name="problem" value="" size="100" id="problem"></td>
</tr>
<tr>
<td>Suggestion:</td>
<td><textarea name="solution" cols="85" rows="5" id="solution"></textarea></td>
</tr>
<tr>
<td colspan=2 align="center" id='botones'>
	
<!--TEMP SUCCESS-->	
<input type = "hidden" value ="0" name ="success">	
<input type = "hidden" value = "<?php echo $name; ?>"name = "enteredBy">	
<input type=submit name=Enviar value='Submit'>
<input type=reset name=reset value='Reset'>
<input type=button name=Cancel value='Cancel' id="cancel">
</td>
</tr>
</table>
</form>

<script type="text/javascript">

var frmvalidator  = new Validator("editForm");
frmvalidator.addValidation("ticket","req","You must enter a ticket number");
frmvalidator.addValidation("category","req","You must enter a category");
frmvalidator.addValidation("model","req","You must enter at least one model");
frmvalidator.addValidation("problem","req","You must enter a symptom");
frmvalidator.addValidation("solution","req","You must enter a suggestion");
frmvalidator.addValidation("howTo","selone","Is This a \"HOW TO\"");


//frmvalidator.addValidation("scanCode","req","You must enter a scan Code", "VWZ_IsListItemSelected()(document.forms['editForm'].elements['category'],'Scan')");//NOT WORKING YET

</script>
</body>
</html>

