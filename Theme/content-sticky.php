<?php
/**
 * The Sticky template to display the sticky posts
 *
 * Used for index/archive
 *
 * @package WordPress
 * @subpackage PROLINGUA
 * @since PROLINGUA 1.0
 */

$prolingua_columns = max(1, min(3, count(get_option( 'sticky_posts' ))));
$prolingua_post_format = get_post_format();
$prolingua_post_format = empty($prolingua_post_format) ? 'standard' : str_replace('post-format-', '', $prolingua_post_format);
$prolingua_animation = prolingua_get_theme_option('blog_animation');

?><div class="column-1_<?php echo esc_attr($prolingua_columns); ?>"><article id="post-<?php the_ID(); ?>" 
	<?php post_class( 'post_item post_layout_sticky post_format_'.esc_attr($prolingua_post_format) ); ?>
	<?php echo (!prolingua_is_off($prolingua_animation) ? ' data-animation="'.esc_attr(prolingua_get_animation_classes($prolingua_animation)).'"' : ''); ?>
	>

	<?php
	if ( is_sticky() && is_home() && !is_paged() ) {
		?><span class="post_label label_sticky"></span><?php
	}

	// Featured image
	prolingua_show_post_featured(array(
		'thumb_size' => prolingua_get_thumb_size($prolingua_columns==1 ? 'big' : ($prolingua_columns==2 ? 'med' : 'avatar'))
	));

	if ( !in_array($prolingua_post_format, array('link', 'aside', 'status', 'quote')) ) {
		?>
		<div class="post_header entry-header">
			<?php
			// Post title
			the_title( sprintf( '<h6 class="post_title entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h6>' );
			// Post meta
			prolingua_show_post_meta(apply_filters('prolingua_filter_post_meta_args', array(), 'sticky', $prolingua_columns));
			?>
		</div><!-- .entry-header -->
		<?php
	}
	?>
</article></div>