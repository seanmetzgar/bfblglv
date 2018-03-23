<?php get_header(); ?>
    <section class="container" role="main">
        <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <header class="header text-center text-secondary">
                    <h1 class="entry-title mt-4"><?php the_title(); ?></h1>
                    <?php edit_post_link(); ?>
                </header>
                <section class="entry-content">
                    <?php if ( has_post_thumbnail() ) { the_post_thumbnail(); } ?>
                    <?php the_content(); ?>
                    <div class="entry-links"><?php wp_link_pages(); ?></div>
                </section>
            </article>
            <?php if ( ! post_password_required() ) comments_template( '', true ); ?>
        <?php endwhile; endif; ?>
    </section>
<?php get_footer(); ?>