<?php

// Include Files
include_once 'includes/functions/general.php'; // general functions, customizations
include_once 'includes/functions/dashboard.php'; // logged-in customizations; includes login screen, dashboard, editor, etc
include_once 'includes/functions/dashboard-settings.php'; // adds fields to Settings pages, incl new image sizes and email addresses
include_once 'includes/functions/rss.php'; // improves RSS feeds, adds featured images and image size
include_once 'includes/functions/sharing.php'; // generates sharing links for pages/posts/etc
include_once 'includes/functions/internal.php'; // changes to wordpress core; avoid adding to this file unless necessary
include_once 'includes/functions/plugin-acf.php'; // ACF extensions
include_once 'includes/functions/plugin-yoast.php'; // Yoast extensions


// Theme Configuration
function theme_scripts() {
	$theme = wp_get_theme();
	$theme_version = $theme->get( 'Version' );

	wp_enqueue_style( get_stylesheet(), get_stylesheet_uri(), array(), $theme_version );
	wp_enqueue_script( 'main', get_template_directory_uri() . '/includes/assets/main.js' , array('jquery'), $theme_version );
}
add_action( 'wp_enqueue_scripts', 'theme_scripts' );

function theme_setup() {

	// 1. Theme Features
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'html5', array( 'comment-list', 'comment-form', 'search-form', 'gallery', 'caption' ) );
	
	// 2. Menus
	$menus = array(
		'header_primary'   => 'Header - Primary',
		'header_secondary' => 'Header - Secondary',

		'footer_primary'   => 'Footer - Primary',
		'footer_secondary' => 'Footer - Secondary',

		'mobile_primary'   => 'Mobile - Primary',
		'mobile_secondary' => 'Mobile - Secondary',
	);
	register_nav_menus($menus);
	
	// 3. Sidebars
	$sidebars = array(
		'sidebar'    => array(
			'Sidebar',
			'Default sidebar.',
		),
		'store'      => array(
			'Store',
			'WooCommerce store sidebar.',
		),
		'checkout'   => array(
			'Checkout',
			'WooCommerce checkout page sidebar.',
		),
		'conversion'     => array(
			'Conversion Page',
			'"Conversion Page" template sidebar.',
		),
	);

	foreach ( $sidebars as $key => $bar ) {
		register_sidebar( array(
			'id'          => $key,
			'name'        => $bar[0],
			'description' => $bar[1],

			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>'
		));
	}
	
	// 4. Widgets
	include_once 'includes/widgets/socialMediaButtons.php';
	
	// 5. Shortcodes
	add_shortcode( 'year', function () { return date('Y'); } );
}
add_action( 'after_setup_theme', 'theme_setup' );