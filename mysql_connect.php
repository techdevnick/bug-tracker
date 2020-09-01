<?php
	$db_projects = @mysqli_connect('localhost', 'ticketaccess', '0058AQQm4SZSqLzF', 'projects')
	OR die('db_projects Could not connect to MySQL ') .
		mysqli_connect_error();
?>