<?php get_header(); ?>
    <section class="container" role="main">
        <header class="header text-center text-secondary mt-4 mb-3">
            <h1 class="entry-title my-0">Resources</h1>
        </header>

        <div class="row justify-content-center">
            <div class="col-md-5 col-sm-6">
                <h2>Community Partners Resources</h2>
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
                            $query->the_post();
                            get_template_part( 'entry', $post_type);
                        }
                    }
                    wp_reset_postdata();
                ?>
            </div>
            <div class="col-md-5 col-sm-6">
                <h2>Vendor Resources</h2>
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
                        $query->the_post();
                        get_template_part( 'entry', $post_type);
                    }
                }
                wp_reset_postdata();
                ?>
            </div>
        </div>
    </section>
<?php get_footer(); ?>