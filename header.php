<?php

include "dbconnect.php";
include "actions_include.php";

date_default_timezone_set("UTC");
$sqldatetimeformat = "Y-m-d h:i:s A e";
$userdatetimeformat = "Y-m-d H:i:s";

function UserDateToUTCDate($date, $h, $m, $ampm){
	$sqldatetimeformat = "Y-m-d h:i:s A e";
	$userdatetimeformat = "Y-m-d H:i:s";
	$datestr = $date . " " . $h . ":" . $m . ":00 " . $ampm . " " . $_SESSION['timezone'];
	$datetime = date_create_from_format($userdatetimeformat, $datestr);
	return $datetime;
}

function SQLDateToUTCDate($sqldate){
	$sqldatetimeformat = "Y-m-d h:i:s A e";
	$userdatetimeformat = "Y-m-d H:i:s";
	$datetime = date_create_from_format($sqldatetimeformat, $sqldate);
	return $datetime;
}

function UTCDateToSQLDate($datetime){
  $sqldatetimeformat = "Y-m-d h:i:s A e";
  $userdatetimeformat = "Y-m-d H:i:s";
	return date_format(new DateTime($datetime), $sqldatetimeformat);
}

function UTCDateToUTCDate($datetime){
	$sqldatetimeformat = "Y-m-d h:i:s A e";
	$userdatetimeformat = "Y-m-d H:i:s";
	return date_format(new DateTime($datetime), $userdatetimeformat);
}

?>

<style>
html *{
	background-color: white;
	padding: 0px;
	margin: 0px;
}

input, textarea {
	background-color: white;
	border: solid black;
	color: black;
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
<a href="view_profile.php">Profile</a>
<a href="search_transactions.php">Search</a>
<a href="create_transaction.php">Post</a>
<a href="view_accepted_transactions.php">Purchased</a>
<a href="view_proposed_transactions.php">Posted</a>
<a href="view_account.php">Account</a>
<a href="logout.php">Log Out</a>
</div>