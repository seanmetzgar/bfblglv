<?php 
if(is_post_type_archive(array('news','events','sponsors'))):
	get_template_part( 'redirect', 'home' );
else:
	get_header();
?>
			<section class="main-content archive-page" role="main">
				<header class="header archive-header">
					<h1 class="entry-title"><?php 
						if ( is_day() ) { printf( __( 'Daily Archives: %s', 'kudu' ), get_the_time( get_option( 'date_format' ) ) ); }
						elseif ( is_month() ) { printf( __( 'Monthly Archives: %s', 'kudu' ), get_the_time( 'F Y' ) ); }
						elseif ( is_year() ) { printf( __( 'Yearly Archives: %s', 'kudu' ), get_the_time( 'Y' ) ); }
						else { _e( 'Archives', 'kudu' ); }
						?></h1>
				</header>

				<div class="archive-list">
					<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
						<?php get_template_part( 'entry' ); ?>
					<?php endwhile; endif; ?>
				</div><!-- end div.archive-list -->

				<?php get_template_part( 'nav', 'below' ); ?>
			</section>


<?php
	get_footer(); 
endif;
?>