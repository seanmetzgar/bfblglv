<?php 
/**
 * @package WordPress
 * @subpackage Buy_Local_GLV
 * @since Buy Local GLV 1.0.0
 */
 
	$chipsOutput = "";
	
	if(have_rows('chips', 'option')):
		$chipsOutput .= '<section class="chips-block page-block tan-shadow">';
			$chipsOutput .= '<nav role="complimentary">';
				$chipsOutput .= '<ul>';
		
					while ( have_rows('chips', 'option') ) : the_row();
						
						$chipTitle = get_sub_field('chip_title');
						$chipDescr = get_sub_field('chip_description');
						$chipImg = get_sub_field('chip_image');
						$chipLink = get_sub_field('chip_page');
						
						$chipsOutput .= "<li class='chip'>";
							$chipsOutput .= "<a href='$chipLink'>";
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



$chipsOutput .= "";







	echo $chipsOutput;
?>