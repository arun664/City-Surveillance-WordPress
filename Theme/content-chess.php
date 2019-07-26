<?php
/**
 * The Classic template to display the content
 *
 * Used for index/archive/search.
 *
 * @package WordPress
 * @subpackage PROLINGUA
 * @since PROLINGUA 1.0
 */

$prolingua_blog_style = explode('_', prolingua_get_theme_option('blog_style'));
$prolingua_columns = empty($prolingua_blog_style[1]) ? 1 : max(1, $prolingua_blog_style[1]);
$prolingua_expanded = !prolingua_sidebar_present() && prolingua_is_on(prolingua_get_theme_option('expand_content'));
$prolingua_post_format = get_post_format();
$prolingua_post_format = empty($prolingua_post_format) ? 'standard' : str_replace('post-format-', '', $prolingua_post_format);
$prolingua_animation = prolingua_get_theme_option('blog_animation');

?><article id="post-<?php the_ID(); ?>" 
	<?php post_class( 'post_item post_layout_chess post_layout_chess_'.esc_attr($prolingua_columns).' post_format_'.esc_attr($prolingua_post_format) ); ?>
	<?php echo (!prolingua_is_off($prolingua_animation) ? ' data-animation="'.esc_attr(prolingua_get_animation_classes($prolingua_animation)).'"' : ''); ?>>

	<?php
	// Add anchor
	if ($prolingua_columns == 1 && shortcode_exists('trx_sc_anchor')) {
		echo do_shortcode('[trx_sc_anchor id="post_'.esc_attr(get_the_ID()).'" title="'.esc_attr(get_the_title()).'"]');
	}

	// Sticky label
	if ( is_sticky() && !is_paged() ) {
		?><span class="post_label label_sticky"></span><?php
	}

	// Featured image
	prolingua_show_post_featured( array(
											'class' => $prolingua_columns == 1 ? 'prolingua-full-height' : '',
											'show_no_image' => true,
											'thumb_bg' => true,
											'thumb_size' => prolingua_get_thumb_size(
																	strpos(prolingua_get_theme_option('body_style'), 'full')!==false
																		? ( $prolingua_columns > 1 ? 'huge' : 'original' )
																		: (	$prolingua_columns > 2 ? 'big' : 'huge')
																	)
											) 
										);

	?><div class="post_inner"><div class="post_inner_content"><?php 

		?><div class="post_header entry-header">
            <div class="post_info_top"><div class="post_categories"><?php echo prolingua_get_post_categories('  ')?></div></div>

                <?php
			do_action('prolingua_action_before_post_title'); 

			// Post title
			the_title( sprintf( '<h3 class="post_title entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h3>' );

		?></div><!-- .entry-header -->
	
		<div class="post_content entry-content">
			<div class="post_content_inner">
				<?php
				$prolingua_show_learn_more = !in_array($prolingua_post_format, array('link', 'aside', 'status', 'quote'));
				if (has_excerpt()) {
					the_excerpt();
				} else if (strpos(get_the_content('!--more'), '!--more')!==false) {
					the_content( '' );
				} else if (in_array($prolingua_post_format, array('link', 'aside', 'status'))) {
					the_content();
				} else if ($prolingua_post_format == 'quote') {
					if (($quote = prolingua_get_tag(get_the_content(), '<blockquote>', '</blockquote>'))!='')
						prolingua_show_layout(wpautop($quote));
					else
						the_excerpt();
				} else if (substr(get_the_content(), 0, 1)!='[') {
					the_excerpt();
				}
				?>
			</div>
			<?php

            // Post content meta
            ?><div class="post_content_meta"><?php

                ?>
                <div class="author_block">

                    <?php

                    $author_id = get_the_author_meta('ID');
                    if (empty($author_id) && !empty($GLOBALS['post']->post_author))
                        $author_id = $GLOBALS['post']->post_author;
                    if ($author_id > 0) {
                    $author_link = get_author_posts_url($author_id);
                    $author_name = get_the_author_meta('display_name', $author_id);

                    ?>
                    <div class="author_avatar_block">
                        <?php
                        $prolingua_mult = prolingua_get_retina_multiplier();
                        echo get_avatar($author_id,120*$prolingua_mult);

                        ?>
                    </div>
                    <div class="author_block_info">
                        <div class="author_link">
                            <a class="post_meta_item post_author" rel="author" href="<?php echo esc_url($author_link); ?>">
                                <?php echo esc_html($author_name); ?>
                            </a>
                        </div>
                        <?php
                        }

                        if (!empty($dt = prolingua_get_date())) {
                            ?>
                            <div class="date_posted_block">
                    <span class="date_posted">
                        <?php echo wp_kses_data($dt); ?>
                    </span>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                </div>
                <?php

                // Post meta
                $prolingua_components = prolingua_is_inherit(prolingua_get_theme_option_from_meta('meta_parts'))
                    ? 'categories,date'.($prolingua_columns < 3 ? ',counters' : '').($prolingua_columns == 1 ? ',edit' : '')
                    : prolingua_array_get_keys_by_value(prolingua_get_theme_option('meta_parts'));
                $prolingua_counters = prolingua_is_inherit(prolingua_get_theme_option_from_meta('counters'))
                    ? 'comments'
                    : prolingua_array_get_keys_by_value(prolingua_get_theme_option('counters'));
                $prolingua_post_meta = empty($prolingua_components)
                    ? ''
                    : prolingua_show_post_meta(apply_filters('prolingua_filter_post_meta_args', array(
                            'components' => $prolingua_components,
                            'counters' => $prolingua_counters,
                            'seo' => false,
                            'echo' => false
                        ), $prolingua_blog_style[0], $prolingua_columns)
                    );
                prolingua_show_layout($prolingua_post_meta);

                // Post meta
                if (in_array($prolingua_post_format, array('link', 'aside', 'status', 'quote'))) {
                    prolingua_show_layout($prolingua_post_meta);
                }
                ?>
            </div><?php

			?>
		</div><!-- .entry-content -->

	</div></div><!-- .post_inner -->

</article>