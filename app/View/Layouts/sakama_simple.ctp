<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title><?php echo $this->fetch('title'); ?></title>
	<!-- end: Meta -->
	
	<!-- start: Mobile Specific -->
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- end: Mobile Specific -->
	<base href="<?php echo BASE_URL ?>">

	<!-- start: CSS -->
	<link href="assets/css/bootstrap.min.css" rel="stylesheet">
	<link href="assets/css/retina.min.css" rel="stylesheet">
	<link href="assets/css/jquery-ui-1.10.3.custom.css" rel="stylesheet">
	<link href="assets/css/font-awesome.min.css" rel="stylesheet">
 	<link href="assets/css/halflings.css" rel="stylesheet">
	<link href="assets/css/social.css" rel="stylesheet">
	<link href="http://fonts.googleapis.com/css?family=Lato:300" rel="stylesheet">
	<link href="http://fonts.googleapis.com/css?family=Lato:400" rel="stylesheet">
	<link href="http://fonts.googleapis.com/css?family=Kaushan+Script" rel="stylesheet">
	<link href="assets/css/style.min.css" rel="stylesheet">
	<link href="assets/css/customs.css" rel="stylesheet">
	<!-- end: CSS -->
	
	<!-- The HTML5 shim, for IE6-8 support of HTML5 elements -->
	<!--[if lt IE 9]>
	  	<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<script src="assets/js/respond.min.js"></script>
		<script src="assets/css/ie6-8.css"></script>
	<![endif]-->
	
	<!-- start: Favicon and Touch Icons -->
	<link rel="apple-touch-icon-precomposed" sizes="144x144" href="assets/ico/apple-touch-icon-144-precomposed.png">
	<link rel="apple-touch-icon-precomposed" sizes="114x114" href="assets/ico/apple-touch-icon-114-precomposed.png">
	<link rel="apple-touch-icon-precomposed" sizes="72x72" href="assets/ico/apple-touch-icon-72-precomposed.png">
	<link rel="apple-touch-icon-precomposed" sizes="57x57" href="assets/ico/apple-touch-icon-57-precomposed.png">
	<link rel="shortcut icon" href="assets/ico/favicon.png">
	<!-- end: Favicon and Touch Icons -->	

	<?php
		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
	?>
	<script src="assets/js/jquery-1.11.1.min.js"></script>
	<script src="assets/js/customs.js"></script>
</head>

<body>
	<div class="container">
		<?php echo $this->fetch('content'); ?>
	</div><!--/container-->
	
	<div class="clearfix"></div>
	
	<?php echo $this->element("admin_footer"); ?>
</body>
</html>