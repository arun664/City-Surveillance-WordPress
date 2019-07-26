<?php
/**
 * The Sidebar containing the main widget areas.
 *
 * @package WordPress
 * @subpackage PROLINGUA
 * @since PROLINGUA 1.0
 */

if (prolingua_sidebar_present()) {
	ob_start();
	$prolingua_sidebar_name = prolingua_get_theme_option('sidebar_widgets');
	prolingua_storage_set('current_sidebar', 'sidebar');
	if ( is_active_sidebar($prolingua_sidebar_name) ) {
		dynamic_sidebar($prolingua_sidebar_name);
	}
	$prolingua_out = trim(ob_get_contents());
	ob_end_clean();
	if (!empty($prolingua_out)) {
		$prolingua_sidebar_position = prolingua_get_theme_option('sidebar_position');
		?>
		<div class="sidebar <?php echo esc_attr($prolingua_sidebar_position); ?> widget_area<?php if (!prolingua_is_inherit(prolingua_get_theme_option('sidebar_scheme'))) echo ' scheme_'.esc_attr(prolingua_get_theme_option('sidebar_scheme')); ?>" role="complementary">
			<div class="sidebar_inner">
				<?php
				do_action( 'prolingua_action_before_sidebar' );
				prolingua_show_layout(preg_replace("/<\/aside>[\r\n\s]*<aside/", "</aside><aside", $prolingua_out));
				do_action( 'prolingua_action_after_sidebar' );
				?>
			</div><!-- /.sidebar_inner -->
		</div><!-- /.sidebar -->
		<?php
	}
}
?>