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
		"meta_key"			=> "date",
		"order_by"			=> "meta_value_num",
		"order"				=> "ASC"
	);
	$news_posts = get_posts($news_args);
	$events_posts = get_posts($events_args);

	$news_count = count($news_posts);
	$events_count = count($events_posts); ?>
	<section class="news-events-list row">
		<div class="col-md-8 news-list">
		<?php foreach ($news_posts as $news_post): ?>
			<article class="news-article">
				<h2><a href="<?php echo get_permalink($news_post->ID); ?>"><?php echo get_the_title($news_post->ID); ?></a></h2>
				<p class="post-meta">
					<span class="published"><?php echo get_the_date(null, $news_post->ID); ?></span> |
					<span class="author"></span>
				</p>
				<pre><?php print_r($news_post); ?></pre>
			</article>
		<? endforeach; ?>
		</div>
	</section>