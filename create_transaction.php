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



<div style="position: absolute;padding-left: 50px;">



<span style="font-size: 300%;">

<?php

//Greet the user

$uid = $_SESSION['uid'];

$sel_user = "select user_name from users where user_id='$uid'";



$run_user = mysqli_query($con, $sel_user);

$row = mysqli_fetch_array($run_user, MYSQLI_ASSOC);

echo "<br /><br />Hey " . $row['user_name'] . ", <br />";



//Insert new transactions into the database

if(isset($_POST['create'])){

	

	$timezone = $_SESSION['timezone'];

	$description = mysqli_real_escape_string($con, $_POST['desc']);

	$unit_price = $_POST['unit_price'];

	$min_quantity = $_POST['min_quantity'];

	$max_quantity = $_POST['max_quantity'];

	$cutoff_date = $_POST['cutoff_date'];


	$cutoff_h = $_POST['cutoff_h'];

	#echo $_POST['cutoff_h'];

	$cutoff_ampm = $_POST['cutoff_ampm'];

	$cutoff_m = $_POST['cutoff_m'];

	#$cutoff_datetime = UTCDateToSQLDate(UserDateToUTCDate($cutoff_date, $cutoff_h, $cutoff_m, $cutoff_ampm));
	
	$cutoff_datetime = date("Y-m-d H:i:s", strtotime($cutoff_date . " " . $cutoff_h . $cutoff_m));
	#echo "This works = " . $start_date;
	#echo "User to UTC ".UserDateToUTCDate($cutoff_date, $cutoff_h, $cutoff_m, $cutoff_ampm);
	#echo $cutoff_datetime;

	$full_date = $_POST['full_date'];

	$full_h = $_POST['full_h'];

	$full_ampm = $_POST['full_ampm'];

	$full_m = $_POST['full_m'];

	$full_datetime = date("Y-m-d H:i:s", strtotime($full_date." ".$full_h.$full_m));

	#$full_datetime = UTCDateToSQLDate(UserDateToUTCDate($full_date, $full_h, $full_m, $full_ampm));

	$address = $_POST['address'];

	$zip_code = $_POST['zip_code'];

	$state = "open";

	

	if(mysqli_query($con, "INSERT INTO transactions(description,min_accept,max_accept,cutoff_time,full_time,curr_state,address,zip_code,proposer_id,unit_cost) VALUES('$description','$min_quantity','$max_quantity','$cutoff_datetime','$full_datetime','$state','$address','$zip_code','$uid','$unit_price')")){

	}

	else{

		echo "Could not create the transaction";

		echo $con->error;

	}

}

?>



</span>



<span style="font-size: 125%;">

Fill in this form to share <br />

with your community

</span>



<br /><br />



<span style="font-size: 125%;">

<?php

if(isset($_POST['create'])){

	echo "Form submitted!";

}

?>

</span>



</div>



<form id="form" style="position: relative; margin: auto;width: 50%;" action="create_transaction.php" method="post">



<p style="text-align: left">

	

	Description: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

	<textarea name="desc" rows="5" cols="50"> </textarea> 

	

	<br /><br />

	

	Unit Price: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

	<input name="unit_price"/> 

	

	<br /><br />

	

	Minimum Quantity: &nbsp;&nbsp;&nbsp;&nbsp;

	<input name="min_quantity"/> 

	

	<br /><br />

	

	Maximum Quantity: &nbsp;&nbsp;&nbsp;

	<input name="max_quantity"/> 

	

		<br /><br />

	

	Accept Deadline: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

	<input type="date" name="cutoff_date"/> 

	h:

	<select name="cutoff_h" form="form">

		<option value="1">1</option>

		<option value="2">2</option>

		<option value="3">3</option>

		<option value="4">4</option>

		<option value="5">5</option>

		<option value="6">6</option>

		<option value="7">7</option>

		<option value="8">8</option>

		<option value="9">9</option>

		<option value="10">10</option>

		<option value="11">11</option>

		<option value="12">12</option>

	</select>

	m:

	<select name="cutoff_m" form="form">

		<option value="00">00</option>

		<option value="15">15</option>

		<option value="30">30</option>

		<option value="45">45</option>

	</select>

	<select name="cutoff_ampm" form="form">

		<option value="AM">AM</option>

		<option value="PM">PM</option>

	</select>

	<br /><br />

	

	Fulfillment Deadline: &nbsp;&nbsp;

	<input type="date" name="full_date"/> 

	h:

	<select name="full_h" form="form">

		<option value="1">1</option>

		<option value="2">2</option>

		<option value="3">3</option>

		<option value="4">4</option>

		<option value="5">5</option>

		<option value="6">6</option>

		<option value="7">7</option>

		<option value="8">8</option>

		<option value="9">9</option>

		<option value="10">10</option>

		<option value="11">11</option>

		<option value="12">12</option>

	</select>

	m:

	<select name="full_m" form="form">

		<option value="00">00</option>

		<option value="15">15</option>

		<option value="30">30</option>

		<option value="45">45</option>

	</select>

	<select name="full_ampm" form="form">

		<option value="AM">AM</option>

		<option value="PM">PM</option>

	</select>	

	

	<br /><br />

	

	Street Address: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

	<input name="address"/> 

	

	<br /><br />

	

	Zipcode: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

	<input name="zip_code"/> 

	

	<br /><br />

	

	<input type="submit" name="create" value="Create" style="background-color: black; color: white;"/>



</p>

	

</form>



</html>