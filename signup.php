<?php session_start();

if(isset($_SESSION['uid']))
{
 header("Location: search_transactions.php");
}

include "dbconnect.php"

?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" >

<?php include "header_logout.php" ?>

<br />

<?php
if(isset($_POST["signup"]))
{
	
 $username = mysqli_real_escape_string($con, $_POST['username']);
 $email = mysqli_real_escape_string($con, $_POST['email']);
 $password = mysqli_real_escape_string($con, $_POST['password']);
 
 if(mysqli_query($con, "INSERT INTO users(user_name,user_email,user_pass) VALUES('$username','$email','$password')"))
 {
  ?>
        <script>alert('successfully registered ');</script>
        <?php
 }
 else
 {
  ?>
        <script>alert('error while registering you...');</script>
        <?php
 }
}
?>

<form action="signup.php" method="post">

<p style="text-align: center">

	Email: <br />
	<input name="email"/> <br />

  <br />

	Username: <br />
	<input name="username"/> <br />

  <br />

	Password: <br />
	<input type="password" name="password"/> <br />

	<br />
	
	Re-Type Password: <br />
	<input type="password" name="retype-password"/> <br />

	<br />

	<input type="submit" name="signup" value="SignUp" style="background-color: black; color: white;"/>

</p>
	
</form>

</html>