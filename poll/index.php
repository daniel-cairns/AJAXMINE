<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Poll</title>
	<style>
		input:checked + label {
			color: green;
		}
	</style>

</head>
<body>
	
	<h1>Movie Poll</h1>

	<?php 
		// Find out if the user has already voted
		// Connect to the dtabase
		$dbc = new mysqli('localhost', 'root', '', 'ajax-poll');

		// Get the users IP address
		$ipAddress = $_SERVER['REMOTE_ADDR'];

		// Prepare the sql
		$sql = "SELECT ID FROM votes WHERE IPaddress = '$ipAddress'";

		// Run the sql
		$result  = $dbc->query($sql);

		// If there is a result
		if( $result->num_rows == 1 ) {
			// User has already voted
			// Tally the votes
			$sql = "SELECT COUNT(id) AS TotalVotes,
					SUM( (CASE WHEN vote = 'yes' THEN 1 ELSE 0 END) ) AS TotalYes,
					SUM( (CASE WHEN vote = 'no' THEN 1 ELSE 0 END) ) AS TotalNo
					FROM votes ";

			// Run the SQL
			$result = $dbc->query($sql);

			// Convert the result into an associative array
			$result = $result->fetch_assoc();

			// Convert result into interger
			$result['TotalVotes'] = (int)$result['TotalVotes'];
			$result['TotalYes'] = (int)$result['TotalYes'];
			$result['TotalNo'] = (int)$result['TotalNo'];

			// Convert inot JSON
			$result = json_encode($result);
			// Create a javascript element and call the drawChart function

			$alreadyVoted = '<script>var toShow'.$result.'</script>';
		}

	 ?>
	<p>Did you like Ant Man?</p>
	<div>
		<input type="radio" name="vote" id="vote-yes" value="yes">
		<label for="">Yes</label>
	</div>
		
	<div>
		<input type="radio" name="vote" id="vote-no" value="no">
		<label for="vote-no">No</label>
	</div>	

	<button id="vote">Submit your vote</button>
	<span id="message"></span>

	<div id="piechart" style="width: 900px; height: 500px;"></div>
		
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	<script type="text/javascript" src="https://www.google.com/jsapi"></script>
	<script type="text/javascript"></script>
	<script src="js/poll.js"></script>
	<?php 

		if( isset($alreadyVoted)){
			echo $alreadyVoted;
		}
	 ?>
	

</body>
</html>