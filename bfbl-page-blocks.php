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
		$block_color = get_sub_field("block_color");
		$block_color = (strlen($block_color) > 0) ? $block_color : "";
		
		$block_icon = '';
		
		
		if ($block_type != "image-split") {
			$block_title = get_sub_field("title");
			$block_text = get_sub_field("text");
			$block_has_button = get_sub_field("has_button");
			$block_has_button = is_bool($block_has_button) ? $block_has_button : false;
			$block_button_href = ($block_has_button) ? get_sub_field("button_href") : false;
			$block_button_cta = ($block_has_button) ? get_sub_field("button_cta") : false;
			$block_button_cta_attr = ($block_button_cta) ? esc_attr($block_button_cta) : false;
			
			// if this is a parent page for a child page that has an icon, find out which icon
			if($block_has_button && $block_button_href) {
				$child_id = url_to_postid($block_button_href);
				$block_icon = get_field('page_icon', $child_id); // if the child page does not have this field, get_field() will return an empty string
				$block_icon = ($block_icon == 'none') ? '' : $block_icon; // if the icon is set to 'none', change $block_icon back to an empty string
			} // end block_has_button test
			
		} // end the is-this-NOT-an-image-split-block test
		

		$block_class = array();
		$block_class[] = "page-block";
		if (strlen($block_type) > 0) $block_class[] = $block_type;
		if (strlen($block_color) > 0) $block_class[] = $block_color;
		// newnewnew:
		if($block_icon) {
			$block_class[] = 'has-icon';
			$block_class[] = 'icon-' . $block_icon; 
		}
		$block_class = implode(" ", $block_class);

		$block_image_class = '';
		$block_image_css = '';
		$block_background = '';
		
		switch($block_type) {
			case "image-left":
			case "image-right":
				$block_image_style = get_sub_field("image_style");
				$block_image_link = $block_has_button;
//				$block_image = wp_get_attachment_image(get_sub_field("image"), "full");
				$block_image_id = get_sub_field("image");
				$block_image = wp_get_attachment_image(get_sub_field("image"), "full");
				
				$block_image_class = $block_image_style;
				$block_class .= " image-{$block_image_class}"; // add the image style to the block, as well 
				
				// also add the image as the background of a separate element
				$block_image_src = wp_get_attachment_image_src($block_image_id, 'full');
				$block_background = "<div class='blockBG' style='background-image: url({$block_image_src[0]})'><!-- nothing here --></div>";
				
				break;
			case "full-width-badge":
				$block_image_link = $block_has_button;
//				$block_image = wp_get_attachment_image(get_sub_field("image"), "full");
				
				// newnewnew
				$block_image_id = get_sub_field("image");
				$block_image = wp_get_attachment_image(get_sub_field("image"), "full");
				
				// second draft:
			//	$block_image_attrs = wp_get_attachment_metadata($block_image_id);
			//	$block_image_css = ' style="margin-top: -' . intval($block_image_attrs['height']/2) . 'px; margin-left: -' . intval($block_image_attrs['height']/2) . 'px;"';

				// final draft:
				$block_image_src = wp_get_attachment_image_src($block_image_id, 'full');
				$block_image_css = " style='background-image: url({$block_image_src[0]})'";
				
				$block_image_class = "badge-icon";
				break;
			case "image-split":
				$block_text_left = get_sub_field("left_text");
				$block_text_right = get_sub_field("right_text");
				$block_has_link = get_sub_field("has_link");
				$block_has_link = is_bool($block_has_link) ? $block_has_link : false;
				$block_link_href = ($block_has_link) ? get_sub_field("link_href") : false;
//				$block_image = wp_get_attachment_image(get_sub_field("image"), "full");
				// newnewnew
				$block_image_id = get_sub_field("image");
				$block_image = wp_get_attachment_image(get_sub_field("image"), "full");
				$block_image_src = wp_get_attachment_image_src($block_image_id, 'full');
				$block_image_css = " style='background-image: url({$block_image_src[0]})'";

				$block_image_class = "";
				break;
			case "video":
				$block_video = get_sub_field("video");
				break;
		}

		if (!$block_members_only || ($block_members_only && is_user_logged_in())):
			$block_output .=			"\n";
			$block_output .= 			"$indent<section class=\"$block_class\">\n";
			$block_output .= 			"$indent    $block_background\n";
			
			
			if ($block_has_link && $block_link_href) {
				$block_output .=		"$indent    <a href=\"$block_link_href\">\n";
			}
			
	// block image
			if ($block_type == "image-left" || $block_type == "image-right" || $block_type == "full-width-badge") {
				$block_output .=		"$indent    <div class=\"image $block_image_class\" $block_image_css>\n";
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
				$block_output .=		"$indent        <div class='videoWrap'>\n";
				$block_output .=		"$indent            $block_video\n";
				$block_output .=		"$indent        </div><!-- end div.videoWrap -->\n";
				$block_output .=		"$indent    </div>\n";
			}

	// block content
			if ($block_type == "image-split") {
				// for the image-split block
				$block_output .=		"$indent    <div class=\"image\"  $block_image_css>\n";
				$block_output .=		"$indent        $block_image\n";
				$block_output .=		"$indent    </div>\n";
				$block_output .=		"$indent    <div class=\"content\">\n";
				$block_output .=		"$indent        <h2>\n";
				$block_output .=		"$indent            <span class=\"left-text\">$block_text_left</span>\n";
				$block_output .=		"$indent            <span class=\"right-text\">$block_text_right</span>\n";
				$block_output .=		"$indent        </h2>\n";
				$block_output .=		"$indent    </div>\n";
			} else {
				// for all other blocks
				$block_output .=		"$indent    <div class=\"content\">\n";
				$block_output .=		"$indent        <h2>$block_title</h2>\n";
				$block_output .=		"$indent        $block_text\n";
				
				if ($block_has_button) {
					
					$btn_class = 'bfblButtonLink';
					if($block_color) {
						switch ($block_color) {
							case 'tan-shadow':
								$btn_class .= ' btnBlue';
								break;
							case 'green':
								$btn_class .= ' btnOrange';
								break;
							case 'white':
								$btn_class .= ' btnBlue';
								break;
						}
						
						// special case: turn the buttons gray on the 'why buy local' page
						// (that is, if there is an icon value)
						if($block_icon) {
							$btn_class .= ' btnGray';
						}
						
						
					}

					$block_output .=	"$indent        <a href=\"$block_button_href\" class=\"$btn_class\" title=\"$block_button_cta_attr\">$block_button_cta</a>\n";

				}
				$block_output .=		"$indent    </div><!-- end div.content -->\n";
			}
			
			$block_output .=			"$indent</section>\n";
			
			// newnewnew -- add an arrow link, to be shown on parent pages
			if($block_has_button && $block_button_href && $block_title) {
				$arrowClass = 'blockArrow';
				if($block_icon) {
					$arrowClass .= ' has-icon icon-' . $block_icon;
				}
				
				global $arrowEven;
				if(!isset($arrowEven)) {
					$arrowEven = FALSE;
				} else {
					$arrowEven = ($arrowEven) ? FALSE : TRUE; // if $arrowEven is true, make it false; if it's false, make it true
				}
				$arrowClass .= ($arrowEven) ? ' even' : ' odd';
				 
				
				$block_output .=		"$indent<div class='$arrowClass'>";
				$block_output .=		"$indent    <a href='$block_button_href'>";
				$block_output .=		"$indent        $block_title";
				$block_output .=		"$indent    </a>";
				$block_output .=		"$indent</div><!-- end div.blockArrow -->";
			}
			
		endif;
	endwhile; endif; 
	echo $block_output;
?>