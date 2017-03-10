<?php 
$block_image = "";
$block_class = array("block-link", "col-md-3", "col-xs-6");
$block_image = get_field("block_image");
if (!$block_image && has_post_thumbnail()) {
	$block_image = wp_get_attachment_url( get_post_thumbnail_id($post->ID) );
}

if ($block_image) {
	$block_image = " style=\"background-image: url('{$block_image}');\"";
} else {
	$block_image = "";
	$block_class[] = "no-image";
}

$block_name = get_field("block_name");
$block_name = $block_name ? $block_name : get_the_title(); ?>
<article id="post-<?php the_ID(); ?>" <?php post_class($block_class); ?>>
	<a href="<?php the_permalink(); ?>">
		<figure class="image"<?php echo $block_image; ?>></figure>
		<div class="content"><?php echo $block_name; ?></div>
	</a>
</article>