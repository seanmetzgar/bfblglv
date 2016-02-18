<?php
/**
 * @package WordPress
 * @subpackage Buy_Local_GLV
 * @since Buy Local GLV 1.0.0
 */
	$resourceTitle = get_the_title();
	$resourceTitleAttr = esc_attr($resourceTitle);
	$resourceLink = get_the_permalink();
	$resourceImage = (has_post_thumbnail()) ? get_the_post_thumbnail(null, "thumbnail") : false;
	$resourceLinkOutput = "";
	$resourceLinkOutput .= 			"<article class=\"resource-link\">\n";
	$resourceLinkOutput .=			"    <a href=\"$resourceLink\"  title=\"$resourceTitleAttr\">\n";
	if ($resourceImage) {
		$resourceLinkOutput .=		"        <figure class=\"image\">\n";
		$resourceLinkOutput .=		"            $resourceImage\n";
		$resourceLinkOutput .= 		"        </figure>";
	}
	$resourceLinkOutput .=			"        <div class=\"details\">\n";
	$resourceLinkOutput .=			"            <h3>$resourceTitle</h3>\n";
	$resourceLinkOutput .=			"        </div>\n";
	$resourceLinkOutput .=			"    </a>\n";
	$resourceLinkOutput .=			"</article>\n";
	echo $resourceLinkOutput;
?>