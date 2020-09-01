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

	require_once('autofill.php');

	if(empty($_POST['ticket_id'])){
		if(isset($_GET['ticket_id'])){
			$ticket_id = $_GET['ticket_id'];
		}else{
			header("Location: projects.php");
			exit;
		}
	}

	$status = array(false,false,false,false);
	
	$priority = array(false,false,false);

	function checkdisableprioritystatus($returnFor){
		if(!isset($_POST['change_status'])){
			if($returnFor == "select"){
				echo 'disabled';
			}
		}else{
			if($returnFor == "checkbox"){
				echo 'checked';
			}
			
			if($returnFor == "optionStatus"){
				if(isset($_POST['status'])){
					global $status;
					switch($_POST['status']){
						case "active":
							$status[0] = "selected";
							break;
						case "idle":
							$status[1] = "selected";
							break;
						case "completed":
							$status[2] = "selected";
							break;
						case "inactive":
							$status[3] = "selected";
							break;
						default:;
					}
				}
			}
			if($returnFor == "optionPriority"){
				if(isset($_POST['priority'])){
					global $priority;
					switch($_POST['priority']){
						case "low":
							$priority[0] = "selected";
							break;
						case "medium":
							$priority[1] = "selected";
							break;
						case "high":
							$priority[2] = "selected";
							break;
						default:;
					}

				}
			}
		}
	}
	
	
	
	function overrideprioritystatus(){
		if(isset($_POST['status']) && isset($_POST['priority'])){
			checkdisableprioritystatus("optionStatus");
			checkdisableprioritystatus("optionPriority");
		}else{
			global $result;
			if(mysqli_num_rows($result) > 0){
				$row = mysqli_fetch_assoc($result);
				global $status;
				switch($row["status"]){
					case "active":
						$status[0] = "selected";
						break;
					case "idle":
						$status[1] = "selected";
						break;
					case "completed":
						$status[2] = "selected";
						break;
					case "inactive":
						$status[3] = "selected";
						break;
					default:;
				};
				
				global $priority;
				switch($row["priority"]){
					case "low":
						$priority[0] = "selected";
						break;
					case "medium":
						$priority[1] = "selected";
						break;
					case "high":
						$priority[2] = "selected";
						break;
					default:;
				};
			} else {
				echo "ERROR";
			}
		}
	}

	require_once('mysql_connect.php');

	$sql = "SELECT * FROM tickets WHERE ticket_id = $ticket_id";
	$result = mysqli_query($db_projects, $sql);

	overrideprioritystatus();
	
	//user id from UserSpice
	$user_id_for_fetch = $user->data()->id;
?>

<script>
	function toggleCheckbox(){
		document.getElementById("status").toggleAttribute("disabled");
		document.getElementById("priority").toggleAttribute("disabled");
	}
</script>

<form action="addcomment.php" method="post" id="commentForm">
	<input type="hidden" name="ticket_id" value="<?php echo $ticket_id ?>">
	<input type="hidden" name="user_id" value="<?php echo $user_id_for_fetch ?>">
	<p>Comment</p>
	<textarea rows="4" cols="50" name="comment" form="commentForm"></textarea>
	
	<p><input id="change_status" name="change_status" type="checkbox" onchange="toggleCheckbox(this)" form="commentForm" <?php checkdisableprioritystatus("checkbox"); ?>>Change Ticket Info and/or Status</input></p>
	
	<p>Ticket Status</p>
	<select id="status" name="status" form="commentForm" <?php checkdisableprioritystatus("select"); ?>>
		<option value="active" <?php echo $status[0] ?>>Active</option>
		<option value="idle" <?php echo $status[1] ?>>Idle</option>
		<option value="completed" <?php echo $status[2] ?>>Completed</option>
		<option value="inactive" <?php echo $status[3] ?>>Inactive</option>
	</select>
	<p>Ticket Priority</p>
	<select id="priority" name="priority" form="commentForm" <?php checkdisableprioritystatus("select"); ?>>
		<option value="low" <?php echo $priority[0] ?>>Low</option>
		<option value="medium" <?php echo $priority[1] ?>>Medium</option>
		<option value="high" <?php echo $priority[2] ?>>High</option>
	</select>
    <input type="submit" name="submit" value="Send" />
</form>
			</div>
		</div>
	</div>
</div>


<?php require_once $abs_us_root . $us_url_root . 'users/includes/html_footer.php'; ?>