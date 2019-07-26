<?php
/**
 * The template to display the widgets area in the header
 *
 * @package WordPress
 * @subpackage PROLINGUA
 * @since PROLINGUA 1.0
 */

// Header sidebar
$prolingua_header_name = prolingua_get_theme_option('header_widgets');
$prolingua_header_present = !prolingua_is_off($prolingua_header_name) && is_active_sidebar($prolingua_header_name);
if ($prolingua_header_present) { 
	prolingua_storage_set('current_sidebar', 'header');
	$prolingua_header_wide = prolingua_get_theme_option('header_wide');
	ob_start();
	if ( is_active_sidebar($prolingua_header_name) ) {
		dynamic_sidebar($prolingua_header_name);
	}
	$prolingua_widgets_output = ob_get_contents();
	ob_end_clean();
	if (!empty($prolingua_widgets_output)) {
		$prolingua_widgets_output = preg_replace("/<\/aside>[\r\n\s]*<aside/", "</aside><aside", $prolingua_widgets_output);
		$prolingua_need_columns = strpos($prolingua_widgets_output, 'columns_wrap')===false;
		if ($prolingua_need_columns) {
			$prolingua_columns = max(0, (int) prolingua_get_theme_option('header_columns'));
			if ($prolingua_columns == 0) $prolingua_columns = min(6, max(1, substr_count($prolingua_widgets_output, '<aside ')));
			if ($prolingua_columns > 1)
				$prolingua_widgets_output = preg_replace("/class=\"widget /", "class=\"column-1_".esc_attr($prolingua_columns).' widget ', $prolingua_widgets_output);
			else
				$prolingua_need_columns = false;
		}
		?>
		<div class="header_widgets_wrap widget_area<?php echo !empty($prolingua_header_wide) ? ' header_fullwidth' : ' header_boxed'; ?>">
			<div class="header_widgets_inner widget_area_inner">
				<?php 
				if (!$prolingua_header_wide) { 
					?><div class="content_wrap"><?php
				}
				if ($prolingua_need_columns) {
					?><div class="columns_wrap"><?php
				}
				do_action( 'prolingua_action_before_sidebar' );
				prolingua_show_layout($prolingua_widgets_output);
				do_action( 'prolingua_action_after_sidebar' );
				if ($prolingua_need_columns) {
					?></div>	<!-- /.columns_wrap --><?php
				}
				if (!$prolingua_header_wide) {
					?></div>	<!-- /.content_wrap --><?php
				}
				?>
			</div>	<!-- /.header_widgets_inner -->
		</div>	<!-- /.header_widgets_wrap -->
		<?php
	}
}
?>