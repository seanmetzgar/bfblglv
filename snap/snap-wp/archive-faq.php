<?php get_header(); ?>
    <section class="container" role="main">
        <header class="header text-center text-secondary mt-4 mb-3">
            <h1 class="entry-title my-0">Frequently Asked Questions</h1>
        </header>
        <?php if ( have_posts() ) : ?>
        <div class="faq-accordion">
            <?php while ( have_posts() ) : the_post(); ?>
            <article class="card">
                <div class="card-header" id="heading-<?php the_ID(); ?>">
                    <a href="#post-<?php the_ID(); ?>" class="collapsed accordion-link" data-toggle="collapse" data-target="#post-<?php the_ID(); ?>" aria-expanded="true" aria-controls="heading-<?php the_ID(); ?>">
                        <h5 class="entry-title">
                            <?php the_title(); ?>
                        </h5>
                    </a>
                </div>
                <div id="post-<?php the_ID(); ?>" class="collapse" aria-labelledby="#heading-<?php the_ID(); ?>" data-parent="#faq-accordion">
                    <div class="card-body">
                        <?php the_content(); ?>
                    </div>
                </div>
            </article>
            <?php endwhile; ?>
        </div>
        <?php endif; ?>
        <?php get_template_part( 'nav', 'below' ); ?>
    </section>
<?php get_footer(); ?>