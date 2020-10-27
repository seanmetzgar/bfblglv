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

	$bfblPageTitle = get_field("formatted_title");
	$bfblPageSubtitle = get_field("formatted_subtitle");

	if (get_page_template_slug() === 'page-agritourism-search.php') {
		$bfblPageTitle = get_field("agritourism_header_title");
		$bfblPageSubtitle = get_field("agritourism_header_subtitle");
		$bfblPageTitle = ($bfblPageTitle) ? $bfblPageTitle : get_the_title();
	} else {
		$bfblPageTitle = ($bfblPageTitle) ? $bfblPageTitle : str_replace(" ", "<br>", get_the_title());
	}

?>
					<header class="<?php echo $entry_header_class; ?>" <?php echo $entry_header_css?>>
						<?php if ($bfblPageSubtitle): ?>
						<div class="entry-title">
							<h1 class="title"><?php echo $bfblPageTitle; ?></h1>
							<p class="subtitle"><?php echo $bfblPageSubtitle; ?></p>
						</div>
						<?php else: ?>
						<h1 class="entry-title"><?php echo $bfblPageTitle; ?></h1>
						<?php endif; ?>
						<?php // edit_post_link(); ?>
						<?php if ($has_post_thumbnail) the_post_thumbnail("full", array("class" => "img-responsive")); ?>
					</header>