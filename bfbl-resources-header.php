<?php 
	$res_header_image = get_field("res_header_image", "option");
	$res_header_image = is_int($res_header_image) ? wp_get_attachment_image($res_header_image, "full") : false;
	$res_header_title = get_field("res_archive_title", "option");
	$res_header_title = strlen($res_header_title) > 0 ? $res_header_title : "Resources";
	$res_header_back = get_field("res_back_button_text", "option");
	$res_header_back = strlen($res_header_back) > 0 ? $res_header_back : "Back to Resources";

	$entry_header_class = $res_header_image ? "page-header has-image" : "page-header";
	$back_button_text = $res_header_back;
	$back_button_href = get_post_type_archive_link($post_type);
?>
					<header class="<?php echo $entry_header_class; ?>">
						<?php if (is_single()): ?>
						<p class="entry-title"><?php echo $res_header_title; ?></p>
						<?php else: ?>
						<h1 class="entry-title"><?php echo $res_header_title; ?></h1>
						<?php endif; ?>
						<?php if ($res_header_image) echo $res_header_image; ?>
					</header>
					<?php if ($back_button_href && $back_button_text && is_single()): ?>
					<a href="<?php echo $back_button_href; ?>" class="back-button"><p><?php echo $back_button_text; ?></p></a>
					<?php endif; ?>