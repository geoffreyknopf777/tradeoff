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

<h3>
Pending
</h3>

<h3>
Current
</h3>

<h3>
Review
</h3>

<h3>
History
</h3>

<table>
	<tr>
		<th>Description:</th>
		<th>Unit Cost:</th>
		<th>Accepted:</th>
		<th>Needed:</th>
		<th>Limit:</th>
		<th>Accept Deadline</th>
		<th>Fulfillment Dealine</th>
		<th>Username:</th>
		<th>Rating:</th>
		<th>Quantity:</th>
		<th>Accept:</th>
	</tr>
	<tr>
		<td>
			Driving from USC to UCLA.
		</td>
		<td>5 credits</td>
		<td>2</td>
		<td>3</td>
		<td>4</td>
		<td>Wednesday, January 20, 2016 3 PM</td>
		<td>Thursday, January 21, 2016 9 AM</td>
		<td><a href="view_profile.php">gknopf</a></td>
		<td><img height="15px" width="100px" src="images/4_stars.png" /></td>
		<td>
			<select>
				<option value="1">1</option>
				<option value="2">2</option>
			</select></td>
		<td><input style="background-color: black; color: white;" type="submit" value="Purchase"/></td>
	</tr>
<table>

</html>