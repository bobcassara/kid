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
        
        <!--Javascript not enabled?? Then redirect-->
        <noscript>
            <meta http-equiv="refresh" content="0; url=nojavascript.html" />
        </noscript> 
       
        

<?php
//Connect to the db

		include ("mysql_connect.php");
$query="";

//Set cookie for displaying extras bar

		if (!isset($_COOKIE['more'])) {
			setcookie('more', 'hidden');
		} else {
			$more = $_COOKIE['more'];
		}

		//Check hidden row value
		if (isset($_COOKIE['more'])) {
			if ($_COOKIE['more'] == "hidden") {
				$value = "Show More";
			} else {
				$value = "Show Less";
			}
		}

		//Error Reporting
		//error_reporting(0);
		ini_set('display_errors', 1);
		ini_set('display_startup_errors', 1);
		error_reporting(E_ALL);
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
   <li><?php
if (isset($_SESSION['admin']) AND ($_SESSION['admin'] >= 1)) {
	echo "<a href=# name='more' id='more'>" . $value . "</a>";
}
 ?></li>
 <li><a href="../index.html">Main Menu</a></li>
   <div id="kidlogo">Knowledge Information Database (KID)</div>
  
  </ul>


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

if (isset($_REQUEST['query'])){
	$query=$_REQUEST['query'];
}
$newquery=str_replace(' ', '* ', $query); 


?>
<br /><br /><br />
<form action=bobble.php>
	<div align=center>
		<img src='images/bobble.png'><br><br />
	<input type=text name = "query" style = "width:600px; height:50px; border:1px solid blue; font-size:18px;" value= "<?php echo $query; ?>">
	<input type = submit style="visibility:hidden">
	<br /><br />
</form> 
<?php
if ($newquery){
$fullTextQuery ="SELECT problem, solution, success, modelId, id, 
MATCH(problem, solution, model) 
AGAINST('$newquery' IN BOOLEAN MODE) AS relevance 
FROM KID.sharp 
ORDER BY relevance DESC, success DESC LIMIT 50";

//print $fullTextQuery;
echo "<table border=0 style='font-size:14px;'>";
//echo "<tr><td colspan=5>Results for ".$newquery."</td></tr>";
$result = mysqli_query($connection, $fullTextQuery);
        $totalRows = mysqli_num_rows($result);
 while ($row = $result -> fetch_assoc()) {
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
	if ($row['relevance']>0) {
		$url="index.php?id=".$row['id']; 	
		//echo "<tr><td>".$model."</td><td>".$row['problem']."</td><td>".$row['solution']."</td><td>".$row['success']."</td><td>".$row['relevance']."</td></tr>";
 		echo "<tr><td>".$row['relevance']."</td><td>".$row['success']."</td><td><a href=$url>".nl2br($row['problem'])."</a></td></tr>";
 	}
 }
echo "</table>";
}

?></div>