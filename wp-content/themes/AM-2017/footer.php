<?php
// Footer
// - everything after affiliate logos
// close .page
echo '
	</div><!-- .page -->
</div><!-- .page-wrap -->
';


// _________________________________
// get settings

// - styling
$styling_options = get_option ( 'sandbox_theme_styling_options' );
$footerhero = $styling_options['footerhero'];

// - affiliate logos
$ouraffiliatestitle = $affiliate_logo_options['ouraffiliatestitle'];
$search = array('Able Mediation');
$replace = array('<strong>Able Mediation</strong>');
$ouraffiliatestitle = str_replace($search, $replace, $ouraffiliatestitle); // bold 'Able Mediation' in the title
$affiliate_logo_options = get_option ( 'sandbox_theme_affiliates_options' );
$logo_1 = $affiliate_logo_options['aff_logo_1'];
$logo_2 = $affiliate_logo_options['aff_logo_2'];
$logo_3 = $affiliate_logo_options['aff_logo_3'];
$logo_4 = $affiliate_logo_options['aff_logo_4'];
$logo_5 = $affiliate_logo_options['aff_logo_5'];
$logo_6 = $affiliate_logo_options['aff_logo_6'];








// if any logo is present, echo the affiliates-band
if ($logo_1 != '' || $logo_2 != '' || $logo_3 != '' || $logo_4 != '')
echo '
<div id="affiliates-band" role="complementary">'
	. ( $ouraffiliatestitle ? ('<div class="container"><h4>'. $ouraffiliatestitle .'</h4></div>')  : '') .'
	<div class="container">';
		// get each property of each logo, discarding the title:
		$BL_title = array_shift($affiliate_logo_options);
		$logogroup = array_chunk($affiliate_logo_options, 4);

		foreach( $logogroup as $logo => $items ) {
			if ($items[0] != '') {
				echo '
				<div class="img-col">
				<img src="' . $items[0] .'" alt="' . $items[1] .'" width="' . $items[2] .'" height="' . $items[3] .'" />
				</div>';
            }
		}

	if ($logo_1 != '' || $logo_2 != '' || $logo_3 != '' || $logo_4 != '' || $logo_5 != '' || $logo_6 != '')
	echo
	'</div>
</div><!-- #affiliates-band -->';
?>



