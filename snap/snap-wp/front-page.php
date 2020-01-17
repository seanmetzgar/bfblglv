<?php
/**
 * @package snap-wp
 * @since snap-wp 0.0.1
 */
get_header(); ?>
<div class="d-flex align-items-center jumbotron jumbotron-fluid text-white" style="background-image:url('<?php the_field('header_image'); ?>');">
    <div class="container-fluid text-md-right text-xs-left">
        <div class="row">
            <p class="ml-auto h1 col-lg-6 col-md-8"><?php the_field('header_text'); ?></p>
        </div>
        <div class="row">
            <p class="ml-auto col-lg-6 col-md-8 my-0">
                <a href="#" class="btn btn-secondary btn-lg"><?php the_field('header_button_text'); ?></a>
            </p>
        </div>
    </div>
</div>

<div class="page-section container-fluid">
    <div class="row justify-content-center">
        <div class="col-8 text-center">
            <h2 class="text-primary"><?php the_field('nav_blocks_text'); ?></h2>
        </div>

    </div>
    <ul class="row justify-content-center nav-blocks mb-4">
        <?php for ($nav_blocks_counter = 1; $nav_blocks_counter <= 4; $nav_blocks_counter++): ?>
        <li class="col-lg-2 col-sm-3 col-6">
            <a href="<?php the_field('nav_blocks_url_' . $nav_blocks_counter); ?>">
                <div class="content">
                    <i class="<?php the_field('nav_blocks_icon_' . $nav_blocks_counter); ?>"></i>
                    <span class="text"><?php the_field('nav_blocks_text_' . $nav_blocks_counter); ?></span>
                </div>
            </a>
        </li>
        <?php endfor; ?>
    </ul>
</div>

<?php
// WP_Query arguments
$args = array(
'post_type'              => array( 'testimonials' ),
'posts_per_page'         => '-1',
);

// The Query
$query = new WP_Query( $args );

// The Loop
if ( $query->have_posts() ) {
    $testimonial_count = $query->post_count;
    $testimonial_counter = 0;
?>
<section class="page-section bg-white container-fluid py-4">
    <h2 class="text-center text-secondary"><?php _e("Testimonials"); ?></h2>
    <div id="carouselExampleIndicators" class="testimonials-carousel carousel slide" data-ride="carousel">
        <div class="carousel-inner">
<?php
    while ( $query->have_posts() ) {
        $query->the_post();
?>
            <div class="carousel-item<?php if ($testimonial_counter === 0) echo " active"; ?>">
                <div class="content d-block w-100 text-center">
                    <blockquote class="blockquote">
                        <p class="mb-0"><?php the_field('quote'); ?></p>
                        <footer class="blockquote-footer"><?php the_field('name'); ?></footer>
                    </blockquote>
                </div>
            </div>
<?php
        $testimonial_counter++;
    }
?>
        </div>
        <a class="carousel-control-prev carousel-control" href="#carouselExampleIndicators" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon icon" aria-hidden="true"><i class="ti-angle-left"></i></span>
            <span class="sr-only"><?php _e("Previous"); ?></span>
        </a>
        <a class="carousel-control-next carousel-control" href="#carouselExampleIndicators" role="button" data-slide="next">
            <span class="carousel-control-next-icon icon" aria-hidden="true"><i class="ti-angle-right"></i></span>
            <span class="sr-only"><?php _e("Next"); ?></span>
        </a>
        <ol class="carousel-indicators">
<?php for ($testimonial_counter = 0; $testimonial_counter < $testimonial_count; $testimonial_counter++) { ?>
            <li data-target="#carouselExampleIndicators" data-slide-to="<?php echo $testimonial_counter; ?>"<?php if ($testimonial_counter === 0) echo " class=\"active\""; ?>></li>
<?php } ?>
        </ol>
    </div>
</section>
<?php
}
wp_reset_postdata();
?>

<section class="page-section bg-primary container-fluid text-white">
    <div class="row">
        <figure class="col-md-7 col-12 image-col" style="background-image:url('<?php the_field('callout_image'); ?>');">
            <img src="<?php the_field('callout_image'); ?>">
        </figure>
        <div class="col-md-5 col-12 text-center">
            <h2 class="mt-4"><?php the_field('callout_heading'); ?></h2>
            <p><?php the_field('callout_text'); ?></p>
            <p class="mb-4"><a href="<?php the_field('callout_button_url'); ?>" class="btn btn-lg btn-outline-light"><?php the_field('callout_button_text'); ?></a></p>
        </div>
    </div>
</section>

<section class="page-section bg-secondary container-fluid text-white py-4">
    <div class="row justify-content-center">
        <h2 class="text-center">
            <small><?php _e("Have any questions?"); ?></small>
            <?php _e("Contact Us"); ?>
        </h2>
    </div>
    <?php echo do_shortcode('[contact-form-7 id="6"]'); ?>
</section>

<?php get_footer(); ?>
