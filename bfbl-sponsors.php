<?php 
/**
 * @package WordPress
 * @subpackage Buy_Local_GLV
 * @since Buy Local GLV 1.0.0
 */

	$sponsors_args = array(
		"post_type"			=> "sponsors",
		"posts_per_page"	=> -1
	);
	$sponsors_posts = get_posts($sponsors_args);

	$sponsors_count = (is_array($sponsors_posts) && count($sponsors_posts)) ? count($sponsors_posts) : 0;
	if ($sponsors_count > 0): ?>
	<section class="sponsors-list">
		<?php foreach ($sponsors_posts as $post): setup_postdata($post);?>
		<p><?php the_title();?></p>
		<?php endforeach; wp_reset_postdata();?>
	</section>
	<?php endif;