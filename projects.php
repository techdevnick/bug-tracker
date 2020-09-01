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
				<div class="projects-table">
<?php
	require_once('mysql_connect.php');

	$limit_query_projects = 10;
	$query_offset_projects = "";
	
	$num = 0;
	
	if(isset($_GET['page'])){
		$num = $_GET['page'];
		$num--;
		$query_offset_projects = "OFFSET ".$num*$limit_query_projects;
	}

	$sql_count = "SELECT COUNT(*) as 'countxx' FROM projects;";
	$result_count = mysqli_query($db_projects, $sql_count);

	$result_count_number = mysqli_fetch_assoc($result_count)["countxx"];

	$sql = "SELECT * FROM projects ORDER BY client LIMIT $limit_query_projects $query_offset_projects";
	$result = mysqli_query($db_projects, $sql);

	if (mysqli_num_rows($result) > 0) {
		// output data of each row
		
		$previous_client = "";
		
		
		
		echo '<div class="project-display"><table><tbody>';
		echo '<tr><td><div class="project-display-title">Client</div></td><td><div>Project</div></td>';
		
		$yyyx = 0;
		
		while($row = mysqli_fetch_assoc($result)) {
			if($previous_client != $row["client"]){
				if($previous_client != ""){
					echo '</td></tr>';
				}
				echo '<tr><td><div class="project-display-title">'.$row["client"].'</div></td>';
				echo '<td><a href="tickets.php?project_id='.$row["project_id"].'">'.$row["title"].' ('.ucwords($row["type"]).')<br />'.$row["description"].'</a>';
			}elseif($previous_client == $row["client"]){
				echo '<br /><a href="tickets.php?project_id='.$row["project_id"].'">'.$row["title"].' ('.ucwords($row["type"]).')<br />'.$row["description"].'</a>';
			}
			$previous_client = $row["client"];
		}
		
		echo '</tr></tbody></table></div>';
		
		
		if($result_count_number > $limit_query_projects && ($num == 0 || $result_count_number > $num*$limit_query_projects)){
			echo "Page";
			$projects_pagination = ceil($result_count_number/$limit_query_projects);
			for($x = 1; $x <= $projects_pagination; $x++){
				echo ' <a class="page-selector';
				
				if($x == $num+1){
					echo ' current-page';
				}
				
				echo '" href="projects.php?page='.$x.'">'.$x.'</a>';
			}
		}
		
	} else {
		echo '<div class="project-display"><div class="bt-search-display-error">Either there are no results or no projects have been created yet.</div></div>';
	}

	mysqli_close($db_projects);
	
?>



				</div>
			</div>
		</div>
	</div>
</div>


<?php require_once $abs_us_root . $us_url_root . 'users/includes/html_footer.php'; ?>