<?php
require_once 'users/init.php';
require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
if(isset($user) && $user->isLoggedIn()){
}
?>
			<!--<h1 align="center">
				<?php //echo $settings->site_name;?>
			</h1>-->
				<?php
				if($user->isLoggedIn()){?>
					<?php require_once $abs_us_root . $us_url_root . 'dashboard.php'; ?>
				<?php }else{
						header("Location: users/login.php");
						exit; 
							}?>

<?php  languageSwitcher();?> 
</div>
<?php require_once $abs_us_root . $us_url_root . 'users/includes/html_footer.php'; ?>