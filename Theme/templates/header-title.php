<?php
/**
 * The template to display the page title and breadcrumbs
 *
 * @package WordPress
 * @subpackage PROLINGUA
 * @since PROLINGUA 1.0
 */

// Page (category, tag, archive, author) title

if ( prolingua_need_page_title() ) {
	prolingua_sc_layouts_showed('title', true);
	prolingua_sc_layouts_showed('postmeta', true);
	?>
	<div class="top_panel_title sc_layouts_row sc_layouts_row_type_normal">
		<div class="content_wrap">
			<div class="sc_layouts_column sc_layouts_column_align_center">
				<div class="sc_layouts_item">
					<div class="sc_layouts_title sc_align_center">
						<?php

                        // Breadcrumbs
                        if (prolingua_exists_trx_addons()) {
                        ?><div class="sc_layouts_title_breadcrumbs"><?php
                            do_action('prolingua_action_breadcrumbs');
                            ?></div><?php
                        }
						// Blog/Post title
						?><div class="sc_layouts_title_title"><?php
							$prolingua_blog_title = prolingua_get_blog_title();
							$prolingua_blog_title_text = $prolingua_blog_title_class = $prolingua_blog_title_link = $prolingua_blog_title_link_text = '';
							if (is_array($prolingua_blog_title)) {
								$prolingua_blog_title_text = $prolingua_blog_title['text'];
								$prolingua_blog_title_class = !empty($prolingua_blog_title['class']) ? ' '.$prolingua_blog_title['class'] : '';
								$prolingua_blog_title_link = !empty($prolingua_blog_title['link']) ? $prolingua_blog_title['link'] : '';
								$prolingua_blog_title_link_text = !empty($prolingua_blog_title['link_text']) ? $prolingua_blog_title['link_text'] : '';
							} else
								$prolingua_blog_title_text = $prolingua_blog_title;
							?>
							<h1 itemprop="headline" class="sc_layouts_title_caption<?php echo esc_attr($prolingua_blog_title_class); ?>"><?php
								$prolingua_top_icon = prolingua_get_category_icon();
								if (!empty($prolingua_top_icon)) {
									$prolingua_attr = prolingua_getimagesize($prolingua_top_icon);
									?><img src="<?php echo esc_url($prolingua_top_icon); ?>" alt="'.esc_attr__('img', 'prolingua').'" <?php if (!empty($prolingua_attr[3])) prolingua_show_layout($prolingua_attr[3]);?>><?php
								}
								echo wp_kses_data($prolingua_blog_title_text);
							?></h1>
							<?php
							if (!empty($prolingua_blog_title_link) && !empty($prolingua_blog_title_link_text)) {
								?><a href="<?php echo esc_url($prolingua_blog_title_link); ?>" class="theme_button theme_button_small sc_layouts_title_link"><?php echo esc_html($prolingua_blog_title_link_text); ?></a><?php
							}

                            // Post meta on the single post
                            if ( is_single() )  {
                                ?><div class="sc_layouts_title_meta"><?php
                                prolingua_show_post_meta(apply_filters('prolingua_filter_post_meta_args', array(
                                        'components' => 'author,date,counters,edit',
                                        'counters' => 'views,comments,likes',
                                        'seo' => true
                                    ), 'header', 1)
                                );
                                ?></div><?php
                            }

                            // Category/Tag description
							if ( is_category() || is_tag() || is_tax() ) 
								the_archive_description( '<div class="sc_layouts_title_description">', '</div>' );
		
						?></div>

					</div>
				</div>
			</div>
		</div>
	</div>
	<?php
}
?>