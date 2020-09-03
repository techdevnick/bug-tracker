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
		
		
		
		echo '<div class="project-grid-container">
						<div class="project-grid-item project-table-title">Client</div>
						<div>
							<div class="project-grid-subgrid">
								<div class="project-grid-item project-table-title">Project Info</div>
								<div class="project-grid-item project-table-title">Status</div>
								<div class="project-grid-item project-table-title">Priority</div>
								<div class="project-grid-item project-table-title">Date Created</div>
							</div>
						</div>
					</div>
					<div class="project-grid-container">
						<div class="project-grid-item">
							<select class="client-order" id="client-order" name="client-order">
								<option value="ascending" selected>Ascending</option>
								<option value="descending">Descending</option>
							</select>
						</div>
						<div>
							<div class="project-grid-subgrid">
								<div class="project-grid-item no-padding">
									<div class="unique-project-search">
										<div class="unique-project-stretch">
											<input class="project-searchbar" type="text" placeholder="Search Projects (can be left blank, just submit to apply filters)">
											<div></div>
											<input class="project-search" type="submit" value="Submit">
										</div>
										<div>
											<select class="input-100" id="type" name="type">
												<option value="all-types" selected>All Types</option>
												<option value="software">Software</option>
												<option value="website">Website</option>
												<option value="webapp">Web App</option>
												<option value="mobileapp">Mobile App</option>
											</select>
										</div>
									</div>
								</div>
								<div class="project-grid-item">
									<select class="input-100" id="status" name="status">
										<option value="active" selected>Active</option>
										<option value="idle">Idle</option>
										<option value="completed">Completed</option>
										<option value="inactive">Inactive</option>
										<option value="all-status">All Statuses</option>
									</select>
								</div>
								<div class="project-grid-item">
									<select class="input-100" id="priorities" name="priorities">
										<option value="all-priorities" selected>All Priorities</option>
										<option value="low">Low</option>
										<option value="medium">Medium</option>
										<option value="high">High</option>
									</select>
								</div>
								<div class="project-grid-item">
									<select class="input-100 date-sort-input" id="priorities" name="priorities">
										<option value="new-first" selected>Newest First</option>
										<option value="old-first">Oldest First</option>
									</select>
								</div>
							</div>
						</div>
					</div>';
		
		$yyyx = 0;
		
		while($row = mysqli_fetch_assoc($result)) {
			if($previous_client != $row["client"]){
				if($previous_client != ""){
					echo '</div></div>';
				}

				echo '<div class="project-grid-container">
						<div class="project-grid-item project-client-name">'.$row["client"].'</div>
						<div>
							<a href="tickets.php?project_id='.$row["project_id"].'">
								<div class="project-grid-subgrid">
									<div class="project-grid-item">
										<div class="project-title">'.$row["title"].' ('.ucwords($row["type"]).')</div>
										'.$row["description"].'
									</div>
									<div class="project-grid-item">'.ucwords($row["status"]).'</div>
									<div class="project-grid-item">'.ucwords($row["priority"]).'</div>
									<div class="project-grid-item">'.$row["date_created"].'</div>
								</div>
							</a>';
				
			}elseif($previous_client == $row["client"]){
				echo '<a href="tickets.php?project_id='.$row["project_id"].'">
								<div class="project-grid-subgrid">
									<div class="project-grid-item">
										<div class="project-title">'.$row["title"].' ('.ucwords($row["type"]).')</div>
										'.$row["description"].'
									</div>
									<div class="project-grid-item">'.ucwords($row["status"]).'</div>
									<div class="project-grid-item">'.ucwords($row["priority"]).'</div>
									<div class="project-grid-item">'.$row["date_created"].'</div>
								</div>
							</a>';
			}
			$previous_client = $row["client"];
		}
		
		echo '</div></div>';
		
		
		if($result_count_number > $limit_query_projects && ($num == 0 || $result_count_number > $num*$limit_query_projects)){
			
			echo '<div class="page-turner">';
			
			//if there are 5 or less pages
			if(ceil($result_count_number/$limit_query_projects) < 6){
				$projects_pagination = ceil($result_count_number/$limit_query_projects);
				for($x = 1; $x <= $projects_pagination; $x++){
					echo ' <a class="page-selector';
					
					if($x == $num+1){
						echo ' current-page';
					}
					
					echo '" href="?page='.$x.'">'.$x.'</a>';
				}
			}else{
				$page_limiter = 5;//limit of how many pages to show
				$max_page = ceil($result_count_number/$limit_query_projects);// this will just return the max page for the query
				$page_start_at = 1;//default is 1 but will be overridden with GET['page']
				
				//if current page < 4 then show 1-5 and MAX
				
				/*if(isset($_GET['page']) && ($_GET['page']) == 1){
					echo '<a href="?page=1">1</a>';
				}*/
				
				if(!isset($_GET['page']) || $_GET['page'] <= 3){
					//echo 'show 1-3-5, and MAX';
					for($x = 1; $x <= 5; $x++){
						echo ' <a class="page-selector';
						
						if($x == $num+1){
							echo ' current-page';
						}
						
						echo '" href="?page='.$x.'">'.$x.'</a>';
					}
					
					echo '<div class="dot-dot-dot">...</div><a class="page-selector" href="?page='.$max_page.'">'.$max_page.'</a>';
				}else if($_GET['page'] >= ($max_page - 2)){
					//echo 'show 1, and MAX - 3';
					echo '<a class="page-selector" href="?page=1">1</a><div class="dot-dot-dot">...</div>';
					
					for($x = $max_page-4; $x <= $max_page; $x++){
						echo ' <a class="page-selector';
						
						if($x == $num+1){
							echo ' current-page';
						}
						
						echo '" href="?page='.$x.'">'.$x.'</a>';
					}
				}else{
					//echo 'show 1, c, and MAX';
					
					echo '<a class="page-selector" href="?page=1">1</a><div class="dot-dot-dot">...</div>';
					
					for($x = $num-1; $x <= $num+3; $x++){
						echo ' <a class="page-selector';
						
						if($x == $num+1){
							echo ' current-page';
						}
						
						echo '" href="?page='.$x.'">'.$x.'</a>';
					}
					
					echo '<div class="dot-dot-dot">...</div><a class="page-selector" href="?page='.$max_page.'">'.$max_page.'</a>';
				}
			}
			
			echo '</div>';
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
