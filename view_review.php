<?php session_start();

if(!isset($_SESSION['uid']))
{
 header("Location: login.php");
}
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" >

<?php include "header.php" ?>

<style>
table {
    width:100%;
}
table, th, td {
    border: 1px solid black;
    border-collapse: collapse;
}
th, td {
    padding: 5px;
    text-align: right;
}
</style>

<br />

<table>
	<tr>
		<th>Reviewed User:</th>
		<th>Review:</th>
		<th>Rating:</th>
		<th>Reviewer:</th>
	</tr>
	<tr>
		<td><a href="view_profile.php">gknopf</a></td>
		<td>
			Made the best chicken-pot-pie I have ever had!
		</td>
		<td><img height="15px" width="100px" src="images/4_stars.png" /></td>
		<td><a href="view_profile.php">gknopf</a></td>
	</tr>
<table>

</html>