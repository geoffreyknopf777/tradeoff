<?php session_start();



if(!isset($_SESSION['uid']))

{

 header("Location: login.php");

}

?>



<?php

class Transaction

{

	public $transaction_id;

	public $creator_id;

	public $min_accept;

	public $max_accept;

	public $current_accept;

	public $cut_off_time;

	public $event_time;

	public $type;

	public $state;







    function __construct(array $list) {

    $this->transaction_id=$list['trans_id'];

		$this->creator_id=$list['proposer_id'];

		$this->min_accept=$list['min_accept'];

		$this->max_accept=$list['max_accept'];

		$this->current_accept=$list['num_accept'];

		$this->cut_off_time=$list['cutoff_time'];

		$this->event_time=$list['full_time'];

		$this->type=$list['trans_type'];

		$this->state=$list['curr_state'];

    }

}

function accept($con, $trans_id, $user_id){
		#sql hit
		$sel_trans_query = "select * from transactions where trans_id=" . $trans_id;
		$run_select_trans = mysqli_query($con, $sel_trans_query);
		if (mysqli_num_rows($run_select_trans) > 0){ // If the transaction exists in the DB
			$row = mysqli_fetch_array($run_select_trans, MYSQLI_ASSOC);
			$t = new Transaction($row);
			if (validAction($t->state, "accept")){ // If the action is valid

				//Update the transaction table
				$newNumAccept = $t->current_accept + 1;
				$sql = "UPDATE transactions SET num_accept=newNumAccept WHERE trans_id=$t->transaction_id"; 
				if ($con->query($sql) === TRUE) {
   					 echo "Transaction updated successfully";
				} else {
				    echo "Error updating record: " . $con->error;
				}

				if ($newNumAccept >= $t->max_accept){ # Set state to LockedOut if max reached
					$sql = "UPDATE transactions SET curr_state='locked_out' WHERE trans_id=$t->transaction_id"; 
				} else if ($newNumAccept >= $t->min_accept){ # Set state to LockedOut if max reached
					$sql = "UPDATE transactions SET curr_state='locked_in' WHERE trans_id=$t->transaction_id"; 
				}

				//Add a new row into the Accepters table
				$sql = "INSERT INTO acceptors (user_id, trans_id) VALUES ($user_id, $t->transaction_id)";
				if ($con->query($sql) === TRUE) {
				    echo "New record created successfully in acceptors table";
				} else {
				    echo "Error: " . $sql . "<br>" . $con->error;
				}
			} else {
				echo "<script>alert('This is not a valid action.')</script>";
			}

		} else {
			echo "<script>alert('The transaction has been removed or does not exist.')</script>";
		}
		#sign up user for event
		#
		#check for cases: max, min, user is transaction creator
	}

function unaccept(Transaction $trans, User $user){
		$sel_trans_query = "select * from transactions where trans_id = '$trans->transaction_id'";
		$run_select_trans = mysqli_query($con, $sel_trans_query);
		if (mysqli_num_rows($run_select_trans) > 0){ // If the transaction exists in the DB
			$row = mysqli_fetch_array($run_select_trans, MYSQLI_ASSOC);
			$t = new Transaction($row); #Get the transaction from the DB
			if (validAction($t->state, "unaccept")){ // If the action is valid

				//Update the transaction table
				$sel_accept_exists = "select * from accepters where transaction_id = '$trans->transaction_id' AND user_id='$user->user_id'";
				$run_accept_query = mysqli_query($con, $sel_accept_exists);
				if (mysqli_num_rows($run_accept_query) > 0){
					$newNumAccept = $t->current_accept - 1;
					$sql = "UPDATE transactions SET num_accept=newNumAccept WHERE trans_id=$t->transaction_id"; 
					#$run_query = mysqli_query($con, $sql);
					if ($con->query($sql) === TRUE) {
	   					 echo "Transaction updated successfully";
					} else {
					    echo "Error updating record: " . $con->error;
					}

					//Remove a row from the Accepters table
					$sql = "DELETE FROM accepters WHERE user_id=$user->user_id AND transaction_id=$t->transaction_id";
					#$run_query = mysqli_query($con, $sql);
					if ($con->query($sql) === TRUE) {
					    echo "Record deleted successfully";
					} else {
					    echo "Error deleting record: " . $con->error;
					}
				} else {
					echo "User is not committed to this transaction.";
				}

				$con->close();
			} else {
				echo "<script>alert('This is not a valid action.')</script>";
			}

		} else {
			echo "<script>alert('The transaction has been removed or does not exist.')</script>";
		}
		#sql hit
		#reverse sign up user for event (only if trans not locked in!!!)
		#check for cases: user is trans creator
	}

