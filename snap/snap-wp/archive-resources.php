<?php get_header(); ?>
    <section class="container" role="main">
        <header class="header text-center text-secondary mt-4 mb-3">
            <h1 class="entry-title my-0">Resources</h1>
        </header>

        <div class="row justify-content-center mb-4">
            <div class="col-lg-5 col-md-6">
                <h5 class="text-center">Community Partners Resources</h5>
                <div class="list-group resource-list mb-3">
                <?php
                    // WP_Query arguments
                    $args = array(
                    'post_type'              => array( 'resources' ),
                    'posts_per_page'         => '-1',
                    'tax_query'              => array(
                    array(
                    'taxonomy'         => 'resource_type',
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
                            $is_external = get_field('external_link');
                            $is_external = is_bool($is_external) ? $is_external : true;
                            $file = get_field('resource_link');

                            if ($is_external && strlen($file)): ?>
                            <a href="<?php echo $file; ?>" class="list-group-item list-group-item-action external" target="_blank">
                                <i class="ti-link"></i>
                                <?php the_title(); ?>
                            </a>
                            <?php elseif (!$is_external && is_array($file)): ?>
                            <a href="<?php echo $file['url']; ?>" class="list-group-item list-group-item-action download" target="_blank">
                                <i class="ti-download"></i>
                                <?php the_title(); ?>
                            </a>
                            <?php endif;
                        }
                    }
                    wp_reset_postdata();
                ?>
                </div>
            </div>
            <div class="col-lg-5 col-md-6">
                <h5 class="text-center">Vendor Resources</h5>
                <div class="list-group resource-list mb-3">
                    <?php
                    // WP_Query arguments
                    $args = array(
                        'post_type'              => array( 'resources' ),
                        'posts_per_page'         => '-1',
                        'tax_query'              => array(
                            array(
                                'taxonomy'         => 'resource_type',
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
                            $file = get_field('resource_link');
                            $file_type = is_array($file) ? "media" : (is_string($file) && strlen($file) > 0) ? "url" : false;

                            if ($file_type === "url"): ?>
                                <a href="<?php echo $file; ?>" class="list-group-item list-group-item-action external" target="_blank">
                                    <i class="ti-link"></i>
                                    <?php the_title(); ?>
                                </a>
                            <?php elseif ($file_type === "media"): ?>
                                <a href="<?php echo $file['url']; ?>" class="list-group-item list-group-item-action download" target="_blank">
                                    <i class="ti-download"></i>
                                    <?php the_title(); ?>
                                </a>
                            <?php endif;
                        }
                    }
                    wp_reset_postdata();
                    ?>
                </div>
            </div>
        </div>
    </section>
<?php get_footer(); ?>