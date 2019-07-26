<?php
/**
 * The template to display posts in widgets and/or in the search results
 *
 * @package WordPress
 * @subpackage PROLINGUA
 * @since PROLINGUA 1.0
 */

$prolingua_post_id    = get_the_ID();
$prolingua_post_date  = prolingua_get_date();
$prolingua_post_title = get_the_title();
$prolingua_post_link  = get_permalink();
$prolingua_post_author_id   = get_the_author_meta('ID');
$prolingua_post_author_name = get_the_author_meta('display_name');
$prolingua_post_author_url  = get_author_posts_url($prolingua_post_author_id, '');

$prolingua_args = get_query_var('prolingua_args_widgets_posts');
$prolingua_show_date = isset($prolingua_args['show_date']) ? (int) $prolingua_args['show_date'] : 1;
$prolingua_show_image = isset($prolingua_args['show_image']) ? (int) $prolingua_args['show_image'] : 1;
$prolingua_show_author = isset($prolingua_args['show_author']) ? (int) $prolingua_args['show_author'] : 1;
$prolingua_show_counters = isset($prolingua_args['show_counters']) ? (int) $prolingua_args['show_counters'] : 1;
$prolingua_show_categories = isset($prolingua_args['show_categories']) ? (int) $prolingua_args['show_categories'] : 1;

$prolingua_output = prolingua_storage_get('prolingua_output_widgets_posts');

$prolingua_post_counters_output = '';
if ( $prolingua_show_counters ) {
	$prolingua_post_counters_output = '<span class="post_info_item post_info_counters">'
								. prolingua_get_post_counters('comments')
							. '</span>';
}


$prolingua_output .= '<article class="post_item with_thumb">';

if ($prolingua_show_image) {
	$prolingua_post_thumb = get_the_post_thumbnail($prolingua_post_id, prolingua_get_thumb_size('tiny'), array(
		'alt' => get_the_title()
	));
	if ($prolingua_post_thumb) $prolingua_output .= '<div class="post_thumb">' . ($prolingua_post_link ? '<a href="' . esc_url($prolingua_post_link) . '">' : '') . ($prolingua_post_thumb) . ($prolingua_post_link ? '</a>' : '') . '</div>';
}

$prolingua_output .= '<div class="post_content">'
			. ($prolingua_show_categories 
					? '<div class="post_categories">'
						. prolingua_get_post_categories()
						. $prolingua_post_counters_output
						. '</div>' 
					: '')
			. '<h6 class="post_title">' . ($prolingua_post_link ? '<a href="' . esc_url($prolingua_post_link) . '">' : '') . ($prolingua_post_title) . ($prolingua_post_link ? '</a>' : '') . '</h6>'
			. apply_filters('prolingua_filter_get_post_info', 
								'<div class="post_info">'
									. ($prolingua_show_date 
										? '<span class="post_info_item post_info_posted">'
											. ($prolingua_post_link ? '<a href="' . esc_url($prolingua_post_link) . '" class="post_info_date">' : '') 
											. esc_html($prolingua_post_date) 
											. ($prolingua_post_link ? '</a>' : '')
											. '</span>'
										: '')
									. ($prolingua_show_author 
										? '<span class="post_info_item post_info_posted_by">' 
											. esc_html__('by', 'prolingua') . ' ' 
											. ($prolingua_post_link ? '<a href="' . esc_url($prolingua_post_author_url) . '" class="post_info_author">' : '') 
											. esc_html($prolingua_post_author_name) 
											. ($prolingua_post_link ? '</a>' : '') 
											. '</span>'
										: '')
									. (!$prolingua_show_categories && $prolingua_post_counters_output
										? $prolingua_post_counters_output
										: '')
								. '</div>')
		. '</div>'
	. '</article>';
prolingua_storage_set('prolingua_output_widgets_posts', $prolingua_output);
?>