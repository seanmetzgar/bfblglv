<?php get_header(); ?>
			<section class="main-content" role="main">
			
				<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
				<?php get_template_part( 'entry' ); ?>
				<?php comments_template(); ?>
				<?php endwhile; endif; ?>

				<?php get_template_part( 'nav', 'below' ); ?>
			</section>


<?php get_footer(); ?>