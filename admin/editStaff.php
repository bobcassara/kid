<?php session_start(); ?>
<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<title>TAC Ticket Queue</title>
		<link rel="stylesheet" type="text/css" href="../css/style.css">
		<script type="text/javascript" src="../js/datepickr.js"></script>
		<script src="../js/jquery-2.1.3.min.js"></script>
		<script src="../js/functions.js"></script>

	</head>
	<?php
    //Error Reporting
    //error_reporting(0);

    //Lets Connect to the db

    include ("../mysql_connect.php");

    if (($_SESSION['admin'] < 2)) {
        echo "<h2>Please Login as an administrator</h2>";
        echo "<form action = ../login.php method = post>
	<b>Name: </b><input type = text name = username>
	<b>Password: </b><input type = password name = password>
	<input type = submit name = submit value = Submit>
	</form>";
        exit();
    }
    if (isset($_SESSION['user'])) {
        $username = $_SESSION['user'];
        $query = "SELECT * FROM staff WHERE username = '$username'";
        $result = mysqli_query($connection, $query);
        $row = $result -> fetch_assoc();
        $name = $row['name'];
    }
    //init the variables
    $edit = "";
?>
<body>

		<?php

        //Include the header

        require ('adminHeader.html');
    ?>
		<h2>Edit Staff</h2>
		<?php

        //Get the staff from the staff database
        $query = "SELECT * FROM staff where display = 1";
        $result = mysqli_query($connection, $query);
		?>

		<form action="editStaff.php" method="get">
			<select name='staffId'>

				<?php

                while ($row = $result -> fetch_assoc()) {
                    echo "<option value=" . $row['staffId'] . ">" . $row['name'] . " </option>";
                }

                echo "</select>";
				?>

				<input type="hidden" name="edit" value="edit">
				<input type="submit" name="submitted" value="Edit"/>
		</form>
		<?php
            if ($edit == 'edit') {print "HERE";
            }
            //Get variables from url

            if (isset($_REQUEST['staffId'])) {//Staff member
                $staffId = $_REQUEST['staffId'];
                $query = "SELECT * FROM staff WHERE staffId ='$staffId'";
                $result = mysqli_query($connection, $query);
                $totalRows = mysqli_num_rows($result);
                echo "<table class='staffTable'>";
                while ($row = $result -> fetch_assoc()) {

                    echo "<tr><td>" . $row['name'] . "</td><td>";
                    echo $row['username'] . "</td><td>";
                    echo $row['password'] . "</td><td>";
                    echo $row['admin'] . "</td><td>";
                    echo $row['lastLog'] . "</td></tr>";
                }

            }
        ?>
	</body>

</html>
