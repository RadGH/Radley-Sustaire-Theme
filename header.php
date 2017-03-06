<!doctype html>
<html <?php language_attributes(); ?>>
<head>
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>

<div class="inside mobile-menu-button-wrapper">
	<button type="button" class="mobile-menu-button">
			<span class="menu-bars">
				<span></span>
				<span></span>
				<span></span>
			</span>
		<span class="mobile-text">
				<span class="mobile-hidden">Menu</span>
				<span class="mobile-visible">Close</span>
			</span>
	</button>
</div>

<a href="he" class="screen-reader-text">hello world</a>

<div class="site-container">
	<header class="site-header">
		<div class="inside">
			<?php

			// Logo
			if ( $logo_id = get_field( 'logo', 'options', false ) ) {
				if ( $img_tag = wp_get_attachment_image( $logo_id, 'large' ) ) {
					printf( '<a href="%s" title="%s" class="logo">%s</a>', esc_attr( home_url() ), esc_attr( get_bloginfo( 'title' ) ), $img_tag );
				}
			}

			// Primary Menu
			if ( has_nav_menu('header_primary') ) {
				$args = array(
					'theme_location' => 'header_primary',
					'menu'           => 'Header - Primary',
					'container'      => '',
					'container_id'   => '',
					'menu_class'     => '',
					'items_wrap'     => '<ul class="nav-list">%3$s</ul>',
				);

				echo '<nav class="nav-menu nav-header nav-primary">';
				wp_nav_menu($args);
				echo '</nav>';
			}

			// Secondary Menu
			if ( has_nav_menu('header_secondary') ) {
				$args = array(
					'theme_location' => 'header_secondary',
					'menu'           => 'Header - Secondary',
					'container'      => '',
					'container_id'   => '',
					'menu_class'     => '',
					'items_wrap'     => '<ul class="nav-list">%3$s</ul>',
				);

				echo '<nav class="nav-menu nav-header nav-secondary">';
				wp_nav_menu($args);
				echo '</nav>';
			}
			?>
		</div>
	</header>


	<div id="content"<?php if ( apply_filters( "sidebar_enabled", true ) ) {echo ' class=" has-sidebar"';} ?>>