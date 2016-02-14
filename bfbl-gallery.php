<?php
/**
 * @package WordPress
 * @subpackage Buy_Local_GLV
 * @since Buy Local GLV 1.0.0
 */

	$galleryOutput = "";
	$galleryID = 0;

	$galleryImages = get_field("gallery");
	$galleryID++;
	$galleryDataSet = [];
	$galleryDataSet[] = "data-cycle-fx=\"fade\"";
	$galleryDataSet[] = "data-cycle-timeout=\"0\"";
	$galleryDataSet[] = "data-cycle-caption=\"#photo-gallery-$galleryID .cycle-caption\"";
	$galleryDataSet[] = "data-cycle-caption-template=\"{{cycleTitle}}\"";
	$galleryDataSet[] = "data-cycle-auto-height=\"container\"";
	$galleryDataSet = implode(" ", $galleryDataSet);
	if (is_array($galleryImages) && count($galleryImages) > 0) {
		$galleryCount = count($galleryImages);
		$galleryOutput .=		"<div class=\"photo-gallery-wrapper\" id=\"photo-gallery-$galleryID\">\n";
		$galleryOutput .= 		"    <div class=\"photo-gallery\">\n";
		$galleryOutput .= 		"        <div class=\"cycle-slideshow\" $galleryDataSet>\n";
		if ($galleryCount > 1) {
			$galleryOutput .= 	"            <a href=\"#\" class=\"cycle-prev\">Previous</a><a href=\"#\" class=\"cycle-next\">Next</a>\n";
		}
		foreach ($galleryImages as $galleryImage) {
			$galleryImageSrc = $galleryImage["url"];
			$galleryImageCaption = $galleryImage["caption"];
			$galleryOutput .= 	"            <img src=\"$galleryImageSrc\" data-cycle-title=\"$galleryImageCaption\" nopin=\"nopin\">\n";
		}
		echo "<!-- \n";
		print_r($galleryImage);
		echo "\n-->"
		$galleryOutput .=		"        </div>\n";
		$galleryOutput .= 		"    </div>\n";
		$galleryOutput .= 		"    <p class=\"cycle-caption\"></p>\n";
		$galleryOutput .=		"</div>\n";
	}
	echo $galleryOutput;