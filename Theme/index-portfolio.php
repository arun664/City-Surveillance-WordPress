<?php
/**
 * The template for homepage posts with "Portfolio" style
 *
 * @package WordPress
 * @subpackage PROLINGUA
 * @since PROLINGUA 1.0
 */

prolingua_storage_set('blog_archive', true);

get_header(); 

if (have_posts()) {

	prolingua_show_layout(get_query_var('blog_archive_start'));

	$prolingua_stickies = is_home() ? get_option( 'sticky_posts' ) : false;
	$prolingua_sticky_out = prolingua_get_theme_option('sticky_style')=='columns' 
							&& is_array($prolingua_stickies) && count($prolingua_stickies) > 0 && get_query_var( 'paged' ) < 1;
	
	// Show filters
	$prolingua_cat = prolingua_get_theme_option('parent_cat');
	$prolingua_post_type = prolingua_get_theme_option('post_type');
	$prolingua_taxonomy = prolingua_get_post_type_taxonomy($prolingua_post_type);
	$prolingua_show_filters = prolingua_get_theme_option('show_filters');
	$prolingua_tabs = array();
	if (!prolingua_is_off($prolingua_show_filters)) {
		$prolingua_args = array(
			'type'			=> $prolingua_post_type,
			'child_of'		=> $prolingua_cat,
			'orderby'		=> 'name',
			'order'			=> 'ASC',
			'hide_empty'	=> 1,
			'hierarchical'	=> 0,
			'exclude'		=> '',
			'include'		=> '',
			'number'		=> '',
			'taxonomy'		=> $prolingua_taxonomy,
			'pad_counts'	=> false
		);
		$prolingua_portfolio_list = get_terms($prolingua_args);
		if (is_array($prolingua_portfolio_list) && count($prolingua_portfolio_list) > 0) {
			$prolingua_tabs[$prolingua_cat] = esc_html__('All', 'prolingua');
			foreach ($prolingua_portfolio_list as $prolingua_term) {
				if (isset($prolingua_term->term_id)) $prolingua_tabs[$prolingua_term->term_id] = $prolingua_term->name;
			}
		}
	}
	if (count($prolingua_tabs) > 0) {
		$prolingua_portfolio_filters_ajax = true;
		$prolingua_portfolio_filters_active = $prolingua_cat;
		$prolingua_portfolio_filters_id = 'portfolio_filters';
		if (!is_customize_preview())
			wp_enqueue_script('jquery-ui-tabs', false, array('jquery', 'jquery-ui-core'), null, true);
		?>
		<div class="portfolio_filters prolingua_tabs prolingua_tabs_ajax">
			<ul class="portfolio_titles prolingua_tabs_titles">
				<?php
				foreach ($prolingua_tabs as $prolingua_id=>$prolingua_title) {
					?><li><a href="<?php echo esc_url(prolingua_get_hash_link(sprintf('#%s_%s_content', $prolingua_portfolio_filters_id, $prolingua_id))); ?>" data-tab="<?php echo esc_attr($prolingua_id); ?>"><?php echo esc_html($prolingua_title); ?></a></li><?php
				}
				?>
			</ul>
			<?php
			$prolingua_ppp = prolingua_get_theme_option('posts_per_page');
			if (prolingua_is_inherit($prolingua_ppp)) $prolingua_ppp = '';
			foreach ($prolingua_tabs as $prolingua_id=>$prolingua_title) {
				$prolingua_portfolio_need_content = $prolingua_id==$prolingua_portfolio_filters_active || !$prolingua_portfolio_filters_ajax;
				?>
				<div id="<?php echo esc_attr(sprintf('%s_%s_content', $prolingua_portfolio_filters_id, $prolingua_id)); ?>"
					class="portfolio_content prolingua_tabs_content"
					data-blog-template="<?php echo esc_attr(prolingua_storage_get('blog_template')); ?>"
					data-blog-style="<?php echo esc_attr(prolingua_get_theme_option('blog_style')); ?>"
					data-posts-per-page="<?php echo esc_attr($prolingua_ppp); ?>"
					data-post-type="<?php echo esc_attr($prolingua_post_type); ?>"
					data-taxonomy="<?php echo esc_attr($prolingua_taxonomy); ?>"
					data-cat="<?php echo esc_attr($prolingua_id); ?>"
					data-parent-cat="<?php echo esc_attr($prolingua_cat); ?>"
					data-need-content="<?php echo (false===$prolingua_portfolio_need_content ? 'true' : 'false'); ?>"
				>
					<?php
					if ($prolingua_portfolio_need_content) 
						prolingua_show_portfolio_posts(array(
							'cat' => $prolingua_id,
							'parent_cat' => $prolingua_cat,
							'taxonomy' => $prolingua_taxonomy,
							'post_type' => $prolingua_post_type,
							'page' => 1,
							'sticky' => $prolingua_sticky_out
							)
						);
					?>
				</div>
				<?php
			}
			?>
		</div>
		<?php
	} else {
		prolingua_show_portfolio_posts(array(
			'cat' => $prolingua_cat,
			'parent_cat' => $prolingua_cat,
			'taxonomy' => $prolingua_taxonomy,
			'post_type' => $prolingua_post_type,
			'page' => 1,
			'sticky' => $prolingua_sticky_out
			)
		);
	}

	prolingua_show_layout(get_query_var('blog_archive_end'));

} else {

	if ( is_search() )
		get_template_part( 'content', 'none-search' );
	else
		get_template_part( 'content', 'none-archive' );

}

get_footer();
?>