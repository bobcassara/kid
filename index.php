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

		<script src="js/functions.js"></script>

	</head>

	<body>
		<!--Javascript enabled??-->

		<noscript>

			<meta http-equiv="refresh" content="0; url=nojavascript.html" />
		</noscript>

		<?php

        //init variables

        $scanC = "";
        $printC = "";
        $jamC = "";
        $serviceC = "";
        $faxC = "";
        $imageC = "";
        $id = NULL;
        $name = NULL;
        $more = "hidden";

        //Set cookie for displaying extras bar

        if (!isset($_COOKIE['more'])) {
            setcookie(more, hidden);
        }

        $more = $_COOKIE['more'];

        //Error Reporting
        //error_reporting(0);
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
        //Lets Connect to the db

        include ("mysql_connect.php");

        //Lets get the form variables

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

        if (isset($_REQUEST['model'])) {//Model
            $model = "%" . mysqli_real_escape_string($connection, $_REQUEST['model']) . "%";
        } else {$model = "%";
        }

        if (isset($_REQUEST['modelsolutions'])) {
            $modelsolutions = "%" . mysqli_real_escape_string($connection, $_REQUEST['modelsolutions']) . "%";
        } else {
            $modelsolutions = "%";
        }

        $model = $model . $modelsolutions;
        //combine for model search

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
            $status = "%";
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

        if (isset($_REQUEST['id'])) {
            $id = mysqli_real_escape_string($connection, $_REQUEST['id']);
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

        $subCat = $printC . $scanC . $jamC . $serviceC . $imageC . $faxC;
        if ($subCat == "") {$subCat = "%";
        }

        //Init Login Credentials
        $user = "";
        $password = "";
		?>
		<!--Header Area-->
		<header>
			<table style="width:100%;">
				<tr>
					<td><img style="text-align:left;" src="images/sharp-transparent.png" alt="logo" width="250"/></td>
					<td><div id="loginname"></div>
					<div style="text-align:center;">
						<?php
                        if (isset($_SESSION['name'])) {echo $_SESSION['name'] . " " . "<a href = 'logout.php'>Logout</a>";
                        }
						?>
					</div></td>
					<td><h1 style="text-align:right;">Knowledge Information Database (KID)</h1></td>
				</tr>
			</table>

			<hr>
			<form action="index.php" method="get">
		</header>
		<!--Table Search Area-->

		<table style ="text-align:center;" class="searchtable">
			<tr>
				<td colspan = 7>&nbsp;</td>
			</tr>
			<tr>

				<td>
				<div style = "text-align:center; font-weight:bold;">
					Model
				</div></td>
				<td>
				<div style = "text-align:center; font-weight:bold;">
					OSA Applications
				</div></td>
				<td>
				<div style = "text-align:center; font-weight:bold;">
					Category
				</div></td>

				<!--Sub Code Labels-->
				<td class="spacer">
				<div style = "text-align:center; font-weight:bold;">
					Sub Category
				</div></td>
				<td class="printCode">
				<div style = "text-align:center; font-weight:bold;">
					Print Sub Category:
				</div></td><!--Print Sub Code-->
				<td class="scanCode">
				<div style = "text-align:center; font-weight:bold;">
					Scan Sub Category:
				</div></td><!--Scan Sub Code-->
				<td class="imageCode">
				<div style = "text-align:center; font-weight:bold;">
					Image Sub Category:
				</div></td><!--Image Quality Sub Code-->
				<td class="faxCode">
				<div style = "text-align:center; font-weight:bold;">
					Fax Sub Category:
				</div></td><!--Fax Sub Code-->
				<td class="serviceCode">
				<div style = "text-align:center; font-weight:bold;">
					Service Code:
				</div></td><!--Service Sub Code-->
				<td class="jam">
				<div style = "text-align:center; font-weight:bold;">
					Jam Code:
				</div></td><!--Jam Sub Code-->
				<td>
				<div style = "text-align:center; font-weight:bold;">
					Symptom
				</div></td>
				<td rowspan="2">
				<div style="text-align:center;">
					<button id='reset' class='button'>
						Reset Form
					</button>
				</div></td>
				<!--Update Display Button-->
				<td rowspan="2">
				<div style="text-align:center;">
					<input id = "updateButton" class="button" name="submit" type="submit" value="Update Display">
				</div></td>
			</tr>
			<tr>

				<!--Model-->

				<td>
				<div style="text-align:center;">
					<input type="text" class = "modelTextBox" placeholder = " example M264" name="model" value = "<?php echo preg_replace("/[%]/", "", $model); ?>">
				</div></td>

				<!--Model Solutions-->

				<td style="text-align:center;">
				<select name="modelsolutions" class = "solutions">
					<option value="%">N/A</option>
					<?php
                    for ($i = 0; $i < $modelsolutionsnumrows; $i++) {
                        echo "<option value = '" . $ModelSolutions[$i] . "'>" . $ModelSolutions[$i] . "</option>";
                        echo $i;
                    }
					?>
				</select></td>
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
				<td style="text-align:center;" class="spacer"><?php
                if (($subCat == "%") OR ($category == "%")) {echo '<img src=images/arrow.png width=25>Select Category First';
                } else { echo $subCat;
                }
				?></td>
				<!--Fax Sub Codes-->
				<td class="faxCode">
				<select name="faxCode">
					<option value = ""></option>
					<?php
                    for ($i = 0; $i < $faxCodenumrows; $i++) {
                        echo "<option value = '" . $faxCode[$i] . "'>" . $faxCode[$i] . "</option>";
                    }
					?>
				</select></td>

				<!--Jam Code-->
				<td class = "jam">
				<select name=jamCode>
					<option value = ""></option>
					<?php
                    for ($i = 0; $i < $jamCodenumrows; $i++) {
                        echo "<option value = '" . $jamCode[$i] . "'>" . $jamCode[$i] . "</option>";
                    }
					?>
				</select></td>
				<!--Service Code-->
				<td class="serviceCode">
				<select name=serviceCode>
					<option value = ""></option>
					<?php
                    for ($i = 0; $i < $serviceCodenumrows; $i++) {
                        echo "<option value = '" . $serviceCode[$i] . "'>" . $serviceCode[$i] . "</option>";
                    }
					?>
				</select></td>

				<!--Problem-->
				<td>
				<div style="text-align:center;">
					<input name="problem" class="problem" placeholder = "Keyword" type="text" value = "<?php echo preg_replace("/[%]/", "", $problem); ?>" >
				</div></td>

			</tr>
			
			<!--Extras Row-->
			<?php
            if (isset($_SESSION['admin']) AND ($_SESSION['admin'] >= 1)) {
                echo "<tr class='darkGray'>
				<td>
				<input type='button' class= 'button' value='More / Less' name='more' id='more'>
				</td>
				<td>
				    <div style='text-align:center'>
			        <center>
                    <button class='button' id='addNew'>
                        Add New Content
                    </button>
                    </center></td>
                    </div></td>";

            }
            if (isset($_SESSION['admin']) AND ($_SESSION['admin'] >= 2)) {
                echo "<td>
				<center>
					<button class='button' id='admin'>
						Admin
					</button>
				</center></td>";
            } else {
                echo "<td></td>";
            }
            if (isset($_SESSION['admin']) AND ($_SESSION['admin'] >= 1)) {
                echo "<td>
				    <div class = " . $more . " ><b>Status: <br /></b>
				<select name='status' size='1' class='status'>
					<option value='%'>ALL</option>";

                for ($z = 0; $z < $statusnumrows; $z++) {
                    if ($status == $StatusId[$z]) {
                        echo "<option selected = 'selected' value ='" . $StatusId[$z] . "'>" . $Status[$z] . "</option>";
                    } else {
                        echo "<option value = '" . $StatusId[$z] . "'>" . $Status[$z] . "</option>";
                        echo $z;
                    }

                }

                echo "</select></div></td>

				<!--Author-->

				<td>
				    <div class = " . $more . "><b>Author:<br /></b>
				<select name='enteredBy'>
					<option value='%'>ANYONE</option>";

                for ($i = 0; $i < $staffnumrows; $i++) {
                    echo "<option value = '" . $staffID[$i] . "'>" . $staff[$i] . "</option>";
                    echo $i;
                }

                echo "</select></div></td>
				<td>
				<div class = " . $more . " >
					<strong>Ticket:<br /></strong>
					<!--Ticket-->

					<input type='text' class=" . $more . " name='ticket' placeholder = 'TAC Ticket' value=" . preg_replace("/[%]/", "", $ticket) . ">
				</div></td>

				<!--Solution-->
				<td>
				<div class=" . $more . ">
					<strong>Suggestion:<br /></strong>
					<input name='solution'  type='text' placeholder = 'Search suggestions' value = " . preg_replace("/[%]/", "", $solution) . ">
				</div></td>

			</tr>";
            }
			 ?>
		</table><!--/Search Table-->

		<!--/MainWindow-->

		<hr />
		</form>

		<br />
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
		</div></b>";
            exit();
        }

        if ($status != "%") {
            $newquery = "SELECT * FROM status WHERE statusId = $status";
            $newresult = mysqli_query($connection, $newquery);
            $newrow = $newresult -> fetch_assoc();
            $newstatus = $newrow['status'];
        } else {$newstatus = "All";
        }

        //Offer blank page if not submtted

        if ($submitted == "false") {
            $status = "new";
        }
        //If id is set then display that row

        if (isset($id)) {
            if ($id == 0) {echo "<h3 align=center>Welcome " . $_SESSION['name'] . "</h3>
            <b>Last Login " . $_COOKIE['lastLog'] . "</b>";
            }
            $query = "SELECT * FROM sharp WHERE id ='$id'";
        } else {

            // Perform SQL query

            $query = "SELECT * FROM sharp
		WHERE ticket LIKE '$ticket'
		AND statusId LIKE '$status'
		AND staffId LIKE '$enteredBy'
		AND model LIKE '$model'
		AND solution LIKE '$solution'
		AND category LIKE '$category'
		AND subCat LIKE '$subCat'
		AND problem LIKE '$problem'
		ORDER BY `success` DESC
        LIMIT 3000";
            //Put success on top
        }
        $result = mysqli_query($connection, $query);
        $totalRows = mysqli_num_rows($result);

        //echo $query;

        if ($id == NULL) {echo "<b>" . $totalRows . "  Records Found </b>";
        }
        if (!$result) {
            die("Error_DIE: " . mysql_error());
        }
        if (($totalRows == 0) AND ($submitted == "true") AND ($id != 0)) {echo "
		<table align = center>
			<tr>
				<td style = 'color:black; text-align:right;' colspan = 2><b>Solution was not found in databse &nbsp;</b><a href='#' id='thumbsDown'><img src='images/thumbsdown.png' width = '25'></a></td>
			</tr>
		</table>
		";
        }

        //Main Table Head

        elseif ($totalRows > 0) {
            echo "
		<table id='mainTableHeader'>
			";
            //Main Table
            echo "
			<colgroup>
				<col style='width:2%'>
				<col style='width:4%'>
				<col style='width:5%'>
				<col style='width:7%'>
				<col style='width:8%'>
				<col style='width:8%'>
				<col style='width:20%'>
				<col style='width:15%'>
				<col >
				<col style='width:5%'>
			</colgroup>
			<tr>
				<td style = 'color:black; text-align:right;' colspan = 10>Solution was not found in database &nbsp;<a href='#' id='thumbsDown'><img src='images/thumbsdown.png' width = '25'></a></td>
			</tr>
			<tr>
				<td></td>
				<td>Ticket</div></td>
				<td>Author</div></td>
				<td>Date</div></td>
				<td>Category</div></td>
				<td>Sub Cat</td>
				<td>Model</td>
				<td>Symptom</td>
				<td>Suggestion</td>
				<td>Success&nbsp;&nbsp;</td>
			</tr>
		</table>";
        }
        echo "
		<div id='mainWindow'>
			";
        //MainWindow Div
        echo "
			<table id='mainTable'>
				<colgroup>
					<col style='width:2%'>
					<col style='width:4%'>
					<col style='width:5%'>
					<col style='width:7%'>
					<col style='width:8%'>
					<col style='width:8%'>
					<col style='width:20%'>
					<col style='width:15%'>
					<col >
					<col style='width:5%'>
				</colgroup>
				";

        //Loop and display query results

        while ($row = $result -> fetch_assoc()) {

            if (($status == "new") | (isset($id))) {
            } elseif ($status != "%") {
                $newquery = "SELECT * FROM status WHERE status = $status";
                $newresult = mysqli_query($connection, $newquery);
                $newrow = $newresult -> fetch_assoc();
                $newstatus = $newrow['status'];
            } else { $newstatus = "";
            }
            $staffnumber = $row['staffId'];
            $newstaff = $staff[$staffnumber - 1];

            if (strlen($row['model']) > 100) {//Lots of models hide unless needed
                $model1 = "
				<div class = 'showModels'>
					Multiple Models <a href='#'>click to view</a>
					<div class = 'hideModels'>
						" . $row['model'] . "
					</div>
				</div>";
            } else {
                $model1 = $row['model'];
            }
            if ($row['howTo'] === "yes") {echo "
				<tr class='howTo'>
					";
            } else {
                echo "
				<tr>
					";
            }
            if (isset($_SESSION['admin'])) {//provide edit link to admins
                echo "<td style='width:30px'><a href='editForm.php?id=" . $row['id'] . "'><img src='images/pencil.png' width='20'></a></td>";
            } else {
                echo "<td width = 25></td>";
            }

            echo "<td width=40>" . $row['ticket'] . "</td><td>" . $newstaff . "</td><td>" . $row['date'] . "</td><td>" . $row['category'] . "</td><td>" . $row['subCat'] . "</td><td>" . $model1 . "</td><td>" . $row['problem'] . "</td><td>" . $row['solution'] . "</td><td>" . $row['success'] . "&nbsp;<a href='#'class='successLink' rel='" . $row['id'] . "'><img src='images/thumbsup.png' width='25'/></a></td>
				</tr>";

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
