<div class="front_page_section front_page_section_about<?php
			$prolingua_scheme = prolingua_get_theme_option('front_page_about_scheme');
			if (!prolingua_is_inherit($prolingua_scheme)) echo ' scheme_'.esc_attr($prolingua_scheme);
			echo ' front_page_section_paddings_'.esc_attr(prolingua_get_theme_option('front_page_about_paddings'));
		?>"<?php
		$prolingua_css = '';
		$prolingua_bg_image = prolingua_get_theme_option('front_page_about_bg_image');
		if (!empty($prolingua_bg_image)) 
			$prolingua_css .= 'background-image: url('.esc_url(prolingua_get_attachment_url($prolingua_bg_image)).');';
		if (!empty($prolingua_css))
			echo ' style="' . esc_attr($prolingua_css) . '"';
?>><?php
	// Add anchor
	$prolingua_anchor_icon = prolingua_get_theme_option('front_page_about_anchor_icon');	
	$prolingua_anchor_text = prolingua_get_theme_option('front_page_about_anchor_text');	
	if ((!empty($prolingua_anchor_icon) || !empty($prolingua_anchor_text)) && shortcode_exists('trx_sc_anchor')) {
		echo do_shortcode('[trx_sc_anchor id="front_page_section_about"'
										. (!empty($prolingua_anchor_icon) ? ' icon="'.esc_attr($prolingua_anchor_icon).'"' : '')
										. (!empty($prolingua_anchor_text) ? ' title="'.esc_attr($prolingua_anchor_text).'"' : '')
										. ']');
	}
	?>
	<div class="front_page_section_inner front_page_section_about_inner<?php
			if (prolingua_get_theme_option('front_page_about_fullheight'))
				echo ' prolingua-full-height sc_layouts_flex sc_layouts_columns_middle';
			?>"<?php
			$prolingua_css = '';
			$prolingua_bg_mask = prolingua_get_theme_option('front_page_about_bg_mask');
			$prolingua_bg_color = prolingua_get_theme_option('front_page_about_bg_color');
			if (!empty($prolingua_bg_color) && $prolingua_bg_mask > 0)
				$prolingua_css .= 'background-color: '.esc_attr($prolingua_bg_mask==1
																	? $prolingua_bg_color
																	: prolingua_hex2rgba($prolingua_bg_color, $prolingua_bg_mask)
																).';';
			if (!empty($prolingua_css))
				echo ' style="' . esc_attr($prolingua_css) . '"';
	?>>
		<div class="front_page_section_content_wrap front_page_section_about_content_wrap content_wrap">
			<?php
			// Caption
			$prolingua_caption = prolingua_get_theme_option('front_page_about_caption');
			if (!empty($prolingua_caption) || (current_user_can('edit_theme_options') && is_customize_preview())) {
				?><h2 class="front_page_section_caption front_page_section_about_caption front_page_block_<?php echo !empty($prolingua_caption) ? 'filled' : 'empty'; ?>"><?php echo wp_kses_post($prolingua_caption); ?></h2><?php
			}
		
			// Description (text)
			$prolingua_description = prolingua_get_theme_option('front_page_about_description');
			if (!empty($prolingua_description) || (current_user_can('edit_theme_options') && is_customize_preview())) {
				?><div class="front_page_section_description front_page_section_about_description front_page_block_<?php echo !empty($prolingua_description) ? 'filled' : 'empty'; ?>"><?php echo wp_kses_post(wpautop($prolingua_description)); ?></div><?php
			}
			
			// Content
			$prolingua_content = prolingua_get_theme_option('front_page_about_content');
			if (!empty($prolingua_content) || (current_user_can('edit_theme_options') && is_customize_preview())) {
				?><div class="front_page_section_content front_page_section_about_content front_page_block_<?php echo !empty($prolingua_content) ? 'filled' : 'empty'; ?>"><?php
					$prolingua_page_content_mask = '%%CONTENT%%';
					if (strpos($prolingua_content, $prolingua_page_content_mask) !== false) {
						$prolingua_content = preg_replace(
									'/(\<p\>\s*)?'.$prolingua_page_content_mask.'(\s*\<\/p\>)/i',
									sprintf('<div class="front_page_section_about_source">%s</div>',
												apply_filters('the_content', get_the_content())),
									$prolingua_content
									);
					}
					prolingua_show_layout($prolingua_content);
				?></div><?php
			}
			?>
		</div>
	</div>
</div>