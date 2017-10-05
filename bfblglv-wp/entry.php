<?php
	$post_class = [];
	if ($post_type === "news" && is_archive()) {
		$post_class[] = "page-block";
		if (has_post_thumbnail()) {
			$post_class[] = "image-right";
		}
	}
?>
<article id="post-<?php the_ID(); ?>" <?php post_class($post_class); ?>>
	<header>
		<?php if ( is_singular() ) { echo '<h1 class="entry-title">'; } else { echo '<h2 class="entry-title">'; } ?><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" rel="bookmark"><?php the_title(); ?></a><?php if ( is_singular() ) { echo '</h1>'; } else { echo '</h2>'; } ?> <?php // edit_post_link(); ?>
		<?php if ( !is_search() ) get_template_part( 'entry', 'meta' ); ?>
	</header>
	<?php get_template_part( 'entry', ( is_archive() || is_search() ? 'summary' : 'content' ) ); ?>
	<?php if ( !is_search() ) get_template_part( 'entry-footer' ); ?>
	<?php if (is_archive() || is_search()):?>
		<p><a href="<?php the_permalink(); ?>" class="read-more">Read More</a></p>
	<?php endif; ?>
	<?php if (is_archive() & has_post_thumbnail()): ?>
		<figure class="post-thumbnail"><a href="<?php the_permalink(); ?>"><?php the_post_thumbnail();?></a></figure>
	<?php endif; ?>
</article>