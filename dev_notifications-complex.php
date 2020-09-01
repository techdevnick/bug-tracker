<?php
	function humanTiming ($time){
		$time = time() - $time; // to get the time since that moment
		$time = ($time<1)? 1 : $time;
		$tokens = array (
			31536000 => 'year',
			2592000 => 'month',
			604800 => 'week',
			86400 => 'day',
			3600 => 'hour',
			60 => 'minute',
			1 => 'second'
		);
		foreach ($tokens as $unit => $text) {
			if ($time < $unit) continue;
			$numberOfUnits = floor($time / $unit);
			return $numberOfUnits.' '.$text.(($numberOfUnits>1)?'s':'');
		}
	}


	function numberToStatus($ntsInput){
		switch($ntsInput){
			case '1':
				return 'Active';
				break;
			case '2':
				return 'idle';
				break;
			case '3':
				return 'completed';
				break;
			case '4':
				return 'inactive';
				break;
			default:
				return '';
				break;
		}
	}

	function numberToPriority($ntpInput){
		switch($ntpInput){
			case '1':
				return 'low';
				break;
			case '2':
				return 'medium';
				break;
			case '3':
				return 'high';
				break;
			default:
				return '';
				break;
		}
	}







	require_once('db_connect.php');
	
	//SELECT ticket_id, posted_by_user_id, comment, status_changed, status_log, priority_log, MAX(date_created) FROM comments GROUP BY(ticket_id) ORDER BY date_created DESC LIMIT 5
	
	//SELECT * FROM table1,table2 where table1.id = table2.idand table1.id = 101;
	
	
	
	$sqlx = "SELECT * FROM tickets,comments WHERE tickets.ticket_id = comments.ticket_id AND tickets.status = 'active' AND tickets.assigned_to = 12 AND comments.assigned_user_read = 0 AND NOT comments.posted_by_user_id = 12 GROUP BY(comments.ticket_id)";
	$resultx = mysqli_query($db_projects, $sqlx);

	if (mysqli_num_rows($resultx) > 0) {
		// output data of each row
		while($row = mysqli_fetch_assoc($resultx)) {
		echo '<p>';
		//print_r($row);
		echo 'Ticket: '.$row['title'].'<br />';
		echo 'Jeff commented<br />';
		echo $row['comment'].'<br />';
		if($row['status_changed'] != 0){
			$log_changes = "";
			
			if($row['status_log'] != 0){
				$previous_status = numberToStatus(substr($row['status_log'], 0, 1));
				$new_status = numberToStatus(substr($row['status_log'], 1, 2));
				
				$log_changes .= "status to ".ucfirst($new_status);
			}
			
			if($row['priority_log'] != 0){
				$previous_priority = numberToPriority(substr($row['priority_log'], 0, 1));
				$new_priority = numberToPriority(substr($row['priority_log'], 1, 2));
				
				if(strlen($log_changes) > 0){
					$log_changes .= " and ";
				}
				
				$log_changes .= "priority to ".ucfirst($new_priority);
			}
			
			echo $log_changes;
		}
		echo humanTiming(strtotime($row['date_created'])).' ago';
		echo'</p>';
		}
	} else {
		echo "0 results";
	}
	
	echo '<br /><br />';

	mysqli_close($db_projects);

?>