<?php
/**
 * @package snap-wp
 * @since snap-wp 0.0.1
 */
get_header(); ?>
<div class="d-flex align-items-center jumbotron jumbotron-fluid text-white" style="background-image:url('http://media.gettyimages.com/photos/friendly-woman-tending-an-organic-vegetable-stall-at-a-farmer-picture-id526709144?s=170667a&w=1007');">
    <div class="container-fluid text-md-right text-xs-left">
        <div class="row">
            <p class="ml-auto h1 col-lg-6 col-md-8">Get Free Fresh and Local Produce with LV Fresh Food Bucks</p>
        </div>
        <div class="row">
            <p class="ml-auto col-lg-6 col-md-8 my-0">
                <a href="#" class="btn btn-secondary btn-lg">Find Locations</a>
            </p>
        </div>
    </div>
</div>

<div class="page-section container-fluid">
    <div class="row justify-content-center">
        <div class="col-8 text-center">
            <h2 class="text-primary">SNAP food dollars helps low-income families eat more fruits &amp; vegetables while supporting American farms and growing the local food economy.</h2>
        </div>

    </div>
    <ul class="row justify-content-center nav-blocks mb-4">
        <li class="col-lg-2 col-sm-3 col-6">
            <a href="#">
                <div class="content">
                    <i class="ti-map-alt"></i>
                    <span class="text">Locations</span>
                </div>
            </a>
        </li>
        <li class="col-lg-2 col-sm-3 col-6">
            <a href="#">
                <div class="content">
                    <i class="ti-info-alt"></i>
                    <span class="text">How it Works</span>
                </div>
            </a>
        </li>
        <li class="col-lg-2 col-sm-3 col-6">
            <a href="#">
                <div class="content">
                    <i class="ti-help-alt"></i>
                    <span class="text">FAQs</span>
                </div>
            </a>
        </li>
        <li class="col-lg-2 col-sm-3 col-6">
            <a href="#">
                <div class="content">
                    <i class="ti-archive"></i>
                    <span class="text">Resources</span>
                </div>
            </a>
        </li>
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
    <h2 class="text-center text-secondary">Testimonials</h2>
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
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next carousel-control" href="#carouselExampleIndicators" role="button" data-slide="next">
            <span class="carousel-control-next-icon icon" aria-hidden="true"><i class="ti-angle-right"></i></span>
            <span class="sr-only">Next</span>
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
        <figure class="col-md-7 col-12 image-col" style="background-image:url('http://media.gettyimages.com/photos/vegetable-stall-in-farmer-market-including-celery-parsnips-and-picture-id931911032?s=170667a&w=1007');">
            <img src="http://media.gettyimages.com/photos/vegetable-stall-in-farmer-market-including-celery-parsnips-and-picture-id931911032?s=170667a&w=1007">
        </figure>
        <div class="col-md-5 col-12 text-center">
            <h2 class="mt-4">History</h2>
            <p>It all started with 5 farmers and a bunch of crops.</p>
            <p class="mb-4"><a href="#" class="btn btn-lg btn-outline-light">Learn More</a></p>
        </div>
    </div>
</section>

<section class="page-section bg-secondary container-fluid text-white py-4">
    <div class="row justify-content-center">
        <h2 class="text-center">
            <small>Have any questions?</small>
            Contact Us
        </h2>
    </div>
    <?php echo do_shortcode('[contact-form-7 id="6"]'); ?>
</section>

<?php get_footer(); ?>