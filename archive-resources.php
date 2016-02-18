<?php get_header(); ?>
			<section class="main-content" role="main">
				<?php get_template_part("entry", "resources-header");

					$findResourcesQuery = new WP_Query( array (
						'post_type'              => array( 'resources' ),
						'tax_query' => array(
							array(
								'taxonomy' => 'resource_type',
								'field'    => 'slug',
								'terms'    => 'find-locally-grown-foods'
							)
						),
						'posts_per_page'         => -1,
						'order'                  => 'ASC',
						'orderby'                => 'title'
					));
					$publicationsResourcesQuery = new WP_Query( array (
						'post_type'              => array( 'resources' ),
						'tax_query' => array(
							array(
								'taxonomy' => 'resource_type',
								'field'    => 'slug',
								'terms'    => 'publications'
							)
						),
						'posts_per_page'         => -1,
						'order'                  => 'ASC',
						'orderby'                => 'title'
					));
				?>

				<div class="resources-container">
					<div class="resources-list row">
						<div class="col-sm-6 resource-category-list">
							<?php  if ($findResourcesQuery->have_posts()):
								echo "<h2>Find Locally<br>Grown Foods</h2>\n";
								echo "<div class=\"resourcesList\">\n";
								while ($findResourcesQuery->have_posts()): $findResourcesQuery->the_post();
									get_template_part( "entry", "resources-summary" );
								endwhile;
								echo "</div>\n";
							endif; ?>
						</div>

						<div class="col-sm-6 resource-category-list">
							<?php if ($publicationsResourcesQuery->have_posts()):
								echo "<h2>Our<br>Publications</h2>";
								echo "<div class=\"resourcesList\">\n";
								while ($publicationsResourcesQuery->have_posts()): $publicationsResourcesQuery->the_post();
									get_template_part( "entry", "resources-summary" );
								endwhile;
								echo "</div>\n";
							endif; ?>
						</div>
					</div>
				</div><!-- end div.resourcesContainer -->

				<?php get_template_part( 'nav', 'below' ); ?>
			</section>


<?php get_footer(); ?>