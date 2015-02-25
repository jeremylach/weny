<?php get_header(); ?>

<?php get_template_part("content", "logo"); ?>

<div id="copy" class='row news-events single'>
    <div class='headline'>News and Events</div>

<?php
    if ( have_posts() ) :
    while ( have_posts() ) : the_post();
?>
        <span class='date'>
            <?php echo get_the_date("M d, Y h:i A", $post->ID); ?>
        </span>
        <h1><?php the_title(); ?></h1>
        <?php the_content(); ?>
    
<?php
    endwhile;
    endif;
?>
</div>

<?php //comments_template(); ?>
<?php get_footer(); ?>