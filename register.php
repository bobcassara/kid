<?php
ini_set("session.gc_maxlifetime", 32400);
ini_set("session.cache_expire", 540);
session_start();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title>KID Register User</title>
        <link href="css/style.css" rel="stylesheet" type="text/css" />
        <script src="js/jquery-2.1.3.min.js"></script>
        <script src="js/jquery.cookie.js"></script>
        <script src="js/functions.js"></script>
    <script>
   document.addEventListener("DOMContentLoaded", function() {

    // JavaScript form validation

    var checkPassword = function(str)
    {
      var re = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}$/;
      return re.test(str);
    };

    var checkForm = function(e)
    {
      if(this.username.value == "") {
        alert("Error: Username cannot be blank!");
        this.username.focus();
        e.preventDefault(); // equivalent to return false
        return;
      }
      re = /^\w+$/;
      if(!re.test(this.username.value)) {
        alert("Error: Username must contain only letters, numbers and underscores!");
        this.username.focus();
        e.preventDefault();
        return;
      }
      if(this.pwd1.value != "" && this.pwd1.value == this.pwd2.value) {
        if(!checkPassword(this.pwd1.value)) {
          alert("The password you have entered is not valid!");
          this.pwd1.focus();
          e.preventDefault();
          return;
        }
      } else {
        alert("Error: Please check that you've entered and confirmed your password!");
        this.pwd1.focus();
        e.preventDefault();
        return;
      }
      alert("Both username and password are VALID!");
    };

    var regForm = document.getElementById("regForm");
    myForm.addEventListener("submit", checkForm, true);

    // HTML5 form validation

    var supports_input_validity = function()
    {
      var i = document.createElement("input");
      return "setCustomValidity" in i;
    }

    if(supports_input_validity()) {
      var usernameInput = document.getElementById("field_username");
      usernameInput.setCustomValidity(usernameInput.title);

      var pwd1Input = document.getElementById("field_pwd1");
      pwd1Input.setCustomValidity(pwd1Input.title);

      var pwd2Input = document.getElementById("field_pwd2");

      // input key handlers

      usernameInput.addEventListener("keyup", function() {
        usernameInput.setCustomValidity(this.validity.patternMismatch ? usernameInput.title : "");
      }, false);

      pwd1Input.addEventListener("keyup", function() {
        this.setCustomValidity(this.validity.patternMismatch ? pwd1Input.title : "");
        if(this.checkValidity()) {
          pwd2Input.pattern = this.value;
          pwd2Input.setCustomValidity(pwd2Input.title);
        } else {
          pwd2Input.pattern = this.pattern;
          pwd2Input.setCustomValidity("");
        }
      }, false);

      pwd2Input.addEventListener("keyup", function() {
        this.setCustomValidity(this.validity.patternMismatch ? pwd2Input.title : "");
      }, false);

    }

  }, false);

</script>



</script>
</head>
<body>
        
        <!--Javascript not enabled?? Then redirect-->
        <noscript>
            <meta http-equiv="refresh" content="0; url=nojavascript.html" />
        </noscript> 
        
        
        <?php

		//init variables
		

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

		//Connect to the db

		include ("mysql_connect.php");
?>		
		<!--Header Area-->

<script type="text/javascript"><!--DropDownMewnu-->
<!--
var timeout         = 500;
var closetimer		= 0;
var ddmenuitem      = 0;

// open hidden layer
function mopen(id)
{	
	// cancel close timer
	mcancelclosetime();

	// close old layer
	if(ddmenuitem) ddmenuitem.style.visibility = 'hidden';

	// get new layer and show it
	ddmenuitem = document.getElementById(id);
	ddmenuitem.style.visibility = 'visible';

}
// close showed layer
function mclose()
{
	if(ddmenuitem) ddmenuitem.style.visibility = 'hidden';
}

// go close timer
function mclosetime()
{
	closetimer = window.setTimeout(mclose, timeout);
}

// cancel close timer
function mcancelclosetime()
{
	if(closetimer)
	{
		window.clearTimeout(closetimer);
		closetimer = null;
	}
}

// close layer when click-out
document.onclick = mclose; 
// -->
</script>




<table width="100%" border="0" >
  <tr>
    <td><img align="left" name="logo" type="image" src="images/sharp-transparent.png" width="250"/></td>
    <td></td>
    <td><h1 align="right">KID Registration</h1></td>
    </tr>
</table>

<ul id="sddm">
	<li><a href="#" onmouseover="mopen('m1')" onmouseout="mclosetime()">Home</a>
		<div id="m1" onmouseover="mcancelclosetime()" onmouseout="mclosetime()">
		<a href="http://172.29.39.23/repair/index.php">KID Home &nbsp;&nbsp;</a>
		<a href="http://172.29.39.23">Main Menu</a>
		</div>
	</li>
	
	
</ul>
<div style="clear:both"></div>

<div style="clear:both"></div>

<form id="regForm" action="registerHandler.php" method="post">
<br /><br />
<table border=0>
<tr>
	<td><b>Invitation Code</b></td><td><input type="text" name="invitation" required></td></tr>
	<td>Name (First Last)</td><td><input type="text" name="name" required></td></tr>
	<td>Web ID</td><td><input type="text" name="techId"></td></tr>
	<td>Desired User Name</td><td><input id="field_username" title="Username must not be blank and contain at least 6 characters." type="text" name="username" required pattern ="\w+"></td></tr>
	<td>Desired Password<br>(6 chars or more)</td><td><input id="field_pwd1" type="password" name="password" required pattern=".{6,}"></td></tr>
	<td>Confirm Password</td><td><input id="field_pwd2" title="Please enter the same Password as above." type="password" name="confirmedPassword" required pattern=".{6,}"></td></tr>
	
	<td colspan=2 ><div style="text-align:center;"><input type="submit"> </div></td></tr>
</table>
</form>
