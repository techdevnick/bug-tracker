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

<?php
	require_once('mysql_connect.php');

	//$user_id_for_fetch = $user->data()->id;

	$sql = "SELECT * FROM tickets WHERE assigned_to = 12";
	$result = mysqli_query($db_projects, $sql);

	function switchTicketPlural($num){
		if($num > 1 || $num == 0){
			return "s";
		}else{
			return;
		}
	}
?>


		<div class="main-content">
			<div class="content-div default-width">
				<div class="standard-content-header">Your Assigned Tickets</div>
				<div class="inner-cd-content">
					<ul>
						<li>23 High Priority Tickets</li>
						<li>9999 Medium Priority Tickets</li>
						<li>420 Low Priority Tickets</li>
					</ul>
					<ol>
						<li>23 High Priority Tickets</li>
						<li>9999 Medium Priority Tickets</li>
						<li>420 Low Priority Tickets</li>
					</ol>
					<a href="#" class="btn">See All Tickets</a>
					
					
					
					
					
		
				</div>
			</div>
		</div>
<!--<script>
</script>-->

<?php require_once $abs_us_root . $us_url_root . 'users/includes/html_footer.php'; ?>