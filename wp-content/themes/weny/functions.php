<?php

function remove_menus(){
    if(!current_user_can( 'manage_options' )) {
        remove_menu_page( 'index.php' );                  //Dashboard
        remove_menu_page( 'edit.php' );                   //Posts
        remove_menu_page( 'upload.php' );                 //Media
        remove_menu_page( 'edit.php?post_type=page' );    //Pages
        remove_menu_page( 'edit-comments.php' );          //Comments
        remove_menu_page( 'users.php' );                  //Users
    }
    
    $current_user = wp_get_current_user();
    if($current_user->user_login !== "admin") {
        remove_menu_page( 'themes.php' );                 //Appearance
        remove_menu_page( 'plugins.php' );                //Plugins    
        remove_menu_page( 'tools.php' );                  //Tools
        remove_menu_page( 'options-general.php' );        //Settings
        remove_menu_page( 'pages.php' );                //Pages
    
        remove_menu_page('edit.php?post_type=acf');     //ACF

    }
}
add_action( 'admin_menu', 'remove_menus', 999 );


//https://managewp.com/spotless-wordpress-dashboard
add_action( 'admin_bar_menu', 'wp_admin_bar_my_custom_account_menu', 11 );
 
function wp_admin_bar_my_custom_account_menu( $wp_admin_bar ) {
    $user_id = get_current_user_id();
    $current_user = wp_get_current_user();
    $profile_url = get_edit_profile_url( $user_id );
     
    if ( 0 != $user_id ) {
        /* Add the "My Account" menu */
        $avatar = get_avatar( $user_id, 28 );
        $howdy = sprintf( __('Welcome, %1$s'), $current_user->display_name );
        $class = empty( $avatar ) ? '' : 'with-avatar';
         
        $wp_admin_bar->add_menu( array(
        'id' => 'my-account',
        'parent' => 'top-secondary',
        'title' => $howdy . $avatar,
        'href' => $profile_url,
        'meta' => array(
        'class' => $class,
        ),
        ) ); 
    }
    

    
	$wp_admin_bar->remove_node( 'wp-logo' );
}

function remove_footer_admin () {
    echo "Watch Enthusiasts of New York";
}
 
add_filter('admin_footer_text', 'remove_footer_admin');

function remove_screen_options_tab()
{
    return false;
}
add_filter('screen_options_show_screen', 'remove_screen_options_tab');
 

//https://wordpress.org/support/topic/remove-help-dropdown-from-menu-bar
add_filter( 'contextual_help', 'mycontext_remove_help', 999, 3 );

function mycontext_remove_help($old_help, $screen_id, $screen){
    $screen->remove_help_tabs();
    return $old_help;
}

//http://codex.wordpress.org/Dashboard_Widgets_API
function example_remove_dashboard_widget() {
 	remove_meta_box( 'dashboard_quick_press', 'dashboard', 'side' );
    remove_meta_box( 'dashboard_primary', 'dashboard', 'side' );
    
    remove_meta_box( 'dashboard_browser_nag', 'dashboard', 'normal' );    
    remove_meta_box( 'dashboard_right_now', 'dashboard', 'normal' );
    //
    remove_meta_box( 'dashboard_welcome_panel', 'dashboard', 'normal' );
    remove_action( 'welcome_panel', 'wp_welcome_panel' );

    if(!current_user_can( 'manage_options' )) {
        remove_meta_box( 'dashboard_activity', 'dashboard', 'normal' );
    }
}
 
// Hook into the 'wp_dashboard_setup' action to register our function
add_action('wp_dashboard_setup', 'example_remove_dashboard_widget' );

function remove_core_updates(){
    global $wp_version;return(object) array('last_checked'=> time(),'version_checked'=> $wp_version,);
}
add_filter('pre_site_transient_update_core','remove_core_updates');
add_filter('pre_site_transient_update_plugins','remove_core_updates');
add_filter('pre_site_transient_update_themes','remove_core_updates');

function my_login_logo() { ?>
    <style type="text/css">
        body.login div#login h1 a {
            background-image: url(<?php echo get_stylesheet_directory_uri(); ?>/images/black_logo.png);
            background-size: cover;
            padding-bottom: 30px;
            width: 225px;
            height: auto;
        }
    </style>
<?php }
add_action( 'login_enqueue_scripts', 'my_login_logo' );

/***************end custom admin formatting ************/

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
        array("slug" => "watch", "plural" => "Watches", "singular" => "Watch", "rewrite" => "watches", "public" => true, "archive" => true, "supports" => array('title', 'editor', 'comments'), "taxonomies"=>array())
    );  
    foreach ($post_types as $pt) {
        $supports = array('title', 'editor', 'post_tags', 'thumbnail', 'excerpt', "comments");
        $public = isset($pt['public']) ? $pt['public'] : false;
        register_post_type($pt["slug"], array(
            'labels' => array(
                'name' => $pt["plural"],
                'singular_name' => $pt["singular"]
            ),
            'menu_icon' => "dashicons-clock",
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
/*add_action( 'init', 'create_my_taxonomies', 0 );

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
}*/

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


function title_prefix( $title, $id = null ) {

    $prefix = get_field("type", $id);
    $prefix = !$prefix ? "" : $prefix . ": ";
    $title = strtoupper($prefix) . $title;

    return $title;
}
add_filter( 'the_title', 'title_prefix', 10, 2 );

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
    //                echo "USER VALID";
                    //exit;
                    login_redirect();

                } else {
  //                  echo "USER BUNK";
                    //exit;
                    $statusMsg = $user_data->get_error_message();
                }

            } else {

                $statusMsg = '<b>ERROR:</b> The password you entered for <b>' . $log . '</b> is incorrect.';
            }

        } else {
//echo "BOGUS";
            $statusMsg = '<b>ERROR:</b> Invalid email address.';
        }
    }
}

//Send email to user with password reset link.
function weny_reset_password_email( $user_email, $unresponsive = false ) {

    $user_info = get_user_by( 'email', $user_email );
    $reset_key = wp_generate_password(20);
    update_user_meta( $user_info->ID, 'reset_password', $reset_key );
    $reset_url = site_url() . '/forgot-password?lostpassword=1&email=' . urlencode($user_email) . '&reset_key=' . urlencode($reset_key);


    $subject = '[Watch Enthusiasts of New York] Password Reset';
    $message = '
    <html>
    <head>
      <title>[Watch Enthusiasts of New York] Password Reset</title>
    </head>
    <body>
       <p>Someone requested that the password be reset for the your Watch Enthusiasts of New York account (' . $user_email . '). If this was a mistake, just ignore this email and nothing will happen. To reset your password, <a href="' . $reset_url . '">click here</a>.</p>
    </body>
    </html>
    ';

    $headers  = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

    //$headers .= 'Bcc: updates@prod4ever.com' . "\r\n";
    return wp_mail($user_info->user_email, $subject, $message, $headers);
}
