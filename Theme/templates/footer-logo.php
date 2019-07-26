<?php
/**
 * The template to display the site logo in the footer
 *
 * @package WordPress
 * @subpackage PROLINGUA
 * @since PROLINGUA 1.0.10
 */

// Logo
if (prolingua_is_on(prolingua_get_theme_option('logo_in_footer'))) {
	$prolingua_logo_image = '';
	if (prolingua_is_on(prolingua_get_theme_option('logo_retina_enabled')) && prolingua_get_retina_multiplier(2) > 1)
		$prolingua_logo_image = prolingua_get_theme_option( 'logo_footer_retina' );
	if (empty($prolingua_logo_image)) 
		$prolingua_logo_image = prolingua_get_theme_option( 'logo_footer' );
	$prolingua_logo_text   = get_bloginfo( 'name' );
	if (!empty($prolingua_logo_image) || !empty($prolingua_logo_text)) {
		?>
		<div class="footer_logo_wrap">
			<div class="footer_logo_inner">
				<?php
				if (!empty($prolingua_logo_image)) {
					$prolingua_attr = prolingua_getimagesize($prolingua_logo_image);
					echo '<a href="'.esc_url(home_url('/')).'"><img src="'.esc_url($prolingua_logo_image).'" class="logo_footer_image" alt="'.esc_attr__('img', 'prolingua').'"'.(!empty($prolingua_attr[3]) ? ' ' . wp_kses_data($prolingua_attr[3]) : '').'></a>' ;
				} else if (!empty($prolingua_logo_text)) {
					echo '<h1 class="logo_footer_text"><a href="'.esc_url(home_url('/')).'">' . esc_html($prolingua_logo_text) . '</a></h1>';
				}
				?>
			</div>
		</div>
		<?php
	}
}
?>