<?php

function theme_setup() {
    register_nav_menu('primary', 'Main Menu');
    register_nav_menu('socialnav', 'Social Menu');
    add_theme_support( 'post-thumbnails' );
    
}
add_action( 'after_setup_theme', 'theme_setup' );

add_filter('show_admin_bar', '__return_false');

function jquery_remove() {
    if (!is_admin()) {
        wp_deregister_script('jquery');                                     // De-Register jQuery
        wp_register_script('jquery', '', '', '', true);                     // Register as 'empty', because we manually insert our script in header.php
    }
}

add_action('init', 'jquery_remove');


add_filter( 'gform_ajax_spinner_url', 'tgm_io_custom_gforms_spinner' );
/**
 * Changes the default Gravity Forms AJAX spinner.
 *
 * @since 1.0.0
 *
 * @param string $src  The default spinner URL.
 * @return string $src The new spinner URL.
 */
function tgm_io_custom_gforms_spinner( $src ) {

    return get_stylesheet_directory_uri() . '/images/321.GIF';
    
}

//Define custom image sizes here
//REFERENCE: https://codex.wordpress.org/Function_Reference/add_image_size
function image_sizes() {
    add_image_size('square300', 300, 300, true);
    add_image_size('bigimage', 0, 450, false);
    add_image_size('singleimage', 505, 505, false);


    ///add_image_size('slider', 1300, 1000, true);
    //add_image_size('magnified', 1300, 1000, false);
    //add_image_size('detail', 600, 500, false);
    //add_image_size('list-grid', 400, 400, false);
}

add_action('init', 'image_sizes', 0);

function custom_post_type_init() {
    $post_types = array(
        array("slug" => "watch", "plural" => "Watches", "singular" => "Watch", "rewrite" => "watches", "public" => true, "archive" => true, "supports" => array('title', 'editor'), "taxonomies"=>array())
    );  
    foreach ($post_types as $pt) {
        $supports = array('title', 'editor', 'post_tags', 'thumbnail', 'excerpt', "comments");
        $public = isset($pt['public']) ? $pt['public'] : false;
        register_post_type($pt["slug"], array(
            'labels' => array(
                'name' => $pt["plural"],
                'singular_name' => $pt["singular"]
            ),
            'show_ui' => true,
            'publicly_queryable' => isset($pt["publicly_queryable"]) ? $pt["publicly_queryable"] : $public,
            'public' => isset($pt['public']) ? $pt['public'] : false,
            'has_archive' => isset($pt['archive']) ? $pt['archive'] : true,
            'rewrite' => array('hierarchical' => true, 'with_front' => true, 'slug' => isset($pt["rewrite"]) ? $pt["rewrite"] : $pt["slug"]),
            'supports' => isset($pt['supports']) ? $pt['supports'] : $supports,
            'taxonomies' => isset($pt['taxonomies']) ? $pt['taxonomies'] : array('post_tag'),
            'hierarchical' => false,
                )
        );
    }
}
add_action('init', 'custom_post_type_init');
add_action( 'init', 'create_my_taxonomies', 0 );

function create_my_taxonomies() {
    $taxonomies = array(
        array("name_tax" => "manufacturer", "related_tax" => "watch", "name" => "Manufacturer", "add_new_item" => "Add New Watch Manufacturer", "new_item_name" => "New Watch Manufacturer", "hierarchical"=>true),
        array("name_tax" => "model", "related_tax" => "watch", "name" => "Model", "add_new_item" => "Add New Watch Model", "new_item_name" => "New Watch Model", "hierarchical"=>false),
        array("name_tax" => "year-manufactured", "related_tax" => "watch", "name" => "Year Manufactured", "add_new_item" => "Add New Year Manufactured", "new_item_name" => "New Year Manufactured", "hierarchical"=>false),
        array("name_tax" => "style", "related_tax" => "watch", "name" => "Style", "add_new_item" => "Add New Watch Style", "new_item_name" => "New Watch Style", "hierarchical"=>false),
        array("name_tax" => "price", "related_tax" => "watch", "name" => "Price Range", "add_new_item" => "Add New Price Range", "new_item_name" => "New Price Range", "hierarchical"=>true)
    );
    foreach ($taxonomies as $tax) {
        register_taxonomy(
            $tax["name_tax"],
            $tax["related_tax"],
            array(
                'labels' => array(
                    'name' => $tax["name"],
                    'add_new_item' => $tax["add_new_item"],
                    'new_item_name' => $tax["new_item_name"]
                ),
                'show_ui' => true,
                'show_tagcloud' => false,
                'hierarchical' => $tax["hierarchical"]
            )
        );
    }
}

