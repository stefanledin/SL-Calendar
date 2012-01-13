<?php
	
	function slCalendar($year = NULL, $month = NULL) {
		/**
		 * CSS-klasser att leka med:
		 * .sl-calendar (Wrapper för hela kalendern)
		 * .sl-calendar-monthname (Div med månadens namn)
		 * .sl-calendar-header (Översta raden med veckodagarnas namn)
		 * .sl-calendar-week ("Raden" med veckonummer och hela veckan)
		 * .sl-calendar-empty (Tomma datumrutor som representerar föregående månad eller nästa månads dagar)
		 * .sl-calendar-weeknumber (Rutan som visar veckonummret)
		 * .sl-calendar-date (Rutorna som visar varje datum)
		 * .sl-calendar-today (Visa dagens datum)
		 */
		
		// Bestämmer tidszon
		date_default_timezone_set('Europe/Stockholm');

		// Om $_GET['year'] och $_GET['month' finns så skriver de över $year och $month]. Kontrollerar även att $_GET['month'] inte är en högre siffra än 12 (och alltså är en riktig månad ^^)
		if ($_GET['year'] && $_GET['month'] && $_GET['month'] <= 12) {
			$year = $_GET['year'];
			$month = $_GET['month'];
		}

		// Om $year och $month är tomma vid funktionsanropet eller om $_GET['year'] och $_GET['month'] är tomma
		if (empty($year)) {
			$year = date('Y');	
		}
		if (empty($month)) {
			$month = date('m');	
		}

		// $today innehåller datumet som hela kalendern baseras på. (Egentligen är det bara året och månaden som är viktig och behöver ändras)
		$today = getdate(strtotime($year.'-'.$month.'-01'));

		// Ta reda på hur många dagar månaden har och lagra antalet i variabeln $numOfdays
		$numOfdays = cal_days_in_month(CAL_GREGORIAN,$today[mon],$today[year]);

		$monthName = array('Januari','Februari','Mars','April','Maj','Juni','Juli','Augusti','September','Oktober','November','December');

		$prevMonth = $month-1;
		$nextMonth = $month+1;
		$prevYear = $year;
		$nextYear = $year;
		
		if ($nextMonth == 13) {
			$nextMonth = 1;
			$nextYear++;
		}
		if ($prevMonth == 0) {
			$prevMonth = 12;
			$prevYear--;
		}

		// Nu börjar vi! Skapa wrapper-diven
		$output = '
			<div class="sl-calendar" id="sl-calendar-wrapper">
				<div class="sl-calendar-monthname">
					<a href="?year='.$prevYear.'&month='.$prevMonth.'" class="sl-calendar-prevmonth sl-calendar-montharrow"> « </a>
						'.$monthName[$today[mon]-1].' '.$year.'
					<a href="?year='.$nextYear.'&month='.$nextMonth.'" class="sl-calendar-nextmonth sl-calendar-montharrow"> » </a>
				</div>
				<div class="sl-calendar-header">
					<div class="sl-calendar-date">Vecka</div>
					<div class="sl-calendar-date">Mån</div>
					<div class="sl-calendar-date">Tis</div>
					<div class="sl-calendar-date">Ons</div>
					<div class="sl-calendar-date">Tors</div>
					<div class="sl-calendar-date">Fre</div>
					<div class="sl-calendar-date">Lör</div>
					<div class="sl-calendar-date">Sön</div>
				</div>
		';
			
			// The Stuff =)
			for ($i=1; $i <= $numOfdays; $i++) { 

				/**
				 * Variablar med information som behövs för varje datum
				 */
				$date = strtotime($today[year].'-'.$today[mon].'-'.$i);
				$week = date('W',$date);
				$dateinfo = getdate($date);

				// Om det är måndag eller månadens första dag så ska man börja på en ny rad
				if ($dateinfo['wday'] == 1 || $i == 1) {
					$output .= '
						<div class="sl-calendar-week">
							<div class="sl-calendar-weeknumber">
								'.date('W',$dateinfo[0]).'
							</div>
					';
				}
					
					// Om månadens första dag inte är en måndag ska tomma rutor lämnas före (för att representera föregående månads dagar)
					if ($i == 1 && $dateinfo['wday'] != 1) {

						// Om månadens första dag är en söndag så är $dateinfo['wday'] 0, och då kommer inte for-loopen fungera
						if ($dateinfo['wday'] == 0) {
							$offset = 6;
						} else {
							$offset = $dateinfo['wday']-1;
						}

						for ($d=0; $d < $offset; $d++) { 
							$output .= '
								<div class="sl-calendar-empty"></div>
							';
						} // End for

					} // Endif

				// Gör en div med datumet. Kontrollera först om datumet är idag och ge det i så fall klassen .sl-calendar-today
				if ($dateinfo['mday'] == date('d') && $dateinfo['mon'] == date('n') && $dateinfo['year'] == date('Y')) {
					$output .= '
						<div class="sl-calendar-date sl-calendar-today">
							'.$dateinfo['mday'].'
						</div>
					';	
				} else {
					$output .= '
						<div class="sl-calendar-date">
							'.$dateinfo['mday'].'
						</div>
					';	
				}

				if ($i == $numOfdays && $dateinfo['wday'] != 0) {

					// Om den sista dagen på månaden är en lördag behövs bara en ruta till.
					if ($dateinfo['wday'] == 6) {
						$output .= '
							<div class="sl-calendar-empty"></div>
						';	
					} else {
						// Om den sista dagen på månaden inte är en lördag eller söndag så räknas det ut hur många rutor till som behövs
						$extra = 6 - $dateinfo['wday'];
						for ($d=0; $d < $extra+1; $d++) { 
							$output .= '
								<div class="sl-calendar-empty"></div>
							';	
						}
					}
					
				}

				// Om det är söndag eller månadens sista dag så ska rad-diven stängas
				if ($dateinfo['wday'] == 0 || $i == $numOfdays) {
					$output .= '</div>';
				}

				

			}
		$output .= '</div>';


		// Nu är allting klart. Leverera allting med $output
		return $output;	
	}

	// Visa kalendern <3
	/*echo slCalendar();*/
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
		<?php
			echo slCalendar();
		?>
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
		<script>
			/*$(document).ready(function(){
				$('.sl-calendar-montharrow').click(function(e){
					e.preventDefault();
					var link = 'http://stefanledin.se/testzon/kalender/index.php'+$(this).attr('href');
						link += ' #sl-calendar-wrapper';
						console.log(link);
					$.get(link, function(data){
						console.log(data);
						//$(body).html(data);
					});
				});
			});*/
		</script>
	</body>
</html>