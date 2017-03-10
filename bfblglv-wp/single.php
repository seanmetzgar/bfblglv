<?php 
if(is_singular(array('sponsors'))):
	get_template_part( 'redirect', 'home' );
else:
	get_header(); ?>
			<section class="main-content" role="main">
				<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
				<?php get_template_part( 'entry' ); ?>
				<?php if ( ! post_password_required() ) comments_template( '', true ); ?>
				<?php endwhile; endif; ?>
				
				<footer class="footer">
					<?php get_template_part( 'nav', 'below-single' ); ?>
				</footer>
			</section>


<?php 
	get_footer();
endif;
?>