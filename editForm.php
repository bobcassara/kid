<?php
ini_set("session.gc_maxlifetime", 32400);
ini_set("session.cache_expire", 540);
session_start();
?>
<!DOCTYPE html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Edit Content</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <script type="text/javascript" src="js/datepickr.js"></script>
    <script src="js/jquery-2.1.3.min.js"></script>
    <script src="js/functions.js"></script>
    <script type="text/javascript" src="js/multiselect.min.js"></script>

</head>
<body>
<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(-1);

//connect to server

include ("mysql_connect.php");

//get id number from url

$id = mysqli_real_escape_string($connection, $_REQUEST['id']);

//Get the Row

$query = "SELECT * FROM sharp WHERE id = " . $id . " LIMIT 1";
$result = mysqli_query($connection, $query);

if (!$result) {
    print "Entered row ID is invalid";
    exit();
}
//And the Values

while ($row = $result -> fetch_assoc()) {
	$model = $row['model'];
    $modelId = $row['modelId'];
    $ticket = $row['ticket'];
    $statusId = $row['statusId'];
    $family = $row['family'];
    $class = $row['class'];
    $category = $row['category'];
    $subCat = $row['subCat'];
    $problem = $row['problem'];
    $solution = $row['solution'];
    $date = $row['date'];
    $enteredBy = $row['staffId'];
    $howTo = $row['howTo'];
}

$href="newConfirmedRepair.php?id=".$id;

$newquery = "SELECT * FROM staff WHERE staffId = $enteredBy";
$newresult = mysqli_query($connection, $newquery);
$newrow = $newresult -> fetch_assoc();
$enteredBy = $newrow['name'];

//Define Status default value

$newquery = "SELECT * FROM status WHERE statusId = $statusId";
$newresult = mysqli_query($connection, $newquery);
$newrow = $newresult -> fetch_assoc();
$status = $newrow['status'];
?>
<form action="editFormHandler.php" method="get" enctype="text/plain">
<table width="100%" border="0">
  <tr>
    <td><img align="left" name="logo" type="image" src="images/sharp-transparent.png" width="250"/></td>
    <td><h1 align="right">Edit Content</h1></td>
    
  </tr>
</table>

<hr>

<table>
<tr>
    <td><b>ID:</b></td><td><?php echo $id; ?></td>
</tr>
<tr>
    <td><b>Date:</b></td>
    <td>
        <?php echo $date; ?>
<!--
        <input id="datepick" type="datetime" name="date" value="<?php echo $date ?>">
-->
    </td>
</tr>
    
       
<tr>
    <td><b>Author:</b></td>
    
    <td>
        <?php echo $enteredBy; ?>

    </td>
    
</tr>
<tr>
    <td><b>Ticket:</b></td>
    <td><input type = "text" name = "ticket" value="<?php echo $ticket; ?>"</td>
    
</tr>

<tr>
    <td><b>Status:</b></td>
    <td>
    <?php
    if ($_SESSION['admin']>1) {
    echo "<select name='statusId'>";
    
    
    for ($i = 0; $i < $statusnumrows; $i++) {

        echo $StatusId[$i];

        if ($statusId == $StatusId[$i]) {
            echo "<option selected = 'selected'  value = '" . $StatusId[$i] . "'>" . $Status[$i] . "</option>";
        } else {
            echo "<option value = '" . $StatusId[$i] . "'>" . $Status[$i] . "</option>";
        }
    }
}else{
    echo $status;
	?><input type = "hidden" name = "statusId" value = "<?php echo $statusId; ?>">
	<?php
}
    ?>
    </select></td>
</tr>


<tr>
   
    <!--<td><textarea name="models" rows="5" cols="86"><?php echo $model; ?> </textarea></td>-->
    
    <?php 
    $modelId = rtrim($modelId, ","); //Trim trailing comma
    
    $modelId=(explode(',',$modelId));  //Put selected models into array
	
	?>
    
	
	<!--All Models-->

<tr>
	<td class = "Models"><b>Models:</b><br>(use arrow buttons)</td>
	<td class = "Models">
