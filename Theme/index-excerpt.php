<?php
/**
 * The template for homepage posts with "Excerpt" style
 *
 * @package WordPress
 * @subpackage PROLINGUA
 * @since PROLINGUA 1.0
 */

prolingua_storage_set('blog_archive', true);

get_header(); 

if (have_posts()) {

	prolingua_show_layout(get_query_var('blog_archive_start'));

	?><div class="posts_container"><?php
	
	$prolingua_stickies = is_home() ? get_option( 'sticky_posts' ) : false;
	$prolingua_sticky_out = prolingua_get_theme_option('sticky_style')=='columns' 
							&& is_array($prolingua_stickies) && count($prolingua_stickies) > 0 && get_query_var( 'paged' ) < 1;
	if ($prolingua_sticky_out) {
		?><div class="sticky_wrap columns_wrap"><?php	
	}
	while ( have_posts() ) { the_post(); 
		if ($prolingua_sticky_out && !is_sticky()) {
			$prolingua_sticky_out = false;
			?></div><?php
		}
		get_template_part( 'content', $prolingua_sticky_out && is_sticky() ? 'sticky' : 'excerpt' );
	}
	if ($prolingua_sticky_out) {
		$prolingua_sticky_out = false;
		?></div><?php
	}
	
	?></div><?php

	prolingua_show_pagination();

	prolingua_show_layout(get_query_var('blog_archive_end'));

} else {

	if ( is_search() )
		get_template_part( 'content', 'none-search' );
	else
		get_template_part( 'content', 'none-archive' );

}

get_footer();
?>