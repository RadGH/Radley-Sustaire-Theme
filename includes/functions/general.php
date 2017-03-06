<?php

// Add charset and viewport tags to <head>
function rs_meta_tags() {
	?>
	<meta charset="<?php echo esc_attr( get_bloginfo( 'charset' ) ); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<?php
}

add_action( 'wp_head', 'rs_meta_tags', 1 );

// Customize the title of the page
function rs_custom_archive_title( $title ) {
	// For taxonomies, show the term name instead of "Archive: {Term Name}"
	if ( is_tax() || is_category() ) {
		$title = single_term_title();
	}

	return $title;
}

add_filter( 'get_the_archive_title', 'rs_custom_archive_title', 10, 2 );