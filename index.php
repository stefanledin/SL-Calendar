<?php
	require 'src/ordbild/markup.php';
	require 'src/ordbild/calendar.php';
	use ordbild\Calendar;
	
	$calendar = new Calendar($_GET['year'], $_GET['month']);
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