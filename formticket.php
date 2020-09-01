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

<div id="page-wrapper">
	<div class="container">
		<div class="row">
			<div class="col-sm-12">

<?php
	require_once('autofill.php');
?>

<form action="addticket.php" method="post" id="ticketForm">
	<p>Project</p>
	<select id="project_id" name="project_id" form="ticketForm">
		<option value="" selected disabled hidden>Select One</option>
		<?php
		
			require_once('mysql_connect.php');
		
			$sqlx = "SELECT * FROM projects";
			$resultx = mysqli_query($db_projects, $sqlx);

			if (mysqli_num_rows($resultx) > 0) {
				// output data of each row
				while($row = mysqli_fetch_assoc($resultx)) {
					echo '<option value="'.$row["project_id"].'"'.autoSelectFormReturn('project_id',$row["project_id"]).'>Project '.$row["title"].' (for '.$row["client"].')</option>';//ALPHABETICAL??
				}
				echo '</select>';
			} else {
				echo "0 results";
			}
		
		?>
	</select>
	
	<p>Ticket Title</p>
    <input type="text" name="title" id="title" <?php autoFillForm('title'); ?>>
	<p>Ticket Type</p>
	<select id="type" name="type" form="ticketForm">
		<option value="bug" <?php autoSelectForm('type','bug')?>>Bug</option>
		<option value="issue" <?php autoSelectForm('type','issue')?>>Issue</option>
		<option value="task" <?php autoSelectForm('type','task')?>>Task</option>
		<option value="new_feature" <?php autoSelectForm('type','new_feature')?>>New Feature</option>
	</select>
	<p>Ticket Description</p>
	<textarea rows="4" cols="50" name="description" form="ticketForm"><?php autoFillDescription('description'); ?></textarea>
	<p>Assign Ticket To User</p>
	<select id="assigned_to" name="assigned_to" form="ticketForm">
		<?php
		
		$sqlu = "SELECT * FROM users";
		$resultu = mysqli_query($db_projects, $sqlu);

		if (mysqli_num_rows($resultu) > 0) {
			// output data of each row
			while($row = mysqli_fetch_assoc($resultu)) {
			echo '<option value="'.$row["id"].'"'.autoSelectFormReturn('assigned_to',$row["id"]).'>'.$row["username"].'</option>';
			}
			echo '</select>';
		} else {
			echo "0 results";
		}
		
		?>
	</select>
	<p>Ticket Status</p>
	<select id="status" name="status" form="ticketForm">
		<option value="active" <?php autoSelectForm('status','active')?>>Active</option>
		<option value="idle" <?php autoSelectForm('status','idle')?>>Idle</option>
		<option value="completed" <?php autoSelectForm('status','completed')?>>Completed</option>
		<option value="inactive" <?php autoSelectForm('status','inactive')?>>Inactive</option>
	</select>
	<p>Ticket Priority</p>
	<select id="priority" name="priority" form="ticketForm">
		<option value="low" <?php autoSelectForm('priority','low')?>>Low</option>
		<option value="medium" <?php autoSelectForm('priority','medium')?>>Medium</option>
		<option value="high" <?php autoSelectForm('priority','high')?>>High</option>
	</select>
    <input type="submit" name="submit" value="Send" />
</form>
			</div>
		</div>
	</div>
</div>


<?php require_once $abs_us_root . $us_url_root . 'users/includes/html_footer.php'; ?>