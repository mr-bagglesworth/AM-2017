<?php
// category pages template
// - similar to home.php, but less fancy
// - almost identical to tag.php
// - keeps the mid page advert that displays every other page

get_header(); ?>

<div id="content" role="main">
	
	<?php
	
	// _______________________________________________________
	// check to see that there are posts
	if ( have_posts() ) :


	// ___________________________
	// page variables

	// page count = $paged;
	$even_pages = $paged % 2 == 0; // first page is even, ($even_pages || $paged > 0)
	$odd_pages = $paged % 2 == 1;
	
	// keep track of the post count
	$index = 0;

	// use index to get colour - use in while loop
	$colours = array(' green', ' orange', ' blue', ' red');
	$seq = $index - 1;

	// sidebar - classes.php
	$blog_sidebar = new blogSidebar('blog_sidebar');

	// advert adds .wrapper white-bg and wrapper grey-bg containers + advert
	// - look for $ad_enabled
	$ad_enabled = get_option ( 'sandbox_theme_blog_options' )['blog_ad_check'];
	
	// ________________
	// category details
	$cat_title = single_cat_title( '', false );
	$cat_desc = category_description();
	// make a top sticky post out of category info
	$cat_info = '
	<div class="archive-info">
		<h1>Category: ' . $cat_title . '</h1>
	</div>';

	// post count
	// - posts per page - defined in settings > reading
	$posts_per_page = get_option( 'posts_per_page' );
	$posts_per_page = (int)$posts_per_page;
	// - posts in category
	$category = get_the_category();
	$posts_in_category = $category[0]->category_count;
	$posts_in_category = (int)$posts_in_category;

	



	// ___________________________
	// wrapping

	// even pages don't ever show an advert
	if (($even_pages) && ($paged > 0)) {
		echo '
		<div class="container pad-top">
			<div class="seven columns">' . $cat_info;
	}

	// odd pages:
	// - with advert: add wrapper white-bg
	// - no advert: add pad-top
	if (($odd_pages) || ($paged == 0)) {
		echo 
		($ad_enabled ? '<div class="wrapper white-bg">' : '') . '
			<div class="container'. ( $ad_enabled ? '' : ' pad-top') .'">
				<div class="seven columns">' . $cat_info;
	}

	
	
	
	// ___________________________
	// start the posts loop:
	while ( have_posts() ) : the_post();
	
	
	// ___________________________
	// post variables
	// a) top border colour
	$seq ++;
	if ($seq % 4 == 0) {
		$seq = 0;	
	}
	$borderTop = $colours[$seq];
	// b) thumbmails - index posts
	if (has_post_thumbnail()) {
		$thumbImg = '<div class="thumb">'.get_the_post_thumbnail().'<span class="divider white"></span></div>';
	}
	else {
		$thumbImg = '';

	}
	// c) linked headings
	$postHeading = '<a href="'.get_the_permalink().'">'.get_the_title().'</a>';


	
	// ___________________________
	// wrapping: after 4th post
	if ($index == 4) {

		// odd pages - with advert:
		// 	 - close: .seven.columns, .container .wrapper white-bg
		//   - add: sidebar, advert, next container
		if ( (($odd_pages) || ($paged == 0)) && $ad_enabled ) {
			echo '
					</div>
					<div class="five columns">';
						$blog_sidebar->add_sidebar();
						echo '
					</div>
				</div>
				<span class="divider grey"></span>
			</div>';
			echo blog_advert(). '
			<div class="container">
				<div class="seven columns">';
		}
	}


	// ___________________________
	// regular list of posts
	echo '
	<div class="post index'.$borderTop.'">
		'.$thumbImg.'
		<h3>'.$postHeading.'</h3>
		<p>'.excerpt(36).'</p>
	</div>';

	
	// increment loop by 1 (move to next post)
	$index++;
	endwhile;
	


	// _________________________________________________________________________________
	// wrapping: after page posts ended

	// odd pages: 3, 5, 7, etc.
	// - add sidebar if: 1st page, ad disabled, 5 posts or less 
	if (($odd_pages) || ($paged == 0)) {
		echo '
			</div>
			<div class="five columns">
				';
				if (!$ad_enabled || $posts_in_category < 6) {
					$blog_sidebar->add_sidebar();
				}
				echo '
			</div>
		</div>';
	}

	// even pages:
	// - add sidebar
	if (($even_pages) && ($paged > 0)) {
		echo '
			</div>
			<div class="five columns">
				';
				$blog_sidebar->add_sidebar();
				echo '
			</div>
		</div>';
	}


			






if ($posts_in_category > $posts_per_page == 'true') {

	// ___________________________
	// posts page navigation
	echo '<div class="container">';
	the_posts_pagination( array(
		'prev_text'          => __( 'Previous page', 'AM2017' ),
		'next_text'          => __( 'Next page', 'AM2017' ),
		'screen_reader_text' => __( 'Blog Post Navigation' ),
		'before_page_number' => '<span class="meta-nav screen-reader-text">' . __( 'Page', 'AM2017' ) . ' </span>',
	) );
	echo '</div><!-- container -->';

}
endif;
?>

</div><!-- #content -->

<?php
// widgets just above the footer area
echo blog_widget_area();

get_footer(); ?>