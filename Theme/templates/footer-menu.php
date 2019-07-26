<?php
/**
 * The template to display menu in the footer
 *
 * @package WordPress
 * @subpackage PROLINGUA
 * @since PROLINGUA 1.0.10
 */

// Footer menu
$prolingua_menu_footer = prolingua_get_nav_menu(array(
											'location' => 'menu_footer',
											'class' => 'sc_layouts_menu sc_layouts_menu_default'
											));
if (!empty($prolingua_menu_footer)) {
	?>
	<div class="footer_menu_wrap">
		<div class="footer_menu_inner">
			<?php prolingua_show_layout($prolingua_menu_footer); ?>
		</div>
	</div>
	<?php
}
?>