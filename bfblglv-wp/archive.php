<?php 
if(is_post_type_archive(array('sponsors'))):
	get_template_part( 'redirect', 'home' );
else:
	get_header();
	$post_type_object = get_post_type_object( $post_type );
	$post_type_name = $post_type_object->labels->name;
?>
			<section class="main-content archive-page" role="main">
				<?php get_template_part("entry", "archive-header"); ?>

				<div class="archive-list">
					<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
						<?php get_template_part( 'entry' ); ?>
					<?php endwhile; endif; ?>
					<?php get_template_part( 'nav', 'below' ); ?>
				</div><!-- end div.archive-list -->
			</section>
<?php
	get_footer(); 
endif;
?>