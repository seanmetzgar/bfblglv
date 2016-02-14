<?php get_header(); ?>
			<section class="main-content" role="main">
				<?php get_template_part("entry", "resources-header"); ?>
				
				<div class="resourcesContainer">
					<div class="resourcesList">
						<!-- <?php 
							if ( have_posts() ) : while ( have_posts() ) : the_post();
								get_template_part( "entry", "resources-summary" );
							endwhile; endif; 
						?> -->
						<?php $communityResourcesQuery = new WP_Query( array (
							'post_type'              => array( 'resources' ),
							'tag'                    => 'community',
							'nopaging'               => false,
							'posts_per_page'         => '-1',
							'order'                  => 'ASC',
							'orderby'                => 'title',
						));
						$publicationsResourcesQuery = new WP_Query( array (
							'post_type'              => array( 'resources' ),
							'tag'                    => 'reports',
							'nopaging'               => false,
							'posts_per_page'         => '-1',
							'order'                  => 'ASC',
							'orderby'                => 'title',
						));
						if ($communityResourcesQuery->have_posts()): 
							echo "<h2>Find Locally Grown Foods</h2>";
							while ($communityResourcesQuery->have_posts): $communityResourcesQuery->the_post();
								get_template_part( "entry", "resources-summary" );
							endwhile;
						endif;
						if ($publicationsResourcesQuery->have_posts()): 
							echo "<h2>Publications</h2>";
							while ($publicationsResourcesQuery->have_posts): $publicationsResourcesQuery->the_post();
								get_template_part( "entry", "resources-summary" );
							endwhile;
						endif;
						?>

					</div><!-- end div.resourcesList -->
				</div><!-- end div.resourcesContainer -->
				
				<?php get_template_part( 'nav', 'below' ); ?>
			</section>


<?php get_footer(); ?>