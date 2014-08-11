<?php
	require 'src/ordbild/markup.php';
	require 'src/ordbild/calendar.php';
	use ordbild\Calendar;
	
	$calendar = new Calendar(array(
		'year' => (isset($_GET['year']) ? $_GET['year'] : null),
		'month' => (isset($_GET['month']) ? $_GET['month'] : null),
		'marked_dates' => array('01', '02', '04', '10')
	));
?>
<!DOCTYPE html>
<html lang="sv">
	<head>
		<meta charset="utf-8">
		<title>slCalendar</title>
	</head>
	<body>
		
		<?php $calendar->paint(); ?>		

	</body>
</html>