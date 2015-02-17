<!DOCTYPE html>
<!--[if IE 7]>
<html class="ie ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) | !(IE 8)  ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width">
	<title><?php echo bloginfo("name"); wp_title( '|', true, 'left' ); ?></title>
	    
    <link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/css/bootstrap.css" media="screen" />
    <link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/css/bootstrap-theme.css" media="screen" />
    <link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/style.css" media="screen" />
	<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/js/fancybox/jquery.fancybox.css?v=2.1.5" type="text/css" media="screen" />
	
	<?php wp_head(); ?>

	<?php
		if (is_user_logged_in()) {
			$loggedout = "hidden";
			$loggedin = "";
		} else {
			$loggedout = "";
			$loggedin = "hidden";
		}
	?>
</head>

<body <?php body_class(); ?>>
	
	<div class='topnav'>
		<div class='logged-out <?php echo $loggedout; ?>'>
			<div class='button'>News & Upcoming Events</div>
			<div class='button'>Forum</div>
			<div class='button'>Member Login</div>
		</div>
		
		<div class='logged-in <?php echo $loggedin; ?>' >
			<div class='button'>News & Upcoming Events</div>
			<div class='button'>Forum</div>
			<div class='button'>Logout</div>
		</div>
		
	</div>
	<!--<div id="socialnav" class="">
		<?php wp_nav_menu(array('theme_location' => 'socialnav', 'menu_class' => 'navbar-nav', 'container' => false, 'items_wrap' => '<ul class="social">%3$s</ul>')); ?>
	</div>--><!-- #navbar -->

		<div id="main" class="site-main container-fluid" data-type="background"> <!--container-fluid-->
		