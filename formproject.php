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

<form action="addproject.php" method="post" id="projectForm">
	<p>Project Title</p>
    <input type="text" name="title" id="title" maxlength="30" <?php autoFillForm('title'); ?>>
	<p>Client Name</p>
	<input type="text" name="client" id="client" maxlength="30" <?php autoFillForm('client'); ?>>
	<p>Type of Project</p>
	<select id="type" name="type" form="projectForm">
		<option value="software" <?php autoSelectForm('type','software')?>>Software</option>
		<option value="website" <?php autoSelectForm('type','website')?>>Website</option>
		<option value="webapp" <?php autoSelectForm('type','webapp')?>>Web App</option>
		<option value="mobileapp" <?php autoSelectForm('type','mobileapp')?>>Mobile App</option>
	</select>
	<p>Project Manager</p>
	<input type="text" name="project_manager" id="project_manager" maxlength="30" <?php autoFillForm('project_manager'); ?>>
	<p>Frontend</p>
	<input type="text" name="frontend" id="frontend" maxlength="30" <?php autoFillForm('frontend'); ?>>
	<p>Backend</p>
	<input type="text" name="backend" id="backend" maxlength="30" <?php autoFillForm('backend'); ?>>
	<p>Project Description</p>
	<textarea rows="4" cols="50" name="description" maxlength="254" form="projectForm"><?php autoFillDescription('description'); ?></textarea>
	<p>Project Status</p>
	<select id="status" name="status" form="projectForm">
		<option value="active" <?php autoSelectForm('status','active')?>>Active</option>
		<option value="idle" <?php autoSelectForm('status','idle')?>>Idle</option>
		<option value="completed" <?php autoSelectForm('status','completed')?>>Completed</option>
		<option value="inactive" <?php autoSelectForm('status','inactive')?>>Inactive</option>
	</select>
	<p>Project Priority</p>
	<select id="priority" name="priority" form="projectForm">
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