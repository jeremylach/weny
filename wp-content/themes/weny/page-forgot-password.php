<?php
/* Template Name: Forgot PW */

$display_reset_form = False;

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
                        $statusMsg = '<b>SUCCESS:</b> Pasword successfully updated. <a href="' . get_permalink(get_page_by_title('Home')) . '">Click here</a> to return to the homepage.';

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
                weny_reset_password_email( $_POST['request_email'] );
                $statusClass = 'alert-success';
                $statusMsg = '<b>SUCCESS:</b> A message has been sent to "' . $_POST['request_email'] . '" with a password reset link.';
            } else {
                $statusMsg = '<b>ERROR:</b> Email address "' . $_POST['request_email'] . '" is not associated with an account.';
            }
        }
    }
}

get_header();

get_template_part("content", "logo"); ?>

<div id="copy" class='single row forgot-password'>

    <div class='headline'>Password Reset</div>

<div class='inner'>
<?php 
if( $display_reset_form ) {
?>
    <?php if( isset( $statusMsg ) ) { ?>
        <div class="alert alert-block <?php echo $statusClass; ?>" style="margin-bottom:14px;"><?php echo $statusMsg; ?></div>
        <?php } ?>
    <p>Enter a new password below for "<?php echo $_GET['email']; ?>" below.</p>
    <form method="post" action="/forgot-password?lostpassword=1&email=<?php echo urlencode($_GET['email']); ?>&reset_key=<?php echo urlencode($_GET['reset_key']); ?>">
        <p>
            <input type="password" name="new_pass" id="new_pass" class="input" size="20" placeholder="New Password" />
        </p>
        <p>
            <input type="password" name="new_pass_confirm" id="new_pass_confirm" class="input" size="20" placeholder="Confirm Password" />
        </p>
        <p>
            <input type="submit" name="wp-submit" id="wp-submit" class="button" value="Update Password">
        </p>
    </form>
<?php
}
else { ?>

    
    <?php if( isset( $statusMsg ) ) { ?>
        <div class="alert alert-block <?php echo $statusClass; ?>" style="margin-bottom:14px;"><?php echo $statusMsg; ?></div>
        <?php } ?>
    <p>Enter your email address below to request a password reset.
    <form method="post" action="/forgot-password?lostpassword=1" id='provide_email'>
        <p>
            <input type="text" name="request_email" id="request_email" class="input" size="20" placeholder="Email Address" />
            <div class='validation_message email_error'></div>
        </p>
        <p>
            <input type="submit" name="wp-submit" id="wp-submit" class="button" value="Request Password Reset">
        </p>
    </form>

    <?php } ?>
</div>

</div>
<?php get_footer(); ?>