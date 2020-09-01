<select id="status" name="status" form="projectForm">

<?php
	require_once('db_connect.php');
	
	$sqlx = "SELECT username FROM users";
	$resultx = mysqli_query($db_projects, $sqlx);

	if (mysqli_num_rows($resultx) > 0) {
		// output data of each row
		while($row = mysqli_fetch_assoc($resultx)) {
		echo '<option value="'.$row["username"].'">'.$row["username"]. '</option>';
		}
		echo '</select>';
	} else {
		echo "0 results";
	}
	
	echo '<br /><br />';

	//processing for username selection
	$sql = "SELECT * FROM users where username ='jeff'";
	$result = mysqli_query($db_projects, $sql);

	if (mysqli_num_rows($result) > 0) {
		// output data of each row
		echo mysqli_fetch_assoc($result)["id"];
	} else {
		echo "0 results";
	}

	//processing for title selection
	$sql2 = "SELECT * FROM projects where title ='123T'";
	$result2 = mysqli_query($db_projects, $sql2);

	if (mysqli_num_rows($result2) > 0) {
		// output data of each row
		echo mysqli_fetch_assoc($result2)["project_id"];
	} else {
		echo "0 results";
	}






	mysqli_close($db_projects);

?>