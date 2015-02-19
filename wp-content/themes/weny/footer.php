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
		<div class='tagline'>Contact WENY</div>
		<?php gravity_form(2, false, false, false, '', true, 1); ?>
	</div>

	<?php

// If user is logged in, redirect to the home page.
function login_redirect() {

    if(isset($_GET['redirect_to'])) {
        $redirect_url = urldecode($_GET['redirect_to']);
    } else {
        $redirect_url = site_url();
    }
    wp_redirect( $redirect_url, 302 );
    exit;
}

$statusMsg = false;

// LOST PASSWORD PROCESSING
if(isset($_GET['lostpassword'])) {

    $display_reset_form = false;
    $statusClass = 'alert-danger';
    if(isset($_GET['email']) && isset($_GET['reset_key'])) {

        // Validate reset key.
        $user_data = get_user_by( 'email', urldecode($_GET['email']) );
        $reset_key_stored = get_user_meta( $user_data->ID, 'reset_password', true );

        // Make sure the reset key is valid.
        if( strlen($reset_key_stored) > 0 && urldecode($_GET['reset_key']) == $reset_key_stored ) {

            // The form is being submitted.
            if(isset($_POST['new_pass']) && isset($_POST['new_pass_confirm'])) {

                // Make sure the password is long enough.
                if(strlen($_POST['new_pass']) >= 7) {

                    // Make sure the passwords match.
                    if($_POST['new_pass'] == $_POST['new_pass_confirm']) {

                        // Change the user's password.
                        wp_set_password( $_POST['new_pass'], $user_data->ID );
                        update_user_meta( $user_data->ID, 'reset_password', '' );
                        $statusClass = 'alert-success';
                        $statusMsg = '<b>SUCCESS:</b> Pasword successfully updated. <a href="' . get_permalink(get_page_by_title('Log In')) . '">Click here</a> to return to the login page.';

                    } else {

                        $display_reset_form = true;
                        $statusMsg = '<b>ERROR:</b> The passwords did not match. Please try again.';
                    }

                } else {

                    $display_reset_form = true;
                    $statusMsg = '<b>ERROR:</b> Passwords must be at least 7 characters in length. Please try again.';
                }

            } else {

                $display_reset_form = true;
            }
        } else {

            $statusMsg = '<b>ERROR:</b> The password reset request is nonexistent or has expired. Feel free to submit a new reset request below.';
        }

    } else {

        // A password reset is being requested.
        if( isset( $_POST['request_email'] ) ) {
            // Make sure the email exists.
            if( email_exists( $_POST['request_email'] ) ) {
                // Send password reset email.
                wiwh_reset_password_email( $_POST['request_email'] );
                $statusClass = 'alert-success';
                $statusMsg = '<b>SUCCESS:</b> A message has been sent to "' . $_POST['request_email'] . '" with a password reset link.';
            } else {
                $statusMsg = '<b>ERROR:</b> Email address "' . $_POST['request_email'] . '" is not associated with an account.';
            }
        }
    }

// JOIN / LOGIN PROCESSING
} else {
    // If this page is receiving post data
    // means that someone has submitted the login form.

    if( isset( $_POST['log'] ) ) {

        $incorrect_login = TRUE;
        $log = trim( $_POST['log'] );
        $pwd = trim( $_POST['pwd'] );


        // Check if email address exists.
        if ( email_exists( $log ) ) {

	echo "EMAIL EXISTS";


            // Read user data
            $user_data = get_user_by( 'email', $log );

            // Create the wp hasher to add some salt to the md5 hash.
            require_once( ABSPATH.'/wp-includes/class-phpass.php' );
            $wp_hasher = new PasswordHash( 8, TRUE );
            // Check that provided password is correct.
            $check_pwd = $wp_hasher->CheckPassword( $pwd, $user_data->user_pass );

            // If password is correct, use Wordpress to sign in.
            if( $check_pwd ) {

                $credentials = array();
                // Get login using email.
                $credentials['user_login'] = $user_data->user_login;
                $credentials['user_password'] = $pwd;
                $credentials['remember'] = true;
                $user_data = wp_signon( $credentials, false );

                // Redirect to the home page.
                if( ! is_wp_error( $user_data ) ) {
					echo "USER VALID";
					exit;
                    login_redirect();

                } else {
					echo "USER BUNK";
					exit;
                    $statusMsg = $user_data->get_error_message();
                }

            } else {

                $statusMsg = '<b>ERROR:</b> The password you entered for <b>' . $log . '</b> is incorrect.';
            }

        } else {
echo "BOGUS";
            $statusMsg = '<b>ERROR:</b> Invalid email address.';
        }
    }
}


	?>	
	<div id='login' style='display: none;'>
		<img src='/wp-content/themes/weny/images/black_logo.png' />
		<div class='tagline'>Sign in to WENY</div>
		<form name="loginform" id="loginform" method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">

			<?php if($statusMsg) { ?>
			<div class="alert alert-block alert-danger" style="margin-bottom:14px;"><p><?php echo $statusMsg; ?></p></div>
			<?php } ?>

				<input type="text" name="log" id="user_login" class="input" value="" size="20" placeholder="Email Address">
			
				<input type="password" name="pwd" id="user_pass" class="input" value="" size="20" placeholder="Password">
			
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