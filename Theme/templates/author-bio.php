<?php
/**
 * The template to display the Author bio
 *
 * @package WordPress
 * @subpackage PROLINGUA
 * @since PROLINGUA 1.0
 */
?>

<div class="author_info scheme_default author vcard trx-stretch-width" itemprop="author" itemscope itemtype="http://schema.org/Person">
    <div class="author_block_single" itemprop="image">
        <div class="author_avatar" itemprop="image">
            <?php
            $prolingua_mult = prolingua_get_retina_multiplier();
            echo get_avatar( get_the_author_meta( 'user_email' ), 200*$prolingua_mult );
            ?>
        </div><!-- .author_avatar -->

        <div class="author_description">
            <span class="about_author"><?php echo esc_html__('About Author', 'prolingua' )?></span>
            <h5 class="author_title" itemprop="name"><?php
                echo get_the_author();
            ?></h5>

            <div class="author_bio" itemprop="description">
                <?php echo wp_kses_post(wpautop(get_the_author_meta( 'description' ))); ?>
                <a class="author_link" href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" rel="author"><?php
                    // Translators: Add the author's name in the <span>
                    printf( esc_html__( 'View all posts by %s', 'prolingua' ), '<span class="author_name">' . esc_html(get_the_author()) . '</span>' );
                ?></a>
                <?php do_action('prolingua_action_user_meta'); ?>
            </div><!-- .author_bio -->

        </div><!-- .author_description -->
    </div><!-- .author_block_single -->
</div><!-- .author_info -->
