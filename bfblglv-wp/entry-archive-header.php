<?php 
	
	$archive_header_image_id = get_field("{$post_type}_header_image", "option");
	$archive_header_image = is_int($archive_header_image_id) ? wp_get_attachment_image($archive_header_image_id, "full") : false;
	
	$archive_header_title = get_field("{$post_type}_archive_title", "option");
	$archive_header_title = strlen($archive_header_title) > 0 ? $archive_header_title : "{$post_type_name}";
	
	$entry_header_class = 'page-header {$post_type}-header';
	$entry_header_class .= $archive_header_image ? " has-image" : " no-image";

	$entry_header_css = '';
	if($archive_header_image_id) {
	//	$thumbnail_attrs = wp_get_attachment_metadata($archive_header_image_id); // if needed
		$thumbnail_src = wp_get_attachment_image_src($archive_header_image_id, 'full');
		$entry_header_css = "style='background-image: url({$thumbnail_src[0]});'";
	} // end the is-there-a-post-thumbnail test

	
	
	$archive_header_back = get_field("{$post_type}_back_button_text", "option");
	$archive_header_back = strlen($archive_header_back) > 0 ? $archive_header_back : "All {$post_type_name}";
	
	$back_button_text = $archive_header_back;
	$back_button_href = get_post_type_archive_link($post_type);
	
	
?>
					<header class="<?php echo $entry_header_class; ?>" <?php echo $entry_header_css?>>
						<?php if (is_single()): ?>
						<p class="entry-title"><?php echo $archive_header_title; ?></p>
						<?php else: ?>
						<h1 class="entry-title"><?php echo $archive_header_title; ?></h1>
						<?php endif; ?>
						<?php if ($archive_header_image) echo $archive_header_image; ?>
					</header>
					<?php if ($back_button_href && $back_button_text && is_single()): ?>
					<a href="<?php echo $back_button_href; ?>" class="back-button parentArrow"><?php echo $back_button_text; ?></a>
					<?php endif; ?>