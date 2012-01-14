<?php
/**
 * Desk Mess Mirrored Quote loop
 *
 * Displays the post-format => quote loop content.
 *
 * @package     Desk_Mess_Mirrored
 * @since       2.0
 *
 * @link        http://buynowshop.com/themes/desk-mess-mirrored/
 * @link        https://github.com/Cais/desk-mess-mirrored/
 * @link        http://wordpress.org/extend/themes/desk-mess-mirrored/
 *
 * @author      Edward Caissie <edward.caissie@gmail.com>
 * @copyright   Copyright (c) 2009-2012, Edward Caissie
 */
?>
<div <?php post_class(); ?> id="post-<?php the_ID(); ?>">
    <div class="transparent glyph"><?php dmm_quote_glyph(); ?></div>
    <?php if ( ! post_password_required() && ( comments_open() || ( get_comments_number() > 0 ) ) ) { ?>
        <div class="post-comments">
            <?php comments_popup_link( __( '0', 'desk-mess-mirrored' ), __( '1', 'desk-mess-mirrored' ), __( '%', 'desk-mess-mirrored' ), '',__( '-', 'desk-mess-mirrored' ) ); ?>
        </div>
    <?php } ?>
    <h1>
        <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute( array( 'before' => __( 'Permalink to: ', 'desk-mess-mirrored' ), 'after' => '' ) ); ?>"><?php the_title(); ?></a>
    </h1>
    <div class="postdata">
        <?php printf( __( 'Posted by %1$s on %2$s in ', 'desk-mess-mirrored' ), get_the_author(), get_the_time( get_option( 'date_format' ) ) ); the_category( ', ' );
        if ( ! post_password_required() && ! comments_open() && ( is_home() || is_front_page() ) ) {
            /** Only displays when comments are closed */
            echo '<br />'; comments_popup_link( '', '', '', '', __( 'with Comments closed', 'desk-mess-mirrored' ) );
        }
        the_shortlink( __( '&#8734;', 'desk-mess-mirrored' ), '', ' | ', '' );
        edit_post_link( __( 'Edit', 'desk-mess-mirrored' ), __( ' | ', 'desk-mess-mirrored' ), __( '', 'desk-mess-mirrored' ) ); ?>
    </div>
    <?php if ( ( is_home() || is_front_page() ) && has_post_thumbnail() ) {
        the_post_thumbnail( 'thumbnail', array( 'class' => 'alignleft' ) );
    }
    the_content( __( 'Read more... ', 'desk-mess-mirrored' ) ); ?>
    <div class="clear"><!-- For inserted media at the end of the post --></div>
    <?php wp_link_pages( array( 'before' => '<p id="wp-link-pages"><strong>' . __( 'Pages:', 'desk-mess-mirrored' ) . '</strong> ', 'after' => '</p>', 'next_or_number' => 'number' ) );
    if ( is_single() ) { ?>
        <div id="author_link"><?php _e( '... other posts by ', 'desk-mess-mirrored' ); ?><?php the_author_posts_link(); ?></div>
    <?php } ?>
    <p class="single-meta"><?php the_tags(); ?></p>
</div> <!-- .post #post-ID -->
<?php comments_template(); ?>