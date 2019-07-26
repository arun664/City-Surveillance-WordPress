<?php
/* Revolution Slider support functions
------------------------------------------------------------------------------- */

// Theme init priorities:
// 9 - register other filters (for installer, etc.)
if (!function_exists('prolingua_revslider_theme_setup9')) {
	add_action( 'after_setup_theme', 'prolingua_revslider_theme_setup9', 9 );
	function prolingua_revslider_theme_setup9() {
		if (prolingua_exists_revslider()) {
			add_action( 'wp_enqueue_scripts', 					'prolingua_revslider_frontend_scripts', 1100 );
			add_filter( 'prolingua_filter_merge_styles',			'prolingua_revslider_merge_styles' );
		}
		if (is_admin()) {
			add_filter( 'prolingua_filter_tgmpa_required_plugins','prolingua_revslider_tgmpa_required_plugins' );
		}
	}
}

// Filter to add in the required plugins list
if ( !function_exists( 'prolingua_revslider_tgmpa_required_plugins' ) ) {
	//Handler of the add_filter('prolingua_filter_tgmpa_required_plugins',	'prolingua_revslider_tgmpa_required_plugins');
	function prolingua_revslider_tgmpa_required_plugins($list=array()) {
		if (prolingua_storage_isset('required_plugins', 'revslider')) {
			$path = prolingua_get_file_dir('plugins/revslider/revslider.zip');
			if (!empty($path) || prolingua_get_theme_setting('tgmpa_upload')) {
				$list[] = array(
					'name' 		=> prolingua_storage_get_array('required_plugins', 'revslider'),
					'slug' 		=> 'revslider',
					'source'	=> !empty($path) ? $path : 'upload://revslider.zip',
					'required' 	=> false
				);
			}
		}
		return $list;
	}
}

// Check if RevSlider installed and activated
if ( !function_exists( 'prolingua_exists_revslider' ) ) {
	function prolingua_exists_revslider() {
		return function_exists('rev_slider_shortcode');
	}
}
	
// Enqueue custom styles
if ( !function_exists( 'prolingua_revslider_frontend_scripts' ) ) {
	//Handler of the add_action( 'wp_enqueue_scripts', 'prolingua_revslider_frontend_scripts', 1100 );
	function prolingua_revslider_frontend_scripts() {
		if (prolingua_is_on(prolingua_get_theme_option('debug_mode')) && prolingua_get_file_dir('plugins/revslider/revslider.css')!='')
			wp_enqueue_style( 'prolingua-revslider',  prolingua_get_file_url('plugins/revslider/revslider.css'), array(), null );
	}
}
	
// Merge custom styles
if ( !function_exists( 'prolingua_revslider_merge_styles' ) ) {
	//Handler of the add_filter('prolingua_filter_merge_styles', 'prolingua_revslider_merge_styles');
	function prolingua_revslider_merge_styles($list) {
		$list[] = 'plugins/revslider/revslider.css';
		return $list;
	}
}
?>