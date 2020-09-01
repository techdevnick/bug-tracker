<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Add Record Form</title>
</head>
<body>

<?php
//print_r($_POST);

if(isset($_POST['submit'])) {
	$data_missing = array();
	
	if(empty($_POST['project_id'])){
		$data_missing[] = "project_id";
	}else{
		$p_project_id = $_POST['project_id'];
	}
	
	if(empty($_POST['title'])){
		$data_missing[] = "title";
	}else{
		$p_title = trim($_POST['title']);
	}
	
	if(empty($_POST['type'])){
		$data_missing[] = "type";
	}else{
		$p_type = $_POST['type'];
	}
	
	$p_description = $_POST['description'];
	$p_assigned_to = $_POST['assigned_to'];
	$p_status = $_POST['status'];
	$p_priority = $_POST['priority'];
	
	if(empty($data_missing)){
		require_once('mysql_connect.php');
		
		$query = "INSERT INTO tickets (project_id, title, date_created, type, description, assigned_to, status, priority, ticket_id) VALUES (?, ?, NOW(), ?, ?, ?, ?, ?, NULL)";
		
		$stmt = mysqli_prepare($db_projects, $query);
		
		mysqli_stmt_bind_param($stmt, "isssiss", $p_project_id, $p_title, $p_type, $p_description, $p_assigned_to, $p_status, $p_priority);
		
		mysqli_stmt_execute($stmt);
		
		$affected_rows = mysqli_stmt_affected_rows($stmt);
		
		if($affected_rows == 1){
			echo 'ticket added213123';
			mysqli_stmt_close($stmt);
			mysqli_close($db_projects);
		}else{
			echo 'Error<br />';
			echo mysqli_error($db_projects);
			mysqli_stmt_close($stmt);
			mysqli_close($db_projects);
		}
		
	}else{
		/*echo 'The following data is missing<br />';
		foreach($data_missing as $missing){
			echo "$missing<br />";
		}*/
		
		include 'formticket.php';
		
	}

}else{
	header("Location: ticketform.php");
	exit;
}
?>





</body>
</html>