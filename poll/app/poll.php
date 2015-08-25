<?php

// Connect to the database
$dbc = new mysqli('localhost', 'root', '', 'ajax-poll');

// Capture and filter the vote
$vote = $dbc->real_escape_string($_GET['vote']);

// Create an array of valid words
$validVotes = ['yes', 'no'];

// See if the user is in the collection of valid words
if( !in_array( $vote, $validVotes ) ) {
	
	$dataToSend = [
		'staus' 	=> false,
		'message' 	=> 'Stop hacking troll!'
	];

	sendMessage( $dataToSend );
}

// Find the user's IP address
$ipAddress = $_SERVER['REMOTE_ADDR'];

// Prepare SQL to find if the user has already voted
$sql = "SELECT  id FROM votes WHERE IPaddress = '$ipAddress'";

// Run the sql
$result = $dbc->query($sql);

// If there is a result
if( $result->num_rows == 1 ) {

	// User has already voted
	$dataToSend = [
		'staus' 	=> false,
		'message' 	=> 'You have already voted'
	];

	sendMessage( $dataToSend );	
}

// Prepare the SQL
$sql = "INSERT INTO votes VALUES( NULL,'$vote', '$ipAddress')";

// Insert the vote
$dbc->query($sql);

$sql = "SELECT COUNT(id) AS TotalVotes,
		SUM( (CASE WHEN vote = 'yes' THEN 1 ELSE 0 END) ) AS TotalYes,
		SUM( (CASE WHEN vote = 'no' THEN 1 ELSE 0 END) ) AS TotalNo
		FROM votes ";
// Run and capture count result		
$result = $dbc->query($sql);

// Convert into an associative array
$result = $result->fetch_assoc();

//Prepare data to send
$dataToSend = [
	'staus' => true,
	'message' => 'Vote Successful',
	'pollResults' => [
		'TotalYes' => (int)$result['TotalYes'],
		'TotalNo' => (int)$result['TotalNo'],
		'TotalVotes' => (int)$result['TotalVotes']
	]
];

// Send the message
sendMessage( $dataToSend );

// Prepares the data messages into JSON
function sendMessage( $messageToSend) {

	$messageToSend = json_encode($messageToSend);

	// Prepare header
	header( 'Content-Type: application/json');

	echo $messageToSend;

	exit();
}