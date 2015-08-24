google.load("visualization", "1", {packages:["corechart"]});
$('document').ready(function(){

	// If  there is a variable called to toShow on the page
	if( toShow != undefined ) {
		drawChart(toShow);
	}
	// Listen for the clicks on the vote button
	$('#vote').click(function(){
		
		// Select the checked radio button
		var userVote = $('[name=vote]:checked').val();

		// If the vote is undefined
		// This can only happen if they click submit without choosing an option
		if( userVote == undefined ) {
			$('#message').html('Please choose your vote!');
			return;
		} else {
			$('#message').html('');
		}

		// AJAX
		$.ajax({
			type: 'get',
			url: 'app/poll.php',
			data: {
				vote: userVote
			},
			success: function(dataFromServer) {
				console.log(dataFromServer);

				// google.setOnLoadCallback(drawChart);
				$('#message').html(dataFromServer.message);

				if(dataFromServer.status == true ) {
					// Draw the chart
					drawChart(dataFromServer.pollResults );
				}	
							
			},
			error: function() {
				$('#message').html('Sorry, our servers are busy...');
			}
		});	
	});
});

function drawChart(pollResults) {
	var TotalVotes = pollResults.totalVotes;
	var TotalYes = pollResults.totalYes;
	var TotalNo = pollResults.totalNo;

	var data = google.visualization.arrayToDataTable([
  		// Column names
  		['Vote', 'Count'],
        // Data
        ['Yes', TotalYes],
        ['No', TotalNo]
    ]);

	var options = {
  		title: 'Did anyone like Ant Man? Total Votes '+TotalVotes,
  		is3D: true,
	};
	// Create the chart
	var chart = new google.visualization.PieChart(document.getElementById('piechart'));
	// Display the chart
	chart.draw(data, options);
}
