<?php 
if(is_post_type_archive(array('sponsors'))):
	get_template_part( 'redirect', 'home' );
else:
	get_header();
	$post_type_object = get_post_type_object( $post_type );
	$post_type_name = $post_type_object->labels->name;
?>
			<section class="main-content archive-page" role="main">
				<header class="header page-header no-image">
					<h1 class="entry-title"><?php 
						printf( __( '%s Archives', 'kudu' ), $post_type_name );
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