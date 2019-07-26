<?php
/**
 * The template to display default site header
 *
 * @package WordPress
 * @subpackage PROLINGUA
 * @since PROLINGUA 1.0
 */


$prolingua_header_css = $prolingua_header_image = '';
$prolingua_header_video = prolingua_get_header_video();
if (true || empty($prolingua_header_video)) {
	$prolingua_header_image = get_header_image();
	if (prolingua_trx_addons_featured_image_override()) $prolingua_header_image = prolingua_get_current_mode_image($prolingua_header_image);
}

?><header class="top_panel top_panel_default<?php
					echo !empty($prolingua_header_image) || !empty($prolingua_header_video) ? ' with_bg_image' : ' without_bg_image';
					if ($prolingua_header_video!='') echo ' with_bg_video';
					if ($prolingua_header_image!='') echo ' '.esc_attr(prolingua_add_inline_css_class('background-image: url('.esc_url($prolingua_header_image).');'));
					if (is_single() && has_post_thumbnail()) echo ' with_featured_image';
					if (prolingua_is_on(prolingua_get_theme_option('header_fullheight'))) echo ' header_fullheight prolingua-full-height';
					?> scheme_<?php echo esc_attr(prolingua_is_inherit(prolingua_get_theme_option('header_scheme')) 
													? prolingua_get_theme_option('color_scheme') 
													: prolingua_get_theme_option('header_scheme'));
					?>"><?php

	// Background video
	if (!empty($prolingua_header_video)) {
		get_template_part( 'templates/header-video' );
	}
	
	// Main menu
	if (prolingua_get_theme_option("menu_style") == 'top') {
		get_template_part( 'templates/header-navi' );
	}

	// Page title and breadcrumbs area
	get_template_part( 'templates/header-title');

	// Header widgets area
	get_template_part( 'templates/header-widgets' );

?></header>