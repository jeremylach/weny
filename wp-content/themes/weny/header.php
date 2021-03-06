<?php
    if(!is_page("forgot-password") && !is_front_page() && !is_user_logged_in()) {
        login_redirect();
    }
?>

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
	<link rel="icon" type="image/png" href="<?php echo get_template_directory_uri(); ?>/images/favicon.png" />
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>

	<?php
		gravity_form_enqueue_scripts( 1, true );
		gravity_form_enqueue_scripts( 2, true );
	?>

	<?php wp_head(); ?>

	<?php
		if (is_user_logged_in()) {
			$loggedout = "hidden";
			$loggedin = "";
			$authorid = get_current_user_id();
		} else {
			$loggedout = "";
			$loggedin = "hidden";
			$authorid = "";
		}
	?>
</head>

<body <?php body_class(); ?>>
	
	<div class='topnav'>
		<div class='logged-out <?php echo $loggedout; ?>'>
			<a class='button fancybox' href='#login'>Member Login</a>
		</div>
		
		<div class='logged-in <?php echo $loggedin; ?>' >
			<a class='button' href='/news-events'>News & Upcoming Events</a>
			<a class='button' href='/watches'>Forum</a>
			<a class='button' href='/wp-admin/edit.php?post_type=watch&author=<?php echo $authorid; ?>'>My Posts</a>
			<a class='button' id="logout" href='#' class='button'>Logout</a>
		</div>
	</div>
	<!--<div id="socialnav" class="">
		<?php wp_nav_menu(array('theme_location' => 'socialnav', 'menu_class' => 'navbar-nav', 'container' => false, 'items_wrap' => '<ul class="social">%3$s</ul>')); ?>
	</div>--><!-- #navbar -->

		<div id="main" class="site-main container-fluid" data-type="background"> <!--container-fluid-->
		