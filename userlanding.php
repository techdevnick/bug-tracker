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

<div class="user-landing">
	<div class="user-landing-flex-container">
		<div><?php
	if (mysqli_num_rows($result) > 0) {
		// output data of each row
		$i = -1;
		while($row = mysqli_fetch_assoc($result)) {
			$i++;
		}
		echo "You have $i open ticket".switchTicketPlural($i);
	}else{
		echo "You don't have any active tickets";
	}

	mysqli_close($db_projects);
?></div>
		<div>2</div>
		<div>3</div>
		<div>4</div>
		<div>5</div>
		<div>6</div>
		<div>7</div>
	</div>
</div>

<?php require_once $abs_us_root . $us_url_root . 'users/includes/html_footer.php'; ?>