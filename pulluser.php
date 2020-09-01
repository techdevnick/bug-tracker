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
//php goes here
?>

<div id="page-wrapper">
	<div class="container">
		<div class="row">
			<div class="col-sm-12">

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

			</div>
		</div>
	</div>
</div>


<?php require_once $abs_us_root . $us_url_root . 'users/includes/html_footer.php'; ?>
