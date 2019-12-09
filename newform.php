<?php session_start(); ?>
<!DOCTYPE html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>Add KB Content</title>
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<script src="js/gen_validatorv4.js" type="text/javascript"></script>
	<script src="js/jquery-2.1.3.min.js"></script>
	<script src="js/functions.js"></script>
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
	<script type="text/javascript" src="js/multiselect.min.js"></script>
	
<link type="text/css" href="../jquery-picklist.css" rel="stylesheet" />
<!--[if IE 7]><link href="../jquery-picklist-ie7.css" rel="stylesheet" type="text/css" /><![endif]-->
	
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

<form method='POST' action='newFormHandler.php' id="editForm">
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
<td width="100px">Author:</td>
<td><?php echo $name;?></td>
</tr>

<!--Ticket-->

<tr>
<td>Ticket No.:</td>
<td><input type=text name=ticket value=""id = "ticket"></td>
</tr>



<!------------------------------------->
<tr>
	<td>Select Model Type:</td>
	<td><select name="modelType" required>
	<option value="">Select</option>
	<option value="All">All</option>
	<option value="MX Series">MX Series</option>
	<Option Value="Solutions">Solutions</Option>
</select>
</td>
	
	</tr>
<!--MX Model-->
<tr>
	<td class = "mxModels">Models:<br>(use arrow buttons)</td>
	<td class = "mxModels">
<div class="row">
        <div class="left-column">
        	<b>MX Models:</b>
            <select name="from[]" id="multiselect" class="form-control" size="20" multiple="multiple" style="width:225px">
                <?php
				for ($i=0; $i< $modelnumrows; $i++) {
					if ((strpos($Model[$i], 'MX-') !== false)AND($ModelFamily[$i]!='Solution')) {
    			echo "<option value = '". $ModelID[$i] . "'>".$Model[$i]  . "&nbsp; &nbsp; (".$ModelFamily[$i].")</option>";
				}
				}
            ?></select>
        </div>
        <div class="button-column">
            <br><br><br><br>
            <button type="button" id="multiselect_rightAll" class="btn">>></button>
            <button type="button" id="multiselect_rightSelected" class="btn"><i class="glyphicon glyphicon-chevron-right"></i>></button>
            <button type="button" id="multiselect_leftSelected" class="btn"><i class="glyphicon glyphicon-chevron-left"></i><</button>
            <button type="button" id="multiselect_leftAll" class="btn"><i class="glyphicon glyphicon-backward"></i><<</button>
        </div>
        
        <div class="right-column">
        	<b>Selected Models:</b>
            <select name="modelId[]" id="multiselect_to" class="form-control" size="20" multiple="multiple" style="width:225px"></select>
        </div>
    </div>

<!--All Models-->

<tr>
	<td class = "allModels">Models:<br>(Use arrow buttons<br />to move desired<br /> models to the<br />Selected Models box.)</td>
	<td class = "allModels">
<div class="row">
        <div class="left-column">
        	<b>Models:</b>
            <select name="from[]" id="allmultiselect" class="form-control" size="20" multiple="multiple" style="width:225px">
                <?php
				for ($i=0; $i< $modelnumrows; $i++) {
					
    			echo "<option value = '". $ModelID[$i] . "'>".$Model[$i]  . "&nbsp; &nbsp; (".$ModelFamily[$i].")</option>";
				
				}
            ?></select>
        </div>
        <div class="button-column">
            <br><br><br><br>
            <button type="button" id="allmultiselect_rightAll" class="btn"><i class="glyphicon glyphicon-forward"></i>>></button>
            <button type="button" id="allmultiselect_rightSelected" class="btn"><i class="glyphicon glyphicon-chevron-right"></i>></button>
            <button type="button" id="allmultiselect_leftSelected" class="btn"><i class="glyphicon glyphicon-chevron-left"></i><</button>
            <button type="button" id="allmultiselect_leftAll" class="btn"><i class="glyphicon glyphicon-backward"></i><<</button>
        </div>
        
        <div class="right-column">
        	<b>Selected Models:</b>
            <select name="modelId[]" id="allmultiselect_to" class="form-control" size="20" multiple="multiple" style="width:225px"></select>
        </div>
    </div>

<!--Solution Model-->
<tr>
	<td class = "solutionModels">Models:<br>(use arrow buttons)</td>
	<td class = "solutionModels">
<div class="row">
        <div class="left-column">
        	<b>Solutions:</b>
            <select name="from[]" id="solutionmultiselect" class="form-control" size="20" multiple="multiple" style="width:225px">
                <?php
				for ($i=0; $i< $modelnumrows; $i++) {
					if ($ModelFamily[$i]=='Solution') {
    			echo "<option value = '". $ModelID[$i] . "'>".$Model[$i]  . "&nbsp; &nbsp; (".$ModelFamily[$i].")</option>";
				}
				}
            ?></select>
        </div>
        <div class="button-column">
            <br><br><br><br>
            <button type="button" id="solutionmultiselect_rightAll" class="btn">>></button>
            <button type="button" id="solutionmultiselect_rightSelected" class="btn"><i class="glyphicon glyphicon-chevron-right"></i>></button>
            <button type="button" id="solutionmultiselect_leftSelected" class="btn"><i class="glyphicon glyphicon-chevron-left"></i><</button>
            <button type="button" id="solutionmultiselect_leftAll" class="btn"><i class="glyphicon glyphicon-backward"></i><<</button>
        </div>
        
        <div class="right-column">
        	<b>Selected Models:</b>
            <select name="modelId[]" id="solutionmultiselect_to" class="form-control" size="20" multiple="multiple" style="width:225px"></select>
        </div>
    </div>


