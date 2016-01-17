<?php session_start(); ?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" >

<?php include "header_logout.php" ?>

<br /> <br /> <br />

<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js">
</script>
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jstimezonedetect/1.0.4/jstz.min.js">
</script>
<script type="text/javascript">
//timezone script. insert timezone as hidden field
  $(document).ready(function(){
    var tz = jstz.determine(); // Determines the time zone of the browser client
    var timezone = tz.name(); //'Asia/Kolhata' for Indian Time.
    document.getElementById("timezone").value = timezone;
		//$.post("url-to-function-that-handles-time-zone", {tz: timezone}, function(data) {
       //Preocess the timezone in the controller function and get
       //the confirmation value here. On success, refresh the page.
     //});
  });
</script>

<form action="login.php" method="post">

<p style="text-align: center">
	Username: <br />
	<input name="username" /> <br />

  <br />

	Password: <br />
	<input type="password" name="password" /> <br />

	<br />

	<input id="timezone" type="hidden" name="timezone" value="UTC"/>
	
	<input type="submit" name="login" value="Login" style="background-color: black; color: white;"/>

</p>
	
</form>

<a href="forgot_password.php" >Forgot Password?</a>

</html>

<?php

// establishing the MySQLi connection

 



// checking the user

if(isset($_POST['login'])){

$username = mysqli_real_escape_string($con,$_POST['username']);

$password = mysqli_real_escape_string($con,$_POST['password']);

$sel_user = "select * from users where user_name='$username' AND user_pass='$password'";

$run_user = mysqli_query($con, $sel_user);

$check_user = mysqli_num_rows($run_user);

if($check_user>0){
$row = mysqli_fetch_array($run_user, MYSQLI_ASSOC);
$_SESSION['uid']=$row['user_id'];
$_SESSION['timezone']=$_POST['timezone'];

echo "<script>window.open('search_transactions.php','_self')</script>";

}

else {

echo "<script>alert('Email or password is not correct, try again!')</script>";

}

}

?>
