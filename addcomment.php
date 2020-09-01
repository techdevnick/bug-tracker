<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Add Record Form</title>
</head>
<body>
<?php
// show all posted variables
//print_r($_POST);

if(isset($_POST['submit'])){
	$data_missing = array();
	
	if(empty($_POST['comment'])){
		$data_missing[] = "comment";
	}else{
		$comment = $_POST['comment'];
	}
	
	$ticket_id = $_POST['ticket_id'];
	
	$user_id = $_POST['user_id'];

	$assigned_user_read = false;

	//check for change_status
	$change_status = false;

	$status_log = 0;
	$priority_log = 0;
	
	if(empty($data_missing)){
		require_once('mysql_connect.php');

		$sql = "SELECT * FROM tickets WHERE ticket_id = $ticket_id";
		$result = mysqli_query($db_projects, $sql);
		$row = mysqli_fetch_assoc($result);


		if($user_id == $row['assigned_to']){
			$assigned_user_read = true;
		}
		
		if(isset($_POST['change_status'])){
			$change_status = true;
		}

		if($change_status){
			//do the status change to the ticket table
			//get current status
			//if different the put in new thing
			//
			
			if($row['priority'] != $_POST['priority']){
				switch($row['priority']){
					case 'low':
						$priority_log = 10;
						break;
					case 'medium':
						$priority_log = 20;
						break;
					case 'high':
						$priority_log = 30;
						break;
					default:
						$priority_log = 10;
				}
				
				switch($_POST['priority']){
					case 'low':
						$priority_log_input = 1;
						break;
					case 'medium':
						$priority_log_input = 2;
						break;
					case 'high':
						$priority_log_input = 3;
						break;
					default:
						$priority_log_input = 1;
				}
				
				$priority_log += $priority_log_input;
			}
			
			if($row['status'] != $_POST['status']){
				switch($row['status']){
					case 'active':
						$status_log = 10;
						break;
					case 'idle':
						$status_log = 20;
						break;
					case 'completed':
						$status_log = 30;
						break;
					case 'inactive':
						$status_log = 40;
						break;
					default:
						$status_log = 10;
				}
				
				switch($_POST['status']){
					case 'active':
						$status_log_input = 1;
						break;
					case 'idle':
						$status_log_input = 2;
						break;
					case 'completed':
						$status_log_input = 3;
						break;
					case 'inactive':
						$status_log_input = 4;
						break;
					default:
						$status_log_input = 1;
				}
				
				$status_log += $status_log_input;
			}
			
			
			$status_changed = 1;
		}else{
			$status_changed = 0;
		}
		
		$query = "INSERT INTO comments (ticket_id, posted_by_user_id, date_created, comment, status_changed, status_log, priority_log, comment_id, assigned_user_read) VALUES (?, ?, NOW(), ?, ?, ?, ?, NULL, ?)";
		
		$stmt = mysqli_prepare($db_projects, $query);
		
		mysqli_stmt_bind_param($stmt, "iisiiii", $ticket_id, $user_id, $comment, $status_changed, $status_log, $priority_log, $assigned_user_read);
		
		mysqli_stmt_execute($stmt);
		
		$affected_rows = mysqli_stmt_affected_rows($stmt);
		
		if($affected_rows == 1){
			echo 'comment added<br />';
			mysqli_stmt_close($stmt);
			mysqli_close($db_projects);
		}else{
			echo 'Error<br />';
			echo mysqli_error($db_projects);
			mysqli_stmt_close($stmt);
			mysqli_close($db_projects);
		}
		
	}else{
		echo 'The following data is missing<br />';
		foreach($data_missing as $missing){
			echo "$missing<br />";
		}
		
		include 'commentform.php';
		
	}
}else{
	header("Location: projects.php");
	exit;
}
?>
</body>
</html>