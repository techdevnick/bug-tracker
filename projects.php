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

	//$sql_count = "SELECT COUNT(*) as 'countxx' FROM projects;";
	//$sql_count = "SELECT COUNT(*) as 'countxx' FROM projects;";
	//$result_count = mysqli_query($db_projects, $sql_count);
	//
	//$result_count_number = mysqli_fetch_assoc($result_count)["countxx"];
		
	//default query
	//$sql = "SELECT * FROM projects ORDER BY client LIMIT $limit_query_projects $query_offset_projects";
	//WHERE CustomerID=1;
	$sql = "SELECT * FROM projects ";
	
	function dateSortSwitch($placement){
		
		$dateSortSwitchQuery = "";
		
		if(isset($_GET['date'])){
			if($_GET['date'] == "new-first"){
				$dateSortSwitchQuery = "date_created ASC";
			}else if($_GET['date'] == "old-first"){
				$dateSortSwitchQuery = "date_created DESC";
			}else{
				return;
			}
		}else{
			return "";
		}
		
		if($placement == "after"){
			return ", ".$dateSortSwitchQuery;
		}else if($placement == "before"){{
			return $dateSortSwitchQuery.", ";
		}
		}else{
			return $dateSortSwitchQuery.", ";
		}
	}
	
	//if(isset($_GET['search']) || isset($_GET['type']) || isset($_GET['status']) || isset($_GET['priorities'])){
	//	$sql .= "WHERE ";
	//}
	
	// START
	
	$sqlInputSearch = "";
	
	if(isset($_GET['search'])){
		if(strlen($_GET['search']) > 0){
			$sqlInputSearch = "title LIKE '%".$_GET['search']."%'";
		}
	}
	
	$sqlInputType = "";
	
	if(isset($_GET['type'])){
		if($_GET['type'] == "all-types"){
			$sqlInputType = "type IN ('software', 'website', 'webapp', 'mobileapp')";
		}else if($_GET['type'] == "software"){
			$sqlInputType = "type = 'software'";
		}else if($_GET['type'] == "website"){
			$sqlInputType = "type = 'website'";
		}else if($_GET['type'] == "webapp"){
			$sqlInputType = "type = 'webapp'";
		}else if($_GET['type'] == "mobileapp"){
			$sqlInputType = "type = 'mobileapp'";
		}
	}
	
	$sqlInputStatus = "";
	
	if(isset($_GET['status'])){
		if($_GET['status'] == "active"){
			$sqlInputStatus = "status = 'active'";
		}else if($_GET['status'] == "idle"){
			$sqlInputStatus = "status = 'idle'";
		}else if($_GET['status'] == "completed"){
			$sqlInputStatus = "status = 'completed'";
		}else if($_GET['status'] == "inactive"){
			$sqlInputStatus = "status = 'inactive'";
		}else if($_GET['status'] == "all-status"){
			$sqlInputStatus = "status IN ('active', 'idle', 'completed', 'inactive')";
		}
	}
	
	$sqlInputPriorities = "";
	
	if(isset($_GET['priorities'])){
		if($_GET['priorities'] == "all-priorities"){
			$sqlInputPriorities = "priority IN ('low', 'medium', 'high')";
		}else if($_GET['priorities'] == "low"){
			$sqlInputPriorities = "priority = 'low'";
		}else if($_GET['priorities'] == "medium"){
			$sqlInputPriorities = "priority = 'medium'";
		}else if($_GET['priorities'] == "high"){
			$sqlInputPriorities = "priority = 'high'";
		}
	}
	
	
	$sql_count = "SELECT COUNT(*) as 'countxx' FROM projects";
	$sqlInputArray = [];
	
	if(strlen($sqlInputSearch) > 0 || strlen($sqlInputType) > 0 || strlen($sqlInputStatus) > 0 || strlen($sqlInputPriorities) > 0){
		$sql .= "WHERE ";
		$sql_count .= " WHERE ";
		if(strlen($sqlInputSearch) > 0){
			array_push($sqlInputArray,$sqlInputSearch);
		}
		if(strlen($sqlInputType) > 0){
			array_push($sqlInputArray,$sqlInputType);
		}
		if(strlen($sqlInputStatus) > 0){
			array_push($sqlInputArray,$sqlInputStatus);
		}
		if(strlen($sqlInputPriorities) > 0){
			array_push($sqlInputArray,$sqlInputPriorities);
		}
		$sql .= implode(" AND ", $sqlInputArray)." ";
		$sql_count .= implode(" AND ", $sqlInputArray);
	}
	
	$sql_count .= ";";
	$result_count = mysqli_query($db_projects, $sql_count);

	$result_count_number = mysqli_fetch_assoc($result_count)["countxx"];
	
	
	/*isset($_GET['status'])
	isset($_GET['priorities'])*/
	
	// END
	
	
	if(isset($_GET['client-order'])){
		
		$sql .= "ORDER BY ";
		
		if($_GET['client-order'] == "ascending-client"){
			$sql .= "client ASC ".dateSortSwitch("after")." ";
		}else if($_GET['client-order'] == "descending-client"){
			$sql .= "client DESC ".dateSortSwitch("after")." ";
		}else if($_GET['client-order'] == "ascending-date"){
			$sql .= dateSortSwitch("before")."client ASC ";
		}else if($_GET['client-order'] == "descending-date"){
			$sql .= dateSortSwitch("before")."client DESC ";
		}else{
			$sql .= "client ASC ";
		}
	}else{
		$sql .= "ORDER BY client ASC ";
	}
	
	
	
	//QUERY SETTINGS
	
	function getSwitchForProjects($value, $getID, $defaultValue){
			$selectValue = "";
			
			if(isset($_GET[$getID])){
				if($_GET[$getID] == $value){
					$selectValue = "selected";
				}
			}else{
				if($value == $defaultValue){
					$selectValue = "selected";
				}
			}
			return 'value="'.$value.'" '.$selectValue."";
		}
		
		function searchProjectValue(){
			if(isset($_GET['search'])){
				return 'value="'.$_GET['search'].'"';
			}else{
				return;
			}
			return;
		}
	
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
					<form class="project-grid-container" form="search-projects"  action="projects.php">
						<div class="project-grid-item">
							<select class="client-order" id="client-order" name="client-order">
								<option '.getSwitchForProjects("ascending-client", "client-order", "ascending-client").'>Ascending</option>
								<option '.getSwitchForProjects("descending-client", "client-order", "ascending-client").'>Descending</option>
								<option '.getSwitchForProjects("ascending-date", "client-order", "ascending-client").'>Ascending (Prioritize Date Created)</option>
								<option '.getSwitchForProjects("descending-date", "client-order", "ascending-client").'>Descending (Prioritize Date Created)</option>
							</select>
						</div>
						<div>
							<div class="project-grid-subgrid">
								<div class="project-grid-item no-padding">
									<div class="unique-project-search">
										<div class="unique-project-stretch">
											<input class="project-searchbar" name="search" type="text" pattern="[a-zA-Z0-9-]+" placeholder="Search Projects (Submit to apply filters. Letters/numbers/spaces only)" '.searchProjectValue().'>
											<div></div>
											<input class="project-search" type="submit" value="Submit">
										</div>
										<div>
											<select class="input-100" id="type" name="type">
												<option '.getSwitchForProjects("all-types", "type", "all-types").'>All Types</option>
												<option '.getSwitchForProjects("software", "type", "all-types").'>Software</option>
												<option '.getSwitchForProjects("website", "type", "all-types").'>Website</option>
												<option '.getSwitchForProjects("webapp", "type", "all-types").'>Web App</option>
												<option '.getSwitchForProjects("mobileapp", "type", "all-types").'>Mobile App</option>
											</select>
										</div>
									</div>
								</div>
								<div class="project-grid-item">
									<select class="input-100" id="status" name="status">
										<option '.getSwitchForProjects("active", "status", "active").'>Active</option>
										<option '.getSwitchForProjects("idle", "status", "active").'>Idle</option>
										<option '.getSwitchForProjects("completed", "status", "active").'>Completed</option>
										<option '.getSwitchForProjects("inactive", "status", "active").'>Inactive</option>
										<option '.getSwitchForProjects("all-status", "status", "active").'>All Statuses</option>
									</select>
								</div>
								<div class="project-grid-item">
									<select class="input-100" id="priorities" name="priorities">
										<option '.getSwitchForProjects("all-priorities", "priorities", "all-priorities").'>All Priorities</option>
										<option '.getSwitchForProjects("low", "priorities", "all-priorities").'>Low</option>
										<option '.getSwitchForProjects("medium", "priorities", "all-priorities").'>Medium</option>
										<option '.getSwitchForProjects("high", "priorities", "all-priorities").'>High</option>
									</select>
								</div>
								<div class="project-grid-item">
									<select class="input-100 date-sort-input" id="date" name="date">
										<option '.getSwitchForProjects("new-first", "date", "new-first").'>Newest First</option>
										<option '.getSwitchForProjects("old-first", "date", "new-first").'>Oldest First</option>
									</select>
								</div>
							</div>
						</div>
					</form>';
	
	//END OF SETTINGS
	
		
	$sql .= "LIMIT $limit_query_projects $query_offset_projects";
	
	//print_r($_GET);
	
	$urlQueryPaginationFix = "";
	
	foreach($_GET as $key => $value)
	{
		if($key != "page"){
			$urlQueryPaginationFix .= "&".$key."=".$value;
		}
	}
	
	//debugging
	//echo $sql;
	
	$result = mysqli_query($db_projects, $sql);

	if (mysqli_num_rows($result) > 0) {
		// output data of each row
		
		$previous_client = "";
		
		
		
			//TOOK FORM FROM THIS POSITION
			
		
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
					
					echo '" href="?page='.$x.$urlQueryPaginationFix.'">'.$x.'</a>';
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
						
						echo '" href="?page='.$x.$urlQueryPaginationFix.'">'.$x.'</a>';
					}
					
					echo '<div class="dot-dot-dot">...</div><a class="page-selector" href="?page='.$max_page.$urlQueryPaginationFix.'">'.$max_page.'</a>';
				}else if($_GET['page'] >= ($max_page - 2)){
					//echo 'show 1, and MAX - 3';
					echo '<a class="page-selector" href="?page=1'.$x.$urlQueryPaginationFix.'">1</a><div class="dot-dot-dot">...</div>';
					
					for($x = $max_page-4; $x <= $max_page; $x++){
						echo ' <a class="page-selector';
						
						if($x == $num+1){
							echo ' current-page';
						}
						
						echo '" href="?page='.$x.$urlQueryPaginationFix.'">'.$x.'</a>';
					}
				}else{
					//echo 'show 1, c, and MAX';
					
					echo '<a class="page-selector" href="?page=1'.$urlQueryPaginationFix.'">1</a><div class="dot-dot-dot">...</div>';
					
					for($x = $num-1; $x <= $num+3; $x++){
						echo ' <a class="page-selector';
						
						if($x == $num+1){
							echo ' current-page';
						}
						
						echo '" href="?page='.$x.$urlQueryPaginationFix.'">'.$x.'</a>';
					}
					
					echo '<div class="dot-dot-dot">...</div><a class="page-selector" href="?page='.$max_page.$urlQueryPaginationFix.'">'.$max_page.'</a>';
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
