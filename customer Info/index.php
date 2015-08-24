<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Customer Info</title>
</head>
<body>
	<h1>Customer Info</h1>
	<select name="customer" id="customer">
		<option>Please Select...</option>
		<?php 

			$dbc = new mysqli( 'localhost', 'root', '', 'ajax-customers');

			$sql = "SELECT ID, CONCAT(last_name, ', ', first_name) AS Customer
					FROM customers
					ORDER BY Customer";

			$result = $dbc->query($sql);

			while( $customer = $result->fetch_assoc() ) {
				
				echo'<option value="'.$customer['ID'].'">';
				echo $customer['Customer'];
				echo'</option>';
			}		

		 ?>
	</select>

	<div id="customer-info"></div>
	
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>	
	<script src="js/customer-info.js"></script>
</body>
</html>