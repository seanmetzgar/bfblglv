<?php get_header(); ?>
    <section class="container" role="main">
        <header class="header text-center text-secondary mt-4 mb-3">
            <h1 class="entry-title my-0">Resources</h1>
        </header>

        <div class="row justify-content-center mb-4">
            <div class="col-lg-5 col-md-6">
                <h4 class="text-center">Community Partners Resources</h4>
                <div class="list-group">
                <?php
                    // WP_Query arguments
                    $args = array(
                    'post_type'              => array( 'resources' ),
                    'posts_per_page'         => '-1',
                    'tax_query'              => array(
                    array(
                    'taxonomy'         => 'sponsor_type',
                    'terms'            => 'community-partners',
                    'field'            => 'slug',
                    ),
                    ),
                    );

                    // The Query
                    $query = new WP_Query( $args );

                    // The Loop
                    if ( $query->have_posts() ) {
                        while ( $query->have_posts() ) {
                            $query->the_post(); ?>
                            <a href="<?php the_permalink(); ?>" class="list-group-item list-group-item-action"><?php the_title(); ?></a>
                        <?php }
                    }
                    wp_reset_postdata();
                ?>
                </div>
            </div>
            <div class="col-lg-5 col-md-6">
                <h4 class="text-center">Vendor Resources</h4>
                <div class="list-group">
                    <?php
                    // WP_Query arguments
                    $args = array(
                        'post_type'              => array( 'resources' ),
                        'posts_per_page'         => '-1',
                        'tax_query'              => array(
                            array(
                                'taxonomy'         => 'sponsor_type',
                                'terms'            => 'vendors',
                                'field'            => 'slug',
                            ),
                        ),
                    );

                    // The Query
                    $query = new WP_Query( $args );

                    // The Loop
                    if ( $query->have_posts() ) {
                        while ( $query->have_posts() ) {
                            $query->the_post(); ?>
                            <a href="<?php the_permalink(); ?>" class="list-group-item list-group-item-action"><?php the_title(); ?></a>
                        <?php }
                    }
                    wp_reset_postdata();
                    ?>
                </div>
            </div>
        </div>
    </section>
<?php get_footer(); ?>