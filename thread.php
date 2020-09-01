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

<div id="page-wrapper">
	<div class="container">
		<div class="row">
			<div class="col-sm-12">

<?php
	if(empty($_GET['ticket_id'])) {
		header("Location: projects.php");
		exit;
	}else{
		$ticket_id = $_GET['ticket_id'];
		
		require_once('mysql_connect.php');

		$sql = "SELECT * FROM comments WHERE ticket_id = $ticket_id ORDER BY date_created DESC";
		$result = mysqli_query($db_projects, $sql);

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

		if (mysqli_num_rows($result) > 0) {
			// output data of each row
			while($row = mysqli_fetch_assoc($result)){
				if($row['status_changed'] == 1){
					if($row['status_log'] != 0){
						$previous_status = numberToStatus(substr($row['status_log'], 0, 1));
						$new_status = numberToStatus(substr($row['status_log'], 1, 2));
						
						echo "Status changed from ".ucfirst($previous_status)." to ".ucfirst($new_status)."<br />";
					}
					
					if($row['priority_log'] != 0){
						$previous_priority = numberToPriority(substr($row['priority_log'], 0, 1));
						$new_priority = numberToPriority(substr($row['priority_log'], 1, 2));
						
						echo "Priority changed from ".ucfirst($previous_priority)." to ".ucfirst($new_priority)." Priority<br />";
					}
				}
				echo $row["comment"];
				echo '<br />';
				echo $row["date_created"];
				echo '<br />';
				
				$user_id = $row['posted_by_user_id'];
				
				//echo $user_id;
				
				$sqlx = "SELECT * FROM users where id ='$user_id'";
				$resultx = mysqli_query($db_projects, $sqlx);
				echo "Posted by ".ucfirst(mysqli_fetch_assoc($resultx)["username"])."<br />";
				
				//echo $user['username'];
				echo '<hr />';
			}
		} else {
			echo "0 results";
		}

		mysqli_close($db_projects);
	}
?>




			</div>
		</div>
	</div>
</div>


<?php require_once $abs_us_root . $us_url_root . 'users/includes/html_footer.php'; ?>