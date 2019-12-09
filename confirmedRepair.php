<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title>KID Knowledge Database</title>
        <!--<link href="css/style.css" rel="stylesheet" type="text/css" />-->
        <script src="js/jquery-2.1.3.min.js"></script>
        <script src="js/jquery.cookie.js"></script>
        <script src="js/functions.js"></script>
        <!--<link href="css/popup.css" rel="stylesheet" type="text/css";-->
    <link rel="stylesheet" href="js/fancybox/source/jquery.fancybox.css?v=2.1.5" type="text/css" media="screen" />
<script type="text/javascript" src="js/fancybox/source/jquery.fancybox.pack.js?v=2.1.5"></script>
    
    
    
    
    
    </head>
	
    <body style=width:400px;>
<script>
$(document).ready(function(){
	
	$(".fancybox").click(function(e) {
		e.preventDefault();
		
		var id = $(location).attr('href');
		id = id.substr(id.indexOf('id=')+3);
		var url1="confirmedRepairDetails.php?id="+id;
		$(".fancybox").fancybox({
		width: 400,
        height: 900,
        autoSize: true,
        href: url1,
        type: 'ajax'
		
		});
		 
		
		//console.log('click');
		//console.log(id);
	});



});
	
</script>	    	
<?php
//Lets Connect to the db

        include ("mysql_connect.php");


if (isset($_REQUEST['id'])) {
            $id = $_REQUEST['id'];
}

//Table
echo "<div style=position:fixed; left:130px; top:130px;>";
echo "<br /><br /><table border=1 cellpadding=5><tr bgcolor=yellow><th>Hits</th><th>Confirmed Repair</th></tr>";

//Get model ID

$query = "SELECT confirmedRepairDescription, count(confirmedRepairDescription) AS tagCount FROM confirmedRepair WHERE repairId='$id' GROUP BY confirmedRepairDescription ORDER BY 'tagCount' ";
$result = mysqli_query($connection, $query);
$totalRows= mysqli_num_rows($result);
while($row = mysqli_fetch_array($result)){
    echo "<tr><td>".$row['tagCount']. 
    "</td><td>".$row['confirmedRepairDescription'].
	"</td></tr>";
}


	echo"</table>";	
	echo "<br /><div align=left><a href=# class='fancybox'><div align=center> <img src='./images/get_details.jpg'></div></a></div></div>";	
?>	


</body>
</html>

	