<?php
require_once 'users/init.php';
require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
if(isset($user) && $user->isLoggedIn()){
}
?>
<div id="page-wrapper">
	<div class="container">
		<div class="jumbotron">
			<h1 align="center"><?php echo $settings->site_name;?></h1>
			<p align="center">
				<?php
				if($user->isLoggedIn()){?>
					<?php
						//this is for the user id
						echo $user->data()->id;
					?>
					<?php require_once $abs_us_root . $us_url_root . 'userlanding.php'; ?>
				<?php }else{?>
					<a class="btn btn-warning" href="users/login.php" role="button"><?=lang("SIGNIN_TEXT");?> &raquo;</a>
					<a class="btn btn-info" href="users/join.php" role="button"><?=lang("SIGNUP_TEXT");?> &raquo;</a>
				<?php }?>
			</p>
		</div>
<?php  languageSwitcher();?> 
	</div>
</div>
<?php require_once $abs_us_root . $us_url_root . 'users/includes/html_footer.php'; ?>