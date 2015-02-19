<?php
    if(!is_user_logged_in()) {
        login_redirect();
    }
?>

<?php get_header(); ?>

<?php get_template_part("content", "logo"); ?>

<div id="copy" class='row forum'>
    <div class='headline'>Forum</div>
<?php
    echo "<ul class=''>";
        if (have_posts()) : while (have_posts()) : the_post();
            echo "<li>";
                echo "<a href='".get_permalink()."'>".$post->post_title."</a> - ";
                echo "<span class='author'>".get_the_author_meta("user_email")."</span> - ";
                echo "<span class='date'>";
                    echo get_the_date("M d, Y h:i A", $post->ID);
                echo "</span>";
            echo "</li>";
        endwhile;
    echo "</ul>";
    endif;
?>
</div>
<?php get_footer(); ?>