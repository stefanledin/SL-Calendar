<?php
	require_once('sl_calendar.php');
?>
<!DOCTYPE html>
<html lang="sv">
	<head>
		<meta charset="utf-8">
		<title>slCalendar</title>
		<style>
			body {
				margin: 50px auto;
				padding:0;
				background-color: #fafafa;
				font-family: sans-serif;
			}

				.sl-calendar {
					margin: 0 auto;
					width: 416px;
					overflow: hidden;
					background:#990000;
				}

					.sl-calendar-week, .sl-calendar-header {
						width:416px;
						overflow: hidden;
					}

					.sl-calendar-monthname {
						font-size:24px;
						text-align: center;
						line-height:36px;
						color: #fff;
					}

					.sl-calendar-montharrow, .sl-calendar-montharrow a,.sl-calendar-montharrow a:visited {
						color: #fff;
						text-decoration:none;
					}

					.sl-calendar-empty, .sl-calendar-weeknumber, .sl-calendar-date {
						width: 50px;
						height: 50px;
						float: left;
						border: 1px solid #ccc;
						text-align: center;
						line-height: 50px;
					}
						.sl-calendar-date {
							background-color: #fff;
						}

						.sl-calendar-empty {
							background-color:#eaeaea;
						}

						.sl-calendar-weeknumber {
							background-color: #333;
							color: #fff;
						}

						.sl-calendar-today {
							background:#990000;
							color: #fff;
						}

		</style>
	</head>
	<body>
		
		<div id="ajaxtarget">
			<?php
				echo slCalendar();
			?>
		</div>

		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
		<script>
			$(document).ready(function(){
				$('.sl-calendar-montharrow').click(function(e){
					e.preventDefault();
					var link = 'http://stefanledin.se/testzon/kalender/index.php'+$(this).attr('href');

					$('#ajaxtarget').load(link);
				});
			});
		</script>
	</body>
</html>