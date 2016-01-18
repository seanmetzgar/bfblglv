<?php get_header(); ?>
			<section class="main-content" role="main">
				<?php get_template_part("entry", "resources-header"); ?>

				<div class="container-fluid constrained">
					<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
					<?php get_template_part( "entry", "resources-summary" ); ?>
					<?php endwhile; endif; ?>
				</div>

				<?php get_template_part( 'nav', 'below' ); ?>
			</section>


<?php get_footer(); ?>