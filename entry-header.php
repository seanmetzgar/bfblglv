<?php 
	$has_post_thumbnail = ( has_post_thumbnail() );
	$entry_header_class = $has_post_thumbnail ? "page-header has-image" : "page-header";
?>
					<header class="<?php echo $entry_header_class; ?>">
						<h1 class="entry-title"><?php the_title(); ?></h1>
						<?php if ($has_post_thumbnail) the_post_thumbnail("full", array("class" => "img-responsive")); ?>
						<?php edit_post_link(); ?>
					</header>