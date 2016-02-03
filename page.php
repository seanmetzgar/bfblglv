<?php get_header(); ?>
			<section class="main-content" role="main">
				<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					<?php get_template_part("entry", "header"); ?>

					<section class="entry-content">
						<?php the_content(); ?>
					</section>
					<?php get_template_part("bfbl", "page-blocks"); ?>					
				</article>
				<?php endwhile; endif; ?>
			</section>


<?php get_footer(); ?>