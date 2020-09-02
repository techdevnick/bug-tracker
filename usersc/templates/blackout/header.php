<?php require_once($abs_us_root.$us_url_root.'users/includes/template/header1_must_include.php'); ?>

<!-- Bootstrap 3 Glyphicons for Compatibility Reasons -->
<?php require_once($abs_us_root.$us_url_root.'usersc/templates/'.$settings->template.'/assets/fonts/glyphicons.php'); ?>

<!-- Table Sorting and Such -->
<link href="<?=$us_url_root?>users/css/datatables.css" rel="stylesheet">

<!-- Custom Fonts/Animation/Styling-->
<link rel="stylesheet" href="<?=$us_url_root?>users/fonts/css/font-awesome.min.css">

<!--<link href="https://fonts.googleapis.com/css2?family=Titillium+Web:ital,wght@0,200;0,300;0,400;0,600;0,700;0,900;1,200;1,300;1,400;1,600;1,700&display=swap" rel="stylesheet">
<style media="screen">
body {

font-family: 'Titillium Web', sans-serif !important;

}
</style>-->
<link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,600;0,700;0,800;1,300;1,400;1,600;1,700;1,800&display=swap" rel="stylesheet">
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>) -->
<script src="<?=$us_url_root?>usersc/templates/<?=$settings->template?>/assets/js/jquery-3.5.1.js" type="text/javascript"></script>
<link href="<?=$us_url_root?>usersc/templates/<?=$settings->template?>/assets/css/bugtracker.css" rel="stylesheet">
<?php
//optional
if(file_exists($abs_us_root.$us_url_root.'usersc/templates/'.$settings->template.'.css')){?> <link href="<?=$us_url_root?>usersc/templates/<?=$settings->template?>.css" rel="stylesheet"> <?php } ?>

</head>
<?php require_once($abs_us_root.$us_url_root.'users/includes/template/header3_must_include.php'); ?>
