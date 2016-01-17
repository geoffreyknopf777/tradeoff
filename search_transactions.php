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



<script src="http://maps.googleapis.com/maps/api/js"></script>

<script>

function initialize() {

  var mapProp = {

    center:new google.maps.LatLng(51.508742,-0.120850),

    zoom:5,

    mapTypeId:google.maps.MapTypeId.ROADMAP

  };

  var map=new google.maps.Map(document.getElementById("googleMap"),mapProp);

}

google.maps.event.addDomListener(window, 'load', initialize);

</script>

  </body>



<form>



<p style="text-align: center">
	
	
	<span style="font-size: 150%;">

	<?php

	if(isset($_POST['accept'])){
		$trans_id = $_POST['trans_id'];
		accept($con, $trans_id, $_SESSION['uid']);
	}

	?>
	
	Search Transactions

	</span>



	<br /><br />

	

	Zip Code:

	<input/>

	<input type="submit" value="Search" style="background-color: black; color: white;"/>



</p>

	

</form>



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

 <form action='search_transactions.php' method='post'>
<input id='trans_id' type='hidden' name="trans_id" value="default"/>
 
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

    <th>Address:</th>

	</tr>


  <?php  
    $sel_trans_query = "select * from transactions where curr_state='open' OR curr_state='locked_in'";
    $run_select_trans = mysqli_query($con, $sel_trans_query);
    if (mysqli_num_rows($run_select_trans) > 0){ // If the transaction exists in the DB
     # $allRows = array();
      while ($row = mysqli_fetch_array($run_select_trans,  MYSQL_ASSOC)){
      #foreach ($allRows as $row){
       
        echo "<tr>";
        echo "<td>";

           echo $row['description'];

        echo "</td>";
        echo "<td>";

          echo $row['unit_cost'];

        echo "</td>";
        echo "<td>";

           echo $row['num_accept'];

        echo "</td>";
        echo "<td>";

          echo $row['min_accept'];

        echo "</td>";
        echo "<td>";

           echo $row['max_accept'];

        echo "</td>";
        echo "<td>";

            echo $row['cutoff_time'];

        echo "</td>";
        echo "<td>";
       
            echo $row['full_time'];

        echo "</td>";
        echo "<td>";

        $sel_username = "select user_name from users where user_id=".$row['proposer_id'];
        $run_username_sel = mysqli_query($con, $sel_username);
        $usern = mysqli_fetch_array($run_username_sel, MYSQLI_ASSOC);
        echo $usern['user_name'];
        echo "</td>";

       echo "<td>";
        $sel_userrating = "select AVG(review_rating) as rating from reviews where reviewed_id=".$row['proposer_id'];
        $run_userrating_sel = mysqli_query($con, $sel_userrating);
        $usern = mysqli_fetch_array($run_userrating_sel, MYSQLI_ASSOC);
        echo $usern['rating'];

       echo "</td>";
       echo "<td>";

          echo "<select>";

          echo "<option value='1'>1</option>";

          echo "<option value='2'>2</option>";

          echo " </select></td> ";

					?>
      <td>
          <input style="background-color: black; color: white;" type="submit" value="Purchase" onclick="document.getElementById('trans_id').value='<?php echo $row['trans_id']; ?>'" name="accept" />
       </td>
				<?php
        echo "<td>";
          echo $row['address'];
        echo "</td>";
        echo "</tr>";
      }
       
    }
?>

</table>

</form>

</html>