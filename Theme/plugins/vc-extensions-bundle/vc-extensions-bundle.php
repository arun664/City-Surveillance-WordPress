<?php
/* Visual Composer Extensions Bundle support functions
------------------------------------------------------------------------------- */

// Theme init priorities:
// 9 - register other filters (for installer, etc.)
if (!function_exists('prolingua_vc_extensions_theme_setup9')) {
	add_action( 'after_setup_theme', 'prolingua_vc_extensions_theme_setup9', 9 );
	function prolingua_vc_extensions_theme_setup9() {
		if (prolingua_exists_visual_composer()) {
			add_action( 'wp_enqueue_scripts', 								'prolingua_vc_extensions_frontend_scripts', 1100 );
			add_filter( 'prolingua_filter_merge_styles',						'prolingua_vc_extensions_merge_styles' );
		}
	
		if (is_admin()) {
			add_filter( 'prolingua_filter_tgmpa_required_plugins',		'prolingua_vc_extensions_tgmpa_required_plugins' );
		}
	}
}

// Filter to add in the required plugins list
if ( !function_exists( 'prolingua_vc_extensions_tgmpa_required_plugins' ) ) {
	//Handler of the add_filter('prolingua_filter_tgmpa_required_plugins',	'prolingua_vc_extensions_tgmpa_required_plugins');
	function prolingua_vc_extensions_tgmpa_required_plugins($list=array()) {
		if (prolingua_storage_isset('required_plugins', 'vc-extensions-bundle')) {
			$path = prolingua_get_file_dir('plugins/vc-extensions-bundle/vc-extensions-bundle.zip');
			if (!empty($path) || prolingua_get_theme_setting('tgmpa_upload')) {
				$list[] = array(
					'name' 		=> prolingua_storage_get_array('required_plugins', 'vc-extensions-bundle'),
					'slug' 		=> 'vc-extensions-bundle',
					'source'	=> !empty($path) ? $path : 'upload://vc-extensions-bundle.zip',
					'required' 	=> false
				);
			}
		}
		return $list;
	}
}

// Check if VC Extensions installed and activated
if ( !function_exists( 'prolingua_exists_vc_extensions' ) ) {
	function prolingua_exists_vc_extensions() {
		return class_exists('Vc_Manager') && class_exists('VC_Extensions_CQBundle');
	}
}
	
// Enqueue VC custom styles
if ( !function_exists( 'prolingua_vc_extensions_frontend_scripts' ) ) {
	//Handler of the add_action( 'wp_enqueue_scripts', 'prolingua_vc_extensions_frontend_scripts', 1100 );
	function prolingua_vc_extensions_frontend_scripts() {
		if (prolingua_is_on(prolingua_get_theme_option('debug_mode')) && prolingua_get_file_dir('plugins/vc-extensions-bundle/vc-extensions-bundle.css')!='')
			wp_enqueue_style( 'prolingua-vc-extensions-bundle',  prolingua_get_file_url('plugins/vc-extensions-bundle/vc-extensions-bundle.css'), array(), null );
	}
}
	
// Merge custom styles
if ( !function_exists( 'prolingua_vc_extensions_merge_styles' ) ) {
	//Handler of the add_filter('prolingua_filter_merge_styles', 'prolingua_vc_extensions_merge_styles');
	function prolingua_vc_extensions_merge_styles($list) {
		$list[] = 'plugins/vc-extensions-bundle/vc-extensions-bundle.css';
		return $list;
	}
}
?>