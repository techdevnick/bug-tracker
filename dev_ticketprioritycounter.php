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


<?php
	require_once('db_connect.php');
	
	//get active user id
	$user_id_for_fetch = $user->data()->id;
	
	$a = [];
	
	//$sqlx = "SELECT username AND id FROM users";
	$sqlx = "SELECT priority FROM tickets WHERE status = 'in_progress' AND assigned_to = '$user_id_for_fetch'";
	$resultx = mysqli_query($db_projects, $sqlx);

	if (mysqli_num_rows($resultx) > 0) {
		// output data of each row
		while($row = mysqli_fetch_assoc($resultx)) {
			array_push($a,$row);
		}
	} else {
		echo "0 results";
	}
	
	//print_r($a);
	//print_r($a[0]['id']);
	
	$ticketPriorityCounter = [0,0,0];// 0 low, 1 medium, 2 high
	
	foreach($a as &$aValue){
		if($aValue["priority"] == "low"){
			$ticketPriorityCounter[0]++;
		}elseif($aValue["priority"] == "medium"){
			$ticketPriorityCounter[1]++;
		}else{
			$ticketPriorityCounter[2]++;
		}
	}
	
	//print_r($ticketPriorityCounter);
	echo 'Your Assigned Tickets<br />';
	echo '<a href="tickets.php?user_id='.$user_id_for_fetch.'&priority=low">'.$ticketPriorityCounter[0].' Low Priority</a>';
	echo "<br />";
	echo '<a href="tickets.php?user_id='.$user_id_for_fetch.'&priority=medium">'.$ticketPriorityCounter[1].' Medium Priority</a>';
	echo "<br />";
	echo '<a href="tickets.php?user_id='.$user_id_for_fetch.'&priority=high">'.$ticketPriorityCounter[2].' High Priority</a>';





































	mysqli_close($db_projects);

?>


<!--<script>
</script>-->

<?php require_once $abs_us_root . $us_url_root . 'users/includes/html_footer.php'; ?>