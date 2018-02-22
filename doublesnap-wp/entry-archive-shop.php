<?php 
$block_image = "";
$block_class = array("block-link", "col-md-3", "col-xs-6");
if (has_post_thumbnail()) {
	$block_image = wp_get_attachment_url( get_post_thumbnail_id($post->ID) );
}

if ($block_image) {
	$block_image = " style=\"background-image: url('{$block_image}');\"";
} else {
	$block_image = "";
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
		<figure class="image"<?php echo $block_image; ?>></figure>
		<div class="content"><?php the_title(); ?></div>
	</a>
</article>