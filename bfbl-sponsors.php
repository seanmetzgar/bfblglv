<?php 
/**
 * @package WordPress
 * @subpackage Buy_Local_GLV
 * @since Buy Local GLV 1.0.0
 */

 	$sponsors = '';
 
	$sponsors_args = array(
		"post_type"			=> "sponsors",
		"posts_per_page"	=> -1
	);
	$sponsors_posts = get_posts($sponsors_args);

	$sponsors_count = (is_array($sponsors_posts) && count($sponsors_posts)) ? count($sponsors_posts) : 0;
	if ($sponsors_count > 0): 
		
		$sponsors .= '<section class="sponsors-list page-block white">';
			$sponsors .= '<h2>Sponsors</h2>';
				$sponsors .= '<ul>';
			
				foreach ($sponsors_posts as $post): setup_postdata($post);
					
					$sponsor_id = get_the_ID();
		
					if(has_post_thumbnail($sponsor_id)) {
						
						$thumbnail_id = get_post_thumbnail_id($sponsor_id);
					//	$thumbnail_attrs = wp_get_attachment_metadata($thumbnail_id);
						$thumbnail_src = wp_get_attachment_image_src($thumbnail_id, 'medium');
						
						// indices of $thumbnail_src:
						// 	[0]: src
						// 	[1]: width
						// 	[2]: height
						
						
						$sponsor_class = 'sponsor';
						$sponsor_css = '';
						$sponsor_name = get_the_title();		
						$sponsor_link = get_field('url', $sponsor_id);
						$sponsor_img = get_the_post_thumbnail($sponsor_id, "medium", array("class" => "img-responsive"));
						
						$sponsor_ratio = $thumbnail_src[1]/$thumbnail_src[2]; // width-to-height ratio
						$sponsor_height = 0;
						$sponsor_width = 0;
						
						if($sponsor_ratio >= 1.5) {
							// wide images
							$sponsor_height = 58;
						} else {
							// tall or square images
							$sponsor_height = 104;
						}
						
						$sponsor_width = $sponsor_height * $sponsor_ratio;
						
						$sponsor_css .= "background-image: url({$thumbnail_src[0]});";
						$sponsor_css .= " height: {$sponsor_height}px; height: " . $sponsor_height/16 . "rem;";
						$sponsor_css .= " width: " . round($sponsor_width, 0) . "px; width: " . round($sponsor_width/16, 4) . "rem;";
						
						$sponsors .= '<li>';
							$sponsors .= "<div class='$sponsor_class' style='$sponsor_css'>";
								$sponsors .= ($sponsor_link) ? "<a href='$sponsor_link' target='_blank'>" : ''; // if $sponsor_link has content (evaluates to 'true'), add the link
									$sponsors .= "<span class='sponsorName'>$sponsor_name</span>";
									$sponsors .= $sponsor_img;
								$sponsors .= ($sponsor_link) ? "</a>" : '';
							$sponsors .= "</div>";
						$sponsors .= '</li>';
						
					} // end the is-there-a-post-thumbnail test			
				endforeach;
				wp_reset_postdata();
				
			$sponsors .= '</ul>';
		$sponsors .= '</section><!-- end section.sponsors-list -->';
		echo $sponsors;
		
		
	endif;?>