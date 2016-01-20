<?php 
/**
 * @package WordPress
 * @subpackage Buy_Local_GLV
 * @since Buy Local GLV 1.0.0
 */
	$block_output = "";
	$indent = indent(5, false);
	if (have_rows("page_blocks")): while(have_rows("page_blocks")): the_row(); 
		$block_type = get_sub_field("block_type");
		$block_members_only = get_sub_field("members_only");
		$block_members_only = is_bool($block_members_only) ? $block_members_only : false;
		$block_has_link = false;
		$block_has_button = false;
		
		if ($block_type != "image-split") {
			$block_title = get_sub_field("title");
			$block_text = get_sub_field("text");
			$block_has_button = get_sub_field("has_button");
			$block_has_button = is_bool($block_has_button) ? $block_has_button : false;
			$block_button_href = ($block_has_button) ? get_sub_field("button_href") : false;
			$block_button_cta = ($block_has_button) ? get_sub_field("button_cta") : false;
			$block_button_cta_attr = ($block_button_cta) ? esc_attr($block_button_cta) : false;
		}
		

		$block_class = "page-block $block_type";
		switch($block_type) {
			case "image-left":
			case "image-right":
				$block_image_style = get_sub_field("image_style");
				$block_image_link = $block_has_button;
				$block_image = wp_get_attachment_image(get_sub_field("image"), "full");
				$block_image_class = $block_image_style;
				break;
			case "full-width-badge":
				$block_image_link = $block_has_button;
				$block_image = wp_get_attachment_image(get_sub_field("image"), "full");
				$block_image_class = "badge-icon";
				break;
			case "image-split":
				$block_text_left = get_sub_field("text_left");
				$block_text_right = get_sub_field("text_right");
				$block_has_link = get_sub_field("has_link");
				$block_has_link = is_bool($block_has_link) ? $block_has_link : false;
				$block_link_href = ($block_has_link) ? get_sub_field("link_href") : false;
				$block_image = wp_get_attachment_image(get_sub_field("image"), "full");
				$block_image_class = "";
				break;
			case "video":
				$block_video = get_sub_field("video");
				break;
		}

		if (!$block_members_only || ($block_members_only && is_user_logged_in())):
			$block_output .=			"\n";
			$block_output .= 			"$indent<section class=\"$block_class\">\n";
			if ($block_has_link && $block_link_href) {
				$block_output .=		"$indent    <a href=\"$block_link_href\">\n";
			}
			if ($block_type == "image-left" || $block_type == "full-width-badge") {
				$block_output .=		"$indent    <div class=\"image $block_image_class\">\n";
				if ($block_has_button) {
					$block_output .=	"$indent        <a href=\"$block_button_href\" title=\"$block_button_cta_attr\">\n";
				}
				$block_output .=		"$indent        $block_image\n";
				if ($block_has_button) {
					$block_output .=	"$indent        </a>\n";
				}
				$block_output .=		"$indent    </div>\n";
			}

			if ($block_type == "image-split") {
				$block_output .=		"$indent    <div class=\"image\">\n";
				$block_output .=		"$indent        $block_image\n";
				$block_output .=		"$indent    </div>\n";
				$block_output .=		"$indent    <div class=\"content\">\n";
				$block_output .=		"$indent        <h2>\n";
				$block_output .=		"$indent            <span class=\"left-text\"></span>\n";
				$block_output .=		"$indent            <span class=\"right-text\"></span>\n";
				$block_output .=		"$indent        </h2>\n";
				$block_output .=		"$indent    </div>\n";
			} else {
				$block_output .=		"$indent    <div class=\"content\">\n";
				$block_output .=		"$indent        <h2>$block_title</h2>\n";
				$block_output .=		"$indent        $block_text\n";
				if ($block_has_button) {
					$block_output .=	"$indent        <a href=\"$block_button_href\" class=\"btn\" title=\"$block_button_cta_attr\">$block_button_cta</a>\n";
				}
				$block_output .=		"$indent    </div>\n";
			}
			
			if ($block_type == "image-right") {
				$block_output .=		"$indent    <div class=\"image $block_image_class\">\n";
				if ($block_has_button) {
					$block_output .=	"$indent        <a href=\"$block_button_href\" title=\"$block_button_cta_attr\">\n";
				}
				$block_output .=		"$indent        $block_image\n";
				if ($block_has_button) {
					$block_output .=	"$indent        </a>\n";
				}
				$block_output .=		"$indent    </div>\n";
			}

			if ($block_type == "video") {
				$block_output .=		"$indent    <div class=\"video\">\n";
				$block_output .=		"$indent        $block_video\n";
				$block_output .=		"$indent    </div>\n";
			}

			$block_output .=			"$indent</section>\n";
		endif;
	endwhile; endif; 
	echo $block_output;
?>