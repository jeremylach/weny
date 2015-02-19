<?php
    if(!is_user_logged_in()) {
        login_redirect();
    }
?>

<?php get_header(); ?>

<?php get_template_part("content", "logo"); ?>

<div id="copy" class='row listing news-events'>
    <div class='headline'>News and Events</div>
<?php
    echo "<div class=''>";
        if (have_posts()) : while (have_posts()) : the_post();
            echo "<div class='row'>";
                echo "<span class='date'>";
                    echo get_the_date("M d, Y h:i A", $post->ID);
                echo "</span>";
                echo "<a href='".get_permalink()."'>".$post->post_title."</a>";
                echo "-";
            echo "</div>";
        endwhile;
    echo "</div>";
    endif;
?>
</div>
<?php get_footer(); ?>