<script type="text/javascript">
    jQuery(document).ready(function($) {
        $('#allmultiselect').multiselect({sort:false});      
    });
</script>

<script type="text/javascript">
    jQuery(document).ready(function($) {
        $('#multiselect').multiselect({sort:false});
    });
</script>

<script type="text/javascript">
    jQuery(document).ready(function($) {
        $('#solutionmultiselect').multiselect({sort:false});
    });
</script>

<!--Category-->
<tr>
<td>Category:</td>
<td><select name="category" required />
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

<!--Status Codes-->
<tr>
    
<td class="statusCode">Status Code:</td><td class="statusCode"><select type="text" name=statusCode>
	<option value = " "</option>
	<?php
	for ($i=0; $i< $statusCodenumrows; $i++) {
    echo "<option value = '". $statusCode[$i] . "'>". $statusCode[$i] . "</option>";  
}
    ?></select>



</td>
</tr>

<!--Boot Codes-->
<tr>
    
<td class="bootCode">Status Code:</td><td class="bootCode"><select type="text" name=bootCode>
	<option value = " "</option>
	<?php
	for ($i=0; $i< $bootCodenumrows; $i++) {
    echo "<option value = '". $bootCode[$i] . "'>". $bootCode[$i] . "</option>";  
}
    ?></select>



</td>
</tr>
<!--Fin Codes-->
<tr>
    
<td class="finCode">Sub Code:</td><td class="finCode"><select type="text" name=finCode>
	<option value = " "</option>
	<?php
	for ($i=0; $i< $finCodenumrows; $i++) {
    echo "<option value = '". $finCode[$i] . "'>". $finCode[$i] . "</option>";  
}
    ?></select>
<!--Auth Codes-->
<tr>
    
<td class="authCode">Sub Code:</td><td class="authCode"><select type="text" name=authCode>
	<option value = " "</option>
	<?php
	for ($i=0; $i< $authCodenumrows; $i++) {
    echo "<option value = '". $authCode[$i] . "'>". $authCode[$i] . "</option>";  
}
    ?></select>

<!--Prodedure Codes-->
<tr>
    
<td class="procedureCode">Sub Code:</td><td class="procedureCode"><select type="text" name=procedureCode>
	<option value = " "</option>
	<?php
	for ($i=0; $i< $procedureCodenumrows; $i++) {
    echo "<option value = '". $procedureCode[$i] . "'>". $procedureCode[$i] . "</option>";  
}
    ?></select>


</td>
</tr>





<tr>
	<td>Model Exclusive?</td>
	<td><input type="radio" value="No" name="howTo" id="howToNo" checked>No<br>
	<input type="radio" id = "howToYes" value="Yes" name="howTo">Yes
	
	</td>
</tr>
<tr>
<tr>
<td>Symptom:</td>
<td><input type="text" name="problem" value="" size="100" id="problem" required></td>
</tr>
<tr>
<td>Suggestion:</td>
<td><textarea name="solution" cols="85" rows="5" id="solution" required></textarea></td>
</tr>
<tr>
<td colspan=2 align="center" id='botones'>
	
<!--TEMP SUCCESS-->	
<input type = "hidden" value ="0" name ="success">	
<input type = "hidden" value = "<?php echo $name; ?>"name = "enteredBy">	
<input type=submit name=Enviar value='Submit' class="button">
<input type=reset name=reset value='Reset' class="button">
<input type=button name=Cancel value='Cancel' id="cancel" class="button">
</td>
</tr>
</table>
</form>
<br /><br />
<script type="text/javascript">

var frmvalidator  = new Validator("editForm");
//frmvalidator.addValidation("ticket","req","You must enter a ticket number");
frmvalidator.addValidation("category","req","You must enter a category");
frmvalidator.addValidation("modelId","req","You must enter at least one model");
frmvalidator.addValidation("problem","req","You must enter a symptom");
frmvalidator.addValidation("solution","req","You must enter a suggestion");
frmvalidator.addValidation("howTo","selone","Is This a \"HOW TO\"");


//frmvalidator.addValidation("scanCode","req","You must enter a scan Code", "VWZ_IsListItemSelected()(document.forms['editForm'].elements['category'],'Scan')");//NOT WORKING YET

</script>

<script src="js/jquery-picklist.js"></script>
	<script src="js/jquery.ui.widget.js"></script>

	<script type="text/javascript">
		$(function()
		{
			jQuery("#basic").pickList();
		});
	</script>
	    
</body>
</html>

