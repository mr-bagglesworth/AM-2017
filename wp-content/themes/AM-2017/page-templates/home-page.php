<?php
/**
 * Template Name: Able Home Page
 * Description: Template for displaying the Home Page
 */

get_header();

?>

<div id="content" role="main">

	<?php
	$styling_options = get_option ( 'sandbox_theme_styling_options' );
	$heromesh = $styling_options['heromesh'];
	
	// get page content to pass into hero:
	while ( have_posts() ) : the_post();
		$hero_content = get_the_content();
		$hero_content = apply_filters('the_content', $hero_content);// apply filters adds html tags, e.g. <p></p>
	endwhile;
	$hero_right = get_field('hero_right_hand_content');
	$hero_right_bg = get_field('hero_right_hand_background_colour');
	
	// pass in all info required into hero function:
	heroSection($hero_content, $hero_right, $hero_right_bg);
	?>




	<!-- second section -->
	<div class="wrapper white-bg">
		<div class="container container--right">
		<?php
		$header_2 = get_field('second_section_header');
		$content_2 = get_field('second_section_content');
		$sidebar_2 = get_field('second_section_sidebar');
		$sidebar_2_colour = get_field('second_section_sidebar_colour');
		if ($header_2) {
			echo '
			<div class="seven columns">
				<h2>'. $header_2 .'</h2> ' . $content_2 . '
			</div>';
		}
		if ($sidebar_2) {
			echo '
			<div class="five columns'. ( $sidebar_2_colour ? ( ' '. $sidebar_2_colour .'"' )  : '"') .'>
				'. $sidebar_2 .'
			</div>';
		}
		?>			
		</div><!-- container -->
	<span class="divider grey"></span>
	</div><!-- wrapper white-bg -->



		<!-- third section -->
		<?php
		$header_3 = get_field('third_section_header');
		$content_3 = get_field('third_section_content');

		$c1 = get_field('column_1');
		$c1_buttontext = get_field('column_1_button_text');
		$c1_buttonlink = get_field('column_1_button_link');
		$c1_btncolour = get_field('column_1_button_colour');

		$c2 = get_field('column_2');
		$c2_buttontext = get_field('column_2_button_text');
		$c2_buttonlink = get_field('column_2_button_link');
		$c2_btncolour = get_field('column_2_button_colour');

		$c3 = get_field('column_3');
		$c3_buttontext = get_field('column_3_button_text');
		$c3_buttonlink = get_field('column_3_button_link');
		$c3_btncolour = get_field('column_3_button_colour');

		$cta = get_field('end_of_content_cta_text');
		$cta_buttonlink = get_field('end_of_content_cta_link');
		$cta_buttoncolour = get_field('end_of_content_cta_colour');

		if ($header_3 || $content_3) {
		echo '<div class="wrapper grey-bg">';
		}

			// columns header and intro
			echo ( $header_3 ? ('<div class="container container--center container-narrow"><h3>'. $header_3 .'</h3>' . $content_3 . '</div>')  : '');

			// start column container
			echo ( $c1 || $c2 || $c3 ? ('<div class="container container--center">')  : '');

			// column 1
			echo ( $c1 ? ('<div class="four columns stage">' . $c1 . ( $c1_buttontext ? ('<div class="button--container"><a class="button'. ( $c1_btncolour ? (' ' . $c1_btncolour)  :  ' green') .'" href="'. $c1_buttonlink .'">' . $c1_buttontext . '</a></div>')  : '') .'</div>')  : '');

			// column 2
			echo ( $c2 ? ('<div class="four columns stage">' . $c2 . ( $c2_buttontext ? ('<div class="button--container"><a class="button'. ( $c2_btncolour ? (' ' . $c2_btncolour)  :  ' green') .'" href="'. $c2_buttonlink .'">' . $c2_buttontext . '</a></div>')  : '') .'<div class="columns--divider"></div></div>')  : '');

			// column 3
			echo ( $c3 ? ('<div class="four columns stage">' . $c3 . ( $c3_buttontext ? ('<div class="button--container"><a class="button'. ( $c3_btncolour ? (' ' . $c3_btncolour)  :  ' green') .'" href="'. $c3_buttonlink .'">' . $c3_buttontext . '</a></div>')  : '') .'<div class="columns--divider"></div></div>')  : '');

			// end column container
			echo ( $c1 || $c2 || $c3 ? ('</div>')  : '');

			// end of content CTA
			echo ( $cta ? ('<div class="container container--center container-narrow"><a href="'. $cta_buttonlink .'" class="button solid cta-btn'. ( $cta_buttoncolour ? (' ' . $cta_buttoncolour)  :  ' green') .'">'. $cta .'</a></div>')  : '');


		if ($header_3 || $content_3) {
		echo '<span class="divider white"></span></div>';
		}

		// 4th section - last content
		$header_4 = get_field('last_header');
		$content_4 = get_field('last_content');

		// columns header and intro
		echo ( $header_4 ? ('<div class="container container--center container-narrow"><h3>'. $header_4 .'</h3>' . $content_4 . '</div>')  : '');

?>
</div><!-- #content -->



<?php
// in page cta - page-content.php
pageCta();
?>

<?php get_footer(); ?>