<div class="row">
        <div class="left-column">
        	<b>Models:</b>
            <select name="from[]" id="allmultiselect" class="form-control" size="20" multiple="multiple" style="width:225px" >
                <?php
				for ($i=0; $i< $modelnumrows; $i++) {
				
        			if (in_array($ModelID[$i],$modelId)){
    			
    				echo "<option value = '". $ModelID[$i] . "'selected=selected>". $Model[$i] . "</option>";
    				}else{ 
    				echo "<option value = '". $ModelID[$i] . "'>". $Model[$i] . "&nbsp; &nbsp; (".$ModelFamily[$i].")</option>";
					}
					
				
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
        	
            <select name="modelId[]" id="allmultiselect_to" class="form-control" size="20" multiple="multiple" style="width:225px">
            	
            </select></td>
        </tr> 
        </div>
    </div>

<script type="text/javascript">
    jQuery(document).ready(function($) {
        $('#allmultiselect').multiselect(
        	{sort:false});
       $('#allmultiselect_rightSelected').click();
    });
</script>   
     
<tr>
    <td><b>Category:</b></td>
    <td><select name="category" type="text" id="category" required />
    <!--<option value="%">ALL</option>-->
    <?php
    for ($i = 0; $i < $categorynumrows; $i++) {
        if ($category == $Category[$i]) {
            echo "<option selected = 'selected' value ='" . $Category[$i] . "'>" . $Category[$i] . "</option>";
        } else {
            echo "<option value = '" . $Category[$i] . "'>" . $Category[$i] . "</option>";
        }

    }
    ?>
    </select></td></tr>
<!-------------------------------------------------------------------------------->
<!--Print Codes--> 
<tr>
 <td class = "printCode" >Print Code:</td><td class = "printCode"><select type="text" name="printCat">
	<option value = ""</option>
	<?php
	for ($i=0; $i< $printCodenumrows; $i++) {
		if ($printCode[$i]==$subCat){
			echo "<option value = '". $printCode[$i] . "' selected>". $printCode[$i] . "</option>";
		}else{
    echo "<option value = '". $printCode[$i] . "'>". $printCode[$i] . "</option>";
}}
    ?></select>
</td>
</tr>
<!--Scan Codes--> 
<tr>
 <td class = "scanCode">Scan Code:</td><td class = "scanCode"><select type="text" name="scanCat">
	<option value = ""</option>
	<?php
	for ($i=0; $i< $scanCodenumrows; $i++) {
		if ($scanCode[$i]==$subCat){
			echo "<option value = '". $scanCode[$i] . "' selected>". $scanCode[$i] . "</option>";
		}else{
    echo "<option value = '". $scanCode[$i] . "'>". $scanCode[$i] . "</option>";
}}
    ?></select>
</td>
</tr>
<!--Image Codes--> 
<tr>
 <td class = "imageCode">Image Quality Code:</td><td class = "imageCode"><select type="text" name="imageCat">
	<option value = ""</option>
	<?php
	for ($i=0; $i< $imageCodenumrows; $i++) {
		if ($imageCode[$i]==$subCat){
			echo "<option value = '". $imageCode[$i] . "' selected>". $imageCode[$i] . "</option>";
		}else{		
		echo "<option value = '". $imageCode[$i] . "'>". $imageCode[$i] . "</option>";
}}
    ?></select>
</td>
</tr>
<!--Fax Codes--> 
<tr><div class="validate">
 <td class = "faxCode">Fax Code:</td><td class = "faxCode"><select type="text" name="faxCat">
	<option value = ""</option>
	<?php
	for ($i=0; $i< $faxCodenumrows; $i++) {
		if ($faxCode[$i]==$subCat){
			echo "<option value = '". $faxCode[$i] . "' selected>". $faxCode[$i] . "</option>";
		}else{		
    echo "<option value = '". $faxCode[$i] . "'>". $faxCode[$i] . "</option>";
}}
    ?></select>
</td>
</tr>
<!--Jam Codes--> 
<tr>
 <td class = "jam">Jam Code:</td><td class = "jam"><select type="text" name="jamCat">
	<option value = ""</option>
	<?php
	for ($i=0; $i< $jamCodenumrows; $i++) {
		if ($jamCode[$i]==$subCat){
			echo "<option value = '". $jamCode[$i] . "' selected>". $jamCode[$i] . "</option>";
		}else{		
    echo "<option value = '". $jamCode[$i] . "'>". $jamCode[$i] . "</option>";
}}
    ?></select>
</td>
</tr></div>
<!--Service Codes-->
<tr>
    
<td class="serviceCode">Error Code:</td><td class="serviceCode"><select type="text" name="serviceCat">
	<option value = " "</option>
	<?php
	for ($i=0; $i< $serviceCodenumrows; $i++) {
		if ($serviceCode[$i]==$subCat){
			echo "<option value = '". $serviceCode[$i] . "' selected>". $serviceCode[$i] . "</option>";
		}else{	
    echo "<option value = '". $serviceCode[$i] . "'>". $serviceCode[$i] . "</option>";  
}}
    ?></select>

<!--Status Codes-->
<tr>
    
<td class="statusCode">Status Code:</td><td class="statusCode"><select type="text" name="statusCat">
	<option value = " "</option>
	<?php
	for ($i=0; $i< $statusCodenumrows; $i++) {
		if ($statusCode[$i]==$subCat){
			echo "<option value = '". $statusCode[$i] . "' selected>". $statusCode[$i] . "</option>";
		}else{	
    echo "<option value = '". $statusCode[$i] . "'>". $statusCode[$i] . "</option>";  
}}
    ?></select>

<!--Boot Codes-->
<tr>
    
<td class="bootCode">Boot Code:</td><td class="bootCode"><select type="text" name="bootCat">
	<option value = " "</option>
	<?php
	for ($i=0; $i< $bootCodenumrows; $i++) {
		if ($bootCode[$i]==$subCat){
			echo "<option value = '". $bootCode[$i] . "' selected>". $bootCode[$i] . "</option>";
		}else{	
    echo "<option value = '". $bootCode[$i] . "'>". $bootCode[$i] . "</option>";  
}}
    ?></select>
<!--Finishing Codes-->
<tr>
    
<td class="finCode">Output / Finishing Code:</td><td class="finCode"><select type="text" name="finCat">
	<option value = " "</option>
	<?php
	for ($i=0; $i< $finCodenumrows; $i++) {
		if ($finCode[$i]==$subCat){
			echo "<option value = '". $finCode[$i] . "' selected>". $finCode[$i] . "</option>";
		}else{	
    echo "<option value = '". $finCode[$i] . "'>". $finCode[$i] . "</option>";  
}}
    ?></select>
<!--Auth Codes-->
<tr>
    
<td class="authCode">Sub Code:</td><td class="authCode"><select type="text" name="authCat">
	<option value = " "</option>
	<?php
	for ($i=0; $i< $authCodenumrows; $i++) {
		if ($authCode[$i]==$subCat){
			echo "<option value = '". $authCode[$i] . "' selected>". $authCode[$i] . "</option>";
		}else{	
    echo "<option value = '". $authCode[$i] . "'>". $authCode[$i] . "</option>";  
}}
    ?></select>

<!--Procedure Codes-->
<tr>
    
<td class="procedureCode">Sub Code:</td><td class="procedureCode"><select type="text" name="procedureCat">
	<option value = " "</option>
	<?php
	for ($i=0; $i< $procedureCodenumrows; $i++) {
		if ($procedureCode[$i]==$subCat){
			echo "<option value = '". $procedureCode[$i] . "' selected>". $procedureCode[$i] . "</option>";
		}else{	
    echo "<option value = '". $procedureCode[$i] . "'>". $procedureCode[$i] . "</option>";  
}}
    
    
    
    
    ?>
    
    </select>


<!--------------------------------------------------------------------------------->


<script type="text/javascript">
    jQuery(document).ready(function($) {
        
       $('#category').click();
    });
</script>   




</td>
</tr>

<tr>
    <td><b>Model Exclusive?</b></td>
    <td>Yes<input type="radio" name="howTo" value= "yes" <?php 
    if (($howTo == "yes")OR($howTo == "Yes")) {echo " checked>";
    }else{echo ">";}
    ?>
    No<input type="radio" name="howTo" value= "no" <?php
    if (($howTo != "Yes" )AND($howTo!="yes")) {echo " checked>";
    }else{echo ">";}
    ?></td>



</tr>
<tr>
    <td><b>Subject:</b></td>
    <!--<td><input type="text" name="problem" class = "problemTextBox" value="<?php echo $problem; ?>"></td></tr>-->
    <td><textarea name="problem" rows="1" cols="86" required><?php echo $problem; ?> </textarea></td></tr>
<tr>
    <td><b>Suggestion:</b></td>
    <td><textarea name="solution" rows="5" cols="86" required><?php echo $solution; ?> </textarea></td></tr>         
<tr>
	<td><b>Confirmed Repair(s):</b></td><td>
	<?php
	//Do the Confirmed Repair Query
    $query = "SELECT confirmedRepairDescription, count(confirmedRepairDescription) AS tagCount FROM confirmedRepair WHERE repairId='$id' GROUP BY confirmedRepairDescription ORDER BY 'tagCount' DESC ";
	$result = mysqli_query($connection, $query);
	$totalRows= mysqli_num_rows($result);
	if ($totalRows>0){
		echo "<table border = 1><tr><td>Hits</td><td>Confirmed Repair</td></tr>";
	while($row = mysqli_fetch_array($result)){
    	echo "<tr><td>".$row['tagCount']. 
    	"</td><td>".$row['confirmedRepairDescription'].
		"</td></tr>";
	} 
	echo "</table>";
}else {echo "There are no confirmed repairs entered for ID ".$id." -- ";}
    
    
      
    ?>
	<a href="#" onClick="window.open('<?php echo $href ?>','pagename','resizable,height=500,width=470'); return false;">Add Confirmed Repair </a>
             </a></td>
</tr>    
    
    </table>
    <br />
<input type = "hidden" name = "id" value = "<?php echo $id; ?>">
<input type = "hidden" name = "family" value = "<?php echo $family; ?>">
<input type = "hidden" name = "class" value = "<?php echo $class; ?>">
<input type = "submit" name="Submit" value="Submit" class="button">
<input type=button name=Cancel value='Cancel' id="cancel" class="button">
</form>
<br /><br /><a href="#" class="delete">Delete this Ticket</a>
<br /><br />
<script>

        $(document).ready(function () {
    $('.delete').click(function () {
        var deleteyes = prompt('Type YES to delete repair ID ' +<?php echo $id; ?>);
        if (deleteyes == 'YES') {
        window.location.replace("delete.php?id="+<?php echo $id; ?>
            );
            }
            });
            });

</script>

</body>
</html>
