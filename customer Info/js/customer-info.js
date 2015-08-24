$('document').ready(function(){
	
	$('#customer').change( getCustomerInfo );

});

function getCustomerInfo() {

	// Save the ID of the chosen customer
	var customerID = $(this).val();

	// Make sure the value is not blank
	if( isNaN(customerID) ) {
		return;
	}

	// Prepare AJAX
	$.ajax({

		url: 'app/get-customer-info.php',
		data: {
			customerID: customerID
		},
		success: function(dataFromServer) {
			
			// Create and unordered list
			var ul = $('<ul>').addClass('test').attr('id', 'test');
			
			// Insert the Data
			$(ul).append('<li>'+dataFromServer.phone+'</li>');
			$(ul).append('<li>'+dataFromServer.email+'</li>');

			// Add the unordered list to the customer-info div
			$('#customer-info').html(ul);
		
		},
		error: function() {
			console.log('cannot connect to server...');
		}

	});
}
	 