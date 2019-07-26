<?php
/**
 * The template to display the widgets area in the footer
 *
 * @package WordPress
 * @subpackage PROLINGUA
 * @since PROLINGUA 1.0.10
 */

// Footer sidebar
$prolingua_footer_name = prolingua_get_theme_option('footer_widgets');
$prolingua_footer_present = !prolingua_is_off($prolingua_footer_name) && is_active_sidebar($prolingua_footer_name);
if ($prolingua_footer_present) { 
	prolingua_storage_set('current_sidebar', 'footer');
	$prolingua_footer_wide = prolingua_get_theme_option('footer_wide');
	ob_start();
	if ( is_active_sidebar($prolingua_footer_name) ) {
		dynamic_sidebar($prolingua_footer_name);
	}
	$prolingua_out = trim(ob_get_contents());
	ob_end_clean();
	if (!empty($prolingua_out)) {
		$prolingua_out = preg_replace("/<\\/aside>[\r\n\s]*<aside/", "</aside><aside", $prolingua_out);
		$prolingua_need_columns = true;
		if ($prolingua_need_columns) {
			$prolingua_columns = max(0, (int) prolingua_get_theme_option('footer_columns'));
			if ($prolingua_columns == 0) $prolingua_columns = min(4, max(1, substr_count($prolingua_out, '<aside ')));
			if ($prolingua_columns > 1)
				$prolingua_out = preg_replace("/class=\"widget /", "class=\"column-1_".esc_attr($prolingua_columns).' widget ', $prolingua_out);
			else
				$prolingua_need_columns = false;
		}
		?>
		<div class="footer_widgets_wrap widget_area<?php echo !empty($prolingua_footer_wide) ? ' footer_fullwidth' : ''; ?> sc_layouts_row  sc_layouts_row_type_normal">
			<div class="footer_widgets_inner widget_area_inner">
				<?php 
				if (!$prolingua_footer_wide) { 
					?><div class="content_wrap"><?php
				}
				if ($prolingua_need_columns) {
					?><div class="columns_wrap"><?php
				}
				do_action( 'prolingua_action_before_sidebar' );
				prolingua_show_layout($prolingua_out);
				do_action( 'prolingua_action_after_sidebar' );
				if ($prolingua_need_columns) {
					?></div><!-- /.columns_wrap --><?php
				}
				if (!$prolingua_footer_wide) {
					?></div><!-- /.content_wrap --><?php
				}
				?>
			</div><!-- /.footer_widgets_inner -->
		</div><!-- /.footer_widgets_wrap -->
		<?php
	}
}
?>