<?php
/**
 * The template to display custom header from the ThemeREX Addons Layouts
 *
 * @package WordPress
 * @subpackage PROLINGUA
 * @since PROLINGUA 1.0.06
 */

$prolingua_header_css = $prolingua_header_image = '';
$prolingua_header_video = prolingua_get_header_video();
if (true || empty($prolingua_header_video)) {
	$prolingua_header_image = get_header_image();
	if (prolingua_trx_addons_featured_image_override()) $prolingua_header_image = prolingua_get_current_mode_image($prolingua_header_image);
}

$prolingua_header_id = str_replace('header-custom-', '', prolingua_get_theme_option("header_style"));
if ((int) $prolingua_header_id == 0) {
	$prolingua_header_id = prolingua_get_post_id(array(
												'name' => $prolingua_header_id,
												'post_type' => defined('TRX_ADDONS_CPT_LAYOUT_PT') ? TRX_ADDONS_CPT_LAYOUT_PT : 'cpt_layouts'
												)
											);
} else {
	$prolingua_header_id = apply_filters('prolingua_filter_get_translated_layout', $prolingua_header_id);
}
$prolingua_header_meta = get_post_meta($prolingua_header_id, 'trx_addons_options', true);

?><header class="top_panel top_panel_custom top_panel_custom_<?php echo esc_attr($prolingua_header_id); 
				?> top_panel_custom_<?php echo esc_attr(sanitize_title(get_the_title($prolingua_header_id)));
				echo !empty($prolingua_header_image) || !empty($prolingua_header_video) 
					? ' with_bg_image' 
					: ' without_bg_image';
				if ($prolingua_header_video!='') 
					echo ' with_bg_video';
				if ($prolingua_header_image!='') 
					echo ' '.esc_attr(prolingua_add_inline_css_class('background-image: url('.esc_url($prolingua_header_image).');'));
				if (!empty($prolingua_header_meta['margin']) != '') 
					echo ' '.esc_attr(prolingua_add_inline_css_class('margin-bottom: '.esc_attr(prolingua_prepare_css_value($prolingua_header_meta['margin'])).';'));
				if (is_single() && has_post_thumbnail()) 
					echo ' with_featured_image';
				if (prolingua_is_on(prolingua_get_theme_option('header_fullheight'))) 
					echo ' header_fullheight prolingua-full-height';
				?> scheme_<?php echo esc_attr(prolingua_is_inherit(prolingua_get_theme_option('header_scheme')) 
												? prolingua_get_theme_option('color_scheme') 
												: prolingua_get_theme_option('header_scheme'));
				?>"><?php

	// Background video
	if (!empty($prolingua_header_video)) {
		get_template_part( 'templates/header-video' );
	}
		
	// Custom header's layout
	do_action('prolingua_action_show_layout', $prolingua_header_id);

	// Header widgets area
	get_template_part( 'templates/header-widgets' );
		
?></header>