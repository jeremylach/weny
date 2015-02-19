		</div><!-- #main -->

		<footer id="colophon" class="site-footer" role="contentinfo">
			<div class="site-info">
				<div class='col-md-8 col-xs-8'>
				&copy; <?php echo date("Y"); ?> Watch Enthusiasts of New York | <a href='#contact' class='fancybox'>Contact Us</a> | Site by <a href='http://iconinteractive.com'>ICON Interactive</a>
			<!-- .site-info -->
				</div>
				<div class='col-md-4'>
					<?php wp_nav_menu(array('theme_location' => 'socialnav', 'menu_class' => 'navbar-nav', 'container' => false, 'items_wrap' => '<ul class="social">%3$s</ul>')); ?>
				</div>
			</div>
		</footer><!-- #colophon -->


	</div><!-- #page -->

	<!--</div>-->

	<?php wp_footer(); ?>
	
	<div id='contact' style='display: none;'>
		<img class='logo' src='/wp-content/themes/weny/images/black_logo.png' />
		<div class='tagline'>Contact WENY</div>
		<?php gravity_form(2, false, false, false, '', true, 1); ?>
	</div>
<?php
	global $statusMsg;
?>
	<div id='login' style='display: none;'>
		<img class='logo' src='/wp-content/themes/weny/images/black_logo.png' />
		<div class='tagline'>Sign in to WENY</div>
		<form name="loginform" id="loginform" method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">

			<?php if($statusMsg) { ?>
			<div class="alert alert-block alert-danger" style="margin-bottom:14px;"><p><?php echo $statusMsg; ?></p></div>
			<?php } ?>

				<input type="text" name="log" id="user_login" class="input" value="" size="20" placeholder="Email Address">
				<div class='validation_message email_error'></div>
				<input type="password" name="pwd" id="user_pass" class="input" value="" size="20" placeholder="Password">
				<div class='validation_message pw_error'></div>

			<!--<p class="login-remember"><label><input name="rememberme" type="checkbox" id="rememberme" value="forever" checked> Remember Me</label></p>-->
			
				<input type="submit" name="wp-submit" id="wp-submit" class="button" value="Sign In">
				<input type="hidden" name="redirect_to" value="/">
			
			<a href="?lostpassword=1" class="forgot-pw">Forgot password?</a>
		</form>
	</div>
	
	<script src="<?php echo get_template_directory_uri(); ?>/js/bootstrap.min.js"></script>
    <!--<script src="<?php echo get_template_directory_uri(); ?>/js/jquery.infinitescroll.js"></script>
    <script src="<?php echo get_template_directory_uri(); ?>/js/behaviors/manual-trigger.js"></script>-->

	<script src="<?php echo get_template_directory_uri(); ?>/js/fancybox/jquery.fancybox.pack.js?v=2.1.5"></script>

    <script src="<?php echo get_template_directory_uri(); ?>/js/weny.js"></script>

	<script>
		(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		})(window,document,'script','//www.google-analytics.com/analytics.js','ga');
	  
		ga('create', 'UA-59935226-1', 'auto');
		ga('send', 'pageview');
	</script>


</body>
</html>