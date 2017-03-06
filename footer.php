</div>

<footer class="site-footer">
	<div class="inside">

		<div class="footer-left">
			<?php
			// Primary Menu
			if ( has_nav_menu( 'footer_primary' ) ) {
				$args = array(
					'theme_location' => 'footer_primary',
					'menu'           => 'Footer - primary',
					'container'      => '',
					'container_id'   => '',
					'menu_class'     => '',
					'items_wrap'     => '<ul class="nav-list">%3$s</ul>',
				);

				echo '<nav class="nav-menu nav-footer nav-primary">';
				wp_nav_menu( $args );
				echo '</nav>';
			}

			// Secondary Menu
			if ( has_nav_menu( 'footer_secondary' ) ) {
				$args = array(
					'theme_location' => 'footer_secondary',
					'menu'           => 'Footer - Secondary',
					'container'      => '',
					'container_id'   => '',
					'menu_class'     => '',
					'items_wrap'     => '<ul class="nav-list">%3$s</ul>',
				);

				echo '<nav class="nav-menu nav-footer nav-secondary">';
				wp_nav_menu( $args );
				echo '</nav>';
			}
			?>

			<?php

			// SOCIAL MEDIA
			// developer: edit the $socialsites array below and/or the Social Media ACF field group to prevent the client adding sites that haven't been styled
			// this code also appears in includes/widgets/socialMediaButtons.php
			$socialsites = array(
				"facebook"    => 'Facebook',
				"twitter"     => 'Twitter',
				"tumblr"      => 'Tumblr',
				"linkedin"    => 'LinkedIn',
				"youtube"     => 'YouTube',
				"googleplus" => 'Google+',
				"pinterest"   => 'Pinterest',
				"instagram"   => 'Instagram',
			);
			$socialoutput = '';
			$svg = file_get_contents( get_template_directory() . '/includes/images/social_icons.svg' );
			foreach ( $socialsites as $site => $sitename ) {
				if ( $url = get_field( $site . '_url', 'options' ) ) {
					$socialoutput .= '<li class="social-' . $site . '"><a href="' . $url . '" target="_blank" rel="external"><span class="screen-reader-text">' . $sitename . '</span>' . $svg . '</a></li>';
				}
			}
			if ( $socialoutput ) {
				echo '<ul class="nav-menu nav-social social-links">', $socialoutput, '</ul>';
			}
			?>
		</div>

		<div class="footer-right">
			
			<?php
			// COPYRIGHT
			if ( $copyright = get_field( 'copyright_text', 'options' ) ) {
				echo '<div class="copyright">', do_shortcode( wpautop( $copyright ) ), '</div>';
			}
			?>

		</div>
	</div>
</footer>

</div>


<?php
// Mobile Nav Menu
if ( has_nav_menu( 'mobile_primary' ) || has_nav_menu( 'mobile_secondary' ) ) {

	?>

	<div id="mobile-nav">

		<div class="inside">
			<div class="mobile-menu">
				<?php
				// Mobile - Primary Menu
				if ( has_nav_menu( 'mobile_primary' ) ) {
					$args = array(
						'theme_location' => 'mobile_primary',
						'menu'           => 'Mobile - Primary',
						'container'      => '',
						'container_id'   => '',
						'menu_class'     => '',
						'items_wrap'     => '<ul class="nav-list">%3$s</ul>',
					);

					echo '<nav class="nav-menu nav-mobile nav-primary">';
					wp_nav_menu( $args );
					echo '</nav>';
				}

				// Mobile - Secondary Menu
				if ( has_nav_menu( 'mobile_secondary' ) ) {
					$args = array(
						'theme_location' => 'mobile_secondary',
						'menu'           => 'Mobile - Secondary',
						'container'      => '',
						'container_id'   => '',
						'menu_class'     => '',
						'items_wrap'     => '<ul class="nav-list">%3$s</ul>',
					);

					echo '<nav class="nav-menu nav-mobile nav-secondary">';
					wp_nav_menu( $args );
					echo '</nav>';
				}
				?>
			</div>
		</div>
	</div>
	<?php
}

?>

<?php wp_footer(); ?>

</body>
</html>