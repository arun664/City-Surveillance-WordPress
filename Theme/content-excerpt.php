<?php
/**
 * The default template to display the content
 *
 * Used for index/archive/search.
 *
 * @package WordPress
 * @subpackage PROLINGUA
 * @since PROLINGUA 1.0
 */

$prolingua_post_format = get_post_format();
$prolingua_post_format = empty($prolingua_post_format) ? 'standard' : str_replace('post-format-', '', $prolingua_post_format);
$prolingua_animation = prolingua_get_theme_option('blog_animation');

?><article id="post-<?php the_ID(); ?>" 
	<?php post_class( 'post_item post_layout_excerpt post_format_'.esc_attr($prolingua_post_format) ); ?>
	<?php echo (!prolingua_is_off($prolingua_animation) ? ' data-animation="'.esc_attr(prolingua_get_animation_classes($prolingua_animation)).'"' : ''); ?>
	><?php

	// Sticky label
	if ( is_sticky() && !is_paged() ) {
		?><span class="post_label label_sticky"></span><?php
	}

	// Featured image
	prolingua_show_post_featured(array( 'thumb_size' => prolingua_get_thumb_size( strpos(prolingua_get_theme_option('body_style'), 'full')!==false ? 'full' : 'big' ),
        'post_info' => (in_array($prolingua_post_format, array('standard', 'image'))
            ? '<div class="post_info_top">'
            . '<div class="post_categories">'.wp_kses_post(prolingua_get_post_categories('  ')).'</div>'
            . '</div>'
            : '')
    ));
    ?>
    <div class="post_wrapper">
    <?php
	// Title and post meta
	if (get_the_title() != '' && $prolingua_post_format != 'quote') {
		?>
		<div class="post_header entry-header">
			<?php
			do_action('prolingua_action_before_post_title'); 

			// Post title
			the_title( sprintf( '<h2 class="post_title entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' );

			do_action('prolingua_action_before_post_meta'); 

		?>
		</div><!-- .post_header --><?php
	}
	
	// Post content
	?><div class="post_content entry-content"><?php
		if (prolingua_get_theme_option('blog_content') == 'fullpost') {
			// Post content area
			?><div class="post_content_inner"><?php
				the_content( '' );
			?></div><?php
			// Inner pages
			wp_link_pages( array(
				'before'      => '<div class="page_links"><span class="page_links_title">' . esc_html__( 'Pages:', 'prolingua' ) . '</span>',
				'after'       => '</div>',
				'link_before' => '<span>',
				'link_after'  => '</span>',
				'pagelink'    => '<span class="screen-reader-text">' . esc_html__( 'Page', 'prolingua' ) . ' </span>%',
				'separator'   => '<span class="screen-reader-text">, </span>',
			) );

		} else {

			$prolingua_show_learn_more = !in_array($prolingua_post_format, array('link', 'aside', 'status', 'quote'));

			// Post content area
			?><div class="post_content_inner"><?php
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
			?></div><?php

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


            $prolingua_components = prolingua_is_inherit(prolingua_get_theme_option_from_meta('meta_parts'))
                ? 'categories,date,counters,edit'
                : prolingua_array_get_keys_by_value(prolingua_get_theme_option('meta_parts'));
            $prolingua_counters = prolingua_is_inherit(prolingua_get_theme_option_from_meta('counters'))
                ? 'views,likes,comments'
                : prolingua_array_get_keys_by_value(prolingua_get_theme_option('counters'));

            if (!empty($prolingua_components))
                prolingua_show_post_meta(apply_filters('prolingua_filter_post_meta_args', array(
                        'components' => $prolingua_components,
                        'counters' => $prolingua_counters,
                        'seo' => false
                    ), 'excerpt', 1)
                );
            ?>
           </div><?php
		}
	?></div><!-- .entry-content -->
    </div><!-- .post_wrapper -->
</article>

