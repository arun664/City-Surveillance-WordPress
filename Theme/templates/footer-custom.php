<?php
/**
 * The template to display default site footer
 *
 * @package WordPress
 * @subpackage PROLINGUA
 * @since PROLINGUA 1.0.10
 */

$prolingua_footer_scheme =  prolingua_is_inherit(prolingua_get_theme_option('footer_scheme')) ? prolingua_get_theme_option('color_scheme') : prolingua_get_theme_option('footer_scheme');
$prolingua_footer_id = str_replace('footer-custom-', '', prolingua_get_theme_option("footer_style"));
if ((int) $prolingua_footer_id == 0) {
	$prolingua_footer_id = prolingua_get_post_id(array(
												'name' => $prolingua_footer_id,
												'post_type' => defined('TRX_ADDONS_CPT_LAYOUT_PT') ? TRX_ADDONS_CPT_LAYOUT_PT : 'cpt_layouts'
												)
											);
} else {
	$prolingua_footer_id = apply_filters('prolingua_filter_get_translated_layout', $prolingua_footer_id);
}
$prolingua_footer_meta = get_post_meta($prolingua_footer_id, 'trx_addons_options', true);
?>
<footer class="footer_wrap footer_custom footer_custom_<?php echo esc_attr($prolingua_footer_id); 
						?> footer_custom_<?php echo esc_attr(sanitize_title(get_the_title($prolingua_footer_id))); 
						if (!empty($prolingua_footer_meta['margin']) != '') 
							echo ' '.esc_attr(prolingua_add_inline_css_class('margin-top: '.prolingua_prepare_css_value($prolingua_footer_meta['margin']).';'));
						?> scheme_<?php echo esc_attr($prolingua_footer_scheme); 
						?>">
	<?php
    // Custom footer's layout
    do_action('prolingua_action_show_layout', $prolingua_footer_id);
	?>
</footer><!-- /.footer_wrap -->
