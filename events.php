<?php
try {
	// localhost
	$url = 'mysql:host=localhost;dbname=fullcalendar';
	$username = 'root';
	$password = 'Spearman12!';

	// connect to database
	$connection = new PDO($url,$mysql_user,$mysql_password);

	// prepare and execute query
	$query = "SELECT * FROM events
			  INNER JOIN locations ON events.location_id = locations.id
			  INNER JOIN speakers  ON events.speaker_id = speakers.id";
	$sth = $connection->prepare($query);
	$sth->execute();

	// returning array
	$events = array();
	
	// fetch event attributes
	while ($row = $sth->fetch(PDO::FETCH_ASSOC)) {
		$e = array();
		$e['id'] = $row['id'];
		$e['title'] = $row['title'];
		$e['start'] = $row['start'];
		$e['end'] = $row['end'];
		$e['speaker'] = $row['sname'];
		$e['bio'] = $row['bio'];
		$e['location'] = $row['lname'];
		$e['address'] = $row['address'];
		$e['map'] = $row['url'];
		$e['group'] = $row['group'];
		switch ($row['type']) {
			case 'WORK':
				$e['color'] = "blue";
				break;
			case 'LECT':
				$e['color'] = "green";
				break;
			case 'LUNC':
				$e['color'] = "orange";
				break;
			default:
				break;
		}

		// merge the event array into the return array
		array_push($events, $e);	
	}

	echo json_encode($events);
	exit();
} catch (PDOException $e) {
	echo $e->getMessage();
}