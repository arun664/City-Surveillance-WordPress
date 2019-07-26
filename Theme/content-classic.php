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
$prolingua_columns = empty($prolingua_blog_style[1]) ? 2 : max(2, $prolingua_blog_style[1]);
$prolingua_expanded = !prolingua_sidebar_present() && prolingua_is_on(prolingua_get_theme_option('expand_content'));
$prolingua_post_format = get_post_format();
$prolingua_post_format = empty($prolingua_post_format) ? 'standard' : str_replace('post-format-', '', $prolingua_post_format);
$prolingua_animation = prolingua_get_theme_option('blog_animation');
$prolingua_components = prolingua_is_inherit(prolingua_get_theme_option_from_meta('meta_parts')) 
							? 'categories,date,counters'.($prolingua_columns < 3 ? ',edit' : '')
							: prolingua_array_get_keys_by_value(prolingua_get_theme_option('meta_parts'));
$prolingua_counters = prolingua_is_inherit(prolingua_get_theme_option_from_meta('counters')) 
							? 'comments'
							: prolingua_array_get_keys_by_value(prolingua_get_theme_option('counters'));

?><div class="<?php prolingua_show_layout($prolingua_blog_style[0] == 'classic' ? 'column' : 'masonry_item masonry_item'); ?>-1_<?php echo esc_attr($prolingua_columns); ?>"><article id="post-<?php the_ID(); ?>"
	<?php post_class( 'post_item post_format_'.esc_attr($prolingua_post_format)
					. ' post_layout_classic post_layout_classic_'.esc_attr($prolingua_columns)
					. ' post_layout_'.esc_attr($prolingua_blog_style[0]) 
					. ' post_layout_'.esc_attr($prolingua_blog_style[0]).'_'.esc_attr($prolingua_columns)
					); ?>
	<?php echo (!prolingua_is_off($prolingua_animation) ? ' data-animation="'.esc_attr(prolingua_get_animation_classes($prolingua_animation)).'"' : ''); ?>>
	<?php

	// Sticky label
	if ( is_sticky() && !is_paged() ) {
		?><span class="post_label label_sticky"></span><?php
	}

	// Featured image
	prolingua_show_post_featured( array( 'thumb_size' => prolingua_get_thumb_size($prolingua_blog_style[0] == 'classic'
													? (strpos(prolingua_get_theme_option('body_style'), 'full')!==false 
															? ( $prolingua_columns > 3 ? 'big' : 'huge' )
															: (	$prolingua_columns > 3
																? ($prolingua_expanded ? 'big' : 'med')
																: ($prolingua_expanded ? 'big' : 'big')
																)
														)
													: (strpos(prolingua_get_theme_option('body_style'), 'full')!==false 
															? ( $prolingua_columns > 2 ? 'masonry-big' : 'full' )
															: (	$prolingua_columns <= 3 && $prolingua_expanded ? 'masonry-big' : 'masonry')
														)
								) ) );

	if ( !in_array($prolingua_post_format, array('link', 'aside', 'status', 'quote')) ) {
		?>
        <div class="post_wrapper">
		<div class="post_header entry-header">

            <div class="post_info_top"><div class="post_categories"><?php echo prolingua_get_post_categories('  ')?></div></div>
			<?php
            do_action('prolingua_action_before_post_title');

			// Post title
			the_title( sprintf( '<h4 class="post_title entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h4>' );

			do_action('prolingua_action_before_post_meta'); 


			?>
		</div><!-- .entry-header -->
		<?php
	}		
	?>

	<div class="post_content entry-content">
		<div class="post_content_inner">
			<?php
			$prolingua_show_learn_more = false;
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

        // Post meta
        if (!empty($prolingua_components))
            prolingua_show_post_meta(apply_filters('prolingua_filter_post_meta_args', array(
                    'components' => $prolingua_components,
                    'counters' => $prolingua_counters,
                    'seo' => false
                ), $prolingua_blog_style[0], $prolingua_columns)
            );

        do_action('prolingua_action_after_post_meta');


        // Post meta
		if (in_array($prolingua_post_format, array('link', 'aside', 'status', 'quote'))) {
			if (!empty($prolingua_components))
				prolingua_show_post_meta(apply_filters('prolingua_filter_post_meta_args', array(
					'components' => $prolingua_components,
					'counters' => $prolingua_counters
					), $prolingua_blog_style[0], $prolingua_columns)
				);
		}
		// More button
		if ( $prolingua_show_learn_more ) {
			?><p><a class="more-link" href="<?php echo esc_url(get_permalink()); ?>"><?php esc_html_e('Read more', 'prolingua'); ?></a></p><?php
		}
		?>
	</div><!-- .entry-content -->
    </div><!-- .post_wrapper -->

</article></div>