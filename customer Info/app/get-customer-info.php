<?php

// Connect to the database
$dbc = new mysqli( 'localhost', 'root', '', 'ajax-customers');

// Capture the and filter data
$customerID = $dbc->real_escape_string($_GET['customerID']);

// Prepare the SQL
$sql = "SELECT phone, email 
		FROM customers 
		WHERE ID = $customerID";

// Run the query
$resultDB = $dbc->query($sql);

// If there was no result
if( $resultDB->num_rows == 1 ) {

	// Convert the result into an associative array
	$resultASSOC = $resultDB->fetch_assoc();

	// Convert into JSON
	$resultJSON = json_encode($resultASSOC);

	// Set up th eheader so javascript knows we are sending JSON
	header('Content-Type: application/json');

	// Display the result on the page
	echo $resultJSON;

} else {

}
