<?php
/**
 * The template to display blog archive
 *
 * @package WordPress
 * @subpackage PROLINGUA
 * @since PROLINGUA 1.0
 */

/*
Template Name: Blog archive
*/

/**
 * Make page with this template and put it into menu
 * to display posts as blog archive
 * You can setup output parameters (blog style, posts per page, parent category, etc.)
 * in the Theme Options section (under the page content)
 * You can build this page in the WordPress editor or any Page Builder to make custom page layout:
 * just insert %%CONTENT%% in the desired place of content
 */

// Get template page's content
$prolingua_content = '';
$prolingua_blog_archive_mask = '%%CONTENT%%';
$prolingua_blog_archive_subst = sprintf('<div class="blog_archive">%s</div>', $prolingua_blog_archive_mask);
if ( have_posts() ) {
	the_post();
	if (($prolingua_content = apply_filters('the_content', get_the_content())) != '') {
		if (($prolingua_pos = strpos($prolingua_content, $prolingua_blog_archive_mask)) !== false) {
			$prolingua_content = preg_replace('/(\<p\>\s*)?'.$prolingua_blog_archive_mask.'(\s*\<\/p\>)/i', $prolingua_blog_archive_subst, $prolingua_content);
		} else
			$prolingua_content .= $prolingua_blog_archive_subst;
		$prolingua_content = explode($prolingua_blog_archive_mask, $prolingua_content);
		// Add VC custom styles to the inline CSS
		$vc_custom_css = get_post_meta( get_the_ID(), '_wpb_shortcodes_custom_css', true );
		if ( !empty( $vc_custom_css ) ) prolingua_add_inline_css(strip_tags($vc_custom_css));
	}
}

// Prepare args for a new query
$prolingua_args = array(
	'post_status' => current_user_can('read_private_pages') && current_user_can('read_private_posts') ? array('publish', 'private') : 'publish'
);
$prolingua_args = prolingua_query_add_posts_and_cats($prolingua_args, '', prolingua_get_theme_option('post_type'), prolingua_get_theme_option('parent_cat'));
$prolingua_page_number = get_query_var('paged') ? get_query_var('paged') : (get_query_var('page') ? get_query_var('page') : 1);
if ($prolingua_page_number > 1) {
	$prolingua_args['paged'] = $prolingua_page_number;
	$prolingua_args['ignore_sticky_posts'] = true;
}
$prolingua_ppp = prolingua_get_theme_option('posts_per_page');
if ((int) $prolingua_ppp != 0)
	$prolingua_args['posts_per_page'] = (int) $prolingua_ppp;
// Make a new main query
$GLOBALS['wp_the_query']->query($prolingua_args);


// Add internal query vars in the new query!
if (is_array($prolingua_content) && count($prolingua_content) == 2) {
	set_query_var('blog_archive_start', $prolingua_content[0]);
	set_query_var('blog_archive_end', $prolingua_content[1]);
}

get_template_part('index');
?>