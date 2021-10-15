<!doctype html>

<!--[if lt IE 7]><html <?php language_attributes(); ?> class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if (IE 7)&!(IEMobile)]><html <?php language_attributes(); ?> class="no-js lt-ie9 lt-ie8"><![endif]-->
<!--[if (IE 8)&!(IEMobile)]><html <?php language_attributes(); ?> class="no-js lt-ie9"><![endif]-->
<!--[if gt IE 8]><!--> <html <?php language_attributes(); ?> class="no-js"><!--<![endif]-->

	<head>
		<meta charset="utf-8">

		<title><?php wp_title(''); ?></title>

		<!-- Google Chrome Frame for IE -->
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

		<!-- Mobile Meta -->
		<meta name="HandheldFriendly" content="True">
		<meta name="MobileOptimized" content="320">
		<meta name="viewport" content="width=device-width, initial-scale=1.0"/>

	  	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">
	    
	    <!-- Bootstrap CSS -->
	    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">

		<link href="<?php echo get_stylesheet_directory_uri() . '/library/css/bootstrap-datetimepicker.min.css'?>" rel="stylesheet">
	    
	    <!-- Font Awesome -->
	    <script src="https://kit.fontawesome.com/0fa7312826.js" crossorigin="anonymous"></script>
    
		<!-- wordpress head functions -->
		<?php wp_head(); ?>
		<!-- end of wordpress head -->

		<!-- Google Analytics-->
		<!-- end analytics -->
		
		<!-- Fallback for AOS in case of disabled JS -->
		<noscript>
	        <style type="text/css">
	            [data-aos] {
	                opacity: 1 !important;
	                transform: translate(0) scale(1) !important;
	            }
	        </style>
	    </noscript>

		<script type="text/javascript">
			var wp_admin_url = '<?php echo admin_url('admin-ajax.php')?>';
		</script>
	</head>

	<body <?php body_class(); ?>>
  	
	<div class="page-content-container">
		<div class="page-header">
			<a class="page-header-logo" href="<?php echo home_url(); ?>">
				<img class="page-header-logo__img" src="<?php echo get_template_directory_uri()?>/library/images/rrid-logo.jpg" alt="Logo Image">
			</a>
			<div class="page-header-nav">
				<a class="page-header-nav-link" href="#">Activate ID</a>
				<a class="page-header-nav-link" href="#">Purchase</a>
				<a class="page-header-nav-link" href="#">My Account</a>
				<a class="page-header-nav-link" href="#">FAQ</a>
			</div>
		</div>
		<div class="page-content">

		

    