<?php
/**
 * @package WordPress
 * @subpackage Buy_Local_GLV
 * @since Buy Local GLV 1.0.0
 */

 //	$page_object = get_queried_object();
//	$page_id     = get_queried_object_id();
//	$page_template = get_post_meta($page_id, "_wp_page_template");
//	$page_template = is_array($page_template) ? $page_template[0] : false;
//	$chipLoader = ($page_template === "page_find-local-food.php") ? $page_id : "option";

	$chipLoader = 'option';
	$chipsOutput = "";

	if(have_rows('chips', $chipLoader)):
		$chipsOutput .= '<section class="chips-block page-block tan-shadow">';
			$chipsOutput .= '<nav role="complimentary">';
				$chipsOutput .= '<ul>';

					while ( have_rows('chips', $chipLoader) ) : the_row();

						$chipTitle = get_sub_field('chip_title');
						$chipDescr = get_sub_field('chip_description');
						$chipImg = get_sub_field('chip_image');
						$chipLink = get_sub_field('chip_page');

						$chipsOutput .= "<li class='chip'>";
							$chipsOutput .= "<a href='$chipLink' class='chipLink'>";
								$chipsOutput .= "<span class='chipImg' style='background-image: url(" . $chipImg['sizes']['medium'] . ")'>";
									$chipsOutput .= "<img src='" . $chipImg['sizes']['thumbnail'] . "' alt='' />";
								$chipsOutput .= "</span>";
								$chipsOutput .= "<span class='chipTitle'>$chipTitle</span>";
								$chipsOutput .= "<span class='chipDescr'>$chipDescr</span>";
							$chipsOutput .= "</a>";
						$chipsOutput .= "</li><!-- end li.chip -->";

					endwhile;
				$chipsOutput .= '</ul>';
			$chipsOutput .= '</nav>';
		$chipsOutput .= '</section><!-- end section.chips-block -->';
	endif; // end the have_rows() test

	echo $chipsOutput;
?>