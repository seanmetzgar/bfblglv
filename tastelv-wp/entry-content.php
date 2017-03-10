<?php
	$content_class  = array("container-fluid", "constrained", "unpadded");
	$has_image = has_post_thumbnail();
	$sponsor = get_field("sponsored_by");
	$sponsor2 = get_field("sponsored_by_2");
?>
<article id="post-<?php the_ID(); ?>" <?php post_class($content_class); ?>>
	<?php if ($has_image): ?>
		<?php if ($sponsor): ?>
		<header class="entry-header has-image col-lg-10 col-lg-offset-1">
			<div class="row">
				<figure class="feature-image col-sm-5">
					<?php the_post_thumbnail("large", array("class" => "img-responsive")); ?>
				</figure>
				<div class="col-sm-7">
					<?php echo page_headline(get_the_title(), ""); ?>
					<?php if (is_array($sponsor) || is_int($sponsor)) echo sponsored_by($sponsor); ?>
					<?php echo page_meta(get_the_ID(), $post_type); ?>
				</div>
			</div>
		</header>
		<section class="entry-content col-lg-10 col-lg-offset-1">
			<?php the_content(); ?>
		</section>
		<?php else: ?>
		<section class="entry-content inline-header has-image col-lg-10 col-lg-offset-1">
			<figure class="feature-image">
				<?php the_post_thumbnail("large", array("class" => "img-responsive")); ?>
			</figure>
			<?php echo page_headline(get_the_title(), ""); ?>
			<?php echo page_meta(get_the_ID(), $post_type); ?>
			<?php the_content(); ?>
		</section>
		<?php endif; ?>
	<?php else: ?>
		<header class="entry-header col-lg-10 col-lg-offset-1">
			<?php echo page_headline(get_the_title(), ""); ?>
			<?php if (is_array($sponsor) || is_int($sponsor)) echo sponsored_by($sponsor); ?>
			<?php echo page_meta(get_the_ID(), $post_type); ?>
		</header>
		<section class="entry-content col-lg-10 col-lg-offset-1">
			<?php the_content(); ?>
		</section>
	<?php endif; ?>

	<?php if (has_term("multiple", "event_type") && have_rows("events")): ?>
		<div class="sub-events">
			<?php while (have_rows("events")): the_row();
				$event_image = get_sub_field("event_image");
				$event_title = get_sub_field("event_title");
				$event_start_time = get_sub_field("event_start_time");
				$event_end_time = get_sub_field("event_end_time");
				$event_location = get_sub_field("event_location");
				$event_website = get_sub_field("event_website");
				$event_meta_string = "";
		        $event_meta_string .= ($event_location) ? $event_location : "";
		        $event_meta_string .= ($event_start_time && $event_meta_string) ? "<br>" : "";
				$event_meta_string .= ($event_start_time) ? $event_start_time : "";
		        $event_meta_string .= ($event_start_time && $event_end_time) ? " - {$event_end_time}" : "";
		        $event_meta_string .= ($event_meta_string && $event_website) ? "<br>" : "";
		        $event_meta_string .= ($event_website) ? "<a href=\"{$event_website}\" target=\"_blank\">{$event_website}</a>" : "";
		        $event_meta_string = ($event_meta_string) ? "<p class=\"meta\">$event_meta_string</p>" : "";

				if ($event_image): ?>
			<section class="entry-content has-image inline-header col-lg-10 col-lg-offset-1">
				<div class="row">
					<figure class="event-image col-md-4 col-sm-5">
						<img class="img-responsive" src="<?php echo $event_image; ?>">
					</figure>
					<div class="col-md-8 col-sm-7">
						<?php echo page_headline($event_title, "", "h3"); ?>
						<?php echo $event_meta_string; ?>
						<?php the_sub_field("event_content"); ?>
					</div>
				</div>
			</section>
				<?php else: ?>
			<header class="entry-header col-lg-10 col-lg-offset-1">
				<?php echo page_headline($event_title, "", "h3"); ?>
				<?php echo $event_meta_string; ?>
			</header>
			<section class="entry-content col-lg-10 col-lg-offset-1">
				<?php the_sub_field("event_content"); ?>
			</section>
				<?php endif;
			endwhile; ?>
		</div>
		<?php endif; ?>
</article>