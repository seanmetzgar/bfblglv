<?php if ($post_type === "eat" || $post_type === "shop" || $post_type === "sponsors") header("Location: /{$post_type}");
get_header(); ?>
			<section class="main-content" role="main">
				<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
				<?php get_template_part( "entry" ); ?>
				<?php if ( ! post_password_required() ) comments_template( '', true ); ?>
				<?php endwhile; endif; ?>
			</section>
<?php get_footer(); ?>