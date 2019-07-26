<?php
/**
 * The Portfolio template to display the content
 *
 * Used for index/archive/search.
 *
 * @package WordPress
 * @subpackage PROLINGUA
 * @since PROLINGUA 1.0
 */

$prolingua_blog_style = explode('_', prolingua_get_theme_option('blog_style'));
$prolingua_columns = empty($prolingua_blog_style[1]) ? 2 : max(2, $prolingua_blog_style[1]);
$prolingua_post_format = get_post_format();
$prolingua_post_format = empty($prolingua_post_format) ? 'standard' : str_replace('post-format-', '', $prolingua_post_format);
$prolingua_animation = prolingua_get_theme_option('blog_animation');

?><article id="post-<?php the_ID(); ?>" 
	<?php post_class( 'post_item post_layout_portfolio post_layout_portfolio_'.esc_attr($prolingua_columns).' post_format_'.esc_attr($prolingua_post_format).(is_sticky() && !is_paged() ? ' sticky' : '') ); ?>
	<?php echo (!prolingua_is_off($prolingua_animation) ? ' data-animation="'.esc_attr(prolingua_get_animation_classes($prolingua_animation)).'"' : ''); ?>>
	<?php

	// Sticky label
	if ( is_sticky() && !is_paged() ) {
		?><span class="post_label label_sticky"></span><?php
	}

	$prolingua_image_hover = prolingua_get_theme_option('image_hover');
	// Featured image
	prolingua_show_post_featured(array(
		'thumb_size' => prolingua_get_thumb_size(strpos(prolingua_get_theme_option('body_style'), 'full')!==false || $prolingua_columns < 3 
								? 'masonry-big' 
								: 'masonry'),
		'show_no_image' => true,
		'class' => $prolingua_image_hover == 'dots' ? 'hover_with_info' : '',
		'post_info' => $prolingua_image_hover == 'dots' ? '<div class="post_info">'.esc_html(get_the_title()).'</div>' : ''
	));
	?>
</article>