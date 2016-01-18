<?php 
	$parent_id = $post->post_parent;
	$has_post_thumbnail = ( has_post_thumbnail($parent_id) );
	$entry_header_class = $has_post_thumbnail ? "page-header has-image" : "page-header";
?>
					<header class="<?php echo $entry_header_class; ?>">
						<p class="entry-title"><?php the_title(); ?></p>
						<?php if ($has_post_thumbnail) echo get_the_post_thumbnail($parent_id, "full", array("class" => "img-responsive")); ?>
					</header>