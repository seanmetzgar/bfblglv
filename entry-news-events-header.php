<?php 
	$parent_id = $post->post_parent;
	$header_image = get_field("ne_child_header_image", "option");
	$header_image = is_int($header_image) ? wp_get_attachment_image($header_image, "full", array("class" => "img-responsive")) : false;
	$entry_header_class = $header_image ? "page-header has-image" : "page-header";
	$back_button_text = get_field("ne_child_back_text", "option");
	$back_button_text = strlen($back_button_text) > 0 ? $back_button_text : false;
	$back_button_href = get_field("ne_child_back_page", "option");
	$back_button_href = strlen($back_button_href) > 0 ? $back_button_page : false;
?>
					<header class="<?php echo $entry_header_class; ?>">
						<p class="entry-title"><?php echo get_the_title($parent_id); ?></p>
						<?php if ($header_image) echo $header_image; ?>
					</header>
					<?php if ($back_button_href && $back_button_text): ?>
					<a href="<?php echo $back_button_href; ?>" class="back-button"><p><?php echo $back_button_text; ?></p></a>
					<?php endif; ?>