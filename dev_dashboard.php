<?php
/*
UserSpice 5
An Open Source PHP User Management System
by the UserSpice Team at http://UserSpice.com

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/
require_once 'users/init.php';
require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
if (!securePage($_SERVER['PHP_SELF'])){die();}
?>




		<div class="main-content">
			<div class="content-div default-width">
			
			
<?php
	require_once('db_connect.php');
	
	//get active user id
	$user_id_for_fetch = $user->data()->id;
	
	$active_tickets = [];
	
	//$sqlx = "SELECT username AND id FROM users";
	$sqlx = "SELECT priority FROM tickets WHERE status = 'active' AND assigned_to = '$user_id_for_fetch'";
	$resultx = mysqli_query($db_projects, $sqlx);

	if (mysqli_num_rows($resultx) > 0) {
		// output data of each row
		while($row = mysqli_fetch_assoc($resultx)) {
			array_push($active_tickets,$row);
		}
	} else {
		echo "0 results";
	}

	
	$ticketPriorityCounter = [0,0,0];// 0 low, 1 medium, 2 high
	
	foreach($active_tickets as &$aValue){
		if($aValue["priority"] == "low"){
			$ticketPriorityCounter[0]++;
		}elseif($aValue["priority"] == "medium"){
			$ticketPriorityCounter[1]++;
		}else{
			$ticketPriorityCounter[2]++;
		}
	}
	
	//print_r($ticketPriorityCounter);
	//REDO AS FOREACH
	echo 'Your Assigned Tickets<br />';
	echo '<a href="tickets.php?user_id='.$user_id_for_fetch.'&priority=low">'.$ticketPriorityCounter[0].' Low Priority</a>';
	echo "<br />";
	echo '<a href="tickets.php?user_id='.$user_id_for_fetch.'&priority=medium">'.$ticketPriorityCounter[1].' Medium Priority</a>';
	echo "<br />";
	echo '<a href="tickets.php?user_id='.$user_id_for_fetch.'&priority=high">'.$ticketPriorityCounter[2].' High Priority</a>';




	//SETUP FOR GETTING MOST RECENT COMMENTS ON UNIQUE TICKETS -----------------------------------------------
	
	$latest_comments = [];
		
	//$sqlx = "SELECT username AND id FROM users";
	//$sqlx = "SELECT * FROM comments Order By date_created Desc LIMIT 10";
	//$sqlx = "SELECT * FROM comments GROUP BY(ticket_id) ORDER BY date_created DESC LIMIT 10";
	$sqlx2 = "SELECT ticket_id, posted_by_user_id, comment, status_changed, status_log, priority_log, MAX(date_created) FROM comments GROUP BY(ticket_id) ORDER BY date_created DESC LIMIT 5";
	$resultx2 = mysqli_query($db_projects, $sqlx2);

	if (mysqli_num_rows($resultx2) > 0) {
		// output data of each row
		while($row = mysqli_fetch_assoc($resultx2)) {
			array_push($latest_comments,$row);
		}
	} else {
		echo "0 results";
	}
	
	
	//SHOW ALL DATA FROM COMMENTS
	
	/*echo "<br />";
	echo "<br />";
	echo "<br />";
	
	foreach ($latest_comments as $b){
		print_r($b);
		echo "<br />";
	}

	echo "<br />";
	echo "<br />";
	echo "<br />";*/

	//SETUP FOR USER RETRIEVAL BASED ON COMMENTS

	$full_user_list = "";

	//LOOP THROUGH COMMENTS LIST AND GET USER ID'S
	foreach ($latest_comments as $b){
		$full_user_list .= " OR id = " . $b['posted_by_user_id'];
	}

	$full_user_list = ltrim($full_user_list," OR ");

	//GET USER INFO BASED ON LIST CREATED
	$user_info = [];

	$sqlx3 = "SELECT username, id FROM users WHERE ($full_user_list)";
	$resultx3 = mysqli_query($db_projects, $sqlx3);

	if (mysqli_num_rows($resultx3) > 0) {
		// output data of each row
		while($row = mysqli_fetch_assoc($resultx3)) {
			array_push($user_info,$row);
		}
	} else {
		echo "0 results";
	}

	//DEV CHECK USERNAME ARRAY
	/*foreach ($user_info as $b){
		print_r($b);
		echo "<br />";
	}*/
	
	
	
	//SETUP FOR TITLE RETRIEVAL BASED ON COMMENTS ------------------------------------------------------------------

	$full_title_list = "";

	//LOOP THROUGH COMMENTS LIST AND GET TITLE ID'S
	foreach ($latest_comments as $b){
		$full_title_list .= " OR ticket_id = " . $b['ticket_id'];
	}

	$full_title_list = ltrim($full_title_list," OR ");

	//print_r($full_title_list);

	//GET TITLE INFO BASED ON LIST CREATED
	$title_info = [];

	$sqlx4 = "SELECT title, ticket_id FROM tickets WHERE ($full_title_list)";
	$resultx4 = mysqli_query($db_projects, $sqlx4);

	if (mysqli_num_rows($resultx4) > 0) {
		// output data of each row
		while($row = mysqli_fetch_assoc($resultx4)) {
			array_push($title_info,$row);
		}
	} else {
		echo "0 results";
	}

	//DEV CHECK TITLE ARRAY
	/*foreach ($title_info as $b){
		print_r($b);
		echo "<br />";
	}*/
	
	//print_r($title_info);






	//SETUP FOR GETTING MOST RECENT ACTIVE PROJECTS -----------------------------------------------

	$active_projects = [];
	
	//$sqlx = "SELECT username AND id FROM users";
	$sqlx5 = "SELECT title, client, date_created, description, priority, project_id FROM projects WHERE status = 'active' ORDER BY date_created DESC LIMIT 5";
	$resultx5 = mysqli_query($db_projects, $sqlx5);

	if (mysqli_num_rows($resultx5) > 0) {
		// output data of each row
		while($row = mysqli_fetch_assoc($resultx5)) {
			array_push($active_projects,$row);
		}
	} else {
		echo "0 results";
	}






	//SETUP FOR GETTING MOST RECENT TICKETS -----------------------------------------------

	$active_tickets = [];
	
	//$sqlx = "SELECT username AND id FROM users";
	$sqlx6 = "SELECT * FROM tickets WHERE status = 'active' ORDER BY date_created DESC LIMIT 5";
	$resultx6 = mysqli_query($db_projects, $sqlx6);

	if (mysqli_num_rows($resultx6) > 0) {
		// output data of each row
		while($row = mysqli_fetch_assoc($resultx6)) {
			array_push($active_tickets,$row);
		}
	} else {
		echo "0 results";
	}
	
	//echo "THIS IS THE PRINT <br />";
	//print_r($active_tickets);




	//SETUP FOR USER RETRIEVAL BASED ON COMMENTS

	$full_project_title_array_dup = [];

	//LOOP THROUGH COMMENTS LIST AND GET USER ID'S
	foreach ($active_tickets as $b){
		array_push($full_project_title_array_dup, $b['project_id']);
	}

	$full_project_title_array_dup = array_unique($full_project_title_array_dup);

	//echo "THIS IS THE PRINT  IIIIII<br />";
	//print_r($full_project_title_array_dup);

	$full_project_title_list = "";

	//LOOP THROUGH COMMENTS LIST AND GET USER ID'S
	foreach ($full_project_title_array_dup as $b){
		$full_project_title_list .= " OR project_id = " . $b;
	}

	$full_project_title_list = ltrim($full_project_title_list," OR ");

	//GET USER INFO BASED ON LIST CREATED
	$project_title_info = [];

	//print_r($full_project_title_list);

	$sqlx7 = "SELECT title, project_id FROM projects WHERE ($full_project_title_list)";
	$resultx7 = mysqli_query($db_projects, $sqlx7);

	if (mysqli_num_rows($resultx7) > 0) {
		// output data of each row
		while($row = mysqli_fetch_assoc($resultx7)) {
			array_push($project_title_info,$row);
		}
	} else {
		echo "0 results";
	}

	//DEV CHECK USERNAME ARRAY
	/*foreach ($project_title_info as $b){
		print_r($b);
		echo "<br />";
	}*/



















	mysqli_close($db_projects);
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	//WHAT HAPPENS WITH EACH COMMENT
	//ADD DIV
	function numberToStatus($ntsInput){
		switch($ntsInput){
			case '1':
				return 'Active';
				break;
			case '2':
				return 'idle';
				break;
			case '3':
				return 'completed';
				break;
			case '4':
				return 'inactive';
				break;
			default:
				return '';
				break;
		}
	}

	function numberToPriority($ntpInput){
		switch($ntpInput){
			case '1':
				return 'low';
				break;
			case '2':
				return 'medium';
				break;
			case '3':
				return 'high';
				break;
			default:
				return '';
				break;
		}
	}
	
	function typeToType($ntsInput){
		if($ntsInput == "new_feature"){
			return 'New Feature';
		}else{
			return ucfirst($ntsInput);
		}
	}
	
	
	foreach ($latest_comments as $b){
		//PULLS KEY FROM $user_info SO WE HAVE THE RIGHT INDEX FOR THE ACTUAL USERNAME
		$actual_username = array_search($b["posted_by_user_id"], array_column($user_info, 'id'));
		$actual_title_index = array_search($b["ticket_id"], array_column($title_info, 'ticket_id'));
		$actual_title = $title_info[$actual_title_index]['title'];
		
		if($b['status_changed'] == 0){
			echo "<a href=\"thread.php?ticket_id=".$b['ticket_id']."\"><div>";
			
			echo "<b>$actual_title</b><br />";
			
			echo $b['comment'];
			
			echo "<br />";
			
			echo "Posted by ".$user_info[$actual_username]["username"];
			
			echo "</div></a>";
		}else{
			$log_changes = "";
			
			if($b['status_log'] != 0){
				$previous_status = numberToStatus(substr($b['status_log'], 0, 1));
				$new_status = numberToStatus(substr($b['status_log'], 1, 2));
				
				$log_changes .= "status from ".ucfirst($previous_status)." to ".ucfirst($new_status);
			}
			
			if($b['priority_log'] != 0){
				$previous_priority = numberToPriority(substr($b['priority_log'], 0, 1));
				$new_priority = numberToPriority(substr($b['priority_log'], 1, 2));
				
				if(strlen($log_changes) > 0){
					$log_changes .= " and ";
				}
				
				$log_changes .= "priority from ".ucfirst($previous_priority)." to ".ucfirst($new_priority);
			}
			
			
			
			echo "<a href=\"thread.php?ticket_id=".$b['ticket_id']."\"><div>";
			
			echo "<b>$actual_title</b><br />";
			
			echo $user_info[$actual_username]["username"]." changed the ".$log_changes;
			echo "<br />and commented: ";
			echo $b["comment"];
			
			echo "</div></a>";
		}
	}
	
	foreach ($active_projects as $b){
		//print_r($b);
		echo "<br />";
		echo "<b>".$b['title']."</b> (".$b['priority']." Priority)";
		echo "<br />";
		echo "Client: ".$b['client'];
		echo "<br />";
		echo "Started: ".$b['date_created'];
		echo "<br />";
		echo $b['description'];
		echo "<br />";
		echo $b['project_id'];
		echo "<br />";
	}
	
	foreach ($active_tickets as $b){
		$actual_project_title_index = array_search($b["project_id"], array_column($project_title_info, 'project_id'));
		//print_r($b);
		echo "<br />";
		echo "<b>".$b['title']."</b> (".ucfirst($b['priority'])." Priority ".typeToType($b['type']).") for <b>".$project_title_info[$actual_project_title_index]['title']." Project</b>";
		echo "<br />";
		echo $b['description'];
		echo "<br />";
		echo "Started: ".$b['date_created'];
		echo "<br />";
		
	}

?>
			
			</div>
		</div>
<!--<script>
</script>-->

<?php require_once $abs_us_root . $us_url_root . 'users/includes/html_footer.php'; ?>