<div id="footer" role="contentinfo" <?php if ($footerhero) echo 'class="has-hero"'; ?>>

	<!-- company information part of footer -->
    <div class="company-info">
	    <div class="container">

			<div class="three columns">

				<?php
				// Output Menu Title
				$services_title = wp_get_nav_menu_object( 3 );
				$services_title = ($services_title -> name);
				echo ( $services_title ? ('<h4>'. $services_title .'</h4>')  : '<h4>Menu</h4>');
				?>
				<ul class="footer-menu">
					<?php
					// function to remove <div> and <ul> which wrap the menu by default
					wp_services_menu_unwrap( array( 'theme_location' => 'services-menu') );
					?>
				</ul>
			</div>

      		<div class="three columns">
				<?php
				// Output Menu Title
				$quicklinks_title = wp_get_nav_menu_object( 52 );
				$quicklinks_title = ($quicklinks_title -> name);
				echo ( $quicklinks_title ? ('<h4>'. $quicklinks_title .'</h4>')  : '<h4>Menu</h4>');
				?>
				<ul class="footer-menu">
				<?php
				// function to remove <div> and <ul> which wrap the menu by default
				wp_quicklinks_menu_unwrap( array( 'theme_location' => 'quicklinks-menu') );
				?>
				</ul>
			</div>

			<div class="six columns">
				<!-- phone, email, and address -->
				<?php
				// company details
				$company_options = get_option ( 'sandbox_theme_company_options' );
				$phone = $company_options['company_phone'];
				// get dialable number from phone
				$search = array(' ', '(', ')', '-');
				$replace = array('', '', '', '');
				$dial = str_replace($search, $replace, $phone);
				// email and address
				$email = $company_options['company_email'];
				$address = $company_options['company_address'];

				if ($phone != '' || $email != '' || $address != '') echo '
				<h4>Contact Us</h4>
				<ul class="contact">';
				if ($phone != '' ) echo '
					<li><a href="tel:'.$dial.'"><i class="fa fa-phone" aria-hidden="true"></i>'.$phone.'</a></li>';
					if ($email != '' ) echo '
					<li><a href="mailto:'.$email.'"><i class="fa fa-envelope" aria-hidden="true"></i>'.$email.'</a></li>';
					if ($address != '' ) echo '
					<li><i class="fa fa-home" aria-hidden="true"></i>'.$address.'</li>';
				if ($phone != '' || $email != '' || $address != '') echo '
				</ul>';


        
        
				// twitter
				$tweet_options = get_option ( 'sandbox_theme_tweet_options' );
				$tweetheading = $tweet_options['twitter_heading'];
				echo ( $tweetheading ? ('<h4>'. $tweetheading .'</h4>')  : '');

				$tweetprofile = $tweet_options['twitter_profile'];
				$tweetuser = $tweet_options['twitter_user'];
				$tweetamount = $tweet_options['twitter_tweet_count'];
				$uri = get_stylesheet_directory_uri();
				// lib/twitterfeed.js targets this div:
				echo '<div id="twitter-feed" data-profile="'.$tweetprofile.'" data-user="'.$tweetuser.'" data-tweets="'.$tweetamount.'" data-path="'.$uri.'"></div>';

				// social media
				$social_options = get_option ( 'sandbox_theme_social_options' );
				$facebook = $social_options['facebook'];
				$twitter = $social_options['twitter'];
				$googleplus = $social_options['googleplus'];
				$linkedin = $social_options['linkedin'];
				$company_name = $company_options['company_name'];

				if ($facebook != '' || $twitter != '' || $googleplus != '' || $linkedin != '') echo '
				<h4>Follow Us on Social Media</h4>
				<ul class="social">';

				if ($facebook != '') echo '
				<li>
					<a href="'.$facebook.'" target="_blank">
					<i class="fa fa-facebook-official" aria-hidden="true"></i>'
					. ( $company_name ? ( '<div class="assistive-text">'.$company_name.' Facebook</div>' )  : '') .
					'</a>
				</li>';

				if ($twitter != '') echo '
				<li>
					<a href="'.$twitter.'" target="_blank">
					<i class="fa fa-twitter-square" aria-hidden="true"></i>'
					. ( $company_name ? ( '<div class="assistive-text">'.$company_name.' Twitter</div>' )  : '') .
					'</a>
				</li>';

				if ($googleplus != '') echo '
				<li>
					<a href="'.$googleplus.'" target="_blank">
					<i class="fa fa-google-plus-official" aria-hidden="true"></i>'
					. ( $company_name ? ( '<div class="assistive-text">'.$company_name.' Google Plus</div>' )  : '') .
					'</a>
				</li>';

				if ($linkedin != '') echo '
				<li>
					<a href="'.$linkedin.'" target="_blank">
					<i class="fa fa-linkedin-square" aria-hidden="true"></i>'
					. ( $company_name ? ( '<div class="assistive-text">'.$company_name.' Linkedin</div>' )  : '') .
					'</a>
				</li>';

				if ($facebook != '' || $twitter != '' || $googleplus != '' || $linkedin != '') echo '
				</ul>';

				?>
			</div><!-- six columns -->
		</div><!-- container -->
	</div><!-- company-info -->



	<!-- site credits -->
	<div class="site-credits">
    <div class="container">
  		<div class="six columns">
        <?php
  			// company name
  			if ($company_name != '') echo '<p>© '.date("Y ").$company_name.'</p>';
  			// add another footer menu - for privacy poilcy and terms
  			?>
  		</div>
  		<div class="six columns">
        	<a href="http://martinbagshaw.co.uk/" title="Website by Martin Bagshaw" target="_blank" <?php if (!is_page( 21 )) echo 'rel="nofollow"'; ?>>Website by Martin Bagshaw</a>
  		</div>
  	</div><!-- container -->
  </div><!-- site-credits -->

</div><!-- #footer -->


<?php wp_footer(); ?>


<?php
// google analytics
$analytics_tracking = get_option ( 'sandbox_theme_google_analytics_options' );
$ga_id = $analytics_tracking['google_analytics'];

if ($ga_id != '') echo '
<script>
    (function(i,s,o,g,r,a,m){i[\'GoogleAnalyticsObject\']=r;i[r]=i[r]||function(){
    (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
    m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,\'script\',\'https://www.google-analytics.com/analytics.js\',\'ga\');

    ga(\'create\', \''. $ga_id .'\', \'auto\');
    ga(\'send\', \'pageview\');
</script>
';
?>

</body>
</html>
