<?php 

session_start();
include "dbconnect.php"

?>

<style>
html *{
	background-color: #ff751a;
	padding: 0px;
	margin: 0px;
}

input, textarea {
	background-color: black;
	border: solid white;
	color: white;
}

#menu a{
	color: white;
	background-color: black;
	text-decoration: none;
	padding-right: 20px;
	border-right: solid black 4px;
}

#menu a:hover, a:focus{
	text-decoration: underline;
}
</style>

<img style="left:0px;top:0px;margin: 0px;padding: 0px;width:100%;z-index:-1;" src="images/panoramic.jpeg" />

<span style="position: absolute;top:0px;padding: 5px;font-size: 300%;background: black; color: white; border: solid black 4px; text-align: center">
TradeOff
</span>

<div id="menu" style="text-align: center;background-color: black;width: 100%;border: solid black 4px;margin-top: -5px; font-size: 150%;">
<a href="login.php">Log In</a>
<a href="signup.php">Sign Up</a>
</div>