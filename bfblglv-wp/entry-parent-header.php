<?php
	$parent_id = $post->post_parent;
	$has_post_thumbnail = ( has_post_thumbnail($parent_id) );
	$entry_header_class = $has_post_thumbnail ? "page-header has-image" : "page-header no-image";

	// newnewnew
	$entry_header_css = '';
	if($has_post_thumbnail) {
		$thumbnail_id = get_post_thumbnail_id($parent_id);
	//	$thumbnail_attrs = wp_get_attachment_metadata($thumbnail_id); // if needed
		$thumbnail_src = wp_get_attachment_image_src($thumbnail_id, 'full');
		$entry_header_css = "style='background-image: url({$thumbnail_src[0]});'";
	} // end the is-there-a-post-thumbnail test

	$bfblPageTitle = get_field("formatted_title", $parent_id);
	$bfblPageTitle = ($bfblPageTitle) ? $bfblPageTitle : str_replace(" ", "<br>", get_the_title($parent_id));

	$back_button_text = get_field("child_back_text", $parent_id);
	$back_button_text = strlen($back_button_text) > 0 ? $back_button_text : false;
	$back_button_href = get_permalink($parent_id);
	$back_button_href = strlen($back_button_href) > 0 ? $back_button_href : false;
?>
					<header class="<?php echo $entry_header_class; ?>" <?php echo $entry_header_css?>>
						<p class="entry-title"><?php echo $bfblPageTitle; ?></p>
						<?php if ($has_post_thumbnail) echo get_the_post_thumbnail($parent_id, "full", array("class" => "img-responsive")); ?>
					</header>

					<?php if ($back_button_href && $back_button_text): ?>
					<a href="<?php echo $back_button_href; ?>" class="back-button parentArrow"><?php echo $back_button_text; ?></a>
					<?php endif; ?>