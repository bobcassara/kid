<?php session_start(); ?>
<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<title>Knowledge Database</title>
		<link href="css/style.css" rel="stylesheet" type="text/css" />
		<script src="js/jquery-2.1.3.min.js"></script>
		<script src="js/functions.js"></script>
	</head>

	<body>

		<?php
        //Error adminReporting
        error_reporting(0);

        //Lets Connect to the db

        include ("mysql_connect.php");

        //Are we logged in?

        if (!isset($_SESSION['user'])) {
            print "<h2>Please Login</h2>";
            print "
		<form action = login.php method = post>
			<b>Name: </b>
			<input type = text name = username>
			<b>Password: </b>
			<input type = password name = password>
			<input type = submit name = submit value = Submit>
		</form>";
            exit();
        }
        $username = $_SESSION['name'];
        //Init the variables

        $category = "";
        $jticket = "";
        $model = "";
        $subCat = "";
        $problem = "";
        $solution = "";
        $notes = "";
        //Lets get the form variables

        if (isset($_REQUEST['category'])) {//category
            $category = mysqli_real_escape_string($connection, $_REQUEST['category']);
        }
        if (isset($_REQUEST['jticket'])) {//Ticket
            $jticket = mysqli_real_escape_string($connection, $_REQUEST['jticket']);
		}
		//if (isset($_REQUEST['ticket'])) {//Ticket
            //$jticket = mysqli_real_escape_string($connection, $_REQUEST['ticket']);
        //}
        if (isset($_REQUEST['model'])) {//model
            $model = mysqli_real_escape_string($connection, $_REQUEST['model']);
        }
        if (isset($_REQUEST['notes'])) {//call notes
            $notes = mysqli_real_escape_string($connection, $_REQUEST['notes']);
        }
        //SUB CATS//

        if (isset($_REQUEST['scanCode'])) {//scan sub code
            $scanCode = mysqli_real_escape_string($connection, $_REQUEST['scanCode']);
        }

        if (isset($_REQUEST['printCode'])) {//print sub code
            $printCode = mysqli_real_escape_string($connection, $_REQUEST['printCode']);
        }

        if (isset($_REQUEST['faxCode'])) {//fax sub code
            $faxCode = mysqli_real_escape_string($connection, $_REQUEST['faxCode']);
        }
        if (isset($_REQUEST['jamCode'])) {//jam sub code
            $jamCode = mysqli_real_escape_string($connection, $_REQUEST['jamCode']);

            if (isset($_REQUEST['imageCode'])) {//image Quality sub code
                $imageCode = mysqli_real_escape_string($connection, $_REQUEST['imageCode']);
            }

            if (isset($_REQUEST['serviceCode'])) {//image Quality sub code
                $serviceCode = mysqli_real_escape_string($connection, $_REQUEST['serviceCode']);
            }

        }
        $subCat = $scanCode . $printCode . $faxCode . $jamCode . $imageCode . $serviceCode;
        //combine

        if (isset($_REQUEST['problem'])) {//problem
            $problem = mysqli_real_escape_string($connection, $_REQUEST['problem']);
        }
        if (isset($_REQUEST['solution'])) {//solution
            $solution = mysqli_real_escape_string($connection, $_REQUEST['solution']);
        }
		if ($notes==""){$notes ="--No notes were entered--";}
		if ($category=="%"){$category="";}
        //The Query

        $query = "INSERT INTO nosuccess VALUES (NULL, '$jticket','$notes','$model','$category','$subCat', '$problem', '$solution', '$username' , NOW())";
		
        echo $query;
        mysqli_query($connection, $query) or die(mysqli_error($connection));
		?>
		<script type = "text/javascript">
            $(document).ready(function() {
                var r = confirm('Successfully Saved');
                if (r == true) {
                    window.location.href = 'index.php';
                    return false;
                } else {
                    window.location.href = 'index.php';
                    return false;
                }
            })
		</script>
		
	</body>
</html>
