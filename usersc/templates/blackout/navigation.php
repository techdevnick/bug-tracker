<?php if($user->isLoggedIn()){ ?>

<!-- Grab the initial menu work that UserSpice does for you -->
<?php require_once($abs_us_root . $us_url_root . 'users/includes/template/database_navigation_prep.php'); ?>

<!-- This file is a way of allowing the end user to customize stuff -->
<!-- without getting in the middle of the whole template itself -->
<?php require_once($abs_us_root . $us_url_root . 'usersc/templates/' . $settings->template . '/assets/functions/style.php'); ?>
<?php


if (file_exists($abs_us_root . $us_url_root . 'usersc/templates/' . $settings->template . '/info.xml')) {
  $xml = simplexml_load_file($abs_us_root . $us_url_root . 'usersc/templates/' . $settings->template . '/info.xml');
  $navstyle = $xml->navstyle;
}


  ?>
  <!-- Set your logo and the "header" of the navigation here -->
	<div class="grid-container">
		<div class="grid-menu">
			<div class="menu-sticky">
				<div class="logo">
					<span id="bug">Bug </span><span id="tracker">Tracker</span>
				</div>
				<nav id="left-menu">
					<?php
						//URL FIX FOR STATIC MENU
						//echo $abs_us_root . $us_url_root;
						$baseUrlForNavigation = $us_url_root;
					?>
					<ul>
						<li class="primary-menu-item">
							<a class="primary-menu-link" href="<?php echo $baseUrlForNavigation?>dashboard.php">
								<div class="side-indicator">
									<div class="side-indicator-block"></div>
								</div>
								<div class="side-indicator-spacing"></div>
								<div class="menu-item-icon">
									<ion-icon name="desktop-outline"></ion-icon>
								</div>
								<div class="menu-item-text">
									Dashboard
								</div>
							</a>
						</li>
						<li class="primary-menu-item">
							<a class="primary-menu-link" href="<?php echo $baseUrlForNavigation?>projects.php">
								<div class="side-indicator">
									<div class="side-indicator-block"></div>
								</div>
								<div class="side-indicator-spacing"></div>
								<div class="menu-item-icon">
									<ion-icon name="cube-outline"></ion-icon>
								</div>
								<div class="menu-item-text">
								Projects
								</div>
							</a>
						</li>
						<li class="primary-menu-item">
							<?php $usrVarForUrl = $user->data()->id; ?>
							<a class="primary-menu-link" href="<?php echo $baseUrlForNavigation?>tickets.php?user_id=<?php echo $usrVarForUrl ?>">
								<div class="side-indicator">
									<div class="side-indicator-block"></div>
								</div>
								<div class="side-indicator-spacing"></div>
								<div class="menu-item-icon">
									<ion-icon name="receipt-outline"></ion-icon>
								</div>
								<div class="menu-item-text">
								Tickets
								</div>
							</a>
						</li>
					</ul>
				</nav>
				<!--<nav id="left-menu-secondary">
					<div id="left-menu">
					<ul>
						<li class="primary-menu-item">
							<a class="primary-menu-link" href="#Dashboard">
								<div class="side-indicator">
									<div class="side-indicator-block"></div>
								</div>
								<div class="side-indicator-spacing"></div>
								<div class="menu-item-icon">
									<ion-icon name="power-outline"></ion-icon>
								</div>
								<div class="menu-item-text">
									Logout
								</div>
							</a>
						</li>
					</ul>
					</div>
				</nav>-->
			</div>
		</div>
	<div class="grid-main">
		<div class="main-header">
			<div class="page-title">
				<span>Dashboard</span>
			</div>
			
			<div class="header-notifications">
				<div class="notification-text">
					Ticket Alerts
				</div>
				<div class="notification-icon">
					<ion-icon name="notifications-circle"></ion-icon>
					<!-- notifications-outline -->
					<div class="notification-blip">
						<ion-icon name="ellipse"></ion-icon>
					</div>
				</div>
				<div class="notification-display">
					<!--<a href="#" class="notification-comment">
						<span class="notifi-comment-title">Assign Filter</span>
						<br />
						<span>Status Change and Priority Change</span>
						<br />
						<div>by Jeff (5 hours ago)</div>
					</a>
					<a href="#" class="notification-comment">
						<span class="notifi-comment-title">Assign Filter</span>
						<br />
						New Comment
						<br />
						by Jeff (5 hours ago)
					</a>-->
					
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
							echo '<a href="'.$baseUrlForNavigation.'thread.php?ticket_id='.$row['ticket_id'].'" class="notification-comment">';
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
					
					
					
					
					
				</div>
				
				
				
				<div class="usercontrol-icon">
					<ion-icon name="person-circle"></ion-icon>
				</div>
				<div class="usercontrol-display">
					<ul class="user-dropdown" style="text-transform:capitalize;">
									<!-- Here's where it gets tricky.	We need to concatenate together the html to make the menu. -->
			<!-- Basically you will be editing each function into the "style" of your menu -->
			<?php
			if ($settings->navigation_type == 0) {
				$query = $db->query("SELECT * FROM email");
				$results = $query->first();

				//Value of email_act used to determine whether to display the Resend Verification link
				$email_act = $results->email_act;

				// Set up notifications button/modal
				if ($user->isLoggedIn()) {
				if ($dayLimitQ = $db->query('SELECT notif_daylimit FROM settings', array()))
				$dayLimit = $dayLimitQ->results()[0]->notif_daylimit;
				else
				$dayLimit = 7;

				// 2nd parameter- true/false for all notifications or only current
				$notifications = new Notification($user->data()->id, false, $dayLimit);
				}
				require_once($abs_us_root . $us_url_root . 'usersc/templates/' . $settings->template . '/assets/functions/nav.php');
			}


			if ($settings->navigation_type == 1) {
				require_once($abs_us_root . $us_url_root . 'usersc/templates/' . $settings->template . '/assets/functions/dbnav.php');
			}
			?>


			<!-- Close everything out and leave the hooks so error and bold messages work on your template -->
					</ul>
				</div>
			</div>
			


		</div>
<?php

} ?>