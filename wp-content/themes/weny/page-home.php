<?php get_header(); ?>


<section id="intro" class='content-box row' data-speed="6" data-type="background">
    <div class='arrow down'></div>
    <div class="dark">
        <!--<div class=''> <!-- col-md-8 col-md-offset-2 col-xs-offset-2 col-xs-8-->
            <img src='/wp-content/themes/weny/images/white_logo.png' />
        <!--</div>-->
    </div>
    <div class='arrow up'></div>
</section>

<section id="copy" class='row' data-speed="6" data-type="background">
    <div class='arrow down'></div>
    <div class='inner'>
        <div class='headline'>Our Story</div>
        <div class='columns'>
            <?php the_post(); the_content(); ?>    
        </div>
    </div>
    <div class='arrow up'></div>
</section>

<section id="interact" class='content-box row' data-speed="6" data-type="background">
    <div class='arrow down'></div>
    <div class='dark'>
        <div class='headline'>Membership</div>
        <div class='inner'>
            <div class='copy'>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut dictum tellus quis nulla placerat dignissim. Ut at erat ut mi fringilla lacinia sed eu sem. Curabitur at ipsum at mi dictum sagittis. </div>
            <?php gravity_form(1, false, false, false, '', true, 1); ?>
        </div>
    </div>
</section>


<?php
    while ( have_posts() ) : the_post();

       
    endwhile;
?>
<?php get_footer(); ?>