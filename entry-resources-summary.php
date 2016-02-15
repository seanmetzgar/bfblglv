<?php

$resourceLinkCSS = '';
$resourceTaxonomyTermsArray = wp_get_post_terms(get_the_ID(), "resource-type");
$resourceTaxonomyTerms = array();
if (is_array($resourceTaxonomyTermsArray) && count($resourceTaxonomyTermsArray) > 0) {
	foreach ($resourceTaxonomyTermsArray as $resourceTaxonomyTerm) {
		$resourceTaxonomyTerms[] = $resourceTaxonomyTerm->name;
	}
	$resourceTaxonomyTerms = implode(", ", $resourceTaxonomyTerms);
}

echo "<article class='resource-link' $resourceLinkCSS >";
	echo "<h3>";
		echo "<a href='";
			the_permalink();
		echo "'>";
			echo "<span>";
				the_title();
			echo "</span>";
		echo "</a>";
	echo "</h3>";
	if (has_post_thumbnail()) { the_post_thumbnail(); }
echo "</article>";
?>