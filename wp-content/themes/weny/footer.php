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
		<img src='/wp-content/themes/weny/images/black_logo.png' />
		<div id='tagline'>Contact WENY</div>
		<?php gravity_form(2, false, false, false, '', true, 1); ?>
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

  ga('create', '', 'auto');
  ga('send', 'pageview');

	</script>

</body>
</html>