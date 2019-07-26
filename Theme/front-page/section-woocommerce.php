<div class="front_page_section front_page_section_woocommerce<?php
			$prolingua_scheme = prolingua_get_theme_option('front_page_woocommerce_scheme');
			if (!prolingua_is_inherit($prolingua_scheme)) echo ' scheme_'.esc_attr($prolingua_scheme);
			echo ' front_page_section_paddings_'.esc_attr(prolingua_get_theme_option('front_page_woocommerce_paddings'));
		?>"<?php
		$prolingua_css = '';
		$prolingua_bg_image = prolingua_get_theme_option('front_page_woocommerce_bg_image');
		if (!empty($prolingua_bg_image)) 
			$prolingua_css .= 'background-image: url('.esc_url(prolingua_get_attachment_url($prolingua_bg_image)).');';
		if (!empty($prolingua_css))
			echo ' style="' . esc_attr($prolingua_css) . '"';
?>><?php
	// Add anchor
	$prolingua_anchor_icon = prolingua_get_theme_option('front_page_woocommerce_anchor_icon');	
	$prolingua_anchor_text = prolingua_get_theme_option('front_page_woocommerce_anchor_text');	
	if ((!empty($prolingua_anchor_icon) || !empty($prolingua_anchor_text)) && shortcode_exists('trx_sc_anchor')) {
		echo do_shortcode('[trx_sc_anchor id="front_page_section_woocommerce"'
										. (!empty($prolingua_anchor_icon) ? ' icon="'.esc_attr($prolingua_anchor_icon).'"' : '')
										. (!empty($prolingua_anchor_text) ? ' title="'.esc_attr($prolingua_anchor_text).'"' : '')
										. ']');
	}
	?>
	<div class="front_page_section_inner front_page_section_woocommerce_inner<?php
			if (prolingua_get_theme_option('front_page_woocommerce_fullheight'))
				echo ' prolingua-full-height sc_layouts_flex sc_layouts_columns_middle';
			?>"<?php
			$prolingua_css = '';
			$prolingua_bg_mask = prolingua_get_theme_option('front_page_woocommerce_bg_mask');
			$prolingua_bg_color = prolingua_get_theme_option('front_page_woocommerce_bg_color');
			if (!empty($prolingua_bg_color) && $prolingua_bg_mask > 0)
				$prolingua_css .= 'background-color: '.esc_attr($prolingua_bg_mask==1
																	? $prolingua_bg_color
																	: prolingua_hex2rgba($prolingua_bg_color, $prolingua_bg_mask)
																).';';
			if (!empty($prolingua_css))
				echo ' style="' . esc_attr($prolingua_css) . '"';
	?>>
		<div class="front_page_section_content_wrap front_page_section_woocommerce_content_wrap content_wrap woocommerce">
			<?php
			// Content wrap with title and description
			$prolingua_caption = prolingua_get_theme_option('front_page_woocommerce_caption');
			$prolingua_description = prolingua_get_theme_option('front_page_woocommerce_description');
			if (!empty($prolingua_caption) || !empty($prolingua_description) || (current_user_can('edit_theme_options') && is_customize_preview())) {
				// Caption
				if (!empty($prolingua_caption) || (current_user_can('edit_theme_options') && is_customize_preview())) {
					?><h2 class="front_page_section_caption front_page_section_woocommerce_caption front_page_block_<?php echo !empty($prolingua_caption) ? 'filled' : 'empty'; ?>"><?php
						echo wp_kses_post($prolingua_caption);
					?></h2><?php
				}
			
				// Description (text)
				if (!empty($prolingua_description) || (current_user_can('edit_theme_options') && is_customize_preview())) {
					?><div class="front_page_section_description front_page_section_woocommerce_description front_page_block_<?php echo !empty($prolingua_description) ? 'filled' : 'empty'; ?>"><?php
						echo wp_kses_post(wpautop($prolingua_description));
					?></div><?php
				}
			}
		
			// Content (widgets)
			?><div class="front_page_section_output front_page_section_woocommerce_output list_products shop_mode_thumbs"><?php 
				$prolingua_woocommerce_sc = prolingua_get_theme_option('front_page_woocommerce_products');
				if ($prolingua_woocommerce_sc == 'products') {
					$prolingua_woocommerce_sc_ids = prolingua_get_theme_option('front_page_woocommerce_products_per_page');
					$prolingua_woocommerce_sc_per_page = count(explode(',', $prolingua_woocommerce_sc_ids));
				} else {
					$prolingua_woocommerce_sc_per_page = max(1, (int) prolingua_get_theme_option('front_page_woocommerce_products_per_page'));
				}
				$prolingua_woocommerce_sc_columns = max(1, min($prolingua_woocommerce_sc_per_page, (int) prolingua_get_theme_option('front_page_woocommerce_products_columns')));
				echo do_shortcode("[{$prolingua_woocommerce_sc}"
									. ($prolingua_woocommerce_sc == 'products' 
											? ' ids="'.esc_attr($prolingua_woocommerce_sc_ids).'"' 
											: '')
									. ($prolingua_woocommerce_sc == 'product_category' 
											? ' category="'.esc_attr(prolingua_get_theme_option('front_page_woocommerce_products_categories')).'"' 
											: '')
									. ($prolingua_woocommerce_sc != 'best_selling_products' 
											? ' orderby="'.esc_attr(prolingua_get_theme_option('front_page_woocommerce_products_orderby')).'"'
											  . ' order="'.esc_attr(prolingua_get_theme_option('front_page_woocommerce_products_order')).'"' 
											: '')
									. ' per_page="'.esc_attr($prolingua_woocommerce_sc_per_page).'"' 
									. ' columns="'.esc_attr($prolingua_woocommerce_sc_columns).'"' 
									. ']');
			?></div>
		</div>
	</div>
</div>