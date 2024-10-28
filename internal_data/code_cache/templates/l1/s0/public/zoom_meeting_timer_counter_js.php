<?php
// FROM HASH: 594296bbdda42ca6eea4d5850221ad2d
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__templater->inlineJs('
	
$(document).ready(function() {

	function DateTimeConverter(unixdatetime) {
		// Convert UNIX timestamp to ISO string (UTC format)
		var utcDateTime = new Date(unixdatetime * 1000).toISOString(); // Returns in \'YYYY-MM-DDTHH:mm:ss.sssZ\' format

		// Extract the human-readable date and time in UTC
		var datePart = utcDateTime.split(\'T\')[0];  // \'YYYY-MM-DD\' part
		var timePart = utcDateTime.split(\'T\')[1].split(\'.\')[0]; // \'HH:mm:ss\' part, removing milliseconds

		// Combine into the desired format
		var fulldate = datePart + " " + timePart;
		
		// Split into parts for ISO format processing
		var tempCountTimmer = fulldate.split(/[- :]/);
		
		// Construct a UTC Date object
		var tempDateObject = new Date(Date.UTC(tempCountTimmer[0], tempCountTimmer[1] - 1, tempCountTimmer[2], tempCountTimmer[3], tempCountTimmer[4], tempCountTimmer[5]));
		var CountDownDateTime = new Date(tempDateObject).getTime();
		
		return CountDownDateTime;
	}

	function timmerCounter(meeting_id, start_datetime) {
		let meet_id = meeting_id;

		// Convert start datetime to UTC countdown date
		let humanDateTime = DateTimeConverter(start_datetime);
		let countDownDate = new Date(humanDateTime).getTime();

		let counter = setInterval(function() {
			let now = new Date().getTime();
			let timeDistance = countDownDate - now;

			// Check if timeDistance is valid and display countdown
			if (timeDistance >= 0) {
				$("#days-meeting-" + meet_id).html(Math.floor(timeDistance / (1000 * 60 * 60 * 24)) + " D");
				$("#hours-meeting-" + meet_id).html(Math.floor((timeDistance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60)) + " H");
				$("#minutes-meeting-" + meet_id).html(Math.floor((timeDistance % (1000 * 60 * 60)) / (1000 * 60)) + " M");
				$("#seconds-meeting-" + meet_id).html(Math.floor((timeDistance % (1000 * 60)) / 1000) + " S");
			}

			// Hide countdown if timeDistance is negative (countdown over)
			if (timeDistance < 0) {
								 
				clearInterval(counter);
				$(".meeting-counter-" + meet_id).hide();
				$("#meeting-counter-" + meet_id).hide();
				$(\'#meeting-waiting-\'+meet_id).text(\'Live\');
				$(\'#meeting-waiting-\'+meet_id).removeClass(\'status_waiting\').addClass(\'status_live\');

			}
		}, 1000);
	}

	// Initialize countdown with UTC timestamp values
	timmerCounter(' . $__vars['meeting']['meeting_id'] . ', ' . $__vars['meeting']['start_time'] . ');
});

');
	return $__finalCompiled;
}
);