<?php get_header(); ?>
			<section class="main-content" role="main">
				<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					<?php get_template_part("entry", "header"); ?>

					<section class="entry-content">
						<?php the_content(); ?>
						<div class="entry-links"><?php wp_link_pages(); ?></div>
					</section>
				</article>
				
				<?php if ( ! post_password_required() ) comments_template( '', true ); ?>
				<?php endwhile; endif; ?>
			</section>


<?php get_footer(); ?>