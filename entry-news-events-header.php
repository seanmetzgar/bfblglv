<?php 
	$parent_id = get_field("ne_child_back_page", "option");
	$has_post_thumbnail = ( has_post_thumbnail($parent_id) );
	$entry_header_class = $has_post_thumbnail ? "page-header has-image" : "page-header";
	$back_button_text = get_field("ne_child_back_text", "option");
	$back_button_text = strlen($back_button_text) > 0 ? $back_button_text : false;
	$back_button_href = get_permalink($parent_id);
	$back_button_href = strlen($back_button_href) > 0 ? $back_button_href : false;
?>
					<header class="<?php echo $entry_header_class; ?>">
						<p class="entry-title"><?php echo get_the_title($parent_id); ?></p>
						<?php if ($has_post_thumbnail) echo get_the_post_thumbnail($parent_id, "full", array("class" => "img-responsive")); ?>
					</header>
					<?php if ($back_button_href && $back_button_text): ?>
					<a href="<?php echo $back_button_href; ?>" class="back-button"><p><?php echo $back_button_text; ?></p></a>
					<?php endif; ?>