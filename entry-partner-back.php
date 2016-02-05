<?php 
	$parent_id = get_field("flf_parent_page", "option");
	
	$back_button_text = get_field("partner_back_text", "option");
	$back_button_text = strlen($back_button_text) > 0 ? $back_button_text : false;
	
	$back_button_href = get_permalink($parent_id);
	$back_button_href = strlen($back_button_href) > 0 ? $back_button_href : false;

?>
					<?php if ($back_button_href && $back_button_text): ?>
					<a href="<?php echo $back_button_href; ?>" class="back-button parentArrow"><?php echo $back_button_text; ?></a>
					<?php endif; ?>