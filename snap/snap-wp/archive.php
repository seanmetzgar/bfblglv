<?php get_header(); ?>
    <section class="container" role="main">
        <header class="header text-center text-secondary mt-4 mb-3">
            <h1 class="entry-title my-0"><?php
                if ( is_day() ) { printf( __( 'Daily Archives: %s', 'snap-wp' ), get_the_time( get_option( 'date_format' ) ) ); }
                elseif ( is_month() ) { printf( __( 'Monthly Archives: %s', 'snap-wp' ), get_the_time( 'F Y' ) ); }
                elseif ( is_year() ) { printf( __( 'Yearly Archives: %s', 'snap-wp' ), get_the_time( 'Y' ) ); }
                else { _e( 'Archives', 'snap-wp' ); }
                ?></h1>
        </header>
        <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
            <?php get_template_part( 'entry' ); ?>
        <?php endwhile; endif; ?>
        <?php get_template_part( 'nav', 'below' ); ?>
    </section>
<?php get_footer(); ?>