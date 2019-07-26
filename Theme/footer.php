<?php
/**
 * The Footer: widgets area, logo, footer menu and socials
 *
 * @package WordPress
 * @subpackage PROLINGUA
 * @since PROLINGUA 1.0
 */

						// Widgets area inside page content
						prolingua_create_widgets_area('widgets_below_content');
						?>				
					</div><!-- </.content> -->

					<?php
					// Show main sidebar
					get_sidebar();

					// Widgets area below page content
					prolingua_create_widgets_area('widgets_below_page');

					$prolingua_body_style = prolingua_get_theme_option('body_style');
					if ($prolingua_body_style != 'fullscreen') {
						?></div><!-- </.content_wrap> --><?php
					}
					?>
			</div><!-- </.page_content_wrap> -->

			<?php
			// Footer
			$prolingua_footer_type = prolingua_get_theme_option("footer_type");
			if ($prolingua_footer_type == 'custom' && !prolingua_is_layouts_available())
				$prolingua_footer_type = 'default';
			get_template_part( "templates/footer-{$prolingua_footer_type}");
			?>

		</div><!-- /.page_wrap -->

	</div><!-- /.body_wrap -->

    <?php if (prolingua_is_on(prolingua_get_theme_option('custom_sections_socials'))) { ?>
        <div class="custom_section custom_section_right <?php if (prolingua_is_on(prolingua_get_theme_option('custom_sections_boxed_hide'))) { echo ('custom_hide_on_boxed'); }?>">
            <div class="custom_section_container">
                <?php
                // Social icons
                prolingua_show_layout(prolingua_get_socials_links(), '<div class="custom_section_socials socials_wrap">', '</div>');

                ?>
            </div>
        </div>
    <?php } ?>
    <?php
    $custom_on = prolingua_get_theme_option('custom_sections_links');
    $custom_hide = prolingua_get_theme_option('custom_sections_boxed_hide');
    $custom_text = prolingua_get_theme_option('custom_sections_title');
    $custom_link = prolingua_get_theme_option('custom_sections_link');
    $custom_link2 = prolingua_get_theme_option('custom_sections_link2');
    $custom_url = prolingua_get_theme_option('custom_sections_url');
    $custom_url2 = prolingua_get_theme_option('custom_sections_url2');

    if (prolingua_is_on($custom_on) && ((!empty($custom_link)  && !empty($custom_url)) || (!empty($custom_link2)  && !empty($custom_url2)))) { ?>
        <div class="custom_section custom_section_left <?php if (prolingua_is_on($custom_hide)) { echo ('custom_hide_on_boxed'); }?>">
            <div class="custom_section_container">
                <div class="custom_section_content">
                    <?php
                    if (!empty($custom_link)  && !empty($custom_url))  {  ?>
                        <a href="<?php echo esc_url($custom_url); ?>"><?php prolingua_show_layout($custom_link); ?></a>
                    <?php } ?>
                    <?php
                    if (!empty($custom_link)  && !empty($custom_url) && !empty($custom_link2) && !empty($custom_url2))  {  ?>
                       <span class="divider"></span>
                    <?php } ?>
                    <?php
                         if (!empty($custom_link2)  && !empty($custom_url2))  {  ?>
                         <a href="<?php echo esc_url($custom_url2); ?>"><?php prolingua_show_layout($custom_link2); ?></a>
                    <?php } ?>
                </div>
            </div>
        </div>
    <?php } ?>


	<?php if (prolingua_is_on(prolingua_get_theme_option('debug_mode')) && prolingua_get_file_dir('images/makeup.jpg')!='') { ?>
		<img src="<?php echo esc_url(prolingua_get_file_url('images/makeup.jpg')); ?>" id="makeup">
	<?php } ?>

	<?php wp_footer(); ?>

</body>
</html>