<?php session_start();

if(!isset($_SESSION['uid']))
{
 header("Location: login.php");
}
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" >

<?php include "header.php" ?>

<br />

Username: gknopf

<br /><br />

Email: gknopf@usc.edu

<br /><br />

Credits: 100,000

<br /><br />

<a href="buy_credits.php">Buy More Credits</a>

<br /><br />

<a href="edit_account.php">Edit Account</a>

<br /><br />

<a href="reset_password.php">Reset Password</a>

<br /><br />

</html>