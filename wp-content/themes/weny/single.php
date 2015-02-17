<?php get_header();

   
    if ( have_posts() ) :

    $ctr = 0;
    while ( have_posts() ) : the_post();
?>
        <div class='row first dark'>
            <div class='col-md-6'>
            <?php
                $gallery = get_field("gallery");
                if($gallery) {
                
                    $first_pic = $gallery[0];
                    echo "<div class='carousel-wrap'>";
                        echo "<img src='".$first_pic['sizes']['singleimage']."' alt='".$first_pic['alt']."' class='first-pic' />";
                    echo "</div>";
                    echo "<div class='thumbs'>";
                        $ctr = 0;
                        foreach($gallery as $p) {
                            $active = $ctr === 0 ? "active" : "";
                            echo "<img src='".$p['sizes']['thumbnail']."' data-big-img='".$p['sizes']['singleimage']."' class='thumb thumb-img $active' />";
                            $ctr++;
                        }
                        while ($ctr < 7) {
                            echo "<img src='".get_template_directory_uri()."/images/blank.png' class='thumb' />";
                            $ctr++;
                        }
                    echo "</div>";
                }
            ?>
            </div>
            <div class='col-md-6 info'>
                <?php post_date(); ?>
                <h1><?php the_title(); ?></h1>
                <?php the_content(); ?>
                <?php
                    $price = get_field("price");
                    if($price) {
                        $formatted_price = "$" . number_format($price, 0, ",", ",");
                    } else {
                        $formatted_price = "Inquire for Price";
                    }
                    echo "<div class='link-price'>";
                        echo "<span class='price'>$formatted_price</span>";
                        $buy_link = get_field("buy_link");
                        if($buy_link) {
                            echo "<a href='$buy_link' class='buy-link' target='_blank'>Buy It Here</a>";
                        }
                    echo "</div>";
                ?>
            </div>
        </div>
        <div class='row facts'>
            <div class="col-md-5ths col-xs-12 dark tax">
                <div class='header'>Make</div>
                <?php print_tax_terms($post, "manufacturer"); ?>
            </div>
            <div class="col-md-5ths col-xs-12 dark tax">
                <div class='header'>Model</div>
                <?php print_tax_terms($post, "model"); ?>
            </div>
            <div class="col-md-5ths col-xs-12 dark tax">
                <div class='header'>Year</div>
                <?php print_tax_terms($post, "year-manufactured"); ?>
            </div>
            <div class="col-md-5ths col-xs-12 dark tax">
                <div class='header'>Style</div>
                <?php print_tax_terms($post, "style"); ?>
            </div>
            <div class="col-md-5ths col-xs-12 dark tax">
                <div class='header'>Price</div>
                <?php print_tax_terms($post, "price"); ?>
            </div>
        </div>
    <div class='row related'>
        <?php
            $manufacturers = wp_get_post_terms($post->ID, 'manufacturer', array("fields" => "slugs"));
            //print_r($manufacturers);
            $related_watches = array();
            if($manufacturers) {
                $related_watches = get_posts(array("post_type"=>"watch", "posts_per_page"=>5, 'post__not_in' => array($post->ID), 'tax_query' => array(
                'relation' => 'OR',
                    array(
                        'taxonomy' => 'manufacturer',
                        'terms' => $manufacturers,
                        'field' => 'slug',
                    ))));
            }
            if(count($related_watches) == 0) {
                $related_watches = get_posts(array("post_type"=>"watch", "posts_per_page"=>5, 'post__not_in' => array($post->ID)));
            }
            if($related_watches) {
                echo "<div class='row watch-set'>";
                    foreach($related_watches as $post) {
                        setup_postdata($post);
                        ?>
                        <div class='col-md-5ths col-xs-12 dark watch-box'>
                            <a href='<?php the_permalink(); ?>'>
                                <?php the_post_thumbnail("square300"); ?>
                                <div class='date-title'>
                                    <?php post_date(); ?>
                                    <div class='title-wrapper'>
                                        <h2><?php the_title(); ?></h2>
                                    </div>
                                </div>
                            </a>
                        </div>
                    <?php
                    }
                echo "</div>";
            }
        ?>
    </div>
        
            <?php
    endwhile;
    endif;
?>
<?php get_footer(); ?>