<?php
/**
 * Template Name: How it Works
 */
get_header(); ?>
    <section class="container" role="main">
        <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <header class="header text-center text-secondary mt-4 mb-3">
                    <h1 class="entry-title my-0"><?php the_title(); ?></h1>
                    <?php edit_post_link(); ?>
                </header>
                <section class="entry-content">
                    <?php if ( has_post_thumbnail() ) { the_post_thumbnail(); } ?>
                    <?php the_content(); ?>
                    <?php if( have_rows('flowchart_steps') ): ?>
                    <ul class="flowchart">
                        <?php while ( have_rows('flowchart_steps') ) :
                            the_row(); $flowchart_image = get_sub_field('image'); ?>
                        <li class="media">
                            <?php if ($flowchart_image): ?>
                            <img class="mr-3" src="<?php echo $flowchart_image; ?>">
                            <?php else: ?>
                            <img class="mr-3" src="http://via.placeholder.com/100x100">
                            <?php endif; ?>
                            <div class="media-body">
                                <?php the_sub_field('description'); ?>
                            </div>
                        </li>
                        <?php endwhile; ?>
                    </ul>
                    <?php endif; ?>
                    <div class="entry-links"><?php wp_link_pages(); ?></div>
                </section>
            </article>
            <?php if ( ! post_password_required() ) comments_template( '', true ); ?>
        <?php endwhile; endif; ?>
    </section>
<?php get_footer(); ?>