<?php
	require_once('db_connect.php');
	
	//SELECT ticket_id, posted_by_user_id, comment, status_changed, status_log, priority_log, MAX(date_created) FROM comments GROUP BY(ticket_id) ORDER BY date_created DESC LIMIT 5
	
	//SELECT * FROM table1,table2 where table1.id = table2.idand table1.id = 101;
	
	
	
	$sqlx = "SELECT * FROM tickets,comments WHERE tickets.ticket_id = comments.ticket_id AND tickets.status = 'active' AND tickets.assigned_to = 12 AND comments.assigned_user_read = 0 AND NOT comments.posted_by_user_id = 12 GROUP BY(comments.ticket_id) LIMIT 8";
	$resultx = mysqli_query($db_projects, $sqlx);

	if (mysqli_num_rows($resultx) > 0) {
		// output data of each row
		while($row = mysqli_fetch_assoc($resultx)) {
		echo '<p>';
		//print_r($row);
		echo '<a href="'.$row['ticket_id'].'" class="notification-comment">';
		echo '<span class="notifi-comment-title">'.$row['title'].'</span><br />';
		$log_changes = "New Comment";
		if($row['status_changed'] != 0){
			if($row['status_log'] != 0){
				$log_changes = "Status Change";
			}
			
			if($row['priority_log'] != 0){
				if($log_changes == "Status Change"){
					$log_changes .= " and Priority Change";
				}else{
					$log_changes = "Priority Change";
				}
			}
		}
		echo '<span>'.$log_changes.'</span>';
		}
	} else {
		echo "0 results";
	}
	
	echo '</a>';

	mysqli_close($db_projects);

?>