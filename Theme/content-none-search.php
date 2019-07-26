<article <?php post_class( 'post_item_single post_item_404 post_item_none_search' ); ?>>
	<div class="post_content">
		<h1 class="page_title"><?php esc_html_e( 'No results', 'prolingua' ); ?></h1>
		<div class="page_info">
			<h3 class="page_subtitle"><?php
				// Translators: Add the query string
				echo esc_html(sprintf(__("We're sorry, but your search \"%s\" did not match", 'prolingua'), get_search_query()));
			?></h3>
			<p class="page_description"><?php
				// Translators: Add the site URL to the link
				echo wp_kses_data( sprintf( __("Can't find what you need? Take a moment and do a search below or start from <a href='%s'>our homepage</a>.", 'prolingua'), esc_url(home_url('/')) ) );
			?></p>
            <div class="search_wrap search_style_normal page_search">
                <div class="search_form_wrap">
                    <form role="search" method="get" class="search_form" action="<?php echo esc_url(home_url('/')); ?>">
                        <input type="text" class="search_field" placeholder="<?php esc_attr_e('Search', 'prolingua'); ?>" value="<?php echo esc_attr(get_search_query()); ?>" name="s">
                        <button type="submit" class="search_submit trx_addons_icon-search"></button>
                    </form>
                </div>
            </div>
		</div>
	</div>
</article>