/*add_filter( 'post_thumbnail_html', 'gallery_first_image', 20, 5 );
function gallery_first_image( $html, $post_id, $post_thumbnail_id, $size, $attr ) {
    if ( empty( $html ) ) {
        // return you fallback image either from post of default as html img tag.
        $images = get_field("gallery", $post_id);
        if($images) {
            $first = $images[0];
            $html = "<img src='".$first['sizes'][$size]."' />";
        } else {
            $html = "";
        }
    }
    return $html;
}

function post_date($post = 0) {
    $post = get_post($post);

    $date = strtotime($post->post_date);
    $month = date("m", $date);
    $day = date("d", $date);

    echo "<div class='post-date'>";
        echo "<div class='month'>$month</div>";
        echo "<div class='day'>$day</div>";
    echo "</div>";
}

function print_tax_terms($post, $tax) {
    $terms = wp_get_post_terms($post->ID, $tax, array("fields" => "all"));
    if($terms) {
        echo "<div class='terms'>";
            foreach($terms as $t) {
                $url = "/?".$t->taxonomy."=".$t->slug;
                echo "<a href='$url' class='tax-term'>".$t->name."</a>";
            }
        echo "</div>";
    }
}

// Replaces the excerpt "more" text by a link
function new_excerpt_more($more) {
       global $post;
	return "...";
}
add_filter('excerpt_more', 'new_excerpt_more');
*/

// If user is logged in, redirect to the home page.
function login_redirect() {

    if(isset($_GET['redirect_to'])) {
        $redirect_url = urldecode($_GET['redirect_to']);
    } else {
        $redirect_url = site_url();
    }
    
    wp_redirect( $redirect_url, 302 );
    
    //exit;
}

function ajax_login() {
	
    if( isset( $_POST['log'] ) ) {
    
            $incorrect_login = TRUE;
            $log = trim( $_POST['log'] );
            $pwd = trim( $_POST['pwd'] );
    
    
            // Check if email address exists.
            if ( email_exists( $log ) ) {
    
    //	echo "EMAIL EXISTS";
    
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
                        //echo "USER VALID";
                        //exit;
                        //login_redirect();
                        $statusMsg = "success";
    
                    } else {
                        //echo "USER BUNK";
                        //exit;
                        $statusMsg = $user_data->get_error_message();
                    }
                } else {
                    $statusMsg = 'Invalid Password';
                }
            } else {
                $statusMsg = 'Email address not recognized';
            }
        }

    echo $statusMsg;
	wp_die(); // this is required to terminate immediately and return a proper response
}

add_action( 'wp_ajax_login', 'ajax_login' );
add_action( 'wp_ajax_nopriv_login', 'ajax_login' );

function ajax_logout() {
    wp_logout();
    wp_die();
}

add_action( 'wp_ajax_logout', 'ajax_logout' );
add_action( 'wp_ajax_nopriv_logout', 'ajax_logout' );

function process_login() {
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
    
    //	echo "EMAIL EXISTS";
    
    
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
                        //exit;
                        login_redirect();
    
                    } else {
                        echo "USER BUNK";
                        //exit;
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
}
?>