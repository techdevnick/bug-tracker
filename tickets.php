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
	
	$status = "AND status = 'active'";
	
	if(isset($_GET['status'])){
		if($_GET['status'] == 'all'){
			$status = "";
		}else{
			$setStat = $_GET['status'];
			$status = "AND status = '".$setStat."'";
		}
	}

	$priority = "";
	$priorityMsg = "";

	if(isset($_GET['priority'])){
		$setPri = $_GET['priority'];
		$priority = "AND priority = '".$setPri."'";
	}

	

	if(!empty($_GET['project_id']) && empty($_GET['user_id'])){
		//----------------------------------------just project_id
		$project_id = $_GET['project_id'];
		
		require_once('mysql_connect.php');

		$sql = "SELECT * FROM tickets WHERE (project_id = $project_id $priority $status)";
		$result = mysqli_query($db_projects, $sql);

		if (mysqli_num_rows($result) > 0) {
			// output data of each row
			while($row = mysqli_fetch_assoc($result)) {
				echo '<a href="thread.php?ticket_id='.$row["ticket_id"].'">'.$row["title"]."</a><br />";
			}
		}else{
			echo "No tickets have been created for this project $project_id$priority";
		}

		mysqli_close($db_projects);
	}elseif(empty($_GET['project_id']) && !empty($_GET['user_id'])){
		//----------------------------------------just user_id
		$user_id = $_GET['user_id'];
		
		require_once('mysql_connect.php');

		if(!empty($priority)){
			echo ucfirst($setPri)." Priority<br />";
		}

		$sql = "SELECT * FROM tickets WHERE (assigned_to = $user_id $priority $status)";
		$result = mysqli_query($db_projects, $sql);

		if (mysqli_num_rows($result) > 0) {
			// output data of each row
			while($row = mysqli_fetch_assoc($result)) {
				echo '<a href="thread.php?ticket_id='.$row["ticket_id"].'">'.$row["title"]."</a><br />";
			}
		}else{
			echo "No tickets have been assigned to user $user_id";
		}
	}elseif(!empty($_GET['project_id']) && !empty($_GET['user_id'])){//
		//----------------------------------------both project_id & user_id
		$project_id = $_GET['project_id'];
		$user_id = $_GET['user_id'];
		
		require_once('mysql_connect.php');

		$sql = "SELECT * FROM tickets WHERE (project_id = $project_id AND assigned_to = $user_id $status)";
		$result = mysqli_query($db_projects, $sql);

		if (mysqli_num_rows($result) > 0) {
			// output data of each row
			while($row = mysqli_fetch_assoc($result)) {
				echo '<a href="thread.php?ticket_id='.$row["ticket_id"].'">'.$row["title"]."</a><br />";
			}
		}else{
			echo "0 results found for user $user_id under project $project_id";
		}
	}else{
		header("Location: projects.php");
		exit;
	}
?>



			</div>
		</div>
	</div>
</div>


<?php require_once $abs_us_root . $us_url_root . 'users/includes/html_footer.php'; ?>