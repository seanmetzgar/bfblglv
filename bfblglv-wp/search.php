<?php get_header(); ?>
			<section class="main-content archive-page" role="main">
				<header class="header archive-header">
					<h1 class="entry-title">
						<small>
							<?php _e( 'Search results for:', 'kudu' ); ?>
						</small>
						<?php printf( __( '%s', 'kudu' ), get_search_query() ); ?>
					</h1>
				</header>

				<?php if ( have_posts() ) : ?>
					<div class="archive-list">
						<?php while ( have_posts() ) : the_post(); ?>
							<?php get_template_part( 'entry' ); ?>
						<?php endwhile; ?>
						<?php get_template_part( 'nav', 'below' ); ?>
					</div><!-- end div.archive-list -->
				
				<?php else : ?>
				
				<article id="post-0" class="entry-content post no-results not-found">
					<header class="header">
						<h2 class="entry-title"><?php _e( 'Nothing Found', 'kudu' ); ?></h2>
					</header>

					<p><?php _e( 'Sorry, nothing matched your search. Please try again.', 'kudu' ); ?></p>
					<div class="searchFormWrap resultsPage">
						<?php get_search_form(); ?>
					</div>
				</article>
				<?php endif; ?>
			</section>


<?php get_footer(); ?>