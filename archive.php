<?php 
if(is_post_type_archive(array('sponsors'))):
	get_template_part( 'redirect', 'home' );
else:
	get_header();
?>
			<section class="main-content archive-page" role="main">
				<header class="header page-header no-image">
					<h1 class="entry-title"><?php 
						printf( __( '%s Archives', 'kudu' ), $post_type );
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