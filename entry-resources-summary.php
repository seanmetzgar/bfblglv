<article class="col-md-4"><a href="<?php the_permalink(); ?>">
	<div class="image">
		<?php if (has_post_thumbnail()) the_post_thumbnail("medium", array("class" => "img-responsive")); ?>
	</div>
	<div class="content">
		<h2><?php the_title(); ?></h2>
	</div>
</a></article>