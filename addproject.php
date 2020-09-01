<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Add Record Form</title>
</head>
<body>

<?php
if(isset($_POST['submit'])) {
	$data_missing = array();
	
	if(empty($_POST['title'])){
		$data_missing[] = "title";
	}else{
		$p_title = trim($_POST['title']);
	}
	
	if(empty($_POST['client'])){
		$data_missing[] = "client";
	}else{
		$p_client = trim($_POST['client']);
	}
	
	$p_type = $_POST['type'];
	
	if(empty($_POST['project_manager'])){
		$data_missing[] = "project manager";
	}else{
		$p_project_manager = trim($_POST['project_manager']);
	}
	
	if(empty($_POST['frontend'])){
		$data_missing[] = "frontend";
	}else{
		$p_frontend = trim($_POST['frontend']);
	}
	
	if(empty($_POST['backend'])){
		$data_missing[] = "backend";
	}else{
		$p_backend = trim($_POST['backend']);
	}
	
	$p_description = $_POST['description'];
	$p_status = $_POST['status'];
	$p_priority = $_POST['priority'];
	
	if(empty($data_missing)){
		require_once('mysql_connect.php');
		
		$query = "INSERT INTO projects (title, client, date_created, type, project_manager, frontend, backend, description, status, priority, project_id) VALUES (?, ?, NOW(), ?, ?, ?, ?, ?, ?, ?, NULL)";
		
		$stmt = mysqli_prepare($db_projects, $query);
		
		mysqli_stmt_bind_param($stmt, "sssssssss", $p_title, $p_client, $p_type, $p_project_manager, $p_frontend, $p_backend, $p_description, $p_status, $p_priority);
		
		mysqli_stmt_execute($stmt);
		
		$affected_rows = mysqli_stmt_affected_rows($stmt);
		
		if($affected_rows == 1){
			echo 'project added213123';
			mysqli_stmt_close($stmt);
			mysqli_close($db_projects);
		}else{
			echo 'Error<br />';
			echo mysqli_error();
			mysqli_stmt_close($stmt);
			mysqli_close($db_projects);
		}
		
	}else{
		/*echo 'The following data is missing<br />';
		foreach($data_missing as $missing){
			echo "$missing<br />";
		}*/
		
		include 'form_project.php';
	}

}else{
	header("Location: form_project.php");
	exit;
}
?>





</body>
</html>