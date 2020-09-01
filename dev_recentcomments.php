<?php
	require_once('db_connect.php');
		
	//SETUP FOR GETTING MOST RECENT COMMENTS ON UNIQUE TICKETS
	
	$a = [];
		
	//$sqlx = "SELECT username AND id FROM users";
	//$sqlx = "SELECT * FROM comments Order By date_created Desc LIMIT 10";
	//$sqlx = "SELECT * FROM comments GROUP BY(ticket_id) ORDER BY date_created DESC LIMIT 10";
	$sqlx = "SELECT ticket_id, posted_by_user_id, comment, status_changed, status_log, priority_log, MAX(date_created) FROM comments GROUP BY(ticket_id) ORDER BY date_created DESC LIMIT 5";
	$resultx = mysqli_query($db_projects, $sqlx);

	if (mysqli_num_rows($resultx) > 0) {
		// output data of each row
		while($row = mysqli_fetch_assoc($resultx)) {
			array_push($a,$row);
		}
	} else {
		echo "0 results";
	}
	
	
	//SHOW ALL DATA FROM COMMENTS
	/*foreach ($a as $b){
		print_r($b);
		echo "<br />";
	}*/



	//SETUP FOR USER RETRIEVAL BASED ON COMMENTS

	$full_user_list = "";

	//LOOP THROUGH COMMENTS LIST AND GET USER ID'S
	foreach ($a as $b){
		$full_user_list .= " OR id = " . $b['posted_by_user_id'];
	}

	$full_user_list = ltrim($full_user_list," OR ");

	//GET USER INFO BASED ON LIST CREATED
	$a2 = [];

	$sqlx2 = "SELECT username, id FROM users WHERE ($full_user_list)";
	$resultx2 = mysqli_query($db_projects, $sqlx2);

	if (mysqli_num_rows($resultx2) > 0) {
		// output data of each row
		while($row = mysqli_fetch_assoc($resultx2)) {
			array_push($a2,$row);
		}
	} else {
		echo "0 results";
	}

	//DEV CHECK USERNAME ARRAY
	/*foreach ($a2 as $b){
		print_r($b);
		echo "<br />";
	}*/

	mysqli_close($db_projects);
	
	//WHAT HAPPENS WITH EACH COMMENT
	foreach ($a as $b){
		echo "<a href=\"thread.php?ticket_id=".$b['ticket_id']."\">";
		//PULLS KEY FROM $a2 SO WE HAVE THE RIGHT INDEX FOR THE ACTUAL USERNAME
		$key = array_search($b["posted_by_user_id"], array_column($a2, 'id'));
		echo $b['comment'];
		echo "<br />";
		echo "Posted by ".$a2[$key]["username"];
		echo "</a>";
		echo "<br />";
		echo "<br />";
	}

?>