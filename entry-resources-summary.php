<?php

$resourceLinkCSS = '';
$resourceTaxonomyTerms = wp_get_post_terms(get_the_ID(), "resource-type");

// UNCOMMENT TO RESTORE
/*
if(has_post_thumbnail()) {
	$thumbnail_id = get_post_thumbnail_id();
//	$thumbnail_attrs = wp_get_attachment_metadata($thumbnail_id); // if needed
	$thumbnail_src = wp_get_attachment_image_src($thumbnail_id, 'full');
	$resourceLinkCSS = "style='background-image: url({$thumbnail_src[0]});'";
} // end the is-there-a-post-thumbnail test
*/

echo "<article class='resourceLink' $resourceLinkCSS >";
	echo "<h2>";
		echo "<a href='";
			the_permalink();
		echo "'>";
			echo "<span>";
				the_title();
			echo "</span>";
			if (is_array($resourceTaxonomyTerms) && count($resourceTaxonomyTerms) > 0) {
			echo "<span class='categories'>";
				foreach ($resourceTaxonomyTerms as $resourceTaxonomyTerm) {
					print_r($resourceTaxonomyTerm);
				}
			echo "</span>";
			}
		echo "</a>";
	echo "</h2>";
echo "</article>";


/*
<article class="col-md-4"><a href="<?php the_permalink(); ?>">
	<div class="image">
		<?php if (has_post_thumbnail()) the_post_thumbnail("medium", array("class" => "img-responsive")); ?>
	</div>
	<div class="content">
		<h2><?php the_title(); ?></h2>
	</div>
</a></article>
*/
?>