<?php 
$block_image = "";
$block_class = array("block-link", "sp-block");
if (has_post_thumbnail()) {
	$block_image = wp_get_attachment_image_url(get_post_thumbnail_id(), "medium");
}

if (!$block_image) {
	$block_class[] = "no-image";
}

$block_link = get_field("link_url");

if ($block_link) {
	$block_link = "href=\"{$block_link}\" target=\"_blank\"";
} else {
	$block_link = "href=\"javascript:void();\"";
}

?>
<article id="post-<?php the_ID(); ?>" <?php post_class($block_class); ?>>
	<a <?php echo $block_link; ?>>
		<?php if ($block_image): ?>
		<figure class="image"><img src="<?php echo $block_image; ?>" alt="<?php the_title_attribute(); ?>"></figure>
		<?php endif; ?>
		<div class="content"><?php the_title(); ?></div>
	</a>
</article>