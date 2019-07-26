<?php
/**
 * The template to display the logo or the site name and the slogan in the Header
 *
 * @package WordPress
 * @subpackage PROLINGUA
 * @since PROLINGUA 1.0
 */

$prolingua_args = get_query_var('prolingua_logo_args');

// Site logo
$prolingua_logo_type   = isset($prolingua_args['type']) ? $prolingua_args['type'] : '';
$prolingua_logo_image  = prolingua_get_logo_image($prolingua_logo_type);
$prolingua_logo_text   = prolingua_is_on(prolingua_get_theme_option('logo_text')) ? get_bloginfo( 'name' ) : '';
$prolingua_logo_slogan = get_bloginfo( 'description', 'display' );
if (!empty($prolingua_logo_image) || !empty($prolingua_logo_text)) {
	?><a class="sc_layouts_logo" href="<?php echo is_front_page() ? '#' : esc_url(home_url('/')); ?>"><?php
		if (!empty($prolingua_logo_image)) {
			if (empty($prolingua_logo_type) && function_exists('the_custom_logo') && (int) $prolingua_logo_image > 0) {
				the_custom_logo();
			} else {
				$prolingua_attr = prolingua_getimagesize($prolingua_logo_image);
				echo '<img src="'.esc_url($prolingua_logo_image).'" alt="'.esc_attr__('img', 'prolingua').'"'.(!empty($prolingua_attr[3]) ? ' '.wp_kses_data($prolingua_attr[3]) : '').'>';
			}
		} else {
			prolingua_show_layout(prolingua_prepare_macros($prolingua_logo_text), '<span class="logo_text">', '</span>');
			prolingua_show_layout(prolingua_prepare_macros($prolingua_logo_slogan), '<span class="logo_slogan">', '</span>');
		}
	?></a><?php
}
?>