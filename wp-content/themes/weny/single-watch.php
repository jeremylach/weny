<?php get_header(); ?>

<?php get_template_part("content", "logo"); ?>

<div id="copy" class='row forum single'>
    <div class='headline'>Forum</div>

<?php
    if ( have_posts() ) :
    while ( have_posts() ) : the_post();
?>
        <span class='author'> <?php echo get_the_author_meta("user_email"); ?> </span> - 
        <span class='date'>
            <?php echo get_the_date("M d, Y h:i A", $post->ID); ?>
        </span>
        <h1>
            <?php the_title(); ?>
        </h1>
        <?php the_content(); ?>

        <?php
            $gallery = get_field("photos");
            if($gallery) {
                foreach ($gallery as $p) {
                    echo "<a href='".$p['url']."' class='fancybox' rel='gallery'>";
                        echo "<img src='".$p['sizes']['medium']."' />";
                    echo "</a>";
                }
            }

            comments_template();
        ?>
<?php   
    endwhile;
    endif;
?>
</div>    
<?php get_footer(); ?>