<?php
/* gdpr-compliance support functions
------------------------------------------------------------------------------- */

// Theme init priorities:
// 9 - register other filters (for installer, etc.)
if (!function_exists('prolingua_gdpr_theme_setup9')) {
	add_action( 'after_setup_theme', 'prolingua_gdpr_theme_setup9', 9 );
	function prolingua_gdpr_theme_setup9() {

		if (prolingua_exists_gdpr()) {
			add_filter( 'prolingua_filter_merge_styles',						'prolingua_gdpr_merge_styles' );
		}
		if (is_admin()) {
			add_filter( 'prolingua_filter_tgmpa_required_plugins',			'prolingua_gdpr_tgmpa_required_plugins' );
		}
	}
}

// Filter to add in the required plugins list
if ( !function_exists( 'prolingua_gdpr_tgmpa_required_plugins' ) ) {
	//Handler of the add_filter('prolingua_filter_tgmpa_required_plugins',	'prolingua_gdpr_tgmpa_required_plugins');
	function prolingua_gdpr_tgmpa_required_plugins($list=array()) {
        if (prolingua_storage_isset('required_plugins', 'wp-gdpr-compliance')) {
			$list[] = array(
				'name' 		=> esc_html__('WP GDPR Compliance', 'prolingua'),
				'slug' 		=> 'wp-gdpr-compliance',
				'required' 	=> false
			);

		}
		return $list;
	}
}

// Check if gdpr installed and activated
if ( !function_exists( 'prolingua_exists_gdpr' ) ) {
	function prolingua_exists_gdpr() {
		return class_exists('GDPR_VERSION');
	}
}