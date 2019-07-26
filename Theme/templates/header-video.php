<?php
/**
 * The template to display the background video in the header
 *
 * @package WordPress
 * @subpackage PROLINGUA
 * @since PROLINGUA 1.0.14
 */
$prolingua_header_video = prolingua_get_header_video();
$prolingua_embed_video = '';
if (!empty($prolingua_header_video) && !prolingua_is_from_uploads($prolingua_header_video)) {
	if (prolingua_is_youtube_url($prolingua_header_video) && preg_match('/[=\/]([^=\/]*)$/', $prolingua_header_video, $matches) && !empty($matches[1])) {
		?><div id="background_video" data-youtube-code="<?php echo esc_attr($matches[1]); ?>"></div><?php
	} else {
		global $wp_embed;
		if (false && is_object($wp_embed)) {
			$prolingua_embed_video = do_shortcode($wp_embed->run_shortcode( '[embed]' . trim($prolingua_header_video) . '[/embed]' ));
			$prolingua_embed_video = prolingua_make_video_autoplay($prolingua_embed_video);
		} else {
			$prolingua_header_video = str_replace('/watch?v=', '/embed/', $prolingua_header_video);
			$prolingua_header_video = prolingua_add_to_url($prolingua_header_video, array(
				'feature' => 'oembed',
				'controls' => 0,
				'autoplay' => 1,
				'showinfo' => 0,
				'modestbranding' => 1,
				'wmode' => 'transparent',
				'enablejsapi' => 1,
				'origin' => esc_url( home_url( '/' )),
				'widgetid' => 1
			));
			$prolingua_embed_video = '<iframe src="' . esc_url($prolingua_header_video) . '" width="1170" height="658" allowfullscreen="0" frameborder="0"></iframe>';
		}
		?><div id="background_video"><?php prolingua_show_layout($prolingua_embed_video); ?></div><?php
	}
}
?>