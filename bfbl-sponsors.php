<?php
/**
 * @package WordPress
 * @subpackage Buy_Local_GLV
 * @since Buy Local GLV 1.0.0
 */

	$sponsors_posts = new WP_Query(array(
		"post_type"			=> "sponsors",
		"posts_per_page"	=> -1
	));

	if ($sponsors_posts->have_posts()):
?>
		<section class="sponsors-list page-block white">
			<h2>Sponsors</h2>
			<ul>
<?php
		while ($sponsors_posts->have_posts()): $sponsors_posts->the_post();
			$sponsor_id = get_the_ID();
			if (has_post_thumbnail($sponsor_id)):
				$sponsor_img_id = get_post_thumbnail_id($sponsor_id);
				$sponsor_img_src = wp_get_attachment_image_src($sponsor_img_id, "medium");
				$sponsor_img_src = $sponsor_img_src[0];
				$sponsor_name_attr = the_title_attribute(array("echo" => false));
				$sponsor_link = get_field('url', $sponsor_id);
?>
				<li class="sponsor">
			<?php if ($sponsor_link) echo "<a href=\"$sponsor_link\" title=\"$sponsor_name_attr\">"; ?>
					<div class="sponsor-image" style="background-image: url('<?php echo $sponsor_img_src; ?>')">
						<span class="visuallyhidden"><?php the_title(); ?></span>
					</div>
			<?php if ($sponsor_link) echo "</a>"; ?>
				</li>
<?php 	endif; endwhile; ?>
			</ul>
		</section>
<?php endif;
wp_reset_postdata();