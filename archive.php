<?php get_header(); ?>
			<section class="main-content" role="main">
				<header class="header">
					<h1 class="entry-title"><?php 
						if ( is_day() ) { printf( __( 'Daily Archives: %s', 'kudu' ), get_the_time( get_option( 'date_format' ) ) ); }
						elseif ( is_month() ) { printf( __( 'Monthly Archives: %s', 'kudu' ), get_the_time( 'F Y' ) ); }
						elseif ( is_year() ) { printf( __( 'Yearly Archives: %s', 'kudu' ), get_the_time( 'Y' ) ); }
						else { _e( 'Archives', 'kudu' ); }
						?></h1>
				</header>

				<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
				<?php get_template_part( 'entry' ); ?>
				<?php endwhile; endif; ?>

				<?php get_template_part( 'nav', 'below' ); ?>
			</section>


<?php get_footer(); ?>