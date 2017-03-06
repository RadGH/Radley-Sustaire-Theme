<?php

ob_start();

if(is_search()) {
	$postType = 'search';
} else {
	$postType = get_post_type();
}

if ( have_posts() ) :
	get_template_part( 'templates/parts/header-archive', $postType );
	while ( have_posts() ) : the_post();
		get_template_part( 'templates/loop/archive', $postType );
	endwhile;
	get_template_part( 'templates/parts/pagination-archive', $postType );
endif;

$content = ob_get_clean();

$title = wp_get_document_title();

echo json_encode(array('title'=>html_entity_decode($title),'content'=>$content));
