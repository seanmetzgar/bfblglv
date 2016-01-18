<?php get_header(); ?>
			<section class="main-content" role="main">
				<?php get_template_part("entry", "resources-header"); ?>

				<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
				<?php get_template_part( 'entry' ); ?>
				<?php endwhile; endif; ?>

				<?php get_template_part( 'nav', 'below' ); ?>
			</section>


<?php get_footer(); ?>