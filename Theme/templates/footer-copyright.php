<?php
/**
 * The template to display the copyright info in the footer
 *
 * @package WordPress
 * @subpackage PROLINGUA
 * @since PROLINGUA 1.0.10
 */

// Copyright area
$prolingua_footer_scheme =  prolingua_is_inherit(prolingua_get_theme_option('footer_scheme')) ? prolingua_get_theme_option('color_scheme') : prolingua_get_theme_option('footer_scheme');
$prolingua_copyright_scheme = prolingua_is_inherit(prolingua_get_theme_option('copyright_scheme')) ? $prolingua_footer_scheme : prolingua_get_theme_option('copyright_scheme');
?> 
<div class="footer_copyright_wrap scheme_<?php echo esc_attr($prolingua_copyright_scheme); ?>">
	<div class="footer_copyright_inner">
		<div class="content_wrap">
			<div class="copyright_text"><?php
				// Replace {{...}} and ((...)) on the <i>...</i> and <b>...</b>
				$prolingua_copyright = prolingua_prepare_macros(prolingua_get_theme_option('copyright'));
				if (!empty($prolingua_copyright)) {
					// Replace {date_format} on the current date in the specified format
					if (preg_match("/(\\{[\\w\\d\\\\\\-\\:]*\\})/", $prolingua_copyright, $prolingua_matches)) {
						$prolingua_copyright = str_replace($prolingua_matches[1], date_i18n(str_replace(array('{', '}'), '', $prolingua_matches[1])), $prolingua_copyright);
					}
					// Display copyright
					echo wp_kses_data(nl2br($prolingua_copyright));
				}
			?></div>
		</div>
	</div>
</div>
