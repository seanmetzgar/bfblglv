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
	$galleryClass = ($upper_gallery) ? "photo-gallery-wrapper upper-gallery" : "photo-gallery-wrapper";
	$galleryDataSet = implode(" ", $galleryDataSet);
	if (is_array($galleryImages) && count($galleryImages) > 0) {
		$galleryCount = count($galleryImages);
		$galleryOutput .=		"<div class=\"$galleryClass\" id=\"photo-gallery-$galleryID\">\n";
		$galleryOutput .= 		"    <div class=\"photo-gallery\">\n";
		$galleryOutput .= 		"        <div class=\"cycle-slideshow\" $galleryDataSet>\n";
		if ($galleryCount > 1) {
			$galleryOutput .= 	"            <a href=\"#\" class=\"cycle-prev\"><span>Previous</span></a><a href=\"#\" class=\"cycle-next\"><span>Next</span></a>\n";
		}
		foreach ($galleryImages as $galleryImage) {
			$galleryImageSrc = $galleryImage["sizes"]["medium_large"];
			$galleryImageSrc = (is_string($galleryImageSrc) && strlen($galleryImageSrc) > 0) ? $galleryImageSrc : $galleryImage["sizes"]["large"];
			$galleryImageSrc = (is_string($galleryImageSrc) && strlen($galleryImageSrc) > 0) ? $galleryImageSrc : $galleryImage["url"];
			//$galleryOutput .= 	"            <img src=\"$galleryImageSrc\" data-cycle-title=\"$galleryImageCaption\" nopin=\"nopin\">\n";
			$galleryOutput .= 	"            <img src=\"$galleryImageSrc\" nopin=\"nopin\">\n";
		}
		$galleryOutput .=		"        </div>\n";
		$galleryOutput .= 		"    </div>\n";
		// $galleryOutput .= 		"    <p class=\"cycle-caption\"></p>\n";
		$galleryOutput .=		"</div>\n";
	}
	echo $galleryOutput;