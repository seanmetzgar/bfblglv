<?php
/**
 * Template Name: Locations
 */
get_header(); ?>
    <section class="container-fluid mt-0 px-0">
        <div class="acf-map-wrap">
            <div class="acf-map results-map"></div>
        </div><!-- end div.acf-map-wrap -->
    </section>
    <section class="container" role="main">
        <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <header class="header text-center text-secondary mt-4 mb-3">
                    <h1 class="entry-title my-0"><?php the_title(); ?></h1>
                    <?php edit_post_link(); ?>
                </header>
                <section class="entry-content">
                    <?php the_content(); ?>
                    <section class="finder-search-results page-block">
                        <div class="results-list list-group list-group-flush"></div><!-- end ul.results-list -->
                    </section>
                </section>
            </article>
            <?php if ( ! post_password_required() ) comments_template( '', true ); ?>
        <?php endwhile; endif; ?>
    </section>
<?php get_footer(); ?>