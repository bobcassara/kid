<!DOCTYPE html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<title>Edit Content</title>
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<script type="text/javascript" src="js/datepickr.js"></script>
	<script src="js/jquery-2.1.3.min.js"></script>
	<script src="js/functions.js"></script>
</head>
<body>
<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(-1);

//connect to server

include ("mysql_connect.php");

//get id number from url

$id = mysqli_real_escape_string($connection, $_GET['id']);

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
	<td>ID:</td><td><?php echo $id; ?></td>
</tr>
<tr>
	<td>Date:</td>
	<td><input id="datepick" type="datetime" name="date" value="<?php echo $date ?>"></td>
</tr>
	
		<script type="text/javascript">
            new datepickr('datepick', {
                dateFormat : 'Y-m-d'
            });
			</script>
<tr>
	<td>Author:</td>
	
	<td><select name="enteredBy" type="text" />
	
	<?php
    for ($i = 0; $i < $staffnumrows; $i++) {
        if ($enteredBy == $staff[$i]) {
            echo "<option selected = 'selected' value = '" . $staffID[$i] . "'>" . $staff[$i] . "</option>";
        } else {
            echo "<option value = '" . $staffID[$i] . "'>" . $staff[$i] . "</option>";
        }
    }
    ?></select></td>
	
</tr>
<tr>
	<td>Ticket:</td>
	<td><input type = "text" name = "ticket" value="<?php echo $ticket; ?>"</td>
    
</tr>

<tr>
	<td>Status:</td>
	<td><select name="statusId">
	<?php
    for ($i = 0; $i < $statusnumrows; $i++) {

        echo $StatusId[$i];

        if ($statusId == $StatusId[$i]) {
            echo "<option selected = 'selected'  value = '" . $StatusId[$i] . "'>" . $Status[$i] . "</option>";
        } else {
            echo "<option value = '" . $StatusId[$i] . "'>" . $Status[$i] . "</option>";
        }
    }
    ?>
	</select></td>
</tr>


<tr>
	<td>Models:</td>
	<td><textarea name="models" rows="5" cols="86"><?php echo $model; ?> </textarea></td></tr>	
<tr>
	<td>Category:</td>
	<td><select name="category" type="text" />
	<option value="%">ALL</option>
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
<tr>
	<td>Sub Category:</td>
	<td><input type = "text" name = "subCat" value="<?php echo $subCat; ?>"</td>
    
</tr>
<tr>
	<td>How To?:</td>
	<td>Yes<input type="radio" name="howTo" value= "yes" <?php
    if ($howTo == "yes") {echo "checked = checked";
    }
    ?><br>
	No<input type="radio" name="howTo" value= "no" <?php
    if ($howTo != "yes") {echo "checked = checked";
    }
    ?></td>




</tr>
<tr>
	<td>Subject:</td>
	<td><input type="text" name="problem" class = "problemTextBox" value="<?php echo $problem; ?>"></td></tr>

<tr>
	<td>Solution:</td>
	<td><textarea name="solution" rows="5" cols="86"><?php echo $solution; ?> </textarea></td></tr>			
	
	
	</table>
<input type = "hidden" name = "id" value = "<?php echo $id; ?>">
<input type = "hidden" name = "family" value = "<?php echo $family; ?>">
<input type = "hidden" name = "class" value = "<?php echo $class; ?>">
<input type = "submit" name="Submit" value="submit">
<input type=button name=Cancel value='Cancel' id="cancel">
</form>
<br /><br /><a href="#" class="delete">Delete this Ticket</a>

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
