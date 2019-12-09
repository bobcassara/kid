<?php
//init values

$email="";

//Connect to database

require ("mysql_connect.php");

# Lets get our data from the URL
if (isset($_REQUEST['email'])){
$email = mysqli_real_escape_string($connection, $_REQUEST['email']);
}

if (!$email){
	?>
<form action = "forgotPassword.php"
<table border=1>
<tr>
<td>SHARP Email Address:</td>
<td><input type="text" name="email" suggestion="email"></td></tr>
<tr>
<td colspan="2"><input type = "submit"></td></tr>
</table>
</form>
<?php
}else{
	$query = "SELECT email,name,password, username FROM staff
	WHERE email = '$email'";
	$result = mysqli_query($connection, $query);
	
	//print $query;
	
	$rows= mysqli_num_rows( $result);
	
	if ($rows === 0) {
    // Oh, no rows! Sometimes that's expected and okay, sometimes
    // it is not. You decide. In this case, maybe actor_id was too
    // large? 
    echo "We could not find a match for $email, sorry about that. Please try again or contact the administrator.";
    exit;
	}
    $row = $result->fetch_assoc();
    $name = $row['name'];
	$password = $row['password']; 
	$userName = $row['username'];  
    $message="Hello ".$name. ",\n\n Your username is: ".$userName." \n Your password is: ".$password;
	$headers = 'From: webmaster@example.com' . "\r\n" .
    'Reply-To: webmaster@example.com' . "\r\n" .
    'X-Mailer: PHP/' . phpversion();
	
	mail($email,'Forgot Password', $message, $headers);
	print $name."<br/>";
	
	print "<br /><br />An Email has been sent to the address you provided.";
	
	
}