<?php get_header(); ?>

<?php get_template_part("content", "logo"); ?>

<div id="copy" class='row forum'>
    <div class='arrow down'></div>
    <div class='headline'>Forum</div>
    <a href='/wp-admin/post-new.php?post_type=watch' class='button'>Add Post</a>
<?php
    echo "<ul class=''>";
        if (have_posts()) : while (have_posts()) : the_post();
            echo "<li>";
                echo "<a href='".get_permalink()."'>";
                    the_title();
                echo "</a> - ";
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