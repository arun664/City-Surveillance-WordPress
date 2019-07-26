<?php
/**
 * The template to display the socials in the footer
 *
 * @package WordPress
 * @subpackage PROLINGUA
 * @since PROLINGUA 1.0.10
 */


// Socials
if ( prolingua_is_on(prolingua_get_theme_option('socials_in_footer')) && ($prolingua_output = prolingua_get_socials_links()) != '') {
	?>
	<div class="footer_socials_wrap socials_wrap">
		<div class="footer_socials_inner">
			<?php prolingua_show_layout($prolingua_output); ?>
		</div>
	</div>
	<?php
}
?>