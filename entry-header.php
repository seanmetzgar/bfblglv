<?php
	$has_post_thumbnail = ( has_post_thumbnail() );
	$entry_header_class = $has_post_thumbnail ? "page-header has-image" : "page-header no-image";

	// newnewnew
	$entry_header_css = '';
	if($has_post_thumbnail) {
		$thumbnail_id = get_post_thumbnail_id();
	//	$thumbnail_attrs = wp_get_attachment_metadata($thumbnail_id); // if needed
		$thumbnail_src = wp_get_attachment_image_src($thumbnail_id, 'full');
		$entry_header_css = "style='background-image: url({$thumbnail_src[0]});'";
	} // end the is-there-a-post-thumbnail test

	$bfblPageTitle = get_the_title();
	$bfblPageTitle = get_field("formatted_title");
	$bfblPageTitle = ($bfblPageTitle) ? $bfblPageTitle : str_replace(" ", "<br>", get_the_title());

?>
					<header class="<?php echo $entry_header_class; ?>" <?php echo $entry_header_css?>>
						<h1 class="entry-title"><?php echo $bfblPageTitle; ?></h1>
						<?php // edit_post_link(); ?>
						<?php if ($has_post_thumbnail) the_post_thumbnail("full", array("class" => "img-responsive")); ?>
					</header>