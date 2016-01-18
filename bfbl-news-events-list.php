<?php 
/**
 * @package WordPress
 * @subpackage Buy_Local_GLV
 * @since Buy Local GLV 1.0.0
 */
	$archive_output = "";
	$indent = indent(5, false);

	$news_args = array(
		"post_type"			=> array( "news" ),
		"nopaging"			=> false,
		"posts_per_page"	=> 5
	);
	$events_args = array(
		"post_type"			=> array( "events" ),
		"nopaging"			=> false,
		"posts_per_page"	=> 5,
		"meta_key"			=> "event_date",
		"order_by"			=> "meta_value_num",
		"order"				=> "ASC"
	);
	$news_posts = get_posts($news_args);
	$events_posts = get_posts($events_args);

	$news_count = (is_array($news_posts) && count($news_posts)) ? count($news_posts) : 0;
	$events_count = (is_array($events_posts) && count($events_posts)) ? count($events_posts) : 0; ?>
	<section class="news-events-list row">
		<div class="col-md-7 news-list">
		<?php foreach ($news_posts as $post): setup_postdata($post);?>
			<article class="news-summary">
				<div class="image">
					<?php if (has_post_thumbnail()): the_post_thumbnail();?>
				</div>
				<header class="entry-header">
					<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
					<p class="post-meta">
						<span class="published"><?php the_date(); ?></span> |
						<span class="author"><?php the_author(); ?></span>
					</p>
				</header>
				<div class="content">
					<div class="excerpt"><?php the_excerpt(); ?></div>
					<p><a href="<?php the_permalink(); ?>" class="read-more">Read More</a></p>
				</div>
			</article>
		<? endforeach; wp_reset_postdata();?>
		</div>

		<div class="col-md-5 events-list">
		<?php foreach ($events_posts as $post): setup_postdata($post);?>
			<article class="events-summary">
				<div class="image">
					<?php if (has_post_thumbnail()): the_post_thumbnail();?>
				</div>
				<header class="entry-header">
					<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
					<p class="post-meta">
						<span class="date"><?php the_field("event_date"); ?></span>
					</p>
				</header>
				<div class="content">
					<div class="excerpt"><?php the_excerpt(); ?></div>
					<p><a href="<?php the_permalink(); ?>" class="read-more">Read More</a></p>
				</div>
			</article>
		<? endforeach; wp_reset_postdata();?>
		</div>
	</section>