function close(Transaction $trans){
		#sql hit
		$sel_trans_query = "select * from transactions where trans_id = '$trans->transaction_id'";
		$run_select_trans = mysqli_query($con, $sel_trans_query);
		if (mysqli_num_rows($run_select_trans) > 0){ // If the transaction exists in the DB
			$row = mysqli_fetch_array($run_select_trans, MYSQLI_ASSOC);
			$t = new Transaction($row); #Get the transaction from the DB
			if (validAction($t->state, "close")){ // If the action is valid

				$sql = "UPDATE transactions SET curr_state='closed' WHERE trans_id=$t->transaction_id";  //SET THE STATUS TO CLOSED.
				if ($conn->query($sql) === TRUE) {
   					 echo "Transaction closed successfully";
				} else {
				    echo "Error closing transaction: " . $conn->error;
				}
			} else {
				echo "<script>alert('This post cannot be closed at this time.')</script>";
			}
		} else {
			echo "<script>alert('This post does not exist or is already closed.')</script>";
		}


	}

function cancel(Transaction $trans, User $user){
		#sql hit
		$sel_trans_query = "select * from transactions where trans_id = '$trans->transaction_id'";
		$run_select_trans = mysqli_query($con, $sel_trans_query);
		if (mysqli_num_rows($run_select_trans) > 0){ // If the transaction exists in the DB
			$row = mysqli_fetch_array($run_select_trans, MYSQLI_ASSOC);
			$t = new Transaction($row); #Get the transaction from the DB
			if (validAction($t->state, "cancel")){ // If the action is valid
		#check if user is trans creator
				if ($user->user_id == $t->creator_id){
					#allow early close & notify subscribers
					$sql = "UPDATE transactions SET curr_state='closed' WHERE trans_id=$t->transaction_id";  //SET THE STATUS TO CLOSED.
					if ($conn->query($sql) === TRUE) {
	   					 echo "<script>alert('This post has been canceled.')</script>";
					} else {
					    echo "Error closing transaction: " . $conn->error;
					}

					$sql = "DELETE FROM accepters WHERE transaction_id=$t->transaction_id";
					if ($conn->query($sql) === TRUE) {
	   					 echo "All accepters removed.";
					} else {
					    echo "Error removing accepters: " . $conn->error;
					}

				}
			}
		}
}

function leaveReview(Transaction $trans, User $user){
		#sql hit
		#check if creator leaving review for person or vice versa
	}

function validAction(string $state, string $action )
	{
		if(strcmp($state,"open")==0 && in_array($action, ['accept', 'unaccept', 'cancel'],true)==true){ #actions: subscribe, close, 
			return true;
		}

		if(strcmp($state,"locked_in")==0 && in_array($action, ['accept'],true)==true){
			return true;
		}

		if(strcmp($state,"locked_out")==0 && in_array($action, ['review'],true)==true){
			return true;
		}

		if(strcmp($state,"review")==0 && in_array($action, ['leavereview','close'],true)==true){
			return true;
		}

		if(strcmp($state,"closed")==0){
			return false; #can't do anything to closed transaction
		}


			return false;

	}




?>