<?php
ini_set("session.gc_maxlifetime", 32400);
ini_set("session.cache_expire", 540);
session_start();
?>
<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<title>KID Knowledge Database</title>
		<link href="css/style.css" rel="stylesheet" type="text/css" />
		<script src="js/jquery-2.1.3.min.js"></script>
		<script src="js/jquery.cookie.js"></script>
		<script src="js/functions.js?ver2"></script>
	</head>
	<body>

		<!--Javascript not enabled?? Then redirect-->
		<noscript>
			<meta http-equiv="refresh" content="0; url=nojavascript.html" />
		</noscript>

		<!--Form Start-->
		<form action="index.php" method="get">

		<?php
		//----------------------------------------------------------------------------------------------
		//init variables
		$value = "Show More";
		$scanC = "";
		$printC = "";
		$jamC = "";
		$serviceC = "";
		$bootC = "";
		$faxC = "";
		$imageC = "";
		$statusC = "";
		$finC = "";
		$authC = "";
		$procedureC = "";
		$id = NULL;
		$name = NULL;
		$more = "hidden";
		$idNumber = "";
		//-------------------------------------------------------------------------------------------------
		//Set cookie for displaying extras bar
		//if (!isset($_COOKIE['more'])) {
		//	setcookie('more', 'hidden');
		//} else {
		//	$more = $_COOKIE['more'];
		//}
		////Check hidden row value
		//if (isset($_COOKIE['more'])) {
		//	if ($_COOKIE['more'] == "hidden") {
		//		$value = "Show More";
		//	} else {
		//		$value = "Show Less";
		//	}
		//}
		$more = "show";
		//Error Reporting
		//error_reporting(0);
		ini_set('display_errors', 1);
		ini_set('display_startup_errors', 1);
		error_reporting(E_ALL);
		//Connect to the db
		include ("mysql_connect.php");
		//----------------------------------------------------------------------------------------------------------------------
		//Get the form variables
		if (isset($_REQUEST['ticket'])) {//TICKET
			$ticket = "%" . mysqli_real_escape_string($connection, $_REQUEST['ticket']) . "%";
		} else {
			$ticket = "%";
		}
		$ticketDisplay = preg_replace("/[%]/", "", $ticket);
		if ($ticketDisplay == "") {$ticketDisplay = "All Tickets";
		}//This is displayed on search bar
		if (isset($_REQUEST['problem'])) {//PROBLEM
			$problem = "%" . mysqli_real_escape_string($connection, $_REQUEST['problem']) . "%";
		} else {
			$problem = "%";
		}
		if (isset($_REQUEST['modelId'])) {//MODEL
			$modelId = mysqli_real_escape_string($connection, $_REQUEST['modelId']);
		} else {$modelId = "%";
		}
		if (isset($_REQUEST['modelsolutions'])) {
			$modelsolutions = "%" . mysqli_real_escape_string($connection, $_REQUEST['modelsolutions']) . "%";
		} else {
			$modelsolutions = "%";
		}
		if (isset($_REQUEST['solution'])) {//Solution
			$solution = "%" . mysqli_real_escape_string($connection, $_REQUEST['solution']) . "%";
		} else {
			$solution = "%";
		}
		$solutionDisplay = preg_replace("/[%]/", "", $solution);
		if ($solutionDisplay == "") {$solutionDisplay = "Any Solution";
		}
		if (isset($_REQUEST['status'])) {//Status
			$status = mysqli_real_escape_string($connection, $_REQUEST['status']);
		} else {
			$status = "ALL";
		}
		$statusDisplay = preg_replace("/[%]/", "", $status);
		if ($statusDisplay == "") {$statusDisplay = "Any Status";
		}
		if (isset($_REQUEST['enteredBy'])) {//Author
			$enteredBy = mysqli_real_escape_string($connection, $_REQUEST['enteredBy']);
		} else {
			$enteredBy = "%";
		}
		$enteredByDisplay = preg_replace("/[%]/", "", $enteredBy);
		if ($enteredByDisplay == "") {$enteredByDisplay = "Anyone";
		}
		if (isset($_REQUEST['category'])) {//Category
			$category = mysqli_real_escape_string($connection, $_REQUEST['category']);
		} else {
			$category = "%";
		}
		$categoryDisplay = preg_replace("/[%]/", "", $category);
		if ($categoryDisplay == "") {$categoryDisplay = "All Categories";
		}
		if (isset($_REQUEST['subCat'])) {//Sub Category
			$subCat = mysqli_real_escape_string($connection, $_REQUEST['subCat']);
		} else {
			$subCat = "%";
		}
		$subCatDisplay = preg_replace("/[%]/", "", $subCat);
		if ($subCatDisplay == "")
			$subCatDisplay = "All Subs";
		if (isset($_REQUEST['submit']) && (isset($_SESSION['user']))) {
			$submitted = "true";
			$username = $_SESSION['user'];
			$query = "SELECT * FROM staff WHERE username = '$username'";
			$result = mysqli_query($connection, $query);
			$row = $result -> fetch_assoc();
			$name = $row['name'];
		} else {
			$submitted = "false";
		}
		if (isset($_REQUEST['submit'])) {
			$submit = mysqli_real_escape_string($connection, $_REQUEST['submit']);
		}
		if (isset($_REQUEST['id'])) {
			$id = mysqli_real_escape_string($connection, $_REQUEST['id']);
		}
		if (isset($_REQUEST['idNumber'])) {
			$idNumber = mysqli_real_escape_string($connection, $_REQUEST['idNumber']);
		}
		//Sub Codes
		if (isset($_REQUEST['printCode'])) {
			$printC = mysqli_real_escape_string($connection, $_REQUEST['printCode']);
			//Print COde
		}
		if (isset($_REQUEST['scanCode'])) {
			$scanC = mysqli_real_escape_string($connection, $_REQUEST['scanCode']);
			//Scan Code
		}
		if (isset($_REQUEST['faxCode'])) {
			$faxC = mysqli_real_escape_string($connection, $_REQUEST['faxCode']);
			//Fax Code
		}
		if (isset($_REQUEST['imageCode'])) {
			$imageC = mysqli_real_escape_string($connection, $_REQUEST['imageCode']);
			//Image Code
		}
		if (isset($_REQUEST['jamCode'])) {
			$jamC = mysqli_real_escape_string($connection, $_REQUEST['jamCode']);
			//Jam Code
		}
		if (isset($_REQUEST['serviceCode'])) {
			$serviceC = mysqli_real_escape_string($connection, $_REQUEST['serviceCode']);
			//Service Code
		}
		if (isset($_REQUEST['statusCode'])) {
			$statusC = mysqli_real_escape_string($connection, $_REQUEST['statusCode']);
			//Status Code
		}
		if (isset($_REQUEST['bootCode'])) {
			$bootC = mysqli_real_escape_string($connection, $_REQUEST['bootCode']);
			//boot Code
		}
		if (isset($_REQUEST['finCode'])) {
			$finC = mysqli_real_escape_string($connection, $_REQUEST['finCode']);
			//Fin Code
		}
		if (isset($_REQUEST['authCode'])) {
			$authC = mysqli_real_escape_string($connection, $_REQUEST['authCode']);
			//Auth Code
		}
		if (isset($_REQUEST['procedureCode'])) {
			$procedureC = mysqli_real_escape_string($connection, $_REQUEST['procedureCode']);
			//Procedure Code
		}
		$subCat = $printC . $scanC . $jamC . $serviceC . $imageC . $faxC . $statusC . $bootC . $finC . $authC . $procedureC;
		if ($subCat == "") {$subCat = "%";
		}
		//----------------------------------------------------------------------------------------------------
		//Init Login Credentials
		$user = "";
		$password = "";
		?>

		<!--Upper Navigation Bar-->
		<ul>
		<li><a href="../"><img style="text-align:left;" src="images/sharp.jpg" alt="logo" width="90"/></a></li>
		<li><b>Welcome <?php
		if (isset($_SESSION['name'])) {echo $_SESSION['name'];
		}
		?></b></li>
		<li><?php
		if (isset($_SESSION['name'])) {echo "<a href = 'logout.php'>Logout</a></li>";
		}
		?>
		<li><?php
		if (isset($_SESSION['admin']) AND ($_SESSION['admin'] >= 1)) {
			echo "<a id='addNew' href=#>
		Add New Content
		</a>";
		}
		?></li>
		<li><?php
		if (isset($_SESSION['admin']) AND ($_SESSION['admin'] >= 3)) {
			echo "<a id='admin' href=#>
		Administration
		</a>";
		}
		?> </li>
		<li><a href="javascript:window.open('../watchlist/index.php','Watch List','width=500,height=350')">Watch List
		</li>
		<li><a href="javascript:window.open('../OpenTickets/index.php','Investigation Queue','width=1500,height=550')">Investigation Queue
		</li>

		<li><a href="../index.html">Main Menu</a></li>
		 <li><a href="bobble.php"><img width="75 px" src="images/bobble.png">Search</a></li>
		<li><div style="text-align:center;">
		<button id='idcToggle' class='idcToggle'>
		MFP Database
		</button>
		</div></li>
		<div id="kidlogo">KID</div>

		</ul>

		<!--Table (Search Form)-->

		<table style ="text-align:center;" class="searchtable">

		<tr>

		<td colspan="2" class = "searchTableHeadings">
		Model:
		</td>

		<td  class = "searchTableHeadings">
		Category:
		</td>

		<!--Sub Code Labels-->

		<td class = "searchTableHeadings">
		Sub Category:
		</td>
		<td class = "searchTableHeadings">
		Symptom:
		</td>
		<td rowspan="3">
		<div style="text-align:center;">
		<button id='reset' class='button'>
		Reset Form
		</button>
		</div></td>
		<!--<input type="hidden" value = "" name="id">-->
		<!--Update Display Button-->
		<td rowspan="3">
		<div style="text-align:center;">
		<input id = "updateButton" class="button" name="submit" type="submit" value="Update Display">
		</div></td>
		</tr>
		<tr>

		<!--Model-->

		<td colspan="2"><div  style="text-align:center;">

		<?php echo "<img src='images/get_info.png' width='17'>"; ?>
		<select name="modelId" class="modelNumber"/>
		<option value="%">All Models</option>
		<?php
		$GBMquery = "SELECT * FROM model ORDER BY `model` ASC";
		$GBMresult = mysqli_query($connection, $GBMquery);
		$GBMmodelnumrows = mysqli_num_rows($GBMresult);
		while ($row = $GBMresult -> fetch_assoc()) {
			$GBMModel[] = $row['model'];
			$GBMModelID[] = $row['modelId'];
			$GBMModelFamily[] = $row['family'];
		}
		for ($i = 0; $i < $GBMmodelnumrows; $i++) {
			if ($modelId == $GBMModelID[$i]) {
				echo "<option selected = 'selected' value ='" . $GBMModelID[$i] . "'>" . $GBMModel[$i] . "</option>";
			} else {
				echo "<option value = '" . $GBMModelID[$i] . "'>" . $GBMModel[$i] . "</option>";
			}
		}
		?></select></td>
		</div></td>
		<!--Model Solutions-->

		<!--Category-->

		<td style="text-align:center;">
		<select class="category" name="category">
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
		</select></td>

		<!---------------------------------------------------------------------------------------------------------------------------------------------
		<!--Sub Category-->

		<!--Print Codes-->

		<td style="text-align:center;" class="printCode">
		<select name="printCode">
		<option value = ""></option>
		<?php
		for ($i = 0; $i < $printCodenumrows; $i++) {
			echo "<option value = '" . $printCode[$i] . "'>" . $printCode[$i] . "</option>";
		}
		?>
		</select></td>
		<!--Scan Codes-->

		<td style="text-align:center;" class="scanCode">
		<select name="scanCode">
		<option value = ""></option>
		<?php
		for ($i = 0; $i < $scanCodenumrows; $i++) {
			echo "<option value = '" . $scanCode[$i] . "'>" . $scanCode[$i] . "</option>";
		}
		?>
		</select></td>

		<!--Image Codes-->

		<td style="text-align:center;" class="imageCode">
		<select name="imageCode">
		<option value = ""></option>
		<?php
		for ($i = 0; $i < $imageCodenumrows; $i++) {
			echo "<option value = '" . $imageCode[$i] . "'>" . $imageCode[$i] . "</option>";
		}
		?>
		</select></td>

		<!--Place Holder-->
		<td style="text-align:center;" class="spacer" ><?php
		if (($subCat == "%") OR ($category == "%")) {echo '<select>
		<option value = "Select Category">All &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</option>';
		} else { echo $subCat;
		}
		?></td>

		<!--Fax Sub Codes-->
		<td style="text-align:center;"  class="faxCode">
		<select name="faxCode">
		<option value = ""></option>
		<?php
		for ($i = 0; $i < $faxCodenumrows; $i++) {
			echo "<option value = '" . $faxCode[$i] . "'>" . $faxCode[$i] . "</option>";
		}
		?>
		</select></td>

		<!--Jam Code-->
		<td style="text-align:center;" class = "jam">
		<select name=jamCode>
		<option value = ""></option>
		<?php
		for ($i = 0; $i < $jamCodenumrows; $i++) {
			echo "<option value = '" . $jamCode[$i] . "'>" . $jamCode[$i] . "</option>";
		}
		?>
		</select></td>

		<!--Service Code-->
		<td style="text-align:center;" class="serviceCode">
		<select name=serviceCode>
		<option value = ""></option>
		<?php
		for ($i = 0; $i < $serviceCodenumrows; $i++) {
			echo "<option value = '" . $serviceCode[$i] . "'>" . $serviceCode[$i] . "</option>";
		}
		?>
		</select></td>

		<!--Status Code-->
		<td style="text-align:center;" class = "statusCode">
		<select name=statusCode>
		<option value = ""></option>
		<?php
		for ($i = 0; $i < $statusCodenumrows; $i++) {
			echo "<option value = '" . $statusCode[$i] . "'>" . $statusCode[$i] . "</option>";
		}
		?>
		</select></td>

		<!--Boot Code-->
		<td style="text-align:center;" class = "bootCode">
		<select name=bootCode>
		<option value = ""></option>
		<?php
		for ($i = 0; $i < $bootCodenumrows; $i++) {
			echo "<option value = '" . $bootCode[$i] . "'>" . $bootCode[$i] . "</option>";
		}
		?>
		</select></td>

		<!--Finishing Code-->
		<td style="text-align:center;" class = "finCode">
		<select name=finCode>
		<option value = ""></option>
		<?php
		for ($i = 0; $i < $finCodenumrows; $i++) {
			echo "<option value = '" . $finCode[$i] . "'>" . $finCode[$i] . "</option>";
		}
		?>
		</select></td>

		<!--Auth Code-->
		<td style="text-align:center;" class = "authCode">
		<select name=authCode>
		<option value = ""></option>
		<?php
		for ($i = 0; $i < $authCodenumrows; $i++) {
			echo "<option value = '" . $authCode[$i] . "'>" . $authCode[$i] . "</option>";
		}
		?>
		</select></td>

		<!--Procedure Code-->
		<td style="text-align:center;" class = "procedureCode">
		<select name=procedureCode>
		<option value = ""></option>
		<?php
		for ($i = 0; $i < $procedureCodenumrows; $i++) {
			echo "<option value = '" . $procedureCode[$i] . "'>" . $procedureCode[$i] . "</option>";
		}
		?>
		</select></td>

		</div>
		<!------------------------------------------------------------------------------------------------------------------------------------------------
		<!--Problem-->
		<td>
		<div style="text-align:center;">
		<input name="problem" class="problem" placeholder = "Keyword" type="text" value = "<?php echo preg_replace("/[%]/", "", $problem); ?>" >
		</div></td>

		</tr>

		<!--Extras Row-->
		<?php
		if (isset($_SESSION['admin']) AND ($_SESSION['admin'] >= 1)) {
			echo "<td>
		<div class = " . $more . " ><b>Status: <br /></b>
		<select name='status' size='1' class='status'>
		<option value='custom'>Custom</option>
		<option value='%'>All</option>";
			for ($i = 0; $i < $statusnumrows; $i++) {
				if ($status == $StatusId[$i]) {
					echo "<option selected = 'selected' value ='" . $StatusId[$i] . "'>" . $Status[$i] . "</option>";
				} else {
					echo "<option value = '" . $StatusId[$i] . "'>" . $Status[$i] . "</option>";
				}
			}
			echo "</select></div></td>

		<!--Author-->

		<td>
		<div class = " . $more . "><b>Author:<br /></b>
		<select name='enteredBy' class='author'>
		<option value='%'>Anyone</option>";
			for ($i = 0; $i < $staffnumrows; $i++) {
				if ($enteredBy == $staffID[$i]) {
					echo "<option selected = 'selected' value ='" . $staffID[$i] . "'>" . $staff[$i] . "</option>";
				} else {
					echo "<option value = '" . $staffID[$i] . "'>" . $staff[$i] . "</option>";
					echo $i;
				}
			}
			$tempId = $id;
			if ($id == "0") {$tempId = NULL;
			}
			echo "</select></div></td>
		<td>
		<div class = " . $more . " >
		<strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Ticket:<br /></strong>
		<!--Ticket-->

		<img src='images/get_ticketinfo.png' width='17'>&nbsp;<input id = 'ticket' name='ticket' type='text' class='textBox' placeholder = 'TAC Ticket' value=" . preg_replace("/[%]/", "", $ticket) . ">
		</div></td>

		<!--Solution-->
		<td>
		<div class=" . $more . ">
		<strong>Suggestion:<br /></strong>
		<input name='solution'  type='text' class='textBox' placeholder = 'Search suggestions' value = " . preg_replace("/[%]/", "", $solution) . ">
		</div></td>

		<!--ID Number-->
		<td>
		<div class=" . $more . ">
		<strong>ID Number:<br /></strong>
		<input name='idNumber'  type='text' class='textBox' placeholder = 'ID Number' value = " . preg_replace("/[%]/", "", $tempId) . ">
		</div></td>

		</tr>";
		} else {$status = "custom";
		}//{$status="2";}//Only show published to the guest user
		?>
		</table><!--/Search Table-->
		</form>
		<!--/MainWindow-->

		<hr />

		<?php

		//Are we logged in?

		if (!isset($_SESSION['user'])) {
		echo "<h2>Please Login</h2>";
		echo "
		<form action = login.php method = post>
		<b>Name: </b>
		<input type = text name = username>
		<b>Password: </b>
		<input type = password name = password>
		<input type = submit name = submit value = Submit>
		</form>
		<br />
		<b>
		<div style = 'color:red'>
		NOTE: Javascript and Cookies are required to use this site
		</div>
		<div id=forgotPassword><a href='#'>Forgot Password</a></div>
		</b>";
		exit();
		}

		//if ($status != "%") {
		//$newquery = "SELECT * FROM status WHERE statusId = $status";
		//$newresult = mysqli_query($connection, $newquery);
		//$newrow = $newresult -> fetch_assoc();
		//$newstatus = $newrow['status'];
		//} else {$newstatus = "ALL";//TODO was "ALL"
		//}

		//Offer a blank page if form not submtted

		if ($submitted == "false") {
		$status = "new";
		}
		//If id is set then display that row

		if (isset($id)) {
		if ($id == 0) {echo "<h3 align=center>Welcome " . $_SESSION['name'] . "</h3>
		<b>Last Login " . $_COOKIE['lastLog'] . "</b>";
		}
		$query = "SELECT * FROM sharp WHERE id ='$id'";
		//GET TODO for editor
		if ($_SESSION['admin']>1){
		$todoQuery = "SELECT * from sharp WHERE statusId = '1'";
		$result = mysqli_query($connection, $todoQuery);
		$totalRows = mysqli_num_rows($result);
		if ($totalRows>0) {
		echo "<br /><br /><table align='center'><tr><td><div style='color:red; font-size:15px; font-weight:bold;'>
		You have ". $totalRows. " new SUBMITTED entries to process</div></td><td>
		<a href='index.php?submit=Upsate&status=1'><img src='images/view-new.jpg' width='125'></a>
		<a href='viewEdits.php'><img src='images/view-all.jpg' width='125'></a>
		</tr>
		</table></div>";}
		}

		}else if ($idNumber!="") {
		$id=$idNumber;
		$query = "SELECT * FROM sharp WHERE id ='$id'";

		}else{

		// Set statusId for query

		if ($status == "%") {
		$statusForQuery = "statusId LIKE '%'";
		}elseif ($status=="new"){
		$statusForQuery="statusId = NULL";
		}elseif ($status == "custom") {
		$statusForQuery = "(statusId = 2 OR statusId = 6 OR statusId > 8)";
		$status = "5 OR statsus = 6";
		}else{
		$statusForQuery = "statusId = ".$status;
		}

		// Perform SQL query

		$query = "SELECT * FROM sharp
		WHERE ticket LIKE '$ticket'
		AND $statusForQuery
		AND staffId LIKE '$enteredBy'
		AND modelId LIKE '%$modelId%'
		AND solution LIKE '$solution'
		AND category LIKE '$category'
		AND subCat LIKE '$subCat'
		AND problem LIKE '$problem'
		ORDER BY `success` DESC
		LIMIT 3000";
		//CHANGE LIMIT BACK TO 300----------------------------------------------------------
		//Put success on top
		}
		$result = mysqli_query($connection, $query);
		$totalRows = mysqli_num_rows($result);

		//Debug
		//print $query . "<br>";
		//echo $status;
		//Debug

		if ($id == NULL AND $totalRows <= 3000) {echo "<div id='status'>" . $totalRows . "  Records Found </div>";}
		if ($id == NULL AND $totalRows > 3000) {echo "<div id='status'> Over 300 records found - The top 300 records are shown.  &nbsp; Please limit your search by also selecting a model or category.</div>";}

		if (!$result) {
		die("Error_DIE: " . mysql_error());
		}
		// removed "AND ($id != 0)" from line below 1-13-2016
		if (($totalRows == 0) AND ($submitted == "true") AND ($submit=="Update Display")) {echo "
		<table align = center>
		<tr>";
		if ($_SESSION['admin']>=1) //TODO
		{

		echo "<td style = 'color:black; text-align:right;' colspan = 2>
		<b>Solution was not found in databse &nbsp;</b><a href='#' id='thumbsDown'><img src='images/thumbsdown.png' width = '25'></a>";
		}else{
		echo "<td colspan='2'></td>";
		}
		echo "</td>
		</tr>
		</table>
		";
		}

		//Main Table Head

		elseif ($totalRows > 0) {
		echo "

		";
		//Main Table
		echo "<table class=mainTableHeader><tr>";
		if ($_SESSION['admin']>0){
		echo "<td style = text-align:right;'>Solution was not found in database &nbsp;<a href='#' id='thumbsDown'><img src='images/thumbsdown.png' width = '25'></a></td>
		</td></tr></table>";
		}

		echo "<table class='mainTableHeader'></tr>
		<tr>
		<td class='row-ID'>ID</td>
		<td class='row-status'>Status</td>
		<td class='row-Date'>Date</td>
		<td class='row-Category'>Category</td>
		<td class='row-Sub-category'>Sub Cat</td>
		<td class='row-Model'>Model</td>
		<td class='row-Symptom'>Symptom</td>
		<td class='row-Suggestion'>Suggestion</td>
		<td class='row-Success'>Success&nbsp;&nbsp;</td>
		</tr>
		</table>";
		}
		//echo $submit;
		echo "
		<div id='mainWindow'>
		";
		//MainWindow Div
		echo "
		<table id='mainTable'>";

		//Loop and display query results

		while ($row = $result -> fetch_assoc()) {

		//Get status of row

		if (($status == "new") | (isset($id))) {
		} //elseif ($status != "%") {
		//$newquery = "SELECT * FROM status WHERE status = $status";

		//$newresult = mysqli_query($connection, $newquery);
		//$newrow = $newresult -> fetch_assoc();
		//$newstatus = $newrow['status'];
		//}
		else { $newstatus = "";
		}

		$staffnumber = $row['staffId'] -1;
		if ($staffnumber <0) $staffnumber=0;//TODO Why do I need to do this?
		//$newstaff = $staff[$staffnumber];

		// Models

		$model="";
		$modelArray = explode(',', $row['modelId']);
		$numModels = count($modelArray);

		$x=0;
		while ($x<$numModels){
		$modelQuery="SELECT model FROM model WHERE modelId = '$modelArray[$x]'";
		$modelResult=mysqli_query($connection,$modelQuery);
		$modelNumberArray = mysqli_fetch_assoc($modelResult);

		if (is_array($modelNumberArray)){
		foreach ($modelNumberArray as &$value)
		{$model .= " " .$value;}
		}

		$x++;
		};

		if (strlen($model) > 100) {//Lots of models hide unless needed
		$model="<div class = 'showModels'>
		Multiple Models <a href='#'>click to view</a>
		<div class = 'hideModels'>
		" . $model . "
		</div>
		</div>";
		} else {
		$model = $model;
		}
		//If row is a How To then highlight it green
		if (($row['howTo'] === "yes")||($row['howTo'] === "Yes")) {echo "
		<tr class='howTo'>";
		} elseif ($row['statusId'] == "6") {echo "
		<tr class='internal'>";

		}else{
		echo "
		<tr>
		";
		}

		//Get Status from statusId

		$statusQuery = "SELECT * FROM status WHERE statusId = ".$row['statusId'];
		$statusResult = mysqli_query($connection, $statusQuery);
		$statusRow = $statusResult -> fetch_assoc();
		$statusName = $statusRow['status'];

		if (isset($_SESSION['admin']) && ($_SESSION['admin'] >= 2)) {//provide edit link to admins or authors
		echo "<td style='width:3%' align='center'><a href='editForm.php?id=" . $row['id'] . "'>".$row['id']."</a>";
		} else {
		echo "<td style='width:3%'>".$row['id'];
		}

		//Add Ticket link
		$ticket="";
		if ($row['ticket']!=""){
		$ticket = $row['ticket'];

		?>
		<a href="/repair/ticketInfo.php?ticket=<?php echo $ticket?>">T</a>

		<?php
		}
		echo"</td>";
		//Hide part of solution if it is over x charachters
		$solution = nl2br($row['solution']);
		//print $solution;
		if (strlen($solution) > 500) {//Lots of words hide unless needed
		$solution="<div class = 'showModels'>
		<a href='#'>click to view</a>
		<div class = 'hideModels'>
		" . $solution . "
		</div>
		</div>";
		} else {
		$solution = $solution;
		}
		echo "<td style='width:4%'>" . $statusName . "</td><td style='width:7%'>" . $row['date'] . "</td><td style='width:8%'>" . $row['category'] .
		"</td><td style='width:8%'>" . $row['subCat'] . "</td><td style='width:20%'>" . $model . "</td><td style='width:15%'>" . $row['problem'] .
		"</td><td style='width:30%'>" . $solution . "</td><td style='width:5%'>" . $row['success'] .
		"<a href='#'class='successLink' rel='" . $row['id'] . "'>";
		if ($_SESSION['admin']>0){
		echo "<img src='images/thumbsup.png' width='20'/></a>";
		}else{
		echo "</a><img src='images/thumbsup.png' width='20'/>";
		}
		// CHECK for confirmed repairs
		//Query ID to see if any confirmed repairs exsist
		$id=$row['id'];
		$confirmedRepairQuery = "SELECT * FROM confirmedRepair WHERE repairId = '$id'";
		$confirmedRepairResult = mysqli_query($connection, $confirmedRepairQuery);
		$confirmedRepairTotalRows = mysqli_num_rows($confirmedRepairResult);  //no of repairs
		if ($confirmedRepairTotalRows>0){
		$href="confirmedRepair.php?id=".$id;
		?><br /><?php echo $confirmedRepairTotalRows; ?>&nbsp;<a href="#" onClick="window.open('<?php echo $href ?>','pagename','resizable=yes,height=260,width=450,right=200,top=500'); return false;"><img src='images/Wrench-Icon.svg' width='15' height='15'></a>

		<?php
		}
		echo"</td></tr>";
		}
		echo "
		</table>";
		echo "</form>";
		// Free resultset
		mysqli_free_result($result);
		// Closing connection
		mysqli_close($connection);
		?>
	</body>
</html>
