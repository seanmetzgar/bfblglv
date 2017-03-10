<?php
	$parent_id = get_field("flf_parent_page", "option");
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
?>
					<header class="<?php echo $entry_header_class; ?>" <?php echo $entry_header_css?>>
						<p class="entry-title"><?php echo $bfblPageTitle; ?></p>
						<?php if ($has_post_thumbnail) echo get_the_post_thumbnail($parent_id, "full", array("class" => "img-responsive")); ?>
					</header>