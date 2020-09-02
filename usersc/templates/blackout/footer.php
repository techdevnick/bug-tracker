<?php

if($user->isLoggedIn()){
require_once $abs_us_root . $us_url_root . 'usersc/templates/' . $settings->template . '/container_close.php'; //custom template container

require_once $abs_us_root . $us_url_root . 'users/includes/page_footer.php';

?>

<script>
var $hamburger = $(".hamburger");
$hamburger.on("click", function(e) {
  $hamburger.toggleClass("is-active");
  // Do something else, like open/close menu
});
</script>
<!-- Google Analytics: change UA-XXXXX-X to be your site's ID. -->
<script>
// (function(b,o,i,l,e,r){b.GoogleAnalyticsObject=l;b[l]||(b[l]=
// function(){(b[l].q=b[l].q||[]).push(arguments)});b[l].l=+new Date;
// e=o.createElement(i);r=o.getElementsByTagName(i)[0];
// e.src='//www.google-analytics.com/analytics.js';
// r.parentNode.insertBefore(e,r)}(window,document,'script','ga'));
// ga('create','UA-XXXXX-X','auto');ga('send','pageview');
</script>
<!--<div class="grid-footer">
<p align="center">&copy; <?php //echo date("Y"); ?> <?//=$settings->copyright; ?></p>
</div>-->


	<div class="main-footer">
		<div class="footer-content">
			Bug Tracker by Dominic Nichols (User Management Powered by <a target="_blank" href="https://userspice.com/">Userspice</a>)
		</div>
	</div>
</div>

	<script src="https://unpkg.com/ionicons@5.1.2/dist/ionicons.js"></script>
<?php require_once($abs_us_root.$us_url_root.'users/includes/html_footer.php');

}?>
