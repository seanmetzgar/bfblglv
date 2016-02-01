<?php get_header(); ?>
			<section class="main-content" role="main">
				<?php get_template_part("entry", "resources-header"); ?>
				
				<div class="resourcesContainer">
					<div class="resourcesList">
						<?php 
							if ( have_posts() ) : while ( have_posts() ) : the_post();
								get_template_part( "entry", "resources-summary" );
							endwhile; endif; 
						?>
					</div><!-- end div.resourcesList -->
				</div><!-- end div.resourcesContainer -->
				
				<?php get_template_part( 'nav', 'below' ); ?>
			</section>


<?php get_footer(); ?>