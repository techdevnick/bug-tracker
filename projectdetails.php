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
	require_once('mysql_connect.php');

	$sql = "SELECT * FROM projects";
	$result = mysqli_query($db_projects, $sql);

	function projectTypeSwitch($statusInput){
		if($statusInput == 'mobileapp'){
			return 'Mobile App';
		}elseif($statusInput == 'webapp'){
			return 'Web App';
		}else{
			return ucfirst($statusInput);
		}
	}

	function projectStatusSwitch($statusInput){
		if($statusInput == 'in_progress'){
			return 'In Progress';
		}else{
			return ucfirst($statusInput);
		}
	}

	if (mysqli_num_rows($result) > 0) {
		// output data of each row
		echo '<div class="table">
				<div class="table-row table-row-desc">
					<div class="table-cell project-client">Client</div>
					<div class="table-cell project-title">Project</div>
					<div class="table-cell project-created">Created On</div>
					<div class="table-cell project-type">Project Type</div>
					<div class="table-cell project-mananger">Project Manager</div>
					<div class="table-cell project-status">Status</div>
					<div class="table-cell project-priority">Priority</div>
				</div>';
		while($row = mysqli_fetch_assoc($result)) {
			$date=date_create($row["date_created"]);
			
		echo '<a class="table-row linked" href="tickets.php?project_id='.$row["project_id"].'">
		<div class="table-cell project-title">'.$row["title"].'</div>
		<div class="table-cell project-client">'.$row["client"].'</div>
		<div class="table-cell project-created">'.date_format($date,"m/d/Y").'</div>
		<div class="table-cell project-type">'.projectTypeSwitch($row["type"]).'</div>
		<div class="table-cell project-mananger">'.$row["project_manager"].'</div>
		<div class="table-cell project-status">'.projectStatusSwitch($row["status"]).'</div>
		<div class="table-cell project-priority">'.ucfirst($row["priority"]).'</div>
	</a>';
		//print_r($row);
		}
		echo "</div>";
	} else {
		echo "0 results";
	}

	mysqli_close($db_projects);
?>

<?php require_once $abs_us_root . $us_url_root . 'users/includes/html_footer.php'; ?>