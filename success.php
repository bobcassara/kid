<?php session_start(); ?>
<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=windows-1252" />
		<title>Knowledge Database</title>
		<link href="style.css" rel="stylesheet" type="text/css" />
		<script src="jquery-2.1.3.min.js"></script>

	</head>
	<body>

		<?php
        //Connect to the database

        include ("mysql_connect.php");

        //Get the id number and ticket number

        $id = mysqli_real_escape_string($connection, $_GET['id']);
        $ticket = mysqli_real_escape_string($connection, $_GET['ticket']);

        if (isset($_REQUEST['ticket'])) {
            $ticket = $_REQUEST['ticket'];

            //Lets get the hit count

            $query = "SELECT * FROM success where repairID = '$id'";

            $result = mysqli_query($connection, $query);
            $hitsnumrows = mysqli_num_rows($result);

            if ($hitsnumrows > 0) {
                $hitsnumrows = $hitsnumrows + 1;
            } else {
                $hitsnumrows = 1;
            }

            //Get author from cookie
            if (isset($_SESSION['name'])) {
                $author = $_SESSION['name'];
            }
            
            //The Query
            
            //Update Success table
            $query = "INSERT INTO success VALUES('$ticket', '$id', '$hitsnumrows', '$author', NOW(), NULL)";
            mysqli_query($connection, $query);
            //print $query;

            //Update Sharp Table
            $query = "UPDATE sharp
		SET success = '$hitsnumrows'
		WHERE id = '$id'";
            //print $query;
            mysqli_query($connection, $query);

            header('location:index.php?id=' . $id . '&submit=submitted');

        }
		?>

	</body>
</html>

