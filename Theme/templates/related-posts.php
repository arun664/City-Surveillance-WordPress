<?php
/**
 * The template 'Style 1' to displaying related posts
 *
 * @package WordPress
 * @subpackage PROLINGUA
 * @since PROLINGUA 1.0
 */

$prolingua_link = get_permalink();
$prolingua_post_format = get_post_format();
$prolingua_post_format = empty($prolingua_post_format) ? 'standard' : str_replace('post-format-', '', $prolingua_post_format);
?><div id="post-<?php the_ID(); ?>" 
    <?php post_class( 'related_item related_item_style_1 post_format_'.esc_attr($prolingua_post_format) ); ?>><?php

    ?>
    <div class="post_featured with_thumb hover_icon<?php echo esc_attr(has_post_thumbnail() ? ' with_image' : ' without_image'); ?>">
    <?php
        if (has_post_thumbnail()) {
            $image = wp_get_attachment_image_src( get_post_thumbnail_id(get_the_ID()), prolingua_get_thumb_size('big') );
            $image = $image[0];
            if (!empty($image)) {
                ?>
                <img src="<?php echo esc_url($image); ?>" alt="<?php echo get_the_title(); ?>">
                <?php
            }
        }
        prolingua_show_layout('<div class="post_header entry-header">'
            . '<div class="post_categories">' . prolingua_get_post_categories('') . '</div>'
            . '<h6 class="post_title entry-title"><a href="' . esc_url($prolingua_link) . '">' . get_the_title() . '</a></h6>'
            . '<a href="' . esc_url($prolingua_link) . '"  class="related_post_link">' . esc_html__('Learn More', 'prolingua') . '</a>'
            . '</div>' );

        ?>
    </div>
</div>

